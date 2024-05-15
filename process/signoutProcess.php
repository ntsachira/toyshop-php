<?php 
session_start();

$response = new stdClass();
$response->status ="error";

if(isset($_SESSION["user"])){
    $_SESSION["user"] = null;
    session_destroy();
    $response->status = "success";    
}

echo json_encode($response);

