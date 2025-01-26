<?php 
require('inc/essentials.php');
adminLogin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel-settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/#commoncss">
    <style>
        #dashboard-menu{
            position: fixed;
            height: 100%;
        }
        @media screen and(max-width:991px) {
            #dashboard-menu{
            height: auto;
            width: 100%;

        }
        #main-content{
            margin-top: 60px;

        }
        }
     </style>
</head>
<body bg-white>
   <?php require('inc/header.php');?>
    <div class="conatiner-fluid " id="main-content">
        <div class="row">
            <div class=" settings-header col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">SETTINGS</h3>
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">General Settings</h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#general-s">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>
                        </div>
                        <h6 class="card-subtitle mb-1 fw-bold">Site Title</h6>
                        <p class="card-text" id="site_title"></p>
                        <h6 class="card-subtitle mb-1 fw-bold">About Us</h6>
                        <p class="card-text " id="site_about"></p>
                    </div>
                </div>
                <div class="modal fade" id="general-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="general_s_form">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">General Settings</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="site_title_inp" class="form-label fw-bold">Site Title</label>
                                        <input type="text" id="site_title_inp" name="site_title" class="form-control shadow-none" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="site_about_inp" class="form-label fw-bold">About Us</label>
                                        <textarea id="site_about_inp" name="site_about" class="form-control shadow-none" rows="6" required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn text-secondary shadow-none" data-bs-dismiss="modal" 
                                            onclick="site_title_inp.value=general_data.site_title; site_about_inp.value=general_data.site_about;">
                                        CANCEL
                                    </button>
                                    <button type="submit" class="btn btn-success text-light shadow-none">
                                        SUBMIT
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h5 class="card-title m-0">Shutdown Website</h5>
                                <div class="form-check form-switch">
                                    <form>   
                                        <input  onchange="upd_shutdown(this.value)" class="form-check-input" type="checkbox" id="shutdown-toggile">
                                    </form>
                                </div>
                            </div>
                            <p class="card-text " >No customers will be allowed to book hotel room,When shutdown mode is turned on</p>
                        </div>
                </div>
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Contacts Settings</h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#contacts-s">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Address</h6>
                                    <p class="card-text" id="address"></p>
                                </div>
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Google Map</h6>
                                    <p class="card-text" id="gmap"></p>
                                </div>
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Phone Numbers</h6>
                                    <p class="card-text mb-1">
                                        <i class="bi bi-telephone-fill"></i>
                                        <span id="pn1"></span>
                                    </p>
                                    <p class="card-text mb-1">
                                        <i class="bi bi-telephone-fill"></i>
                                        <span id="pn2"></span>
                                    </p>
                                </div>
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Email</h6>
                                    <p class="card-text" id="email"></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Social Links</h6>
                                    <p class="card-text mb-1">
                                        <i class="bi bi-facebook me-1"></i>
                                        <span id="fb"></span>
                                    </p>
                                    <p class="card-text mb-1">
                                        <i class="bi bi-instagram me-1"></i>
                                        <span id="insta"></span>
                                    </p>
                                    <p class="card-text mb-1">
                                        <i class="bi bi-twitter me-1"></i>
                                        <span id="tw"></span>
                                    </p>
                                </div>
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">iFrame</h6>
                                    <iframe id="iframe" class="border p-2 w-100" loading="lazy" src=""></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
               </div>
               <div class="modal fade" id="contacts-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="contacts_s_form">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Contact Settings</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="site_title_inp" class="form-label fw-bold">Address</label>
                                                    <input type="text" id="address_inp" name="address" class="form-control shadow-none" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="site_title_inp" class="form-label fw-bold">Google Map Link</label>
                                                    <input type="text" id="gmap_inp" name="gmap" class="form-control shadow-none" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="site_title_inp" class="form-label fw-bold">Phone Numbers(With country code)</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" ><i class="bi bi-telephone-fill"></i></span>
                                                        <input type="number" name="pn1" id="pn1_inp" class="form-control shadow-none" required>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" ><i class="bi bi-telephone-fill"></i></span>
                                                        <input type="numbe" name="pn2" id="pn2_inp" class="form-control shadow-none" required>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="site_title_inp" class="form-label fw-bold">Email</label>
                                                    <input type="text" id="email_inp" name="email" class="form-control shadow-none" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="site_title_inp" class="form-label fw-bold">Social Links</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" ><i class="bi bi-facebook me-1"></i></span>
                                                        <input type="text" name="fb" id="fb_inp" class="form-control shadow-none" required>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" ><i class="bi bi-instagram me-1"></i></span>
                                                        <input type="text" name="insta" id="insta_inp" class="form-control shadow-none" required>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" ><i class="bi bi-twitter me-1"></i></span>
                                                        <input type="text" name="tw" id="tw_inp" class="form-control shadow-none" required>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="site_title_inp" class="form-label fw-bold">iFrame Src</label>
                                                    <input type="text" id="iframe_inp" name="iframe" class="form-control shadow-none" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn text-secondary shadow-none" data-bs-dismiss="modal" 
                                            onclick="contacts_inp(contacts_data)">
                                        CANCEL
                                    </button>
                                    <button type="submit" class="btn btn-success text-light shadow-none">
                                        SUBMIT
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Management Team</h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#team-s">
                                <i class="bi bi-plus-lg"></i> Add
                            </button>
                        </div>
                        <div class="container mt-4">
                            <div class="row" id="team-data">
                                <div class="col-md-3 mb-3">
                                    <div class="card text-center shadow-sm">
                                        <img src="image/team1.jpg" class="card-img-top rounded" alt=""/>
                                        <div class="card-body">
                                            <h5 class="card-title">Welcomer</h5>
                                            <button type="button" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash3"></i> Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="team-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="team_s_form" enctype="multipart/form-data">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Team Member</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="member_name_inp" class="form-label fw-bold">Name</label>
                                        <input type="text" id="member_name_inp" name="member_name" class="form-control shadow-none" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="member_picture_inp" class="form-label fw-bold">Picture</label>
                                        <input type="file" id="member_picture_inp" name="member_picture" accept="image/jpeg, image/png, image/webp" class="form-control shadow-none" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" onclick="member_name.value='', member_picture.value=''" class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                                    <button type="submit" class="btn btn-success text-light shadow-none">SUBMIT</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>



            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php require('inc/script.php');?>
    <script src="scripts/settings.js"></script>
    </body>
</html>