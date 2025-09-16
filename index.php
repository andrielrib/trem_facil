<?php

include 'public/db.php';

session_start();

$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : null;

if ($tipo) {
    $_SESSION['tipo_usuario'] = $tipo;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrada</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <div class="img_entrada">
        <img src="assets/icons/trem_bala_icon.png" alt="icone trem bala" width="300" height="250">
    </div>

    <br><br>

    <div class="text_entrada">
        <h1>Quem é você?</h1>
    </div>

    <br><br><br>

    <div class="alinhar_entrada">

        <a href="public/entrada.php?tipo=1">
            <button class="caixa_azul_entrada"><h2>Cliente</h2></button>
        </a>

        <br><br>

        <a href="public/entrada.php?tipo=2">
            <button class="caixa_azul_entrada" id="admin-button"><h2>Administrador</h2></button>
        </a>
    </div>

    <br><br>

    <div class="resultado">
        <?php
        if ($tipo == "1") {
            echo "<h2>Você entrou como <span style='color:blue;'>Cliente</span>.</h2>";
        } elseif ($tipo == "2") {
            echo "<h2>Você entrou como <span style='color:red;'>Administrador</span>.</h2>";
        }
        ?>
    </div>

    <script src="../script/tela_inicial.js"></script>
</body>
</html>
