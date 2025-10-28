<?php
 session_start();

 if (!isset($_SESSION['cadastro1'])) {
    header("Location: cadastro1.php");
    exit();
  }

 $telefone = $senha = $confirmar_senha = "";
 $errors = [];

 if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $telefone = trim($_POST['telefone']);
    $senha = trim($_POST['senha']);
    $confirmar_senha = trim($_POST['confirmar_senha']);

    if (empty($telefone)) {
        $errors[] = "Telefone é obrigatório.";
    } elseif (!preg_match('/^[0-9]{11}$/', $telefone)) {
        $errors[] = "Telefone deve conter 11 dígitos (DDD + número).";
    }

    if (empty($senha) || empty($confirmar_senha)) {
        $errors[] = "Senha e confirmação são obrigatórias.";
    } elseif ($senha !== $confirmar_senha) {
        $errors[] = "As senhas não coincidem.";
    } elseif (strlen($senha) < 6) {
        $errors[] = "A senha deve ter pelo menos 6 caracteres.";
    }

    if (empty($errors)) {
        $dados1 = $_SESSION['cadastro1'];

        $servername = "localhost";
        $username = "root"; 
        $password = "root";    
        $dbname = "trem_facil";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Erro de conexão: " . $conn->connect_error);
        }

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (nome_completo, email, telefone, CEP, CPF, senha, tipo_usuarios) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        $tipo_usuarios = 1;
        $stmt->bind_param(
            "ssssssi",
            $dados1['nome_completo'],
            $dados1['email'],
            $telefone,
            $dados1['cep'],
            $dados1['cpf'],
            $senhaHash,
            $tipo_usuarios
        );

        if ($stmt->execute()) {
            unset($_SESSION['cadastro1']);
            header("Location: pagina_inicial.php");
            exit();
        } else {
            $errors[] = "Erro ao cadastrar: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
  }
?>

<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cadastro parte 2</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    
<div class="cadastro2_icon">
    <img src="../assets/icons/trem_bala_icon.png" alt="icone trem" width="260" height="210">
</div>
<br>
<br>
<br>
<div>
    <form id="formulario_cadas_2" method="post" action="cadastro2.php">

        <strong><p class="margin_cadastro2">Telefone:</p></strong>
        <input type="text" class="caixa_login" id="telefone" name="telefone">

        <strong><p class="margin_cadastro2">Senha:</p></strong>
        <input type="password" class="caixa_login" id="senha" name="senha">

        <strong><p class="margin_cadastro2">Confirmar senha:</p></strong>
        <input type="password" class="caixa_login" id="confirmar_senha" name="confirmar_senha">

        <br><br>
        <div class="final_cadastro2">
            <button type="submit" class="caixa_verde_cadastro2"><p class="centralizar_cadastro2">REGISTRAR</p></button>
        </div>
    </form>
</div>

<div class="flex_circulo">
    <div class="circulo_esquerda_cadastro2"></div>
    <div class="circulo_direita_cadastro2"></div>
</div>

</body>
</html>