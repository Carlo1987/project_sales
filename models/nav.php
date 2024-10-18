<?php


 function nav(){

    return array(
        "categories" => [
            "name" => "Categorie",
            'url' =>   "type-products/{id}",      
            'image' =>  "assets/img/categories.jpg"
        ],

        "contacts" => [
            'name' => "Contatti",
            'url' => "contact",
            'image' => "assets/img/phone.png"
        ],

        "users" => [
            "name" => "Utenti fittizzi",
            "url" => "pdf/users_list.php",
            'image' => 'assets/img/people_group.png'
        ],

        "cart" => [
            "name" => "Carrello",
            "url" => "cart",
            "image" => "assets/img/shopping_cart.png"
        ]
    );
 }







