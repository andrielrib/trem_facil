<?php


include "db.php";

session_start();

$msg = "";
$errors = [];

if (isset($_GET['logout'])) {
  session_unset();
  session_destroy();
  $msg = "Você saiu com sucesso.";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $login = $_POST["login"] ?? "";
  $senha = $_POST["senha"] ?? "";


  $stmt = $conn->prepare("SELECT id_usuario, nome_completo, senha, tipo_usuarios FROM usuarios WHERE email=? OR telefone=?");
  $stmt->bind_param("ss", $login, $login);
  $stmt->execute();
  $result = $stmt->get_result();
  $usuario = $result->fetch_assoc();
  $stmt->close();


  if ($usuario && password_verify($senha, $usuario['senha'])) {
    $_SESSION["user_id"] = $usuario["id_usuario"];
    $_SESSION["username"] = $usuario["nome_completo"];
    $_SESSION["tipo_usuario"] = $usuario["tipo_usuarios"];
    header("Location:pagina_inicial.php");

    
    exit;
  } else {
    $errors[] ="Email/Telefone ou senha incorretos!";
  }
}
?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrada</title>
    <link rel="stylesheet" href="../style/style.css">
</head>

<body>

  <div class="login_icon">
    <img src="../assets/icons/trem_bala_icon.png" alt="icone trem" width="200" height="150">
  </div>

  <?php if (!empty($_SESSION["user_id"])): ?>
    <div class="card">
      <?php header("Location:pagina_inicial.php"); ?>
      <h3>Bem-vindo, <?= $_SESSION["username"] ?>!</h3>
      <p>Tipo de usuário: <?= $_SESSION["tipo_usuario"] == '1' ? 'Cliente' : 'Administrador' ?></p>
      <p><a href="?logout=1">Sair</a></p>
    </div>
  <?php else: ?>
    <div>
      <h3 class="text_volta">Bem vindo de volta!</h3>
      <br><br>
      <div class="final_página">
        <form method="post">
          <?php if (!empty($errors)): ?>
            <div class="error">
              <?php foreach ($errors as $error): ?>
                <p style="color:red;"><?= $error ?></p>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
          <?php if ($msg): ?><p class="msg"><?= $msg ?></p><?php endif; ?>
          <strong>
            <h2 class="margin">Email ou telefone:</h2>
          </strong>
          <input type="text" class="caixa_login" name="login" required>
          <div><br></div>
          <strong>
            <h2 class="margin">Senha:</h2>
          </strong>
          <input type="password" class="caixa_login" name="senha" required>
          <div><br><br></div>
          <div class="final_página">
            <input type="submit" value="ENTRAR" class="caixa_verde_login">
            <div>
              <div><br><br></div>
              <strong>
                <h2 class="margin">Esqueceu sua senha?</h2>
              </strong>
              <div class="flex_login">
                <a href="redefinir_senha.php" class="button_link">Clique aqui! </a>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  <?php endif; ?>

</body>

</html>