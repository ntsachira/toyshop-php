<?php

include "../../connection.php";

$response = new StdClass();
$response->status = "faild";

if(isset($_GET["cat"]) && !empty(trim($_GET["cat"]))){
    $category_result = Database::execute("SELECT * FROM `category` WHERE `category_name` = '".$_GET["cat"]."'");
    if($category_result->num_rows == 0 ){
        Database::execute("INSERT INTO `category` (`category_name`) VALUES('".$_GET["cat"]."')");
        $response->status = "success";
        $response->message = "Category saved successfully";
    }else{
        $response->message = "Category already exists";
    }
}else{
    $response->message = "Category name is Empty, Please try again";
}

echo json_encode($response);