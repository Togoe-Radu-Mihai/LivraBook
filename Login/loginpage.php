<?php
include '..\Config\connect.php';
$sql = 'SELECT* FROM users ORDER BY USER_ID';
$result = mysqli_query($conn, $sql);
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);
$email = $password = '';
$ok = 0;
$login_error = '';
$errors = ['email' => '', 'password' => ''];

/* foreach ($users as $user)
{
	echo $user['email'] .''. $user['pass'] .'';
} */



if (isset($_POST) && isset($_POST['submit'])) {
	if (empty($_POST['email']))
		$errors['email'] = "The email field is empty";
	else {
		if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
			$errors['email'] = "You must introduce a valid email adress";
		else
			$email = $_POST['email'];
	}
	if (empty($_POST['password']))
		$errors['password'] = "The password field is empty";
	else
		$password = $_POST['password'];

	if (!array_filter($errors)) {
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$title = mysqli_real_escape_string($conn, $_POST['password']);
		$ok = 0;
		foreach ($users as $user) {
			if ($user['EMAIL'] == $email && $user['PASSWORD'] = $password) {
				$_SESSION['userid'] = $user['USER_ID'];
				$_SESSION['username'] = $user['USERNAME'];
				$_SESSION['birthdate'] = $user['BIRTH_DATE'];
				$_SESSION['email'] = $user['EMAIL'];
				$_SESSION['passwrd'] = $user['PASSWORD'];
				$_SESSION['fullname'] = $user['FULL_NAME'];
				$_SESSION['phonenumber'] = $user['PHONE_NUMBER'];
				$ok = 1;
				break;
			}
		}
		if ($ok == 1) {
			header('Location:..\index.php');
		} else
			$login_error = 'The email and password do not match any account';
	} else
		echo 'errors in form';
	mysqli_free_result($result);
}
?>




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
</head>
<?php include '..\Templates\header.php'; ?>

<body style="background-color: #666666;">
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" action="\Login\loginpage.php" method="POST">
					<span class="login100-form-title p-b-43">
						Login to continue
					</span>


					<div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="email" value="">
						<span class="focus-input100"></span>
						<span class="label-input100">Email</span>
					</div>


					<div class="wrap-input100 validate-input" data-validate="Password is required">
						<input class="input100" type="password" name="password" value="">
						<span class="focus-input100"></span>
						<span class="label-input100">Password</span>
					</div>

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
						<button class="login100-form-btn" id="oringi" style="background-color:red;" name="submit">
							Login
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