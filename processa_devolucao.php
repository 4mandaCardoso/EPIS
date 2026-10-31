<?php
session_start();

// Verifica se os dados necessários vieram pela URL
if (!isset($_SESSION['matricula']) || !isset($_GET['id_emprestimo']) || !isset($_GET['id_epi'])) {
    header("Location: alugueis.php");
    exit;
}

require_once 'config/Database.php';

$database = new Database();
$db = $database->getConnection();

$id_emprestimo = $_GET['id_emprestimo'];
$id_epi = $_GET['id_epi'];

try {
    // 1. Marca o empréstimo como 'Devolvido' e anota a hora do clique
    $queryEmprestimo = "UPDATE emprestimo SET status = 'Devolvido', data_devolucao = NOW() WHERE id_emprestimo = ?";
    $stmt = $db->prepare($queryEmprestimo);
    $stmt->execute([$id_emprestimo]);

    // 2. Coloca o EPI de volta nos 'Disponíveis'
    $queryUpdate = "UPDATE epi SET status = 'Disponível' WHERE id_epi = ?";
    $stmtUpdate = $db->prepare($queryUpdate);
    $stmtUpdate->execute([$id_epi]);

} catch (PDOException $e) {
    echo "Erro ao processar devolução: " . $e->getMessage();
    exit;
}

// Volta instantaneamente para a página
header("Location: alugueis.php");
exit;
?>