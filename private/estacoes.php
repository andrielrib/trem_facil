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
            e.nome_estacao AS nome_estacao, 
            GROUP_CONCAT(DISTINCT CONCAT(l.id_exibicao, ' - ', l.nome, '|', l.status_color) ORDER BY l.id_exibicao ASC SEPARATOR '||') AS dados_linhas
        FROM estacoes e
        LEFT JOIN linhas_trens lt ON e.estacao_id = lt.estacao_id
        LEFT JOIN linha l ON lt.linha_id = l.id_linha
        GROUP BY e.estacao_id, e.nome_estacao
        ORDER BY e.nome_estacao ASC
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
<a href="<?= $backPage ?>"><img src="../assets/icons/seta_esquerda.png" alt="Voltar" style="position: absolute; top: 10px; left: 10px; width: 40px; height: 40px; cursor: pointer; z-index: 1000;"></a>

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
