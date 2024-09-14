<?php
    require_once "inc/init.php";
    require_once "class/Database.php";

    $conn = new Database();
    $pdo = $conn->getConnect();

    // Lấy tất cả các giỏ hàng đang chờ xác nhận
    $sql_pending_carts = "SELECT * FROM Carts WHERE status = 2";
    $stmt_pending_carts = $pdo->query($sql_pending_carts);
    $pending_carts = $stmt_pending_carts->fetchAll(PDO::FETCH_ASSOC);

    // Lấy tất cả các giỏ hàng đã thanh toán
    $sql_completed_carts = "SELECT * FROM Carts WHERE status = 1";
    $stmt_completed_carts = $pdo->query($sql_completed_carts);
    $completed_carts = $stmt_completed_carts->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="wrapper">
    <?php require_once "inc/header2.php" ?>
    <div style="margin-top: -20px;border-top: 5px solid #009966">
        <div class="main">
            <div class="about_form">
                <h2>Đơn hàng</h2>
                <ul class="nav nav-tabs" id="orderTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pending-tab" data-toggle="tab" href="#pending" role="tab" aria-controls="pending" aria-selected="true">Chưa xác nhận</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="completed-tab" data-toggle="tab" href="#completed" role="tab" aria-controls="completed" aria-selected="false">Đã xác nhận/Thanh toán</a>
                    </li>
                </ul>

                <div class="tab-content" id="orderTabsContent">
                    <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                        <?php if (count($pending_carts) > 0): ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Mã đơn hàng</th>
                                        <th>Tài khoản</th>
                                        <th>Ngày lập</th>
                                        <th>Tình trạng</th>
                                        <th>Tùy chỉnh</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pending_carts as $cart): ?>
                                        <tr>
                                            <td><a href="order_details.php?cart_id=<?= $cart['cart_id'] ?>"><?= $cart['cart_id'] ?></a></td>
                                            <td><?= $cart['username'] ?></td>
                                            <td><?= $cart['created_at'] ?></td>
                                            <td>Chưa xác nhận</td>
                                            <td>
                                                <form method="post" action="update_cart_status.php">
                                                    <input type="hidden" name="cart_id" value="<?= $cart['cart_id'] ?>">
                                                    <button type="submit" class="btn btn-outline-success mx-1">Xác nhận</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p>Không có đơn hàng nào</p>
                        <?php endif; ?>
                    </div>
                    <div class="tab-pane fade" id="completed" role="tabpanel" aria-labelledby="completed-tab">
                        <?php if (count($completed_carts) > 0): ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Mã đơn hàng</th>
                                        <th>Tài khoản</th>
                                        <th>Ngày lập</th>
                                        <th>Tình trạng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($completed_carts as $cart): ?>
                                        <tr>
                                            <td><a href="order_details.php?cart_id=<?= $cart['cart_id'] ?>"><?= $cart['cart_id'] ?></a></td>
                                            <td><?= $cart['username'] ?></td>
                                            <td><?= $cart['created_at'] ?></td>
                                            <td>Đã hoàn thành</td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p>Không có đơn hàng nào.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once 'inc/banner2.php';?>
    <?php require_once 'inc/footer.php';?>
</div>
