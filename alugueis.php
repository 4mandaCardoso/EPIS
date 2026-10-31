<?php
session_start();
if (!isset($_SESSION['matricula'])) {
    header("Location: index.php");
    exit;
}

require_once 'config/Database.php';

$database = new Database();
$db = $database->getConnection();

$id_usuario_logado = $_SESSION['matricula'];
$nome_usuario_logado = $_SESSION['nome'];

// 1. Corrigido: Usando "Categoria" para organizar
$queryDisponiveis = "SELECT * FROM epi WHERE status = 'Disponível' ORDER BY Categoria ASC";
$stmtDisponiveis = $db->prepare($queryDisponiveis);
$stmtDisponiveis->execute();

// 2. Corrigido: Usando "Categoria" e "CA" exatos da tua tabela
$queryMeus = "SELECT emp.id_emprestimo, emp.data_retirada, epi.id_epi, epi.Categoria, epi.CA 
              FROM emprestimo emp 
              JOIN epi epi ON emp.id_epi = epi.id_epi 
              WHERE emp.id_usuario = ? AND emp.status = 'Em uso'
              ORDER BY emp.data_retirada DESC";
$stmtMeus = $db->prepare($queryMeus);
$stmtMeus->execute([$id_usuario_logado]);
?>
<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retirada de EPIs - ConstruMais</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        .aluguel-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-top: 20px; }
        @media (max-width: 900px) { .aluguel-grid { grid-template-columns: 1fr; } }
        
        .btn-alugar { background-color: var(--status-green); color: #fff; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: 600; display: inline-block; transition: 0.2s; }
        .btn-alugar:hover { background-color: #059669; }
        
        .btn-devolver { background-color: var(--status-orange); color: #fff; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: 600; display: inline-block; transition: 0.2s; }
        .btn-devolver:hover { background-color: #D97706; }
        
        .empty-msg { text-align: center; padding: 32px; color: var(--text-muted); font-size: 14px; }
    </style>
</head>
<body>
    
    <?php include 'includes/sidebar.php'; ?>

    <main class="main-content">
        <?php include 'includes/topbar.php'; ?>

        <div class="content-area">
            
            <div style="margin-bottom: 24px;">
                <h2 style="font-size: 24px; color: var(--text-main); margin-bottom: 8px;">Área de Retirada de EPIs</h2>
                <p style="color: var(--text-muted); font-size: 14px;">Bem-vindo(a), <strong><?= htmlspecialchars($nome_usuario_logado) ?></strong>. Faça a gestão dos seus equipamentos aqui.</p>
            </div>

            <div class="aluguel-grid">
                
                <div class="table-container">
                    <h3 style="margin-bottom: 16px; color: var(--status-green); font-size: 16px; display: flex; align-items: center; gap: 8px;">
                        <i class="ph ph-check-circle"></i> Disponíveis para Retirada
                    </h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Equipamento (Categoria)</th>
                                <th>CA</th>
                                <th style="text-align: right;">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($stmtDisponiveis->rowCount() > 0): ?>
                                <?php while($epi = $stmtDisponiveis->fetch(PDO::FETCH_ASSOC)): ?>
                                <tr>
                                    <!-- Usando $epi['Categoria'] e $epi['CA'] -->
                                    <td><strong><?= htmlspecialchars($epi['Categoria']) ?></strong></td>
                                    <td><?= htmlspecialchars($epi['CA']) ?></td>
                                    <td style="text-align: right;">
                                        <a href="processa_aluguel.php?id_epi=<?= $epi['id_epi'] ?>" class="btn-alugar" onclick="return confirm('Deseja retirar o equipamento <?= htmlspecialchars($epi['Categoria']) ?>?')">Alugar</a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="3" class="empty-msg">Nenhum equipamento disponível no momento.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="table-container">
                    <h3 style="margin-bottom: 16px; color: var(--status-orange); font-size: 16px; display: flex; align-items: center; gap: 8px;">
                        <i class="ph ph-hand-grabbing"></i> Meus Equipamentos em Uso
                    </h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Equipamento</th>
                                <th>Data Retirada</th>
                                <th style="text-align: right;">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($stmtMeus->rowCount() > 0): ?>
                                <?php while($meu = $stmtMeus->fetch(PDO::FETCH_ASSOC)): ?>
                                <tr>
                                    <!-- Usando $meu['Categoria'] -->
                                    <td><strong><?= htmlspecialchars($meu['Categoria']) ?></strong></td>
                                    <td style="font-size: 13px; color: var(--text-muted);"><?= date('d/m/Y H:i', strtotime($meu['data_retirada'])) ?></td>
                                    <td style="text-align: right;">
                                        <a href="processa_devolucao.php?id_emprestimo=<?= $meu['id_emprestimo'] ?>&id_epi=<?= $meu['id_epi'] ?>" class="btn-devolver" onclick="return confirm('Deseja devolver o equipamento <?= htmlspecialchars($meu['Categoria']) ?>?')">Devolver</a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="3" class="empty-msg">Você não possui nenhum equipamento alugado no momento.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </main>
</body>
</html>