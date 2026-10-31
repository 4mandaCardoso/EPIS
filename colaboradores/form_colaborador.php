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
    <title>Novo Colaborador - ConstruMais</title>
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
        .btn-save { padding: 12px 24px; background: var(--primary-blue); border: none; color: white; border-radius: 8px; cursor: pointer; font-weight: 500; font-size: 14px; }
    </style>
</head>
<body>
    
    <?php include '../includes/sidebar.php'; ?>

    <main class="main-content">
        <?php include '../includes/topbar.php'; ?>

        <div class="content-area">
            <div style="margin-bottom: 32px;">
                <h2 style="font-size: 24px; color: var(--text-main); margin-bottom: 8px;">Cadastro de Colaborador</h2>
                <p style="color: var(--text-muted); font-size: 14px;">Preencha os dados do novo funcionário</p>
            </div>

            <div class="form-panel">
                <form action="processa_colaborador.php" method="POST">
                    <div class="form-grid">
                        <!-- Coluna Esquerda -->
                        <div>
                            <div class="form-group">
                                <label>Nome Completo <span>*</span></label>
                                <input type="text" name="nome" class="form-control" placeholder="Ex: João da Silva" required>
                            </div>
                            <div class="form-group">
                                <label>Cargo <span>*</span></label>
                                <input type="text" name="cargo" class="form-control" placeholder="Ex: Pedreiro" required>
                            </div>
                        </div>

                        <!-- Coluna Direita -->
                        <div>
                            <div class="form-group">
                                <label>CPF <span>*</span></label>
                                <input type="text" name="cpf" class="form-control" placeholder="000.000.000-00" required>
                            </div>
                            <div class="form-group">
                                <label>Telefone</label>
                                <input type="text" name="telefone" class="form-control" placeholder="(00) 00000-0000">
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control" required>
                                    <option value="Ativo" selected>Ativo</option>
                                    <option value="Inativo">Inativo</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="listar_colaboradores.php" class="btn-cancel">Cancelar</a>
                        <button type="submit" class="btn-save">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

</body>
</html>