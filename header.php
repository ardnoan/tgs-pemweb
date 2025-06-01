<?php
session_start();
$Email = $_SESSION['Email'];
$title = "Toko 1234";
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome -->
  <title><?php echo $title; ?></title>
  <style>
    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      background-image: url('background.jpg');
      /* Ganti dengan path gambar latar Anda */
      background-size: cover;
      background-repeat: no-repeat;
      background-attachment: fixed;
    }

    .container-fluid {
      flex: 1;
      background-color: rgba(255, 255, 255, 0.8);
      /* Memberikan efek transparan pada latar konten */
    }

    .sidebar {
      height: 100%;
      border-right: 1px solid #ddd;
      padding-right: 10px;
      margin-top: 20px;
      /* Menambahkan margin atas untuk memberikan ruang ekstra */
    }

    .content {
      padding: 20px;
    }

    .footer {
      background-color: #f8f9fa;
      text-align: center;
      padding: 10px;
      border-top: 1px solid #ddd;
    }

    .accordion-button {
      width: 100%;
      text-align: left;
      padding: 10px;
      background-color: #007bff;
      color: white;
      border: none;
    }

    .accordion-button:hover,
    .accordion-button:focus {
      background-color: #0056b3;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: left;
      background-color: rgba(0, 123, 255, 0.7);
      /* Transparansi dengan warna dasar biru */
      color: white;
      padding: 10px 20px;
    }

    .header img {
      max-height: 75px;
    }

    .profile {
      display: flex;
      align-items: center;
    }

    .profile img {
      border-radius: 50%;
      max-height: 40px;
      margin-right: 10px;
    }

    .profile span {
      color: white;
    }

    .box {
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 10px;
      background-color: #fff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      text-align: center;
      margin-bottom: 20px;
    }

    .box h3 {
      margin: 0;
      font-size: 20px;
    }

    .box p {
      margin: 5px 0 0;
      font-size: 24px;
      font-weight: bold;
      color: #007BFF;
    }
  </style>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
  <header class="header">
    <img src="logo.png" alt="Logo">
    <h2 style="line-height: 5rem"><?php echo $title; ?></h2>
    <div class="profile">
      <img src="profile.png" alt="Profile Picture">
      <span><?php echo $Email; ?></span>
    </div>
  </header>
</body>