<?php

class Type{
    private $name;
    private $database;

    
    public function __construct(){
       return $this -> database = Database::conexion();
    }



    public function setName($elem){
        return $this -> name = $this -> database -> real_escape_string($elem);
    }





    public function getTypes(){
        $paginate = new Paginate();
        $model = "types";
        return $paginate->getPaginate($model, 2);
    }


    public function getAllTypes(){
        $sql = "SELECT * FROM types";
         $save = $this -> database -> query($sql);
 
         return $save; 
     }


    public function getOne($id){
        $sql = "SELECT * FROM types WHERE id = {$id}";
        $save = $this -> database -> query($sql);

        return $save->fetch_object();
    }


    public function getOne_byProduct($name){
        $sql = "SELECT t.* FROM types t INNER JOIN products p ON t.id=p.type_id WHERE p.name = '$name'";
        $search = $this->database->query($sql);

        if($search->num_rows == 1){
            return $search->fetch_object();
        }else{
            return false;
        }
    }


    public function addType(){
        $sql = "INSERT INTO types VALUES(NULL, '{$this->name}')";
        $save = $this -> database -> query($sql);

        if($save){
            return $save;
        }else{
            return false;
        }
    }


    public function modifyType($id){
        $sql = "UPDATE types SET name = '$this->name' WHERE id = '$id'";
        $save = $this -> database -> query($sql);

        if($save){
            return $save;
        }else{
            return false;
        }
    }


    public function delete($id){
        $products = new Product();
        $products->delete($id);

        $sql = "DELETE FROM types WHERE id = $id";
        $delete = $this->database->query($sql);

        if($delete){
            return $delete;
        }else{
            return false;
        }

    }


}