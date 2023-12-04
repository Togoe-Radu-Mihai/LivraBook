<?php
include 'Config\connect.php';
$success = '';
$sql = 'SELECT* FROM products ORDER BY CATEGORY';
$result = mysqli_query($conn, $sql);
$produse = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_free_result($result);
if (isset($_GET['productID'])) {
    if ($_SESSION['userid'] != '0') {
        echo "GOOD";
        $userid = $_SESSION['userid'];
        $productid = $_GET['productID'];
        $cart_sql = "INSERT INTO cart(IDuser, IDproduct) VALUES('$userid', '$productid')";
        if (!mysqli_query($conn, $cart_sql))
            echo 'query error: ' . mysqli_error($conn);
        else {
            $success = "Product added successfully";
            header("Location: index.php");
        }
    }
}
?>
<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>LivraBook</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="home_page_style.css" rel="stylesheet" />
    <link href="home_page_style.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <style>
        .title-text {
            margin-top: 50px;
            font-family: 'Roboto', sans-serif;
            /* Choose an appropriate font */
            font-size: 36px;
            /* Adjust the font size as needed */
            font-weight: bold;
            /* Make the text bold */
            color: #333;
            /* Choose a suitable color */
            text-align: center;
            /* Center-align the text */
            margin-bottom: 20px;
            /* Add spacing below the title */
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            /* Add a subtle text shadow */
        }

        /* Optionally, you can add animation for a more dynamic effect */
        .title-text:hover {
            transform: scale(1.05);
            /* Scale the text on hover */
            transition: transform 0.3s ease-in-out;
            /* Add a smooth transition effect */
        }
        .hed
        {
            background-image: url("book_images\\head.jpg");
            background-repeat: no-repeat; 
            height: 500px;
            background-size: 100%;
        }
    </style>
</head>

<body>
    <?php include 'Templates\header.php'; ?>
    <!-- Header-->
    <header class="py-5 hed">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder" style="color: #3e2723; font-family: roboto;">LivraBook</h1>
                <p class="pText lead fw-normal mb-0"  style="color: #3e2723; font-family: roboto;">We love readin'</p>
            </div>
        </div>
    </header>

    <div class="title-text">
        <h1> Our most popular books </h1>
    </div>


    <!-- Section-->
    <section class="py-5">
        <div class="container  px-lg-5 mt-5">
            <h1> Fiction </h1>
        </div>
        <div class="container px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php 
                $var = 0;
                foreach ($produse as $produs): 
                    if ($produs['CATEGORY'] == "Fiction") {
                    if ($var < 16) $var++; else break;?>
                    
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            <img class="card-img-top" src="<?php echo $produs['PRODUCT_IMAGE']; ?>" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">
                                        <?php echo $produs['TITLE']; ?>
                                    </h5>
                                    <!-- Product price-->
                                    <p class="price">
                                        <?php echo $produs['PRICE'] . " lei"; ?>
                                    </p>
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center">
                                    <a class="btn btn-outline-dark" id="oringi" href=<?php echo "product_page.php?PRODUCT_ID=" . $produs['PRODUCT_ID'] ?>>View options</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } endforeach; ?>
            </div>
        </div>
        <div class="container  px-lg-5 mt-5">
            <h1> Psychology </h1>
        </div>
        <div class="container px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            <?php 
                $var = 0;
                foreach ($produse as $produs): 
                    if ($produs['CATEGORY'] == "psychology") {
                    if ($var < 16) $var++; else break;?>
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            <img class="card-img-top" src="<?php echo $produs['PRODUCT_IMAGE']; ?>" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">
                                        <?php echo $produs['TITLE']; ?>
                                    </h5>
                                    <!-- Product price-->
                                    <p class="price">
                                        <?php echo $produs['PRICE'] . " lei"; ?>
                                    </p>
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center">
                                    <a class="btn btn-outline-dark"  id="oringi" href=<?php echo "product_page.php?PRODUCT_ID=" . $produs['PRODUCT_ID'] ?>>View options</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } endforeach; ?>
            </div>
        </div>
        <div class="container  px-lg-5 mt-5">
            <h1> Children's Books </h1>
        </div>
        <div class="container px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            <?php 
                $var = 0;
                foreach ($produse as $produs): 
                    if ($produs['CATEGORY'] == "children") {
                    if ($var < 16) $var++; else break;?>
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            <img class="card-img-top" src="<?php echo $produs['PRODUCT_IMAGE']; ?>" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">
                                        <?php echo $produs['TITLE']; ?>
                                    </h5>
                                    <!-- Product price-->
                                    <p class="price">
                                        <?php echo $produs['PRICE'] . " lei"; ?>
                                    </p>
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center">
                                    <a class="btn btn-outline-dark"  id="oringi" href=<?php echo "product_page.php?PRODUCT_ID=" . $produs['PRODUCT_ID'] ?>>View options</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } endforeach; ?>
            </div>
        </div>
        
    </section>
    <!-- Footer-->
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>