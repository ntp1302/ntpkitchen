<?php
    class Cart {
        // Hàm lấy thông tin giỏ hàng dựa vào username
        public static function getCartByUsername($pdo, $username) {
            $stmt = $pdo->prepare("SELECT * FROM Carts WHERE username = :username");
            $stmt->execute(['username' => $username]);
            $cart = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($cart) {
                $stmt = $pdo->prepare("SELECT * FROM CartItems WHERE cart_id = :cart_id");
                $stmt->execute(['cart_id' => $cart['cart_id']]);
                $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $items;
            }
            return [];
        }

        // Hàm thêm sản phẩm vào giỏ hàng
        public static function addToCart($pdo, $username, $product_id, $quantity = 1) {
            // Kiểm tra xem giỏ hàng đã tồn tại chưa
            $stmt = $pdo->prepare("SELECT * FROM Carts WHERE username = :username");
            $stmt->execute(['username' => $username]);
            $cart = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$cart) {
                // Tạo giỏ hàng mới nếu chưa tồn tại
                $stmt = $pdo->prepare("INSERT INTO Carts (username, created_at) VALUES (:username, NOW())");
                $stmt->execute(['username' => $username]);
                $cart_id = $pdo->lastInsertId();
            } else {
                $cart_id = $cart['cart_id'];
            }

            // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
            $stmt = $pdo->prepare("SELECT * FROM CartItems WHERE cart_id = :cart_id AND product_id = :product_id");
            $stmt->execute(['cart_id' => $cart_id, 'product_id' => $product_id]);
            $cartItem = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($cartItem) {
                // Cập nhật số lượng nếu sản phẩm đã có trong giỏ hàng
                $stmt = $pdo->prepare("UPDATE CartItems SET quantity = quantity + :quantity WHERE cart_id = :cart_id AND product_id = :product_id");
                $stmt->execute(['quantity' => $quantity, 'cart_id' => $cart_id, 'product_id' => $product_id]);
            } else {
                // Thêm sản phẩm mới vào giỏ hàng
                $stmt = $pdo->prepare("INSERT INTO CartItems (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)");
                $stmt->execute(['cart_id' => $cart_id, 'product_id' => $product_id, 'quantity' => $quantity]);
            }
        }
        public static function deleteCartByID($pdo, $cart_id) {
            $sql_check_items = "SELECT COUNT(*) FROM CartItems WHERE cart_id = :cart_id";
            $stmt_check_items = $pdo->prepare($sql_check_items);
            $stmt_check_items->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
            $stmt_check_items->execute();
            $num_items = $stmt_check_items->fetchColumn();
        
            if ($num_items > 0) {
                return false;
            } else {
                // If the cart has no items, delete it
                $sql_delete_cart = "DELETE FROM carts WHERE cart_id = :cart_id";
                $stmt_delete_cart = $pdo->prepare($sql_delete_cart);
                $stmt_delete_cart->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
                if ($stmt_delete_cart->execute()) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }
?>
