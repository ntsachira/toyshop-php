<?php
session_start();
if (isset($_SESSION['user'])) {
    include '../connection.php';

    $response = new stdClass();
    $response->status = "faild";

    if (isset($_POST["pid"]) && isset($_POST["rate"])) {
        $product_result = Database::execute("SELECT * FROM `product` WHERE `product_id` = '" . $_POST['pid'] . "'");
        if ($product_result->num_rows == 1) {
            $date = new DateTime();
            $timeZone = new DateTimeZone('Asia/Colombo');
            $date->setTimezone($timeZone);

            $invoice_item_id = 0;
            if(isset($_POST['inv_item_id']) && !empty($_POST['inv_item_id'])){
                $invoice_item_id = $_POST["inv_item_id"];
            }

            if (empty(trim($_POST['review']))) {
                if($invoice_item_id == 0){
                    Database::execute("INSERT INTO `reviews` (`rate`,`product_product_id`,`user_email`,`review_date`) 
                VALUES('" . $_POST['rate'] . "','" . $_POST['pid'] . "','" . $_SESSION['user']['email'] . "','" . date_format($date, "Y-m-d H:i:s") . "') ");
                }else{
                    Database::execute("INSERT INTO `reviews` (`rate`,`product_product_id`,`user_email`,`review_date`,`invoice_item_invoice_item_id`) 
                VALUES('" . $_POST['rate'] . "','" . $_POST['pid'] . "','" . $_SESSION['user']['email'] . "',
                '" . date_format($date, "Y-m-d H:i:s") . "','".$invoice_item_id."') ");
                }
                
                $response->status = "success";
                $response->message = "Review submited Successfully";
            } else {
                if (strlen(trim($_POST['review'])) > 500) {
                    $response->message = "Review should not exceed 500 characters";
                } else {
                    if($invoice_item_id == 0){
                        Database::execute("INSERT INTO `reviews` (`rate`,`user_review`,`product_product_id`,`user_email`,`review_date`) 
                    VALUES('" . $_POST['rate'] . "','" . $_POST['review'] . "','" . $_POST['pid'] . "','" . $_SESSION['user']['email'] . "'
                    ,'" . date_format($date, "Y-m-d H:i:s") . "') ");
                    }else{
                    Database::execute("INSERT INTO `reviews` (`rate`,`user_review`,`product_product_id`,`user_email`,`review_date`,`invoice_item_invoice_item_id`) 
                    VALUES('" . $_POST['rate'] . "','" . $_POST['review'] . "','" . $_POST['pid'] . "','" . $_SESSION['user']['email'] . "'
                    ,'" . date_format($date, "Y-m-d H:i:s") . "','".$invoice_item_id."') ");
                    }
                    $response->status = "success";
                    $response->message = "Review submited Successfully";
                }
            }

        } else {
            $response->message = "Product not found, Please try again";
        }
    } else {
        $response->message = "Something went wrong please try again";
    }

   

    echo json_encode($response);
}

