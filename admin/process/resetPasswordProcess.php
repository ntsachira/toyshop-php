<?php

include "../../connection.php";

$response = new stdClass();
$response->status = "faild";

if (isset($_POST["new"]) && isset($_POST["reNew"]) && isset($_POST["otp"])) {
    if (empty(trim($_POST["new"]))) {
        $response->message = "New password must not be empty";
    } else if (strlen($_POST["new"]) < 8 || strlen($_POST["new"]) > 15) {
        $response->message = "Password must be between 8 - 15 characters";
    } else if ($_POST["new"] != $_POST["reNew"]) {
        $response->message = "Passwords does not match, please try again";
    } else{
        $admin_result = Database::execute("SELECT * FROM `admin`");
        $admin_data = $admin_result->fetch_assoc();

        if($_POST["otp"] == $admin_data["otp"]){
            Database::execute("UPDATE `admin` SET `password` = '".$_POST["new"]."'");
            $response->status = "success";
            $response->message = "Password reset Successfully";
        }else{
            $response->message = "OTP does not match";
        }
    }
}else {
    $response->message = "Something went wrong. Please try again later.";
}

echo json_encode($response);