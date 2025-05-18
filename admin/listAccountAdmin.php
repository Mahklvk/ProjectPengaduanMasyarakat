<?php 
require "config/sessionLogin.php";
require('../config/db.php');

// Cek apakah ada pencarian
if (isset($_GET['search']) && $_GET['search'] != '') {
    $filtervalues = $_GET['search'];
    $query = "SELECT * FROM petugas WHERE CONCAT(nama_petugas,username,password,telp,level) LIKE '%$filtervalues%' ";
    $result = mysqli_query($conn, $query);
} else {
    // Tidak ada pencarian, ambil semua data
    $query = "SELECT * FROM petugas";
    $result = mysqli_query($conn, $query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Akun</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <style>
    .icon-search {
  /* position: relative; */
  left: 30px;
  top: 17.5%;
  /* transform: translateY(-50%); */
  background: none;
  border: none;
  cursor: pointer;
  color: #6c757d;
}

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
  </style>
</head>
<body>
  <?php include('config/navbar.php')?>
<div class="container mt-5">
  <h1 class="mb-4">Daftar Akun</h1>

<div class="row mb-4">
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
    <!-- <div class="col-md-4 text-end">
      <button type="button" class="btn btn-outline-secondary"><i class="fa-solid fa-circle-plus"></i> Tambah Akun</button>
    </div> -->
  </div>
<div class="table-responsive">
  <table class="table">
    <thead>
      <tr>
        <th>No</th>
        <th>NIK</th>
        <th>Nama</th>
        <th>Username</th>
        <th>Telp</th>
        <th>Level</th>
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
            <td><?= $data['nama_petugas']; ?></td>
            <td><?= $data['username']; ?></td>
            <td><?= $data['telp']; ?></td>
            <td><?= $data['level']; ?></td>
            <td><a href="accountDetailAdmin.php?p=<?php echo $data['id_petugas']; ?>" class="btn btn-sm btn-outline-dark"> Edit</a></td>
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
