<?php
session_start();

$default_user = [
    'id' => 329,
    'nome' => 'Nome',
    'cargo' => 'Administrador',
    'permissoes' => 'Geral',
    'foto' => 'default-profile.png'
];
if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = $default_user;
}
$user = $_SESSION['user'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Só altera a foto se houver upload novo
    if (isset($_FILES['nova_foto']) && $_FILES['nova_foto']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['nova_foto']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($ext, $allowed)) {
            $dir = __DIR__ . '/../uploads';
            if (!is_dir($dir)) mkdir($dir, 0777, true);
            $novo_nome_arquivo = 'uploads/perfil_' . $user['id'] . '.' . $ext;
            move_uploaded_file($_FILES['nova_foto']['tmp_name'], __DIR__ . '/../' . $novo_nome_arquivo);
            $user['foto'] = $novo_nome_arquivo;
        }
    } else {
        // Se não houve upload, mantém a foto já salva em $user['foto']
        if (!isset($user['foto']) || empty($user['foto'])) {
            $user['foto'] = $default_user['foto'];
        }
    }

    $_SESSION['user'] = $user;

    if (!isset($_POST['redirect_page'])) {
        header('Location: perfil.php');
        exit();
    }

    if (isset($_POST['redirect_page'])) {
        $page = $_POST['redirect_page'];
        if ($page === 'sensores') {
            header('Location: ../private/sensor.php');
            exit();
        } elseif ($page === 'trens') {
            header('Location: trens.php');
            exit();
        } elseif ($page === 'estacoes') {
            header('Location: estacoes.php');
            exit();
        } elseif ($page === 'perfil') {
            header('Location: perfil.php');
            exit();
        } else {
            header('Location: index.php');
            exit();
        }
    }
}

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'alterar_conta':
            header('Location: login.php');
            exit;
        case 'remover_conta':
            header('Location: voce_tem_certza.php');
            exit;
        case 'suporte':
            header('Location: suporte_alerta.php');
            exit;
        case 'editar':
            header('Location: cadastro1.php');
            exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Perfil</title>
    <link rel="stylesheet" href="../style/style2.css">
</head>
<body onload="loadRandomFoxBackground()">
    <div class="wrapper">
        <form method="POST" enctype="multipart/form-data" id="perfilForm" class="perfil-container" action="">
            <div class="foto-container">
                <img id="imagemPerfil" src="<?php echo (strpos($user['foto'], 'uploads/') === 0 ? '../' : '../assets/') . htmlspecialchars($user['foto']); ?>" alt="Foto Perfil" />
                <label for="nova_foto" title="Alterar foto de perfil">
                    <img src="../assets/icons/caneta.png" alt="Editar Foto" />
                </label>
                <input type="file" name="nova_foto" id="nova_foto" accept="image/*" onchange="previewImagem(this)" />
            </div>

            <div class="nome-editavel" id="nomeDisplay">
                <span id="nomeTexto"><?php echo htmlspecialchars($user['nome']); ?></span>
            </div>

            <div class="info-section">
                <div class="info">
                    <b>ID</b>
                    #<?php echo $user['id']; ?>
                </div>
                <div class="info">
                    <b>CARGO</b>
                    <?php echo htmlspecialchars($user['cargo']); ?>
                </div>
                <div class="info">
                    <b>PERMISSÕES</b>
                    <?php echo htmlspecialchars($user['permissoes']); ?>
                </div>
            </div>

            <div class="suporte-section">
                <b>SUPORTE</b>
                <small> Clique <a href="?action=suporte">aqui</a> para ser redirecionado para tela de suporte </small>
            </div>
            <br>
            <br>
        </form>

        <!-- Botão de Logout -->
        <div style="text-align: center; margin-top: 20px;">
            <a href="login.php?logout=1" onclick="return confirm('Tem certeza que deseja sair?')" style="background-color: #f44336; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;">Logout</a>
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
        function previewImagem(input) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagemPerfil').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        async function loadRandomFoxBackground() {
            try {
                const response = await fetch('../public/apis.php/apis.php?fox');
                const data = await response.json();
                if (data.image) {
                    document.body.style.backgroundImage = `url('${data.image}')`;
                }
            } catch (error) {
                console.error('Erro ao carregar fundo de raposa:', error);
            }
        }
    </script>
</body>
</html>
