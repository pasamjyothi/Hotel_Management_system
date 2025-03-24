<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MahaRaj Hotel</title>
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
</style>
</head>
<body class="bg-light">
    <?php require('inc/header.php')?>
    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center" >OUR FACILITIES</h2>
        <div class="h-line bg-dark"></div>
    <p class="text-center mt-3">Amenities in hotel rooms can include a minibar, tea and coffee 
        facilities,..etc <br>These can include a lobby, check-in and check-out areas, a bar, 
        and a business center These can include dining spaces and services These can include a fitness<br> center or
         swimming pool A hotel may have an on-site spa A hotel may have meeting rooms and 
         conference facilities These can include laundry service, airport transfers, babysitting,
          and 24-hour concierge 
        <br></p>
    </div>
    <div class="container">
        <div class="row">
        <?php
$res = selectAll('facilities');
$path = FEATURES_IMG_PATH;
while ($row = mysqli_fetch_assoc($res)) {
    $image = $path . $row['icon']; // Fetch image dynamically
    $name = htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); // Prevent XSS
    $description = htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8');

    echo <<<data
        <div class="col-lg-4 md-6 mb-5 px-4">
            <div class="bg-white rounded shadow p-4 border-top border-4">
                <div class="d-flex align-items-center mb-2">
                    <img src="$image" width="40px">
                    <h5 class="m-0 ms-3">$name</h5>
                </div>
                <p>$description</p>
            </div>
        </div>
    data;
}
?>
        </div>
    </div>
    <!-- Bootstrap JS (for dropdowns) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php require('inc/script.php');?>
<?php require('inc/footer.php');?>
</body>
</html>