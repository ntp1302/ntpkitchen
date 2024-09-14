<?php 
    require_once "inc/init.php";
    require_once "class/Database.php";
    require_once "class/Product.php";

    $conn = new Database();
    $pdo = $conn->getConnect();

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (isset($_GET["id"])) {
            $product_id = $_GET["id"];
        }
    }
    if(Product::deleteProductByID($pdo, $product_id))
        header("location: edit_product.php");
    else
        echo "<script>alert('Có lỗi xảy ra, không thể xóa!'); window.location.href='edit_product.php';</script>";
?>