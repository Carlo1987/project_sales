<?php

class Paginate
{
    private $database;

    public function __construct()
    {
        $this->database = Database::conexion();
    }



    public function getPaginate($model, $filter) {
           
        if(!isset($_GET['page'])){
           $start = 0;
        }else{
            $start = ($_GET['page'] - 1) * $filter;
        }

        $query = "SELECT * FROM {$model} LIMIT {$start},{$filter}";
        $show = $this->database->query($query);

        return $show;
    }


    public function linksPaginate($model, $filter) {
        $counter = 0;

        $product_class = new Product();
        $types = $this->database->query("SELECT * FROM {$model}");

        while($type = $types->fetch_object()){
            $products = $product_class->getProducts_index($type->id);

            if($products->num_rows > 0){
                $counter++;
            }
        }

        $pages = ceil($counter / $filter);
       
        return $pages;
    }


    public function arrowLeft(){
        if(isset($_GET['page'])){
            $counter = $_GET['page'] - 1;
            if($counter > 1){
                return 'home?page='.$counter;
            }else{
                return 'home';
            } 
        }
    }



    public function arrowRight($limit){
        if(isset($_GET['page'])){
           $counter = $_GET['page'];
        }else{
            $counter = 1;
        }

        if($counter < $limit){
            $counter++;
            return 'home?page='.$counter;
        }
      
    }




}
