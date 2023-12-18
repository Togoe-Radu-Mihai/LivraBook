<?php
include("../Config/connect.php");
$user_id = $_SESSION['userid'];
$sql0 = "SELECT * FROM cart WHERE USER_ID = '$user_id'";
$result = mysqli_query($conn, $sql0);
$carts = mysqli_fetch_all($result, MYSQLI_ASSOC);
$total = 0;
$errors = ["firstname" => "", "lastname" => "", "city" => "", "adress" => "", "country" => "", "zipcode" => "", "state" => ""];
if (isset($_POST["firstname"])) {
    $ok = 0;

    // Validate first name
    $firstname = $_POST['firstname'];
    if (empty($firstname)) {
        $errors['firstname'] = 'First name is required';
        $ok = 1;
    }

    // Validate last name
    $lastname = $_POST['lastname'];
    if (empty($lastname)) {
        $errors['lastname'] = 'Last name is required';
        $ok = 1;
    }

    // Validate address
    $address = $_POST['adress']; // Note: 'adress' is a typo in your HTML
    if (empty($address)) {
        $errors['adress'] = 'Address is required';
        $ok = 1;
    }

    // Validate country
    $country = $_POST['country'];
    if (empty($country)) {
        $errors['country'] = 'Country is required';
        $ok = 1;
    }

    // Validate zip code
    $zipcode = $_POST['zipcode'];
    if (empty($zipcode)) {
        $errors['zipcode'] = 'Zip code is required';
        $ok = 1;
    }

    // Validate city
    $city = $_POST['city'];
    if (empty($city)) {
        $errors['city'] = 'City is required';
        $ok = 1;
    }

    // Validate state
    $state = $_POST['state'];
    if (empty($state)) {
        $errors['state'] = 'Region is required';
        $ok = 1;
    }

   
    if ($ok == 0)
    {
        $_SESSION['firstname'] = $firstname;
        $_SESSION['zipcode'] = $zipcode;
        $_SESSION['lastname'] = $lastname;
        $_SESSION['city'] = $city;
        $_SESSION['adress'] = $adress;
        $_SESSION['state'] = $state;
        $_SESSION['country'] = $country;
        header("Location: checkout.php?continue=1");
    }
   
}

if (isset($_GET['continue'])) {

    $sql = "DELETE FROM cart WHERE USER_ID = '$user_id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        foreach ($carts as $cart) {
            $userid = $cart['USER_ID'];
            $productid = $cart['PRODUCT_ID'];
            $date = date("Y-m-d");
            $quantity = $cart['QUANTITY'];
            $_SESSION['date'] = $date;
            $completed = $cart['COMPLETED'];
    
            // Move the SQL query inside the loop
            $sql1 = "INSERT INTO cart(USER_ID, PRODUCT_ID, ORDER_DATE, QUANTITY, COMPLETED) VALUES('$userid', '$productid', '$date', '$quantity', 1)";
            mysqli_query($conn, $sql1);
        }
    
        // Redirect after the loop completes
        header('Location: cart.php?checkout=1');
    }

}

?>
<html>
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
            <form action="checkout.php" method="POST">
                <div class="form">

                    <div class="fields fields--2">
                        <label class="field">
                            <span class="field__label" for="firstname">First name</span>
                            <input name = "firstname" class="field__input" type="text" id="firstname" value="" />
                            <?php echo "<p style='color: #dc3545; margin-top: -5; padding: 0;'>" . $errors['firstname'] . "</p>"; ?>
                        </label>
                        <label class="field">
                            <span class="field__label" for="lastname">Last name</span>
                            <input class="field__input" name = "lastname" type="text" id="lastname" value="" />
                            <?php echo "<p style='color: #dc3545;  margin-top: -5;' >" . $errors['lastname'] . "</p>"; ?>
                        </label>
                    </div>
                    <label class="field">
                        <span class="field__label" for="address">Address</span>
                        <input name = "adress" class="field__input" type="text" id="address" />
                        <?php echo "<p style='color: #dc3545; margin-top: -5;'>" . $errors['adress'] . "</p>"; ?>
                    </label>
                    <label class="field">
                        <span class="field__label" for="country">Country</span>
                        <input class="field__input" name = "country" type="text" id="country" />
                        <?php echo "<p style='color: #dc3545; margin-top: -5;'>" . $errors['country'] . "</p>"; ?>
                    </label>
                    <div class="fields fields--3">
                        <label class="field">
                            <span class="field__label" for="zipcode">Zip code</span>
                            <input name = "zipcode" class="field__input" type="text" id="zipcode" />
                            <?php echo "<p style='color: #dc3545; margin-top: -5;'>" . $errors['zipcode'] . "</p>"; ?>
                        </label>
                        <label class="field">
                            <span class="field__label" for="city">City</span>
                            <input name = "city" class="field__input" type="text" id="city" />
                            <?php echo "<p style='color: #dc3545; margin-top: -5;'>" . $errors['city'] . "</p>"; ?>
                        </label>
                        <label class="field">
                            <span class="field__label" for="state">County/Region</span>
                            <input name = "state" class="field__input" type="text" id="state" />
                            <?php echo "<p style='color: #dc3545; margin-top: -5;'>" . $errors['state'] . "</p>"; ?>
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
        <!-- <a href="checkout.php?continue=1"> -->
            <button class="shipbutton" name="submit" style="background-color:#E7473C;">Continue</button>
        <!-- </a> -->
        </form>
    </div>
    </div>

    <script>
        function togglePaymentFields() {
            var paymentMethod = document.getElementById('paymentMethod').value;
            var creditCardFields = document.getElementById('creditCardFields');

            if (paymentMethod === 'creditCard') {
                var x = document.querySelector('.shipContainer');
                x.style.height = "100vh";
                creditCardFields.style.display = 'block';
            } else {
                var x = document.querySelector('.shipContainer');
                x.style.height = "90vh";
                creditCardFields.style.display = 'none';
            }
        }
    </script>
</body>

</html>