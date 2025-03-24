<?php
require(__DIR__ . '/admin/inc/db_config.php');
require(__DIR__ . '/admin/inc/essentials.php');

session_start();

if (!isset($_GET['order']) || !isset($_SESSION['uId'])) {
    redirect('index.php');
}

$order_id = $_GET['order'];

$query = "SELECT * FROM `booking_order` WHERE `order_id` = ? AND `user_id` = ? AND `booking_status` != ?";
$result = select($query, [$order_id, $_SESSION['uId'], 'booked'], 'sis');

if (mysqli_num_rows($result) == 0) {
    redirect('index.php');
}

$booking = mysqli_fetch_assoc($result);

?>

<html>
<head>
    <title>Payment Status</title>
</head>
<body>
    <?php require('inc/header.php');?>
    <h2>Payment Status</h2>
    <?php if ($booking['trans_status'] === 'success'): ?>
        <p>Payment successful! Your booking is confirmed.</p>
    <?php else: ?>
        <p>Payment failed. Please try again.</p>
    <?php endif; ?>
    <a href="bookings.php">Go to Bookings</a>
    <?php require('inc/footer.php');?>
</body>
</html>
