<?php
session_start();
if (!isset($_SESSION['matricula'])) {
    header("Location: ../index.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: listar_epis.php");
    exit;
}

require_once '../config/Database.php';
require_once '../classes/EPI.php';

$database = new Database();
$db = $database->getConnection();
$epi = new EPI($db);

// Puxa os dados atuais do equipamento
$dados = $epi->buscarPorId($_GET['id']);

if (!$dados) {
    header("Location: listar_epis.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Equipamento - ConstruMais</title>
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
                <h2 style="font-size: 24px; color: var(--text-main); margin-bottom: 8px;">Editar Equipamento</h2>
                <p style="color: var(--text-muted); font-size: 14px;">Atualize os dados da ferramenta</p>
            </div>

            <div class="form-panel">
                <form action="processa_edicao_epi.php" method="POST">
                    
                    <!-- Campo oculto para enviar o ID ao ficheiro de processamento -->
                    <input type="hidden" name="id_epi" value="<?= htmlspecialchars($dados['id_epi']) ?>">

                    <div class="form-grid">
                        <div>
                            <div class="form-group">
                                <label>Nome do equipamento <span>*</span></label>
                                <input type="text" name="Categoria" class="form-control" value="<?= htmlspecialchars($dados['Categoria']) ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Código <span>*</span></label>
                                <input type="text" name="CA" class="form-control" value="<?= htmlspecialchars($dados['CA']) ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control" required>
                                    <option value="Disponível" <?= ($dados['status'] == 'Disponível') ? 'selected' : '' ?>>Disponível</option>
                                    <option value="Em uso" <?= ($dados['status'] == 'Em uso') ? 'selected' : '' ?>>Em uso</option>
                                    <option value="Em manutenção" <?= ($dados['status'] == 'Em manutenção') ? 'selected' : '' ?>>Em manutenção</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <div class="form-group">
                                <label>Data de aquisição</label>
                                <input type="date" name="primeiro_uso" class="form-control" value="<?= htmlspecialchars($dados['primeiro_uso']) ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Data de Validade (CA)</label>
                                <input type="date" name="validade" class="form-control" value="<?= htmlspecialchars($dados['Validade']) ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="listar_epis.php" class="btn-cancel">Cancelar</a>
                        <button type="submit" class="btn-save">Atualizar Equipamento</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

</body>
</html>