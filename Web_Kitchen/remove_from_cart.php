<?php
    require_once "inc/init.php";
    require_once "class/Database.php";
    $conn = new Database();
    $pdo = $conn->getConnect();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $cart_item_id = intval($_POST['cart_item_id']);

        try {
            $sql_check_empty = "SELECT COUNT(*) AS num_items FROM CartItems WHERE cart_id = (SELECT cart_id FROM CartItems WHERE cart_item_id = :cart_item_id)";
            $stmt_check_empty = $pdo->prepare($sql_check_empty);
            $stmt_check_empty->bindParam(':cart_item_id', $cart_item_id, PDO::PARAM_INT);
            $stmt_check_empty->execute();
            $num_items = $stmt_check_empty->fetchColumn();

            $sql_delete_item = "DELETE FROM CartItems WHERE cart_item_id = :cart_item_id";
            $stmt_delete_item = $pdo->prepare($sql_delete_item);
            $stmt_delete_item->bindParam(':cart_item_id', $cart_item_id, PDO::PARAM_INT);
            $stmt_delete_item->execute();

            if ($num_items == 1) {
                $sql_delete_cart = "DELETE FROM Carts WHERE cart_id = (SELECT cart_id FROM CartItems WHERE cart_item_id = :cart_item_id)";
                $stmt_delete_cart = $pdo->prepare($sql_delete_cart);
                $stmt_delete_cart->bindParam(':cart_item_id', $cart_item_id, PDO::PARAM_INT);
                $stmt_delete_cart->execute();
            }

            header("location: cart.php"); 
            exit();
        } catch (Exception $e) {
            echo "Failed: " . $e->getMessage();
        }
    }
?>