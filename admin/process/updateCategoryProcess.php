<?php
include "../../connection.php";

$response = new stdClass();
$response->status = "faild";

if(isset($_POST["id"])&&isset($_POST["name"])){
    $category_result = Database::execute("SELECT * FROM `category` WHERE `category_name` = '".$_POST["name"]."'");
    if($category_result->num_rows == 0){
        Database::execute("UPDATE `category` SET `category_name` = '".$_POST["name"]."' WHERE `category_id` = '".$_POST["id"]."' ");
        $response->status = "success";
        $response->message = "Category Name Updated";
    }else{
        $response->message = "Category name already exists";
    }
    if(sizeof($_FILES) == 1){
        $allowed_types = array("jpg", "jpeg", "svg", "png", "webp");
        $type = pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION);

        if(in_array($type,$allowed_types)){

            move_uploaded_file($_FILES["image"]["tmp_name"],"../../resource/category_image/cat_".$_POST["id"].".".$type);
            $category_image_result = Database::execute("SELECT * FROM `category_image` WHERE `category_category_id` = '".$_POST["id"]."'");
            $image_path = "resource/category_image/cat_".$_POST["id"].".".$type;
            if($category_image_result->num_rows == 1){
                Database::execute("UPDATE `category_image` SET `image_path` = '".$image_path."' WHERE `category_category_id` = '".$_POST["id"]."'");
            }else{
                Database::execute("INSERT INTO `category_image` (`image_path`,`category_category_id`) VALUES ('".$image_path."','".$_POST["id"]."')");
            }
            $response->status = "success";
            $response->message = $response->message." | Image Uploaded Successfully";
        }else{
            $response->message = $response->message." | Invalid file type";
        }
    }
}else{
    $response->message = "Something went wrong please try again";
}

echo json_encode($response);