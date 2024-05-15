<?php
session_start();
include "../connection.php";

$response = new stdClass();
$response->status = "faild";

if (isset($_SESSION['user'])) {

    if (isset($_GET['id']) & !empty($_GET['id']) & isset($_GET['qty']) & !empty($_GET['qty'])) {

        $product_result = Database::execute("SELECT * FROM `product` WHERE `product_id` = '" . $_GET['id'] . "' AND `status_status_id`='1'");

        if ($product_result->num_rows == 1) {
            $product_data = $product_result->fetch_assoc();

            $cart_result = Database::execute("SELECT * FROM `cart` WHERE `product_product_id`='" . $_GET['id'] . "' 
            AND `user_email` = '" . $_SESSION['user']['email'] . "'");

            if ($cart_result->num_rows == 1) {
                $cart_data = $cart_result->fetch_assoc();
                if ($product_data['quantity'] >= ( $_GET['qty'] + $cart_data['cart_quantity'])) {
                    //update cart
                    Database::execute("UPDATE `cart` SET `cart_quantity` = cart_quantity+'" .  $_GET['qty'] . "' 
                    WHERE `product_product_id`='" . $_GET['id'] . "' AND `user_email` = '" . $_SESSION['user']['email'] . "'");

                    $response->status = "success";
                    $response->message = "Product added to cart successfully";
                } else {
                    $response->message = "Insufficient stock, Please contact the seller";
                }
            } else {
                if ($product_data['quantity'] >=  $_GET['qty']) {
                    // insert to cart
                    Database::execute("INSERT INTO `cart` (`cart_quantity`,`product_product_id`,`user_email`) VALUES 
                    ('" . $_GET['qty'] . "','" . $_GET['id'] . "','" . $_SESSION['user']['email'] . "')");

                    $response->status = "success";
                    $response->message = "Product added to cart successfully";
                } else {
                    $response->message = "Insufficient stock, Please contact the seller";
                }
            }

        } else {
            $response->message = "Product not found, Please try again";
        }

    } else {
        $response->message = "Something went wrong, Please try again";
    }

} else {
    $response->message = "Please Sign In First";
}

echo json_encode($response);