<?php

include "../../connection.php";

$response = new StdClass();
$response->status = "faild";

if(empty(trim($_POST["name"]))){
    $response->message = "Website name cannot be empty";
}else if(empty(trim($_POST["email"]))){
    $response->message = "Email address cannot be empty";
}else if(!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)){
    $response->message = "Please enter a valid email";
}else if(empty(trim($_POST["tele"]))){
    $response->message = "Contact number cannot be empty";
}else if(strlen($_POST["tele"])!=10){
    $response->message = "Mobile Number must be 10 characters";
}else if(!preg_match("/0[7,4][0,1,2,4,5,6,7,8][0-9]/", $_POST["tele"])){
    $response->message = "Please Enter Valid Mobile Number";
}else if(empty(trim($_POST["mission"]))){
    $response->message = "Mission statement cannot be empty";
}else if(empty(trim($_POST["copy"]))){
    $response->message = "Copy Right statement cannot be empty";
}else if(empty(trim($_POST["address"]))){
    $response->message = "Address cannot be empty";
}else {
    Database::execute("UPDATE `footer` SET `mission`='".$_POST["mission"]."',
    `copy_right`='".$_POST["copy"]."',`address`='".$_POST["address"]."',`email`='".$_POST["email"]."',`tele`='".$_POST["tele"]."', 
    `updated_datetime`='".date_format(new DateTime("now",new DateTimeZone("Asia/Colombo")),"Y-m-d H:i:s")."',`site_name`='".$_POST["name"]."' ");

    $response->status = "success";
    $response->message = "Site data updated successfully";
}

echo json_encode($response);