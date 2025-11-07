<?php

require_once 'db.php'; 

$sql_estacoes = "SELECT estacao_id, nome_estacao FROM estacoes ORDER BY estacao_id ASC";
$result_estacoes = $conn->query($sql_estacoes);

$estacoes_bd = [];
if ($result_estacoes->num_rows > 0) {
    while($row = $result_estacoes->fetch_assoc()) {
        $estacoes_bd[] = $row;
    }
}

$sql_linhas = "SELECT nome_linha FROM linhas_trens WHERE estacao_id = ?";
$stmt_linhas = $conn->prepare($sql_linhas);


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
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="../style/style2.css">
    <title>Estações</title>
</head>
<body>

<div class="container">
    <header>
        <button class="btn-back" onclick="history.back()">&#8592;</button>
        <h1>ESTAÇÕES</h1>
    </header>
    <input type="text" id="searchInput" placeholder="Filtrar estações..." onkeyup="filterStations()">
    
    <div id="stationsContainer">
        
        <?php 
        $index = 0; 
        foreach ($estacoes_bd as $estacao): 
            
            $stmt_linhas->bind_param("i", $estacao['estacao_id']);
            $stmt_linhas->execute();
            $result_linhas = $stmt_linhas->get_result();
            
            $linhas = [];
            if ($result_linhas->num_rows > 0) {
                while ($linha_row = $result_linhas->fetch_assoc()) {
                    $linhas[] = $linha_row['nome_linha'];
                }
            }
            
        ?>
            <div class="station" data-name="<?= strtolower($estacao['nome_estacao']) ?>">
                <div class="station-header" onclick="toggleLines(<?= $index ?>)">
                    <img src="assets/icons/station-icon.png" alt="Estação" class="icon" onerror="this.style.display='none'" />
                    <h2><?= htmlspecialchars($estacao['nome_estacao']) ?></h2>
                    <span class="toggle-arrow" id="arrow-<?= $index ?>">&#9650;</span>
                </div>
                <div class="lines-list" id="lines-<?= $index ?>"> 
                    <?php if (count($linhas) > 0): ?>
                        <?php foreach ($linhas as $linha): ?>
                            <span><?= htmlspecialchars($linha) ?></span>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="color:#777; font-style: italic;">Nenhuma linha disponível</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php 
        $index++; 
        endforeach; 
        
        $stmt_linhas->close();
        $conn->close();
        ?>
    </div>

</div>

<footer>
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
    document.addEventListener('DOMContentLoaded', () => {
        const stations = document.querySelectorAll('.station');
        stations.forEach((station, idx) => {
            const lines = station.querySelector('.lines-list');
            const arrow = station.querySelector('.toggle-arrow');
            
            lines.classList.remove('visible'); 
            arrow.classList.add('rotate');
        });
    });

    function toggleLines(index) {
        const lines = document.getElementById('lines-' + index);
        const arrow = document.getElementById('arrow-' + index);
        
        if (lines.classList.contains('visible')) {
            lines.classList.remove('visible');
            arrow.classList.add('rotate');
        } else {
            lines.classList.add('visible');
            arrow.classList.remove('rotate');
        }
    }

    function filterStations() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase();
        const stations = document.querySelectorAll('#stationsContainer .station');

        stations.forEach(station => {
            const name = station.getAttribute('data-name');
            if (name.includes(filter)) {
                station.style.display = '';
            } else {
                station.style.display = 'none';
            }
        });
    }
</script>

</body>
</html>