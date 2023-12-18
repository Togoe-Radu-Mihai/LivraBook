<?php
include '../Config/connect.php';

$nr_conturi = $nr_recenzii = $nr_cosuri = $nr_bani = 0;

$sql = "SELECT * FROM USERS";
$users = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);

$sql = "SELECT * FROM cart WHERE COMPLETED=1";
$carts = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);

$sql = "SELECT * FROM products";
$products = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);

$searchTerm = isset($_POST['search']) ? $_POST['search'] : '';
if (!empty($searchTerm)) {
    // Adjust your SQL query to include the search condition for title or author
    $sql = "SELECT * FROM PRODUCTS WHERE 
            TITLE LIKE '%$searchTerm%' OR
            AUTHOR LIKE '%$searchTerm%'";
    // Execute the query and fetch $products
    $result = mysqli_query($conn, $sql);
    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
}

$searchTerm = isset($_POST['searchaccounts']) ? $_POST['searchaccounts'] : '';
if (!empty($searchTerm)) {
    // Adjust your SQL query to include the search condition for title or author
    $sql = "SELECT * FROM USERS WHERE 
            USERNAME LIKE '%$searchTerm%' OR
            FULL_NAME LIKE '%$searchTerm%'";
    // Execute the query and fetch $products
    $result = mysqli_query($conn, $sql);
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
}


$sql = "SELECT * FROM reviews";
$recenzii = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);

$nr_conturi = sizeof($users);

foreach ($carts as $cart) {
    $x = $cart['PRODUCT_ID'];
    $nr_cosuri += $cart['QUANTITY'];
    $sql = "SELECT PRICE FROM PRODUCTS WHERE PRODUCT_ID = '$x'";
    $x = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);
    foreach ($x as $x1) {
        $nr_bani += doubleval($x1['PRICE']) * $cart['QUANTITY'];
        break;
    }
}

foreach ($recenzii as $recenzie) {
    if (intval($recenzie['RATING']) >= 3)
        $nr_recenzii++;
}

if (isset($_POST['DELETEACCOUNT']))
{
    $userid = $_GET['acc'];
    $sql = "DELETE FROM CART WHERE USER_ID = '$userid'";
    mysqli_query($conn, $sql);
    $sql = "DELETE FROM USERS WHERE USER_ID = '$userid'";
    if (mysqli_query($conn, $sql)) {
        header("Location:admin.php?editaccounts=1");
    }

}

if (isset($_POST['DELETEPRODUCT']))
{
    $PRODUCT_ID = $_GET['prd'];
    $sql = "DELETE FROM CART WHERE PRODUCT_ID = '$PRODUCT_ID'";
    mysqli_query($conn, $sql);
    $sql = "DELETE FROM PRODUCTS WHERE PRODUCT_ID = '$PRODUCT_ID'";
    if (mysqli_query($conn, $sql)) {
        header("Location:admin.php?editproducts=1");
    }

}

if (isset($_POST['edit'])) {
    $USERNAME = $_POST['USERNAME'];
    $FULL_NAME = $_POST['FULL_NAME'];
    $PASSWORD = $_POST['PASSWORD'];
    $BIRTH_DATE = $_POST['BIRTH_DATE'];
    $PHONE_NUMBER = $_POST['PHONE_NUMBER'];
    $EMAIL = $_POST['EMAIL'];
    $ADMIN = false;
    if (isset($_POST['ADMIN']))
        $ADMIN = true;
    $sql = "UPDATE USERS SET USERNAME='$USERNAME', FULL_NAME = '$FULL_NAME', PASSWORD = '$PASSWORD', BIRTH_DATE = '$BIRTH_DATE', PHONE_NUMBER = '$PHONE_NUMBER', EMAIL = '$EMAIL', IS_ADMIN = '$ADMIN' WHERE EMAIL = '$EMAIL'";
    mysqli_query($conn, $sql);
}

if (isset($_POST["editproducts"])) {

    $TITLE = $_POST['TITLE'];
    $AUTHOR = $_POST["AUTHOR"];
    $RELEASE_YEAR = $_POST["RELEASE_YEAR"];
    $PRICE = $_POST["PRICE"];
    $DESCRIPTION = $_POST["DESCRIPTION"];
    $CATEGORY = $_POST["CATEGORY"];


    $uploadDirectory = "../book_images/";  // Specify the directory where you want to store the uploaded images

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["PRODUCT_IMAGE"])) {
        $uploadedFile = $_FILES["PRODUCT_IMAGE"];
        $uploadedFileName = $uploadedFile["name"];

        $sql = "UPDATE PRODUCTS SET PRODUCT_IMAGE='book_images/$uploadedFileName' WHERE TITLE = '$TITLE' AND PRICE = '$PRICE'";
        mysqli_query($conn, $sql);
    }
    $TITLE = $_POST['TITLE'];
    $AUTHOR = $_POST["AUTHOR"];
    $RELEASE_YEAR = $_POST["RELEASE_YEAR"];
    $PRICE = $_POST["PRICE"];
    $DESCRIPTION = $_POST["DESCRIPTION"];
    $CATEGORY = $_POST["CATEGORY"];
    $prd = $_GET['prd'];
    $sql = "UPDATE PRODUCTS SET TITLE=?, AUTHOR=?, RELEASE_YEAR=?, PRICE=?, DESCRIPTION=?, CATEGORY=? WHERE PRODUCT_ID=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $TITLE, $AUTHOR, $RELEASE_YEAR, $PRICE, $DESCRIPTION, $CATEGORY, $prd);

    if ($stmt->execute()) {
        echo "Update successful";
        header("Location: admin.php?editproducts");
    } else {
        echo "Error updating record: " . $stmt->error;

    }

    $stmt->close();


}

if (isset($_POST["addprd"])) {
    $TITLE = $_POST['title'];
    $AUTHOR = $_POST["author"];
    $RELEASE_YEAR = $_POST["release_year"];
    $PRICE = $_POST["price"];
    $PUBLISHER = $_POST["publisher"];
    $DESCRIPTION = $_POST["description"];
    $CATEGORY = $_POST["category"];
    $uploadedFileName = "book_images/";
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["product_image"])) {
        $uploadedFile = $_FILES["product_image"];
        $uploadedFileName = $uploadedFileName . $uploadedFile["name"];
       

    }
    $sql = "INSERT INTO PRODUCTS(PRODUCT_IMAGE, TITLE, AUTHOR, RELEASE_YEAR, PRICE, DESCRIPTION, CATEGORY, PUBLISHER) 
    VALUES ('$uploadedFileName', '$TITLE', '$AUTHOR', '$RELEASE_YEAR', '$PRICE', '$DESCRIPTION', '$CATEGORY', '$PUBLISHER')";
   mysqli_query($conn, $sql);


}


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.css">
    <title>LivraBook Dashboard</title>
    <link href="admin.css" rel="stylesheet">
</head>

<body>

    <!-- Sidebar -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <a href="../index.php">
                <h3>LivraBook</h3>
            </a>
        </div>

        <ul class="list-unstyled components">
            <li>
                <a href="admin.php?performance=1"><i class="fas fa-chart-line mr-2"></i> Performance Status</a>
            </li>
            <li>
                <a href="#accounts"><i class="fas fa-users mr-2"></i> Accounts Management</a>
                <ul class="list-unstyled">
                    <li><a href="admin.php?editaccounts=1"><i class="fas fa-user-edit mr-2"></i> Edit Accounts</a></li>
                    
                </ul>
            </li>
            <li>
                <a href="#product-management"><i class="fas fa-book mr-2"></i> Product Management</a>
                <ul class="list-unstyled">
                    <li><a href="admin.php?addproducts=1"><i class="fas fa-plus mr-2"></i> Add Products</a></li>
                    <li><a href="admin.php?editproducts=1"><i class="fas fa-edit mr-2"></i> Edit Products</a></li>
                  
                </ul>
            </li>
        </ul>
    </nav>

    <?php if (isset($_GET["addproducts"])) { ?>
        <div class="addproduct">

            <form action="admin.php?addproducts" method="post" enctype="multipart/form-data" id="productForm">
                <label for="title" class="form-label">Title:</label>
                <input type="text" id="title" name="title" class="form-input" required>

                <label for="author" class="form-label">Author:</label>
                <input type="text" id="author" name="author" class="form-input" required>

                <label for="author" class="form-label">Publisher:</label>
                <input type="text" id="publisher" name="publisher" class="form-input" required>

                <label for="release_year" class="form-label">Release Year:</label>
                <input type="number" id="release_year" name="release_year" class="form-input" required>

                <label for="price" class="form-label">Price:</label>
                <input type="number" id="price" name="price" class="form-input" required>

                <label for="description" class="form-label">Description:</label>
                <textarea id="description" name="description" rows="4" class="form-input" required></textarea>

                <label for="category" class="form-label">Category:</label>
                <input type="text" id="category" name="category" class="form-input" required>

                <label for="product_image" class="form-label">Product Image:</label>
                <input type="file" id="product_image" name="product_image" accept="image/*" class="form-input" required>

                <input type="submit" name="addprd" class="form-button" value="Add Product"></button>
            </form>
        </div>
    <?php } ?>
    <?php if (isset($_GET['editproducts'])) { ?>

        <form action="admin.php?editproducts=1" method="POST" class="search-form">
        <label for="search">Search:</label>
        <input type="text" name="search" id="search">
        <button type="submit">Search</button>
    </form>
        <div class="producttable">
            <table>
                <thead>
                    <tr>
                        <th> Picture </th>
                        <th> Title </th>
                        <th> Author </th>
                        <th> Publisher </th>
                        <th> Price </th>
                        <th> Release Year </th>
                        <th> Category </th>
                        <th> Description </th>
                        <th> Save Changes </th>
                        <th> Delete Product </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product) {
                        $x = $product['PRODUCT_ID'] ?>
                        <tr>
                            <form class="accounteditor" enctype="multipart/form-data" action=<?php echo "admin.php?prd=" . $x; ?> method="POST">
                                <td id="product-image" style="display: flex; align-items: center;">
                                    <div style="margin-right: 10px;">
                                        <label for="fileInput"
                                            style="cursor: pointer;  background-color:#FF6659; padding: 6px 10px; color: #fff; border-radius: 5px;">
                                            Choose File
                                        </label>
                                        <input type="file" name="PRODUCT_IMAGE" id="fileInput" accept="image/*"
                                            style="display: none;">
                                        <!-- <span id="fileName" style="margin-left: 5px;"></span> -->
                                    </div>
                                    <div>
                                        <img src="<?php echo "../" . $product['PRODUCT_IMAGE'] ?>" width="50px" height="50px"
                                            style="border-radius: 5px;">
                                    </div>
                                </td>

                                <script>
                                    document.getElementById('fileInput').addEventListener('change', function () {
                                        var fileName = this.files[0].name;
                                        document.getElementById('fileName').textContent = fileName;
                                    });
                                </script>
                                <td>
                                    <input type="text" name="TITLE" value="<?php echo $product['TITLE'] ?>"> </input>
                                </td>
                                <td>
                                    <input type="text" name="AUTHOR" value="<?php echo $product['AUTHOR'] ?>"> </input>
                                </td>
                                <td>
                                    <input type="text" name="PUBLISHER" value="<?php echo $product['PUBLISHER'] ?>"> </input>
                                </td>
                                <td>
                                    <input type="text" name="PRICE" value="<?php echo $product['PRICE'] ?>"> </input>
                                </td>
                                <td>
                                    <input type="text" name="RELEASE_YEAR" value="<?php echo $product['RELEASE_YEAR'] ?>">
                                    </input>
                                </td>
                                <td>
                                    <input type="text" name="CATEGORY" value="<?php echo $product['CATEGORY'] ?>"> </input>
                                </td>
                                <td>
                                    <input type="text" name="DESCRIPTION" value="<?php echo $product['DESCRIPTION'] ?>">
                                    </input>
                                </td>
                                <td>
                                    <input type="submit" name="editproducts" value="EDIT" class="submitbtn"> </input>
                                </td>
                                <td>
                                <input type="submit" name="DELETEPRODUCT" value="DELETE" class="delete">
                                </td>
                            </form>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    <?php } ?>


    <?php if (isset($_GET['editaccounts'])) { ?>
        <form action="admin.php?editaccounts=1" method="POST" class="search-form">
        <label for="search">Search:</label>
        <input type="text" name="searchaccounts" id="search">
        <button type="submit">Search</button>
        <div class="accounttable">
            <table>
                <thead>
                    <tr>
                        <th> Username </th>
                        <th> Full Name </th>
                        <th> E-mail </th>
                        <th> Phone Number </th>
                        <th> Birth Date </th>
                        <th> Password </th>
                        <th> Admin </th>
                        <th> Save Changes </th>
                        <th> Delete Account </th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($users as $user) { ?>
                        <tr>
                            <form class="accounteditor" action="<?php echo "admin.php?acc=" . $user['USER_ID']?>" method="POST">
                                <td>
                                    <input type="text" name="USERNAME" value="<?php echo $user['USERNAME'] ?>"> </input>
                                </td>
                                <td>
                                    <input type="text" name="FULL_NAME" value="<?php echo $user['FULL_NAME'] ?>"> </input>
                                </td>
                                <td>
                                    <input disabled type="text" name="EMAIL" value="<?php echo $user['EMAIL'] ?>"> </input>
                                </td>
                                <td>
                                    <input type="text" name="PHONE_NUMBER" value="<?php echo $user['PHONE_NUMBER'] ?>"> </input>
                                </td>
                                <td>
                                    <input type="text" name="BIRTH_DATE" value="<?php echo $user['BIRTH_DATE'] ?>"> </input>
                                </td>
                                <td>
                                    <input type="text" name="PASSWORD" value="<?php echo $user['PASSWORD'] ?>"> </input>
                                </td>
                                <td>
                                    <?php if ($user['IS_ADMIN'] == true) { ?>
                                        <input type="checkbox" name="ADMIN" value="admin" checked />
                                    <?php } else { ?>
                                        <input type="checkbox" name="ADMIN" value="admin" unchecked />
                                    <?php } ?>
                                </td>
                                <td>
                                    <input type="submit" name="edit" value="EDIT" class="submitbtn">
                                </td>
                                <td>
                                    <input type="submit" name="DELETEACCOUNT" value="DELETE" class="delete">
                                </td>
                            </form>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    <?php } ?>
    <?php if (isset($_GET['performance'])) { ?>

        <div class="performance-indicator" id="conturi">
            <img src="../book_images/profile.png" title="user icon"> <!-- User icon created by Freepik -->
            <div class="indicator-content">
                <h1>Total Accounts Created</h1>
                <!-- Add your PHP code or static value below the h1, on the same line as the image -->
                <h5>
                    <?php echo $nr_conturi ?>
                </h5>
            </div>
        </div>

        <div class="performance-indicator" id="produse">
            <img src="../book_images/stack-of-books.png" title="user icon"> <!-- User icon created by Freepik -->
            <div class="indicator-content">
                <h1>Number of Sold Books</h1>
                <!-- Add your PHP code or static value below the h1, on the same line as the image -->
                <h5>
                    <?php echo $nr_cosuri ?>
                </h5>
            </div>
        </div>

        <div class="performance-indicator" id="bani">
            <img src="../book_images/money.png" title="user icon"> <!-- User icon created by vectorsmarket15 -->
            <div class="indicator-content">
                <h1>Total Amount Processed</h1>
                <!-- Add your PHP code or static value below the h1, on the same line as the image -->
                <h5>
                    <?php echo $nr_bani ?>
                    <h3>
            </div>
        </div>

        <div class="performance-indicator" id="recenzii">
            <img src="../book_images/sstar.png" title="user icon"> <!-- User icon created by Freepik -->
            <div class="indicator-content">
                <h1>Number of Positive Ratings</h1>
                <!-- Add your PHP code or static value below the h1, on the same line as the image -->
                <h5>
                    <?php echo $nr_recenzii ?>
                </h5>
            </div>
        </div>


    <?php } ?>


    <!-- Bootstrap Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>