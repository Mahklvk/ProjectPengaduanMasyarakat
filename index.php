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
        <h1 class="h1-carousel-caption">PENGADUAN MASALAH</h1>
        <p class="p-carousel-caption mt-md-4">Adukan <b>Masalah</b> Temukan <b>Solusi</b></p>
        <button type="button" class="btn btn-costum mt-md-5">Mulai Lapor</button>
      </div>
    </div>
  </div>
</div>

    </section>



    <script src="assets/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="assets/fontawesome/js/all.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
</body>
</html>