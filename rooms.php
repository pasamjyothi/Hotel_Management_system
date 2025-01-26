<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MahaRaj Hotel-Rooms</title>
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
    <?php require('inc/header.php');?>
    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center" >OUR ROOMS</h2>
        <div class="h-line bg-dark"></div>
    </div>
<div class="container">
    <div id="main">
        <div class="col-lg-4 col-md-12 mb-lg-0 mb-4 px-lg-0">
            <nav class="navbar  navbar-expand-lg navbar-light bg-white rounded shadow">
                <div class="container-fluid flex-lg-column align-items-stretch ">
                    <h4 class="mt-2">FILTERS</h4>
                    <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#filterDropdown" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="filterDropdown">
                        <div class="border bg-light p-4 rounded mb-4">
                            <h5 class="mb-3" style="font-size: 18px;">CHECK AVAILABILITY</h5>
                            <label class="form-label">Check-in</label>
                            <input type="date" class="form-control shadow-none">
                            <label class="form-label">Check-out</label>
                            <input type="date" class="form-control shadow-none">
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
                            <h5 class="mb-3" style="font-size: 18px;">GUESTS</h5>
                            <div class="d-flex">
                                <div class="me-3">
                                    <label class="form-label">Adults</label>
                                    <input type="number" class="form-control shadow-none">
                                </div>
                                <div>
                                    <label class="form-label">Children</label>
                                    <input type="number" class="form-control shadow-none">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <div class="col-lg-9 col-md-12 px-4" id="sec2">
            <div class="card mb-4 border-0 shadow">
                <div class="row g-0 p-3 align-items-center">
                    <div class="col-md-5 mb-lg-0 mb-md-0 mb-3">
                        <img src="image/img2.png" class="img-fluid rounded">
                    </div>
                    <div class="col-md-5 px-lg-3 px-md-3 px-0">
                            <h5 class="mb-3">Deluxe Room</h5>
                            <div class="features mb-3">
                                <h6 class="mb-1">Features</h6>
                                <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">2 Beds</span>
                                <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">2 Bathrooms</span>
                                <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">2 Sofas</span>
                            </div>
                            <div class="facilities mb-4">
                                <h6 class="mb-1"> Facilities</h6>
                                <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">wifi</span>
                                <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">Television</span>
                                <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">AC</span>
                                <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">Geyser</span>

                            </div>
                            <div class="facilities mb-4">
                                    <h6 class="mb-1">Guests</h6>
                                    <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">3 Adults</span>
                                    <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">2 Childrens</span>
                            </div>
                    </div>
                    <div class="col-md-2 text-center">
                        <h6 class="mb-4">1000/- per night</h6> 
                        <a href="#" class="btn btn-sm w-100 custom-bg shadow-none mb-2 btn-outline-dark">Book Now</a>
                        <a href="#" class="btn btn-sm  w-100 btn-outline-dark shadow-none">More Details</a>
                    </div>

                </div>
            </div>
            <div class="card mb-4 border-0 shadow">
                <div class="row g-0 p-3 align-items-center">
                    <div class="col-md-5 mb-lg-0 mb-md-0 mb-3">
                        <img src="image/img1.png" class="img-fluid rounded">
                    </div>
                    <div class="col-md-5 px-lg-3 px-md-3 px-0">
                            <h5 class="mb-3">Deluxe Room</h5>
                            <div class="features mb-3">
                                <h6 class="mb-1">Features</h6>
                                <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">2 Beds</span>
                                <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">2 Bathrooms</span>
                                <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">2 Sofas</span>
                            </div>
                            <div class="facilities mb-4">
                                <h6 class="mb-1"> Facilities</h6>
                                <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">wifi</span>
                                <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">Television</span>
                                <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">AC</span>
                                <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">Geyser</span>

                            </div>
                            <div class="facilities mb-4">
                                    <h6 class="mb-1">Guests</h6>
                                    <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">3 Adults</span>
                                    <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">2 Childrens</span>
                            </div>
                    </div>
                    <div class="col-md-2 text-center">
                        <h6 class="mb-4">1000/- per night</h6> 
                        <a href="#" class="btn btn-sm w-100 custom-bg shadow-none mb-2 btn-outline-dark">Book Now</a>
                        <a href="#" class="btn btn-sm  w-100 btn-outline-dark shadow-none">More Details</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?php require('inc/footer.php');?>
</body> 
</html>