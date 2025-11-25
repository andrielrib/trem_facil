<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carregamento</title>
    <link rel="stylesheet" href="../style/style.css">
</head>

<body>

    <div class="suporEalert">
        <a href="pagina_inicial.php" style="position: absolute; top: 10px; left: 10px;">
            <img src="../assets/icons/seta_esquerda.png" alt="Voltar" width="50" height="50">
        </a>
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

    <script>
        document.querySelector(".caixa_verde_supEale").addEventListener("click", function() {
            alert("Enviado");
            window.location.href = "pagina_inicial.php";
        });
    </script>

</body>

</html>