<?php
include "verifica.php";

// Do agendamento mais próximo para o mais distante
$sql = "SELECT a.id, a.placa,
               DATE_FORMAT(a.data_hora, '%d/%m/%Y %H:%i') AS data_formatada,
               c.nome AS cliente, m.nome AS mecanico, m.especialidade
        FROM agendamentos a
        INNER JOIN clientes c ON c.id = a.cliente_id
        INNER JOIN mecanicos m ON m.id = a.mecanico_id
        ORDER BY a.data_hora ASC";
$resultado = $conexao->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head><meta charset="UTF-8"><title>Agendamentos</title></head>
<body>
    <h1>Agendamentos</h1>
    <a href="principal.php">Voltar</a> |
    <a href="agendamento_form.php">Cadastrar agendamento</a>

    <table border="1" cellpadding="5">
        <tr>
            <th>Cliente</th><th>Placa</th><th>Mecânico</th>
            <th>Especialidade</th><th>Data/Hora</th><th>Ações</th>
        </tr>
        <?php while ($a = $resultado->fetch_assoc()) { ?>
        <tr>
            <td><?php echo htmlspecialchars($a['cliente']); ?></td>
            <td><?php echo htmlspecialchars($a['placa']); ?></td>
            <td><?php echo htmlspecialchars($a['mecanico']); ?></td>
            <td><?php echo htmlspecialchars($a['especialidade']); ?></td>
            <td><?php echo $a['data_formatada']; ?></td>
            <td>
                <a href="agendamento_form.php?id=<?php echo $a['id']; ?>">Editar</a>
                <a href="agendamento_excluir.php?id=<?php echo $a['id']; ?>" onclick="return confirm('Excluir?')">Excluir</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
