<?php
// contoh jika login berhasil, simpan: $_SESSION['username'] = 'NamaUser';
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
          <!-- Notifikasi -->

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
</style>
