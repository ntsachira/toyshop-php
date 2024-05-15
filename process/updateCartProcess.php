<?php
session_start();
include "../connection.php";

$response = new stdClass();
$response->status ="faild";

if(isset($_SESSION['user'])){
    if(isset($_GET['id']) & !empty($_GET['id'])& isset($_GET['qty']) & !empty($_GET['qty'])){

        $cart_result = Database::execute("SELECT * FROM `cart` WHERE `product_product_id`='" . $_GET['id'] . "' 
        AND `user_email` = '" . $_SESSION['user']['email'] . "'");

        if ($cart_result->num_rows == 1) {
            $cart_data = $cart_result->fetch_assoc();
            
            $product_result = Database::execute("SELECT * FROM `product` WHERE `product_id` = '" . $_GET['id'] . "' AND `status_status_id`='1'");
            $product_data = $product_result->fetch_assoc();

            if ($product_data['quantity'] >=  $_GET['qty'] ) {
                //update cart
                Database::execute("UPDATE `cart` SET `cart_quantity` = '" .  $_GET['qty'] . "' 
                WHERE `product_product_id`='" . $_GET['id'] . "' AND `user_email` = '" . $_SESSION['user']['email'] . "'");

                $response->status = "success";
                $response->message = "Product quantity updated successfully";
            } else {
                $response->message = "Insufficient stock, Please contact the seller";
            }
        } else {
            $response->message ="Something went wrong, Please try again";
        }
    }else{
        $response->message ="Something went wrong, Please try again";
    }
}else{
$response->status = 'log';
$response->message = "Please login first";
}

echo json_encode($response);
