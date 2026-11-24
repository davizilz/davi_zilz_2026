<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
if (time() - $_SESSION['ultimo_acesso'] > 300) {
    session_destroy();
    header("Location: login.php?expirou=1");
    exit;
}
$_SESSION['ultimo_acesso'] = time();

include "conexao.php";
