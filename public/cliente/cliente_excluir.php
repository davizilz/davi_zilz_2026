<?php
include __DIR__ . '/../../verifica.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    header("Location: clientes.php");
    exit;
}

$stmt = $conexao->prepare("SELECT COUNT(*) AS total FROM agendamentos WHERE cliente_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$total = (int) $stmt->get_result()->fetch_assoc()['total'];

if ($total > 0) {
    header("Location: clientes.php?erro=1");
    exit;
}

$stmt = $conexao->prepare("DELETE FROM clientes WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: clientes.php?excluido=1");
exit;
