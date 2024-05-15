<?php
session_start();
include "../connection.php";

$response = new stdClass();
$response->status = "faild";

if (isset($_SESSION['user'])) {


    $cart_result = Database::execute("SELECT * FROM `cart` INNER JOIN `active_product` ON `cart`.`product_product_id`=`active_product`.`product_id` 
         WHERE `user_email` = '" . $_SESSION['user']['email'] . "' AND `quantity` > 0");

    if ($cart_result->num_rows > 0) {
        

        $address_result = Database::execute("SELECT * FROM `user_has_address` INNER JOIN `city` ON user_has_address.city_city_id = city.city_id 
                WHERE `user_email` ='" . $_SESSION['user']['email'] . "' ");

        if ($address_result->num_rows == 1) {
            $address_data = $address_result->fetch_assoc();

            $amount = 0;
            $shippingTotal = 0;
            while($cart_data = $cart_result->fetch_assoc()){

                $amount = $amount + ($cart_data['price'] *$cart_data['cart_quantity']);

                if($address_data['city_city_id']==1){
                    $shippingTotal = $shippingTotal + ($cart_data['delivery_fee_matara']*(ceil($cart_data['cart_quantity']/2)));
                }else{
                    $shippingTotal = $shippingTotal + ($cart_data['delivery_fee_other']*(ceil($cart_data['cart_quantity']/2)));
                }
               
            }
            $order_id = round(microtime(true)*100);
            $merchant_id = "1223792";
            $merchant_secret = "NTg2MTcyMjUxMTg5MzY3ODA0MjE1MTc0NjQwNzQxMTQ0ODQ1Nzg3";
            $currency = "LKR";
            $amount = $amount+$shippingTotal;
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
            $response->data->address = $address_data['line1'] . ", " . $address_data['line2'];
            $response->data->city = $address_data['city_name'];
            $response->data->country = "Sri Lanka";

            $response->status = "success";

        } else {
            $response->message = "Please complete your profile address section and try again";
        }

    } else {
        $response->message = "No products found in your cart, Please try again";
    }

} else {
    $response->status = 'log';
    $response->message = "Please login first";
}

echo json_encode($response);