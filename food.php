<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MahaRaj Hotel - Order Food</title>
    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <?php require('inc/links.php');?>
    <style>
    .menu-item {
        padding: 15px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
    }
    .menu-item img {
        width: 100%;                
        height: 200px;             
        object-fit: cover;        
        border-radius: 8px;
    }

   
    .menu-item:hover {
        transform: scale(1.05);
        transition: all 0.3s;
        border: 2px solid var(--teal);
    }
    .menu-card {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .menu-card {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .menu-container {
        display: flex;
        flex-wrap: wrap;            
        gap: 15px;                  
        justify-content: center;    
    }
    #todays-special-popup {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        border-radius: 8px;
        padding: 15px;
        max-width: 300px;
        z-index: 1000;
    }

    #todays-special-popup h5 {
        margin-bottom: 10px;
        font-weight: bold;
    }

    #todays-special-popup img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin-bottom: 10px;
    }

    #close-popup {
        position: absolute;
        top: 10px;
        right: 10px;
        background: none;
        border: none;
        font-size: 18px;
        cursor: pointer;
    }
</style>

</head>
<body class="bg-light">
    <?php require('inc/header.php'); ?>

    <div id="todays-special-popup">
        <button id="close-popup" aria-label="Close">&times;</button>
        <h5>Today's Special</h5>
        <img src="image/butter.jpeg" alt="Today's Special">
        <p>Try our Chef's Special <strong>Butter Chicken</strong>, a rich and creamy delight!</p>
        <h6 class="text-danger">Price: 350/-</h6>
    </div>

    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">Order Your Favorite Food</h2>
        <div class="h-line bg-dark"></div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <h4 class="fw-bold mt-4">Indian Cuisine</h4>
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card menu-card menu-item">
                            <img src="image/panner.jpeg" class="card-img-top" alt="Paneer Butter Masala">
                            <div class="card-body">
                                <h5 class="card-title">Paneer Butter Masala</h5>
                                <p class="card-text">Delicious cottage cheese cooked in creamy tomato gravy.</p>
                                <h6 class="text-danger">Price: 250/-</h6>
                                <button class="btn btn-sm btn-outline-dark">Add to Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card menu-card menu-item">
                            <img src="image/biryani.jpeg" class="card-img-top" alt="Chicken Biryani">
                            <div class="card-body">
                                <h5 class="card-title">Chicken Biryani</h5>
                                <p class="card-text">Spiced basmati rice with marinated chicken.</p>
                                <h6 class="text-danger">Price: 300/-</h6>
                                <button class="btn btn-sm btn-outline-dark">Add to Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card menu-card menu-item">
                            <img src="image/veg.jpg" class="card-img-top" alt="Chicken Biryani">
                            <div class="card-body">
                                <h5 class="card-title">veg Thali</h5>
                                <p class="card-text">Spiced basmati rice with marinated chicken.</p>
                                <h6 class="text-danger">Price: 300/-</h6>
                                <button class="btn btn-sm btn-outline-dark">Add to Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card menu-card menu-item">
                            <img src="image/non.jpg" class="card-img-top" alt="Chicken Biryani">
                            <div class="card-body">
                                <h5 class="card-title">Non veg Thali</h5>
                                <p class="card-text">Spiced basmati rice with marinated chicken.</p>
                                <h6 class="text-danger">Price: 300/-</h6>
                                <button class="btn btn-sm btn-outline-dark">Add to Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card menu-card menu-item">
                            <img src="image/mush.jpeg" class="card-img-top" alt="Chicken Biryani">
                            <div class="card-body">
                                <h5 class="card-title">Mushroom fried rice</h5>
                                <p class="card-text">Spiced basmati rice with marinated chicken.</p>
                                <h6 class="text-danger">Price: 300/-</h6>
                                <button class="btn btn-sm btn-outline-dark">Add to Order</button>
                            </div>
                        </div>
                    </div>
                </div>

                <h4 class="fw-bold mt-4">Chinese Cuisine</h4>
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card menu-card menu-item">
                            <img src="image/noodles.jpg" class="card-img-top" alt="Noodles">
                            <div class="card-body">
                                <h5 class="card-title">Hakka Noodles</h5>
                                <p class="card-text">Classic stir-fried noodles with vegetables and sauces.</p>
                                <h6 class="text-danger">Price: 180/-</h6>
                                <button class="btn btn-sm btn-outline-dark">Add to Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card menu-card menu-item">
                            <img src="image/manchurian.jpg" class="card-img-top" alt="Manchurian">
                            <div class="card-body">
                                <h5 class="card-title">Veg Manchurian</h5>
                                <p class="card-text">Crispy vegetable balls in tangy, spicy gravy.</p>
                                <h6 class="text-danger">Price: 200/-</h6>
                                <button class="btn btn-sm btn-outline-dark">Add to Order</button>
                            </div>
                        </div>
                    </div>
                </div>
                <h4 class="fw-bold mt-4">Desserts</h4>
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card menu-card menu-item">
                            <img src="image/brow.jpg" class="card-img-top" alt="Chocolate Brownie">
                            <div class="card-body">
                                <h5 class="card-title">Sizzling Browine</h5>
                                <p class="card-text">Rich and moist chocolate dessert.</p>
                                <h6 class="text-danger">Price: 150/-</h6>
                                <button class="btn btn-sm btn-outline-dark">Add to Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card menu-card menu-item">
                            <img src="image/jamun.jpg" class="card-img-top" alt="Gulab Jamun">
                            <div class="card-body">
                                <h5 class="card-title">Gulab Jamun</h5>
                                <p class="card-text">Soft milk dumplings soaked in sugar syrup.</p>
                                <h6 class="text-danger">Price: 120/-</h6>
                                <button class="btn btn-sm btn-outline-dark">Add to Order</button>
                            </div>
                        </div>
                    </div>
                </div>
                <h4 class="fw-bold mt-4">Staters</h4>
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card menu-card menu-item">
                            <img src="image/nuggets.jpg" class="card-img-top" alt="Chocolate Brownie">
                            <div class="card-body">
                                <h5 class="card-title">Corn Cheese Nuggets</h5>
                                <p class="card-text">Corn Cheese Nuggets with herbs,spices and bread crumbs</p>
                                <h6 class="text-danger">Price: 150/-</h6>
                                <button class="btn btn-sm btn-outline-dark">Add to Order</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card menu-card menu-item">
                            <img src="image/65.jpeg" class="card-img-top" alt="Gulab Jamun">
                            <div class="card-body">
                                <h5 class="card-title">Paneer 65</h5>
                                <p class="card-text">delicious Indian appetizer made with fresh cubes of paneer</p>
                                <h6 class="text-danger">Price: 220/-</h6>
                                <button class="btn btn-sm btn-outline-dark">Add to Order</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Order Summary</h4>
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control shadow-none" placeholder="Enter your name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" class="form-control shadow-none" placeholder="Enter your phone number">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Room Number</label>
                            <textarea class="form-control shadow-none" rows="3" placeholder="Enter your Room Number"></textarea>
                        </div>
                        <div class="mb-3">
                            <h6>Total Price: <span class="text-danger">0/-</span></h6>
                        </div>
                        <button class="btn btn-dark w-100">Place Order</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require('inc/footer.php'); ?>
    <!-- Bootstrap JS (for dropdowns) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const popup = document.getElementById('todays-special-popup');
        const closePopupBtn = document.getElementById('close-popup');
        closePopupBtn.addEventListener('click', () => {
            popup.style.display = 'none';
            localStorage.setItem('popupClosed', 'true');
        });
        document.addEventListener('DOMContentLoaded', () => {
            const popupClosed = localStorage.getItem('popupClosed');
            if (popupClosed === 'true') {
                popup.style.display = 'none';
            }
        });
    </script>

</body>
</html>