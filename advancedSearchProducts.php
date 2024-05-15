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
    <!-- page header -->
    <?php include "header.php" ?>
    <!-- page header -->

    <!-- search bar -->
    <?php include "searchbar.php" ?>
    <!-- search bar -->

    <!-- content -->
    <div class="container-xl py-3">
        <div class="row pb-3">
            <div class="col-12 ">
                <?php

                $key = "";
                $category = "";
                $cat = "";
                $sortOption = "";
                $price_sort = "";
                $sort = "";
                $cond = "";
                $no_of_results = 20;
                $priceRange = "";
                $max_price = 0;
                $min_price = 0;

                if(isset($_GET["cat"]) && $_GET["cat"]!=0 && $_GET["cat"]!=""){
                    $cat = "AND `category_id` = '" . $_GET["cat"] . "'";
                    $category = $_GET["cat"];
                }

                if(isset($_GET["key"])){
                    $key = $_GET["key"];
                }
                if(isset($_GET["price_sort"]) && $_GET["price_sort"] != 0 && $_GET["price_sort"] != ""){
                    $price_sort = $_GET["price_sort"];
                    if($_GET["price_sort"] == "range"){
                        if(isset($_GET["min_price"]) && isset($_GET["max_price"]) && $_GET["min_price"] != "" && $_GET["max_price"] != ""){
                            $max_price = $_GET["max_price"];
                            $min_price = $_GET["min_price"];
                            $priceRange = " AND `price` BETWEEN ".$_GET["min_price"]." AND ".$_GET["max_price"]." ";
                        }else{
                            ?>
                            <script>
                                alert("Price filter could not perform");
                            </script>
                            <?php
                        }
                        
                    }else{
                        $order = "ASC";

                        if($_GET["price_sort"] == "ASC"){
                            $sort = "Price lowest first ";
                        }else{
                            $sort = "Price heighest first ";
                            $order = "DESC";
                        }     

                        $sortOption = " ORDER BY `price` ".$order." ";
                    }
                   
                }
                    
                if(isset($_GET["cond"]) && $_GET["cond"] != 0 && $_GET["cond"] != "" ){
                   
                    $cond = $_GET["cond"];
                    if($cond == "Any Condition"){
                        $cond = "";
                    }
                }
             
                    ?>
                    <div class="active section mt-2">Advanced search results
                    </div>
                </div>
                <!-- bread crumb -->
                <?php
                $page_no = 1;
                $product_per_page = 20;

                if(isset($_GET["page"]) && !empty($_GET["page"])){
                    $page_no = $_GET["page"];
                }

                if(isset($_GET["no_of_results"]) && !empty($_GET["no_of_results"])){
                    $product_per_page = $_GET["no_of_results"];
                }
                $all_products = Database::execute("SELECT * FROM `active_product` WHERE `title` LIKE '%" . $key . "%' $cat  
                AND `condition_name` LIKE '%" . $cond . "%' $priceRange $sortOption");
                $number_of_pages = ceil($all_products->num_rows/$product_per_page);
                

                $product_result = Database::execute("SELECT * FROM `active_product` WHERE `title` LIKE '%" . $key . "%' $cat  
                AND `condition_name` LIKE '%" . $cond . "%' $priceRange $sortOption LIMIT $product_per_page OFFSET ".(($page_no-1)*$product_per_page)."");

                ?>
                <!-- filter options -->
                <div class="row border-bottom mb-3 py-3 gap-2 gap-lg-0 align-items-center">
                    <div class="col-12 col-lg-3">
                        <span class="fw-bold">
                            <?php echo $all_products->num_rows . " products found" ?>
                        </span>
                    </div>
                    <div class="col-12 col-lg-9 d-flex flex-column flex-md-row gap-2 justify-content-end">
                        <div class="d-flex flex-column flex-sm-row gap-2">                            
                            <select class="form-select rounded-5" name="" id="condition-select" 
                            onchange="filterConditionAdvancedSearch('<?php echo $key ?>','<?php echo $category ?>','<?php echo $price_sort ?>',
                            '<?php echo $max_price ?>','<?php echo $min_price ?>','<?php echo $cond ?>','<?php echo $product_per_page ?>','<?php echo $page_no ?>');">
                                <option <?php if($cond == ""){ ?>selected<?php } ?> value="Any Condition">Any Condition</option>
                                <option <?php if($cond == "Brand New"){ ?>selected<?php } ?> value="Brand New">Brand New</option>
                                <option <?php if($cond == "Used"){ ?>selected<?php } ?> value="Used">Used</option>
                                <option <?php if($cond == "Unbranded"){ ?>selected<?php } ?> value="Unbranded">Unbranded</option>
                            </select>                          
                            
                            <select class="form-select rounded-5" style="min-width:15rem;" name="" id="price-range-select"
                            onchange="filterPriceAdvancedSearch('<?php echo $key ?>','<?php echo $category ?>','<?php echo $price_sort ?>',
                            '<?php echo $max_price ?>','<?php echo $min_price ?>','<?php echo $cond ?>','<?php echo $product_per_page ?>','<?php echo $page_no ?>');">
                                <option value="All prices">All prices</option>
                                <option value="Under Rs.2000">Under Rs.2000</option>
                                <option value="Rs.2000 to Rs.10,000">Rs.2000 to Rs.10,000</option>
                                <option value="Over Rs.10,000">Over Rs.10,000</option>
                            </select>

                            <select class="form-select rounded-5" style="min-width:15rem;" name="" id="order-select"
                            onchange="filterOrderAdvancedSearch('<?php echo $key ?>','<?php echo $category ?>','<?php echo $price_sort ?>',
                            '<?php echo $max_price ?>','<?php echo $min_price ?>','<?php echo $cond ?>','<?php echo $product_per_page ?>','<?php echo $page_no ?>');">
                                <option value="Price heighest first">Price heighest first</option>
                                <option value="Price lowest first">Price lowest first</option>                                
                            </select>
                        </div>               

                    </div>
                </div>
                <!-- filter options -->
                <div class="row gap-3 justify-content-center px-lg-5  mb-3">
                    <?php

                    if ($product_result->num_rows == 0) {
                        ?>
                        <p class="text-secondary">No products yet</p>
                        <img src="resource/emptySearch.jpg" style="width:20rem" alt="">
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
                            if ($product_data['quantity'] == 0) {
                                ?>
                                <div class="bg-white bg-opacity-75 position-absolute d-flex justify-content-center h-100 w-100 end-0 align-items-center"
                                    style="max-height:240px;"><span class="text-bg-warning px-3 shadow py-2">Out Of Stock!</span>
                                </div>
                                <?php
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

            </div>
        </div>
        <?php 
        if ($product_result->num_rows != 0) {
        ?>
        <div class="col-12 mb-3 gap-2 d-flex justify-content-center align-items-center">            
            <select class="form-select w-auto" name="" id="results-per-page" 
            onchange="changeResultsPerPage('<?php echo $_GET['key'] ?>',<?php echo $_GET['cat'] ?>,'<?php echo $_GET['price_sort'] ?>',
            <?php echo $_GET['max_price'] ?>,<?php echo $_GET['min_price'] ?>,'<?php echo $_GET['cond'] ?>',<?php echo $page_no ?>)">
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
                                                <a onclick="advancedSearchPaginationTransition('<?php echo $_GET['key'] ?>',<?php echo $_GET['cat'] ?>,'<?php echo $_GET['price_sort'] ?>',
                                                        <?php echo $_GET['max_price'] ?>,<?php echo $_GET['min_price'] ?>,'<?php echo $_GET['cond'] ?>',<?php echo $_GET['no_of_results'] ?>,<?php echo $page_no-1 ?>)"
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
                                                        onclick="advancedSearchPaginationTransition('<?php echo $_GET['key'] ?>',<?php echo $_GET['cat'] ?>,'<?php echo $_GET['price_sort'] ?>',
                                                        <?php echo $_GET['max_price'] ?>,<?php echo $_GET['min_price'] ?>,'<?php echo $_GET['cond'] ?>',<?php echo $_GET['no_of_results'] ?>,<?php echo $i ?>)"
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
                                                    <a onclick="advancedSearchPaginationTransition('<?php echo $_GET['key'] ?>',<?php echo $_GET['cat'] ?>,'<?php echo $_GET['price_sort'] ?>',
                                                        <?php echo $_GET['max_price'] ?>,<?php echo $_GET['min_price'] ?>,'<?php echo $_GET['cond'] ?>',<?php echo $_GET['no_of_results'] ?>,<?php echo $page_no+1 ?>)"
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
    </div>

    <!-- footer -->
    <?php include "footer.php"; ?>
    <!-- footer -->

    <script src="script.js"></script>
</body>

</html>