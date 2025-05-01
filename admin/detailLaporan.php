<?php
require ('../config/db.php');

$id = $_GET['p'];
$querySelectLaporan = mysqli_query($conn, "SELECT * FROM pengaduan WHERE id_pengaduan='$id'");
$fetch_data = mysqli_fetch_array($querySelectLaporan);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <title>Document</title>
</head>
<body>
  <h1 class="text-center mt-4">Detail Laporan</h1>
  <h2 class="text-center mt-5"><?php echo $fetch_data['judul_laporan']?></h2>
  <div class="container">
  <div class="row align-items-start border border-dark rounded p-2">
    <div class="col-md-6 col-sm-11">
    <form action="" class="container w-10" enctype="multipart/form-data" method="post">
            <label for="judulLaporan" class="form-label">Judul Laporan</label>
            <input type="nik" class="form-control" name="judulLaporan" id="judulLaporan" value="<?php echo $fetch_data['judul_laporan']?>" disabled>

            <label for="date" class="form-label">Tanggal lapor</label>
            <input type="text" class="form-control" name="date" id="date" disabled value="<?php echo $fetch_data['tgl_pengaduan']?>" disabled>

            <label for="tanggapan">Tanggapan</label>
            <textarea name="tanggapan" id="tanggapan" class="form-control" placeholder="ambil data dari database" required></textarea>

            <label for="isiLaporan">Isi Laporan</label>
            <textarea name="isiLaporan" id="isiLaporan" class="form-control" disabled><?php echo $fetch_data['isi_laporan']?></textarea>

            <label for="foto">Upload Foto</label>
            <input type="file" class="form-control" name="foto" id="foto" disabled>

            <div class="row">
              <div class="container align-items-center justify-content-center d-flex mt-2 col-md-6">
                <button class="btn btn-primary" name="submit" id="submit">Edit</button>
              </div>
              <div class="container align-items-center justify-content-center d-flex mt-2 col-md-6">
                <button type="button"  class="btn btn-danger" name="delete" id="delete" onclick="rejectLaporan(<?php echo $fetch_data['id_pengaduan']?>)">Delete</button>
              </div>
            </div>
          </form>
      <?php
      if(isset ($_POST['submit'])){
        $judulLaporan = mysqli_real_escape_string($conn, $_POST['judulLaporan']);
        $date = mysqli_real_escape_string($conn, $_POST['date']);
        $isiLaporan = mysqli_real_escape_string($conn, $_POST['isiLaporan']);

      }
      ?>
    </div>
    <div class="col-md-6 col-sm-11 align-items-center justify-content-center text-center mt-5">
      <p>Current Photo</p>
      <img src="storages/foto_laporan/<?php echo $fetch_data['foto']; ?>" alt="image laporan" class="img-fluid" style="max-height: 200px;">
    </div>
  </div>
</div>

<script src="assets/bootstrap/js/bootstrap.bundle.js"></script>
  <script src="assets/fontawesome/js/all.min.js"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <script>
    function rejectLaporan(laporanID){
      Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: "Laporan ini akan dimasukan ke kategori reject",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Reject!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('rejectLaporan.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ id_pengaduan: laporanID }),
                    }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire(
                                'Sukses!',
                                'laporan Telah Tereject.',
                                'success'
                            ).then(() => {window.location.href = 'listLaporan.php';});
                        } else {
                            Swal.fire(
                                'Error!',
                                data.message || 'Tidak Bisa menghapus Laporan ini.',
                                'error'
                            );
                        }
                    })
                    .catch(error => {
                        Swal.fire(
                            'Error!',
                            'Ada yang salah ketika menghapus Laporan.',
                            'error'
                        );
                    });
                }
            });
        }
  </script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js"></script>
</body>
</html>