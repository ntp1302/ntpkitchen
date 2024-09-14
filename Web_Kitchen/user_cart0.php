
<?php
    require_once "inc/init.php";
    require_once "class/Database.php";

    if (!isset($_COOKIE['username'])) {
        header("location: login.php");
        exit();
    }
    $conn = new Database();
    $pdo = $conn->getConnect();
    $user = null;
    // Lấy thông tin về người dùng từ URL
    if (isset($_GET['username'])) {
        $user = urldecode($_GET['username']);
    } else {
        header("location: edit_user.php");
        exit();
    } 
    
    $sql = "SELECT c.cart_id as id, created_at, status
            FROM Carts c
            WHERE c.username = :username";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $user, PDO::PARAM_STR);
    $stmt->execute();
    $carts = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="wrapper">
    <?php require_once "inc/header2.php" ?>
    <div style="margin-top: -20px;border-top: 5px solid #009966">
        <div class="main">
            <div class="edit_product">
                <h3>Giỏ hàng của <?= $user ?></h3>
                <?php if (count($carts) > 0): ?>
                    <table class="table table-hover">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">Mã giỏ hàng</th>
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Tình trạng</th>
                                <th scope="col">Chi tiết</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($carts as $item) : ?>
                                <tr class="text-center">
                                    <th scope="row"><?= $item['id'] ?></th>
                                    <td><?= $item['created_at'] ?></td>
                                    <?php if ($item['status'] == 1): ?>
                                        <td>Đơn đã hoàn thành</td>
                                    <?php else : ?>
                                        <td>Đơn chưa hoàn thành</td>
                                    <?php endif ?>
                                    <td>
                                        <a type="button" class="btn btn-outline-success mx-1" href="user_cart.php?cart_id=<?= $item['id'] ?>">
                                            <img src="img/cart.png" alt="gh" width="30px">
                                        </a>
                                        <a type="button" class="btn btn-outline-danger mx-1" onclick="confirmDelete(<?= $item['id'] ?>)">Xóa</a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Tài khoản <?= $user ?> chưa có giỏ hàng.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php require_once 'inc/banner2.php' ?>
    <?php require_once 'inc/footer.php' ?>
</div>
<script>
    function confirmDelete(user_id) {
        if (confirm("Xác nhận xóa tài khoản này?")) {
            window.location.href = "delete_cart.php?id=" + user_id;
        }
    }
</script>