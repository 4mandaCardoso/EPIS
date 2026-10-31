<?php
session_start();
if (!isset($_SESSION['matricula'])) {
    header("Location: ../index.php");
    exit;
}

// Se não houver um ID no link, devolve para a listagem
if (!isset($_GET['id'])) {
    header("Location: listar_epis.php");
    exit;
}

require_once '../config/Database.php';
require_once '../classes/EPI.php';

$database = new Database();
$db = $database->getConnection();
$epi = new EPI($db);

// Busca os dados reais deste equipamento específico
$dados = $epi->buscarPorId($_GET['id']);

if (!$dados) {
    header("Location: listar_epis.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes - ConstruMais</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        .detail-panel { background-color: var(--bg-panel); padding: 24px; border-radius: 12px; border: 1px solid var(--border-color); }
        .info-list { list-style: none; display: flex; flex-direction: column; gap: 16px; margin-top: 20px; }
        .info-list li { display: flex; justify-content: space-between; font-size: 14px; border-bottom: 1px solid rgba(51, 65, 85, 0.5); padding-bottom: 8px; }
        .info-list strong { color: var(--text-muted); font-weight: 500; }
        .info-list span { color: var(--text-main); }
    </style>
</head>
<body>
    
    <?php include '../includes/sidebar.php'; ?>

    <main class="main-content">
        <?php include '../includes/topbar.php'; ?>

        <div class="content-area">
            
            <!-- Cabeçalho com Botão Voltar -->
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 32px;">
                <div>
                    <h2 style="font-size: 24px; color: var(--text-main); margin-bottom: 4px;">Detalhes do Equipamento</h2>
                    <p style="color: var(--text-muted); font-size: 14px;">Equipamentos > Detalhes</p>
                </div>
                <a href="listar_epis.php" class="btn-cancel" style="display: inline-flex; align-items: center; gap: 8px; text-decoration: none; padding: 8px 16px;">
                    <i class="ph ph-arrow-left"></i> Voltar
                </a>
            </div>

            <!-- Grid de duas colunas do design -->
            <div style="display: grid; grid-template-columns: 350px 1fr; gap: 24px;">
                
                <!-- Coluna Esquerda: Imagem e Dados -->
                <div class="detail-panel" style="display: flex; flex-direction: column; gap: 20px;">
                    <!-- Placeholder para a foto -->
                    <div style="background: rgba(15, 23, 42, 0.5); border-radius: 8px; height: 200px; display: flex; justify-content: center; align-items: center; border: 1px solid var(--border-color);">
                        <i class="ph ph-wrench" style="font-size: 80px; color: var(--text-muted);"></i>
                    </div>
                    
                    <h3 style="font-size: 20px; display: flex; justify-content: space-between; align-items: center; color: var(--text-main);">
                        <?= htmlspecialchars($dados['Categoria']) ?>
                        <span class="badge" style="background: rgba(59, 130, 246, 0.15); color: #3B82F6; border: 1px solid rgba(59, 130, 246, 0.3); font-size: 10px;">
                            <?= htmlspecialchars($dados['status']) ?>
                        </span>
                    </h3>

                    <ul class="info-list">
                        <li><strong>Código:</strong> <span><?= htmlspecialchars($dados['CA']) ?></span></li>
                        <li><strong>Data de aquisição:</strong> <span><?= date('d/m/Y', strtotime($dados['primeiro_uso'])) ?></span></li>
                        <li><strong>Validade CA:</strong> <span><?= date('d/m/Y', strtotime($dados['Validade'])) ?></span></li>
                    </ul>
                </div>

                <!-- Coluna Direita: Tabela de Histórico de Uso -->
                <div class="detail-panel">
                    <h3 style="font-size: 16px; margin-bottom: 20px; color: var(--text-main);">Histórico de uso</h3>
                    <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                        <thead>
                            <tr>
                                <th style="padding: 12px 16px; border-bottom: 1px solid var(--border-color); text-align: left; color: var(--text-muted); font-weight: 500;">Data</th>
                                <th style="padding: 12px 16px; border-bottom: 1px solid var(--border-color); text-align: left; color: var(--text-muted); font-weight: 500;">Colaborador</th>
                                <th style="padding: 12px 16px; border-bottom: 1px solid var(--border-color); text-align: left; color: var(--text-muted); font-weight: 500;">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Tabela estática até criarmos a tabela MYSQL de movimentações -->
                            <tr>
                                <td style="padding: 16px; border-bottom: 1px solid rgba(51, 65, 85, 0.5); color: var(--text-main);">16/10/2026</td>
                                <td style="padding: 16px; border-bottom: 1px solid rgba(51, 65, 85, 0.5); color: var(--text-main);">João Silva</td>
                                <td style="padding: 16px; border-bottom: 1px solid rgba(51, 65, 85, 0.5); color: var(--text-main);">Retirou</td>
                            </tr>
                            <tr>
                                <td style="padding: 16px; border-bottom: 1px solid rgba(51, 65, 85, 0.5); color: var(--text-main);">15/10/2026</td>
                                <td style="padding: 16px; border-bottom: 1px solid rgba(51, 65, 85, 0.5); color: var(--text-main);">Carlos Souza</td>
                                <td style="padding: 16px; border-bottom: 1px solid rgba(51, 65, 85, 0.5); color: var(--text-main);">Devolveu</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </main>

</body>
</html>