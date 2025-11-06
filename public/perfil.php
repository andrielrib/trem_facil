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
    if (isset($_POST['novo_nome'])) {
        $user['nome'] = trim($_POST['novo_nome']) !== '' ? trim($_POST['novo_nome']) : 'Nome';
    }

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
        if (empty($user['foto'])) {
            $user['foto'] = 'default-profile.png';
        }
    }

    $_SESSION['user'] = $user;

    if (!isset($_POST['redirect_page'])) {
        header('Location: perfil.php');
        exit();
    }

    if (isset($_POST['redirect_page'])) {
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
<body>
    <div class="wrapper">
        <form method="POST" enctype="multipart/form-data" id="perfilForm" class="perfil-container" action="">
            <div class="foto-container">
                <img id="imagemPerfil" src="<?php echo htmlspecialchars($user['foto']); ?>" alt="Foto Perfil" />
                <label for="nova_foto" title="Alterar foto de perfil">
                    <img src="../assets/icons/caneta.png" alt="Editar Foto" />
                </label>
                <input type="file" name="nova_foto" id="nova_foto" accept="image/*" onchange="previewImagem(this)" />
            </div>

            <div class="nome-editavel" id="nomeDisplay" onclick="editarNome()" title="Clique para editar nome">
                <span id="nomeTexto"><?php echo htmlspecialchars($user['nome']); ?></span>
                <img src="../assets/icons/caneta.png" alt="Editar Nome" class="icone-editar" />
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

            <div class="links-conta">
                <b>EDITAR CONTA</b>
                <small> Clique <a href="?action=editar">aqui</a> para ser redirecionado para tela de cadastro </small>
                <b>SUPORTE</b>
                <small> Clique <a href="?action=suporte">aqui</a> para ser redirecionado para tela de suporte </small>
            </div>

            <div class="botoes-conta">
                <button type="button" class="btn-alterar" onclick="window.location.href='?action=alterar_conta'">ALTERAR CONTA</button>
                <button type="button" class="btn-remover" onclick="window.location.href='?action=remover_conta'">REMOVER CONTA</button>
            </div>

            <input type="hidden" name="novo_nome" id="inputNome" value="<?php echo htmlspecialchars($user['nome']); ?>" />
        </form>
    </div>

    <footer role="contentinfo" aria-label="Menu principal">
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
    function previewImagem(input) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagemPerfil').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    const nomeDisplay = document.getElementById('nomeDisplay');
    const nomeTexto = document.getElementById('nomeTexto');
    const inputNome = document.getElementById('inputNome');

    function editarNome() {
        if (nomeDisplay.querySelector('input')) return;
        const input = document.createElement('input');
        input.type = 'text';
        input.value = nomeTexto.textContent;
        input.maxLength = 50;
        input.autofocus = true;
        input.addEventListener('blur', () => salvarNome(input.value));
        input.addEventListener('keydown', e => {
            if (e.key === 'Enter') {
                e.preventDefault();
                input.blur();
            }
            if (e.key === 'Escape') {
                cancelarEdicao();
            }
        });
        nomeDisplay.innerHTML = '';
        nomeDisplay.appendChild(input);
        input.focus();
    }

    function salvarNome(valor) {
        if (valor.trim() === '') valor = 'Nome';
        nomeTexto.textContent = valor;
        inputNome.value = valor;
        nomeDisplay.innerHTML = '';
        nomeDisplay.appendChild(nomeTexto);
        const icone = document.createElement('img');
        icone.src = '../assets/icons/caneta.png';
        icone.alt = 'Editar Nome';
        icone.className = 'icone-editar';
        nomeDisplay.appendChild(icone);
        document.getElementById('perfilForm').submit();
    }

    function cancelarEdicao() {
        nomeDisplay.innerHTML = '';
        nomeDisplay.appendChild(nomeTexto);
        const icone = document.createElement('img');
        icone.src = '../assets/icons/caneta.png';
        icone.alt = 'Editar Nome';
        icone.className = 'icone-editar';
        nomeDisplay.appendChild(icone);
    }
</script>
</body>
</html>
