<?php

include '../connection.php';

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title id="title">Toy Shop : Admin login</title>

    <link rel="stylesheet" href="../bootstrap.css" />
    <link rel="icon" type="image/png" href="../resource/logo.png">
    <link rel="stylesheet" href="../style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <div class="container-fluid min-vh-100 d-flex justify-content-center max-width">
        <div class="row align-content-center justify-content-center max-width">
            <!-- header -->
            <div class="col-12 p-3">
                <!-- logo block -->
                <div class="d-flex align-items-center justify-content-center ">
                    <img src="../resource/logo.png" alt="logo">
                    <h1 class="logo-text">Toy Shop</h1>
                </div>
                <!-- logo block -->               
            </div>
            <!-- header -->          

            <!-- signIn form -->
            <div class="col-12 col-sm-7 col-lg-4 " id="signInBox">
                <div class="row g-2">
                    <div class="col-12">
                        <p class="fs-4">Admin Log In</p>
                    </div>

                    <?php

                    $email = "";
                    $password = "";
                    $rememberme = "";

                    if (isset($_COOKIE["admin_email"])) {
                        $email = $_COOKIE["admin_email"];
                        $rememberme = 'checked';
                    }
                    if (isset($_COOKIE["admin_password"])) {
                        $password = $_COOKIE["admin_password"];
                    }

                    ?>

                    <div class="col-12">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control needs-validation" placeholder="Enter email address"
                        id="admin-email" value="<?php echo $email; ?>" />
                    </div>
                   <?php 
                    $admin_result = Database::execute("SELECT * FROM `admin`");
                    $admin_data = $admin_result->fetch_assoc();
                   if($admin_data["admin_login_options_type_id"]==1){
                        ?>
                         <div class="col-12">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" id="admin-password" placeholder="Enter password"
                        value="<?php echo $password; ?>" />
                    </div>
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" <?php echo $rememberme; ?> id="admin-rememberme" />
                            <label class="form-check-label" for="admin-rememberme">Remember Me</label>
                        </div>
                    </div>
                    <div class="col-12 mt-4 d-grid">
                        <button class="btn btn-blue" id="admin-login-btn">Log In</button>
                    </div> 
                        <?php
                   }else{
                    ?>
                     <div class="col-12 mt-4 d-grid">
                        <button class="btn btn-blue button " onclick="getLoginOtp();">
                        <span id="otp-login-spinner" class="spinner-border spinner-border-sm d-none" aria-hidden="true"></span>
                        <span id="admin-otp-btn">Get Login OTP</span></button>
                    </div> 
                    <?php
                   }
                   ?>
                   
                                     
                </div>
            </div>
            <!-- signIn form -->           

            <!-- footer -->
            <div class="col-12 fixed-bottom">
                <p class="text-center">2024 ToyShop.lk || All Rights Reserved</p>
            </div>
            <!-- footer -->
        </div>

    </div>

    <script src="../bootstrap.js"></script>
    <script src="script.js"></script>
</body>

</html>