<?php

include "../connection.php";

include "../mailer/SMTP.php";
include "../mailer/PHPMailer.php";
include "../mailer/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;


$response = new stdClass(); // create new response object
$response->status = "error"; // set status to error by default

if (empty($_GET['email'])) {
    $response->message = "Please Enter your registered Email in the Email field";
} else {
    $email = $_GET['email'];
    $verificationCode = uniqid();

    Database::execute("UPDATE `user` SET `verification_code`='" . $verificationCode . "' WHERE `email`='" . $email . "'");

    $mail = new PHPMailer;
    $mail->IsSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'info.ntsachira@gmail.com';
    $mail->Password = 'fpkyticwolzzxjlq';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->setFrom('info.ntsachira@gmail.com', 'ToyShop Help Center');
    $mail->addReplyTo('info.ntsachira@gmail.com', 'ToyShop Help Center');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'ToyShop - Reset password Verification Code';
    $bodyContent = '<h3 style="font-family: monospace;">PLease use the following verification code to complete your request</h3>
    <span style=" padding:5px; padding-left: 10px; background-color: orange; font-family: monospace; font-size:20px; letter-spacing: 5px;">
    '.$verificationCode.'</span>';
    $mail->Body = $bodyContent;

    if (!$mail->send()) {
        $response->message = "Something went wrong. Please try again later.";
    } else {
        $response->status = "success";
        $response->message = "Verification Code sent to your email";
    }
}

echo json_encode($response);

?>