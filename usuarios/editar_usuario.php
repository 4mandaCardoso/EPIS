<?php
session_start();
if (!isset($_SESSION['matricula'])) {
    header("Location: ../index.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: listar_usuarios.php");
    exit;
}

require_once '../config/Database.php';
require_once '../classes/Usuario.php';

$database = new Database();
$db = $database->getConnection();
$usuarioObj = new Usuario($db);

$dados = $usuarioObj->buscarPorId($_GET['id']);

if (!$dados) {
    header("Location: listar_usuarios.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário - ConstruMais</title>
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
        .btn-save { padding: 12px 24px; background: var(--status-green); border: none; color: white; border-radius: 8px; cursor: pointer; font-weight: 500; font-size: 14px; }
    </style>
</head>
<body>
    
    <?php include '../includes/sidebar.php'; ?>

    <main class="main-content">
        <?php include '../includes/topbar.php'; ?>

        <div class="content-area">
            <div style="margin-bottom: 32px;">
                <h2 style="font-size: 24px; color: var(--text-main); margin-bottom: 8px;">Editar Usuário</h2>
                <p style="color: var(--text-muted); font-size: 14px;">Atualize as permissões de acesso</p>
            </div>

            <div class="form-panel">
                <form action="processa_edicao_usuario.php" method="POST">
                    
                    <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($dados['id_usuario']) ?>">
                    <!-- Guardamos a senha atual escondida. Se não digitar senha nova, usa esta -->
                    <input type="hidden" name="senha_atual" value="<?= htmlspecialchars($dados['senha']) ?>">

                    <div class="form-grid">
                        <div>
                            <div class="form-group">
                                <label>Nome Completo <span>*</span></label>
                                <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($dados['nome']) ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Nome de Usuário (Login) <span>*</span></label>
                                <input type="text" name="usuario" class="form-control" value="<?= htmlspecialchars($dados['usuario']) ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Nova Senha (deixe em branco para manter a atual)</label>
                                <input type="password" name="senha_nova" class="form-control" placeholder="Digite apenas se quiser alterar">
                            </div>
                        </div>

                        <div>
                            <div class="form-group">
                                <label>Nível de Acesso <span>*</span></label>
                                <select name="nivel_acesso" class="form-control" required>
                                    <option value="Padrão" <?= ($dados['nivel_acesso'] == 'Padrão') ? 'selected' : '' ?>>Padrão</option>
                                    <option value="Administrador" <?= ($dados['nivel_acesso'] == 'Administrador') ? 'selected' : '' ?>>Administrador</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control" required>
                                    <option value="Ativo" <?= ($dados['status'] == 'Ativo') ? 'selected' : '' ?>>Ativo</option>
                                    <option value="Inativo" <?= ($dados['status'] == 'Inativo') ? 'selected' : '' ?>>Inativo</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="listar_usuarios.php" class="btn-cancel">Cancelar</a>
                        <button type="submit" class="btn-save">Atualizar Usuário</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

</body>
</html>