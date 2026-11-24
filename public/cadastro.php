<?php
include __DIR__ . '/../conexao.php';

$erro = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nome = trim($_POST['nome']);
    $usuario = trim($_POST['usuario']);
    $senha = $_POST['senha'];

    $stmt = $conexao->prepare("SELECT id FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();

    if ($stmt->get_result()->fetch_assoc()) {
        $erro = "Este usuário já existe";
    } else {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        $stmt = $conexao->prepare("INSERT INTO usuarios (nome, usuario, senha) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $usuario, $senha_hash);

        if ($stmt->execute()) {
            header("Location: login.php?cadastro=1");
            exit;
        } else {
            $erro = "Erro ao cadastrar usuário";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
</head>
<body>
    <h1>Cadastro</h1>

    <?php if ($erro != "") { ?>
        <p><?php echo htmlspecialchars($erro); ?></p>
    <?php } ?>

    <form method="post">
        Nome:<br>
        <input type="text" name="nome" required><br><br>

        Usuário:<br>
        <input type="text" name="usuario" required><br><br>

        Senha:<br>
        <input type="password" name="senha" required><br><br>

        <button type="submit">Cadastrar</button>
    </form>

    <p><a href="login.php">Voltar para o login</a></p>
</body>
</html>
