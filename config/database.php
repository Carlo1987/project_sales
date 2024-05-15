<?php

class Database{

    public static function conexion(){
   
       $host = 'localhost';
       $root = 'root';
       $password = '';
       $db = 'vendita';
 

        $database = new mysqli($host, $root, $password, $db);

        $database -> query("SET NAMES 'utf8'");

        return $database;
    }
}

session_start();