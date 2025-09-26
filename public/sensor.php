<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sensores Inteligentes</title>
    <script src="../script/sensor.js"></script>
</head>

<body>
    
<style>
    .caixa_selecione{
    color: black;
    font-size: 20px;
}

    body {
    background-color: black;
    color: white;
    margin: auto;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    display: flex;
    flex-direction: column;
}

    .flex_sensor {
    display: flex;
    justify-content: space-between;
    margin-left: 30px;
    margin-right: 50px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;

.sensor {
    margin: 10px;
}

.img {
    margin: 10px;
}

.titulo1 {
    font-size: 30;
    margin: 5px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.titulo2 {
    font-size: 20;
    margin: 5px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin-left: 30px;
}

.subt1 {
    margin: 5px;
    font-size: large;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.subt2 {
    margin: 5px;
    font-size: large;
    color: #00bf63;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin-left: 30px;
}

.textinho {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin-left: 30px;
}

.btn_seta {
    background-color: black;
    border: none;
    padding: 0;
    margin: 0;
    cursor: pointer;
}

.btn_seta img {
    display: block;
}
}

.button_icones{
    border: none;
    background-color: black;
}


</style>

<strong><h1>Sensores Inteligentes:</h1></strong>
<img src="../assets/img/sensor.PNG" alt="Sensores" width="360" height="300">
<hr style="border: 2px solid #0549b1;" width="424">

<div class="flex_sensor">
    <strong><h1 class="sensor">Sensor 01</h1></strong>
    <button class="btn_seta">
        <img src="../assets/img/seta_baixo.png" onclick="trocaSensor()" alt="seta para baixo" width="60" height="40" class="img_seta">
    </button>
</div>

<hr style="border: 2px solid #0549b1;" width="424">
<div class="flex_sensor">
    <strong><h1 class="sensor">Sensor 02</h1></strong>
    <img src="../assets/img/seta_baixo.png" alt="seta para baixo" width="60" height="40" class="img_seta">
</div>
<hr style="border: 2px solid #0549b1;" width="424">
<div class="flex_sensor">
    <strong><h1 class="sensor">Sensor 03</h1></strong>
    <img src="../assets/img/seta_baixo.png" alt="seta para baixo" width="60" height="40" class="img_seta">
</div>
<hr style="border: 2px solid #0549b1;" width="424">
<div class="flex_sensor">
    <strong><h1 class="sensor">Sensor 04</h1></strong>
    <img src="../assets/img/seta_baixo.png" alt="seta para baixo" width="60" height="40" class="img_seta">
</div>
<hr style="border: 2px solid #0549b1;" width="424">
<div class="flex_sensor">
    <strong><h1 class="sensor">Sensor 05</h1></strong>
    <img src="../assets/img/seta_baixo.png" alt="seta para baixo" width="60" height="40" class="img_seta">
</div>

<hr style="border: 2px solid #0549b1;" width="424">

<div class="flex_perfil">
        <button class="button_icones" onclick="telaRotas()"><img src="../assets/icons/tela_inicial_icon.png" alt="icone da tela inicial" width="60" height="65"></button>
        <button class="button_icones" onclick="telaSensor()"><img src="../assets/icons/tela_sensor_icon.png" alt="icone da tela de sensores" width="62" height="65"></button>
        <button class="button_icones" onclick="telaPesquisa()"><img src="../assets/icons/tela_pesquisa_icon.png" alt="icone da tela de pesquisa" width="62" height="65"></button>
        <button class="button_icones" onclick="telaSuporteAlerta()"><img src="../assets/icons/tela_suporte_alerta_icon.png" alt="icone da tela de suport e alerta" width="62" height="65"></button>
        <button class="button_icones" onclick="telaPerfil()"><img src="../assets/icons/tela_perfil_icon.png" alt="icone da tela de perfil" width="62" height="65"></button>
</div>

</body>
</html>