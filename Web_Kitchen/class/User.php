
<?php
class User {
    public $username;
    public $password;
    public $email;
    public $full_name;
    public $address;
    public $phone;
    public $security_question;

    public function __construct($username, $password, $email, $full_name, $address, $phone, $security_question) {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->full_name = $full_name;
        $this->address = $address;
        $this->phone = $phone;
        $this->security_question = $security_question;
    }
    public static function addOneUser($pdo, $user) {
        $sql = "INSERT INTO users(username, password, email, full_name, address, phone, security_question) VALUE('$user->username', '$user->password', '$user->email', '$user->full_name', '$user->address', '$user->phone', '$user->security_question')";
        if ($pdo->query($sql)) {
            return true;
        } else {
            return false;
        }
    }
    public static function getOneById($pdo, $id){
        $sql = "SELECT * FROM users WHERE user_id=:user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":user_id", $id, PDO::PARAM_INT);

        if($stmt->execute()){
            //$stmt->setFetchMode(PDO::FETCH_CLASS, "Product");
            //return $stmt->fetch();
            $stmt->setFetchMode(PDO::FETCH_OBJ);  
            return $stmt->fetch();
        }   
    }
    public static function isUsernameExists($pdo, $username) {     
        try {
            $query = "SELECT COUNT(*) FROM users WHERE username = :username";
            $stmt = $pdo->prepare($query);
            $stmt->execute(array(':username' => $username));
            $count = $stmt->fetchColumn();
            if ($count == 0) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }
    public static function deleteUserByUserId($pdo, $user_id) {
        $sql = "DELETE FROM users WHERE user_id = :user_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public static function updateUser($pdo, $id, $email, $full_name, $address, $phone) {
        $sql = "UPDATE users SET email = :email, full_name = :full_name, address = :address, phone = :phone WHERE user_id = :id";
        $stmt = $pdo->prepare($sql);
    
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":full_name", $full_name, PDO::PARAM_STR);
        $stmt->bindParam(":address", $address, PDO::PARAM_STR);
        $stmt->bindParam(":phone", $phone, PDO::PARAM_STR);
    
        if ($stmt->execute()) {
            return true; 
        } else {
            return false;
        }
    }
    public static function getUserByUsernameAndEmail($pdo, $username, $email) {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username AND email = :email');
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function updatePassword($pdo, $username, $hashedPassword) {
        $stmt = $pdo->prepare('UPDATE users SET password = :password WHERE username = :username');
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':username', $username);
        return $stmt->execute();
    }
}

