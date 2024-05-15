<?php

class Orders_prod_controller{

    public function cart(){
        require 'views/orders_products/show.php';
    }
    

    public function orders(){
      global $host;

      if(isset($_SESSION['identity'])){
        if(isset($_POST['buy'])  && $_GET['id']){
            $id = $_GET['id'];
            $quantity = $_POST['quantity_number'];

            $product_class = new Product();
            $product = $product_class -> getOneProducts($id);

        if($product->stock > 0){
          if(($product->stock - $quantity) >= 0){

            $cart = array();

            $cart['product_id'] = $product->id;
            $cart['user_id'] = $_SESSION['identity']->id;
            $cart['name'] = $product->name;
            $cart['image'] = $product->image;
            $cart['type'] = $product->type_name;
            $cart['quantity'] = $quantity;
            
            $price = number_format($product->price - ($product->price * ($product->discount / 100)), 2);
            $cart['price'] = $price;
            $total = $price * $quantity;
            $cart['total_cost'] = $total; 

            if(!isset($_SESSION['cart'])){
              $_SESSION['cart'][1]= $cart;

             }else{ 
                $index = false;
    
                  foreach($_SESSION['cart'] as $key => $product){
                     if($product['name'] == $cart['name']){
                      $index = $key;
                    } 
                 }  

                 if(!$index){
                  $_SESSION['cart'][] = $cart;

                 }else{
                  if(!isset($_GET['edit'])){
                    $_SESSION['cart'][$index]['quantity'] += $cart['quantity'];
                    $_SESSION['cart'][$index]['total_cost'] += $cart['total_cost'];

                  }else{
                    $_SESSION['cart'][$index]['quantity'] = $cart['quantity'];
                    $_SESSION['cart'][$index]['total_cost'] = $cart['total_cost'];
                  }
                }
             }
          
     // header('Location: index.php?controller=Orders_prod_controller&action=cart');
      echo "<h2>... Caricamento in corso ... </h2> <script> window.location.href = 'https://$host?controller=Orders_prod_controller&action=cart' </script>";

      }else{  #  se $product->stock - $quantity < 0
        $_SESSION['error_stock'] = "Spiacenti, restano solo $product->stock articoli in magazzino";
      //  header('Location: index.php?controller=Products_controller&action=product_one&id='.$product->id);
      echo "<h2>... Caricamento in corso ... </h2> <script> window.location.href = 'https://$host?controller=Products_controller&action=product_one&id='$product->id </script>";
      }

      }else{   # se $product->stock <= 0
       // header('Location: index.php?controller=Products_controller&action=product_one&id='.$product->id);
       echo "<h2>... Caricamento in corso ... </h2> <script> window.location.href = 'https://$host?controller=Products_controller&action=product_one&id='$product->id </script>";
      }
        }else{  # se non arriva il post buy e il get id
            echo "<div class='noResult_search'> Errore di procedura dell'ordine </div>";
        }

      }else{  # se non esiste la sessione identity
        echo "<div class='noResult_search'> Effettua il LOGIN per poter acquistare </div>";
      }  
    }


    public function delete(){
       if(isset($_GET['index'])){
          $index = $_GET['index'];
      
          foreach($_SESSION['cart'] as $key => $value){
             if($value['product_id'] == $index){
                unset($_SESSION['cart'][$key]);
            }   
          } 
       }
 
       global $host;
      echo "<h2>... Caricamento in corso ... </h2> <script> window.location.href = 'https://$host?controller=Orders_prod_controller&action=cart' </script>";
    }



 
}