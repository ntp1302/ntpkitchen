<?php
    require_once "inc/init.php";
    require_once "class/Database.php";
    require_once "class/User.php"; 

    // use PHPMailer\PHPMailer\PHPMailer;
    // use PHPMailer\PHPMailer\Exception;

    // require 'vendor/autoload.php';

    $conn = new Database();
    $pdo = $conn->getConnect();

    $usernameErr = '';
    $emailErr = '';
    $questionErr = '';
    $successMsg = '';
    $errorMsg = '';
    $username = '';
    $email = '';
    $question ='';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $email = $_POST["email"];
        $question = $_POST["security_question"];

        if (empty($username)) {
            $usernameErr = "Hãy nhập tên đăng nhập!";
        }
        if (empty($email)) {
            $emailErr = "Hãy nhập email!";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Địa chỉ email không hợp lệ!";
        }
        if(empty($question)){
            $questionErr = "Hãy nhập câu hỏi bảo mật";
        }
        elseif(!preg_match("/^[a-zA-Z0-9\s]+$/", $question)){
            $questionErr = "Vui lòng nhập câu hỏi bảo mật phải là chuỗi tiếng anh không dấu và không có dấu chấm, phẩy...";
        }

        if (!$usernameErr && !$emailErr && !$questionErr) {
            $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username AND email = :email AND security_question = :security_question');
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':security_question', $question);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $newPassword = bin2hex(random_bytes(4)); // Generate a random password
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                $updateStmt = $pdo->prepare('UPDATE users SET password = :password WHERE username = :username');
                $updateStmt->bindParam(':password', $hashedPassword);
                $updateStmt->bindParam(':username', $username);
                $updateStmt->execute();

                $successMsg = 'Mật khẩu mới của bạn là: ('.$newPassword.")";
            } else {
                $errorMsg = "Tên đăng nhập, email hoặc câu hỏi bảo mật không đúng!";
            }
        }
    }
?>
<div class="wrapper">
    <?php require_once "inc/header2.php"; ?>
    <div style="margin-top: -20px;border-top: 5px solid #009966">
        <div class="main">
            <div class="login_form">
                <h4 class="text-center">Quên mật khẩu</h4>
                <?php if ($successMsg): ?>
                    <p class="text-success" ><?= $successMsg ?></p>
                <?php endif; ?>
                <?php if ($errorMsg): ?>
                    <p class="text-danger"><?= $errorMsg ?></p>
                <?php endif; ?>
                <form class="w-50 m-auto" method="post" style="text-align:center">
                    <div class="mb-3">
                        <input class="form-control" id="username" name="username" placeholder="Tên đăng nhập..." value="<?= $username ?>">
                        <span class="text-danger"><?= $usernameErr ?></span>
                    </div>
                    <div class="mb-3">
                        <input class="form-control" id="email" name="email" type="email" placeholder="Email..." value="<?= $email ?>">
                        <span class="text-danger"><?= $emailErr ?></span>
                    </div>
                    <div class="mb-3">
                        <input class="form-control" id="security_question" name="security_question" type="security_question" placeholder="Câu hỏi bảo mật..." value="<?= $question ?>">
                        <span class="text-danger"><?= $questionErr ?></span>
                    </div>
                    <button class="btn btn-primary" type="submit" style="background-color:#009966">Gửi mật khẩu mới</button>
                </form>
            </div>
        </div>
    </div>
    <?php require_once 'inc/banner2.php'?>
    <?php require_once "inc/footer.php"; ?>
</div>
