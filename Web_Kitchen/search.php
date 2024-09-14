<!-- search.php -->
<?php
require_once "inc/init.php";
require_once "class/Database.php";
require_once "class/Product.php";

if (isset($_GET['keyword'])) {
    $keyword = trim($_GET['keyword']);

    $conn = new Database();
    $pdo = $conn->getConnect();

    // Truy vấn cơ sở dữ liệu để tìm kiếm sản phẩm
    $sql = "SELECT product_id, product.name as product_name, price, categories.name as category_name, image 
            FROM product
            JOIN categories ON product.category_id = categories.category_id
            WHERE product.name LIKE :keyword
            ORDER BY product_id DESC";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':keyword' => '%' . $keyword . '%']);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<div class="wrapper">
    <?php require_once "inc/header2.php"; ?>
    <div style="display:flex; margin-top: -20px; border-top: 5px solid #009966">
        <div class="main">
            <div class="all_product">
                <h3>Kết quả tìm kiếm cho: <?= htmlspecialchars($keyword) ?></h3>
                <div class="row" style="width:100%;">
                    <?php if ($data): ?>
                        <?php foreach ($data as $product): ?>
                            <div class="col-3" style="margin-top: 10px;">
                                <div class="card" style="width: 14rem; height: 360px">
                                    <a href="product.php?id=<?= $product['product_id'] ?>"><img src="img_product/<?= $product['image'] ?>" class="card-img-top" width="100%" height="230px"></a>
                                    <div class="card-body">
                                        <div style="height:50px">
                                            <h5 class="card-title" style="font-size: 17px;">
                                                <a href="product.php?id=<?= $product['product_id'] ?>"><?= $product['product_name'] ?></a>
                                            </h5>
                                        </div>
                                        <p class="card-text">Giá: <b style="color: red; font-weight: 100;"><?= number_format($product['price'], 0, ',', '.') ?> VND</b></p>
                                    </div>
                                </div>
                            </div>         
                        <?php endforeach; ?>   
                    <?php else: ?>
                        <p>Không tìm thấy sản phẩm nào khớp với từ khóa "<?= htmlspecialchars($keyword) ?>".</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php require_once 'inc/banner2.php'; ?>
    <?php require_once "inc/footer.php"; ?>
</div>
