<?php
require('../inc/db_config.php');
require('../inc/essentials.php');

if (!function_exists('adminLogin')) {
    die("Function adminLogin not found.");
}
adminLogin();

if (isset($_POST['add_image'])) {
    if (!isset($_FILES['picture'])) {
        die("No file uploaded.");
    }

    $img_r = uploadImage($_FILES['picture'], USER_FOLDER);

    if (in_array($img_r, ['inv_img', 'inv_size', 'upd_failed'])) {
        echo $img_r;
    } else {
        $q = "INSERT INTO `user_details`(`image`) VALUES (?)";
        $values = [$img_r];
        $res = insert($q, $values, 's');

        if ($res) {
            echo "success";
        } else {
            echo "db_error";
        }
    }
}

if (isset($_POST['get_user'])) {
    $res = selectAll('user_details');

    if (!$res) {
        die("Query failed.");
    }

    $path = USER_IMG_PATH;
    while ($row = mysqli_fetch_assoc($res)) {
        echo <<<data
        <div class="col-md-4 mb-3">
            <div class="card bg-dark text-light">
                <img src="{$path}{$row['image']}" class="card-img">
                <div class="card-img-overlay text-end">
                    <button type="button" onClick="rem_user({$row['sr_no']})" class="btn btn-danger btn-sm shadow-none">
                        <i class="bi bi-trash3"></i> Delete
                    </button>
                </div>
            </div>
        </div>
        data;
    }
}

if (isset($_POST['rem_user'])) {
    $frm_data = filteration($_POST);
    
    if (!isset($frm_data['rem_user'])) {
        die("Invalid request.");
    }

    $values = [$frm_data['rem_user']];
    $pre_q = "SELECT * FROM `user_details` WHERE `sr_no`=?";
    $res = select($pre_q, $values, 'i');

    if (!$res) {
        die("Query execution failed.");
    }

    $img = mysqli_fetch_assoc($res);

    if ($img && deleteImage($img['image'], USER_FOLDER)) {
        $q = "DELETE FROM `user_details` WHERE `sr_no`=?";
        $res = delete($q, $values, 'i');

        echo $res ? "success" : "delete_failed";
    } else {
        echo "img_delete_failed";
    }
}
?>
