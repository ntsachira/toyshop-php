<?php
include '../../connection.php';

$date = new DateTimeImmutable("now", new DateTimeZone("Asia/Colombo"));

$start_date = $date->modify("1 month ago");
$range = "";

if (isset($_GET["range"]) && !empty($_GET["range"])) {
    if ($_GET["range"] == "month") {
        $start_date = $date->modify("1 month ago");
    } else if ($_GET["range"] == "six_months") {
        $start_date = $date->modify("6 months ago");
    }else if ($_GET["range"] == "last_year") {
        $start_date = $date->modify("12 months ago");
    }else if ($_GET["range"] == "two_years") {
        $start_date = $date->modify("2 years ago");
    }
}
$range = " WHERE `date` > '".$start_date->format("Y-m-d H:i:s")."' ";

$low_selling_result = Database::execute("SELECT product_id,title,price,SUM(invoice_item.invoice_item_quantity) AS `qty`,`date` 
FROM `invoice` INNER JOIN `invoice_item` ON invoice.invoice_id = invoice_item.invoice_invoice_id INNER JOIN `product` ON
product.product_id = invoice_item.product_product_id $range GROUP BY product_id ORDER BY `qty` DESC LIMIT 10");


?>

<div class="row">
    <div class="col-5 mb-2">
        <h4>Low Selling Product Report (<?php echo $low_selling_result->num_rows  ?>)</h4>
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
                    <th>Sold</th>
                    <th>Revenue(Rs)</th>                  
                </tr>
            </thead>
            <tbody>
                <?php        
                $revenue = 0;      
                while ($product_data = $low_selling_result->fetch_assoc()) {    
                    $revenue += ($product_data["price"] * $product_data["qty"]);              
                    ?>
                    <tr>
                        <td><?php echo $product_data["product_id"] ?></td>
                        <td><?php echo $product_data["title"] ?></td>
                        <td class="text-end"><?php echo number_format($product_data["price"], 2) ?></td>
                        <td class="text-center">
                            <?php echo $product_data["qty"] == null ? "0" : $product_data["qty"] ?></td>
                         <td class="text-end">   <?php echo number_format($product_data["price"] * $product_data["qty"], 2) ?></td> 
                    </tr>
                    <?php
                 
                }
                ?>
                <tr>
                    <th colspan="4" class="text-end">Total Revenue</th>
                    <th colspan="1" class="text-end"><?php echo number_format($revenue, 2) ?></th>
                </tr>
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