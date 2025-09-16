<html lang="en">

<?php

$mysqli = new mysqli("localhost", "root", "root", "trem_facil");
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
    $user = $_POST["username"] ?? "";
    $pass = $_POST["password"] ?? "";

    $stmt = $mysqli->prepare("SELECT id_usuario, nome_completo, senha, tipo_usuarios FROM usuarios WHERE email=? OR telefone=?");
    $stmt->bind_param("ss", $user, $user);
    $stmt->execute();
    $result = $stmt->get_result();
    $dados = $result->fetch_assoc();
    $stmt->close();

    if ($dados && password_verify($pass, $dados['senha'])) {
        $_SESSION["user_id"] = $dados["id_usuario"];
        $_SESSION["username"] = $dados["nome_completo"];
        $_SESSION["tipo_usuario"] = $dados["tipo_usuarios"];
        header("Location: login.php");
        exit;
    } else {
        $msg = "Usuário ou senha incorretos!";
    }
}
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../style/style.css">
<meta charset="utf-8">
<title>Login Trem Fácil</title>
<link rel="stylesheet" href="../style/style.css">
</head>

<div class="login_icon">
    <img src="../assets/icons/trem_bala_icon.png" alt="icone trem" width="260" height="210">
</div>

<div class="text_volta">
    <strong>
        <h1>Bem vindo de</h1>
    </strong>
    <strong>
        <h1 class="margin">volta!</h1>
    </strong>
</div>

<form id="loginForm">
    <div>
        <strong>
            <p class="margin">Email ou telefone:</p>
        </strong>
        <input type="text" class="caixa_login" id="username" required>
    </div>

    <div>
        <strong>
            <p class="margin">Senha:</p>
        </strong>
        <input type="password" class="caixa_login" id="password" required>
    </div>

    <br>
    <br>
    <div class="final_página">
        <input type="submit" value="ENTRAR" class="caixa_verde_login">
        <div>
            <strong>
                <p class="margin">Esqueceu sua senha?</p>
            </strong>
            <div class="flex_login">
                <p class="centralizar2">Clique</p>
                <a href="esqueci_senha.php"><input type="button" value="Aqui" onclick="trocar_senha()"></a>
            </div>
        </div>
    </div>
</form>
<script src="../script/login.js"></script>
</body>

</html>

