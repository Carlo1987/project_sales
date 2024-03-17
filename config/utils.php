<?php

class Utils{

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


    public static function delete_token(){
        if(isset($_SESSION['token'])){
            $_SESSION['token'] = null;
        }
    }


    public static function delete_token_error(){
        if(isset($_SESSION['token_error'])){
            $_SESSION['token_error'] = null;
        }
    }


    public static function delete_errors_product(){
        if(isset($_SESSION['product_error'])){
            $_SESSION['product_error'] = null;
        }
    }

    public static function delete_errors_order(){
        if(isset( $_SESSION['error_order_user'])){
            $_SESSION['error_order_user'] = null;
        }
    }


    public static function delete_errors_payment(){
        if(isset($_SESSION['error_payment'])){
            $_SESSION['error_payment'] = null;
        }
    }


     public static function delete_change(){
        if(isset($_SESSION['change'])){
            $_SESSION['change'] = null;
        }

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
    

    public static function delete_orders(){
        if(isset($_SESSION['order'])){
            $_SESSION['order'] = null;
        }
    }


    /////////  AUTENTIFICAZIONE SESSIONE DELL'UTENTE  ///////////

    public static function isIdentity(){
        if(!isset($_SESSION['identity']) || empty($_SESSION['identity'])){
             global $host;
            echo "<h2> ...Devi prima fare il LOGIN... </h2>  <script> window.location.href='https://$host/progetti/progetto_vendita/index.php' </script>"; 
       
        }
    }


        /////////  AUTENTIFICAZIONE UTENTE AMMINISTRATORE  ///////////

    public static function isAdmin(){
        if($_SESSION['identity']->role != 'admin'){
            global $host;
            echo "<h2> ...Devi essere un AMMINISTRATORE... </h2>  <script> window.location.href='https://$host/progetti/progetto_vendita/index.php' </script>" ;
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

              require "emails/email_finish.php";
              return $orders->update_orders($order->id);
    
            }else{ 
                return null;
            }
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
        if(isset($_GET['ending']) && $_GET['ending'] == 'eseguito'){

            unset($_COOKIE['cart']);   
            setcookie('cart','',time()-(60*180),'/');
    
            unset($_COOKIE['identity']);   
            setcookie('identity','',time()-(60*180),'/');
            
            unset($_COOKIE['count_emails']);   
            setcookie('count_emails','',time()-(60*180),'/');
        }
    }



    public static function cookieMarketing(){                     #   creazione cookie di profilazione marketing
        if(isset($_SESSION['identity']) && isset($_COOKIE['marketing'])){
             $cookie = $_COOKIE['marketing'];
             $cookie = explode('-', $cookie);
            if($cookie[0] == 'true'){
                $hour = $cookie[1];
                $minute = $cookie[2];
                $identity = $_SESSION['identity'];                

                $order_model = new Orders_product;
                $order_products = $order_model -> list_user_products($identity->id);

                if($order_products->num_rows >= 1){     
                $types_products= array();
                $products_order_list = array();
                while($product = $order_products->fetch_object()){
                  array_push($types_products , $product->type_name);
                  array_push($products_order_list , $product->name);
                }
     
                $types_count = array_count_values($types_products);
                $major_type_product = array_search(max($types_count) , $types_count);

                $product_model = new Product();
                $products_list = $product_model->getProducts_ByTypeName($major_type_product);

                $rimaining_product = array();
                while($product = $products_list->fetch_object()){
                    $find = in_array($product->name , $products_order_list);
                    if(!$find){
                        array_push($rimaining_product , $product->name);
                    }
                }
           
                $random_number = rand( 0 , count($rimaining_product)-1);
                $random_product = $rimaining_product[$random_number];
                $random_product_data = $product_model->getOneProduct_ByName($random_product);

                $current_hour = date('H');
                $current_minute = date('i');

                if(!isset($_COOKIE['count_emails'])){
                if($current_hour == $hour){
                    if( $current_minute == $minute+1){
                        require "emails/email_marketing.php";
                        setcookie('count_emails' , '1' , time()+(60*8), '/');
                    }

                }else if($current_hour == $hour+1){
                    if($current_minute == 5){
                        require "emails/email_marketing.php";
                        setcookie('count_emails' , '1' , time()+(60*8), '/');
                    }

                }else if($current_hour == 0 && $hour == 23){
                    if($current_minute == 1){
                        require "emails/email_marketing.php";
                        setcookie('count_emails' , '1' , time()+(60*8), '/');
                    }
                } 

                }else if(isset($_COOKIE['count_emails']) && $_COOKIE['count_emails'] == '1'){
                    if($current_hour == $hour){
                        if($current_minute == $minute+10){
                            require "emails/email_marketing.php";
                            setcookie('count_emails' , '2' , time()+(60*3), '/');
                        }
    
                    }else if($current_hour == $hour+1){
                        if($current_minute == 6){
                            require "emails/email_marketing.php";
                            setcookie('count_emails' , '2' , time()+(60*3), '/');
                        }
    
                    }else if($current_hour == 0 && $hour == 23){
                        if($current_minute == 6){
                            require "emails/email_marketing.php";
                            setcookie('count_emails' , '2' , time()+(60*3), '/');
                        }
                    } 
                }
            } 
          }
        }
    }

   





}