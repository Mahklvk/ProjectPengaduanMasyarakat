<?php 
require "config/sessionLogin.php";
require('../config/db.php');

// Cek apakah ada pencarian
if (isset($_GET['search']) && $_GET['search'] != '') {
    $filtervalues = $_GET['search'];
    $query = "SELECT * FROM masyarakat WHERE CONCAT(nik,nama,username,telp) LIKE '%$filtervalues%' ";
    $result = mysqli_query($conn, $query);
} else {
    // Tidak ada pencarian, ambil semua data
    $query = "SELECT * FROM masyarakat";
    $result = mysqli_query($conn, $query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Akun - MyReport</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
  <style>
        .search-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .search-box {
            width: 800px;
            position: relative;
        }
        
        .search-box input {
            padding-left: 40px;
            border-radius: 20px;
        }
        
        .search-icon {
            position: absolute;
            left: 15px;
            top: 10px;
            color: #6c757d;
        }
        .btn-add-akun {
            position: fixed;
            bottom: 5rem;
            right: 4rem;
            background-color: #3E6EA2;
            border-color: #3E6EA2;
        }

        .page-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
                .content-container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
  </style>
</head>
<body>
  <?php include('config/navbar.php')?>
<div class="content-container">
  <h1 class="page-title">Daftar Akun</h1>

  <div class="row">
    <div class="col-md-8 col-sm-6 input-icons">
      <form action="" method="GET" role="search">
        <div class="search-container">
            <div class="search-box">
                <i class="fa fa-search search-icon"></i>
                <input type="text" class="form-control d-inline" placeholder="Cari Laporan" id="searchInput" name="search">
                <button class="btn btn-outline-dark rounded-pill mt-2" type="submit">Search</button>
                <a href="?" class="btn btn-outline-danger rounded-pill mt-2">Reset</a>
            </div>
        </div>
        </form>
    </div>
  </div>

  <div class="table-responsive">
  <table class="table">
    <thead>
      <tr>
        <th>No</th>
        <th>NIK</th>
        <th>Email</th>
        <th>Nama</th>
        <th>Username</th>
        <th>Telp</th>
        <th>Aksi</th>
      </tr>
    </thead>

 <a href="buat_akun.php"><button class="btn btn-primary btn-add-akun" id="addAkunBtn">
       <i class="fa fa-plus-circle"></i> Buat Akun
  </button></a>

    <tbody>
      <?php 
      if (mysqli_num_rows($result) > 0) {
        $no = 1;
        while ($data = mysqli_fetch_array($result)) {
          ?>
          <tr>
            <td><?= $no++; ?></td>
            <td><?= $data['nik']; ?></td>
            <td><?= $data['email']; ?></td>
            <td><?= $data['nama']; ?></td>
            <td><?= $data['username']; ?></td>
            <td><?= $data['telp']; ?></td>
            <td><a href="detail_akun_masyarakat.php?p=<?php echo $data['id_masyarakat']; ?>" class="btn btn-sm btn-outline-secondary">Detail</a></td>
          </tr>
          <?php
        }
      } else {
        echo "<tr><td colspan='7' class='text-center'>Tidak ada data ditemukan.</td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js"></script>
</body>
</html>
