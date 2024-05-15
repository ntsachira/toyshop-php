<?php 
session_start();
include '../../connection.php';

$response = new stdClass();

$response->status = "faild";

if(!isset($_POST["otp"])){
    $response->message = "OTP does not found";
}else{

    $admin_result = Database::execute("SELECT * FROM `admin` WHERE `otp` = '".$_POST['otp']."'");

    if($admin_result->num_rows == 1){

        Database::execute("INSERT INTO `admin_login_history` (`login_datetime`) 
        VALUES('".date_format(new DateTime("now",new DateTimeZone("Asia/Colombo")),"Y-m-d H:i:s")."')");
        $response->status = "success";
        $response->message = "Login Success";       

        $_SESSION['admin'] = $admin_result->fetch_assoc();      
        
    }else{
        $response->message = "OTP does not match";
    }	
    
}

echo json_encode($response);