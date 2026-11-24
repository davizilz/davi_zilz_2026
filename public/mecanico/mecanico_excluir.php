<?php
include "verifica.php";
$id = (int) $_GET['id'];

$stmt = $conexao->prepare("SELECT COUNT(*) AS total FROM agendamentos WHERE mecanico_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$total = $stmt->get_result()->fetch_assoc()['total'];

if ($total > 0) {
    header("Location: mecanicos.php?erro=1");
    exit;
}

$stmt = $conexao->prepare("DELETE FROM mecanicos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
header("Location: mecanicos.php");
exit;
