<?php
define('BD','bd_cb_pokemons');
define('USUARIO','us_cb_pokemons');
define('PASS','us_cb_pokemons');

function conectaDB(){
    try {
        $db = new PDO("mysql:host=localhost; dbname=".BD,USUARIO,PASS);
        $db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY,true);
        $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
        return ($db);
    } catch (PDOException $e) {
        echo "Error conexion";
        exit();
    };
}
?>