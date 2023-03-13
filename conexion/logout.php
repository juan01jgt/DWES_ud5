<?php
session_start();
$_SESSION['usuario']='invitado';
header('Location: index.php');