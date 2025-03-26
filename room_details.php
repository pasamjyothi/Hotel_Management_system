<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MahaRaj Hotel - Room Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <?php require('inc/links.php'); ?>
    <style>
        .pop:hover {
            border-top-color: var(--teal) !important;
            transform: scale(1.03);
            transition: all 0.3s;
        }
        #main {
            display: flex;
            flex-wrap: wrap;
            width: 100%;
            gap: 30px;
        }
        .rating i {
            font-size: 1.2rem;
        }
        .badge {
            font-size: 0.9rem;
            padding: 5px 10px;
        }
    </style>
</head>
<body class="bg-light">
    <?php require('inc/header.php'); ?>

    <?php
    if (!isset($_GET['id'])) {
        redirect('rooms.php');
    }

    $data = filteration($_GET);
    $room_res = select("SELECT * FROM `rooms` WHERE `id`=? AND `status`=? AND `removed`=?", [$data['id'], 1, 0], 'iii');

    if (mysqli_num_rows($room_res) == 0) {
        redirect('rooms.php');
    }

    $room_data = mysqli_fetch_assoc($room_res);
    ?>

<div class="container">
    <div class="row g-4">
    <div class="col-12 my-5 mb-4 px-4">
                <h2 class="fw-bold h-font text-center"><?php echo $room_data['name']; ?></h2>
    </div>
        <!-- Room Image Section -->
        <div class="col-lg-7 col-md-12 px-4">
            <div id="roomCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    $room_img = ROOMS_IMG_PATH . "thumbnail.jpg";
                    $img_q = mysqli_query($con, "SELECT * FROM `room_images` WHERE `room_id`='$room_data[id]'");
                    $active_class = "active";

                    if (mysqli_num_rows($img_q) > 0) {
                        while ($img_res = mysqli_fetch_assoc($img_q)) {
                            echo "<div class='carousel-item $active_class'>
                                    <img src='" . ROOMS_IMG_PATH . $img_res['image'] . "' class='d-block w-100 rounded' style='max-height: 400px; object-fit: cover;'>
                                  </div>";
                            $active_class = ""; // Remove active after first image
                        }
                    } else {
                        echo "<div class='carousel-item active'>
                                <img src='$room_img' class='d-block w-100 rounded' style='max-height: 400px; object-fit: cover;'>
                              </div>";
                    }
                    ?>
                </div>

                <!-- Carousel Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <!-- Room Details Section -->
        <div class="col-lg-5 col-md-12 px-4">
            <div class="card shadow-sm border-0 rounded-3 p-4">

                <h4 class="mb-3">₹<?php echo $room_data['price']; ?> per night</h4>
                <?php
        $rating_q="SELECT AVG(rating) AS `avg_rating` FROM `rating_review` WHERE `room_id`='$room_data[id]' ORDER BY `sr_no` DESC LIMIT 20";
          $rating_res=mysqli_query($con,$rating_q);
          $rating_data="";
          $rating_fetch=mysqli_fetch_assoc($rating_res);
          if($rating_fetch['avg_rating']!=NULL){
                for($i=0;$i<$rating_fetch['avg_rating'];$i++){
                       $rating_data.=" <i class='bi bi-star-fill text-warning'></i>";
               }
          }
          echo<<<rating
          <div class="mb-3">
          $rating_data
          </div>
          rating;
          ?>
                <?php
                // Fetch Features
                $fea_q = mysqli_query($con, "SELECT f.name FROM `features` f INNER JOIN `rooms_features` rfea ON f.id = rfea.features_id WHERE rfea.room_id = '$room_data[id]'");
                $features_data = "";
                while ($fea_row = mysqli_fetch_assoc($fea_q)) {
                    $features_data .= "<span class='badge bg-light text-dark me-2'>$fea_row[name]</span>";
                }

                if ($features_data) {
                    echo "<h6 class='mb-2'>Features</h6><p>$features_data</p>";
                }

                // Fetch Facilities
                $fac_q = mysqli_query($con, "SELECT f.name FROM `facilities` f INNER JOIN `rooms_facilities` rfac ON f.id = rfac.facilities_id WHERE rfac.room_id = '$room_data[id]'");
                $facilities_data = "";
                while ($fac_row = mysqli_fetch_assoc($fac_q)) {
                    $facilities_data .= "<span class='badge bg-light text-dark me-2'>$fac_row[name]</span>";
                }

                if ($facilities_data) {
                    echo "<h6 class='mb-2'>Facilities</h6><p>$facilities_data</p>";
                }
                echo<<<guests
                     <div class="guests mb-3">
                        <h6 class="mb-1">Guests</h6>
                        <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">$room_data[adult] Adults</span>
                        <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">$room_data[children] Childrens</span>
                    </div>
                guests;
                echo<<<area
                    <div class="mb-3">
                        <h6 class="mb-1">Area</h6>
                           <span class='badge bg-light text-dark me-2'>$room_data[area] sq.ft</span>
                    </div>
                area;
                if (!$settings_r['shutdown']) {
                    $login = 0;
                    if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
                        $login = 1;
                    }
                echo<<<book
                 <button onclick='checkLoginToBook($login,$room_data[id])' class='btn btn-sm btn-success custom-bg shadow-none'>Book Now</button>
                book;
                }
                ?>
            </div>
        </div>
        <div class=" col-12 px-4 mt-4">
            <div class="mb-5">
                <h5>Description</h5>
                <p><?php echo $room_data['description']?></p>
            </div>
            <div>
            <h5 class="mb-3">Review Rating</h5>
         
        <?php
          $review_q = "SELECT rr.*,uc.name AS uname,uc.profile, r.name AS rname FROM `rating_review` rr
          INNER JOIN `user_cred` uc ON rr.user_id=uc.id
         INNER JOIN `rooms` r ON rr.room_id=r.id
         WHERE rr.room_id='$room_data[id]'
          ORDER BY `sr_no` DESC LIMIT 15";
          $review_res=mysqli_query($con,$review_q);
          $img_path=USERIMAGE_IMG_PATH;
          if(mysqli_num_rows($review_res)==0){
            echo 'No review yet!';
          }else{
            while($row=mysqli_fetch_assoc($review_res)){
                $stars=" <i class='bi bi-star-fill text-warning'></i>";
                for($i=1;$i<5;$i++){
                  $stars.=" <i class='bi bi-star-fill text-warning'></i>";
                }
                echo<<<data
                        <div class="mb-4">
                            <div class='d-flex align-items-center mb-2'>
                            <img src="$img_path$row[profile]" class="ronded-circle" loading="lazy" width="30px'>
                            <h6 class='m-0 ms-2'>$row[uname]</h6>
                        </div>
                        <p class="mb-1">$row[review]</p>
                        <div class='rating'>           
                          $stars
                        </div>
                            </div>
                data;

            }
          }
        ?>
            </div>
        </div>
    </div>
</div>


    <?php require('inc/footer.php'); ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
