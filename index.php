<?php
// index.php
require_once 'connection.php';

// READ: Consulta todos os pacientes
try {
    $stmt = $pdo->query("SELECT * FROM paciente ORDER BY nome ASC");
    $pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao carregar pacientes: " . $e->getMessage());
}

$message = '';
if (isset($_GET['status'])) {
    switch ($_GET['status']) {
        case 'inserted':
            $message = '✅ Paciente cadastrado com sucesso!';
            break;
        case 'updated':
            $message = '🔄 Paciente atualizado com sucesso!';
            break;
        case 'deleted':
            $message = '🗑️ Paciente excluído com sucesso.';
            break;
        case 'not_found':
            $message = '⚠️ Paciente não encontrado.';
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoramento de Pacientes</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <h1>🏥 Sistema de Monitoramento de Pacientes</h1>

        <?php if ($message): ?>
            <p style="padding: 10px; background-color: #e9ecef; border-left: 5px solid #007bff;"><?= $message ?></p>
        <?php endif; ?>

        <a href="insert.php" class="create-btn">➕ Cadastrar Novo Paciente</a>

        <h2>📋 Pacientes Registrados</h2>
        
        <?php if (count($pacientes) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Idade</th>
                        <th>IMC</th>
                        <th>Pressão Sistólica (mmHg)</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pacientes as $p): ?>
                        <tr>
                            <td><?= htmlspecialchars($p['id']) ?></td>
                            <td><?= htmlspecialchars($p['nome']) ?></td>
                            <td><?= htmlspecialchars($p['idade']) ?></td>
                            <td><?= htmlspecialchars($p['imc']) ?></td>
                            <td><?= htmlspecialchars($p['pressao_sistolica']) ?></td>
                            <td>
                                <a href="update.php?id=<?= $p['id'] ?>" class="action-btn edit-btn">Editar</a>
                                <a href="delete.php?id=<?= $p['id'] ?>" class="action-btn delete-btn" onclick="return confirm('Tem certeza que deseja excluir este paciente?');">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nenhum paciente cadastrado ainda.</p>
        <?php endif; ?>
    </div>
</body>
</html>
