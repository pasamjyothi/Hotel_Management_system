<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MahaRaj Hotel-Home</title>
    <?php require('inc/links.php');?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
 <link rel="stylesheet" href="css/#commoncss">
 <style>
  input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
input[type=number] {
  -moz-appearance: textfield;
}
   
.custom-bg{
      background-color: #2ec1ac;
      align-items: center;

}
   
.custom-bg:hover{
      background-color: #279e8c;
 }
.availability-form{
    margin-top: -50px;
    z-index: 2;
    position: relative;
}
 @media screen and(max-width: 575px) {
    .availability-form{
      margin-top: 0px;
      padding: 0 35px;
    }

    
  }
    .swiper-slide img {
      object-fit: cover;
      height: 100%;
    }
    .swiper {
      width: 100%;
      height: 450px; 
    }
    .card-img-custom {
  height: 200px; 
  width: 100%; 
  object-fit: cover; 
  border-radius: 0.5rem;
}


 </style>
  </head>
<body>
<?php require('inc/header.php');?>
<div class="container-fluid px-lg-4 mt-4">
    <div class="swiper swiper-container">
      <div class="swiper-wrapper">
      <?php
        $res = selectAll('user_details');

        while ($row = mysqli_fetch_assoc($res)) {
            $path = USER_IMG_PATH;  

            echo <<<DATA
            <div class="swiper-slide">
                <img src="$path$row[image]" class="w-100 d-block" alt="User Image"/>
            </div>
            DATA;
    }
?>
      </div>
</div>
<div class="container availability-form">
  <div class="row">
    <div class="col-lg-12 bg-white shadow p-4 rounded">
      <h5>Check Booking Availability</h5>
      <form>
        <div class="row">
          <div class="col-lg-3">
            <label class="form-label" style="font-weight: 500;">Check-in</label>
          <input type="date" class="form-control shadow-none">
          </div>
          <div class="col-lg-3">
            <label class="form-label" style="font-weight: 500;">Check-Out</label>
          <input type="date" class="form-control shadow-none">
          </div>
          <div class="col-lg-3">
            <label class="form-label" style="font-weight: 500;">Adult</label>
            <select class="form-select shadow-none">
              <option selected>Open this select menu</option>
              <option value="1">One</option>
              <option value="2">Two</option>
              <option value="3">Three</option>
            </select>
          </div>
          <div class="col-lg-3">
            <label class="form-label" style="font-weight: 500;">Children</label>
            <select class="form-select shadow-none">
              <option selected>Open this select menu</option>
              <option value="1">One</option>
              <option value="2">Two</option>
              <option value="3">Three</option>
            </select>
          </div>
          <div class="text-center my-1 p-3">
            <button type="submit" class="btn btn-sm btn-outline-dark shadow-none custom-bg">Submit</button>
          </div>
          </div>
      </form>
    </div>
  </div>
</div>
<h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">OUR ROOMS</h2>
<div class="container">
  <div class="row">
    <div class="col-lg-4 col-md-7">
      <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
        <img src="image/1 (1).jpg" class="card-img-top card-img-custom" alt="...">
        <div class="card-body">
          <h5>Simple Room</h5>
          <h6 class="mb-4">500/- per night</h6>
          <div class="features mb-4">
             <h6 class="mb-1">Features</h6>
             <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
              2 Beds
            </span>
            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
              2 Bathroom
            </span>
            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
              2 Sofas
            </span>
          </div>
          <div class="facilities mb-4">
            <h6 class="mb-1"> Facilities</h6>
            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
              wifi
            </span>
            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
              Television
            </span>
            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
              AC
            </span>
            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
              Geyser
            </span>

          </div>
          <div class="facilities mb-4">
            <h6 class="mb-1">Guests</h6>
            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
              3 Adults
            </span>
            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
              2 Children
            </span>
          </div>
          <div class="rating mb-4">
            <h6 class="mb-1">Rating</h6> 
            <span class="badge rounded-pill bg-light">           
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            </span>
          </div>
          <div class="d-flex justify-content-between mt-3">
          <a href="#" class="btn btn-sm btn-outline-success custom-bg shadow-none">Book Now</a>
          <a href="#" class="btn btn-sm btn-outline-dark shadow-none">More Details</a>
        </div>
      </div>
    </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
      <img src="image/img3.webp" class="card-img-top card-img-custom" alt="Deluxe Room">
        <div class="card-body">
          <h5>Deluxe Room </h5>
          <h6 class="mb-4">500/- per night</h6>
          <div class="features mb-4">
             <h6 class="mb-1">Features</h6>
             <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
              2 Beds
            </span>
            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
              2 Bathroom
            </span>
            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
              2 Sofas
            </span>
          </div>
          <div class="facilities mb-4">
            <h6 class="mb-1"> Facilities</h6>
            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
              wifi
            </span>
            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
              Television
            </span>
            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
              AC
            </span>
            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
              Geyser
            </span>

          </div>
          <div class="facilities mb-4">
            <h6 class="mb-1">Guests</h6>
            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
              3 Adults
            </span>
            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
              2 Children
            </span>
          </div>
          <div class="rating mb-4">
            <h6 class="mb-1">Rating</h6> 
            <span class="badge rounded-pill bg-light">           
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            </span>
          </div>
          <div class="d-flex justify-content-between mt-3">
          <a href="#" class="btn btn-sm  btn-outline-success custom-bg shadow-none">Book Now</a>
          <a href="#" class="btn btn-sm btn-outline-dark shadow-none">More Details</a>
        </div>
      </div>
    </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
        <img src="image/1 (1).jpg" class="card-img-top card-img-custom" alt="...">
        <div class="card-body">
          <h5>Simple Room Name</h5>
          <h6 class="mb-4">500/- per night</h6>
          <div class="features mb-4">
             <h6 class="mb-1">Features</h6>
             <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
              2 Beds
            </span>
            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
              2 Bathroom
            </span>
            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
              2 Sofas
            </span>
          </div>
          <div class="facilities mb-4">
            <h6 class="mb-1"> Facilities</h6>
            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
              wifi
            </span>
            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
              Television
            </span>
            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
              AC
            </span>
            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
              Geyser
            </span>
          </div>
          <div class="facilities mb-4">
            <h6 class="mb-1">Guests</h6>
            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
              3 Adults
            </span>
            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
              2 Children
            </span>
          </div>
          <div class="rating mb-4">
            <h6 class="mb-1">Rating</h6> 
            <span class="badge rounded-pill bg-light">           
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            </span>
          </div>
          <div class="d-flex justify-content-between mt-3">
          <a href="#" class="btn btn-sm  btn-outline-success custom-bg shadow-none">Book Now</a>
          <a href="#" class="btn btn-sm btn-outline-dark shadow-none">More Details</a>
        </div>
      </div>
    </div>
    </div>
    <div class="col-lg-12 text-center mt-5">
      <a href="#" class="btn bt-sm btn-outline-dark rounded-0 fw-bold shadow-none">More Rooms</a>
    </div>
  </div>
</div>
<h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">OUR FACILITIES</h2>
<div class="container">
  <div class="row justify-content-evenly px-lg-0 px-md-0 px-5">
    <div class="col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 my-3">
      <img src="image/wifi.jpg" width="80px">
      <h5 class="mt-3">Wifi</h5>
    </div>
    <div class="col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 my-3">
      <img src="image/television.svg" width="80px">
      <h5 class="mt-3">Television</h5>
    </div>
    <div class="col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 my-3">
      <img src="image/wash.png" width="80px">
      <h5 class="mt-3">Washing Machine</h5>
    </div>
    <div class="col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 my-3">
      <img src="image/geyser.png" width="80px">
      <h5 class="mt-3">Geyser</h5>
    </div>
    <div class="col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 my-3">
      <img src="image/fan.png" width="80px">
      <h5 class="mt-3">Fan</h5>
    </div>
    <div class="col-lg-12 text-center mt-5">
      <a href="#" class="btn bt-sm btn-outline-dark rounded-0 fw-bold shadow-none">More Facilities</a>
    </div>
  </div>
</div>
<h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">OUR REVIEWS</h2>
<div class="container">
    <div class="swiper swiper-testimonials">
      <div class="swiper-wrapper mb-5">
        <div class="swiper-slide bg-white p-4">
          <div class="profile d-flex align-items-center p-4">
            <img src="image/star.png" width="30px">
            <h6 class="m-0 ms-2">Jyothi</h6>
          </div>
          <p>The hotel was in a great location The staff were friendly and helpful</p>
          <div class="rating">           
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
          </div>
        </div>  
        <div class="swiper-slide bg-white p-4">
          <div class="profile d-flex align-items-center p-4">
            <img src="image/star.png" width="30px">
            <h6 class="m-0 ms-2">Jyothi</h6>
          </div>
          <p>The hotel was in a great location The staff were friendly and helpful</p>
          <div class="rating">           
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
          </div>
        </div> 
        <div class="swiper-slide bg-white p-4">
          <div class="profile d-flex align-items-center p-4">
            <img src="image/star.png" width="30px">
            <h6 class="m-0 ms-2">Jyothi</h6>
          </div>
          <p>The hotel was in a great location The staff were friendly and helpful</p>
          <div class="rating">           
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
            <i class="bi bi-star-fill text-warning"></i>
          </div>
        </div> 
      </div>
      <div class="swiper-pagination"></div>
    </div>

      <?php 
        $contact_q = "SELECT * FROM `contact_details` WHERE `sr_no`=?";
        $values = [1];
        $contact_result = select($contact_q, $values, 'i');
        $contact_r = mysqli_fetch_assoc($contact_result);
      ?>

<h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">OUR LOCATION</h2>
<div class="container">
  <div class="row">
    <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3 bg-white rounded">
      <iframe class="w-100 rounded" height="320px" 
              src="<?php echo htmlspecialchars($contact_r['iframe']); ?>" 
              loading="lazy" 
              referrerpolicy="no-referrer-when-downgrade">
      </iframe>
    </div>
    <div class="col-lg-4 col-md-4">
      <div class="bg-white p-4 rounded mb-4">
        <h5>Call us</h5>
  
        <a href="tel:<?php echo htmlspecialchars($contact_r['pn1']); ?>" 
           class="d-inline-block mb-2 text-decoration-none text-dark">
           <i class="bi bi-telephone-fill"></i> <?php echo htmlspecialchars($contact_r['pn1']); ?>
        </a>
        <br>
        <?php if (!empty($contact_r['pn2'])): ?>
          <a href="tel:<?php echo htmlspecialchars($contact_r['pn2']); ?>" 
             class="d-inline-block mb-2 text-decoration-none text-dark">
             <i class="bi bi-telephone-fill"></i> <?php echo htmlspecialchars($contact_r['pn2']); ?>
          </a>
        <?php endif; ?>
      </div>
      <div class="bg-white p-4 rounded mb-4">
  <h5>Follow us</h5>
  <?php
    if (!empty($contact_r['tw'])) {
      echo <<<data
      <a href="{$contact_r['tw']}" class="d-inline-block mb-2">
        <span class="badge bg-light text-dark fs-6 p-2">
          <i class="bi bi-twitter me-1"></i> Twitter
        </span>
      </a>
      <br>
      data;
    }
  ?>
  <a href="<?php echo htmlspecialchars($contact_r['fb']); ?>" class="d-inline-block mb-2">
    <span class="badge bg-light text-dark fs-6 p-2">
      <i class="bi bi-facebook me-1"></i> Facebook
    </span>
  </a>
  <br>
  <a href="<?php echo htmlspecialchars($contact_r['insta']); ?>" class="d-inline-block mb-2">
    <span class="badge bg-light text-dark fs-6 p-2">
      <i class="bi bi-instagram me-1"></i> Instagram
    </span>
  </a>
  <br>
</div>


        </div>
      </div>
    </div>
</div>
<?php require('inc/footer.php');?>
<br><br><br>
<br><br><br>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> 
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script src="https://accounts.google.com/gsi/client" async defer></script>
<script>
     var swiper = new Swiper(".swiper-container", {
      spaceBetween: 30,
      effect: "fade",
      loop:true,
      autoplay:{
        delay:3500,
        disableOnInteraction:false
      }
      });
      var swiper = new Swiper(".swiper-testimonials", {
      effect: "coverflow",
      grabCursor: true,
      centeredSlides: true,
      slidesPerView: "auto",
      slidesPerView:"3",
      loop: true,
      coverflowEffect: {
        rotate: 50,
        stretch: 0,
        depth: 100,
        modifier: 1,
        slideShadows: false,
      },
      pagination: {
        el: ".swiper-pagination",
      },
      breakpoints:{
        320:{
          slidesPerView: 1,
        },
        640:{
          slidesPerView: 1,
        },
        768:{
          slidesPerView: 2,
        },
        1024:{
          slidesPerView: 3,
        },
      }
    });
  window.onload = initializeGoogleSignIn;
</script>
</body>
</html>