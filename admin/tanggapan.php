<?php
require "config/sessionLogin.php";
require('../config/db.php');

$id_pengaduan = $_GET['p'];

$tgl_tanggapan = date('Y-m-d');
$id_petugas = $_SESSION['id_petugas'];
$querySelectLaporan = mysqli_query($conn, "SELECT * FROM pengaduan WHERE id_pengaduan='$id_pengaduan'");
$fetch_laporan = mysqli_fetch_array($querySelectLaporan);
$hitungPengaduan = mysqli_num_rows($querySelectLaporan);

$cekTanggapan = mysqli_query($conn, "SELECT * FROM tanggapan WHERE id_pengaduan = '$id_pengaduan'");
$hitungTanggapan = mysqli_num_rows($cekTanggapan);

$fetchTanggapan = mysqli_fetch_array($cekTanggapan);
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
<style>
  body {
      background: linear-gradient(135deg, rgba(0, 0, 0, 0.6), rgba(0, 123, 255, 0.4));
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  margin: 0;
  padding: 0;
  overflow-x: hidden;
}
  .form-control:disabled{
    cursor: not-allowed;
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

  .card-blur {
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    backdrop-filter: blur(15px);
    background: rgba(255, 255, 255, 0.15);
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.2);
    padding: 30px;
}

.judul-laporan, .nik, .alamat, .telp, .username, .kategori, .tanggal, .tanggapan, .isi-laporan{
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
</style>
<body>
    <?php include('config/navbar.php')?>

    <h1 class="text-center mt-5">Tanggapan</h1>
    <div class="container mt-2 card-blur">
        <div class="row">
            <div class="col-md-6 align-items-start  p-2">
                <form action="" method="post" class="py-5 p-5 justify-content-center align-items-center ">
                <label for="judulLaporan" class="form-label">Judul Laporan</label>
                <input type="text" class="form-control judul-laporan" name="judulLaporan" id="judulLaporan" value="<?php echo $fetch_laporan['judul_laporan']?>" disabled>

                <label for="judulLaporan" class="form-label">NIK</label>
                <input type="text" class="form-control nik" name="nik" id="nik" value="<?php echo $fetch_laporan['nik']?>" disabled>

                <label for="judulLaporan" class="form-label">Alamat</label>
                <input type="text" class="form-control alamat" name="alamat" id="alamat" value="<?php echo $fetch_laporan['alamat']?>" disabled>

                <label for="judulLaporan" class="form-label">No.Telp</label>
                <input type="text" class="form-control telp" name="telp" id="telp" value="<?php echo $fetch_laporan['telp']?>" disabled>

                <label for="judulLaporan" class="form-label">Username</label>
                <input type="text" class="form-control username" name="username" id="username" value="<?php echo $fetch_laporan['username']?>" disabled>

                <label for="judulLaporan" class="form-label">Kategori</label>
                <input type="text" class="form-control kategori" name="kategori" id="kategori" value="<?php echo $fetch_laporan['kategori']?>" disabled>

                <label for="date" class="form-label">Tanggal Lapor</label>
                <input type="text" class="form-control tanggal" name="date" id="date" disabled value="<?php echo $fetch_laporan['tgl_pengaduan']?>" disabled>

                <label for="tanggapan">Tanggapan</label>
          <?php
          if($hitungTanggapan < 1){
            ?>
            <textarea name="tanggapan" id="tanggapan" class="form-control tanggapan" placeholder="Masukkan tanggapan untuk laporan ini"></textarea>
            <?php
          }else{
            ?>
            <textarea name="tanggapan" id="tanggapan" class="form-control tanggapan" disabled><?php echo $fetchTanggapan['tanggapan'];?></textarea>
            <?php
          }
          ?>

                    <label for="isiLaporan">Isi Laporan</label>
          <textarea name="isiLaporan" id="isiLaporan" class="form-control isi-laporan" disabled><?php echo $fetch_laporan['isi_laporan']?></textarea>
                    
          <?php
          if($hitungTanggapan < 1){
            ?>
            <div class="row mt-4">
              <div class="col-md-6">
                <button type="button" class="btn btn-success w-100" onclick="processLaporan(<?php echo $id_pengaduan?>, 'selesai')">
                  <i class="fas fa-check"></i> Selesai
                </button>
              </div>
              <div class="col-md-6">
                <button type="button" class="btn btn-danger w-100" onclick="processLaporan(<?php echo $id_pengaduan?>, 'ditolak')">
                  <i class="fas fa-times"></i> Tolak
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
            </div>
            <div class="col-md-6 col-sm-11 align-items-center justify-content-center text-center mt-5">
        <p>Foto</p>
        <img src="../storages/foto_laporan/<?php echo $fetch_laporan['foto']; ?>" alt="image laporan" class="img-fluid" style="max-height: 500px; cursor: pointer;" 
     data-bs-toggle="modal" 
     data-bs-target="#imageModal" 
     onclick="openImageModal(this.src)">
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

function processLaporan(idPengaduan, status) {
  const tanggapan = document.getElementById('tanggapan').value.trim();
  
  if (tanggapan === '') {
    Swal.fire({
      icon: 'warning',
      title: 'Peringatan',
      text: 'Harap masukkan tanggapan terlebih dahulu!'
    });
    return;
  }

  const statusText = status === 'selesai' ? 'diselesaikan' : 'ditolak';
  const confirmText = status === 'selesai' ? 'Selesaikan' : 'Tolak';
  
  Swal.fire({
    title: 'Apakah Anda yakin?',
    text: `Laporan ini akan ${statusText} dan tanggapan akan disimpan.`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: status === 'selesai' ? '#28a745' : '#dc3545',
    cancelButtonColor: '#6c757d',
    confirmButtonText: confirmText,
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      // Send data to server
      fetch('processLaporan.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          id_pengaduan: idPengaduan,
          tanggapan: tanggapan,
          status: status
        }),
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: `Laporan berhasil ${statusText}!`
          }).then(() => {
            window.location.href = 'list_pengaduan.php';
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: data.message || 'Gagal memproses laporan'
          });
        }
      })
      .catch(error => {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Terjadi kesalahan saat memproses laporan'
        });
      });
    }
  });
}
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>