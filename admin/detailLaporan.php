<?php
require "config/sessionLogin.php";
require('../config/db.php');
$id = $_GET['p'];
$querySelectLaporan = mysqli_query($conn, "SELECT * FROM pengaduan WHERE id_pengaduan='$id'");
$fetch_data = mysqli_fetch_array($querySelectLaporan);


$querySelectPengaduan = mysqli_query($conn, "SELECT * FROM tanggapan");
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Detail Laporan - MyReport</title>
    <style>
            .modal-body {
    padding: 0 !important;
  }

  .image-container img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    transform-origin: center center;
    will-change: transform;
  }
    </style>
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

<?php
          if($hitungPengaduan < 1){
            ?>
            <label for="">Tanggapan</label>
            <textarea name="tanggapan" id="tanggapan" class="form-control"disabled>Petugas Belum Memberikan Tanggapan</textarea>
            <?php
          }else{
            ?>
            <label for="">Tanggapan</label>
            <textarea name="tanggapan" id="tanggapan" class="form-control"disabled><?php echo $dataPengaduan['tanggapan'];?></textarea>
            <?php
          }
          ?>

          <label for="isiLaporan">Isi Laporan</label>
          <textarea name="isiLaporan" id="isiLaporan" class="form-control" disabled><?php echo $fetch_data['isi_laporan']?></textarea>

          <label for="foto">Upload Foto</label>
          <input type="file" class="form-control" name="foto" id="foto" disabled>

          <div class="row">
            <div class="container align-items-center justify-content-center d-flex mt-2 col-md-6">
            <button type="button" class="btn btn-primary me-2" name="approve" onclick="approveLaporan(<?php echo $fetch_data['id_pengaduan']?>)">Selesai</button>
            </div>
            <div class="container align-items-center justify-content-center d-flex mt-2 col-md-6">
            <button type="button" class="btn btn-danger" onclick="rejectLaporan(<?php echo $fetch_data['id_pengaduan']?>)">Tolak</button>
            </div>
          </div>
          </form>
            </div>
            <div class="col-md-6 col-sm-11 align-items-center justify-content-center text-center mt-5 mb-5">
        <p>Current Photo</p>
        <img src="../storages/foto_laporan/<?php echo $fetch_data['foto']; ?>" alt="image laporan" class="img-fluid" style="max-height: 200px; cursor: pointer;" 
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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
          window.location.href = 'list_pengaduan.php';
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
          window.location.href = 'list_pengaduan.php';
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