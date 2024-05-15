<?php 
session_start();
include '../../connection.php';

$response = new stdClass();

$response->status = "faild";

if(empty($_POST["email"])){
    $response->message = "Please enter your Email";
}else if(empty($_POST["password"])){
    $response->message = "Please enter your Password";
}else{

    $admin_result = Database::execute("SELECT * FROM `admin` WHERE `email` = '".$_POST['email']."' AND 
    `password` = '".$_POST['password']."'");

    if($admin_result->num_rows == 1){
        Database::execute("INSERT INTO `admin_login_history` (`login_datetime`) 
        VALUES('".date_format(new DateTime("now",new DateTimeZone("Asia/Colombo")),"Y-m-d H:i:s")."')");
        
        $response->status = "success";
        $response->message = "Login Success";       

        $_SESSION['admin'] = $admin_result->fetch_assoc();

        if($_POST['rememberme'] == "true"){
           setcookie("admin_email",$_POST["email"],time()+(60*60*24*30),"/"); 
           setcookie("admin_password",$_POST["password"],time()+(60*60*24*30),"/"); 
        }else{
            setcookie("admin_email","",time()-1,"/"); 
            setcookie("admin_password","",time()-1,"/");
        }
        
    }else{
        $response->message = "Invalid Email or Password";
    }	
    
}

echo json_encode($response);