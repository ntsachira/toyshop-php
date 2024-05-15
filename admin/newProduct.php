<?php

?>
<!DOCTYPE html>
<html>

<body id="bd">

    <div class="container-lg mb-5">

        <div class="row  p-3 g-3 border-top justify-content-center">
            <div class="col-12">
                <div class="d-flex justify-content-between">
                    <div>
                        <h2>Add Product</h2>
                        <span>Add your product for your customers</span>
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

                            <div class="input-group">
                                <select class="form-select" id="categorySelect"
                                    aria-label="Example select with button addon">
                                    <option value="">Choose category...</option>
                                   <?php 
                                   $category_result = Database::execute("SELECT * FROM `category`");
                                      while($category_data = $category_result->fetch_assoc()){
                                        ?>
                                        <option value="<?php echo $category_data['category_id'] ?>"><?php echo $category_data['category_name'] ?></option>
                                        <?php
                                      }
                                   ?>
                                </select>
                                <button class="btn btn-outline-secondary"  onclick="toggleModal('Category')" type="button">or Add New</button>
                            </div>
                        </div>
                        <!-- brand -->
                        <div class="mb-3">
                            <label for="" class="form-label">Brand</label>

                            <div class="input-group">
                                <select class="form-select" id="brandSelect"
                                    aria-label="Example select with button addon">
                                    <option value="">Choose brand...</option>
                                   <?php 
                                   $brand_result = Database::execute("SELECT * FROM `brand`");
                                   while($brand_data = $brand_result->fetch_assoc()){
                                       ?>
                                       <option value="<?php echo $brand_data['brand_id'] ?>"><?php echo $brand_data['brand_name'] ?></option>
                                       <?php
                                   }
                                   ?>
                                </select>
                                <button class="btn btn-outline-secondary"  onclick="toggleModal('Brand')" type="button">or Add New</button>
                            </div>
                        </div>
                        <!-- Model -->
                        <div class="mb-3">
                            <label for="" class="form-label">Model</label>
                            <div class="input-group">
                                <select class="form-select" id="modelSelect" aria-label="Example select with button addon">
                                    <option value="">Choose Model...</option>
                                    <?php 
                                    $model_result = Database::execute("SELECT * FROM `model`");
                                    while($model_data = $model_result->fetch_assoc()){
                                        ?>
                                        <option value="<?php echo $model_data['model_id'] ?>"><?php echo $model_data['model_name'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <button class="btn btn-outline-secondary"  onclick="toggleModal('Model')" type="button">or Add New</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        Basic Information
                    </div>
                    <div class="card-body">
                        <!-- category -->
                        <div class="mb-3">
                            <label for="" class="form-label">Enter Product Title (Max 100 characters)</label>
                            <textarea input type="text" class="form-control" rows="2" id="productTitle" placeholder="Product Title"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Select Product Condition</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" checked name="inlineRadioOptions"
                                        id="inlineRadio1" value="1">
                                    <label class="form-check-label" for="inlineRadio1">Brand New</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                        id="inlineRadio2" value="2">
                                    <label class="form-check-label" for="inlineRadio2">Used</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                        id="inlineRadio3" value="3">
                                    <label class="form-check-label" for="inlineRadio3">Not Specified</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Product Description</label>
                            <textarea class="form-control" id="description" rows="6"></textarea>
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
                                <input type="number" class="form-control" id="deliveryWithin">
                                <span class="input-group-text">.00</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Delevery Cost Out of Matara</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">Rs</span>
                                <input type="number" class="form-control" id="deliveryOut">
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
                            <div class="col-4">
                                <img src="../resource/product_image/emptyImage.jpg" class="img-thumbnail" id="imagePreview0" alt="...">
                            </div>
                            <div class="col-4">
                                <img src="../resource/product_image/emptyImage.jpg" class="img-thumbnail" id="imagePreview1" alt="...">
                            </div>
                            <div class="col-4">
                                <img src="../resource/product_image/emptyImage.jpg" class="img-thumbnail" id="imagePreview2" alt="...">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end">
                                <label for="addProductImage" class="ui button teal">Upload Product Images</label>
                                <input class="d-none" type="file" id="addProductImage" multiple>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        Product Color
                    </div>
                    <div class="card-body">
                        <!-- category -->
                        <div class="mb-3">
                            <label for="" class="form-label">Select Product Color</label>
                            <div class="input-group">
                                <select class="form-select" id="colorSelect"
                                    aria-label="Example select with button addon">
                                    <option value="">Choose color</option>
                                    <?php 
                                    $color_result = Database::execute("SELECT * FROM `color`");
                                    while($color_data = $color_result->fetch_assoc()){
                                        ?>
                                        <option value="<?php echo $color_data['color_id'] ?>"><?php echo $color_data['color_name'] ?></option>
                                        <?php
                                    }
                                    ?>                                  
                                </select>
                                <!-- Button trigger modal -->
                                <button class="btn btn-outline-secondary" type="button" id="newColor"
                                    onclick="toggleModal('Color')">or Add
                                    New</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        Quantity & Prices
                    </div>
                    <div class="card-body">
                        <!-- category -->
                        <div class="mb-3">
                            <label for="" class="form-label">Enter Product Quantity</label>
                            <input type="number" min="0" class="form-control" id="productQuantity">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Enter Unit Price</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">Rs</span>
                                <input type="number" class="form-control" id="productPrice">
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
                    <button class="ui button orange w-100" id="saveProductBtn">Save Product</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div class="ui mini modal position-relative h-auto" id="addNewModal">
        <i class="close icon"></i>
        <div class="header">
            Add New <span id="modalTitle"></span>
        </div>
        <div class="image content">
            <div class="ui input w-100">
                <input type="text" placeholder="Enter New value..." id="newValueInput" value="">
            </div>

        </div>
        <div class="actions">
            <div class="ui button" onclick="toggleModal('')">Cancel</div>
            <div class="ui button primary" id="addNewBtn">Add</div>
        </div>
    </div>

</body>

</html>