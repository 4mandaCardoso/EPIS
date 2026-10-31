<?php
session_start();
if (!isset($_SESSION['matricula'])) {
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Usuário - ConstruMais</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        .form-panel { background-color: var(--bg-panel); padding: 32px; border-radius: 12px; border: 1px solid var(--border-color); }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 14px; font-weight: 500; color: var(--text-main); margin-bottom: 8px; }
        .form-group label span { color: var(--status-red); }
        .form-control { width: 100%; padding: 12px 16px; background-color: rgba(15, 23, 42, 0.5); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-main); outline: none; transition: 0.3s; font-size: 14px; }
        .form-control:focus { border-color: var(--primary-blue); }
        .form-actions { display: flex; justify-content: flex-end; gap: 16px; margin-top: 32px; padding-top: 24px; border-top: 1px solid var(--border-color); }
        .btn-cancel { padding: 12px 24px; background: transparent; border: 1px solid var(--border-color); color: var(--text-main); border-radius: 8px; cursor: pointer; text-decoration: none; font-weight: 500; font-size: 14px; }
    </style>
</head>
<body>
    
    <?php include '../includes/sidebar.php'; ?>

    <main class="main-content">
        <?php include '../includes/topbar.php'; ?>

        <div class="content-area">
            <div style="margin-bottom: 32px;">
                <h2 style="font-size: 24px; color: var(--text-main); margin-bottom: 8px;">Adicionar Novo Usuário</h2>
                <p style="color: var(--text-muted); font-size: 14px;">Crie um novo acesso para a plataforma.</p>
            </div>

            <div class="form-panel">
                <!-- O método POST é fundamental aqui -->
                <form action="processa_usuario.php" method="POST">
                    
                    <div class="form-grid">
                        <div>
                            <div class="form-group">
                                <label>Nome Completo <span>*</span></label>
                                <!-- O name="nome" faz o PHP receber a variável -->
                                <input type="text" name="nome" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Nome de Usuário (Login) <span>*</span></label>
                                <!-- Foi a falta deste name="usuario" que causou o erro -->
                                <input type="text" name="usuario" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Senha <span>*</span></label>
                                <input type="password" name="senha" class="form-control" required>
                            </div>
                        </div>

                        <div>
                            <div class="form-group">
                                <label>Nível de Acesso <span>*</span></label>
                                <!-- Foi a falta deste name="nivel_acesso" que causou o erro -->
                                <select name="nivel_acesso" class="form-control" required>
                                    <option value="Padrão">Padrão</option>
                                    <option value="Administrador">Administrador</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Status <span>*</span></label>
                                <!-- Foi a falta deste name="status" que causou o erro -->
                                <select name="status" class="form-control" required>
                                    <option value="Ativo">Ativo</option>
                                    <option value="Inativo">Inativo</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="listar_usuarios.php" class="btn-cancel">Cancelar</a>
                        <button type="submit" class="btn-primary">Salvar Usuário</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

</body>
</html>