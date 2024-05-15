<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container-fluid ">
        <div class="row">
            <div class="col-12 d-flex text-center bg-blue">
                <a href="#bd" class="text-decoration-none text-white col-12 p-2 bg-blue">Back to top &uarr;</a>
            </div>
        </div>
        <div class="row  p-4 gy-3" style="background-color: #eff3f8;">
            <div class="col-sm-7">
                <div class="row gap-3 gap-lg-0">
                    <div class="col-lg-8">
                        <?php
                        $footer_result = Database::execute("SELECT * FROM `footer`");
                        $footer_data = $footer_result->fetch_assoc();
                        ?>
                        <h4 class="text-orange ">ToyShop</h4>
                        <p class="">
                            <?php echo $footer_data["mission"] ?>
                        </p>
                        <!-- logo block -->
                        <div class=" d-none mt-5 d-lg-flex align-items-center gap-2">
                            <img src="resource/logo.png" class="object-fit-contain" alt="logo">
                            <h1 class="logo-text ">Toy Shop</h1>
                        </div>
                        <!-- logo block -->
                    </div>
                    <div class="col-lg-3 col-12 ps-xl-5">
                        <h4 class="text-orange ">Categories</h4>
                        <dl class="row">
                            <?php
                            $category_result = Database::execute("SELECT * FROM `category`");
                            while ($category = $category_result->fetch_assoc()) {
                                ?>
                                <dd class="col-6 col-lg-12">
                                    <a href="loadProducts.php?cat=<?php echo $category["category_id"] ?>" class="text-decoration-none footer-text ">
                                        <?php echo $category["category_name"]; ?>
                                    </a>
                                </dd>
                                <?php
                            }
                            ?>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="row g-4">
                    <div class="col-lg-4">
                        <h4 class="text-orange text-sm-center">Follow Us</h4>
                        <div class="d-flex gap-3 flex-row flex-lg-column justify-content-sm-center align-items-center">
                            <a href="#"><i class="fa-brands fa-square-facebook footer-text fs-1"></i></a>
                            <a href="#"><i class="fa-brands fa-square-whatsapp footer-text fs-1"></i></a>
                            <a href="#"><i class="fa-brands fa-square-twitter footer-text fs-1"></i></a>
                            <a href="#"><i class="fa-brands fa-square-instagram footer-text fs-1"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <h4 class="text-orange text-sm-center">Contact Us</h4>

                        <p class="text-sm-center">
                            <i class="fa-solid fa-location-dot"></i>
                        </p>
                        <p class="text-sm-center">
                            <?php echo $footer_data["address"] ?>
                        </p>
                        <p class="text-sm-center">
                            <i class="fa-solid fa-envelope"></i>&nbsp;
                        </p>
                        <p class="text-sm-center">
                            <?php echo $footer_data["email"] ?>
                        </p>
                        <p class="text-sm-center">
                            <i class="fa-solid fa-phone"></i>
                        </p>
                        <p class="text-sm-center">
                            <?php echo $footer_data["tele"] ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row bg-default">
            <div class="col py-3">
                <p class="text-center text-white">
                    <?php echo $footer_data["copy_right"] ?>
                </p>
            </div>
        </div>
    </div>
    <div class="position-fixed bottom-0 end-0 p-3">
        <a href="#bd" class="ui icon orange button position-relative shadow" id="pageUp">
            <i class="arrow up icon large"></i>
        </a>
    </div>

    <!-- script files and links -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
    <script src="bootstrap.js"></script>
    <script src="script.js"></script>
    <script src="https://kit.fontawesome.com/826bed8bf4.js" crossorigin="anonymous"></script>
    <!-- script files and links -->
</body>

</html>