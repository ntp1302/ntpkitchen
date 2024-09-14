<?php
    require_once "inc/init.php";
    require_once "class/Database.php";
    require_once "class/Product.php";

    $page = 1;
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (isset($_GET["page"])) {
            $page = $_GET["page"];
        }
    }

    $conn = new Database();
    $pdo = $conn->getConnect();

    $sql = "SELECT COUNT(*) as total_products FROM Product";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $totalProducts = intval($result['total_products']); 

    $productPerPage = 5;
    $totalPage = $totalProducts / $productPerPage + 1;

    $limit = $productPerPage;
    $offset = ($page - 1) * $productPerPage;

    $sql = "SELECT product_id, product.name as product_name, price, categories.category_id as category_id,categories.name as category_name, image 
            FROM product, categories 
            WHERE product.category_id = categories.category_id 
            ORDER BY product_id DESC
            LIMIT ".$limit." OFFSET ".$offset;
    $stmt = $pdo->prepare($sql);

    $data = null;
    if ($stmt->execute()) {
        $data = (object)$stmt->fetchAll(PDO::FETCH_ASSOC);
    }
?>
<div class="wrapper">
    <?php require_once "inc/header2.php"; ?>
    <div style="margin-top: -20px;border-top: 5px solid #009966">
        <div class="main">            
            <div class="edit_product">
                    
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th colspan="5"><h3>Danh sách sản phẩm</h3></th>
                            <th><a type="button" class="btn btn-primary" style="background-color: #009966;" href="new_product.php">Thêm sản phẩm mới</a></th>
                        </tr>
                        <tr class="text-center">
                            <th scope="col">Mã</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Giá bán</th>
                            <th scope="col">Danh mục sản phẩm</th>
                            <th scope="col">Hình ảnh</th>
                            <th scope="col">Tùy chỉnh</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $product) : ?>
                            <tr class="text-center">
                                <th scope="row"><?= $product['product_id'] ?></th>
                                <td><a href="product.php?id=<?= $product['product_id'] ?>"><?= $product['product_name'] ?></a></td>
                                <td><?= number_format($product['price'], 0, ',', '.') ?> VND</td>
                                <td><a href="category.php?id=<?= $product['category_id'] ?>"><?= $product['category_name'] ?></a></td>
                                <td><img src="img_product/<?= $product['image'] ?>" width="100px" height="100px"></td>
                                <td style="display: flex; flex-wrap: wrap">
                                    <a type="button" class="btn btn-outline-danger mx-1" onclick="confirmDelete(<?= $product['product_id'] ?>)">Xóa</a>
                                    <a type="button" class="btn btn-outline-success mx-1" href="update_product.php?id=<?=$product["product_id"]?>">Chỉnh sửa</a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
                <nav aria-label="Page navigation example" style="text-align:center; margin:20px 0px">
                    <ul class="pagination justify-content-center">
                        <?php if ($page == 1) : ?>
                            <li class="page-item disabled">
                                <a class="page-link" href="edit_product.php?page=<?= $page?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php else:?>
                            <li class="page-item">
                                <a class="page-link" href="edit_product.php?page=<?= $page-1?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php endif ?>
                        <li class="page-item active">
                            <a class="page-link" href="#"><?= $page?></a>
                        </li>
                        <?php if ($page >= $totalPage-1) : ?>
                            <li class="page-item disabled">
                                <a class="page-link" href="edit_product.php?page=<?= $page?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php else:?>
                            <li class="page-item">
                                <a class="page-link" href="edit_product.php?page=<?= $page+1?>" aria-label="Next">
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
    function confirmDelete(productId) {
        if (confirm("Xác nhận xóa sản phẩm này?")) {
            window.location.href = "delete_product.php?id=" + productId;
        }
    }
</script>
