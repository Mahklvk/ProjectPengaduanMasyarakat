<?php 
require('config/db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
    <title>Document</title>

    <style>
      .about{
        background: #e0e0e0;
      }
        .h1-carousel-caption{
            font-weight: bolder;
        }
        .btn-costum{
            background-color: #38758E;
            color: white;
        }

        .btn-costum:hover{
            background-color:rgb(37, 150, 195);
            color: white;
        }

        .carousel-img{
            filter: brightness(1.2);
        }

    </style>
</head>
<body>
    <?php include('config/navbar.php')?>
    <section id="hero" class="hero">
    <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="storages/hero-bg.png" class="d-block w-100 carousel-img" alt="...">
      <div class="carousel-caption d-block top-0 text-black mt-md-5">
        <h1 class="h1-carousel-caption">PENGADUAN MASYARAKAT</h1>
        <p class="p-carousel-caption mt-md-4">Adukan <b>Masalah</b> Temukan <b>Solusi</b></p>
        <button type="button" class="btn btn-costum mt-md-5">Mulai Lapor</button>
      </div>
    </div>
  </div>
</div>

    </section>

    <section id="about" class="about py-5">
        <div class="container">
            <div class="row">
                <div class="container col-md-12 text-center">
                    <h2 class="mb-5">About</h2>
                    </div>
                    <div class="container col-md-6 text">
                    <p class="text">Sampaikan aspirasi dan keluhan Anda secara mudah melalui satu platform digital. Aplikasi Pelaporan Masyarakat hadir untuk menjembatani komunikasi antara masyarakat dan instansi, dengan proses yang cepat, transparan, dan responsif.</p>
                    <div class="col-6 container align-items-center justify-content-center d-flex mt-5 mb-5">
                      <button class="btn btn-costum">Mulai Lapor</button>
                    </div>
                </div>
                <div class="container col-md-3 img-about">
                    <img src="storages/bllack.png" alt="About Us" class="img-fluid">
                </div>
            </div>
        </div>
    </section>



    <script src="assets/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="assets/fontawesome/js/all.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
</body>
</html>