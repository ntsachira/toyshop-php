<?php 
include "../../connection.php";

$page_no = 1;
$reviews_per_page = 5;

$product_id = 0;
if(isset($_GET["id"]) && !empty($_GET["id"])){
    $product_id = $_GET["id"];
}

$reviews_count_result = Database::execute("SELECT * FROM `reviews` WHERE `product_product_id` = '" . $product_id . "'");

$reviews_count = $reviews_count_result->num_rows;

$number_of_pages = ceil($reviews_count / $reviews_per_page);

if (isset($_GET['page']) && !empty($_GET['page'])) {
    if ($_GET['page'] > $number_of_pages) {
        $page_no = $number_of_pages;
    } else {
        $page_no = $_GET['page'];
    }

}


?>
<div class="col-12">
    <div class="row">
        <?php
      

                                     if($reviews_count == 0){
                                        ?>
                                        <div class="col-12 bg-light p-3 mb-1">
                                            No reviews yet
                                        </div>
                                        <?php
                                     }else{
                                        $review_result2 = Database::execute("SELECT * FROM `reviews` WHERE `product_product_id` = '" . $product_id . "' 
                                        ORDER BY `review_date` DESC
                                        LIMIT $reviews_per_page OFFSET ".(($page_no-1)*$reviews_per_page)."");

                                        while ($review_data2 = $review_result2->fetch_assoc()) {
                                            ?>
                                            <div class="col-12 bg-light p-3 mb-1">
                                                <div class="row gap-3">
                                                    <div class="col-12 d-flex justify-content-between">
                                                        <div class="d-flex gap-3 flex-column flex-sm-row">
                                                            <div class="ui huge star rating" data-max-rating="5"
                                                                id="user-rating<?php echo $review_data2["review_id"] ?>"></div>
                                                            <?php
                                                            $user_result = Database::execute("SELECT * FROM `user` WHERE `email` = '" . $review_data2['user_email'] . "'");
                                                            $user_data = $user_result->fetch_assoc();
                                                            ?>
                                                            <span class="text-secondary">
                                                                <?php echo $user_data["first_name"] . " " . $user_data["last_name"] ?>
                                                            </span>
                                                        </div>
                                
                                                        <span class="text-secondary">
                                                            <?php
                                                            $today = new DateTime();
                                                            $timeZone = new DateTimeZone("Asia/Colombo");
                                                            $today->setTimezone($timeZone);
                                                            $today = new DateTime(date_format($today, "Y-m-d H:i:s"));
                                                            $reviewDate = new DateTime($review_data2['review_date']);
                                
                                
                                
                                                            $interval = $today->diff($reviewDate);
                                                            // Format the difference into a human-readable format
                                                            if ($interval->y > 0) {
                                                                $difference = $interval->y . " year(s) ";
                                                            } elseif ($interval->m > 0) {
                                                                $difference = $interval->m . " month(s) ";
                                                            } elseif ($interval->d > 0) {
                                                                $difference = $interval->d . " day(s) ";
                                                            } elseif ($interval->h > 0) {
                                                                $difference = $interval->h . " hour(s) ";
                                                            } elseif ($interval->i > 0) {
                                                                $difference = $interval->i . " minute(s) ";
                                                            } else {
                                                                $difference = $interval->s . " second(s) ";
                                                            }
                                
                                                            // Output the difference
                                                            echo $difference;
                                
                                
                                
                                
                                                            ?> Ago
                                                        </span>
                                
                                                    </div>
                                                    <div class="col-12">
                                                        <p><b>
                                                                <?php echo $review_data2["user_review"] ?>
                                                            </b></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <script>
                                                $("#user-rating<?php echo $review_data2["review_id"] ?>")
                                                    .rating('set rating', <?php echo $review_data2["rate"] ?>)
                                                    .rating("disable");
                                            </script>
                                            <?php
                                        }
                                        ?>
                                        <div class="col-12 mt-3">
                                <!-- to review pagination -->
                                <div class="col-12 d-flex justify-content-center">
                                    <nav aria-label="...">
                                        <ul class="pagination">
                                            <?php 
                                            if($page_no > 1){
                                                ?>
                                                <li class="page-item">
                                                <a onclick="loadCheckReviewModal(<?php echo $product_id ?>,<?php echo $page_no-1 ?>)" 
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
                                                        onclick="loadCheckReviewModal(<?php echo $product_id ?>,<?php echo $i ?>)"><?php echo $i ?></a></li>
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
                                                    <a  onclick="loadCheckReviewModal(<?php echo $product_id ?>,<?php echo $page_no+1 ?>)" 
                                                    class="page-link"><i class="angle double right icon"></i></a>
                                                    </li>
                                                    <?php
                                                }
                                            ?>                              
                                           
                                        </ul>
                                    </nav>
                                </div>
        </div>
                                        <?php
                                     }

       
        ?>

        
    </div>

</div>