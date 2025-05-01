<?php
require ('../config/db.php');

$id = $_GET['p'];
$querySelectLaporan = mysqli_query($conn, "SELECT * FROM pengaduan WHERE id_pengaduan='$id'");
$fetch_data = mysqli_fetch_array($querySelectLaporan);

// Cek apakah sudah ada tanggapan untuk id_pengaduan ini
$queryTanggapan = mysqli_query($conn, "SELECT * FROM tanggapan WHERE id_pengaduan='$id'");
$queryTanggapanTanggapan = mysqli_query($conn, "SELECT tanggapan FROM tanggapan");
$fetchTanggapan = mysqli_fetch_array($queryTanggapanTanggapan);
$adaTanggapan = mysqli_num_rows($queryTanggapan) > 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  
  <title>Detail Laporan</title>
</head>
<body>
  <h1 class="text-center mt-4">Detail Laporan</h1>
  <h2 class="text-center mt-5"><?php echo $fetch_data['judul_laporan']?></h2>
  <div class="container">
    <div class="row align-items-start border border-dark rounded p-2">
      <div class="col-md-6 col-sm-11">
        <form action="" method="post">
          <label for="judulLaporan" class="form-label">Judul Laporan</label>
          <input type="text" class="form-control" name="judulLaporan" id="judulLaporan" value="<?php echo $fetch_data['judul_laporan']?>" disabled>

          <label for="date" class="form-label">Tanggal Lapor</label>
          <input type="text" class="form-control" name="date" id="date" disabled value="<?php echo $fetch_data['tgl_pengaduan']?>">

          <label for="tanggapan">Tanggapan</label>
          <textarea name="tanggapan" id="tanggapan" class="form-control" required><?php echo $fetchTanggapan['tanggapan'];?></textarea>

          <label for="isiLaporan">Isi Laporan</label>
          <textarea name="isiLaporan" id="isiLaporan" class="form-control" disabled><?php echo $fetch_data['isi_laporan']?></textarea>

          <label for="foto">Upload Foto</label>
          <input type="file" class="form-control" name="foto" id="foto" disabled>

          <div class="row">
            <div class="container align-items-center justify-content-center d-flex mt-2 col-md-6">
            <button type="button" class="btn btn-success me-2" onclick="<?php echo $adaTanggapan ? "konfirmasi('approve')" : "noTanggapan()" ?>">Approve</button>
            </div>
            <div class="container align-items-center justify-content-center d-flex mt-2 col-md-6">
            <button type="button" class="btn btn-danger" onclick="<?php echo $adaTanggapan ? "konfirmasi('reject')" : "noTanggapan()" ?>">Reject</button>
            </div>
          </div>
        </form>
      </div>
      <div class="col-md-6 col-sm-11 align-items-center justify-content-center text-center mt-5">
        <p>Current Photo</p>
        <img src="storages/foto_laporan/<?php echo $fetch_data['foto']; ?>" alt="image laporan" class="img-fluid" style="max-height: 200px;">
      </div>
    </div>
  </div>

  <!-- Hidden Form for action -->
  <form id="verifikasiForm" method="post" action="proses_laporan.php">
    <input type="hidden" name="id_pengaduan" value="<?php echo $id ?>">
    <input type="hidden" name="action" id="actionInput">
  </form>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
    function noTanggapan() {
      Swal.fire({
        icon: 'warning',
        title: 'Tanggapan belum diisi',
        text: 'Silakan isi tanggapan terlebih dahulu sebelum memverifikasi laporan.'
      });
    }

    function konfirmasi(aksi) {
      Swal.fire({
        title: 'Yakin?',
        text: `Laporan akan di-${aksi}.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: `Ya, ${aksi}!`,
        cancelButtonText: 'Batal',
        confirmButtonColor: aksi === 'approve' ? '#28a745' : '#dc3545',
        cancelButtonColor: '#6c757d'
      }).then((result) => {
        if (result.isConfirmed) {
          // Set value ke hidden input dan submit
          document.getElementById('actionInput').value = aksi;
          document.getElementById('verifikasiForm').submit();
        }
      });
    }
  });
  </script>
</body>
</html>
