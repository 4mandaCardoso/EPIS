<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    require_once '../config/Database.php';
    require_once '../classes/Usuario.php';

    $database = new Database();
    $db = $database->getConnection();

    $usuarioObj = new Usuario($db);

    // As variáveis da classe estão em minúsculas e correspondem exatamente aos campos do formulário
    $usuarioObj->nome         = $_POST['nome'];
    $usuarioObj->usuario      = $_POST['usuario'];
    $usuarioObj->senha        = $_POST['senha']; 
    $usuarioObj->nivel_acesso = $_POST['nivel_acesso'];
    $usuarioObj->status       = $_POST['status'];

    if ($usuarioObj->cadastrar()) {
        header("Location: listar_usuarios.php");
        exit;
    } else {
        header("Location: form_usuario.php");
        exit;
    }
} else {
    header("Location: ../painel.php");
    exit;
}
?>