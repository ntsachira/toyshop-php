<?php

session_start();
include '../../connection.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../index.php");
}

$response = new stdClass();
$response->status = "faild";

$invoice_result = Database::execute("SELECT `invoice_status_id`,`status_name`,COUNT(invoice_status_id) AS `invoice_count` FROM `invoice` INNER JOIN `invoice_status` ON 
`invoice_status`.`invoice_status_id`=`invoice`.`invoice_status_invoice_status_id`  GROUP BY `invoice_status_id` ");

if ($invoice_result->num_rows > 0) {

    $response->status = "success";
    $response->data = array();

    while ($invoice_data = $invoice_result->fetch_assoc()) {

        if ($invoice_data['invoice_count'] != 0) {
            $invoices = new stdClass();

            $invoices->id = $invoice_data['invoice_status_id'];
            $invoices->name = $invoice_data['status_name'];
            $invoices->count = $invoice_data['invoice_count'];

            array_push($response->data, $invoices);
        }

    }
} else {
    $response->message = "No users found";
}

echo json_encode($response);

