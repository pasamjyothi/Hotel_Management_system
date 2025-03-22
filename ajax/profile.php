<?php
require('../admin/inc/db_config.php');
require('../admin/inc/essentials.php');
date_default_timezone_set("Asia/Kolkata");
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    redirect('index.php');
}

// Fetch user data
$u_exist = select("SELECT * FROM `user_cred` WHERE `id`=? LIMIT 1", [$_SESSION['uId']], 's');
if (mysqli_num_rows($u_exist) == 0) {
    redirect('index.php');
}

$u_fetch = mysqli_fetch_assoc($u_exist);

// Handle profile information update
if (isset($_POST['info_form'])) {
    $frm_data = filteration($_POST);

    // Check if phone number already exists for another user
    $u_exist = select("SELECT * FROM user_cred WHERE phonenum=? AND id!=? LIMIT 1", 
                      [$frm_data['phonenum'], $_SESSION['uId']], 
                      "si");

    if (mysqli_num_rows($u_exist) != 0) {
        echo 'phone_already';
        exit;
    }

    // Update user information
    $query = "UPDATE user_cred 
              SET name=?, address=?, phonenum=?, pincode=?, dob=? 
              WHERE id=?";

    $values = [
        $frm_data['name'],
        $frm_data['address'],
        $frm_data['phonenum'],
        $frm_data['pincode'],
        $frm_data['dob'],
        $_SESSION['uId']
    ];

    if (update($query, $values, 'ssssis')) { 
        $_SESSION['uName'] = $frm_data['name'];
        echo "success";
    } else {
        echo "error";
    }
    exit;
}

// Handle profile picture update
if (isset($_FILES['profile'])) {
    $img = uploadUserImage($_FILES['profile']);

    if ($img == 'inv_img') {
        echo 'invalid_image';
        exit;
    } elseif ($img == 'upd_failed') {
        echo 'upload_failed';
        exit;
    }

    // Update profile picture in database
    $query = "UPDATE `user_cred` SET `profile`=? WHERE `id`=? LIMIT 1";
    $values = [$img, $_SESSION['uId']];

    if (update($query, $values, 'si')) {
        $_SESSION['uPic'] = $img;
        echo "success";
    } else {
        echo "error";
    }
    exit;
}

// Handle password update
if (isset($_POST['pass_form'])) {
    $frm_data=filteration($_POST);
    session_start();
    if($frm_data['new_pass']!=$frm_data['confirm_pass']){
      echo 'mismatch';
      exit;  
    }
    $enc_pass=password_hash($frm_data['new_pass'],PASSWORD_BCRYPT);
    
    $query = "UPDATE user_cred SET password=? WHERE id=? LIMIT 1";

  
    $values = [
        $enc_pass,
        $_SESSION['uId']
    ];

    
    if (update($query, $values, 'ss')) { 
        $_SESSION['uPic'] = $img;
        echo 1; 
    } else {
        echo 0; 
    }
}
?>
