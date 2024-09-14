<?php
    require_once "inc/init.php";
    require_once "class/Database.php";

    // Kiểm tra xem người dùng đã đăng nhập hay chưa
    if (!isset($_COOKIE['username'])) {
        header("location: login.php");
        exit();
    }

    $conn = new Database();
    $pdo = $conn->getConnect();
    $cart_id = null;

    // Lấy thông tin về cart_id từ URL
    if (isset($_GET['cart_id'])) {
        $cart_id = intval($_GET['cart_id']);
    } else {
        echo "<script>alert('Không tìm thấy mã giỏ hàng!'); window.location.href='edit_user.php';</script>";
        exit();
    }

    // Truy vấn để lấy thông tin về giỏ hàng dựa trên cart_id
    $sql = "SELECT ci.cart_item_id as id, p.product_id as product_id, p.name as product_name, p.price as price, ci.quantity as quantity, (p.price * ci.quantity) as total_price, p.image as p_image
            FROM CartItems ci
            JOIN Product p ON ci.product_id = p.product_id
            WHERE ci.cart_id = :cart_id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
    $stmt->execute();
    $cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Tính tổng số tiền trong giỏ hàng
    $total_amount = 0;
    foreach ($cart_items as $item) {
        $total_amount += $item['total_price'];
    }
?>

<div class="wrapper">
    <?php require_once "inc/header2.php" ?>
    <div style="margin-top: -20px;border-top: 5px solid #009966">
        <div class="main">
            <div class="edit_product">
                <h3>Giỏ hàng của người dùng với mã giỏ hàng <?= $cart_id ?></h3>
                <?php if (count($cart_items) > 0): ?>
                    <table class="table table-hover">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">Mã giỏ hàng</th>
                                <th scope="col">Ảnh sản phẩm</th>
                                <th scope="col">Tên sản phẩm</th>
                                <th scope="col">Giá bán</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col">Tổng tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cart_items as $item) : ?>
                                <tr class="text-center">
                                    <th scope="row"><?= $item['id'] ?></th>
                                    <td><img src="img_product/<?= htmlspecialchars($item['p_image']) ?>" alt="Product Image" style="width:100px; height:90px"></td>
                                    <td><a href="product.php?id=<?= $item['product_id'] ?>"><?= htmlspecialchars($item['product_name']) ?></a></td>
                                    <td><?= number_format($item['price'], 0, ',', '.') ?> VND</td>
                                    <td><?= htmlspecialchars($item['quantity']) ?></td>
                                    <td><?= number_format($item['total_price'], 0, ',', '.') ?> VND</td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                    <div class="total-amount">
                        <h4>Tổng thanh toán: <?= number_format($total_amount, 0, ',', '.') ?> VND</h4>
                    </div>
                <?php else: ?>
                    <p>Giỏ hàng của người dùng với mã giỏ hàng <?= $cart_id ?> trống.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php require_once 'inc/banner2.php' ?>
    <?php require_once 'inc/footer.php' ?>
</div>
