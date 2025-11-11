<?php
include 'public/db.php';

$result = $conn->query('SHOW TABLES');
while ($row = $result->fetch_array()) {
    echo $row[0] . PHP_EOL;
}

$result = $conn->query('SELECT * FROM sensor');
while ($row = $result->fetch_assoc()) {
    echo "Sensor: " . $row['nome'] . " - Status: " . $row['status'] . PHP_EOL;
}

$result = $conn->query('SELECT * FROM usuario');
while ($row = $result->fetch_assoc()) {
    echo "Usuario: " . $row['nome_completo'] . " - Email: " . $row['email'] . PHP_EOL;
}

$conn->close();
?>
