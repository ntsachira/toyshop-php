<?php
session_start();
include "../connection.php";

$response = new stdClass();
$response->status = "faild";

if (isset($_SESSION['user'])) {
    if (isset($_GET['id']) & !empty($_GET['id']) & isset($_GET['qty']) & !empty($_GET['qty'])) {

        $product_result = Database::execute("SELECT * FROM `active_product` WHERE `product_id` = '" . $_GET['id'] . "'");

        if ($product_result->num_rows == 1) {
            $product_data = $product_result->fetch_assoc();

            if ($product_data['quantity'] >= $_GET['qty']) {

                $address_result = Database::execute("SELECT * FROM `user_has_address` INNER JOIN `city` ON user_has_address.city_city_id = city.city_id 
                WHERE `user_email` ='" . $_SESSION['user']['email'] . "' ");

                if ($address_result->num_rows == 1) {
                    $address_data = $address_result->fetch_assoc();

                    $order_id = round(microtime(true)*100);
                    $merchant_id = "1223792";
                    $merchant_secret = "NTg2MTcyMjUxMTg5MzY3ODA0MjE1MTc0NjQwNzQxMTQ0ODQ1Nzg3";
                    $amount = $product_data['price'] * $_GET['qty'];
                    $currency = "LKR";

                    $hash = strtoupper(
                        md5(
                            $merchant_id .
                            $order_id .
                            number_format($amount, 2, '.', '') .
                            $currency .
                            strtoupper(md5($merchant_secret))
                        )
                    );

                    $response->data = new stdClass();
                    $response->data->sandbox = true;
                    $response->data->merchant_id = $merchant_id;
                    $response->data->return_url = "home.php";
                    $response->data->cancel_url = "singleProductView.php?userType=user";
                    $response->data->notify_url = "http://sample.com/notify";
                    $response->data->order_id = $order_id;
                    $response->data->items = "INV-".$order_id;
                    $response->data->amount = $amount;
                    $response->data->currency = $currency;
                    $response->data->hash = $hash;
                    $response->data->first_name = $_SESSION['user']['first_name'];
                    $response->data->last_name = $_SESSION['user']['last_name'];
                    $response->data->email = $_SESSION['user']['email'];
                    $response->data->phone = $_SESSION['user']['mobile'];
                    $response->data->address = $address_data['line1'].", ".$address_data['line2'];
                    $response->data->city = $address_data['city_name'];
                    $response->data->country = "Sri Lanka";

                    $response->status = "success";

                } else {
                    $response->message = "Please complete your profile address section and try again";
                }

            } else {
                $response->message = "Insufficient stock, Please contact the seller";
            }

        } else {
            $response->message = "Product not found, Please try again";
        }
    } else {
        $response->message = "Something went wrong, Please try again";
    }
} else {
    $response->status = 'log';
    $response->message = "Please login first";
}

echo json_encode($response);