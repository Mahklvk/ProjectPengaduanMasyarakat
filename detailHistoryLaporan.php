<?php
require('config/session.php');
require('config/db.php');

// Ambil data user dari database berdasarkan session
// Cek terlebih dahulu apakah variabel session nik ada
if (!isset($_SESSION['nik'])) {
    $_SESSION['message'] = "Silakan login untuk melanjutkan.";
    $_SESSION['message_type'] = "error";
    header("Location: login.php");
    exit();
}

$nik = $_SESSION['nik']; // Ini dari session login

// Cek apakah parameter id_pengaduan ada
if (!isset($_GET['p'])) {
    $_SESSION['message'] = "Laporan tidak ditemukan.";
    $_SESSION['message_type'] = "error";
    header("Location: history_laporan.php");
    exit();
}

$id = $_GET['p']; // ID laporan yang mau dilihat

// Ambil data pengaduan sesuai ID dan NIK
$query = mysqli_query($conn, "SELECT * FROM pengaduan WHERE id_pengaduan = '$id' AND nik = '$nik'");
if (!$query || mysqli_num_rows($query) == 0) {
    // Laporan tidak ditemukan atau bukan milik user
    echo "<script>
        Swal.fire({
            title: 'OOPS!',
            text: 'Kamu tidak bisa melihat laporan orang lain!',
            icon: 'error'
        }).then(() => {
            window.location.href = 'history_laporan.php';
        });
    </script>";
    exit();
}

// Kalau lolos validasi, ambil datanya
$fetch_data = mysqli_fetch_array($query);

$querySelectPengaduan = mysqli_query($conn, "SELECT * FROM tanggapan WHERE id_pengaduan = '$id'");
$hitungPengaduan = mysqli_num_rows($querySelectPengaduan);
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

if (!$fetch_data) {
    echo "<script>
            Swal.fire({
                title: 'Oops!',
                text: 'Laporan tidak ditemukan!',
                icon: 'error'
            }).then(() => {
                window.location.href = 'history_laporan.php';
            });
          </script>";
    exit();
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
  <title>Document</title>
</head>

<body>
  <?php include('config/navbar.php')?>
  <h1 class="text-center mt-4">Detail Laporan</h1>
  <h2 class="text-center mt-5"><?php echo $fetch_data['judul_laporan'] ?></h2>
  <div class="container">
    <div class="row align-items-start border border-dark rounded p-2">
      <div class="col-md-6 col-sm-11">
        <form action="" class="container w-10" enctype="multipart/form-data" method="post">
          <label for="judulLaporan" class="form-label">Judul Laporan</label>
          <input type="nik" class="form-control" name="judulLaporan" id="judulLaporan" value="<?php echo $fetch_data['judul_laporan'] ?>">

          <label for="date" class="form-label">Tanggal lapor</label>
          <input type="text" class="form-control" name="date" id="date" readonly value="<?php echo $fetch_data['tgl_pengaduan'] ?>">

          <label for="tanggapan">Tanggapan</label>
          <?php
          if($hitungPengaduan < 1){
            ?>
            <textarea name="tanggapan" id="tanggapan" class="form-control"disabled>Petugas Belum Memberikan Tanggapan</textarea>
            <?php
          }else{
            ?>
            <textarea name="tanggapan" id="tanggapan" class="form-control"disabled><?php echo $dataPengaduan['tanggapan'];?></textarea>
            <?php
          }
          ?>
          
          

          <label for="isiLaporan">Isi Laporan</label>
          <textarea name="isiLaporan" id="isiLaporan" class="form-control"><?php echo $fetch_data['isi_laporan'] ?></textarea>

          <label for="foto">Upload Foto</label>
          <input type="file" class="form-control" name="foto" id="foto">

          <div class="row">
            <div class="container align-items-center justify-content-center d-flex mt-2 col-md-6">
              <button class="btn btn-primary" name="submit" id="submit">Edit</button>
            </div>
            <div class="container align-items-center justify-content-center d-flex mt-2 col-md-6">
              <button type="button" class="btn btn-danger" name="delete" id="delete" onclick="hapusLaporan(<?php echo $fetch_data['id_pengaduan'] ?>)">Delete</button>
            </div>
          </div>
        </form>
        <?php
        if (isset($_POST['submit'])) {
          $judulLaporan = mysqli_real_escape_string($conn, $_POST['judulLaporan']);
          // $date = mysqli_real_escape_string($conn, $_POST['date']);
          $isiLaporan = mysqli_real_escape_string($conn, $_POST['isiLaporan']);

          $targetDir = "storages/foto_laporan/";
          $namaFoto = basename($_FILES["foto"]["name"]);
          $targetFile = $targetDir . $namaFoto;
          $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
          $sizeFoto = $_FILES["foto"]["size"];
          $namaFotoRandom = generatorRandom(20);
          $namaFotoBaru = $namaFotoRandom . "." . $fileType;

          if ($namaFoto != '') {
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
                if (!empty($fetch_data['foto']) && file_exists($targetDir . $fetch_data['foto'])) {
                  unlink($targetDir . $fetch_data['foto']);
                }
                $queryUpdate = mysqli_query($conn, "UPDATE pengaduan SET judul_laporan='$judulLaporan', isi_laporan='$isiLaporan', foto='$namaFotoBaru' WHERE id_pengaduan = '$id'");
              }
            }
          } else {
            $queryUpdate = mysqli_query($conn, "UPDATE pengaduan SET judul_laporan='$judulLaporan', isi_laporan='$isiLaporan' WHERE id_pengaduan = '$id'");
          }
          if ($queryUpdate) {
            ?>
            <script>
              Swal.fire({
                title: "Sukses",
                text: "Laporan telah diperbarui!",
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
                title: "Gagal!",
                text: "Laporan Gagal Diperbarui, ada yang salah!",
                icon: "error"
              });
            </script>
        <?php
          }
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
    function hapusLaporan(laporanID) {
      Swal.fire({
        title: 'Apakah Kamu Yakin?',
        text: "Jika laporan dihapus tidak akan bisa dipulikan lagi",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Hapus'
      }).then((result) => {
        if (result.isConfirmed) {
          fetch('hapusLaporan.php', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
              },
              body: JSON.stringify({
                id_pengaduan: laporanID
              }),
            }).then(response => response.json())
            .then(data => {
              if (data.success) {
                Swal.fire(
                  'Sukses!',
                  'laporan Telah Terhapus.',
                  'success'
                ).then(() => {
                  window.location.href = 'history_laporan.php';
                });
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
</body>

</html>