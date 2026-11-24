<?php
include __DIR__ . '/../../verifica.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    header("Location: mecanicos.php");
    exit;
}
$stmt = $conexao->prepare("SELECT COUNT(*) AS total FROM agendamentos WHERE mecanico_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$total = (int) $stmt->get_result()->fetch_assoc()['total'];

if ($total > 0) {
    header("Location: mecanicos.php?erro=1");
    exit;
}
$stmt = $conexao->prepare("DELETE FROM mecanicos WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute() && $conexao->affected_rows > 0) {
    header("Location: mecanicos.php?excluido=1");
} else {
    header("Location: mecanicos.php?erro=excluir");
}
exit;
