<?php
session_start();
$_SESSION['iniciada'] = false;
$_SESSION['intentos'] = 0;
header('Location: index.php');