<?php

session_start();
include '../../connection.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../index.php");
}

$response = new stdClass();
$response->status = "faild";

if(isset($_GET["id"])){
    $product_result = Database::execute("SELECT * FROM `product` WHERE `product_id` = '" . $_GET['id'] . "'");
    if($product_result->num_rows==1){
        $product_data = $product_result->fetch_assoc();
        if($product_data["status_status_id"]==1){
            Database::execute("UPDATE `product` SET `status_status_id` = '2' WHERE `product_id` = '" . $_GET['id'] . "'");
            $response->status = "success";
            $response->message = "Product Successfully Deactivated";
        }else if($product_data["status_status_id"]==2){
            Database::execute("UPDATE `product` SET `status_status_id` = '1' WHERE `product_id` = '" . $_GET['id'] . "'");
            $response->status = "success";
            $response->message = "Product Successfully Activated";
        }else{
            $response->message = "Something went wrong, Please try again";
        }
    }else{
        $response->message = "Product not found";
    }
}else{
    $response->message = "Something went wrong, Please try again";
}

echo json_encode($response);