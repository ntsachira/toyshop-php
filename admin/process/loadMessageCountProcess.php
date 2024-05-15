<?php
include "../../connection.php";

$message_result = Database::execute("SELECT `sender` FROM `message_history` 
WHERE `seen_status_seen_status_id` = '2' AND `sender` != 'admin@gmail.com' GROUP BY `sender`");

echo $message_result->num_rows;
