<?php

class Payment_controller{

     public function pay(){
        if(isset($_POST)){
         $verify = false;

         if(isset($_POST['card'])){
            if($_POST['name'] != '' && $_POST['surname'] != '' && $_POST['code'] != '' && $_POST['month'] != '' && $_POST['year'] != '' && $_POST['security'] != ''){

               if(strlen($_POST['code']) != 16 ){
                  $_SESSION['error'] = "Il numero di carta deve essere di 16 caratteri";
                  Utils::route('back');

               }else{
                  $name = $_POST['name'];
                  $surname = $_POST['surname'];
                  $type = 'carta di debito';
                  $code = $_POST['code'];
                  $month = $_POST['month'];
                  $year = $_POST['year'];
                  $security = $_POST['security'];
                  $bic = '';
                  $iban = '';
   
                  global $verify;
                  $verify = true;
               }
   
            }else{
               $_SESSION['error'] = "Compilare tutti i campi";
               Utils::route('back');
            } 
            

        }else if(isset($_POST['bank'])){
           if($_POST['dates'] != '' && $_POST['iban'] != ''){

            if(strlen($_POST['iban']) != 33){
               $_SESSION['error'] = "Iban non valido, segui l'esempio sopra";
               Utils::route('back');
            
            }else{
               $dates = $_POST['dates'];
               $dates = explode(' ',$dates);
               $name = $dates[0];
               $surname = $dates[1];
               $type = 'bonifico';
               $code = '';
               $month = '';
               $year = '';
               $security = '';
               $bic = $_POST['bic'];
               $iban = $_POST['iban'];
   
               global $verify;
               $verify = true;
            }

           }else{
            $_SESSION['error'] = "I campi IBAN e NOME TITOLARE sono obbligatori";
            Utils::route('back');
           }
        }


        if($verify){
           $order = $_SESSION['order'];
           $cart = $_SESSION['cart'];

           /////  salvo ordine /////
           $order_user = new Order_user();

           $order_user-> setUser_id($_SESSION['identity']->id);
           $order_user-> setRegion($order['region']);
           $order_user-> setProvince($order['province']);
           $order_user-> setCity($order['city']);
           $order_user-> setAdress($order['adress']);
           $order_user-> setCap($order['cap']);
           $order_user-> setTotal($order['total']);
           $order_user->save();

           $last_order = $order_user->maxID();
               
            ///// salvo prodotti relativi all'ordine //////
           $order_product = new Orders_product();
           $product_class = new Product();
       
           foreach($cart as $key => $product){
               $order_product -> setUser_id($_SESSION['identity']->id);
               $order_product -> setOrderUser_id($last_order->id);
               $order_product -> setName($product['name']);
               $order_product -> setImage($product['image']);
               $order_product -> setCost($product['price']);
               $order_product -> setQuantity($product['quantity']); 
               $order_product -> setTotal($product['total_cost']);
               $order_product -> save_order();

               $single_product = $product_class -> getOneProducts($product['name']);
               $new_stock = $single_product->stock - $product['quantity'];
               $product_class -> modifyStock($new_stock, $product['name']);
            }

            ////  salvo metodo di pagamento ///////////
            $payment = new Payment();

            $payment->setOrder_id($last_order->id);
            $payment->setUser_id($_SESSION['identity']->id);
            $payment->setType($type);
            $payment->setName($name);
            $payment->setSurname($surname);
            $payment->setCard($code);
            $payment->setMonth($month);
            $payment->setYear($year);
            $payment->setCode($security);
            $payment->setBic($bic);
            $payment->setIban($iban);
            $payment->save();

            require "views/emails/email_payments.php";

            unset($_SESSION['order']);
            unset($_SESSION['cart']);

            Utils::route('order-completed');
        }
      }
     }


     public function end_order(){
        require ('views/payment/end.php');
     }





}