<?php

session_start();
include '../../connection.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../index.php");
}

$response = new stdClass();
$response->status = "faild";

$status_result = Database::execute("SELECT `status_id`,`status_name`,COUNT(status_id) AS `user_count` 
FROM `active_user` GROUP BY `status_id` ");

if ($status_result->num_rows > 0) {

    $response->status = "success";
    $response->data = array();

    while ($status_data = $status_result->fetch_assoc()) {

        if ($status_data['user_count'] != 0) {
            $status = new stdClass();

            $status->id = $status_data['status_id'];
            $status->name = $status_data['status_name'];
            $status->count = $status_data['user_count'];

            array_push($response->data, $status);
        }

    }
} else {
    $response->message = "No users found";
}

echo json_encode($response);

