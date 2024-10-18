<?php



function menu_aside(){
    $product_class = 'modify_element';

    return array(

        'edit-datas' => [
            'name' => 'Cambia dati',
            'url' => 'user-edit'
        ],


        'edit-password' => [
            'name' => 'Cambia password',
            'url' => 'user-editPassword'
        ],


        'orders' => [
            'name' => 'Storico ordini',
            'url' => 'orders-list'
        ],

        ######  Amministratore #####

        'admin' => strtoupper('Amministratore'),


        'orders-list' => [
            'name' => 'Elenco ordini utenti',
            'url' => 'pdf/orders_list.php'
        ],


        'orders-search' => [
            'name' => 'Cerca ordine cliente',
            'url' => 'orders-search'
        ],


        'categories' => 'Gestisci categorie',


        'products' => 'Gestisci prodotti',


        'add-category' => [
            'name' => 'Aggiungi categoria',
            'url' => 'show-type'
        ],


        'edit-category' => [
            'name' => 'Modifica categoria',
            'url' => 'update-type'
        ],


        'delete-category' => [
            'name' => 'Elimina categoria',
            'url' => 'show-type?delete'
        ],


        'products-list' => [
            'name' => 'Lista prodotti',
            'url' => 'pdf/products_list.php'
        ],


        'add-product' => [
            'name' => 'Aggiungi prodotto',
            'url' => 'show-product'
        ],


        'edit-product' => [
            'name' => 'Modifica prodotto',
            'class' => $product_class,
            'data' => 'modify'
        ],


        'delete-product' => [
            'name' => 'Elimina prodotto',
            'class' => $product_class,
            'data' => 'delete'
        ],


        'logout' => 'Logout'

    );
}