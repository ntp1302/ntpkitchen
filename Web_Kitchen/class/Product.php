
<?php
    class Product{
        public $id;
        public $name;
        public $description;
        public $price;
        public $stock_quantity;
        public $category_id;
        public $image;
        public function __construct($id=0, $name="", $description="", $price=0, $stock_quantity = 0, $category_id = 0){
            $this->id = $id;
            $this->name = $name;
            $this->description = $description;
            $this->price = $price;
            $this->stock_quantity = $stock_quantity;
            $this->category_id = $category_id;
        }

        public static function getAll($pdo){
            $sql = "SELECT product_id, product.name as product_name, price, categories.name as category_name FROM product, categories where product.category_id = categories.category_id";
            $stmt = $pdo->prepare($sql);

            if($stmt->execute()){
                // $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
                // return $products;
                // $stmt->setFetchMode(PDO::FETCH_CLASS, "Product");
                // return $stmt->fetchAll();
                $stmt->setFetchMode(PDO::FETCH_OBJ);  
                return $stmt->fetchAll();
            }
        }
        
        public static function getOneById($pdo, $id){
            $sql = "SELECT * FROM product WHERE product_id=:product_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":product_id", $id, PDO::PARAM_INT);

            if($stmt->execute()){
                //$stmt->setFetchMode(PDO::FETCH_CLASS, "Product");
                //return $stmt->fetch();
                $stmt->setFetchMode(PDO::FETCH_OBJ);  
                return $stmt->fetch();
            }   
        }

        public static function getLastID($pdo){
            $last = end($pdo);
            return $last->id; 
        }
        public static function addProduct($pdo, $name, $price, $image, $cate_id) {
            $sql = "INSERT INTO product (name, price, image, category_id) VALUES (:name, :price, :image, :category_id)";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(":name", $name, PDO::PARAM_STR);
            $stmt->bindParam(":price", $price, PDO::PARAM_INT);
            $stmt->bindParam(":image", $image, PDO::PARAM_STR);
            $stmt->bindParam(":category_id", $cate_id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return true; 
            } else {
                return false;
            }
        }
        public static function deleteProductByID($pdo, $product_id) {
            $sql = "DELETE FROM product WHERE product_id = :product_id";
    
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }
        public static function updateProduct($pdo, $id, $name, $price, $image, $category_id) {
            $sql = "UPDATE product SET name = :name, price = :price, image = :image, category_id = :category_id WHERE product_id = :id";
            $stmt = $pdo->prepare($sql);
        
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->bindParam(":name", $name, PDO::PARAM_STR);
            $stmt->bindParam(":price", $price, PDO::PARAM_INT);
            $stmt->bindParam(":image", $image, PDO::PARAM_STR);
            $stmt->bindParam(":category_id", $category_id, PDO::PARAM_INT);
        
            if ($stmt->execute()) {
                return true; 
            } else {
                return false;
            }
        }
        public static function getProductsByCategory($pdo, $category_id) {
            $sql = "SELECT product_id, product.name as product_name, price, image FROM product WHERE category_id = :category_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":category_id", $category_id, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        }
        
        public static function getCategoryName($pdo, $category_id) {
            $sql = "SELECT name FROM categories WHERE category_id = :category_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":category_id", $category_id, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return $result['name'];
            } else {
                return false;
            }
        }
    }
?>
