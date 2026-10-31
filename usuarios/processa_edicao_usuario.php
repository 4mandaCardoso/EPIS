<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    require_once '../config/Database.php';
    require_once '../classes/Usuario.php';

    $database = new Database();
    $db = $database->getConnection();

    $usuarioObj = new Usuario($db);

    $id_usuario = $_POST['id_usuario'];
    $usuarioObj->nome         = $_POST['nome'];
    $usuarioObj->usuario      = $_POST['usuario'];
    $usuarioObj->nivel_acesso = $_POST['nivel_acesso'];
    $usuarioObj->status       = $_POST['status'];

    // Lógica da senha: usa a nova se for digitada, ou mantém a antiga
    if (!empty($_POST['senha_nova'])) {
        $usuarioObj->senha = $_POST['senha_nova'];
    } else {
        $usuarioObj->senha = $_POST['senha_atual'];
    }

    if ($usuarioObj->atualizar($id_usuario)) {
        header("Location: listar_usuarios.php");
        exit;
    } else {
        header("Location: editar_usuario.php?id=" . $id_usuario);
        exit;
    }
} else {
    header("Location: ../painel.php");
    exit;
}
?>