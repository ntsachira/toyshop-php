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
        <h1>Orders</h1>
    </div>
    <?php 
    $invoice_status = "";
    $date = "";
    $order_id = "";
    $customer_name = "";

    if(isset($_GET["status"]) && !empty($_GET["status"])){
        $invoice_status = $_GET["status"];
    }
    if(isset($_GET["date"]) && !empty($_GET["date"])){
        $date = $_GET["date"];
    }
    if(isset($_GET["id"]) && !empty($_GET["id"])){
        $order_id = $_GET["id"];
    }
    if(isset($_GET["cus"]) && !empty($_GET["cus"])){
        $customer_name = $_GET["cus"];
    }
    
    ?>

    <div class="row mb-3">
    <!-- search -->
      <div class="col-12 mb-3 bg-white  p-3  border  rounded">
        <div class="row mb-2 gap-2">
            <div clas="col-12">
                <b>Filter Orders</b>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-12 col-sm-6 col-xl-3 mb-2">
                    <select class="col ui dropdown w-100" id="invoice-status-select">
                        <option value="0">Select Status</option>
                        <?php
                        
                        $invoice_status_result = Database::execute("SELECT * FROM `invoice_status`");
                        while ($invoice_status_data = $invoice_status_result->fetch_assoc()) {
                            ?>
                            <option <?php echo ($invoice_status == $invoice_status_data['invoice_status_id'] ? "selected" : "") ?>
                                value="<?php echo $invoice_status_data['invoice_status_id'] ?>">
                                <?php echo $invoice_status_data['status_name'] ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-3 mb-2">
                        <div class="ui input w-100">
                            <input type="date" value="<?php echo $date ?>" id="order-date" >
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-3 mb-2">
                        <div class="ui input icon w-100">
                            <input type="text" placeholder="Search by Order ID..." id="order-id" value="<?php echo $order_id ?>">
                            <i class="search icon"></i>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-3 mb-2">
                        <div class="ui input icon w-100">
                            <input type="text" placeholder="Search by Customer..." id="customer-name" value="<?php echo $customer_name ?>">
                            <i class="search icon"></i>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-end align-items-center">
                        <a href="home.php?tab=orders" class="ui button ">Clear</a>
                        <a class="ui button  primary" onclick="searchOrders();">Search</a>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <!-- search end -->
        <?php
        $invoice_per_page = 10;
        $page = 1;

        $invoices = Database::execute("SELECT * FROM `invoice` INNER JOIN `user` ON `invoice`.`user_email` = `user`.`email` 
        WHERE `invoice_status_invoice_status_id` LIKE '%".$invoice_status."%' AND `date` LIKE '%".$date."%' AND 
        (`email` LIKE '%".$customer_name."%' OR `first_name` LIKE '%".$customer_name."%' OR `last_name` LIKE '%".$customer_name."%') AND 
        `invoice_id` LIKE '%".$order_id."%'");
        $number_of_invoice = $invoices->num_rows;

        if (isset($_GET["invoice_per_page"])) {
            $invoice_per_page = $_GET["invoice_per_page"];
        }

        $number_of_pages = ceil($number_of_invoice / $invoice_per_page);

        if (isset($_GET["page"])) {
            $page = $_GET["page"];
        }

        $invoice_result = Database::execute("SELECT `invoice_id`,
        SUM((`invoice_item_quantity`*`invoice_item_price`)+(`shipping_fee`*CEIL(invoice_item_quantity/2))) AS `price`,
        SUM(`shipping_fee`*CEIL(invoice_item_quantity/2)) AS ship_price,SUM(`invoice_item_quantity`*`invoice_item_price`) AS `sub_total`,
        `invoice_status_invoice_status_id` AS `status`,`date`,CONCAT(`first_name`,' ',`last_name`) AS `name`,`user_email`
         FROM `invoice` INNER JOIN `invoice_item` ON `invoice`.`invoice_id` = `invoice_item`.`invoice_invoice_id`
         INNER JOIN `user` ON `user`.`email`=`invoice`.`user_email` 
        WHERE `invoice_status_invoice_status_id` LIKE '%".$invoice_status."%' AND `date` LIKE '%".$date."%' AND 
        (`email` LIKE '%".$customer_name."%' OR `first_name` LIKE '%".$customer_name."%' OR `last_name` LIKE '%".$customer_name."%') AND 
        `invoice_id` LIKE '%".$order_id."%'  GROUP BY `invoice_id` ORDER BY `date` DESC 
         LIMIT $invoice_per_page  OFFSET " . (($page - 1) * $invoice_per_page));

        ?>
        <div class="col-12 mb-3 py-3 border bg-white rounded align-items-center d-flex justify-content-between">
            <span><b>
                    <?php echo $number_of_invoice ?> Order results
                </b> ( Showing page
                <?php echo $page ?> of
                <?php echo $number_of_pages ?> )
            </span>
            <!-- pagination top -->
            <div class="ui right floated pagination menu">
                <?php
                if ($page > 1) {
                    ?>
                    <a href="?tab=orders&page=<?php echo $page - 1 ?>" class="icon item">
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
                    <a href="?tab=orders&page=<?php echo $i ?>" class="item <?php echo $page == $i ? "active" : "" ?>">
                        <?php echo $i ?>
                    </a>
                    <?php
                }

                if ($page < $number_of_pages) {
                    ?>
                    <a href="?tab=orders&page=<?php echo $page + 1 ?>" class="icon item">
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
        <div class="col-12 bg-white overflow-auto table-responsive p-3 mb-3 border rounded ">
            <table class="table  table-bordered align-middle ">
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
                                        <img src="../resource/<?php echo $user_image_path ?>" class="ui rounded image" style="height:3rem;width:3rem;object-fit:cover;">
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
                                            style="background-color:#dddddd" ><a class="ui black empty circular label"></a>Awaiting Confirm
                                        </div>
                                        <?php
                                    } else if ($invoice_data["status"] == 2) {
                                        ?>
                                            <div class="rounded-5 py-2 px-3 d-flex gap-2 justify-content-center align-items-center"
                                                style="background-color:#ffd8b0 ;"><a class="ui orange empty circular label"></a>Out for
                                                Delivery</div>
                                        <?php
                                    } else if ($invoice_data["status"] == 4) {
                                        ?>
                                            <div class="rounded-5 py-2 px-3 d-flex gap-2 justify-content-center align-items-center"
                                                style="background-color:#c6e2ff ;"><a class="ui blue empty circular label"></a>Confirmed</div>
                                        <?php
                                    } else if ($invoice_data["status"] == 5) {
                                        ?>
                                            <div class="rounded-5 py-2 px-3 d-flex gap-2 justify-content-center align-items-center"
                                                style="background-color:#eacbf3 ;"><a class="ui purple empty circular label"></a>Packaging</div>
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
                                            <button class="ui button teal" onclick="confirmOrder('<?php echo $invoice_data['invoice_id'] ?>')">Confirm</button>
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
                            <td colspan="6" class="text-center">No Orders Found</td>
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
                            <span id="user-name">Sahan Perera</span>
                        </div>
                        <div class="ui red icon mini button h-auto w-auto position-absolute " onclick="closeModal('');">
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
                                    
                                    <button class="ui w-100 button orange" onclick="updateOrderStatus();">Update Status</button>
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
        <div class="col-12 d-flex bg-white p-3 rounded border align-items-center justify-content-between ">
            <!-- Number of users per page change option -->
            <div class="content">
                Showing
                <div class="ui inline dropdown"><i class="dropdown icon"></i>
                    <div class="text">
                        <?php echo $invoice_per_page ?>
                    </div>
                    <div class="menu">
                        <a href="<?php echo $_SERVER['REQUEST_URI'] ?>&invoice_per_page=10" class="item"
                            data-text="10">10</a>
                        <a href="<?php echo $_SERVER['REQUEST_URI'] ?>&invoice_per_page=15" class="item"
                            data-text="15">15</a>
                        <a href="<?php echo $_SERVER['REQUEST_URI'] ?>&invoice_per_page=20" class="item"
                            data-text="20">20</a>
                        <a href="<?php echo $_SERVER['REQUEST_URI'] ?>&invoice_per_page=30" class="item"
                            data-text="30">30</a>
                    </div>
                </div>
                orders per page
            </div>
            <!-- Number of products per page change option -->
            <!-- pagination bottom -->
            <div class="ui right floated pagination menu">
                <?php
                if ($page > 1) {
                    ?>
                    <a href="?tab=orders&page=<?php echo $page - 1 ?>" class="icon item">
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
                    <a href="?tab=orders&page=<?php echo $i ?>" class="item <?php echo $page == $i ? "active" : "" ?>">
                        <?php echo $i ?>
                    </a>
                    <?php
                }

                if ($page < $number_of_pages) {
                    ?>
                    <a href="?tab=orders&page=<?php echo $page + 1 ?>" class="icon item">
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