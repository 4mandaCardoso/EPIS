<?php
session_start();
if (!isset($_SESSION['matricula'])) {
    header("Location: ../index.php");
    exit;
}

require_once '../config/Database.php';
require_once '../classes/Colaborador.php';

$database = new Database();
$db = $database->getConnection();
$colaborador = new Colaborador($db);
$stmt = $colaborador->listarTodos();
?>
<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Colaboradores - ConstruMais</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body>
    
    <?php include '../includes/sidebar.php'; ?>

    <main class="main-content">
        <?php include '../includes/topbar.php'; ?>

        <div class="content-area">
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                <div>
                    <h2 style="font-size: 24px; color: var(--text-main); margin-bottom: 4px;">Colaboradores</h2>
                    <p style="color: var(--text-muted); font-size: 14px;">Lista de todos os funcionários</p>
                </div>
                <a href="form_colaborador.php" class="btn-primary" style="display: flex; align-items: center; gap: 8px; text-decoration: none;">
                    <i class="ph ph-plus"></i> Novo Colaborador
                </a>
            </div>

            <div class="table-container">
                <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
                    <div class="input-group" style="width: 320px; margin-bottom: 0;">
                        <i class="ph ph-magnifying-glass"></i>
                        <input type="text" placeholder="Buscar por nome ou CPF..." style="padding: 12px 12px 12px 40px; background-color: rgba(15, 23, 42, 0.5); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-main); width: 100%;">
                    </div>
                </div>

                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="padding: 16px; border-bottom: 1px solid var(--border-color); color: var(--text-muted); text-align: left; font-weight: 500; font-size: 14px;">Nome</th>
                            <th style="padding: 16px; border-bottom: 1px solid var(--border-color); color: var(--text-muted); text-align: left; font-weight: 500; font-size: 14px;">Cargo</th>
                            <th style="padding: 16px; border-bottom: 1px solid var(--border-color); color: var(--text-muted); text-align: left; font-weight: 500; font-size: 14px;">Status</th>
                            <th style="padding: 16px; border-bottom: 1px solid var(--border-color); color: var(--text-muted); text-align: center; font-weight: 500; font-size: 14px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($stmt->rowCount() > 0) {
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $status_style = ($row['status'] == 'Ativo') 
                                    ? "background: rgba(16, 185, 129, 0.15); color: #10B981; border: 1px solid rgba(16, 185, 129, 0.3);" 
                                    : "background: rgba(239, 68, 68, 0.15); color: #EF4444; border: 1px solid rgba(239, 68, 68, 0.3);";

                                echo "<tr>";
                                echo "<td style='padding: 16px; border-bottom: 1px solid rgba(51, 65, 85, 0.5); font-weight: 500;'>" . htmlspecialchars($row['nome']) . "</td>";
                                echo "<td style='padding: 16px; border-bottom: 1px solid rgba(51, 65, 85, 0.5);'>" . htmlspecialchars($row['cargo']) . "</td>";
                                echo "<td style='padding: 16px; border-bottom: 1px solid rgba(51, 65, 85, 0.5);'><span class='badge' style='{$status_style} padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 500;'>" . htmlspecialchars($row['status']) . "</span></td>";
                                
                                echo "<td style='padding: 16px; border-bottom: 1px solid rgba(51, 65, 85, 0.5); text-align: center;'>";
                                echo "<div style='display: flex; gap: 8px; justify-content: center;'>";
                                echo "<a href='editar_colaborador.php?id=" . $row['id_colaborador'] . "' style='padding: 6px; border-radius: 6px; background: rgba(16, 185, 129, 0.15); color: #10B981; display: flex; transition: 0.2s;'><i class='ph ph-pencil-simple'></i></a>";
                                echo "<a href='excluir_colaborador.php?id=" . $row['id_colaborador'] . "' onclick='return confirm(\"Excluir este colaborador?\")' style='padding: 6px; border-radius: 6px; background: rgba(239, 68, 68, 0.15); color: #EF4444; display: flex; transition: 0.2s;'><i class='ph ph-trash'></i></a>";
                                echo "</div>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4' style='text-align: center; padding: 30px; color: var(--text-muted);'>Nenhum colaborador cadastrado.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</body>
</html>