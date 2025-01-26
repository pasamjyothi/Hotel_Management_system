<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MahaRaj Hotel-About</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="css/#commoncss">
<style>
    .box{
        border-top-color:var(--teal)!important;
    }
    </style>
</head>
<body class="bg-light">
    <?php require('inc/header.php');?>
    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center align-items-center" >ABOUT US</h2>
        <div class="h-line bg-dark"></div>
    <p class="text-center mt-3">Amenities in hotel rooms can include a minibar, tea and coffee 
        facilities, a safe, air conditioning, a TV, a phone, USB charging points, and a desk 
         These can include a lobby, check-in and check-out areas, a bar, and a business center 
         These can include dining spaces and services These can include a fitness center or
         swimming pool A hotel may have an on-site spa A hotel may have meeting rooms and 
         conference facilities These can include laundry service, airport transfers, babysitting,
          and 24-hour concierge 
        <br></p>
    </div>
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-6 col-md-5 mb-4 order-lg-1 order-md-1 order-2">
                <h3 class="mb-3">Rai Bahadur Mohan Singh Oberoi</h3>
                <p>Rai Bahadur Mohan Singh Oberoi is the founder of the Oberoi Group, India's 
                    largest hotel chain. Before India gained independence, Oberoi interacted 
                    with the leaders of Free India, who were often guests at his hotels
                </p>
            </div>
                <div class="col-lg-5 col-md-4 order-lg-2 order-md-2 order-1 p-4">
                    <img src="image/oener.jpg" class="w-100" >
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box mt-4">
                   <img src="image/hotel.svg" width="60px">
                   <h4  class="mt-3">100+Rooms</h4>
                </div>

            </div>
            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box mt-4">
                   <img src="image/customers.svg" width="60px">
                   <h4  class="mt-3">900+Customer</h4>
                </div>

            </div>
            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box mt-4">
                   <img src="image/rating.svg" width="60px">
                   <h4  class="mt-3">200+Ratings</h4>
                </div>

            </div>
            <div class="col-lg-3 col-md-6 mb-4 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 text-center box mt-4">
                   <img src="image/staff.svg" width="60px">
                   <h4  class="mt-3">150+staff</h4>
                </div>

            </div>
        </div>
    </div>
<h3 class="my-5 fw-bold h-font text-center">MANAGEMENT TEAM</h3>
<div class="container px-4">
    <div class="swiper swiper-container">
        <div class="swiper-wrapper mb-5">
        <?php
$about_r = selectAll('team_details'); 
$path = ABOUT_IMG_PATH; // Define the base image path

while ($row = mysqli_fetch_assoc($about_r)) {
    $img_path = $path . $row['picture']; // Construct the full image path
    $name = htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); // Escape the name for security

    echo <<<data
    <div class="swiper-slide bg-white text-center overflow-hidden rounded">
        <img src="$img_path" class="w-100 d-block" alt="$name">
        <h5 class="mt-2">$name</h5>
    </div>
    data;
}
?>

        <div class="swiper-pagination"></div>
    </div>
</div>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper(".swiper-container", {
        spaceBetween: 20,
        loop: true,
        autoplay: {
            delay: 3500,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });
</script>
  <?php require('inc/footer.php');?>
</body>
</html>