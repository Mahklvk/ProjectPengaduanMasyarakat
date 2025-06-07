<?php
session_start();
require('config/db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>MyReport</title>

  <!-- Bootstrap, Font Awesome, Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Custom Styles -->
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
      overflow-x: hidden;
      position: relative;
    }

    /* Parallax Background */
    .parallax-bg {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('assets/img/bg2.jpg') no-repeat center center fixed;
      background-size: cover;
      z-index: -2;
    }

    /* Gradient overlay with fade-in */
    .gradient-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, rgba(0, 0, 0, 0.6), rgba(0, 123, 255, 0.4));
      z-index: -1;
      opacity: 1;
      animation: fadeIn 2s ease-in forwards;
    }

     input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 16px;
            border: none;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            outline: none;
            transition: background 0.3s;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        textarea:focus {
            background: rgba(255, 255, 255, 0.2);
        }
    .glass {
      background: rgba(255, 255, 255, 0.1);
      border-radius: 16px;
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.2);
      padding: 2rem;
      color: #fff;
      box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.2 );
    }

    .carousel-img {
      max-height: 85vh;
      object-fit: cover;
      filter: brightness(0.6);
    }

    .carousel-caption h1 {
      font-size: 3.5rem;
      font-weight: bold;
      text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
    }

    .carousel-caption p {
      font-size: 1.3rem;
      text-shadow: 1px 1px 6px rgba(0, 0, 0, 0.6);
    }

    .btn-glass {
      background-color: rgba(255, 255, 255, 0.15);
      color: #fff;
      backdrop-filter: blur(6px);
      border: 1px solid rgba(255, 255, 255, 0.3);
      transition: 0.3s ease;
      border-radius: 10px;
    }

    .btn-glass:hover {
      background-color: rgba(255, 255, 255, 0.3);
    }

    .btn-up {
      position: fixed;
      bottom: 3rem;
      right: 2rem;
      background: rgba(255, 255, 255, 0.2);
      color: white;
      border: none;
      width: 3rem;
      height: 3rem;
      border-radius: 50%;
      backdrop-filter: blur(8px);
      z-index: 10;
    }

    footer {
      background: rgba(0, 0, 0, 0.3);
      backdrop-filter: blur(8px);
      color: #fff;
      text-align: center;
      padding: 1rem;
      margin-top: 4rem;
    }

    label {
      font-weight: 500;
    }
  </style>
</head>
<body>

  <!-- Background Layers -->
  <div class="parallax-bg"></div>
  <div class="gradient-overlay"></div>

  <?php include('config/navbar.php'); ?>

  <!-- Hero Section -->
  <section id="hero">
    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="storages/hero-bg.png" class="d-block w-100 carousel-img" alt="Hero Image" />
          <div class="carousel-caption text-start">
            <h1>PENGADUAN MASYARAKAT</h1>
            <p>Sampaikan masalahmu di sini secara <strong>bebas</strong> dan <strong>mudah</strong></p>
            <a href="tulisLaporan.php" class="btn btn-glass mt-3">Tulis Laporan</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- About Section -->
  <section id="about" class="py-5">
    <div class="container">
      <div class="glass">
        <h2 class="text-center mb-4">Tentang Kami</h2>
        <div class="row align-items-center">
          <div class="col-md-6 mb-4">
            <p class="fs-5">
              Platform ini mempermudah masyarakat untuk menyampaikan laporan atau keluhan kepada pihak berwenang.
              Setiap laporan ditangani dengan cepat, transparan, dan dapat dipantau secara real-time.
            </p>
            <a href="tulisLaporan.php" class="btn btn-glass mt-3">Mulai Lapor</a>
          </div>
          <div class="col-md-6 text-center">
            <img src="storages/botta.png" class="img-fluid" alt="Tentang Kami" width="300px"/>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section id="contact" class="py-5">
    <div class="container">
      <div class="glass">
        <h2 class="text-center mb-4">Hubungi Kami</h2>
        <div class="row g-4">
          <div class="col-md-5">
            <iframe class="w-100 rounded" height="250" style="border:0;" loading="lazy"
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3959.9516624298767!2d107.64888750931945!3d-7.014967668684224!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e6f9cd53f7b9%3A0xf84e76c83055f248!2sSMKN%207%20Baleendah!5e0!3m2!1sid!2sid!4v1745628066995!5m2!1sid!2sid">
            </iframe>
          </div>
          <div class="col-md-7">
            <form action="" method="POST">
              <div class="mb-3">
                <input type="text" name="nama" class="form-control" placeholder="Nama kamu" required>
              </div>
              <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email kamu" required>
              </div>
              <div class="mb-3">
                <textarea name="isi_kontak" class="" rows="3" placeholder="Bagikan pendapatmu..." required></textarea>
              </div>
              <button type="submit" name="submit" class="btn btn-glass">Kirim Pesan</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- PHP Insert -->
  <?php
  if (isset($_POST['submit'])) {
    $nama = htmlspecialchars($_POST['nama']);
    $email = htmlspecialchars($_POST['email']);
    $isi_kontak = htmlspecialchars($_POST['isi_kontak']);

    $query = mysqli_query($conn, "INSERT INTO kontak(nama, email, isi_kontak) VALUES ('$nama', '$email', '$isi_kontak')");

    if ($query) {
      echo "<script>
        Swal.fire({
          title: 'Berhasil!',
          text: 'Pesan kamu berhasil dikirim.',
          icon: 'success'
        }).then(() => window.location.href = 'index.php#contact');
      </script>";
    } else {
      echo "<script>
        Swal.fire({
          title: 'Gagal!',
          text: 'Terjadi kesalahan saat mengirim pesan.',
          icon: 'error'
        });
      </script>";
    }
  }
  ?>

  <!-- Footer -->
  <footer>
    <?php include('config/footer.php'); ?>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
