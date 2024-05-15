<?php

include "../../connection.php";

if (isset($_GET["id"])) {
    $invoice_result = Database::execute("SELECT * FROM `invoice` WHERE `invoice_id`='" . $_GET["id"] . "' ");

    if ($invoice_result->num_rows == 1) {
        $invoice_data = $invoice_result->fetch_assoc();

        $invoice_item_result = Database::execute("SELECT * FROM `product` INNER JOIN `invoice_item` 
        ON `product`.`product_id`=`invoice_item`.`product_product_id`  LEFT JOIN `product_has_color` 
         ON `product_has_color`.`product_product_id` = `product`.`product_id` LEFT JOIN `color` ON `color`.`color_id` = `product_has_color`.`color_color_id`
         WHERE `invoice_invoice_id` = '" . $_GET['id'] . "'");

        $user_result = Database::execute("SELECT * FROM `user` INNER JOIN `user_has_address` ON `user_has_address`.`user_email` = `user`.`email` 
        INNER JOIN `city` ON `user_has_address`.`city_city_id`=`city`.`city_id` WHERE `email`='" . $invoice_data["user_email"] . "'");

         $user_data = $user_result->fetch_assoc();

        ?>
        <div class="col-12 col-sm-6 ">
            <div class="row bg-white border rounded py-2">
                <?php
                if ($invoice_item_result->num_rows > 0) {
                    ?>
                    <div class="col-12  py-1 bg-light">
                        <?php echo $invoice_item_result->num_rows." Item".($invoice_item_result->num_rows==1?"":"s")?> 
                    </div>
                    <?php
                    while ($invoice_item_data = $invoice_item_result->fetch_assoc()) {
                        $image_result = Database::execute("SELECT * FROM `product_image` WHERE `product_product_id` = '".$invoice_item_data["product_id"]."'");
                        $image_path = "empty.jpg";
                        if($image_result->num_rows > 0){
                            $image_path = "product_image/".$image_result->fetch_assoc()["image_path"];
                        }
                        ?>
                        <!-- 1 product -->
                        <div class="col-12 mb-2 pt-2 border-top">
                            <h6 class="card-title fw-bold">
                                <?php echo $invoice_item_data["title"] ?>
                            </h6>
                        </div>
                        <div class="col-4">
                            <img src="../resource/<?php echo $image_path ?>" style="width:5rem;height:5rem;object-fit:cover" class="rounded img-thumbnail" alt="">
                        </div>
                        <div class="col-8 mb-2">
                            <span>Color:
                                <?php echo $invoice_item_data["color_name"]==null?"Not Specified":$invoice_item_data["color_name"] ?>
                            </span>
                            <p>Qty:
                                <?php echo $invoice_item_data["invoice_item_quantity"] ?>
                            </p>
                            <h6 class="fw-bold">Rs.
                                <?php echo number_format($invoice_item_data["invoice_item_price"], 2) ?>
                            </h6>
                        </div>
                        <!-- 1 product -->
                        <?php
                    }
                } else {
                    ?>
                    <!-- 1 product -->
                    <div class="col-12">
                        <h6>*** Title ***</h6>
                    </div>
                    <div class="col-4">
                        <img src="../resource/empty.jpg" style="width:5rem;height:5rem;object-fit:cover" class="rounded" alt="">
                    </div>
                    <div class="col-8 mb-2">
                        <span>Color: ***</span>
                        <p>Qty: ***</p>
                        <h6>Rs. ***.00</h6>
                    </div>
                    <!-- 1 product -->
                    <?php
                }
                ?>

            </div>
        </div>
        <div class="col-12 col-sm-6  ">
            <div class="row gap-2 pe-2">
                <div class="col-12 card px-0">
                    <div class="card-header">
                        Shipping Details
                    </div>
                    <div class="card-body">
                        <span class="fw-bold ">Recipient Name</span>
                        <p class="bg-light py-1 px-2 mt-1 rounded border"><?php echo $user_data["first_name"]." ".$user_data["last_name"] ?></p>
                        <span class="fw-bold ">Phone Number</span>
                        <p class="bg-light py-1 px-2 mt-1 rounded border"><?php echo $user_data["mobile"] ?></p>
                        <span class="fw-bold ">Address</span>
                        <p class="bg-light py-1 px-2 mt-1rounded border"><?php echo $user_data["line1"]." ".$user_data["line2"] ?></p>
                        <span class="fw-bold ">City</span>
                        <p class="bg-light py-1 px-2 mt-1 rounded border"><?php echo $user_data["city_name"] ?></p>
                    </div>
                </div>
                <div class="col-12 px-0 card">
                    <div class="card-header">
                        Seller Response
                    </div>
                    <div class="card-body">
                        
                        <?php 
                        if($invoice_data["invoice_status_invoice_status_id"] != '6'){
                            ?> 
                            <span class="fw-bold ">Select Order Status</span>
                            <select name="" class="form-select mt-1" id="order-status">
                            <?php 
                            $invoice_status_result = Database::execute("SELECT * FROM `invoice_status` WHERE `invoice_status_id` != '6'");
                            while($invoice_status_data = $invoice_status_result->fetch_assoc()){
                                ?>
                                 <option <?php if($invoice_data["invoice_status_invoice_status_id"]==$invoice_status_data["invoice_status_id"]){?> selected <?php } ?> 
                                 value="<?php echo $invoice_status_data["invoice_status_id"] ?>"><?php echo $invoice_status_data["status_name"]; ?></option>
                                <?php
                            }
                            ?>
                           
                        </select>
                            <?php 
                        } else{
                            ?>
                            <div class="alert alert-danger" role="alert">
  Order Cancelled
</div>
                            <?php
                        }
                        ?> 
                        
                    </div>
                </div>
            </div>
        </div>
        <?php
    } else {
        ?>
        <div class="row">
            <div class="col-4">Something went wrong, Please try again</div>
        </div>
        <?php
    }


} else {
    ?>
    <div class="row">
        <div class="col-4">Something went wrong, Please try again</div>
    </div>
    <?php
}