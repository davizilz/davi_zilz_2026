<?php
session_start();
include "conexao.php";

$erro = "";

if (isset($_GET['expirou'])) {
    $erro = "Sessão expirada, faça login novamente";
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    $stmt = $conexao->prepare("SELECT id, nome, senha FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $linha = $stmt->get_result()->fetch_assoc();

    if ($linha && password_verify($senha, $linha['senha'])) {
        $_SESSION['usuario_id'] = $linha['id'];
        $_SESSION['usuario_nome'] = $linha['nome'];
        $_SESSION['ultimo_acesso'] = time();
        header("Location: principal.php");
        exit;
    } else {
        $erro = "Usuário ou senha inválidos";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head><meta charset="UTF-8"><title>Login</title></head>
<body>
    <h1>Login</h1>
    <?php if ($erro != "") { ?>
        <p style="color:red;"><?php echo $erro; ?></p>
    <?php } ?>
    <form method="post">
        Usuário: <input type="text" name="usuario" required><br><br>
        Senha: <input type="password" name="senha" required><br><br>
        <button type="submit">Entrar</button>
    </form>
</body>
</html>
