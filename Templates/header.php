<?php
$login = 'login';
if (isset($_SESSION['userid'])) {
  $login = 'logout';
}
if (isset($_GET['logout'])) {
  echo "123123";
  $_SESSION['userid'] = '0';
  $_SESSION['username'] = '0';
  header("Location:loginpage.php");
}
?>

<head>
  <!-- <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8"> -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <style>
            #oringi
        {
            color: white;
            background-color: #E7473C;
            border: none;
        }
        #oringi:hover
        {
            background-color: #FF6659;
        }
        </style>

  <title>Online Bookstore</title>
  <style>
  
    body {
      background: #eee;
      background-color: #DDD0C8;
      
    }
    a, a:hover, a:focus, a:active {
      text-decoration: none;
      color: inherit;
 }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark text-white" style= "background-color: #E7473C; color: white;">
    <div class="container">
      <a class="navbar-brand text-white" href="../index.php">LivraBook</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link text-white" href="..\index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="..\products.php">Books</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="..\aboutus.php">About Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="..\Contact\contact.php">Contact Us</a>
          </li>
          <?php if ($_SESSION['userid'] == '0') {
            echo '<a class="nav-link text-white" href="..\Login\loginpage.php">Log In</a>';
          } else {
            echo '<a class="nav-link text-white" href="..\Login\loginpage.php?logout=1">Log Out</a>';

          }
          ?>
          </li>
          <?php if ($_SESSION['userid'] == '0') {
            echo '<a class="nav-link text-white" href="\Login\registerpage.php">Register</a>';
          } else {
           
            echo '<a class="nav-link text-white" href="..\Login\account.php">Account</a>';

          }
          ?>
          </li>
          <?php if ($_SESSION['userid'] != '0') { ?>
            <li class="nav-item">
              <a class="nav-link" href="..\shopping_cart\cart.php"><img src="..\cart.png" width="24px" height="24px">
                </img></a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="..\shopping_cart\purchasehistory.php"> Purchase History </a>
            </li>
          <?php } ?>
          <?php if ($_SESSION['userid'] != '0' && isset($_SESSION['admin']) && $_SESSION['admin'] == 1) { ?>
            <li class="nav-item">
              <a class="nav-link text-white" href="../adminpannel/admin.php">Dashboard </a>
            </li>
            <?php } ?>
        </ul>

      </div>
    </div>
  </nav>

  <!-- Add the rest of your content here -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>