<?php
require('config/session.php');
require('config/db.php');


// Ambil data user dari database berdasarkan session
// Cek terlebih dahulu apakah variabel session nik ada
if(isset($_SESSION['nik'])) {
    $nik = $_SESSION['nik'];
    $telp = $_SESSION['telp'];
    $username = $_SESSION['username'];
} else {
    // Jika tidak ada variabel nik, coba cek variabel lain yang mungkin menyimpan nik user
    if(isset($_SESSION['nik'])) {
    $nik = $_SESSION['nik'];
       $telp = $_SESSION['telp'];
    $username = $_SESSION['username'];
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
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <title>Tulis laporan - MyReport</title>
</head>

<style>
    body {
      background: linear-gradient(135deg, rgba(0, 0, 0, 0.6), rgba(0, 123, 255, 0.4));
            margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
      overflow-x: hidden;
      position: relative;
    }
        .card {
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      background: rgba(255, 255, 255, 0.15);
      border-radius: 18px;
      box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2);
      border: 1px solid rgba(255, 255, 255, 0.18);
      padding: 2rem 2.5rem;
      margin-top: 2rem;
      margin-bottom: 2rem;
      color: #333;
    }
  /* .form-section {
    max-width: 900px;
    margin: auto;
    margin-top: 40px;
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  } */
  .form-title {
    font-size: 2rem;
    font-weight: 600;
    margin-bottom: 30px;
    text-align: center;
  }
  .select2-container--default .select2-selection--single {
    height: 38px;
    padding: 5px 10px;
    border-radius: 8px;
    border: 1px solid #ced4da;
  }
  #preview-container {
    border: 2px dashed #ccc;
    height: 300px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    margin-top: 20px;
    color: #888;
  }
      .judul-laporan, .tanggal, .isi-laporan, .tanggapan, .upload, .kategori, .alamat{
      width: 100%;
      padding: 12px;
            margin-bottom: 16px;
            border: none;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            outline: none;
            transition: background 0.3s;
    }

          .judul-laporan:focus, .tanggal:focus, .isi-laporan:focus, .tanggapan:focus, .upload:focus, .kategori:focus, .alamat:focus{
background: rgba(255, 255, 255, 0.2);
color: white;
    }
    .upload::file-selector-button{
      border-radius: 10px;
      background: rgba(255, 255, 255, 0.1);
      border: none;
      margin-left:5px ;
    }
    .upload:hover, .upload::file-selector-button{
      background: rgba(255, 255, 255, 0.1);
    }
</style>
<body>
  <?php include('config/navbar.php')?>
  <h1 class="container mt-5 text-center">Lapor Sekarang</h1>
  <div class="container">
    <div class="row p-2">
      <div class="col-md-12  p-5 card">
        <div class="container form-section">
  <form action="" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="judul" class="form-label">Judul Laporan</label>
      <input type="text" class="form-control judul-laporan" id="judul" name="judulLaporan" placeholder="Contoh: Lampu jalan mati" required>
    </div>

    <div class="mb-3">
      <label for="tanggal" class="form-label">Tanggal Kejadian</label>
      <input type="date" class="form-control tanggal" id="tanggal" name="date" required>
    </div>

        <div class="mb-3">
      <label for="tanggal" class="form-label">Alamat</label>
      <input type="text" class="form-control alamat" id="alamat" name="alamat" placeholder="Alamat kejadian" required>
    </div>

    <div class="mb-3">
      <label for="kategori" class="form-label">Kategori</label>
      <select id="kategori" name="kategori" class="form-control kategori" required>
        <option></option>
        <option value="Jalan">Jalan</option>
        <option value="Listrik">Listrik</option>
        <option value="Air">Air</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="isi" class="form-label">Isi Laporan</label>
      <textarea class="form-control isi-laporan" id="isi" name="isiLaporan" rows="4" placeholder="Tuliskan detail kejadian..." required></textarea>
    </div>

    <div class="mb-3">
      <label for="foto" class="form-label">Foto</label>
      <input type="file" class="form-control upload" id="foto" name="foto" accept="image/*" required onchange="previewImage(event)" >
    </div>

    <div id="preview-container" class="text-white">Image Preview</div>

    <div class="text-center mt-4">
      <button type="submit" class="btn btn-primary px-5 py-2" name="submit">Submit</button>
    </div>
  </form>
</div>

          <?php
          if (isset($_POST['submit'])) {
            $judulLaporan = htmlspecialchars($_POST['judulLaporan']);
            $kategori = htmlspecialchars($_POST['kategori']);
            $date = htmlspecialchars($_POST['date']);
            $isiLaporan = htmlspecialchars($_POST['isiLaporan']);
            $alamat = htmlspecialchars($_POST['alamat']);

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
                $queryUploadData = mysqli_query($conn, "INSERT INTO pengaduan(judul_laporan, tgl_pengaduan, alamat, nik, isi_laporan, foto, kategori, username, telp) VALUES ('$judulLaporan', '$date','$alamat', '$nik', '$isiLaporan', '$namaFotoBaru', '$kategori', '$username', '$telp')");

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
                if (mysqli_affected_rows($conn) > 0) {
    // Ambil ID pengaduan yang baru dibuat
    $id_pengaduan_baru = mysqli_insert_id($conn);
    
    // Include fungsi notifikasi
    require_once('config/functions_notifikasi.php');
    
    // Buat notifikasi "diproses" untuk user
    buatNotifikasi($id_pengaduan_baru, $_SESSION['username'], 'diproses', $conn);
    
    // Redirect atau response success
    echo json_encode([
        'success' => true, 
        'message' => 'Laporan berhasil dibuat dan notifikasi telah dikirim'
    ]);
} else {
    echo json_encode([
        'success' => false, 
        'message' => 'Gagal membuat laporan'
    ]);
}
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
      </div>
    </div>
      </div>
    </div>
  </div>
<!-- jQuery dulu -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- lalu Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- baru kemudian pakai $ -->
<script>
  $(document).ready(function() {
    $('#kategori').select2({
      tags: true,
      placeholder: "Pilih atau ketik kategori",
      allowClear: true
    });
  });
  
  function previewImage(event) {
    const preview = document.getElementById('preview-container');
    const file = event.target.files[0];
    if (file && file.type.startsWith('image/')) {
      const reader = new FileReader();
      reader.onload = function(e) {
        preview.innerHTML = `<img src="${e.target.result}" style="max-height: 100%; max-width: 100%; object-fit: contain;" />`;
      }
      reader.readAsDataURL(file);
    } else {
      preview.innerHTML = "Image Preview";
    }
  }
</script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.bundle.js"></script>
  <script src="assets/fontawesome/js/all.min.js"></script>
  <script src="https://unpkg.com/feather-icons"></script>
</body>

</html>