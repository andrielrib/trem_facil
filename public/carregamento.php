<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Carregamento</title>
  <link rel="stylesheet" href="../style/style.css">
  <style>
    /* Reset */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background: #fff; /* ajuste se tiver tema */
      font-family: Arial, sans-serif;
    }

    .tela_carregamento {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      gap: 2rem;
      width: 100%;
      height: 100%;
      padding: 1rem;
      text-align: center;
    }

    .logo_carregamento img {
      max-width: 70%;
      height: auto;
    }

    .bolinhas_carregamento img {
      max-width: 80%;
      height: auto;
    }

    /* Responsividade */
    @media (min-width: 768px) {
      .logo_carregamento img {
        max-width: 50%;
      }
      .bolinhas_carregamento img {
        max-width: 40%;
      }
    }

    @media (min-width: 1024px) {
      .logo_carregamento img {
        max-width: 35%;
      }
      .bolinhas_carregamento img {
        max-width: 25%;
      }
    }
  </style>
</head>
<body>
  <div class="tela_carregamento">
    <div class="logo_carregamento">
      <img src="../assets/icons/trem_bala_icon.png" alt="icone trem bala">
    </div>
    <div class="bolinhas_carregamento">
      <img src="../assets/img/03-42-07-846_512.webp" alt="bolinhas de Carregamento">
    </div>
  </div>
  <script src="../script/carregamento.js"></script>
</body>
</html>
