<?php
include_once("Class/database.php");

$hostname = "localhost";
$bancodedados = "dario";
$usuario = "root";
$senha = "";

$database = new Database($hostname, $bancodedados, $usuario, $senha);
$database->conectar(); // Estabelece a conexão com o banco de dados



