<?php

include "../../connection.php";

$response = new stdClass();
$response->status = "faild";

if(isset($_GET["id"])&&!empty($_GET["id"])){
    $category_result = Database::execute("SELECT * FROM `category` WHERE `category_id` = '".$_GET["id"]."'");
    if($category_result->num_rows == 1){
        $category_data = $category_result->fetch_assoc();
        if($category_data["status_status_id"] == 1){
            Database::execute("UPDATE `category` SET `status_status_id` = 2 WHERE `category_id`='".$_GET["id"]."'");            
            $response->message = "Deactivated";
        }else{
            Database::execute("UPDATE `category` SET `status_status_id` = 1 WHERE `category_id`='".$_GET["id"]."'");            
            $response->message = "Activated";
        }
        $response->status = "success";
        
    }else{
        $response->message = "Category not found, Please try again";
    }
}else{
    $response->message = "Something went wrong please try again";
}

echo json_encode($response);