<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MahaRaj Hotel-Rooms</title>
    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <?php require('inc/links.php');?>
<style>
.pop:hover{
    border-top-color:var(--teal) !important;
    transform: scale(1.03);
    transition:all 0.3s;

}  
#main{
    display: flex;
    width: 100%;
    gap: 30px;
}

</style>
</head>
<body class="bg-light">
    <?php require('inc/header.php');
    ?>
    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center" >OUR ROOMS</h2>
        <div class="h-line bg-dark"></div>
    </div>
<div class="container">
    <div id="main">
        <div class="col-lg-4 col-md-12 mb-lg-0 mb-4 ps-4 px-lg-0">
            <nav class="navbar  navbar-expand-lg navbar-light bg-white rounded shadow">
                <div class="container-fluid flex-lg-column align-items-stretch ">
                    <h4 class="mt-2">FILTERS</h4>
                    <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#filterDropdown" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="filterDropdown">
                        <div class="border bg-light p-4 rounded mb-4">
                            <h5 class="mb-3 d-flex align-items-center justify-content-center" style="font-size: 18px;">
                                <span>CHECK AVAILABILITY</span>
                                <button id="chk_avail_btn" onclick="chk_avail_clear()" class="btn btn-sm shadow-none text-secondary">Reset</button>
                            </h5>
                            <label class="form-label">Check-in</label>
                            <input type="date" id="checkin" class="form-control shadow-none mb-3" name="checkin" onchange="chk_avail_filter()">

                            <label class="form-label">Check-out</label>
                            <input type="date" id="checkout" class="form-control shadow-none" name="checkout" onchange="chk_avail_filter()">
                        </div>
                        <div class="border bg-light p-4 rounded mb-4">
                            <h5 class="mb-3" style="font-size: 18px;">FACILITIES</h5>
                            <div class="mb-2">
                                <input type="checkbox" id="f1" class="form-check-input shadow-none me-1">
                                <label class="form-check-label" for="f1">Wifi</label>
                            </div>
                            <div class="mb-2">
                                <input type="checkbox" id="f2" class="form-check-input shadow-none me-1">
                                <label class="form-check-label" for="f2">Facility T.V</label>
                            </div>
                            <div class="mb-2">
                                <input type="checkbox" id="f3" class="form-check-input shadow-none me-1">
                                <label class="form-check-label" for="f3">AC</label>
                            </div>
                        </div>



                        <div class="border bg-light p-4 rounded mb-4">
                            <h5 class="mb-3 d-flex align-items-center justify-content-center" style="font-size: 18px;">
                                <span>GUESTS</span>
                                <button id="guests_btn" onclick="guests_clear()" class="btn btn-sm shadow-none text-secondary">Reset</button>
                            </h5>
                            <div class="d-flex">
                                <div class="me-3">
                                    <label class="form-label">Adults</label>
                                    <input type="number" min="1" id="adults" class="form-control shadow-none">
                                </div>
                                <div>
                                    <label class="form-label">Children</label>
                                    <input type="number" min="1" class="form-control shadow-none">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <div class="col-lg-9 col-md-12 px-4" id="rooms-data">

        </div>
    </div>
</div>



<!-- Bootstrap JS (for dropdowns) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
let checkin = document.getElementById('checkin');
let checkout = document.getElementById('checkout');
let chk_avail_btn = document.getElementById('chk_avail_btn');

function fetch_rooms() {
    if (!checkin || !checkout) {
        console.error("Check-in or Check-out element not found!");
        return;
    }
    let chk_avail=JSON.stringify({
        checkin:checkin.value,
        checkout:checkout.value
    });

    console.log("Fetching rooms...");
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "ajax/rooms_cred.php?fetch_rooms&chk_avail="+chk_avail, true);

    xhr.onprogress = function () {
        document.getElementById('rooms-data').innerHTML = `
            <div class="spinner-border text-info mb-3 d-block mx-auto" id="loader" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        `;
    };

    xhr.onload = function () {
        console.log("Response received:", this.responseText);
        document.getElementById('rooms-data').innerHTML = this.responseText;
    };

    xhr.onerror = function () {
        console.error("Request failed.");
    };

    xhr.send("checkin=" + checkin.value + "&checkout=" + checkout.value);
}

function chk_avail_filter() {
    if (checkin.value !== '' && checkout.value !== '') {
        fetch_rooms();
        chk_avail_btn.classList.remove('d-none');
    }
}

function chk_avail_clear() {
    checkin.value = '';
    checkout.value = '';
    chk_avail_btn.classList.add('d-none');
    fetch_rooms();
}

// Ensure event listeners are attached after DOM loads
document.addEventListener("DOMContentLoaded", function () {
    fetch_rooms();
});

</script>
<?php require('inc/footer.php');?>
</body> 
</html>