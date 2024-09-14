<?php
    require_once "inc/init.php";

    require_once "class/Database.php";
    require_once "class/Product.php";
    require_once "class/User.php";

    $conn = new Database();
    $pdo = $conn->getConnect();

    $emailErr = '';
    $fnameErr = '';
    $addressErr = '';
    $phoneErr = '';
    $updateFail = '';

    $email = '';
    $full_name = '';
    $address = '';
    $phone = '';

    $id = null;
    $id = $_GET["id"];

    $user = User::getOneById($pdo, $id);

    if (!$user) {
        echo "<script>alert('Tài khoản không tồn tại!'); window.location.href='edit_user.php';</script>";
    }

    if($_SERVER["REQUEST_METHOD"]== "POST"){

        $email = $_POST['email'];
        $full_name = $_POST['full_name'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];

        if(empty($email)){
            $emailErr = "Phải nhập email";
        }
        elseif(!preg_match('/^\\S+@\\S+\\.\\S+$/', $email)) {
            $emailErr = "Email chưa đúng định dạng!";
        }
        if(empty($full_name)){
            $fnameErr = "Phải nhập họ và tên";
        }
        if(empty($address)){
            $addressErr = "Phải nhập địa chỉ";
        }
        if(empty($phone)){
            $phoneErr = "Phải nhập số điện thoại";
        }
        elseif(!preg_match("/^0[0-9]{9}$/", $phone)){
            $phoneErr = "Số điện thoại không hợp lệ";
        }

        if(!$emailErr && !$fnameErr && !$addressErr && !$phoneErr){
            if(User::updateUser($pdo, $id, $email, $full_name, $address, $phone)) {
                echo "<script>alert('Đã chỉnh sửa thông tin tài khoản!'); window.location.href='edit_user.php';</script>";
            }
            else {
                $updateFail = "Có lỗi xảy ra. Không cập nhật được tài khoản!";
            }

        } else {
            echo "<script>alert('Vui lòng kiểm tra lại các trường nhập liệu.');</script>";
        }
    }
?>

<div class="wrapper">
    <?php require_once "inc/header2.php"; ?>
    <div style="margin-top: -20px;border-top: 5px solid #009966">
        <div class="main">  
            <div class="update_product">
                <h2 class= "text-center">Chỉnh sửa thông tin tài khoản: <?= $user->username?></h2> 
                <form class="w-50 m-auto" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <input name="email" id="email" class="form-control" value="<?= $user->email ?>" placeholder="Email..." />
                        <span class = "text-danger fw-bold"><?= $emailErr ?></span>
                    </div>
                    <div class="mb-3">
                        <input name="full_name" id="full_name" class="form-control" value="<?= $user->full_name ?>" placeholder="Họ và tên..."/>
                        <span class = "text-danger fw-bold"><?= $fnameErr ?></span>
                    </div>
                    <div class="mb-3">
                        <input name="address" id="address" class="form-control" value="<?= $user->address ?>" placeholder="Địa chỉ..."/>
                        <span class = "text-danger fw-bold"><?= $address ?></span>
                    </div>
                    <div class="mb-3">
                        <input name="phone" id="phone" class="form-control" value="<?= $user->phone ?>" placeholder="Số điện thoại..."/>
                        <span class = "text-danger fw-bold"><?= $phone ?></span>
                    </div>
                    <button type="submit" class ="btn btn-primary" style="background-color:#009966" >Cập nhật tài khoản</button>
                    <span class = "text-danger fw-bold"><?= $updateFail ?></span>
                </form>
            </div>
        </div>
    </div>
    <?php require_once 'inc/banner2.php'?>
    <?php require_once "inc/footer.php"; ?>
</div>
