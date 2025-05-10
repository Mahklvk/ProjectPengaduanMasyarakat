<?php 
require('../config/db.php');

// Cek apakah ada pencarian
if (isset($_GET['search']) && $_GET['search'] != '') {
    $filtervalues = $_GET['search'];
    $query = "SELECT * FROM kontak WHERE CONCAT(nama,email,isi_kontak) LIKE '%$filtervalues%' ";
    $result = mysqli_query($conn, $query);
} else {
    // Tidak ada pencarian, ambil semua data
    $query = "SELECT * FROM kontak";
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
  </style>
</head>
<body>
<?php include('config/navbar.php')?>
<div class="container mt-5">
  <h1 class="mb-4">Daftar Kontak</h1>

  <div class="row mb-4">
    <div class="col-md-8 col-sm-6 input-icons">
      <form class="d-flex" role="search" method="get">
      <button type="button" class="icon-search">
        <i class="fa fa-search fa-xl"></i>
      </button>
      <!-- <div class="search-container">
            <div class="search-box">
                <i class="fa fa-search search-icon"></i>
                <input type="text" name="search" class="form-control" placeholder="Cari Laporan" id="searchInput" value="<?php if (isset($_GET['search'])) echo $_GET['search']; ?>">
            </div>
        </div> -->
        <input type="text" name="search" value="" class="form-control me-2 input-field" placeholder="Search data">
        <button class="btn btn-outline-secondary" type="submit">Search</button>
      </form>
    </div>
<div class="table-responsive">
  <table class="table">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>email</th>
        <th>Isi laporan</th>
        <th>Action</th>
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
            <td><?= $data['nama']; ?></td>
            <td><?= $data['email']; ?></td>
            <td><?= strlen($data['isi_kontak']) > 50 ? substr($data['isi_kontak'], 0, 50) . '...' : $data['isi_kontak']; ?></td>
            <td><a href="detail_kontak.php?p=<?php echo $data['id_kontak']; ?>" class="btn btn-sm btn-outline-dark"> Detail</a></td>
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
