<?php
include __DIR__ . '/../../verifica.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    header("Location: agendamentos.php");
    exit;
}

$stmt = $conexao->prepare("DELETE FROM agendamentos WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute() && $conexao->affected_rows > 0) {
    header("Location: agendamentos.php?excluido=1");
} else {
    header("Location: agendamentos.php?erro=excluir");
}
exit;
