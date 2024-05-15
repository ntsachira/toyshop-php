<?php

include "../../connection.php";

include "../../mailer/SMTP.php";
include "../../mailer/PHPMailer.php";
include "../../mailer/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

$response = new stdClass(); // create new response object
$response->status = "error";

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
$mail->setFrom('info.ntsachira@gmail.com', 'ToyShop Admin LgoIn');
$mail->addReplyTo('info.ntsachira@gmail.com', 'ToyShop Admin LgoIn');
$mail->addAddress("ntsachira@gmail.com");
$mail->isHTML(true);
$mail->Subject = 'ToyShop Admin - LogIn OTP';
$bodyContent = '<h3 style="font-family: monospace;">PLease use the following OTP to complete your Login</h3>
    <span style=" padding:5px; padding-left: 10px; background-color: orange; font-family: monospace; font-size:20px; letter-spacing: 5px;">
    ' . $verificationCode . '</span>';
$mail->Body = $bodyContent;

if (!$mail->send()) {
    $response->message = "Something went wrong. Please try again later.";
} else {
    $response->status = "success";
    $response->message = "Verification Code sent to your email";
}


echo json_encode($response);

