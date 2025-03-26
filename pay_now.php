<?php
require(__DIR__ . '/admin/inc/db_config.php');
require(__DIR__ . '/admin/inc/essentials.php');
require(__DIR__ . '/inc/vendor/autoload.php');

session_start();
date_default_timezone_set("Asia/Kolkata");

use Razorpay\Api\Api;

define('RAZORPAY_KEY_ID', 'rzp_test_yVj0dg5ZvAfOiI');
define('RAZORPAY_KEY_SECRET', 'N2WEsuigCXtR46QCAPBPsBhb');

$api = new Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);

$con = mysqli_connect('localhost', 'root', '', 'hotel');
if (!$con) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['pay_now']) && isset($_SESSION['uId'])) {
    
    $ORDER_ID = 'ORD_' . $_SESSION['uId'] . random_int(11111, 9999999);
    $TRANS_ID = 'TXN_' . $_SESSION['uId'] . random_int(11111, 9999999); 
    $CUST_ID = $_SESSION['uId'];
    $TXN_AMOUNT = $_SESSION['room']['payment'] ?? 0;

    if ($TXN_AMOUNT <= 0) {
        die("Error: Invalid transaction amount.");
    }

    $frm_data = filteration($_POST);


    $query1 = "INSERT INTO booking_order 
        (user_id, room_id, check_in, check_out, arrival, refund, booking_status, order_id, trans_id, trans_status, datentime) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmt1 = mysqli_prepare($con, $query1);
    $booking_status = "pending";
    $trans_status = "pending";

    $room_id = $_SESSION['room']['id'];
    $arrival = isset($frm_data['arrival']) ? $frm_data['arrival'] : 'Unknown';
    $refund = isset($frm_data['refund']) ? $frm_data['refund'] : 'No Refund'; 

    
    mysqli_stmt_bind_param($stmt1, "iisssissis", 
        $CUST_ID, 
        $room_id,  
        $frm_data['checkin'], 
        $frm_data['checkout'], 
        $arrival,  
        $refund, 
        $booking_status, 
        $ORDER_ID, 
        $TRANS_ID, 
        $trans_status
    );
    
    if (!mysqli_stmt_execute($stmt1)) {
        die("Error: Booking order insertion failed - " . mysqli_error($con));
    }

    $booking_id = mysqli_insert_id($con);

    // Insert into `booking_details`
   // Fetch User Name
$user_name = "Guest User"; // Default value

if (isset($_SESSION['user']['name']) && !empty($_SESSION['user']['name'])) {
    $user_name = $_SESSION['user']['name']; // Get from session
} elseif (isset($frm_data['name']) && !empty($frm_data['name'])) {
    $user_name = $frm_data['name']; // Get from form
}

// Fetch Room Name
$room_name = isset($_SESSION['room']['name']) ? $_SESSION['room']['name'] : "Unknown Room";

// Debugging: Check values before inserting

$query2 = "INSERT INTO booking_details 
    (booking_id, room_no, room_name, price, total_pay, user_name, phonenum, address, user_id) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt2 = mysqli_prepare($con, $query2);
mysqli_stmt_bind_param($stmt2, "iississsi", 
    $booking_id, 
    $_SESSION['room']['room_no'], 
    $room_name, 
    $_SESSION['room']['price'], 
    $TXN_AMOUNT, 
    $user_name, 
    $frm_data['phonenum'], 
    $frm_data['address'], 
    $CUST_ID
);

if (!mysqli_stmt_execute($stmt2)) {
    die("Error: Booking details insertion failed - " . mysqli_error($con));
}


    $order = $api->order->create([
        'receipt' => $ORDER_ID,
        'amount' => $TXN_AMOUNT * 100, 
        'currency' => 'INR',
        'payment_capture' => 1
    ]);

    mysqli_close($con);
    
    ?>
    <html>
    <head>
        <title>Redirecting to Payment...</title>
        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    </head>
    <body>
        <h1>Please wait, redirecting to payment...</h1>
        <script>
        var options = {
            "key": "<?php echo RAZORPAY_KEY_ID; ?>",
            "amount": "<?php echo $TXN_AMOUNT * 100; ?>",
            "currency": "INR",
            "name": "MAHARAJ HOTEL ",
            "description": "Room Booking Payment",
            "order_id": "<?php echo $order['id']; ?>",
            "handler": function (response){
                window.location.href = "<?php echo $_SERVER['PHP_SELF']; ?>?order_id=<?php echo $ORDER_ID; ?>&payment_id=" + response.razorpay_payment_id + "&signature=" + response.razorpay_signature;
            },
            "prefill": {
                "name": "<?php echo $frm_data['name']; ?>",
                "email": "test@example.com",
                "contact": "<?php echo $frm_data['phonenum']; ?>",
            },
            "theme": {
                "color": "#3399cc"
            }
        };

        var rzp1 = new Razorpay(options);
        rzp1.open();
        </script>
    </body>
    </html>
    <?php
    exit();
}


if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['order_id']) && isset($_GET['payment_id']) && isset($_GET['signature'])) {

    $order_id = $_GET['order_id'];
    $razorpay_payment_id = $_GET['payment_id'];
    $signature = $_GET['signature'];

    $slct_query = "SELECT `booking_id`, `user_id` FROM `booking_order` WHERE `order_id` = ?";
    $stmt = mysqli_prepare($con, $slct_query);
    mysqli_stmt_bind_param($stmt, "s", $order_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 0) {
        die("Error: Order not found.");
    }

    $booking = mysqli_fetch_assoc($result);
    $booking_id = $booking['booking_id'];

    $generated_signature = hash_hmac('sha256', $order_id . "|" . $razorpay_payment_id, RAZORPAY_KEY_SECRET);

    if ($generated_signature === $signature) {
        file_put_contents("error_log.txt", "Signature mismatch - Order ID: $order_id, Received Signature: $signature, Generated: $generated_signature\n", FILE_APPEND);

        $fail_query = "UPDATE `booking_order` SET 
            `trans_status` = 'TXN_FAILED', 
            `trans_resp_msg` = 'Payment Failed' 
            WHERE `order_id` = ?";

        $stmt = mysqli_prepare($con, $fail_query);
        mysqli_stmt_bind_param($stmt, "s", $order_id);
        mysqli_stmt_execute($stmt);

        mysqli_close($con);

        header("Location: pay_status.php?order=" . $order_id . "&status=failed");
        exit();
    } else {
        // Payment Failed
        $upd_query = "UPDATE `booking_order` SET 
        `booking_status` = 'booked',
        `trans_id` = ?, 
        `trans_amt` = (SELECT total_pay FROM booking_details WHERE booking_id = ? LIMIT 1),
        `trans_status` = 'TXN_SUCCESS', 
        `trans_resp_msg` = 'Payment Successful' 
        WHERE `booking_id` = ?";
    

        $stmt = mysqli_prepare($con, $upd_query);
        mysqli_stmt_bind_param($stmt, "sii", $razorpay_payment_id, $booking_id, $booking_id);
        mysqli_stmt_execute($stmt);

        mysqli_close($con);

        header("Location: pay_status.php?order=" . $order_id);
        exit();
    }
}

mysqli_close($con);
?>
