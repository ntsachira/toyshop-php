<?php
session_start();
include_once "../connection.php";

$page_no = 1;
$reviews_per_page = 5;

$reviews_count_result = Database::execute("SELECT * FROM `invoice` INNER JOIN `invoice_item` ON 
 `invoice`.`invoice_id` = `invoice_item`.`invoice_invoice_id` WHERE 
 `user_email`='" . $_SESSION['user']['email'] . "' AND `review_status_review_status_id`='1' ");

$reviews_count = $reviews_count_result->num_rows;

$number_of_pages = ceil($reviews_count / $reviews_per_page);

if (isset($_GET['page']) && !empty($_GET['page'])) {
    if ($_GET['page'] > $number_of_pages) {
        $page_no = $number_of_pages;
    } else {
        $page_no = $_GET['page'];
    }

}
$invoice_item_result = Database::execute("SELECT * FROM `invoice` INNER JOIN `invoice_item` ON 
`invoice`.`invoice_id` = `invoice_item`.`invoice_invoice_id` INNER JOIN `product` ON `invoice_item`.`product_product_id` = `product`.`product_id`
INNER JOIN `reviews` ON `invoice_item`.`invoice_item_id` = `reviews`.`invoice_item_invoice_item_id`
 WHERE `invoice`.`user_email` = '" . $_SESSION['user']["email"] . "' AND `review_status_review_status_id`='1'");



if ($invoice_item_result->num_rows == 0) {
    ?>
    <!-- empty order  -->
    <div class="col-12 mb-5 d-flex flex-column justify-content-center align-items-center">
        <img src="resource/emptySearch.jpg" style="max-height:20rem" alt="">
        <span class="fs-1 text-secondary mb-3">You have no items to Review</span>
        <a href="home.php" class="ui button orange  huge">Start Shopping Now <i class="right arrow icon"></i></a>
    </div>
    <?php
} else {
    $invoice_item_result = Database::execute("SELECT * FROM `invoice` INNER JOIN `invoice_item` ON 
`invoice`.`invoice_id` = `invoice_item`.`invoice_invoice_id` INNER JOIN `product` ON `invoice_item`.`product_product_id` = `product`.`product_id`
INNER JOIN `reviews` ON `invoice_item`.`invoice_item_id` = `reviews`.`invoice_item_invoice_item_id`
 WHERE `invoice`.`user_email` = '" . $_SESSION['user']["email"] . "' AND `review_status_review_status_id`='1' ORDER BY `review_date` DESC
 LIMIT $reviews_per_page OFFSET ".(($page_no-1)*$reviews_per_page)."");

    while ($invoice_item_data = $invoice_item_result->fetch_assoc()) {

        ?>
        <div class="row bg-light px-3 pb-3 mb-3 rounded">
            <div class="col-12 pt-2 px-1">
                <h6>Purchased on
                    <?php echo date_format(new DateTime($invoice_item_data['date']), "d M Y") ?>
                </h6>
            </div>
            <?php
            $image_result = Database::execute("SELECT * FROM `product_image` WHERE product_product_id = '" . $invoice_item_data['product_id'] . "' ");
            $image_data = $image_result->fetch_assoc();
            ?>
            <div class="col-12 p-3 mb-3 bg-white rounded-4">
                <div class="row">
                    <div class="w-auto position-relative" style="width:5rem;">
                        <img src="resource/product_image/<?php echo $image_data['image_path'] ?>"
                            id="image<?php echo $invoice_item_data['product_id'] ?>"
                            style="width:5rem;height:5rem;object-fit: contain;" alt="">
                    </div>
                    <div class="col w-auto d-flex flex-column justify-content-center">
                        <span class="">
                            <?php echo $invoice_item_data['title'] ?>
                        </span>
                        <p class="text-secondary">Color: red</p>
                    </div>
                </div>

            </div>
            <?php
            $review_result = Database::execute("SELECT * FROM `reviews` WHERE `invoice_item_invoice_item_id` = '" . $invoice_item_data['invoice_item_id'] . "'");
            $rate = 1;
            $review = "Content unavailable";
            if ($review_result->num_rows == 1) {
                $review_data = $review_result->fetch_assoc();
                $rate = $review_data["rate"];
                $review = $review_data["user_review"];
            }
            ?>
            <div class="col-12 d-flex border-top mb-2 pt-3 pe-0">
                Rating:&nbsp;
                <div class="ui huge star rating" data-max-rating="5"
                    id="review-history-rating<?php echo $invoice_item_data['invoice_item_id'] ?>"></div>
                <script>
                    $("#review-history-rating<?php echo $invoice_item_data['invoice_item_id'] ?>").rating(
                        {
                            initialRating: <?php echo $rate ?>,
                            maxRating: 5,
                        }
                    ).rating("disable");;
                </script>
            </div>
            <div class="col-12">Review:&nbsp;
                <b>
                    <?php echo $review ?>
                </b>
            </div>
        </div>


        <?php
    }
    ?>
      <!-- to review pagination -->
      <div class="col-12 d-flex justify-content-center">
                                    <nav aria-label="...">
                                        <ul class="pagination">
                                            <?php 
                                            if($page_no > 1){
                                                ?>
                                                <li class="page-item">
                                                <a onclick="loadReviewHistory(<?php echo $page_no-1 ?>,<?php echo $reviews_per_page ?>)" 
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
                                                        onclick="loadReviewHistory(<?php echo $i ?>,<?php echo $reviews_per_page ?>)"><?php echo $i ?></a></li>
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
                                                    <a  onclick="loadReviewHistory(<?php echo $page_no+1 ?>,<?php echo $reviews_per_page ?>)" 
                                                    class="page-link"><i class="angle double right icon"></i></a>
                                                    </li>
                                                    <?php
                                                }
                                            ?>                              
                                           
                                        </ul>
                                    </nav>
                                </div>
    <?php
}
?>
                              