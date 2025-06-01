<?php
$current_page = basename($_SERVER['PHP_SELF']);
$current_table = $_GET['table'] ?? '';

// Define menu items with proper structure
$menu_items = [
    'dashboard' => [
        'title' => 'Dashboard',
        'icon' => 'fas fa-tachometer-alt',
        'url' => 'content.php',
        'active' => $current_page === 'content.php'
    ],
    'master' => [
        'title' => 'Master Data',
        'icon' => 'fas fa-database',
        'submenu' => [
            [
                'title' => 'Barang',
                'icon' => 'fas fa-box',
                'url' => 'list.php?table=barang',
                'active' => $current_table === 'barang'
            ],
            [
                'title' => 'Jenis',
                'icon' => 'fas fa-tags',
                'url' => 'list.php?table=jenis',
                'active' => $current_table === 'jenis'
            ],
            [
                'title' => 'Pelanggan',
                'icon' => 'fas fa-users',
                'url' => 'list.php?table=pelanggan',
                'active' => $current_table === 'pelanggan'
            ],
            [
                'title' => 'Supplier',
                'icon' => 'fas fa-truck',
                'url' => 'list.php?table=supplier',
                'active' => $current_table === 'supplier'
            ]
        ]
    ],
    'transaction' => [
        'title' => 'Transaksi',
        'icon' => 'fas fa-exchange-alt',
        'submenu' => [
            [
                'title' => 'Pembelian',
                'icon' => 'fas fa-shopping-basket',
                'url' => 'list.php?table=pembelian',
                'active' => $current_table === 'pembelian'
            ],
            [
                'title' => 'Penjualan',
                'icon' => 'fas fa-shopping-cart',
                'url' => 'list.php?table=penjualan',
                'active' => $current_table === 'penjualan'
            ]
        ]
    ],
    'reports' => [
        'title' => 'Laporan',
        'icon' => 'fas fa-chart-bar',
        'submenu' => [
            [
                'title' => 'Laporan Pembelian',
                'icon' => 'fas fa-file-invoice',
                'url' => 'laporan_pembelian.php',
                'active' => $current_page === 'laporan_pembelian.php'
            ],
            [
                'title' => 'Laporan Penjualan',
                'icon' => 'fas fa-file-alt',
                'url' => 'laporan_penjualan.php',
                'active' => $current_page === 'laporan_penjualan.php'
            ]
        ]
    ],
    'settings' => [
        'title' => 'Pengaturan',
        'icon' => 'fas fa-cogs',
        'submenu' => [
            [
                'title' => 'User Management',
                'icon' => 'fas fa-user-cog',
                'url' => 'list.php?table=user',
                'active' => $current_table === 'user'
            ]
        ]
    ]
];

// Check if any submenu is active
foreach ($menu_items as $key => &$item) {
    if (isset($item['submenu'])) {
        $item['has_active'] = false;
        foreach ($item['submenu'] as $subitem) {
            if ($subitem['active']) {
                $item['has_active'] = true;
                break;
            }
        }
    }
}
?>

<style>
/* Enhanced Sidebar Styles */
.modern-sidebar {
    background: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);
    border-radius: 15px;
    padding: 0;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    overflow: hidden;
    position: sticky;
    top: 20px;
    max-height: calc(100vh - 40px);
}

.sidebar-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 20px;
    text-align: center;
    color: white;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.sidebar-header h5 {
    margin: 0;
    font-weight: 700;
    font-size: 18px;
    letter-spacing: 0.5px;
}

.sidebar-menu {
    padding: 15px 0;
    max-height: calc(100vh - 150px);
    overflow-y: auto;
}

.sidebar-menu::-webkit-scrollbar {
    width: 4px;
}

.sidebar-menu::-webkit-scrollbar-track {
    background: rgba(255,255,255,0.1);
}

.sidebar-menu::-webkit-scrollbar-thumb {
    background: rgba(255,255,255,0.3);
    border-radius: 2px;
}

.menu-item {
    margin: 0 10px 5px 10px;
}

.menu-link {
    display: flex;
    align-items: center;
    padding: 12px 15px;
    color: #bdc3c7;
    text-decoration: none;
    border-radius: 10px;
    transition: all 0.3s ease;
    font-weight: 500;
    position: relative;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
}

.menu-link:hover {
    background: rgba(255,255,255,0.1);
    color: white;
    transform: translateX(5px);
    text-decoration: none;
}

.menu-link.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
}

.menu-link.has-active {
    background: rgba(102, 126, 234, 0.2);
    color: #667eea;
}

.menu-icon {
    width: 20px;
    text-align: center;
    margin-right: 12px;
    font-size: 16px;
}

.menu-text {
    flex: 1;
    font-size: 14px;
}

.menu-arrow {
    font-size: 12px;
    transition: transform 0.3s ease;
}

.menu-arrow.rotated {
    transform: rotate(90deg);
}

.submenu {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
    background: rgba(0,0,0,0.1);
    border-radius: 8px;
    margin: 5px 10px;
}

.submenu.show {
    max-height: 300px;
    padding: 10px 0;
}

.submenu-item {
    display: flex;
    align-items: center;
    padding: 10px 20px 10px 45px;
    color: #95a5a6;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 13px;
    position: relative;
}

.submenu-item:hover {
    background: rgba(255,255,255,0.05);
    color: white;
    text-decoration: none;
    padding-left: 50px;
}

.submenu-item.active {
    background: rgba(102, 126, 234, 0.3);
    color: #667eea;
    border-left: 3px solid #667eea;
}

.submenu-item .menu-icon {
    width: 16px;
    margin-right: 10px;
    font-size: 12px;
}

.logout-section {
    border-top: 1px solid rgba(255,255,255,0.1);
    padding: 15px 10px 10px 10px;
    margin-top: auto;
}

.logout-link {
    display: flex;
    align-items: center;
    padding: 12px 15px;
    color: #e74c3c;
    text-decoration: none;
    border-radius: 10px;
    transition: all 0.3s ease;
    font-weight: 500;
    background: rgba(231, 76, 60, 0.1);
}

.logout-link:hover {
    background: #e74c3c;
    color: white;
    text-decoration: none;
    transform: translateX(5px);
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .modern-sidebar {
        position: static;
        margin-bottom: 20px;
        max-height: none;
    }
    
    .sidebar-menu {
        max-height: none;
    }
    
    .menu-text {
        font-size: 13px;
    }
}

/* Animation for menu items */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.menu-item {
    animation: slideIn 0.3s ease;
}

.menu-item:nth-child(1) { animation-delay: 0.1s; }
.menu-item:nth-child(2) { animation-delay: 0.2s; }
.menu-item:nth-child(3) { animation-delay: 0.3s; }
.menu-item:nth-child(4) { animation-delay: 0.4s; }
.menu-item:nth-child(5) { animation-delay: 0.5s; }
.menu-item:nth-child(6) { animation-delay: 0.6s; }
</style>

<div class="modern-sidebar">
    <!-- Sidebar Header -->
    <div class="sidebar-header">
        <h5><i class="fas fa-store"></i> TOKO 123</h5>
        <small>Management System</small>
    </div>
    
    <!-- Sidebar Menu -->
    <div class="sidebar-menu">
        <?php foreach ($menu_items as $key => $item): ?>
            <div class="menu-item">
                <?php if (isset($item['submenu'])): ?>
                    <!-- Menu with Submenu -->
                    <button class="menu-link <?= $item['has_active'] ? 'has-active' : '' ?>" 
                            onclick="toggleSubmenu('<?= $key ?>')">
                        <i class="menu-icon <?= $item['icon'] ?>"></i>
                        <span class="menu-text"><?= $item['title'] ?></span>
                        <i class="menu-arrow fas fa-chevron-right" id="arrow-<?= $key ?>"></i>
                    </button>
                    
                    <div class="submenu <?= $item['has_active'] ? 'show' : '' ?>" id="submenu-<?= $key ?>">
                        <?php foreach ($item['submenu'] as $subitem): ?>
                            <a href="<?= $subitem['url'] ?>" 
                               class="submenu-item <?= $subitem['active'] ? 'active' : '' ?>">
                                <i class="menu-icon <?= $subitem['icon'] ?>"></i>
                                <span><?= $subitem['title'] ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <!-- Direct Menu Link -->
                    <a href="<?= $item['url'] ?>" 
                       class="menu-link <?= $item['active'] ? 'active' : '' ?>">
                        <i class="menu-icon <?= $item['icon'] ?>"></i>
                        <span class="menu-text"><?= $item['title'] ?></span>
                    </a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
    
    <!-- Logout Section -->
    <div class="logout-section">
        <a href="logout.php" class="logout-link" onclick="return confirm('Apakah Anda yakin ingin logout?')">
            <i class="menu-icon fas fa-sign-out-alt"></i>
            <span class="menu-text">Logout</span>
        </a>
    </div>
</div>

<script>
function toggleSubmenu(menuKey) {
    const submenu = document.getElementById('submenu-' + menuKey);
    const arrow = document.getElementById('arrow-' + menuKey);
    
    if (submenu.classList.contains('show')) {
        submenu.classList.remove('show');
        arrow.classList.remove('rotated');
    } else {
        // Close all other submenus
        document.querySelectorAll('.submenu').forEach(sub => {
            sub.classList.remove('show');
        });
        document.querySelectorAll('.menu-arrow').forEach(arr => {
            arr.classList.remove('rotated');
        });
        
        // Open current submenu
        submenu.classList.add('show');
        arrow.classList.add('rotated');
    }
}

// Initialize submenus state on page load
document.addEventListener('DOMContentLoaded', function() {
    // Auto-expand active submenus
    document.querySelectorAll('.submenu.show').forEach(submenu => {
        const menuKey = submenu.id.replace('submenu-', '');
        const arrow = document.getElementById('arrow-' + menuKey);
        if (arrow) {
            arrow.classList.add('rotated');
        }
    });
    
    // Add smooth scrolling to active menu item
    const activeItem = document.querySelector('.menu-link.active, .submenu-item.active');
    if (activeItem) {
        activeItem.scrollIntoView({ 
            behavior: 'smooth', 
            block: 'nearest' 
        });
    }
});

// Add ripple effect to menu items
document.querySelectorAll('.menu-link, .submenu-item').forEach(item => {
    item.addEventListener('click', function(e) {
        const ripple = document.createElement('span');
        const rect = this.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;
        
        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        ripple.classList.add('ripple');
        
        this.appendChild(ripple);
        
        setTimeout(() => {
            ripple.remove();
        }, 600);
    });
});
</script>

<style>
/* Ripple effect */
.ripple {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: scale(0);
    animation: ripple-animation 0.6s linear;
    pointer-events: none;
}

@keyframes ripple-animation {
    to {
        transform: scale(4);
        opacity: 0;
    }
}

.menu-link, .submenu-item {
    position: relative;
    overflow: hidden;
}
</style>