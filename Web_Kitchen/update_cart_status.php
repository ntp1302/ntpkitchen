<?php
require_once "inc/init.php";
require_once "class/Database.php";

$conn = new Database();
$pdo = $conn->getConnect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cart_id = intval($_POST['cart_id']);
    $new_status = 1; // Đặt trạng thái mới là 1 (Đã hoàn thành)

    try {
        $sql = "UPDATE Carts SET status = :status WHERE cart_id = :cart_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':status', $new_status, PDO::PARAM_INT);
        $stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: order.php");
        exit();
    } catch (Exception $e) {
        echo "Failed: " . $e->getMessage();
    }
}
?>
