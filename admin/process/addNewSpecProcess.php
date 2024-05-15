<?php

session_start();
include '../../connection.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../index.php");
}

$response = new stdClass();
$response->status = "faild";

if (isset($_GET["color"])&&!empty($_GET["color"])) {
    $color_result = Database::execute("SELECT * FROM `color` WHERE `color_name` = '" . $_GET['color'] . "'");
    if ($color_result->num_rows > 0) {
        $response->message = "Color already exists";
    } else {
        Database::execute("INSERT INTO `color` (`color_name`) VALUES ('" . $_GET['color'] . "')");
        $id = Database::$connection->insert_id;
        $response->status = "success";
        $response->message = "Color Successfully Added";

        // apppend the new color to the color list by sending html tags as text
        $response->data = "<option >Choose color</option>";
        $colorNew_result = Database::execute("SELECT * FROM `color`");
        while ($color_data = $colorNew_result->fetch_assoc()) {
            if ($color_data['color_id'] == $id) {
                $response->data .= '<option value=' . $color_data['color_id'] . ' selected>' . $color_data['color_name'] . '</option>';
            } else {
                $response->data .= '<option value=' . $color_data['color_id'] . '>' . $color_data['color_name'] . '</option>';
            }
        }

    }
} else if (isset($_GET["category"])&&!empty($_GET["category"])) {
    $category_result = Database::execute("SELECT * FROM `category` WHERE `category_name` = '" . $_GET['category'] . "'");
    if ($category_result->num_rows > 0) {
        $response->message = "Category already exists";
    } else {
        Database::execute("INSERT INTO `category` (`category_name`) VALUES ('" . $_GET['category'] . "')");
        $id = Database::$connection->insert_id;
        $response->status = "success";
        $response->message = "Category Successfully Added";

        // apppend the new category to the category list by sending html tags as text
        $response->data = "<option >Choose category</option>";
        $categoryNew_result = Database::execute("SELECT * FROM `category`");
        while ($category_data = $categoryNew_result->fetch_assoc()) {
            if ($category_data['category_id'] == $id) {
                $response->data .= '<option value=' . $category_data['category_id'] . ' selected>' . $category_data['category_name'] . '</option>';
            } else {
                $response->data .= '<option value=' . $category_data['category_id'] . '>' . $category_data['category_name'] . '</option>';
            }
        }
        
    }

} else if (isset($_GET["brand"])&&!empty($_GET["brand"])) {
    $brand_result = Database::execute("SELECT * FROM `brand` WHERE `brand_name` = '" . $_GET['brand'] . "'");
    if ($brand_result->num_rows > 0) {
        $response->message = "Brand already exists";
    } else {
        Database::execute("INSERT INTO `brand` (`brand_name`) VALUES ('" . $_GET['brand'] . "')");
        $id = Database::$connection->insert_id;
        $response->status = "success";
        $response->message = "Brand Successfully Added";
        
        // apppend the new brand to the brand list by sending html tags as text
        $response->data = "<option >Choose brand</option>";
        $brandNew_result = Database::execute("SELECT * FROM `brand`");
        while ($brand_data = $brandNew_result->fetch_assoc()) {
            if ($brand_data['brand_id'] == $id) {
                $response->data .= '<option value=' . $brand_data['brand_id'] . ' selected>' . $brand_data['brand_name'] . '</option>';
            } else {
                $response->data .= '<option value=' . $brand_data['brand_id'] . '>' . $brand_data['brand_name'] . '</option>';
            }
        }
    }

} else if (isset($_GET["model"])&&!empty($_GET["model"])) {
    $model_result = Database::execute("SELECT * FROM `model` WHERE `model_name` = '" . $_GET['model'] . "'");
    if ($model_result->num_rows > 0) {
        $response->message = "Model already exists";
    } else {
        Database::execute("INSERT INTO `model` (`model_name`) VALUES ('" . $_GET['model'] . "')");
        $id = Database::$connection->insert_id;
        $response->status = "success";
        $response->message = "Model Successfully Added";
       
        // apppend the new model to the model list by sending html tags as text
        $response->data = "<option >Choose model</option>";
        $modelNew_result = Database::execute("SELECT * FROM `model`");
        while ($model_data = $modelNew_result->fetch_assoc()) {
            if ($model_data['model_id'] == $id) {
                $response->data .= '<option value=' . $model_data['model_id'] . ' selected>' . $model_data['model_name'] . '</option>';
            } else {
                $response->data .= '<option value=' . $model_data['model_id'] . '>' . $model_data['model_name'] . '</option>';
            }
        }
    }

} else {
    $response->message = "Something went wrong, Please try again";
}

echo json_encode($response);
