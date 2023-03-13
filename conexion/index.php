<?php
include_once("config/config.php");
include_once("lib/functions.php");

session_start();
$db = conectaDB();
$sql="";

$msgError="";
if (isset($_SESSION['usuario'])) {
    if (isset($_POST["login"])) {
        $user= limpiarDatos($_POST['user']);
        $pass= limpiarDatos($_POST['pass']);
        $sql= "SELECT COUNT(*) FROM perfiles WHERE usuario LIKE '".$user."' AND contraseña LIKE '".$pass."';";
        $resultado = $db->query($sql)->fetchColumn();
        if ($resultado > 0) {
            $_SESSION['usuario'] = 'Usuario';
        }
        else{
            $_SESSION['usuario'] = 'invitado';
            $msgError="Error en credenciales";
        }
    }
}
else{
    $_SESSION['usuario'] = 'invitado';
}
    
if (isset($_POST['buscar'])) {
    $sql= "SELECT * FROM equipos WHERE nombre LIKE '%".$_POST['buscar']."%'";
}else{
    $sql= "SELECT * FROM equipos";
}

$resultado = $db->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipos</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>CB Pokemons</h1>
    <div>
        <?php
            if ($_SESSION['usuario']=='invitado') {
                include("include/login_form.html");
                echo $msgError;
            }
            else{
                echo 'Usuario: '.$_SESSION['usuario'].'<br><a href="logout.php">Salir</a>';
            }
        ?>
    </div>
    <h2>Lista de equipos</h2>
    <form action="" method="post">
        <?php
            if (isset($_POST['buscar'])) {
                echo '<input type="search" name="buscar" id="" value="'.$_POST['buscar'].'">';
            }else{
                echo '<input type="search" name="buscar" id="">';
            }
        ?>
    </form>
    <div>
        <?php
                if ($_SESSION['usuario']=='Usuario') {
                    echo '<a href="editar.php">Añadir nuevo</a>';
                }
        ?>
    </div>
    <br>
    <div>
        <table id="tabla" border="1px solid">
                <?php
                    foreach($resultado as $valor){
                        echo '<tr><td>'.$valor['nombre'].'</td>';
                        if ($_SESSION['usuario']=='Usuario') {
                            echo '<td><a href="editar.php?id='.$valor['id'].'">Editar </a></td>';
                            echo '<td><a href="eliminar.php?id='.$valor['id'].'">Eliminar</a></td></tr>';
                        }
                    }
                ?>
        </table>
    </div>
</body>
</html>