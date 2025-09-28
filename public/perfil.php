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
    if (isset($_POST['novo_nome'])) {
        $user['nome'] = trim($_POST['novo_nome']);
    }

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
    <title>Perfil</title>
    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            background: #000;
            font-family: Arial, sans-serif;
            color: white;
            margin: 40px;
            height: 700px;
            justify-content: center;
            align-items:center;
        }
        .perfil-container {
            background: #111;
            border-radius: 30px 30px 0 0 ;
            width: 350px;
            padding: 20px 20px 0 20px;
            text-align: center;
            position: relative;
        }


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
     
        #nova_foto {
            display: none;
        }

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
            padding: 0 0 20px 0 ;
        }
        .btn-remover {
            color: #e63946;
            font-weight: bold;
            cursor: pointer;
            text-transform: uppercase;
            border: none;
            background: none;
            font-size: 18px;
            padding: 0 0 20px 0 ;
        }

        .btn-alterar:hover {
            text-decoration: underline;
        }
        .btn-remover:hover {
            text-decoration: underline;
        }

              .photo-container {
  display: flex;
  align-items: center;
  gap: 12px;
}

.photo-circle {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  border: 3px solid #ccc;
  box-shadow: 0 2px 6px rgba(0,0,0,0.15);
}

.edit-icon {
  width: 30px;
  height: 30px;
  border-radius: 50%;
  background-color: #ddd;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
  box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

.name-container {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 24px;
  font-weight: 600;
  color: #f0f0f0;
}

.section {
  margin-top: 16px;
}

.button-blue {
  color: #0055ff;
  font-weight: bold;
  cursor: pointer;
}

.button-red {
  color: #ff3333;
  font-weight: bold;
  cursor: pointer;
  margin-left: 24px;
}      .photo-container {
  display: flex;
  align-items: center;
  gap: 12px;
}

.photo-circle {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  border: 3px solid #ccc;
  box-shadow: 0 2px 6px rgba(0,0,0,0.15);
}

.edit-icon {
  width: 30px;
  height: 30px;
  border-radius: 50%;
  background-color: #ddd;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
  box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

.name-container {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 24px;
  font-weight: 600;
  color: #f0f0f0;
}

.section {
  margin-top: 16px;
}

.button-blue {
  color: #0055ff;
  font-weight: bold;
  cursor: pointer;
}

.button-red {
  color: #ff3333;
  font-weight: bold;
  cursor: pointer;
  margin-left: 24px;
}

footer{
    background-color: #000;
    border-radius:  0 0 30px 30px;
    width: 350px;
    border-color: #808080; 
}

    </style>
</head>
<body>

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


    <input type="hidden" name="novo_nome" id="inputNome" value="<?php echo htmlspecialchars($user['nome']); ?>" />

    <br>


</form>

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
        icone.src = 'pen-icon.png';
        icone.alt = 'Editar Nome';
        icone.className = 'icone-editar';
        nomeDisplay.appendChild(icone);

      
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
