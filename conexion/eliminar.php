<?php
include_once("config/config.php");

session_start();
if ($_SESSION['usuario']=='invitado') {
    header('Location:index.php');
}

$db = conectaDB();

$editar = false;
$nombre = "";
$sql="";

if (isset($_GET['confirmar'])) {
    $sql = "DELETE FROM `equipos` WHERE `equipos`.`id` = ".$_GET['id'];
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
    <h1>CB Pokemons</h1>
    <h2>¿Estas seguro de que quieres eliminarlo?</h2>
    <a href="eliminar.php?confirmar=true&id=<?php echo $_GET['id'] ?>">Si, eliminar</a>
    <br>
    <a href="index.php">Cancelar</a>
    <br>
</body>
</html>