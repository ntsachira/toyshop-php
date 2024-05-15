<!DOCTYPE html>

<html>



<body onload="reloadMessages();">
    <div class=" border-bottom border-info d-flex sticky-top bg-light bg-opacity-75 justify-content-center mb-2 rounded-bottom-5" id='header'>
        <div class="container-lg row py-2 align-items-center">
            <div class="col-6 d-flex gap-4 align-items-center">
                 <!-- logo block -->
                 <a href="home.php" class="text-decoration-none col-md-1 gap-2 d-flex justify-content-center align-items-center ">
                        <img src="resource/logo.png" style="width:3rem" alt="logo">
                        <h1 class="logo-text d-md-none ">Toy Shop</h1>
                    </a>
                    <!-- logo block -->
                <div class="d-flex align-items-center gap-2">
                    <?php
                    if (isset($_SESSION["user"])) {
                        ?>
                        <span class="text-blue fw-bold d-none d-lg-block">Hi!
                            <?php echo $_SESSION["user"]["first_name"] ?>
                        </span>
                        
                        <?php
                    }
                    ?>
                    

                </div>   
                <a href="userProfile.php?msg=open" class="position-relative header-link  d-none d-sm-block">
                    <i class="envelope icon fs-4 "></i>
                    <?php
                    if (isset($_SESSION["user"])) {
                        $message_result = Database::execute("SELECT `sender` FROM `message_history` 
                        WHERE `seen_status_seen_status_id` = '2' AND `sender` = 'admin@gmail.com' AND `receiver`='".$_SESSION['user']['email']."'GROUP BY `sender`");       
                       
                        ?>
                        <span id="unread-message-count" class="position-absolute top-0 mt-1 start-100 translate-middle badge rounded-pill bg-orange">
                         <!-- load message count here -->    0                        
                        </span>
                        <?php
                    }
                    ?>
                </a>      
                   
            </div>
            <!-- header-right -->
            <div class="col-6 d-flex gap-4 flex-row-reverse align-items-center">
                <a href="cart.php" class="position-relative header-link d-none d-sm-block">
                    <i class="shop icon fs-4"></i>
                    <?php
                    if (isset($_SESSION["user"])) {
                        $cart_items = Database::execute("SELECT * FROM `cart` WHERE `user_email`='" . $_SESSION["user"]["email"] . "'");
                       
                        ?>
                        <span class="position-absolute top-0 mt-1 start-100 translate-middle badge rounded-pill bg-orange">
                            <?php 
                             echo $cart_items->num_rows;
                            ?>
                            <span class="visually-hidden">Cart Items</span>
                        </span>
                        <?php
                    }
                    ?>
                </a>
                <a href="watchlist.php" class="header-link d-none d-sm-block"><i class="heart icon fs-4"></i></a>

                <!-- dropdown -->
                <div class="dropdown">
                    <button class="btn btn-light rounded-5 dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="user fs-5 icon "></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item " href="userProfile.php"><i class="user icon text-orange"></i>
                                Manage My Account</a></li>
                        <li><a class="dropdown-item " href="myOrders.php"><i class="box icon text-orange"></i> My Orders</a></li>
                        <li><a class="dropdown-item " href="cart.php"><i class="shop icon text-orange"></i> Cart</a>
                        </li>
                        <li><a class="dropdown-item " href="watchlist.php"><i class="heart icon text-orange"></i>
                                Watchlist</a></li>
                        <li><a class="dropdown-item " href="myReviews.php"><i class="star icon text-orange"></i> My reviews</a></li>
                        
                        <?php
                        if (isset($_SESSION["user"])) {
                        ?>                        
                        <li><a class="dropdown-item " href="#" onclick="signout();"><i class="sign-out icon"></i> <span class="btn btn-secondary rounded-5">SignOut</span></a></li>
                       
                        <?php
                    }else {
                        ?>
                        <li><a class="dropdown-item " href="index.php"><i class="sign-in icon"></i> <span class="btn btn-secondary rounded-5">SignIn</span></a></li>                   
                       
                        <?php
                    }
                    ?>
                    </ul>
                </div>
                <!-- dropdown -->

                
                
            </div>
            <!-- header-right -->
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>

</body>

</html>