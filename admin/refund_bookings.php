<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Refund Bookings</title>
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
            <h3 class="mb-4">Refund Bookings</h3>

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
                                    <th scope="col">Refund Amount</th>
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




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<?php require('inc/script.php'); ?>
<script>

function get_bookings(search='') {

    let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/refund_bookings_crud.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onload = function () {
        
            document.getElementById('table-data').innerHTML = this.responseText;
        };
        xhr.send("get_bookings&search="+search);
}

function refund_booking(id) {
    if (confirm("Refund money for this booking?")) {
        let data = new FormData();
        data.append('booking_id', id);
        data.append('refund_booking', '1');  // Change key from 'cancel_booking' to 'refund_booking'

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/refund_bookings_crud.php", true);

        xhr.onload = function () {
            if (this.responseText.trim() == "1") {
                alert('success', 'Booking Refunded');
                get_bookings(); 
            } else {
                alert('Error: Unable to process refund');
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