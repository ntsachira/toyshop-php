<?php

include "../../connection.php";

$response = new stdClass();
$response->status = "faild";

$login_option = Database::execute("SELECT * FROM `admin`");
$login_option_data = $login_option->fetch_assoc();

if($login_option_data["admin_login_options_type_id"] == 1){
    Database::execute("UPDATE `admin` SET `admin_login_options_type_id` = '2'");
    $response->status = "success1";
    $response->message = "OTP login Activated";
}else if($login_option_data["admin_login_options_type_id"] == 2){
    Database::execute("UPDATE `admin` SET `admin_login_options_type_id` = '1'");
    $response->status = "success2";
    $response->message = "OTP login deactivated";
}else{
    $response->message = "Something went wrong, Please try again";
}

echo json_encode($response);