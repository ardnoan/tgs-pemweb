<?php
 include('db.php');
 // Fungsi untuk mengambil jumlah record dari tabel
 function getRecordCount($conn, $tableName) {
    $query = "SELECT COUNT(*) as count FROM $tableName";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'];
 }
 // Daftar tabel yang ingin Anda tampilkan jumlah recordnya
 $tables = ["jenis","barang","user","pelanggan","supplier","pembelian","penjualan"]; // ganti dengan nama tabel yang ada di database Anda
 $data = [];
 foreach ($tables as $table) {
    $data[$table] = getRecordCount($conn, $table);
 }
 ?>
 <?php include("header.php"); ?>
 <div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 sidebar">
            <?php include("menu.php"); ?>
        </nav>
        <main class="col-md-10 content">
            <div class="card">
                <div class="card-header">
                    Dashboard
                </div>
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <?php foreach ($data as $table => $count): ?>
                                <div class="col-md-4">
                                    <div class="box">
                                        <h3><?php echo htmlspecialchars($table); ?></h3>
                                        <p><?php echo htmlspecialchars($count); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <h2 class="text-center mt-5">Grafik Jumlah Record</h2>
                        <canvas id="recordChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </main>
    </div>
 </div>
 <?php include("footer.php"); ?>