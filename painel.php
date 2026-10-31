<?php
session_start();
if (!isset($_SESSION['matricula'])) {
    header("Location: index.php");
    exit;
}

// O comando __DIR__ obriga o PHP a procurar na pasta exata do projeto
require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/classes/EPI.php';
require_once __DIR__ . '/classes/Colaborador.php';

$database = new Database();
$db = $database->getConnection();

$epi = new EPI($db);
$colaborador = new Colaborador($db);

$total_equipamentos = $epi->contarTodos() ?? 0;
$total_manutencao = $epi->contarPorStatus('Em manutenção') ?? 0;
$total_disponiveis = $epi->contarPorStatus('Disponível') ?? 0;

$total_colaboradores = $colaborador->contarTodos() ?? 0; 
?>
<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ConstruMais</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body>
    
    <!-- Menu Lateral -->
    <?php include 'includes/sidebar.php'; ?>

    <main class="main-content">
        <!-- Barra Superior -->
        <?php include 'includes/topbar.php'; ?>

        <div class="content-area">
            <div style="margin-bottom: 32px;">
                <h2 style="font-size: 24px; color: var(--text-main); margin-bottom: 8px;">Dashboard</h2>
                <p style="color: var(--text-muted); font-size: 14px;">Visão geral do sistema</p>
            </div>

            <!-- Os teus Cartões com as classes corretas do novo CSS -->
            <div class="card-grid">
                <div class="card blue">
                    <h3>Total de Equipamentos</h3>
                    <div class="value"><?php echo $total_equipamentos; ?></div>
                </div>
                
                <div class="card green">
                    <h3>Colaboradores</h3>
                    <div class="value"><?php echo $total_colaboradores; ?></div>
                </div>
                
                <div class="card orange">
                    <h3>Em Manutenção</h3>
                    <div class="value"><?php echo $total_manutencao; ?></div>
                </div>
                
                <div class="card purple">
                    <h3>Disponíveis</h3>
                    <div class="value"><?php echo $total_disponiveis; ?></div>
                </div>
            </div>
        </div>
    </main>

</body>
</html>