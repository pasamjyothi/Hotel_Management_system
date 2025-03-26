<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MahaRaj Hotel -Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <?php require('inc/links.php'); ?>
    <style>
        .pop:hover {
            border-top-color: var(--teal) !important;
            transform: scale(1.03);
            transition: all 0.3s;
        }
        #main {
            display: flex;
            flex-wrap: wrap;
            width: 100%;
            gap: 30px;
        }
        .rating i {
            font-size: 1.2rem;
        }
        .badge {
            font-size: 0.9rem;
            padding: 5px 10px;
        }
    </style>
</head>
<body class="bg-light">
    <?php require('inc/header.php');
    if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    redirect('index.php');
}
$u_exist=select("SELECT * FROM user_cred WHERE id=? LIMIT 1",[$_SESSION['uId']],'s');
if(mysqli_num_rows($u_exist)==0){
    redirect('index.php');
}
$u_fetch=mysqli_fetch_assoc($u_exist);

?>

    <div class="container">
        <div class="row g-4">
            <div class="col-12 my-5 px-4">
                <h2 class="fw-bold h-font text-center">Profile</h2>
                <div style="font-size: 14px;">
                    <a href="index.php" class="text-secondary text-decoration-none">Home</a> >
                    <a href="rooms.php" class="text-secondary text-decoration-none">Profile</a> >
                </div>
            </div>

            <div class="col-12 mb-5 px-4">
                <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                    <form id="info-form">
                        <h5 class="mb-3">Basic Information</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" value="<?php echo $u_fetch['name']?>" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="number" name="phonenum"  value="<?php echo $u_fetch['phonenum']?>"  class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Pincode</label>
                                <input type="number" name="pincode"  value="<?php echo $u_fetch['pincode']?>"  class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Address</label>
                                <textarea  name="address" class="form-control shadow-none" rows="1" required><?= $u_fetch['address'] ?></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success text-light shadow-none">Save Changes</button>
                    </form>
                </div>
            
            </div>

            
            <div class="col-md-4 mb-5 px-4">
                <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                    <form id="profile-form">
                        <h5 class="mb-3">Picture</h5>
                        <img src="<?php echo USERIMAGE_IMG_PATH.$u_fetch['profile']?>" alt="" class=" rounded-circle img-fluid mb-3">
                            <label class="form-label"> New Picture</label>
                            <input type="file" accept=".jpg,.jpeg,.png,.webp" name="profile" class=" mb-4 form-control shadow-none" required>
                        <button type="submit" class="btn btn-success text-light shadow-none">Save Changes</button>
                    </form>
                </div>
            
            </div>
            <div class="col-md-8 mb-5 px-4">
                <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                    <form id="pass-form">
                        <h5 class="mb-3">Change Password</h5>
                        <div class="row">
                        <div class="col-md-6 mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" name="new_pass"  class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" name="confirm_pass"   class="form-control" required>
                            </div>

                        </div>
                        <button type="submit" class="btn btn-success text-light shadow-none">Save Changes</button>
                    </form>
                </div>
            
            </div>





        </div>
    </div>
     


    <?php require('inc/footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
let info_form = document.getElementById('info-form');
info_form.addEventListener('submit', function (e) {
    e.preventDefault();

    let data = new FormData();
    data.append('info_form', '');
    data.append('name', info_form.elements['name'].value);
    data.append('phonenum', info_form.elements['phonenum'].value);
    data.append('address', info_form.elements['address'].value);
    data.append('pincode', info_form.elements['pincode'].value);

    if (confirm('Are you sure you want to save changes?')) {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/profile.php", true);
        xhr.onload = function () {
            if (this.responseText === 'phone_already') {
                alert('error','Phone number is already registered!');
            } else if (this.responseText == 0) {
                alert('error','No changes made!');
            } else {
                alert('success','Changes saved successfully!');
                location.reload();  // Reload the page to reflect changes
            }
        }
        xhr.send(data);
    }
});
let profile_form = document.getElementById('profile-form');
profile_form.addEventListener('submit', function (e) {
    e.preventDefault();

    let data = new FormData();
    data.append('profile_form', '');
    data.append('profile', profile_form.elements['profile'].files[0]);

    if (confirm('Are you sure you want to save changes?')) {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/profile.php", true);
        xhr.onload = function () {
            if(this.responseText=='inv_img'){
                alert('error',"Only JPG, WEBP & PNG images are allowed");
            }
            else if(this.responseText=='upd_failed'){
                alert('error',"Image upload failed!");
            }
             else if (this.responseText == 0) {
                alert('error','No changes made!');
            } else {
                 window.location.href=window.location.pathname;
            }
        }
        xhr.send(data);
    }
});
let pass_form = document.getElementById('pass-form');
pass_form.addEventListener('submit', function (e) {
    e.preventDefault();
    let new_pass=pass_form.elements['new_pass'].value;
    let confirm_pass=pass_form.elements['confirm_pass'].value;
    if(new_pass!=confirm_pass){
        alert('error','password do not match');
    }

    let data = new FormData();
    data.append('pass_form', '');
    data.append('new_pass', new_pass);
    data.append('confirm_pass',confirm_pass);
    if (confirm('Are you sure you want to save changes?')) {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/profile.php", true);
        xhr.onload = function () {
            if(this.responseText=='mismatch'){
                alert('error',"Password do not match!");
            }
             else if (this.responseText == 0) {
                alert('error','No changes made!');
            } else {
                 alert('success','changes saved')
            }
        }
        xhr.send(data);
    }
});
    
    </script>
</body>
</html>