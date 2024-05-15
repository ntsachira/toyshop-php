<!DOCTYPE html>
<html>

<body>
    <div class="row mb-3">
        <h1>Settings</h1>
    </div>
    <div class="row m-0 justify-content-center">
        <div class="col-12 col-md-8 col-lg-6 ">
            <div class="ui secondary menu" id="setting-tabs">
                <a class="active item" data-tab="first">General</a>
                <a class=" item" data-tab="second">Security</a>
                <a class="item" data-tab="third">Account</a>
                <a class="item" data-tab="history" onclick="loadAdminLoginHistory(1);">Log In History</a>
            </div>
            <?php
            $site_result = Database::execute("SELECT * FROM `footer`");
            $site_data = $site_result->fetch_assoc();
            ?>
            <div class="ui active tab segment" data-tab="first">
                <!-- wesite name  -->
                <!-- footer info -->
                <div class="mb-3">
                    <label for="site-name" class="form-label">Website Name</label>
                    <input type="text" class="form-control" id="site-name"
                        value="<?php echo $site_data["site_name"] ?>">
                </div>
                <div class="mb-3">
                    <label for="contact-email" class="form-label">Contact Email</label>
                    <input type="email" class="form-control" id="contact-email"
                        value="<?php echo $site_data["email"] ?>">
                </div>
                <div class="mb-3">
                    <label for="tele" class="form-label">Contact Number</label>
                    <input type="text" class="form-control" id="tele" value="<?php echo $site_data["tele"] ?>">
                </div>
                <div class="mb-3">
                    <label for="mission" class="form-label">Mission</label>
                    <textarea class="form-control" id="mission" rows="3"><?php echo $site_data["mission"] ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="copy" class="form-label">Copy Right Statement</label>
                    <textarea class="form-control" id="copy" rows="3"><?php echo $site_data["copy_right"] ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control" id="address" rows="3"><?php echo $site_data["address"] ?></textarea>
                </div>
                <div class="row gap-2 px-2">
                    <button class="col ui button" onclick="window.location.reload();">Reset</button>
                    <button class="col ui button teal" id="general-save-button" onclick="updateSiteData()">Save</button>
                </div>
            </div>
            <div class="ui  tab segment" data-tab="second">
                <!-- change password -->
                <!-- toggle otp login -->
                <h5>Reset Password</h5>
                <div class="mb-3">
                    <label for="new-pass" class="form-label">Enter New Password</label>
                    <input type="password" class="form-control" id="new-pass" placeholder="">
                </div>
                <div class="mb-3">
                    <label for="re-pass" class="form-label">Re Enter New Password</label>
                    <input type="password" class="form-control" id="re-pass" placeholder="">
                </div>
                <div class="mb-3 d-flex justify-content-end">
                    <button class="col ui button teal" id="submit-button"
                        onclick="resetAdminPassword();">Submit</button>
                </div>
                <h5>Toggle Login with OTP </h5>
                <?php
                $admin_result = Database::execute("SELECT * FROM `admin`");
                $admin_data = $admin_result->fetch_assoc();
                ?>
                <div class="d-flex justify-content-between">
                    <div class="ui toggle checkbox">
                        <input type="checkbox" id="check-switch" name="public" onchange="toggleOtpLogin();" <?php if ($admin_data["admin_login_options_type_id"] == 2) { ?>checked<?php } ?>>
                        <label id="otp-info-label" for="check-switch">OTP login
                            <?php echo $admin_data["admin_login_options_type_id"] == 2 ? "Active" : "Inactive" ?>
                        </label>
                    </div>
                    <div class="ui inline loader" id="loader1"></div>
                </div>
            </div>
            <div class="ui tab segment" data-tab="third">
                <!-- image -->
                <!-- name -->
                <div class="mb-3 d-flex justify-content-center">
                    <img src="../resource/user_image/Sachira_0714798940.png" class="img-thumbnail" alt=""
                        style="width:10rem;height:12rem;object-fit:cover;">
                </div>
                <div class="mb-3">
                    <label for="first-name" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="first-name"
                        value="<?php echo $admin_data["first_name"] ?>">
                </div>
                <div class="mb-3">
                    <label for="last-name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="last-name"
                        value="<?php echo $admin_data["last_name"] ?>">
                </div>
                <div class="row gap-2 px-2">
                    <button class="col ui button" onclick="window.location.reload()">Reset</button>
                    <button class="col ui button teal" id="name-save-button" onclick="updateAdmin();">Save</button>
                </div>
            </div>
            <div class="ui  tab segment" data-tab="history">
                <h5>Admin Log In Date and Time</h5>
            <div class="table-responsive">
                <table class="table table-striped align-middle table-bordered" id="login-history-container">
                   <!-- table content loads here -->
                </table>
            </div>
            </div>
        </div>
    </div>

    <script>
        $('.menu .item')
            .tab()
            ;
    </script>
</body>

</html>