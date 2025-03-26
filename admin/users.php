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
    <?php require('inc/db_config.php'); ?>

    <div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <h3 class="mb-4">USERS</h3>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-end mb-4">
                         <input type="text" oninput="search_user(this.value)" class="form-control shadow-none w-25 ms-auto" placeholder="type here to search">
                    </div>

                    <div class="table-responsive-lg" style="height: 450px; overflow-y: scroll;">
                        <table class="table table-hover border text-center">
                            <thead class="sticky-top">
                                <tr class="bg-dark text-light sticky-top">
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone no</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">DOB</th>
                                    <th scope="col">Verified</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="users-data">
                                
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

function get_users() {
    let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/users_crud.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onload = function () {
        
            document.getElementById('users-data').innerHTML = this.responseText;
        };
        xhr.send("get_users");
}

function toggle_status(id, val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/users_crud.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        if (this.responseText == 1) {
            alert('Success' ,'Status toggled');
            get_users(); // Refresh user list
        } else {
            alert('Server error: ' + this.responseText);
        }
    };

    xhr.onerror = function () {
        alert('Network error. Please check your connection.');
    };

    xhr.send("toggle_status=" + id + "&value=" +val);
}
function remove_user(user_id) {
    if (confirm("Are you sure you want to remove this room?")) {
        let data = new FormData();
        data.append('user_id', user_id);
        data.append('remove_user', '1');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/users_crud.php", true);

        xhr.onload = function () {
            console.log("Server Response:", this.responseText.trim());

            if (this.responseText.trim() === "1") {
                alert("user removed Successfully");
                get_user();  // Ensure front-end updates properly
            } else if (this.responseText.trim() === "2") {
                alert("Error: Room has active bookings and cannot be removed.");
            } else {
                alert("Error: Room could not be removed.");
            }
        };

        xhr.send(data);
    }
}
function search_user(username){
    let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/users_crud.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onload = function () {
        
            document.getElementById('users-data').innerHTML = this.responseText;
        };
        xhr.send("search_user&name="+username);
}


    window.onload=function(){
        get_users();
    }
</script>
</body>
</html>