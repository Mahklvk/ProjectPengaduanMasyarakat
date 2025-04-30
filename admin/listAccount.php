<?php 
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
  <title>Daftar Akun</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h1 class="mb-4">Daftar Akun</h1>

  <div class="row mb-4">
    <div class="col-md-8">
      <form class="d-flex" role="search" method="get">
        <input type="text" name="search" required value="<?php if (isset($_GET['search'])) echo $_GET['search']; ?>" class="form-control me-2" placeholder="Search data">
        <button class="btn btn-outline-secondary" type="submit">Search</button>
      </form>
    </div>
    <div class="col-md-4 text-end">
      <button type="button" class="btn btn-outline-secondary">Tambah Akun</button>
    </div>
  </div>

  <table class="table">
    <thead>
      <tr>
        <th>No</th>
        <th>NIK</th>
        <th>Nama</th>
        <th>Username</th>
        <th>Password</th>
        <th>Telp</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      if (mysqli_num_rows($result) > 0) {
        $no = 1;
        while ($data = mysqli_fetch_array($result)) {
          ?>
          <tr>
            <td><?= $no++; ?></td>
            <td><?= $data['nik']; ?></td>
            <td><?= $data['nama']; ?></td>
            <td><?= $data['username']; ?></td>
            <td><?= strlen($data['password']) > 50 ? substr($data['password'], 0, 50) . '...' : $data['password']; ?></td>
            <td><?= $data['telp']; ?></td>
            <td><a href="accountDetail.php?p=<?= $data['nik']; ?>" class="btn btn-sm btn-outline-secondary">Edit</a></td>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
