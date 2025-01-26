<?php
require('../inc/db_config.php');
require('../inc/essentials.php');
adminLogin();
if(isset($_POST['add_image'])){
    $img_r=uploadImage($_FILES['picture'],USER_FOLDER);
    if($img_r=='inv_img'){
        echo $img_r;
    }
    else if($img_r=='inv_size'){
        echo $img_r;
    }
    else if($img_r=='upd_failed'){
        echo $img_r;
    }
    else{
       $q="INSERT INTO `user_details`(`image`) VALUES (?)" ;
       $values=[$img_r];
       $res=insert($q,$values,'s');
       echo $res;
    }
}
if (isset($_POST['get_user'])) {
    $res = selectAll('user_details');

    while ($row = mysqli_fetch_assoc($res)) {
        $path = USER_IMG_PATH;
        echo<<<data
         <div class="col-md-4 mb-3">
                <div class="card  bg-dark text-light">
                    <img src="$path$row[image]" class="card-img">
                    <div class="card-img-overlay text-end">
                        <button type="button" onClick="rem_user($row[sr_no])" class="btn btn-danger btn-sm shadow-none">
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
    $values = [$frm_data['rem_user']];
    $pre_q = "SELECT * FROM `user_details` WHERE `sr_no`=?";
    $res = select($pre_q, $values, 'i');
    $img = mysqli_fetch_assoc($res);

    if ($img && deleteImage($img['image'], USER_FOLDER)) {
        $q = "DELETE FROM `user_details` WHERE `sr_no`=?";
        $res = delete($q, $values, 'i');
        echo $res;
    } else {
        echo 0; 
    }
}




?>