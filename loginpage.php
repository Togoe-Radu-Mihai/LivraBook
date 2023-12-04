<?php
include 'Config\connect.php';
$sql = 'SELECT* FROM users ORDER BY id';
$result = mysqli_query($conn, $sql);
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);
$email = $password = '';
$ok = 0;
$login_error = '';
$errors = ['email' => '', 'password' => ''];
if (isset($_POST) && isset($_POST['submit']))
{
    if (empty($_POST['email']))
        $errors['email'] = "The email field is empty";
    else
    {
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
            $errors['email'] = "You must introduce a valid email adress";
        else
        $email = $_POST['email'];
    }
    if (empty($_POST['password']))
        $errors['password'] = "The password field is empty";
    else
        $password = $_POST['password'];
    
    if (!array_filter($errors))
    {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
		$title = mysqli_real_escape_string($conn, $_POST['password']);
        $ok = 0;
        foreach ($users as $user)
        {
            if ($user['email'] == $email && $user['password'] = $password)
            {
                $_SESSION['userid'] = $user['ID'];
                $_SESSION['name'] = $user['firstname'];
                $ok = 1;
                break;
            }
        }
        if ($ok == 1)
            header('Location:index.php');
        else
            $login_error = 'The email and password do not match any account';
    }
    else
    {
        echo "<h1>AAAAAAAAAAAAAAAAAAA</h1>";
        echo 'errors in form';
    }
    mysqli_free_result($result);
}
?>
<!DOCTYPE HTML>
<html>
<?php include 'Templates\header.php'; ?>
        <form id = "login" action="loginpage.php" method="POST">
        <label for="email"> Your Email <br /> </label>
        <input  id = "email" type="text" name="email" value="<?php echo $email; ?>">
        <?php if ($ok == 1) ?>
        <div id="error-text"> <?php echo $errors['email'] ?></div>
        <br />
        <label for="password"> Password <br /> </label>
        <input id = "password" type="password" name="password" value="<?php echo $password; ?>" autocomplete="off">
        <div id="error-text"> <?php echo $errors['password'] ?></div>
        <br />
        <input type="submit" name="submit" value="login" autocomplete="off">
        <div id="error-text"> <?php echo $login_error ?></div>
        <h4> You don't have an account yet? </h4>
        <a class = "register" href="registerpage.php"> Register </a>
        </form>
<?php include 'Templates\footer.php'; ?>
</html>