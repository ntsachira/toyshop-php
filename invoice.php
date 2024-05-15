<?php
session_start();
if (!isset($_SESSION['user']['email'])) {
    header('Location:index.php');
} else {
    include_once "connection.php";
    if (isset($_GET['inv'])) {
        $invoice_result = Database::execute("SELECT * FROM `invoice` WHERE `invoice_id`='" . $_GET['inv'] . "'");
        if ($invoice_result->num_rows == 1) {
            $invoice_data = $invoice_result->fetch_assoc();
            ?>
            <!DOCTYPE html>
            <html>

            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">

                <title>
                    Payment Invoice | ToyShop
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

                <!-- email invoice copy -->
                <style>

                </style>
            </head>

            <body>
                <?php
                include 'header.php';

                ?>
                <div class="container-lg">
                    <div class="row">
                        <div class="col-12 border rounded border-success py-3 my-2 d-flex justify-content-between align-items-center">
                            <span class="text-success fs-5 fw-bold">Order Placed - Payment Success</span>
                            <div class="d-flex">
                                <a href="myOrders.php" data-content="Go to My orders" data-position="bottom center" class="ui button icon invoiceTarget" ><div class="d-flex"><i class="left arrow icon"></i><span class="d-none d-md-block">Back to My Orders</span></div></a>
                                <button data-content="Print Invoice" data-position="bottom center" class="ui button orange icon invoiceTarget" id="print-invoice"><i class="print icon"></i><span class="d-none d-md-inline">Print</span></button>
                                <button data-content="Email Invoice" data-position="bottom center" class="ui button secondary icon invoiceTarget" id="email-invoice"><i id="email-invoice-icon" class="envelope icon">                                    
                                </i> <div id="email-invoice-spinner" class="ui mini  inline loader">&nbsp;</div>  <span class="d-none d-md-inline">Email</span>
                                </button>
                            </div>
                        </div>
                    </div>
                   
                  
                    <div class="row" id="invoice">
                        <div class="col-12 py-5 bg-blue">
                            <div class="row px-3 text-white">
                                <div class="col-6">
                                    <!-- logo block -->
                                    <img src="resource/logo.png" class="mb-2" alt="logo">
                                    <h1 class="">Invoice</h1>
                                    <!-- logo block -->
                                </div>
                                <div class="col-6 d-flex flex-column align-items-end">
                                    <h3 class="fw-bold">Toy Shop</h3>
                                    <span>54, Hakmana Road</span>
                                    <span>Matara</span>
                                    <span>Sri Lanka</span>
                                    <span>81000</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-3 py-3">
                            <div class="row px-3">
                                <?php
                                $address_result = Database::execute("SELECT * FROM `user_has_address` INNER JOIN `city` ON user_has_address.city_city_id = city.city_id
                                 WHERE `user_email` = '" . $_SESSION['user']['email'] . "'");
                                $address_num = $address_result->num_rows;
                                $address_data = $address_result->fetch_assoc();
                                ?>
                                <div class="col-6 d-flex flex-column">
                                    <span class="fw-bold">BILL TO:</span>
                                    <h5 class="">
                                        <?php echo $_SESSION['user']['first_name'] . " " . $_SESSION['user']['last_name'] ?>
                                    </h5>
                                    <span><?php echo $address_data['line1'].", ".$address_data['line2']?></span>
                                    <span><?php echo $address_data['city_name']?></span>
                                    <span>Sri Lanka</span>
                                    <span><?php echo $address_data['postal_code']?></span>
                                </div>
                                <div class="col-6 d-flex flex-column align-items-end">
                                    <span class="fw-bold">INVOICE ID</span>
                                    <span class="mb-2">
                                        <?php echo $_GET['inv'] ?>
                                    </span>
                                    <span class="fw-bold">ISSUED DATE</span>
                                    <span><?php echo date_format(new DateTime($invoice_data['date']), "D M Y  H:i:s"); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 py-3">
                            <div class="row">
                                <div class="col-12 bg-blue py-2 px-4 text-white">
                                    <div class="row">
                                        <div class="col-1">ITEM</div>
                                        <div class="col-4">DESCRIPTION</div>
                                        <div class="col-1 d-flex justify-content-end">QTY</div>
                                        <div class="col-2 d-flex justify-content-end">UNIT PRICE (Rs)</div>
                                        <div class="col-2 d-flex justify-content-end">SHIPPING (Rs)</div>
                                        <div class="col-2 d-flex justify-content-end">AMOUNT (Rs)</div>
                                    </div>
                                </div>
                                <?php
                                $invoice_item_result = Database::execute("SELECT * FROM `invoice_item` INNER JOIN `product` ON invoice_item.product_product_id = product.product_id                                
                                 WHERE `invoice_invoice_id`='" . $invoice_data['invoice_id'] . "'");
                                $num = 1;
                                $subtotal = 0;
                                $shippingTotal = 0;
                                while ($invoice_item_data = $invoice_item_result->fetch_assoc()) {
                                    $subtotal = $subtotal + ($invoice_item_data['invoice_item_price'] * $invoice_item_data['invoice_item_quantity']);
                                    $shippingTotal = $shippingTotal + ($invoice_item_data['shipping_fee'] * (ceil($invoice_item_data['invoice_item_quantity'] / 2)));

                                    ?>
                                    <div class="col-12 bg-lblue py-3 px-4 border-bottom border-white">
                                        <div class="row">
                                            <div class="col-1">
                                                <?php echo $num ?>
                                            </div>
                                            <div class="col-4">
                                                <?php echo $invoice_item_data['title'] ?>
                                            </div>
                                            <div class="col-1 d-flex justify-content-end">
                                                <?php echo $invoice_item_data['invoice_item_quantity'] ?>
                                            </div>
                                            <div class="col-2 d-flex justify-content-end">
                                                <?php echo number_format($invoice_item_data['invoice_item_price'], 2) ?>
                                            </div>
                                            <div class="col-2 d-flex justify-content-end">
                                                <?php echo number_format($invoice_item_data['shipping_fee'] * (ceil($invoice_item_data['invoice_item_quantity'] / 2)), 2) ?>
                                            </div>
                                            <div class="col-2 d-flex justify-content-end">
                                                <?php echo number_format(($invoice_item_data['invoice_item_quantity'] * $invoice_item_data['invoice_item_price']) + 
                                                ($invoice_item_data['shipping_fee'] * (ceil($invoice_item_data['invoice_item_quantity'] / 2))), 2) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $num = $num + 1;
                                }
                                ?>

                            </div>
                        </div>
                        <div class="col-12 py-3 px-4">
                            <div class="row justify-content-end">
                                <div class="col-2 d-flex flex-column align-items-end">
                                    <p class="fw-bold">SUB-TOTAL</p>
                                    <p class="fw-bold">SHIPPING-TOTAL</p>
                                </div>
                                <div class="col-2 d-flex flex-column align-items-end">
                                    <p>Rs.
                                        <?php echo number_format($subtotal, 2) ?>
                                    </p>
                                    <p>Rs.
                                        <?php echo number_format($shippingTotal, 2) ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 py-3">
                            <div class="row flex-row-reverse">
                                <div
                                    class="col-12 py-3 px-4 d-flex flex-column justify-content-center align-items-end col-md-4 bg-blue text-white">
                                    <span>TOTAL</span>
                                    <h2 class="fw-bold">Rs.
                                        <?php echo number_format($subtotal + $shippingTotal, 2) ?>
                                    </h2>
                                </div>
                                <div class="col-12 py-3 px-4 col-md-8 bg-lblue">
                                    <p class="fw-bold">NOTES:</p>
                                    <p class="">Please note, our return policy allows returns within 30 days of the receipt of the
                                        item. If you have any issues with your order, please don't hesitate to contact our customer
                                        service at [Customer Service Contact Information].</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Email copy hidden visually -->
                    <div class="d-none"style="display: flex; flex-direction: column; background-color: white;" id="email-invoice-content">
                    <div style="margin-bottom: 10px">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="width: 50%;border-bottom: 1px solid #ddd;padding-bottom: 10px"><h1>Invoice</h1></td>
                                    <td style="width: 50%; text-align:right;border-bottom: 1px solid #ddd;padding-bottom: 10px">
                                        <span><b>Toy Shop</b></span><br>
                                        <span>70, Hakmana Road</span><br>
                                        <span>Matara</span><br>
                                        <span>Sri Lanka</span>
                                    </td>
                                </tr>
                            </table>                           
                        </div>

                        <div style="margin-bottom: 10px">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="width: 50%;">
                                    <span><b>BILL TO:</b></span><br>
                                    <span class="">
                                        <?php echo $_SESSION['user']['first_name'] . " " . $_SESSION['user']['last_name'] ?>
                                    </span><br>
                                    <span><?php echo $address_data['line1'].", ".$address_data['line2']?></span><br>
                                    <span><?php echo $address_data['city_name']?></span><br>
                                    <span>Sri Lanka</span><br>
                                    <span><?php echo $address_data['postal_code']?></span>
                                    </td>

                                    <td style="width: 50%; text-align:right">
                                        <span><b>INVOICE ID</b></span>
                                        <p><?php echo $_GET['inv'] ?></p>
                                        <span><b>ISSUED DATE</b></span><br>
                                        <span><?php echo date_format(new DateTime($invoice_data['date']), "D M Y  H:i:s"); ?></span>
                                    </td>
                                </tr>
                            </table>                           
                        </div>                       
                       
                        <div style="display: flex; flex-direction: row;">
                       
                            <table style=" width: 100%;  border-collapse: collapse;">
                                <tr>
                                    <th style="border: 1px solid; padding: 5px;">DESCRIPTION</th>
                                    <th style="border: 1px solid; padding: 5px; text-align:right">SHIPPING</th>
                                    <th style="border: 1px solid; padding: 5px; text-align:right">AMOUNT</th>
                                </tr>
                                <?php
                                $email_invoice_result = Database::execute("SELECT * FROM `invoice_item` INNER JOIN `product` ON invoice_item.product_product_id = product.product_id                                
                                 WHERE `invoice_invoice_id`='" . $invoice_data['invoice_id'] . "'");
                                
                                $subtotal = 0;
                                $shippingTotal = 0;
                                while ($invoice_item_data = $email_invoice_result->fetch_assoc()) {
                                    $subtotal = $subtotal + ($invoice_item_data['invoice_item_price'] * $invoice_item_data['invoice_item_quantity']);
                                    $shippingTotal = $shippingTotal + ($invoice_item_data['shipping_fee'] * (ceil($invoice_item_data['invoice_item_quantity'] / 2)));

                                    ?>

                                <tr >
                                    <td style="padding: 5px;padding-bottom: 5px;border-bottom: 1px solid #ddd;padding-top: 10px;">
                                        <span><?php echo $invoice_item_data['title'] ?></span>
                                        <p style=""><?php echo $invoice_item_data['invoice_item_quantity'] ?> * <?php echo number_format($invoice_item_data['invoice_item_price'], 2) ?></p>
                                    </td>
                                    <td style="padding: 5px;padding-bottom: 5px; text-align:right;border-bottom: 1px solid #ddd;padding-top: 10px;">
                                        <?php echo number_format($invoice_item_data['shipping_fee'] * (ceil($invoice_item_data['invoice_item_quantity'] / 2)), 2) ?>
                                    </td>
                                    <td style="padding: 5px;padding-bottom: 5px; text-align:right;border-bottom: 1px solid #ddd;padding-top: 10px;">
                                    <?php echo number_format(($invoice_item_data['invoice_item_quantity'] * $invoice_item_data['invoice_item_price']) + 
                                    ($invoice_item_data['shipping_fee'] * (ceil($invoice_item_data['invoice_item_quantity'] / 2))), 2) ?>
                                    </td>
                                </tr>
                                <?php 
                                }
                                ?>
                                <tr>
                                    
                                <td style="padding: 5px;padding-bottom: 5px;padding-top: 10px;text-align:right">
                                    <b>SUB-TOTAL</b>
                                </td>
                                <td colspan="2" style="padding: 5px;padding-bottom: 5px;padding-top: 10px;text-align:right">
                                    Rs. <?php echo number_format($subtotal, 2) ?>
                                </td>
                                </tr>
                                <tr>
                                    
                                <td style="padding: 5px;padding-bottom: 5px;padding-top: 10px;text-align:right">
                                    <b>SHIPPING-TOTAL</b>
                                </td>
                                <td colspan="2" style="padding: 5px;padding-bottom: 5px;border-bottom: 1px solid;padding-top: 10px;text-align:right">
                                    Rs. <?php echo number_format($shippingTotal, 2) ?>
                                </td>
                                </tr>
                                <tr>         
                                    <td style="text-align: right;"><b>TOTAL</b></td>                           
                                    <td colspan="2" style="text-align: right; padding-top:15px;padding-bottom: 15px;">                                        
                                        <h2>Rs. <?php echo number_format($subtotal + $shippingTotal, 2) ?></h2>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="padding-top: 10px;">
                                    <p><b>NOTES:</b></p>
                                    <p class="">Please note, our return policy allows returns within 30 days of the receipt of the
                                        item. If you have any issues with your order, please don't hesitate to contact our customer
                                        service at [Customer Service Contact Information].</p>
                                    </td>
                                </tr>
                            </table>
                            
                        </div>
                    </div>
                </div>

                <?php include "footer.php" ?>
                <script src="script.js"></script>
            </body>

            </html>

            <?php
        }
    }

}

?>