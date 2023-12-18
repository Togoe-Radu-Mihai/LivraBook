<?php
include '..\Config\connect.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

$cookie = $_COOKIE['total'];
$_SESSION['total'] = $cookie;

if (isset($_SESSION['userid'])) {

    $deleted_cart = 0;
    if (isset($_GET['deleteID'])) {
        $del = $_GET['deleteID'];
        $sql = "DELETE FROM cart WHERE CART_ID = $del";
        $result = mysqli_query($conn, $sql);
        if ($result)
            header('Location:cart.php');
        else
            echo "noob";
    }
    $user_id = $_SESSION['userid'];
    $sql = "SELECT * FROM cart WHERE USER_ID = '$user_id' & COMPLETED='0'";
    $result = mysqli_query($conn, $sql);
    $carts = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
    if (isset($_GET['checkout'])) {
        $date = $_SESSION['date'];
        $price = $_SESSION['total'];
        $next_date = date('Y-m-d', strtotime($date . ' + 2 days'));
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "livrabook141@gmail.com";
        $mail->Password = "esfuryltopvyrakk";
        $mail->SMTPSecure = "ssl";
        $mail->Port = 465;

        $mail->setFrom("anothernoobanother@gmail.com");
        $mail->addAddress($_SESSION["email"]);
        $mail->isHTML(true);

        $mail->Subject = "LivraBook: Your order has been confirmed";
        $mail->Body = "
    <div style='background-color: #DDD0C8; padding: 20px; font-family: Arial, sans-serif;'>
        <h2 style='text-align: center; color: #E7473C;'>Thank you for purchasing from LivraBook</h2>
        <div style='margin-top: 20px; font-color: black; font-family: Georgia;'>
            <h3>Order details:</h3>
            <p><b>Order date:</b> $date</p>
            <p><b>Expected Shipping Date:</b> $next_date</p>
            <p><b>Total price:</b> $price</p>
            <p><b>Customer name:</b> " . $_SESSION['lastname'] . " " . $_SESSION['firstname'] . "</p>
            <p><b>County/Region:</b> " . $_SESSION['state'] . "</p>
            <p><b>City:</b> " . $_SESSION['city'] . "</p>
            <p><b>Zip Code:</b> " . $_SESSION['zipcode'] . "</p>
            <p><b>Address:</b> " . $_SESSION['adress'] . "</p>
        </div>
    </div>";
        $mail->send();

    }
}

?>
<!DOCTYPE html>

<head>
    <link href="cart.css" rel="stylesheet">
    <style>
        .oringi {
            background-color: #E7473C;
        }

        .oringi:hover {
            background-color: #FF6659;
        }
    </style>
</head>

<body style="background-color:#DDD0C8">
    <?php include '..\Templates\header.php'; ?>

    <?php
    if (isset($_GET['checkout'])) { ?>
        <h1 style="color: #14A44D; text-align: center; margin-top: 10px;"> Your order has been completed! Please check your
            email for shipping details</h1>
    <?php } ?>
    <div class="cart-body" style="background-color:#DDD0C8;">
        <div class="container px-3 my-5 clearfix">
            <!-- Shopping cart table -->
            <div class="card" style="background-color:#fff; padding-bottom:10px;">
                <div class="card-header">
                    <h2>Shopping Cart</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="cartTable" class="table table-bordered m-0">
                            <thead>
                                <tr>
                                    <!-- Set columns width -->
                                    <th class="text-center py-3 px-4" style="width: 300px;">Product Name &amp;
                                        Details</th>
                                    <th class="text-right py-3 px-4" style="width: 100px;">Price</th>
                                    <th class="text-center py-3 px-4" style="width: 10px;">Quantity</th>
                                    <th class="text-right py-3 px-4" style="width: 100px;">Total</th>
                                    <th class="text-center align-middle py-3 px-0" style="width: 40px;"><a href="#"
                                            class="shop-tooltip float-none text-light" title=""
                                            data-original-title="Clear cart"><i class="ino ion-md-trash"></i></a></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $id_produse[] = array();
                                foreach ($carts as $cart)
                                    array_push($id_produse, $cart['PRODUCT_ID']);
                                $ids = join(',', array_map('intval', $id_produse));
                                $produs_sql = "SELECT p.*, c.CART_ID, c.QUANTITY
               FROM products p
               JOIN cart c ON p.PRODUCT_ID = c.PRODUCT_ID
               WHERE p.PRODUCT_ID IN ($ids) AND c.COMPLETED = 0";
                                $r = mysqli_query($conn, $produs_sql);
                                $produse = mysqli_fetch_all($r, MYSQLI_ASSOC); ?>
                                <?php foreach ($produse as $produs): ?>
                                    <tr>
                                        <td class="p-4">
                                            <div class="media align-items-center">
                                                <img src=<?php echo '..\\' . $produs['PRODUCT_IMAGE']; ?>
                                                    class="d-block ui-w-40 ui-bordered mr-4"
                                                    style="min-width: 300px; min-height: 400px" alt="">
                                                <div class="media-body">
                                                    <a href="#" class="d-block text-dark">
                                                        <?php echo $produs['TITLE'] ?>
                                                    </a>
                                                    <small>
                                                        <span class="text-muted">Author:
                                                            <?php echo $produs['AUTHOR']; ?>
                                                        </span>
                                                        <span class="text-muted">Publisher:
                                                            <?php echo $produs['PUBLISHER']; ?>
                                                        </span> &nbsp;
                                                        <span class="text-muted">Category:
                                                            <?php echo $produs['CATEGORY']; ?>
                                                        </span> &nbsp;
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-right font-weight-semibold align-middle p-4 productPrice">
                                            <?php echo $produs['PRICE']; ?>
                                        </td>
                                        
                                        <td class="align-middle p-4">
                                        <input type="number" class="form-control text-center quantityInput" value="<?php echo intval($produs['QUANTITY']); ?>"
    data-product-id="<?php echo $produs['PRODUCT_ID']; ?>">
                                        </td>
                                        <td class="text-right font-weight-semibold align-middle p-4 productTotal">
                                            <?php echo ($produs['PRICE']) * intval($produs['QUANTITY']) . ".00 lei"; ?>
                                        </td>
                                        <td class="text-center align-middle px-0">
                                            <a href=<?php echo "cart.php?deleteID=" . $produs['CART_ID']; ?>
                                                class="shop-tooltip close float-none text-danger" title=""
                                                data-original-title="Remove">
                                                <button class="rmvButton">
                                                    DELETE
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- / Shopping cart table -->

                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Left side: Coupon input section -->
                                <div class="mt-4" style="width: 30%">
                                    <label for="coupon" class="text-muted font-weight-normal">Coupon Code</label>
                                    <input type="text" id="coupon" placeholder="ABC" class="form-control">
                                    <button id="checkCouponBtn" class="btn btn-primary oringi"
                                        style="background-color:#E7473C; border: none;">Check Coupon</button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Right side: Discount and Total price section -->
                                <div class="d-flex justify-content-end">
                                    <div class="text-right mt-4 mr-5">
                                        <label class="text-muted font-weight-normal m-0">Discount &emsp; </label>
                                        <div class="text-large"><strong>
                                                <p id="discountValue"> 0% </p>
                                            </strong></div>
                                    </div>
                                    <div class="text-right mt-4">
                                        <label class="text-muted font-weight-normal m-0 productTotalLabel">Total
                                            price</label>
                                        <div class="text-large"><strong>
                                                <p id="totalCart">$1164.65</p>
                                            </strong></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="float-right">
                    <button type="button" class="btn btn-lg btn-default md-btn-flat mt-2 mr-3">Back to
                        shopping</button>
                    <a href="checkout.php"> <button type="button" class="oringi btn btn-lg btn-primary mt-2"
                            style="background-color:#E7473C; border: none;">Checkout</button> </a>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        var final = 0;
        var discountPercentage = 0;

        document.addEventListener('DOMContentLoaded', function () {
            updateTotal();

            // Bind the input change event to updateTotal function
            var inputs = document.querySelectorAll('.quantityInput');
            inputs.forEach(function (input) {
                input.addEventListener('input', function () {
                    updateProductTotal(input);
                    updateTotal();
                });
            });
            // Bind the coupon input change event to applyCoupon function
            var couponInput = document.querySelector('#coupon');
            var checkCouponBtn = document.querySelector('#checkCouponBtn');

            checkCouponBtn.addEventListener('click', function () {
                applyCoupon(couponInput.value);
            });

            function applyCoupon(couponCode) {
                // Assuming 'FIRST20' is the valid coupon code for a 20% discount
                if (couponCode == "FIRST20")
                    discountPercentage = 20;
                else if (couponCode == "PROMO30")
                    discountPercentage = 30;
                else {
                    discountPercentage = 0;
                }

                updateTotal();
            }

            function updateProductTotal(input) {
                var quantity = parseInt(input.value);
                var price = parseFloat(input.closest('tr').querySelector('.productPrice').textContent);
                final = (quantity * price).toFixed(2);
                input.closest('tr').querySelector('.productTotal').textContent = (quantity * price).toFixed(2);
            }

            function updateTotal() {
                var total = 0;

                var rows = document.querySelectorAll('#cartTable tbody tr');
                rows.forEach(function (row) {
                    var price = parseFloat(row.querySelector('.productTotal').textContent);
                    total += isNaN(price) ? 0 : price;
                });

                var discount = (total * (discountPercentage / 100)).toFixed(2);
                var discountedTotal = (total - discount).toFixed(2);

                var totalElement = document.querySelector('.productTotalLabel strong');
                if (totalElement) {
                    totalElement.textContent = '$' + discountedTotal;
                }

                updateTotalCart(discountedTotal);
            }

            function updateTotalCart(total) {

                document.cookie = "total=" + total;

                var x = document.getElementById("totalCart");
                var y = document.getElementById("discountValue");
                x.textContent = total + " lei";
                y.textContent = discountPercentage + "%";
            }
        });
    </script>

</body>

</html>