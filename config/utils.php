<?php

class Utils{



    public static function title($title){
        if (strlen($title) > 16){
            return  substr($title, 0, 15).'...'; 
        
        }else{
            return $title;
        }
    }


    public static function issetDiscount($prod) {

         if ($prod->discount != 0){
            return "<span class='price_total'> 
                     €$prod->price
                   </span>
                    <span class='discount'>
                        Sconto $prod->discount!!
                    </span>";
         }
    }



    public static function getDiscount($prod){
        return number_format($prod->price - (($prod->price * ($prod->discount / 100))), 2);
    }



    ////////  METODO PER REINDIRIZZARE LE ROTTE  ////////

    public static function route($url):void{
        global $host;
        if($url == 'back'){
            header("Location:".$_SERVER['HTTP_REFERER']);
            exit();
        }
        header("Location:".$host.$url);
        exit();
    }


    ////////  CANCELLAZIONE MESSAGGI ERRORI E VARI  ////////

    public static function delete_aside(){
        if(isset($_SESSION['errors'])){
            $_SESSION['errors'] = null;
        }

        if(isset($_SESSION['register'])){
            $_SESSION['register'] = null;
        }

        if(isset($_SESSION['reset'])){
            $_SESSION['reset'] = null;
        }
    }


    public static function delete_error(){
        if(isset($_SESSION['error'])){
            $_SESSION['error'] = null;
        }
    }


    public static function delete_success(){
        if(isset($_SESSION['success'])){
            $_SESSION['success'] = null;
        }
    }


    public static function delete_token(){
        if(isset($_SESSION['token'])){
            $_SESSION['token'] = null;
        }
    }



     public static function delete_change(){

        if(isset($_SESSION['errors_change'])){
            $_SESSION['errors_change'] = null;
        }
    }    


    public static function delete_role(){
        if(isset($_SESSION['error_role'])){
            $_SESSION['error_role'] = null;
        }

        if(isset($_SESSION['role'])){
            $_SESSION['role'] = null;
        }
    }


    public static function update_product(){
        if(isset($_SESSION['error_stock'])){
            $_SESSION['error_stock'] = null;
        }
    }
    




    /////////  AUTENTIFICAZIONE SESSIONE DELL'UTENTE  ///////////

    public static function isIdentity(){
        if(!isset($_SESSION['identity']) || empty($_SESSION['identity'])){
            header('Location:home');
        }
    }


        /////////  AUTENTIFICAZIONE UTENTE AMMINISTRATORE  ///////////

    public static function isAdmin(){
        if($_SESSION['identity']->role != 'admin'){
            header('Location:home');
        }
    }


    public static function FormatTime($time){
        $time = explode(' ', $time);
        $date = $time[0];
        $hour = $time[1];

        $date = explode('-',$date);
        $date = array_reverse($date);
        $date = implode('-',$date);
       
        return $date.' alle ore '.$hour;
    }


    ///////////   CONSEGNA AUTOMATICA DEI PRODOTTI AL CLIENTE  //////////

    public static function update_orders(){
        if(isset($_SESSION['idendity']) && $_SESSION['identity']->id == 1 || isset($_SESSION['idendity']) && $_SESSION['identity']->id > 8){
            $current_day =  date('d');
            $current_hour = date('H');
            $current_minute =  date('i');
    
            $orders = new Order_user();
            $orders_inProgress = $orders->in_progress();
    
            while($order = $orders_inProgress->fetch_object()){
                $email = $order->email;
    
                $date = $order->hour;
                $date = explode(' ', $date);
                $dates = explode('-',$date[0]);
                $hours = explode(':',$date[1]);
        
                $day = $dates[2];
                $hour = $hours[0];
                $minute = $hours[1];
        
                if($current_day > $day || $current_hour > $hour || $current_minute >= $minute+2){
    
                  require "views/emails/email_finish.php";
                  return $orders->update_orders($order->id);
        
                }else{ 
                    return null;
                }
            }
        }else{ 
            return null;
        }
    }



    /////////////   RIAGGIORNAMENTO AUTOMARICO DEI PRODOTTI ESAURITI NELLO STOCK  ////////////////

    public static function update_stock(){
        $current_day =  date('d');
        $current_hour = date('H');
        $current_minute =  date('i');
    
        $product_class = new Product();
        $products = $product_class->getProducts();

        while($product = $products->fetch_object()){
            if($product->stock == 0){
                
                $date = $product->end_stock;
                $date = explode(' ', $date);
                $dates = explode('-',$date[0]);
                $hours = explode(':',$date[1]);
        
                $day = $dates[2];
                $hour = $hours[0];
                $minute = $hours[1];

                if($current_day > $day || $current_hour > $hour || $current_minute >= $minute+5){

                    return $product_class->update_stock($product->id);
          
                  }else{ 
                      return null;
                  }
            }
        }
    }



    //////////////   QUANTITA' PRODOTTI NEL CARRELLO  /////////////////

    public static function quantityCart(){
        $quantity_products = 0;

        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
              foreach ($_SESSION['cart'] as $product) {
              $quantity_products += $product['quantity'];
              } 

       }else if (isset($_SESSION['cart']) && empty($_SESSION['cart'])) {
             unset($_SESSION['cart']);
       }

       return $quantity_products;
    }



    ////////////////    GESTIONE  COOKIES  ///////////////////

    public static function cookiesIdentity(){          #  creazione cookie tecnico Utente dopo "login"

        if(isset($_SESSION['identity'])){
            $identity = $_SESSION['identity'];
            setcookie('identity', $identity->email, time()+(60*180),'/');
        }
    }


    public static function cartCookie(){               #  creazione cookie tecnico Carrello acquisto dei prodotti
        if(isset($_SESSION['cart'])){
         
           $cart = $_SESSION['cart'];

           $order = "";

           foreach($cart as $key => $product){
            
            $order = $order .$key .'-'.$product['product_id'].'-'.$product['user_id']
                     .'-'.$product['name'].'-'.$product['image'].'-'.$product['type']
                     .'-'.$product['quantity'].'-'.$product['price'].'-'.$product['total_cost']. '/';
           }
        
           setcookie('cart', $order , time()+(60*180),'/');
        }
  }


    public static function recoverSession(){              #  recupero delle sessioni Utente e Carrello prodotti tramite i cookies

        if(!isset($_SESSION['identity'])  && isset($_COOKIE['identity']) && $_COOKIE['identity'] != 'identity'){
              $user_model = new User();
              $user = $user_model->verify_email($_COOKIE['identity']);

              $_SESSION['identity'] = $user;
        }

        if(!isset($_SESSION['cart']) && isset($_COOKIE['cart'])){
            $cart = $_COOKIE['cart'];
            $cart = explode('/',$cart);
           
            $list = array();
            foreach($cart as $product){
                 $product = explode('-',$product);
                 $list['product_id'] = $product[1];
                 $list['user_id'] = $product[2];
                 $list['name'] = $product[3];
                 $list['image'] = $product[4];
                 $list['type'] = $product[5];
                 $list['quantity'] = $product[6];
                 $list['price'] = $product[7];
                 $list['total_cost'] = $product[8];

                 $_SESSION['cart'][$product[0]] = $list;
            } 
        }
    }


    public static function deleteCookies(){                       #   cancellazione cookies dopo il "logout"

            unset($_COOKIE['cart']);   
          //  setcookie('cart','',time()-(60*180),'/');
    
            unset($_COOKIE['identity']);   
           // setcookie('identity','',time()-(60*180),'/');
            
            unset($_COOKIE['count_emails']);   
         //   setcookie('count_emails','',time()-(60*180),'/');
    }





}