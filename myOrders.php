<?php
session_start();
if (!isset($_SESSION['user']['email'])) {
    header('Location:index.php');
} else {
    include_once "connection.php";
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>
            My Orders | ToyShop
        </title>
        <link rel="icon" type="image/png" href="resource/logo.png">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">

        <!-- jQuery CDN -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <!-- jQuery CDN -->

        <!-- Semantic UI CDN -->
        <script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.5.0/dist/semantic.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.5.0/dist/semantic.min.css">
        <!-- Semantic UI CDN -->
    </head>

    <body id="bd">
        <?php include 'header.php'; ?>

        <div class="container-lg">
            <div class="col-12 mb-3 border-bottom py-2">
                <div class="row d-flex align-items-center justify-content-center gap-2">                    
                    <div class="col d-flex flex-column flex-md-row gap-2">
                        <h2>📦My Orders</h2>
                    </div>
                   
                </div>
            </div>
            <!-- bread crumb -->
            <div class="ui breadcrumb my-2">
                <a href="home.php" class="section text-decoration-none">ToyShop</a>
                <i class="right angle icon divider"></i>
                <a href="userProfile.php" class="section text-decoration-none ">Profile</a>
                <i class="right angle icon divider"></i>
                <div class="active section mt-2">
                    Orders
                </div>
            </div>
            <!-- bread crumb -->
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-9 col-xl-8 mt-4">
                    <nav>
                        <div class="nav nav-tabs " id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home"
                                aria-selected="true">All</button>
                            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                                type="button" role="tab" aria-controls="nav-profile" aria-selected="false">To
                                Receive</button>
                        </div>
                    </nav>
                    <?php 
                    $page_no = 1;
                    $invoice_per_page = 5;                   

                    $invoice_count_result = Database::execute("SELECT * FROM `invoice` WHERE 
                    `user_email`='" . $_SESSION['user']['email'] . "' ");

                    $invoice_count = $invoice_count_result->num_rows;

                    $number_of_pages = ceil($invoice_count/$invoice_per_page);

                    if(isset($_GET['page']) && !empty($_GET['page'])){
                        if($_GET['page']>$number_of_pages){
                            $page_no = $number_of_pages;
                        }else{
                             $page_no = $_GET['page'];
                        }
                       
                    }
                    ?>
                    <div class="tab-content bg-light" id="nav-tabContent">
                        <!-- All orders -->
                        <div class="tab-pane fade py-3 show active" id="nav-home" role="tabpanel"
                            aria-labelledby="nav-home-tab" tabindex="0">
                            <div class="row justify-content-center m-0 p-3">
                                <?php
                                $invoice_result = Database::execute("SELECT * FROM `invoice` WHERE 
                                `user_email`='" . $_SESSION['user']['email'] . "' ORDER BY `date` DESC LIMIT 5 OFFSET ".(($page_no-1)*$invoice_per_page)." ");
                                if ($invoice_result->num_rows > 0) {
                                    while ($invoice_data = $invoice_result->fetch_assoc()) {

                                        $invoice_item_result = Database::execute("SELECT * FROM `invoice_item` INNER JOIN 
                                        `product` ON invoice_item.product_product_id = product.product_id                                
                                        WHERE `invoice_invoice_id`='" . $invoice_data['invoice_id'] . "'");


                                        ?>
                                        <div class="col-12 px-3 bg-white py-2 mb-3">
                                            <div class="row">
                                                <div class="col-9 mb-3 pb-2 border-bottom border-light curser-pointer" 
                                                onclick="openOrderModal('<?php echo $invoice_data['invoice_id'] ?>')">
                                                    <span class="fs-5">Order
                                                        <?php echo $invoice_data['invoice_id'] ?> &rightarrow;
                                                    </span>
                                                    <p class="text-secondary">Placed on
                                                        <?php echo date_format(new DateTime($invoice_data['date']), "D M Y  H:i:s"); ?>
                                                    </p>
                                                </div>
                                                <div
                                                    class="text-secondary col-3 align-items-end d-flex mb-3 pb-2 justify-content-end border-bottom border-light">
                                                    <i> Paid</i>
                                                </div>
                                                <?php
                                                $invoice_total = 0;
                                                $shippingTotal = 0;
                                                $items_list = array();
                                                while ($invoice_item_data = $invoice_item_result->fetch_assoc()) {
                                                    array_push($items_list,$invoice_item_data);

                                                    $invoice_total = $invoice_total + ($invoice_item_data['invoice_item_price']*$invoice_item_data['invoice_item_quantity']);
                                                    $shippingTotal = $shippingTotal + ($invoice_item_data['shipping_fee']*(ceil($invoice_item_data['invoice_item_quantity']/2)));

                                                    $image_result = Database::execute("SELECT * FROM `product_image` WHERE product_product_id = '" . $invoice_item_data['product_id'] . "' ");
                                                    $image_data = $image_result->fetch_assoc();
                                                    ?>
                                                    <div class="col-12 mb-3 pb-3 border-bottom border-light">
                                                        <div class="row">
                                                            <div class="w-auto position-relative" style="width:5rem;">
                                                                <img src="resource/product_image/<?php echo $image_data['image_path'] ?>"
                                                                    style="width:5rem;height:5rem;object-fit: contain;" alt="">
                                                            </div>
                                                            <div class="col w-auto d-flex flex-column">
                                                                <span>
                                                                    <?php echo $invoice_item_data['title'] ?>
                                                                </span>
                                                                <p><b>Rs.
                                                                        <?php echo number_format($invoice_item_data['invoice_item_price'], 2); ?>
                                                                    </b></p>
                                                                <div class="d-flex justify-content-between">
                                                                    <span class="text-secondary">Qty:
                                                                        <?php echo $invoice_item_data['invoice_item_quantity'] ?>
                                                                    </span>
                                                                    <?php
                                                                    if ($invoice_data['invoice_status_invoice_status_id'] == 1) {
                                                                        ?>
                                                                        <span style="background-color:#dddddd" class=" px-3 rounded-5">Awaiting Confirm</span>
                                                                        <?php
                                                                    } else if ($invoice_data['invoice_status_invoice_status_id'] == 2) {
                                                                        ?>
                                                                            <span style="background-color:#ffd8b0 ;" class="px-3 rounded-5">Out for Delevery</span>
                                                                        <?php
                                                                    } else if($invoice_data["invoice_status_invoice_status_id"] == 4){
                                                                        ?>
                                                                            <span style="background-color:#c6e2ff ;" class="px-3 rounded-5">Confirmed</span>
                                                                        <?php
                                                                    }else if($invoice_data["invoice_status_invoice_status_id"] == 5){
                                                                        ?>
                                                                            <span style="background-color:#eacbf3 ;" class=" px-3 rounded-5">Packaging</span>
                                                                        <?php
                                                                    }else if($invoice_data["invoice_status_invoice_status_id"] == 6){
                                                                        ?>
                                                                            <span style="background-color:#ffb0b0 ;" class=" px-3 rounded-5">Cancelled</span>
                                                                        <?php
                                                                    }else{
                                                                        ?>
                                                                            <span  style="background-color:#caf5c5 ;" class=" px-3 rounded-5">Delevered</span>
                                                                        <?php
                                                                    }
                                                                    ?>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                 
                                                    <?php
                                                }
                                                ?>
                                                    <div class="col-12 pb-2 d-flex border-bottom border-light align-items-center justify-content-end">
                                                        <?php echo $invoice_item_result->num_rows ?> Item<?php echo $invoice_item_result->num_rows > 1 ? "s" : "" ?>, Total :&nbsp;&nbsp;
                                                        <span class="text-orange fs-5 fw-bold"> Rs. <?php echo number_format($shippingTotal+$invoice_total,2);?></span>
                                                    </div>
                                                    <?php
                                                        if ($invoice_data['invoice_status_invoice_status_id'] == 1|$invoice_data['invoice_status_invoice_status_id'] == 4|$invoice_data['invoice_status_invoice_status_id'] == 5) {
                                                    ?>
                                                        <div class="col-12 pt-2 d-flex justify-content-center">
                                                        <button onclick="cancelOrder('<?php echo $invoice_data['invoice_id']?>');" class="ui button basic orange">Cancel Order</button>
                                                        </div>
                                                    <?php
                                                        }
                                                    ?>
                                                  
                                            </div>
                                        </div>

                                        <!-- order modal -->
                                        <div class="modal" tabindex="-1" id="order-modal<?php echo $invoice_data['invoice_id']?>">
                                        <div class="modal-dialog modal-xl modal-dialog-scrollable">
                                            <div class="modal-content">
                                            <div class="modal-header ">
                                                <h5 class="modal-title fw-bold">Order Details (<?php echo $invoice_item_result->num_rows ?> Item<?php echo $invoice_item_result->num_rows > 1 ? "s" : "" ?>)</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body py-0">
                                                <div class="row bg-light p-2 gap-2">
                                                    <div class="col-12 p-2 bg-white">
                                                    <div class="row">
                                                        <div class="col-8">
                                                        <span class="fs-6">Order
                                                            <?php echo $invoice_data['invoice_id'] ?>
                                                        </span>
                                                        <p class="text-secondary">Placed on
                                                            <?php echo date_format(new DateTime($invoice_data['date']), "d M Y  H:i:s"); ?>
                                                        </p>
                                                        </div>
                                                        <div class="col-4 d-flex justify-content-end align-items-center">
                                                        <?php 
                                                    if($invoice_data["invoice_status_invoice_status_id"] == 6){
                                                        ?>
                                                        <span  class="text-danger  px-3 rounded-5">Cancelled</span>
                                                    <?php
                                                    
                                                    }else{
                                                        
                                                        if ($invoice_data['invoice_status_invoice_status_id'] == 1|$invoice_data['invoice_status_invoice_status_id'] == 4|$invoice_data['invoice_status_invoice_status_id'] == 5) {
                                                    ?>

                                                            <button  onclick="cancelOrder('<?php echo $invoice_data['invoice_id']?>');" class="ui button basic orange">Cancel</button>
                                                            <?php 
                                                        }
                                                    }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    <?php 
                                                    if($invoice_data["invoice_status_invoice_status_id"] != 6){
                                                        ?>
                                                        <div class="col-12 p-2 bg-white d-flex justify-content-center align-items-center">
                                                        <div class="ui ordered w-100 mini steps">
                                                            <!-- processing -->
                                                            <div class="<?php if ($invoice_data['invoice_status_invoice_status_id'] == 1) { ?>
                                                                active
                                                                <?php } else{ ?>
                                                                completed
                                                                <?php } ?> step">
                                                                <div class="content">
                                                                    <div class="title">Processing</div>                    
                                                                </div>
                                                            </div>
                                                                <!-- Shipped -->
                                                            <div class="<?php if ($invoice_data['invoice_status_invoice_status_id'] == 3||$invoice_data['invoice_status_invoice_status_id'] == 2) { ?>
                                                                completed
                                                                <?php
                                                                    } else if($invoice_data["invoice_status_invoice_status_id"] == 5){
                                                                ?>
                                                                active
                                                                <?php
                                                                    }else{
                                                                ?>
                                                                disabled
                                                                <?php
                                                                    } ?> step">
                                                                <div class="content">
                                                                    <div class="title">Out for Delivery</div>                    
                                                                </div>
                                                            </div>
                                                                <!-- Delivered -->
                                                            <div class="<?php 
                                                                    if ($invoice_data['invoice_status_invoice_status_id'] == 2) {
                                            
                                                                ?>
                                                                active
                                                                <?php
                                                                    } else if ($invoice_data['invoice_status_invoice_status_id'] == 3) {
                                                                ?>
                                                                completed
                                                                <?php
                                                                    } else{
                                                                    ?>
                                                                        disabled
                                                                    <?php
                                                                }
                                                                ?> step">
                                                                <div class="content">
                                                                    <div class="title">Delivered</div>     
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    }
                                                    ?>
                                                    
                                                    
                                                    <div class="col-12 p-2 d-flex align-items-center bg-white justify-content-between">     
                                                        <button onclick="window.location = 'invoice.php?inv=<?php echo $invoice_data['invoice_id'] ?>'" 
                                                        class="ui button teal basic">Open Invoice</button>                                                   
                                                        <span class="fs-4">Total:&nbsp;&nbsp;<b> Rs. <?php echo number_format($shippingTotal+$invoice_total,2);?></b></span>
                                                    </div>
                                                   
                                                    <div class="col-12 p-2 bg-white overflow-auto">
                                                        <h5 class="fw-bold">Item list</h5>
                                                        <div class="row  mb-2 w-100" style="min-width:50rem">
                                                            <div class="col-1">ITEM</div>
                                                            <div class="col-4">DESCRIPTION</div>
                                                            <div class="col-1 d-flex justify-content-end">QTY</div>
                                                            <div class="col-2 d-flex justify-content-end">PRICE (Rs)</div>
                                                            <div class="col-2 d-flex justify-content-end">SHIPPING (Rs)</div>
                                                            <div class="col-2 d-flex justify-content-end">AMOUNT (Rs)</div>
                                                        </div>
                                                        <?php 
                                                        foreach ($items_list as $item){
                                                            
                                                            $image_result = Database::execute("SELECT * FROM `product_image` WHERE product_product_id = '" . $item['product_id'] . "' ");
                                                            $image_data = $image_result->fetch_assoc();
                                                            ?>
                                                                <div class="row mb-2 pt-3 border-top w-100" style="min-width:50rem;">
                                                                    <div class="w-auto position-relative" style="width:5rem;">
                                                                        <img src="resource/product_image/<?php echo $image_data['image_path'] ?>"
                                                                            style="width:5rem;height:5rem;object-fit: contain;" alt="">
                                                                    </div>
                                                                    <div class="col w-auto d-flex flex-column">
                                                                        <span>
                                                                            <?php echo $item['title'] ?>
                                                                        </span>
                                                                        <p><b>Rs.
                                                                                <?php echo number_format($item['invoice_item_price'], 2); ?>
                                                                            </b></p>
                                                                        <div class="d-flex justify-content-between">
                                                                            <span class="text-secondary">Qty:
                                                                                <?php echo $item['invoice_item_quantity'] ?>
                                                                            </span>
                                                                        </div>                                                                        
                                                                    </div>
                                                                        <div class="col-1 d-flex justify-content-end">
                                                                            <?php echo $item['invoice_item_quantity'] ?>
                                                                        </div>
                                                                        <div class="col-2 d-flex justify-content-end">
                                                                            <?php echo number_format($item['invoice_item_price'], 2) ?>
                                                                        </div>
                                                                        <div class="col-2 d-flex justify-content-end">
                                                                            <?php echo number_format($item['shipping_fee'] * (ceil($item['invoice_item_quantity'] / 2)), 2) ?>
                                                                        </div>
                                                                        <div class="col-2 d-flex justify-content-end">
                                                                            <?php echo number_format(($item['invoice_item_quantity'] * $item['invoice_item_price']) + ($item['shipping_fee'] * (ceil($item['invoice_item_quantity'] / 2))), 2) ?>
                                                                        </div>
                                                                </div>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="col-12 col-lg-6 p-2 bg-white">
                                                        <h5 class="text-decoration-underline">Shipping Address</h5>
                                                        <?php
                                                            $address_result = Database::execute("SELECT * FROM `user_has_address` INNER JOIN `city` ON user_has_address.city_city_id = city.city_id
                                                            WHERE `user_email` = '" . $_SESSION['user']['email'] . "'");
                                                            $address_num = $address_result->num_rows;
                                                            $address_data = $address_result->fetch_assoc();
                                                            ?>
                                                            <div class="d-flex flex-column">                                                                
                                                                <h5 class="">
                                                                    <?php echo $_SESSION['user']['first_name'] . " " . $_SESSION['user']['last_name'] ?>
                                                                </h5>
                                                                <span><?php echo $address_data['line1'].", ".$address_data['line2']?></span>
                                                                <span><?php echo $address_data['city_name']?></span>
                                                                <span>Sri Lanka</span>
                                                                <span><?php echo $address_data['postal_code']?></span>
                                                            </div>
                                                    </div>
                                                    <div class="col-12 col-lg p-2 bg-white">
                                                        <h4>Total Summary</h4>
                                                        <div class="row">
                                                            <div class="col-6">Subtotal</div>
                                                            <div class="col-6 d-flex justify-content-end">Rs. <?php echo number_format($invoice_total,2);?></div>
                                                        </div>
                                                        <div class="row mb-3">                                                            
                                                            <div class="col-6">Delivery Fee</div>
                                                            <div class="col-6 d-flex justify-content-end">Rs. <?php echo number_format($shippingTotal,2);?></div>
                                                        </div>
                                                        <div class="row px-2">                                                            
                                                           <div class="col-12 border-top"></div>
                                                        </div>
                                                        <div class="row  pt-3">                                                            
                                                            <div class="col-6">Total</div>
                                                            <div class="col-6 fs-4 d-flex justify-content-end">Rs. <?php echo number_format($invoice_total,2);?></div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>                                                
                                            </div>
                                            </div>
                                        </div>
                                        </div>

                                        
                                        <?php
                                    }
                                    ?>
                                     <!-- all orders pagination -->
                                <div class="col-12 d-flex justify-content-center">
                                    <nav aria-label="...">
                                        <ul class="pagination">
                                            <?php 
                                            if($page_no > 1){
                                                ?>
                                                <li class="page-item">
                                                <a href="myOrders.php?page=<?php echo $page_no-1 ?>" class="page-link"><i class="angle double left icon"></i></a>
                                                </li>
                                                <?php
                                            }else{
                                                ?>
                                                 <li class="page-item disabled">
                                                <span class="page-link"><i class="angle double left icon"></i></span>
                                                </li>
                                                <?php
                                            }
                                           
                                                for($i = 1; $i <= $number_of_pages; $i++){
                                                    if($page_no == $i){
                                                        ?>
                                                        <li class="page-item active" aria-current="page">
                                                        <span class="page-link"><?php echo $i ?></span>
                                                        </li>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <li class="page-item"><a class="page-link" href="myOrders.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
                                                        <?php
                                                    }
                                                }
                                                if($page_no >= $number_of_pages){
                                                    ?>
                                                    <li class="page-item disabled">
                                                    <span class="page-link"><i class="angle double right icon"></i></span>
                                                    </li>
                                                    <?php
                                                }else{
                                                    ?>
                                                     <li class="page-item ">
                                                    <a href="myOrders.php?page=<?php echo $page_no+1 ?>" class="page-link"><i class="angle double right icon"></i></a>
                                                    </li>
                                                    <?php
                                                }
                                            ?>                              
                                           
                                        </ul>
                                    </nav>
                                </div>
                                    <?php
                                } else {
                                    ?>
                                    <!-- empty order  -->
                                    <div class="col-12 mb-5 d-flex flex-column justify-content-center align-items-center">
                                        <img src="resource/emptySearch.jpg" style="max-height:30rem" alt="">
                                        <span class="fs-1 text-secondary mb-3">You have no orders placed yet</span>
                                        <a href="home.php" class="ui button orange  huge">Start Shopping Now <i
                                                class="right arrow icon"></i></a>
                                    </div>
                                    <?php
                                }
                                ?>
                               
                            </div>
                        </div>

                        <!-- To recieve -->
                        <div class="tab-pane fade py-3 " id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab"
                            tabindex="0">
                            <div class="row justify-content-center p-3 m-0">
                                <?php
                                $invoice_result = Database::execute("SELECT * FROM `invoice` WHERE `user_email`='" . $_SESSION['user']['email'] . "' 
                                AND `invoice_status_invoice_status_id` NOT IN('3','6') ORDER BY `date` DESC");
                                if ($invoice_result->num_rows > 0) {
                                    while ($invoice_data = $invoice_result->fetch_assoc()) {

                                        $invoice_item_result = Database::execute("SELECT * FROM `invoice_item` INNER JOIN `product` ON invoice_item.product_product_id = product.product_id                                
                                        WHERE `invoice_invoice_id`='" . $invoice_data['invoice_id'] . "'");


                                        ?>
                                        <div class="col-12 bg-white px-3 py-2 mb-3">
                                            <div class="row">
                                                <div class="col-9 mb-3 pb-2 border-bottom border-light curser-pointer"  
                                                onclick="openReceiveOrderModal('<?php echo $invoice_data['invoice_id'] ?>')">
                                                    <span class="fs-5">Order
                                                        <?php echo $invoice_data['invoice_id'] ?> &rightarrow;
                                                    </span>
                                                    <p class="text-secondary">Placed on
                                                        <?php echo date_format(new DateTime($invoice_data['date']), "D M Y  H:i:s"); ?>
                                                    </p>
                                                </div>
                                                <div
                                                    class="text-secondary col-3 align-items-end d-flex mb-3 pb-2 justify-content-end border-bottom border-light">
                                                    <i> Paid</i>
                                                </div>
                                                <?php
                                                $invoice_total = 0;
                                                $shippingTotal = 0;
                                                $items_list = array();
                                                while ($invoice_item_data = $invoice_item_result->fetch_assoc()) {
                                                    array_push($items_list,$invoice_item_data);
                                                    $invoice_total = $invoice_total + ($invoice_item_data['invoice_item_price']*$invoice_item_data['invoice_item_quantity']);
                                                    $shippingTotal = $shippingTotal + ($invoice_item_data['shipping_fee']*(ceil($invoice_item_data['invoice_item_quantity']/2)));

                                                    $image_result = Database::execute("SELECT * FROM `product_image` WHERE product_product_id = '" . $invoice_item_data['product_id'] . "' ");
                                                    $image_data = $image_result->fetch_assoc();
                                                    ?>
                                                    <div class="col-12 mb-3 pb-3 border-bottom border-light">
                                                        <div class="row">
                                                            <div class="w-auto position-relative" style="width:5rem;">
                                                                <img src="resource/product_image/<?php echo $image_data['image_path'] ?>"
                                                                    style="width:5rem;height:5rem;object-fit: contain;" alt="">
                                                            </div>
                                                            <div class="col w-auto d-flex flex-column">
                                                                <span>
                                                                    <?php echo $invoice_item_data['title'] ?>
                                                                </span>
                                                                <p><b>Rs.
                                                                        <?php echo number_format($invoice_item_data['invoice_item_price'], 2); ?>
                                                                    </b></p>
                                                                <div class="d-flex justify-content-between">
                                                                    <span class="text-secondary">Qty:
                                                                        <?php echo $invoice_item_data['invoice_item_quantity'] ?>
                                                                    </span>
                                                                    <?php
                                                                    if ($invoice_data['invoice_status_invoice_status_id'] == 1) {
                                                                        ?>
                                                                        <span style="background-color:#dddddd" class=" px-3 rounded-5">Awaiting Confirm</span>
                                                                        <?php
                                                                    } else if ($invoice_data['invoice_status_invoice_status_id'] == 2) {
                                                                        ?>
                                                                            <span style="background-color:#ffd8b0 ;" class="px-3 rounded-5">Out for Delevery</span>
                                                                        <?php
                                                                    } else if($invoice_data["invoice_status_invoice_status_id"] == 4){
                                                                        ?>
                                                                            <span class="px-3 rounded-5">Confirmed</span>
                                                                        <?php
                                                                    }else if($invoice_data["invoice_status_invoice_status_id"] == 5){
                                                                        ?>
                                                                            <span style="background-color:#c6e2ff ;" class=" px-3 rounded-5">Packaging</span>
                                                                        <?php
                                                                    }else if($invoice_data["invoice_status_invoice_status_id"] == 6){
                                                                        ?>
                                                                            <span style="background-color:#ffb0b0 ;" class=" px-3 rounded-5">Cancelled</span>
                                                                        <?php
                                                                    }else{
                                                                        ?>
                                                                            <span class="text-white bg-blue  px-3 rounded-5">Delevered</span>
                                                                        <?php
                                                                    }
                                                                    ?>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                 
                                                    <?php
                                                }
                                                ?>
                                                    <div class="col-12 pb-2 d-flex align-items-center justify-content-end">
                                                        <?php echo $invoice_item_result->num_rows ?> Item<?php echo $invoice_item_result->num_rows > 1 ? "s" : "" ?>, Total :&nbsp;&nbsp;
                                                        <span class="text-orange fs-5 fw-bold"> Rs. <?php echo number_format($shippingTotal+$invoice_total,2);?></span>
                                                    </div>
                                                    <?php
                                                        if ($invoice_data['invoice_status_invoice_status_id'] == 1|$invoice_data['invoice_status_invoice_status_id'] == 4|$invoice_data['invoice_status_invoice_status_id'] == 5) {
                                                    ?>
                                                        <div class="col-12 pt-2 d-flex justify-content-center">
                                                        <button class="ui button basic orange" onclick="cancelOrder('<?php echo $invoice_data['invoice_id']?>');">Cancel Order</button>
                                                        </div>
                                                    <?php
                                                        }
                                                    ?>
                                            </div>

                                        </div>

                                        <!-- to receive modal -->
                                        <div class="modal" tabindex="-1" id="receive-order-modal<?php echo $invoice_data['invoice_id']?>">
                                            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header ">
                                                        <h5 class="modal-title fw-bold">Order Details (<?php echo $invoice_item_result->num_rows ?> Item<?php echo $invoice_item_result->num_rows > 1 ? "s" : "" ?>)</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body py-0">
                                                        <div class="row bg-light p-2 gap-2">
                                                            <div class="col-12 p-2 bg-white">
                                                            <div class="row">
                                                                <div class="col-8">
                                                                <span class="fs-6">Order
                                                                    <?php echo $invoice_data['invoice_id'] ?>
                                                                </span>
                                                                <p class="text-secondary">Placed on
                                                                    <?php echo date_format(new DateTime($invoice_data['date']), "d M Y  H:i:s"); ?>
                                                                </p>
                                                                </div>
                                                                <div class="col-4 d-flex justify-content-end align-items-center">
                                                                <?php 
                                                            if($invoice_data["invoice_status_invoice_status_id"] == 6){
                                                                ?>
                                                                <span  class="text-danger  px-3 rounded-5">Cancelled</span>
                                                            <?php
                                                            
                                                            }else{
                                                                
                                                                if ($invoice_data['invoice_status_invoice_status_id'] == 1|$invoice_data['invoice_status_invoice_status_id'] == 4|$invoice_data['invoice_status_invoice_status_id'] == 5) {
                                                            ?>

                                                                    <button  onclick="cancelOrder('<?php echo $invoice_data['invoice_id']?>');" class="ui button basic orange">Cancel</button>
                                                                    <?php 
                                                                }
                                                            }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                            </div>
                                                            <?php 
                                                            if($invoice_data["invoice_status_invoice_status_id"] != 6){
                                                                ?>
                                                                <div class="col-12 p-2 bg-white d-flex justify-content-center align-items-center">
                                                                <div class="ui ordered w-100 mini steps">
                                                                    <!-- processing -->
                                                                    <div class="<?php if ($invoice_data['invoice_status_invoice_status_id'] == 1) { ?>
                                                                        active
                                                                        <?php } else{ ?>
                                                                        completed
                                                                        <?php } ?> step">
                                                                        <div class="content">
                                                                            <div class="title">Processing</div>                    
                                                                        </div>
                                                                    </div>
                                                                        <!-- Shipped -->
                                                                    <div class="<?php if ($invoice_data['invoice_status_invoice_status_id'] == 3||$invoice_data['invoice_status_invoice_status_id'] == 2) { ?>
                                                                        completed
                                                                        <?php
                                                                            } else if($invoice_data["invoice_status_invoice_status_id"] == 5){
                                                                        ?>
                                                                        active
                                                                        <?php
                                                                            }else{
                                                                        ?>
                                                                        disabled
                                                                        <?php
                                                                            } ?> step">
                                                                        <div class="content">
                                                                            <div class="title">Out for Delivery</div>                    
                                                                        </div>
                                                                    </div>
                                                                        <!-- Delivered -->
                                                                    <div class="<?php 
                                                                            if ($invoice_data['invoice_status_invoice_status_id'] == 2) {
                                                    
                                                                        ?>
                                                                        active
                                                                        <?php
                                                                            } else if ($invoice_data['invoice_status_invoice_status_id'] == 3) {
                                                                        ?>
                                                                        completed
                                                                        <?php
                                                                            } else{
                                                                            ?>
                                                                                disabled
                                                                            <?php
                                                                        }
                                                                        ?> step">
                                                                        <div class="content">
                                                                            <div class="title">Delivered</div>     
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                            }
                                                            ?>
                                                            
                                                            
                                                            <div class="col-12 p-2 d-flex align-items-center bg-white justify-content-between">     
                                                                <button onclick="window.location = 'invoice.php?inv=<?php echo $invoice_data['invoice_id'] ?>'" 
                                                                class="ui button teal basic">Open Invoice</button>                                                   
                                                                <span class="fs-4">Total:&nbsp;&nbsp;<b> Rs. <?php echo number_format($shippingTotal+$invoice_total,2);?></b></span>
                                                            </div>
                                                        
                                                            <div class="col-12 p-2 bg-white overflow-auto">
                                                                <h5 class="fw-bold">Item list</h5>
                                                                <div class="row  mb-2 w-100" style="min-width:50rem">
                                                                    <div class="col-1">ITEM</div>
                                                                    <div class="col-4">DESCRIPTION</div>
                                                                    <div class="col-1 d-flex justify-content-end">QTY</div>
                                                                    <div class="col-2 d-flex justify-content-end">PRICE (Rs)</div>
                                                                    <div class="col-2 d-flex justify-content-end">SHIPPING (Rs)</div>
                                                                    <div class="col-2 d-flex justify-content-end">AMOUNT (Rs)</div>
                                                                </div>
                                                                <?php 
                                                                foreach ($items_list as $item){
                                                                    
                                                                    $image_result = Database::execute("SELECT * FROM `product_image` WHERE product_product_id = '" . $item['product_id'] . "' ");
                                                                    $image_data = $image_result->fetch_assoc();
                                                                    ?>
                                                                        <div class="row mb-2 pt-3 border-top w-100" style="min-width:50rem;">
                                                                            <div class="w-auto position-relative" style="width:5rem;">
                                                                                <img src="resource/product_image/<?php echo $image_data['image_path'] ?>"
                                                                                    style="width:5rem;height:5rem;object-fit: contain;" alt="">
                                                                            </div>
                                                                            <div class="col w-auto d-flex flex-column">
                                                                                <span>
                                                                                    <?php echo $item['title'] ?>
                                                                                </span>
                                                                                <p><b>Rs.
                                                                                        <?php echo number_format($item['invoice_item_price'], 2); ?>
                                                                                    </b></p>
                                                                                <div class="d-flex justify-content-between">
                                                                                    <span class="text-secondary">Qty:
                                                                                        <?php echo $item['invoice_item_quantity'] ?>
                                                                                    </span>
                                                                                </div>                                                                        
                                                                            </div>
                                                                                <div class="col-1 d-flex justify-content-end">
                                                                                    <?php echo $item['invoice_item_quantity'] ?>
                                                                                </div>
                                                                                <div class="col-2 d-flex justify-content-end">
                                                                                    <?php echo number_format($item['invoice_item_price'], 2) ?>
                                                                                </div>
                                                                                <div class="col-2 d-flex justify-content-end">
                                                                                    <?php echo number_format($item['shipping_fee'] * (ceil($item['invoice_item_quantity'] / 2)), 2) ?>
                                                                                </div>
                                                                                <div class="col-2 d-flex justify-content-end">
                                                                                    <?php echo number_format(($item['invoice_item_quantity'] * $item['invoice_item_price']) + ($item['shipping_fee'] * (ceil($item['invoice_item_quantity'] / 2))), 2) ?>
                                                                                </div>
                                                                        </div>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </div>
                                                            <div class="col-12 col-lg-6 p-2 bg-white">
                                                                <h5 class="text-decoration-underline">Shipping Address</h5>
                                                                <?php
                                                                    $address_result = Database::execute("SELECT * FROM `user_has_address` INNER JOIN `city` ON user_has_address.city_city_id = city.city_id
                                                                    WHERE `user_email` = '" . $_SESSION['user']['email'] . "'");
                                                                    $address_num = $address_result->num_rows;
                                                                    $address_data = $address_result->fetch_assoc();
                                                                    ?>
                                                                    <div class="d-flex flex-column">                                                                
                                                                        <h5 class="">
                                                                            <?php echo $_SESSION['user']['first_name'] . " " . $_SESSION['user']['last_name'] ?>
                                                                        </h5>
                                                                        <span><?php echo $address_data['line1'].", ".$address_data['line2']?></span>
                                                                        <span><?php echo $address_data['city_name']?></span>
                                                                        <span>Sri Lanka</span>
                                                                        <span><?php echo $address_data['postal_code']?></span>
                                                                    </div>
                                                            </div>
                                                            <div class="col-12 col-lg p-2 bg-white">
                                                                <h4>Total Summary</h4>
                                                                <div class="row">
                                                                    <div class="col-6">Subtotal</div>
                                                                    <div class="col-6 d-flex justify-content-end">Rs. <?php echo number_format($invoice_total,2);?></div>
                                                                </div>
                                                                <div class="row mb-3">                                                            
                                                                    <div class="col-6">Delivery Fee</div>
                                                                    <div class="col-6 d-flex justify-content-end">Rs. <?php echo number_format($shippingTotal,2);?></div>
                                                                </div>
                                                                <div class="row px-2">                                                            
                                                                <div class="col-12 border-top"></div>
                                                                </div>
                                                                <div class="row  pt-3">                                                            
                                                                    <div class="col-6">Total</div>
                                                                    <div class="col-6 fs-4 d-flex justify-content-end">Rs. <?php echo number_format($invoice_total,2);?></div>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>                                                
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }   
                                } else {
                                    ?>
                                    <div class="col-12 mb-5 d-flex flex-column justify-content-center align-items-center">
                                        <img src="resource/emptySearch.jpg" style="max-height:30rem" alt="">
                                        <span class="fs-1 text-secondary mb-3">You have no orders placed yet</span>
                                        <a href="home.php" class="ui button orange  huge">Start Shopping Now <i
                                                class="right arrow icon"></i></a>
                                    </div>
                                    <?php
                                }
                                ?>
                            
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
    <?php
}

?>