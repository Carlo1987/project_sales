<?php


# Rotte Types
$router->addRoute('GET', '/home', [new Types_controller(), 'index']);       # index principale
$router->addRoute('GET', '/show-type', [new Types_controller(), 'show']); 
$router->addRoute('GET', '/update-type', [new Types_controller(), 'modify']);
$router->addRoute('POST', '/add-type', [new Types_controller(), 'add']); 
$router->addRoute('GET', '/show-type?delete', [new Types_controller(), 'show']); 
$router->addRoute('POST', '/delete-type', [new Types_controller(), 'deleteType']); 


#Rotte Prodotti
$router->addRoute('GET', '/type-products/{id}', [new Products_controller(), 'products_for_type']); 
$router->addRoute('GET', '/product/{id}', [new Products_controller(), 'product_one']);
$router->addRoute('GET', '/show-product', [new Products_controller(), 'show']);
$router->addRoute('POST', '/add-product', [new Products_controller(), 'add']);
$router->addRoute('POST', '/find-product', [new Products_controller(), 'find']);
$router->addRoute('GET', '/delete-product/{id}', [new Products_controller(), 'deleteProduct']);


#Rotte Utente
$router->addRoute('POST','/user-save',[new Users_controller(), 'save']);
$router->addRoute('POST','/user-login',[new Users_controller(), 'login']);
$router->addRoute('GET','/user-logout',[new Users_controller(), 'logout']);
$router->addRoute('GET','/user-edit',[new Users_controller(), 'change']);
$router->addRoute('GET','/user-editPassword',[new Users_controller(), 'change_password']);
$router->addRoute('GET','/user-resetEmail',[new Users_controller(), 'email_reset']);
$router->addRoute('GET','/user-token',[new Users_controller(), 'verify_token']);
$router->addRoute('POST','/user-sendToken',[new Users_controller(), 'send_token']);
$router->addRoute('GET','/user-resetPassword',[new Users_controller(), 'reset_password']);
$router->addRoute('POST','/user-newPassword',[new Users_controller(), 'new_password']);

$router->addRoute('GET','/contact',[new Users_controller(), 'contacts']);


#Rotte Ordini utente
$router->addRoute('GET','/orders-list',[new Order_user_controller(), 'orders_list']);
$router->addRoute('GET','/orders-search',[new Order_user_controller(), 'search']);
$router->addRoute('POST','/orders-find',[new Order_user_controller(), 'find_order']);
$router->addRoute('GET','/order-user',[new Order_user_controller(), 'order']);
$router->addRoute('POST','/save-order-user',[new Order_user_controller(), 'save']);
$router->addRoute('GET','/payment',[new Order_user_controller(), 'payment']);


#Routte Ordini prodotti
$router->addRoute('POST','/order-products/{id}',[new Orders_prod_controller(), 'orders']);
$router->addRoute('GET','/cart',[new Orders_prod_controller(), 'cart']);
$router->addRoute('GET','/delete-order-product/{id}',[new Orders_prod_controller(), 'delete']);


#Rotte pagamenti
$router->addRoute('POST','/send-payment',[new Payment_controller(), 'pay']);
$router->addRoute('GET','/order-completed',[new Payment_controller(), 'end_order']);


