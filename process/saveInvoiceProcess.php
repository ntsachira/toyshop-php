<?php
session_start();
include '../connection.php';

$response = new stdClass();
$response->status = 'faild';

if (isset($_SESSION['user'])) {
    if (isset($_POST['order_id']) && isset($_POST['product_id'])) {

        //insert into invoice table
        $date = new DateTime();
        $tz = new DateTimeZone('Asia/Colombo');
        $date->setTimezone($tz);

        Database::execute("INSERT INTO `invoice` (`invoice_id`,`date`,`user_email`,`invoice_status_invoice_status_id`) VALUES 
        ('INV-" . $_POST['order_id'] . "','" . date_format($date, "Y-m-d H:i:s") . "','" . $_SESSION['user']['email'] . "','1')");

                
        if (empty($_POST['product_id'])) {
            //save invoice for cart checkout
            $cart_result = Database::execute("SELECT * FROM `cart` INNER JOIN `active_product` ON `cart`.`product_product_id`=`active_product`.`product_id` 
            WHERE `user_email` = '" . $_SESSION['user']['email'] . "' AND `quantity` > 0");

           

            if ($cart_result->num_rows > 0) {
                while ($cart_data = $cart_result->fetch_assoc()) {
                    //insert into invoice item
                    $city_result = Database::execute("SELECT * FROM `user_has_address` WHERE `user_email` = '" . $_SESSION['user']['email'] . "'");
                    $city_data = $city_result->fetch_assoc();
                    $shipping_fee = 0;
                    if($city_data['city_city_id'] == 1){
                        $shipping_fee = $cart_data['delivery_fee_matara'];
                    }else{
                        $shipping_fee = $cart_data['delivery_fee_other'];
                    }

                    Database::execute("INSERT INTO `invoice_item` (`invoice_invoice_id`,`product_product_id`,`invoice_item_quantity`,`invoice_item_price`,`shipping_fee`,`review_status_review_status_id`) 
                    VALUES('INV-" . $_POST['order_id'] . "','" . $cart_data['product_id'] . "','" . $cart_data['cart_quantity'] . "',
                    '" . $cart_data['price'] . "','".$shipping_fee."','2')");

                    //reduce from stock
                    Database::execute("UPDATE `product` SET `quantity` = quantity-'" . $cart_data['cart_quantity'] . "' 
                    WHERE `product_id`='" . $cart_data['product_id'] . "'");

                    //delete form cart
                    Database::execute("DELETE FROM `cart` WHERE `product_product_id`='" . $cart_data['product_id'] . "' 
                    AND `user_email` = '" . $_SESSION['user']['email'] . "'");
                }
                $response->status = "success";

            } else {
                $response->message = "Something went wrong, Please try again";

            }
        } else {
            //save invoice for single product
            $product_result = Database::execute("SELECT * FROM `active_product` WHERE `product_id` = '" . $_POST['product_id'] . "'");

            if ($product_result->num_rows == 1) {
                $product_data = $product_result->fetch_assoc();

                $city_result = Database::execute("SELECT * FROM `user_has_address` WHERE `user_email` = '" . $_SESSION['user']['email'] . "'");
                $city_data = $city_result->fetch_assoc();
                $shipping_fee = 0;
                if($city_data['city_city_id'] == 1){
                    $shipping_fee = $product_data['delivery_fee_matara'];
                }else{
                    $shipping_fee = $product_data['delivery_fee_other'];
                }

                //indert into invoice item table
                Database::execute("INSERT INTO `invoice_item` (`invoice_invoice_id`,`product_product_id`,`invoice_item_quantity`,`invoice_item_price`,`shipping_fee`,`review_status_review_status_id`) 
                VALUES('INV-" . $_POST['order_id'] . "','" . $_POST['product_id'] . "','" . $_POST['quantity'] . "'
                ,'" . $product_data['price'] . "','".$shipping_fee."','2')");

                //reduce from stock
                Database::execute("UPDATE `product` SET `quantity` = quantity-'" . $_POST['quantity'] . "' 
                WHERE `product_id`='" . $_POST['product_id'] . "'");

                //check if the product also in cart and remove from cart
                $cart_result_2 = Database::execute("SELECT * FROM `cart` WHERE `product_product_id`='" . $_POST['product_id'] . "' 
            AND `user_email` = '" . $_SESSION['user']['email'] . "'");

                if ($cart_result_2->num_rows == 1) {
                    Database::execute("DELETE FROM `cart` WHERE `product_product_id`='" . $_POST['product_id'] . "' 
                AND `user_email` = '" . $_SESSION['user']['email'] . "'");

                }
                $response->status = "success";
            } else {
                $response->message = "Product not found, Please try again";
            }
        }
    } else {
        $response->message = "Something went wrong, Please try again";
    }
} else {
    $response->message = "Session not found, Please sign in again";
}

echo json_encode($response);