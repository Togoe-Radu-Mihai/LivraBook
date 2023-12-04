<?php
include("../Config/connect.php");
$user_id = $_SESSION['userid'];
$sql0 = "SELECT * FROM cart WHERE USER_ID = '$user_id'";
$result = mysqli_query($conn, $sql0);
$carts = mysqli_fetch_all($result, MYSQLI_ASSOC);

if (isset($_GET['continue'])) {
    $sql = "DELETE FROM cart WHERE USER_ID = '$user_id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        foreach ($carts as $cart) {
            $userid = $cart['USER_ID'];
            $productid = $cart['PRODUCT_ID'];
            $date =  date("Y-m-d");
            $completed = $cart['COMPLETED'];
            $sql1 = "INSERT INTO cart(USER_ID, PRODUCT_ID, ORDER_DATE, COMPLETED) VALUES('$userid', '$productid', '$date', '1')";
            mysqli_query($conn, $sql1);
            header('Location:cart.php');
        }
    } else
        echo "noob";


}

?>

<head>
    <link href="checkout.css" rel="stylesheet">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
</head>
<!------ Include the above in your HEAD tag ---------->

<body>
    <?php
    include("..\Templates\header.php")
        ?>

    <div class="shipHTML shipBody">
        <div class="shipContainer">
            <h1 class="shiph1">Checkout</h1>
            <p class="shipp">Please enter your shipping details.</p>
            <hr />
            <div class="form">

                <div class="fields fields--2">
                    <label class="field">
                        <span class="field__label" for="firstname">First name</span>
                        <input class="field__input" type="text" id="firstname" value="" />
                    </label>
                    <label class="field">
                        <span class="field__label" for="lastname">Last name</span>
                        <input class="field__input" type="text" id="lastname" value="" />
                    </label>
                </div>
                <label class="field">
                    <span class="field__label" for="address">Address</span>
                    <input class="field__input" type="text" id="address" />
                </label>
                <label class="field">
                    <span class="field__label" for="country">Country</span>
                    <input class="field__input" type="text" id="country" />
                </label>
                <div class="fields fields--3">
                    <label class="field">
                        <span class="field__label" for="zipcode">Zip code</span>
                        <input class="field__input" type="text" id="zipcode" />
                    </label>
                    <label class="field">
                        <span class="field__label" for="city">City</span>
                        <input class="field__input" type="text" id="city" />
                    </label>
                    <label class="field">
                        <span class="field__label" for="state">State</span>
                        <input class="field__input" type="text" id="state" />
                    </label>
                </div>

                <!-- Select Payment Method -->
                <div class="field">
                    <label for="paymentMethod" class="field__label">Select Payment Method</label>
                    <select id="paymentMethod" class="field__input" onchange="togglePaymentFields()">
                        <option value="cash">Cash on Delivery</option>
                        <option value="creditCard">Credit Card</option>
                    </select>
                </div>

                <!-- Credit Card Payment Fields -->
                <div class="fields fields--3" id="creditCardFields" style="display: none;">
                    <label class="field">
                        <span class="field__label" for="cardNumber">Credit Card Number</span>
                        <input class="field__input" type="text" id="cardNumber" />
                    </label>
                    <label class="field">
                        <span class="field__label" for="expiryDate">Expiry Date</span>
                        <input class="field__input" type="text" id="expiryDate" />
                    </label>
                    <label class="field">
                        <span class="field__label" for="cvv">CVV</span>
                        <input class="field__input" type="text" id="cvv" />
                    </label>
                </div>
                <!-- Credit Card Payment Fields End -->

            </div>
            <hr>
            <a href="checkout.php?continue=1">
                <button class="shipbutton" style="background-color:#E7473C;">Continue</button>
            </a>
        </div>
    </div>

    <script>
        function togglePaymentFields() {
            var paymentMethod = document.getElementById('paymentMethod').value;
            var creditCardFields = document.getElementById('creditCardFields');

            if (paymentMethod === 'creditCard') {
                var x = document.querySelector('.shipContainer');
                x.style.height = "90vh";
                creditCardFields.style.display = 'block';
            } else {
                creditCardFields.style.display = 'none';
            }
        }
    </script>
</body>

</html>