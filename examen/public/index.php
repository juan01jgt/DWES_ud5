<?php

use Dotenv\Parser\Value;

require_once("../vendor/autoload.php");
include_once("../app/models/connection.php");
include_once("../app/config.php");
include_once("lib/functions.php");

$db = Connection::getInstance($connection,$host,$name,$username,$password)->connect();

session_start();

$book;
$msgError="";
if (!isset($_SESSION['iniciada'])) {
    $_SESSION['iniciada'] = false;
    $_SESSION['intentos'] = 0;
    $_SESSION['usuarioanterior'] = "";
}

if (isset($_POST["login"])) {
    $user= limpiarDatos($_POST['user']);
    $pass= limpiarDatos($_POST['pass']);
    $sql= "SELECT* FROM usuarios WHERE `user` LIKE '".$user."' AND `psw` LIKE '".$pass."';";
    $resultado = $db->query($sql)->fetchAll();
    // print_r($resultado);
    if (!empty($resultado)) {
        if ($resultado[0]["bloqueado"]) {
            $msgError="Usuario bloqueado, pongase en contacto con el administrador";
        }
        else {
            $_SESSION['iniciada'] = true;
            $_SESSION['tipousu'] = $resultado[0]["perfil"];
            $_SESSION['id'] = $resultado[0]["id"];
        }
    }
    else{
        if ($_SESSION['usuarioanterior']==$user) {
            $_SESSION['intentos']++;
        }else{
            $_SESSION['intentos'] = 1;
        }
        $msgError="Error en credenciales";
        if ($_SESSION['intentos']>3) {
            $sql= "UPDATE `usuarios` SET `bloqueado` = '1' WHERE `usuarios`.`user` = '".$user."'";
            $resultado = $db->query($sql);
            $msgError="Usuario bloqueado, pongase en contacto con el administrador";
        }
        $_SESSION['usuarioanterior'] = $user;
    }
}

if ($_SESSION['iniciada']) {
    $sql= "SELECT * FROM bookmarks WHERE idUsuario LIKE '%".$_SESSION['id']."%'";
    $book = $db->query($sql)->fetchAll();
    if ($_SESSION['tipousu'] == "admin") {
        $sql= "SELECT * FROM usuarios";
        $users = $db->query($sql)->fetchAll();
    }
}

if (isset($_POST["bloqueados"])) {
    foreach ($users as $key => $value) {
        if (isset($_POST[$value['id']])) {
            $sql= "UPDATE `usuarios` SET `bloqueado` = '1' WHERE `usuarios`.`id` = '".$value['id']."'";
            $resultado = $db->query($sql);
        }
        else{
            $sql= "UPDATE `usuarios` SET `bloqueado` = '0' WHERE `usuarios`.`id` = '".$value['id']."'";
            $resultado = $db->query($sql);
        }
    }
    if ($_SESSION['tipousu'] == "admin") {
        $sql= "SELECT * FROM usuarios";
        $users = $db->query($sql)->fetchAll();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookmarks</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Bookmarks</h1>
    <div>
        <?php
            if (!$_SESSION['iniciada']) {
                include("include/login_form.html");
                echo $msgError;
            }
            else{
                echo '<br><a href="logout.php">Salir</a>';
            }
            ?>
    </div>
    <br>
    <div>
        <?php
            if ($_SESSION['iniciada']) {
                if ($_SESSION['tipousu'] == "admin") {
                    echo('<h3>Usuarios bloqueados</h3>');
                    echo('<form action="" method="post">');
                    foreach ($users as $key => $value) {
                        echo('<label for=""><input type="checkbox" name="'.$value['id'].'" value ="'.$value['bloqueado'].'" '.($value['bloqueado']?"checked":"").'>'.$value['user'].'</label></br>');
                    }
                    echo('<input type="submit" name="bloqueados" value="Guardar cambios"></form>');
                }
            }
        ?>
    </div>
    <br>
    <div>
        <?php
            if ($_SESSION['iniciada']) {
                echo("<h3>Bookmarks guardados</h3>");
                echo('<a href="crear.php">Crear Nuevo</a>');
                echo('<table id="tabla" border="1px solid">');
                echo('<tr><th>Enlace</th><th>Descripción</th></tr>');
                foreach ($book as $key => $value) {
                            echo('<tr><td><a href="'.$value["bm_url"].'">'.$value["bm_url"].'</a></td><td>'.$value["descripcion"].'</td><td><a href="eliminar.php?id='.$value['id'].'">Eliminar</a></td></tr>');
                }
                echo('</table>');
            }
        ?>
    </div>
</body>
</html>