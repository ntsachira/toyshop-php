<?php
session_start();
if (!isset($_SESSION['user']['email'])) {
    header('Location:index.php');
} else {
    include_once "connection.php";
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>
            My Reviews | ToyShop
        </title>
        <link rel="icon" type="image/png" href="resource/logo.png">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">

        <!-- jQuery CDN -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <!-- jQuery CDN -->

        <!-- Semantic UI CDN -->
        <script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.5.0/dist/semantic.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.5.0/dist/semantic.min.css">
        <!-- Semantic UI CDN -->
    </head>

    <body id="bd">
        <?php include 'header.php'; ?>

        <div class="container-lg">
            <div class="col-12 mb-3 border-bottom py-2">
                <div class="row d-flex align-items-center justify-content-center gap-2">                   

                    <div class="col d-flex flex-column flex-md-row gap-2">
                        <h2>⭐My Reviews</h2>
                    </div>

                </div>
            </div>
            <!-- bread crumb -->
            <div class="ui breadcrumb my-2">
                <a href="home.php" class="section text-decoration-none">ToyShop</a>
                <i class="right angle icon divider"></i>
                <a href="userProfile.php" class="section text-decoration-none">Profile</a>
                <i class="right angle icon divider"></i>
                <div class="active section mt-2">
                    Reviews
                </div>
            </div>
            <!-- bread crumb -->

            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-9 col-xl-8 my-4">
                <?php 
                    $page_no = 1;
                    $reviews_per_page = 5;                   

                    $reviews_count_result = Database::execute("SELECT * FROM `invoice` INNER JOIN `invoice_item` ON 
                    `invoice`.`invoice_id` = `invoice_item`.`invoice_invoice_id` WHERE 
                    `user_email`='" . $_SESSION['user']['email'] . "' AND `review_status_review_status_id`='2' AND `invoice_status_invoice_status_id` = 3");

                    $reviews_count = $reviews_count_result->num_rows;

                    $number_of_pages = ceil($reviews_count/$reviews_per_page);

                    if(isset($_GET['page']) && !empty($_GET['page'])){
                        if($_GET['page']>$number_of_pages){
                            $page_no = $number_of_pages;
                        }else{
                             $page_no = $_GET['page'];
                        }
                       
                    }
                    ?>
                    <!-- tab menu bar -->
                    <div class="ui pointing secondary  menu">
                        <a class="item active" data-tab="first">To Review &nbsp; <label class="px-2 py-1 rounded-5 bg-blue text-white"><?php echo $reviews_count ?></label></a>
                        <a onclick="loadReviewHistory(1,5)" class="item" data-tab="second">History</a>
                    </div>
                    <!-- tab menu bar -->
                   

                    <!-- to review tab content -->
                    <div class="ui tab segment border-0 shadow-none active" data-tab="first">
                        <?php
                        $invoice_item_result = Database::execute("SELECT * FROM `invoice` INNER JOIN `invoice_item` ON 
                        `invoice`.`invoice_id` = `invoice_item`.`invoice_invoice_id` INNER JOIN `product` ON `invoice_item`.`product_product_id` = `product`.`product_id`                        
                         WHERE `user_email` = '" . $_SESSION['user']["email"] . "' AND `review_status_review_status_id`='2' AND `invoice_status_invoice_status_id` = 3
                         LIMIT 5 OFFSET ".(($page_no-1)*$reviews_per_page)."");

                        if ($invoice_item_result->num_rows == 0) {
                            ?>
                            <!-- empty order  -->
                            <div class="col-12 mb-5 d-flex flex-column justify-content-center align-items-center">
                                <img src="resource/emptySearch.jpg" style="max-height:20rem" alt="">
                                <span class="fs-1 text-secondary mb-3">You have no items to Review</span>
                                <a href="home.php" class="ui button orange  huge">Start Shopping Now <i
                                        class="right arrow icon"></i></a>
                            </div>
                            <?php
                        } else {
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
                                    <div class="col-12 p-3 bg-white rounded">
                                        <div class="row">
                                            <div class="w-auto position-relative" style="width:5rem;">
                                                <img src="resource/product_image/<?php echo $image_data['image_path'] ?>" id="image<?php echo $invoice_item_data['product_id'] ?>"
                                                    style="width:5rem;height:5rem;object-fit: contain;" alt="">
                                            </div>
                                            <div class="col w-auto d-flex flex-column justify-content-center">
                                                <span class=" fw-bold">
                                                    <?php echo $invoice_item_data['title'] ?>
                                                </span>
                                                <p class="text-secondary">Color: red</p>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex flex-row-reverse pe-0">
                                            <button onclick="openReviewModal('<?php echo $invoice_item_data['product_id'] ?>',
                                            '<?php echo $invoice_item_data['title'] ?>','<?php echo $invoice_item_data['invoice_item_id'] ?>')"
                                                class="ui button orange">Review</button>
                                        </div>
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
                                                <a href="myReviews.php?page=<?php echo $page_no-1 ?>" class="page-link"><i class="angle double left icon"></i></a>
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
                                                        <li class="page-item"><a class="page-link" href="myReviews.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
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
                                                    <a href="myReviews.php?page=<?php echo $page_no+1 ?>" class="page-link"><i class="angle double right icon"></i></a>
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

                        <!-- review modal -->
                        <div class="modal" id="review-modal" tabindex="-1"
                                    data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Add product Review</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body py-0">
                                                <div class="col-12">
                                                    <div class="row justify-content-center bg-light py-3">
                                                        <div class="col-12">
                                                            <div class="row gap-3">
                                                                <div class="col-12">
                                                                   <div class="row me-0 pe-0">
                                                                   <h6 class="col" >
                                                                        Review &nbsp;<b id="modal-title">
                                                                           <!-- title -->
                                                                        </b>
                                                                    </h6>
                                                                    <img src="" id="modal-image" alt="" class="col-3 img-thumbnail" style="width:5rem;height:5rem;object-fit:contain;">
                                                                   </div>
                                                                </div>
                                                                <div class="col-12 mb-3">
                                                                    <span>Your Rate</span>
                                                                    <div class="ui huge star rating" data-max-rating="5"
                                                                        id="userRating"></div> 
                                                                        <!-- unique id ekk denna -->
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="row">                                                                      
                                                                     
                                                                        <div class="col-12 mb-3">
                                                                            <label for="exampleFormControlTextarea1"
                                                                                class="form-label">Your
                                                                                Review (<span
                                                                                    id="review-limit">0</span>/500)</label>
                                                                            <textarea class="form-control" id="review-text"
                                                                                placeholder="Enter your review here"
                                                                                rows="5"></textarea>
                                                                        </div>
                                                                       
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer gap-2">
                                                <button type="button" class="ui  button"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="button" onclick="loadAddReview();" class="ui secondary button">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- review modal end -->

                                 

                    </div>
                    <!-- to review Tab content -->

                    <!-- review history tab content -->
                    <div class="ui tab segment border-0 shadow-none" id="review-history-content" data-tab="second">
                    

                       
                    </div>
                    <!-- review history tab content -->

                </div>
            </div>
        </div>
        <?php include "footer.php" ?>
        <script src="script.js"></script>
    </body>

    </html>
    <?php
}

?>