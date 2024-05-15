<?php

class Products_controller
{

    public function products_for_type()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $type_class = new Type();
            $type = $type_class->getOne($id);

            $product_class = new Product();
            $products = $product_class->getProducts_index($id);

            require_once 'views/products/products_for_type.php';
        }
    }


    public function product_one()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $product_class = new Product();
            $product = $product_class->getOneProducts($id);

            require_once 'views/products/product_single.php';
        }
    }


    public function show()
    {
        require 'views/products/add_product.php';
    }


    public function add()
    {
        if (isset($_POST['product'])) {
            $type_id = $_POST['type'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $discount = $_POST['discount'];
            $stock = $_POST['stock'];

           if($name == '' || $description == '' || $price == '' || $stock == ''){
            $_SESSION['product_error'] = "<div class='errors'>Compila tutti i campi</div>";
            $urlPrevious = $_SERVER['HTTP_REFERER'];
            echo "...Caricamento... <script> window.location.href='$urlPrevious' </script>";

           }else{
            $product = new Product();
            $description= str_replace("'",'%',$description);

            $product -> setTypeId($type_id);
            $product -> setName($name);
            $product -> setDescription($description);
            $product -> setPrice($price);
            $product -> setDiscount($discount);
            $product -> setStock($stock);
            $product -> setEndStock(null);

            $image = $_FILES['image'];
            $image_name = $image['name'];
            $image_type = $image['type'];
            $image_tmp = $image['tmp_name'];

            $type_class = new Type();
            $type = $type_class -> getOne($type_id);

        if(isset($_FILES['image']) && !empty($_FILES['image']) && $image_name != ''){
     
            if($image_type == 'image/jpeg' || $image_type == 'image/jpg' || $image_type == 'image/png' || $image_type == 'image/gif'){
                if(!is_dir('assets/img/products/'.$type->name)){
                    mkdir('assets/img/products/'.$type->name);
                }

                $folder = array();  # array vuoto
                if($files = opendir('assets/img/products/'.$type->name)){
                 while(true == $file = readdir($files)){
                   if($file != '.' && $file != '..'){
                     $folder[] = $file; # metto ogni file dentro l'array
                   } 
                 }
                }
                
                $search = in_array($image_name, $folder); 
                if(!$search){
                    move_uploaded_file($image_tmp, 'assets/img/products/'.$type->name.'/'.$image_name);
                }
                $product -> setImage($image_name);
                unset($folder);
            }
        }else if($image_name == '' && isset($_GET['id'])){
            $thisProduct = $product->getOneProducts($_GET['id']);
            $product->setImage($thisProduct->image);

        }else if($image_name == '' && !isset($_GET['id'])){
            $_SESSION['product_error'] = "<div class='errors'>Inserisci un'immagine del prodotto</div>";
            $urlPrevious = $_SERVER['HTTP_REFERER'];
            echo "...Caricamento... <script> window.location.href='$urlPrevious' </script>";
        } 

            if(isset($_GET['id'])){
               $product -> modifyProduct($_GET['id']);
               $text = 'Modifiche in corso';
               
            }else{
                $product -> addProduct();
                $text = 'Caricamento nuovo prodotto in corso';
            }

            global $host;
          echo "<h2>...$text... </h2> <script> window.location.href = 'https://$host' </script>";
        }
      }
    }



    public function find(){
        if(isset($_POST['search'])){
            $name = $_POST['name'];

            $product_class = new Product();
            $products = $product_class -> search($name);

           require 'views/products/search.php';

        }else{
            echo 'errore durante la ricerca, tornare idietro e riprovare';
        }
    }



    public function deleteProduct(){
        if(isset($_GET['id']) && !empty($_GET['id'])){
            $id = $_GET['id'];
            $product = new Product();
            $product->delete($id);

            global $host;
            echo "<h2>... Eliminazione in corso ... </h2> <script> window.location.href = 'https://$host' </script>";
        }  
    }




}
