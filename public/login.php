<?php


include "db.php";

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
      <div class="text_volta">
        <h1>Login</h1>
      </div>

      <br><br><br><br>

      <div class="final_página">
        <?php if ($msg): ?><p class="msg"><?= $msg ?></p><?php endif; ?>
        <form method="post">
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
              <div><br><br><br></div>
              <strong>
                <h2 class="margin">Esqueceu sua senha?</h2>
              </strong>
              <div class="flex_login">
                <a href="redefinir_senha.php"><input type="button" class="caixa_verde_login" value="Clique aqui" onclick="trocar_senha()"></a>
              </div>
            </div>
          </div>

        </form>
      </div>
    <?php endif; ?>
    </div>

</body>

</html>