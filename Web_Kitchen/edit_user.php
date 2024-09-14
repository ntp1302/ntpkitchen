
<?php
    require_once "inc/init.php";
    require_once "class/Database.php";
    require_once "class/User.php";

    $page = 1;
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (isset($_GET["page"])) {
            $page = $_GET["page"];
        }
    }

    $conn = new Database();
    $pdo = $conn->getConnect();

    $sql = "SELECT COUNT(*) as total_users FROM Users";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $totalUsers = intval($result['total_users']); 

    $userPerPage = 5;
    $totalPage = $totalUsers / $userPerPage + 1;

    $limit = $userPerPage;
    $offset = ($page - 1) * $userPerPage;

    $sql = "SELECT * FROM Users ORDER BY user_id ASC 
            LIMIT ".$limit." OFFSET ".$offset;
    $stmt = $pdo->prepare($sql);

    $data = null;
    if ($stmt->execute()) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
?>
<div class="wrapper">
    <?php require_once "inc/header2.php"; ?>
    <div style="margin-top: -20px;border-top: 5px solid #009966">
        <div class="main">            
            <div class="edit_product">
                    
                <table class="table table-hover">
                    <thead>
                        <h3>Danh sách tài khoản</h3>
                        <tr class="text-center">
                            <th scope="col">Mã</th>
                            <th scope="col">Tên đăng nhập</th>
                            <th scope="col">Email</th>
                            <th scope="col">Họ và tên</th>
                            <th scope="col">Địa chỉ</th>
                            <th scope="col">Số điện thoại</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Tùy chỉnh</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $user) : ?>
                            <tr class="text-center">
                                <th scope="row"><?= $user['user_id'] ?></th>
                                <td><a href="user_cart0.php?username=<?= $user['username'] ?>"><?= $user['username'] ?></a></td>
                                <td><?= $user['email'] ?></td>
                                <td><?= $user['full_name'] ?></td>
                                <td><?= $user['address'] ?></td>
                                <td><?= $user['phone'] ?></td>
                                <td><?= $user['create_at'] ?></td>
                                <?php if($user['username'] == "phatadmin") : ?>
                                    <td style="display: flex; flex-wrap: wrap">
                                        <a type="button" class="btn btn-outline-success mx-1" href="update_user.php?id=<?=$user["user_id"]?>">Chỉnh sửa</a>
                                    </td>
                                <?php else: ?>
                                    <td style="display: flex; flex-wrap: wrap">
                                        <a type="button" class="btn btn-outline-danger mx-1" onclick="confirmDelete(<?= $user['user_id'] ?>)">Xóa</a>
                                        <a type="button" class="btn btn-outline-success mx-1" href="update_user.php?id=<?=$user["user_id"]?>">Chỉnh sửa</a>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
                <nav aria-label="Page navigation example" style="text-align:center; margin:20px 0px">
                    <ul class="pagination justify-content-center">
                        <?php if ($page == 1) : ?>
                            <li class="page-item disabled">
                                <a class="page-link" href="edit_user.php?page=<?= $page?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php else:?>
                            <li class="page-item">
                                <a class="page-link" href="edit_user.php?page=<?= $page-1?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php endif ?>
                        <li class="page-item active">
                            <a class="page-link" href="#"><?= $page?></a>
                        </li>
                        <?php if ($page >= $totalPage-1) : ?>
                            <li class="page-item disabled">
                                <a class="page-link" href="edit_user.php?page=<?= $page?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php else:?>
                            <li class="page-item">
                                <a class="page-link" href="edit_user.php?page=<?= $page+1?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php endif ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <?php require_once 'inc/banner2.php'?>
    <?php require_once "inc/footer.php"; ?>
</div>
<script>
    function confirmDelete(user_id) {
        if (confirm("Xác nhận xóa tài khoản này?")) {
            window.location.href = "delete_user.php?id=" + user_id;
        }
    }
</script>
