<?php
require "config/sessionLogin.php";
require('../config/db.php');
$id = $_GET['p'];
$querySelectLaporan = mysqli_query($conn, "SELECT * FROM pengaduan WHERE id_pengaduan='$id'");
$fetch_data = mysqli_fetch_array($querySelectLaporan);


$querySelectPengaduan = mysqli_query($conn, "SELECT * FROM tanggapan");
$dataPengaduan = mysqli_fetch_array($querySelectPengaduan);

function generatorRandom($length = 10)
{
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}
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
    <h2 class="text-center mt-4"><?php echo $fetch_data['judul_laporan']?></h2>
    <div class="container mt-4">
        <div class="row items-start border border-dark rounded p-2">
            <div class="col-md-6">
                <form action="" method="post">
            <label for="judulLaporan" class="form-label">Judul Laporan</label>
            <input type="text" class="form-control" name="judulLaporan" id="judulLaporan" value="<?php echo $fetch_data['judul_laporan']?>" disabled>

            <label for="date" class="form-label">Tanggal Lapor</label>
          <input type="text" class="form-control" name="date" id="date" disabled value="<?php echo $fetch_data['tgl_pengaduan']?>">

          <label for="tanggapan">Tanggapan</label>
          <textarea name="tanggapan" id="tanggapan" class="form-control" disabled><?php echo $dataPengaduan['tanggapan'];?></textarea>

          <label for="isiLaporan">Isi Laporan</label>
          <textarea name="isiLaporan" id="isiLaporan" class="form-control" disabled><?php echo $fetch_data['isi_laporan']?></textarea>

          <label for="foto">Upload Foto</label>
          <input type="file" class="form-control" name="foto" id="foto" disabled>

          <div class="row">
            <div class="container align-items-center justify-content-center d-flex mt-2 col-md-6">
            <button type="button" class="btn btn-primary me-2" name="approve" onclick="approveLaporan(<?php echo $fetch_data['id_pengaduan']?>)">Approve</button>
            </div>
            <div class="container align-items-center justify-content-center d-flex mt-2 col-md-6">
            <button type="button" class="btn btn-danger" onclick="rejectLaporan(<?php echo $fetch_data['id_pengaduan']?>)">Reject</button>
            </div>
          </div>
          </form>
            </div>
            <div class="col-md-6 col-sm-11 align-items-center justify-content-center text-center mt-5">
        <p>Current Photo</p>
        <img src="../storages/foto_laporan/<?php echo $fetch_data['foto']; ?>" alt="image laporan" class="img-fluid" style="max-height: 200px;">
      </div>
        </div>
    </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function approveLaporan(idLaporan){
      Swal.fire({
  title: 'Apakah Kamu Yakin?',
  text: "Laporan ini akan disetujui dan statusnya menjadi selesai.",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Setujui'
}).then((result) => {
  if (result.isConfirmed) {
    fetch('approveLaporan.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        id_pengaduan: idLaporan
      }),
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        Swal.fire(
          'Berhasil!',
          'Laporan telah disetujui.',
          'success'
        ).then(() => {
          window.location.href = 'listLaporan.php';
        });
      } else {
        Swal.fire(
          'Error!',
          data.message || 'Tidak bisa menyetujui laporan.',
          'error'
        );
      }
    })
    .catch(error => {
      Swal.fire(
        'Error!',
        'Ada yang salah ketika menyetujui laporan.',
        'error'
      );
    });
  }
});
    }

    function rejectLaporan(idLaporan){
      Swal.fire({
  title: 'Apakah Kamu Yakin?',
  text: "Laporan ini akan ditolak dan statusnya menjadi ditolak.",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Tolak'
}).then((result) => {
  if (result.isConfirmed) {
    fetch('rejectLaporan.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        id_pengaduan: idLaporan
      }),
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        Swal.fire(
          'Berhasil!',
          'Laporan telah ditolak.',
          'success'
        ).then(() => {
          window.location.href = 'listLaporan.php';
        });
      } else {
        Swal.fire(
          'Error!',
          data.message || 'Tidak bisa menolak laporan.',
          'error'
        );
      }
    })
    .catch(error => {
      Swal.fire(
        'Error!',
        'Ada yang salah ketika menolak laporan.',
        'error'
      );
    });
  }
});
    }
</script>
</body>
</html>