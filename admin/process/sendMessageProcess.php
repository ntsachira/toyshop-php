<?php

session_start();
if (isset($_SESSION['admin'])) {
    include '../../connection.php';

    $response = new stdClass();
    $response->status = "faild";

    if (isset($_POST["message"]) && !empty(trim($_POST["message"]))) {
        if (strlen($_POST["message"]) <= 500) {

            $history_id = round(microtime(true)*100);
            $date = new DateTime();
            $timeZone = new DateTimeZone("Asia/Colombo");
            $date->setTimezone($timeZone);

            Database::execute("INSERT INTO `message_history` 
            (`history_id`,`message_date`,`message`,`sender`,`receiver`,`seen_status_seen_status_id`) 
            VALUES('".$history_id."','".date_format($date,"Y-m-d H:i:s")."','".$_POST["message"]."','admin@gmail.com','".$_POST["email"]."','2')");

            $response->status = 'success';
            $response->message = "Message sent successfully";
        } else {
            $response->message = "Message should less than 500 characters";
        }
    } else {
        $response->message = "Something went wrong, Please try again";
    }

    echo json_encode($response);
} else {
    header("location:../home.php");
}