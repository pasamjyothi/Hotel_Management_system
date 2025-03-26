<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
require('../inc/db_config.php');
require('../inc/essentials.php');
adminLogin();

if (isset($_POST['get_bookings'])) {
    $frm_data = filteration($_POST);

    $query = "SELECT bo.*, bd.* FROM `booking_order` bo
              INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
              WHERE (bo.order_id LIKE ? OR bd.phonenum LIKE ? OR bd.user_name LIKE ?)
              AND (bo.booking_status = ? AND bo.refund = ?)
              ORDER BY bo.booking_id ASC";

    $res = select($query, ["%$frm_data[search]%", "%$frm_data[search]%", "%$frm_data[search]%", "cancelled", 0], "sssss");

    $i = 1;
    $table_data = "";

    if (mysqli_num_rows($res) == 0) {
        echo "<b>No Data Found</b>";
        exit;
    }

    while ($data = mysqli_fetch_assoc($res)) {
        $date = date("d-m-Y", strtotime($data['datentime']));
        $checkin = date("d-m-Y", strtotime($data['check_in']));
        $checkout = date("d-m-Y", strtotime($data['check_out']));

        $table_data .= "
            <tr>
                <td>$i</td>
                <td>
                    <span class='badge bg-primary'>
                        Order ID: $data[order_id]
                    </span>
                    <br>
                    <b>Name:</b> $data[user_name]
                    <br>
                    <b>Phone No:</b> $data[phonenum]
                </td>
                <td>
                    <b>Check-in:</b> $checkin
                    <br>
                    <b>Check-out:</b> $checkout
                    <br>
                    <b>Date:</b> $date
                </td>
                <td>
                <b>₹$data[trans_amt]</b>
                </td>
                <td>
                    <button type='button' onclick='refund_booking($data[booking_id])' class='btn text-light btn-sm fw-bold btn-success shadow-none'>
                        <i class='bi bi-cash-stack'></i> Refund
                    </button>
                </td>
            </tr>
        ";

        $i++;
    }
    echo $table_data;
}

// Refund booking logic
if (isset($_POST['refund_booking'])) {
    $frm_data = filteration($_POST);

    // Ensure booking exists and is cancelled
    $check_query = "SELECT * FROM `booking_order` WHERE `booking_id`=? AND `booking_status`='cancelled' AND `refund`=0";
    $check_res = select($check_query, [$frm_data['booking_id']], 'i');

    if (mysqli_num_rows($check_res) > 0) {
        // Proceed with the refund update
        $query = "UPDATE `booking_order` SET `refund`=1 WHERE `booking_id`=?"; 
        $values = [$frm_data['booking_id']];
        $res = update($query, $values, 'i');

        if ($res) {
            echo "1";  // Success response
        } else {
            echo "0";  // Failure response
        }
    } else {
        echo "0";  // No matching booking found or already refunded
    }
}
?>
