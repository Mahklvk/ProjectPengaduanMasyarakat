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

$filtervalues = $_GET['search'] ?? '';
$filterkategori = $_GET['kategori'] ?? '';
$filtertanggal = $_GET['tanggal'] ?? '';

// Pagination variables
$limit = 6; // Batas data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Escape NIK untuk keamanan
$escapedNik = mysqli_real_escape_string($conn, $nik);

// Query untuk menghitung total data - PERBAIKAN DI SINI
$countQuery = "SELECT COUNT(*) as total FROM pengaduan WHERE nik = '$escapedNik'";
$whereConditions = [];

// Tambahkan filter untuk counting dengan proper escaping
if ($filtervalues !== '') {
    $escapedFilter = mysqli_real_escape_string($conn, $filtervalues);
    $whereConditions[] = "CONCAT(judul_laporan, isi_laporan, nik) LIKE '%$escapedFilter%'";
}
if ($filterkategori !== '') {
    $escapedKategori = mysqli_real_escape_string($conn, $filterkategori);
    $whereConditions[] = "kategori = '$escapedKategori'";
}
if ($filtertanggal !== '') {
    $escapedTanggal = mysqli_real_escape_string($conn, $filtertanggal);
    $whereConditions[] = "tgl_pengaduan = '$escapedTanggal'";
}

// PERBAIKAN: Gunakan AND bukan WHERE karena sudah ada WHERE nik
if (!empty($whereConditions)) {
    $countQuery .= " AND " . implode(" AND ", $whereConditions);
}

// Debug query (uncomment untuk debugging)
// echo "Count Query: " . $countQuery . "<br>";

$countResult = mysqli_query($conn, $countQuery);

// Error handling untuk count query
if (!$countResult) {
    die("Error in count query: " . mysqli_error($conn));
}

$totalData = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($totalData / $limit);

// Query untuk mengambil data dengan pagination - PERBAIKAN DI SINI JUGA
$query = "SELECT * FROM pengaduan WHERE nik = '$escapedNik'";

// PERBAIKAN: Gunakan AND bukan WHERE karena sudah ada WHERE nik
if (!empty($whereConditions)) {
    $query .= " AND " . implode(" AND ", $whereConditions);
}

$query .= " ORDER BY tgl_pengaduan DESC LIMIT $limit OFFSET $offset";

// Debug query (uncomment untuk debugging)
// echo "Data Query: " . $query . "<br>";

$result = mysqli_query($conn, $query);

// Error handling untuk data query
if (!$result) {
    die("Error in data query: " . mysqli_error($conn));
}
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

   /* Pagination Styles */
  .pagination-container {
    margin-top: 30px;
    display: flex;
    justify-content: center;
  }

  .pagination .page-link {
    background-color: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #fff;
    backdrop-filter: blur(5px);
  }

  .pagination .page-link:hover {
    background-color: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.3);
    color: #fff;
  }

  .pagination .page-item.active .page-link {
    background-color: #3E6EA2;
    border-color: #3E6EA2;
    color: #fff;
  }

  .pagination .page-item.disabled .page-link {
    background-color: rgba(255, 255, 255, 0.05);
    border-color: rgba(255, 255, 255, 0.1);
    color: rgba(255, 255, 255, 0.5);
  }

  .data-info {
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.9rem;
    margin-bottom: 20px;
  }
        .page-title {
            font-size: 50px;
            font-weight: bold;
            margin-bottom: 20px;
            color: whitesmoke;
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
  <input type="hidden" name="page" value="1">
</form>
  <!-- Info jumlah data -->
  <?php if ($totalData > 0): ?>
    <div class="data-info">
      Menampilkan <?= ($offset + 1) ?> - <?= min($offset + $limit, $totalData) ?> dari <?= $totalData ?> data
    </div>
  <?php endif; ?>

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

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
    <div class="pagination-container">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <!-- Previous button -->
                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $page - 1])) ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>

                <?php
                // Menentukan range halaman yang ditampilkan
                $start_page = max(1, $page - 2);
                $end_page = min($totalPages, $page + 2);

                // Jika di awal, tampilkan lebih banyak halaman ke kanan
                if ($page <= 3) {
                    $end_page = min($totalPages, 5);
                }
                
                // Jika di akhir, tampilkan lebih banyak halaman ke kiri
                if ($page > $totalPages - 3) {
                    $start_page = max(1, $totalPages - 4);
                }

                // Tampilkan halaman pertama jika tidak termasuk dalam range
                if ($start_page > 1) {
                    echo '<li class="page-item"><a class="page-link" href="?' . http_build_query(array_merge($_GET, ['page' => 1])) . '">1</a></li>';
                    if ($start_page > 2) {
                        echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                    }
                }

                // Tampilkan halaman dalam range
                for ($i = $start_page; $i <= $end_page; $i++):
                ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                        <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"><?= $i ?></a>
                    </li>
                <?php endfor;

                // Tampilkan halaman terakhir jika tidak termasuk dalam range
                if ($end_page < $totalPages) {
                    if ($end_page < $totalPages - 1) {
                        echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                    }
                    echo '<li class="page-item"><a class="page-link" href="?' . http_build_query(array_merge($_GET, ['page' => $totalPages])) . '">' . $totalPages . '</a></li>';
                }
                ?>

                <!-- Next button -->
                <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $page + 1])) ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <?php endif; ?>
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
