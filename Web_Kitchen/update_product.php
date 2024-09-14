<?php
    require_once "inc/init.php";
    require_once "class/Database.php";
    require_once "class/Product.php";

    $conn = new Database();
    $pdo = $conn->getConnect();

    $id = $_GET["id"];

    $product = Product::getOneById($pdo, $id);

    if (!$product) {
        echo "<script>alert('Sản phẩm không tồn tại!'); window.location.href='edit_product.php';</script>";
    }

    $cate_sql = "SELECT category_id, name FROM Categories";
    $cate_stmt = $pdo->prepare($cate_sql);
    $categories = [];
    if ($cate_stmt->execute()) {
        $categories = $cate_stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    $nameErr = '';
    $priceErr = '';
    $cateErr = '';
    $imageErr = '';
    $updateFail = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            $name = $_POST["name"];
            $price = $_POST["price"];
            $cate = $_POST["cate"];

            if (empty($name)) {
                $nameErr = "Bắt buộc nhập tên sản phẩm!";
            }
            if (empty($price)) {
                $priceErr = "Phải nhập giá!";
            } elseif ($price % 1000 != 0) {
                $priceErr = "Giá phải chia hết cho 1000!";
            }

            if (empty($_FILES["img"]["name"])) {
                $image = $product->image;
            } else {
                switch ($_FILES["img"]["error"]) {
                    case UPLOAD_ERR_OK:
                        break;
                    case UPLOAD_ERR_NO_FILE:
                        throw new Exception('Không có tệp được tải lên');
                        break;
                    default:
                        throw new Exception('Lỗi không xác định');
                        break;
                }

                if ($_FILES["img"]["size"] > 1000000) {
                    throw new Exception('File quá lớn');
                }

                $mime_types = ['image/gif', 'image/jpeg', 'image/png'];
                $file_info = finfo_open(FILEINFO_MIME_TYPE);
                $mime_type = finfo_file($file_info, $_FILES["img"]["tmp_name"]);
                if (!in_array($mime_type, $mime_types)) {
                    throw new Exception('Phải tải lên một hình ảnh.');
                }

                $fname = pathinfo($_FILES["img"]["name"], PATHINFO_FILENAME);
                $ext = pathinfo($_FILES["img"]["name"], PATHINFO_EXTENSION);
                $dest = "img_product/" . $_FILES["img"]["name"];
                $i = 1;
                while (file_exists($dest)) {
                    $dest = "img_product/" . $fname . "-$i." . $ext;
                    $i++;
                }

                if (!move_uploaded_file($_FILES["img"]["tmp_name"], $dest)) {
                    throw new Exception('Không thể tải lên tệp!');
                }

                $image = basename($dest);
            }

            if (Product::updateProduct($pdo, $id, $name, $price, $image, $cate)) {
                echo "<script>alert('Đã cập nhật sản phẩm!'); window.location.href='edit_product.php';</script>";
            } else {
                $updateFail = "Không cập nhật được sản phẩm!";
            }
        } catch (Exception $e) {
            $imageErr = $e->getMessage();
        }
    }
?>

<div class="wrapper">
    <?php require_once "inc/header2.php"; ?>
    <div style="margin-top: -20px;border-top: 5px solid #009966">
        <div class="main">  
            <div class="update_product">
                <h2 class= "text-center">Chỉnh sửa sản phẩm</h2>
                <form class="w-50 m-auto" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <input name="name" id="name" class="form-control" value="<?= $product->name ?>" placeholder="Tên sản phẩm..." />
                        <span class = "text-danger fw-bold"><?= $nameErr ?></span>
                    </div>
                    <div class="mb-3">
                        <input name="price" id="price" class="form-control" type = "number" value="<?= $product->price ?>" placeholder="Giá sản phẩm..."/>
                        <span class = "text-danger fw-bold"><?= $priceErr ?></span>
                    </div>
                    <div class="mb-3">
                        <select name="cate" id="cate" class="form-control">
                            <option value="">Chọn danh mục...</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['category_id'] ?>" <?= $product->category_id == $category['category_id'] ? 'selected' : '' ?>>
                                    <?= $category['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <span class="text-danger fw-bold"><?= $cateErr ?></span>
                    </div>
                    <div class="mb-3">
                        <input name="img" id="img" type="file" />
                        <span class = "text-danger fw-bold"><?= $imageErr ?></span>
                    </div>
                    <button type="submit" class ="btn btn-primary" style="background-color:#009966" >Cập nhật sản phẩm</button>
                    <span class = "text-danger fw-bold"><?= $updateFail ?></span>
                </form>
            </div>
        </div>
    </div>
    <?php require_once 'inc/banner2.php'?>
    <?php require_once "inc/footer.php"; ?>
</div>
