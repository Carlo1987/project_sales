<?php

require 'config/private.php';

require 'config/database.php';
require 'config/utils.php';
require 'config/validate.php';
require 'config/uploads.php';
require 'config/paginate.php';

require 'models/nav.php';
require 'models/menu_aside.php';
require 'models/type.php';
require 'models/product.php';
require 'models/user.php';
require 'models/order_product.php';
require 'models/order_user.php';
require 'models/payment.php';

require 'controllers/products_controller.php';
require 'controllers/users_controller.php';
require 'controllers/types_controller.php';
require 'controllers/orders_prod_controller.php';
require 'controllers/orders_user_controller.php';
require 'controllers/payment_controller.php';


class Router {
    public $routes = [];


    public function addRoute($method, $path, $handler) {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $this->preparePath($path),
            'handler' => $handler,
        ];
    }

   

    private function preparePath($path) {     
        return preg_replace('/{(\w+)}/', '([^/]+)', $path);
    }



    public function dispatch($requestMethod, $requestPath) {
        global $url_general;

        foreach ($this->routes as $route) {          
            if ($route['method'] === strtoupper($requestMethod)) {

                if (preg_match('#^' . $url_general . $route['path'] . '$#', $requestPath, $matches)) { 
                    array_shift($matches);   
           
                    return call_user_func_array($route['handler'], $matches); 
                }
            } 
        }
        http_response_code(404);
        require 'error.php';
    }




    public function generateUrl($path, $params = []) {

        foreach ($params as $key => $value) {
            $path = str_replace('{' . $key . '}', $value, $path);
        }
        return $path;
    }

}



##############      Definire rotte (routes.php)   ############


$router = new Router();

require_once 'routes.php';


##############      "Pulire" la rotta durante l'uso in locale   ############

function clearPath(){
   $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


  if(strpos($path, '/progetti/progetto_vendita/') !== false){
    $path = str_replace('/progetti/progetto_vendita/','/',$path);
   } 

   return $path;

}



##############      Variabili che andranno messe come parametri del metodo "$router->dispach" nella view "index.php"   ############

$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestPath = clearPath();



##############      Metodo per caricare le rotte nelle varie views   ############

function url($url){                          
    global $host;
    return $host.$url;
}

