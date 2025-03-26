<?php 
require('inc/essentials.php');
require('inc/db_config.php'); // or wherever the connection is set

adminLogin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel-Dasboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/#commoncss">
    <style>
        #dashboard-menu{
            position: fixed;
            height: 100%;
            z-index: 11;
        }
        @media screen and(max-width:991px) {
            #dashboard-menu{
            height: auto;
            width: 100%;

        }
        #main-content{
            margin-top: 60px;

        }
        }
     </style>
</head>
<body bg-white>
   <?php 
   require('inc/header.php');
   $is_shutdown=mysqli_fetch_assoc(mysqli_query($con,"SELECT `shutdown` FROM `settings`"));
   $current_bookings = mysqli_fetch_assoc(mysqli_query($con, "
    SELECT 
        COUNT(CASE WHEN booking_status='booked' AND arrival=0 THEN 1 END) AS new_bookings,
        COUNT(CASE WHEN booking_status='cancelled' AND refund=0 THEN 1 END) AS refund_bookings
    FROM `booking_order`
"));

   $unread_queries=mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(sr_no) AS count FROM user_queries WHERE seen=0"));
   $unread_reviews=mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(sr_no) AS count FROM rating_review WHERE seen=0"));
   $current_users = mysqli_fetch_assoc(mysqli_query($con, "
   SELECT 
       COUNT(id) AS total,
       COUNT(CASE WHEN status=1 THEN 1 END) AS active,
       COUNT(CASE WHEN status=0 THEN 1 END) AS  inactive,
       COUNT(CASE WHEN is_verified=0 THEN 1 END) AS unverified
   FROM `user_cred`
"));
 
 ?>
    <div class="conatiner-fluid " id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h3>DASHBOARD</h3>
                </div>
                <div class="row mb-4">
                    <div class="col-md-3 mb-4">
                        <a href="new_bookings.php" class="text-decoration-none">
                            <div class="card text-center text-success p-3">
                                <h6>New Bookings</h6>
                                <h1 class="mt-2 mb-0"><?php echo $current_bookings['new_bookings']?></h1>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 mb-4">
                        <a href="refund_bookings.php" class="text-decoration-none">
                            <div class="card text-center text-warning p-3">
                                <h6>Refund Bookings</h6>
                                <h1 class="mt-2 mb-0"><?php echo $current_bookings['refund_bookings']?></h1>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 mb-4">
                        <a href="user_queries.php" class="text-decoration-none">
                            <div class="card text-center text-info p-3">
                                <h6>User Queries</h6>
                                <h1 class="mt-2 mb-0"><?php echo $unread_queries['count']?></h1>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 mb-4">
                        <a href="rate_review.php" class="text-decoration-none">
                            <div class="card text-center text-info p-3">
                                <h6>Rating & Review</h6>
                                <h1 class="mt-2 mb-0">5</h1>
                            </div>
                        </a>
                    </div>

                </div>
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h3>Booking Analytics</h3>
                    <select class="form-select shadow-none bg-light w-auto " onchange="booking_analytics(this.value)">
                        <option value="1">Past 2 Days</option>
                        <option value="2">Past 5 Days</option>
                        <option value="3">Past 1 Year</option>
                        <option value="4">All time</option>
                    </select>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-primary p-3">
                            <h6>Total Bookings</h6>
                            <h1 class="mt-2 mb-0" id="total_bookings">0</h1>
                            <h4 class="mt-2 mb-0" id="total_amt">0/-</h4>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-success p-3">
                            <h6>Active Bookings</h6>
                            <h1 class="mt-2 mb-0" id="active_bookings">0</h1>
                            <h4 class="mt-2 mb-0" id="active_amt">0/-</h4>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-primary p-3">
                            <h6>Cancelled Bookings</h6>
                            <h1 class="mt-2 mb-0" id="cancelled_bookings">0</h1>
                            <h4 class="mt-2 mb-0" id="cancelled_amt">0/-</h4>
                        </div>
                    </div>

                </div>
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h3>User, Queries,Reviews Analytics</h3>
                    <select class="form-select shadow-none bg-light w-auto" onchange="user_analytics(this.value)">
                        <option value="1">Past 2 Days</option>
                        <option value="2">Past 5 Days</option>
                        <option value="3">Past 1 Year</option>
                        <option value="4">All time</option>
                    </select>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-success p-3">
                            <h6>New Registration</h6>
                            <h1 class="mt-2 mb-0" id="total_new_reg">0</h1>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-primary p-3">
                            <h6>Queries</h6>
                            <h1 class="mt-2 mb-0" id="total_queries">0</h1>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-primary p-3">
                            <h6>Reviews</h6>
                            <h1 class="mt-2 mb-0" id="total_reviews">0</h1>
                        </div>
                    </div>

                </div>

                <h5>Users</h5>
                <div class="row mb-3">
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-info p-3">
                            <h6>Total</h6>
                            <h1 class="mt-2 mb-0"><?php echo $current_users['total']?></h1>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-success p-3">
                            <h6>Active</h6>
                            <h1 class="mt-2 mb-0"><?php echo $current_users['active']?></h1>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-warning p-3">
                            <h6>Inactive</h6>
                            <h1 class="mt-2 mb-0"><?php echo $current_users['inactive']?></h1>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-danger p-3">
                            <h6>Unverified</h6>
                            <h1 class="mt-2 mb-0"><?php echo $current_users['unverified']?></h1>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<?php require('inc/script.php'); ?>
<script>
function booking_analytics(period = 1) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/dashboard_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        try {
            let data = JSON.parse(this.responseText);

            document.getElementById('total_bookings').textContent = data.total_bookings;
            document.getElementById('total_amt').textContent = data.total_amt + "/-";
            document.getElementById('active_bookings').textContent = data.active_bookings;
            document.getElementById('active_amt').textContent = data.active_amt + "/-";
            document.getElementById('cancelled_bookings').textContent = data.cancelled_bookings;
            document.getElementById('cancelled_amt').textContent = data.cancelled_amt + "/-";
        } catch (error) {
            console.error("Error parsing booking analytics JSON:", error, "Response:", this.responseText);
        }
    };

    xhr.send("booking_analytics=1&period=" + period);
}

function user_analytics(period = 1) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/dashboard_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        try {
            let data = JSON.parse(this.responseText);

            document.getElementById('total_new_reg').textContent = data.total_new_reg;
            document.getElementById('total_queries').textContent = data.total_queries;
            document.getElementById('total_reviews').textContent = data.total_reviews;
        } catch (error) {
            console.error("Error parsing user analytics JSON:", error, "Response:", this.responseText);
        }
    };

    xhr.send("user_analytics=1&period=" + period);
}

window.onload = function () {
    booking_analytics();
    user_analytics();
};

</script>
</body>
</html>