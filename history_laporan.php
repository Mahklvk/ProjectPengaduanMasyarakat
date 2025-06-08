<?php
require('config/session.php');
require('config/db.php');

if (isset($_SESSION['nik'])) {
    $nik = $_SESSION['nik'];
} else {
    if (isset($_SESSION['id_user'])) {
        $nik = $_SESSION['id_user'];
    } elseif (isset($_SESSION['user_id'])) {
        $nik = $_SESSION['user_id'];
    } elseif (isset($_SESSION['id'])) {
        $nik = $_SESSION['id'];
    } else {
        $_SESSION['message'] = "Sesi tidak valid. Silakan login kembali.";
        $_SESSION['message_type'] = "error";
        header("Location: login.php");
        exit();
    }
}

$filtervalues = mysqli_real_escape_string($conn, $_GET['search'] ?? '');
$filterkategori = mysqli_real_escape_string($conn, $_GET['kategori'] ?? '');
$filtertanggal = mysqli_real_escape_string($conn, $_GET['tanggal'] ?? '');

$query = "SELECT * FROM pengaduan WHERE nik = '$nik'";

// Tambahkan filter hanya jika tidak kosong
if ($filtervalues !== '') {
    $query .= " AND CONCAT(judul_laporan, isi_laporan, nik) LIKE '%$filtervalues%'";
}
if ($filterkategori !== '') {
    $query .= " AND kategori = '$filterkategori'";
}
if ($filtertanggal !== '') {
    $query .= " AND tgl_pengaduan = '$filtertanggal'";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Laporan - MyReport</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap & FontAwesome -->
  <!-- Bootstrap, Font Awesome, Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.6), rgba(0, 123, 255, 0.4));
            color: white;
            min-height: 100vh;
            z-index: -1;
        }

        .card-glass {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 15px;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            color: #fff;
        }

        .search-form {
            background-color: rgba(255,255,255,0.1);
            padding: 1rem;
            border-radius: 1rem;
            margin-bottom: 2rem;
            backdrop-filter: blur(5px);
        }

        .card-img-top {
            max-height: 180px;
            object-fit: cover;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }

        .badge {
            font-size: 0.9rem;
        }

        .btn-primary {
            position: fixed;
            bottom: 5rem;
            right: 4rem;
            background-color: #3E6EA2;
            border-color: #3E6EA2;
            z-index: 1;
        }

        .input-with-clear {
    position: relative;
  }

  .input-with-clear input {
    padding-right: 2rem;
  }

  .clear-btn {
    position: absolute;
    right: 0.6rem;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    font-weight: bold;
    color: #888;
    background: transparent;
    border: none;
    font-size: 1rem;
    display: none;
  }

  .input-with-clear input:not(:placeholder-shown) + .clear-btn {
    display: block;
  }

  .clear-btn:hover {
    color: #333;
  }
    </style>
</head>
<body>

<?php include('config/navbar.php'); ?>

<div class="container mt-4">
    <h2 class="text-white mb-4">Daftar Laporan</h2>

    <!-- Filter Form -->
    <form class="search-form" method="GET">
  <div class="row g-3">
    <div class="col-md-12 input-with-clear">
      <input type="text" name="search" class="form-control" placeholder="Cari judul / isi laporan..." id="searchInput" value="<?= htmlspecialchars($filtervalues) ?>">
      <button type="button" class="clear-btn" onclick="document.getElementById('searchInput').value='';">×</button>
    </div>

    <div class="col-md-4 input-with-clear">
      <input type="text" name="kategori" class="form-control" placeholder="Kategori" id="kategoriInput" value="<?= htmlspecialchars($filterkategori) ?>">
      <button type="button" class="clear-btn" onclick="document.getElementById('kategoriInput').value='';">×</button>
    </div>

    <div class="col-md-4">
      <input type="date" name="tanggal" class="form-control" id="tanggalInput" value="<?= htmlspecialchars($filtertanggal) ?>">
    </div>

    <div class="col-md-4">
      <button class="btn btn-outline-light w-100">Search</button>
    </div>
  </div>
</form>

    <!-- Card Grid -->
    <div class="row g-4 mb-2">
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($data = mysqli_fetch_array($result)) {
                $status = trim($data['status']);
                $class = match ($status) {
                    'diproses' => 'secondary',
                    'ditolak'  => 'danger',
                    'selesai'  => 'success',
                    default    => 'light'
                };
        ?>
        <div class="col-md-4">
            <div class="card card-glass h-100">
                <img src="storages/foto_laporan/<?= $data['foto'] ?>" class="card-img-top" alt="Foto Laporan">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($data['judul_laporan']) ?></h5>
                    <p class="card-text"><strong>Kategori:</strong> <?= $data['kategori'] ?></p>
                    <p class="card-text"><strong>Tanggal:</strong> <?= $data['tgl_pengaduan'] ?></p>
                    <p class="card-text"><strong>Alamat:</strong> <?= $data['alamat'] ?></p>
                    <p class="card-text"><strong>Isi:</strong> <?= strlen($data['isi_laporan']) > 100 ? substr($data['isi_laporan'], 0, 100) . '...' : $data['isi_laporan']; ?></p>
                    <span class="badge bg-<?= $class ?>"><?= htmlspecialchars($status) ?></span>
                </div>
                <div class="card-footer bg-transparent border-0 text-end">
                    <a href="detailHistoryLaporan.php?p=<?= $data['id_pengaduan'] ?>" class="btn btn-sm btn-outline-light">Detail</a>
                </div>
            </div>
        </div>
        <?php
            }
        } else {
            echo "<div class='col-12 text-center'><div class='alert alert-light text-dark'>Tidak ada laporan ditemukan.</div></div>";
        }
        ?>
    </div>
</div>
<!-- Add Report Button -->
<button class="btn btn-primary" id="addReportBtn">
    <i class="bi bi-plus-circle"></i> Buat Laporan
</button>
<!-- jQuery dulu -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- lalu Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Tampilkan tombol "X" jika input ada isinya (untuk pertama kali halaman dimuat)
  document.querySelectorAll('.input-with-clear input').forEach(input => {
    if (input.value) {
      input.nextElementSibling.style.display = 'block';
    }

    // Tambahkan event input agar tombol X muncul/hilang saat mengetik
    input.addEventListener('input', () => {
      input.nextElementSibling.style.display = input.value ? 'block' : 'none';
    });
  });
     $(document).ready(function() {
    $('#kategori').select2({
      tags: true,
      placeholder: "Pilih atau ketik kategori",
      allowClear: true
    });
  });
  
    document.getElementById('addReportBtn').addEventListener('click', () => {
        window.location.href = 'tulisLaporan.php';
    });
</script>

</body>
</html>
