<!DOCTYPE html>
<html>

<body
    onload="loadCategorySalesChart();loadSalesChart(); loadChart();customerStatusChart();orderStatusChart();totalOrderChart();revernueByCategoryChart();">
    <div class="row mb-3 align-items-start">
        <h1 class="col-12 col-sm-6 col-lg-8 col-xl-9">Analytics</h1>
        <a href="home.php?tab=analytics" class="col ui button ">Refresh</a>
        <a href="home.php?tab=report" class="col ui button secondary">Generate</a>
    </div>
    <div class="row m-0 gap-3">
        <div class="col-12 col-sm mb-3">
            <div class="row gap-3 align-items-start">
                <div class="col-12">
                    <h4>Customer Analytics</h4>
                </div>
                <?php
                $user_result = Database::execute("SELECT * FROM `user`  WHERE `email` != 'admin@gmail.com'");
                ?>
                <div class="col-12 py-2 px-3 border rounded bg-white  border-bottom">
                    <div class="fs-6 fw-semibold d-flex justify-content-between">Total Registered Customers<i
                            class="users icon text-default fs-5"></i></div>
                    <p class="text-center fs-4 text-default fw-bold">
                        <?php echo number_format($user_result->num_rows, 0) ?>
                    </p>
                </div>

                <!-- chart -->
                <div class="col-12 py-3 ps-4 pe-0 border rounded bg-white  border-bottom">
                    <div class="fs-6 fw-semibold ">USER STATISTICS</div>
                    <div class=" ">
                        <canvas id="myChart" class="row  w-100 h-auto"></canvas>
                    </div>
                </div>
                <!-- chart -->
                <div class="col col-sm-12 col-xxl py-2 px-3 border rounded bg-white  border-bottom">
                    <div class="fs-6 fw-semibold d-flex justify-content-between">Active Customers</div>
                    <?php
                    $active_user_result = Database::execute("SELECT * FROM `user`  WHERE `email` != 'admin@gmail.com' AND `status_status_id` = '1'");
                    ?>
                    <p class="text-center fs-4 text-success fw-bold"><span>
                            <?php echo number_format($active_user_result->num_rows, 0) ?>
                        </span> <i class="users icon text-success fs-5"></i></p>
                </div>
                <div class="col col-sm-12 col-xxl py-2 px-3 border rounded bg-white  border-bottom">
                    <div class="fs-6 fw-semibold d-flex justify-content-between">Inactive Customers
                    </div>
                    <p class="text-center fs-4 text-danger fw-bold"><span>
                            <?php echo number_format(($user_result->num_rows) - ($active_user_result->num_rows), 0) ?>
                        </span> <i class="users icon text-danger fs-5"></i></p>
                </div>

                <!-- chart -->
                <div class="col-12 py-3 ps-4 pe-0 border rounded bg-white  border-bottom">
                    <div class="fs-6 fw-semibold ">CUSTOMERS' STATUS</div>
                    <div class=" ">
                        <canvas id="customerStatusChart" class="row  w-100 h-auto"></canvas>
                    </div>
                </div>
                <div class="col-12 py-3 ps-4 border rounded bg-white ">
                    <div class="fs-6 mb-2 fw-semibold d-flex justify-content-between">CUSTOMER ENGUAGEMENT<span
                            class="fs-3 d-none d-xl-inline">🏆</span></div>
                    <p>These Customer expected to spend the most at your store</p>
                    <div class="row">
                        <?php
                        $medals = ["🥇", "🥈", "🥉"];

                        $most_engaged_users = Database::execute("SELECT `email`,CONCAT(`first_name`,' ',`last_name`) AS `name`,
                        SUM((`invoice_item_quantity`*`invoice_item_price`)+(`shipping_fee`*CEIL(invoice_item_quantity/2))) AS `amount`
                        FROM  `product` INNER JOIN `invoice_item` ON `invoice_item`.`product_product_id`=`product`.`product_id` 
                        INNER JOIN `invoice` ON `invoice`.`invoice_id` = `invoice_item`.`invoice_invoice_id`
                        INNER JOIN `user` ON `user`.`email`=`invoice`.`user_email`GROUP BY `user_email` ORDER BY `amount` DESC LIMIT 3");

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
                                                <span class="d-xl-none d-none d-md-inline">
                                                    <?php echo $x + 1 ?>.
                                                </span>
                                                <img src="../resource/<?php echo $user_image_path ?>"
                                                    class="d-md-none d-xl-inline ui mini rounded-circle image"
                                                    style="height:2.5rem;width:2.5rem;object-fit:cover">
                                                <div class="content">
                                                    <?php echo $rank_data["name"] ?>
                                                    <div class="sub header">Rs.
                                                        <?php echo number_format($rank_data["amount"], 2) ?>
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
                <div class="col-12">
                    <h4>Stock Analytics</h4>
                </div>
                <div class="col-12 py-3 ps-4 border rounded bg-white border-danger " id="sold-out-container">
                    
                    <script>
                        $.get("process/loadSoldOutProcess.php", (res) => { $("#sold-out-container").html(res) });
                    </script>
                </div>
            </div>


        </div>
        <div class="col-12 col-sm mb-3">
            <div class="row gap-3 align-items-start">
                <div class="col-12">
                    <h4>Product Analytics</h4>
                </div>
                <!-- chart -->
                <div class="col-12 py-3 ps-4 pe-0 border rounded bg-white  border-bottom">
                    <div class="fs-6 fw-semibold ">TOTAL SALES BY CATEGORY</div>
                    <div class=" ">
                        <canvas id="categorySalesChart" class="row  w-100 h-auto"></canvas>
                    </div>
                </div>
                <!-- chart -->
                <div class="col-12 p-3 border rounded bg-white  border-bottom">
                    <div class="fs-6 fw-semibold d-flex justify-content-between">TOP SELLING PRODUCTS OF THE MONTH<i
                            class="trophy icon text-orange fs-5"></i></div>
                    <p class="text-center fs-3">🥇🥈🥉</p>
                    <div class="ui items" style="margin-top:-1rem">
                        <?php
                        $invoice_result = Database::execute("SELECT * FROM `invoice`");
                        if ($invoice_result->num_rows != 0) { //* checking if invoices are available                           
                        
                            $invoice_item_current_result = Database::execute("SELECT `product_product_id`,SUM(invoice_item_quantity) AS `product_count` FROM `invoice` 
                                        INNER JOIN `invoice_item` ON `invoice`.`invoice_id`=`invoice_item`.`invoice_invoice_id` WHERE `date` LIKE '%" . date("y-m") . "%'
                                         GROUP BY `product_product_id` ORDER BY `product_count` DESC LIMIT 3 OFFSET 0 ");

                            if ($invoice_item_current_result->num_rows != 0) { //* checking if invoices are available for current year
                        
                                while ($invoice_item_current_data = $invoice_item_current_result->fetch_assoc()) {
                                    $product_result = Database::execute("SELECT * FROM `product` WHERE `product_id` = '" . $invoice_item_current_data['product_product_id'] . "'");
                                    $product_data = $product_result->fetch_assoc();

                                    $image_result = Database::execute("SELECT * FROM `product_image` WHERE `product_product_id` = '" . $product_data['product_id'] . "'");
                                    $image_path = "resource/product_image/emptyImage.jpg";
                                    if ($image_result->num_rows != 0) {
                                        $image_data = $image_result->fetch_assoc();
                                        $image_path = $image_data['image_path'];
                                    }
                                    ?>
                                    <div class="item border-top pt-3">
                                        <div class="image img-thumbnail overflow-hidden" style="width:5rem;height:5rem;">
                                            <img src="../resource/product_image/<?php echo $image_path ?>"
                                                style="width:5rem;height:5rem;object-fit: contain;">
                                        </div>
                                        <div class="content">
                                            <a class="fw-bold fs-6 card-title">
                                                <?php echo $product_data["title"] ?>
                                            </a>
                                            <div class="meta">
                                                <span class="fs-5 text-blue"><b>
                                                        <?php echo $invoice_item_current_data["product_count"] ?>
                                                    </b> Items Sold</span>
                                            </div>

                                            <?php
                                            $product_qty_result = Database::execute("SELECT * FROM `product` WHERE `product_id` = '" . $product_data['product_id'] . "'");
                                            $product_qty_data = $product_qty_result->fetch_assoc();
                                            ?>
                                            <div
                                                class="extra text-orange text-center d-flex justify-content-between align-items-center">
                                                Remaining quantity: <b>
                                                    <?php echo $product_qty_data["quantity"] ?>
                                                </b>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }

                            } else {
                                // no data available
                                ?>
                                <p>No data Available</p>
                                <?php
                            }
                        } else {
                            // no data available
                            ?>
                            <p>No data Available</p>
                            <?php
                        }
                        ?>

                    </div>
                </div>
                <div class="col-12 py-2 px-3 border rounded bg-white  border-bottom">
                    <div class="fs-6 fw-semibold d-flex justify-content-between">TOP SELLING PRODUCTS OF THE YEAR<i
                            class="trophy icon text-blue fs-5"></i></div>
                    <p class="text-center fs-3">🥇🥈🥉</p>
                    <div class="ui items" style="margin-top:-1rem">
                        <?php
                        $invoice_result = Database::execute("SELECT * FROM `invoice`");
                        if ($invoice_result->num_rows != 0) { //* checking if invoices are available                           
                        
                            $invoice_item_current_result = Database::execute("SELECT `product_product_id`,SUM(invoice_item_quantity) AS `product_count` FROM `invoice` 
                                        INNER JOIN `invoice_item` ON `invoice`.`invoice_id`=`invoice_item`.`invoice_invoice_id` WHERE `date` LIKE '%" . date("Y") . "%'
                                         GROUP BY `product_product_id` ORDER BY `product_count` DESC LIMIT 3 OFFSET 0 ");

                            if ($invoice_item_current_result->num_rows != 0) { //* checking if invoices are available for current year
                        
                                while ($invoice_item_current_data = $invoice_item_current_result->fetch_assoc()) {
                                    $product_result = Database::execute("SELECT * FROM `product` WHERE `product_id` = '" . $invoice_item_current_data['product_product_id'] . "'");
                                    $product_data = $product_result->fetch_assoc();

                                    $image_result = Database::execute("SELECT * FROM `product_image` WHERE `product_product_id` = '" . $product_data['product_id'] . "'");
                                    $image_path = "resource/product_image/emptyImage.jpg";
                                    if ($image_result->num_rows != 0) {
                                        $image_data = $image_result->fetch_assoc();
                                        $image_path = $image_data['image_path'];
                                    }
                                    ?>
                                    <div class="item border-top pt-3">
                                        <div class="image img-thumbnail overflow-hidden" style="width:5rem;height:5rem;">
                                            <img src="../resource/product_image/<?php echo $image_path ?>"
                                                style="width:5rem;height:5rem;object-fit: contain;">
                                        </div>
                                        <div class="content">
                                            <a class="fw-bold fs-6 card-title">
                                                <?php echo $product_data["title"] ?>
                                            </a>
                                            <div class="meta">
                                                <span class="fs-5 text-blue"><b>
                                                        <?php echo $invoice_item_current_data["product_count"] ?>
                                                    </b> Items Sold</span>
                                            </div>

                                            <?php
                                            $product_qty_result = Database::execute("SELECT * FROM `product` WHERE `product_id` = '" . $product_data['product_id'] . "'");
                                            $product_qty_data = $product_qty_result->fetch_assoc();
                                            ?>
                                            <div
                                                class="extra text-orange text-center d-flex justify-content-between align-items-center">
                                                Remaining quantity: <b>
                                                    <?php echo $product_qty_data["quantity"] ?>
                                                </b>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }

                            } else {
                                ?>
                                <p>No data Available</p>
                                <?php
                            }
                        } else {
                            ?>
                            <p>No data Available</p>
                            <?php
                        }
                        ?>

                    </div>
                </div>
                <div class="col-12 py-3 ps-4 border rounded bg-white  border-bottom" id="limited-stock-container">
                                        
                    <script>
                        $.get("process/loadLimitedStockProcess.php", (res) => { $("#limited-stock-container").html(res) });
                    </script>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg mb-3">
            <div class="row gap-3 align-items-start">
                <div class="col-12">
                    <h4>Sales Analytics</h4>
                </div>
                <div class="col-12">
                    <div class="row gap-3">
                        <div class="col py-2 px-3 border rounded bg-white  border-bottom">                            
                            <div class="fs-6 fw-semibold d-flex justify-content-between">Total Orders<i
                                    class="boxes icon text-default  fs-5"></i></div>
                            <p class="text-center fs-4 text-default fw-bold">
                                <?php 
                                $order_result = Database::execute("SELECT * FROM `invoice`");
                                echo number_format($order_result->num_rows,0);
                                ?>
                            </p>
                        </div>
                        <div class="col col-lg-12 col-xl py-2 px-3 border rounded bg-white  border-bottom">
                            <div class="fs-6 fw-semibold d-flex justify-content-between">Active Orders<i
                                    class="box icon text-blue fs-5"></i></div>
                            <p class="text-center fs-4 text-blue fw-bold">
                            <?php 
                                $order_result = Database::execute("SELECT * FROM `invoice` WHERE `invoice_status_invoice_status_id` NOT IN ('6','3')");
                                echo number_format($order_result->num_rows,0);
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm col-lg-12 col-xl py-2 px-3 border rounded bg-white  border-bottom">
                    <div class="fs-6 fw-semibold d-flex justify-content-between">Completed Orders<i
                            class="box icon text-success fs-5"></i></div>
                    <p class="text-center fs-4 text-success fw-bold">
                    <?php 
                                $order_result = Database::execute("SELECT * FROM `invoice` WHERE `invoice_status_invoice_status_id` = '3' ");
                                echo number_format($order_result->num_rows,0);
                                ?>
                    </p>
                </div>
                <div class="col-12 col-sm col-lg-12 col-xl py-2 px-3 border rounded bg-white  border-bottom">
                    <div class="fs-6 fw-semibold d-flex justify-content-between">Cancelled Orders<i
                            class="box icon text-danger fs-5"></i></div>
                    <p class="text-center fs-4 text-danger fw-bold">
                    <?php 
                                $order_result = Database::execute("SELECT * FROM `invoice`  WHERE `invoice_status_invoice_status_id` = '6'");
                                echo number_format($order_result->num_rows,0);
                                ?>
                    </p>
                </div>
                <!-- chart -->
                <div class="col-12 py-3 ps-4 pe-0 border rounded bg-white  border-bottom">
                    <div class="fs-6 fw-semibold ">TOTAL SALES OVER TIME (LKR)</div>
                    <div class=" ">
                        <canvas id="salesChart" class="row  w-100 h-auto"></canvas>
                    </div>
                </div>
                <!-- chart -->
                <div class="col-12 col-sm col-lg-12 py-3 ps-4 pe-0 border rounded bg-white  border-bottom">
                    <div class="fs-6 fw-semibold ">TOTAL REVERNURE BY CATEGORY</div>
                    <div class=" ">
                        <canvas id="revernueByCategoryChart" class="row  w-100 h-auto"></canvas>
                    </div>
                </div>
                <!-- chart -->
                <div class="col-12 col-sm col-lg-12 py-3 ps-4 pe-0 border rounded bg-white  border-bottom">
                    <div class="fs-6 fw-semibold ">ORDERS' STATUS</div>
                    <div class=" ">
                        <canvas id="orderStatusChart" class="row  w-100 h-auto"></canvas>
                    </div>
                </div>
                <!-- chart -->
                <div class="col-12  py-3 ps-4 pe-0 border rounded bg-white  border-bottom">
                    <div class="fs-6 fw-semibold ">TOTAL ORDERS OVER TIME</div>
                    <div class=" ">
                        <canvas id="totalOrdersChart" class="row  w-100 h-auto"></canvas>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js"
        integrity="sha512-L0Shl7nXXzIlBSUUPpxrokqq4ojqgZFQczTYlGjzONGTDAcLremjwaWv5A+EDLnxhQzY5xUZPWLOLqYRkY0Cbw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>