<?php

include "../../connection.php";

include "../../mailer/SMTP.php";
include "../../mailer/PHPMailer.php";
include "../../mailer/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
$response = new stdClass(); // create new response object
$response->status = "error";

if (isset($_POST["new"]) && isset($_POST["reNew"])) {
    if (empty(trim($_POST["new"]))) {
        $response->message = "New password must not be empty";
    } else if (strlen($_POST["new"]) < 8 || strlen($_POST["new"]) > 15) {
        $response->message = "Password must be between 8 - 15 characters";
    } else if ($_POST["new"] != $_POST["reNew"]) {
        $response->message = "Passwords does not match, please try again";
    } else {
        // set status to error by default

        $verificationCode = uniqid();

        Database::execute("UPDATE `admin` SET `otp`='" . $verificationCode . "'");

        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'info.ntsachira@gmail.com';
        $mail->Password = 'fpkyticwolzzxjlq';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('info.ntsachira@gmail.com', 'ToyShop Admin Help Center');
        $mail->addReplyTo('info.ntsachira@gmail.com', 'ToyShop Admin Help Center');
        $mail->addAddress("ntsachira@gmail.com");
        $mail->isHTML(true);
        $mail->Subject = 'ToyShop Admin - Reset password Verification Code';
        $bodyContent = '<h3 style="font-family: monospace;">PLease use the following verification code to complete your request</h3>
    <span style=" padding:5px; padding-left: 10px; background-color: orange; font-family: monospace; font-size:20px; letter-spacing: 5px;">
    ' . $verificationCode . '</span>';
        $mail->Body = $bodyContent;

        if (!$mail->send()) {
            $response->message = "Something went wrong. Please try again later.";
        } else {
            $response->status = "success";
            $response->message = "Verification Code sent to your email";
        }
    }
} else {
    $response->message = "Something went wrong. Please try again later.";
}




echo json_encode($response);

