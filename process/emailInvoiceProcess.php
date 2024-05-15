<?php
session_start();
include "../connection.php";

include "../mailer/SMTP.php";
include "../mailer/PHPMailer.php";
include "../mailer/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;


$response = new stdClass(); // create new response object
$response->status = "error"; // set status to error by default

if (!isset($_POST['invoice'])) {
    $response->message = "Something went wrong , Please contact the seller";
} else {    
  
    $mail = new PHPMailer;
    $mail->IsSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'info.ntsachira@gmail.com';
    $mail->Password = 'fpkyticwolzzxjlq';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->setFrom('info.ntsachira@gmail.com', 'ToyShop Invoice Center');
    $mail->addReplyTo('info.ntsachira@gmail.com', 'ToyShop Invoice Center');
    $mail->addAddress($_SESSION['user']['email']);
    $mail->isHTML(true);
    $mail->addEmbeddedImage('resource/logo.png', 'image_cid');
    $mail->Subject = 'ToyShop - Invoice';
    $bodyContent = $_POST['invoice'];
    $mail->Body = $bodyContent;

    if (!$mail->send()) {
        $response->message = "Could not send the Email. Please contact the seller.";
    } else {
        $response->status = "success";
        $response->message = "Copy of Invoice sent to your email";
    }
}

echo json_encode($response);

?>