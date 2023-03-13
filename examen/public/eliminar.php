<?php
require_once("../vendor/autoload.php");
include_once("../app/models/connection.php");
include_once("../app/config.php");
include_once("lib/functions.php");

session_start();
$db = Connection::getInstance($connection,$host,$name,$username,$password)->connect();

$puedeeliminar=true;
$sql = "SELECT* FROM `bookmarks` WHERE `bookmarks`.`id` = ".$_GET['id'];
$resultado = $db->query($sql)->fetchObject();

if (!$_SESSION['iniciada'] || $resultado->idUsuario != $_SESSION['id']) {
    header('Location:index.php');
    $puedeeliminar=false;
}

if (isset($_GET['confirmar']) && $puedeeliminar) {
    $sql = "DELETE FROM `bookmarks` WHERE `bookmarks`.`id` = ".$_GET['id'];
    $resultado = $db->query($sql);
    header('Location: index.php');
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Bookmarks</h1>
    <h2>¿Estas seguro de que quieres eliminarlo?</h2>
    <a href="eliminar.php?confirmar=true&id=<?php echo $_GET['id'] ?>">Si, eliminar</a>
    <br>
    <a href="index.php">Cancelar</a>
    <br>
</body>
</html>