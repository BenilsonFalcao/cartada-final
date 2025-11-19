<?php
// connection.php
require_once 'config.php';

try {
    $pdo = new PDO(
        "mysql:host={$config['host']};dbname={$config['db_name']};charset=utf8",
        $config['user'],
        $config['password']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Conexão estabelecida com sucesso!"; // Opcional para debug
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
