<?php 
    require_once "inc/init.php";
    require_once "class/Database.php";
    require_once "class/User.php";

    $conn = new Database();
    $pdo = $conn->getConnect();
    $user_id = null;
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (isset($_GET["id"])) {
            $user_id= $_GET["id"];
        }
    }
    if(User::deleteUserByUserId($pdo, $user_id))
        header("location: edit_user.php");
    else
        echo "<script>alert('Có lỗi xảy ra, không thể xóa!'); window.location.href='edit_user.php';</script>";
?>