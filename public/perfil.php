<?php
session_start();

// Credenciais do banco (SUBSTITUA PELAS SUAS REAIS!)
$host = 'localhost';
$username = 'root';  // Usuário MySQL
$password = '';      // Senha MySQL (vazia para local)
$dbname = 'trem_facil';

// Conexão com o banco
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erro de conexão com o banco: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");  // Suporte a UTF-8 para nomes com acentos

$user_id = intval($_SESSION['user_id']);

// Carrega dados do usuário do BD
$stmt = $conn->prepare("SELECT nome_completo, tipo_usuarios FROM usuarios WHERE id_usuario = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $user = [
        'id' => $user_id,
        'nome' => $row['nome_completo'] ?? $_SESSION['user_nome'] ?? 'Nome do Usuário',
        'cargo' => $row['tipo_usuarios'] == 1 ? 'Administrador' : 'Usuário',  // Adaptado ao schema
        'permissoes' => 'Geral',  // Hardcoded, pois não está no schema
        'foto' => $_SESSION['user_foto'] ?? 'default_profile.png' 
    ];
    // Sincroniza sessão com BD
    $_SESSION['user_nome'] = $user['nome'];
} else {
    // Usuário não encontrado no BD
    session_destroy();
    header('Location: login.php');
    exit;
}
$stmt->close();

// Handler para atualizar nome (POST AJAX) - Adaptado ao BD
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_name'])) {
    $novoNome = trim($_POST['nome']);
    if (!empty($novoNome) && mb_strlen($novoNome) <= 120) {  // Limite do BD: VARCHAR(120)
        $stmt = $conn->prepare("UPDATE usuarios SET nome_completo = ? WHERE id_usuario = ?");
        $stmt->bind_param("si", $novoNome, $user_id);
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $_SESSION['user_nome'] = $novoNome;
                echo json_encode(['success' => true, 'nome' => $novoNome]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Usuário não encontrado ou sem alterações']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro no banco de dados']);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Nome inválido (máx. 120 caracteres)']);
    }
    $conn->close();
    exit;
}

// Handler para upload de foto (POST)
$upload_error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload_photo'])) {
    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile_photo']['tmp_name'];
        $fileName = basename($_FILES['profile_photo']['name']);
        $fileSize = $_FILES['profile_photo']['size'];
        $fileType = $_FILES['profile_photo']['type'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

        if (!in_array($fileType, $allowedTypes)) {
            $upload_error = "Tipo de arquivo não permitido. Use JPEG, PNG ou GIF.";
        } elseif ($fileSize > 2 * 1024 * 1024) { 
            $upload_error = "Arquivo muito grande. Max 2MB.";
        } else {
            $newFileName = 'profile_' . $user_id . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
            $uploadDir = __DIR__ . '/uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $destPath = $uploadDir . $newFileName;
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $_SESSION['user_foto'] = 'uploads/' . $newFileName;
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            } else {
                $upload_error = "Erro ao salvar o arquivo.";
            }
        }
    } else {
        $upload_error = "Nenhum arquivo enviado ou erro no upload.";
    }
    // Armazena erro em sessão para exibir após redirect
    $_SESSION['upload_error'] = $upload_error;
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Recupera erro de upload da sessão (flash message)
if (isset($_SESSION['upload_error'])) {
    $upload_error = $_SESSION['upload_error'];
    unset($_SESSION['upload_error']);
}

$fotoUrl = htmlspecialchars($user['foto'], ENT_QUOTES, 'UTF-8');
$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Perfil - Minha SA</title>
<style>
  body {
    background-color: #000;
    color: #fff;
    font-family: Arial, sans-serif;
  }
  .perfil-container {
    max-width: 360px;
    margin: 10px auto;
    padding: 10px;
    background-color: #111;
    border-radius: 15px;
    text-align: center;
    position: relative;
  }
  .foto-container {
    position: relative;
    width: 120px;
    height: 120px;
    margin: 0 auto 10px;
  }
  .foto-container img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    border: 4px solid #ccc;
    object-fit: cover;
  }
  .foto-container .edit-foto-icon {
    position: absolute;
    bottom: 5px;
    right: 5px;
    background: rgba(255,255,255,0.8);
    border-radius: 50%;
    padding: 5px;
    cursor: pointer;
  }
  .edit-foto-icon svg {  /* Ajuste para SVG em vez de img */
    width: 24px;
    height: 24px;
  }
  #nome-display {
    font-weight: bold;
    font-size: 1.5em;
    margin-bottom: 5px;
    display: inline-flex;
    align-items: center;
    cursor: pointer;
  }
  #nome-display svg {
    margin-left: 6px;
    width: 18px;
    height: 18px;
    fill: #ccc;
  }
  #nome-input {
    font-size: 1.5em;
    padding: 4px;
    border-radius: 4px;
    border: none;
    width: 200px;
    display: none;
    background: #333;
    color: #fff;
  }
  .info-label {
    font-weight: bold;
    margin-top: 10px;
  }
  .small-text {
    font-size: 0.85em;
    color: #bbb;
    margin-bottom: 8px;
  }
  a {
    color: #06f;
    cursor: pointer;
    text-decoration: underline;
  }
  .action-buttons {
    margin-top: 20px;
  }
  .btn {
    cursor: pointer;
    display: block;
    margin: 10px auto;
    width: 80%;
    padding: 10px;
    border-radius: 6px;
    font-weight: bold;
    font-size: 1.1em;
    user-select: none;
  }
  .btn-alterar {
    background: none;
    color: #007bff;
    border: 2px solid #007bff;
  }
  .btn-remover {
    background: none;
    color: #e00;
    border: 2px solid #e00;
  }
  .btn-alterar:hover {
    background-color: #007bff;
    color: #fff;
  }
  .btn-remover:hover {
    background-color: #e00;
    color: #fff;
  }
  /* Modal */
  .modal-bg {
    display: none;
    position: fixed;
    top:0; left:0; width: 100%; height: 100%;
    background: rgba(0,0,0,0.7);
    justify-content: center;
    align-items: center;
    z-index: 1000;
  }
  .modal {
    background: #222;
    padding: 20px;
    border-radius: 12px;
    width: 300px;
    text-align: left;
  }
  .modal h2 {
    margin-top: 0;
    color: #fff;
  }
  .modal input[type=file] {
    width: 100%;
    margin-bottom: 10px;
  }
  .modal button {
    margin-top: 10px;
    width: 100%;
    padding: 8px;
    border: none;
    border-radius: 6px;
    background-color: #007bff;
    color: white;
    font-weight: bold;
    cursor: pointer;
  }
  .modal .close-btn {
    background-color: #555;
    margin-top: 5px;
  }
  .error-msg {
    color: #f33;
    margin-top: 10px;
    display: none;  /* Inicialmente escondido, mostrado via JS/PHP */
  }
</style>
</head>
<body>
<div class="perfil-container">

  <div class="foto-container" title="Clique para alterar foto de perfil">
    <img src="<?= $fotoUrl ?>" alt="Foto de Perfil" id="foto-perfil" />
    <div class="edit-foto-icon" id="btn-edit-foto" title="Editar foto">
      <svg xmlns="http://www.w3.org/2000/svg" fill="#000" viewBox="0 0 24 24" width="24" height="24">
        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM22.71 6.04a1.003 1.003 0 0 0 0-1.42l-2.34-2.34a1.003 1.003 0 0 0-1.42 0l-1.83 1.83 3.75 3.75 1.84-1.82z"/>
      </svg>
    </div>
  </div>

  <div>
    <span id="nome-display" title="Clique para editar nome">
      <span id="nome-text"><?= htmlspecialchars($user['nome'], ENT_QUOTES, 'UTF-8') ?></span>
      <svg xmlns="http://www.w3.org/2000/svg" fill="#ccc" viewBox="0 0 24 24">
        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM22.71 6.04a1.003 1.003 0 0 0 0-1.42l-2.34-2.34a1.003 1.003 0 0 0-1.42 0l-1.83 1.83 3.75 3.75 1.84-1.82z"/>
      </svg>
    </span>
    <input type="text" id="nome-input" maxlength="120" />
  </div>

  <div class="info-label">ID</div>
  <div class="small-text">#<?= intval($user['id']) ?></div>

  <div class="info-label">CARGO</div>
  <div class="small-text"><?= htmlspecialchars($user['cargo'], ENT_QUOTES, 'UTF-8') ?></div>

  <div class="info-label">PERMISSÕES</div>
  <div class="small-text"><?= htmlspecialchars($user['permissoes'], ENT_QUOTES, 'UTF-8') ?></div>

  <div class="info-label">EDITAR CONTA</div>
  <div class="small-text">
    Clique <a href="cadastro1.php">aqui</a> para ser redirecionado para tela de cadastro
  </div>

  <div class="info-label">SUPORTE</div>
  <div class="small-text">
    Clique <a href="suporte_alerta.php">aqui</a> para ser redirecionado para tela de suporte
  </div>

  <div class="action-buttons">
    <button class="btn btn-alterar" onclick="alert('Função ALTERAR CONTA ainda será implementada')">ALTERAR CONTA</button>
    <button class="