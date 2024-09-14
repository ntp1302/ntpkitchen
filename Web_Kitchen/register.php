<?php
    require_once "inc/init.php";

    require_once "class/Database.php";
    require_once "class/Product.php";
    require_once "class/User.php";

    $conn = new Database();
    $pdo = $conn->getConnect();

    $userErr = '';
    $passErr = '';
    $repassErr = '';
    $emailErr = '';
    $fnameErr = '';
    $addressErr = '';
    $phoneErr = '';
    $questionErr = '';

    $user = '';
    $pass = '';
    $repass = '';
    $email = '';
    $full_name = '';
    $address = '';
    $phone = '';
    $question ='';

    if($_SERVER["REQUEST_METHOD"]== "POST"){
        //Xử lý form
        //var_dump($_POST);
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        $repass = $_POST['repass'];
        $email = $_POST['email'];
        $full_name = $_POST['fullname'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $question = $_POST['security_question'];
        if(empty($user)){
            $userErr = "Phải nhập tên đăng nhập";
        }
        elseif(!User::isUsernameExists($pdo, $user)) {
            $userErr = "Username đã tồn tại!!!";
        }
        if(empty($pass)){
            $passErr = "Phải nhập mật khẩu";
        }
        elseif(!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $pass)) {
            $passErr = "Mật Khẩu phải từ 8 kí tự, có in hoa, có số từ 0-9!";
        }
        if(empty($repass)){
            $repassErr = "Phải nhập lại mật khẩu";
        }
        
        elseif($pass != $repass){
            $repassErr = "Mật khẩu chưa trùng khớp";
        }
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
        if(empty($question)){
            $questionErr = "Hãy nhập câu hỏi bảo mật";
        }
        elseif(!preg_match("/^[a-zA-Z0-9\s]+$/", $question)){
            $questionErr = "Vui lòng nhập câu hỏi bảo mật phải là chuỗi tiếng anh không dấu và không có dấu chấm, phẩy...";
        }

        if(!$userErr && !$passErr && !$repassErr && !$emailErr && !$fnameErr && !$addressErr && !$phoneErr && !$questionErr){
            // Mã hóa mật khẩu
            $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);
            $username = new User($user, $hashedPassword, $email, $full_name, $address, $phone, $question);

            if(User::addOneUser($pdo, $username)) {
                //echo "Đăng ký thành công!";
                //header("location: index.php");
                echo "<script>alert('Đăng ký thành công!'); window.location.href='login.php';</script>";
            }
            else {
                echo "<script>alert('Có lỗi xảy ra. Vui lòng thử lại sau.');</script>";
            }

        } else {
            // Hiển thị lỗi nếu có vấn đề xảy ra
            echo "<script>alert('Vui lòng kiểm tra lại các trường nhập liệu.');</script>";
        }
    }
?>
<div class="wrapper">
    <?php require_once "inc/header2.php" ?>
    <div style="margin-top: -20px;border-top: 5px solid #009966;">
        <div class="main">
            <div class="register">
                <h4 class= "text-center"><b>Đăng ký khách hàng mới</b></h4>
                <form class="w-50 m-auto" method="post">
                    <div class="mb-3" >
                        <input name="user" id="user" class="form-control" placeholder="Tên đăng nhập..."  value="<?= $user ?>"/>
                        <span class = "text-danger fw-bold"><?= $userErr ?></span>
                    </div>
                    <div class="mb-3">
                        <input name="pass" id="pass" class="form-control" type="password" placeholder="Mật khẩu..." value="<?= $pass ?>" />
                        <span class = "text-danger fw-bold"><?= $passErr ?></span>
                    </div>
                    <div class="mb-3">
                        <input name="repass" id="repass" class="form-control" type="password" placeholder="Nhập lại mật khẩu..." value="<?= $repass ?>" />
                        <span class = "text-danger fw-bold"><?= $repassErr ?></span>
                    </div>
                    <div class="mb-3">
                        <input name="email" id="email" class="form-control" type="eml" placeholder="Email..." value="<?= $email ?>" />
                        <span class = "text-danger fw-bold"><?= $emailErr ?></span>
                    </div>
                    <div class="mb-3">
                        <input name="fullname" id="fullname" class="form-control" type="text" placeholder="Họ và tên..." value="<?= $full_name ?>" />
                        <span class = "text-danger fw-bold"><?= $fnameErr ?></span>
                    </div>
                    <div class="mb-3">
                        <input name="address" id="address" class="form-control" type="address" placeholder="Địa chỉ..." value="<?= $address ?>" />
                        <span class = "text-danger fw-bold"><?= $addressErr ?></span>
                    </div>
                    <div class="mb-3">
                        <input name="phone" id="phone" class="form-control" type="phone" placeholder="Số điện thoại..." value="<?= $phone ?>" />
                        <span class = "text-danger fw-bold"><?= $phoneErr ?></span>
                    </div>
                    <div class="mb-3">
                        <input name="security_question" id="security_question" class="form-control" type="security_question" placeholder="Câu hỏi bảo mật..." value="<?= $question ?>" />
                        <span class = "text-danger fw-bold"><?= $questionErr ?></span>
                    </div>
                    <button type="submit" class ="btn btn-primary" style="background-color:#009966">Đăng ký</button>
                    <a href="login.php">Đã có tài khoản</a>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once 'inc/banner2.php'?>
<?php require_once "inc/footer.php" ?>
