<?php

class Orders_product{
    private $user_id;
    private $order_user_id;
    private $name;
    private $image;
    private $cost;
    private $quantity;
    private $total_cost;
    private $database;


    public function __construct() {
        return $this -> database = Database::conexion();
    }


    public function setUser_id($elem){
        return $this-> user_id = $elem;
    }

    public function setOrderUser_id($elem){
        return $this-> order_user_id = $elem;
    }

    public function setName($elem){
        return $this-> name = $elem;
    }

    public function setImage($elem){
        return $this-> image = $elem;
    }

    public function setCost($elem){
        return $this-> cost = $elem;
    }

    public function setQuantity($elem){
        return $this-> quantity = $elem;
    }

    public function setTotal($elem){
        return $this-> total_cost = $elem;
    }



public function save_order(){
    $sql = "INSERT INTO orders_products VALUES(NULL, '{$this->user_id}', '{$this->order_user_id}','{$this->name}', '{$this->image}', '{$this->cost}', '{$this->quantity}', '$this->total_cost' )";
    $save = $this->database-> query($sql);

    if($save){
        return $save;
    }else{
        return false;
    }
}


public function list_products($id){
    $sql = "SELECT * FROM orders_products WHERE order_user_id = $id";
    $list = $this->database-> query($sql);

    if($list){
        return $list;
    }else{
        return false;
    }
}



public function list_user_products($id){
   $sql = "SELECT o.*, t.id as 'type_id', t.name as 'type_name' FROM orders_products o INNER JOIN products p ON p.name=o.name
           INNER JOIN types t ON t.id=p.type_id 
           WHERE o.user_id = $id";
   $list = $this->database-> query($sql);

   if($list){
    return $list;
   }else{
    return false;
   }
}



}