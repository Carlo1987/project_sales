<?php

class Order_user_controller{

    public function order(){
        require 'views/orders_users/order.php';
    }


    public function save(){
        if(isset($_POST['confirm'])){
             $region = $_POST['region'];
             $province = $_POST['province'];
             $city = $_POST['city'];
             $adress = $_POST['adress'];
             $cap = $_POST['cap'];

             if($region != '' && $province != '' && $city != '' && $adress != '' && $cap != ''){
                if(isset($_SESSION['cart'])){
                    $cart = $_SESSION['cart'];
    
                    $total = 0;
                    foreach($cart as $key => $product){
                        $total += $product['total_cost'];
                    }
    
                    $_SESSION['order']['user_id'] = $_SESSION['identity']->id;
                    $_SESSION['order']['region'] = $region;
                    $_SESSION['order']['province'] = $province;
                    $_SESSION['order']['city'] = $city;
                    $_SESSION['order']['adress'] = $adress;
                    $_SESSION['order']['cap'] = $cap;
                    $_SESSION['order']['total'] = number_format($total,2);
    
                    global $host;
                    echo "<h2> ...Caricamento in corso...</h2> <script> window.location.href='https://$host?controller=Order_user_controller&action=payment' </script>";
               
                }else{
                    global $host;
                    echo "<h2> ...Errore, non è presente nessun prodotto nel carrello...</h2>  <script> window.location.href='https://$host'  </script>";
                }
           
             }else{
                $_SESSION['error_order_user'] = "<div class='errors'> Compilare tutti i campi </div>";
                global $host;
                echo "<h2> ...Caricamento in corso...</h2> <script> window.location.href='https://$host?controller=Order_user_controller&action=order' </script>";
            }
        }
    }


    public function payment(){
        require 'views/payment/payment.php';
    }

    
    public function orders_list(){
        $order_user = new Order_user();
        $orders = $order_user -> order($_SESSION['identity']->id);

        require 'views/orders_users/orders_list.php';
    }



    public function search(){
        require 'views/admin/orders_users.php';
      }



    public function find_order(){
        global $host;
        if(isset($_POST['search_order'])){
            $order_user = new Order_user();

            if($_POST['order'] != null) {

                $dates = $_POST['order']; 
                $dates =  (int)$dates;

                $orders = $order_user -> number_order($dates);

                if($orders->num_rows == 0){
                    $_SESSION['order']['error'] = "<div class='errors'> Numero d'ordine non trovato </div>";
                    echo "<h2> ...Ricerca in corso... </h2>
                <script> window.location.href='https://$host?controller=Order_user_controller&action=search' </script>";
                }

                $result = true;
                require 'views/orders_users/orders_list.php';
            }else{
                $_SESSION['order']['error'] = "<div class='errors'> Non hai inserito nessun numero d'ordine </div>";
               echo "<h2> ...Ricerca in corso... </h2>
                <script> window.location.href='https://$host?controller=Order_user_controller&action=search' </script>";
            
            }

        }
    }


}