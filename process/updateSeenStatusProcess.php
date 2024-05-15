<?php
session_start();
include_once "../connection.php";

if(isset($_SESSION["user"])){
    Database::execute("UPDATE `message_history` SET `seen_status_seen_status_id`='1' WHERE 
    `receiver`='" . $_SESSION['user']["email"] . "'");
}