<?php
session_start();

// Simulação de dados carregados de banco ou sessão
$user = [
    'id' => 329,
    'nome' => 'Nome',
    'cargo' => 'Administrador',
    'permissoes' => 'Geral',
    'foto' => 'default-profile.png' // arquivo de imagem padrão
];

// Atualização do nome via POST (edição inline)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['novo_nome'])) {
        $user['nome'] = trim($_POST['novo_nome']);
    }

    // Upload da foto (se enviada) para alterar a foto de perfil
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
}

// Redirecionamentos via GET (links clicados)
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'alterar_conta':
            header('Location: login.php');
            exit;
        case 'remover_conta':
            header('Location: vooce_tem_certeza.php');
            exit;
        case 'suporte':
            header('Location: suporte.php');
            exit;
        case 'editar':
            header('Location: cadastro.php');
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
        /* Reset básico */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            background: #000;
            font-family: Arial, sans-serif;
            color: white;
            display:flex;
            justify-content: center;
            align-items:center;
            height: 100vh;
        }
        .perfil-container {
            background: #111;
            border-radius: 30px;
            width: 350px;
            padding: 20px;
            text-align: center;
            position: relative;
        }

        /* Imagem perfil circular com borda */
        .foto-container {
            position: relative;
            width: 150px;
            height: 150px;
            margin: 0 auto 15px;
        }
        .foto-container img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #ccc;
            background: #ccc;
        }
        /* Ícone caneta no canto superior direito da imagem */
        .foto-container label {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(128, 128, 128, 0.7);
            border-radius: 50%;
            width: 35px;
            height: 35px;
            cursor: pointer;
            display:flex;
            justify-content: center;
            align-items: center;
        }
        .foto-container label img {
            width: 20px;
            height: 20px;
        }
        /* input file escondido */
        #nova_foto {
            display: none;
        }

        /* Nome com ícone caneta para editar inline */
        .nome-editavel {
            font-weight: bold;
            font-size: 24px;
            display: inline-flex;
            align-items: center;
            margin-bottom: 10px;
            cursor: pointer;
            user-select: none;
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
            width: 150px;
        }
        .nome-editavel .icone-editar {
            width: 18px;
            height: 18px;
            margin-left: 6px;
            opacity: 0.7;
        }
        /* Info simples */
        .info {
            text-align: left;
            margin: 10px 0;
            font-weight: normal;
        }
        .info b {
            display: block;
            font-weight: 800;
            margin-bottom: 3px;
        }
        /* Links editar conta e suporte */
        .links-conta {
            margin-top: 15px;
            text-align: left;
        }
        .links-conta b {
            display: block;
            margin-bottom: 3px;
            color: white;
        }
        .links-conta small {
            margin-bottom: 5px;
            display: block;
            color: #ccc;
            font-weight: normal;
        }
        .links-conta a {
            color: #00cc00;
            text-decoration: underline;
            cursor: pointer;
        }

        /* Botões ALTERAR e REMOVER CONTA */
        .botoes-conta {
            margin-top: 25px;
            display: flex;
            justify-content: space-around;
        }
        .btn-alterar {
            color: #0057b7;
            font-weight: bold;
            cursor: pointer;
            text-transform: uppercase;
            border: none;
            background: none;
            font-size: 18px;
        }
        .btn-remover {
            color: #e63946;
            font-weight: bold;
            cursor: pointer;
            text-transform: uppercase;
            border: none;
            background: none;
            font-size: 18px;
        }

        /* Hover para botões */
        .btn-alterar:hover {
            text-decoration: underline;
        }
        .btn-remover:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>

<form method="POST" enctype="multipart/form-data" id="perfilForm" class="perfil-container" action="">
    <div class="foto-container">
        <img id="imagemPerfil" src="<?php echo htmlspecialchars($user['foto']); ?>" alt="Foto Perfil" />
        <label for="nova_foto" title="Alterar foto de perfil">
            <img src="pen-icon.png" alt="Editar Foto" />
        </label>
        <input type="file" name="nova_foto" id="nova_foto" accept="image/*" onchange="previewImagem(this)" />
    </div>

    <div class="nome-editavel" id="nomeDisplay" onclick="editarNome()" title="Clique para editar nome">
        <span id="nomeTexto"><?php echo htmlspecialchars($user['nome']); ?></span>
        <img src="pen-icon.png" alt="Editar Nome" class="icone-editar" />
    </div>

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

    <!-- input oculto para o nome editado -->
    <input type="hidden" name="novo_nome" id="inputNome" value="<?php echo htmlspecialchars($user['nome']); ?>" />
</form>

<script>
    // Preview da imagem selecionada
    function previewImagem(input) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagemPerfil').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
            // Envia o form automaticamente após escolher a foto se quiser, senão comente essa linha
            // document.getElementById('perfilForm').submit();
        }
    }

    // Permite editar o nome inline
    const nomeDisplay = document.getElementById('nomeDisplay');
    const nomeTexto = document.getElementById('nomeTexto');
    const inputNome = document.getElementById('inputNome');

    function editarNome() {
        if (nomeDisplay.querySelector('input')) return; // Não permite abrir outro input repetido

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
        if (valor.trim() === '') valor = 'Nome'; // valor padrão
        nomeTexto.textContent = valor;
        inputNome.value = valor;
        nomeDisplay.innerHTML = '';
        nomeDisplay.appendChild(nomeTexto);
        // Ícone caneta
        const icone = document.createElement('img');
        icone.src = 'pen-icon.png';
        icone.alt = 'Editar Nome';
        icone.className = 'icone-editar';
        nomeDisplay.appendChild(icone);

        // Enviar o formulário para salvar a alteração no backend
        document.getElementById('perfilForm').submit();
    }

    function cancelarEdicao() {
        nomeDisplay.innerHTML = '';
        nomeDisplay.appendChild(nomeTexto);
        const icone = document.createElement('img');
        icone.src = 'pen-icon.png';
        icone.alt = 'Editar Nome';
        icone.className = 'icone-editar';
        nomeDisplay.appendChild(icone);
    }
</script>

</body>
</html>
