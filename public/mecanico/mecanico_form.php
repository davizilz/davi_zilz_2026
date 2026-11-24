<?php
include __DIR__ . '/../../verifica.php';

$id = 0;
$nome = "";
$matricula = "";
$especialidade = "";
$aviso = "";

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $stmt = $conexao->prepare("SELECT * FROM mecanicos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $mecanico = $stmt->get_result()->fetch_assoc();
    if ($mecanico) {
        $nome = $mecanico['nome'];
        $matricula = $mecanico['matricula'];
        $especialidade = $mecanico['especialidade'];
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id = (int) $_POST['id'];
    $nome = $_POST['nome'];
    $matricula = $_POST['matricula'];
    $especialidade = $_POST['especialidade'];

  
    $stmt = $conexao->prepare("SELECT COUNT(*) AS total FROM mecanicos WHERE matricula = ? AND id <> ?");
    $stmt->bind_param("si", $matricula, $id);
    $stmt->execute();
    $total = $stmt->get_result()->fetch_assoc()['total'];

    if ($total > 0) {
        $aviso = "Já existe um mecânico com essa matrícula.";
    } else {
        if ($id > 0) {
            $stmt = $conexao->prepare("UPDATE mecanicos SET nome=?, matricula=?, especialidade=? WHERE id=?");
            $stmt->bind_param("sssi", $nome, $matricula, $especialidade, $id);
        } else {
            $stmt = $conexao->prepare("INSERT INTO mecanicos (nome, matricula, especialidade) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nome, $matricula, $especialidade);
        }
        $stmt->execute();
        header("Location: mecanicos.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head><meta charset="UTF-8"><title>Mecânico</title></head>
<body>
    <h1><?php echo $id > 0 ? "Editar" : "Cadastrar"; ?> mecânico</h1>
    <?php if ($aviso != "") { ?>
        <p style="color:red;"><?php echo $aviso; ?></p>
    <?php } ?>
    <form method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        Nome: <input type="text" name="nome" value="<?php echo htmlspecialchars($nome); ?>" required><br><br>
        Matrícula: <input type="text" name="matricula" value="<?php echo htmlspecialchars($matricula); ?>" required><br><br>
        Especialidade: <input type="text" name="especialidade" value="<?php echo htmlspecialchars($especialidade); ?>" required><br><br>
        <button type="submit">Salvar</button>
        <a href="mecanicos.php">Cancelar</a>
    </form>
</body>
</html>
