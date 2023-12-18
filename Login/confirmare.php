<?php
include '..\Config\connect.php';

if (isset($_GET['email']))
{
    $email = $_GET['email'];

    $sql = "SELECT * FROM PENDING_USERS WHERE EMAIL = '$email'";
    $result = mysqli_query($conn, $sql);
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);

    foreach ($users as $user)
    {
        $username = mysqli_real_escape_string($conn, $user['USERNAME']);
        $password = mysqli_real_escape_string($conn, $user['PASSWORD']);
        $date = mysqli_real_escape_string($conn, $user['BIRTH_DATE']);
        $fullname = mysqli_real_escape_string($conn, $user['FULL_NAME']);
        $phone = mysqli_real_escape_string($conn, $user['PHONE_NUMBER']);
        $sql = "INSERT INTO USERS(USERNAME, FULL_NAME, PHONE_NUMBER, PASSWORD, BIRTH_DATE, EMAIL, IS_ADMIN) VALUES('$username', '$fullname', '$phone', '$password', '$date', '$email', '0')";
        mysqli_query($conn, $sql);
        $sql = "DELETE FROM PENDING_USERS WHERE EMAIL = '$email'";
        mysqli_query($conn, $sql);
    }
} 
?>

<!DOCTYPE HTML>
<html lang="en">

<head>
    <style>
        body {
            background-image: url("../book_images/conf.avif");
            background-size: 100%;
            background-repeat: no-repeat;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        h1 {
            color: white;
            font-size: 100px;
            text-align: center;
            font-family: 'Work Sans', sans-serif;
            margin-bottom: 20vh;
            text-shadow: 10px 10px 20px black;
        }

        button {
           
            display: inline-block;
           
            outline: none;
            cursor: pointer;
            font-size: 20px;
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
            height: 89px;
            width: 200px;
        }

        button:hover {
            background-color: #FF6659;
        }
    </style>
</head>

<body>
    <h1> Email confirmat cu succes! </h1>
    <a href="loginpage.php"> <button> Login </button> </a>
</body>

</html>