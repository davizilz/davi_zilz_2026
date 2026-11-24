<?php
include "verifica.php";
$id = (int) $_GET['id'];

// Confere se o cliente tem agendamentos
$stmt = $conexao->prepare("SELECT COUNT(*) AS total FROM agendamentos WHERE cliente_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$total = $stmt->get_result()->fetch_assoc()['total'];

if ($total > 0) {
    header("Location: clientes.php?erro=1");
    exit;
}

$stmt = $conexao->prepare("DELETE FROM clientes WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
header("Location: clientes.php");
exit;
