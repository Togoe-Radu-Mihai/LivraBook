<?php
include '..\Config\connect.php';

// Check if the user is logged in
if ($_SESSION['userid'] == '0') {
    header("Location: loginpage.php");
    exit();
}

// Handle the form submission to update account information
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userid = $_SESSION['userid'];
    // Retrieve and sanitize form data
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password =($_POST['password']); 
    $birthdate =$_POST['birthdate'];
    $phonenumber = htmlspecialchars($_POST['phonenumber']);
    $fullname = htmlspecialchars($_POST['fullname']);
    // Update session variables
    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;
    $_SESSION['birthdate'] = $birthdate;
    $_SESSION['phonenumber'] = $phonenumber;
    $_SESSION['fullname'] = $fullname;

    $sql = "SELECT* FROM users WHERE USER_ID = '$userid'";
    $result = mysqli_query($conn, $sql);
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $sql = "UPDATE users
            SET username = '$username',
                FULL_NAME = '$fullname',
                PHONE_NUMBER = '$phonenumber',
                PASSWORD = '$password',
                birth_date = '$birthdate',
                email = '$email'
            WHERE user_id = '$userid'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
            header("Location:account.php");
    }
    echo "Account updated successfully!";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .AccountBody {
            background-color: #DDD0C8;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .AccountContainer {
            max-width: 600px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        .AccountContainer h1 {
            text-align: center;
            color: #E7473C;
        }

        .AccountForm {
            display: flex;
            flex-direction: column;
        }

        .AccountLabel {
            margin-bottom: 8px;
            color: #E7473C;
        }

        .AccountInput {
            padding: 10px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #E7473C;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        button:hover {
            background-color: #C53A2F; /* Darker shade on hover */
        }

        .Footer {
            text-align: center;
            margin-top: 20px;
            color: #888;
            font-size: 14px;
        }
    </style>
    <title>Account Settings</title>
</head>

<body>
    <?php include '..\Templates\header.php'; ?>
    <div class="AccountBody">
    <div class="AccountContainer">
        <h1>Account Settings</h1>

        <form class="AccountForm" action="account.php" method="post">
            <label class="AccountLabel" for="username">Username:</label>
            <input class="AccountInput" type="text" id="username" name="username"
                value="<?php echo $_SESSION['username']; ?>" required>

            <label class="AccountLabel" for="fullname">Full Name:</label>
            <input class="AccountInput" type="text" id="fullname" name="fullname"
                value="<?php echo $_SESSION['fullname']; ?>" required>
            <label class="AccountLabel" for="phonenumber">Phone Number:</label>
            <input class="AccountInput" type="text" id="phonenumber" name="phonenumber"
                value="<?php echo $_SESSION['phonenumber']; ?>" required>
            <label class="AccountLabel" for="email">Email:</label>
            <input class="AccountInput" type="email" id="email" name="email" value="<?php echo $_SESSION['email']; ?>"
                required>

            <label class="AccountLabel" for="password">New Password:</label>
            <input class="AccountInput" type="password" id="password" name="password">

            <label class="AccountLabel" for="birthdate">Birth Date:</label>
            <input class="AccountInput" type="date" id="birthdate" name="birthdate"
                value="<?php echo $_SESSION['birthdate']; ?>" required>

            <button type="submit">Save Changes</button>
        </form>
    </div>

    </div>

</body>

</html>