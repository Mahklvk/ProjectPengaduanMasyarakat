<?php
// contoh jika login berhasil, simpan: $_SESSION['username'] = 'NamaUser';
// Include fungsi notifikasi jika user sudah login
if (isset($_SESSION['username'])) {
    require_once 'config/functions_notifikasi.php';
    $notifikasi_count = hitungNotifikasiBelumDibaca($_SESSION['username'], $conn);
    $notifikasi_list = getNotifikasi($_SESSION['username'], $conn);
}
?>

<nav class="navbar navbar-expand-lg navbar-custom sticky-top shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand ms-3" href="index.php">
      <img src="storages/logo.png" alt="logo" width="35px">
      <img src="storages/MyReport.png" alt="logo" width="100px" class="ms-2">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="index.php">
            <img src="assets/featherIcon/home.png" width="20px" class="me-2 mb-1">Home
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php#about">
            <img src="assets/featherIcon/info.png" width="20px" class="me-2 mb-1">About
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php#contact">
            <img src="assets/featherIcon/phone.png" width="20px" class="me-2 mb-1">Contact
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown">
            Lainnya
          </a>
          <ul class="dropdown-menu dropdown-menu-dark">
            <li><a class="dropdown-item" href="history_laporan.php"><img src="assets/featherIcon/list.png" width="20px" class="me-2 mb-1">List Laporan</a></li>
            <li><a class="dropdown-item" href="tulisLaporan.php"><img src="assets/featherIcon/plus.png" width="20px" class="me-2 mb-1">Buat Laporan</a></li>
          </ul>
        </li>
      </ul> 

      <form class="d-flex align-items-center" role="search">
        <?php if (isset($_SESSION['username'])): ?>
          <!-- Notifikasi Dropdown -->
          <div class="dropdown me-3">
            <button class="btn btn-outline-light position-relative" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-bell"></i>
              <?php if ($notifikasi_count > 0): ?>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                  <?= $notifikasi_count > 99 ? '99+' : $notifikasi_count ?>
                </span>
              <?php endif; ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end notification-dropdown" aria-labelledby="notificationDropdown" style="width: 350px; max-height: 400px; overflow-y: auto;">
              <li class="dropdown-header d-flex justify-content-between align-items-center">
                <span>Notifikasi</span>
                <?php if ($notifikasi_count > 0): ?>
                  <button type="button" class="btn btn-sm btn-outline-light" onclick="tandaiSemuaDibaca()">
                    <i class="fas fa-check-double"></i> Tandai Semua
                  </button>
                <?php endif; ?>
              </li>
              <li><hr class="dropdown-divider"></li>
              
              <?php if (empty($notifikasi_list)): ?>
                <li class="dropdown-item-text text-center py-3">
                  <i class="fas fa-bell-slash mb-2"></i><br>
                  Tidak ada notifikasi
                </li>
              <?php else: ?>
                <?php foreach ($notifikasi_list as $notif): ?>
                  <li>
                    <a class="dropdown-item notification-item <?= $notif['status'] == 'belum_dibaca' ? 'unread' : '' ?>" 
                       href="#" onclick="bacaNotifikasi(<?= $notif['id_notifikasi'] ?>)">
                      <div class="d-flex align-items-start">
                        <div class="notification-icon me-2">
                          <?php if ($notif['tipe_notifikasi'] == 'diproses'): ?>
                            <i class="fas fa-spinner text-warning"></i>
                          <?php elseif ($notif['tipe_notifikasi'] == 'selesai'): ?>
                            <i class="fas fa-check-circle text-success"></i>
                          <?php else: ?>
                            <i class="fas fa-times-circle text-danger"></i>
                          <?php endif; ?>
                        </div>
                        <div class="flex-grow-1">
                          <div class="notification-text">
                            <?= htmlspecialchars($notif['pesan']) ?>
                          </div>
                          <small class="text-muted">
                            <?= date('d M Y, H:i', strtotime($notif['tanggal_dibuat'])) ?>
                          </small>
                        </div>
                        <?php if ($notif['status'] == 'belum_dibaca'): ?>
                          <div class="notification-badge"></div>
                        <?php endif; ?>
                      </div>
                    </a>
                  </li>
                <?php endforeach; ?>
              <?php endif; ?>
            </ul>
          </div>

          <!-- Username Dropdown -->
          <div class="dropdown me-3">
            <button class="btn btn-outline-light dropdown-toggle costum-btn rounded-pill" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
              <?= htmlspecialchars($_SESSION['username']) ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="userDropdown">
              <li><a class="dropdown-item" href="dashboard.php">Profile</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="config/logout.php">Logout</a></li>
            </ul>
          </div>
        <?php else: ?>
          <button type="button" class="btn btn-outline-light me-3 costum-btn" onclick="window.location.href='login.php'">
            Login <img src="assets/featherIcon/login.png" width="20px" class="ms-2 mb-1">
          </button>
        <?php endif; ?>
      </form>
    </div>
  </div>
</nav>

<style>
  .navbar-custom {
    background: linear-gradient(90deg, #3E6EA2, #5995DA);
  }

  .nav-link {
    color: #fff;
  }

  .nav-link:hover {
    color: #ffffff;
  }

  .dropdown-menu-dark {
    background-color: #3E6EA2;
  }

  .costum-btn {
    margin-left: 10px;
  }

  .costum-btn:hover {
    background-color: rgb(70, 139, 212);
    color: white;
  }

  .costum-btn:active {
    background-color: rgb(66, 116, 171);
    color: white;
  }

  .sticky-top {
    z-index: 1030;
  }

  /* Notification Styles */
  .notification-dropdown {
    border: 1px solid rgba(255, 255, 255, 0.2);
  }

  .notification-item {
    padding: 12px 16px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    transition: background-color 0.2s;
  }

  .notification-item:hover {
    background-color: rgba(255, 255, 255, 0.1);
  }

  .notification-item.unread {
    background-color: rgba(255, 255, 255, 0.05);
    border-left: 3px solid #ffc107;
  }

  .notification-text {
    font-size: 0.9em;
    line-height: 1.4;
    margin-bottom: 4px;
  }

  .notification-badge {
    width: 8px;
    height: 8px;
    background-color: #dc3545;
    border-radius: 50%;
    margin-left: 8px;
    flex-shrink: 0;
  }

  .notification-icon {
    font-size: 1.1em;
    margin-top: 2px;
  }
</style>

<script>
function bacaNotifikasi(idNotifikasi) {
  fetch('config/baca_notifikasi.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({
      id_notifikasi: idNotifikasi
    }),
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      // Refresh halaman untuk update badge notifikasi
      location.reload();
    }
  })
  .catch(error => {
    console.error('Error:', error);
  });
}

function tandaiSemuaDibaca() {
  fetch('config/tandai_semua_dibaca.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      // Refresh halaman untuk update badge notifikasi
      location.reload();
    }
  })
  .catch(error => {
    console.error('Error:', error);
  });
}
</script>