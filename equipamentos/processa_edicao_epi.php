<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    require_once '../config/Database.php';
    require_once '../classes/EPI.php';

    $database = new Database();
    $db = $database->getConnection();

    $epi = new EPI($db);

    // Recebe os dados do formulário
    $id_epi = $_POST['id_epi'];
    $epi->Categoria    = $_POST['Categoria'];
    $epi->CA           = $_POST['CA'];
    $epi->status       = $_POST['status'];
    $epi->primeiro_uso = $_POST['primeiro_uso'];
    $epi->Validade     = $_POST['validade'];

    // Executa a função atualizar() passando o ID
    if ($epi->atualizar($id_epi)) {
        header("Location: listar_epis.php");
        exit;
    } else {
        header("Location: editar_epi.php?id=" . $id_epi);
        exit;
    }
} else {
    header("Location: ../painel.php");
    exit;
}
?>