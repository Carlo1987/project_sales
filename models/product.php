<?php

class Product{
    private $type_id;
    private $name;
    private $description;
    private $image;
    private $price;
    private $discount;
    private $stock;
    private $end_stock;
    private $database;

    public function __construct(){
        return $this -> database = Database::conexion();
     }


    public function setTypeId($elem){
        return $this -> type_id = $elem;
    }

    public function setName($elem){
        return $this -> name = $this->database->real_escape_string($elem);
    }

    public function setDescription($elem){
        return $this -> description = $this->database->real_escape_string($elem);
    }

    public function setImage($elem){
        return $this -> image = $elem;
    }

    public function setPrice($elem){
        return $this -> price = $elem;
    }

    public function setDiscount($elem){
        return $this -> discount = $elem;
    }

    public function setStock($elem){
        return $this -> stock = $elem;
    }

    public function setEndStock($elem){
        return $this -> end_stock = $elem;
    }


    public function getProducts(){
        $sql = "SELECT p.*, t.name as 'type' FROM products p INNER JOIN types t ON t.id=p.type_id ORDER BY p.name ASC";
        $select = $this -> database -> query($sql);
        return $select; 
    }


    public function getProduct($id){
        $sql = "SELECT p.*, t.id AS 'type_id' , t.name AS 'type_name' FROM products p INNER JOIN types t ON t.id=p.type_id WHERE p.id = {$id}";
        $result = $this -> database -> query($sql);
        return $result -> fetch_object();
    }


    public function getProducts_index($id){
        $sql = "SELECT p.*, t.name AS 'type_name' FROM products p INNER JOIN types t ON t.id = p.type_id WHERE type_id = {$id} ORDER BY p.name ASC";
        $save = $this -> database -> query($sql);
        return $save;  
    }


    public function getProducts_ByTypeName($name){
        $sql = "SELECT p.* FROM products p INNER JOIN types t ON t.id=p.type_id WHERE t.name='{$name}'";
        $search = $this->database->query($sql);
        return $search;
    }


    public function getOneProducts($dates){
        if(!isset($_SESSION['order'])){
            $sql = "SELECT p.*, t.name AS 'type_name' FROM products p INNER JOIN types t ON t.id=p.type_id WHERE p.id = {$dates}";
        }else{
            $sql = "SELECT p.*, t.name AS 'type_name' FROM products p INNER JOIN types t ON t.id=p.type_id WHERE p.name = '$dates'";
          
        }
       
        $save = $this -> database -> query($sql);
        return $save -> fetch_object();
    }


    public function getOneProduct_ByName($name){
        $sql = "SELECT p.*, t.name AS 'type_name' FROM products p INNER JOIN types t ON t.id=p.type_id WHERE p.name = '$name'";
        $search = $this->database->query($sql);
        if($search->num_rows == 1){
            return $search->fetch_object();
        }else{
            return false;
        }
       
    }


    public function last_product($id){
        $sql = "SELECT * FROM products WHERE type_id = {$id} ORDER BY id DESC LIMIT 1";
        $search = $this->database->query($sql);

        if($search && $search->num_rows == 1){
            return $search->fetch_object();
        }else{
            return false;
        }
    }
  

    public function addProduct(){
        $sql = "INSERT INTO products VALUES(NULL, '{$this->type_id}', '{$this->name}', '{$this->description}', '{$this->image}', '{$this->price}', '{$this->discount}', '{$this->stock}', '{$this->end_stock}' )";
        $save = $this->database->query($sql);
        return $save;
    }


    public function modifyProduct($id){
        $sql = "UPDATE products SET type_id = '{$this->type_id}', name = '{$this->name}', description = '{$this->description}', image = '{$this->image}', price = '{$this->price}', discount = '{$this->discount}', stock = '{$this->stock}' WHERE id = '$id'";
        $update = $this -> database -> query($sql);
        return $update;
    }


    public function modifyStock($quantity, $name){
        if($quantity > 0){
            $sql = "UPDATE products SET stock = '$quantity' WHERE name = '$name'";
        }else{
            $sql = "UPDATE products SET stock = '$quantity', end_stock = CURTIME() WHERE name = '$name'";
        }
       
        $save = $this -> database -> query($sql);
        
        if($save){
            return $save;
        }else{
            return false;
        }
    }


    public function search($name){
        $sql = "SELECT p.*, t.name AS 'type' FROM products p INNER JOIN types t ON t.id = p.type_id
                WHERE p.name LIKE '%$name%' OR p.name LIKE '$name%' OR p.name LIKE '%$name'";
        $search = $this->database->query($sql);

        if($search){
            return $search;
        }else{
            return false;
        }
    }


    public function delete($id){
        if($_GET['action'] == 'deleteType'){
           $sql = "DELETE FROM products WHERE type_id = $id";
        }else{
            $sql = "DELETE FROM products WHERE id = $id";
        }
        
        $delete = $this->database->query($sql);

        if($delete){
            return $delete;
        }else{
            return false;
        }
    }


    public function update_stock($id){
       $sql = "UPDATE products SET stock = 8 WHERE id = $id";
       $update = $this->database->query($sql);

       if($update){
           return $update;
       }else{
           return false;
       }
    }


  


}