<?php
    require_once "inc/init.php";
    require_once "class/Database.php";

    $conn = new Database();
    $pdo = $conn->getConnect();

    $sql_categories = "SELECT * FROM Categories";
    $stmt_categories = $pdo->query($sql_categories);
    $categories = $stmt_categories->fetchAll(PDO::FETCH_ASSOC);

    function fetchProductsByCategory($pdo, $category_id) {
        $sql_products = "SELECT * FROM Product WHERE category_id = :category_id";
        $stmt_products = $pdo->prepare($sql_products);
        $stmt_products->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt_products->execute();
        return $stmt_products->fetchAll(PDO::FETCH_ASSOC);
    }

?>

<div class="wrapper">
    <?php require_once "inc/header2.php" ?>
    <?php require_once 'inc/banner1.php'?>
        <div class="main">

        <?php foreach ($categories as $category): ?>
            <?php
            $category_id = $category['category_id'];
            $products = fetchProductsByCategory($pdo, $category_id);
            ?>
            <div class="category_product">
                <div class="banner-1">
                    <div class="banner-2">
                        <img src="img/logo_mini.png" alt="logomini">
                        <a href="category.php?id=<?= $category['category_id']?>" style="color: inherit;text-decoration: none;" class="text-uppercase">
                            <b><?= htmlspecialchars($category['name']) ?></b>
                        </a>
                    </div>
                </div>
                <?php if (count($products) > 0): ?>
                <div class="row" style="width:100%;">
                    <?php foreach ($products as $product): ?>
                        <div class ="col-3" style="margin-top: 10px">
                            <div class="card" style="width: 14rem; height: 360px">
                                <a href="product.php?id=<?= $product['product_id'] ?>" style="font-weight:500"><img src="img_product/<?= $product['image'] ?>" class="card-img-top" width="100%" height="230px"></a>
                                <div class="card-body">
                                    <div style="height:50px">
                                        <h5 class="card-title" style="font-size: 17px;"><a href="product.php?id=<?= $product['product_id'] ?>" style="font-weight:500"><?= $product['name'] ?></a></h5>
                                    </div>
                                    <p class="card-text"><b style="color: red; font-weight: 100;"><?= number_format($product['price'], 0, ',', '.') ?> VND</b></p>
                                </div>
                            </div>
                        </div>  
                    <?php endforeach; ?> 
                </div>
                <?php else: ?>
                    <p>No products available in this category.</p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        </div>
    <?php require_once 'inc/banner2.php'; ?>
    <?php require_once 'inc/footer.php'; ?>
</div>