<?php
require "config/sessionLogin.php";
require('../config/db.php');
$id = $_GET['p'];
$querySelectLaporan = mysqli_query($conn, "SELECT * FROM kontak WHERE id_kontak='$id'");
$fetch_data = mysqli_fetch_array($querySelectLaporan);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Document</title>
</head>
<body>
    <?php include('config/navbar.php')?>
    <h2 class="text-center mt-4"><?php echo $fetch_data['nama']?></h2>
    <div class="container mt-4">
        <div class="row items-start border border-dark rounded p-2">
            <div class="col-md-12">
                <form action="" method="post">
            <label for="judulLaporan" class="form-label">Nama</label>
            <input type="text" class="form-control" name="judulLaporan" id="judulLaporan" value="<?php echo $fetch_data['nama']?>" disabled>

            <label for="date" class="form-label">Email</label>
          <input type="text" class="form-control" name="date" id="date" disabled value="<?php echo $fetch_data['email']?>">

          <label for="tanggapan">Isi Kontak</label>
          <textarea name="tanggapan" id="tanggapan" class="form-control" disabled><?php echo $fetch_data['isi_kontak'];?></textarea>
          </form>
            </div>
        </div>
    </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>