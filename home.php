<?php
session_start();
include_once "connection.php";
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home | ToyShop</title>
    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="icon" type="image/png" href="resource/logo.png">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- jQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- jQuery CDN -->

    <!-- Semantic UI CDN -->
    <script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.5.0/dist/semantic.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.5.0/dist/semantic.min.css">
    <!-- Semantic UI CDN -->
</head>

<body class="m-0" id="bd">
    <video class="position-fixed z-n1 vh-100 " autoplay loop muted preload="auto" style="object-fit: cover; width:100%;;">
        <source src="resource/Welcome2.mp4">
    </video>
    <div class="bg-dark d-flex">
        <span class="text-white text-center w-100">WELCOME TO OUT STORE</span>
    </div>
    <!-- page header -->
    <?php include "header.php" ?>
    <!-- page header -->

    <!-- search bar -->
    <?php include "searchbar.php" ?>
    <!-- search bar -->

    <!-- content -->  
    <div class="row pb-3 justify-content-center" >
            <div class="col-12 col-sm-11">
                
                <!-- carousal -->
                
                <div id="carouselExampleFade"  class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                        <img src="resource/carousel/5.svg"style="max-height:44rem;object-fit:cover" class="d-block w-100 img-thumbnail rounded-5" alt="">
                        </div>
                        <div class="carousel-item">
                        <img src="resource/carousel/4.svg"style="max-height:44rem;object-fit:cover" class="d-block w-100 img-thumbnail rounded-5" alt="">
                        </div>
                        <div class="carousel-item">
                        <img src="resource/carousel/3.svg"style="max-height:44rem;object-fit:cover" class="d-block w-100 img-thumbnail rounded-5" alt="">
                        </div>
                        <div class="carousel-item">
                        <img src="resource/carousel/2.svg"style="max-height:44rem;object-fit:cover" class="d-block w-100 img-thumbnail rounded-5" alt="">
                        </div>
                        <div class="carousel-item">
                        <img src="resource/carousel/1.svg"style="max-height:44rem;object-fit:cover" class="d-block w-100 img-thumbnail rounded-5" alt="">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                <!-- carousal -->
            </div>
        </div>
    <div class="container-xl py-2 rounded-5 bg-light bg-opacity-75 mb-2">
      

<!-- categories -->
        <div class="row pb-3 my-2  py-3 border   bg-light bg-opacity-75 mx-sm-1 rounded-5">
            <div class="col-12">
                <h4 class="fw-bold">Featured Categories</h4>
            </div>
            <div class="col-12">
                <div class="row justify-content-center gy-4 p-2  d-none d-sm-flex">
                    <?php
                    $category_result = Database::execute("SELECT * FROM `category` INNER JOIN `category_image` on 
                    category.category_id = category_image.category_category_id WHERE `status_status_id`='1' ");

                    while ($category_data = $category_result->fetch_assoc()) {
                        ?>
                        <!-- card -->
                        <a href="loadProducts.php?cat=<?php echo $category_data["category_id"] ?>"
                            class="d-flex flex-column align-items-center gap-2 text-decoration-none header-link"
                            style="width:14rem;">
                            <img src="<?php echo $category_data["image_path"] ?>"
                                class="card-img-top   rounded-circle img-thumbnail"
                                style="height: 170px; width:170px; object-fit:contain;" alt="...">
                            <div class="card-body">
                                <h6 class="card-title fw-bold">
                                    <?php echo $category_data["category_name"] ?>
                                </h6>
                            </div>
                        </a>
                        <!-- card -->
                        <?php
                    }
                    ?>
                </div>
                <div class="row justify-content-center gy-4 p-2 d-sm-none">
                    <?php
                    $category_result = Database::execute("SELECT * FROM `category` INNER JOIN `category_image` on 
                    category.category_id = category_image.category_category_id WHERE `status_status_id`='1' LIMIT 8");

                    while ($category_data = $category_result->fetch_assoc()) {
                        ?>
                        <!-- card -->
                        <a href="loadProducts.php?cat=<?php echo $category_data["category_id"] ?>"
                            class="d-flex flex-column align-items-center gap-2 text-decoration-none header-link"
                            style="width:7rem;">
                            <img src="<?php echo $category_data["image_path"] ?>"
                                class="card-img-top   rounded-circle img-thumbnail"
                                style=" object-fit:contain;" alt="...">
                            <div class="card-body">
                                <h6 class="card-title text-center fw-bold">
                                    <?php echo $category_data["category_name"] ?>
                                </h6>
                            </div>
                        </a>
                        <!-- card -->
                        <?php
                    }
                    ?>
                </div>

            </div>
        </div>
        <!-- categories end -->

        <div class="row mb-3 justify-content-center border py-3 bg-light bg-opacity-75 mt-3 mx-sm-1 rounded-5">
            <div class="col-12 mb-3">
                <h4 class="fw-bold">New Arrivals</h4>                
            </div>
            <div class="col-11">
                <div class="row justify-content-center gap-xxl-3 gap-3  gap-xl-1 d-none d-sm-flex">
                    <?php
                    $product_result = Database::execute("SELECT * FROM `active_product` ORDER BY `datetime_added` DESC LIMIT 12");

                    while ($product_data = $product_result->fetch_assoc()) {
                        $image_result = Database::execute("SELECT * FROM `product_image` WHERE
                        `product_product_id` = '" . $product_data["product_id"] . "' LIMIT 1 ");
                        $image_data = $image_result->fetch_assoc();
                        ?>
                        <!-- product card -->
                        <div class="card col-6 col-lg-2 p-1 position-relative" style="width: 18rem;">

                            <img src="resource/product_image/<?php echo $image_data["image_path"] ?>"
                                class="card-img-top product-image"
                                onclick='viewProduct(<?php echo $product_data["product_id"] ?>,"user");'
                                style="height:240px; object-fit:contain;" alt=" product-image">
                                <?php 
                                    if($product_data['quantity']==0){
                                        ?>
                                        <div class="bg-white bg-opacity-75 position-absolute d-flex justify-content-center h-100 w-100 end-0 align-items-center" 
                                        style="max-height:240px;"><span class="text-bg-warning px-3 shadow py-2">Out Of Stock!</span></div>                                    <?php
                                    }
                                ?>                                  
                               
                            <div class="card-body border-top mt-2">

                                <a class="card-title text-default curser-pointer"
                                    onclick='viewProduct(<?php echo $product_data["product_id"] ?>,"user");'>
                                    <?php echo $product_data["title"] ?>
                                </a>
                                <span class="ui  tag h-auto label ">
                                    <?php echo $product_data["condition_name"] ?>
                                </span><br>
                                <span class="card-text fs-3">Rs.
                                    <?php echo number_format($product_data["price"], 2) ?>
                                </span> <br>
                                <div class="d-flex">                                   
                                    <button <?php if($product_data['quantity']==0){?>disabled<?php } ?> onclick="addtoCart(<?php echo $product_data['product_id'] ?>,1);"
                                    class="ui button icon orange w-50"><i class=" shop icon"></i></button>
                                    <?php                                 
                                    
                                    if (isset($_SESSION["user"])) {
                                        $watchlist_result = Database::execute("SELECT * FROM `watchlist` WHERE `product_product_id` = '" . $product_data["product_id"] . "' 
                                    AND `user_email` = '" . $_SESSION["user"]["email"] . "'");
                                        if ($watchlist_result->num_rows == 1) {
                                            ?>
                                            <a onclick="toggleWatchList(<?php echo $product_data['product_id'] ?>)"
                                                class="ui button  secondary basic icon w-50" >
                                                <i class=" heart icon text-danger" id="heart-icon<?php echo  $product_data['product_id'] ?>"></i>
                                            </a>
                                            <?php
                                        } else {
                                            ?>
                                            <a onclick="toggleWatchList(<?php echo $product_data['product_id'] ?>)"
                                                class="ui button  secondary basic icon    w-50" >
                                                <i class=" heart icon" id="heart-icon<?php echo  $product_data['product_id'] ?>"></i>
                                            </a>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                            <a onclick="toggleWatchList(<?php echo $product_data['product_id'] ?>)"
                                                class="ui button icon secondary basic  w-50" >
                                                <i class=" heart icon" id="heart-icon<?php echo  $product_data['product_id'] ?>"></i>
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
                    ?>
                </div>

                <!-- mobile -->
                <div class="row justify-content-center gap-1 d-sm-none">
                    <?php
                    $product_result = Database::execute("SELECT * FROM `active_product` ORDER BY `datetime_added` DESC LIMIT 12");

                    while ($product_data = $product_result->fetch_assoc()) {
                        $image_result = Database::execute("SELECT * FROM `product_image` WHERE
                        `product_product_id` = '" . $product_data["product_id"] . "' LIMIT 1 ");
                        $image_data = $image_result->fetch_assoc();
                        ?>
                        <!-- product card -->
                        <div class="card col-6 col-lg-2 p-1 position-relative" style="width: 13rem;">

                            <img src="resource/product_image/<?php echo $image_data["image_path"] ?>"
                                class="card-img-top product-image"
                                onclick='viewProduct(<?php echo $product_data["product_id"] ?>,"user");'
                                style="height:160px; object-fit:contain;" alt=" product-image">
                                <?php 
                                    if($product_data['quantity']==0){
                                        ?>
                                        <div class="bg-white bg-opacity-75 position-absolute d-flex justify-content-center h-100 w-100 end-0 align-items-center" 
                                        style="max-height:240px;"><span class="text-bg-warning px-3 shadow py-2">Out Of Stock!</span></div>                                    <?php
                                    }
                                ?>                                  
                               
                            <div class="card-body border-top mt-2">

                                <a class="card-title text-default curser-pointer"
                                    onclick='viewProduct(<?php echo $product_data["product_id"] ?>,"user");'>
                                    <?php echo $product_data["title"] ?>
                                </a>
                                <span class="ui  tag h-auto label ">
                                    <?php echo $product_data["condition_name"] ?>
                                </span><br>
                                <span class="card-text fs-3">Rs.
                                    <?php echo number_format($product_data["price"], 2) ?>
                                </span> <br>
                                <div class="d-flex align-items-center">                                   
                                    <button <?php if($product_data['quantity']==0){?>disabled<?php } ?> onclick="addtoCart(<?php echo $product_data['product_id'] ?>,1);"
                                    class="ui button small icon orange w-50"><i class=" shop icon"></i></button>
                                    <?php                                 
                                    
                                    if (isset($_SESSION["user"])) {
                                        $watchlist_result = Database::execute("SELECT * FROM `watchlist` WHERE `product_product_id` = '" . $product_data["product_id"] . "' 
                                    AND `user_email` = '" . $_SESSION["user"]["email"] . "'");
                                        if ($watchlist_result->num_rows == 1) {
                                            ?>
                                            <a onclick="toggleWatchList(<?php echo $product_data['product_id'] ?>)"
                                                class="ui button small secondary basic icon w-50" >
                                                <i class=" heart icon text-danger" id="heart-icon<?php echo  $product_data['product_id'] ?>"></i>
                                            </a>
                                            <?php
                                        } else {
                                            ?>
                                            <a onclick="toggleWatchList(<?php echo $product_data['product_id'] ?>)"
                                                class="ui button small secondary basic icon    w-50" >
                                                <i class=" heart icon" id="heart-icon<?php echo  $product_data['product_id'] ?>"></i>
                                            </a>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                            <a onclick="toggleWatchList(<?php echo $product_data['product_id'] ?>)"
                                                class="ui button icon secondary basic  w-50" >
                                                <i class=" heart icon" id="heart-icon<?php echo  $product_data['product_id'] ?>"></i>
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
                    ?>
                </div>


            </div>
        </div>
    </div>
    <!-- content -->

    <!-- footer -->
    <?php include "footer.php"; ?>
    <!-- footer -->

</body>

</html>