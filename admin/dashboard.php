<!DOCTYPE html>
<html>

<body onload="loadCategorySalesChart();loadSalesChart(); loadChart();">
    <div class="row mb-3">
        <h1>Dashboard</h1>
    </div>
    <div class="row m-0">
        <div class="col-12">
            <div class="row gap-sm-4 mb-3 justify-content-center">
                <!-- card1 -->
                <div class="col-12 col-sm card mb-3 border-3 border-start border-bottom-0  border-end-0 border-top-0 border-warning shadow-sm bg-white"
                    style="min-width:16rem;">
                    <div class="row g-2">
                        <div class="col-12 pt-2 d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Total Sales</h5>
                            <i class="money bill alternate outline icon text-orange fs-3"></i>
                        </div>
                        <?php

                        // revenure
                        $date_obj = new DateTime("now",new DateTimeZone("Asia/Colombo"));
                        $date = $date_obj->format("Y-m-d h:i:s");

                        $invoice_total_result = Database::execute("SELECT * FROM `invoice` INNER JOIN `invoice_item` 
                        ON `invoice`.`invoice_id` = `invoice_item`.`invoice_invoice_id`");


                        $totalSales = 0;

                        while ($invoice_total_data = $invoice_total_result->fetch_assoc()) {
                            $shipping_fee = $invoice_total_data['shipping_fee'] * ceil($invoice_total_data['invoice_item_quantity'] / 2);
                            $totalSales = $totalSales + ($invoice_total_data['invoice_item_price'] * $invoice_total_data['invoice_item_quantity']) + $shipping_fee;
                        }

                        ?>
                        <div class="col-12 mb-2">
                            <p class="text-center fw-semibold fs-3" id='totalSales'>Rs.
                                <?php echo number_format($totalSales, 2) ?>
                            </p>
                        </div>
                        <div class="col-12 mb-2">
                            <p class="text-end text-secondary  fs-6">Updated
                                <?php echo $date ?>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- card1 -->

                <!-- card2 -->
                <div class="col-12 col-sm card mb-3 border-3 border-start border-bottom-0 border-end-0 border-top-0 border-info shadow-sm bg-white "
                    style="min-width:16rem">
                    <div class="row g-2">
                        <div class="col-12 pt-2 d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Monthly Sales</h5>
                            <i class="money bill alternate outline icon text-blue fs-3"></i>
                        </div>
                        <div class="col-12 mb-2">
                            <?php
                            $invoice_monthly_result = Database::execute("SELECT * FROM `invoice` INNER JOIN `invoice_item` 
                             ON `invoice`.`invoice_id` = `invoice_item`.`invoice_invoice_id` WHERE `date` LIKE '" . date("Y-m") . "%'");


                            $monthlySales = 0;

                            while ($invoice_monthly_data = $invoice_monthly_result->fetch_assoc()) {
                                $shipping_fee = $invoice_monthly_data['shipping_fee'] * ceil($invoice_monthly_data['invoice_item_quantity'] / 2);
                                $monthlySales = $monthlySales + ($invoice_monthly_data['invoice_item_price'] * $invoice_monthly_data['invoice_item_quantity']) + $shipping_fee;
                            }
                            ?>
                            <p class="text-center fw-semibold fs-3" id="monthlySales">Rs.
                                <?php echo number_format($monthlySales, 2) ?>
                            </p>
                        </div>
                        <div class="col-12 mb-2">
                            <p class="text-end text-secondary fs-6">Updated
                                <?php echo $date ?>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- card2 -->

                <!-- card3 -->
                <div class="col-12 col-sm card mb-3 border-start border-3 border-bottom-0 border-end-0 border-top-0 border-warning shadow-sm bg-white"
                    style="min-width:16rem">
                    <div class="row g-2">
                        <div class="col-12 pt-2 d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Registered Customers</h5>
                            <i class="users icon text-orange fs-3"></i>
                        </div>
                        <?php
                        $user_result = Database::execute("SELECT * FROM `user`  WHERE `email` != 'admin@gmail.com'");
                        ?>
                        <div class="col-12 mb-2">
                            <p class="text-center fw-semibold fs-3">
                                <?php echo $user_result->num_rows ?>
                            </p>
                        </div>
                        <div class="col-12 mb-2">
                            <p class="text-end text-secondary fs-6">Updated
                                <?php echo $date ?>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- card3 -->

                <!-- card4 -->
                <div class="col-12 col-sm card mb-3 border-3 border-bottom-0 border-top-0 border-end-0 border-start border-info shadow-sm bg-white"
                    style="min-width:16rem;">
                    <div class="row g-2">
                        <div class="col-12 pt-2 d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Total Products</h5>
                            <i class="archive icon text-blue fs-3"></i>
                        </div>
                        <?php
                        $product_result = Database::execute("SELECT * FROM `product`");

                        ?>
                        <div class="col-12 mb-2">
                            <p class="text-center fw-semibold fs-3">
                                <?php echo number_format($product_result->num_rows, 0) ?>
                            </p>
                        </div>
                        <div class="col-12 mb-2">
                            <p class="text-end text-secondary fs-6">Updated
                                <?php echo $date ?>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- card4 -->

            </div>
            <div class="row gap-3 align-items-start justify-content-center">

                <div class="col-12 col-md  ">
                    <div class="row overflow-auto bg-white rounded  border p-3 mb-3  gap-3 ">
                        <div class="fw-semibold">ANNUAL SALES</div>
                        <table class="table table-bordered ">
                            <thead class="table-light">
                                <th class="text-center w-50" style="min-width:15rem">Current year</th>
                                <th class="text-center w-50" style="min-width:15rem">Prior Year</th>
                            </thead>
                            <tbody>
                                <!-- row 1 -->
                                <tr>
                                    <td colspan="2">
                                        <div
                                            class="col-12 text-bg-light py-1 border-3 border-bottom border-warning text-center">
                                            Top Selling Product🏆
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                $invoice_result = Database::execute("SELECT * FROM `invoice`");
                                if ($invoice_result->num_rows != 0) { //* checking if invoices are available
                                    $previousYear = (int) date("Y") - 1;

                                    ?>
                                    <tr>
                                        <?php

                                        $invoice_item_current_result = Database::execute("SELECT `product_product_id`,SUM(invoice_item_quantity) AS `product_count` FROM `invoice` 
                                        INNER JOIN `invoice_item` ON `invoice`.`invoice_id`=`invoice_item`.`invoice_invoice_id` WHERE `date` LIKE '%" . date("Y") . "%'
                                         GROUP BY `product_product_id` ORDER BY `product_count` DESC LIMIT 1 OFFSET 0 ");

                                        if ($invoice_item_current_result->num_rows != 0) { //* checking if invoices are available for current year
                                            $invoice_item_current_data = $invoice_item_current_result->fetch_assoc();

                                            $product_result = Database::execute("SELECT * FROM `product` WHERE `product_id` = '" . $invoice_item_current_data['product_product_id'] . "'");
                                            $product_data = $product_result->fetch_assoc();

                                            $image_result = Database::execute("SELECT * FROM `product_image` WHERE `product_product_id` = '" . $product_data['product_id'] . "'");
                                            $image_path = "resource/product_image/emptyImage.jpg";
                                            if ($image_result->num_rows != 0) {
                                                $image_data = $image_result->fetch_assoc();
                                                $image_path = $image_data['image_path'];
                                            }

                                            ?>
                                            <td
                                                onclick='gotoSingleProductView(<?php echo $invoice_item_current_data["product_product_id"] ?>,"admin")'>
                                                <div class="row justify-content-center ">
                                                    <img src="../resource/product_image/<?php echo $image_path ?>"
                                                        class="img-thumbnail"
                                                        style="height:10rem;width:10rem;object-fit: contain;">
                                                    <h3 class="text-center mt-2">
                                                        <?php echo $invoice_item_current_data["product_count"] ?> items sold
                                                    </h3>
                                                    <span class="card-title  text-center">
                                                        <?php echo $product_data["title"] ?>
                                                    </span>
                                                    <p class="text-center fs-1">🥇</p>
                                                </div>
                                            </td>
                                            <?php
                                        } else {
                                            ?>
                                            <td>
                                                <div class="row justify-content-center">
                                                    <img src="../resource/empty.jpg" class="img-thumbnail"
                                                        style="height:10rem;width:10rem;object-fit: contain;">

                                                    <span class="card-title text-center">
                                                        Currently not available
                                                    </span>
                                                </div>
                                            </td>
                                            <?php
                                        }

                                        $invoice_item_prior_result = Database::execute("SELECT `product_product_id`,SUM(invoice_item_quantity) AS `product_count` FROM `invoice` 
                                        INNER JOIN `invoice_item` ON `invoice`.`invoice_id`=`invoice_item`.`invoice_invoice_id` WHERE `date` LIKE '%" . $previousYear . "%'
                                         GROUP BY `product_product_id` ORDER BY `product_count` DESC LIMIT 1 OFFSET 0 ");

                                        if ($invoice_item_prior_result->num_rows != 0) { //* checking if invoices are available for prior year
                                            $invoice_item_prior_data = $invoice_item_prior_result->fetch_assoc();

                                            $product_result_p = Database::execute("SELECT * FROM `product` WHERE `product_id` = '" . $invoice_item_prior_data['product_product_id'] . "'");
                                            $product_data_p = $product_result_p->fetch_assoc();

                                            $image_result_p = Database::execute("SELECT * FROM `product_image` WHERE `product_product_id` = '" . $product_data_p['product_id'] . "'");
                                            $image_path = "resource/empty.jpg";
                                            if ($image_result_p->num_rows != 0) {
                                                $image_data = $image_result_p->fetch_assoc();
                                                $image_path = $image_data['image_path'];
                                            }
                                            ?>
                                            <td
                                                onclick='gotoSingleProductView(<?php echo $invoice_item_prior_data["product_product_id"] ?>,"admin")'>
                                                <div class="row justify-content-center">
                                                    <img src="../resource/product_image/<?php echo $image_path ?>"
                                                        class="img-thumbnail"
                                                        style="height:10rem;width:10rem;object-fit: contain;">
                                                    <h3 class="text-center text-secondary mt-2">
                                                        <?php echo $invoice_item_prior_data["product_count"] ?> Items sold
                                                    </h3>
                                                    <span class="card-title text-secondary text-center">
                                                        <?php echo $product_data_p["title"] ?>

                                                    </span>
                                                    <p class="text-center fs-1">🥇</p>
                                                </div>
                                            </td>
                                            <?php
                                        } else {
                                            ?>
                                            <td>
                                                <div class="row justify-content-center">
                                                    <img src="../resource/empty.jpg" class="img-thumbnail"
                                                        style="height:10rem;width:10rem;object-fit: contain;">

                                                    <span class="card-title text-secondary text-center">
                                                        Currently not available
                                                    </span>
                                                </div>
                                            </td>
                                            <?php
                                        } ?>
                                    </tr>
                                    <!-- row 1 -->

                                    <!-- row 2 -->
                                    <tr>
                                        <td colspan="2">
                                            <div
                                                class="col-12 text-bg-light border-3 border-bottom border-warning py-1 text-center">
                                                Top Selling Category🏆
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>

                                        <?php

                                        if ($invoice_item_current_result->num_rows != 0) { //* checking if invoices are available for current year
                                            $product_category = Database::execute("SELECT `category_id`,`category_name`,SUM(invoice_item_quantity) AS `count` FROM `product` INNER JOIN `category` 
                                            ON `product`.`category_category_id`=`category`.`category_id` INNER JOIN `invoice_item` ON `invoice_item`.`product_product_id`=`product`.`product_id`
                                            GROUP BY `category_id` ORDER BY `count` DESC");
                                            $product_category_data = $product_category->fetch_assoc();

                                            $category_image_result = Database::execute("SELECT * FROM `category_image` WHERE `category_category_id` = '" . $product_category_data['category_id'] . "'");

                                            $cat_image_path = "resource/empty.jpg";
                                            if ($category_image_result->num_rows != 0) {
                                                $category_image_data = $category_image_result->fetch_assoc();
                                                $cat_image_path = $category_image_data['image_path'];
                                            }
                                            ?>
                                            <td>
                                                <div class="row justify-content-center">
                                                    <img src="../<?php echo $cat_image_path ?>" class="img-thumbnail"
                                                        style="height:10rem;width:10rem;object-fit: contain;">
                                                    <h3 class="text-center mt-2">
                                                        <?php echo $product_category_data['count'] ?> Items sold
                                                    </h3>
                                                    <span class="card-title text-center">
                                                        <?php echo $product_category_data["category_name"] ?>
                                                    </span>
                                                    <p class="text-center fs-1">🥇</p>
                                                </div>
                                            </td>
                                            <?php
                                        } else {
                                            ?>
                                            <td>
                                                <div class="row justify-content-center">
                                                    <img src="../resource/empty.jpg" class="img-thumbnail"
                                                        style="height:10rem;width:10rem;object-fit: contain;">

                                                    <span class="card-title text-center">
                                                        Currently not available
                                                    </span>
                                                </div>
                                            </td>
                                            <?php
                                        }

                                        if ($invoice_item_prior_result->num_rows != 0) { //* checking if invoices are available for prior year
                                            $product_category_p = Database::execute("SELECT `category_id`,`category_name`,SUM(invoice_item_quantity) AS `count` FROM `product` INNER JOIN `category` 
                                            ON `product`.`category_category_id`=`category`.`category_id` INNER JOIN `invoice_item` ON `invoice_item`.`product_product_id`=`product`.`product_id` 
                                            GROUP BY `category_id` ORDER BY `count` DESC");
                                            $product_category_p_data = $product_category_p->fetch_assoc();

                                            $category_image_p_result = Database::execute("SELECT * FROM `category_image` WHERE `category_category_id` = '" . $product_category_p_data['category_id'] . "'");

                                            $cat_image_path_p = "resource/empty.jpg";
                                            if ($category_image_p_result->num_rows != 0) {
                                                $category_image_p_data = $category_image_p_result->fetch_assoc();
                                                $cat_image_path_p = $category_image_p_data['image_path'];
                                            }
                                            ?>
                                            <td>
                                                <div class="row justify-content-center ">
                                                    <img src="../<?php echo $cat_image_path_p ?>" class="img-thumbnail"
                                                        style="height:10rem;width:10rem;object-fit: contain;">
                                                    <h3 class="text-center text-secondary mt-2">
                                                        <?php echo $product_category_p->num_rows ?> items sold
                                                    </h3>
                                                    <span class="card-title text-secondary text-center">
                                                        <?php echo $product_category_p_data["category_name"] ?>
                                                    </span>
                                                    <p class="text-center fs-1">🥇</p>
                                                </div>
                                            </td>
                                            <?php
                                        } else {
                                            ?>
                                            <td>
                                                <div class="row justify-content-center">
                                                    <img src="../resource/empty.jpg" class="img-thumbnail"
                                                        style="height:10rem;width:10rem;object-fit: contain;">

                                                    <span class="card-title text-center">
                                                        Currently not available
                                                    </span>
                                                </div>
                                            </td>
                                            <?php
                                        } ?>
                                    </tr>
                                    <!-- row 2 -->

                                    <!-- row 3 -->
                                    <tr>
                                        <td colspan="2">
                                            <div class="col-12 text-bg-warning py-1 text-center">
                                                Total sales
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <?php
                                                $invoice_current_result = Database::execute("SELECT * FROM `invoice` INNER JOIN `invoice_item` 
                             ON `invoice`.`invoice_id` = `invoice_item`.`invoice_invoice_id` WHERE `date` LIKE '" . date("Y") . "%'");


                                                $currentSales = 0;

                                                while ($invoice_current_data = $invoice_current_result->fetch_assoc()) {
                                                    $shipping_fee = $invoice_current_data['shipping_fee'] * ceil($invoice_current_data['invoice_item_quantity'] / 2);
                                                    $currentSales = $currentSales + ($invoice_current_data['invoice_item_price'] * $invoice_current_data['invoice_item_quantity']) + $shipping_fee;
                                                }
                                                ?>
                                                <div class="col-12 text-center fs-5 fw-bold py-1">
                                                    Rs.
                                                    <?php echo number_format($currentSales, 2); ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <?php
                                                $invoice_prior_result = Database::execute("SELECT * FROM `invoice` INNER JOIN `invoice_item` 
                             ON `invoice`.`invoice_id` = `invoice_item`.`invoice_invoice_id` WHERE `date` LIKE '" . ((int) date("Y") - 1) . "%'");


                                                $priorSales = 0;

                                                while ($invoice_prior_data = $invoice_prior_result->fetch_assoc()) {
                                                    $shipping_fee = $invoice_prior_data['shipping_fee'] * ceil($invoice_prior_data['invoice_item_quantity'] / 2);
                                                    $priorSales = $priorSales + ($invoice_prior_data['invoice_item_price'] * $invoice_prior_data['invoice_item_quantity']) + $shipping_fee;
                                                }
                                                ?>
                                                <div class="col-12 text-center text-secondary fs-5 fw-bold  py-1">
                                                    Rs.
                                                    <?php echo number_format($priorSales, 2); ?>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="2">
                                            <div class="col-12 text-bg-warning py-1 text-center">
                                                No Sales So Far 😕
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="col-3 d-flex  gap-xl-0 flex-wrap w-auto">
                    <div
                        class="row flex-column flex-xl-column justify-content-center align-items-start  gap-3 flex-md-row flex-wrap">
                        <!-- chart -->
                        <div class="col py-3 ps-4 pe-0 border rounded bg-white  border-bottom"
                            style="min-width:20rem;max-width: 23rem;">
                            <div class="fs-6 fw-semibold ">TOTAL SALES OVER TIME (LKR)</div>
                            <div class=" ">
                                <canvas id="salesChart" class="row  w-100 h-auto"></canvas>
                            </div>
                        </div>
                        <!-- chart -->
                        <!-- chart -->
                        <div class="col py-3 ps-4  border rounded bg-white  border-bottom"
                            style="min-width:20rem;max-width: 23rem;">
                            <div class="fs-6 fw-semibold ">TOTAL SALES BY CATEGORY</div>
                            <div class=" ">
                                <canvas id="categorySalesChart" class="row  w-100 h-auto"></canvas>
                            </div>
                        </div>
                        <!-- chart -->
                        <!-- chart -->
                        <div class="col py-3 ps-4 pe-0 border rounded bg-white  border-bottom"
                            style="min-width:20rem;max-width: 23rem;">
                            <div class="fs-6 fw-semibold ">USER STATISTICS</div>
                            <div class=" ">
                                <canvas id="myChart" class="row  w-100 h-auto"></canvas>
                            </div>
                        </div>
                        <!-- chart -->
                        <div class="col  p-3  border rounded bg-white " style="min-width:20rem;max-width: 23rem;">
                            <div class="fs-6 fw-semibold ">CUSTOMER INVOLVMENT</div>
                            <div class="fs-6 ">This Customer expected to spend the most at your store</div>
                            <div class="row">
                            <?php
                        $medals = ["🥇", "🥈", "🥉"];

                        $most_engaged_users = Database::execute("SELECT `email`,CONCAT(`first_name`,' ',`last_name`) AS `name`,
                        SUM((`invoice_item_quantity`*`invoice_item_price`)+(`shipping_fee`*CEIL(invoice_item_quantity/2))) AS `amount`
                        FROM  `product` INNER JOIN `invoice_item` ON `invoice_item`.`product_product_id`=`product`.`product_id` 
                        INNER JOIN `invoice` ON `invoice`.`invoice_id` = `invoice_item`.`invoice_invoice_id`
                        INNER JOIN `user` ON `user`.`email`=`invoice`.`user_email`GROUP BY `user_email` ORDER BY `amount` DESC LIMIT 1");

                        if ($most_engaged_users->num_rows > 0) {
                            for ($x = 0; $x < $most_engaged_users->num_rows; $x++) {
                                $rank_data = $most_engaged_users->fetch_assoc();

                                $user_image_result = Database::execute("SELECT * FROM `user_image` WHERE `user_email` = '" . $rank_data['email'] . "'");
                                    $user_image_path = "new_user.svg";
                                    if ($user_image_result->num_rows != 0) {
                                        $user_image_data = $user_image_result->fetch_assoc();
                                        $user_image_path = "user_image/" . $user_image_data['image_path'];
                                    }
                                ?>
                                <div class="col-12 mt-3">
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-between">
                                            <h4 class="ui image header ">
                                                <span class="d-xl-none d-none d-md-inline"><?php echo $x+1 ?>.</span>
                                                <img src="../resource/<?php echo $user_image_path ?>" class="d-md-none d-xl-inline ui mini rounded-circle image" 
                                                style="height:2.5rem;width:2.5rem;object-fit:cover">
                                                <div class="content">
                                                    <?php echo $rank_data["name"] ?>
                                                    <div class="sub header">Rs. <?php echo number_format($rank_data["amount"],2) ?>
                                                    </div>
                                                </div>

                                            </h4>
                                            <span class="fs-1 text-end d-inline d-lg-none d-xl-inline">
                                                <?php echo $medals[$x] ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="col-12 mb-2">
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-between">
                                        <span class="fs-1 text-end">
                                            Not Available Yet
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="row border rounded gap-3 p-3 bg-white mb-3  overflow-auto">
                    <div class=" fw-semibold">RECENT ORDERS</div>
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width:11rem;min-width:11rem">OrderID</th>
                                <th style="min-width:18rem;max-width: 19rem;">Customer</th>
                                <th class="text-center" style="min-width:9rem">Date</th>
                                <th class="d-none d-lg-block text-end" style="min-width:10rem">Amount</th>
                                <th class="text-center" style="min-width:13rem">Status</th>
                                <th class="text-center" style="min-width:15rem">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $invoice_result = Database::execute("SELECT `invoice_id`,
                            SUM((`invoice_item_quantity`*`invoice_item_price`)+(`shipping_fee`*CEIL(invoice_item_quantity/2))) AS `price`,
                            SUM(`shipping_fee`*CEIL(invoice_item_quantity/2)) AS ship_price,SUM(`invoice_item_quantity`*`invoice_item_price`) AS `sub_total`,
                            `invoice_status_invoice_status_id` AS `status`,`date`,CONCAT(`first_name`,' ',`last_name`) AS `name`,`user_email`
                             FROM `invoice` INNER JOIN `invoice_item` ON `invoice`.`invoice_id` = `invoice_item`.`invoice_invoice_id`
                             INNER JOIN `user` ON `user`.`email`=`invoice`.`user_email` GROUP BY `invoice_id` ORDER BY `date` DESC LIMIT 5");

                            if ($invoice_result->num_rows > 0) {
                                while ($invoice_data = $invoice_result->fetch_assoc()) {
                                    $user_image_result = Database::execute("SELECT * FROM `user_image` WHERE `user_email` = '" . $invoice_data['user_email'] . "'");
                                    $user_image_path = "new_user.svg";
                                    if ($user_image_result->num_rows != 0) {
                                        $user_image_data = $user_image_result->fetch_assoc();
                                        $user_image_path = "user_image/" . $user_image_data['image_path'];
                                    }

                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $invoice_data['invoice_id'] ?>
                                        </td>
                                        <td>
                                            <h4 class="ui image header">
                                                <img src="../resource/<?php echo $user_image_path ?>"
                                                    class="ui  rounded image" style="height:3rem;width:3rem;object-fit:cover;">
                                                <div class="content">
                                                    <?php echo $invoice_data['name'] ?>
                                                    <div class="sub header">
                                                    <?php
                                                $address_data = "";
                                                $city_data = "";
                                                $address_result = Database::execute("SELECT * FROM `user_has_address` WHERE `user_email`='" . $invoice_data['user_email'] . "' ");
                                                if ($address_result->num_rows == 1) {
                                                    $address_data = $address_result->fetch_assoc();
                                                    $city_result = Database::execute("SELECT * FROM `city` WHERE `city_id`='" . $address_data["city_city_id"] . "' ");
                                                    $city_data = $city_result->fetch_assoc();
                                                    echo $city_data["city_name"];
                                                } else {
                                                    echo "Unknown";
                                                }
                                                ?>
                                                    </div>
                                                </div>
                                            </h4>
                                        </td>
                                        <td class="text-center">
                                            <?php echo date_format(new DateTime($invoice_data['date']), "M d, Y") ?>
                                        </td>
                                        <td class="d-none d-lg-block text-end">Rs.
                                            <?php echo number_format($invoice_data['price'], 2) ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-start">
                                                <?php
                                                if ($invoice_data['status'] == 1) {
                                                    ?>
                                                    <div class="rounded-5 py-2 px-3 d-flex gap-2 justify-content-center align-items-center"
                                                        style="background-color:#dddddd"><a
                                                            class="ui black empty circular label"></a>Awaiting Confirm
                                                    </div>
                                                    <?php
                                                } else if ($invoice_data["status"] == 2) {
                                                    ?>
                                                        <div class="rounded-5 py-2 px-3 d-flex gap-2 justify-content-center align-items-center"
                                                            style="background-color:#ffd8b0 ;"><a
                                                                class="ui orange empty circular label"></a>Out for Delivery</div>
                                                    <?php
                                                } else if ($invoice_data["status"] == 4) {
                                                    ?>
                                                            <div class="rounded-5 py-2 px-3 d-flex gap-2 justify-content-center align-items-center"
                                                                style="background-color:#c6e2ff ;"><a
                                                                    class="ui blue empty circular label"></a>Confirmed</div>
                                                    <?php
                                                } else if ($invoice_data["status"] == 5) {
                                                    ?>
                                                                <div class="rounded-5 py-2 px-3 d-flex gap-2 justify-content-center align-items-center"
                                                                    style="background-color:#eacbf3 ;"><a
                                                                        class="ui purple empty circular label"></a>Packaging</div>
                                                    <?php
                                                } else if ($invoice_data["status"] == 6) {
                                                    ?>
                                                                <div class="rounded-5 py-2 px-3 d-flex gap-2 justify-content-center align-items-center"
                                                                    style="background-color:#ffb0b0 ;"><a
                                                                        class="ui red empty circular label"></a>Cancelled</div>
                                                    <?php
                                                } else {
                                                    ?>
                                                                <div class="rounded-5 py-2 px-3 d-flex gap-2 justify-content-center align-items-center"
                                                                    style="background-color:#caf5c5 ;"><a
                                                                        class="ui green empty circular label"></a>Delivered</div>
                                                    <?php
                                                }

                                                $message_result = Database::execute("SELECT * FROM `message_history` WHERE 
                                            (`sender`='" . $invoice_data['user_email'] . "' AND `receiver`='admin@gmail.com') AND `seen_status_seen_status_id`='2'");


                                                ?>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <button class="ui  basic button icon "
                                                onclick="openInvoice('<?php echo $invoice_data['ship_price'] ?>','<?php echo $invoice_data['price'] ?>','<?php echo $invoice_data['sub_total'] ?>','<?php echo $invoice_data['invoice_id'] ?>')">
                                                <i class="eye icon"></i></button>
                                            <button class="ui button icon basic  position-relative"
                                                onclick="openMessage('<?php echo $invoice_data['user_email'] ?>','<?php echo $invoice_data['name'] ?>')">
                                                <i class="comment alternate      icon"></i>
                                                <?php
                                                if ($message_result->num_rows > 0) {
                                                    ?>
                                                    <span
                                                        class="position-absolute top-0 start-100 translate-middle mt-1 me-1 p-2 bg-success border border-light rounded-circle">
                                                        <span class="visually-hidden">New alerts</span>
                                                    </span>
                                                    <?php
                                                } ?>
                                            </button>
                                            <?php
                                            if ($invoice_data["status"] == 1) {
                                                ?>
                                                <button class="ui button teal"
                                                    onclick="confirmOrder('<?php echo $invoice_data['invoice_id'] ?>')">Confirm</button>
                                                <?php
                                            } else {
                                                ?>
                                                <button class="ui button " disabled>Confirm</button>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>

                                    <?php
                                }

                            } else {
                                ?>
                                <tr>
                                    <td colspan="6" class="text-center">No Orders Yet</td>
                                </tr>
                                <?php
                            }
                            ?>

                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6">
                                    <a href="?tab=orders" class="ui right floated small teal basic  button">
                                        View All <i class="right chevron icon"></i>
                                    </a>
                                </td>

                            </tr>
                        </tfoot>
                    </table>

                    <!-- message modal -->
                    <div class="ui bg-light pb-3 pb-sm-0   longer modal position-relative h-auto w-auto"
                        id="message-modal">
                        <div class="header p-2 bg-white">
                            <div class="row px-2 justify-content-end">
                                <div class="col gap-3 d-flex align-items-center justify-content-center">
                                    <img src="" style="height: 3.5rem;width: 3.5rem;object-fit:cover" alt=""
                                        id="user-image" class="img-thumbnail rounded-circle">
                                    <span id="user-name">Sahan Perera</span>
                                </div>
                                <div class="ui red icon mini button h-auto w-auto position-absolute "
                                    onclick="closeModal('');">
                                    <i class="remove icon"></i>
                                </div>
                            </div>
                        </div>
                        <!-- messaging area -->
                        <div class="scrolling content bg-light w-100" style="min-height: 20rem;max-width:40rem"
                            id="message-scroll">
                            <div class="row" id="message-container">
                                <!-- load content here -->

                            </div>
                        </div>
                        <!-- messaging area -->
                        <div class="actions bg-white py-2">
                            <div class="ui fluid input gap-2 align-items-center" id="input-container">
                                <label>(<span id="limit-value">0</span>/500)</label>
                                <input type="text" placeholder="Type here..." id="message-text">
                                <div class="ui button teal" id="send-btn">Send</div>
                            </div>
                        </div>
                    </div>
                    <!-- modal -->

                    <!-- invoice modal -->
                    <div class="ui bg-light p-0  longer modal position-relative h-auto w-auto" id="invoice-modal">
                        <div class="header p-2 bg-white">
                            <div class="row px-2 justify-content-end">
                                <div class="col gap-3 d-flex align-items-center justify-content-center">
                                    <span id="invoice-id">Order (Invoive ID)</span>
                                </div>
                                <div class="ui red icon mini button h-auto w-auto position-absolute "
                                    onclick="closeInvoice('');">
                                    <i class="remove icon"></i>
                                </div>
                            </div>
                        </div>

                        <div class="scrolling content bg-light w-100" style="min-height: 20rem;max-width:40rem"
                            id="invoice-scroll">
                            <div class="row flex-row-reverse gap-2 gap-sm-0" id="invoice-container">
                                <!-- load content here -->


                            </div>
                        </div>
                        <!-- messaging area -->
                        <div class="actions bg-white py-2">
                            <div class="row gap-3">
                                <div class="col d-flex align-items-center">

                                    <button class="ui w-100 button orange" onclick="updateOrderStatus();">Update
                                        Status</button>
                                </div>
                                <div class="col-7 border-start">
                                    <div class="row" id="">
                                        <div class="col-6 d-flex justify-content-end">
                                            <span>Subtotal</span>
                                        </div>
                                        <div class="col-6 d-flex justify-content-end">
                                            <span id="sub-total" class="fw-bold">Rs.4122.00</span>
                                        </div>
                                    </div>
                                    <div class="row  border-bottom py-2" id="">
                                        <div class="col-6 d-flex justify-content-end">
                                            <span>Shipping</span>
                                        </div>
                                        <div class="col-6 d-flex justify-content-end">
                                            <span id="shipping-fee" class="fw-bold">Rs.4122.00</span>
                                        </div>
                                    </div>
                                    <div class="row py-2" id="">
                                        <div class="col-6 d-flex justify-content-end">
                                            <span class="fw-bold">Total</span>
                                        </div>
                                        <div class="col-6 d-flex justify-content-end">
                                            <span id="inv-total" class="fw-bold">Rs.4122.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- modal -->
                </div>

            </div>

        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js"
        integrity="sha512-L0Shl7nXXzIlBSUUPpxrokqq4ojqgZFQczTYlGjzONGTDAcLremjwaWv5A+EDLnxhQzY5xUZPWLOLqYRkY0Cbw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>