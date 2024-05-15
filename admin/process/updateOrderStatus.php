<?php
include "../../connection.php";
$response = new stdClass();
$response->status ="faild";
if(isset($_POST["id"]) && isset($_POST["status"])){
    
    Database::execute("UPDATE `invoice` SET `invoice_status_invoice_status_id` = '".$_POST['status']."' WHERE `invoice_id`='".$_POST['id']."'");

    $response->status ="success";
    $response->message ="Status Updated";
}else{
    $response->message ="Something went wrong";
}

echo json_encode($response);