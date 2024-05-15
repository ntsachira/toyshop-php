<?php
session_start();
include "../../connection.php";

if (isset($_GET["email"])) {
    Database::execute("UPDATE `message_history` SET `seen_status_seen_status_id`='1' WHERE 
    `sender`='" . $_GET["email"] . "' AND `receiver`='admin@gmail.com'");

}


