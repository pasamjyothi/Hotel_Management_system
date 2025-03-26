<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

require('../inc/db_config.php');
require('../inc/essentials.php');
adminLogin();

if (isset($_POST['booking_analytics'])) { 
    $frm_data = filteration($_POST);
    $condition = "";

    if ($frm_data['period'] == 1) {
        $condition = "WHERE datentime BETWEEN NOW() - INTERVAL 2 DAY AND NOW()";
    } elseif ($frm_data['period'] == 2) {
        $condition = "WHERE datentime BETWEEN NOW() - INTERVAL 5 DAY AND NOW()";
    } elseif ($frm_data['period'] == 3) {
        $condition = "WHERE datentime BETWEEN NOW() - INTERVAL 1 YEAR AND NOW()";
    }

    // Fetch booking analytics
    $query = "
        SELECT 
            COUNT(booking_id) AS total_bookings,
            COALESCE(SUM(trans_amt),0) AS total_amt,
            COUNT(CASE WHEN booking_status = 'booked' AND arrival = 1 THEN 1 END) AS active_bookings,
            COALESCE(SUM(CASE WHEN booking_status = 'booked' AND arrival = 1 THEN trans_amt END), 0) AS active_amt,
            COUNT(CASE WHEN booking_status = 'cancelled' AND refund=1 THEN 1 END) AS cancelled_bookings,
            COALESCE(SUM(CASE WHEN booking_status = 'cancelled' AND refund=1 THEN trans_amt END), 0) AS cancelled_amt
        FROM booking_order 
        $condition
    ";

    $current_bookings = mysqli_fetch_assoc(mysqli_query($con, $query));
    echo json_encode($current_bookings);
    exit;
}

if (isset($_POST['user_analytics'])) { 
    $frm_data = filteration($_POST);
    $condition = "";
    if ($frm_data['period'] == 1) {
        $condition = "WHERE datentime BETWEEN NOW() - INTERVAL 2 DAY AND NOW()";
    } elseif ($frm_data['period'] == 2) {
        $condition = "WHERE $datentime BETWEEN NOW() - INTERVAL 5 DAY AND NOW()";
    } elseif ($frm_data['period'] == 3) {
        $condition = "WHERE $datentime BETWEEN NOW() - INTERVAL 1 YEAR AND NOW()";
    }

    $total_review = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(sr_no) AS count FROM rating_review $condition"));
    $total_queries = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(sr_no) AS count FROM user_queries $condition"));
    $total_new_reg = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(id) AS count FROM user_cred $condition"));

    $output = [
        'total_queries' => $total_queries['count'] ?? 0,
        'total_reviews' => $total_review['count'] ?? 0,
        'total_new_reg' => $total_new_reg['count'] ?? 0
    ];

    echo json_encode($output);
    exit;
}

?>
