<?php
session_start();
include_once "../connection.php";
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
}

if (isset($_GET['error'])) {
    ?>
    <script>
        alert("Something went wrong");        
    </script>
    <?php

}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title id="title">Toy Shop : Admin Pannel</title>
    <link rel="icon" type="image/png" href="../resource/logo.png">
    
    <link rel="stylesheet" href="../style.css">

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

<body>
    <div class="container-fluid bg-light">
        <div class="row ">

            <!-- sidebar -->
            <div class=" bg-white  position-absolute vh-100 pe-0" id="sidebar"
                style="width:15rem; overflow-x: hidden;overflow-y:scroll ;z-index: 50;">
                <div class="row  pe-0 m-0" style="width:15rem;">
                    <!-- logo block -->
                    <div class="col-7 border-bottom col-md-12 d-flex gap-3 py-2 align-items-center">
                        <img src="../resource/logo.png" style="height:3rem" class="" alt="logo">
                        <span class="fs-4 d-none d-md-block text-orange">Toy Shop</span>
                    </div>
                    <!-- logo block -->
                    <div class="col-5 border-bottom d-flex pe-2 d-md-none align-items-center">
                        <i class="close icon d-md-none curser-pointer" id="close-sidebar"></i>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12">
                                <a href="?tab=dashboard" class="row  gap-3 px-3 py-2 text-black tab-btn rounded-start"
                                    id="dashboard">
                                    <i class="tachometer alternate icon"></i>Dashboard</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <a href="?tab=myProducts" class="row gap-3 px-3 py-2 text-black tab-btn rounded-start"
                                    id="myproducts">
                                    <i class="briefcase icon"></i>Products</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <a href="?tab=orders" class="row gap-3 px-3 py-2 text-black tab-btn rounded-start"
                                    id="orders">
                                    <i class="box icon"></i>Orders<div style="width:3rem" class="d-flex ">
                                    </div></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <a href="?tab=customers" class="row gap-3 px-3 py-2 text-black tab-btn rounded-start"
                                    id="customers">
                                    <i class="users icon"></i>Customers</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <a href="?tab=analytics" class="row gap-3 px-3 py-2 text-black tab-btn rounded-start"
                                    id="analytics">
                                    <i class="chart bar icon"></i>Analytics</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <a href="?tab=categories" class="row gap-3 px-3 py-2 text-black tab-btn rounded-start"
                                    id="categories">
                                    <i class="boxes icon"></i>Categories</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <a href="?tab=settings" class="row gap-3 px-3 py-2 text-black tab-btn rounded-start"
                                    id="settings">
                                    <i class="cog icon"></i>Settings</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 pt-3 mt-3 border-top d-flex align-items-end text-secondary">
                        Sales Channels
                    </div>
                    <div class="col-12 py-3 ">
                        <a href="/toyshop" class="ui button icon  w-75 "><i class="globe icon"></i> Online Store</a>
                    </div>
                </div>
            </div>
            <!-- sidebar -->

            <div class="col vh-100 overflow-auto " id="loader">
                <!-- nav -->
                <div class="row py-2 bg-white border-bottom">
                    <!-- left -->
                    <div class="col-6 d-flex align-items-center">
                        <div class="ps-2">
                            <i class="sidebar icon curser-pointer d-md-none" id="menu"></i>
                            <div class="d-none d-md-block">
                                Hi!
                                <?php echo $_SESSION["admin"]["first_name"] ?>
                            </div>
                        </div>

                    </div>
                    <!-- right -->
                    <div class="col-6 d-flex gap-3 justify-content-end align-items-center">
                        <a class="ui basic label">
                            <i class="mail icon"></i> 
                          <span id="message-count">0</span>
                        </a>
                        <div class="ui inline dropdown " id="menu-dropdown">
                            <img src="../resource/user_image/Sachira_0714798940.png" class="rounded-circle"
                                style="width:3rem;height:3rem;object-fit:cover" alt="profile">
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                <div class="item">
                                    <button class="ui button primary" id="logout-btn">Logout</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- nav -->

                <!-- tab content -->
                <div class="row px-4 pt-3" id="wow">
                    <?php
                    if (isset($_GET['tab'])) {
                        if ($_GET['tab'] == "dashboard") {
                            include 'dashboard.php';
                            ?>
                            <script>
                                $("#dashboard").addClass("bg-blue  text-white").removeClass("tab-btn");
                            </script>
                            <?php
                        } else if ($_GET['tab'] == "myProducts") {
                            include 'myProducts.php';
                            ?>
                                <script>
                                    $("#myproducts").addClass("bg-blue  text-white").removeClass("tab-btn");
                                </script>
                            <?php
                        } else if ($_GET['tab'] == "newproduct") {
                            include 'newProduct.php';
                            ?>
                                    <script>
                                        $("#myproducts").addClass("bg-blue  text-white").removeClass("tab-btn");
                                    </script>
                            <?php
                        } else if ($_GET['tab'] == "updateproduct") {
                            include 'updateProduct.php';
                            ?>
                                        <script>
                                            $("#myproducts").addClass("bg-blue  text-white").removeClass("tab-btn");
                                        </script>
                            <?php
                        } else if ($_GET['tab'] == "customers") {
                            include 'customers.php';
                            ?>
                                            <script>
                                                $("#customers").addClass("bg-blue  text-white").removeClass("tab-btn");
                                            </script>
                            <?php
                        } else if ($_GET['tab'] == "orders") {
                            include 'orders.php';
                            ?>
                                                <script>
                                                    $("#orders").addClass("bg-blue  text-white").removeClass("tab-btn");
                                                </script>
                            <?php
                        } else if ($_GET["tab"] == "settings") {
                            include 'settings.php';
                            ?>
                                                    <script>
                                                        $("#settings").addClass("bg-blue  text-white").removeClass("tab-btn");
                                                    </script>
                            <?php
                        }
                        else if($_GET["tab"]== "analytics"){
                            include 'analytics.php'
                            ?>
                            <script>
                                $("#analytics").addClass("bg-blue  text-white").removeClass("tab-btn");
                            </script>
                            <?php
                        }
                        else if($_GET["tab"]== "categories"){
                            include 'categories.php'
                            ?>
                            <script>
                                $("#categories").addClass("bg-blue  text-white").removeClass("tab-btn");
                            </script>
                            <?php
                        }else if($_GET["tab"]== "report"){
                            include "report.php";
                        }else {
                            include 'dashboard.php';
                        }
                    }  else {
                        include 'dashboard.php';
                    }
                    ?>
                </div>
                <!-- tab content -->

            </div>
        </div>
    </div>
    <script src="script.js"></script>
    
</body>

</html>