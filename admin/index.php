<?php
// require "config/session.php";
require "../config/db.php"; // include database

$queryGetPengaduan = mysqli_query($conn, "SELECT * FROM pengaduan"); // ambil data dari tabel pengaduan
$jumlahPengaduan = mysqli_num_rows($queryGetPengaduan);  // ambil jumlah data dari tabel pengaduan

$queryGetMasyarakat = mysqli_query($conn, "SELECT * FROM masyarakat"); //untukk megambil data dari tabel masyrakat
$jumlahMasyarakat = mysqli_num_rows($queryGetMasyarakat); // untuk  mengambil jumlah data dari tabel masyarakat

$queryGetPetugas = mysqli_query($conn, "SELECT * FROM petugas"); // untuk mengambil data dari tabel petugas
$jumlahPetugas = mysqli_num_rows($queryGetPetugas); // untuk mengambil jumlah data dari tabel petugas

$queryGetKontak = mysqli_query($conn, "SELECT * FROM kontak"); //untuk mengambil data dari tabel kontak
$jumlahKontak = mysqli_num_rows($queryGetPetugas); // untuk  mengambil jumlah data dari tabel kontak
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
    <title>index admin</title>
    <style>

        .card {
            border-radius: 10px;
        }/* Memberikan efek sudut membulat sebesar 10px pada elemen dengan class 'card' */

        
        /* Memberikan style pada elemen dengan class 'summary-user' *//* Memberikan style pada elemen dengan class 'summary-user' */
.summary-user {
    /* Memberikan efek bayangan kotak agar terlihat timbul */
    box-shadow: 6px 6px 15px rgba(97, 92, 92, 0.4);

    /* Menambahkan efek transisi halus saat elemen berubah (misalnya saat hover) */
    transition: transform 0.1s ease, box-shadow 0.1s ease;

    /* Memberikan sudut membulat 10px agar tampilan lebih lembut */
    border-radius: 10px;
}


        .summary-user:hover {
    transform: translateY(2px); /* Saat hover, elemen sedikit turun 2px */
    box-shadow: 3px 3px 10px rgba(97, 92, 92, 0.3); /* Saat hover, bayangan menjadi lebih kecil dan lebih soft */
}

        .summary-post {
    /* Memberikan efek bayangan dengan offset horizontal 6px, offset vertikal 6px, blur 15px, dan warna abu-abu transparan */
    box-shadow: 6px 6px 15px rgba(97, 92, 92, 0.4);

    /* Menambahkan animasi transisi yang halus pada properti transform dan box-shadow dengan durasi 0.1 detik */
    transition: transform 0.1s ease, box-shadow 0.1s ease;

    /* Membuat sudut elemen menjadi membulat dengan radius 10px */
    border-radius: 10px;
}


       .summary-post:hover {
    /* Saat hover, elemen akan bergeser sedikit ke bawah sejauh 2px */
    transform: translateY(2px);

    /* Bayangan berubah menjadi lebih kecil dan lebih ringan saat hover */
    box-shadow: 3px 3px 10px rgba(97, 92, 92, 0.3);
}

       .summary-comment {
    /* Memberikan bayangan dengan offset 6px ke kanan dan bawah, blur 15px, dan warna abu-abu transparan */
    box-shadow: 6px 6px 15px rgba(97, 92, 92, 0.4);

    /* Menambahkan transisi halus pada perubahan transform dan box-shadow selama 0.1 detik */
    transition: transform 0.1s ease, box-shadow 0.1s ease;

    /* Membuat sudut elemen membulat dengan radius 10px */
    border-radius: 10px;
}


        .summary-comment:hover {
    /* Saat hover, elemen bergeser sedikit ke bawah sejauh 2px */
    transform: translateY(2px);

    /* Bayangan menjadi lebih kecil dan lebih redup saat hover */
    box-shadow: 3px 3px 10px rgba(97, 92, 92, 0.3);
}

       .summary-report {
    /* Memberikan bayangan dengan offset 6px ke kanan dan bawah, blur 15px, dan warna abu-abu transparan */
    box-shadow: 6px 6px 15px rgba(97, 92, 92, 0.4);

    /* Menambahkan transisi halus untuk transform dan box-shadow selama 0.1 detik */
    transition: transform 0.1s ease, box-shadow 0.1s ease;

    /* Membulatkan sudut elemen dengan radius 10px */
    border-radius: 10px;
}

       .summary-report:hover {
    /* Saat hover, elemen bergeser turun sejauh 2px */
    transform: translateY(2px);

    /* Bayangan menjadi lebih kecil dan lebih transparan saat hover */
    box-shadow: 3px 3px 10px rgba(97, 92, 92, 0.3);
}
       .summary-community {
    /* Memberikan efek bayangan dengan offset 6px ke kanan dan bawah, blur 15px, serta warna abu-abu transparan */
    box-shadow: 6px 6px 15px rgba(97, 92, 92, 0.4);

    /* Menambahkan transisi halus untuk properti transform dan box-shadow selama 0.1 detik */
    transition: transform 0.1s ease, box-shadow 0.1s ease;

    /* Membulatkan sudut elemen dengan radius 10px */
    border-radius: 10px;
}

        .summary-community:hover {
    /* Saat hover, elemen bergeser turun sejauh 2px */
    transform: translateY(2px);

    /* Bayangan mengecil dan menjadi lebih transparan saat hover */
    box-shadow: 3px 3px 10px rgba(97, 92, 92, 0.3);
}

        .no-decoration {
    /* Menghilangkan garis bawah atau dekorasi teks lainnya */
    text-decoration: none;

    /* Mengatur warna teks menjadi hitam */
    color: black;
}

    </style>
</head>

<body>
    <!-- Memuat navbar dari file eksternal -->
    <?php include('config/navbar.php')?>

    <div class="container mt-5">
        <div class="row">

            <!-- Card Pengaduan -->
            <div class="col-lg-3 col-md-12 col-12 col-sm-12 mb-2">
                <a href="list_pengaduan.php" class="no-decoration">
                    <div class="summary-user p-3">
                        <div class="row">
                            <div class="col-6">
                                <!-- Ikon menu bar -->
                                <i class="fas fa-bars fa-3x text-black-50 position-absolute mt-2"></i>
                            </div>

                            <div class="text-black text-end">
                                <h3><strong>Pengaduan</strong></h3>
                                <!-- Menampilkan jumlah pengaduan dari PHP -->
                                <p>List pengaduan: <?php echo $jumlahPengaduan ?></p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Card Masyarakat -->
            <div class="col-lg-3 col-md-12 col-12 col-sm-12 mb-2">
                <a href="listAccountMasyarakat.php" class="no-decoration">
                    <div class="summary-post p-3">
                        <div class="row">
                            <div class="col-6">
                                <!-- Ikon user -->
                                <i class="fas fa-user fa-3x text-black-50 position-absolute mt-2"></i>
                            </div>

                            <div class="text-black text-end">
                                <h3><strong>Masyarakat</strong></h3>
                                <p>List Masyarakat: <?php echo $jumlahMasyarakat ?></p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Card Petugas/Admin -->
            <div class="col-lg-3 col-md-12 col-12 col-sm-12 mb-2">
                <a href="listAccountAdmin.php" class="no-decoration">
                    <div class="summary-comment p-3">
                        <div class="row">
                            <div class="col-6">
                                <!-- Ikon petugas/admin -->
                                <i class="fa fa-user-tie fa-3x text-black-50 position-absolute mt-2"></i>
                            </div>

                            <div class="text-black text-end">
                                <h3><strong>Petugas</strong></h3>
                                <p>List Petugas & Admin: <?php echo $jumlahPetugas ?></p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Card Kontak -->
            <div class="col-lg-3 col-md-12 col-12 col-sm-12 mb-2">
                <a href="list_kontak.php" class="no-decoration">
                    <div class="summary-comment p-3">
                        <div class="row">
                            <div class="col-6">
                                <!-- Ikon kontak -->
                                <i class="fa fa-address-book fa-3x text-black-50 position-absolute mt-2"></i>
                            </div>

                            <div class="text-black text-end">
                                <h3><strong>Kontak</strong></h3>
                                <p>List Kontak: <?php echo $jumlahKontak ?></p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Card Tambah Akun -->
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <a href="tambah_akun.php" class="no-decoration">
                    <div class="summary-comment p-3">
                        <div class="row">
                            <div class="col-12 justify-content-center align-items-center p-2">
                                <!-- Ikon tambah akun -->
                                <i class="fas fa-circle-plus fa-4x text-black-50 container"></i>
                            </div>

                            <div class="text-black text-center">
                                <p class="ms-4">Tambah Akun</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>

    <!-- Memuat JS Bootstrap dan FontAwesome -->
    <script src="../assets/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="../assets/fontawesome/js/all.min.js"></script>
</body>

</html>