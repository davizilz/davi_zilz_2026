<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: /davi_zilz_2026/public/login.php");
    exit;
}
if (time() - $_SESSION['ultimo_acesso'] > 300) {
    session_destroy();
    header("Location: /davi_zilz_2026/public/login.php?expirou=1");
    exit;
}
$_SESSION['ultimo_acesso'] = time();

include __DIR__ . '/conexao.php';
