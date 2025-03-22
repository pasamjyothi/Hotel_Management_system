<?php
require('../inc/db_config.php');
require('../inc/essentials.php');
adminLogin();

if (isset($_POST['get_general'])) {
    $query = "SELECT * FROM `settings` WHERE `sr_no` = 1";
    $result = mysqli_query($con, $query);
    if ($result) {
        $data = mysqli_fetch_assoc($result);
        echo json_encode($data);
    } else {
        echo json_encode(["error" => "Failed to fetch settings"]);
    }
    exit;
}

if (isset($_POST['upd_general'])) {
    $frm_data = filteration($_POST);
    $query = "UPDATE `settings` SET `site_title` = ?, `site_about` = ? WHERE `sr_no` = ?";
    $values = [$frm_data['site_title'], $frm_data['site_about'], 1];
    $res = update($query, $values, 'ssi');
    echo $res ? "1" : "0"; 
    exit;
}

if (isset($_POST['upd_shutdown'])) {
    $new_shutdown_value = ($_POST['upd_shutdown'] == 1) ? 1 : 0; // Toggle shutdown

    $query = "UPDATE `settings` SET `shutdown` = ? WHERE `sr_no` = ?";
    $values = [$new_shutdown_value, 1];

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $new_shutdown_value, $values[1]);

    if ($stmt->execute()) {
        echo "1"; // Success
    } else {
        error_log("Shutdown update failed: " . $conn->error); // Log error
        echo "0"; // Failure
    }

    $stmt->close();
    $conn->close();
    exit;
}





if (isset($_POST['get_contacts'])) {
    $query = "SELECT * FROM `contact_details` WHERE `sr_no` = ?";
    $values = [1];
    $res = select($query, $values, "i");

    if ($res && mysqli_num_rows($res) > 0) {
        $data = mysqli_fetch_assoc($res);
        echo json_encode($data);
    } else {
        echo json_encode(["error" => "No contact details found"]);
    }
    exit;
}

if (isset($_POST['upd_contacts'])) {
    $frm_data = filteration($_POST);
    $query = "UPDATE `contact_details` SET `address`=?, `gmap`=?, `pn1`=?, `pn2`=?, `email`=?, `fb`=?, `insta`=?, `tw`=?, `iframe`=? WHERE `sr_no`=?";
    $values = [
        $frm_data['address'], $frm_data['gmap'], $frm_data['pn1'], $frm_data['pn2'],
        $frm_data['email'], $frm_data['fb'], $frm_data['insta'], $frm_data['tw'], $frm_data['iframe'], 1
    ];
    $res = update($query, $values, 'sssssssssi');
    echo $res ? "1" : "0";
    exit;
}

if (isset($_POST['add_member'])) {
    $frm_data = filteration($_POST);

    if (!isset($_FILES['picture'])) {
        echo "no_image"; 
        exit;
    }

    $img_r = uploadImage($_FILES['picture'], ABOUT_FOLDER);

    if ($img_r == 'inv_img' || $img_r == 'inv_size' || $img_r == 'upd_failed') {
        echo $img_r;
        exit;
    }

    $query = "INSERT INTO `team_details`(`name`, `picture`) VALUES (?, ?)";
    $values = [$frm_data['name'], $img_r];
    $res = insert($query, $values, 'ss');

    echo $res ? "1" : "0";
    exit;
}

if (isset($_POST['get_members'])) {
    $res = selectAll('team_details');

    if ($res) {
        $path = ABOUT_IMG_PATH;
        while ($row = mysqli_fetch_assoc($res)) {
            echo <<<data
                <div class="col-md-2 mb-3">
                    <div class="card bg-dark text-light">
                        <img src="$path$row[picture]" class="card-img">
                        <div class="card-img-overlay text-end">
                            <button type="button" onClick="rem_members($row[sr_no])" class="btn btn-danger btn-sm shadow-none">
                                <i class="bi bi-trash3"></i> Delete
                            </button>
                        </div>
                        <p class="card-text text-center px-3 py-2">$row[name]</p>
                    </div>
                </div>  
            data;
        }
    } else {
        echo "<p class='text-center'>No team members found</p>";
    }
    exit;
}

if (isset($_POST['rem_members'])) {
    $frm_data = filteration($_POST);
    $values = [$frm_data['rem_members']];
    
    $pre_q = "SELECT * FROM `team_details` WHERE `sr_no`=?";
    $res = select($pre_q, $values, 'i');

    if ($res && mysqli_num_rows($res) > 0) {
        $img = mysqli_fetch_assoc($res);

        if (deleteImage($img['picture'], ABOUT_FOLDER)) {
            $query = "DELETE FROM `team_details` WHERE `sr_no`=?";
            $res = delete($query, $values, 'i');
            echo $res ? "1" : "0";
        } else {
            echo "del_failed"; 
        }
    } else {
        echo "not_found"; 
    }
}
?>
