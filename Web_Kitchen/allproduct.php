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

    //$pdo = Database::getConnect();
    //$data = Product::getAll($pdo);
    $conn = new Database();
    $pdo = $conn->getConnect();

    // Chuẩn bị truy vấn SQL
    $sql = "SELECT COUNT(*) as total_products FROM Product";

    // Thực thi truy vấn
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Lấy kết quả
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $totalProducts = intval($result['total_products']); 
    //var_dump($page);

    $productPerPage = 4;
    $totalPage = $totalProducts / $productPerPage + 1;

    $limit = $productPerPage;
    $offset = ($page - 1) * $productPerPage;

    $sql = "SELECT product_id, product.name as product_name, price, categories.name as category_name, image 
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
    <?php require_once "inc/header2.php" ?>
    <div style="margin-top: -20px;border-top: 5px solid #009966;">
        <div class="main">
            <div class="all_product">
                <div class="row" style="width:100%;">
                    <?php foreach($data as $product) : ?>
                        <div class ="col-3" style="margin-top: 10px;">
                            <div class="card" style="width: 14rem; height: 360px">
                                <a href="product.php?id=<?= $product['product_id'] ?>"><img src="img_product/<?= $product['image'] ?>" class="card-img-top" width="100%" height="230px"></a>
                                <div class="card-body">
                                    <h5 class="card-title" style="font-size: 17px"><a href="product.php?id=<?= $product['product_id'] ?>"><?= $product['product_name'] ?></a></h5>
                                    <p class="card-text">Giá: <b style="color: red; font-weight: 100;"><?= number_format($product['price'], 0, ',', '.') ?> VND</b></p>
                                </div>
                            </div>
                        </div>         
                    <?php endforeach; ?>   
                </div>
                
                <nav aria-label="Page navigation example" style="text-align:center; margin:20px 0px">
                    <ul class="pagination justify-content-center">
                        <?php if ($page == 1) : ?>
                            <li class="page-item disabled">
                                <a class="page-link" href="allproduct.php?page=<?= $page?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php else:?>
                            <li class="page-item">
                                <a class="page-link" href="allproduct.php?page=<?= $page-1?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php endif ?>
                        <li class="page-item active">
                            <a class="page-link" href="#"><?= $page?></a>
                        </li>
                        <?php if ($page >= $totalPage-1) : ?>
                            <li class="page-item disabled">
                                <a class="page-link" href="allproduct.php?page=<?= $page?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php else:?>
                            <li class="page-item">
                                <a class="page-link" href="allproduct.php?page=<?= $page+1?>" aria-label="Next">
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
    <?php require_once "inc/footer.php" ?>
</div>