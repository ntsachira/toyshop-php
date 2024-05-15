<?php

session_start();
include '../../connection.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../index.php");
}

$response = new stdClass();
$response->status = "faild";

if(isset($_GET["email"])){
    $user_result = Database::execute("SELECT * FROM `user` WHERE `email` = '" . $_GET['email'] . "'");
    if($user_result->num_rows==1){
        $user_data = $user_result->fetch_assoc();
        if($user_data["status_status_id"]==1){
            Database::execute("UPDATE `user` SET `status_status_id` = '2' WHERE `email` = '" . $_GET['email'] . "'");
            $response->status = "success";
            $response->message = "user Successfully Deactivated";
        }else if($user_data["status_status_id"]==2){
            Database::execute("UPDATE `user` SET `status_status_id` = '1' WHERE `email` = '" . $_GET['email'] . "'");
            $response->status = "success";
            $response->message = "User Successfully Activated";
        }else{
            $response->message = "Something went wrong, Please try again";
        }
    }else{
        $response->message = "User not found";
    }
}else{
    $response->message = "Something went wrong, Please try again";
}

echo json_encode($response);