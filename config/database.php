<?php

class Database{

    public static function conexion(){

        global $database_datas;       # dati per connessione al database di "security.php"

       $host = $database_datas['host'];
       $user = $database_datas['user'];
       $password = $database_datas['password'];
       $db = $database_datas['database']; 

        $database = new mysqli($host, $user, $password, $db);

        $database -> query("SET NAMES 'utf8'");

        return $database;
    }
}

session_start();