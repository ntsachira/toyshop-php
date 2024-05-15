<?php
session_start();
include "../connection.php";

$response = new stdClass();
$response->status = "faild";

if (isset($_SESSION['user'])) {
    if (isset($_GET['id']) & !empty($_GET['id'])) {
        $product_result = Database::execute("SELECT * FROM `product` WHERE `product_id` = '" . $_GET['id'] . "' 
        AND `status_status_id`='1'");
        if ($product_result->num_rows == "1") {
            Database::execute("DELETE FROM `cart` WHERE `product_product_id`='" . $_GET['id'] . "' 
            AND `user_email` = '" . $_SESSION['user']['email'] . "' ");
            $response->status = "success";
            $response->message = "Product  successfully removed";
        } else {
            $response->message = "Product not found, Please try again";
        }
    } else {
        $response->message = "Something went wrong, Please try again";
    }
} else {
    $response->status = 'log';
    $response->message = "Please login first";
}

echo json_encode($response);