<?php
include __DIR__ . '/../../verifica.php';

$id = 0;
$cliente_id = 0;
$mecanico_id = 0;
$placa = "";
$data_hora = "";   // formato do campo: 2026-11-30T14:00
$aviso = "";

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $stmt = $conexao->prepare("SELECT * FROM agendamentos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $agendamento = $stmt->get_result()->fetch_assoc();
    if ($agendamento) {
        $cliente_id = $agendamento['cliente_id'];
        $mecanico_id = $agendamento['mecanico_id'];
        $placa = $agendamento['placa'];
        $data_hora = date("Y-m-d\TH:i", strtotime($agendamento['data_hora']));
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id = (int) $_POST['id'];
    $cliente_id = (int) $_POST['cliente_id'];
    $mecanico_id = (int) $_POST['mecanico_id'];
    $placa = $_POST['placa'];
    $data_hora = $_POST['data_hora'];

    // troca o "T" por espaço para o MySQL entender
    $data_para_banco = str_replace("T", " ", $data_hora) . ":00";

    // Mesmo mecânico, mesma data e hora?
    $stmt = $conexao->prepare("SELECT COUNT(*) AS total FROM agendamentos WHERE mecanico_id = ? AND data_hora = ? AND id <> ?");
    $stmt->bind_param("isi", $mecanico_id, $data_para_banco, $id);
    $stmt->execute();
    $total = $stmt->get_result()->fetch_assoc()['total'];

    if ($total > 0) {
        $aviso = "Esse mecânico já tem um agendamento nessa data e horário.";
    } else {
        if ($id > 0) {
            $stmt = $conexao->prepare("UPDATE agendamentos SET cliente_id=?, mecanico_id=?, placa=?, data_hora=? WHERE id=?");
            $stmt->bind_param("iissi", $cliente_id, $mecanico_id, $placa, $data_para_banco, $id);
        } else {
            $stmt = $conexao->prepare("INSERT INTO agendamentos (cliente_id, mecanico_id, placa, data_hora) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiss", $cliente_id, $mecanico_id, $placa, $data_para_banco);
        }
        $stmt->execute();
        header("Location: agendamentos.php");
        exit;
    }
}

// Listas para os selects
$clientes = $conexao->query("SELECT id, nome FROM clientes ORDER BY nome");
$mecanicos = $conexao->query("SELECT id, nome, especialidade FROM mecanicos ORDER BY nome");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head><meta charset="UTF-8"><title>Agendamento</title></head>
<body>
    <h1><?php echo $id > 0 ? "Editar" : "Cadastrar"; ?> agendamento</h1>
    <?php if ($aviso != "") { ?>
        <p style="color:red;"><?php echo $aviso; ?></p>
    <?php } ?>
    <form method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        Cliente:
        <select name="cliente_id" required>
            <option value="">Escolha...</option>
            <?php while ($c = $clientes->fetch_assoc()) { ?>
                <option value="<?php echo $c['id']; ?>" <?php if ($c['id'] == $cliente_id) echo "selected"; ?>>
                    <?php echo htmlspecialchars($c['nome']); ?>
                </option>
            <?php } ?>
        </select><br><br>

        Mecânico:
        <select name="mecanico_id" required>
            <option value="">Escolha...</option>
            <?php while ($m = $mecanicos->fetch_assoc()) { ?>
                <option value="<?php echo $m['id']; ?>" <?php if ($m['id'] == $mecanico_id) echo "selected"; ?>>
                    <?php echo htmlspecialchars($m['nome'] . " - " . $m['especialidade']); ?>
                </option>
            <?php } ?>
        </select><br><br>

        Placa do veículo: <input type="text" name="placa" maxlength="8" value="<?php echo htmlspecialchars($placa); ?>" required><br><br>
        Data e hora: <input type="datetime-local" name="data_hora" value="<?php echo $data_hora; ?>" required><br><br>

        <button type="submit">Salvar</button>
        <a href="agendamentos.php">Cancelar</a>
    </form>
</body>
</html>
