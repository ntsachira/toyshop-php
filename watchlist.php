<?php
session_start();
if (!isset($_SESSION['user']['email'])) {
    header('Location:index.php');
}
include_once "connection.php";
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        My Watchlist | ToyShop
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

<body>
    <?php
    include 'header.php';

    ?>
    <div class="container-lg">
        <div class="col-12 mb-3 border-bottom py-2">
            <div class="row d-flex align-items-center justify-content-center gap-2">

                <div class="col d-flex flex-column flex-md-row gap-2">
                    <h2><i class="heart icon fs-4 text-danger"> </i>Watchlist</h2>
                </div>
                <div class="col d-flex justify-content-end">
                    <!-- search -->
                    <div class="ui search">
                        <div class="ui icon input d-flex gap-2">
                            <input class="prompt" type="text" placeholder="Search Watchlist..." id="watchlist-search">
                            <i class="search icon"></i>
                        </div>
                        <div class="results"></div>
                    </div>
                    <!-- search -->
                </div>
            </div>
        </div>
        <!-- bread crumb -->
        <div class="ui breadcrumb my-2">
            <a href="home.php" class="section">ToyShop</a>
            <i class="right angle icon divider"></i>
            <a href="userProfile.php" class="section">Profile</a>
            <i class="right angle icon divider"></i>
            <div class="active section mt-2">
                Watchlist
            </div>
        </div>
        <!-- bread crumb -->
        <div class="row">
            <div class="col-12 mb-3">
                <?php
                $watchlist_result = Database::execute("SELECT * FROM `watchlist` INNER JOIN `full_product` ON `watchlist`.`product_product_id`=`full_product`.`product_id` 
                 WHERE `user_email`='" . $_SESSION['user']['email'] . "'");
                $watchlist_num = $watchlist_result->num_rows;
                ?>
                <h1 class="text-center">My Watchlist (
                    <?php echo $watchlist_num ?>)
                </h1>
            </div>
            <div class="col-12 mb-3 ">
                <div class="row justify-content-center p-2">
                    <div class="col-12 col-md-11 col-lg-10  ">
                        <table class="ui single line table" id="watchlistTable">

                            <tbody>
                                <?php
                                $watchlist = array();
                                if ($watchlist_num == 0) {
                                    ?>
                                    <tr>
                                        <td colspan="5" class="text-center fs-3">
                                            <img src="resource/no-wish-list.png"
                                                style="height:15rem;width:15rem;object-fit:cover" alt="">
                                            <h1 class="text-secondary">No Items in Watchlist</h1>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-center ">
                                            <button onclick="window.location='home.php';"
                                                class=" ui icon button w-100 teal huge">Start Shopping <i
                                                    class="arrow right icon"></i></button>
                                        </td>
                                    </tr>
                                    <?php
                                } else {
                                    for ($i = 0; $i < $watchlist_num; $i++) {
                                        $watchlist_data = $watchlist_result->fetch_assoc();
                                        // to get the title list to load the search
                                        $data = new stdClass();
                                        $data->id = $watchlist_data['product_id'];
                                        $data->title = $watchlist_data['title'];
                                        array_push($watchlist, $data);
                                        ?>
                                        <tr>
                                            <td class="text-bg-light">
                                                <?php echo $i + 1 ?>
                                            </td>
                                            <td class="curser-pointer"
                                                onclick="viewProduct(<?php echo $watchlist_data['product_id'] ?>,'user')">
                                                <h4 class="d-flex gap-3">
                                                    <?php
                                                    $image_result = Database::execute("SELECT * FROM `product_image` WHERE
                                                    `product_product_id` = '" . $watchlist_data["product_id"] . "' LIMIT 1 ");
                                                    $image_data = $image_result->fetch_assoc();
                                                    ?>
                                                    <img src="resource/product_image/<?php echo $image_data["image_path"] ?>"
                                                        class="img-thumbnail image"
                                                        style="height:10rem;width:10rem;object-fit:contain">
                                                    <div class=" py-2 text-wrap position-relative w-100">
                                                        <span class="fs-6 card-title">
                                                            <?php echo $watchlist_data['title'] ?>
                                                        </span>
                                                        <div class="mt-2 py-2 px-3 fs-6">
                                                            <span class="text-secondary "> Color :</span>
                                                            <?php echo $watchlist_data['color_name'] == "" ? "Not specified" : $watchlist_data['color_name'] ?>
                                                        </div>
                                                        <div class="mt-2 py-2 px-3">
                                                            <span class=" text-orange fs-4 fw-bold">Rs.
                                                                <?php echo number_format($watchlist_data['price'], 2); ?>
                                                            </span>
                                                        </div>
                                                        <div class="mt-2 py-2 px-3">
                                                            <span class="border rounded-5 border-info px-2 py-1 fs-6">
                                                                <?php echo $watchlist_data['condition_name'] ?>
                                                            </span>
                                                        </div>
                                                        <div class="mt-2  py-2 px-3 text-bg-light">
                                                            <?php
                                                            if ($watchlist_data["quantity"] == 0) {
                                                                ?>
                                                                <span class=" text-danger fw-bold fs-6">Out of Stock</span>
                                                                <?php
                                                            } else if ($watchlist_data["quantity"] > 0) {
                                                                $invoice_item = Database::execute("SELECT `product_product_id`,SUM(invoice_item_quantity) AS `product_count` FROM `invoice` 
                                    INNER JOIN `invoice_item` ON `invoice`.`invoice_id`=`invoice_item`.`invoice_invoice_id` WHERE
                                     `product_product_id` = '" . $watchlist_data['product_id'] . "'");

                                                                $invoice_item_data = $invoice_item->fetch_assoc();

                                                                if ($watchlist_data["quantity"] > 10) {
                                                                    ?>
                                                                        <span class=" fs-6">
                                                                            More than 10 available <span class=""> / <?php echo $invoice_item_data["product_count"] == null ? "0":$invoice_item_data["product_count"] ?> Sold</span></span>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                        <span class="fw-normal fs-6">
                                                                        <?php echo $watchlist_data["quantity"] ?>
                                                                            items available <span class=""> / <?php echo $invoice_item_data["product_count"] == null ? "0":$invoice_item_data["product_count"] ?> Sold</span>
                                                                        </span>
                                                                    <?php
                                                                }

                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </h4>
                                            </td>

                                            <td class="mb-3 ui right aligned">
                                                <button
                                                    onclick="addtoCart(<?php echo $watchlist_data['product_id'] ?>,1);toggleWatchList(<?php echo $watchlist_data['product_id'] ?>);"
                                                    class=" ui icon teal  button" <?php if ($watchlist_data["quantity"] == 0) { ?>disabled<?php } ?>>
                                                    <b>+</b>
                                                    <i class="shop icon"></i>
                                                </button>
                                                <button
                                                    onclick="viewProduct(<?php echo $watchlist_data['product_id'] ?>,'user')"
                                                    class=" ui icon blue basic  button">
                                                    <i class="eye icon"></i>
                                                </button>
                                                <button onclick="toggleWatchList(<?php echo $watchlist_data['product_id'] ?>)"
                                                    class="ui  icon button basic secondary">
                                                    <i class="trash icon"></i>
                                                </button>
                                            </td>

                                        </tr>
                                        <?php
                                    }

                                }
                                ?>




                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <?php include "footer.php" ?>
    <script src="script.js"></script>
    <script>
        $(document).ready(() => {
            $('#watchlist-search').click(function () {
                $(this).select();
            });

            $('.ui.search')
                .search({
                    source: <?php echo json_encode($watchlist) ?>, //set the array of product titles
                    onResultsClose: function (query) {
                        var value = $("#watchlist-search").val().toLowerCase();
                        if (value == "") {
                            // Reset the filter when the search input is empty
                            $("#watchlistTable tr").show();
                        }

                    },
                    onSelect: function (result, response) {
                        console.log(result);
                        var value = result.title.toLowerCase();
                        $("#watchlistTable tr").filter(function () {
                            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                        });
                        return true;
                    }
                });

        });
    </script>
</body>

</html>