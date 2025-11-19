<?php
// update.php
require_once 'connection.php';

$id = $_GET['id'] ?? null;
$paciente = null;

if (!$id || !is_numeric($id)) {
    header("Location: index.php");
    exit();
}

// 1. Carregar dados atuais do paciente
try {
    $stmt = $pdo->prepare("SELECT * FROM paciente WHERE id = ?");
    $stmt->execute([$id]);
    $paciente = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$paciente) {
        header("Location: index.php?status=not_found");
        exit();
    }
} catch (PDOException $e) {
    die("Erro ao carregar paciente: " . $e->getMessage());
}

// 2. Processar submissão do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $idade = (int)$_POST['idade'];
    $imc = (float)$_POST['imc'];
    $pressao_sistolica = (int)$_POST['pressao_sistolica'];

    try {
        $sql = "UPDATE paciente SET nome = ?, idade = ?, imc = ?, pressao_sistolica = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $idade, $imc, $pressao_sistolica, $id]);
        header("Location: index.php?status=updated");
        exit();
    } catch (PDOException $e) {
        $error = "Erro ao atualizar paciente: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Paciente</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <h2>✍️ Editar Paciente: <?= htmlspecialchars($paciente['nome']) ?></h2>
        
        <?php if (isset($error)): ?>
            <p style="color: red;"><?= $error ?></p>
        <?php endif; ?>

        <form action="update.php?id=<?= $id ?>" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($paciente['nome']) ?>" required>

            <label for="idade">Idade:</label>
            <input type="number" id="idade" name="idade" value="<?= htmlspecialchars($paciente['idade']) ?>" required min="0">

            <label for="imc">IMC:</label>
            <input type="number" id="imc" name="imc" step="0.01" value="<?= htmlspecialchars($paciente['imc']) ?>" required min="0">

            <label for="pressao_sistolica">Pressão Sistólica (mmHg):</label>
            <input type="number" id="pressao_sistolica" name="pressao_sistolica" value="<?= htmlspecialchars($paciente['pressao_sistolica']) ?>" required min="0">

            <button type="submit">Salvar Alterações</button>
        </form>
        <p><a href="index.php">Voltar para a Lista</a></p>
    </div>
</body>
</html>
