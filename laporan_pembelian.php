<?php
include("header.php");
require 'db.php';
echo '<div class="container-fluid">';
echo '<div class="row">';
echo '<nav class="col-md-2 sidebar">';
include("menu.php");
echo '</nav>';
echo '<main class="col-md-10 content">';
echo '<div class="card">';
echo '<div class="card-header">Laporan Pembelian</div>';
echo '<div class="card-body">';
// Form untuk filter laporan berdasarkan tanggal
echo '<form method="post" class="mb-4">';
echo '<div class="form-row">';
echo '<div class="col">';
echo '<input type="date" name="start_date" class="form-control" placeholder="Start Date">';
echo '</div>';
echo '<div class="col">';
echo '<input type="date" name="end_date" class="form-control" placeholder="End Date">';
echo '</div>';
echo '<div class="col">';
echo '<button type="submit" class="btn btn-primary">Filter</button>';
echo '</div>';
echo '</div>';
echo '</form>';
// Filter berdasarkan tanggal
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '1970-01-01';
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : date('Y-m-d');
// Query untuk mengambil data pembelian
$sql = "SELECT pembelian.Kode_Pembelian, pembelian.Tanggal, supplier.Nama AS 
Nama_Supplier, barang.Nama AS Nama_Barang, pembelian.Jumlah, pembelian.Total_Harga
        FROM pembelian
        JOIN supplier ON pembelian.Kode_Supplier = supplier.Kode_Supplier
        JOIN barang ON pembelian.Kode_Barang = barang.Kode
        WHERE pembelian.Tanggal BETWEEN :start_date AND :end_date";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':start_date', $start_date);
$stmt->bindValue(':end_date', $end_date);
$stmt->execute();
$purchases = $stmt->fetchAll(PDO::FETCH_ASSOC);
if ($purchases) {
  echo '<div class="table-responsive">';
  echo '<table class="table table-bordered table-striped">';
  echo '<thead class="thead-dark">';
  echo '<tr>';
  echo '<th scope="col">Kode Pembelian</th>';
  echo '<th scope="col">Tanggal</th>';
  echo '<th scope="col">Nama Supplier</th>';
  echo '<th scope="col">Nama Barang</th>';
  echo '<th scope="col">Jumlah</th>';
  echo '<th scope="col">Total Harga</th>';
  echo '</tr>';
  echo '</thead>';
  echo '<tbody>';
  foreach ($purchases as $purchase) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($purchase['Kode_Pembelian']) . '</td>';
    echo '<td>' . htmlspecialchars($purchase['Tanggal']) . '</td>';
    echo '<td>' . htmlspecialchars($purchase['Nama_Supplier']) . '</td>';
    echo '<td>' . htmlspecialchars($purchase['Nama_Barang']) . '</td>';
    echo '<td>' . htmlspecialchars($purchase['Jumlah']) . '</td>';
    echo '<td>' . htmlspecialchars($purchase['Total_Harga']) . '</td>';
    echo '</tr>';
  }
  echo '</tbody>';
  echo '</table>';
  echo '</div>';
} else {
  echo '<div class="alert alert-warning">No purchases found for the selected date range.</div>';
}
echo '</div>';
echo '</div>';
echo '</main>';
echo '</div>';
echo '</div>';
include("footer.php");
