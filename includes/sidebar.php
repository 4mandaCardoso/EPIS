<?php
// Prefixo das URLs: no XAMPP o sistema fica em /epis; na nuvem (Render) fica na raiz.
// A variável APP_BASE_PATH (definida no Dockerfile como vazia) controla isso.
$base_url = getenv('APP_BASE_PATH');
if ($base_url === false) { $base_url = '/epis'; }
?>
<aside class="sidebar" style="background-color: var(--bg-panel, #1E293B); border-right: 1px solid var(--border-color, #334155); display: flex; flex-direction: column; height: 100vh; position: fixed; width: 260px; left: 0; top: 0; font-family: sans-serif; z-index: 100;">
    
    <!-- ÁREA DO LOGO -->
    <div class="logo-area" style="padding: 24px; border-bottom: 1px solid var(--border-color, #334155); display: flex; align-items: center; gap: 12px;">
        <i class="ph ph-hard-hat" style="color: #FBBF24; font-size: 38px;"></i>
        <div style="display: flex; flex-direction: column;">
            <h1 style="color: var(--text-main, #ffffff); font-size: 22px; font-weight: 700; margin: 0; line-height: 1.1; letter-spacing: -0.5px;">
                ConstruMais
            </h1>
            <span style="color: #93C5FD; font-size: 13px; font-weight: 500; margin-top: 2px;">
                Gestão de Equipamentos
            </span>
        </div>
    </div>

    <!-- MENU DE NAVEGAÇÃO -->
    <nav class="nav-menu" style="padding: 24px 16px; flex: 1; display: flex; flex-direction: column; gap: 8px;">
        
        <?php 
        // SÓ MOSTRA SE FOR ADMINISTRADOR
        if(isset($_SESSION['nivel']) && $_SESSION['nivel'] == 'Administrador'): 
        ?>
            <a href="<?= $base_url ?>/painel.php" class="nav-item" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: var(--text-main, #F8FAFC); text-decoration: none; border-radius: 8px; transition: all 0.3s ease;">
                <i class="ph ph-squares-four" style="font-size: 20px; color: var(--text-muted, #94A3B8);"></i> Dashboard
            </a>
            <a href="<?= $base_url ?>/equipamentos/listar_epis.php" class="nav-item" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: var(--text-main, #F8FAFC); text-decoration: none; border-radius: 8px; transition: all 0.3s ease;">
                <i class="ph ph-wrench" style="font-size: 20px; color: var(--text-muted, #94A3B8);"></i> Equipamentos
            </a>
            <a href="<?= $base_url ?>/colaboradores/listar_colaboradores.php" class="nav-item" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: var(--text-main, #F8FAFC); text-decoration: none; border-radius: 8px; transition: all 0.3s ease;">
                <i class="ph ph-users" style="font-size: 20px; color: var(--text-muted, #94A3B8);"></i> Colaboradores
            </a>
            <a href="<?= $base_url ?>/usuarios/listar_usuarios.php" class="nav-item" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: var(--text-main, #F8FAFC); text-decoration: none; border-radius: 8px; transition: all 0.3s ease;">
                <i class="ph ph-shield-check" style="font-size: 20px; color: var(--text-muted, #94A3B8);"></i> Usuários
            </a>
        <?php endif; ?>

        <?php 
        // SÓ MOSTRA SE FOR PADRÃO
        if(isset($_SESSION['nivel']) && $_SESSION['nivel'] == 'Padrão'): 
        ?>
            <a href="<?= $base_url ?>/alugueis.php" class="nav-item" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: var(--text-main, #F8FAFC); text-decoration: none; border-radius: 8px; transition: all 0.3s ease;">
                <i class="ph ph-hand-grabbing" style="font-size: 20px; color: var(--text-muted, #94A3B8);"></i> Meus Aluguéis
            </a>
        <?php endif; ?>
        
    </nav>

    <!-- INFORMAÇÃO DO USUÁRIO LOGADO -->
    <div class="user-info" style="padding: 24px 16px; border-top: 1px solid var(--border-color, #334155); display: flex; align-items: center; gap: 12px;">
        <div style="width: 40px; height: 40px; background: rgba(59, 130, 246, 0.15); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--primary-blue, #3B82F6);">
            <i class="ph ph-user" style="font-size: 20px;"></i>
        </div>
        <div style="flex: 1; overflow: hidden;">
            <h4 style="font-size: 14px; font-weight: 500; color: var(--text-main, #F8FAFC); margin: 0 0 2px 0; white-space: nowrap; text-overflow: ellipsis;">
                <?php echo isset($_SESSION['nome']) ? htmlspecialchars($_SESSION['nome']) : 'Usuário'; ?>
            </h4>
            <p style="font-size: 12px; color: var(--text-muted, #94A3B8); margin: 0; white-space: nowrap; text-overflow: ellipsis;">
                <?php echo isset($_SESSION['nivel']) ? htmlspecialchars($_SESSION['nivel']) : 'Padrão'; ?>
            </p>
        </div>
        <!-- BOTÃO DE LOGOUT -->
        <a href="<?= $base_url ?>/logout.php" style="color: var(--status-red, #EF4444); text-decoration: none; padding: 8px; transition: all 0.2s ease; display: flex; align-items: center; justify-content: center; border-radius: 8px; background: rgba(239, 68, 68, 0.1);" title="Sair do Sistema" onmouseover="this.style.background='rgba(239, 68, 68, 0.2)'" onmouseout="this.style.background='rgba(239, 68, 68, 0.1)'">
            <i class="ph ph-sign-out" style="font-size: 18px;"></i>
        </a>
    </div>
</aside>

<style>
    .nav-item:hover { background-color: rgba(59, 130, 246, 0.1) !important; color: #3B82F6 !important; }
    .nav-item:hover i { color: #3B82F6 !important; }
</style>