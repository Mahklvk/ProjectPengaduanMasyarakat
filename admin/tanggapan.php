<?php
require "config/sessionLogin.php";
require('../config/db.php');

$id_pengaduan = $_GET['p'];

$tgl_tanggapan = date('Y-m-d');
$id_petugas = $_SESSION['id_petugas'];
$querySelectLaporan = mysqli_query($conn, "SELECT * FROM pengaduan WHERE id_pengaduan='$id_pengaduan'");
$fetch_laporan = mysqli_fetch_array($querySelectLaporan);
$hitungPengaduan = mysqli_num_rows($querySelectLaporan);

$queryGetTanggapan = mysqli_query($conn, "SELECT tanggapan, id_pengaduan FROM tanggapan");

$cekTanggapan = mysqli_query($conn, "SELECT * FROM tanggapan WHERE id_pengaduan = '$id_pengaduan'");

$fetchTanggapan = mysqli_fetch_array($queryGetTanggapan);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>tanggapan - MyReport</title>
</head>
<body>
    <?php include('config/navbar.php')?>
    <h1 class="text-center mt-5">Tanggapan</h1>
    <div class="container mt-2">
        <div class="row border border-dark rounded">
            <div class="col-md-6 align-items-start  p-2">
                <form action="" method="post" class="py-5 p-5 justify-content-center align-items-center ">
                <label for="judulLaporan" class="form-label">Judul Laporan</label>
                <input type="text" class="form-control" name="judulLaporan" id="judulLaporan" value="<?php echo $fetch_laporan['judul_laporan']?>" disabled>

                <label for="judulLaporan" class="form-label">Kategori</label>
                <input type="text" class="form-control" name="kategori" id="kategori" value="<?php echo $fetch_laporan['kategori']?>" disabled>

                <label for="date" class="form-label">Tanggal Lapor</label>
                <input type="text" class="form-control" name="date" id="date" disabled value="<?php echo $fetch_laporan['tgl_pengaduan']?>">


                    <label for="tanggapan">Tanggapan</label>
          <?php
          if($hitungPengaduan < 1){
            ?>
            <textarea name="tanggapan" id="tanggapan" class="form-control"></textarea>
            <?php
          }else{
            ?>
            <textarea name="tanggapan" id="tanggapan" class="form-control"disabled><?php echo $fetchTanggapan['tanggapan'];?></textarea>
            <?php
          }
          ?>

                    <label for="isiLaporan">Isi Laporan</label>
          <textarea name="isiLaporan" id="isiLaporan" class="form-control" disabled><?php echo $fetch_laporan['isi_laporan']?></textarea>

          <label for="foto">Upload Foto</label>
          <input type="file" class="form-control" name="foto" id="foto" disabled>
                    <button class="btn btn-outline-dark mt-5 justify-content-center align-items-center d-flex container" name="submit">Submit Tanggapan</button>
                </form>

                <?php
                if(isset($_POST['submit'])){
                    $tanggapan = htmlspecialchars($_POST['tanggapan']);

                    
                    if(mysqli_num_rows($cekTanggapan) > 0){
                        ?>
                        <script>Swal.fire({icon: 'error', title: 'Error', text: 'Tanggapan Sudah Diberikan, tidak bisa lagi!'});</script>
                        <?php
                    }else{
                    $queryInsert = mysqli_query($conn, "INSERT INTO tanggapan (id_pengaduan, tgl_tanggapan, tanggapan, id_petugas) VALUES ('$id_pengaduan', '$tgl_tanggapan', '$tanggapan', '$id_petugas')");
                    if($queryInsert){
                        ?>
                        <script>Swal.fire({icon: 'success', title: 'Success!', text: 'Tanggapan telah ditambahkan!'}).then(() => {window.location.href = 'list_pengaduan.php';});</script>
                        <?php
                    }else{
                        ?>
                        <script>Swal.fire({icon: 'error', title: 'Error', text: 'Gagal menambahkan tanggapan'});</script>
                        <?php
                    }
                }
            }
                ?>
            </div>
            <div class="col-md-6 col-sm-11 align-items-center justify-content-center text-center mt-5">
        <p>Current Photo</p>
        <img src="../storages/foto_laporan/<?php echo $fetch_laporan['foto']; ?>" alt="image laporan" class="img-fluid" style="max-height: 200px;">
      </div>
        </div>
    </div>

  <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content bg-dark border-0">
      <div class="modal-body p-0 position-relative">
        <!-- Tombol Close -->
        <button type="button" class="btn btn-danger position-absolute top-0 end-0 m-3 z-3" data-bs-dismiss="modal" aria-label="Close" onclick="reset()">
          <i class="fas fa-times"></i>
        </button>

        <!-- Kontainer Gambar -->
        <div class="image-container d-flex justify-content-center align-items-center h-100 overflow-hidden" style="touch-action: none;">
          <img id="modalImage" src="" alt="Preview" class="img-fluid" style="transition: transform 0.3s;">
        </div>

        <!-- Tombol Zoom -->
        <div class="position-absolute bottom-0 start-50 translate-middle-x mb-4 z-3">
          <button class="btn btn-light me-2" onclick="zoomImage('in')"><i class="fas fa-search-plus"></i></button>
          <button class="btn btn-light" onclick="zoomImage('out')"><i class="fas fa-search-minus"></i></button>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>