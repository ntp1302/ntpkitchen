<?php
require_once "inc/init.php";
require_once "class/Database.php";

$conn = new Database();
$pdo = $conn->getConnect();

if (!isset($_GET['cart_id'])) {
    echo "No cart ID specified!";
    exit();
}

$cart_id = intval($_GET['cart_id']);

// Lấy chi tiết giỏ hàng
$sql_cart_details = "SELECT ci.cart_item_id, p.name AS product_name, p.price, ci.quantity, (p.price * ci.quantity) AS total_price, p.image
                     FROM CartItems ci
                     JOIN Product p ON ci.product_id = p.product_id
                     WHERE ci.cart_id = :cart_id";
$stmt_cart_details = $pdo->prepare($sql_cart_details);
$stmt_cart_details->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
$stmt_cart_details->execute();
$cart_details = $stmt_cart_details->fetchAll(PDO::FETCH_ASSOC);

// Lấy thông tin giỏ hàng
$sql_cart_info = "SELECT * FROM Carts WHERE cart_id = :cart_id";
$stmt_cart_info = $pdo->prepare($sql_cart_info);
$stmt_cart_info->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
$stmt_cart_info->execute();
$cart_info = $stmt_cart_info->fetch(PDO::FETCH_ASSOC);
?>

<div class="wrapper">
    <?php require_once "inc/header2.php" ?>
    <div style="margin-top: -20px;border-top: 5px solid #009966">
        <div class="main">
            <div class="about_form">
                <h2>Chi tiết đơn hàng</h2>
                <p>Mã đơn hàng: <?= $cart_info['cart_id'] ?></p>
                <p>Tài khoản: <?= $cart_info['username'] ?></p>
                <p>Ngày lập: <?= $cart_info['created_at'] ?></p>
                <p>Tình trạng: <?= $cart_info['status'] == 1 ? 'Đã hoàn thành' : 'Chưa xác nhận' ?></p>

                <?php if (count($cart_details) > 0): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Ảnh sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá bán</th>
                                <th>Số lượng</th>
                                <th>Tổng tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cart_details as $item): ?>
                                <tr>
                                    <td><img src="img_product/<?= htmlspecialchars($item['image']) ?>" alt="Product Image" style="width:200px; height:180px"></td>
                                    <td><?= htmlspecialchars($item['product_name']) ?></td>
                                    <td><?= number_format($item['price'], 0, ',', '.') ?> VND</td>
                                    <td><?= htmlspecialchars($item['quantity']) ?></td>
                                    <td><?= number_format($item['total_price'], 0, ',', '.') ?> VND</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Không có sản phẩm nào trong đơn hàng.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php require_once 'inc/banner2.php';?>
    <?php require_once 'inc/footer.php';?>
</div>
