<?php 
require "config/sessionLogin.php";
require('../config/db.php');

// Cek apakah ada pencarian
$filtervalues = $_GET['search'] ?? '';
$filterlevel = $_GET['level'] ?? '';

// Pagination variables
$limit = 6; // Batas data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Query untuk menghitung total data
$countQuery = "SELECT COUNT(*) as total FROM petugas";
$whereConditions = [];

// Tambahkan filter untuk counting dengan proper escaping
if ($filtervalues !== '') {
    $escapedFilter = mysqli_real_escape_string($conn, $filtervalues);
    $whereConditions[] = "CONCAT(username, email, nik, telp) LIKE '%$escapedFilter%'";
}
if ($filterlevel !== '') {
    $escapedLevel = mysqli_real_escape_string($conn, $filterlevel);
    $whereConditions[] = "level = '$escapedLevel'";  // Menggunakan 'level' bukan 'role'
}

if (!empty($whereConditions)) {
    $countQuery .= " WHERE " . implode(" AND ", $whereConditions);
}

// Debug: Tampilkan query untuk debugging (hapus setelah fixed)
// echo "Count Query: " . $countQuery . "<br>";

$countResult = mysqli_query($conn, $countQuery);

// Error handling untuk count query
if (!$countResult) {
    die("Error in count query: " . mysqli_error($conn));
}

$totalData = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($totalData / $limit);

// Query untuk mengambil data dengan pagination
$query = "SELECT * FROM petugas";

if (!empty($whereConditions)) {
    $query .= " WHERE " . implode(" AND ", $whereConditions);
}

$query .= " ORDER BY level DESC LIMIT $limit OFFSET $offset";

// Debug: Tampilkan query untuk debugging (hapus setelah fixed)
// echo "Data Query: " . $query . "<br>";

$result = mysqli_query($conn, $query);

// Error handling untuk data query
if (!$result) {
    die("Error in data query: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Akun - MyReport</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <style>
    body {
      background: linear-gradient(135deg, rgba(0, 0, 0, 0.6), rgba(0, 123, 255, 0.4));
      font-family: 'Segoe UI', sans-serif;
       min-height: 100vh;
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
        .btn-add-akun {
            position: fixed;
            bottom: 2rem;
            right: 1rem;
            background-color: #3E6EA2;
            border-color: #3E6EA2;
        }

        .page-title {
            font-size: 50px;
            font-weight: bold;
            margin-bottom: 20px;
            color: whitesmoke;
        }
                .content-container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
         .search-form {
            background-color: rgba(255,255,255,0.1);
            padding: 1rem;
            border-radius: 1rem;
            margin-bottom: 2rem;
            backdrop-filter: blur(5px);
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

  .btn-add-akun {
            position: fixed;
            bottom: 2rem;
            right: 4rem;
            background-color: #3E6EA2;
            border-color: #3E6EA2;
            z-index: 1;
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
  </style>
</head>
<body>
  <?php include('config/navbar.php')?>
<div class="content-container">
  <h1 class="page-title">Daftar Akun</h1>

<div class="row">
    <div class="col-md-12 col-sm-6 input-icons">
      <form class="search-form" method="GET">
  <div class="row g-3">
    <div class="col-md-12 input-with-clear">
      <input type="text" name="search" class="form-control" placeholder="Username, Email, NIK, Nomor Telpon" id="searchInput" value="<?= htmlspecialchars($filtervalues) ?>">
      <button type="button" class="clear-btn" onclick="document.getElementById('searchInput').value='';">×</button>
    </div>
   <div class="col-md-4">
  <select name="level" class="form-select" id="kategoriSelect">
    <option value="">Semua Role</option>
    <option value="petugas" <?= $filterlevel === 'petugas' ? 'selected' : '' ?>>Petugas</option>
    <option value="admin" <?= $filterlevel === 'admin' ? 'selected' : '' ?>>Admin</option>
  </select>
</div>

    <div class="col-md-3">
      <button class="btn btn-outline-light w-100">Search</button>
    </div>
  </div>
  <input type="hidden" name="page" value="1">
</form>

  <?php if ($totalData > 0): ?>
    <div class="data-info">
      Menampilkan <?= ($offset + 1) ?> - <?= min($offset + $limit, $totalData) ?> dari <?= $totalData ?> data
    </div>
  <?php endif; ?>
    </div>
    <!-- <div class="col-md-4 text-end">
      <button type="button" class="btn btn-outline-secondary"><i class="fa-solid fa-circle-plus"></i> Tambah Akun</button>
    </div> -->
  </div>
<div class="row g-4 mb-2">
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($data = mysqli_fetch_array($result)) {
        ?>
        <div class="col-md-4">
            <div class="card card-glass h-100">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($data['username']) ?></h5>
                    <p class="card-text"><strong>NIK: </strong> <?= $data['nik'] ?></p>
                    <p class="card-text"><strong>Email: </strong> <?= $data['email'] ?></p>
                    <p class="card-text"><strong>Telp:</strong> <?= $data['telp'] ?></p>
                    <p class="card-text"><strong>Role:</strong> <?= $data['level'] ?></p>
                </div>
                <div class="card-footer bg-transparent border-0 text-end">
                    <a href="accountDetailAdmin.php?p=<?= $data['id_petugas'] ?>" class="btn btn-sm btn-outline-light">Detail</a>
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
<button class="btn btn-primary btn-add-akun" id="addAkun">
    <i class="fa fa-plus-circle"></i> Tambah Akun
</button>
<script>
     document.getElementById('addAkun').addEventListener('click', () => {
        window.location.href = 'buatAkun.php';
    });
  document.querySelectorAll('.input-with-clear input').forEach(input => {
    if (input.value) {
      input.nextElementSibling.style.display = 'block';
    }

    // Tambahkan event input agar tombol X muncul/hilang saat mengetik
    input.addEventListener('input', () => {
      input.nextElementSibling.style.display = input.value ? 'block' : 'none';
    });
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js"></script>
</body>
</html>
