<?php
session_start();

$user = [
    'id' => 329,
    'nome' => 'Nome',
    'cargo' => 'Administrador',
    'permissoes' => 'Geral',
    'foto' => 'default-profile.png' 
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Processa a atualização do nome
    if (isset($_POST['novo_nome'])) {
        $user['nome'] = trim($_POST['novo_nome']);
    }

    // Processa a atualização da foto
    if (isset($_FILES['nova_foto']) && $_FILES['nova_foto']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['nova_foto']['name'], PATHINFO_EXTENSION);
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array(strtolower($ext), $allowed)) {
            $novo_nome_arquivo = 'uploads/perfil_' . $user['id'] . '.' . $ext;
            if (!is_dir('uploads')) mkdir('uploads');
            move_uploaded_file($_FILES['nova_foto']['tmp_name'], $novo_nome_arquivo);
            $user['foto'] = $novo_nome_arquivo;
        }
    }

    // Processa redirecionamentos apenas se 'redirect_page' estiver definido
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
                header('Location: index.php');  // Redireciona para index apenas se necessário
                exit();
        }
    }
    // Se não for um redirecionamento, continua renderizando a página atual
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
    <style>
        /* Estilos gerais */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            background: #000;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }

        .wrapper {
            width: 100%;
            max-width: 400px;
            background: #111;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
            transition: transform 0.3s ease;
        }

        .wrapper:hover {
            transform: scale(1.02);
        }

        .perfil-container {
            padding: 20px;
            text-align: center;
        }

        .foto-container {
            position: relative;
            width: 150px;
            height: 150px;
            margin: 0 auto 20px;
        }

        .foto-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #ccc;
            background: #ccc;
        }

        .foto-container label {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(128, 128, 128, 0.7);
            border-radius: 50%;
            width: 35px;
            height: 35px;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .foto-container label img {
            width: 20px;
            height: 20px;
        }

        #nova_foto {
            display: none;
        }

        .nome-editavel {
            font-weight: bold;
            font-size: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            cursor: pointer;
        }

        .nome-editavel input {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            background: transparent;
            border: none;
            border-bottom: 1px solid white;
            color: white;
            outline: none;
            width: 80%;
        }

        .nome-editavel .icone-editar {
            width: 18px;
            height: 18px;
            margin-left: 8px;
            opacity: 0.7;
        }

        .info-section {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 20px;
            text-align: left;
        }

        .info {
            padding: 10px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
        }

        .info b {
            font-weight: 800;
            margin-bottom: 5px;
        }

        .links-conta {
            margin-bottom: 20px;
            text-align: left;
        }

        .links-conta b {
            display: block;
            margin-bottom: 10px;
            color: white;
        }

        .links-conta small {
            display: block;
            color: #ccc;
            font-weight: normal;
        }

        .links-conta a {
            color: #00cc00;
            text-decoration: none;
        }

        .links-conta a:hover {
            text-decoration: underline;
        }

        .botoes-conta {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }

        .btn-alterar, .btn-remover {
            color: white;
            font-weight: bold;
            cursor: pointer;
            border: none;
            background: none;
            font-size: 18px;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .btn-alterar {
            background: #0057b7;
        }

        .btn-alterar:hover {
            background: #003d82;
        }

        .btn-remover {
            background: #e63946;
        }

        .btn-remover:hover {
            background: #b2222e;
        }

        footer {
            background: #000;
            width: 100%;
            padding: 15px;
            display: flex;
            justify-content: center;
            gap: 10px;
            border-top: 1px solid #808080;
        }

        footer form {
            margin: 0;
        }

        footer button {
            border: none;
            background: none;
            cursor: pointer;
        }

        footer img {
            width: 60px;
            height: 60px;
            transition: transform 0.3s;
        }

        footer img:hover {
            transform: scale(1.1);
        }
    </style>
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
            <button type="submit" title="Estacoes">
                <img src="../assets/icons/tela_estacao_icon.png" alt="botão para tela estacoes">
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
