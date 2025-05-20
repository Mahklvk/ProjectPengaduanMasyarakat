<?php
session_start();
require('config/db.php'); //include database 
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css"> <!-- link bootstrap untuk bisa styling bootstrap -->
  <link rel="stylesheet" href="assets/fontawesome/css/all.min.css"> <!-- link fontawesome untuk bisa mengakses icon -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <title>MyReport</title>
  <style>
            .btn-up {
            position: fixed;
            bottom: 5rem;
            right: 4rem;
            background-color: #3E6EA2;
            border-color: #3E6EA2;
            width: 5rem;
            height: 3rem;
        }

        .form-custom{
          border-top: none;
          border-right:none ;
          border-left: none;
          border-radius: 0;
        }

        .input-custom{
          border-radius: 0;
          border-top: none;
          border-right:none ;
          border-left: none;
          background-color: white;
        }

  </style>
</head>

<body>
  <?php include('config/navbar.php') //include navbar
  ?>
  <section id="hero" class="hero">
    <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="storages/hero-bg.png" class="d-block w-100 carousel-img" alt="..."> <!-- carousel untuk menampilkan gambar di hero section-->
          <div class="carousel-caption d-block top-0 text-black mt-md-5">
            <h1 class="h1-carousel-caption">PENGADUAN MASYARAKAT</h1>
            <p class="p-carousel-caption mt-md-4">Adukan <b>Masalah</b> Temukan <b>Solusi</b></p>
            <a href="tulisLaporan.php"><button type="button" class="btn btn-costum mt-md-5">Mulai Lapor</button></a> <!--caption yang ada di gambar-->
          </div>
        </div>
      </div>
    </div>

  </section>

  <section id="about" class="about py-5">
  <div class="container">
    <h2 class="text-center mb-4">About</h2>
    <div class="row align-items-center">
      <div class="col-lg-6 col-md-12 mb-4">
        <p>Sampaikan aspirasi dan keluhan Anda secara mudah melalui satu platform digital. Aplikasi Pelaporan Masyarakat hadir untuk menjembatani komunikasi antara masyarakat dan instansi, dengan proses yang cepat, transparan, dan responsif.</p>
        <div class="text-center text-md-start mt-4">
          <a href="tulisLaporan.php">
            <button class="btn btn-costum">Mulai Lapor</button>
          </a>
        </div>
      </div>
      <div class="col-lg-6 col-md-12 text-center">
        <img src="storages/about-imgv1.png" alt="About Us" class="img-fluid shadow-costum">
      </div>
    </div>
  </div>
</section>

<section id="contact" class="py-5">
  <div class="container">
    <h1 class="text-center mb-5">Contact Us</h1>
    <div class="row g-4">
      <!-- Map -->
      <div class="col-md-5">
        <iframe class="shadow w-100" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3959.9516624298767!2d107.64888750931945!3d-7.014967668684224!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e6f9cd53f7b9%3A0xf84e76c83055f248!2sSMKN%207%20Baleendah!5e0!3m2!1sid!2sid!4v1745628066995!5m2!1sid!2sid" width="300" height="200" style="border:0; border-radius:10px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>

      <!-- Form -->
      <div class="col-md-7">
        <form action="" method="post">
          <!-- Nama -->
          <div class="mb-3 input-group form-custom">
            <span class="input-group-text input-custom"><i class="fa-solid fa-user"></i></span>
            <input type="text" class="form-custom form-control" name="nama" placeholder="Nama Kamu" required>
          </div>

          <!-- Email -->
          <div class="mb-3 input-group form-custom">
            <span class="input-group-text input-custom"><i class="fa-solid fa-envelope"></i></span>
            <input type="email" class="form-custom form-control" name="email" placeholder="Email Kamu" required>
          </div>

          <!-- Isi kontak -->
          <div class="mb-3 input-group form-custom">
            <span class="input-group-text input-custom"><i class="fa-solid fa-comment-dots"></i></span>
            <textarea class="form-custom form-control" name="isi_kontak" rows="2" cols="2" placeholder="Bagikan pendapatmu..." required></textarea>
          </div>

          <!-- Tombol submit -->
          <div class="text-start">
            <button class="btn btn-costum" name="submit">Bagikan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
                  <a href="#"><button class="btn btn-costum btn-up" id="addReportBtn">
                <i class="fa fa-eject"></i>
            </button></a>
<?php
require 'config/db.php';

if(isset($_POST['submit'])){
  $nama = htmlspecialchars($_POST['nama']);
  $email = htmlspecialchars($_POST['email']);
  $isi_kontak = htmlspecialchars($_POST['isi_kontak']);
  $query = mysqli_query($conn, "INSERT INTO kontak(nama, email, isi_kontak) VALUES ('$nama', '$email', '$isi_kontak')");

  if($query){
    ?>
  <script>
  Swal.fire({
  title: 'Berhasil!',
  text: 'Terimakasih, petugas kami akan segera menghubungi anda kembali!',
   icon: 'success'
     }).then(() => {
       window.location.href = 'index.php#contact';
        });;
    </script>
    <?php
  }else{
    ?>
      <script>
  Swal.fire({
  title: 'Gagal!',
  text: 'Ada kesalahan! mohon ulangi',
   icon: 'error'
     });
    </script>
    <?php
  }
}
?>


  <footer>
    <?php
    include('config/footer.php');
    ?>
  </footer>

  <script src="assets/bootstrap/js/bootstrap.bundle.js"></script>
  <script src="assets/fontawesome/js/all.min.js"></script>
  <script src="https://unpkg.com/feather-icons"></script>
</body>

</html>