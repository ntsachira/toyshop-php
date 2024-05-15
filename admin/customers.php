<?php
if (!isset($_SESSION["admin"]["email"])) {
    ?>
    <script>
        window.location = "index.php";
    </script>
    <?php
}
?>
<!DOCTYPE html>

<html>

<body>
    <div class="row mb-3">
        <h1>Customers</h1>
    </div>
    <?php

    $customer = "";

    if (isset($_GET["key"]) && !empty($_GET["key"])) {
        $customer = $_GET["key"];
    }

    ?>
    <div class="row mb-3 ">
        <!-- search -->
        <div class="col-12 mb-3 bg-white  p-3  border  rounded">
            <div class="row mb-2 gap-2">
                <div clas="col-12">
                    <b>Filter Customers</b>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col mb-2 mb-sm-0">
                            <div class="ui input icon w-100">
                                <input type="text" placeholder="Search by Customer..." id="search-text"
                                    value="<?php echo $customer ?>">
                                <i class="search icon"></i>
                            </div>
                        </div>
                        <div class="col-12 col-sm-5  col-lg-3 d-flex align-items-center">
                            <a class="ui button  primary" onclick="searchCustomers();">Search</a>
                            <a href="home.php?tab=customers" class="ui button ">Clear</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- search end -->
        <?php
        $user_result1 = Database::execute("SELECT * FROM `user` WHERE `email` != 'admin@gmail.com' AND 
        (`email` LIKE '%" . $customer . "%' OR `mobile` LIKE '%" . $customer . "%' OR `first_name` LIKE '%" . $customer . "%' OR `last_name` LIKE '%" . $customer . "%' ) 
        ");
        $number_of_users = $user_result1->num_rows;

        $users_per_page = 5;
        $page = 1;

        if (isset($_GET["users_per_page"])) {
            $users_per_page = $_GET["users_per_page"];
        }

        $number_of_pages = ceil($number_of_users / $users_per_page);

        if (isset($_GET["page"])) {
            $page = $_GET["page"];
        }


        ?>
        <div class=" col-12 mb-3 py-3 border bg-white rounded align-items-center d-flex justify-content-between">
            <span><b>
                    <?php echo $number_of_users ?> User results
                </b> ( Showing page
                <?php echo $page ?> of
                <?php echo $number_of_pages ?> )
            </span>
            <!-- pagination top -->
            <div class="ui right floated pagination menu">
                <?php
                if ($page > 1) {
                    ?>
                    <a href="?tab=customers&page=<?php echo $page - 1 ?>" class="icon item">
                        <i class="left chevron icon"></i>
                    </a>
                    <?php
                } else {
                    ?>
                    <a class="icon item">
                        <i class="left chevron icon"></i>
                    </a>
                    <?php
                }
                ?>

                <?php
                for ($i = 1; $i <= $number_of_pages; $i++) {
                    ?>
                    <a href="?tab=customers&page=<?php echo $i ?>" class="item <?php echo $page == $i ? "active" : "" ?>">
                        <?php echo $i ?>
                    </a>
                    <?php
                }

                if ($page < $number_of_pages) {
                    ?>
                    <a href="?tab=customers&page=<?php echo $page + 1 ?>" class="icon item">
                        <i class="right chevron icon"></i>
                    </a>
                    <?php
                } else {
                    ?>
                    <a class="icon item">
                        <i class="right chevron icon"></i>
                    </a>
                    <?php
                }

                ?>

            </div>
            <!-- pagination top -->
        </div>
        <div class=" bg-white col-12 overflow-auto p-3 border rounded mb-3">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width:11rem;min-width:11rem">Email</th>
                        <th style="width:20rem;min-width:20rem">Customer</th>
                        <th class="text-center" style="width:9rem;min-width:9rem">mobile</th>
                        <th class="text-center" style="width:9rem;min-width:9rem">Joined Date</th>
                        <th class="text-center" style="width:9rem;min-width:9rem">Status</th>
                        <th class="text-center" style="width:9rem;min-width:9rem">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $user_result = Database::execute("SELECT * FROM `user`  WHERE `email` != 'admin@gmail.com' AND
                    (`email` LIKE '%" . $customer . "%' OR `mobile` LIKE '%" . $customer . "%' OR `first_name` LIKE '%" . $customer . "%' OR `last_name` LIKE '%" . $customer . "%' ) 
                    LIMIT $users_per_page OFFSET " . (($page - 1) * $users_per_page));
                    if ($user_result->num_rows > 0) {
                        while ($user_data = $user_result->fetch_assoc()) {

                            $image_result = Database::execute("SELECT * FROM `user_image` WHERE `user_email`='" . $user_data["email"] . "' ");

                            $image_path = "new_user.svg";

                            if ($image_result->num_rows == 1) {
                                $image_data = $image_result->fetch_assoc();
                                $image_path = "user_image/" . $image_data["image_path"];
                            }

                            ?>

                            <tr>
                                <td>
                                    <?php echo $user_data["email"] ?>
                                </td>
                                <td>
                                    <h4 class="ui image header">
                                        <img src="../resource/<?php echo $image_path ?>" class="ui rounded image" style="height:3rem;width:3rem;object-fit:cover;">
                                        <div class="content">
                                            <?php echo $user_data["first_name"] . " " . $user_data["last_name"] ?>

                                            <div class="sub header">
                                                <?php
                                                $address_data = "";
                                                $city_data = "";
                                                $address_result = Database::execute("SELECT * FROM `user_has_address` WHERE `user_email`='" . $user_data["email"] . "' ");
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
                                    <?php echo $user_data["mobile"] ?>
                                </td>
                                <td class="text-center">
                                    <?php echo date_format(new DateTime($user_data["joined_date"]), "M d, Y") ?>
                                </td>

                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-3">
                                        <span
                                            class="<?php echo ($user_data["status_status_id"] == '1' ? 'text-success fw-bold' : "text-secondary") ?>">
                                            <?php echo ($user_data["status_status_id"] == '1' ? 'Active' : "Inactive") ?>
                                        </span>
                                        <div class="ui toggle checkbox d-flex flex-column">
                                            <input type="checkbox" name="public" <?php if ($user_data["status_status_id"] == "1") { ?>checked <?php } ?>
                                                onchange="toggleUserStatus('<?php echo $user_data['email'] ?>');">
                                            <label></label>
                                        </div>
                                    </div>
                                </td>
                                <?php
                                $message_result = Database::execute("SELECT * FROM `message_history` WHERE 
                                   (`sender`='" . $user_data['email'] . "' AND `receiver`='admin@gmail.com') AND `seen_status_seen_status_id`='2'");

                                ?>
                                <td class="text-center">
                                    <button class="ui  basic button icon "
                                        onclick="openCustomerViewModal('<?php echo $user_data['mobile'] ?>')">
                                        <i class="eye icon"></i></button>
                                    <button class="ui button icon basic  position-relative"
                                        onclick="openMessage('<?php echo $user_data['email'] ?>',' <?php echo $user_data['first_name'] ?>')">
                                        <i class="comment alternate icon"></i>
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
                                </td>

                            </tr>

                            <!-- customer view modal -->
                            <div class="ui longer modal position-relative h-auto"
                                id="view-cutomer-modal<?php echo $user_data["mobile"] ?>">
                                <i class="close icon"></i>
                                <div class="header fs-5">
                                    Customer Profile
                                </div>
                                <div class="scrolling content" style="background-color:#f1f1f1 ;">
                                    <div class="row  px-3 gap-3 align-items-start">
                                        <div class="col-12 col-sm">
                                            <div class="row gap-3">
                                                <div class="bg-white col-12 d-flex flex-column align-items-center p-2 ">
                                                    <img src="../resource/<?php echo $image_path ?>" alt=""
                                                        style="height:15rem;width:13rem;object-fit:cover;"
                                                        class="img-thumbnail rounded-5">
                                                    <h4 class="mt-2">
                                                        <?php echo $user_data["first_name"] . " " . $user_data["last_name"] ?>
                                                    </h4>
                                                </div>
                                                <div class="bg-white col-12 p-2 ">
                                                    <h6 class="bg-lblue text-center p-2">Personal Info</h6>
                                                    <p class="d-flex px-3 justify-content-between">Email: <b>
                                                            <?php echo $user_data["email"] ?>
                                                        </b></p>
                                                    <p class="d-flex px-3 justify-content-between">Mobile: <b>
                                                            <?php echo $user_data["mobile"] ?>
                                                        </b></p>
                                                    <p class="d-flex px-3 justify-content-between">Gender: <b>
                                                            <?php echo $user_data["gender_gender_id"] == 1 ? "Male" : "Female" ?>
                                                        </b></p>
                                                    <p class="d-flex px-3 justify-content-between">Joined: <b>
                                                            <?php echo date_format(new DateTime($user_data["joined_date"]), "M d, Y") ?>
                                                        </b></p>
                                                </div>
                                                <div class="bg-white col-12 p-2">
                                                    <h6 class="bg-lblue text-center p-2">Location</h6>
                                                    <p class="d-flex px-3 justify-content-between">City: <b>
                                                            <?php echo $address_data == "" ? "Not Provided" : $city_data["city_name"] ?>
                                                        </b></p>
                                                    <p class="d-flex px-3 justify-content-between">Line 1: <b>
                                                            <?php echo $address_data == "" ? "Not Provided" : $address_data["line1"] ?>
                                                        </b></p>
                                                    <p class="d-flex px-3 justify-content-between">Line 2: <b>
                                                            <?php echo $address_data == "" ? "Not Provided" : $address_data["line2"] ?>
                                                        </b></p>
                                                    <p class="d-flex px-3 justify-content-between">Postal Code: <b>
                                                            <?php echo $address_data == "" ? "Not Provided" : $address_data["postal_code"] ?>
                                                        </b></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm">
                                            <div class="row gap-3">
                                                <div class="bg-white col-12 p-2">
                                                    <?php 
                                                        $last_purchased_date = "Not available";
                                                        $total_orders = "Not available";
                                                        $total_reviews = "Not available";
                                                        $total_spent = 0;
                                                        $invoice_data ="";
                                                        $invoice_result = Database::execute("SELECT * FROM `invoice` INNER JOIN `invoice_status` ON
                                                        `invoice`.`invoice_status_invoice_status_id` = `invoice_status`.`invoice_status_id` 
                                                        WHERE `user_email` = '".$user_data["email"]."' 
                                                        ORDER BY `date` DESC ");
                                                        if($invoice_result->num_rows > 0){
                                                            $invoice_data = $invoice_result->fetch_assoc();

                                                            $last_purchased_date = $invoice_data["date"];
                                                            $total_orders = $invoice_result->num_rows;
                                                        }

                                                        $review_result = Database::execute("SELECT * FROM `reviews` WHERE `user_email` =  '".$user_data["email"]."' ");
                                                        $total_reviews = $review_result->num_rows;

                                                        $total_result  = Database::execute("SELECT `invoice_id`,
                                                        SUM((`invoice_item_quantity`*`invoice_item_price`)+(`shipping_fee`*CEIL(invoice_item_quantity/2))) AS `price`,
                                                        SUM(`shipping_fee`*CEIL(invoice_item_quantity/2)) AS ship_price,SUM(`invoice_item_quantity`*`invoice_item_price`) AS `sub_total`,
                                                        `invoice_status_invoice_status_id` AS `status`,`date`,CONCAT(`first_name`,' ',`last_name`) AS `name`,`user_email`
                                                         FROM `invoice` INNER JOIN `invoice_item` ON `invoice`.`invoice_id` = `invoice_item`.`invoice_invoice_id`
                                                         INNER JOIN `user` ON `user`.`email`=`invoice`.`user_email` WHERE `user_email` =  '".$user_data["email"]."'");

                                                        while($total_data = $total_result->fetch_assoc()){
                                                            $total_spent = $total_spent + ($total_data["ship_price"]+$total_data["sub_total"]);
                                                        }
                                                    ?>
                                                    <h6 class="bg-lblue text-center p-2">Activity</h6>
                                                    <p class="d-flex px-3 justify-content-between">Status: <b>
                                                            <?php echo ($user_data["status_status_id"] == '1' ? 'Active' : "Inactive") ?>
                                                        </b></p>
                                                    <p  class="d-flex px-3 justify-content-between">Last Purchased date: <b>
                                                            <?php echo $last_purchased_date ?>
                                                        </b></p>
                                                    <p class="d-flex px-3 justify-content-between">Total Orders: <b>
                                                            <?php echo $total_orders ?>
                                                        </b></p>
                                                    <p  class="d-flex px-3 justify-content-between">Total Reviews: <b>
                                                            <?php echo $total_reviews ?>
                                                        </b></p>
                                                    <p class="d-flex px-3 justify-content-between">Total spent: <b>
                                                            Rs. <?php echo number_format($total_spent,2) ?>
                                                        </b></p>
                                                </div>
                                                <div class="col-12 bg-white p-2">
                                                    <?php 
                                                    $total_amount = 0;
                                                    $number_of_items = 0;

                                                    if(isset($invoice_data["invoice_id"])){
                                                        $order_result  = Database::execute("SELECT `invoice_id`,
                                                    SUM((`invoice_item_quantity`*`invoice_item_price`)+(`shipping_fee`*CEIL(invoice_item_quantity/2))) AS `price`,
                                                    SUM(`shipping_fee`*CEIL(invoice_item_quantity/2)) AS ship_price,SUM(`invoice_item_quantity`*`invoice_item_price`) AS `sub_total`,
                                                    `invoice_status_invoice_status_id` AS `status`,`date`,CONCAT(`first_name`,' ',`last_name`) AS `name`,`user_email`
                                                     FROM `invoice` INNER JOIN `invoice_item` ON `invoice`.`invoice_id` = `invoice_item`.`invoice_invoice_id`
                                                     INNER JOIN `user` ON `user`.`email`=`invoice`.`user_email` WHERE `invoice_id` =  '".$invoice_data["invoice_id"]."'");

                                                     if($order_result->num_rows == 1){
                                                        $order_data = $order_result->fetch_assoc();
                                                        $total_amount = $order_data["ship_price"]+$order_data["sub_total"];
                                                     }

                                                     $invoice_items = Database::execute("SELECT * FROM `invoice_item` WHERE `invoice_invoice_id` ='".$invoice_data["invoice_id"]."' ");
                                                     if($invoice_items->num_rows > 0){
                                                        $number_of_items = $invoice_items->num_rows;
                                                     }
                                                    }
                                                    
 
                                                    ?>
                                                    <h6 class="bg-lblue text-center p-2">Last Order</h6>
                                                    <p class="d-flex px-3 justify-content-between">Order ID: <b>
                                                            <?php echo isset($invoice_data["invoice_id"])?$invoice_data["invoice_id"]:"Not available" ?>
                                                        </b></p>
                                                    <p class="d-flex px-3 justify-content-between">Number of Items: <b>
                                                            <?php echo $number_of_items ?>
                                                        </b></p>
                                                    <p class="d-flex px-3 justify-content-between">Total: <b>
                                                            Rs. <?php echo number_format($total_amount,2) ?>
                                                        </b></p>
                                                    <p class="d-flex px-3 justify-content-between">Status: <b>
                                                            <?php echo isset($invoice_data["status_name"])?$invoice_data["status_name"]:"Not available" ?>
                                                        </b></p>
                                                    <p class="d-flex px-3 justify-content-between">Placed on: <b>
                                                            <?php echo isset($invoice_data["date"])?$invoice_data["date"]:"Not available" ?>
                                                        </b></p>
                                                </div>
                                                <div class="col-12 bg-white p-2">
                                                    <?php 
                                                    $last_review = Database::execute("SELECT invoice_invoice_id AS order_id,title,user_review AS review,rate,review_date AS date 
                                                    FROM `reviews` INNER JOIN `invoice_item` ON `invoice_item`.invoice_item_id = reviews.invoice_item_invoice_item_id
                                                    INNER JOIN product ON product.product_id = invoice_item.product_product_id WHERE `user_email` = '".$user_data["email"]."'
                                                    ORDER BY `review_date` DESC ");

                                                    $order_id = "Not available";
                                                    $title = "Not available";
                                                    $rate = 0;
                                                    $review = "Not available";
                                                    $review_date = "Not available";

                                                    if($last_review->num_rows > 0){
                                                        $last_review_data = $last_review->fetch_assoc();

                                                        $order_id = $last_review_data["order_id"];
                                                        $title = $last_review_data["title"];
                                                        $rate = $last_review_data["rate"];
                                                        $review = $last_review_data["review"];
                                                        $review_date = $last_review_data["date"];
                                                    }
                                                    ?>
                                                    <h6 class="bg-lblue text-center p-2">Last Review</h6>
                                                    <p  class="d-flex px-3 justify-content-between">Order ID: <b>
                                                            <?php echo $order_id ?>
                                                        </b></p>
                                                    <p class="d-flex px-3 justify-content-between">Item: <b class="card-title">
                                                            <?php echo $title ?>
                                                        </b></p>
                                                    <p class="d-flex px-3 justify-content-between">Rate: <b>
                                                            <?php echo $rate ?>
                                                        </b></p>
                                                    <p class="d-flex px-3 justify-content-between">Review: <b>
                                                            <?php echo $review ?>
                                                        </b></p>
                                                    <p class="d-flex px-3 justify-content-between">Placed on: <b>
                                                            <?php echo $review_date ?>
                                                        </b></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="actions">
                                    <button class="ui button secondary"
                                        onclick="openCustomerViewModal('<?php echo $user_data['mobile'] ?>')">Close</button>
                                </div>

                            </div>
                            <!-- customer view modal end -->
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="7" class="text-center">No Users Found</td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
            <!-- message modal -->
            <div class="ui bg-light pb-3 pb-sm-0  longer modal position-relative h-auto w-auto" id="message-modal">
                <div class="header p-2 bg-white">
                    <div class="row px-2 justify-content-end">
                        <div class="col gap-3 d-flex align-items-center justify-content-center">
                            <img src="" style="height: 3.5rem;width: 3.5rem;object-fit:cover" alt="" id="user-image"
                                class="img-thumbnail rounded-circle">
                            <span id="user-name" style="min-width:15rem">Sahan Perera</span>
                        </div>
                        <div class="ui red icon mini button h-auto w-auto position-absolute " onclick="closeModal('');">
                            <i class="remove icon"></i>
                        </div>
                    </div>
                </div>
                <!-- messaging area -->
                <div class="scrolling content bg-light w-100" style="min-height:20rem;max-width:40rem"
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
        </div>
        <div class="col-12 d-flex bg-white p-3 rounded border align-items-center justify-content-between ">
            <!-- Number of users per page change option -->
            <div class="content">
                Showing
                <div class="ui inline dropdown"><i class="dropdown icon"></i>
                    <div class="text">
                        <?php echo $users_per_page ?>
                    </div>
                    <div class="menu">
                        <a href="<?php echo $_SERVER['REQUEST_URI'] ?>&users_per_page=5" class="item"
                            data-text="5">5</a>
                        <a href="<?php echo $_SERVER['REQUEST_URI'] ?>&users_per_page=10" class="item"
                            data-text="10">10</a>
                        <a href="<?php echo $_SERVER['REQUEST_URI'] ?>&users_per_page=15" class="item"
                            data-text="15">15</a>
                        <a href="<?php echo $_SERVER['REQUEST_URI'] ?>&users_per_page=21" class="item"
                            data-text="21">21</a>
                    </div>
                </div>
                users per page
            </div>
            <!-- Number of products per page change option -->
            <!-- pagination bottom -->
            <div class="ui right floated pagination menu">
                <?php
                if ($page > 1) {
                    ?>
                    <a href="?tab=customers&page=<?php echo $page - 1 ?>" class="icon item">
                        <i class="left chevron icon"></i>
                    </a>
                    <?php
                } else {
                    ?>
                    <a class="icon item">
                        <i class="left chevron icon"></i>
                    </a>
                    <?php
                }
                ?>

                <?php
                for ($i = 1; $i <= $number_of_pages; $i++) {
                    ?>
                    <a href="?tab=customers&page=<?php echo $i ?>" class="item <?php echo $page == $i ? "active" : "" ?>">
                        <?php echo $i ?>
                    </a>
                    <?php
                }

                if ($page < $number_of_pages) {
                    ?>
                    <a href="?tab=customers&page=<?php echo $page + 1 ?>" class="icon item">
                        <i class="right chevron icon"></i>
                    </a>
                    <?php
                } else {
                    ?>
                    <a class="icon item">
                        <i class="right chevron icon"></i>
                    </a>
                    <?php
                }

                ?>

            </div>
            <!-- pagination bottom -->
        </div>

    </div>
</body>

</html>