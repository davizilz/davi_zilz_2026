<?php
include __DIR__ . '/../../verifica.php';
$id = (int) $_GET['id'];

$stmt = $conexao->prepare("DELETE FROM agendamentos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
header("Location: agendamentos.php");
exit;
