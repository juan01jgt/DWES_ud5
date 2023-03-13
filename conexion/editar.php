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

if (isset($_GET['id'])) {
    $sql = "SELECT * FROM equipos WHERE id=".$_GET['id'];
    $resultado = $db->query($sql);
    foreach ($resultado as $valor) {
        $nombre = $valor['nombre'];
    }
    $editar = true;
}
if (isset($_POST['editar'])) {
    if ($_POST['nombre'] != "") {
        $sql = "UPDATE `equipos` SET `nombre` = '".$_POST['nombre']."' WHERE `equipos`.`id` = ".$_GET['id'];
        $resultado = $db->query($sql);
        header('Location: index.php');
    }
}
if (isset($_POST['agregar'])) {
    if ($_POST['nombre'] != "") {
        $sql = "INSERT INTO `equipos` (`id`, `nombre`) VALUES (NULL, '".$_POST['nombre']."')";
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
    <h1>CB Pokemons</h1>
    <?php
    if ($editar) {
        echo "<h2>Editar equipo</h2>";
    }
    else{
        echo "<h2>Añadir equipo</h2>";
    }
    ?>
    <form action="" method="post">
        <label for="nombre"></label><input type="text" name="nombre" value= <?php echo $nombre ?>>
        <br>
        <?php
            if ($editar) {
                echo "<button type='submit' name='editar'>Editar equipo y volver</button>";
            }
            else{
                echo "<button type='submit' name='agregar'>Añadir equipo y volver</button>";
            }
        ?>
    </form>
    <br>
    <a href="index.php">Volver sin guardar</a>
    <br>
</body>
</html>