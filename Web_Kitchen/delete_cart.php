<?php 
    require_once "inc/init.php";
    require_once "class/Database.php";
    require_once "class/Cart.php";

    $conn = new Database();
    $pdo = $conn->getConnect();

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (isset($_GET["id"])) {
            $cart_id = $_GET["id"];
        }
    }
    if(Cart::deleteCartByID($pdo, $cart_id))
        echo "<script>alert('Giỏ hàng đã được xóa!'); window.location.href='edit_user.php';</script>";
    else
        echo "<script>alert('Giỏ hàng có sản phẩm, không thể xóa!'); window.location.href='edit_user.php';</script>";
?>