<?php
session_start();
if (!isset($_SESSION['matricula'])) {
    header("Location: ../index.php");
    exit;
}

require_once '../config/Database.php';
require_once '../classes/Usuario.php';

$database = new Database();
$db = $database->getConnection();
$usuarioObj = new Usuario($db);

$stmt = $usuarioObj->listarTodos();
?>
<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuários - ConstruMais</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body>
    
    <?php include '../includes/sidebar.php'; ?>

    <main class="main-content">
        <?php include '../includes/topbar.php'; ?>

        <div class="content-area">
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
                <div>
                    <h2 style="font-size: 24px; color: var(--text-main); margin-bottom: 8px;">Controlo de Usuários</h2>
                    <p style="color: var(--text-muted); font-size: 14px;">Gira quem tem acesso ao sistema ConstruMais</p>
                </div>
                <!-- O Botão Azul que já criámos antes -->
                <a href="form_usuario.php" class="btn-primary" style="display: flex; align-items: center; gap: 8px;">
                    <i class="ph ph-plus-circle" style="font-size: 20px;"></i>
                    Novo Usuário
                </a>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Login</th>
                            <th>Nível de Acesso</th>
                            <th>Status</th>
                            <th style="text-align: right;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($stmt->rowCount() > 0) {
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                
                                // Cor da badge do Status
                                $statusClass = ($row['status'] == 'Ativo') ? 'badge-ativo' : 'badge-inativo';
                                
                                // Cor do Nível de Acesso
                                $nivelColor = ($row['nivel_acesso'] == 'Administrador') ? 'color: var(--status-orange); font-weight: bold;' : 'color: var(--text-muted);';

                                echo "<tr>";
                                echo "<td><strong>" . htmlspecialchars($row['nome']) . "</strong></td>";
                                echo "<td>" . htmlspecialchars($row['usuario']) . "</td>";
                                echo "<td style='{$nivelColor}'>" . htmlspecialchars($row['nivel_acesso']) . "</td>";
                                echo "<td><span class='badge {$statusClass}'>" . htmlspecialchars($row['status']) . "</span></td>";
                                echo "<td style='text-align: right;'>";
                                
                                // Botão Verde (Editar)
                                echo "<a href='editar_usuario.php?id={$row['id_usuario']}' title='Editar' style='color: var(--status-green); margin-right: 12px; font-size: 20px; transition: 0.2s;' onmouseover='this.style.color=\"#34D399\"' onmouseout='this.style.color=\"var(--status-green)\"'>
                                        <i class='ph ph-pencil-simple'></i>
                                      </a>";
                                
                                // Botão Vermelho (Eliminar) - Mostra um aviso antes de apagar
                                echo "<a href='excluir_usuario.php?id={$row['id_usuario']}' title='Eliminar' onclick='return confirm(\"Tem a certeza que deseja eliminar o acesso de {$row['nome']}?\")' style='color: var(--status-red); font-size: 20px; transition: 0.2s;' onmouseover='this.style.color=\"#FCA5A5\"' onmouseout='this.style.color=\"var(--status-red)\"'>
                                        <i class='ph ph-trash'></i>
                                      </a>";
                                
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' style='text-align: center; padding: 32px; color: var(--text-muted);'>Nenhum utilizador encontrado na base de dados.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </div>
    </main>

</body>
</html>