<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Rooms</title>
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
    <?php require('inc/db_config.php'); ?>

    <div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <h3 class="mb-4">ROOMS</h3>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-end mb-4">
                        <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#add-room">
                            <i class="bi bi-plus-lg"></i> Add
                        </button>
                    </div>

                    <div class="table-responsive-lg" style="height: 450px; overflow-y: scroll;">
                        <table class="table table-hover border text-center">
                            <thead class="sticky-top">
                                <tr class="bg-dark text-light sticky-top">
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Area</th>
                                    <th scope="col">Guests</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="room-data">
                                
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="add-room" tabindex="-1" aria-labelledby="featureModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="add_room_form" autocomplete="off">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="featureModalLabel">Add Room</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Name</label>
                            <input type="text" name="name" class="form-control shadow-none" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Area</label>
                            <input type="number" min="1" name="area" class="form-control shadow-none" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Price</label>
                            <input type="number" min="1" name="price" class="form-control shadow-none" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Quantity</label>
                            <input type="number" min="1" name="quantity" class="form-control shadow-none" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Adult (Max.)</label>
                            <input type="number" min="1" name="adult" class="form-control shadow-none" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Children (Max.)</label>
                            <input type="number" min="1" name="children" class="form-control shadow-none" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Features</label>
                            <div class="row">
                             <?php
                              $res = selectAll('features');
                                while ($opt = mysqli_fetch_assoc($res)) {
                                    echo <<<HTML
                                    <div class='col-md-3'>
                                        <label>
                                            <input type='checkbox' name='features[]' value='{$opt['id']}' class='form-check-input shadow-none'>
                                            {$opt['name']}
                                        </label>
                                    </div>
                                    HTML;
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Facilities</label>
                            <div class="row">
                            <?php
                              $res = selectAll('facilities');
                                while ($opt = mysqli_fetch_assoc($res)) {
                                    echo <<<HTML
                                    <div class='col-md-3'>
                                        <label>
                                            <input type='checkbox' name='facilities' value=$opt[id] class='form-check-input shadow-none'>
                                            {$opt['name']}
                                        </label>
                                    </div>
                                    HTML;
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                           <label class="form-label fw-bold">Description</label>
                           <textarea name="desc" rows="4" class="form-control shadow-none" required></textarea>
                        </div>                   
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
<div class="modal fade" id="edit-room" tabindex="-1" aria-labelledby="featureModalLabel" style="display: none;">
    <div class="modal-dialog modal-lg">
        <form id="edit_room_form" autocomplete="off">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="featureModalLabel">Edit Room</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Name</label>
                            <input type="text" name="name" class="form-control shadow-none" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Area</label>
                            <input type="number" min="1" name="area" class="form-control shadow-none" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Price</label>
                            <input type="number" min="1" name="price" class="form-control shadow-none" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Quantity</label>
                            <input type="number" min="1" name="quantity" class="form-control shadow-none" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Adult (Max.)</label>
                            <input type="number" min="1" name="adult" class="form-control shadow-none" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Children (Max.)</label>
                            <input type="number" min="1" name="children" class="form-control shadow-none" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Features</label>
                            <div class="row">
                             <?php
                              $res = selectAll('features');
                                while ($opt = mysqli_fetch_assoc($res)) {
                                    echo <<<HTML
                                    <div class='col-md-3'>
                                        <label>
                                            <input type='checkbox' name='features[]' value='{$opt['id']}' class='form-check-input shadow-none'>
                                            {$opt['name']}
                                        </label>
                                    </div>
                                    HTML;
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Facilities</label>
                            <div class="row">
                            <?php
                              $res = selectAll('facilities');
                                while ($opt = mysqli_fetch_assoc($res)) {
                                    echo <<<HTML
                                    <div class='col-md-3'>
                                        <label>
                                        <input type='checkbox' name='facilities[]' value=$opt[id] class='form-check-input shadow-none'>
                                            {$opt['name']}
                                        </label>
                                    </div>
                                    HTML;
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                           <label class="form-label fw-bold">Description</label>
                           <textarea name="desc" rows="4" class="form-control shadow-none" required></textarea>
                        </div> 
                        <input type="hidden" name="room_id" >                 
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
<div class="modal fade" id="room-images" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"  style="display: none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title mb-2">Room Image</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="image-alert"></div>
        <div class="border-bottom border-3 mb-3">
        <form id="add_image_form">
            <label class="form-label fw-bold">Add Image</label>
            <input type="file" name="image" accept="image/jpeg, image/png, image/webp" class="form-control shadow-none mb-3" required>
            <button class='btn btn-dark btn-sm shadow-none'>ADD</button>
            <input type="hidden" name="room_id">
        </form>
        </div>
    <div class="table-responsive-lg" style="height: 350px; overflow-y: scroll;">
        <table class="table table-hover border text-center">
            <thead class="sticky-top">
                <tr class="bg-dark text-light sticky-top">
                    <th scope="col" width="60%">Image</th>
                    <th scope="col">Thumb</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody id="room-image-data">
                                
             </tbody>
        </table>
    </div>
</div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<?php require('inc/script.php'); ?>
<script>
    let add_room_form = document.getElementById('add_room_form');

    add_room_form.addEventListener('submit', function (e) {
        e.preventDefault();
        add_room();
    });

    function add_room() {
        let data = new FormData();
        data.append('add_room', '');
        data.append('name', add_room_form.elements['name'].value);
        data.append('area', add_room_form.elements['area'].value);
        data.append('price', add_room_form.elements['price'].value);
        data.append('quantity', add_room_form.elements['quantity'].value);
        data.append('adult', add_room_form.elements['adult'].value);
        data.append('children', add_room_form.elements['children'].value);
        data.append('description', add_room_form.elements['desc'].value);

        let features = [];
        document.querySelectorAll("input[name='features[]']:checked").forEach(el => {
            features.push(el.value);
        });

        let facilities = [];
        document.querySelectorAll("input[name='facilities']:checked").forEach(el => {
            facilities.push(el.value);
        });

        data.append('features', JSON.stringify(features));
        data.append('facilities', JSON.stringify(facilities));

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/rooms_crud.php", true);

        xhr.onload = function () {
            console.log("Response:", this.responseText); // Debugging

            let myModal = document.getElementById('add-room');
            let modal = bootstrap.Modal.getInstance(myModal);
            modal.hide();

            let response = this.responseText.trim(); // Remove extra spaces/new lines
            if (this.responseText.trim() === "success") {            
                alert('success',' New room added!');
                add_room_form.reset();
                get_all_rooms();
            } else {
                alert('Unexpected error');
            }
        };

        xhr.onerror = function () {
            alert('Network error. Please check your connection.');
        };

        xhr.send(data);
    }
function get_all_rooms() {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/rooms_crud.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onload = function () {
        
            document.getElementById('room-data').innerHTML = this.responseText;
        };
        xhr.send("get_all_rooms=1");
}

    function toggle_status(id, val) {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/rooms_crud.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onload = function () {
            if (this.responseText.trim() === "1") {
                alert('Success: Status toggled');
                get_all_rooms();
            } else {
                alert('Server error: Status not updated');
            }
        };

        xhr.onerror = function () {
            alert('Network error. Please check your connection.');
        };

        xhr.send("toggle_status=" + id + "&val=" + val);
    }
function edit_details(id) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        let data = JSON.parse(this.responseText);
        
        if (data.error) {
            console.error("Error: " + data.error);
            return;
        }

        let form = document.forms['edit_room_form'];
        form.elements['name'].value = data.roomdata.name;
        form.elements['area'].value = data.roomdata.area;
        form.elements['price'].value = data.roomdata.price;
        form.elements['quantity'].value = data.roomdata.quantity;
        form.elements['adult'].value = data.roomdata.adult;
        form.elements['children'].value = data.roomdata.children;
        form.elements['desc'].value = data.roomdata.description;
        form.elements['room_id'].value = data.roomdata.id;

        form.querySelectorAll("input[name='features[]']").forEach(el => {
            el.checked = data.features.includes(Number(el.value));
        });

        
        form.querySelectorAll("input[name='facilities[]']").forEach(el => {
            el.checked = data.facilities.includes(Number(el.value));
        });
    };

    xhr.send("get_room=" + id);
}

edit_room_form.addEventListener('submit', function (e) {
    e.preventDefault();
    submit_edit_room();
});

function submit_edit_room() {
    let data = new FormData();
    data.append('edit_room', '1');
    data.append('room_id', edit_room_form.elements['room_id'].value);
    data.append('name', edit_room_form.elements['name'].value);
    data.append('area', edit_room_form.elements['area'].value);
    data.append('price', edit_room_form.elements['price'].value);
    data.append('quantity', edit_room_form.elements['quantity'].value);
    data.append('adult', edit_room_form.elements['adult'].value);
    data.append('children', edit_room_form.elements['children'].value);
    data.append('desc', edit_room_form.elements['desc'].value);

    let facilities = [];
    let features = [];

    if (edit_room_form.elements['facilities']) {
        document.querySelectorAll("input[name='facilities']:checked").forEach(el => {
            facilities.push(el.value);
        });
    }

    if (edit_room_form.elements['features']) {
        document.querySelectorAll("input[name='features']:checked").forEach(el => {
            features.push(el.value);
        });
    }

    data.append('features', JSON.stringify(features));
    data.append('facilities', JSON.stringify(facilities));

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms_crud.php", true);

    xhr.onload = function () {
        let myModal = document.getElementById('edit-room');
        let modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        
        if (this.responseText.trim() == "1") {
            alert('Room successfully updated');
            edit_room_form.reset();
            get_all_rooms();
        } else {
            alert('Error updating room: ' + this.responseText);
        }
    };

    xhr.send(data);
}

    let add_image_form=document.getElementById('add_image_form');
    add_image_form.addEventListener('submit', function (e) {
        e.preventDefault();
        add_image();
    });
    function add_image() {
        let data = new FormData();
        data.append('image', add_image_form.elements['image'].files[0]);
        data.append('room_id', add_image_form.elements['room_id'].value);
        data.append('add_image', '');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/rooms_crud.php", true);

        xhr.onload = function () {

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
                    alert('success', 'New image added','image-alert');
                    room_images(add_image_form.elements['room_id'].value, document.querySelector("#room-images .modal-title").innerText = rname);
                    add_image_form.reset();
            }
        };

        xhr.send(data);
    }
    function room_images(id, rname) {
        document.querySelector("#room-images .modal-title").innerText = rname;
        document.getElementById("add_image_form").elements['room_id'].value = id;
        document.getElementById("add_image_form").elements['image'].value = '';
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/rooms_crud.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onload = function () {
        document.getElementById('room-image-data').innerHTML=this.responseText;
        };

        xhr.send('get_room_images='+id);


    }
    function rem_image(img_id, room_id) {
        let data = new FormData();
        data.append('image_id', img_id);
        data.append('room_id', room_id);
        data.append('rem_image', '1');

        fetch('ajax/rooms_crud.php', {
            method: 'POST',
            body: data
        })
        .then(response => response.json())
        .then(result => {
            if (result.status === "success") {
                alert("Image Removed Successfully");
                room_images(room_id, document.querySelector("#room-images .modal-title").innerText);
            } else {
                console.error("Error:", result.message);
                alert("Error: " + result.message);
            }
        })
        .catch(err => console.error('Fetch Error:', err));
    }
    function thumb_image(img_id, room_id) {
        let data = new FormData();
        data.append('image_id', img_id);
        data.append('room_id', room_id);
        data.append('thumb_image', '1');  // Send a meaningful value

        fetch('ajax/rooms_crud.php', {
            method: 'POST',
            body: data
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(result => {
            if (result.status === "success") {
                alert("Image Thumbnail changed");
                room_images(room_id, document.querySelector("#room-images .modal-title").innerText);
            } else {
                console.error("Error:", result.message);
                alert("Error: " + result.message);
            }
        })
        .catch(err => console.error('Fetch Error:', err));
    }
    function remove_room(roomId) {
    if (!roomId) {
        console.error("Error: roomId is undefined or invalid.");
        return;
    }

    if (confirm("Are you sure you want to remove this room?")) {
        let data = new FormData();
        data.append('room_id', roomId);
        data.append('remove_room', '1');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/rooms_crud.php", true);

        xhr.onload = function () {
            console.log("Server Response:", this.responseText.trim());

            if (this.responseText.trim() === "1") {
                alert("Room Removed Successfully");
                location.reload();  // Ensure front-end updates properly
            } else if (this.responseText.trim() === "2") {
                alert("Error: Room has active bookings and cannot be removed.");
            } else {
                alert("Error: Room could not be removed.");
            }
        };

        xhr.send(data);
    }
}

    window.onload=function(){
        get_all_rooms();
    }
</script>
</body>
</html>