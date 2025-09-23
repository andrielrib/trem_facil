<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trem Fácil</title>
  <link rel="stylesheet" href="../style/style.css">
</head>
<body>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background:black;
      text-align: center;
    }

    .container {
      padding: 20px;
    }

    .login_icon img {
      max-width: 250px;
    }

    h2 {
      margin: 10px 0;
      font-size: 2rem;
    }

    h2 span {
      color:  #31a06a;
    }

    .bemvindo {
      font-size: 1.5rem;
      margin: 20px 0;
    }

    .menu {
      display: flex;
      justify-content: center;
      gap: 60px;
      flex-wrap: wrap;
    }

    .card img {
      width: 150px;
      height: auto;
      transition: transform 0.2s ease;
    }

    .card:hover img {
      transform: scale(1.1);
    }
  </style>
</head>
<body>
  <div class="container">

    <div class="login_icon">
      <img src="../assets/icons/trem_bala_icon.png" alt="Ícone trem bala">
      <h2><span>Bem vindo!</span></h2>
    </div>

  

    <div class="menu">
      <a href="#" class="card">
        <img src="../assets/icons/perfil.png" alt="Perfil">
      </a>

      <a href="#" class="card">
        <img src="../assets/icons/trens.png" alt="Trens">
      </a>

      <a href="#" class="card">
        <img src="../assets/icons/sensores.png" alt="Sensores">
      </a>

      <a href="#" class="card">
        <img src="../assets/icons/estacoes.png" alt="Estações">
      </a>
    </div>
  </div>
</body>
</html>

      