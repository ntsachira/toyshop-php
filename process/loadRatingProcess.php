<?php
include "../connection.php";

$response = new stdClass();
$response->status = "faild";

if(isset($_GET['id']) & !empty($_GET['id'])){
    $product_result = Database::execute("SELECT * FROM `product` WHERE `product_id` = '" . $_GET['id'] . "'");
    if ($product_result->num_rows == 1) {
        $review_result = Database::execute("SELECT * FROM `reviews` WHERE `product_product_id` = '".$_GET['id']."'");
        $response->data = new stdClass();
        $response->data->rate = 0;
        while($review_data = $review_result->fetch_assoc()){
            $response->data->rate =  $response->data->rate + $review_data['rate'];
        }
        $response->data->rate = (int)( $response->data->rate / $review_result->num_rows);
        $response->status = 'success';
    } else {
        $response->message = "Product not found, Please try again";
    }
}

echo json_encode($response);
