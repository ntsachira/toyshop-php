<?php

include 'connection.php';

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title id="title">Toy Shop : Sign Up</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="icon" type="image/png" href="resource/logo.png">
    <link rel="stylesheet" href="style.css">
    <!-- jQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- jQuery CDN -->
</head>

<body>
    <div class="container-fluid min-vh-100 d-flex justify-content-center max-width">
        <div class="row align-content-center justify-content-center max-width">
            <!-- header -->
            <div class="col-12 p-3">
                <!-- logo block -->
                <div class="d-flex align-items-center justify-content-center ">
                    <img src="resource/logo.png" alt="logo">
                    <h1 class="logo-text">Toy Shop</h1>
                </div>
                <!-- logo block -->
                <div class="d-flex justify-content-center">
                    <span class="text-center text-blue fs-3">Welcome to <span class="">Toy Shop</span></span>
                </div>
            </div>
            <!-- header -->

            <!-- Alert box -->
            <?php include "alertBox.php" ?>
            <!-- Alert box -->

            <!-- signUp form -->
            <div class="col-12 col-sm-10 col-lg-7 d-none" id="signUpBox">
                <div class="row g-2">

                    <div class="col-12">
                        <p class="fs-4">Create New Account</p>
                    </div>

                    <div class="col-6 mb-3">
                        <label class="form-label">First Name</label>
                        <input type="text" class="form-control" placeholder="Enter first name" id="fname" />
                    </div>

                    <div class="col-6 mb-3">
                        <label class="form-label">Last Name</label>
                        <input type="text" class="form-control" placeholder="Enter last name" id="lname" />
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" placeholder="Enter Email address" id="email" />
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" placeholder="Enter password" id="password" />
                    </div>

                    <div class="col-6">
                        <label class="form-label">Mobile</label>
                        <input type="text" class="form-control" placeholder="Enter mobile" id="mobile" />
                    </div>

                    <div class="col-6 mb-3">
                        <label class="form-label">Gender</label>
                        <select class="form-select" id="gender">
                            <!-- search and fetch data from database -->
                            <?php
                            $result = Database::execute("SELECT * FROM gender");
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <option value="<?php echo $row["gender_id"] ?>">
                                    <?php echo $row["gender_name"] ?>
                                </option>
                                <?php
                            }
                            ?>
                            <!-- search and fetch data from database -->
                        </select>
                        <div class="form-text">We collect this data give you more personalized results</div>
                    </div>

                    <div class="col-12 col-lg-6 d-grid">
                        <button class="btn btn-blue" onclick="signup()">Register</button>
                    </div>

                    <div class="col-12 col-lg-6 d-grid">
                        <button class="btn btn-default" onclick="changeView()">Already registered? Sign In</button>
                    </div>

                </div>
            </div>
            <!-- signUp form -->

            <!-- signIn form -->
            <div class="col-12 col-sm-7 col-lg-4 " id="signInBox">
                <div class="row g-2">
                    <div class="col-12">
                        <p class="fs-4">Sign In</p>
                    </div>

                    <?php

                    $email = "";
                    $password = "";
                    $rememberme = "";

                    if (isset($_COOKIE["email"])) {
                        $email = $_COOKIE["email"];
                        $rememberme = 'checked';
                    }
                    if (isset($_COOKIE["password"])) {
                        $password = $_COOKIE["password"];
                    }

                    ?>

                    <div class="col-12 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control needs-validation" id="email2" placeholder="Enter Email address"
                            value="<?php echo $email; ?>" />
                    </div>
                    <div class="col-12">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" id="password2" placeholder="Enter Password" value="<?php echo $password; ?>" />
                    </div>
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" <?php echo $rememberme; ?>
                                id="rememberme" />
                            <label for="rememberme" class="form-check-label">Remember Me</label>
                        </div>
                    </div>
                    <div class="col-6 text-end">
                        <div id="fogot-password-spinner" class="spinner-border d-none text-primary"
                            style="width: 1rem; height: 1rem;" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <a href="#" class="link-primary" onclick="forgotPassword();">Forgot Password?</a>
                    </div>
                    <div class="col-12 mt-4 d-grid">
                        <button class="btn btn-blue" onclick="signin()">Sign In</button>
                    </div>
                    <div class="col-12 mt-2 d-grid">
                        <button class="btn btn-default" onclick="changeView();">Are You New? Register Now</button>
                    </div>
                </div>
            </div>
            <!-- signIn form -->

            <!-- modal -->
            <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="passwordResetModal">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><span class="text-orange">ToyShop</span> | Reset Password</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Display error messages -->
                            <div class="d-none d-flex justify-content-end " id="passwordresetModel-errorLabelDiv">
                                <label class="form-label "
                                    id="passwordresetModel-errorLabel"><!-- Error message --></label>
                            </div>
                            <!-- Display error messages -->
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" placeholder="Enter new Password"
                                    id="newPassword">
                                <button class="btn btn-outline-secondary" type="button" id="newPasswordButton"
                                    onclick="toggleShowPassword('newPassword','newPasswordButton')">Show</button>
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" placeholder="Re-Enter new password"
                                    id="reEnterPassword">
                                <button class="btn btn-outline-secondary" type="button" id="reEnterPasswordButton"
                                    onclick="toggleShowPassword('reEnterPassword','reEnterPasswordButton')">Show</button>
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Verification Code</label>
                                <input type="text" class="form-control" id="verificationCode"
                                    placeholder="Check your email inbox for the Code">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-blue" onclick="resetPassword();">Reset</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- modal -->

            <!-- footer -->
            <div class="col-12 fixed-bottom">
                <p class="text-center">2024 ToyShop.lk || All Rights Reserved</p>
            </div>
            <!-- footer -->
        </div>

    </div>

    <script src="bootstrap.js"></script>
    <script src="script.js"></script>
</body>

</html>