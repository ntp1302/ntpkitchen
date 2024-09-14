<?php
    require_once "inc/init.php";
    require_once "class/Database.php";

    $conn = new Database();
    $pdo = $conn->getConnect();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $product_id = intval($_POST['product_id']);
        $quantity = intval($_POST['quantity']);
        $username = $_COOKIE['username']; 

        try {
            $pdo->beginTransaction();

            $sql = "SELECT cart_id FROM Carts WHERE username = :username AND status = 0";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            $cart = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$cart) {
                $sql = "INSERT INTO Carts (username, created_at) VALUES (:username, NOW())";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt->execute();
                $cart_id = $pdo->lastInsertId();
            } else {
                $cart_id = $cart['cart_id'];
            }

            $sql = "SELECT cart_item_id, quantity FROM CartItems WHERE cart_id = :cart_id AND product_id = :product_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->execute();
            $cart_item = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($cart_item) {
                $new_quantity = $cart_item['quantity'] + $quantity;
                $sql = "UPDATE CartItems SET quantity = :quantity WHERE cart_item_id = :cart_item_id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':quantity', $new_quantity, PDO::PARAM_INT);
                $stmt->bindParam(':cart_item_id', $cart_item['cart_item_id'], PDO::PARAM_INT);
                $stmt->execute();
            } else {
                $sql = "INSERT INTO CartItems (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
                $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
                $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
                $stmt->execute();
            }

            $pdo->commit();
            header("location: cart.php"); 
            exit();
        } catch (Exception $e) {
            $pdo->rollBack();
            echo "Failed: " . $e->getMessage();
        }
    }
?>
