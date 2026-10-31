<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    require_once '../config/Database.php';
    require_once '../classes/Colaborador.php';

    $database = new Database();
    $db = $database->getConnection();

    $colaborador = new Colaborador($db);

    $id_colaborador = $_POST['id_colaborador'];
    $colaborador->nome     = $_POST['nome'];
    $colaborador->cpf      = $_POST['cpf'];
    $colaborador->cargo    = $_POST['cargo'];
    $colaborador->telefone = $_POST['telefone'];
    $colaborador->status   = $_POST['status'];

    if ($colaborador->atualizar($id_colaborador)) {
        header("Location: listar_colaboradores.php");
        exit;
    } else {
        header("Location: editar_colaborador.php?id=" . $id_colaborador);
        exit;
    }
} else {
    header("Location: ../painel.php");
    exit;
}
?>