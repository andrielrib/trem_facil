<?php
include '../public/db.php';

session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuários - Trem Fácil</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: black;
            color: white;
            text-align: center;
        }

        .container {
            padding: 20px;
        }

        h1 {
            color: #31a06a;
        }

        .back-button {
            margin-top: 20px;
        }

        .back-button a {
            color: #31a06a;
            text-decoration: none;
            font-size: 1.2rem;
        }

        .back-button a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Lista de Usuários</h1>
        <p>Aqui será exibida a lista de usuários cadastrados.</p>
        <!-- Placeholder for user list functionality -->

        <div class="back-button">
            <a href="pagina_inicial_adm.php">Voltar</a>
        </div>
    </div>
</body>
</html>
