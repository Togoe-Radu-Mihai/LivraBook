<?php
    include 'Config\connect.php';
    if (isset($_POST["submit"])) {
        $rating = $_POST["rating"];
        $comment = $_POST["comment"];
        $username = $_SESSION["username"];
        $productid = $_POST["product_id"];
        $userid = $_SESSION["userid"];
        echo $userid;
        $sql = "INSERT INTO REVIEWS(USER_ID, USERNAME, PRODUCT_ID, RATING ,COMMENT)  VALUES ('$userid', '$username', '$productid', '$rating', '$comment')";
        $result = mysqli_query($conn, $sql);
        if ($result)
        {
            header("Location:product_page.php?PRODUCT_ID=$productid");
        }
        
    }

?>