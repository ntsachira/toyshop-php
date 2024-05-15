<?php

session_start();
include '../../connection.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../index.php");
}

$response = new stdClass();
$response->status = "faild";

$category_result = Database::execute("SELECT `category_id`,`category_name`,
SUM((`invoice_item_quantity`*`invoice_item_price`)+(`shipping_fee`*CEIL(invoice_item_quantity/2))) AS `price`
FROM `product` INNER JOIN `invoice_item` ON `invoice_item`.`product_product_id`=`product`.`product_id` INNER JOIN `category` ON 
`category`.`category_id`=`product`.`category_category_id` GROUP BY `category_category_id` ");

if ($category_result->num_rows > 0) {

    $response->status = "success";
    $response->data = array();

    while ($category_data = $category_result->fetch_assoc()) {

       
            $categories = new stdClass();

            $categories->id = $category_data['category_id'];
            $categories->name = $category_data['category_name'];
            $categories->count = $category_data['price'];

            array_push($response->data, $categories);
     

    }
} else {
    $response->message = "No users found";
}

echo json_encode($response);

