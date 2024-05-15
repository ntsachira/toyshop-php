<?php
session_start();
include '../connection.php';

$response = new stdClass();
$response->status = 'faild';

if(isset($_GET["id"])){
    if(!empty($_GET["id"])){
        $product_result = Database::execute("SELECT * FROM `full_product` WHERE `product_id` = '".$_GET["id"]."'");
        if($product_result->num_rows == 1){
            $product = $product_result->fetch_assoc();
            $_SESSION["product"] = $product;
            $response->status = 'success';
            $response->message = 'Product session set successfully.';
        }else{
            $response->message = "Something went wrong!, Please try again later.";
        }
    }else{
        $response->message = "Something went wrong!, Please try again later.";
    }
}else{
    $response->message = "Something went wrong!, Please try again later.";
}

echo json_encode($response);