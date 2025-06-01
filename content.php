<?php
include('db.php');

// Fungsi untuk mengambil jumlah record dari tabel
function getRecordCount($conn, $tableName) {
    try {
        $query = "SELECT COUNT(*) as count FROM $tableName";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    } catch (PDOException $e) {
        return 0;
    }
}

// Fungsi untuk mengambil data chart penjualan/pembelian bulanan
function getMonthlyData($conn, $table, $dateColumn = 'tanggal') {
    try {
        $query = "SELECT 
                    MONTH($dateColumn) as month,
                    YEAR($dateColumn) as year,
                    COUNT(*) as count 
                  FROM $table 
                  WHERE YEAR($dateColumn) = YEAR(CURDATE())
                  GROUP BY YEAR($dateColumn), MONTH($dateColumn)
                  ORDER BY month";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

// Konfigurasi tabel dengan icon dan warna
$tableConfig = [
    'jenis' => [
        'title' => 'Jenis Barang',
        'icon' => 'fas fa-tags',
        'color' => '#667eea',
        'gradient' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)'
    ],
    'barang' => [
        'title' => 'Data Barang',
        'icon' => 'fas fa-box',
        'color' => '#f093fb',
        'gradient' => 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)'
    ],
    'user' => [
        'title' => 'Pengguna',
        'icon' => 'fas fa-users',
        'color' => '#4facfe',
        'gradient' => 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)'
    ],
    'pelanggan' => [
        'title' => 'Pelanggan',
        'icon' => 'fas fa-user-friends',
        'color' => '#43e97b',
        'gradient' => 'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)'
    ],
    'supplier' => [
        'title' => 'Supplier',
        'icon' => 'fas fa-truck',
        'color' => '#fa709a',
        'gradient' => 'linear-gradient(135deg, #fa709a 0%, #fee140 100%)'
    ],
    'pembelian' => [
        'title' => 'Pembelian',
        'icon' => 'fas fa-shopping-basket',
        'color' => '#a8edea',
        'gradient' => 'linear-gradient(135deg, #a8edea 0%, #fed6e3 100%)'
    ],
    'penjualan' => [
        'title' => 'Penjualan',
        'icon' => 'fas fa-shopping-cart',
        'color' => '#ffecd2',
        'gradient' => 'linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%)'
    ]
];

// Ambil data untuk semua tabel
$data = [];
foreach (array_keys($tableConfig) as $table) {
    $data[$table] = getRecordCount($conn, $table);
}

// Ambil data untuk chart bulanan
$monthlyPenjualan = getMonthlyData($conn, 'penjualan');
$monthlyPembelian = getMonthlyData($conn, 'pembelian');

include("header.php");
?>

<style>
/* Enhanced Dashboard Styles */
.dashboard-container {
    background: transparent;
    min-height: calc(100vh - 120px);
}

.dashboard-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 30px;
    border-radius: 20px;
    margin-bottom: 30px;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    position: relative;
    overflow: hidden;
}

.dashboard-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    animation: pulse 4s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); opacity: 0.5; }
    50% { transform: scale(1.1); opacity: 0.8; }
}

.dashboard-header h1 {
    margin: 0;
    font-size: 2.5rem;
    font-weight: 700;
    position: relative;
    z-index: 1;
}

.dashboard-header p {
    margin: 10px 0 0 0;
    font-size: 1.1rem;
    opacity: 0.9;
    position: relative;
    z-index: 1;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 25px;
    margin-bottom: 40px;
}

.stat-card {
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    border: none;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--card-gradient);
}

.stat-card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.stat-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: white;
    background: var(--card-gradient);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.stat-title {
    font-size: 16px;
    color: #64748b;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin: 0;
}

.stat-value {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
    line-height: 1;
}

.stat-trend {
    font-size: 14px;
    color: #10b981;
    margin-top: 8px;
    display: flex;
    align-items: center;
    gap: 5px;
}

.charts-section {
    background: white;
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}

.chart-header {
    text-align: center;
    margin-bottom: 40px;
}

.chart-header h2 {
    font-size: 2rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 10px;
}

.chart-header p {
    color: #64748b;
    font-size: 1.1rem;
    margin: 0;
}

.chart-container {
    position: relative;
    height: 400px;
    margin-bottom: 30px;
}

.chart-tabs {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-bottom: 30px;
}

.chart-tab {
    padding: 12px 24px;
    background: #f1f5f9;
    border: none;
    border-radius: 25px;
    color: #64748b;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.chart-tab.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
}

.chart-tab:hover:not(.active) {
    background: #e2e8f0;
    color: #475569;
}

/* Animation for stat cards */
.stat-card {
    animation: slideUp 0.6s ease-out;
}

.stat-card:nth-child(1) { animation-delay: 0.1s; }
.stat-card:nth-child(2) { animation-delay: 0.2s; }
.stat-card:nth-child(3) { animation-delay: 0.3s; }
.stat-card:nth-child(4) { animation-delay: 0.4s; }
.stat-card:nth-child(5) { animation-delay: 0.5s; }
.stat-card:nth-child(6) { animation-delay: 0.6s; }
.stat-card:nth-child(7) { animation-delay: 0.7s; }

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Loading state */
.loading-card {
    background: #f8fafc;
    border-radius: 20px;
    padding: 30px;
    text-align: center;
    color: #64748b;
}

.loading-spinner {
    width: 40px;
    height: 40px;
    border: 4px solid #e2e8f0;
    border-top: 4px solid #667eea;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto 20px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Responsive design */
@media (max-width: 768px) {
    .dashboard-header {
        padding: 20px;
        text-align: center;
    }
    
    .dashboard-header h1 {
        font-size: 2rem;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .stat-card {
        padding: 20px;
    }
    
    .charts-section {
        padding: 20px;
    }
    
    .chart-container {
        height: 300px;
    }
    
    .chart-tabs {
        flex-direction: column;
        align-items: center;
    }
}

/* Quick actions section */
.quick-actions {
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}

.quick-actions h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 20px;
    text-align: center;
}

.action-buttons {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
}

.action-btn {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 15px 20px;
    background: white;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    text-decoration: none;
    color: #475569;
    font-weight: 600;
    transition: all 0.3s ease;
}

.action-btn:hover {
    border-color: #667eea;
    color: #667eea;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.2);
    text-decoration: none;
}

.action-btn i {
    font-size: 18px;
}
</style>

<div class="container-fluid dashboard-container">
    <div class="row">
        <nav class="col-md-2 sidebar">
            <?php include("menu.php"); ?>
        </nav>
        
        <main class="col-md-10">
            <!-- Dashboard Header -->
            <div class="dashboard-header">
                <h1><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
                <p>Selamat datang di sistem manajemen Toko 123. Pantau performa bisnis Anda dengan mudah.</p>
            </div>
            
            <!-- Statistics Grid -->
            <div class="stats-grid">
                <?php foreach ($tableConfig as $table => $config): ?>
                    <div class="stat-card" style="--card-gradient: <?php echo $config['gradient']; ?>">
                        <div class="stat-card-header">
                            <div>
                                <h3 class="stat-title"><?php echo $config['title']; ?></h3>
                                <p class="stat-value" id="count-<?php echo $table; ?>"><?php echo number_format($data[$table]); ?></p>
                                <div class="stat-trend">
                                    <i class="fas fa-arrow-up"></i>
                                    <span>Data tersedia</span>
                                </div>
                            </div>
                            <div class="stat-icon">
                                <i class="<?php echo $config['icon']; ?>"></i>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Quick Actions -->
            <div class="quick-actions">
                <h3><i class="fas fa-bolt"></i> Aksi Cepat</h3>
                <div class="action-buttons">
                    <a href="list.php?table=barang" class="action-btn">
                        <i class="fas fa-plus-circle"></i>
                        <span>Tambah Barang</span>
                    </a>
                    <a href="list.php?table=penjualan" class="action-btn">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Transaksi Penjualan</span>
                    </a>
                    <a href="list.php?table=pembelian" class="action-btn">
                        <i class="fas fa-shopping-basket"></i>
                        <span>Transaksi Pembelian</span>
                    </a>
                    <a href="laporan_penjualan.php" class="action-btn">
                        <i class="fas fa-chart-line"></i>
                        <span>Laporan Penjualan</span>
                    </a>
                </div>
            </div>
            
            <!-- Charts Section -->
            <div class="charts-section">
                <div class="chart-header">
                    <h2><i class="fas fa-chart-bar"></i> Analisis Data</h2>
                    <p>Visualisasi data untuk membantu pengambilan keputusan bisnis</p>
                </div>
                
                <div class="chart-tabs">
                    <button class="chart-tab active" onclick="showChart('overview')">Overview</button>
                    <button class="chart-tab" onclick="showChart('monthly')">Bulanan</button>
                    <button class="chart-tab" onclick="showChart('comparison')">Perbandingan</button>
                </div>
                
                <div class="chart-container">
                    <canvas id="mainChart"></canvas>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
// Chart configuration
let currentChart = null;
const chartData = {
    overview: {
        labels: <?php echo json_encode(array_map(function($config) { return $config['title']; }, $tableConfig)); ?>,
        datasets: [{
            label: 'Jumlah Data',
            data: <?php echo json_encode(array_values($data)); ?>,
            backgroundColor: [
                'rgba(102, 126, 234, 0.8)',
                'rgba(240, 147, 251, 0.8)',
                'rgba(79, 172, 254, 0.8)',
                'rgba(67, 233, 123, 0.8)',
                'rgba(250, 112, 154, 0.8)',
                'rgba(168, 237, 234, 0.8)',
                'rgba(255, 236, 210, 0.8)'
            ],
            borderColor: [
                'rgba(102, 126, 234, 1)',
                'rgba(240, 147, 251, 1)',
                'rgba(79, 172, 254, 1)',
                'rgba(67, 233, 123, 1)',
                'rgba(250, 112, 154, 1)',
                'rgba(168, 237, 234, 1)',
                'rgba(255, 236, 210, 1)'
            ],
            borderWidth: 2,
            borderRadius: 8,
            borderSkipped: false
        }]
    },
    monthly: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        datasets: [
            {
                label: 'Penjualan',
                data: new Array(12).fill(0),
                backgroundColor: 'rgba(102, 126, 234, 0.2)',
                borderColor: 'rgba(102, 126, 234, 1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            },
            {
                label: 'Pembelian',
                data: new Array(12).fill(0),
                backgroundColor: 'rgba(240, 147, 251, 0.2)',
                borderColor: 'rgba(240, 147, 251, 1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }
        ]
    }
};

// Process monthly data
<?php if (!empty($monthlyPenjualan)): ?>
    <?php foreach ($monthlyPenjualan as $item): ?>
        chartData.monthly.datasets[0].data[<?php echo $item['month'] - 1; ?>] = <?php echo $item['count']; ?>;
    <?php endforeach; ?>
<?php endif; ?>

<?php if (!empty($monthlyPembelian)): ?>
    <?php foreach ($monthlyPembelian as $item): ?>
        chartData.monthly.datasets[1].data[<?php echo $item['month'] - 1; ?>] = <?php echo $item['count']; ?>;
    <?php endforeach; ?>
<?php endif; ?>

// Chart initialization
function initChart() {
    const ctx = document.getElementById('mainChart').getContext('2d');
    
    currentChart = new Chart(ctx, {
        type: 'bar',
        data: chartData.overview,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: {
                            size: 12,
                            weight: '600'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.95)',
                    titleColor: '#1e293b',
                    bodyColor: '#475569',
                    borderColor: '#e2e8f0',
                    borderWidth: 1,
                    cornerRadius: 8,
                    padding: 12
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false
                    },
                    ticks: {
                        color: '#64748b',
                        font: {
                            size: 11
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#64748b',
                        font: {
                            size: 11
                        }
                    }
                }
            },
            animation: {
                duration: 1000,
                easing: 'easeOutQuart'
            }
        }
    });
}

// Chart switching function
function showChart(type) {
    // Update active tab
    document.querySelectorAll('.chart-tab').forEach(tab => {
        tab.classList.remove('active');
    });
    event.target.classList.add('active');
    
    // Update chart
    if (currentChart) {
        currentChart.destroy();
    }
    
    const ctx = document.getElementById('mainChart').getContext('2d');
    
    let config = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
                position: 'top',
                labels: {
                    usePointStyle: true,
                    padding: 20,
                    font: {
                        size: 12,
                        weight: '600'
                    }
                }
            }
        },
        animation: {
            duration: 800,
            easing: 'easeOutQuart'
        }
    };
    
    if (type === 'monthly') {
        currentChart = new Chart(ctx, {
            type: 'line',
            data: chartData.monthly,
            options: {
                ...config,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    } else {
        currentChart = new Chart(ctx, {
            type: type === 'comparison' ? 'doughnut' : 'bar',
            data: chartData.overview,
            options: config
        });
    }
}

// Counter animation
function animateCounters() {
    document.querySelectorAll('[id^="count-"]').forEach(counter => {
        const target = parseInt(counter.textContent.replace(/,/g, ''));
        const increment = target / 100;
        let current = 0;
        
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                counter.textContent = target.toLocaleString();
                clearInterval(timer);
            } else {
                counter.textContent = Math.floor(current).toLocaleString();
            }
        }, 20);
    });
}

// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(() => {
        initChart();
        animateCounters();
    }, 500);
});

// Refresh data every 5 minutes
setInterval(() => {
    location.reload();
}, 300000);
</script>

<?php include("footer.php"); ?>