<?php 
include "../../connection.php";

$page_no = 1;
$logins_per_page = 10;

$product_id = 0;
if(isset($_GET["id"]) && !empty($_GET["id"])){
    $product_id = $_GET["id"];
}

$logins_count_result = Database::execute("SELECT * FROM `admin_login_history`");

$logins_count = $logins_count_result->num_rows;

$number_of_pages = ceil($logins_count / $logins_per_page);

if (isset($_GET['page']) && !empty($_GET['page'])) {
    if ($_GET['page'] > $number_of_pages) {
        $page_no = $number_of_pages;
    } else {
        $page_no = $_GET['page'];
    }

}


?>
<thead>
    <tr>
        <th class="text-center" scope="col">ID</th>
        <th class="text-center" scope="col">Date</th>
        <th class="text-center" scope="col">Time</th>
    </tr>
</thead>
<tbody>
    <?php 
    $history_result = Database::execute("SELECT * FROM `admin_login_history`  ORDER BY `login_datetime` DESC
    LIMIT $logins_per_page OFFSET ".(($page_no-1)*$logins_per_page)."");

    while($history_data = $history_result->fetch_assoc()){
        $date = new DateTime($history_data["login_datetime"]);
        
        ?>
        <tr>
            <th class="text-center" scope="row"><?php echo $history_data["login_id"]?></th>
            <td class="text-center"><?php echo $date->format("Y-m-d"); ?></td>
            <td class="text-center"><?php echo $date->format("h:i:s a"); ?></td>
        </tr>
        <?php 
    }
   
    if($logins_count == 0){
        ?>
         <tr>
        <td class="text-center" colspan="3">No Data available</td>
    </tr>
        <?php
    }
    ?>
   
</tbody>
<tfoot>
    <tr>
        <td class="text-center" colspan="3">
        <div class="col-12 d-flex pt-3 justify-content-center">
       
<nav aria-label="...">
                                        <ul class="pagination">
                                            <?php 
                                            if($page_no > 1){
                                                ?>
                                                <li class="page-item">
                                                <a onclick="loadAdminLoginHistory(<?php echo $page_no-1 ?>)" 
                                                class="page-link"><i class="angle double left icon"></i></a>
                                                </li>
                                                <?php
                                            }else{
                                                ?>
                                                 <li class="page-item disabled">
                                                <span class="page-link"><i class="angle double left icon"></i></span>
                                                </li>
                                                <?php
                                            }
                                           
                                                for($i = 1; $i <= $number_of_pages; $i++){
                                                    if($page_no == $i){
                                                        ?>
                                                        <li class="page-item active" aria-current="page">
                                                        <span class="page-link"><?php echo $i ?></span>
                                                        </li>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <li class="page-item"><a class="page-link" 
                                                        onclick="loadAdminLoginHistory(<?php echo $i ?>)"><?php echo $i ?></a></li>
                                                        <?php
                                                    }
                                                }
                                                if($page_no >= $number_of_pages){
                                                    ?>
                                                    <li class="page-item disabled">
                                                    <span class="page-link"><i class="angle double right icon"></i></span>
                                                    </li>
                                                    <?php
                                                }else{
                                                    ?>
                                                     <li class="page-item ">
                                                    <a  onclick="loadAdminLoginHistory(<?php echo $page_no+1 ?>)" 
                                                    class="page-link"><i class="angle double right icon"></i></a>
                                                    </li>
                                                    <?php
                                                }
                                            ?>                              
                                           
                                        </ul>
                                    </nav>
        </div>
                                    </td>
    </tr>
                                </tfoot>