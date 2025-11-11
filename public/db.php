<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "trem_facil";
$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Conexão com o banco de dados falhou: " . $conn->connect_error);
}

?>