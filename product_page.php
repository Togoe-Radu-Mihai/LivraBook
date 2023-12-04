<?php
include 'Config\connect.php';

$AAA = 'no';
$product_id = mysqli_real_escape_string($conn, $_GET['PRODUCT_ID']);
$sql = "SELECT * FROM PRODUCTS WHERE PRODUCT_ID = '$product_id'";
$result = mysqli_query($conn, $sql);
$produse = mysqli_fetch_all($result, MYSQLI_ASSOC);


if (!empty($produse)) {
    $p = $produse[0];
} else {
    echo "Error: Product not found.";
}

if (isset($_GET['productID'])) {
    if ($_SESSION['userid'] != '0') {
        $userid = $_SESSION['userid'];
        $productid = $_GET['productID'];
        $completed = 0;
        $date = date("Y-m-d");
        $AAA = $date;
        $cart_sql = "INSERT INTO cart(USER_ID, PRODUCT_ID, ORDER_DATE, COMPLETED) VALUES('$userid', '$productid', '$date', '$completed')";
        if (!mysqli_query($conn, $cart_sql))
            echo 'query error: ' . mysqli_error($conn);
        else {
            $success = "Product added successfully";
            $str = "Location: product_page.php?PRODUCT_ID=" . $_GET['PRODUCT_ID'] . "&success=1";
            header($str);
        }
    }
}

$message = "";

if (isset($_GET['success'])) {
    $message = "Product added to cart";
}

// Function to display user ratings
function displayUserRatings($conn, $product_id)
{
    $ratings_sql = "SELECT * FROM reviews WHERE PRODUCT_ID = '$product_id'";
    $ratings_result = mysqli_query($conn, $ratings_sql);
    $ratings = mysqli_fetch_all($ratings_result, MYSQLI_ASSOC);

    foreach ($ratings as $rating) {
        ?>
        <div class="card user-rating mb-3">
            <div class="card-body">
                <h5 class="card-title">Username: <?php echo $rating['USERNAME']; ?></h5>
                <p class="card-text"><strong>Rating:</strong> <?php
                    $i = 0;
                    for ($i = 0; $i <  $rating['RATING']; $i++)
                    echo '<img src="..\book_images\star.png" width="10px" height="10px">';
                ?> </p>
                <p class="card-text"><strong>Comment:</strong> <?php echo $rating['COMMENT']; ?></p>
            </div>
        </div>
        <?php
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .product-container {
            margin-top: 50px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            max-width: 800px;
            overflow: hidden;
            margin-bottom: 50px;
        }

        .product-image {
            max-width: 100%;
            border-radius: 10px 10px 0 0;
            overflow: hidden;
        }

        .product-image img {
            width: 100%;
            height: auto;
            transition: transform 0.3s ease-in-out;
        }

        .product-image img:hover {
            transform: scale(1.2);
        }

        .product-info {
            padding: 20px;
        }

        .product-info h2 {
            color: #343a40;
        }

        .product-info p {
            color: #6c757d;
        }

        .product-info strong {
            color: #495057;
        }

        .product-info button {
            background-color: #E7473C;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        .orange {
            background-color: #FF6659;
        }

        .orange:hover {
            background-color: #FF6659;
        }

        .product-info button:hover {
            background-color: #FF6659;
        }

        .ratings-section {
            margin-top: 20px;
        }

        .user-rating {
            margin-bottom: 20px;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 10px;
        }

        .user-rating p {
            margin: 5px 0;
        }

        .card {
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 0.25rem;
        }

        .card-body {
            padding: 1.25rem;
        }

        .card-title {
            font-size: 1.25rem;
            margin-bottom: 0.75rem;
        }

        .card-text {
            margin-bottom: 0.5rem;
        }

        a,
        a:hover,
        a:focus,
        a:active {
            color: white;
            text-decoration: none;
            color: inherit;
        }

        .add-review-form {
            margin-top: 20px;
            border-top: 1px solid #dee2e6;
            padding-top: 20px;
        }

        .add-review-form h3 {
            color: #343a40;
        }

        .add-review-form form {
            max-width: 600px;
            margin-top: 20px;
        }

        .add-review-form form label {
            font-weight: bold;
            color: #495057;
        }

        .add-review-form form button {
            background-color: #E7473C;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        .add-review-form form button:hover {
            background-color: #FF6659;
        }

        .text-success {
            color: #28a745;
        }

        /* Responsive Styling */
        @media (max-width: 768px) {
            .product-container {
                margin-top: 20px;
            }

            .product-info {
                padding: 10px;
            }

            .product-info button {
                padding: 8px 16px;
            }
        }
    </style>
    <title>Bookstore - Product Page</title>
</head>

<body>
    <?php include 'Templates\header.php'; ?>

    <div class="container product-container" style="padding-left: 20px; padding-top:20px;">
        <div class="row">
            <div class="col-md-4 product-image">
                <img src="<?php echo $p['PRODUCT_IMAGE'] ?>" class="img-fluid" alt="Book Cover" data-toggle="modal" data-target="#zoomModal">
                <!-- Zoom Modal -->
                <div class="modal fade" id="zoomModal" tabindex="-1" role="dialog" aria-labelledby="zoomModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <img src="<?php echo $p['PRODUCT_IMAGE'] ?>" class="img-fluid" alt="Book Cover">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 product-info">
                <h2><?php echo $p['TITLE'] ?></h2>
                <p><strong>Author:</strong> <?php echo $p['AUTHOR'] ?></p>
                <p><strong>Publisher:</strong> <?php echo $p['PUBLISHER'] ?></p>
                <p><strong>Release Date:</strong> <?php echo $p['RELEASE_YEAR'] ?></p>
                <p><strong>Description:</strong><br><?php echo $p['DESCRIPTION'] ?></p>
                <p><strong>Category:</strong><br><?php echo $p['Category'] ?></p>
                <p><strong>Price:</strong> <?php echo $p['PRICE'] ?> LEI</p>
           
                    <?php if ($p['STOC'] <= '0') 
                    { echo "<h1 class='text-danger'> PRODUCT OUT OF STOCK </h1>";} else 
                    {echo " <a href=" . "product_page.php?productID=" . $p['PRODUCT_ID'] . "&PRODUCT_ID=" . $_GET['PRODUCT_ID'] . "<button class='btn btn-primary'>Add to Cart</button>" ."</a>";}
                    ?>
                
                <p class="text-success"><?php echo $message; ?></p>
            </div>
        </div>

        <!-- Add Review Form -->
        <?php if ($_SESSION['userid'] != '0') : ?>
            <div class="add-review-form">
                <h3>Add Your Review</h3>
                <form action="add_review.php" method="post">
                    <div class="form-group">
                        <label for="rating">Rating (1-5):</label>
                        <input type="number" name="rating" class="form-control" min="1" max="5" required>
                    </div>
                    <div class="form-group">
                        <label for="comment">Comment:</label>
                        <textarea name="comment" class="form-control" rows="3" required></textarea>
                    </div>
                    <input type="hidden" name="product_id" value="<?php echo $_GET['PRODUCT_ID']; ?>">
                    <button type="submit" name="submit" class="btn orange">Submit Review</button>
                </form>
            </div>
        <?php endif; ?>

        <!-- Ratings Section -->
        <div class="ratings-section">
            <h3>User Ratings</h3>
            <?php displayUserRatings($conn, $product_id); ?>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>