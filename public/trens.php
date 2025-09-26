<?php
$terminal = [
    "nome" => "Terminal Norte",
    "linhas" => [
        [
            "nome" => "Costa e Silva Centro",
            "id" => 101,
            "status" => "Ativo",
            "status_color" => "#00c853",
            "paradas" => [
                ["nome" => "Estação do Príncipe - Centro", "tempo" => "Agora"],
                ["nome" => "Estação Ruy Barbosa - Costa e Silva", "tempo" => "15 min"],
            ],
            "horarios" => [
                "Estação Príncipe" => ["5:30", "6:15", "7:00", "7:45", "8:30", "11:00", "13:00", "15:30", "17:30", "19:30"],
                "Estação Ruy Barbosa" => ["6:00", "6:45", "7:30", "8:15", "9:00", "11:30", "13:30", "16:00", "18:00", "20:00"],
            ],
        ],
        [
            "nome" => "Pirabeiraba Centro",
            "id" => 102,
            "status" => "Inativo",
            "status_color" => "#d50000",
            "paradas" => [],
            "horarios" => [],
        ],
        [
            "nome" => "Tupy / Norte via Centro",
            "id" => 103,
            "status" => "Ativo",
            "status_color" => "#00c853",
            "paradas" => [
                ["nome" => "Dona Francisca via Morro Cortado", "tempo" => "Agora"],
                ["nome" => "Arno W. Dohler / Norte", "tempo" => "10 min"],
            ],
            "horarios" => [
                "Dona Francisca" => ["6:00", "7:30", "9:00", "10:30", "12:00", "14:00", "16:00", "18:00"],
                "Arno W. Dohler" => ["6:15", "8:00", "10:00", "11:30", "13:15", "15:00", "17:30", "19:00"],
            ],
        ],
        [
            "nome" => "Norte / Vila Nova via Walmor Harger",
            "id" => 104,
            "status" => "Ativo",
            "status_color" => "#00c853",
            "paradas" => [
                ["nome" => "Vila Nova via João Miers", "tempo" => "Agora"],
                ["nome" => "Pirabeiraba", "tempo" => "20 min"],
            ],
            "horarios" => [
                "Vila Nova" => ["5:45", "7:00", "8:30", "10:00", "11:45", "13:30", "15:45", "17:15"],
                "Pirabeiraba" => ["6:30", "8:00", "9:30", "11:00", "12:45", "14:30", "16:30", "18:00"],
            ],
        ],
        [
            "nome" => "Circulares Rui Barbosa",
            "id" => 105,
            "status" => "Ativo",
            "status_color" => "#00c853",
            "paradas" => [
                ["nome" => "Circular Parque Douat", "tempo" => "Agora"],
                ["nome" => "Circular Rui Barbosa", "tempo" => "5 min"],
            ],
            "horarios" => [
                "Parque Douat" => ["6:00", "7:00", "8:00", "9:00", "10:00", "11:00", "12:00"],
                "Rui Barbosa" => ["6:30", "7:30", "8:30", "9:30", "10:30", "11:30", "12:30"],
            ],
        ],
    ],
];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $page = $_POST['redirect_page'] ?? '';
    switch ($page) {
        case 'sensores':
            header('Location: sensor.php');
            exit();
        case 'trens':
            header('Location: trens.php');
            exit();
        case 'estacoes':
            header('Location: estacoes.php');
            exit();
        case 'perfil':
            header('Location: perfil.php');
            exit();
        default:
            header('Location: index.php'); 
            
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Trens - <?=htmlspecialchars($terminal['nome'])?></title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            background-color: #000;
            color: #ccc;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
        }

        #app {
            flex: 1;
            display: flex;
            flex-direction: column;
            max-width: 414px;
            width: 100%;
            margin: 0 auto;
            background: #000;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            border-radius: 20px;
            padding-bottom: 80px;
        }

        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color:rgb(0, 0, 0);
            padding: 8px 20px;
            color: #fff;
            font-weight: 700;
            font-size: 18px;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .btn-back {
            background: #004ecb;
            border: none;
            border-radius: 24px;
            color: white;
            font-weight: 700;
            padding: 6px 12px;
            cursor: pointer;
            font-size: 20px;
            display: flex;
            align-items: center;
        }
        .btn-back svg {
            margin-right: 6px;
            stroke: white;
            stroke-width: 3;
        }
        .title {
            flex: 1;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            user-select: none;
            font-size: 20px;
        }
        .btn-trens {
            background-color: #0e4caf;
            border-radius: 22px;
            padding: 6px 16px;
            font-weight: 700;
            font-size: 20px;
            user-select: none;
            cursor: default;
            color: white;
        }

        .search-container {
            position: relative;
            display: flex;
            align-items: center;
            max-width: 400px;
            margin: 20px auto;
            border-radius: 50px;
            overflow: hidden;
            background: white;
            background-color:rgb(0, 0, 0);
            color: white;
        }

        .search-input {
            flex: 1;
            padding: 12px;
            border: none;
            outline: none;
            font-size: 16px;
            background: transparent;
        }

        .search-input::placeholder {
            color: #999;
        }

        .search-button {
            padding: 12px;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color:rgb(0, 0, 0);
        }

        .search-button svg {
            stroke: white;
        }

        .trem {
            border: none;
            background-color: #02145e;
            color: white;
            margin: 12px;
            border-radius: 12px;
            padding: 14px;
            box-shadow: 0 0 10px #0039d1;
        }
        .header-trem {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #0e4caf;
            padding-bottom: 10px;
            margin-bottom: 14px;
        }
        .info-trem {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .icon-train {
            width: 26px;
            height: 26px;
            stroke: white;
            stroke-width: 2;
        }
        .titulo-trem {
            font-weight: 700;
            font-size: 18px;
            color: white;
        }
        .id-status {
            margin-left: 12px;
            font-weight: 700;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .status {
            font-weight: 700;
            font-size: 14px;
        }
        .btn-notify {
            background-color: transparent;
            border: none;
            cursor: pointer;
            padding: 6px;
            border-radius: 50%;
            transition: background-color 0.3s ease;
        }
        .btn-notify:hover {
            background-color: #004ecb;
        }
        .icon-bell {
            width: 24px;
            height: 24px;
            stroke: white;
            stroke-width: 2;
            fill: none;
        }
        .status.Ativo {
            color: #00c853;
            border-bottom: 3px solid #00c853;
            padding-bottom: 4px;
        }
        .status.Inativo {
            color: #d50000;
            border-bottom: 3px solid #d50000;
            padding-bottom: 4px;
        }

        .paradas {
            font-weight: 700;
            font-size: 16px;
            margin-bottom: 12px;
            margin-top: 10px;
            color: white;
        }
        .paradas-list {
            margin-left: 12px;
            margin-bottom: 14px;
        }
        .parada-item {
            display: flex;
            justify-content: space-between;
            font-weight: 600;
            font-size: 14px;
            padding: 3px 0;
            color: #ccc;
        }
        .parada-item .tempo {
            font-weight: 700;
            color: #00c853;
        }
        .parada-item.nao-agora .tempo {
            color: #00c853;
        }
        .parada-item.agora .tempo {
            color: #00c853;
        }

        .horarios-container {
            margin-top: 10px;
            padding-top: 8px;
            border-top: 2px solid #0e4caf;
            font-weight: 700;
            color: white;
        }
        .toggle-label {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
            font-weight: 700;
            font-size: 16px;
            user-select: none;
        }
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 24px;
        }
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .slider {
            position: absolute;
            cursor: pointer;
            border-radius: 30px;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #444;
            transition: 0.4s;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            border-radius: 50%;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: 0.4s;
        }
        input:checked + .slider {
            background-color: #0e4caf;
        }
        input:checked + .slider:before {
            transform: translateX(20px);
        }

        .horarios {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            font-weight: 600;
            gap: 12px;
            flex-wrap: wrap;
        }
        .horarios-column {
            flex: 1;
            min-width: 120px;
        }
        .horarios-column strong {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
            border-bottom: 1px solid #444;
            padding-bottom: 4px;
            color: #ddd;
        }
        .horarios-list {
            display: grid;
            gap: 6px;
            grid-template-columns: auto auto;
        }

        footer {
            background: #000;
            padding: 5px;
            display: flex;
            justify-content: space-around;
            border-top: 1px solid #0a5fff;
            position: fixed; 
            bottom: 0;
            width: 100%;
            z-index: 1000;
        }
        footer button {
            background: transparent;
            border: none;
            font-size: 26px;
            color: #108000;
            cursor: pointer;
        }
        footer button:hover {
            color: #1aff1a;
        }
    </style>
</head>
<body>
    <div id="app" role="main" aria-label="Lista de linhas de trem">
        <header>
            <button class="btn-back" aria-label="Voltar" onclick="history.back();">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" focusable="false">
                    <polyline points="15 18 9 12 15 6" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Voltar
            </button>
            <div class="title">Trens</div>
            <div class="btn-trens" aria-hidden="true">TRENS</div>
        </header>

        <div class="search-container">
            <button type="submit" class="search-button">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="../assets/icons/icone_lupa.png">
                        <path d="M21 21L15.0001 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="#999" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <input type="search" id="searchInput" placeholder="Pesquisar Trem" class="search-input">
        </div>

        <?php foreach ($terminal['linhas'] as $linha): ?>
            <article class="trem" data-nome="<?=htmlspecialchars(strtolower($linha['nome']))?>">
                <div class="header-trem">
                    <div class="info-trem">
                        <svg class="icon-train" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                            <rect x="3" y="3" width="18" height="14" rx="2" ry="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="8.5" cy="20.5" r="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="15.5" cy="20.5" r="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <line x1="3" y1="11" x2="21" y2="11" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <div>
                            <div class="titulo-trem"><?=htmlspecialchars($linha['nome'])?></div>
                            <div class="id-status" aria-label="ID e status do trem">
                                <span>ID #<?=htmlspecialchars($linha['id'])?></span>
                                <span class="status <?=htmlspecialchars($linha['status'])?>" style="color: <?=htmlspecialchars($linha['status_color'])?>">
                                    Status: <?=htmlspecialchars($linha['status'])?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <button class="btn-notify" aria-label="Ativar notificações para <?=htmlspecialchars($linha['nome'])?>">
                        <svg class="icon-bell" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </button>
                </div>

                <?php if (!empty($linha['paradas'])): ?>
                    <div class="paradas" aria-label="Pontos de Parada">
                        Pontos de Parada:
                    </div>
                    <div class="paradas-list">
                        <?php foreach ($linha['paradas'] as $parada): ?>
                            <?php 
                                $isAgora = strtolower(trim($parada['tempo'])) === 'agora';
                                $tempoClass = $isAgora ? 'agora' : 'nao-agora';
                            ?>
                            <div class="parada-item <?= $tempoClass ?>">
                                <span><?=htmlspecialchars($parada['nome'])?></span>
                                <span class="tempo"><?=htmlspecialchars($parada['tempo'])?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($linha['horarios'])): ?>
                    <div class="horarios-container">
                        <div class="horarios" aria-label="Horários dos dias úteis para <?=htmlspecialchars($linha['nome'])?>">
                            <?php foreach ($linha['horarios'] as $estacao => $horarios): ?>
                                <div class="horarios-column">
                                    <strong><?=htmlspecialchars($estacao)?></strong>
                                    <div class="horarios-list">
                                        <?php foreach ($horarios as $hora): ?>
                                            <span><?=htmlspecialchars($hora)?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </article>
        <?php endforeach; ?>
    </div>

    <footer role="contentinfo" aria-label="Menu principal">
        <form action="" method="post" style="display: inline;">
            <input type="hidden" name="redirect_page" value="sensores">
            <button type="submit" title="Sensores" style="border: none; background: none; cursor: pointer;">
            <img src="../assets/icons/tela_sensor_icon.png" alt="botão para tela sensores" width="60" height="60">
            </button>
        </form>
        <form action="" method="post" style="display: inline; margin-left: 10px;">
            <input type="hidden" name="redirect_page" value="trens">
            <button type="submit" title="Trens" style="border: none; background: none; cursor: pointer;">
            <img src="../assets/icons/tela_tren_icon.png" alt="botão para tela trens" width="60" height="60">
            </button>
        </form>
        <form action="" method="post" style="display: inline; margin-left: 10px;">
            <input type="hidden" name="redirect_page" value="estacoes">
            <button type="submit" title="Estacoes" style="border: none; background: none; cursor: pointer;">
            <img src="../assets/icons/tela_estacao_icon.png" alt="botão para tela estacoes" width="60" height="60">
            </button>
        </form>
        <form action="" method="post" style="display: inline; margin-left: 10px;">
            <input type="hidden" name="redirect_page" value="perfil">
            <button type="submit" title="Perfil" style="border: none; background: none; cursor: pointer;">
            <img src="../assets/icons/tela_perfil_icon.png" alt="botão para tela perfil" width="60" height="60">
            </button>
        </form>
    </footer>

    <script>
        const searchInput = document.getElementById('search-input');
        const linhas = document.querySelectorAll('.trem');

        searchInput.addEventListener('input', () => {
            const term = searchInput.value.toLowerCase().trim();

            linhas.forEach(linha => {
                const nome = linha.getAttribute('data-nome');
                if (!term || nome.includes(term)) {
                    linha.style.display = '';
                } else {
                    linha.style.display = 'none';
                }
            });
        });

        document.querySelectorAll('.horarios-container').forEach(container => {
            const checkbox = container.querySelector('input[type="checkbox"]');
            const horariosDiv = container.querySelector('.horarios');

            horariosDiv.style.display = 'none';

            checkbox.addEventListener('change', () => {
                horariosDiv.style.display = checkbox.checked ? 'flex' : 'none';
            });
        });

    </script>
</body>
</html>