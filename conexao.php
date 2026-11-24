<?php
$conexao = new mysqli("127.0.0.1", "root", "", "oficina", 3306);

if ($conexao->connect_error) {
    die("Erro ao conectar no banco: " . $conexao->connect_error);
}

$conexao->set_charset("utf8mb4");