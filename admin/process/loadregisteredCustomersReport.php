<?php
include '../../connection.php';

$date = new DateTimeImmutable("now", new DateTimeZone("Asia/Colombo"));

$start_date = $date->modify("1 month ago");
$range = "";
$duration = "";
if (isset($_GET["range"]) && !empty($_GET["range"])) {
    if ($_GET["range"] == "month") {
        $start_date = $date->modify("1 month ago");
        $duration = "Last 30 Days";
    } else if ($_GET["range"] == "six_months") {
        $start_date = $date->modify("6 months ago");
        $duration = "Last 6 Months";
    }else if ($_GET["range"] == "last_year") {
        $start_date = $date->modify("12 months ago");
        $duration="Last 12 Months";
    }else if ($_GET["range"] == "two_years") {
        $start_date = $date->modify("2 years ago");
        $duration = "Last 2 Years";
    }
}

$range = " WHERE joined_date > '".$start_date->format("Y-m-d H:i:s")."' ";

$category_result = Database::execute("SELECT email,CONCAT(first_name,' ',last_name) AS `name`,mobile,joined_date 
FROM user $range AND email != 'admin@gmail.com'");


?>

<div class="row">
    <div class="col-5 mb-2">
        <h4>Customer List (<?php echo $category_result->num_rows  ?>) - <?php echo $duration ?></h4>
    </div>
    <div class="col-7 d-flex mb-2">
        <span class="text-end w-100">Generated On: <b><?php echo $date->format("d M Y H:i:s") ?></b></span>
    </div>
    <div class="col-12">
        <table class="table table-bordered table-striped h-auto">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Name</th>
                    <th class="text-center">Mobile</th>                    
                    <th class="text-center">Joined Date</th>     
                </tr>
            </thead>
            <tbody>
                <?php              
                while ($category_data = $category_result->fetch_assoc()) {                  
                    ?>
                    <tr>
                        <td><?php echo $category_data["email"] ?></td>
                        <td><?php echo $category_data["name"] ?></td>                        
                        <td class="text-center"> <?php echo $category_data["mobile"]  ?></td>
                        <td class="text-center"> <?php echo $category_data["joined_date"]  ?></td>  
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