<?php
include __DIR__ . '/../../verifica.php';
$resultado = $conexao->query("SELECT * FROM clientes ORDER BY nome");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head><meta charset="UTF-8"><title>Clientes</title></head>
<body>
    <h1>Clientes</h1>
    <a href="../../principal.php">Voltar</a> |
    <a href="cliente_form.php">Cadastrar cliente</a>

    <?php if (isset($_GET['erro'])) { ?>
        <p style="color:red;">Não é possível excluir: este cliente possui agendamentos.</p>
    <?php } ?>

    <?php if (isset($_GET['excluido'])) { ?>
        <p style="color:green;">Cliente excluído com sucesso.</p>
    <?php } ?>

    <table border="1" cellpadding="5">
        <tr><th>Nome</th><th>Telefone</th><th>E-mail</th><th>Ações</th></tr>
        <?php while ($c = $resultado->fetch_assoc()) { ?>
        <tr>
            <td><?php echo htmlspecialchars($c['nome']); ?></td>
            <td><?php echo htmlspecialchars($c['telefone']); ?></td>
            <td><?php echo htmlspecialchars($c['email']); ?></td>
            <td>
                <a href="cliente_form.php?id=<?php echo $c['id']; ?>">Editar</a>
                <a href="cliente_excluir.php?id=<?php echo $c['id']; ?>" onclick="return confirm('Excluir?')">Excluir</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
