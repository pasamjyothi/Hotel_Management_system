<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Booking Records</title>
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
            <h3 class="mb-4">Booking Records</h3>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-end mb-4">
                         <input type="text"id="search_input" oninput="get_bookings(this.value)" class="form-control shadow-none w-25 ms-auto" placeholder="type here to search">
                    </div>

                    <div class="table-responsive-lg">
                        <table class="table table-hover border " style="min-width:1200px;">
                            <thead class="sticky-top">
                                <tr class="bg-dark text-light sticky-top">
                                    <th scope="col">#</th>
                                    <th scope="col">User Details</th>
                                    <th scope="col">Room Details</th>
                                    <th scope="col">Booking Details</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="table-data">
                                
                            </tbody>
                        </table>
                    </div>
                    <nav>
                        <ul class="pagination mt-2" id="table-pagination">
                            
                        </ul>
                    </nav>

                </div>
            </div>

        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<?php require('inc/script.php'); ?>
<script>

function get_bookings(search='',page=1) {

    let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/booking_records_crud.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onload = function () {
        
            document.getElementById('table-data').innerHTML = data.table-data;
            document.getElementById('table-pagination').innerHTML = data.pagination;
        }
        xhr.send("get_bookings&search="+search+'&page='+page);
}

function change_page(page){
    get_bookings(document.getElementById('search_input').value,page)


}
function download(id){
    window.location.href='generate_pdf.php?gen_pdf&id='+id;
}
    window.onload=function(){
        get_bookings();
    }
</script>
</body>
</html>