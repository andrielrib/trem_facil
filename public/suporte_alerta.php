<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carregamento</title>
    <link rel="stylesheet" href="../style/style.css">
</head>

<body>

    <div class="suporEalert">
        <p>Suporte e Alertas</p>
    </div>


    <div class="coisas">

        <div class="texto_sobre">
            <h2>Onde</h2>
        </div>


        <div class="texto_sobre">
            <h3>Selecione aqui</h3>
        </div>
        <select class="caixa_selecione">
            <option value="valor1">Garuva</option>
            <option value="valor2" selected>Joinville</option>
            <option value="valor3">São paulo</option>
        </select>


        <div class="texto_sobre">
            <h2>Linha</h2>
        </div>


        <div class="texto_sobre">
            <h3>Selecione aqui</h3>
        </div>
        <select class="caixa_selecione">
            <option value="valor1">Linha 1-Azul</option>
            <option value="valor2" selected>Linha 8-Diamante</option>
            <option value="valor3">Ferrovia Norte-Sul</option>
        </select>


        <div class="texto_sobre">
            <h2>Problema</h2>
        </div>


        <div class="texto_sobre">
            <h3>Selecione aqui</h3>
        </div>
        <select class="caixa_selecione">
            <option value="valor1">Descarrilamento</option>
            <option value="valor2" selected>Esbarro de trens</option>
            <option value="valor3">Falhas no sistema de sinalização</option>
            <option value="valor1">descarrilamento</option>
            <option value="valor2" selected>tombamento</option>
            <option value="valor3">choque de trens</option>
        </select>


        <div class="texto_sobre">
            <h2>Emergência</h2>
        </div>


        <div class="texto_sobre">
            <h3>Selecione aqui</h3>
        </div>
        <select class="caixa_selecione">
            <option value="valor1">Incêndio</option>
            <option value="valor2" selected>Problemas elétricos</option>
            <option value="valor3">Abalroamento</option>
            <option value="valor1">SOS</option>
            <option value="valor2" selected>Centro de Controle Operacional (CCO)</option>
            <option value="valor3">Serviços de Emergência</option>
        </select>
    </div>

    <br>
    <br>
    <br>
    <br>
    <button class="caixa_verde_supEale"><strong><p class="centralizar_text_alert">ENVIAR</p></strong></button>
    <br>
    <br>
    <br>
    <br>

       
        <div class="flex_perfil">
        <button class="button_icones" onclick="telaRotas()"><img src="../assets/icons/tela_inicial_icon.png" alt="icone da tela inicial" width="86" height="70"></button>
        <button class="button_icones" onclick="telaSensor()"><img src="../assets/icons/tela_sensor_icon.png" alt="icone da tela de sensores" width="86" height="70"></button>
        <button class="button_icones" onclick="telaPesquisa()"><img src="../assets/icons/tela_pesquisa_icon.png" alt="icone da tela de pesquisa" width="86" height="70"></button>
        <button class="button_icones" onclick="telaSuporteAlerta()"><img src="../assets/icons/tela_suporte_alerta_icon.png" alt="icone da tela de suport e alerta" width="86" height="70"></button>
        <button class="button_icones" onclick="telaPerfil()"><img src="../assets/icons/tela_perfil_icon.png" alt="icone da tela de perfil" width="86" height="70"></button>
    </div>

</body>

</html>