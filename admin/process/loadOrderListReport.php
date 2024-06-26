<?php
include '../../connection.php';

$date = new DateTimeImmutable("now", new DateTimeZone("Asia/Colombo"));

$status = "";
if (isset($_GET["status"]) && !empty($_GET["status"])) {
    $status = $_GET["status"];
}

$category_result = Database::execute("SELECT * FROM invoice 
INNER JOIN invoice_status ON invoice.invoice_status_invoice_status_id = invoice_status.invoice_status_id
WHERE invoice_status.status_name IN (''$status)");

?>

<div class="row">
    <div class="col-5 mb-2">
        <h4>Order List (<?php echo $category_result->num_rows  ?>)</h4>
    </div>
    <div class="col-7 d-flex mb-2">
        <span class="text-end w-100">Generated On: <b><?php echo $date->format("d M Y H:i:s") ?></b></span>
    </div>
    <div class="col-12">
        <table class="table table-bordered table-striped h-auto">
            <thead>
                <tr>
                    <th>Invoice ID</th>
                    <th>Date</th>
                    <th class="text-center">User Email</th>                    
                    <th class="text-center">Status</th>     
                </tr>
            </thead>
            <tbody>
                <?php              
                while ($category_data = $category_result->fetch_assoc()) {                  
                    ?>
                    <tr>
                        <td><?php echo $category_data["invoice_id"] ?></td>
                        <td><?php echo $category_data["date"] ?></td>                        
                        <td class="text-center"> <?php echo $category_data["user_email"]  ?></td>
                        <td class="text-center"> <?php echo $category_data["status_name"]  ?></td>  
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