<?php
include '..\Config\connect.php';

$user_id = $_SESSION['userid'];
$sql = "SELECT DISTINCT ORDER_DATE FROM cart WHERE USER_ID = '$user_id' and COMPLETED='1' ORDER BY ORDER_DATE";
$result = mysqli_query($conn, $sql);
$dates = mysqli_fetch_all($result, MYSQLI_ASSOC);


?>
<!DOCTYPE html>

<head>
    <link href="cart.css" rel="stylesheet">
</head>

<body>
    <?php include '..\Templates\header.php'; ?>

    <?php
    foreach ($dates as $date) { ?>
        <div class="cart-body">
            <div class="container px-3 my-5 clearfix">
                <div class="card">
                    <div class="card-header">
                        <h2>
                            <?php echo $date['ORDER_DATE'] ?>
                        </h2>
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
                                    $d = $date['ORDER_DATE'];
                                    $sql1 = "SELECT PRODUCT_ID, COUNT(*) as NR
                                    FROM CART
                                    WHERE ORDER_DATE = '$d' AND USER_ID = '$user_id' AND COMPLETED='1'
                                    GROUP BY PRODUCT_ID;";
                                    $result1 = mysqli_query($conn, $sql1);
                                    $ids = mysqli_fetch_all($result1, MYSQLI_ASSOC);
                                    foreach ($ids as $id) {
                                        $i = $id['PRODUCT_ID'];
    
                                        $sql2 = "SELECT  * FROM PRODUCTS WHERE PRODUCT_ID = '$i'";
                                        $result2 = mysqli_query($conn, $sql2);
                                        $produse = mysqli_fetch_all($result2, MYSQLI_ASSOC);
                                        foreach ($produse as $produs) { ?>
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
                                                    <input type="number" class="form-control text-center quantityInput" value=<?php echo $id["NR"] ?>
                                                        data-product-id="<?php echo $produs['PRODUCT_ID']; ?>">
                                                </td>
                                                <td class="text-right font-weight-semibold align-middle p-4 productTotal">
                                                    <?php echo $produs['PRICE']; ?>
                                                </td>
                                                <td class="text-center align-middle px-0">
                                                </td>
                                            </tr>


                                        <?php } ?>
                        <?php } ?>
                        </tbody>
                        </table>
                    </div>


                <?php } ?>






                <!-- / Shopping cart table -->


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
                            if (couponCode == "FIRST20") {
                                discountPercentage = 20;
                            } else {
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
                            var x = document.getElementById("totalCart");
                            var y = document.getElementById("discountValue");
                            x.textContent = total + " lei";
                            y.textContent = discountPercentage + "%";
                        }
                    });
                </script>
</body>

</html>