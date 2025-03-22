<?php
require(__DIR__ . '/admin/inc/db_config.php');
require(__DIR__ . '/admin/inc/essentials.php');
require(__DIR__ . '/inc/paytm/config_paytm.php');
require(__DIR__ . '/inc/paytm/encdec_paytm.php');
date_default_timezone_set("Asia/Kolkata");
session_start();

if (!isset($_SESSION['uId']) || !isset($_POST['pay_now'])) {
    die("Error: Unauthorized access.");
}

// Prevent direct access without form submission
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Error: Invalid request method.");
}

header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");

$ORDER_ID = 'ORD_' . $_SESSION['uId'] . random_int(11111, 9999999);
$CUST_ID = $_SESSION['uId'];
$TXN_AMOUNT = $_SESSION['room']['payment'] ?? 0;

if ($TXN_AMOUNT <= 0) {
    die("Error: Invalid transaction amount.");
}

$paramList = [
    "MID" => PAYTM_MERCHANT_MID,
    "ORDER_ID" => $ORDER_ID,
    "CUST_ID" => $CUST_ID,
    "INDUSTRY_TYPE_ID" => INDUSTRY_TYPE_ID,
    "CHANNEL_ID" => CHANNEL_ID,
    "TXN_AMOUNT" => $TXN_AMOUNT,
    "WEBSITE" => PAYTM_MERCHANT_WEBSITE,
    "CALLBACK_URL" => CALLBACK_URL
];

$checkSum = getChecksumFromArray($paramList, PAYTM_MERCHANT_KEY);
$frm_data = filteration($_POST);

// Database Insertion
$query1 = "INSERT INTO `booking_order` (`user_id`, `room_id`, `check_in`, `check_out`, `order_id`) VALUES (?, ?, ?, ?, ?)";
insert($query1, [$CUST_ID, $_SESSION['room']['id'], $frm_data['checkin'], $frm_data['checkout'], $ORDER_ID], 'issss');

$booking_id = mysqli_insert_id($con);
$query2 = "INSERT INTO `booking_details` (`booking_id`, `room_name`, `price`, `total_pay`, `user_name`, `phonenum`, `address`) VALUES (?, ?, ?, ?, ?, ?, ?)";
insert($query2, [$booking_id, $_SESSION['room']['name'], $_SESSION['room']['price'], $TXN_AMOUNT, $frm_data['name'], $frm_data['phonenum'], $frm_data['address']], 'issssss');

?>
<html>
<head>
    <title>Redirecting to Payment...</title>
</head>
<body>
    <h1>Please wait, you are being redirected...</h1>
    <form method="post" action="<?php echo PAYTM_TXN_URL; ?>" name="paymentForm">
        <?php foreach ($paramList as $name => $value) { ?>
            <input type="hidden" name="<?php echo $name; ?>" value="<?php echo $value; ?>">
        <?php } ?>
        <input type="hidden" name="CHECKSUMHASH" value="<?php echo $checkSum; ?>">
    </form>
    <script type="text/javascript">document.paymentForm.submit();</script>
</body>
</html>
