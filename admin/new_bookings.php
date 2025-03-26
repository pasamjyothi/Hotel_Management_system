<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - New Bookings</title>
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
            <h3 class="mb-4">New Bookings</h3>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-end mb-4">
                         <input type="text" oninput="get_bookings(this.value)" class="form-control shadow-none w-25 ms-auto" placeholder="type here to search">
                    </div>

                    <div class="table-responsive-lg">
                        <table class="table table-hover border ">
                            <thead class="sticky-top">
                                <tr class="bg-dark text-light sticky-top">
                                    <th scope="col">#</th>
                                    <th scope="col">User Details</th>
                                    <th scope="col">Room Details</th>
                                    <th scope="col">Booking Details</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="table-data">
                                
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="assign-room" tabindex="-1" aria-labelledby="featureModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="assign_room_form">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="featureModalLabel">Assign Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="feature_name" class="form-label fw-bold">Room Number</label>
                        <input type="text" name="room_no" class="form-control shadow-none" required>
                    </div>
                    <span class="badge rounded-pill bg-light text-dark mb-3">
                        Note: Assign Room Number only When the user has been arrived
                    </span>
                    <input type="hidden" name="booking_id">

                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn btn-success text-light shadow-none">Assign</button>
                </div>
            </div>
        </form>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<?php require('inc/script.php'); ?>
<script>

function get_bookings(search='') {

    let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/new_bookings_crud.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onload = function () {
        
            document.getElementById('table-data').innerHTML = this.responseText;
        };
        xhr.send("get_bookings&search="+search);
}
let assign_room_form=document.getElementById('assign_room_form');
function assign_room(id){
    assign_room_form.elements['booking_id'].value=id;
}
assign_room_form.addEventListener('submit',function(e){
    e.preventDefault();

    let data = new FormData();
    data.append('room_no', assign_room_form.elements['room_no'].value);
    data.append('booking_id', assign_room_form.elements['booking_id'].value);
    data.append('assign_room',''); 

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/new_bookings_crud.php", true);

    xhr.onload = function () {
        var myModal=document.getElementById('assign-room');
        var modal=bootstrap.Modal.getInstance(myModal);
        modal.hide();
        if(this.responseText==1){
            alert('success','Room Number Alloted Booking Finalized');
            assign_room_form.reset();

        }else{
            alert('error','Server Down')
        }
    }
    xhr.send(data);

});


function cancel_booking(id){
    if (confirm("Are you sure you want to cancel this booking?")) {
        let data = new FormData();
        data.append('booking_id',id);
        data.append('cancel_booking','');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/new_bookings_crud.php", true);

        xhr.onload = function () {
            if (this.responseText== "1") {
                alert('success','Booking Cancelled');
                get_bookings(); 
            } else {
                alert('error','Server Down');
            }
        }

        xhr.send(data);
    }
}



    window.onload=function(){
        get_bookings();
    }
</script>
</body>
</html>