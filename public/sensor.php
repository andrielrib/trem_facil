<?php
// Exemplo de dados dos sensores (pode ser substituído por dados dinâmicos)
$sensores = [
    [
        'nome' => 'SENSOR X',
        'status' => 'ATIVO',
        'status_color' => 'green',
        'localizacao' => 'X',
        'ultima_atualizacao_texto' => '5 MIN',
        'ultima_atualizacao_valor' => '120',
        'ultima_atualizacao_unidade' => 'KM/H'
    ],
    [
        'nome' => 'SENSOR X',
        'status' => 'INATIVO',
        'status_color' => 'red',
        'localizacao' => 'X',
        'ultima_atualizacao_texto' => '1 H',
        'ultima_atualizacao_valor' => '80',
        'ultima_atualizacao_unidade' => 'KM/H'
    ],
    [
        'nome' => 'SENSOR X',
        'status' => 'ATIVO',
        'status_color' => 'green',
        'localizacao' => 'X',
        'ultima_atualizacao_texto' => '1 MIN',
        'ultima_atualizacao_valor' => '150',
        'ultima_atualizacao_unidade' => 'KM/H'
    ],
];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sensores - Trem Fácil</title>
    <style>
        /* Reset básico */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #000;
            font-family: Arial, sans-serif;
            color: white;
            padding: 15px;
        }

        .header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .btn-voltar {
            background-color: transparent;
            border: none;
            color: #0B57DA;
            font-size: 22px;
            cursor: pointer;
            display: flex;
            align-items: center;
        }
        /* Ícone de seta para esquerda com unicode */
        .btn-voltar::before {
            content: "←";
            margin-right: 6px;
        }

        .titulo-principal {
            background-color: #0B57DA;
            padding: 8px 18px;
            border-radius: 25px;
            font-weight: bold;
            font-size: 19px;
            color: white;
            user-select: none;
        }

        .linha-azul {
            height: 2px;
            background-color: #0B57DA;
            margin-bottom: 15px;
            border-radius: 2px;
        }

        .input-search {
            width: 100%;
            background: transparent;
            border: none;
            border-bottom: 2px solid #0B57DA;
            color: #999;
            padding: 7px 5px;
            font-size: 15px;
            margin-bottom: 18px;
            outline: none;
        }

        ::placeholder {
            color: #777;
            font-style: italic;
        }

        /* Botões principais azul */
        .btn-primary {
            background-color: #0B57DA;
            color: white;
            padding: 10px 18px;
            border-radius: 25px;
            border: none;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
            user-select: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.25s;
        }
        .btn-primary:hover {
            background-color: #0943b0;
        }

        /* Ícones filtro e lixeira com borda e azul */
        .btn-filter, .btn-trash {
            background-color: transparent;
            border: 2.5px solid white;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            color: white;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: background-color 0.3s, border-color 0.3s;
        }
        .btn-filter:hover, .btn-trash:hover {
            background-color: #0B57DA;
            border-color: #0B57DA;
        }

        /* Container do filtro/lixeira ao lado do botão */
        .btn-group {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 14px;
        }

        /* Lista dos sensores */
        .sensor-item {
            background-color: #111;
            margin-bottom: 18px;
            padding: 15px 15px 18px;
            border-radius: 12px;
            box-shadow: 0 2px 9px rgba(11, 87, 218, 0.3);
        }

        .sensor-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
        }

        .sensor-name {
            background-color: #0B57DA;
            padding: 8px 22px;
            border-radius: 25px;
            font-weight: 700;
            font-size: 16px;
            color: white;
            user-select: none;
        }

        /* Status e localização */
        .sensor-details {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .status-label {
            user-select: none;
        }

        .status-ativo {
            color: #27ae60; /* verde */
            font-weight: 700;
        }

        .status-inativo {
            color: #e74c3c; /* vermelho */
            font-weight: 700;
        }

        .localizacao {
            color: white;
        }

        /* Última atualização */
        .ult-atualizacao {
            font-size: 13px;
        }

        .kmh {
            color: #0B57DA;
            font-weight: 700;
            user-select: none;
        }

        /* Rodapé com menu inferior */
        .menu-inferior {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 65px;
            background-color: black;
            border-top: 1px solid #0B57DA;
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            user-select: none;
        }

        /* Itens do menu inferior */
        .menu-item {
            color: #27ae60;
            font-size: 24px;
            cursor: pointer;
            transition: transform 0.15s;
        }
        .menu-item:hover {
            transform: scale(1.2);
            color: #0B57DA;
        }
    </style>
</head>
<body>

    <header class="header">
        <button class="btn-voltar" title="Voltar"></button>
        <div class="titulo-principal">SENSORES</div>
    </header>

    <div class="linha-azul"></div>

    <input type="text" class="input-search" placeholder="Pesquisar Sensor" aria-label="Pesquisar Sensor" />

    <div class="btn-group">
        <button class="btn-primary" type="button">ADICIONAR SENSOR</button>
        <button class="btn-filter" type="button" title="Filtro">
            <!-- ícone filtro simples -->
            <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" fill="white" viewBox="0 0 24 24"><path d="M3 4a1 1 0 0 1 1-1h16a1 1 0 0 1 .8 1.6l-6.4 7.2v6.4a1 1 0 0 1-1.5.85l-3-2a1 1 0 0 1-.3-1.35L17.2 6H4a1 1 0 0 1-1-1z"/></svg>
        </button>
    </div>

    <!-- Lista de sensores -->
    <?php foreach($sensores as $sensor): ?>
        <div class="sensor-item">
            <div class="sensor-header">
                <button class="btn-primary" type="button"><?= htmlspecialchars($sensor['nome']) ?></button>
                <button class="btn-trash" type="button" title="Excluir Sensor">
                    <!-- ícone lixeira simples -->
                    <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" fill="white" viewBox="0 0 24 24"><path d="M3 6h18v2H3V6zm3 14a2 2 0 1 1 4 0H6zm7 0a2 2 0 1 1 4 0h-4zm2-10v8H9v-8H5V8h14v2h-6z"/></svg>
                </button>
            </div>

            <div class="sensor-details">
                <div class="status-label">
                    STATUS: 
                    <?php if($sensor['status'] === 'ATIVO'): ?>
                        <span class="status-ativo"><?= htmlspecialchars($sensor['status']) ?></span>
                    <?php else: ?>
                        <span class="status-inativo"><?= htmlspecialchars($sensor['status']) ?></span>
                    <?php endif; ?>
                </div>
                <div class="localizacao">
                    LOCALIZAÇÃO: <?= htmlspecialchars($sensor['localizacao']) ?>
                </div>
            </div>

            <div class="ult-atualizacao">
                ÚLTIMA ATUALIZAÇÃO(<?= htmlspecialchars($sensor['ultima_atualizacao_texto']) ?>): 
                <span class="kmh"><?= htmlspecialchars($sensor['ultima_atualizacao_valor']) ?> <?= htmlspecialchars($sensor['ultima_atualizacao_unidade']) ?></span>
            </div>
        </div>
    <?php endforeach; ?>

    <footer class="menu-inferior" aria-label="Menu principal">
        <!-- Ícones representativos do menu inferior -->
        <div class="menu-item" title="Sinalização">
            <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
                <circle cx="14" cy="14" r="10" />
                <line x1="14" y1="8" x2="14" y2="14" />
                <line x1="14" y1="14" x2="18" y2="18" />
            </svg>
        </div>
        <div class="menu-item" title="Trem">
            <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
                <rect x="3" y="11" width="18" height="7" rx="2" ry="2"/>
                <line x1="7" y1="11" x2="7" y2="18"/>
                <line x1="17" y1="11" x2="17" y2="18"/>
                <circle cx="7" cy="19" r="1"/>
                <circle cx="17" cy="19" r="1"/>
            </svg>
        </div>
        <div class="menu-item" title="Estação">
            <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
                <path d="M12 2 L2 7 L12 12 L22 7z"/>
                <rect x="5" y="12" width="14" height="10"/>
                <line x1="12" y1="12" x2="12" y2="22"/>
            </svg>
        </div>
        <div class="menu-item" title="Usuário">
            <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
                <circle cx="14" cy="8" r="4"/>
                <path d="M6 22c0-4 16-4 16 0" />
            </svg>
        </div>
    </footer>

</body>
</html>
