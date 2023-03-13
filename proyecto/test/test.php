<?php
require_once('../vendor/autoload.php');
use Dotenv\Dotenv;
use App\Models\Equipo;

session_start();

$dotenv = Dotenv::createImmutable(__DIR__,'/..');
$dotenv->load();
?>