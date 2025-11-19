<?php
// delete.php
require_once 'connection.php';

$id = $_GET['id'] ?? null;

if ($id && is_numeric($id)) {
    try {
        $sql = "DELETE FROM paciente WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        header("Location: index.php?status=deleted");
        exit();
    } catch (PDOException $e) {
        // Redireciona com erro (pode ser melhorado para mostrar o erro)
        header("Location: index.php?status=error_deleting");
        exit();
    }
}

header("Location: index.php");
exit();
