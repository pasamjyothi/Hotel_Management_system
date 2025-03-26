<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
require('../inc/db_config.php');
require('../inc/essentials.php');
adminLogin();

if (isset($_POST['add_room'])) {
    $features = isset($_POST['features']) ? json_decode($_POST['features'], true) : [];
    $facilities = isset($_POST['facilities']) ? json_decode($_POST['facilities'], true) : [];

    $frm_data = filteration($_POST);
    $flag = 0;

    $q1 = "INSERT INTO rooms(`name`, `area`, `price`, `quantity`, `adult`, `children`, `description`) VALUES (?,?,?,?,?,?,?)";
    $values = [$frm_data['name'], $frm_data['area'], $frm_data['price'], $frm_data['quantity'], $frm_data['adult'], $frm_data['children'], $frm_data['description']];

    if (insert($q1, $values, 'siiiiis')) {
        $flag = 1;
    } else {
        die('Error inserting room data.');
    }

    global $con;
    $room_id = mysqli_insert_id($con);

    if (!empty($facilities)) {
        $q2 = "INSERT INTO rooms_facilities(room_id, facilities_id) VALUES (?, ?)";
        if ($stmt = mysqli_prepare($con, $q2)) {
            foreach ($facilities as $f) {
                mysqli_stmt_bind_param($stmt, 'ii', $room_id, $f);
                mysqli_stmt_execute($stmt);
            }
            mysqli_stmt_close($stmt);
        }
    }

    if (!empty($features)) {
        $q3 = "INSERT INTO rooms_features(room_id, features_id) VALUES (?, ?)";
        if ($stmt = mysqli_prepare($con, $q3)) {
            foreach ($features as $f) {
                mysqli_stmt_bind_param($stmt, 'ii', $room_id, $f);
                mysqli_stmt_execute($stmt);
            }
            mysqli_stmt_close($stmt);
        }
    }

    echo $flag ? '1' : 'error';
}
if (isset($_POST['get_all_rooms'])) {
    $res = select("SELECT * FROM `rooms` WHERE `removed` =?", [0], 'i');
    $i = 1;
    $data = "";
    while ($row = mysqli_fetch_assoc($res)) {
        $status = ($row['status'] == 1) 
            ? "<button onclick='toggle_status({$row['id']},0)' class='btn btn-dark btn-sm shadow-none'>Active</button>"
            : "<button onclick='toggle_status({$row['id']},1)' class='btn btn-warning btn-sm shadow-none'>Inactive</button>";

        $data .= "
        <tr class='align-middle'>
          <td>$i</td>
          <td>{$row['name']}</td>
          <td>{$row['area']} sq.ft</td>
          <td>
            <span class='badge rounded-pill bg-light text-dark'>Adult: {$row['adult']}</span><br>
            <span class='badge rounded-pill bg-light text-dark'>Children: {$row['children']}</span>
          </td>
          <td>{$row['price']}/-</td>
          <td>{$row['quantity']}</td>
          <td>$status</td>
          <td>
              <button type='button' onclick='edit_details({$row['id']})' class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#edit-room'>
                  <i class='bi bi-pencil-square'></i>
              </button>
              <button type='button' onclick=\"room_images({$row['id']}, '{$row['name']}')\" class='btn btn-info btn-sm' data-bs-toggle='modal' data-bs-target='#room-images'>
                  <i class='bi bi-images'></i>
              </button>
              <button type='button' onclick='remove_room({$row['id']})' class='btn btn-danger btn-sm'>
                  <i class='bi bi-trash'></i>
              </button>
          </td>
        </tr>";
        $i++;
    }

    echo $data;
}

if (isset($_POST['get_room'])) {
    $frm_data = filter_input_array(INPUT_POST);

    $res1 = select("SELECT * FROM rooms WHERE id=?", [$frm_data['get_room']], 'i');
    if (!$res1) {
        echo json_encode(["error" => "Database error: " . mysqli_error($con)]);
        exit;
    }

    $roomdata = mysqli_fetch_assoc($res1);
    $features = [];
    $facilities = [];

    // Fetch features
    $res2 = select("SELECT * FROM rooms_features WHERE room_id=?", [$frm_data['get_room']], 'i');
    while ($row = mysqli_fetch_assoc($res2)) {
        $features[] = $row['features_id'];
    }

    // Fetch facilities (fixed issue)
    $res3 = select("SELECT * FROM rooms_facilities WHERE room_id=?", [$frm_data['get_room']], 'i');
    while ($row = mysqli_fetch_assoc($res3)) {  // Corrected from $res2 to $res3
        $facilities[] = $row['facilities_id'];
    }

    $data = ["roomdata" => $roomdata, "features" => $features, "facilities" => $facilities];
    echo json_encode($data);
}
if (isset($_POST['edit_room'])) {
   
    // Validate and sanitize input data
    $frm_data = filteration($_POST);
    $room_id = intval($frm_data['room_id']); 

    // Decode JSON inputs
    $features = isset($_POST['features']) ? json_decode($_POST['features'], true) : [];
    $facilities = isset($_POST['facilities']) ? json_decode($_POST['facilities'], true) : [];

    if (!is_array($features) || !is_array($facilities)) {
        echo "Invalid data format for features or facilities";
        exit;
    }

    // Update room details
    $q1 = "UPDATE rooms SET name=?, area=?, price=?, quantity=?, adult=?, children=?, description=? WHERE id=?";
    $values = [$frm_data['name'], $frm_data['area'], $frm_data['price'], $frm_data['quantity'], $frm_data['adult'], $frm_data['children'], $frm_data['desc'], $room_id];

    if (!update($q1, $values, 'siiiiisi')) {
        echo "Error updating room details";
        exit;
    }

    // Delete previous features & facilities
    if (!delete("DELETE FROM rooms_features WHERE room_id=?", [$room_id], 'i') ||
        !delete("DELETE FROM rooms_facilities WHERE room_id=?", [$room_id], 'i')) {
        echo "Error deleting previous features/facilities";
        exit;
    }

    // Insert new facilities
    $q2 = "INSERT INTO rooms_facilities (room_id, facilities_id) VALUES (?, ?)";
    $stmt = mysqli_prepare($con, $q2);
    if ($stmt) {
        foreach ($facilities as $f) {
            mysqli_stmt_bind_param($stmt, 'ii', $room_id, $f);
            mysqli_stmt_execute($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error inserting facilities";
        exit;
    }

    // Insert new features
    $q3 = "INSERT INTO rooms_features (room_id, features_id) VALUES (?, ?)";
    $stmt = mysqli_prepare($con, $q3);
    if ($stmt) {
        foreach ($features as $f) {
            mysqli_stmt_bind_param($stmt, 'ii', $room_id, $f);
            mysqli_stmt_execute($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error inserting features";
        exit;
    }

    echo "1"; // Success response
}



if (isset($_POST['toggle_status'])) {
    $id = $_POST['toggle_status'];
    $val = $_POST['val'];

    $q = "UPDATE rooms SET status=? WHERE id=?";
    $values = [$val, $id];

    echo update($q, $values, 'ii') ? "1" : "error";
}
if (isset($_POST['add_image'])) {
    $frm_data = filteration($_POST);
    $img_r = uploadImage($_FILES['image'], ROOMS_FOLDER);

    if ($img_r == 'inv_img' || $img_r == 'inv_size' || $img_r == 'upd_failed') {
        echo $img_r;
        exit;
    }

    $query = "INSERT INTO room_images(room_id, image) VALUES (?,?)";
    $values = [$frm_data['room_id'], $img_r];
    $res = insert($query, $values, 'is');

    echo $res ? "1" : "upd_failed";
    exit;
}
if (isset($_POST['get_room_images'])) {
    $frm_data = filteration($_POST);
    $res=select("SELECT * FROM room_images WHERE room_id=?",[$frm_data['get_room_images']],'i');
    $path=ROOMS_IMG_PATH;
    while($row=mysqli_fetch_assoc($res)){
        if($row['thumb']==1){
            $thumb_btn="<i class='bi bi-check-lg text-light bg-success px-2 py-1' rounded fs-5></i>";
        }else{
            $thumb_btn="
                    <button onclick='thumb_image({$row['sr_no']}, {$row['room_id']})'
                            class='btn btn-secondary btn-sm shadow-none'>
                        <i class='bi bi-check-lg'></i>
                    </button>";
        }

        
        echo <<<data
            <tr class='align-middle'>
                <td><img src='{$path}{$row['image']}' class='img-fluid'></td>
                <td>  $thumb_btn</td>
                <td>
                    <button onclick='rem_image({$row['sr_no']}, {$row['room_id']})'
                            class='btn btn-danger btn-sm shadow-none'>
                        <i class='bi bi-trash'></i>
                    </button>
                </td>
            </tr>
            data;

    }
   
}
if (isset($_POST['rem_image'])) { 
    $frm_data = filteration($_POST);
    $values = [$frm_data['image_id'], $frm_data['room_id']];

 
    $pre_q = "SELECT * FROM `room_images` WHERE `sr_no`=? AND `room_id`=?";
    $res = select($pre_q, $values, 'ii');

    if (!$res || mysqli_num_rows($res) == 0) {
        echo json_encode(["status" => "error", "message" => "Image not found"]);
        exit;
    }

    $img = mysqli_fetch_assoc($res);


    if (!deleteImage($img['image'], ROOMS_FOLDER)) {
        echo json_encode(["status" => "error", "message" => "File deletion failed"]);
        exit;
    }


    $q = "DELETE FROM `room_images` WHERE `sr_no`=? AND `room_id`=?";
    $res = delete($q, $values, 'ii');

    if ($res) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Database delete failed"]);
    }
    exit;
}
if (isset($_POST['thumb_image'])) { 
    $frm_data = filteration($_POST);

    $pre_q = "UPDATE room_images SET thumb = ? WHERE room_id = ?"; 
    $pre_v = [0, $frm_data['room_id']];
    $pre_res = update($pre_q, $pre_v, 'ii');

    $q = "UPDATE room_images SET thumb = ? WHERE sr_no = ? AND room_id = ?"; 
    $v = [1, $frm_data['image_id'], $frm_data['room_id']];
    $res = update($q, $v, 'iii');


    if ($res) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Database update failed"]);
    }
    exit;
}

if (isset($_POST['remove_room'])) {

    $frm_data = filter_input_array(INPUT_POST, FILTER_SANITIZE_NUMBER_INT);
    $room_id = $frm_data['room_id'];

    if (!$room_id) {
        echo "0";  
        exit;
    }

    error_log("Attempting to delete room ID: " . $room_id);

    
    $booking_check = select("SELECT id FROM room_bookings WHERE room_id=?", [$room_id], 'i');
    if (mysqli_num_rows($booking_check) > 0) {
        echo "2";  
        exit;
    }

  
    $res1 = select("SELECT * FROM room_images WHERE room_id=?", [$room_id], 'i');
    while ($row = mysqli_fetch_assoc($res1)) {
        deleteImage($row['image'], ROOMS_FOLDER);
    }

    
    $res2 = delete("DELETE FROM room_images WHERE room_id=?", [$room_id], 'i');
    $res3 = delete("DELETE FROM rooms_features WHERE room_id=?", [$room_id], 'i');
    $res4 = delete("DELETE FROM rooms_facilities WHERE room_id=?", [$room_id], 'i');

    $res5 = delete("DELETE FROM rooms WHERE id=?", [$room_id], 'i');

    if ($res2 && $res3 && $res4 && $res5) {
        echo '1';  
    } else {
        echo '0';  
    }
}


?>