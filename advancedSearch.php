<?php
session_start();
include_once "connection.php";
?>
<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        Advanced Search | ToyShop
    </title>
    <link rel="icon" type="image/png" href="resource/logo.png">

    <link rel="stylesheet" href="bootstrap.css" />
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

<body id="bd">
    <?php include "header.php" ?>
    <div class="container-lg">
        <div class="row px-3 py-2">
            <div class="col-12 mb-3 border-bottom pb-2">
                <div class="row d-flex align-items-center justify-content-center gap-2">
                    <!-- logo block -->
                    <a href="home.php" class="col-md-1 d-flex justify-content-center align-items-center ">
                        <img src="resource/logo.png" class="object-fit-contain" alt="logo">
                        <h1 class="logo-text d-md-none">Toy Shop</h1>
                    </a>
                    <!-- logo block -->
                    <div class="col d-flex flex-column flex-md-row gap-2">
                        <h2>Advanced Search</h2>
                    </div>
                </div>
            </div>
            <!-- bread crumb -->
            <div class="ui breadcrumb">
                <a href="home.php" class="section">ToyShop</a>
                <i class="right angle icon divider"></i>
                <div class="active section mt-2">
                    Advanced Search
                </div>
            </div>
            <!-- bread crumb -->
            <div class="col-12 mb-5">
                <div class="row justify-content-center">
                    <div class="col-11 col-md-8">
                        <div class="row">
                            <div class="col-12 border-bottom py-4 mb-3">
                                <h4 class="fw-bold">Find Toys</h4>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="" class="form-label fw-bold">Enter keywords</label>
                                    <input type="text" name="" id="keyword" class="form-control" placeholder="Type keyword here...">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <div class="mb-3">
                                    <label for="" class="form-label">In this category</label>
                                    <select class="form-select" id="category-id">
                                        <option value="0">All Categories</option>
                                        <?php
                                        $category_result = Database::execute("SELECT * FROM `category`");
                                        while ($category = $category_result->fetch_assoc()) {
                                            ?>
                                            <option value="<?php echo $category["category_id"]; ?>">
                                                <?php echo $category["category_name"]; ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Price -->
                            <div class="col-12 mb-2"><b>Price</b></div>
                            <div class="col-12 mb-3">
                                <div class="form-check mb-3"> 
                                    <input class="form-check-input" type="radio" name="price" onchange="toggleActivePriceFilter(1)"
                                        id="price1" checked>
                                    <label class="form-check-label" for="price1">
                                        Price Low to high
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="price" onchange="toggleActivePriceFilter(2)"
                                        id="price2" >
                                    <label class="form-check-label" for="price2">
                                        Price high to low
                                    </label>
                                </div>
                                <div class="form-check mb-3 d-flex align-items-center gap-2">
                                    <input class="form-check-input" type="radio" name="price" onchange="toggleActivePriceFilter(3)"
                                        id="price3" >
                                    <div class="form-check-label d-flex align-items-center gap-2"
                                        for="price3">
                                        <label for="price3">Price between</label>
                                        <input type="number" name="" id="price-min" min="0" style="max-width:10rem"
                                            class="form-control" placeholder="min price" value="0" disabled>
                                        <span>and</span>
                                        <input type="number" name="" id="price-max" min="1000" class="form-control" 
                                            style="max-width:10rem" placeholder="max price" value="0" disabled>
                                    </div>
                                </div>
                            </div>

                            <!-- condition -->
                            <div class="col-12 mb-2"><b>Condition</b></div>
                            <div class="col-12 mb-3">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="cond" 
                                        id="cond1">
                                    <label class="form-check-label" for="cond1">
                                        Brand New
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="cond" 
                                        id="cond2">
                                    <label class="form-check-label" for="cond2">
                                        Used
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="cond" 
                                        id="cond3" >
                                    <label class="form-check-label" for="cond3">
                                        Unbranded
                                    </label>
                                </div>
                            </div>
                            <!--  -->
                            <div class="col-12 mb-2"><b>Results per page</b></div>
                            <div class="col-12 mb-3">
                                <input type="number" name="" id="no-of-results" min="10" class="form-control" style="max-width:10rem"
                                    value="20">
                            </div>
                            <!--  -->
                            <div class="col-6 mb-2">
                                <button onclick="searchAdvanced();" class="ui right button primary w-100">Search</button>
                            </div>
                            <div class="col-6 mb-2">
                                <button class="ui right button  w-100" onclick="window.location.reload();">Clear options</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <?php include "footer.php" ?>

    <script src="script.js"></script>
</body>

</html>