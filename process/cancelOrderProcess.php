<?php

session_start();
include "../connection.php";

$response = new stdClass();
$response->status = "faild";

if (isset($_SESSION['user'])) {
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        Database::execute("Update `invoice` SET `invoice_status_invoice_status_id` = '6' 
        WHERE `invoice_id` = '".$_GET['id']."'");

        $response->status = "success";
        $response->message = "Order successfully cancelled";
    } else {
        $response->message = "Something went erong please try again";
    }

}else{
    $response->message = "Please log in first";
}

echo json_encode($response);