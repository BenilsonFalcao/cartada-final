<?php
// insert.php
require_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $idade = (int)$_POST['idade'];
    $imc = (float)$_POST['imc'];
    $pressao_sistolica = (int)$_POST['pressao_sistolica'];

    try {
        $sql = "INSERT INTO paciente (nome, idade, imc, pressao_sistolica) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $idade, $imc, $pressao_sistolica]);
        header("Location: index.php?status=inserted");
        exit();
    } catch (PDOException $e) {
        $error = "Erro ao inserir paciente: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Paciente</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <h2>➕ Adicionar Novo Paciente</h2>
        
        <?php if (isset($error)): ?>
            <p style="color: red;"><?= $error ?></p>
        <?php endif; ?>

        <form action="insert.php" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="idade">Idade:</label>
            <input type="number" id="idade" name="idade" required min="0">

            <label for="imc">IMC:</label>
            <input type="number" id="imc" name="imc" step="0.01" required min="0">

            <label for="pressao_sistolica">Pressão Sistólica (mmHg):</label>
            <input type="number" id="pressao_sistolica" name="pressao_sistolica" required min="0">

            <button type="submit">Cadastrar Paciente</button>
        </form>
        <p><a href="index.php">Voltar para a Lista</a></p>
    </div>
</body>
</html>
