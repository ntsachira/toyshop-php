<?php
session_start();
include "../connection.php";

$message_result = Database::execute("SELECT * FROM `message_history` WHERE 
`sender`='" . $_SESSION["user"]["email"] . "' AND `receiver`='admin@gmail.com' OR 
`sender`='admin@gmail.com' AND `receiver`='" . $_SESSION["user"]["email"] . "' ORDER BY `message_date` ASC");

if ($message_result->num_rows == 0) {
    ?>
    <div class="col-12 mb-2">
        <div class="row gap-2 align-items-start justify-content-start">
            <div class="" style="width: 3rem;">
                <img src="resource/logo.png" class="rounded-circle shadow-sm bg-white border"
                    style="height: 3rem;width: 3rem;" alt="">
            </div>
            <div class="col d-flex">
                <p class="px-3 shadow-sm py-2 roun rounded bg-white border">Hi
                    <?php echo $_SESSION['user']['first_name'] ?>!, How may I help you today?
                </p>
            </div>
        </div>
    </div>
    <?php
} else {
    ?>
    <div class="col-12 mb-2">
        <div class="row gap-2 align-items-start justify-content-start">
            <div class="" style="width: 3rem;">
                <img src="resource/logo.png" class="rounded-circle shadow-sm bg-white border"
                    style="height: 3rem;width: 3rem;" alt="">
            </div>
            <div class="col d-flex">
                <p class="px-3 shadow-sm py-2 roun rounded bg-white border">Hi
                    <?php echo $_SESSION['user']['first_name'] ?>!, How may I help you today?
                </p>
            </div>
        </div>
    </div>
    <?php
    while ($message_data = $message_result->fetch_assoc()) {
        if ($message_data["sender"] != "admin@gmail.com") {
            ?>
            <div class="col-12 d-flex flex-row-reverse mb-2">
                <p class="text-white bg-orange shadow-sm p-3 py-2 rounded">
                    <?php echo $message_data['message'] ?>
                </p>
            </div>
            <?php
        } else {
            ?>
            <div class="col-12 mb-2">
                <div class="row gap-2 align-items-start justify-content-start">
                    <div class="" style="width: 3rem;">
                        <img src="resource/logo.png" class="rounded-circle shadow-sm bg-white border"
                            style="height: 3rem;width: 3rem;" alt="">
                    </div>
                    <div class="col d-flex">
                        <p class="px-3 shadow-sm py-2 roun rounded bg-white border">
                        <?php echo $message_data['message'] ?>
                        </p>
                    </div>
                </div>
            </div>
            <?php
        }
    }

}
?>