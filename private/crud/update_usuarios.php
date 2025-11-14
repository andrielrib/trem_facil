<?php
include __DIR__ . '/../../public/db.php'; 
session_start();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: ../lista_usuarios.php");
    exit();
}

$id = (int)$_GET['id'];
$errors = [];
$data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data['nome_completo'] = trim($_POST['nome_completo'] ?? '');
    $data['cpf'] = trim($_POST['cpf'] ?? '');
    $data['cep'] = trim($_POST['cep'] ?? '');
    $data['email'] = trim($_POST['email'] ?? '');
    $data['telefone'] = trim($_POST['telefone'] ?? '');

    if (!$data['nome_completo']) $errors[] = "Nome completo é obrigatório.";
    if (!$data['cpf'] || !preg_match('/^\d{11}$/', $data['cpf'])) $errors[] = "CPF inválido.";
    if (!$data['cep'] || !preg_match('/^\d{8}$/', $data['cep'])) $errors[] = "CEP inválido.";
    if (!$data['email'] || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors[] = "Email inválido.";
    if (!$data['telefone'] || !preg_match('/^\d{10,11}$/', $data['telefone'])) $errors[] = "Telefone inválido.";

    if (!$errors) {
        $stmt = $conn->prepare("SELECT id_usuario FROM usuario WHERE (cpf = ? OR email = ? OR telefone = ?) AND id_usuario != ?");
        $stmt->bind_param("sssi", $data['cpf'], $data['email'], $data['telefone'], $id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) $errors[] = "CPF, email ou telefone já cadastrados para outro usuário.";
        $stmt->close();
    }

    if (!$errors) {
        $stmt = $conn->prepare("UPDATE usuario SET nome_completo=?, cpf=?, cep=?, email=?, telefone=? WHERE id_usuario=?");
        $stmt->bind_param("sssssi", $data['nome_completo'], $data['cpf'], $data['cep'], $data['email'], $data['telefone'], $id);
        if ($stmt->execute()) {
            header("Location: ../lista_usuarios.php?msg=Usuário atualizado com sucesso");
            exit();
        } else {
            $errors[] = "Erro ao atualizar usuário: " . $stmt->error;
        }
        $stmt->close();
    }
} else {
    $stmt = $conn->prepare("SELECT nome_completo, cpf, cep, email, telefone FROM usuario WHERE id_usuario = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($nome_completo, $cpf, $cep, $email, $telefone);
    if ($stmt->fetch()) {
        $data = compact('nome_completo', 'cpf', 'cep', 'email', 'telefone');
    } else {
        header("Location: ../lista_usuarios.php");
        exit();
    }
    $stmt->close();
}
?>

