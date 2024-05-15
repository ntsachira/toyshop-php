<?php 

include "../connection.php";

$response = new stdClass(); // create new response object
$response->status = "error"; // set status to error by default

// get data from request
$data = json_decode(file_get_contents('php://input'), true);

$email = $data['email'];
$newPassword = $data['newPassword'];
$reEnterPassword = $data['reEnterPassword'];
$verificationCode = $data['verificationCode'];

if(empty($newPassword) && empty($reEnterPassword)){
    $response->message = "**Please Enter your new password";
}else if($newPassword != $reEnterPassword){
    $response->message = "**Passwords do not match";
}else{
    $result = Database::execute("SELECT * FROM `user` WHERE `email`='$email' AND `verification_code`='$verificationCode'");
    if($result->num_rows==1){

        $response->status="success";        

        $userData = $result->fetch_assoc();

        $newPassword = password_hash($newPassword,PASSWORD_DEFAULT); //encrypt password

        Database::execute("UPDATE `user` SET `password`='$newPassword' WHERE `email`='$email'");

        $response->message="Password Reset Successful";

    }else{
        $response->message="Invalid Email or Verification Code";
    }
}

echo json_encode($response);

?>