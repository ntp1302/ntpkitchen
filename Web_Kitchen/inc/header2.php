<?php
    require_once "init.php";
    require_once "class/Database.php";

    $cart_item_count = 0;
    $conn = new Database();
    $pdo = $conn->getConnect();
    if (isset($_COOKIE['username'])) {
        $username = $_COOKIE['username'];
        $sql = "SELECT SUM(quantity) as total_quantity
                FROM CartItems ci
                JOIN Carts c ON ci.cart_id = c.cart_id
                WHERE c.username = :username and c.status = 0";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $cart_item_count = $result['total_quantity'];
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" />
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/banner.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <link rel="stylesheet" href="css/style.css">
    <title>NTP Kitchen</title>
</head>
<body>  
    <div id="header" class="row" style="background-color: #009966">
        <div class="logo">
            <a href="index.php"><img src="img/NTP_Kitchen.png" width="100%"></a>
        </div>
        <div class="search" style="width:30%; margin-top:30px; text-align: enter;">
            <form action="search.php" method="get">
                <input class="form-control" style="width:80%; height:50px; display:inline; margin-left:10px" type="search" name="keyword" placeholder="Tìm kiếm sản phẩm ..." aria-label="Search">
                <button class="btn btn-link" type="submit" style="width: 15%;background-color:greenyellow;border-radius:5px"><img src="img/kinhlup.png" style="width:100%"></button>
            </form>
        </div>
        <div style="margin-top: 20px; text-align: center; margin-left:0px">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto mb-2 mb-lg-0">
                        <?php if(!isset($_COOKIE['username'])) : ?>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="login.php">ĐĂNG NHẬP |</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="register.php">ĐĂNG KÝ |</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                            <div class="dropdown show">
                                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color:white; color:#009966; font-weight:bold">
                                    <?= $_COOKIE['username'] ?>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item" href="update_account.php">Thông tin tài khoản</a>
                                    <a class="dropdown-item" href="logout.php">Đăng xuất</a>
                                </div>
                            </div>
                            </li>
                        <?php endif ?>
                            <li class="nav-item">
                                <a class="nav-link" href="Cart.php">GIỎ HÀNG <i style="font-size: 15px;">(<?= $cart_item_count ?>)</i></a>
                            </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
    <div>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php" style="color:black"><p>TRANG CHỦ </p>|</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php" style="color:black"><p>GIỚI THIỆU </p>|</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="allproduct.php" style="color:black"><p>SẢN PHẨM </p>|</a>
                    </li>
                    <?php if(!isset($_COOKIE['username']) || $_COOKIE['username'] != "phatadmin"): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="hotcombo.php" style="color:black"><p id="hot">HOT COMBO </p></a>
                        </li>
                    <?php else: ?> 
                        <li class="nav-item">
                            <a class="nav-link" href="hotcombo.php" style="color:black"><p id="hot">HOT COMBO </p>|</a>
                        </li>
                        <li class="nav-item">
                            <div class="dropdown show">
                                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color:#009966; color:white; font-weight:bold">
                                    QUẢN LÝ
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item" href="edit_product.php">QUẢN LÝ SẢN PHẨM</a>
                                    <a class="dropdown-item" href="edit_user.php">QUẢN LÝ TÀI KHOẢN</a>
                                    <a class="dropdown-item" href="order.php">ĐƠN HÀNG</a>
                                </div>
                            </div>
                        </li>
                        
                    <?php endif ?>
                </ul>
            </div>
        </div>
    </nav>
    </div>
    