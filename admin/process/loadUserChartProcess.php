<?php

session_start();
include '../../connection.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../index.php");
}

$response = new stdClass();
$response->status = "faild";

$user_result = Database::execute("SELECT * FROM `active_user`  WHERE `email` != 'admin@gmail.com'");

if ($user_result->num_rows > 0) {

    $response->status = "success";
    $response->data = array();
 
   for($i = 5; $i >= 0; $i--){
    $month = date("Y-m", strtotime("-".$i." month"));
    $month_result = Database::execute("SELECT * FROM `active_user` WHERE `joined_date` LIKE '".$month."%'");

    $month_data = new stdClass();

    $month_data->month = date("M", strtotime("-".$i." month"));
    $month_data->year = date("Y", strtotime("-".$i." month"));
    $month_data->count = $month_result->num_rows;

    array_push($response->data, $month_data);
   }
} else {
    $response->message = "No users found";
}

echo json_encode($response);

