<?php
include 'Config\connect.php';

$success = '';
$search_term = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $search_term = mysqli_real_escape_string($conn, $_POST['search_term']);
    $search_option = mysqli_real_escape_string($conn, $_POST['search_option']);

    $sql = "SELECT * FROM PRODUCTS WHERE $search_option LIKE '%$search_term%' ORDER BY CATEGORY";
    $result = mysqli_query($conn, $sql);
    $produse = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_free_result($result);
} else {
    $sql = 'SELECT * FROM PRODUCTS ORDER BY CATEGORY';
    $result = mysqli_query($conn, $sql);
    $produse = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
}


if (isset($_GET['productID'])) {
    if ($_SESSION['userid'] != '0') {

        $userid = $_SESSION['userid'];
        $productid = $_GET['productID'];
        $completed = 0;
        $date = "";
        $AAA = $date;
        $cart_sql = "INSERT INTO cart(USER_ID, PRODUCT_ID, ORDER_DATE, COMPLETED) VALUES('$userid', '$productid', '$date', '$completed')";
        if (!mysqli_query($conn, $cart_sql))
            echo 'query error: ' . mysqli_error($conn);
        else {
            $success = "Product added successfully";
            header("Location: ..\products.php");
        }
    }
}


?>

<!DOCTYPE HTML>
<html>

<head>
    <link rel="stylesheet" href="product_style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.css">

</head>

<body>
    <?php include 'Templates\header.php'; ?>

    <!-- Fancy Search Bar -->
    <div class="container mt-3">
        <form method="POST" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control typeahead" name="search_term" placeholder="Search..."
                    style="width: 70%;">
                <select class="form-control" name="search_option" style="width: 20%;">
                    <option value="TITLE">Title</option>
                    <option value="AUTHOR">Author</option>
                    <option value="PUBLISHER">Publisher</option>
                    <option value="CATEGORY">Category</option>
                </select>
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" id="oringi" type="submit">Search</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Product Display -->
    <div class="container mt-3">
        <div class="row">
            <?php
            $count = 0;
            foreach ($produse as $produs):
                $count++;
                ?>
                                    <div class="col mb-5">
                        <div class="card h-100" style="max-width: 400px; max-height: 800px; margin: auto;">
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
                                    <a class="btn btn-outline-dark" id="oringi" href=<?php echo "product_page.php?PRODUCT_ID=" . $produs['PRODUCT_ID'] ?> >View Product</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php if ($count % 3 == 0): ?>
                </div>
                <div class="row">
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Typeahead and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

    <script>
        $(document).ready(function () {
            // Initialize Typeahead
            $('.typeahead').typeahead({
                source: function (query, process) {
                    return $.ajax({
                        url: 'autocomplete.php', // Replace with the endpoint for autocomplete
                        type: 'GET',
                        data: { query: query },
                        dataType: 'json',
                        success: function (data) {
                            return process(data);
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>