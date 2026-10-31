<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // O comando 'trim' corta espaços invisíveis e o 'strtolower' força tudo a ficar minúsculo
    $usuario = trim(strtolower($_POST['usuario']));
    $senha = trim($_POST['senha']);

    // Login Padrão: admin / admin
    if ($usuario === 'admin' && $senha === 'admin') {
        
        // Cria a sessão (a chave que mantém o utilizador logado)
        $_SESSION['matricula'] = 'ADMIN-001';
        $_SESSION['nome_usuario'] = 'Administrador';
        
        // Atira para o dashboard
        header("Location: painel.php");
        exit;
    } else {
        // Se errar, guarda a mensagem de erro e atira de volta para o index
        $_SESSION['erro_login'] = "Usuário ou senha incorretos!";
        header("Location: index.php");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
?>