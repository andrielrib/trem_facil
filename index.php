<?php

include '../public/db.php';

session_start();

$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : null;

if ($tipo) {
    $_SESSION['tipo_usuario'] = $tipo;
    
   
    if ($tipo == "1") {
      
    } elseif ($tipo == "2") {
        
        header('Location: entradrada.php');
        exit(); 
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrada</title>
    <link rel="stylesheet" href="../style/style.css">
    <style>
        
        body {
            background-color: #000000; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            font-weight: bold; 
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            text-align: center;
        }

        .img_entrada {
            margin-bottom: 20px;
        }

        .img_entrada img {
            max-width: 100%; 
            height: auto;
        }

        .text_entrada h1 {
            font-size: 2.5em; 
            margin: 0;
        }

        .alinhar_entrada {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px; 
            width: 100%;
            max-width: 300px; 
        }

        .caixa_azul_entrada {
            background-color: #007BFF; 
            color: #ffffff;
            border: none;
            padding: 15px 30px;
            font-size: 1.2em;
            font-family: 'Segoe UI', sans-serif;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            width: 100%; 
            max-width: 250px;
            text-decoration: none;
            display: block;
            transition: background-color 0.3s ease;
        }

        .caixa_azul_entrada:hover {
            background-color: #0056b3; 
        }

        .caixa_azul_entrada h2 {
            margin: 0;
            font-size: 1.1em;
        }

       
        @media (max-width: 768px) { 
            body {
                padding: 10px;
            }

            .text_entrada h1 {
                font-size: 2em;
            }

            .alinhar_entrada {
                gap: 15px;
                max-width: 100%;
            }

            .caixa_azul_entrada {
                padding: 12px 20px;
                font-size: 1em;
            }

            .img_entrada img {
                width: 400px; 
                height: auto;
              
            }
        }

        @media (max-width: 480px) {
            .text_entrada h1 {
                font-size: 1.5em;
            }

            .caixa_azul_entrada {
                padding: 10px 15px;
                font-size: 0.9em;
            }

       
        @media (min-width: 1024px) {
            .alinhar_entrada {
                flex-direction: row; 
                justify-content: center;
                max-width: 600px;
            }

            .caixa_azul_entrada {
                width: auto;
                margin: 0 10px;
            }
        }
    
     } </style>

</head>
<body>
    <div class="img_entrada">
        <img src="assets/icons/trem_bala_icon.png" alt="icone trem bala">
    </div>

    <div class="text_entrada">

        <h1>Quem é você?</h1>
    </div>

    <br>
   <br>

    <div class="alinhar_entrada">
        <a href="public/entrada.php?tipo=1">
            <button class="caixa_azul_entrada"><h2>Cliente</h2></button>
        </a>

<br>

        <a href="public/entrada.php?tipo=2">
            <button class="caixa_azul_entrada" id="admin-button"><h2>Administrador</h2></button>


</body>
</html>
