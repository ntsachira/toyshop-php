<?php
session_start();
include "../connection.php";

$response = new stdClass();
$response->status="error";
$response->message="";

$result = Database::execute("SELECT * FROM `city_data` WHERE `city_id`='".$_GET["city_id"]."'");

if($result->num_rows == 1){
    $result_data = $result->fetch_assoc();
    $data = new stdClass();
    $data->district = $result_data["district_name"];
    $data->province = $result_data["province_name"];

    $response->data = $data;
    $response->status = "success";
    $response->message = "Loading Successfull";
}

echo json_encode($response);
?>