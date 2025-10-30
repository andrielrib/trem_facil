<?php
session_start();

if (!isset($_SESSION['sensores'])) {
    $_SESSION['sensores'] = [
        [
            'id' => 1,
            'nome' => 'SENSOR X',
            'status' => 'ATIVO',
            'status_color' => 'green',
            'localizacao' => 'X',
            'ultima_atualizacao_texto' => '5 MIN',
            'ultima_atualizacao_valor' => '120',
            'ultima_atualizacao_unidade' => 'KM/H'
        ],
        [
            'id' => 2,
            'nome' => 'SENSOR Y',
            'status' => 'INATIVO',
            'status_color' => 'red',
            'localizacao' => 'Y',
            'ultima_atualizacao_texto' => '1 H',
            'ultima_atualizacao_valor' => '80',
            'ultima_atualizacao_unidade' => 'KM/H'
        ],
        [
            'id' => 3,
            'nome' => 'SENSOR Z',
            'status' => 'ATIVO',
            'status_color' => 'green',
            'localizacao' => 'Z',
            'ultima_atualizacao_texto' => '1 MIN',
            'ultima_atualizacao_valor' => '150',
            'ultima_atualizacao_unidade' => 'KM/H'
        ],
    ];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['redirect_page'])) {
    $page = $_POST['redirect_page'];
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
            exit();
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_sensor'])) {
    $novoSensor = [
        'id' => count($_SESSION['sensores']) + 1,
        'nome' => $_POST['nome'] ?? 'SENSOR NOVO',
        'status' => 'ATIVO', 
        'status_color' => 'green',
        'localizacao' => $_POST['localizacao'] ?? 'DESCONHECIDA',
        'ultima_atualizacao_texto' => 'AGORA',
        'ultima_atualizacao_valor' => '0',
        'ultima_atualizacao_unidade' => 'KM/H'
    ];
    $_SESSION['sensores'][] = $novoSensor;
    header('Location: ' . $_SERVER['PHP_SELF']); 
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_sensor'])) {
    $id = (int)$_POST['sensor_id'];
    $_SESSION['sensores'] = array_filter($_SESSION['sensores'], function($sensor) use ($id) {
        return $sensor['id'] !== $id;
    });
    header('Location: ' . $_SERVER['PHP_SELF']); 
    exit();
}

$sensores = $_SESSION['sensores'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sensores - Trem Fácil</title>
    <style>
        
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
            padding-bottom: 80px; 
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

        .btn-group {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 14px;
        }

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
            color: #27ae60;
            font-weight: 700;
        }

        .status-inativo {
            color: #e74c3c;
            font-weight: 700;
        }

        .localizacao {
            color: white;
        }

        .ult-atualizacao {
            font-size: 13px;
        }

        .kmh {
            color: #0B57DA;
            font-weight: 700;
            user-select: none;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: #111;
            padding: 20px;
            border-radius: 12px;
            width: 90%;
            max-width: 400px;
            color: white;
        }
        .modal-content input, .modal-content button {
            display: block;
            width: 100%;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
        }
        .modal-content input {
            background: #222;
            border: 1px solid #0B57DA;
            color: white;
        }
        .modal-content button {
            background: #0B57DA;
            border: none;
            cursor: pointer;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover {
            color: white;
        }

        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 80px;
            background-color: black;
            border-top: 1px solid #0B57DA;
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            user-select: none;
        }
        footer form {
            display: inline;
        }
        footer button {
            border: none;
            background: none;
            cursor: pointer;
        }
        footer img {
            width: 60px;
            height: 60px;
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
        <button class="btn-primary" type="button" onclick="openModal()">ADICIONAR SENSOR</button>
        <button class="btn-filter" type="button" title="Filtro">
            <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" fill="white" viewBox="0 0 24 24"><path d="M3 4a1 1 0 0 1 1-1h16a1 1 0 0 1 .8 1.6l-6.4 7.2v6.4a1 1 0 0 1-1.5.85l-3-2a1 1 0 0 1-.3-1.35L17.2 6H4a1 1 0 0 1-1-1z"/></svg>
        </button>
    </div>

    <?php foreach($sensores as $sensor): ?>
        <div class="sensor-item">
            <div class="sensor-header">
                <div class="sensor-name"><?= htmlspecialchars($sensor['nome']) ?></div>
                <form action="" method="post" style="display: inline;" onsubmit="return confirm('Tem certeza que deseja remover este sensor?');">
                    <input type="hidden" name="sensor_id" value="<?= $sensor['id'] ?>">
                    <button class="btn-trash" type="submit" name="remove_sensor" title="Excluir Sensor">
                        <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" fill="white" viewBox="0 0 24 24"><path d="M3 6h18v2H3V6zm3 14a2 2 0 1 1 4 0H6zm7 0a2 2 0 1 1 4 0h-4zm2-10v8H9v-8H5V8h14v2h-6z"/></svg>
                    </button>
                </form>
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

    <div id="addSensorModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Adicionar Sensor</h2>
            <form action="" method="post">
                <input type="text" name="nome" placeholder="Nome do Sensor" required>
                <input type="text" name="localizacao" placeholder="Localização" required>
                <button type="submit" name="add_sensor">Adicionar</button>
            </form>
        </div>
    </div>

    <footer>
        <form action="" method="post">
            <input type="hidden" name="redirect_page" value="sensores">
            <button type="submit" title="Sensores">
                <img src="../assets/icons/tela_sensor_icon.png" alt="botão para tela sensores">
            </button>
        </form>
        <form action="" method="post">
            <input type="hidden" name="redirect_page" value="trens">
            <button type="submit" title="Trens">
                <img src="../assets/icons/tela_tren_icon.png" alt="botão para tela trens">
            </button>
        </form>
        <form action="" method="post">
            <input type="hidden" name="redirect_page" value="estacoes">
            <button type="submit" title="Estações">
                <img src="../assets/icons/tela_estacao_icon.png" alt="botão para tela estações">
            </button>
        </form>
        <form action="" method="post">
            <input type="hidden" name="redirect_page" value="perfil">
            <button type="submit" title="Perfil">
                <img src="../assets/icons/tela_perfil_icon.png" alt="botão para tela perfil">
            </button>
        </form>
    </footer>

    <script>
        function openModal() {
            document.getElementById('addSensorModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('addSensorModal').style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById('addSensorModal')) {
                closeModal();
            }
        }
    </script>

</body>
</html>