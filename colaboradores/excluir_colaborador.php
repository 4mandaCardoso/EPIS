<?php
session_start();
if (!isset($_SESSION['matricula'])) {
    header("Location: ../index.php");
    exit;
}

if (isset($_GET['id'])) {
    require_once '../config/Database.php';
    require_once '../classes/Colaborador.php';

    $database = new Database();
    $db = $database->getConnection();
    $colaborador = new Colaborador($db);

    $colaborador->excluir($_GET['id']);
}

header("Location: listar_colaboradores.php");
exit;
?>