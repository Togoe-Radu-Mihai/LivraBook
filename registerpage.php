<?php
include 'Config\connect.php';
$errors = ['email' => '', 'first_name' => '', 'last_name' => '', 'adress' => '', 
'phone_number' => '', 'password' => '', 'confirm_password' => ''];
$email = $first_name = $last_name = $adress = $phone_number = $adress = $password = $confirm_password = '';
if (isset($_POST) && isset($_POST['submit']))
{
    if (empty($_POST['email']))
    {
        $errors['email'] = "The field is empty!";
    }
    else
    {
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
            $errors['email'] = "The input doesn't match an email";
        else
            $email = $_POST['email'];
    }
    if (empty($_POST['first_name']))
    {
        $errors['first_name'] = "The field is empty!";
    }
    else
    {
        if(!preg_match('/^[a-zA-Z\s]+$/', $_POST['first_name']))
            $errors['first_name'] = 'The input must have letters and spaces only!';
        else
            $first_name = $_POST['first_name'];

    }
    if (empty($_POST['last_name']))
    {
        $errors['last_name'] = "The field is empty!";
    }
    else
    {
        if(!preg_match('/^[a-zA-Z\s]+$/', $_POST['last_name']))
            $errors['first_name'] = 'The input must have letters and spaces only!';
        else
            $last_name = $_POST['last_name'];
    }
    if (empty($_POST['adress']))
    {
        $errors['adress'] = "The field is empty!";
    }
    else
    {
        $adress = $_POST['adress'];
    }
    if (empty($_POST['phone_number']))
    {
        $errors['phone_number'] = "The field is empty!";
    }
    else
    {
        if(!preg_match('/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/', $_POST['phone_number']))
            $errors['phone_number'] = 'The input doesn\'t match a phone number';
        else
            $phone_number = $_POST['phone_number'];
    }
    if (empty($_POST['password']))
    {
        $errors['password'] = "The field is empty!";
    }
    else
    {
        $password = $_POST['password'];
    }
    if (empty($_POST['confirm_password']))
    {
        $errors['confirm_password'] = "The field is empty!";
    }
    else
    {
        if ($_POST['password'] != $_POST['confirm_password'])
            $errors['confirm_passwrd'] = "The password doesn't match";
    }
    if(array_filter($errors))
    {
        //echo 'errors in form';
    } else 
    {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $title = mysqli_real_escape_string($conn, $_POST['first_name']);
        $ingredients = mysqli_real_escape_string($conn, $_POST['last_name']);
        $ingredients = mysqli_real_escape_string($conn, $_POST['adress']);
        $ingredients = mysqli_real_escape_string($conn, $_POST['phone_number']);
        $ingredients = mysqli_real_escape_string($conn, $_POST['password']);

        // create sql
        $sql = "INSERT INTO users(firstname, lastname, email, adress, phonenumber, pass) VALUES('$first_name', '$last_name', '$email', '$adress', '$phone_number', '$password')";

        // save to db and check
        if(mysqli_query($conn, $sql)){
            // success
            header('Location: index.php');
        } else {
            echo 'query error: '. mysqli_error($conn);
        }
        
    }
}

?>
<!DOCTYPE HTML>
<html>
    <?php include 'Templates\header.php'; ?>
    <form action="registerpage.php" method="POST">
        <label> Email <br /> </label>
        <input type = "text" name = "email" value="<?php echo $email; ?>">
        <div id="error-text"> <?php echo $errors['email'] ?></div>
        <label> First Name <br /> </label>
        <input type = "text" name = "first_name" value="<?php echo $first_name; ?>">
        <div id="error-text"> <?php echo $errors['first_name'] ?></div>
        <label> Last Name <br /> </label>
        <input type = "text" name = "last_name"value="<?php echo $last_name; ?>">
        <div id="error-text"> <?php echo $errors['last_name'] ?></div>
        <label> Adress <br /> </label>
        <input type = "text" name = "adress" value="<?php echo $adress; ?>">
        <div id="error-text"> <?php echo $errors['adress'] ?></div>
        <label> Phone Number <br /> </label>
        <input type = "text" name = "phone_number" value="<?php echo $phone_number; ?>">
        <div id="error-text"> <?php echo $errors['phone_number'] ?></div>
        <label> Password <br /> </label>
        <input type = "password" name = "password" value="<?php echo $password; ?>">
        <div id="error-text"> <?php echo $errors['password'] ?></div>
        <label> Confirm Password <br /> </label>
        <input type = "password" name = "confirm_password" value="<?php echo $confirm_password; ?>">
        <div id="error-text"> <?php echo $errors['confirm_password'] ?></div>
        <input type = "submit" name = "submit" value = "Register">
    </form>
    <?php include 'Templates\footer.php'; ?>
    <script>
    document.querySelector(".logo").style.top = "180%";
    </script>
</html>