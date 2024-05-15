<?php 
include "../../connection.php";

$page_no = 1;
$product_per_page = 4;

$product_count_result = Database::execute("SELECT * FROM `product` WHERE `quantity` = 0 ");

$product_count = $product_count_result->num_rows;

$number_of_pages = ceil($product_count / $product_per_page);

if (isset($_GET['page']) && !empty($_GET['page'])) {
    if ($_GET['page'] > $number_of_pages) {
        $page_no = $number_of_pages;
    } else {
        $page_no = $_GET['page'];
    }

}
?>
<div class="fs-6 fw-semibold text-danger mb-2">SOLD OUT PRODUCTS (<?php echo $product_count ?>)</div>
                    <div class="row " >
                        <!-- limites stock content -->

                    
<div class="ui items" style="margin-top:-1rem">
    <?php
    $invoice_result = Database::execute("SELECT * FROM `invoice`");
    if ($invoice_result->num_rows != 0) { //* checking if invoices are available                           
    
        $product_result = Database::execute("SELECT * FROM `product` WHERE `quantity` = 0 LIMIT $product_per_page 
        OFFSET ".(($page_no-1)*$product_per_page)."");

        if ($product_result->num_rows != 0) { //* checking if invoices are available for current year
    
            while ($product_data = $product_result->fetch_assoc()) {               

                $image_result = Database::execute("SELECT * FROM `product_image` WHERE `product_product_id` = '" . $product_data['product_id'] . "'");
                $image_path = "resource/product_image/emptyImage.jpg";
                if ($image_result->num_rows != 0) {
                    $image_data = $image_result->fetch_assoc();
                    $image_path = $image_data['image_path'];
                }
                ?>
                <div class="item border-top pt-3">
                    <div class="image img-thumbnail overflow-hidden" style="width:5rem;height:5rem;">
                        <img src="../resource/product_image/<?php echo $image_path ?>"
                            style="width:5rem;height:5rem;object-fit: contain;">
                    </div>
                    <div class="content">
                        <a class="fw-bold fs-6 card-title">
                            <?php echo $product_data["title"] ?>
                        </a>
                        <?php
                        $product_qty_result = Database::execute("SELECT * FROM `product` WHERE `product_id` = '" . $product_data['product_id'] . "'");
                        $product_qty_data = $product_qty_result->fetch_assoc();
                        ?>
                        <div class="meta">
                            <span class="fs-5 text-danger"> Remaining quantity: <b>
                                <?php echo $product_qty_data["quantity"] ?>
                            </b></span>
                        </div>

                    </div>
                </div>
                <?php
            }

        } else {
            ?>
            <p>No data Available</p>
            <?php
        }
    } else {
        ?>
        <p>No data Available</p>
        <?php
    }
    ?>

</div>

  <!-- to review pagination -->
  <div class="col-12 d-flex justify-content-center">
                                    <nav aria-label="...">
                                        <ul class="pagination">
                                            <?php 
                                            if($page_no > 1){
                                                ?>
                                                <li class="page-item curser-pointer">
                                                <a onclick="loadSoldOut(<?php echo $page_no-1 ?>)" 
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
                                                        <li class="page-item active " aria-current="page">
                                                        <span class="page-link"><?php echo $i ?></span>
                                                        </li>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <li class="page-item curser-pointer"><a class="page-link" 
                                                        onclick="loadSoldOut(<?php echo $i ?>)"><?php echo $i ?></a></li>
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
                                                     <li class="page-item curser-pointer">
                                                    <a  onclick="loadSoldOut(<?php echo $page_no+1 ?>)" 
                                                    class="page-link"><i class="angle double right icon"></i></a>
                                                    </li>
                                                    <?php
                                                }
                                            ?>                              
                                           
                                        </ul>
                                    </nav>
                                </div>   
                                </div>                           