<?php 


define('SITE_URL', 'http://127.0.0.1/hotel-management/');
define('ABOUT_IMG_PATH', SITE_URL . 'image/about/');
define('USER_IMG_PATH', SITE_URL . 'image/user/');
define('FEATURES_IMG_PATH', SITE_URL . 'image/features/');
define('ROOMS_IMG_PATH', SITE_URL . 'image/rooms/');
define('USERIMAGE_IMG_PATH', SITE_URL . 'image/userimage/');

define('UPLOAD_IMAGE_PATH',$_SERVER['DOCUMENT_ROOT'].'/hotel-management/image/');
define('ABOUT_FOLDER','about/');
define('USER_FOLDER','user/');
define('FEATURES_FOLDER','features/');
define('ROOMS_FOLDER','rooms/');
define('USERIMAGE_FOLDER', 'userimage/');

define('SENDGRID_API_KEY', "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");
define('SENDGRID_EMAIL',"mounikapamula496@gmail.com");
define("SENDGRID_NAME","MAHARAJ HOTEL");
function adminLogin(){
   session_start();
   if(!(isset($_SESSION['adminLogin'])&& $_SESSION['adminLogin']==true)){
    echo"<script>
    window.location.href='index.php';
    </script>
    ";
    exit;
   } 
}


function redirect($url){
    echo"<script>
    window.location.href='$url';
    </script>
    ";
    exit;
}


function alert($type,$msg){
    $bs_class=($type=="success")? "alert-success":"alert-danger";
   
    echo <<<alert
    <div class="alert $bs_class alert-dismissible fade show custom-alert" role="alert">
        <strong class="me-3">$msg</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    alert;
}
function uploadImage($image, $folder) {
    $valid_mime = ['image/jpeg', 'image/png', 'image/webp'];
    $img_mime = $image['type'];

    if (!in_array($img_mime, $valid_mime)) {
        return 'inv_img';
    } else if (($image['size'] / (1024 * 1024)) > 2) {
        return 'inv_size';
    } else {
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $rname = 'IMG_' . random_int(11111, 99999) . ".$ext";

        $img_path = UPLOAD_IMAGE_PATH . $folder . $rname;
        if (move_uploaded_file($image['tmp_name'], $img_path)) {
            return $rname;
        } else {
            return 'upd_failed';
        }
    }
}
function deleteImage($image, $folder) {
    $img_path = UPLOAD_IMAGE_PATH . $folder . $image;
    if (file_exists($img_path)) {
        return unlink($img_path);
    }
    return false;
}


function uploadSVGImage($image, $folder) 
    {
    $valid_mime = ['image/jpeg', 'image/png', 'image/webp','image/svg+xml'];
    $img_mime = $image['type'];

    if (!in_array($img_mime, $valid_mime)) {
        return 'inv_img';
    } else if (($image['size'] / (1024 * 1024)) > 1) {
        return 'inv_size';
    } else {
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $rname = 'IMG_' . random_int(11111, 99999) . ".$ext";

        $img_path = UPLOAD_IMAGE_PATH . $folder . $rname;
        if (move_uploaded_file($image['tmp_name'], $img_path)) {
            return $rname;
        } else {
            return 'upd_failed';
        }
    }
}
function uploadUserImage($image){
        $valid_mime = ['image/jpeg', 'image/png', 'image/webp'];
        $img_mime = $image['type'];
    
        if (!in_array($img_mime, $valid_mime)) {
            return 'inv_img';
        } else {
            $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
            $rname = 'IMG_' . random_int(11111, 99999) . ".jpeg";
            $img_path = UPLOAD_IMAGE_PATH .USERIMAGE_FOLDER.$rname;
            if($ext=='png'||$ext=='PNG'){
                $img=imagecreatefrompng($image['tmp_name']);
            }else if($ext=='webp'||$ext=='WEBP'){
                $img=imagecreatefromwebp($image['tmp_name']);
            }else{
                $img=imagecreatefromjpeg($image['tmp_name']);
            }
            if(imagejpeg($img,$img_path,75)) {
                return $rname;
            } else {
                return 'upd_failed';
            }
        }
} 

?>