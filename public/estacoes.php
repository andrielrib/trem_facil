<?php

require_once 'db.php';

function buscarEstacoesComLinhas($conn) {
    $sql = "
        SELECT e.id_estacao, e.nome AS nome_estacao, GROUP_CONCAT(l.nome SEPARATOR '|') AS linhas
        FROM estacao e
        LEFT JOIN estacao_linha el ON e.id_estacao = el.id_estacao
        LEFT JOIN linha l ON el.id_linha = l.id_linha
        GROUP BY e.id_estacao, e.nome
        ORDER BY e.id_estacao ASC
    ";
    $result = $conn->query($sql);
    if (!$result) {
        die("Erro na consulta: " . $conn->error);
    }

    $estacoes = [];
    while ($row = $result->fetch_assoc()) {
        $linhas = $row['linhas'] ? explode('|', $row['linhas']) : [];
        $estacoes[] = [
            'estacao_id' => $row['id_estacao'],
            'nome_estacao' => $row['nome_estacao'],
            'linhas' => $linhas
        ];
    }
    return $estacoes;
}


function processarPost() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $page = $_POST['redirect_page'] ?? '';
        switch ($page) {
            case 'sensores':
                header('Location: sensor.php');
                exit();
            case 'trens':
                header('Location: trens.php');
                exit();
            case 'adicionar_perfil':
                header('Location: perfil.php');
                exit();
            case 'perfil':
                header('Location: perfil.php');
                exit();
            default:
                header('Location: index.php');
                exit();
        }
    }
}

$estacoes_finais = buscarEstacoesComLinhas($conn);
processarPost();

$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style3.css">
    <title>Estações</title>
</head>
<body>

<div class="container">

    <header>
        <button class="btn-back" onclick="history.back()">&#8592;</button>
        <span class="header-title">ESTAÇÕES</span>
    </header>

    <div class="search-container">
        <span class="search-icon">🔍</span>
        <input type="text" id="searchInput" placeholder="Pesquisar Estaçőes" onkeyup="filterStations()" autocomplete="off" />
    </div>

    <div id="stationsContainer">
        <?php 
        foreach ($estacoes_finais as $index => $estacao): 
            $nome_estacao_seguro = htmlspecialchars($estacao['nome_estacao']);
            $linhas = $estacao['linhas'];
        ?>
            <div class="station" data-name="<?= strtolower($nome_estacao_seguro) ?>">
                
                <div class="station-header" onclick="toggleLines(<?= $index ?>)">
                    <img src="../assets/icons/estacao_icon.png" alt="" class="icon" />
                    <h2><?= $nome_estacao_seguro ?></h2>
                    
                    <span class="toggle-arrow" id="arrow-<?= $index ?>">&#9660;</span>
                </div>
                
                <div class="lines-list" id="lines-<?= $index ?>"> 
                    <?php if (count($linhas) > 0): ?>
                        <?php foreach ($linhas as $linha): ?>
                            <span><?= htmlspecialchars($linha) ?></span>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Nenhuma linha disponível</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php 
        endforeach; 
        ?>
    </div>

</div>

<footer>
    <form action="" method="post" style="display: inline;">
        <input type="hidden" name="redirect_page" value="sensores">
        <button type="submit" title="Sensores">
            <img src="../assets/icons/tela_sensor_icon.png" alt="Sensores">
        </button>
    </form>
    
    <form action="" method="post" style="display: inline;">
        <input type="hidden" name="redirect_page" value="trens">
        <button type="submit" title="Trens">
            <img src="../assets/icons/tela_tren_icon.png" alt="Trens">
        </button>
    </form>
    
    <form action="" method="post" style="display: inline;" class="active-page">
        <input type="hidden" name="redirect_page" value="estacoes">
        <button type="submit" title="Estacoes">
            <img src="../assets/icons/tela_estacao_icon.png" alt="Estacoes">
        </button>
    </form>
    
    <form action="" method="post" style="display: inline;">
        <input type="hidden" name="redirect_page" value="perfil">
        <button type="submit" title="Perfil">
            <img src="../assets/icons/tela_perfil_icon.png" alt="Perfil">
        </button>
    </form>
</footer>

<script>
    function toggleLines(index) {
        const lines = document.getElementById('lines-' + index);
        const arrow = document.getElementById('arrow-' + index);
        
        // Verifica se está visível
        if (lines.classList.contains('visible')) {
            lines.classList.remove('visible');
            arrow.innerHTML = '&#9660;';
        } else {
            lines.classList.add('visible');
            arrow.innerHTML = '&#9650;';
        }
    }

    function filterStations() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase(); 
        const stationsContainer = document.getElementById('stationsContainer');
        const stations = stationsContainer.getElementsByClassName('station');

        for (let i = 0; i < stations.length; i++) {
            const stationName = stations[i].getAttribute('data-name');
            
            if (stationName.includes(filter)) {
                stations[i].style.display = "block"; 
            } else {
                stations[i].style.display = "none"; 
            }
        }
    }

    document.addEventListener('DOMContentLoaded', (event) => {
        const allLines = document.querySelectorAll('.lines-list');
        allLines.forEach(lines => {
            lines.classList.remove('visible'); 
        });
    });
</script>

</body>
</html>