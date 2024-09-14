<?php
    require_once "inc/init.php";
    require_once "class/Database.php";
    require_once "class/Product.php";

    $conn = new Database();
    $pdo = $conn->getConnect();

    $category_id = null; 

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (isset($_GET["id"])) {
            $category_id = $_GET["id"]; 
        }
    }

    if ($category_id !== null) { 
        $products = Product::getProductsByCategory($pdo, $category_id);
        $category_name = Product::getCategoryName($pdo, $category_id);
    } else {
        echo "<script>alert('Có lỗi xảy ra!'); window.location.href='allproduct.php';</script>";
    }
?>
<div class="wrapper">
    <?php require_once "inc/header2.php"; ?>
    <div style="margin-top: -20px;border-top: 5px solid #009966">
        <div class="main">  
            <div class="category_products">
                <h4 class= "text-center">Danh mục: <?= $category_name ?></h4>
                <div class="row" style="width:100%;">
                    <?php foreach ($products as $product): ?>
                        <div class="col-3" style="margin-top: 10px;">
                            <div class="card" style="width: 14rem; height: 360px">
                                <img src="img_product/<?= $product['image'] ?>" class="card-img-top" width="100%" height="230px">
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
                </div>
            </div>
        </div>
    </div>
    <?php require_once 'inc/banner2.php'?>
    <?php require_once "inc/footer.php"; ?>
</div>
