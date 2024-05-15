<?php
session_start();
include "connection.php";
if (!isset($_SESSION["user"])) {
    header("Location: index.php");
} else {
    $user = $_SESSION["user"];
}


?>
<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Profile | ToyShop</title>
    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="icon" type="image/png" href="resource/logo.png">
    <link rel="stylesheet" href="style.css">
    <!-- jQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- jQuery CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Semantic UI CDN -->
    <script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.5.0/dist/semantic.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.5.0/dist/semantic.min.css">
    <!-- Semantic UI CDN -->
</head>

<body <?php if(isset($_GET["msg"])){?>onload="openMessage()"<?php }?> >
    <?php include "header.php" ?>
    <?php include "alertBox.php" ?>
    <div class="container-lg mb-5">
        <div class="row pt-3">
            <div class="col-12">
                <!-- breadcrumb -->
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="home.php" class="text-decoration-none text-orange">ToyShop</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">My Profile</li>
                    </ol>
                </nav>
                <!-- breadcrumb -->
            </div>
        </div>
        <div class="row px-3 border-top">
            <div
                class=" d-flex flex-column justify-content-between col-lg-3 col-md-4 d-flex align-items-center py-3 border-bottom">
                <?php
                $user_image_result = Database::execute("SELECT * FROM `user_image` WHERE `user_email`='" . $user["email"] . "'");
                $user_image_data = $user_image_result->fetch_assoc();
                ?>
                <!-- user image card -->
                <div class=" d-flex flex-column align-items-center" style="width: 16rem;">
                    <img src="<?php echo (!empty($user_image_data["image_path"])) ? ("resource/user_image/" . $user_image_data["image_path"]) : ("resource/new_user.svg"); ?>"
                        class="card-img-top img-thumbnail mb-2 rounded-circle" alt="user-image" id="userImage"
                        style="height:12rem; width:10rem; object-fit:cover">

                    <ul class=" card list-group list-group-flush">
                        <li class="list-group-item">
                            <h6 class="card-title text-center fw-bold">
                                <?php echo ($user["first_name"] . " " . $user["last_name"]) ?>
                            </h6>
                        </li>
                        <li class="list-group-item text-center">
                            <?php echo $user["email"] ?>
                        </li>
                        <li class="list-group-item text-center">Joined
                            <?php echo $user["joined_date"] ?>
                        </li>
                    </ul>
                    <div class="my-3 ">
                        <label class="input-group-text  btn-blue curser-pointer" for="userImageSelect">Change
                            Image</label>
                        <input type="file" class="form-control d-none" id="userImageSelect"
                            onchange="loadProfilePicture('userImageSelect','userImage')">
                    </div>

                </div>
                <!-- user image card -->

                <div class="ui vertical menu">
                    <a class="item " href="myOrders.php"><i class="box icon "></i> My Orders</a>
                    <a class="item " href="myReviews.php"><i class="star icon "></i> My Reviews</a>
                    <a class="item " href="cart.php"><i class="shop icon "></i> Cart</a>
                    <a class="item " href="watchlist.php"><i class="heart icon "></i> Watchlist</a>
                    <a class="item " onclick="openMessage()"><i class="comment alternate icon "></i> Chat with
                        Seller</a>
                </div>


            </div>
            <!-- chat modal -->
            <div class="modal " tabindex="-1" id="chat-modal">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" >
                    <div class="modal-content" >
                        <div class="modal-header py-2">
                            <div class="row align-items-center">
                                <div class="col-3">
                                    <img src="resource/logo.png" style="height: 3rem;" alt="">
                                </div>
                                <div class="col">
                                    <p class="text-center">Chat with ToyShop</p>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body bg-light" id="message-scroll" >
                            <div class="row" id="message-block">                               
                                <!-- messages -->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="ui fluid w-100 align-items-center input gap-2" id="input-container">
                                <label>(<span id="message-limit">0</span>/500)</label>
                                <input type="text" placeholder="Keep your questions short and simple..." id="message-text">
                                <div class="ui button teal" id="send-btn">Send</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- chat modal end -->
            <div class="col-lg-6 col-md-8 p-3 border-start border-end">
                <div class="row g-2">
                    <div class="col-12">
                        <p class="fs-5">Profile Settings</p>
                    </div>

                    <div class="col-6">
                        <label class="form-label">First Name</label>
                        <input type="text" class="form-control" id="fname" value="<?php echo $user["first_name"] ?>" />
                    </div>

                    <div class="col-6">
                        <label class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lname" value="<?php echo $user["last_name"] ?>" />
                    </div>

                    <div class="col-6">
                        <label class="form-label">Mobile</label>
                        <input type="text" class="form-control" id="mobile" value="<?php echo $user["mobile"] ?>" />
                    </div>

                    <div class="col-6">
                        <label class="form-label">Gender</label>
                        <input type="text" disabled class="form-control" id=""
                            value="<?php echo $user["gender_name"] ?>" />
                    </div>

                    

                    <div class="col-12 mt-4 pt-3 border-top">
                        <p class="fs-5">Contact Details</p>
                    </div>

                    <?php

                    $address_result = Database::execute("SELECT * FROM `user_has_address` INNER JOIN `city_data` ON city_data.city_id=user_has_address.city_city_id WHERE `user_email`='" . $user["email"] . "'");
                    $address_data = $address_result->fetch_assoc();

                    ?>

                    <div class="col-12">
                        <label class="form-label">Address Line 1</label>
                        <input type="text" class="form-control" id="line1"
                            value="<?php echo (!empty($address_data["line1"])) ? ($address_data["line1"]) : "" ?>" />
                    </div>
                    <div class="col-12">
                        <label class="form-label">Address Line 2</label>
                        <input type="text" class="form-control" id="line2"
                            value="<?php echo (!empty($address_data["line2"])) ? ($address_data["line2"]) : "" ?>" />
                    </div>
                    <div class="col-6">
                        <label class="form-label">City</label>
                        <select class="form-select" aria-label="Default select example" id="city_select"
                            onchange="changeDistrictAndProvinceOnCity()">
                            <option value="0">Select city</option>
                            <?php
                            $city_list_rs = Database::execute("SELECT * FROM `city` ORDER BY `city_name` ASC");
                            while ($city = $city_list_rs->fetch_assoc()) {
                                $isSelected = "";
                                if (!empty($address_data["city_id"])) {
                                    if ($address_data["city_id"] == $city["city_id"]) {
                                        $isSelected = "selected";
                                    }
                                }

                                ?>
                                <option <?php echo $isSelected ?> value="<?php echo $city["city_id"] ?>">
                                    <?php echo $city["city_name"] ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">District</label>
                        <input type="text" class="form-control" id="district" disabled
                            value="<?php echo (!empty($address_data["district_name"])) ? ($address_data["district_name"]) : ""; ?>" />
                    </div>
                    <div class="col-6">
                        <label class="form-label">Province</label>
                        <input type="text" class="form-control" id="province" disabled
                            value="<?php echo (!empty($address_data["province_name"])) ? ($address_data["province_name"]) : ""; ?>" />
                    </div>
                    <div class="col-6">
                        <label class="form-label">Postal Code</label>
                        <input type="text" class="form-control" id="postalCode"
                            value="<?php echo (!empty($address_data["postal_code"])) ? ($address_data["postal_code"]) : ""; ?>" />
                    </div>
                    <div class="col-12">
                        <div class="row my-3">
                            <div class="col-6">
                                <a href="userProfile.php" class="btn btn-orange col-12">Discard Changes</a>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-default col-12" onclick="updateUserProfile();">Save
                                    Changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 py-3 d-flex align-items-center justify-content-center border-bottom">
                <p class="text-center">Display Advertiesments</p>
            </div>
        </div>
    </div>

    <?php include "footer.php" ?>

</body>

</html>