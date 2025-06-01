 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome -->
 <div id="accordion">
   <button class="accordion-button" type="button" data-toggle="collapse" data
     target="#menu0" aria-expanded="true" aria-controls="menu0">
     <a href="content.php" style="text-decoration:none">
       <font color=white><i class="fas fa-tachometer-alt"></i> Dashboard</font>
     </a>
   </button>
   <button class="accordion-button" type="button" data-toggle="collapse" data
     target="#menu1" aria-expanded="true" aria-controls="menu1">
     <i class="fas fa-database"></i> Master
   </button>
   <div id="menu1" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
     <div class="card-body">
       <ul class="list-unstyled">
         <li><a href="list.php?table=barang" class="text-dark" style="text-decoration:none"><i
               class="fas fa-box"></i> Barang</a></li>
         <li><a href="list.php?table=jenis" class="text-dark" style="text-decoration:none"><i
               class="fas fa-tags"></i> Jenis</a></li>
         <li><a href="list.php?table=pelanggan" class="text-dark"
             style="text-decoration:none"><i class="fas fa-users"></i> Pelanggan</a></li>
         <li><a href="list.php?table=supplier" class="text-dark" style="text-decoration:none"><i class="fas fa-truck"></i> Supplier</a></li>
       </ul>
     </div>
   </div>
   <button class="accordion-button" type="button" data-toggle="collapse" data
     target="#menu2" aria-expanded="false" aria-controls="menu2">
     <i class="fas fa-exchange-alt"></i> Transaksi
   </button>
   <div id="menu2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
     <div class="card-body">
       <ul class="list-unstyled">
         <li><a href="list.php?table=pembelian" class="text-dark" style="text-decoration:none"><i class="fas fa-shopping-basket"></i> Pembelian</a></li>
         <li><a href="list.php?table=penjualan" class="text-dark" style="text-decoration:none"><i class="fas fa-shopping-cart"></i> Penjualan</a></li>
       </ul>
     </div>
   </div>

   <button class="accordion-button" type="button" data-toggle="collapse" data
     target="#menu3" aria-expanded="true" aria-controls="menu3">
     <i class="fas fa-file-alt"></i> Laporan
   </button>
   <div id="menu3" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
     <div class="card-body">
       <ul class="list-unstyled">
         <li><a href="laporan_pembelian.php" class="text-dark" style="text-decoration:none"><i class="fas fa-file-alt"></i> Pembelian</a></li>
       </ul>
       <ul class="list-unstyled">
         <li><a href="laporan_penjualan.php" class="text-dark" style="text-decoration:none"><i
               class="fas fa-file-alt"></i> Penjualan</a></li>
       </ul>
     </div>
   </div>
   <button class="accordion-button" type="button" data-toggle="collapse" data
     target="#menu4" aria-expanded="true" aria-controls="menu4">
     <i class="fas fa-cog"></i> Setting
   </button>
   <div id="menu4" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
     <div class="card-body">
       <ul class="list-unstyled">
         <li><a href="list.php?table=user" class="text-dark" style="text-decoration:none"><i
               class="fas fa-user"></i> User</a></li>
       </ul>
     </div>
   </div>

   <button class="accordion-button" type="button" data-toggle="collapse" data
     target="#menu5" aria-expanded="true" aria-controls="menu5">
     <a href="logout.php" style="text-decoration:none">
       <font color=white><i class="fas fa-sign out-alt"></i> Logout</font>
     </a>
   </button>
 </div>