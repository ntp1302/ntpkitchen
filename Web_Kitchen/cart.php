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

    $sql = "SELECT ci.cart_item_id, p.name as product_name, p.price, 
            ci.quantity, (p.price * ci.quantity) as total_price, p.image, p.product_id as product_id
            FROM CartItems ci
            JOIN Carts c ON ci.cart_id = c.cart_id
            JOIN Product p ON ci.product_id = p.product_id
            WHERE c.username = :username and c.status = 0";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $total_amount = 0;
    foreach ($cart_items as $item) {
        $total_amount += $item['total_price'];
    }
?>

<div class="wrapper">
    <?php require_once "inc/header2.php" ?>
    <div style="margin-top: -20px;border-top: 5px solid #009966">
        <div class="main">
            <div class="card boder-dark" style="margin-top: 10px; padding: 20px; border-radius: 15px">
                <table class="boder-dark mx-3 mb-3 mt-3">
                    <thead>
                        <tr style="border-bottom:1px solid black">
                            <th colspan="5"><h3>Giỏ hàng của bạn</h3></th>
                            <th>
                                <a type="button" href="cart_history.php">Lịch sử mua hàng</a>
                            </th>
                            <th>
                                <a type="button" href="cart_wating.php">Đang xác nhận</a>
                            </th>
                        </tr>
                    </thead>
                </table>
                <?php if (count($cart_items) > 0): ?>
                    <table class="boder-dark mx-3 mb-3 mt-3">
                        <thead>
                            <tr height="20px"></tr>
                            <tr style="text-align:center">
                                <th>Ảnh sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá bán</th>
                                <th>Số lượng</th>
                                <th>Tổng tiền</th>
                                <th>Lựa chọn khác</th>
                            </tr>
                            <tr height="20px"></tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cart_items as $item): ?>
                                <tr style="text-align:center">
                                    <td><img src="img_product/<?= htmlspecialchars($item['image']) ?>" alt="Product Image" style="width:200px; height:180px"></td>
                                    <td><a href="product.php?id=<?= $item['product_id'] ?>"><?= htmlspecialchars($item['product_name']) ?></a></td>
                                    <td><?= number_format($item['price'], 0, ',', '.') ?> VND</td>
                                    <td><?= htmlspecialchars($item['quantity']) ?></td>
                                    <td><?= number_format($item['total_price'], 0, ',', '.') ?> VND</td>
                                    <td>
                                        <form action="remove_from_cart.php" method="post">
                                            <input type="hidden" name="cart_item_id" value="<?= $item['cart_item_id'] ?>">
                                            <input type="submit" class="btn btn-outline-danger mx-1" value="Xóa sản phẩm">
                                        </form>
                                    </td>
                                </tr>
                                <tr height="20px"></tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="total-amount">
                        <h4>Tổng thanh toán: <?= number_format($total_amount, 0, ',', '.') ?> VND</h4>
                    </div>
                    <div class="checkout">
                        <a href="checkout.php" class="btn btn-primary" style="background-color:#009966">Xác nhận đơn hàng</a>
                    </div>
                <?php else: ?>
                    <p>Giỏ hàng của bạn trống.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php require_once 'inc/banner2.php'?>
    <?php require_once 'inc/footer.php' ?>
</div>
