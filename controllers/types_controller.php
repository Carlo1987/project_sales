<?php

class Types_controller{


    public function index(){
        $types_class = new Type();
        $types = $types_class->getTypes();
        $paginate = new Paginate();

        require 'views/layouts/main.php';
    }


    public function show(){
        require 'views/types/new_type.php';
    }


    public function add(){
        $type = new Type();
        if(isset($_POST['type'])){
            $type_name = $_POST['type_name'];

            $type -> setName($type_name);
            $type -> addType();

        }

        if(isset($_POST['modify_type'])){
            $old_type = $_POST['old_type'];
            $type_name = $_POST['type_name'];

            $type -> modifyType($type_name, $old_type);
        }

        global $host;
       echo "<h2>... Caricamento ... </h2> <script> window.location.href = 'https://$host/progetti/progetto_vendita/index.php' </script>";
    }


    public function modify(){
        require 'views/types/modify_type.php';
    }


    
    public function deleteType(){
        if(isset($_POST['type_id']) && !empty($_POST['type_id'])){
            $id = $_POST['type_id'];

            $type = new Type();
            $type->delete($id);

            global $host;
            echo "<h2>... Cancellazione in corso ... </h2> <script> window.location.href = 'https://$host/progetti/progetto_vendita/index.php' </script>";
        }
    }



}