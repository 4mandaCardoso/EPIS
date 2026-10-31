<?php
session_start();
if (!isset($_SESSION['matricula'])) {
    header("Location: ../index.php");
    exit;
}

if (isset($_GET['id'])) {
    require_once '../config/Database.php';
    require_once '../classes/EPI.php';

    $database = new Database();
    $db = $database->getConnection();
    $epi = new EPI($db);

    // Chama a função excluir que acabámos de criar
    $epi->excluir($_GET['id']);
}

// Volta para a lista de equipamentos logo a seguir
header("Location: listar_epis.php");
exit;
?>