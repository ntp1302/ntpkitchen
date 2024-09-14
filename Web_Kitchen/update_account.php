<?php
    require_once "inc/init.php";
    require_once "class/Database.php";
    require_once "class/User.php";

    if (!isset($_COOKIE['username'])) {
        header("location: login.php");
        exit();
    }

    $username = $_COOKIE['username'];

    $conn = new Database();
    $pdo = $conn->getConnect();

    $userErr = '';
    $passErr = '';
    $repassErr = '';
    $emailErr = '';
    $fnameErr = '';
    $addressErr = '';
    $phoneErr = '';

    $pass = '';
    $repass = '';
    $email = '';
    $full_name = '';
    $address = '';
    $phone = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve and sanitize form inputs
        $pass = $_POST['pass'];
        $repass = $_POST['repass'];
        $email = $_POST['email'];
        $full_name = $_POST['fullname'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $old_password = $_POST['old_password'];

        // Fetch user data from the database
        $sql = "SELECT password FROM Users WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            echo "<script>alert('User not found.');</script>";
            exit();
        }

        if (!empty($old_password) && !password_verify($old_password, $user['password'])) {
            $passErr = "Old password is incorrect.";
        }

        if (empty($email)) {
            $emailErr = "Email is required.";
        } elseif (!preg_match('/^\S+@\S+\.\S+$/', $email)) {
            $emailErr = "Invalid email format.";
        }

        if (empty($full_name)) {
            $fnameErr = "Full name is required.";
        }

        if (empty($address)) {
            $addressErr = "Address is required.";
        }

        if (empty($phone)) {
            $phoneErr = "Phone number is required.";
        } elseif (!preg_match("/^0[0-9]{9}$/", $phone)) {
            $phoneErr = "Invalid phone number.";
        }

        if (!empty($pass) && !preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $pass)) {
            $passErr = "Password must be at least 8 characters long and include uppercase, lowercase, number, and special character.";
        }

        if ($pass !== $repass) {
            $repassErr = "Passwords do not match.";
        }

        if (!$passErr && !$repassErr && !$emailErr && !$fnameErr && !$addressErr && !$phoneErr) {
            // Update user information
            $update_sql = "UPDATE Users SET email = :email, full_name = :full_name, address = :address, phone = :phone";
            $params = [
                ':email' => $email,
                ':full_name' => $full_name,
                ':address' => $address,
                ':phone' => $phone,
                ':username' => $username,
            ];

            // Update password if new password is provided and matches confirmation
            if (!empty($pass) && !empty($old_password)) {
                $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
                $update_sql .= ", password = :password";
                $params[':password'] = $hashed_password;
            }

            $update_sql .= " WHERE username = :username";
            $stmt = $pdo->prepare($update_sql);
            $stmt->execute($params);

            echo "<script>alert('Mật khẩu tài khoản đã được thay đổi, vui lòng đăng nhập lại cùng mật khẩu mới.'); window.location.href='logout.php';window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Có lỗi xảy ra! Kiểm tra thông tin điền vào.');</script>";
        }
    } else {
        // Fetch current user information for pre-filling the form
        $sql = "SELECT full_name, email, address, phone FROM Users WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $full_name = $user['full_name'];
        $email = $user['email'];
        $address = $user['address'];
        $phone = $user['phone'];
    }
?>

<div class="wrapper">
    <?php require_once "inc/header2.php" ?>
    <div style="margin-top: -20px;border-top: 5px solid #009966">
        <div class="main">
            <div class="register">
                <h4 class="text-center"><b>Thông tin tài khoản</b></h4>
                <form class="w-50 m-auto" method="post">
                    <div class="mb-3">
                        <input name="user" id="user" class="form-control" placeholder="Tên đăng nhập..." value="<?= htmlspecialchars($username) ?>" readonly />
                    </div>
                    <div class="mb-3">
                        <input name="email" id="email" class="form-control" type="email" placeholder="Email..." value="<?= htmlspecialchars($email) ?>" />
                        <span class="text-danger fw-bold"><?= $emailErr ?></span>
                    </div>
                    <div class="mb-3">
                        <input name="fullname" id="fullname" class="form-control" type="text" placeholder="Họ và tên..." value="<?= htmlspecialchars($full_name) ?>" />
                        <span class="text-danger fw-bold"><?= $fnameErr ?></span>
                    </div>
                    <div class="mb-3">
                        <input name="address" id="address" class="form-control" type="text" placeholder="Địa chỉ..." value="<?= htmlspecialchars($address) ?>" />
                        <span class="text-danger fw-bold"><?= $addressErr ?></span>
                    </div>
                    <div class="mb-3">
                        <input name="phone" id="phone" class="form-control" type="text" placeholder="Số điện thoại..." value="<?= htmlspecialchars($phone) ?>" />
                        <span class="text-danger fw-bold"><?= $phoneErr ?></span>
                    </div>
                    <button type="button" class="btn btn-secondary" onclick="togglePasswordFields()">Đổi mật khẩu</button>
                    <div id="passwordFields" style="display: none;">
                        <div class="mb-3">
                            <input name="old_password" id="old_password" class="form-control" type="password" placeholder="Mật khẩu cũ..." />
                            <span class="text-danger fw-bold"><?= $passErr ?></span>
                        </div>
                        <div class="mb-3">
                            <input name="pass" id="pass" class="form-control" type="password" placeholder="Mật khẩu mới..." />
                            <span class="text-danger fw-bold"><?= $passErr ?></span>
                        </div>
                        <div class="mb-3">
                            <input name="repass" id="repass" class="form-control" type="password" placeholder="Nhập lại mật khẩu mới..." />
                            <span class="text-danger fw-bold"><?= $repassErr ?></span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" style="background-color:#009966">Cập nhật tài khoản</button>
                    <a href="index.php">Quay lại</a>
                </form>
            </div>
        </div>
    </div>
    <?php require_once 'inc/banner2.php' ?>
    <?php require_once "inc/footer.php" ?>
</div>
    <script>
        function togglePasswordFields() {
            var passwordFields = document.getElementById('passwordFields');
            if (passwordFields.style.display === 'none') {
                passwordFields.style.display = 'block';
            } else {
                passwordFields.style.display = 'none';
            }
        }
    </script>
