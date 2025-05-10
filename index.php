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
  <title>Document</title>
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
      <div class="row">
        <div class="container">
          <h2 class="container text-center mb-3">About</h2>
        </div>
        <div class="container col-md-6 text text-justify mt-md-5">
          <p class="text">Sampaikan aspirasi dan keluhan Anda secara mudah melalui satu platform digital. Aplikasi Pelaporan Masyarakat hadir untuk menjembatani komunikasi antara masyarakat dan instansi, dengan proses yang cepat, transparan, dan responsif.</p>
          <div class="col-md-6 container align-items-center justify-content-center d-flex mb-5 mt-md-5">
           <a href="tulisLaporan.php"> <button class="btn btn-costum">Mulai Lapor</button></a>
          </div>
        </div>
        <div class="container col-md-3 img-about">
          <img src="storages/about-imgv1.png" alt="About Us" class="img-fluid shadow-costum">
        </div>
      </div>
    </div>
  </section>

  <section id="contact" class="py-4">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="container text-center">
            <h1>Contact Us</h1>
          </div>
        </div>
        <div class="col-md-4 container ms-4 rounded"><iframe claas="shadow" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3959.9516624298767!2d107.64888750931945!3d-7.014967668684224!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e6f9cd53f7b9%3A0xf84e76c83055f248!2sSMKN%207%20Baleendah!5e0!3m2!1sid!2sid!4v1745628066995!5m2!1sid!2sid" width="300" height="200" style="border:0; border-radius:10px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></div>
        <div class="col-md-7">
          <form action="" method="post">
            <i class="fa-solid fa-user"></i>
            <input type="username" placeholder="Nama Kamu" class="form-input" name="nama">
            <br>
            <i class="fa-solid fa-envelope"></i>
            <input type="email" placeholder="Email Kamu" class="form-input" name="email"><br>
            <textarea id="" placeholder="bagikan pendapatmu" class="form-textarea" name="isi_kontak"></textarea><br>
            <div class="col-md-5"><button class="container button-contact btn btn-costum mt-3 mb-5" name="submit">Bagikan</button></div>
          </form>
        </div>
      </div>
    </div>
  </section>
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