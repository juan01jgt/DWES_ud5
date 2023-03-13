<?php

use App\Models\bookmarks;

require_once("../vendor/autoload.php");
include_once("../app/models/connection.php");
include_once("../app/config.php");
include_once("lib/functions.php");

session_start();
if (!$_SESSION['iniciada']) {
    header('Location:index.php');
}

$db = Connection::getInstance($connection,$host,$name,$username,$password)->connect();

$sql="";

if (isset($_POST['agregar'])) {
    if ($_POST['enlace'] != "" && $_POST['descripcion'] != "") {
        $sql = "INSERT INTO `bookmarks` (`id`, `bm_url`, `descripcion`, `idUsuario`) VALUES (NULL, '".$_POST['enlace']."', '".$_POST['descripcion']."', '".$_SESSION['id']."')";
        $resultado = $db->query($sql);
        header('Location: index.php');
    }
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
    <h2>Añadir bookmark</h2>
    <form action="" method="post">
        <label for="enlace"></label><input type="text" name="enlace" placeholder="Enlace">
        <label for="descripcion"></label><input type="text" name="descripcion" placeholder="Descripcion">
        <br>
        <button type='submit' name='agregar'>Añadir bookmark y volver</button>
    </form>
    <br>
    <a href="index.php">Volver sin guardar</a>
    <br>
</body>
</html>