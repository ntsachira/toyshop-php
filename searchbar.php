<?php

include_once 'connection.php';

?>
<!DOCTYPE html>

<html>

<?php 
$cat_id=0;
$key="";

if(isset($_GET["key"])){
    $key = $_GET["key"];
}
if(isset($_GET["cat"])){
    $cat_id = $_GET["cat"];
}
?>

<body>
    <div class="container-lg  bg-dark bg-opacity-75  rounded-5 mb-1">
        <div class="row px-3 py-2">
            <div class="col-12">
                <div class="row d-flex align-items-center justify-content-center gap-2">                    
                    <div class="col d-flex flex-column flex-md-row gap-2">
                        <!-- searchbar -->
                        <div class="w-100 d-flex flex-row gap-2 justify-content-between">
                            <div class="d-flex justify-content-between align-items-center">

                                <!-- dropdown -->
                                <div class="dropdown d-md-none">
                                    <button class="btn btn-black text-white rounded-5 dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="th list icon "></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                    <?php
                                    $category_result = Database::execute("SELECT * FROM `active_category` ");
                                    while ($category = $category_result->fetch_assoc()) {
                                        ?>
                                        <li><a class="dropdown-item curser-pointer" onclick="loadProducts(<?php echo $category['category_id']; ?>);">
                                        <?php echo $category["category_name"]; ?></a>                                        
                                        <?php
                                    }
                                    ?>                                                       
                                    </ul>
                                </div>
                                <!-- dropdown -->

                               <div class="d-md-flex d-none justify-content-center gap-4 align-items-center">
                               <?php
                                    $more_products = array();

                                    $category_result = Database::execute("SELECT * FROM `active_category` ");
                                    if($category_result->num_rows >= 5){
                                        $product_count = 0;
                                        while($category = $category_result->fetch_assoc()){
                                            if($product_count < 5){
                                            ?>
                                            <a class="dropdown-item curser-pointer  hover-orange" onclick="loadProducts(<?php echo $category['category_id']; ?>);">
                                            <?php echo $category["category_name"]; ?></a>                                        
                                            <?php
                                            $product_count++;
                                            continue;
                                            }
                                            array_push($more_products,$category);
                                        }
                                        ?>
                                        <!-- dropdown -->
                                        <div class="dropdown">
                                            <button class="btn btn-dark rounded-5 dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                More
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                            <?php                                           
                                            for($i = 0; $i < sizeof($more_products);$i++) {
                                                $category = $more_products[$i];
                                                ?>
                                                <li><a class="dropdown-item curser-pointer" onclick="loadProducts(<?php echo $category['category_id']; ?>);">
                                                <?php echo $category["category_name"]; ?></a>                                        
                                                <?php
                                            }
                                            ?>                                                       
                                            </ul>
                                        </div>
                                        <!-- dropdown -->
                               </div>
                                        <?php
                                    }else{
                                           while ($category = $category_result->fetch_assoc()) {
                                        ?>
                                        <a class="dropdown-item curser-pointer text-white" onclick="loadProducts(<?php echo $category['category_id']; ?>);">
                                        <?php echo $category["category_name"]; ?></a>                                        
                                        <?php
                                    }
                                    }
                                 
                                    ?> 
                                
                            </div>
                            <!-- search modal toggle button -->
                            <button type="button" class="btn btn-light rounded-5" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="fa-solid fa-magnifying-glass "></i>
                            </button>
                            <!-- search modal toggle button end -->
                            
                        </div>
                        <!-- searchbar -->
                        
                    </div>

                    <!-- Search modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">What are you looking for?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="product-search-input"value="<?php echo $key ?>"
                                        placeholder="search toys..">
                                        <?php 
                                        $cat = 0;
                                        if(isset($_GET["cat"]) && $_GET["cat"] != 0){
                                            $cat = $_GET["cat"];
                                        }
                                        ?>
                                    <button class="btn btn-blue" onclick="loadProducts(<?php echo $cat ?>,true);"><span
                                            class="d-none d-md-block">Search</span><i
                                            class="fa-solid fa-magnifying-glass d-md-none"></i></button>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button class="d-flex gap-1 btn btn-orange" onclick="window.location = 'advancedSearch.php'">Search Advanced</button>
                            </div>
                            </div>
                        </div>
                    </div>
                    <!-- Search modal end-->

                </div>
            </div>
        </div>
    </div>





</body>

</html>