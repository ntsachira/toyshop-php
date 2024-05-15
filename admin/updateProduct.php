<?php


if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
} else {
    if (isset($_GET['id'])) {
        $product_result = Database::execute("SELECT * FROM `full_product` WHERE `product_id` = '" . $_GET['id'] . "'");
        if ($product_result->num_rows == 1) {
            $product_data = $product_result->fetch_assoc();

            ?>
            <!DOCTYPE html>
            <html>

            <body id="bd">

                <div class="container-lg mb-5">

                    <div class="row  p-3 g-3 border-top justify-content-center">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h2>Update Product</h2>
                                </div>
                                <div>
                                    <a href="?tab=myProducts" class="ui button primary">Back</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-9 col-md-6">
                            <div class="card mb-3">
                                <div class="card-header">
                                    Category Details
                                </div>
                                <div class="card-body">
                                    <!-- category -->
                                    <div class="mb-3">
                                        <label for="" class="form-label">Category</label>
                                        <input readonly type="text" class="form-control" id=""
                                            value="<?php echo $product_data["category_name"] ?>">
                                    </div>
                                    <!-- brand -->
                                    <div class="mb-3">
                                        <label for="" class="form-label">Brand</label>
                                        <input readonly type="text" class="form-control" id=""
                                            value="<?php echo $product_data["brand_name"] ?>">
                                    </div>
                                    <!-- Model -->
                                    <div class="mb-3">
                                        <label for="" class="form-label">Model</label>
                                        <input readonly type="text" class="form-control" id=""
                                            value="<?php echo $product_data["model_name"] ?>">
                                    </div>
                                </div>
                            </div>
                            <!-- Basic Information -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    Basic Information
                                </div>                                
                                <div class="card-body">                                    
                                    <div class="mb-3">
                                        <label for="productTitle" class="form-label">Product Title</label>
                                        <textarea class="form-control" id="productTitle"
                                            rows="2"><?php echo $product_data["title"] ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Product Condition</label>
                                        <div>
                                            <label class="form-check-label text-bg-light px-3 py-2" for="inlineRadio1">Brand
                                                New</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="productDescription" class="form-label">Product Description</label>
                                        <textarea class="form-control" id="productDescription"
                                            rows="6"><?php echo $product_data["description"] ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-header">
                                    Delevery Charges
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Delevery Cost Within Matara</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">Rs</span>
                                            <input type="number" class="form-control" id="deliveryWithin"
                                                value="<?php echo $product_data["delivery_fee_matara"] ?>">
                                            <span class="input-group-text">.00</span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Delevery Cost Out of Matara</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">Rs</span>
                                            <input type="number" class="form-control" id="deliveryOut"
                                                value="<?php echo $product_data["delivery_fee_other"] ?>">
                                            <span class="input-group-text">.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-9 col-md-6">
                            <div class="card mb-3">
                                <div class="card-header">
                                    Product Images
                                </div>
                                <div class="card-body">
                                    <!-- category -->
                                    <div class="row mb-3">
                                        <?php
                                        $image_result = Database::execute("SELECT * FROM `product_image` WHERE `product_product_id` = '" . $product_data['product_id'] . "'");

                                        for ($x = 0; $x < $image_result->num_rows; $x++) {
                                            $image_data = $image_result->fetch_assoc()
                                                ?>
                                            <div class="col-4">
                                                <img src="../resource/product_image/<?php echo $image_data['image_path'] ?>"
                                                    class="img-thumbnail h-100" style="max-height:10rem;width:12rem;object-fit:contain;" alt="..."
                                                    id="productImage<?php echo $x ?>">
                                            </div>
                                            <?php
                                        }
                                        for ($x = 2; $x >= $image_result->num_rows; $x--) {
                                            ?>
                                            <div class="col-4">
                                                <img src="../resource/product_image/emptyImage.jpg"
                                                    style="max-height:10rem;width:12rem;object-fit:contain;" class="img-thumbnail" alt="..."
                                                    id="productImage<?php echo $x ?>">
                                            </div>
                                            <?php
                                        }

                                        ?>

                                    </div>
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end">
                                            <label for="updateProductImage" class="ui button teal">Upload Product Images</label>
                                            <input class="d-none" type="file" id="updateProductImage" max="3" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-header">
                                    Product Color
                                </div>
                                <div class="card-body">

                                    <div class="mb-3">
                                        <label for="" class="form-label">Product Color</label>
                                        <input type="text" class="form-control" id="exampleFormControlInput1"
                                            value="<?php echo $product_data["color_name"] ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-header">
                                    Quantity & Prices
                                </div>
                                <div class="card-body">

                                    <div class="mb-3">
                                        <label for="productQuantity" class="form-label">Product Quantity</label>
                                        <input type="number" min="0" class="form-control" id="productQuantity" value="<?php echo $product_data["quantity"] ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Enter Unit Price</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control" value="<?php echo $product_data["price"] ?>" id="productPrice">
                                            <span class="input-group-text">.00</span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Prefered Payment Methods</label>
                                        <div class="d-flex justify-content-around">
                                            <div class=" ">
                                                <input class="btn-check " type="checkbox" name="ipaymentOptions" id="ipayment1"
                                                    value="option1">
                                                <label class="btn p-0" for="ipayment1">
                                                    <img src="../resource/product_image/payment_method/paypal.jpeg"
                                                        class="img-thumbnail" alt="..." style="height: 4rem;">
                                                </label>
                                            </div>
                                            <div class="">
                                                <input class="btn-check " type="checkbox" name="ipaymentOptions" id="ipayment2"
                                                    value="option2">
                                                <label class="btn p-0" for="ipayment2">
                                                    <img src="../resource/product_image/payment_method/visa.jpg"
                                                        class="img-thumbnail" alt="..." style="height: 4rem;">
                                                </label>
                                            </div>
                                            <div class="">
                                                <input class="btn-check" type="checkbox" name="ipaymentOptions" id="ipayment3"
                                                    value="option3">
                                                <label class="btn p-0" for="ipayment3">
                                                    <img src="../resource/product_image/payment_method/mastercard.jpg"
                                                        class="img-thumbnail" alt="..." style="height: 4rem;">
                                                </label>
                                            </div>
                                            <div class="">
                                                <input class="btn-check" type="checkbox" name="ipaymentOptions" id="ipayment4"
                                                    value="option3">
                                                <label class="btn p-0" for="ipayment4">
                                                    <img src="../resource/product_image/payment_method/amex.jpg"
                                                        class="img-thumbnail" alt="..." style="height: 4rem;">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="d-flex">
                                <button class="ui button orange w-100" id="saveProduct" onclick="updateProduct(<?php echo $product_data['product_id'] ?>)">Save Product</button>
                            </div>
                        </div>
                    </div>
                </div>

            </body>

            </html>
            <?php
        } else {
            header("Location: ?tab=myProducts&error=true");
        }
    } else {
        header("Location: ?tab=myProducts&error=true");

    }

}
?>