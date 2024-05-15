<?php
session_start();
include_once "../connection.php";

$response = new stdClass();
$response->status = "faild";

if (isset($_SESSION['user'])) {
    $message_result = Database::execute("SELECT `sender` FROM `message_history` 
    WHERE `seen_status_seen_status_id` = '2' AND `sender` = 'admin@gmail.com' AND 
    `receiver`='" . $_SESSION['user']['email'] . "'");

    $response->data = $message_result->num_rows;
    $response->status = "success";   

}else{
    $response->message = "Log in first";
}

echo json_encode($response);