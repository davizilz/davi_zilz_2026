<?php
include "verifica.php";

$id = 0;
$nome = "";
$telefone = "";
$email = "";

// Se veio id na URL, é edição: busca os dados
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $stmt = $conexao->prepare("SELECT * FROM clientes WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $cliente = $stmt->get_result()->fetch_assoc();
    if ($cliente) {
        $nome = $cliente['nome'];
        $telefone = $cliente['telefone'];
        $email = $cliente['email'];
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id = (int) $_POST['id'];
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];

    if ($id > 0) {
        $stmt = $conexao->prepare("UPDATE clientes SET nome=?, telefone=?, email=? WHERE id=?");
        $stmt->bind_param("sssi", $nome, $telefone, $email, $id);
    } else {
        $stmt = $conexao->prepare("INSERT INTO clientes (nome, telefone, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $telefone, $email);
    }
    $stmt->execute();
    header("Location: clientes.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head><meta charset="UTF-8"><title>Cliente</title></head>
<body>
    <h1><?php echo $id > 0 ? "Editar" : "Cadastrar"; ?> cliente</h1>
    <form method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        Nome: <input type="text" name="nome" value="<?php echo htmlspecialchars($nome); ?>" required><br><br>
        Telefone: <input type="text" name="telefone" value="<?php echo htmlspecialchars($telefone); ?>" required><br><br>
        E-mail: <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br><br>
        <button type="submit">Salvar</button>
        <a href="clientes.php">Cancelar</a>
    </form>
</body>
</html>
