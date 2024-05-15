<?php

session_start();
include '../../connection.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../index.php");
}

$response = new stdClass();
$response->status = "faild";

if(empty($_POST["category"])){
    $response->message = "Please Select a Category";
}else if(empty($_POST["brand"])){
    $response->message = "Please Select a Brand";
}else if(empty($_POST["model"])){
    $response->message = "Please Select a Model";
}else if(empty($_POST["title"])){
    $response->message = "Please Enter a Title";
}else if(empty($_POST["description"])){
    $response->message = "Please Enter a Description";
}else if(empty($_POST["deliveryWithin"])&&$_POST["deliveryWithin"]!=0){
    $response->message = "Please Enter the delivery fee within Matara";
}else if(empty($_POST["deliveryOut"])&&$_POST["deliveryOut"]!=0){
    $response->message = "Please Enter the delivery fee outside Matara";
}else if(sizeof($_FILES)==0){
    $response->message = "Please Select at least one image";
}else if(empty($_POST["color"])){
    $response->message = "Please Select a color";
}else if(empty($_POST["price"])){
    $response->message = "Please Enter a Price";
}else if(empty($_POST["quantity"])){
    $response->message = "Please Enter a Quantity";
}else{
    $brand_has_model_id;
    //brand has model
    $brand_has_model_result = Database::execute("SELECT * FROM `brand_has_model` WHERE 
    `brand_brand_id` = '" . $_POST['brand'] . "' AND `model_model_id` = '" . $_POST['model'] . "'");
    if ($brand_has_model_result->num_rows > 0) {
        $brand_has_model_id = $brand_has_model_result->fetch_assoc()['brand_has_model_id'];
    } else {
        Database::execute("INSERT INTO `brand_has_model` (`brand_brand_id`,`model_model_id`) 
        VALUES ('" . $_POST['brand'] . "','" . $_POST['model'] . "')");
        $brand_has_model_id = Database::$connection->insert_id;        
    }
    //category has brand
    $category_has_brand_result = Database::execute("SELECT * FROM `category_has_brand` WHERE 
    `category_category_id` = '" . $_POST['category'] . "' AND `brand_brand_id` = '" . $_POST['brand'] . "'");

    if ($category_has_brand_result->num_rows != 1) {
        Database::execute("INSERT INTO `category_has_brand` (`category_category_id`,`brand_brand_id`) 
        VALUES ('" . $_POST['category'] . "','" . $_POST['brand'] . "')");
    }

    //product
    $product_result = Database::execute("SELECT * FROM `product` WHERE `title` = '" . $_POST['title'] . "'");
    if($product_result->num_rows>0){
        $response->message = "Product already exists";
    }else{   
        Database::execute("INSERT INTO `product` (`price`,`quantity`,`title`,`description`,`datetime_added`,
        `delivery_fee_matara`,`delivery_fee_other`,`brand_has_model_brand_has_model_id`,`condition_condition_id`,
        `category_category_id`,`status_status_id`) 
        VALUES ('".$_POST['price']."','".$_POST['quantity']."','".$_POST['title']."','".$_POST['description']."',
        '".date("Y-m-d H:i:s")."','".$_POST["deliveryWithin"]."','".$_POST["deliveryOut"]."','".$brand_has_model_id."',
        '".$_POST['condition']."','".$_POST["category"]."','1')");

        $product_id = Database::$connection->insert_id;

        //product_has_color
        Database::execute("INSERT INTO `product_has_color` (`product_product_id`,`color_color_id`)
        VALUES ('".$product_id."','".$_POST['color']."')");

        //product_has_image
        $valid = true;
        foreach ($_FILES as $key => $value) {
         $allowed_types = array('jpg', 'jpeg', 'png', 'svg');
            $file_ext = pathinfo($_FILES[$key]['name'], PATHINFO_EXTENSION);
            if (!in_array($file_ext, $allowed_types)) {
                $response->message = "Please Select a valid image";
                $valid = false;
            } 
        }

        if($valid){
            $image_number = 1;
            foreach ($_FILES as $key => $value) {                
                $extension = pathinfo($_FILES[$key]['name'], PATHINFO_EXTENSION);
                $file_name = $product_id."_". $image_number. "." . $extension;
                $file_path = "../../resource/product_image/" . $file_name;
                move_uploaded_file($_FILES[$key]['tmp_name'], $file_path);
                Database::execute("INSERT INTO `product_image` (`product_product_id`,`image_path`)
                VALUES ('".$product_id."','".$file_name."')"); 
                $image_number++;               
            }
            $response->status = "success";
                $response->message = "Product Successfully Added";
        }
    }   
    
}

echo json_encode($response);

