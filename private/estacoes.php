<?php
session_start();

$db_host = 'localhost';
$db_name = 'trem_facil';
$db_user = 'root';
$db_pass = 'root';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar: " . $e->getMessage());
}

$backPage = '../private/pagina_inicial_adm.php';
if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 1) {
    $backPage = '../pagina_inicial.php';
}

function buscarEstacoes($pdo) {
    $sql = "
        SELECT 
            e.nome AS nome_estacao, 
            GROUP_CONCAT(DISTINCT CONCAT(l.id_exibicao, ' - ', l.nome, '|', l.status_color) ORDER BY l.id_exibicao ASC SEPARATOR '||') AS dados_linhas
        FROM estacao e
        LEFT JOIN estacao_linha el ON e.id_estacao = el.id_estacao
        LEFT JOIN linha l ON el.id_linha = l.id_linha
        GROUP BY e.id_estacao, e.nome
        ORDER BY e.nome ASC
    ";
    
    try {
        return $pdo->query($sql)->fetchAll();
    } catch (PDOException $e) {
        return [];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['redirect_page'])) {
    header("Location: " . $_POST['redirect_page'] . ".php");
    exit();
}

$estacoes = buscarEstacoes($pdo);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style3.css">
    <title>Estações - Admin</title>
</head>
<body>
<a href="<?= $backPage ?>"><img src="../assets/icons/seta_esquerda.png" alt="Voltar" style="position: absolute; top: 10px; left: 10px; width: 40px; height: 40px; cursor: pointer;"></a>

<div class="container">
    <header>
        <button class="btn-back" onclick="history.back()">&#8592;</button>
        <span class="header-title">ESTAÇÕES - ADMIN</span>
    </header>

    <div class="search-container">
        <span class="search-icon">🔍</span>
        <input type="text" id="searchInput" placeholder="Pesquisar Estações..." onkeyup="filterStations()" autocomplete="off" />
    </div>

    <div class="status-legend">
        <div class="legend-item">
            <span class="legend-bar bg-green"></span>
            <span>ATIVO</span>
        </div>
        <div class="legend-item">
            <span class="legend-bar bg-yellow"></span>
            <span>MANUTENÇÃO</span>
        </div>
        <div class="legend-item">
            <span class="legend-bar bg-red"></span>
            <span>INATIVO</span>
        </div>
    </div>
    <div id="stationsContainer">
        <?php foreach ($estacoes as $index => $estacao): 
            $linhas_raw = $estacao['dados_linhas'] ? explode('||', $estacao['dados_linhas']) : [];
        ?>
            <div class="station" data-name="<?= strtolower($estacao['nome_estacao']) ?>">
                
<div class="container">

    <header>

    <div class = "afastamento">
        <button class="btn-back" onclick="history.back()">&#8592;</button>
        <span class="header-title">ESTAÇÕES</span>
        </div>
         <a href="pagina_inicial.php"><img src="../assets/icons/seta_esquerda.png" alt="Voltar" style="position: absolute; top: 10px; left: 10px; width: 40px; height: 40px; cursor: pointer;"></a>
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
                    <img src="../assets/icons/estacao_icon.png" alt="" width="50" heigth="50"/>
                    <h2><?= $nome_estacao_seguro ?></h2>
                    
                    <span class="toggle-arrow" id="arrow-<?= $index ?>">&#9660;</span>
                </div>
                
                <div class="lines-list" id="lines-<?= $index ?>"> 
                    <?php if (count($linhas) > 0 && !empty($linhas[0])): // Verificação extra ?>
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
        
        <?php if (empty($estacoes_finais)): ?>
            <p style="color: white; text-align: center; padding: 20px;">
                Nenhuma estação encontrada. Verifique seu banco de dados.
            </p>
        <?php endif; ?>
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
    function toggleLines(index) {
        const lines = document.getElementById('lines-' + index);
        const arrow = document.getElementById('arrow-' + index);
        
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