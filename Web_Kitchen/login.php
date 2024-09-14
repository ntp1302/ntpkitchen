<?php
    require_once "inc/init.php";
    require_once "class/Database.php";
    require_once "class/User.php"; 
    
    $conn = new Database();
    $pdo = $conn->getConnect();

    $usernameErr = '';
    $passwordErr = '';

    $checkUser = '';
    $checkPass = '';
    $username = '';
    $password = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $checkUser = $username;
            $checkPass = $password;
        }

        if (empty($username)) {
            $usernameErr = "Hãy nhập tên đăng nhập!";
        } elseif (!preg_match('/^[a-zA-Z0-9]+([._]?[a-zA-Z0-9]+)*$/', $username)) {
            $usernameErr = "Tên đăng nhập chưa đúng!";
        }
        if (empty($password)) {
            $passwordErr = "Phải nhập mật khẩu!";
        }
        if (!$usernameErr && !$passwordErr) {
            if ($username == $checkUser && $password == $checkPass) {
                setcookie("username", $username, time() + (86400 * 30), "/");
                setcookie("password", $password, time() + (86400 * 30), "/");

                echo "<script>alert('Đăng nhập thành công!'); window.location.href='index.php';</script>";
            } else {
                $passwordErr = "Tên đăng nhập hoặc mật khẩu không đúng!";
            }
        }
    }
?>
<div class="wrapper">
    <?php require_once "inc/header2.php"; ?>
    <div style="margin-top: -20px;border-top: 5px solid #009966">
        <div class="main">            
            <div class="login_form">
                <h4 class= "text-center">Đăng Nhập</h4>
                <form class="w-50 m-auto" method="post" style="text-align:center">
                    <div class="mb-3">
                        <input class="form-control" id="username" name="username" placeholder="Tên đăng nhập..." value="<?= $username ?>">
                        <span class="text-danger"><?= $usernameErr ?></span>
                    </div>
                    <div class="mb-3">
                        <input class="form-control" id="password" name="password" type="password" placeholder="Mật khẩu..." value="<?= $password ?>">
                        <span class="text-danger"><?= $passwordErr ?></span>
                    </div>
                    <button class="btn btn-primary" type="submit" style="background-color:#009966">Đăng Nhập</button>
                    <a href="forgot_password.php">Quên mật khẩu</a>
                </form> 
            </div>
        </div>
    </div>
    <?php require_once 'inc/banner2.php'?>
    <?php require_once "inc/footer.php"; ?>
</div>
