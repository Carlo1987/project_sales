<?php

class Products_controller extends Uploads
{

    use Validate;

    public function products_for_type($id)
    {  
            $type_class = new Type();
            $type = $type_class->getOne($id);

            $product_class = new Product();
            $products = $product_class->getProducts_index($id);

            require_once 'views/products/products_for_type.php';
    }


    public function product_one($id)
    {
        $product_class = new Product();
        $product = $product_class->getOneProducts($id);

        require_once 'views/products/product_single.php';
    
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
            $discount = (int) $_POST['discount'];
            $stock = (int) $_POST['stock'];

           if($name == '' || $description == '' || $price == '' || $stock == ''){
            $_SESSION['error'] = "Compilare tutti i campi";
           
           
           }else{

            $type_class = new Type();
            $type = $type_class -> getOne($type_id);

            if($this->validatePrice($price)){

                if($this->validateNumber($discount) && $this->validateNumber($stock)){
                    
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

    
                if(isset($_FILES['image']) && !empty($_FILES['image']) && $image_name != ''){
            
                    if($this->validateImage($image_type)){
    
                        if(isset($_GET['id'])){
                            $thisProduct = $product->getProduct($_GET['id']);
                            $this->directory = 'assets/img/products/'.$thisProduct->type_name;
                            $this->image_name = $thisProduct->image;
                            $this->deleteImage(); 
                        }

                        $this->directory = 'assets/img/products/'.$type->name;
                        $this->image_name = $image_name;
                        $this->image_tmp = $image_tmp;
    
                        $this->createDir();
                        $this->saveImage();
                    
                        $product -> setImage($image_name);
                                
                    }else{
                        $_SESSION['error'] = "Formato immagine non valido";
                    }
    
                }else if($image_name == '' && isset($_GET['id'])){
                    $thisProduct = $product->getProduct($_GET['id']);
                    $old_file = 'assets/img/products/'.$thisProduct->type_name.'/'.$thisProduct->image;
                    $new_file = 'assets/img/products/'.$type->name.'/'.$thisProduct->image;
                 
                    $this->moveImage($old_file , $new_file);
                    $product->setImage($thisProduct->image); 
        
                }else if($image_name == '' && !isset($_GET['id'])){
                    $_SESSION['error'] = "Inserisci un'immagine del prodotto";
                } 
    
                    if(isset($_GET['id'])){
                    $product -> modifyProduct($_GET['id']);
                    $_SESSION['success'] = "Prodotto aggiornato";
                                
                    }else{
                        $product -> addProduct();
                        $_SESSION['success'] = "Prodotto aggiunto nella categoria ".strtoupper($type->name);
                    }

                }else{
                    $_SESSION['error'] = 'I campi "Sconto" e "Quantità" devono essere numeri interi'; 
                }

            }else{
                $_SESSION['error'] = "Inserire un formato prezzo come da esempio";
            }
    
        }
        Utils::route('back');
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



    public function deleteProduct($id){

        $product_model = new Product();
        $product = $product_model->getProduct($id);

        $this->directory = 'assets/img/products/'.$product->type_name;
        $this->image_name = $product->image;

        $this->deleteImage(); 
  
        $product_model->delete($id);

        $_SESSION['success'] = "Prodotto eliminato";

        Utils::route('type-products/'.$product->type_id);  
    }




}
