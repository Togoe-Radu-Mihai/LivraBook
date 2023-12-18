<?php
include '..\Config\connect.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CodePen - A.</title>
    <style>
        body {
            background-image: url("../book_images/verificationbackground.webp");
            background-repeat: no-repeat;
            background-size: 100%;

            font-family: 'Work Sans', sans-serif;
            font-weight: 600;
        }

        .mesaj {
            font-family: 'Source Sans Pro';
            margin: auto;
            padding: 1.5%;
            width: 80vh;
            height: 90vh;
            ;
            background-color: #e9ecef;
            border-radius: 25px;
            text-align: center;
        }

        h1 {
            margin-top: 0;
            font-size: 100px;
        }

        h3 {
            font-size: 50px;
        }

        button {
            display: inline-block;
            outline: none;
            cursor: pointer;
            font-size: 14px;
            line-height: 1;
            border-radius: 500px;
            transition-property: background-color, border-color, color, box-shadow, filter;
            transition-duration: .3s;
            border: 1px solid transparent;
            letter-spacing: 2px;
            min-width: 160px;
            text-transform: uppercase;
            white-space: normal;
            font-weight: 700;
            text-align: center;
            padding: 16px 14px 18px;
            color: #fff;
            background-color: #E7473C;
            height: 48px;
        }

        button:hover {
            background-color: #FF6659;
        }

        
    </style>
</head>

<body>
    <div class="mesaj">
        <h1> Confirm your email adress </h1>
        <h3> We've sent a verification link to your e-mail. After verifying your account, please proceed to our login
            page in order to sign in </h3>
        <a href = "loginpage.php" > <button> Login </button> </a>
    </div>
</body>

</html>