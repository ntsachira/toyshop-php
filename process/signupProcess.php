<?php 

include '../connection.php'; 

$response = new stdClass(); // create new response object
$response->status = "error"; // set status to error by default

// get data from request
$data = json_decode(file_get_contents('php://input'), true);

$firstname = $data['firstname'];
$lastname = $data['lastname'];
$email = $data['email'];
$password = $data['password'];
$mobile = $data['mobile'];
$gender = $data['gender'];
// get data from request

// validate data
if(empty($firstname)){    
    $response->message = "Please Enter Your First Name";        
}else if(strlen($firstname)>50){
    $response->message = "First Name must be less than 50 characters";
}else if(empty($lastname)){    
    $response->message = "Please Enter Your Last Name";
}else if(strlen($lastname)>50){
    $response->message = "Last Name must be less than 50 characters";
}else if(empty($email)){
    $response->message = "Please Enter Your Email";
}else if(strlen($email)>100){
    $response->message = "Email must be less than 100 characters";
}else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    $response->message = "Please Enter Valid Email";
}else if(empty($password)){
    $response->message = "Please Enter Your Password";
}else if(strlen($password)<5|| strlen($password)>20){
    $response->message = "Password must be between 5 and 20 characters";
}else if(empty($mobile)){
    $response->message = "Please Enter Your Mobile Number";
}else if(strlen($mobile)!=10){
    $response->message = "Mobile Number must be 10 characters";
}else if(!preg_match("/07[0,1,2,4,5,6,7,8][0-9]/", $mobile)){
    $response->message = "Please Enter Valid Mobile Number";
//validate end
}else{
    $result = Database::execute("SELECT * FROM `user` WHERE `email`='$email' OR `mobile`='$mobile'");

    if($result->num_rows>0){
        $response->message = "Email or Mobile you Entered, Already registered";
    }else{
        //get current date time and format to save the joined date
        $datetime = new DateTime();
        $datetime->setTimezone(new DateTimeZone("Asia/Colombo"));        
        $formatedDatetime = $datetime->format("Y-m-d H:i:s");

        //encrypt password
        $password = password_hash($password,PASSWORD_DEFAULT);

        Database::execute("INSERT INTO `user` (`first_name`,`last_name`,`email`,`password`,`mobile`,`joined_date`,`gender_gender_id`,`status_status_id`) 
        VALUES('$firstname','$lastname','$email','$password','$mobile','$formatedDatetime','$gender','1')");

        $response->status = "success";
        $response->message = "Registration Successfull!";
    }   
    
}

echo json_encode($response); //response 

?>