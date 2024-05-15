<?php
session_start();
include_once "../connection.php";

$response = new stdClass();
$response->status = "faild";

if(isset($_SESSION["user"])){
    if(isset($_GET["id"]) & !empty($_GET["id"])){
        $watchlist_result = Database::execute("SELECT * FROM `watchlist` WHERE `product_product_id` = '" .  $_GET["id"] . "' 
        AND `user_email` = '" . $_SESSION["user"]["email"] . "'");

        if($watchlist_result->num_rows == 1){
            Database::execute("DELETE FROM `watchlist` WHERE `product_product_id` = '" .  $_GET["id"] . "' 
            AND `user_email` = '" . $_SESSION["user"]["email"] . "'");
            $response->status = "removed";
            $response->message = "Product removed from the watchlist";
        }else if($watchlist_result->num_rows == 0){
            Database::execute("INSERT INTO `watchlist` (`product_product_id`,`user_email`) VALUES ('" .  $_GET["id"] . "','" . $_SESSION["user"]["email"] . "')");
            $response->status = "added";
            $response->message = "Product added to the watchlist";
        }else{
            $response->message = "Something went wrong Please try again";
        }
    }else{
        $response->message = "Something went wrong, please try again";
    }
}else{
    $response->message = "Please Log In First";
}

echo json_encode($response);