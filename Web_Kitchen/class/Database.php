
<?php
    class Database{
        public function getConnect(){
            $host = "localhost";
            //$db = "mydb";
            //$username = "phatweb";
            //$password = "cDlAYr1Eaxk9C3Cq";

            $db = "mydb";
            $username = "root";
            $password = "mysql";

            $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";

            try {
                $pdo = new PDO($dsn, $username, $password);

                if ($pdo) {
                    return $pdo;
                }
            } catch (PDOException $ex) {
                echo $ex->getMessage();
            }
        }
    }
?>
