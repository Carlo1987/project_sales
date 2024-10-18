<?php

class User{

    private $name;
    private $surname;
    private $gender;
    private $email;
    private $password;
    private $image;
    private $database;

    public function setName($elem){
        return $this -> name = $this -> database -> real_escape_string($elem);
    }

    public function setSurname($elem){
        return $this -> surname = $this -> database -> real_escape_string($elem);
    }

    public function setGender($elem){
        return $this -> gender = $this -> database -> real_escape_string($elem);
    }

    public function setEmail($elem){
        return $this -> email = $this -> database -> real_escape_string($elem);
    }

    public function setPassword($elem){
        return $this -> password =  password_hash($this -> database -> real_escape_string($elem), PASSWORD_BCRYPT);
    }

    public function setImage($elem){
        return $this -> image = $elem;
    }


    public function __construct() {
        return $this -> database = Database::conexion();
    }



    public function list(){
        $sql = "SELECT * FROM users ORDER BY surname ASC";
        $list = $this -> database -> query($sql);

        if($list){
            return $list;
        }else{
            return false;
        }
    }


    public function verify_email($email){
        $sql = "SELECT * FROM users WHERE email = '{$email}'";
        $login = $this -> database -> query($sql);

        if($login && $login->num_rows==1){
            return $login->fetch_object();
        }else{
            return false;
        }
    }


    public function search_User_byID($id){
        $sql = "SELECT * FROM users WHERE id = '{$id}'";
        $search = $this->database->query($sql);

        if($search && $search->num_rows == 1){
            return $search->fetch_object();
        }
    }


    public function search_User_byElements($name, $surname, $email){
        $sql = "SELECT id FROM users WHERE name = '$name' AND surname = '$surname' AND email = '$email'";
        $search = $this->database->query($sql);

        if($search && $search->num_rows == 1){
            return $search->fetch_object();
        }else{
            return false;
        }
    }

    
    public function save_User(){
        $sql = "INSERT INTO users VALUES(NULL, '{$this->name}', '{$this->surname}', '{$this->gender}','{$this->email}', '{$this->password}', '{$this->image}', 'admin')";
        $save = $this -> database -> query($sql);
        return $save;
    }


    public function modify_User($id){
        $sql = "UPDATE users SET name = '{$this->name}', surname = '{$this->surname}', gender = '{$this->gender}', email = '{$this->email}', image = '{$this->image}' WHERE id = '{$id}'";
        $save = $this -> database -> query($sql);
        return $save;
    }


    public function modify_User_password($id){
        $sql = "UPDATE users SET password = '{$this->password}' WHERE id = '{$id}'";
        $save = $this -> database -> query($sql);
        return $save;
    }


    public function modify_role($role,$id){
        $sql = "UPDATE users SET role = '$role' WHERE id = '$id'";
        $save = $this -> database -> query($sql);

        if($save){
            return $save;
        }else{
            return false;
        }
    }



    public function modify_password($email){
        $sql = "UPDATE users SET password = '{$this->password}' WHERE email = '$email'";
        $update = $this -> database -> query($sql);

        if($update){
            return $update;
        }else{
            return false;
        }
    }


}