<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MahaRaj Hotel - Bookings</title>
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
    <?php require('inc/header.php');?>
    <?php  
    if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
        redirect('index.php');
    }
    ?>

    <div class="container">
        <div class="row g-4">
            <div class="col-12 my-5 px-4">
                <h2 class="fw-bold h-font text-center">Bookings</h2>
                <div style="font-size: 14px;">
                    <a href="index.php" class="text-secondary text-decoration-none">Home</a> >
                    <a href="rooms.php" class="text-secondary text-decoration-none">Bookings</a> >
                </div>
            </div>

            <?php
            $query = "SELECT bo.*, bd.* FROM `booking_order` bo
                      INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
                      WHERE ((bo.booking_status='booked' ) OR (bo.booking_status='cancelled')
                      OR (bo.booking_status='payment failed' )) AND (bd.user_id=?) ORDER BY bo.booking_id DESC";
                   
            
            $result = select($query, [$_SESSION['uId']], 'i');
            
            while ($data = mysqli_fetch_assoc($result)) {
                $date = date("d-m-Y", strtotime($data['datentime']));
                $checkin = date("d-m-Y", strtotime($data['check_in']));
                $checkout = date("d-m-Y", strtotime($data['check_out']));

                $status_bg = "";
                $btn = "";
                if ($data['booking_status'] == 'booked') {
                    $status_bg = "bg-success";
                
                    if ($data['arrival'] == 1) {
                        $btn = "<a href='generate_pdf.php?gen_pdf&id={$data['booking_id']}' class='btn text-light btn-sm btn-dark shadow-none'>Download PDF</a>";
                    }
                if($data['arrival']==0){
                    $btn.="<button type='button' onclick='cancel_booking({$data['booking_id']})' class='btn btn-sm btn-danger shadow-none'>cancel</button>";
                }
                    if ($data['rate_review'] == 0) {
                        $btn .= " <button type='button' onclick='review_room({$data['booking_id']},{$data['room_id']})' data-bs-toggle='modal' data-bs-target='#reviewModal' class='btn btn-sm btn-success shadow-none'>Rate & Review</button>";
                    } 
                
                } elseif ($data['booking_status'] == 'cancelled') {
                    $status_bg = "bg-danger";
                    
                    if ($data['refund'] == 0) {
                        $btn = "<span class='badge bg-primary'>Refund in process</span>";
                    } else {
                        $btn = "<a href='generate_pdf.php?gen_pdf&id={$data['booking_id']}' class='btn text-light btn-sm btn-dark shadow-none'>Download PDF</a>";
                    }
                
                } elseif ($data['booking_status'] == 'payment_failed') {
                    $status_bg = "bg-warning";
                    $btn = "<a href='generate_pdf.php?gen_pdf&id={$data['booking_id']}' class='btn text-light btn-sm btn-dark shadow-none'>Download PDF</a>";
                }
                

                echo <<<bookings
                <div class='col-md-4 px-4 mb-4'>
                    <div class='bg-white p-3 rounded shadow-sm'>
                       <h5 class='fw-bold'>$data[room_name]</h5>
                        <p>$data[price] per night</p>
                        <p>
                        <b>Check-in: </b> $checkin<br>
                        <b>Check-in: </b>$checkout 
                        </p>
                        <p>
                        <b>Amount: </b>$data[price]<br>
                        <b>Order ID:</b> $data[order_id]
                        <b> Date:</b>$date
                        </p>
                        <p>
                        <span class='badge $status_bg'>$data[booking_status]</span>
                        </p>
                        $btn
                    </div>
                </div>
                bookings;
            }
            ?>
        </div>
    </div>


<div class="modal fade" id="reviewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="loginModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="review-form">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-item-center"><i class="bi bi-chat-square-heart-fill"></i>Rate and Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Rating</label>
                        <select class="form-select shadow-one" name="rating">
                            <option selected>Open this select menu</option>
                            <option value="5">Excellent</option>
                            <option value="4">Good</option>
                            <option value="3">Ok</option>
                            <option value="2">Poor</option>
                            <option value="1">Bad</option>
                        </select>
                    </div>
                    <div class="mb-3 col-md-12 p-0">
                        <label class="form-label">Review</label>
                        <textarea type="password" name="review" rows="1" required class="form-controk shadow-none"></textarea>
                    </div>
                    <input type="hidden" name="booking_id">
                    <input type="hidden" name="room_id">
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-success text-light shadow-none">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
        <?php
        if(isset($_GET['cancel_status'])){
            alert('success','Booking Cancelled');
            
        }
        else if(isset($_GET['review_status'])){
            alert('success','Thank you for Rating and Review');
            
        }
        ?>


    <?php require('inc/footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    function cancel_booking(id) {
        if(confirm('Are you sure to cancel booking?')){
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/cancel_booking.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
              if(this.responseText==1){
                window.location.href="bookings.php?cancel_status=true";
              }else{
                alert('error','Cancellation Failed!');
              }
            
            }
            xhr.send('cancel_booking&id='+id);
        }
        
    }
    let review_form=document.getElementById('review-form');
    function review_room(bid,rid){
        review_form.elements['booking_id'].value=bid;
        review_form.elements['room_id'].value=rid;
    }
    review_form.addEventListener('submit',function(e){
    e.preventDefault();
    let data = new FormData();
    data.append('review_form', '');
    data.append('rating', review_form.elements['rating'].value);
    data.append('review', review_form.elements['review'].value);
    data.append('booking_id', review_form.elements['booking_id'].value);
    data.append('room_id', review_form.elements['room_id'].value);
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/review_room.php", true);
        xhr.onload = function () {
            if (this.responseText ==0) {
                window.location.href='bookings.php?review_status=true';
            }else {
                var myModal = document.getElementById('reviewModal');
                var  modal = bootstrap.Modal.getInstance(myModal);
                modal.hide();
                alert('success','Rating & Review success!');
            }
    }
    xhr.send(data);

    }
);

    </script>
</body>
</html>
