<nav class="navbar navbar-expand-lg navbar-custom">
  <div class="container-fluid">
    <a class="navbar-brand ms-3" href="#"><img src="storages/logo.png" alt="logo" width="35px"><img src="storages/MyReport.png" alt="logo" width="100px" class="ms-2"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="#"><img src="assets/featherIcon/home.png" width="20px" class="me-2 mb-1">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"><img src="assets/featherIcon/info.png" width="20px" class="me-2 mb-1">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"><img src="assets/featherIcon/phone.png" width="20px" class="me-2 mb-1">Contact</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Lainnya
          </a>
          <ul class="dropdown-menu dropdown-menu-dark">
            <li><a class="dropdown-item" href="#"><img src="assets/featherIcon/user.png" width="20px" class="me-2 mb-1">Dashboard</a></li>
            <li><a class="dropdown-item" href="#"><img src="assets/featherIcon/list.png" width="20px" class="me-2 mb-1">List Laporan</a></li>
            <li><a class="dropdown-item" href="#"><img src="assets/featherIcon/plus.png" width="20px" class="me-2 mb-1">Buat Laporan</a></li>
          </ul>
        </li>
      </ul>
      <form class="d-flex" role="search">
      <button type="button" class="btn btn-outline-light me-5 costum-btn">Login<img src="assets/featherIcon/login.png" width="20px" class="ms-2 mb-1"></button>
      </form>
    </div>
  </div>
</nav>

<style>
    .navbar-custom{
        background-color: #3E6EA2;
    }

    .nav-link{
        color: rgb(235, 223, 223);
    }
    .nav-link:hover{
        color:rgb(255, 255, 255);
    }

    .dropdown-menu-dark{
        background-color: #3E6EA2;
    }

    .costum-btn:hover{
      background-color:rgb(70, 139, 212);
      color: white;
    }

    .costum-btn:active{
      background-color:rgb(66, 116, 171);
      color: white;
    }
</style>