<?php

class Order_user{
    private $user_id;
    private $region;
    private $province;
    private $city;
    private $adress;
    private $cap;
    private $total_cost;
    private $database;


    public function __construct(){
        return $this->database = Database::conexion();
    }

    public function setUser_id($elem){
        return $this-> user_id = $elem;
    }

    public function setRegion($elem){
        return $this-> region = $this->database->real_escape_string($elem);
    }

    public function setProvince($elem){
        return $this-> province = $this->database->real_escape_string($elem);
    }

    public function setCity($elem){
        return $this-> city = $this->database->real_escape_string($elem);
    }

    public function setAdress($elem){
        return $this-> adress = $this->database->real_escape_string($elem);
    }

    public function setCap($elem){
        return $this-> cap = $elem;
    }

    public function setTotal($elem){
        return $this-> total_cost = $elem;
    } 



    public function list(){
        $sql = "SELECT CONCAT(u.surname,' ',u.name) AS 'user', o.id AS 'id', o.total_cost AS 'total' FROM users u INNER JOIN orders_users o
                ON u.id = o.user_id ORDER BY u.surname ASC";
        $list = $this->database->query($sql);

        if($list){
            return $list;
        }else{
            return false;
        }
    }


    public function save(){
        $sql = "INSERT INTO orders_users VALUES(NULL, '{$this->user_id}', '{$this->region}', '{$this->province}', '{$this->city}', '{$this->adress}', '{$this->cap}', CURTIME(), 'in corso', '{$this->total_cost}')";
        $save = $this->database-> query($sql);

        if($save){
            return $save;
        }else{
            return false;
        }
    }

    
public function maxID(){
    $sql = "SELECT o.*, u.email AS 'email' FROM orders_users o INNER JOIN users u ON u.id=o.user_id ORDER BY id DESC LIMIT 1"; 
    $save = $this->database-> query($sql);

    if($save){
        return $save->fetch_object();
    }else{
        return false;
    }
}

public function total($id){
    $sql = "UPDATE orders_users SET total_cost = '{$this->total_cost}' WHERE id = $id";
    $save = $this->database-> query($sql);

    if($save){
        return $save;
    }else{
        return false;
    }
}



public function order($id){
    $sql = "SELECT * FROM orders_users WHERE user_id = $id ORDER BY id DESC";
    $list = $this->database-> query($sql);

    if($list){
        return $list;
    }else{
        return false;
    }
}


public function number_order($id){
    $sql = "SELECT o.*, CONCAT(u.surname,' ',u.name) as 'user', p.type as 'method', p.card_number as 'card', p.iban as 'bank'
            FROM orders_users o INNER JOIN users u ON u.id = o.user_id INNER JOIN payments p on o.id=p.order_id WHERE o.id = $id";
    $list = $this->database-> query($sql);

    if($list){
        if(!isset($_GET['search'])){
            return $list->fetch_object();

        }else{
            return $list;
        }
       
    }else{
        return false;
    }
}



public function findUser($name,$surname,$email){

       $sql = "SELECT o.* FROM orders_users o INNER JOIN users u ON u.id = o.user_id
        WHERE u.name = '$name' AND u.surname = '$surname' AND  u.email = '$email'";

    $search = $this->database->query($sql);

    if($search){
       return $search;

    }else{
        return false;
    }
}



public function in_progress(){
    $sql = "SELECT o.id, o.hour, u.email as'email' FROM orders_users o INNER JOIN users u ON u.id=o.user_id WHERE state = 'in corso'";
    $select = $this->database->query($sql);
    return $select;
}



public function update_orders($id){
    $sql = "UPDATE orders_users SET state = 'consegnato' WHERE id = $id";
    $update = $this->database->query($sql);
    return $update;
}




}