<?php

include "../connection.php";

$response = new stdClass();
$response->status = "faild";

if (isset($_GET["id"]) && !empty($_GET["id"])) {

    Database::execute("UPDATE `invoice_item` SET `review_status_review_status_id`='1' WHERE `invoice_item_id`='" . $_GET["id"] . "'");

    $response->status = "success";
    $response->message = "Review status updated successfully";

} else {
    $response->message = "Something went wrong , please try again";
}

echo json_encode($response);