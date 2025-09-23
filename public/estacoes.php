<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Estações</title>
    <link rel="stylesheet" href="../style/style.css" />
    <style>
        body {
            margin: 0;
            background-color: #000;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #fff;
        }
        .flex_estacao {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            gap: 10px;
        }
        .btn_seta {
            background-color: transparent;
            border: none;
            cursor: pointer;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s ease;
        }
        .btn_seta:hover {
            background-color: #2847c1;
            border-radius: 50%;
        }
        .btn_seta img {
            width: 40px;
            height: 40px;
        }
        .title {
            background-color: #3254ea;
            border-radius: 20px;
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
            width: 200px;
            height: 50px;
            line-height: 50px;
            text-align: center;
            user-select: none;
        }
        hr.divisor {
            border: none;
            border-top: 2px solid #3254ea;
            margin: 0 15px 10px;
        }
        .search_container {
            position: relative;
            width: calc(100% - 60px);
            max-width: 320px;
            margin: 0 30px 20px;
        }
        .input_search {
            width: 100%;
            padding: 10px 40px;
            font-size: 1rem;
            border: none;
            border-bottom: 2px solid #3254ea;
            background-color: transparent;
            color: #ccc;
            outline: none;
        }
        .input_search::placeholder {
            color: #777;
        }
        .icon_search {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            filter: invert(100%);
            width: 18px;
            height: 18px;
        }
        .estacao_section {
            margin: 0 15px 15px;
            border-bottom: 1px solid #3254ea;
        }
        .estacao_header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            padding: 5px 0;
            user-select: none;
        }
        .estacao_header h3 {
            display: flex;
            align-items: center;
            font-size: 1.1rem;
            font-weight: 700;
            gap: 10px;
            margin: 0;
        }
        .estacao_header img.icon_estacao {
            width: 30px;
            height: 30px;
        }
        .estacao_header img.icon_arrow {
            width: 24px;
            height: 24px;
            filter: invert(54%) sepia(83%) saturate(4908%) hue-rotate(211deg) brightness(100%) contrast(101%);
            transition: transform 0.3s ease;
        }

        .estacao_header.collapsed img.icon_arrow {
            transform: rotate(0deg);
        }

        .estacao_header.expanded img.icon_arrow {
            transform: rotate(180deg);
        }

        .estacao_list {
            display: none;
            padding-left: 40px;
            padding-bottom: 10px;
            color: #ddd;
        }
        .estacao_list.expanded {
            display: block;
        }
        .estacao_list ul {
            display: flex;
            flex-wrap: wrap;
            list-style: none;
            padding: 0;
            margin: 5px 0 0 0;
            font-size: 0.85rem;
            gap: 10px 20px;
        }
        .estacao_list ul li {
            min-width: 120px;
        }

        .footer_nav {
            position: fixed;
            bottom: 0;
            width: 100%;
            max-width: 360px;
            background-color: #000;
            border-top: 2px solid #3254ea;
            display: flex;
            justify-content: space-around;
            padding: 10px 0;
        }
        .footer_nav img {
            width: 30px;
            height: 30px;
            filter: invert(54%) sepia(83%) saturate(4908%) hue-rotate(211deg) brightness(100%) contrast(101%);
            cursor: pointer;
        }
    </style>

    <script>
      window.addEventListener('DOMContentLoaded', () => {
        const headers = document.querySelectorAll('.estacao_header');
        headers.forEach(header => {
          header.addEventListener('click', () => {
            const list = header.nextElementSibling;
            const expanded = header.classList.contains('expanded');
            if (expanded) {
              header.classList.remove('expanded');
              header.classList.add('collapsed');
              list.classList.remove('expanded');
            } else {
              header.classList.add('expanded');
              header.classList.remove('collapsed');
              list.classList.add('expanded');
            }
          });
        });
      });
    </script>

</head>
<body>

    <div class="flex_estacao">
        <button class="btn_seta" aria-label="Voltar" onclick="history.back()">
            <img src="../assets/icons/seta_esquerda.png" alt="Seta apontando para esquerda" />
        </button>
        <h2 class="title">ESTAÇÕES</h2>
    </div>

    <hr class="divisor"/>

    <div class="search_container">
        <img src="./assets/icons/icone_lupa.png" alt="Ícone de lupa" class="icon_search" />
        <input type="search" placeholder="Pesquisar Estações" class="input_search" />
    </div>

    <div class="estacao_section">
        <div class="estacao_header collapsed" tabindex="0">
            <h3>
                <img src="./assets/icons/estacao_principe.png" alt="Ícone Estação do Príncipe" class="icon_estacao" />
                Estação do Príncipe
            </h3>
            <img src="./assets/icons/seta_cima.png" alt="Seta para cima" class="icon_arrow" />
        </div>
        <div class="estacao_list">
            <ul>
                <li>Agulhas Negras</li>
                <li>Jarivatuba</li>
                <li>Costa e Silva Centro</li>
                <li>Itaum Centro</li>
                <li>Tupy Centro</li>
                <li>Vila Nova Centro</li>
                <li>Itaum Centro</li>
                <li>Itaum Sul</li>
                <li>Estação Pirabeiraba</li>
                <li>Agulhas Negras</li>
                <li>Jarivatuba</li>
                <li>Costa e Silva Centro</li>
                <li>Itaum Centro</li>
                <li>Tupy Centro</li>
                <li>Vila Nova Centro</li>
                <li>Itaum Centro</li>
                <li>Itaum Sul</li>
                <li>Estação Pirabeiraba</li>
            </ul>
        </div>
    </div>

    <div class="estacao_section">
        <div class="estacao_header collapsed" tabindex="0">
            <h3>
                <img src="./assets/icons/estacao_costa_silva.png" alt="Ícone Estação Costa e Silva" class="icon_estacao" />
                Estação Costa e Silva
            </h3>
            <img src="./assets/icons/seta_cima.png" alt="Seta para cima" class="icon_arrow" />
        </div>
        <div class="estacao_list">
            <ul>
                <li>Agulhas Negras</li>
                <li>Jarivatuba</li>
                <li>Costa e Silva Centro</li>
                <li>Itaum Centro</li>
                <li>Tupy Centro</li>
                <li>Vila Nova Centro</li>
                <li>Itaum Centro</li>
                <li>Itaum Sul</li>
                <li>Estação Pirabeiraba</li>
            </ul>
        </div>
    </div>

    <div class="estacao_section">
        <div class="estacao_header collapsed" tabindex="0">
            <h3>
                <img src="./assets/icons/estacao_pirabeiraba.png" alt="Ícone Estação Pirabeiraba" class="icon_estacao" />
                Estação Pirabeiraba
            </h3>
            <img src="./assets/icons/seta_cima.png" alt="Seta para cima" class="icon_arrow" />
        </div>
        <div class="estacao_list">
            <ul>
                <li>Agulhas Negras</li>
                <li>Jarivatuba</li>
                <li>Costa e Silva Centro</li>
                <li>Itaum Centro</li>
                <li>Tupy Centro</li>
                <li>Vila Nova Centro</li>
                <li>Itaum Centro</li>
                <li>Itaum Sul</li>
                <li>Estação Pirabeiraba</li>
            </ul>
        </div>
    </div>

    <div class="footer_nav">
        <img src="./assets/icons/icone_wifi.png" alt="Ícone Wi-Fi" />
        <img src="./assets/icons/icone_trem.png" alt="Ícone Trem" />
        <img src="./assets/icons/icone_predio.png" alt="Ícone Prédio" />
        <img src="./assets/icons/icone_usuario.png" alt="Ícone Usuário" />
    </div>

</body>
</html>