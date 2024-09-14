<?php 
    setcookie('username', '', time() - 86400*30,'/');
    header("location: index.php");
    
?>