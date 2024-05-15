<?php


if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
}

$category = "";
$brand = "";
$model = "";
$condition = "";
$search_key = "";
$sort_option = "`datetime_added` DESC";
$sort_id = "";

// check and get search parameters from url
if (isset($_GET['category']) && $_GET['category'] != "0") {
    $category = $_GET['category'];
}
if (isset($_GET['brand']) && $_GET['brand'] != "0") {
    $brand = $_GET['brand'];
}
if (isset($_GET['model']) && $_GET['model'] != "0") {
    $model = $_GET['model'];
}
if (isset($_GET['condition']) && $_GET['condition'] != "0") {
    $condition = $_GET['condition'];
}
if (isset($_GET['searchKey'])) {
    $search_key = $_GET['searchKey'];
}
if (isset($_GET['sort']) && $_GET['sort'] != "0") {
    if ($_GET['sort'] == "1") {
        $sort_option = "`price` ASC";
        $sort_id = "1";
    } else if ($_GET['sort'] == "2") {
        $sort_option = "`price` DESC";
        $sort_id = "2";
    } else if ($_GET['sort'] == "3") {
        $sort_option = "`quantity` ASC";
        $sort_id = "3";
    } else if ($_GET['sort'] == "4") {
        $sort_option = "`datetime_added` ASC";
        $sort_id = "4";
    }

}
// check and get search parameters from url
?>
<!DOCTYPE html>
<html>

<body>
    <div class="col-12 d-flex  justify-content-between align-items-center">
        <h1>My Products</h1>
        <a href="?tab=newproduct" class="ui button teal" id="addProduct-btn">Add New Product</a>
    </div>
    <!-- search -->
    <div class="col-12 mb-3 bg-white  p-3  border  rounded">
        <div class="row mb-2">
            <div clas="col-12">
                <b>Search products</b>
            </div>
        </div>
        <div class="row m-0 ">
            <div class="col-12 d-flex gap-2 ">
                <div class="row gap-3  m-0 w-100">
                    <select class="col ui dropdown" id="categorySelect">
                        <option value="0">Select Category</option>
                        <?php
                        $category_result = Database::execute("SELECT * FROM `category`");
                        while ($category_data = $category_result->fetch_assoc()) {
                            ?>
                            <option <?php echo ($category == $category_data['category_name'] ? "selected" : "") ?>
                                value="<?php echo $category_data['category_name'] ?>">
                                <?php echo $category_data['category_name'] ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                    <select class="col ui dropdown" id="brandSelect">
                        <option value="0">Select Brand</option>
                        <?php
                        $brand_result = Database::execute("SELECT * FROM `brand`");
                        while ($brand_data = $brand_result->fetch_assoc()) {
                            ?>
                            <option <?php echo ($brand == $brand_data['brand_name'] ? "selected" : "") ?>
                                value="<?php echo $brand_data['brand_name'] ?>">
                                <?php echo $brand_data['brand_name'] ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                    <select class="col ui dropdown" id="modelSelect">
                        <option value="0">Select Model</option>
                        <?php
                        $model_result = Database::execute("SELECT * FROM `model`");
                        while ($model_data = $model_result->fetch_assoc()) {
                            ?>
                            <option <?php echo ($model == $model_data['model_name'] ? "selected" : "") ?>
                                value="<?php echo $model_data['model_name'] ?>">
                                <?php echo $model_data['model_name'] ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                    <select class="col ui dropdown" id="conditionSelect">
                        <option value="0">Select Condition</option>
                        <?php
                        $condition_result = Database::execute("SELECT * FROM `condition`");
                        while ($condition_data = $condition_result->fetch_assoc()) {
                            ?>
                            <option <?php echo ($condition == $condition_data['condition_name'] ? "selected" : "") ?>
                                value="<?php echo $condition_data['condition_name'] ?>">
                                <?php echo $condition_data['condition_name'] ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                    <div class="col-12 ">
                        <div class="row gap-3 justify-content-end">
                            <select class="col-md-3 ui dropdown" id="sortOption">
                                <option value="0">Newest First</option>
                                <option <?php echo ($sort_id == "1" ? "selected" : "") ?> value="1">Price Low to High
                                </option>
                                <option <?php echo ($sort_id == "2" ? "selected" : "") ?> value="2">Price High to Low
                                </option>
                                <option <?php echo ($sort_id == "3" ? "selected" : "") ?> value="3">Low quantity first
                                </option>
                                <option <?php echo ($sort_id == "4" ? "selected" : "") ?> value="4">Oldest First</option>
                            </select>
                            <div class="col ui icon input p-0 w-100">
                                <input type="text" placeholder="Search by keyword..." id="searchKeyInput"
                                    value="<?php echo $search_key ?>">
                                <i class="search icon"></i>
                            </div>
                            <button class=" ui button secondary" style="width:auto"
                                id="productSearchBtn">Search</button>
                            <a href="home.php?tab=myProducts" class="ui button default" style="width:auto">Reset</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- search -->
    <?php
    $all_product_result = Database::execute("SELECT * FROM `full_product` WHERE `title` LIKE '%" . $search_key . "%' AND `category_name` LIKE '%" . $category . "%' AND 
    `brand_name` LIKE '%" . $brand . "%' AND `model_name` LIKE '%" . $model . "%' AND `condition_name` LIKE '%" . $condition . "%' ");
    $product_count = $all_product_result->num_rows;

    $product_per_page = 9;

    if (isset($_GET['product_per_page'])) {
        $product_per_page = $_GET['product_per_page'];
    }

    $number_of_pages = ceil($product_count / $product_per_page);

    $page = 1;
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    }
    ?>
    <div class="col-12 border rounded bg-white align-items-center d-flex justify-content-between  p-3  mb-3">
        <span><b>
                <?php echo $product_count ?> Product results
            </b> ( Showing page
            <?php echo $page ?> of
            <?php echo $number_of_pages ?> )
        </span>


        <!-- pagination top -->
        <div class="ui  pagination menu">
            <?php

            if ($page > 1) {
                ?>
                <a href="?tab=myProducts&page=<?php echo $page - 1 ?>&product_per_page=<?php echo $product_per_page ?>" class="icon item">
                    <i class="left chevron icon"></i>
                </a>
                <?php
            } else {
                ?>
                <a class="icon item">
                    <i class="left chevron icon"></i>
                </a>
                <?php
            }
            ?>

            <?php
            for ($i = 1; $i <= $number_of_pages; $i++) {
                ?>
                <a href="?tab=myProducts&page=<?php echo $i ?>&product_per_page=<?php echo $product_per_page ?>" class="item <?php echo $page == $i ? "active" : "" ?>">
                    <?php echo $i ?>
                </a>
                <?php
            }

            if ($page < $number_of_pages) {
                ?>
                <a href="?tab=myProducts&page=<?php echo $page + 1 ?>&product_per_page=<?php echo $product_per_page ?>" class="icon item">
                    <i class="right chevron icon"></i>
                </a>
                <?php
            } else {
                ?>
                <a class="icon item">
                    <i class="right chevron icon"></i>
                </a>
                <?php
            }

            ?>

        </div>
        <!-- pagination top -->
    </div>
    <!-- table -->
    <div class="col-12 p-3 mb-3 bg-white border rounded table-responsive ">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th scope="col" class="text-center">Id</th>
                    <th scope="col" class="text-center">Product</th>
                    <th scope="col" class="text-center">Description</th>
                    <th scope="col" class="text-center">Delivery_Fees</th>
                    <th scope="col" class="text-center">Registered_Date</th>
                    <th scope="col" class="text-center">Status</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php


                $product_result = Database::execute("SELECT * FROM `full_product` WHERE `title` LIKE '%" . $search_key . "%' AND `category_name` LIKE '%" . $category . "%' AND 
                `brand_name` LIKE '%" . $brand . "%' AND `model_name` LIKE '%" . $model . "%' AND `condition_name` LIKE '%" . $condition . "%'  
                ORDER BY $sort_option LIMIT $product_per_page  OFFSET " . (($page - 1) * $product_per_page));
                $product_num = $product_result->num_rows;

                if ($product_num > 0) {
                    while ($product_data = $product_result->fetch_assoc()) {
                        ?>
                        <tr>
                            <th scope="row">
                                <?php echo $product_data["product_id"] ?>
                            </th>
                            <td style="min-width: 20rem;max-width: 20rem;">
                                <div class="row gap-2">
                                    <div class="col-12 d-flex gap-1">
                                        <?php
                                        $image_result = Database::execute("SELECT * FROM `product_image` WHERE `product_product_id` = '" . $product_data['product_id'] . "'");
                                        if ($image_result->num_rows > 0) {
                                            while ($image_data = $image_result->fetch_assoc()) {
                                                ?>
                                                <img src="../resource/product_image/<?php echo $image_data['image_path'] ?>"
                                                    class="img-thumbnail" style="height:6rem;width:6rem; object-fit: contain;">
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <img src="../resource/product_image/emptyImage.jpg" class="img-thumbnail"
                                                style="height:6rem; object-fit: cover;">
                                            <?php
                                        }
                                        ?>


                                    </div>
                                    <div class="col-12">
                                        <b>
                                            <?php echo $product_data["title"] ?>
                                        </b>
                                    </div>
                                    <div class="col-12 d-flex align-items-start justify-content-between">
                                        <div class="ui teal tag h-auto label fw-bold">Rs.
                                            <?php echo number_format($product_data["price"], 2) ?>
                                        </div>
                                        <div class="text-bg-light px-2 py-1 d-flex flex-column"><span>Condition :</span>
                                            <b>
                                                <?php echo $product_data["condition_name"] ?>
                                            </b>
                                        </div>
                                    </div>
                                    <div class="col-12 bg-warning d-flex justify-content-between">
                                        <div class="">
                                            <b>
                                                <?php echo $product_data["quantity"] ?>
                                            </b> items Remaining
                                        </div>
                                        <?php                                

                                    $invoice_item = Database::execute("SELECT `product_product_id`,SUM(invoice_item_quantity) AS `product_count` FROM `invoice` 
                                    INNER JOIN `invoice_item` ON `invoice`.`invoice_id`=`invoice_item`.`invoice_invoice_id` WHERE
                                     `product_product_id` = '" . $product_data['product_id'] . "'");

                                    $invoice_item_data = $invoice_item->fetch_assoc();

                                    
                                    ?>
                                        <div><?php echo $invoice_item_data["product_count"] == null ? "0":$invoice_item_data["product_count"] ?> Sold</div>
                                
                                    </div>

                                </div>

                            </td>
                            <td style="min-width: 15rem;max-width: 20rem;">
                                <?php echo $product_data["description"] ?>
                            </td>
                            <td style="max-width:8rem">
                                <div class="row gap-3">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-12">Within Matara</div>
                                            <div class="col-12 fw-semibold">Rs.
                                                <?php echo $product_data["delivery_fee_matara"] ?>.00
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-12">Out Of Matara</div>
                                            <div class="col-12 fw-semibold">Rs.
                                                <?php echo $product_data["delivery_fee_other"] ?>.00
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <?php echo date_format(new DateTime($product_data["datetime_added"]), 'M d, Y') ?>
                            </td>
                            <td>
                                <div class="d-flex flex-column gap-3">
                                    <span
                                        class="<?php echo ($product_data["status_name"] == 'Active' ? 'text-success fw-bold' : "text-secondary") ?>">
                                        <?php echo $product_data["status_name"] ?>
                                    </span>
                                    <div class="ui toggle checkbox d-flex flex-column">
                                        <input type="checkbox" name="public" <?php if ($product_data["status_name"] == "Active") { ?>checked <?php } ?>
                                            onchange="toggleProductStatus(<?php echo $product_data['product_id'] ?>);">
                                        <label></label>
                                    </div>
                                </div>

                            </td>
                            <td>
                                <div class="d-flex flex-column gap-2">
                                    <a href="?tab=updateproduct&id=<?php echo $product_data["product_id"] ?>"
                                        class="ui button primary">Update</a>
                                    <button type="button" class="ui button default w-auto"
                                        onclick="openCheckReviewModal('<?php echo $product_data['product_id'] ?>')">Check
                                        Reviews</button>
                                    <button onclick='gotoSingleProductView(<?php echo $product_data["product_id"] ?>,"admin")'
                                        class="ui button teal w-auto">Customer view</button>
                                </div>
                            </td>

                            <!-- check reviews modal -->
                            <div class="ui longer modal position-relative h-auto" id="check-review-modal<?php echo $product_data["product_id"] ?>">
                                <i class="close icon"></i>
                                <div class="header fs-5">
                                    <span class="fw-normal">Reviews for </span>
                                    <?php echo $product_data["title"] ?>
                                </div>
                                <div class="image content" id="product-reviews-container<?php echo $product_data["product_id"] ?>">                                   
                                    <!-- customer reviews -->
                           
                                    <!-- customer reviews -->
                                </div>                               
                            </div>
                            <!-- check reviews modal end -->

                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <th colspan="7">
                            <div class="row justify-content-center p-4 gap-3">
                                <div class="col-12 d-flex justify-content-center">No products Yet</div>
                                <div class="col-12 d-flex justify-content-center"><a href="?tab=newproduct"
                                        class="ui button teal" id="addProduct-btn">Add New Product</a></div>
                            </div>
                        </th>
                    </tr>
                    <?php
                }

                ?>

            </tbody>
        </table>

    </div>



    <div class="col-12 d-flex bg-white p-3 rounded border align-items-center justify-content-between mb-3">
        <!-- Number of products per page change option -->
        <div class="content">
            Showing
            <div class="ui inline dropdown"><i class="dropdown icon"></i>
                <div class="text">
                    <?php echo $product_per_page ?>
                </div>
                <div class="menu">
                    <a href="<?php echo $_SERVER['REQUEST_URI'] ?>&product_per_page=6" class="item" data-text="6">6</a>
                    <a href="<?php echo $_SERVER['REQUEST_URI'] ?>&product_per_page=10" class="item"
                        data-text="10">10</a>
                    <a href="<?php echo $_SERVER['REQUEST_URI'] ?>&product_per_page=15" class="item"
                        data-text="15">15</a>
                    <a href="<?php echo $_SERVER['REQUEST_URI'] ?>&product_per_page=21" class="item"
                        data-text="21">21</a>
                </div>
            </div>
            Products per page
        </div>
        <!-- Number of products per page change option -->

        <!-- pagination bottom -->
        <div class="ui right floated pagination menu">
            <?php
            if ($page > 1) {
                ?>
                <a href="?tab=myProducts&page=<?php echo $page - 1 ?>&product_per_page=<?php echo $product_per_page ?>" class="icon item">
                    <i class="left chevron icon"></i>
                </a>
                <?php
            } else {
                ?>
                <a class="icon item">
                    <i class="left chevron icon"></i>
                </a>
                <?php
            }
            ?>

            <?php
            for ($i = 1; $i <= $number_of_pages; $i++) {
                ?>
                <a href="?tab=myProducts&page=<?php echo $i ?>&product_per_page=<?php echo $product_per_page ?>" class="item <?php echo $page == $i ? "active" : "" ?>">
                    <?php echo $i ?>
                </a>
                <?php
            }

            if ($page < $number_of_pages) {
                ?>
                <a href="?tab=myProducts&page=<?php echo $page + 1 ?>&product_per_page=<?php echo $product_per_page ?>" class="icon item">
                    <i class="right chevron icon"></i>
                </a>
                <?php
            } else {
                ?>
                <a class="icon item">
                    <i class="right chevron icon"></i>
                </a>
                <?php
            }

            ?>

        </div>
        <!-- pagination bottom -->
    </div>
</body>

</html>