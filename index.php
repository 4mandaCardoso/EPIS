<?php
session_start();

// Se o utilizador já tiver feito login, redireciona para a página correta consoante o nível
if (isset($_SESSION['matricula'])) {
    if (isset($_SESSION['nivel']) && $_SESSION['nivel'] == 'Administrador') {
        header("Location: painel.php");
    } else {
        header("Location: alugueis.php");
    }
    exit;
}

$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'config/Database.php';
    
    $database = new Database();
    $db = $database->getConnection();
    
    $usuario = trim($_POST['usuario']);
    $senha = $_POST['senha'];
    
    // Busca o utilizador na base de dados (apenas utilizadores Ativos)
    $query = "SELECT * FROM usuario WHERE usuario = ? AND senha = ? AND status = 'Ativo'";
    $stmt = $db->prepare($query);
    $stmt->execute([$usuario, $senha]);
    
    if ($stmt->rowCount() == 1) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Criamos as variáveis de sessão com os dados reais
        $_SESSION['matricula'] = $row['id_usuario']; 
        $_SESSION['nome'] = $row['nome'];
        $_SESSION['nivel'] = $row['nivel_acesso'];
        
        // REDIRECIONAMENTO INTELIGENTE:
        if ($_SESSION['nivel'] == 'Administrador') {
            header("Location: painel.php");
        } else {
            header("Location: alugueis.php");
        }
        exit;
    } else {
        $erro = "Utilizador ou senha incorretos, ou conta inativa.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ConstruMais</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        /* Ajuste extra para garantir que o logo do login fica perfeito e centrado */
        .login-logo-custom {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 32px;
        }
        .login-logo-text {
            display: flex;
            flex-direction: column;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="login-page">
        <div class="login-background"></div>
        
        <div class="login-container">
            
            <!-- ÁREA DO LOGO ATUALIZADA (IDÊNTICA À IMAGEM) -->
            <div class="login-logo-custom">
                <i class="ph ph-hard-hat" style="color: #FBBF24; font-size: 48px;"></i>
                <div class="login-logo-text">
                    <h1 style="color: var(--text-main, #ffffff); font-size: 28px; font-weight: 700; margin: 0; line-height: 1.1; letter-spacing: -0.5px;">
                        ConstruMais
                    </h1>
                    <span style="color: #93C5FD; font-size: 15px; font-weight: 500; margin-top: 2px;">
                        Gestão de Equipamentos
                    </span>
                </div>
            </div>

            <div class="login-box">
                <h3 style="text-align: center; margin-bottom: 24px; color: var(--text-main);">Acesso ao Sistema</h3>
                
                <?php if(!empty($erro)): ?>
                    <div class="alerta-erro">
                        <i class="ph ph-warning-circle" style="vertical-align: middle;"></i> <?php echo $erro; ?>
                    </div>
                <?php endif; ?>

                <form action="index.php" method="POST">
                    <div class="input-group">
                        <i class="ph ph-user"></i>
                        <input type="text" name="usuario" placeholder="Nome de utilizador (Ex: admin)" required>
                    </div>
                    
                    <div class="input-group">
                        <i class="ph ph-lock-key"></i>
                        <input type="password" name="senha" placeholder="Senha" required>
                    </div>
                    
                    <button type="submit" class="btn-login">Entrar no Sistema</button>
                </form>
                
                <div class="login-footer" style="text-align: center; margin-top: 24px; font-size: 12px; color: var(--text-muted);">
                    &copy; <?php echo date("Y"); ?> ConstruMais. Todos os direitos reservados.
                </div>
            </div>
        </div>
    </div>
</body>
</html>