<?php

session_start();
include "../connection.php";

$response = new stdClass();
$response->status = "error";

$email = $_SESSION["user"]["email"];

$fname = $_POST["fname"];
$lname = $_POST["lname"];
$mobile = $_POST["mobile"];
$line1 = $_POST["line1"];
$line2 = $_POST["line2"];
$city = $_POST["city"];
$postalCode = $_POST["postalCode"];

if (empty($line1)) {
    $response->message = "Address line 1 can not be empty";
} else if (empty($line2)) {
    $response->message = "Address line 2 can not be empty";
} else if ($city == "0") {
    $response->message = "Please select a city";
} else if (empty($postalCode)) {
    $response->message = "Postal Code can not be empty";
} else {


    $active_user = Database::execute("SELECT * FROM `active_user` WHERE `email`='" . $email . "'");

    if ($active_user->num_rows == 1) {

        $query = "UPDATE `user` SET ";
        if (!empty($fname)) {
            $first = "`first_name`='" . $fname . "' ";
            $query = $query . $first;
        }
        if (!empty($lname)) {
            if (isset($fname)) {
                $query = $query . ", ";
            }
            $last = "`last_name`='" . $lname . "' ";
            $query = $query . $last;
        }
        if (!empty($mobile)) {
            if (isset($lname) || isset($first)) {
                $query = $query . ", ";
            }
            $mob = "`mobile`='" . $mobile . "' ";
            $query = $query . $mob;
        }

        if (!empty($fname) || !empty($lname) || !empty($mobile)) {
            Database::execute($query . " WHERE `email`='" . $email . "'");
        }

        $address_result = Database::execute("SELECT * FROM `user_has_address` WHERE `user_email`='" . $email . "'");

        if ($address_result->num_rows == 1) {
            Database::execute("UPDATE `user_has_address` SET `city_city_id`='" . $city . "' , `line1`='" . $line1 . "', `line2`='" . $line2 . "' , `postal_code`='" . $postalCode . "' WHERE
             `user_email`='" . $email . "'");
        } else {
            Database::execute("INSERT INTO `user_has_address` (`user_email`,`city_city_id`,`line1`,`line2`,`postal_code`) 
            VALUES ('" . $email . "','" . $city . "','" . $line1 . "','" . $line2 . "','" . $postalCode . "')");
        }

        $result = Database::execute("SELECT * FROM `active_user` WHERE `email`='$email'");         

        $userData = $result->fetch_assoc();

        $_SESSION["user"]=$userData;

        $response->message = "Profile Successfully Updated";
        $response->status = "success";

        if (sizeof($_FILES) == 1) {

            $image = $_FILES["image"];
            $extension = pathinfo($image["name"], PATHINFO_EXTENSION);            

            $allowed_types = array("jpg", "jpeg", "svg", "png", "webp");

            if (in_array($extension, $allowed_types)) {
                $new_file_name = $fname . "_" . $mobile . "." . $extension;
                
                move_uploaded_file($image["tmp_name"], "../resource/user_image/" . $new_file_name);

                $image_result = Database::execute("SELECT * FROM `user_image` WHERE `user_email`='" . $email . "'");

                if ($image_result->num_rows == 1) {
                    Database::execute("UPDATE `user_image` SET `image_path`='" . $new_file_name . "' WHERE `user_email`='" . $email . "'");
                } else {
                    Database::execute("INSERT INTO `user_image` (`user_email`,`image_path`) VALUES ('" . $email . "','" . $new_file_name . "')");
                }               
                
            } else {
                $response->status = "error";
                $response->message = "Invalid file type (recommended types -jpg,jpeg,svg,png,webp)";
            }
        }        

    } else {
        $response->message = "Invalid User";
    }

}


echo json_encode($response);


?>