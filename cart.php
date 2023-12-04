<?php
    include "Config\connect.php";
    if (isset($_SESSION['userid']))
    {
    $user_id = $_SESSION['userid'];
    $sql = "SELECT * FROM cart WHERE IDuser = '$user_id'";
    $result = mysqli_query($conn, $sql);
    $carts = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $deleted_cart = 0;
    if (isset($_GET['colID']))
    {
        foreach ($carts as $cart)
        {
            if ($cart['IDuser'] == $_SESSION['userid'] && $cart['IDproduct'] == $_GET['colID'])
            {
                $deleted_cart = $cart['ID'];
                break;
            }
        }
        $sql= "DELETE FROM cart WHERE ID = '$deleted_cart'";
        $result = mysqli_query($conn, $sql);
        if ($result)
            header('Location:cart.php');
        else
            echo "noob";
    }
    if (isset($_GET['checkout']))
    {
        $userid = $_SESSION['userid'];
        $sql= "DELETE FROM cart WHERE IDuser = '$userid'";
        $result = mysqli_query($conn, $sql);
        if ($result)
            header('Location:cart.php');
        else
            echo "noob";
    }
}
?>
<!DOCTYPE HTML>
<html>
    <?php include "Templates/header.php"; ?>
    <?php if (!isset($_SESSION['userid'])): ?>
        <div class = "cartempty">
        <h1> You are not signed in! </h1>
        </div>
    <?php else: ?>
    <?php if (sizeof($carts) == 0): ?>
        <div class = "cartempty">
            <h1> Your cart is empty! </h1>
        </div>
    <?php else: 
    $id_produse[] = array();
    foreach ($carts as $cart)
        array_push($id_produse, $cart['IDproduct']);
    $ids = join(',', array_map('intval', $id_produse));
    $produs_sql = "SELECT * from products WHERE ID in ($ids)";
    $r = mysqli_query($conn, $produs_sql);
    $produse = mysqli_fetch_all($r, MYSQLI_ASSOC); ?>
<table class="cart-products-table">
    <?php foreach ($produse as $produs): ?>
    <tr>
        <td><img src=<?php echo $produs['imagelocation'];?> alt="Laptop"></td>
        <td><?php echo $produs['name'] ?> </td>
        <td><?php echo $produs['price'] ?> </td>
        <td>
            <?php $cart_delete = "cart.php?colID=" . $produs["ID"]; ?>
            <a href = <?php echo $cart_delete; ?>>
            <button class = "add-to-cart" style="background-color: red">-</button>
        </a>
        </td>
    </tr>
    <?php endforeach;?>
</table>
            <div class="checkout">
            <?php $checkout = "cart.php?checkout=1"; ?>
            <a href = <?php echo $checkout; ?>>
            <button class = "add-to-cart" style="background-color: blue">Checkout</button> 
            </div>
    <?php endif ?>
    <?php endif ?>
    </body>
</html>

