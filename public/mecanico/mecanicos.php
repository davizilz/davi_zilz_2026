<?php
include "verifica.php";
$resultado = $conexao->query("SELECT * FROM mecanicos ORDER BY nome");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head><meta charset="UTF-8"><title>Mecânicos</title></head>
<body>
    <h1>Mecânicos</h1>
    <a href="principal.php">Voltar</a> |
    <a href="mecanico_form.php">Cadastrar mecânico</a>

    <?php if (isset($_GET['erro'])) { ?>
        <p style="color:red;">Não é possível excluir: este mecânico possui agendamentos.</p>
    <?php } ?>

    <table border="1" cellpadding="5">
        <tr><th>Nome</th><th>Matrícula</th><th>Especialidade</th><th>Ações</th></tr>
        <?php while ($m = $resultado->fetch_assoc()) { ?>
        <tr>
            <td><?php echo htmlspecialchars($m['nome']); ?></td>
            <td><?php echo htmlspecialchars($m['matricula']); ?></td>
            <td><?php echo htmlspecialchars($m['especialidade']); ?></td>
            <td>
                <a href="mecanico_form.php?id=<?php echo $m['id']; ?>">Editar</a>
                <a href="mecanico_excluir.php?id=<?php echo $m['id']; ?>" onclick="return confirm('Excluir?')">Excluir</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
