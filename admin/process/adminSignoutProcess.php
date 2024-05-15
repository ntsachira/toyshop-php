<?php

session_start();

$response = new stdClass();
$response->status ="error";

if(isset($_SESSION["admin"])){
    $_SESSION["admin"] = null;
    $response->status = "success";    
}

echo json_encode($response);