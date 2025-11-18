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
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}

require_once '../public/db.php'; // Este arquivo fornece a variável $pdo

function buscarEstacoesComLinhas($pdo) {
    // Esta SQL busca os nomes das estações e agrupa todas as linhas
    // que passam por ela, usando as tabelas que REALMENTE têm dados.
    $sql = "
        SELECT 
            estacao, 
            GROUP_CONCAT(l.nome SEPARATOR '|') AS linhas
        FROM estacao eh
        JOIN linha l ON eh.id_linha = l.id_linha
        GROUP BY eh.nome_estacao
        ORDER BY eh.nome_estacao ASC
    ";
    
    try {
        $stmt = $pdo->query($sql);
        $estacoes = [];
        
        while ($row = $stmt->fetch()) {
            $linhas = $row['linhas'] ? explode('|', $row['linhas']) : [];
            $estacoes[] = [
                'nome_estacao' => $row['nome_estacao'],
                'linhas' => $linhas
            ];
        }
        return $estacoes;

    } catch (PDOException $e) {
        die("Erro na consulta: " . $e->getMessage());
    }
}


function processarPost() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $page = $_POST['redirect_page'] ?? '';
        switch ($page) {
            case 'sensores':
                header('Location: ../private/sensor.php');
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
            case 'estacoes': // Adicionado para evitar loop
                header('Location: estacoes.php');
                exit();
            default:
                header('Location: index.php');
                exit();
        }
    }
}

$estacoes_finais = buscarEstacoesComLinhas($pdo); // Usando $pdo
processarPost();

// $conn->close(); // Não é necessário para PDO, a conexão fecha sozinha
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