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
                    echo "<h2> ...Caricamento in corso...</h2> <script> window.location.href='https://$host/progetti/progetto_vendita/index.php?controller=Order_user_controller&action=payment' </script>";
               
                }else{
                    global $host;
                    echo "<h2> ...Errore, non è presente nessun prodotto nel carrello...</h2>  <script> window.location.href='https://$host/progetti/progetto_vendita/index.php'  </script>";
                }
           
             }else{
                $_SESSION['error_order_user'] = "<div class='errors'> Compilare tutti i campi </div>";
                global $host;
                echo "<h2> ...Caricamento in corso...</h2> <script> window.location.href='https://$host/progetti/progetto_vendita/index.php?controller=Order_user_controller&action=order' </script>";
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
            $user = new User();

            if($_POST['order'] != null && $_POST['user'] == null && $_POST['email'] == null) {
                $search_order = true;
                $dates = $_POST['order']; 
                $dates =  (int)$dates;

                $orders = $order_user -> number_order($dates);

                if($orders->num_rows == 0){
                    $_SESSION['order']['error'] = "<div class='errors'> Numero d'ordine non trovato </div>";
                    echo "<h2> ...Ricerca in corso... </h2>
                <script> window.location.href='https://$host/progetti/progetto_vendita/index.php?controller=Order_user_controller&action=search' </script>";
                }

            }else if($_POST['user'] != null && $_POST['email'] != null && $_POST['order'] == null){
                $user_dates = $_POST['user'];
                $email = $_POST['email'];

                $user_dates = explode(' ', $user_dates);
                $surname = $user_dates[0];
                $name = $user_dates[1];

                $verify_user = $user->search_User_byElements($name,$surname,$email);

                if(!$verify_user){
                    $_SESSION['order']['error'] = "<div class='errors'> Utente non trovato </div>";
                    echo "<h2> ...Ricerca in corso... </h2>
                    <script> window.location.href='https://$host/progetti/progetto_vendita/index.php?controller=Order_user_controller&action=search' </script>";
                
                }else{
                    $orders = $order_user -> findUser($name,$surname,$email);
                }
               
            }else if($_POST['user'] == null && $_POST['email'] == null && $_POST['order'] == null){
                $_SESSION['order']['error'] = "<div class='errors'> Devi compilare o il campo di sopra o i due campi di sotto </div>";
               echo "<h2> ...Ricerca in corso... </h2>
                <script> window.location.href='https://$host/progetti/progetto_vendita/index.php?controller=Order_user_controller&action=search' </script>";
            
            }else if($_POST['user'] != null && $_POST['email'] != null && $_POST['order'] != null){
                $_SESSION['order']['error'] = "<div class='errors'> Devi compilare o solo il campo di sopra o solo i due campi di sotto </div>";
               echo "<h2> ...Ricerca in corso... </h2>
                <script> window.location.href='https://$host/progetti/progetto_vendita/index.php?controller=Order_user_controller&action=search' </script>";
            
            }else if($_POST['user'] == null && $_POST['email'] != null && $_POST['order'] == null){
                $_SESSION['order']['error'] = "<div class='errors'> I campi di sotto vanno compilati insieme </div>";
               echo "<h2> ...Ricerca in corso... </h2>
                <script> window.location.href='https://$host/progetti/progetto_vendita/index.php?controller=Order_user_controller&action=search' </script>";
            
            }else if($_POST['user'] != null && $_POST['email'] == null && $_POST['order'] == null){
                $_SESSION['order']['error'] = "<div class='errors'>  I campi di sotto vanno compilati insieme  </div>";
               echo "<h2> ...Ricerca in corso... </h2>
                <script> window.location.href='https://$host/progetti/progetto_vendita/index.php?controller=Order_user_controller&action=search' </script>";
            
            }

            $result = true;
             require 'views/orders_users/orders_list.php';
        }
    }


}