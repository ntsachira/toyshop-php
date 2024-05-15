<?php
session_start();

if (!isset($_SESSION["product"])) {
    header("Location: home.php");
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        <?php echo $_SESSION["product"]["title"] ?>
    </title>
    <link rel="icon" type="image/png" href="resource/logo.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">


    <!-- jQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- jQuery CDN -->

    <!-- Semantic UI CDN -->
    <script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.5.0/dist/semantic.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.5.0/dist/semantic.min.css">
    <!-- Semantic UI CDN -->

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body id="bd" onload='loadRating(<?php echo $_SESSION["product"]["product_id"] ?>);loadCheckReviewModal(<?php echo $_SESSION["product"]["product_id"] ?>,1);'>
    <?php
    $userType = "user";
    if (isset($_GET["userType"])) {
        if ($_GET["userType"] != "admin") {
            include_once 'connection.php';
            include 'header.php';
            include "searchbar.php";
        } else {
            $userType = "admin";
            include 'connection.php';
        }

    } else {
        include 'connection.php';
    }
    ?>
    <div class="container-xl">
        <div class="col-12 py-3">
            <?php
            $back_url = "home.php";
            if (isset($_GET["userType"])) {
                if ($_GET["userType"] == "admin") {
                    $back_url = "admin/home.php?tab=myProducts";
                    ?>
                    <a href="<?php echo $back_url ?>" class="text-dark"><i class="left arrow icon divider"></i>Back</a>
                    <?php
                } else {
                    ?>
                    <!-- bread crumb -->
                    <div class="ui breadcrumb">
                        <a href="home.php" class="section">ToyShop</a>
                        <i class="right angle icon divider"></i>
                        <a class="section" href="loadProducts.php?cat=<?php echo $_SESSION["product"]["category_id"] ?>">
                            <?php echo $_SESSION["product"]["category_name"] ?>
                        </a>
                        <i class="right angle icon divider"></i>
                        <div class="active section mt-2">
                            <?php $words = explode(" ", $_SESSION["product"]["title"]);
                            echo implode(" ", array_splice($words, 0, 6)) ?>...
                        </div>
                    </div>
                    <!-- bread crumb -->
                    <?php
                }
            }
            ?>

        </div>
        <div class="row p-3 gap-3 mb-5 bg-light">

            <div class="col-12">
                <h3 class="d-md-none">
                    <?php echo $_SESSION["product"]["title"] ?>
                </h3>
            </div>
            <div class="col-12 col-md-6 col-lg-7">
                <div class="row gap-2 flex-row-reverse  px-3">
                    <div class="col-12 col-lg curser-zoom  position-relative overflow-hidden rounded-4 img-thumbnail"
                        id="imageParent">
                        <div class="col-12 overflow-hidden   position-relative" id="imageContainer">
                            <img src="" alt="" id="largeImagePreview" class="col-12  position-relative"
                                style="object-fit: contain; max-height: 35rem;">

                        </div>
                    </div>
                    <div class="col-12 col-lg-2">
                        <div class="row justify-content-center gap-2">
                            <?php
                            $image_result = Database::execute("SELECT * FROM `product_image` WHERE 
                    `product_product_id` = '" . $_SESSION["product"]["product_id"] . "' ");
                            for ($x = 0; $x < $image_result->num_rows; $x++) {
                                $image = $image_result->fetch_assoc();
                                ?>
                                <img class="img-thumbnail rounded-3 curser-pointer "
                                    src="resource/product_image/<?php echo $image["image_path"] ?>" alt=""
                                    id="productImage<?php echo $x ?>"
                                    onclick="setLargeImage('resource/product_image/<?php echo $image['image_path'] ?>')"
                                    style="height:7rem; max-width:7rem;object-fit: contain;">
                                <?php
                            }
                            ?>
                            <script>
                                $('#largeImagePreview').attr("src", $('#productImage0').attr("src"));
                            </script>
                        </div>
                    </div>
                </div>
            </div>
            <!-- right -->
            <div class="col-12 col-md">
                <h3 class="d-md-block d-none" id="pt">
                    <?php echo $_SESSION["product"]["title"] ?>
                </h3>
                <div class="row px-3 py-4 gap-3 bg-white border">

                    <div
                        class="col-12 d-flex align-items-center flex-row align-items-md-start flex-md-column align-items-xl-center flex-xl-row gap-2">
                        <span class="fs-2 fw-bold">Rs.
                            <?php echo number_format($_SESSION["product"]["price"], 2) ?>
                        </span>
                        <?php
                        $price = (intval($_SESSION["product"]["price"]) / 10) + intval($_SESSION["product"]["price"]);
                        ?>
                        <span class="text-blue "><del>Rs.
                                <?php echo number_format($price, 2) ?>
                            </del> &nbsp; <b>10% OFF</b></span>
                    </div>
                    <div class="col-12">
                        <span>Condition : <b>
                                <?php echo $_SESSION["product"]["condition_name"] ?>
                            </b></span>
                    </div>
                    <div class="col-12">
                        <div class="row align-items-center">
                            <div class="d-flex align-items-center justify-content-between"
                                style="min-width:12rem;max-width:12rem">
                                <span>Quantity : </span>
                                <div class="ui input">
                                    <input type="number" id="qtyInput" max="<?php echo $_SESSION["product"]["quantity"] ?>" min="1"
                                        <?php echo $_SESSION["product"]['quantity'] == 0 ? "disabled" : "" ?> value="1">
                                </div>
                            </div>
                            <?php
                            if ($_SESSION["product"]['quantity'] > 0) {
                                ?>
                                <div class=" col">
                                    <?php echo $_SESSION["product"]["quantity"] > 10 ? "More than 10 available" : "Only " . $_SESSION["product"]["quantity"] . " products available" ?>
                                    /
                                    20 sold
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class=" col text-danger">
                                    Sold Out!
                                </div>
                                <?php
                            }
                            ?>

                        </div>
                    </div>
                    <div class="col-12 d-flex flex-column gap-2">
                        <?php
                        if ($_SESSION["product"]['quantity'] > 0) {
                            ?>
                            <div class="huge ui orange button" onclick="buyitNow(<?php echo $_SESSION['product']['product_id'] ?>);">
                                Buy it Now
                            </div>
                            <div class="huge ui teal button" onclick="addtoCart(<?php echo $_SESSION['product']['product_id'] ?>,1);">
                                <i class="shop icon "></i> Add to Cart
                            </div>
                            <?php
                        }
                        if (isset($_SESSION["user"])) {
                            $watchlist_result = Database::execute("SELECT * FROM `watchlist` WHERE `product_product_id` = '" . $_SESSION['product']["product_id"] . "' 
                                    AND `user_email` = '" . $_SESSION["user"]["email"] . "'");
                            if ($watchlist_result->num_rows == 1) {
                                ?>
                                <div onclick="toggleWatchList(<?php echo $_SESSION['product']['product_id'] ?>)"
                                    class=" ui basic default button">
                                    <i id="heart-icon<?php echo $_SESSION['product']['product_id'] ?>"
                                        class="heart icon text-danger"></i> Watchlist
                                </div>
                                <?php
                            } else {
                                ?>
                                <div onclick="toggleWatchList(<?php echo $_SESSION['product']['product_id'] ?>)"
                                    class=" ui basic default button">
                                    <i id="heart-icon<?php echo $_SESSION['product']['product_id'] ?>" class="heart icon"></i>
                                    Watchlist
                                </div>
                                <?php
                            }
                        } else {
                            ?>
                            <div onclick="toggleWatchList(<?php echo $_SESSION['product']['product_id'] ?>)"
                                class=" ui basic default button">
                                <i id="heart-icon<?php echo $_SESSION['product']['product_id'] ?>" class="heart icon"></i>
                                Watchlist
                            </div>
                            <?php
                        }

                        ?>


                    </div>
                    <div class="col-12 border-top pt-3 mt-2">
                        <h6>Highlights</h6>
                        <ul>
                            <li>
                                <?php echo $_SESSION["product"]["description"] ?>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews and Ratings -->
        <div class="row p-3 gap-3 justify-content-center ">
            <div class="col-12 col-sm-11 col-md-10 border-top border-bottom  px-4 py-4">
                <div class="row gap-3">
                    <div class="col-12 d-flex flex-column flex-sm-row justify-content-between">
                        <?php 
                        $rate = 0;
                        $reviewed = false;
                             $review_result = Database::execute("SELECT * FROM `reviews` WHERE `product_product_id` = '".$_SESSION['product']['product_id'] ."'");   
                                                     
                             while($review_data = $review_result->fetch_assoc()){
                                 $rate =  $rate + $review_data['rate'];
                                 if(isset($_SESSION['user']) && $review_data['user_email'] == $_SESSION['user']['email'] ){
                                    $reviewed = true;
                                 }
                             }
                             if($rate != 0){
                                $rate = (int)($rate / $review_result->num_rows); 
                             }
                                                         
                        
                        ?>
                        <h5 id="">Reviews & Ratings(<?php echo $review_result->num_rows ?>)</h5>
                        <div class="d-flex gap-2 align-items-center">
                            <span class="fs-4"><?php echo $rate ?></span>
                            <div class="ui huge star rating" data-max-rating="5" id='total-rate'></div>
                        </div>
                    </div>
                         <?php 
                          if($review_result->num_rows == 0 ){
                            ?>
                            <!-- no reviews alert -->
                    <div class="col-12">
                        <div class="alert alert-warning rounded-0">There are No reviews yet</div>
                    </div>
                    <!-- no reviews alert -->
                            <?php
                         }else{
                            ?>
                            <!-- customer reviews -->
                            <div class="col-12">
                                <div class="row" >
                                    <div class="col-12 mb-3">
                                    <p>What people like about it</p>
                                    </div>
                                    <div class="col-12">
                                        <div class="row" id="product-reviews-container">
                                            <!-- load content here -->
                                        </div>
                                    </div>                                     
                                                                    
                                </div>

                            </div>
        <!-- customer reviews -->
                            <?php 
                         }
                      
                    if(isset($_SESSION['user'])){
                        if(!$reviewed){

                       
                        ?>
                        <!-- Add first review -->
                    <div class="col-12">
                        <div class="row justify-content-center bg-light py-5">
                            <div class="col-10 py-4">
                                <div class="row gap-3">
                                    <div class="col-12">
                                        <h5 class="text-truncate"><?php if($review_result->num_rows == 0 ){?>Be the first to <?php }?> Review &nbsp;<b>
                                                <?php echo $_SESSION["product"]["title"] ?>
                                            </b></h5>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <span>Your Rate</span>
                                        <div class="ui huge star rating" data-max-rating="5" id="userRating"></div>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="exampleFormControlInput1" class="form-label">Your
                                                    Name</label>
                                                <input type="text" disabled class="form-control" id="exampleFormControlInput1"
                                                value="<?php echo $_SESSION['user']['first_name']." ".$_SESSION['user']['last_name']?>"
                                                    placeholder="Enter your Name here">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="exampleFormControlInput1" class="form-label">Your
                                                    Email</label>
                                                <input type="email" disabled class="form-control" id="exampleFormControlInput1"
                                                value="<?php echo $_SESSION['user']['email'] ?>"
                                                    placeholder="Enter your Email here">
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label for="exampleFormControlTextarea1" class="form-label">Your
                                                    Review (<span id="review-limit">0</span>/500)</label>
                                                <textarea class="form-control" id="review-text"
                                                    placeholder="Enter your review here" rows="5"></textarea>
                                            </div>
                                            <div class="col-12">
                                                <button class="ui secondary button w-100" onclick='addReview( <?php echo $_SESSION["product"]["product_id"] ?>)' id="submit-review">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Add first review -->
                        <?php
                         }
                    }
                    ?>
                    
                </div>


            </div>
        </div>

        <!-- Related products -->
        <?php
        $product_result = Database::execute("SELECT * FROM `active_product` WHERE category_id = '" . $_SESSION["product"]["category_id"] . "' 
                    AND `product_id` != '" . $_SESSION["product"]["product_id"] . "' LIMIT 5");

        if ($product_result->num_rows > 0) { ?>
            <div class="row p-3 pb-5 gap-3 bg-light position-relative my-3">
                <div class="col-12">
                    <h5><b>Related Products</b></h><b></b>
                </div>
                <div class="col-12">
                    <div class="row justify-content-center gap-3">
                        <?php
                        while ($product_data = $product_result->fetch_assoc()) {
                            $image_result = Database::execute("SELECT * FROM `product_image` WHERE
                        `product_product_id` = '" . $product_data["product_id"] . "' LIMIT 1");
                            $image_data = $image_result->fetch_assoc();
                            ?>

                            <!-- product card -->
                            <div class="card col-6 col-lg-2 p-1" style="width: 17rem;">
                                <img src="resource/product_image/<?php echo $image_data["image_path"] ?>"
                                    class="card-img-top img-thumbnail product-image"
                                    onclick='viewProduct(<?php echo $product_data["product_id"] ?>,"<?php echo $userType ?>");'
                                    style="height:240px; object-fit:contain;" alt=" product-image">
                                <?php
                                if ($product_data['quantity'] == 0) {
                                    ?>
                                    <div class="bg-white bg-opacity-75 position-absolute d-flex justify-content-center h-100 w-100 end-0 align-items-center"
                                        style="max-height:240px;"><span class="text-bg-warning px-3 shadow py-2">Out Of
                                            Stock!</span></div>
                                    <?php
                                }
                                ?>
                                <div class="card-body ">
                                    <a class="card-title text-default link-dark curser-pointer"
                                        onclick='viewProduct(<?php echo $product_data["product_id"] ?>,"<?php echo $userType ?>");'>
                                        <?php echo $product_data["title"] ?>
                                    </a>
                                    <span class="ui  tag h-auto label">
                                        <?php echo $product_data["condition_name"] ?>
                                    </span><br>
                                    <span class="card-text fs-3">Rs.
                                        <?php echo number_format($product_data["price"], 2) ?>
                                    </span><br>
                                    <div class="d-flex gap-1">
                                        <?php
                                        if ($product_data['quantity'] > 0) {
                                            ?>
                                            <button onclick="addtoCart(<?php echo $product_data['product_id'] ?>,1);"
                                                class="ui button icon orange w-50"><i class=" shop icon"></i></button>
                                            <?php
                                        } else {
                                            ?>
                                            <button disabled class="ui button icon orange w-50"><i class=" shop icon"></i></button>
                                            <?php
                                        }

                                        if (isset($_SESSION["user"])) {
                                            $watchlist_result = Database::execute("SELECT * FROM `watchlist` WHERE `product_product_id` = '" . $product_data["product_id"] . "' 
                                    AND `user_email` = '" . $_SESSION["user"]["email"] . "'");
                                            if ($watchlist_result->num_rows == 1) {
                                                ?>
                                                <a onclick="toggleWatchList(<?php echo $product_data['product_id'] ?>)"
                                                    class="ui button basic secondary icon w-50">
                                                    <i class=" heart icon text-danger"
                                                        id="heart-icon<?php echo $product_data['product_id'] ?>"></i>
                                                </a>
                                                <?php
                                            } else {
                                                ?>
                                                <a onclick="toggleWatchList(<?php echo $product_data['product_id'] ?>)"
                                                    class="ui button basic secondary icon w-50">
                                                    <i class=" heart icon" id="heart-icon<?php echo $product_data['product_id'] ?>"></i>
                                                </a>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <a onclick="toggleWatchList(<?php echo $product_data['product_id'] ?>)"
                                                class="ui button basic secondary icon w-50">
                                                <i class=" heart icon" id="heart-icon<?php echo $product_data['product_id'] ?>"></i>
                                            </a>
                                            <?php
                                        }

                                        ?>
                                    </div>
                                </div>
                            </div>
                            <!-- product card -->
                            <?php
                        }
        }

        ?>
                </div>
            </div>

        </div>

    </div>
    <div class="row gap-3 position-relative p-3 m-0 my-3">
        <div class="col-12">
            <div class="row justify-content-center gap-3">
                <!-- card 1 -->
                <div class=" p-3 border border" style="width: 19rem;">
                    <div class="row">
                        <div class="col-3">
                            <i class="shipping fast text-blue fs-1 icon"></i>
                        </div>
                        <div class="col-9">
                            <h6 class="fw-bold">Fast Delivery</h6>
                            <span>Get your product within 2 days</span>
                        </div>
                    </div>
                </div>
                <!-- card -->
                <!-- card 2 -->
                <div class=" p-3 border border" style="width: 19rem;">
                    <div class="row">
                        <div class="col-3">
                            <i class="undo fs-1 icon text-blue"></i>
                        </div>
                        <div class="col-9">
                            <h6 class="fw-bold">Easy Returns</h6>
                            <span>Return policy that lets you shop at ease</span>
                        </div>
                    </div>
                </div>
                <!-- card -->
                <!-- card 3 -->
                <div class=" p-3 border border" style="width: 19rem;">
                    <div class="row">
                        <div class="col-3">
                            <i class="shield alternate fs-1 icon text-blue"></i>
                        </div>
                        <div class="col-9">
                            <h6 class="fw-bold">Fast Delivery</h6>
                            <span>Get your product within 2 days</span>
                        </div>
                    </div>
                </div>
                <!-- card -->
                <!-- card 4 -->
                <div class=" p-3 border border" style="width: 19rem;">
                    <div class="row">
                        <div class="col-3">
                            <i class="lock icon fs-1 text-blue"></i>
                        </div>
                        <div class="col-9">
                            <h6 class="fw-bold">Fast Delivery</h6>
                            <span>Get your product within 2 days</span>
                        </div>
                    </div>
                </div>
                <!-- card -->
            </div>
        </div>

    </div>

    </div>


    <?php include "footer.php" ?>

    <script src="script.js"></script>
    <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
</body>

</html>