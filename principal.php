<?php include "verifica.php"; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head><meta charset="UTF-8"><title>Tela principal</title></head>
<body>
    <h1>Oficina Mecânica</h1>
    <p>Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>!</p>
    <ul>
        <li><a href="clientes.php">Clientes</a></li>
        <li><a href="mecanicos.php">Mecânicos</a></li>
        <li><a href="agendamentos.php">Agendamentos</a></li>
    </ul>
    <a href="sair.php"><button>Sair</button></a>
</body>
</html>
