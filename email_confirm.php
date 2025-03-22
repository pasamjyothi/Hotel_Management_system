<?php

require('admin/inc/essentials.php');
require('admin/inc/db_config.php'); 

if (isset($_GET['type']) && $_GET['type'] == 'email_confirmation') {
    $data = filteration($_GET);

    $query = select("SELECT * FROM `user_cred` WHERE `email`=? AND `token`=? LIMIT 1", [$data['email'], $data['token']], 'ss');

    if (mysqli_num_rows($query) == 1) {
        $fetch = mysqli_fetch_assoc($query);

        if ($fetch['is_verified'] == 1) {
            echo "<script>alert('Email already verified! Redirecting to login...'); window.location.href='index.php';</script>";
            exit;
        } else {
            $update = update("UPDATE `user_cred` SET `is_verified`=1, `status`=1, `token`=NULL WHERE `id`=?", [$fetch['id']], 'i');

            if ($update) {
                echo "<script>alert('Email Verification Successful! Redirecting to login...'); window.location.href='index.php';</script>";
                exit;
            } else {
                echo "<script>alert('Email Verification Failed! Server Down'); window.location.href='index.php';</script>";
                exit;
            }
        }
    } else {
        echo "<script>alert('Invalid or Expired Link! Redirecting to home...'); window.location.href='index.php';</script>";
        exit;
    }
}
?>
