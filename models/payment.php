<?php

class Payment{
    private $order_id;
    private $user_id;
    private $type;
    private $name;
    private $surname;
    private $card_number;
    private $expiration_month;
    private $expiration_year;
    private $code;
    private $bic;
    private $iban;
    private $database;


    public function __construct(){
        return $this->database = Database::conexion();
    }

    public function setOrder_id($elem){
        return $this-> order_id = $elem;
    }

    public function setUser_id($elem){
        return $this-> user_id = $elem;
    }

    public function setType($elem){
        return $this-> type = $this->database->real_escape_string($elem);
    }

     public function setName($elem){
        return $this-> name = $this->database->real_escape_string($elem);
    }

     public function setSurname($elem){
        return $this-> surname = $this->database->real_escape_string($elem);
    }

    public function setCard($elem){
        return $this-> card_number = $elem;
    }

    public function setMonth($elem){
        return $this-> expiration_month = $this->database->real_escape_string($elem);
    }

    public function setYear($elem){
        return $this-> expiration_year = $this->database->real_escape_string($elem);
    }

    public function setCode($elem){
        return $this-> code = $elem;
    }

    public function setBic($elem){
        return $this-> bic = $this->database->real_escape_string($elem);
    } 

    public function setIban($elem){
        return $this-> iban = $this->database->real_escape_string($elem);
    } 



    public function save(){
        $sql = "INSERT INTO payments VALUES(NULL, '{$this->order_id}', '{$this->user_id}', '{$this->type}', '{$this->name}','{$this->surname}','{$this->card_number}', '{$this->expiration_month}', '{$this->expiration_year}', '{$this->code}', '{$this->bic}', '{$this->iban}')";
        $save = $this -> database -> query($sql);
        return $save;
    }


    

     
public function last_payment(){
    $sql = "SELECT * FROM payments ORDER BY id DESC LIMIT 1";
    $last = $this->database->query($sql);
 
    if($last->num_rows == 1){
        return $last->fetch_object();
    }else{
        false;
    }
 }
}