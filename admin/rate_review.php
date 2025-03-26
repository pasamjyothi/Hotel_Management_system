<?php 
require('inc/essentials.php');
require('inc/db_config.php');
adminLogin();

$alert_msg = '';
$alert_type = ''; 
if (isset($_GET['seen'])) {
    $frm_data = filteration($_GET);
    if ($frm_data['seen'] == 'all') {
        $q = "UPDATE `rating_review` SET `seen`=?";
        $values = [1];
        if (update($q, $values, 'i')) {
            $alert_msg = 'Marked as read successfully!';
            $alert_type = 'success';
        } else {
            $alert_msg = 'Failed to mark as read.';
            $alert_type = 'danger';
        }
    }
    else {
        $q = "UPDATE `rating_review` SET `seen`=? WHERE `sr_no`=?";
        $values = [1, $frm_data['seen']];
        if (update($q, $values, 'ii')) {
            $alert_msg = 'Marked as read successfully!';
            $alert_type = 'success';
        } else {
            $alert_msg = 'Failed to mark as read.';
            $alert_type = 'danger';
        }
    }
}

if (isset($_GET['del'])) {
    $frm_data = filteration($_GET);
    if($frm_data['del']=='all'){
    $q = "DELETE FROM `rating_review`";
    if (mysqli_query($con,$q)) {
        $alert_msg = 'Deleted successfully!';
        $alert_type = 'success';
    } else {
        $alert_msg = 'Failed to delete.';
        $alert_type = 'danger';
    }
    }
   else{
    $q = "DELETE FROM `rating_review` WHERE `sr_no`=?";
    $values = [$frm_data['del']];
    if (update($q, $values, 'i')) {
        $alert_msg = 'Deleted successfully!';
        $alert_type = 'success';
    } else {
        $alert_msg = 'Failed to delete.';
        $alert_type = 'danger';
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Ratings & Reviews</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/#commoncss">
    <style>
        #dashboard-menu {
            position: fixed;
            height: 100%;
        }
        @media screen and (max-width: 991px) {
            #dashboard-menu {
                height: auto;
                width: 100%;
            }
            #main-content {
                margin-top: 60px;
            }
        }
    </style>
</head>
<body class="bg-white">
    <?php require('inc/header.php'); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">RATINGS & REVIEWS</h3>
                <?php if ($alert_msg): ?>
                    <div class="alert alert-<?= $alert_type ?> alert-dismissible fade show" role="alert">
                        <?= $alert_msg ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <a href="?seen=all" class="btn btn-dark rounded-pill shadow-none btn-sm">
                            <i class="bi bi-check2-all"></i>Mark all read</a>
                            <a href="?del=all" class="btn btn-danger rounded-pill shadow-none btn-sm">
                            <i class="bi bi-trash3-fill"></i>Delete all</a>
                        </div>
                        <div class="table-responsive-md">
                            <table class="table table-hover border">
                                <thead>
                                    <tr class="bg-dark text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Room Name</th>
                                        <th scope="col">User Name</th>
                                        <th scope="col" >Rating</th>
                                        <th scope="col" width="30%">Review</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $q = "SELECT rr.*,uc.name AS uname, r.name AS rname FROM `rating_review` rr
                                     INNER JOIN `user_cred` uc ON rr.user_id=uc.id
                                    INNER JOIN `rooms` r ON rr.room_id=r.id
                                     ORDER BY `sr_no` DESC";
                                    $data = mysqli_query($con, $q);
                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($data)) {
                                        $date=date('d-m-Y',strtotime($row['datentime']));

                                        $actions = "";
                                        if ($row['seen'] != 1) {
                                            $actions .= "<a href='?seen=$row[sr_no]' class='btn btn-sm rounded-pill btn-primary'>Mark as read</a> <br>";
                                        }
                                        $actions .= "<a href='?del=$row[sr_no]' class='btn btn-sm rounded-pill btn-danger'>Delete</a>";

                                        echo <<<QUERY
                                        <tr>
                                            <td>$i</td>
                                            <td>$row[rname]</td>
                                            <td>$row[uname]</td>
                                            <td>$row[rating]</td>
                                            <td>$row[review]</td>
                                            <td>$date</td>
                                            <td>$actions</td>
                                        </tr>
                                        QUERY;
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require('inc/script.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
