<?php

class Types_controller extends Uploads
{

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

            $this->directory = "assets/img/products/$type_name";

            if (mkdir($this->directory)) {

                $type -> setName($type_name);
                $type -> addType();
    
                $_SESSION['success'] = "Categoria aggiunta";

            } else {
               $_SESSION['error'] = "Errore: non è possibile aggiungere questa categoria";
            }

       

        }


        if(isset($_POST['modify_type'])){

            $type = $_POST['old_type'];
            $new_name = $_POST['type_name'];
          
            $type = explode('/',$type);
            $type_id = $type[0];
            $this->directory = "assets/img/products/";
            $old_name = $this->directory.$type[1];

            if(is_dir($old_name)){

                if (!is_dir($this->directory.$new_name)) {

                    if (rename($old_name, $this->directory.$new_name)) {

                        $type_model = new Type();

                        $type_model->setName($new_name);
                        $type_model -> modifyType($type_id);

                        $_SESSION['success'] = "Categoria modificata";

                    } else {
                        $_SESSION['error'] = "Errore: Impossibile modificare la categoria";
                    }
                }else{
                    $_SESSION['error'] = "Questo nome non può essere usato";
                }
            }else{
                $_SESSION['error'] = "La categoria non è presente in archivio";
            }
        }

        Utils::route('back');
    }


    public function modify(){
        require 'views/types/modify_type.php';
    }


    
    public function deleteType(){

        if(isset($_POST['type_id']) && !empty($_POST['type_id'])){

            $type_input = $_POST['type_id'];
            $type_input = explode('/',$type_input);
            $id = $type_input[0];
            $type_name = $type_input[1];


             $products = new Product();
            $type_products = $products->getProducts_index($id);
              
            
            if($type_products->num_rows == 0){

                $this->directory = "assets/img/products/".$type_name;
        
                if (rmdir($this->directory)) {

                    $type = new Type();
                    $type->delete($id);
        
                    $_SESSION['success'] = "Categoria eliminata";

                } else {
                    $_SESSION['error'] = "Questa categoria non è presente in archivio";
                } 
            }else{          
                $_SESSION['error'] = "Eliminazione negata perchè questa categoria ha ancora dei prodotti";
            }   

           Utils::route('back');
        }
    }



}