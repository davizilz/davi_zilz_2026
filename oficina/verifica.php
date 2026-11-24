<?php
session_start();

$diretorio_app = str_replace('\\', '/', __DIR__);
$document_root = str_replace('\\', '/', rtrim($_SERVER['DOCUMENT_ROOT'] ?? '', '/\\'));
$base_uri = str_replace($document_root, '', $diretorio_app);

if (!isset($_SESSION['usuario_id'])) {
    header("Location: " . $base_uri . "/public/login.php");
    exit;
}
if (!isset($_SESSION['ultimo_acesso']) || time() - $_SESSION['ultimo_acesso'] > 300) {
    session_destroy();
    header("Location: " . $base_uri . "/public/login.php?expirou=1");
    exit;
}
$_SESSION['ultimo_acesso'] = time();

include __DIR__ . '/conexao.php';
