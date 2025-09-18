<?php


$mysqli = new mysqli("localhost", "root", "", "trem_facil");
if ($mysqli->connect_errno) {
    die("Erro de conexão: " . $mysqli->connect_error);
}


session_start();




if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}


$msg = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $login = $_POST["login"] ?? "";  
    $senha = $_POST["senha"] ?? "";


    $stmt = $mysqli->prepare("SELECT id_usuario, nome_completo, senha, tipo_usuarios FROM usuarios WHERE email=? OR telefone=?");
    $stmt->bind_param("ss", $login, $login);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuario = $result->fetch_assoc();
    $stmt->close();


    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION["user_id"] = $usuario["id_usuario"];
        $_SESSION["username"] = $usuario["nome_completo"];
        $_SESSION["tipo_usuario"] = $usuario["tipo_usuarios"];
        header("Location: login.php");
        exit;
    } else {
        $msg = "Email/Telefone ou senha incorretos!";
    }
}
?>


<!doctype html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<title>Login Trem Fácil</title>
<link rel="stylesheet" href="../style/style.css">
</head>
<body>

<div class="login_icon">
    <img src="../assets/icons/trem_bala_icon.png" alt="icone trem" width="600" height="550">
</div>

<form id="loginForm">
  <?php if (!empty($_SESSION["user_id"])): ?>
    <div class="card">
      <h3>Bem-vindo, <?= $_SESSION["username"] ?>!</h3>
      <p>Tipo de usuário: <?= $_SESSION["tipo_usuario"] == '1' ? 'Cliente' : 'Administrador' ?></p>
      <p><a href="?logout=1">Sair</a></p>
    </div>


  <?php else: ?>
    <div class="card">
      <h3>Login</h3>
      <?php if ($msg): ?><p class="msg"><?= $msg ?></p><?php endif; ?>
      <form method="post">
        <strong>
            <p class="margin">Email ou telefone:</p>
        </strong>
        <input type="text" class="caixa_login" name="login" required>
        <strong>
            <p class="margin">Senha:</p>
        </strong>
        <input type="password" class="caixa_login" name="senha" required>

        <div class="final_página">
        <input type="submit" value="ENTRAR" class="caixa_verde_login">
        <div>
            <strong>
                <p class="margin">Esqueceu sua senha?</p>
            </strong>
            <div class="flex_login">
                <p class="centralizar2">Clique</p>
                <a href="redefinir_senha.php"><input type="button" value="Aqui" onclick="trocar_senha()"></a>
            </div>
        </div>
    </div>
        
      </form>
    </div>
  <?php endif; ?>
</div>

</body>
</html>

<a href=""></a>