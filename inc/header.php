
<html>
  <head>
    <title>header</title>
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
<body>


<?php
require_once 'admin/inc/essentials.php';
require_once 'admin/inc/db_config.php';



if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$contact_q = "SELECT * FROM `contact_details` WHERE `sr_no`=?";
$settings_q = "SELECT * FROM `settings` WHERE `sr_no`=?";
$values = [1];
$contact_result = select($contact_q, $values, 'i');
$contact_r = mysqli_fetch_assoc($contact_result);
$settings_r = mysqli_fetch_assoc(select($settings_q, $values, 'i'));

if (!defined("USERIMAGE_IMG_PATH")) {
    define("USERIMAGE_IMG_PATH", SITE_URL . 'image/userimage/');
}
?>

<nav id="nav-bar" class="navbar navbar-expand-lg navbar-light bg-blurywood px-lg-3 py-lg-2 shadow-sm sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand me-5 fw-bold fs-3 h-font" href="index.php">
            <?php echo $settings_r['site_title']; ?>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="rooms.php">Rooms</a></li>
                <li class="nav-item"><a class="nav-link" href="facilities.php">Facilities</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact us</a></li>
                <li class="nav-item"><a class="nav-link" href="food.php">Order Food</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
            </ul>

            <div class="d-flex">
                <?php
                if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
                    $profileImg = !empty($_SESSION['uPic']) ? USERIMAGE_IMG_PATH . $_SESSION['uPic'] : "default-profile.png";

                    echo <<<HTML
                    <div class="btn-group position-relative">
                        <button type="button" class="btn btn-outline-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="$profileImg" onerror="this.src='default-profile.png';" 
                                style="width: 25px; height: 25px; border-radius: 50%;" class="me-2">
                            {$_SESSION['uName']}
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                            <li><a class="dropdown-item" href="bookings.php">Bookings</a></li>
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </div>
                    HTML;
                } else {
                    echo <<<HTML
                    <button type="button" class="btn btn-outline-dark shadow-none me-lg-3 me-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
                    <button type="button" class="btn btn-outline-dark shadow-none" data-bs-toggle="modal" data-bs-target="#registerModal">Register</button>
                    HTML;
                }
                ?>
            </div>
        </div>
    </div>
</nav>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="loginModalLabel" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="login_form">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel"><i class="bi bi-person-circle"></i> User Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Email / Mobile</label>
                        <input type="text" name="email_mob" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="pass" class="form-control" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-dark">LOGIN</button>
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#forgotModal">Forgot Password?</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="registerModal" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-labelledby="registerModalLabel"  style="display: none;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form id="register_form">
          <div class="modal-header">
            <h5 class="modal-title d-flex align-items-center"><i class="bi bi-person-add"></i> User Registration</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <span class="badge rounded-pill bg-light text-dark mb-3">
              Note: Your Details must match your ID (Aadhar card, passport, driving licence, etc.) that will be required during check-in.
            </span>
            <div class="mb-3">
              <label class="form-label">Name</label>
              <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input name="email" type="email" class="form-control" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Phone Number</label>
              <input type="number" name="phonenum" class="form-control" required>
            </div>
            <div class="col-md-12 p-0">
                <label class="form-label">Picture</label>
                <input type="file" accept=".jpg,.jpeg,.png,.webp" name="profile" class="form-control shadow-none" required>
              </div>
              <div class="col-md-12 p-0 mb-3">
                <label class="form-label">Address</label>
              <textarea name="address" class="form-control shadow-none" rows="1" required></textarea>
              </div>
              <div class="col-md-12 ps-0 mb-3">
                <label class="form-label">Pincode</label>
                <input type="number" name="pincode" class="form-control shadow-none" required>
              </div>
              <div class="col-md-12 p-0 mb-3">
                <label class="form-label">Date of birth</label>
                <input type="date" name="dob" class="form-control shadow-none" required>
              </div>
              <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password"  name="pass" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Confirm Password</label>
              <input type="password" name="cpass" class="form-control" required>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-dark shadow-none">REGISTER</button>
            </div>
            <div class="text-center p-4">
            <button type="button" id="googleSignInButton" class="btn btn-outline-dark shadow-none d-flex align-items-center justify-content-center mx-auto">
              <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google" class="me-2" style="width: 20px;">
              Sign in with Google
            </button>
            <div >

            </div>
            <div id="result"></div>

            </div>
          </div>
        </form>
      </div>
    </div>
</div>
<div class="modal fade" id="forgotModal" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form id="forgot_form">
          <div class="modal-header">
            <h5 class="modal-title d-flex align-items-center"><i class="bi bi-person-circle fs-3 me-2"></i>Forgot Password</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <span class="badge rounded-pill bg-light text-dark mb-3">
              Note: A link will be sent to your email to reset your password
            </span>
            <div class="mb-4">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-2 text-end">
            <button type="button" class="btn shadow-none p-0 me-2" id="forgotCancelBtn">CANCEL</button>
              <button type="submit" class="btn btn-dark shadow-none">SEND LINK</button>
            </div>
          </div>
        </form>
      </div>
    </div>
</div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://accounts.google.com/gsi/client" async defer></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.getElementById("forgotCancelBtn").addEventListener("click", function () {
  
    var forgotModal = bootstrap.Modal.getInstance(document.getElementById('forgotModal'));
    forgotModal.hide();


    setTimeout(function () {
        var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
        loginModal.show();
    }, 500);
});
</script>

</body>
</html>
