<?php
include '../../connection.php';

$product_result = Database::execute("SELECT * FROM `product` WHERE `quantity` = '0'");

$date = new DateTime("now", new DateTimeZone("Asia/Colombo"));

?>

<div class="row">
    <div class="col-5 mb-2">
        <h4>Out Of Stock Product Report (<?php echo $product_result->num_rows ?>)</h4>
    </div>
    <div class="col-7 d-flex mb-2">
        <span class="text-end w-100">Generated On: <b><?php echo $date->format("d M Y H:i:s") ?></b></span>
    </div>
    <div class="col-12">
        <table class="table table-bordered table-striped h-auto">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th class="text-end">Price (Rs)</th>
                    <th>Added_Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($product_data = $product_result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $product_data["product_id"] ?></td>
                        <td><?php echo $product_data["title"] ?></td>
                        <td class="text-end"><?php echo number_format($product_data["price"], 2) ?></td>
                        <td style="min-width:11rem"><?php echo $product_data["datetime_added"] ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="col-12">
        <h6>&copy; 2024 ToyShop</h6>
    </div>    
</div>
<div id="report-print-btn" class="row position-fixed bottom-0 end-75 mb-5 w-auto py-3 bg-white bg-opacity-75 shadow rounded-3">
    <div class="col-12 d-flex flex-row-reverse w-100">
        <button class="ui button orange" onclick="printReport();">Print</button>
        <button class="ui button" onclick="window.location.reload()">Reset</button>
    </div>
</div>