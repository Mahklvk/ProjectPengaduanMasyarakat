<?php
require('config/session.php');
require('config/db.php');


// Ambil data user dari database berdasarkan session
// Cek terlebih dahulu apakah variabel session nik ada
if(isset($_SESSION['nik'])) {
    $nik = $_SESSION['nik'];
} else {
    // Jika tidak ada variabel nik, coba cek variabel lain yang mungkin menyimpan nik user
    if(isset($_SESSION['nik'])) {
    $nik = $_SESSION['nik'];
} else {
    $_SESSION['message'] = "Sesi tidak valid. Silakan login kembali.";
    $_SESSION['message_type'] = "error";
    header("Location: login.php");
    exit();
}
}


//untuk generator random nama file foto agar tidak sama dan unik
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
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css"> <!-- link bootstrap untuk bisa styling bootstrap -->
  <link rel="stylesheet" href="assets/fontawesome/css/all.min.css"> <!-- link fontawesome untuk bisa mengakses icon -->
  <link rel="stylesheet" href="assets/css/style.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <title>Tulis laporan - MyReport</title>
</head>

<body>
  <?php include('config/navbar.php')?>
  <h1 class="container mt-5">Lapor Sekarang</h1>
  <div class="container">
    <div class="row p-2">
      <div class="col-md-8 border border-dark rounded p-5">
        <div class="container">
          <form action="" class="container w-10" enctype="multipart/form-data" method="post">
            <label for="judulLaporan" class="form-label">Judul Laporan</label>
            <input type="text" class="form-control" name="judulLaporan" id="judulLaporan" required placeholder="Laporan">

            <label for="date" class="form-label">Tanggal Kejadian</label>
            <input type="date" class="form-control" name="date" id="date">

            <label for="isiLaporan">Isi Laporan</label>
            <textarea name="isiLaporan" id="isiLaporan" class="form-control" placeholder="Isi Laporan" required></textarea>

            <label for="foto">Foto</label>
            <div class="container justify-content-center align-items-center text-center">
            </div>
            <input type="file" class="form-control" name="foto" id="foto" required onchange="img.src = window.URL.createObjectURL(this.files[0])">

            <div class="row">
              <div class="container align-items-center justify-content-center d-flex mt-2">
                <button class="btn btn-primary col-4" name="submit" id="submit">Submit</button>
              </div>
            </div>
          </div>
          </form>
          <?php
          if (isset($_POST['submit'])) {
            $judulLaporan = htmlspecialchars($_POST['judulLaporan']);
            $date = htmlspecialchars($_POST['date']);
            $isiLaporan = htmlspecialchars($_POST['isiLaporan']);

            $targetDir = "storages/foto_laporan/";
            $namaFoto = basename($_FILES["foto"]["name"]);
            $targetFile = $targetDir . $namaFoto;
            $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $sizeFoto = $_FILES["foto"]["size"];
            $namaFotoRandom = generatorRandom(20);
            $namaFotoBaru = $namaFotoRandom . "." . $fileType;

            if ($sizeFoto > 1048576) {
          ?>
              <script>
                Swal.fire({
                  icon: "error",
                  title: "Oops...",
                  text: "Ukuran file terlalu besar, harus kurang dari 1MB!",
                });
              </script>
            <?php
            } elseif (!in_array($fileType, ['png', 'jpg', 'jpeg'])) {
            ?>
              <script>
                Swal.fire({
                  icon: "error",
                  title: "Oops...",
                  text: "Jenis File foto hanya PNG, JPG dan JPEG!",
                });
              </script>
              <?php
            } else {
              if (move_uploaded_file($_FILES["foto"]["tmp_name"], $targetDir . $namaFotoBaru)) {
                $queryUploadData = mysqli_query($conn, "INSERT INTO pengaduan(judul_laporan, tgl_pengaduan, nik, isi_laporan, foto) VALUES ('$judulLaporan', '$date', '$nik', '$isiLaporan', '$namaFotoBaru')");

                if ($queryUploadData) {
              ?>
                  <script>
                    Swal.fire({
                      title: "Laporan Terkirim!",
                      text: "Laporan akan segera ditanggapi oleh petugas kami!",
                      icon: "success"
                    }).then(() => {
                      window.location.href = 'history_laporan.php';
                    });
                  </script>
                <?php
                } else {
                ?>
                  <script>
                    Swal.fire({
                      title: "Laporan Gagal Terkirim!",
                      text: "Ada yang salah!",
                      icon: "error"
                    });
                  </script>
                <?php
                }
              } else {
                ?>
                <script>
                  Swal.fire({
                    title: "Gagal Mengupload gambar",
                    text: "ada yang salah saat mengupload gambar!",
                    icon: "error"
                  })
                </script>
          <?php
              }
            }
          }
          ?>
        </div>
        <div class="col-md-4 col-sm-11 align-items-center justify-content-center text-center border border-dark rounded p-5 mbs-sm-5">
        <p class="">Image Preview</p>
        <img class="img-fluid  style="max-width: 150px;" id="img">
      </div>
      </div>
    </div>
      </div>
    </div>
  </div>


  <script src="assets/bootstrap/js/bootstrap.bundle.js"></script>
  <script src="assets/fontawesome/js/all.min.js"></script>
  <script src="https://unpkg.com/feather-icons"></script>
</body>

</html>