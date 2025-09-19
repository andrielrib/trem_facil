<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cadastro_parte_1</title>
    <link rel="stylesheet" href="../style/style.css">
</head>


<body>


    <div class="cadastro1_icon">
        <img src="../assets/icons/trem_bala_icon.png" alt="icone trem" width="260" height="210">
    </div>


    <form id="loginForm">
        <div>
            <strong>
                <p class="margin_cadastro1">Nome completo:</p>
            </strong>
            <input type="text" class="caixa_login" id="nome_completo" required>
        </div>


        <div>
            <strong>
                <p class="margin_cadastro1">CPF:</p>
            </strong>
            <input type="text" class="caixa_login" id="cpf" required>
        </div>


        <div>
            <strong>
                <p class="margin_cadastro1">CEP:</p>
            </strong>
            <input type="text" class="caixa_login" id="cep" required>
        </div>


        <div>
            <strong>
                <p class="margin_cadastro1">Email:</p>
            </strong>
            <input type="text" class="caixa_login" id="email" required>
        </div>


        <br>
        <br>
       
       
        <div class="final_cadastro1">

            <a href="cadastro2.php"><button type="submit" class="caixa_verde_cadastro1"><strong><p class="centralizar_cadastro1">PRÓXIMO</p></strong></button></a>

        </div>


    </form>


    <script src="../script/cadastro1.js"></script>


    <div class="flex_circulo">
        <div class="circulo_esquerda_cadastro1"></div>
        <div class="circulo_direito_cadastro1"></div>
    </div>


</body>


</html>