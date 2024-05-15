<!DOCTYPE html>
<html>

<body>
    <div class="row mb-3">
        <h1>Manage Categories</h1>
    </div>
    <div class="row m-0">
        <div class="col-6">
            <?php
            $category_result = Database::execute("SELECT * FROM `category`");
            ?>
            <h5 class="text-secondary">
                <?php echo $category_result->num_rows ?> Categories Found
            </h5>
        </div>
        <div class="col-6 d-flex justify-content-end align-items-center">
            <button onclick="openAddNewCategory();" class="ui button teal">Add New</button>
        </div>
        <div class="col-12 my-3">
            <div class="row gap-3 justify-content-center">
                <?php
                while ($category_data = $category_result->fetch_assoc()) {
                    $products = Database::execute("SELECT COUNT(*) AS `count` FROM `product` WHERE `category_category_id` = '" . $category_data["category_id"] . "'");
                    $products_data = $products->fetch_assoc();

                    $image_result = Database::execute("SELECT * FROM `category_image` WHERE `category_category_id` = '" . $category_data["category_id"] . "' ");
                    $image_path = "resource/empty.jpg";
                    if ($image_result->num_rows == 1) {
                        $image_data = $image_result->fetch_assoc();
                        $image_path = $image_data["image_path"];
                    }

                    ?>
                    <div class="col-2 border shadow-sm rounded-4  bg-white" style="width:20rem">
                        <div class="row px-3 py-2 position-relative">

                            <i class="edit icon position-absolute end-0 me-3 curser-pointer header-link"
                                onclick="toggleCatModal( <?php echo $category_data['category_id'] ?>)"></i>


                            <img src="../<?php echo $image_path ?>" alt="" class="img-thumbnail p-1"
                                style="min-width:5rem;max-width:5rem;height: 5rem;object-fit: cover;">
                            <div class="col d-flex flex-column justify-content-center">
                                <h5 class="mb-2">
                                    <?php echo $category_data["category_name"] ?>
                                </h5>
                                <p class="mb-2">
                                    <?php if ($products_data["count"] == 0) { ?>No Products Available
                                    <?php } else
                                        if ($products_data["count"] == 1) {
                                            echo $products_data["count"] ?> Product Available
                                        <?php } else {
                                            echo $products_data["count"]; ?> Products Available
                                        <?php } ?>
                                </p>
                                <div class="form-check form-switch">
                                    <input class="form-check-input fs-6" type="checkbox" role="switch" 
                                    onchange="toggleCategoryStatus(<?php echo $category_data['category_id'] ?>);"
                                        id="flexSwitchCheckChecked<?php echo $category_data['category_id'] ?>" <?php echo $category_data["status_status_id"]==1?"checked":"" ?>>
                                        <label id="cat-label<?php echo $category_data['category_id'] ?>" class="form-check-label <?php echo $category_data["status_status_id"]==1?"text-success":"text-danger" ?>" 
                                        for="flexSwitchCheckChecked<?php echo $category_data['category_id'] ?>">
                                            <?php echo $category_data["status_status_id"]==1?"Active":"Deactivated" ?>
                                        </label>
                                        <span id="cat-status-spinner<?php echo $category_data['category_id'] ?>" class="spinner-border spinner-border-sm d-none" aria-hidden="true"></span>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- modal -->
                    <div class="ui modal h-auto position-relative w-auto"
                        id="cat-modal<?php echo $category_data["category_id"] ?>">
                        <i class="close icon"></i>
                        <div class="header">
                            Edit Category:
                            <span class="text-orange">
                                <?php echo $category_data["category_name"] ?>
                            </span>
                        </div>
                        <div class="image content">
                            <div class="image position-relative">
                                <?php
                                if ($image_result->num_rows == 1) {
                                    ?>
                                    <img src="../<?php echo $image_path ?>" class="img-thumbnail"
                                        id="cat-upload-image<?php echo $category_data['category_id'] ?>"
                                        style="width:10rem;height:10rem;object-fit:cover" alt="">

                                    <?php
                                } else {
                                    ?>
                                    <img src="../resource/product_image/emptyImage.jpg" class="img-thumbnail"
                                        id="cat-upload-image<?php echo $category_data['category_id'] ?>"
                                        style="width:10rem;height:10rem;object-fit:cover" alt="">

                                    <?php
                                }
                                ?>

                            </div>
                            <div class="description position-relative">
                                <div class="mb-3">
                                    <label for="cat-name" class="form-label">Category Name</label>
                                    <input type="text" class="form-control"
                                        id="cat-name<?php echo $category_data['category_id'] ?>"
                                        placeholder="Enter Category Name"
                                        value="<?php echo $category_data["category_name"] ?>">
                                </div>
                                <label for="cat-image-chooser<?php echo $category_data['category_id'] ?>"
                                    class="ui teal small button bottom-0 position-absolute">
                                    <i class="camera icon"></i> Upload Image
                                </label>
                                <input type="file" onchange="setCatImage(<?php echo $category_data['category_id'] ?>)"
                                    id="cat-image-chooser<?php echo $category_data['category_id'] ?>" class="d-none">
                            </div>
                        </div>
                        <div class="actions">
                            <div class="ui button" onclick="toggleCatModal(<?php echo $category_data['category_id'] ?>);">
                                Cancel</div>
                            <div class="ui button blue"
                                onclick="updateCategory(<?php echo $category_data['category_id'] ?>)">Save</div>
                        </div>
                    </div>
                    <!-- modal end -->
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js"
        integrity="sha512-L0Shl7nXXzIlBSUUPpxrokqq4ojqgZFQczTYlGjzONGTDAcLremjwaWv5A+EDLnxhQzY5xUZPWLOLqYRkY0Cbw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>