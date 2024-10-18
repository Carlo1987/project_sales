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
    
                    Utils::route('payment');
               
                }else{
                    Utils::route('home');
                }
           
             }else{  
                $_SESSION['error'] = "Compilare tutti i campi";
                Utils::route('back');
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

        if(isset($_POST['search_order'])){
            $order_user = new Order_user();

            if($_POST['order'] != null) {

                $dates = $_POST['order']; 
                $dates =  (int)$dates;

                $orders = $order_user -> number_order($dates);

                if($orders->num_rows == 0){
                    $_SESSION['error'] = "Numero d'ordine non trovato";
                    Utils::route('orders-search');
                }

                $result = true;
                require 'views/orders_users/orders_list.php';
            }else{
                $_SESSION['error'] = "Non hai inserito nessun numero d'ordine";
                Utils::route('orders-search');
            }
        
        }
    }


}