<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    require_once '../config/Database.php';
    require_once '../classes/Colaborador.php';

    $database = new Database();
    $db = $database->getConnection();

    $colaborador = new Colaborador($db);

    // Recebe os dados do formulário e associa às variáveis da classe
    $colaborador->nome     = $_POST['nome'];
    $colaborador->cpf      = $_POST['cpf'];
    $colaborador->cargo    = $_POST['cargo'];
    $colaborador->telefone = $_POST['telefone'];
    $colaborador->status   = $_POST['status'];

    // Tenta cadastrar na base de dados
    if ($colaborador->cadastrar()) {
        header("Location: listar_colaboradores.php");
        exit;
    } else {
        header("Location: form_colaborador.php");
        exit;
    }
} else {
    // Se não vier por POST, expulsa de volta para o painel
    header("Location: ../painel.php");
    exit;
}
?>