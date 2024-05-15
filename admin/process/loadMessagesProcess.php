<?php
session_start();
include "../../connection.php";

if (isset($_GET["email"])) {
    $message_result = Database::execute("SELECT * FROM `message_history` WHERE 
    `sender`='" . $_GET["email"] . "' AND `receiver`='admin@gmail.com' OR 
    `sender`='admin@gmail.com' AND `receiver`='" . $_GET["email"] . "' ORDER BY `message_date` ASC");

    if ($message_result->num_rows != 0) {
        ?>
        <div class="col-12 d-flex flex-row-reverse mb-2">
            <p class="text-white bg-blue px-3 py-2 rounded">Hi
                <?php echo "sahan" ?>! How may I help you today?
            </p>
        </div>
        <?php
        while ($message_data = $message_result->fetch_assoc()) {
            if ($message_data["sender"] == "admin@gmail.com") {
                ?>
                <div class="col-12 d-flex flex-row-reverse mb-2">
                    <p class="text-white bg-blue px-3 py-2 rounded">
                        <?php echo $message_data['message'] ?>
                    </p>
                </div>
                <?php
            } else {
                $image_result = Database::execute("SELECT *FROM `user_image` WHERE `user_email` = '".$_GET['email']."'");
                $image_path = "new_user.svg";
                if($image_result->num_rows != 0){
                    $image_path = "user_image/".$image_result->fetch_assoc()['image_path'];
                }
                ?>
                <div class="col-12 mb-2">
                    <div class="row gap-2 align-items-start">
                        <div class="" style="width: 3rem;">
                            <img src="../resource/<?php echo $image_path ?>" style="height: 3.1rem;width: 3rem;object-fit:cover" id="chat-user-image"
                            class="rounded-circle shadow-sm border" alt="">
                        </div>
                        <div class="col d-flex">
                            <p class="px-3 shadow-sm py-2 roun rounded bg-white border">
                            <?php echo $message_data['message'] ?></p>
                        </div>
                    </div>
                </div>               
                <?php
            }
        }

    }else{
        ?>
        <div class="col-12 mb-2">
            <div class="row gap-2 align-items-start">
                <div class="d-none" style="width: 3rem;">
                    <img src="../resource/new_user.svg" style="height: 3.1rem;width: 3rem;object-fit:cover" id="chat-user-image"
                    class="rounded-circle shadow-sm border" alt="">
                </div>
                <div class="col d-flex">
                    <p class="px-3 shadow-sm py-2 roun rounded bg-white border">
                    No Messages from this user
                </div>
            </div>
        </div>               
        <?php
    }
}


?>