<?php
include '..\Config\connect.php';

if (isset($_POST) && isset($_POST['submit']))
{
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $date = mysqli_real_escape_string($conn, $_POST['date']);
        $fullname = mysqli_real_escape_string($conn, $_POST['full_name']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        // create sql
        $sql = "INSERT INTO users(username, FULL_NAME, PHONE_NUMBER, PASSWORD, birth_date, email) VALUES('$username', '$fullname', '$phone', '$password', '$date', '$email')";
        header('Location:..\index.php');
        // save to db and check
        if(mysqli_query($conn, $sql)){
            // success
            
            header('Location:..\index.php');
        } else {
            echo 'query error: '. mysqli_error($conn);
        }
 
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login V18</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!--===============================================================================================-->

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.2/css/bootstrap-responsive.css">
    <link rel="stysheet" href="date_style.css">



</head>
<?php include '..\Templates\header.php'; ?>

<body style="background-color: #666666;">
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form class="login100-form validate-form" action="\Login\registerpage.php" method="POST">
                    <span class="login100-form-title p-b-43">
                        Register a new account
                    </span>


                    <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                        <input class="input100" type="text" name="email" value="">
                        <span class="focus-input100"></span>
                        <span class="label-input100">Email</span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="The field must not be empty">
                        <input class="input100" type="text" name="username" value="">
                        <span class="focus-input100"></span>
                        <span class="label-input100">Username</span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="The field must not be empty">
                        <input class="input100" type="text" name="full_name" value="">
                        <span class="focus-input100"></span>
                        <span class="label-input100">Full Name</span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="The field doesn't match a phone number">
                        <input class="input100" type="text" name="phone" value="">
                        <span class="focus-input100"></span>
                        <span class="label-input100">Phone Number</span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <input class="input100" type="password" name="password" value="">
                        <span class="focus-input100"></span>
                        <span class="label-input100">Password</span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="The password does not match">
                        <input class="input100" type="password" name="confirm_password" value="">
                        <span class="focus-input100"></span>
                        <span class="label-input100">Confirm Password</span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="You must introduce your birth date">
        <input class="input100" id="birthDate" type="text" name="date" placeholder="Date" onfocus="(this.type='date')" onblur="(this.type='text')" onchange="clearPlaceholder(this)">
        <span class="focus-input100"></span>
    </div>

    <script>
        function clearPlaceholder(input) {
            input.setCustomValidity('');
        }
    </script>

                    <!-- <div class="flex-sb-m w-full p-t-3 p-b-32">
                        <div class="contact100-form-checkbox">
                            <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
                            <label class="label-checkbox100" for="ckb1">
                                Remember me
                            </label>
                        </div>

                        <div>
                            <a href="#" class="txt1">
                                Forgot Password?
                            </a>
                        </div>
                    </div> -->
                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn .bg-danger" id="oringi" style="background-color:#E7473C;" name="submit">
                            Register
                        </button>

                    </div>

                </form>

                <div class="login100-more" style="background-image: url('bookImage.jpg');">
                </div>
            </div>
        </div>
    </div>





    <!--===============================================================================================-->
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/animsition/js/animsition.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/daterangepicker/moment.min.js"></script>
    <script src="vendor/daterangepicker/daterangepicker.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/countdowntime/countdowntime.js"></script>
    <!--===============================================================================================-->
    <script src="js/main.js"></script>

</body>

</html>