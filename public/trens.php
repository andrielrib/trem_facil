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

include "db.php";

$terminal = [
    "nome" => "Terminal Norte",
    "linhas" => []
];

$linhas_db = $pdo->query("
    SELECT 
        id_linha, 
        id_exibicao AS id, 
        nome, 
        status, 
        status_color 
    FROM linha
")->fetchAll();


foreach ($linhas_db as $linha) {
    
    $stmt_paradas = $pdo->prepare("SELECT nome, tempo FROM parada WHERE id_linha = ?");
    $stmt_paradas->execute([ $linha['id_linha'] ]);
    $linha['paradas'] = $stmt_paradas->fetchAll();

    $stmt_estacoes = $pdo->prepare("
        SELECT id_estacao_horario, nome_estacao 
        FROM estacao_horario 
        WHERE id_linha = ?
    ");
    $stmt_estacoes->execute([ $linha['id_linha'] ]);
    
    $horarios_agrupados = [];
    foreach ($stmt_estacoes->fetchAll() as $estacao) {
        
        $stmt_horas = $pdo->prepare("
            SELECT TIME_FORMAT(hora, '%k:%i') AS hora_formatada 
            FROM horario 
            WHERE id_estacao_horario = ?
        ");
        $stmt_horas->execute([ $estacao['id_estacao_horario'] ]);
        
        $lista_de_horas = $stmt_horas->fetchAll(PDO::FETCH_COLUMN); 
        
        if (!empty($lista_de_horas)) {
            $horarios_agrupados[ $estacao['nome_estacao'] ] = $lista_de_horas;
        }
    }
    
    $linha['horarios'] = $horarios_agrupados;
    
    $terminal['linhas'][] = $linha;
}

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
            exit();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Trens - <?=htmlspecialchars($terminal['nome'])?></title>
    <link rel="stylesheet" href="../style/style3.css">
</head>
<body>
    <div id="app" role="main" aria-label="Lista de linhas de trem">
        <header>
            <button class="btn-back" aria-label="Voltar" onclick="history.back();">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24" fill="none" aria-hidden="true" focusable="false">
                    <polyline points="15 18 9 12 15 6" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Voltar
            </button>
            <div class="title">Trens</div>
            <div class="btn-trens" aria-hidden="true">TRENS</div>
        </header>

        <div class="search-container">
            <button type="submit" class="search-button">
                <svg width="20" height="20" viewBox="0 0 24" fill="none" xmlns="../assets/icons/icone_lupa.png">
                    <path d="M21 21L15.0001 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="#999" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <input type="search" id="searchInput" placeholder="Pesquisar Trem" class="search-input">
        </div>

        <?php foreach ($terminal['linhas'] as $linha): ?>
            <article class="trem" data-nome="<?=htmlspecialchars(strtolower($linha['nome']))?>">
                <div class="header-trem">
                    <div class="info-trem">
                        <svg class="icon-train" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24" 24" aria-hidden="true" focusable="false">
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
                        <label class="toggle-label" for="toggle-<?=htmlspecialchars($linha['id'])?>">
                            <span>Mostrar Horários</span>
                            <div class="toggle-switch">
                                <input type="checkbox" id="toggle-<?=htmlspecialchars($linha['id'])?>">
                                <span class="slider"></span>
                            </div>
                        </label>
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
        const searchInput = document.getElementById('searchInput');
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