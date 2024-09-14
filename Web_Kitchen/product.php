
<?php
    require_once "inc/init.php";
    require_once "class/Database.php";
    require_once "class/Product.php";

    if (!isset($_GET['id'])) {
        die("Product ID not specified.");
    }

    $product_id = intval($_GET['id']);

    $conn = new Database();
    $pdo = $conn->getConnect();

    $sql = "SELECT product_id, product.name as product_name, product.description as product_description, price, stock_quantity, categories.name as category_name, image,
            brand, origin, size, product.category_id as category_id
            FROM product 
            JOIN categories ON product.category_id = categories.category_id 
            WHERE product.product_id = :product_id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->execute();

    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        die("Product not found.");
    }
?>

<div class="wrapper">
    <?php require_once "inc/header2.php" ?>
    <div style="margin-top: -20px;border-top: 5px solid #009966">
        <div class="main">
            <div class="card boder-dark" style="margin-top: 10px;">
            <form method="post" action="add_to_cart.php">
                    <table class="boder-dark mx-3 mb-3 mt-3">
                        <tr class="text-left">
                            <td rowspan="5" width="45%">
                                <div class="hover01 column">
                                    <figure><img class="card-header" src="img_product/<?= htmlspecialchars($product['image']) ?>" style="width:100%; height: 450px" alt="Image" /></figure>
                                </div>
                            </td>
                            <td width="35%" style="font-weight: bold;font-size:30px"><?= htmlspecialchars($product['product_name']) ?></td>
                        </tr>
                        <tr class="text-left">
                            <td style="font-weight: bold; color: red; font-size: 30px;"><?= number_format($product['price'], 0, ',', '.') ?> VND
                                <p> </p>
                                <p style="font-size: 15px; color:#777777">*TÌNH TRẠNG: MỚI 100%</p>
                                <p style="font-size: 15px; color:#777777">*BẢO HÀNH: 12 THÁNG</p>
                                <p style="font-size: 15px; color:#777777">*TRỌN BỘ: NGUYÊN SEAL CHƯA ACTIVE</p>
                            </td>
                        </tr>
                        <tr class="text-left">
                            <td>
                                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>" />
                                <input type="hidden" name="price" value="<?= $product['price'] ?>" />
                                <input type="number" name="quantity" value="1" min="1" max="<?= $product['stock_quantity'] ?>" />
                                <input type="submit" value="Thêm vào giỏ hàng" style="border: 10px solid #009966; border-radius: 4px; background-color:#009966; color: white" />
                            </td>
                        </tr>
                        <tr class="text-left">
                            <td>
                                <table>
                                    <tr>
                                        <td>
                                            <p style="font-size: 20px; font-weight: bold; margin-top: 10px">Tính phí ship tự động </p>
                                            <img src="img/tinh-phi-tu-dong.JPG" height="100px" />
                                        </td>
                                        <td>
                                            <p style="font-size: 20px; font-weight: bold; margin-top: 10px"> Thanh toán Online dễ dàng</p>
                                            <img src="img/thanhtoan.JPG" height="100px" />
                                        </td>
                                    </tr>
                                    <tr style="height:40px"></tr>
                                    <tr style="font-weight: normal; font-size: 18px; height: 40px; border-top: 1px dashed;">
                                        <td colspan="2">
                                            <span>Mã: <?= htmlspecialchars($product['product_id']) ?></span>
                                        </td>
                                    </tr>
                                    <tr style="font-weight: normal; font-size: 18px; height: 40px; border-top: 1px dashed;">
                                        <td colspan="2">
                                            <span>Danh mục: 
                                                <span>
                                                    <a href="category.php?id=<?= $product['category_id'] ?>"><?= htmlspecialchars($product['category_name']) ?></a>
                                                </span>
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <hr />
            <div style="width:100%">
                <div class="tab">
                    <button class="tablinks" onclick="openCity(event, 'MoTa')">MÔ TẢ</button>
                </div>

                <div id="MoTa" class="tabcontent">
                    <h3 style="font-weight: bold; font-size:25px">THÔNG TIN CHI TIẾT</h3>
                    <table style="width:100%">
                        <tr>
                            <td style="font-weight: bold;">Thương hiệu</td>
                            <td><?= htmlspecialchars($product['brand']) ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Xuất xứ</td>
                            <td><?= htmlspecialchars($product['origin']) ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Thời gian bảo hành</td>
                            <td>12 tháng</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;"v>Địa điểm bảo hành</td>
                            <td>NTP Kitchen Store</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Danh mục hàng</td>
                            <td><?= htmlspecialchars($product['category_name']) ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Kích thước</td>
                            <td><?= htmlspecialchars($product['size']) ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    <?php require_once 'inc/banner2.php'?>
    <?php require_once 'inc/footer.php' ?>   
</div> 
    <script>
        function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>
    