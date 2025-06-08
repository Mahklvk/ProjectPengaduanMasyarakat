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

$querySelectTanggapan = mysqli_query($conn, "SELECT * FROM tanggapan WHERE id_pengaduan = '$id'");
$hitungTanggapan = mysqli_num_rows($querySelectTanggapan);
$dataTanggapan = mysqli_fetch_array($querySelectTanggapan);
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
  <title>Detail history laporan - My Report</title>
 <style>
    body {
        background: linear-gradient(135deg, rgba(0, 0, 0, 0.6), rgba(0, 123, 255, 0.4));
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  margin: 0;
  padding: 0;
  overflow-x: hidden;
    }

    .laporan-detail-card {
          border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    backdrop-filter: blur(15px);
    background: rgba(255, 255, 255, 0.15);
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.2);
    padding: 30px;
    }
    .judul-laporan, .tanggal, .isi-laporan, .tanggapan, .upload, .kategori{
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
        .judul-laporan:focus, .tanggal:focus, .isi-laporan:focus, .tanggapan:focus, .upload:focus, .kategori:focus{
          color: white;
background: rgba(255, 255, 255, 0.2);
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

    .form-control:read-only{
      cursor: not-allowed;
    }
    
  </style>
</head>

<body>
  <?php include('config/navbar.php')?>
  <h1 class="text-center mt-4">Detail Laporan</h1>
  <h2 class="text-center mt-2"><?php echo $fetch_data['judul_laporan'] ?></h2>
  <div class="container mt-2">
        <div class="row laporan-detail-card">
            <div class="col-md-6 align-items-start  p-2">
          <form action="" enctype="multipart/form-data" method="post">
            <div class="laporan-label">Judul Laporan</div>
            <div class="laporan-value">
              <input type="text" class="form-control judul-laporan" name="judulLaporan" value="<?= htmlspecialchars($fetch_data['judul_laporan']) ?>">
            </div>
            <div class="laporan-label">Tanggal Kejadian</div>
            <div class="laporan-value">
              <input type="text" class="form-control tanggal" name="date" value="<?= htmlspecialchars($fetch_data['tgl_pengaduan']) ?>" readonly>
            </div>
            <div class="laporan-label">Alamat Kejadian</div>
            <div class="laporan-value">
              <input type="text" class="form-control tanggal" name="alamat" value="<?= htmlspecialchars($fetch_data['alamat']) ?>">
            </div>
            <div class="laporan-label">Kategori</div>
            <div class="laporan-value">
              <input type="text" class="form-control kategori" name="kategori" value="<?= htmlspecialchars($fetch_data['kategori']) ?>">
            </div>
            <div class="laporan-label">Tanggapan</div>
            <div class="laporan-value">
              <textarea name="tanggapan" class="form-control tanggapan" readonly><?= $hitungTanggapan < 1 ? 'Petugas Belum Memberikan Tanggapan' : htmlspecialchars($dataTanggapan['tanggapan']) ?></textarea>
            </div>
            <div class="laporan-label">Isi Laporan</div>
            <div class="laporan-value">
              <textarea name="isiLaporan" class="form-control isi-laporan"><?= htmlspecialchars($fetch_data['isi_laporan']) ?></textarea>
            </div>
            <div class="laporan-label">Upload Foto</div>
            <div class="laporan-value">
              <input type="file" class="form-control upload" name="foto">
            </div>
            <?php
          if($hitungTanggapan < 1){
            ?>
            <div class="row mt-4">
              <div class="col-md-6">
                <button type="submit" class="btn btn-success w-100" id="submit" name="submit">
                  <i class="fas fa-pencil"></i> Edit
                </button>
              </div>
              <div class="col-md-6">
                <button type="button" class="btn btn-danger w-100"  name="delete" id="delete" onclick="hapusLaporan(<?= $fetch_data['id_pengaduan'] ?>)">
                  <i class="fas fa-trash"></i> Hapus
                </button>
              </div>
            </div>
            <?php
          }else{
            ?>
            <div class="alert alert-info mt-3">
              <i class="fas fa-info-circle"></i> Tanggapan sudah diberikan untuk laporan ini.
            </div>
            <?php
          }
          ?>
        </form>
        <?php
        if (isset($_POST['submit'])) {
          $judulLaporan = mysqli_real_escape_string($conn, $_POST['judulLaporan']);
          // $date = mysqli_real_escape_string($conn, $_POST['date']);
          $isiLaporan = mysqli_real_escape_string($conn, $_POST['isiLaporan']);
          $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
          $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

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
                $queryUpdate = mysqli_query($conn, "UPDATE pengaduan SET judul_laporan='$judulLaporan',kategori = '$kategori',alamat = '$alamat', isi_laporan='$isiLaporan', foto='$namaFotoBaru' WHERE id_pengaduan = '$id'");
              }
            }
          } else {
            $queryUpdate = mysqli_query($conn, "UPDATE pengaduan SET judul_laporan='$judulLaporan',kategori = '$kategori', alamat = '$alamat', isi_laporan='$isiLaporan' WHERE id_pengaduan = '$id'");
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
        <p>Foto</p>
        <img src="storages/foto_laporan/<?php echo $fetch_data['foto']; ?>" alt="image laporan" class="img-fluid" style="max-height: 500px; cursor: pointer;" 
     data-bs-toggle="modal" 
     data-bs-target="#imageModal" 
     onclick="openImageModal(this.src)">
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/fontawesome/js/all.min.js"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <script>
    let scale = 1;
  let modalImg = null;

  function openImageModal(src) {
    modalImg = document.getElementById("modalImage");
    modalImg.src = src;
    scale = 1;
    modalImg.style.transform = `scale(${scale})`;
    const modal = new bootstrap.Modal(document.getElementById('imageModal'));
    modal.show();
  }

  function zoomImage(direction) {
    if (!modalImg) return;
    if (direction === 'in') {
      scale = Math.min(scale + 0.2, 5);
    } else if (direction === 'out') {
      scale = Math.max(1, scale - 0.2);
    }
    modalImg.style.transform = `scale(${scale})`;
  }
  // Scroll wheel zoom
  document.getElementById("imageModal").addEventListener("wheel", function(e) {
    if (!modalImg) return;
    e.preventDefault();
    if (e.deltaY < 0) {
      scale = Math.min(scale + 0.1, 5);
    } else {
      scale = Math.max(1, scale - 0.1);
    }
    modalImg.style.transform = `scale(${scale})`;
  }, { passive: false });

  // Pinch Zoom (mobile)
  let initialDistance = null;
  let startScale = 1;

  document.addEventListener('touchstart', function(e) {
    if (e.touches.length === 2 && modalImg) {
      initialDistance = getDistance(e.touches[0], e.touches[1]);
      startScale = scale;
    }
  });

  document.addEventListener('touchmove', function(e) {
    if (e.touches.length === 2 && modalImg && initialDistance) {
      const newDistance = getDistance(e.touches[0], e.touches[1]);
      let pinchScale = newDistance / initialDistance;
      scale = Math.min(Math.max(1, startScale * pinchScale), 5);
      modalImg.style.transform = `scale(${scale})`;
    }
  });

  function getDistance(touch1, touch2) {
    const dx = touch2.clientX - touch1.clientX;
    const dy = touch2.clientY - touch1.clientY;
    return Math.sqrt(dx * dx + dy * dy);
  }

function reset() {
  const imageModal = document.getElementById('imageModal');
  const modalImg = document.getElementById('modalImage'); // tambahkan ini
  let scale = 1;

  if (imageModal) {
    imageModal.addEventListener('hidden.bs.modal', function () {
      // Reset transform zoom
      if (modalImg) {
        modalImg.style.transform = 'scale(1)';
      }
      scale = 1;

      // Hapus backdrop Bootstrap jika masih ada
      const backdrops = document.querySelectorAll('.modal-backdrop');
      backdrops.forEach(el => el.remove());

      // Bersihkan class & style Bootstrap yang mengunci layar
      document.body.classList.remove('modal-open');
      document.body.style.paddingRight = '';
      document.body.style.overflow = '';
    });
  }
}

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