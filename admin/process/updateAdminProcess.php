<?php
session_start();
include "../../connection.php";

$response = new stdClass();
$response->status = "faild";

if(isset($_GET["fname"])&&isset($_GET["lname"])){
    if(empty(trim($_GET["fname"]))){
        $response->message = "First name must not be empty";
    }else if(empty(trim($_GET["lname"]))){
        $response->message = "Last Name must not be empty";
    }else{
        Database::execute("UPDATE `admin` SET `first_name`='".$_GET["fname"]."', `last_name`='".$_GET["lname"]."'");
        $response->status = "success";
        $response->message = "Successfully updated";
        $admin_result = Database::execute("SELECT * FROM `admin`");
        $_SESSION["admin"] = $admin_result->fetch_assoc();
    }
}else{
    $response->message = "Something went wrong. Please try again later.";
}


echo json_encode($response);