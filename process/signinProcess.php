<?php
session_start();

include "../connection.php";

$response = new stdClass(); // create new response object
$response->status = "error"; // set status to error by default

// get data from request
$data = json_decode(file_get_contents('php://input'), true);

$email = $data['email'];
$password = $data['password'];
$rememberMe = $data["rememberme"];

if (empty($email)) {
    $response->message = "Please Enter your Email";
} else if (empty($password)) {
    $response->message = "Please Enter your password";
} else {
    $result = Database::execute("SELECT * FROM `active_user` WHERE `email`='$email' ");
    if ($result->num_rows == 1) {

        $userData = $result->fetch_assoc();

        if (password_verify($password, $userData["password"])) { // check if the password is matching the encrypted password in the database

            $response->status = "success";

            $_SESSION["user"] = $userData;

            if ($rememberMe == "true") {
                setcookie("email", $email, time() + 60 * 60 * 24 * 30, "/");
                setcookie("password", $password, time() + 60 * 60 * 24 * 30, "/"); //the path is set to '/', so the cookie will be available for the entire domain.
            } else {
                setcookie("email", "", time() - 3600, "/");
                setcookie("password", "", time() - 3600, "/");
            }
        } else {
            $response->message = "Incorrect Email or  Password";
        }

    } else {
        $response->message = "Incorrect Email or Password";
    }
}

echo json_encode($response);


?>