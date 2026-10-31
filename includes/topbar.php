<!-- /includes/topbar.php -->
<header class="topbar">
    <div class="topbar-left">
        <button class="menu-toggle"><i class="ph ph-list" style="font-size: 24px; color: var(--text-main);"></i></button>
        <!-- O título específico da página (ex: "Dashboard" ou "Cadastro de Equipamento") será colocado na própria página, logo abaixo disto -->
    </div>

    <div class="topbar-right">
        <div class="user-profile">
            <!-- Puxa a foto do utilizador logado, ou usa uma padrão se não houver -->
            <div class="avatar">
                <i class="ph-fill ph-user-circle" style="font-size: 32px; color: var(--text-muted);"></i>
            </div>
            <div class="user-info">
                <span class="user-name"><?php echo $_SESSION['nome'] ?? 'Administrador'; ?></span>
                <span class="user-role"><?php echo $_SESSION['cargo'] ?? 'admin'; ?></span>
            </div>
            <i class="ph ph-caret-down" style="color: var(--text-muted); margin-left: 8px;"></i>
        </div>
    </div>
</header>