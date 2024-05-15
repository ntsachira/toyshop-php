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
        My Cart | ToyShop
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
                    <h2><i class="shop icon fs-4"></i> Cart</h2>
                </div>
                <div class="col d-flex justify-content-end">
                    <!-- search -->
                    <div class="ui search">
                        <div class="ui icon input d-flex gap-2">
                            <input class="prompt" type="text" placeholder="Search cart..." id="cart-search">
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
                Cart
            </div>
        </div>
        <!-- bread crumb -->
        <div class="row">
            <?php
            $cart_result = Database::execute("SELECT * FROM `cart` INNER JOIN `active_product` ON `cart`.`product_product_id`=`active_product`.`product_id` 
                 WHERE `user_email`='" . $_SESSION['user']['email'] . "' AND `quantity` > '0'");
            $cart_num = $cart_result->num_rows;
            ?>
            <div class="col-12 mb-3">
                <h1 class="text-center fw-normal fs-1">Your Shopping Cart Summary</h1>
            </div>
            <?php
            $address_num = 0;
            if ($cart_num > 0) {
                $cart_result_2 = Database::execute("SELECT * FROM `cart` INNER JOIN `active_product` ON `cart`.`product_product_id`=`active_product`.`product_id` 
                WHERE `user_email`='" . $_SESSION['user']['email'] . "' AND `quantity` > '0'");

                $address_result = Database::execute("SELECT * FROM `user_has_address` WHERE `user_email` = '" . $_SESSION['user']['email'] . "'");
                $address_num = $address_result->num_rows;
                $address_data = $address_result->fetch_assoc();

                $subtotal = 0;
                $shippingTotal = 0;                

                while($cart_result_2_data = $cart_result_2->fetch_assoc()){

                    $subtotal = $subtotal + ($cart_result_2_data['price']*$cart_result_2_data['cart_quantity']);

                    if($address_num == 1){
                        if($address_data['city_city_id']==1){
                            $shippingTotal = $shippingTotal + ($cart_result_2_data['delivery_fee_matara']*(ceil($cart_result_2_data['cart_quantity']/2)));
                        }else{
                            $shippingTotal = $shippingTotal + ($cart_result_2_data['delivery_fee_other']*(ceil($cart_result_2_data['cart_quantity']/2)));
                        }
                    }else{
                        $shippingTotal = $shippingTotal + ($cart_result_2_data['delivery_fee_matara']*(ceil($cart_result_2_data['cart_quantity']/2)));
                    }
                    

                }

                ?>
                <div class="col-12 mb-3 pb-3">
                    <h6 class="text-center text-secondary">Review your cart with <b class="text-orange"><?php echo $cart_num ?> item<?php echo $cart_num > 1?"s":"" ?></b> and
                        total <b class="text-orange">Rs.<?php echo number_format($subtotal+$shippingTotal,2); ?></b></h6>
                </div>
                <?php               
                if($address_num == 0){
                    ?>
                     <div class="col-12 mb-3">
                <div class="alert alert-warning d-flex align-items-center h-auto w-auto" role="alert">           
                <div><i class="exclamation circle icon"></i>To complete the checkout, <a class="alert-link" href="userProfile.php">go to your profile </a>and update your address</div>
                </div>
                </div>
                    <?php
                }
            }
            ?>                   

            <div class="col-12 mb-3">
                <div class="row justify-content-center p-2">
                    <div class="col-12 col-md-8 mb-3">
                        <table class="ui single line table" id="cartTable">

                            <tbody>
                                <?php
                                $cart = array();
                                if ($cart_num == 0) {
                                    ?>
                                    <tr>
                                        <td colspan="5" class="text-center fs-3">
                                            <img src="resource/emptycart.png"
                                                style="height:15rem;width:15rem;object-fit:cover" alt="">
                                            <h1 class="text-secondary">No Items in Cart</h1>
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
                                    for ($i = 0; $i < $cart_num; $i++) {
                                        $cart_data = $cart_result->fetch_assoc();
                                         // to get the title list to load the search
                                         $data = new stdClass();
                                         $data->id = $cart_data['product_id'];
                                         $data->title = $cart_data['title'];
                                         array_push($cart, $data);
                                            ?>
                                        <tr>
                                            <td class="text-bg-light">
                                                <?php echo $i + 1 ?>
                                            </td>
                                            <td class="curser-pointer"  >
                                                <div class="d-flex gap-3">
                                                    <?php
                                                    $image_result = Database::execute("SELECT * FROM `product_image` WHERE
                                                    `product_product_id` = '" . $cart_data["product_id"] . "' LIMIT 1 ");
                                                    $image_data = $image_result->fetch_assoc();
                                                    ?>
                                                    <img src="resource/product_image/<?php echo $image_data["image_path"] ?>"
                                                        class="img-thumbnail image" onclick="viewProduct(<?php echo $cart_data['product_id'] ?>,'user')"
                                                        style="height:10rem;width:10rem;object-fit:contain">
                                                    <div class=" py-2 text-wrap position-relative w-100">
                                                        <span class="fs-6 card-title" onclick="viewProduct(<?php echo $cart_data['product_id'] ?>,'user')">
                                                            <?php echo $cart_data['title'] ?>
                                                        </span>
                                                        <div class="py-2  fs-6 text-secondary">                                                        
                                                                <?php echo $cart_data['condition_name'] ?>,                                                            
                                                            <span class=" "> Color:</span>
                                                            <?php echo $cart_data['color_name'] == "" ? "Not specified" : $cart_data['color_name'] ?>
                                                        </div>         
                                                        <?php 
                                                        $shipping = 0;
                                                        if($address_num == 1){
                                                            if($address_data['city_city_id']==1){
                                                                $shipping = $cart_data['delivery_fee_matara'];
                                                            }else{
                                                                $shipping = $cart_data['delivery_fee_other'];
                                                            }
                                                        }else{
                                                            $shipping = $cart_data['delivery_fee_matara'];
                                                        }
                                                        $shipping = $shipping*(ceil($cart_data['cart_quantity']/2));
                                                        ?>                                               
                                                        <div class="mb-2">🚢 Shipping fee: Rs. <?php echo number_format($shipping,2) ?></div>
                                                        <div class="d-flex flex-column flex-sm-row justify-content-between mb-3">
                                                            <span class=" text-orange fs-4 fw-bold">Rs.
                                                                <?php echo number_format($cart_data['price'], 2); ?>
                                                            </span>
                                                            <div class="d-flex flex-column align-items-end">
                                                            <select name="" id="cart-quantity<?php echo $cart_data["product_id"]?>" class="form-select w-auto" 
                                                            onchange='updateCart(<?php echo $cart_data["product_id"]?>)'>
                                                                <?php 
                                                                if($cart_data['quantity'] > 10){
                                                                    for($x = 1 ; $x <= 10 ; $x++){
                                                                        ?>
                                                                        <option <?php if($cart_data['cart_quantity']==$x){?>selected<?php } ?> value="<?php echo $x ?>"><?php echo $x ?></option>
                                                                        <?php
                                                                    }
                                                                }else{
                                                                    for($y = 1 ; $y <= $cart_data['quantity'] ; $y++){
                                                                        ?>
                                                                        <option <?php if($cart_data['cart_quantity']==$y){?>selected<?php } ?>  value="<?php echo $y ?>"><?php echo $y ?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                            <span>Total: Rs. <?php echo number_format(($cart_data['price']*$cart_data['cart_quantity']), 2); ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-end">
                                                            <button class="ui button basic "onclick="removeFromCart(<?php echo $cart_data['product_id']?>);toggleWatchList(<?php echo $cart_data['product_id'] ?>);">
                                                            Save for later</button>
                                                            <button class="ui button basic icon" onclick="removeFromCart(<?php echo $cart_data['product_id']?>);">
                                                            <i class="trash icon"></i></button>
                                                        </div>                                                      
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                        <?php
                                    }

                                }
                                $soldout_result = Database::execute("SELECT * FROM `cart` INNER JOIN `active_product` ON `cart`.`product_product_id`=`active_product`.`product_id` 
                                WHERE `user_email`='" . $_SESSION['user']['email'] . "' AND `quantity` = '0'");    
                                
                                if($soldout_result->num_rows > 0){
                                    ?>
                                    <tfoot>
                                     <tr>
                                        <td class="p-0 pt-3" colspan='2'>
                                            <div class="py-2 px-3 bg-warning bg-opacity-25">
                                               <span class="">Products Sold Out!</span> 😢
                                            </div>
                                        </td>
                                     </tr>
                                    <?php
                                while($soldout_data = $soldout_result->fetch_assoc()){
                                    ?>                                  
                                       
                                        <tr>
                                            <td class="text-bg-light">
                                            <button class="ui button basic icon" onclick="removeFromCart(<?php echo $soldout_data['product_id']?>);"><i class="trash icon"></i></button>

                                            </td>
                                            <td class="curser-pointer position-relative overflow-hidden"  >
                                            <div class="  position-absolute w-100 h-100 top-0 start-0 bg-light opacity-50"style="z-index: 1;"></div>
                                                <div class="d-flex gap-3 position-relative">
                                                    
                                                    <?php
                                                    $image_result = Database::execute("SELECT * FROM `product_image` WHERE
                                                    `product_product_id` = '" . $soldout_data["product_id"] . "' LIMIT 1 ");
                                                    $image_data = $image_result->fetch_assoc();
                                                    ?>
                                                    <img src="resource/product_image/<?php echo $image_data["image_path"] ?>" 
                                                        class="img-thumbnail image" onclick="viewProduct(<?php echo $soldout_data['product_id'] ?>,'user')"
                                                        style="height:10rem;width:10rem;object-fit:contain;z-index: 0;">
                                                    <div class=" py-2 text-wrap position-relative w-100">
                                                        <span class="fs-6 card-title" onclick="viewProduct(<?php echo $soldout_data['product_id'] ?>,'user')">
                                                            <?php echo $soldout_data['title'] ?>
                                                        </span>
                                                        <div class="py-2  fs-6 text-secondary">                                                        
                                                                <?php echo $soldout_data['condition_name'] ?>,                                                            
                                                            <span class=" "> Color:</span>
                                                            <?php echo $soldout_data['color_name'] == "" ? "Not specified" : $soldout_data['color_name'] ?>
                                                        </div>         
                                                        <?php 
                                                        $shipping = 0;
                                                        if($address_num == 1){
                                                            if($address_data['city_city_id']==1){
                                                                $shipping = $soldout_data['delivery_fee_matara'];
                                                            }else{
                                                                $shipping = $soldout_data['delivery_fee_other'];
                                                            }
                                                        }else{
                                                            $shipping = $soldout_data['delivery_fee_matara'];
                                                        }
                                                        $shipping = $shipping*(ceil($soldout_data['cart_quantity']/2));
                                                        ?>                                               
                                                        <div class="mb-2">🚢 Shipping fee: Rs. <?php echo number_format($shipping,2) ?></div>
                                                        <div class="d-flex flex-column flex-sm-row justify-content-between mb-3">
                                                            <span class=" text-orange fs-4 fw-bold">Rs.
                                                                <?php echo number_format($soldout_data['price'], 2); ?>
                                                            </span>
                                                            
                                                        </div>
                                                        <div class="d-flex justify-content-end" >                                      
                                                            <button class="ui button basic orange icon" style="z-index: 2;"
                                                            onclick="removeFromCart(<?php echo $soldout_data['product_id']?>);toggleWatchList(<?php echo $soldout_data['product_id'] ?>)">
                                                            <i id="heart-icon<?php echo $soldout_data['product_id'] ?>" class="heart icon "></i> 
                                                            Add to Watchlist</button>
                                                        </div>                                                      
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                       
                                   
                                    <?php
                                }
                                ?>
                               
                                </tfoot>
                                <?php
                            }
                                ?>

                            </tbody>
                        </table>
                    </div>
                    <?php 
                    if ($cart_num > 0) {
                        ?>
                         <div class="col-12 col-md-4 ">
                        <div class="row border py-3">
                            <div class="col-12 mb-3 d-flex justify-content-between">
                                <button onclick="checkout();"
                                class="ui button orange rounded-5 w-100 large" <?php if($address_num == 0){ ?>disabled<?php }?>>CheckOut</button>
                            </div>
                            <div class="col-12 mb-3 d-flex justify-content-between">
                                <span>Items</span>
                                <span class="fw-bold">Rs.<?php echo number_format($subtotal,2); ?></span>
                            </div>
                            <div class="col-12 mb-3 d-flex justify-content-between">
                            <span>Shipping</span>
                                <span class="fw-bold">Rs.<?php echo number_format($shippingTotal,2); ?></span>
                            </div>
                            <div class="col-12 pt-3 d-flex justify-content-between fs-4 border-top">
                            <span>Subtotal</span>
                                <span>Rs.<?php echo number_format($subtotal+$shippingTotal,2); ?></span>
                            </div>
                        </div>
                    </div>
                        <?php
                    }
                    ?>
                   
                </div>

            </div>
        </div>
    </div>
    <?php include "footer.php" ?>
    <script>
        $(document).ready(() => {
            $('#cart-search').click(function () {
                $(this).select();
            });

            $('.ui.search')
                .search({
                    source: <?php echo json_encode($cart) ?>, //set the array of product titles
                    onResultsClose: function (query) {
                        var value = $("#cart-search").val().toLowerCase();
                        if (value == "") {
                            // Reset the filter when the search input is empty
                            $("#cartTable tr").show();
                        }

                    },
                    onSelect: function (result, response) {
                        console.log(result);
                        var value = result.title.toLowerCase();
                        $("#cartTable tr").filter(function () {
                            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                        });
                        return true;
                    }
                });

        });
    </script>
       <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>

</body>

</html>