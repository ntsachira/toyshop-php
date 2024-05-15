<?php
session_start();
include_once 'connection.php';

if (isset($_GET["cat"])) {
    $category = "";
    $product_result;
    $title; // holds the document header title
    $search_state; // holds the search state (Search states - key="" & cat=0 , key!="" & cat=0, like that...)

    if ($_GET["cat"] != "0") {
        $category = $_GET["cat"];
        $category_result = Database::execute("SELECT * FROM `category` WHERE category_id = '" . $_GET["cat"] . "'");
        $category_data = $category_result->fetch_assoc();

        if (isset($_GET["key"])) {
            $title = $_GET["key"] . " in " . $category_data["category_name"] . " for sale";
            $search_state = 3;
        } else {
            $title = $category_data["category_name"] . " for sale | ToyShop";
            $search_state = 1;
        }
    } else {
        if (isset($_GET["key"])) {
            $title = $_GET["key"] . " for sale";
            $search_state = 2;
        } else {
            $title = "Shop by Category | ToyShop";
            $search_state = 0;
        }
    }

    $cond = "";
    $price = "";
    $sort = "";

    $condition = "";
    $priceRange = "";
    $sortOption = "";

    if (isset($_GET['cond'])) {
        $cond = "&cond=" . $_GET["cond"];
        if ($_GET["cond"] != "Any Condition") {
            $condition = $_GET["cond"];
        }

    }
    if (isset($_GET["price"])) {
        $price = "&price=" . $_GET["price"];

        if ($_GET["price"] == "Under Rs.2000") {
            $priceRange = "AND `price` <= '2000' ";
        } else if ($_GET["price"] == "Rs.2000 to Rs.10,000") {
            $priceRange = "AND `price` BETWEEN '2000'AND'10000' ";
        } else if ($_GET["price"] == "Over Rs.10,000") {
            $priceRange = "AND `price` >= '10000' ";
        }
    }
    if (isset($_GET["sort"])) {
        $sort = "&sort=" . $_GET["sort"];

        if ($_GET["sort"] == "Newly added") {
            $sortOption = "ORDER BY `datetime_added` DESC ";
        } else if ($_GET["sort"] == "Price lowest first First") {
            $sortOption = "ORDER BY `price` ASC ";
        } else if ($_GET["sort"] == "Price highest first First") {
            $sortOption = "ORDER BY `price` DESC ";
        }
    }

    $page_no = 1;
    if(isset($_GET["page"])){
        $page_no = $_GET["page"];
    }
    $number_of_pages = 1;
    $product_per_page = 20;
    if(isset($_GET["no_of_results"]) && filter_var($_GET["no_of_results"],FILTER_VALIDATE_INT)){
        $product_per_page = $_GET["no_of_results"];
    }
    ?>
    <!DOCTYPE html>

    <html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>
            <?php echo $title ?>
        </title>
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

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    </head>

    <body id="bd">
<video class="position-fixed z-n1 vh-100 " autoplay loop muted preload="auto" style="object-fit: cover; width:100%;;">
        <source src="resource/Welcome2.mp4">
    </video>
        <?php
        include 'header.php';
        include 'searchBar.php';
        ?>
        <div class="container-xl bg-light pb-2 mb-2 rounded-4" >
            <!-- bread crumb -->
            <div class="ui breadcrumb my-2">
                <a href="home.php" class="section">ToyShop</a>
                <i class="right angle icon divider"></i>

                <?php
                if ($search_state == 0) { //* load all categories
                    ?>
                    <div class="active section mt-2">
                        All categories
                    </div>
                </div>
                <!-- bread crumb -->
                <?php
                $category_result = Database::execute("SELECT * FROM `category` WHERE `status_status_id`='1'");
                while ($category_data = $category_result->fetch_assoc()) {
                    ?>
                    <!-- category row -->
                    <div class="row  p-3 pb-4 px-xl-0 border-bottom mb-3">
                        <div class="col-12 mb-3">
                            <h4 class="fw-bold">
                                <?php echo $category_data["category_name"] ?>
                            </h4>
                            <a href="?cat=<?php echo $category_data['category_id'] ?>" class="text-decoration-none">See More <i
                                    class="fa-solid fa-arrow-right"></i></a>
                        </div>
                        <div class="col-12">
                            <div class="row gap-2 justify-content-center ">
                                <?php
                                $product_result = Database::execute("SELECT * FROM `active_product` WHERE `category_id`='" . $category_data["category_id"] . "'  LIMIT 5");
                                if ($product_result->num_rows == 0) {
                                    ?>
                                    <p class="text-secondary">No products yet</p>
                                    <?php
                                }

                                while ($product_data = $product_result->fetch_assoc()) {
                                    $image_result = Database::execute("SELECT * FROM `product_image` WHERE
                        `product_product_id` = '" . $product_data["product_id"] . "' LIMIT 1 ");
                                    $image_data = $image_result->fetch_assoc();
                                    ?>
                                    <!-- product card -->
                                    <div class="card col-6 col-lg-2 p-1" style="width: 18rem;">

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
                                                <button class="ui button icon orange  w-50"  <?php if($product_data['quantity']==0){?>disabled<?php } ?> 
                                                onclick="addtoCart(<?php echo $product_data['product_id'] ?>,1);"><i class=" shop icon"></i></button>
                                                <?php
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
                                                            class="ui button basic icon secondary w-50">
                                                            <i class=" heart icon"
                                                                id="heart-icon<?php echo $product_data['product_id'] ?>"></i>
                                                        </a>
                                                        <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <a onclick="toggleWatchList(<?php echo $product_data['product_id'] ?>)"
                                                        class="ui button basic secondary icon w-50">
                                                        <i class=" heart icon"
                                                            id="heart-icon<?php echo $product_data['product_id'] ?>"></i>
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
                    <!-- category row -->
                    <?php
                }
                } else if ($search_state == 1) { //* search by category
                    $product_result = Database::execute("SELECT * FROM `active_product` WHERE `category_id` = '" . $_GET['cat'] . "'");

                    $product_num = $product_result->num_rows;
                    ?>
                    <div class="active section mt-2">
                    <?php echo $category_data['category_name'] ?>
                    </div>
                </div>
                <!-- bread crumb -->

                <!-- category banner -->
                <div class="row p-3 bg-blue my-3 mx-0 mx-md-2 mb-4 rounded-3">
                    <div class="col-12 d-flex justify-content-between">
                        <div>
                            <h1 class="text-white fw-bold">
                            <?php echo $category_data['category_name'] ?>
                            </h1>
                            <h4 class="text-white fw-bold">Whether it's rare, retro, or right-now, the perfect toy is here.</h4>
                        </div>

                        <?php
                        $category_result = Database::execute("SELECT * FROM `category_image` WHERE category_category_id = '" . $category_data["category_id"] . "' ");
                        $category_data = $category_result->fetch_assoc();
                        ?>
                        <img src="<?php echo $category_data["image_path"] ?>" class="rounded-3"
                            style="max-height:10rem;object-fit:cover" alt="">
                    </div>
                </div>
                <!-- category banner -->
                <div class="col-12 mb-3">
                    <span class="fw-bold">
                    <?php echo $product_result->num_rows . " products found" ?>
                    </span>
                </div>
                <div class="row gap-2 justify-content-center mb-3">
                    <?php
                    $products1 = Database::execute("SELECT * FROM `active_product` WHERE `category_id`='" . $category_data["category_category_id"] . "'");
                    $number_of_pages = ceil($products1->num_rows/$product_per_page);

                    $product_result = Database::execute("SELECT * FROM `active_product` WHERE `category_id`='" . $category_data["category_category_id"] . "'  
                    LIMIT $product_per_page OFFSET ".(($page_no-1)*$product_per_page)."");
                    if ($product_result->num_rows == 0) {
                        ?>
                        <p class="text-secondary">No products yet</p>
                    <?php
                    }

                    while ($product_data = $product_result->fetch_assoc()) {
                        $image_result = Database::execute("SELECT * FROM `product_image` WHERE
                        `product_product_id` = '" . $product_data["product_id"] . "' LIMIT 1 ");
                        $image_data = $image_result->fetch_assoc();
                        ?>
                        <!-- product card -->
                        <div class="card col-6 col-lg-2 p-1" style="width: 18rem;">

                            <img src="resource/product_image/<?php echo $image_data["image_path"] ?>" class="card-img-top product-image"
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
                                <div class="d-flex ">
                                    <button class="ui button icon orange  w-50" <?php if($product_data['quantity']==0){?>disabled<?php } ?> 
                                    onclick="addtoCart(<?php echo $product_data['product_id'] ?>,1);"><i class=" shop icon"></i></button>
                                    <?php
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
                                            class="ui button basic secondary w-50">
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
                    ?>
                </div>
            <?php

                } else if ($search_state == 2) { //* search state 2 -  Have only a key 
            
                    ?>
                    <div class="active section mt-2">Results for
                        "
                <?php echo $_GET['key'] ?>"
                    </div>
                    </div>
                    <!-- bread crumb -->
                <?php
                $products2 = Database::execute("SELECT * FROM `active_product` WHERE `title` LIKE '%" . $_GET["key"] . "%' 
                AND `condition_name` LIKE '%" . $condition . "%' $priceRange $sortOption");
                
                $number_of_pages = ceil($products2->num_rows/$product_per_page);
                ?>
                    <!-- filter options -->
                    <div class="row border-bottom mb-3 py-3 gap-2 gap-lg-0 align-items-center">
                        <div class="col-12 col-lg-3">
                            <span class="fw-bold">
                        <?php echo $products2->num_rows . " products found" ?>
                            </span>
                        </div>
                        <?php
                $product_result = Database::execute("SELECT * FROM `active_product` WHERE `title` LIKE '%" . $_GET["key"] . "%' 
                AND `condition_name` LIKE '%" . $condition . "%' $priceRange $sortOption LIMIT $product_per_page OFFSET ".(($page_no-1)*$product_per_page)."");

                ?>

                        <div class="col-12 col-lg-9 d-flex flex-column flex-md-row gap-2 justify-content-end">
                            <div class="d-flex flex-column flex-sm-row gap-2">
                                <div style="min-width:10rem" id="condition-drop"
                                    uri="?cat=<?php echo $cat_id . "&key=" . $key . $cond . $price . $sort ?>"
                                    class="ui col inline dropdown button basic rounded-5 d-flex justify-content-between align-items-center gap-2">
                                    <div class="text">
                                <?php echo isset($_GET['cond']) && $_GET['cond'] != "" ? $_GET['cond'] : "Condition" ?>
                                    </div>
                                    <i class="dropdown icon"></i>
                                    <div class="menu">
                                        <div class="item" data-text="Any Condition">Any Condition</div>
                                        <div class="item" data-text="Brand New">Brand New</div>
                                        <div class="item" data-text="Used">Used</div>
                                        <div class="item" data-text="Unbranded">Unbranded</div>
                                    </div>
                                </div>
                                <div style="min-width:15rem" uri="?cat=<?php echo $cat_id . "&key=" . $key . $cond . $price . $sort ?>"
                                    id="price-drop"
                                    class="ui col inline dropdown button basic text-center d-flex justify-content-between align-items-center gap-2 rounded-5">
                                    <div class="text">
                                <?php echo isset($_GET['price'])&& $_GET['price'] != "" ? $_GET['price'] : "Price" ?>
                                    </div>
                                    <i class="dropdown icon"></i>
                                    <div class="menu">
                                        <div class="item" data-text="All prices">All prices</div>
                                        <div class="item" data-text="Under Rs.2000">Under Rs.2000</div>
                                        <div class="item" data-text="Rs.2000 to Rs.10,000">Rs.2000 to Rs.10,000</div>
                                        <div class="item" data-text="Over Rs.10,000">Over Rs.10,000</div>
                                    </div>
                                </div>
                            </div>
                            <div class="content ui button basic rounded-5 ">
                                Sort :
                                <div class="ui inline dropdown"
                                    uri="?cat=<?php echo $cat_id . "&key=" . $key . $cond . $price . $sort ?>" id='sort-drop'>
                                    <div class="text">
                                <?php echo isset($_GET['sort']) && $_GET['sort'] != ""? $_GET['sort'] : "Newly added" ?>
                                    </div>
                                    <i class="dropdown icon"></i>
                                    <div class="menu">
                                        <div class="item" data-text="Newly added">Newly added</div>
                                        <div class="item" data-text="Price lowest first First">Price lowest first First</div>
                                        <div class="item" data-text="Price highest first First">Price highest first First</div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- filter options -->
                    <div class="row gap-2 justify-content-center px-lg-5  mb-3">
                    <?php

                    if ($product_result->num_rows == 0) {
                        ?>
                            <p class="text-secondary">No products yet</p>
                    <?php
                    }


                    while ($product_data = $product_result->fetch_assoc()) {
                        $image_result = Database::execute("SELECT * FROM `product_image` WHERE
                        `product_product_id` = '" . $product_data["product_id"] . "' LIMIT 1 ");
                        $image_data = $image_result->fetch_assoc();
                        ?>
                            <!-- product card -->
                            <div class="card col-6 col-lg-2 p-1" style="width: 18rem;">

                                <img src="resource/product_image/<?php echo $image_data["image_path"] ?>" class="card-img-top product-image"
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
                    ?>
                    </div>

            <?php
                } else if ($search_state == 3) { //** search state 3 - have both a key and category
            
                    ?>
                        <div class="active section mt-2">Results for
                            "
                <?php echo $_GET['key'] ?>"
                        </div>
                        </div>
                        <!-- bread crumb -->
                <?php
                $products3 = Database::execute("SELECT * FROM `active_product` WHERE `title` LIKE '%" . $_GET["key"] . "%' AND `category_id` = '" . $_GET['cat'] . "' 
                AND `condition_name` LIKE '%" . $condition . "%' $priceRange $sortOption");

                $number_of_pages = ceil($products3->num_rows/$product_per_page);
                ?>
                        <!-- filter options -->
                        <div class="row border-bottom mb-3 py-3 gap-2 gap-lg-0 align-items-center">
                            <div class="col-12 col-lg-3">
                                <span class="fw-bold">
                        <?php echo $products3->num_rows . " products found" ?>
                                </span>
                            </div>
                            <?php
                $product_result = Database::execute("SELECT * FROM `active_product` WHERE `title` LIKE '%" . $_GET["key"] . "%' AND `category_id` = '" . $_GET['cat'] . "' 
                AND `condition_name` LIKE '%" . $condition . "%' $priceRange $sortOption LIMIT $product_per_page OFFSET ".(($page_no-1)*$product_per_page)."");

                ?>
                            <div class="col-12 col-lg-9 d-flex flex-column flex-md-row gap-2 justify-content-end">
                                <div class="d-flex flex-column flex-sm-row gap-2">
                                    <div uri="?cat=<?php echo $cat_id . "&key=" . $key . $cond . $price . $sort ?>" id='condition-drop'
                                        style="min-width:10rem"
                                        class="ui col inline dropdown button basic rounded-5 d-flex justify-content-between align-items-center gap-2">
                                        <div class="text">
                                <?php echo isset($_GET['cond']) && $_GET['cond'] != ""? $_GET['cond'] : "Condition" ?>
                                        </div>
                                        <i class="dropdown icon"></i>
                                        <div class="menu">
                                            <div class="item" data-text="Any Condition">Any Condition</div>
                                            <div class="active item" data-text="Brand New">Brand New</div>
                                            <div class="item" data-text="Used">Used</div>
                                            <div class="item" data-text="Unbranded">Unbranded</div>
                                        </div>
                                    </div>
                                    <div uri="?cat=<?php echo $cat_id . "&key=" . $key . $cond . $price . $sort ?>" id='price-drop'
                                        style="min-width:15rem"
                                        class="ui col inline dropdown button basic text-center d-flex justify-content-between align-items-center gap-2 rounded-5">
                                        <div class="text">
                                <?php echo isset($_GET['price'])  && $_GET['price'] != "" ? $_GET['price'] : "Price" ?>
                                        </div>
                                        <i class="dropdown icon"></i>
                                        <div class="menu">
                                            <div class="active item" data-text="All prices">All prices</div>
                                            <div class="item" data-text="Under Rs.2000">Under Rs.2000</div>
                                            <div class="item" data-text="Rs.2000 to Rs.10,000">Rs.2000 to Rs.10,000</div>
                                            <div class="item" data-text="Over Rs.10,000">Over Rs.10,000</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="content ui button basic rounded-5 ">
                                    Sort :
                                    <div class="ui inline dropdown"
                                        uri="?cat=<?php echo $cat_id . "&key=" . $key . $cond . $price . $sort ?>" id='sort-drop'>
                                        <div class="text">
                                <?php echo isset($_GET['sort']) && $_GET['sort'] != "" ? $_GET['sort'] : "Newly added" ?>
                                        </div>
                                        <i class="dropdown icon"></i>
                                        <div class="menu">
                                            <div class="active item" data-text="Newly added">Newly added</div>
                                            <div class="item" data-text="Price lowest first First">Price lowest first First</div>
                                            <div class="item" data-text="Price highest first First">Price highest first First</div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- filter options -->
                        <div class="row gap-2 justify-content-center px-lg-5  mb-3">
                    <?php

                    if ($product_result->num_rows == 0) {
                        ?>
                                <p class="text-secondary">No products yet</p>
                    <?php
                    }


                    while ($product_data = $product_result->fetch_assoc()) {
                        $image_result = Database::execute("SELECT * FROM `product_image` WHERE
                        `product_product_id` = '" . $product_data["product_id"] . "' LIMIT 1 ");
                        $image_data = $image_result->fetch_assoc();
                        ?>
                                <!-- product card -->
                                <div class="card col-6 col-lg-2 p-1" style="width: 18rem;">

                                    <img src="resource/product_image/<?php echo $image_data["image_path"] ?>" class="card-img-top product-image"
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
                                        <div class="d-flex ">
                                            <button <?php if ($product_data['quantity'] == 0) { ?>disabled<?php } ?>
                                                onclick="addtoCart(<?php echo $product_data['product_id'] ?>,1);"
                                                class="ui button icon orange w-50"><i class=" shop icon"></i></button>
                                    <?php
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
                    ?>
                        </div>

            <?php
                }
                ?>

        </div>
        <?php 
        if($search_state >= 1){
?>
<div class="col-12 mb-3 gap-2 d-flex justify-content-center align-items-center">            
            <select class="form-select w-auto" name="" id="results-per-page" 
            onchange="changeResultsPerPageGeneral(<?php echo $cat_id ?>,'<?php echo $key ?>','<?php echo $cond ?>','<?php echo $price ?>','<?php echo $sort ?>',<?php echo $page_no?>)">
                <option><?php echo $product_per_page ?></option>
                <option value="8">8</option>
                <option value="16">16</option>
                <option value="24">24</option>
                <option value="32">32</option>
                <option value="40">40</option>
            </select>
            <label for="results-per-page">Products per page</label>
        </div>
         <!-- to review pagination -->
         <div class="col-12 d-flex justify-content-center">
                                    <nav aria-label="...">
                                        <ul class="pagination">
                                            <?php 
                                            if($page_no > 1){
                                                ?>
                                                <li class="page-item">
                                                <a onclick="searchPaginationTransitionGeneral(<?php echo $cat_id ?>,'<?php echo $key ?>',
                                                '<?php echo $cond ?>','<?php echo $price ?>','<?php echo $sort ?>',<?php echo $product_per_page ?>,<?php echo $page_no-1?>)"
                                                class="page-link"><i class="angle double left icon"></i></a>
                                                </li>
                                                <?php
                                            }else{
                                                ?>
                                                 <li class="page-item disabled">
                                                <span class="page-link"><i class="angle double left icon"></i></span>
                                                </li>
                                                <?php
                                            }
                                           
                                                for($i = 1; $i <= $number_of_pages; $i++){
                                                    if($page_no == $i){
                                                        ?>
                                                        <li class="page-item active" aria-current="page">
                                                        <span class="page-link"><?php echo $i ?></span>
                                                        </li>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <li class="page-item"><a class="page-link" 
                                                        onclick="searchPaginationTransitionGeneral(<?php echo $cat_id ?>,'<?php echo $key ?>','<?php echo $cond ?>',
                                                        '<?php echo $price ?>','<?php echo $sort ?>',<?php echo $product_per_page ?>,<?php echo $i ?>)"
                                                        ><?php echo $i ?></a></li>
                                                        <?php
                                                    }
                                                }
                                                if($page_no >= $number_of_pages){
                                                    ?>
                                                    <li class="page-item disabled">
                                                    <span class="page-link"><i class="angle double right icon"></i></span>
                                                    </li>
                                                    <?php
                                                }else{
                                                    ?>
                                                     <li class="page-item ">
                                                    <a onclick="searchPaginationTransitionGeneral(<?php echo $cat_id ?>,'<?php echo $key ?>',
                                                '<?php echo $cond ?>','<?php echo $price ?>','<?php echo $sort ?>',<?php echo $product_per_page ?>,<?php echo $page_no+1 ?>)"
                                                    class="page-link"><i class="angle double right icon"></i></a>
                                                    </li>
                                                    <?php
                                                }
                                            ?>                              
                                           
                                        </ul>
                                    </nav>
                                </div>
<?php
        }
        ?>
        

        <?php include "footer.php" ?>

        <script src="script.js"></script>
    </body>

    </html>
    <?php
} else {
    header('Location:home.php');
}

?>