<?php
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

<<<<<<< HEAD
function buscarEstacoes($pdo) {
=======
require_once 'db.php'; 

function buscarEstacoesComLinhas($pdo) {
    
>>>>>>> 5eb6f576565ccb133e6831513e4e3a5d007292a0
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

<<<<<<< HEAD
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['redirect_page'])) {
    header("Location: " . $_POST['redirect_page'] . ".php");
    exit();
}

$estacoes = buscarEstacoes($pdo);
=======

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
            case 'estacoes': 
                header('Location: estacoes.php');
                exit();
            default:
                header('Location: index.php');
                exit();
        }
    }
}

$estacoes_finais = buscarEstacoesComLinhas($pdo); 
processarPost();


>>>>>>> 5eb6f576565ccb133e6831513e4e3a5d007292a0
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
                
                <div class="station-header" onclick="toggleLines(<?= $index ?>)">
                    <img src="../assets/icons/estacao_icon.png" alt="" width="50" height="50"/>
                    <h2><?= htmlspecialchars($estacao['nome_estacao']) ?></h2>
                    <span class="toggle-arrow" id="arrow-<?= $index ?>">&#9660;</span>
                </div>
                
                <div class="lines-list" id="lines-<?= $index ?>"> 
                    <?php if (!empty($linhas_raw)): ?>
                        <?php foreach ($linhas_raw as $linha_data): 
                            $parts = explode('|', $linha_data);
                            $nome_linha = $parts[0] ?? 'Linha';
                            $cor = $parts[1] ?? '#ccc';
                        ?>
                            <div class="line-item">
                                <span class="status-dot" style="background-color: <?= $cor ?>;" title="Status da Linha"></span>
                                <span><?= htmlspecialchars($nome_linha) ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="padding: 10px; color: #777;">Nenhuma linha ativa no momento.</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<footer>
    <?php 
    $menu = ['sensores' => 'tela_sensor_icon.png', 'trens' => 'tela_tren_icon.png', 'estacoes' => 'tela_estacao_icon.png', 'perfil' => 'tela_perfil_icon.png'];
    foreach($menu as $page => $icon): ?>
        <form action="" method="post" style="display:inline;">
            <input type="hidden" name="redirect_page" value="<?= $page ?>">
            <button type="submit"><img src="../assets/icons/<?= $icon ?>"></button>
        </form>
    <?php endforeach; ?>
</footer>

<script>
    function toggleLines(idx) {
        const el = document.getElementById(`lines-${idx}`);
        const arrow = document.getElementById(`arrow-${idx}`);
        el.classList.toggle('visible');
        arrow.innerHTML = el.classList.contains('visible') ? '&#9650;' : '&#9660;';
    }

    function filterStations() {
        const term = document.getElementById('searchInput').value.toLowerCase();
        document.querySelectorAll('.station').forEach(st => {
            st.style.display = st.dataset.name.includes(term) ? 'block' : 'none';
        });
    }
</script>
</body>
</html>