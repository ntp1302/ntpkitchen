<?php
    require_once "inc/init.php";
    require_once "class/Database.php";

    if (!isset($_COOKIE['username'])) {
        header("location: login.php");
        exit();
    }

    $username = $_COOKIE['username'];

    $conn = new Database();
    $pdo = $conn->getConnect();

    // Begin a transaction
    $pdo->beginTransaction();

    try {
        $sql = "SELECT cart_id FROM Carts WHERE username = :username AND status = 0";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $cart = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cart) {
            $cart_id = $cart['cart_id'];

            // Update the cart status to 1 (checked out)
            $sql = "UPDATE Carts SET status = 2 WHERE cart_id = :cart_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
            $stmt->execute();

            // Commit the transaction
            $pdo->commit();

            // Redirect to a confirmation page or display a success message
            header("Location: checkout_success.php");
            exit();
        } else {
            throw new Exception("No active cart found for the user.");
        }
    } catch (Exception $e) {
        // Rollback the transaction in case of error
        $pdo->rollBack();
        echo "Failed to checkout: " . $e->getMessage();
    }
?>
