<?php
session_start();
if (!isset($_SESSION['matricula'])) {
    header("Location: ../index.php");
    exit;
}

if (isset($_GET['id'])) {
    require_once '../config/Database.php';
    require_once '../classes/Usuario.php';

    $database = new Database();
    $db = $database->getConnection();
    $usuarioObj = new Usuario($db);

    $usuarioObj->excluir($_GET['id']);
}

header("Location: listar_usuarios.php");
exit;
?>