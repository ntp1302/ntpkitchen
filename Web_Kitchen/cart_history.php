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
            ci.quantity, (p.price * ci.quantity) as total_price, p.image, 
            p.product_id as product_id, c.created_at as created_at
            FROM CartItems ci 
            JOIN Carts c ON ci.cart_id = c.cart_id
            JOIN Product p ON ci.product_id = p.product_id
            WHERE c.username = :username and c.status = 1";

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
            
                <?php if (count($cart_items) > 0): ?>
                    <table class="boder-dark mx-3 mb-3 mt-3">
                        <thead>
                            <tr style="border-bottom:1px solid black">
                                <th colspan="6"><h3>Lịch sử mua hàng</h3></th>
                                <th>
                                    <a type="button" class="btn btn-primary" href="allproduct.php">Mua hàng</a>
                                </th>
                            </tr>
                            <tr height="20px"></tr>
                            <tr style="text-align:center">
                                <th>Ảnh sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá bán</th>
                                <th>Số lượng</th>
                                <th>Tổng tiền</th>
                                <th>Ngày mua hàng</th>
                                <th>Lựa chọn khác</th>
                            </tr>
                            <tr height="20px"></tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cart_items as $item): ?>
                                <tr style="text-align:center">
                                    <td><img src="img_product/<?= htmlspecialchars($item['image']) ?>" alt="Product Image" style="width:100px; height:80px"></td>
                                    <td><a href="product.php?id=<?= $item['product_id'] ?>"><?= htmlspecialchars($item['product_name']) ?></a></td>
                                    <td><?= number_format($item['price'], 0, ',', '.') ?> VND</td>
                                    <td><?= htmlspecialchars($item['quantity']) ?></td>
                                    <td><?= number_format($item['total_price'], 0, ',', '.') ?> VND</td>
                                    <td><?= htmlspecialchars($item['created_at']) ?></td>
                                    <td>
                                        <form action="remove_from_cart.php" method="post">
                                            <a type="button" class="btn btn-outline-success mx-1" href="product.php?id=<?=$item["product_id"]?>">Mua lại</a>
                                        </form>
                                    </td>
                                </tr>
                                <tr height="20px"></tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Quý khách chưa có lịch sử mua hàng.</p>
                <?php endif; ?>
                <div class="checkout">
                    <a href="cart.php" class="btn btn-primary">Quay lại</a>
                </div>
            </div>
        </div>
    </div>
    <?php require_once 'inc/banner2.php'?>
    <?php require_once 'inc/footer.php' ?>
</div>
