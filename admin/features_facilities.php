<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - User Queries</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/#commoncss">
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
<body class="bg-white">
    <?php require('inc/header.php'); ?>

    <div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <h3 class="mb-4">FEATURES & FACILITIES</h3>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="card-title m-0">Features</h5>
                        <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#featureModal">
                            <i class="bi bi-plus-lg"></i> Add
                        </button>
                    </div>

                    <div class="table-responsive-md" style="height: 450px; overflow-y: scroll;">
                        <table class="table table-hover border">
                            <thead class="sticky-top">
                                <tr class="bg-dark text-light">
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="features-data">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="card-title m-0">Facilities</h5>
                        <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#facility-s">
                            <i class="bi bi-plus-lg"></i> Add
                        </button>
                    </div>

                    <div class="table-responsive-md" style="height: 450px; overflow-y: scroll;">
                        <table class="table table-hover border">
                            <thead>
                                <tr class="bg-dark text-light">
                                    <th scope="col">#</th>
                                    <th scope="col">Icon</th>
                                    <th scope="col">Name</th>
                                    <th scope="col" width="40%">Description</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="facilities-data">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Add Feature Modal -->
<div class="modal fade" id="featureModal" tabindex="-1" aria-labelledby="featureModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="feature_s_form">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="featureModalLabel">Add Feature</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="feature_name" class="form-label fw-bold">Name</label>
                        <input type="text" id="feature_name" name="feature_name" class="form-control shadow-none" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn btn-success text-light shadow-none">SUBMIT</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="facility-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="facility_s_form" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Facility</h5>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="member_name_inp" class="form-label fw-bold">Name</label>
                                <input type="text" id="facility_name" class="form-control shadow-none" required>
                            </div>
                            <div class="mb-3">
                                <label for="member_picture_inp" class="form-label fw-bold">Icon</label>
                                <input type="file" id="facility_icon" accept="image/jpeg, image/png, image/webp" class="form-control shadow-none" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea id="facility_desc" class="form-control shadow-none" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                            <button type="submit" class="btn btn-success text-light shadow-none">SUBMIT</button>
                        </div>
                    </div>
                </form>
            </div>
</div>
<!-- Ensure Bootstrap JS is Included -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</div>


<?php require('inc/script.php'); ?>
<script>
document.getElementById('feature_s_form').addEventListener('submit', function (e) {
    e.preventDefault();
    add_feature();
});

function add_feature() {
    let data = new FormData();
    data.append('feature_name', document.getElementById('feature_name').value);
    data.append('add_feature', ''); 

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities_crud.php", true);

    xhr.onload = function () {
        if (this.responseText == 1) {
            alert('success',' New feature added!');
            document.getElementById('feature_s_form').reset();
            get_features(); 
        } else {
            alert('Error: Could not add feature.');
        }
    };
    xhr.send(data);
}

function get_features() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
        if (this.status === 200) {
            document.getElementById("features-data").innerHTML = this.responseText;
        } else {
            alert("Failed to load features.");
        }
    }
    xhr.send("get_features=true");
}

function rem_feature(id) {
    let data = new FormData();
    data.append('rem_feature', id);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities_crud.php", true);

    xhr.onload = function () {
        if (this.responseText==1) {
            alert('success','Feature deleted successfully!');
            get_features(); 
        } else {
            alert('Error: Could not delete feature.');
        }
    };
    xhr.send(data);
}
facility_s_form.addEventListener('submit', function (e) {
    e.preventDefault();
    add_facility();
});
function add_facility() {
    let data = new FormData();
    data.append('name', facility_s_form.elements['facility_name'].value);
    data.append('icon', facility_s_form.elements['facility_icon'].files[0]);
    data.append('desc', facility_s_form.elements['facility_desc'].value);
    data.append('add_facility', ''); 

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities_crud.php", true);

    xhr.onload = function () {
        var myModal=document.getElementById('facility-s');
        var modal=bootstrap.Modal.getInstance(myModal);
        modal.hide();
        switch (this.responseText) {
                case 'inv_img':
                    alert('error', 'Only JPG and PNG images are allowed');
                    break;
                case 'inv_size':
                    alert('error', 'Image should be less than 2MB!');
                    break;
                case 'upd_failed':
                    alert('error', 'Image upload failed due to server error!');
                    break;
                default:
                    alert('success', 'New member added!');
                    facility_s_form.reset();
                    //get_members();
                    break;
            }
    };
    xhr.send(data);
}

function get_facilities() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    
    xhr.onload = function () {
        if (this.status === 200) {
            document.getElementById("facilities-data").innerHTML = this.responseText;
        } else {
            alert("Failed to load facilities.");
        }
    };

    xhr.send("get_facilities");
}
function rem_facility(id) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        if (this.responseText==1) {
            alert('success','Feature deleted successfully!');
            get_facilities(); 
        } 
        else if(this.responseText=='room_added')
        {
            alert('error','Facility is added in room');
        }
        else{
            alert('Error: Could not delete feature.');
        }
        }
    xhr.send('rem_facility='+id);
}

window.onload = function () {
    get_features();
    get_facilities();
};
</script>

</body>
                        
 </html> 