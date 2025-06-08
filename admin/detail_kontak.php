<?php
require "config/sessionLogin.php";
require('../config/db.php');
$id = $_GET['p'];
$querySelectLaporan = mysqli_query($conn, "SELECT * FROM kontak WHERE id_kontak='$id'");
$fetch_data = mysqli_fetch_array($querySelectLaporan);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Detail Kontak - MyReport</title>
</head>
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

        .margin{
            margin-top: 150px;
        }
</style>
<body>
    <?php include('config/navbar.php')?>
    <div class="container margin justify-content-center align-items-center">
        <div class="container">
            <h1 class="text-center text-white mb-2"><strong><?= $fetch_data['nama']?></strong></h1>
            <div class="card card-glass">
                <div class="card-body">
                    <p class="card-text"><strong>Nama: </strong> <?= $fetch_data['nama'] ?></p>
                    <p class="card-text"><strong>Email: </strong> <?= $fetch_data['email'] ?></p>
                    <p class="card-text"><strong>Isi Kontak: </strong> <?= $fetch_data['isi_kontak']?></p>
                </div>
            </div>
        </div>
    </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>