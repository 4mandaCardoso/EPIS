<?php
session_start();

// Verifica se a pessoa está logada e se clicou num EPI válido
if (!isset($_SESSION['matricula']) || !isset($_GET['id_epi'])) {
    header("Location: alugueis.php");
    exit;
}

require_once 'config/Database.php';

$database = new Database();
$db = $database->getConnection();

$id_epi = $_GET['id_epi'];
$id_usuario = $_SESSION['matricula']; // Pega o ID de quem está a usar o sistema

try {
    // 1. Grava no "caderno" que este utilizador pegou este EPI agora
    $queryEmprestimo = "INSERT INTO emprestimo (id_epi, id_usuario, status) VALUES (?, ?, 'Em uso')";
    $stmt = $db->prepare($queryEmprestimo);
    $stmt->execute([$id_epi, $id_usuario]);

    // 2. Vai à prateleira (tabela EPI) e tira-o dos disponíveis
    $queryUpdate = "UPDATE epi SET status = 'Em uso' WHERE id_epi = ?";
    $stmtUpdate = $db->prepare($queryUpdate);
    $stmtUpdate->execute([$id_epi]);

} catch (PDOException $e) {
    // Se houver algum erro de banco de dados, podes tratar aqui futuramente
    echo "Erro ao processar o aluguer: " . $e->getMessage();
    exit;
}

// Volta instantaneamente para a página (o utilizador nem vê isto acontecer)
header("Location: alugueis.php");
exit;
?>