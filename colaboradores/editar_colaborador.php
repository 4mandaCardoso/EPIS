<?php
session_start();
if (!isset($_SESSION['matricula'])) {
    header("Location: ../index.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: listar_colaboradores.php");
    exit;
}

require_once '../config/Database.php';
require_once '../classes/Colaborador.php';

$database = new Database();
$db = $database->getConnection();
$colaborador = new Colaborador($db);

// Puxa os dados atuais do trabalhador
$dados = $colaborador->buscarPorId($_GET['id']);

if (!$dados) {
    header("Location: listar_colaboradores.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Colaborador - ConstruMais</title>
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
                <h2 style="font-size: 24px; color: var(--text-main); margin-bottom: 8px;">Editar Colaborador</h2>
                <p style="color: var(--text-muted); font-size: 14px;">Atualize os dados do funcionário</p>
            </div>

            <div class="form-panel">
                <form action="processa_edicao_colaborador.php" method="POST">
                    
                    <!-- ID oculto para o sistema saber quem vai atualizar -->
                    <input type="hidden" name="id_colaborador" value="<?= htmlspecialchars($dados['id_colaborador']) ?>">

                    <div class="form-grid">
                        <div>
                            <div class="form-group">
                                <label>Nome Completo <span>*</span></label>
                                <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($dados['nome']) ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Cargo <span>*</span></label>
                                <input type="text" name="cargo" class="form-control" value="<?= htmlspecialchars($dados['cargo']) ?>" required>
                            </div>
                        </div>

                        <div>
                            <div class="form-group">
                                <label>CPF <span>*</span></label>
                                <input type="text" name="cpf" class="form-control" value="<?= htmlspecialchars($dados['cpf']) ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Telefone</label>
                                <input type="text" name="telefone" class="form-control" value="<?= htmlspecialchars($dados['telefone']) ?>">
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
                        <a href="listar_colaboradores.php" class="btn-cancel">Cancelar</a>
                        <button type="submit" class="btn-save">Atualizar Colaborador</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

</body>
</html>