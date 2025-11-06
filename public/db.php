<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "trem_facil";

// Cria a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se a conexão falhou
if ($conn->connect_error) {
    die("Conexao falhou: " . $conn->connect_error);
}
?>
