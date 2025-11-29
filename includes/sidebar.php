<?php
// Make sure session is started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Determine current page
$current_page = basename($_SERVER['PHP_SELF']);

// Determine base path based on current location
$base_path = '';
if (strpos($_SERVER['PHP_SELF'], '/site/') !== false) {
    $base_path = '../';
} elseif (strpos($_SERVER['PHP_SELF'], '/usuario/') !== false || 
          strpos($_SERVER['PHP_SELF'], '/vaga/') !== false || 
          strpos($_SERVER['PHP_SELF'], '/categoria/') !== false || 
          strpos($_SERVER['PHP_SELF'], '/admin/') !== false) {
    $base_path = '../';
}
?>

<!-- Sidebar Toggle for Mobile -->
<button class="sidebar-toggle" onclick="toggleSidebar()">☰</button>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="<?=$base_path?>site/index.php" class="sidebar-logo">Portal de Vagas</a>
    </div>
    
    <nav class="sidebar-nav">
        <?php if(isset($_SESSION["login"])): ?>
            <!-- User Navigation -->
            <a href="<?=$base_path?>site/index.php" class="<?=$current_page == 'index.php' ? 'active' : ''?>">
                📋 Vagas Disponíveis
            </a>
            <a href="<?=$base_path?>usuario/minhasCandidaturas.php" class="<?=$current_page == 'minhasCandidaturas.php' ? 'active' : ''?>">
                📝 Minhas Candidaturas
            </a>
        <?php elseif(isset($_SESSION["admin"])): ?>
            <!-- Admin Navigation -->
            <a href="<?=$base_path?>vaga/listar.php" class="<?=$current_page == 'listar.php' && strpos($_SERVER['PHP_SELF'], 'vaga') !== false ? 'active' : ''?>">
                📋 Gerenciar Vagas
            </a>
            <a href="<?=$base_path?>categoria/listar.php" class="<?=$current_page == 'listar.php' && strpos($_SERVER['PHP_SELF'], 'categoria') !== false ? 'active' : ''?>">
                🏷️ Categorias
            </a>
        <?php else: ?>
            <!-- Guest Navigation -->
            <a href="<?=$base_path?>site/index.php" class="<?=$current_page == 'index.php' ? 'active' : ''?>">
                📋 Vagas Disponíveis
            </a>
        <?php endif; ?>
        
        <?php if(!isset($_SESSION["login"]) && !isset($_SESSION["admin"])): ?>
            <div style="border-top: 1px solid #2d2438; margin: 20px 0; padding-top: 20px;">
                <a href="<?=$base_path?>site/login.php">🔐 Login</a>
                <a href="<?=$base_path?>site/cadastro.php">📝 Cadastrar</a>
            </div>
        <?php endif; ?>
    </nav>
    
    <?php if(!isset($_SESSION["admin"])): ?>
        <div class="sidebar-footer">
            <a href="<?=$base_path?>admin/login.php">🔒 Área Admin</a>
        </div>
    <?php endif; ?>
</div>

<!-- Overlay for mobile -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<!-- Topbar with User Menu -->
<div class="topbar">
    <?php if(isset($_SESSION["login"])): ?>
        <!-- User Menu -->
        <div class="user-menu">
            <button class="user-menu-toggle" onclick="toggleUserMenu()">
                <?php
                // Adjust path for UsuarioDAO
                $dao_path = $base_path . 'class/usuarioDAO.class.php';
                if (file_exists($dao_path)) {
                    include_once $dao_path;
                    $objUsuarioDAO = new UsuarioDAO();
                    $usuario = $objUsuarioDAO->buscarPorId($_SESSION["id"]);
                ?>
                    <?php if($usuario["imagem"]): ?>
                        <img src="<?=$base_path?>img/<?=$usuario["imagem"]?>" alt="Foto" class="user-avatar">
                    <?php else: ?>
                        <img src="https://via.placeholder.com/40" alt="Foto" class="user-avatar">
                    <?php endif; ?>
                <?php } else { ?>
                    <img src="https://via.placeholder.com/40" alt="Foto" class="user-avatar">
                <?php } ?>
                <span class="user-name"><?=$_SESSION["nome"]?></span>
                <span>▼</span>
            </button>
            
            <div class="user-dropdown" id="userDropdown">
                <a href="<?=$base_path?>usuario/perfil.php">👤 Ver Perfil</a>
                <div class="divider"></div>
                <a href="<?=$base_path?>site/logout.php">🚪 Sair</a>
            </div>
        </div>
    <?php elseif(isset($_SESSION["admin"])): ?>
        <!-- Admin Menu -->
        <div class="user-menu">
            <button class="user-menu-toggle" onclick="toggleUserMenu()">
                <div class="user-avatar" style="background: #504988; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                    A
                </div>
                <span class="user-name"><?=$_SESSION["admin_nome"]?></span>
                <span>▼</span>
            </button>
            
            <div class="user-dropdown" id="userDropdown">
                <a href="<?=$base_path?>admin/logout.php">🚪 Sair</a>
            </div>
        </div>
    <?php else: ?>
        <!-- Guest Buttons -->
        <div class="guest-buttons">
            <a href="<?=$base_path?>site/login.php" class="btn">Login</a>
            <a href="<?=$base_path?>site/cadastro.php" class="btn btn-success">Cadastre-se</a>
        </div>
    <?php endif; ?>
</div>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    sidebar.classList.toggle('show');
    overlay.classList.toggle('show');
}

function toggleUserMenu() {
    const dropdown = document.getElementById('userDropdown');
    dropdown.classList.toggle('show');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const userMenu = document.querySelector('.user-menu');
    const dropdown = document.getElementById('userDropdown');
    
    if (userMenu && dropdown && !userMenu.contains(event.target)) {
        dropdown.classList.remove('show');
    }
});
</script>