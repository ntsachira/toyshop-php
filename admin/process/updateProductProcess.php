<?php
session_start();
include '../../connection.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../index.php");
}

$response = new stdClass();
$response->status = "faild";

if (empty($_POST["title"])) {
    $response->message = "Product Title is required";
} else if (empty($_POST["description"])) {
    $response->message = "Product Description is required";
} else if (empty($_POST["deliveryWithin"])&&$_POST["deliveryWithin"]!=0) {
    $response->message = "Delivery fees Within Matara is required";
} else if (empty($_POST["deliveryOut"])&&$_POST["deliveryOut"]!=0) {
    $response->message = "Delivery fees Out of Matara is required";
} else if (empty($_POST["price"])) {
    $response->message = "Product Price is required";
} else if (empty($_POST["quantity"])) {
    $response->message = "Product Quantity is required";
} else {
    $product_result = Database::execute("SELECT * FROM `product` WHERE `product_id` = '" . $_POST['id'] . "'");
    if ($product_result->num_rows == 1) {
        Database::execute("UPDATE `product` SET `title` = '" . $_POST['title'] . "', `description` = '" . $_POST['description'] . "',
         `delivery_fee_matara` = '" . $_POST['deliveryWithin'] . "', `delivery_fee_other` = '" . $_POST['deliveryOut'] . "',
          `price` = '" . $_POST['price'] . "', `quantity` = '" . $_POST['quantity'] . "' WHERE `product_id` = '" . $_POST['id'] . "'");

        $response->status = "success";
        $response->message = "Product Successfully Updated";

        if (sizeof($_FILES) > 0) {
            $allowed_types = array("jpg", "jpeg", "svg", "png", "webp");
            $valid = true;
            for ($i = 0; $i < sizeof($_FILES); $i++) {
                $type = pathinfo($_FILES["productImage" . $i]["name"], PATHINFO_EXTENSION);
                if (!in_array($type, $allowed_types)) {
                    $valid = false;
                    $response->message = "Please upload only image files";
                    $response->status = "faild";
                    break;
                }
            }
            if ($valid) {
                for ($i = 0; $i < sizeof($_FILES); $i++) {
                    $type = pathinfo($_FILES["productImage" . $i]["name"], PATHINFO_EXTENSION);
                    $image = $_FILES["productImage" . $i];
                    $image_name = $_POST['id'] . "_" . $i . "." . $type;
                    move_uploaded_file($image["tmp_name"], "../../resource/product_image/" . $image_name);
                    Database::execute("INSERT INTO `product_image` (`product_product_id`,`image_path`) VALUES ('" . $_POST['id'] . "','" . $image_name . "')");
                }

            }
        }
    } else {
        $response->message = "Product not found";
    }    
}

echo json_encode($response);