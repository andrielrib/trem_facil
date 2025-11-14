<?php
include __DIR__ . '/../../public/db.php';
session_start();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: ../lista_usuarios.php");
    exit();
}
$id = (int)$_GET['id'];


$stmt = $conn->prepare("SELECT tipo_usuario FROM usuario WHERE id_usuario = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($tipo_usuario);
$stmt->fetch();
$stmt->close();

if ($tipo_usuario == 1) {
    header("Location: ../lista_usuarios.php?msg=Não é permitido deletar administrador.");
    exit();
}
// Executa exclusão

$stmt = $conn->prepare("DELETE FROM usuario WHERE id_usuario = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

header("Location: ../lista_usuarios.php?msg=Usuário deletado com sucesso.");
exit();