<?php
// require "config/session.php";
require "../config/db.php";

$queryGetPengaduan = mysqli_query($conn, "SELECT * FROM pengaduan");
$jumlahPengaduan = mysqli_num_rows($queryGetPengaduan);

$queryGetMasyarakat = mysqli_query($conn, "SELECT * FROM masyarakat");
$jumlahMasyarakat = mysqli_num_rows($queryGetMasyarakat);

$queryGetPetugas = mysqli_query($conn, "SELECT * FROM petugas");
$jumlahPetugas = mysqli_num_rows($queryGetPetugas);

$queryGetKontak = mysqli_query($conn, "SELECT * FROM kontak");
$jumlahKontak = mysqli_num_rows($queryGetPetugas);
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
        }

        .summary-user {
            box-shadow: 6px 6px 15px rgba(97, 92, 92, 0.4);
            transition: transform 0.1s ease, box-shadow 0.1s ease;
            border-radius: 10px;
        }

        .summary-user:hover {
            transform: translateY(2px);
            /* Sedikit turun */
            box-shadow: 3px 3px 10px rgba(97, 92, 92, 0.3);
            /* Bayangan lebih kecil */
        }

        .summary-post {
            box-shadow: 6px 6px 15px rgba(97, 92, 92, 0.4);
            transition: transform 0.1s ease, box-shadow 0.1s ease;
            border-radius: 10px;
        }

        .summary-post:hover {
            transform: translateY(2px);
            /* Sedikit turun */
            box-shadow: 3px 3px 10px rgba(97, 92, 92, 0.3);
            /* Bayangan lebih kecil */
        }
        .summary-comment {
            box-shadow: 6px 6px 15px rgba(97, 92, 92, 0.4);
            transition: transform 0.1s ease, box-shadow 0.1s ease;
            border-radius: 10px;
        }

        .summary-comment:hover {
            transform: translateY(2px);
            /* Sedikit turun */
            box-shadow: 3px 3px 10px rgba(97, 92, 92, 0.3);
            /* Bayangan lebih kecil */
        }
        .summary-report {
            box-shadow: 6px 6px 15px rgba(97, 92, 92, 0.4);
            transition: transform 0.1s ease, box-shadow 0.1s ease;
            border-radius: 10px;
        }

        .summary-report:hover {
            transform: translateY(2px);
            /* Sedikit turun */
            box-shadow: 3px 3px 10px rgba(97, 92, 92, 0.3);
            /* Bayangan lebih kecil */
        }
        .summary-community {
            box-shadow: 6px 6px 15px rgba(97, 92, 92, 0.4);
            transition: transform 0.1s ease, box-shadow 0.1s ease;
            border-radius: 10px;
        }

        .summary-community:hover {
            transform: translateY(2px);
            /* Sedikit turun */
            box-shadow: 3px 3px 10px rgba(97, 92, 92, 0.3);
            /* Bayangan lebih kecil */
        }

        .no-decoration{
            text-decoration: none;
            color: black;
        }
    </style>
</head>

<body>
    <div class="container mt-5 ">
        <div class="row">

            <div class="col-lg-3 col-md-12 col-12 col-sm-12 mb-2">
                <a href="list_pengaduan.php" class="no-decoration">
                <div class="summary-user p-3">
                    <div class="row">
                        <div class="col-6 ">
                            <i class="fas fa-bars fa-3x text-black-50 position-absolute mt-2"></i>
                        </div>

                        <div class="text-black text-end" >
                            <h3 class=""><strong>Pengaduan</strong></h3>
                            <p class="">List pengaduan: <?php echo $jumlahPengaduan?></p>
                        </div>
                    </div>
                    </a>
                </div>
            
            </div>

            <div class="col-lg-3 col-md-12 col-12 col-sm-12 mb-2">
                <a href="listAccountMasyarakat.php" class="no-decoration">
                <div class="summary-post p-3">
                    <div class="row">
                        <div class="col-6">
                            <i class="fas fa-user fa-3x text-black-50 position-absolute mt-2"></i>
                        </div>

                        <div class="text-black text-end">
                            <h3 class=""><strong>Masyarakat</strong></h3>
                            <p class="">List Masyarakat: <?php echo $jumlahMasyarakat ?></p>
                        </div>
                    </div>
                </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-12 col-12 col-sm-12 mb-2">
                <a href="listAccountAdmin.php" class="no-decoration">
                <div class="summary-comment p-3">
                    <div class="row">
                        <div class="col-6 ">
                            <i class="fa fa-user-tie fa-3x text-black-50 position-absolute mt-2"></i>
                        </div>

                        <div class="text-black text-end">
                            <h3 class=""><strong>Petugas</strong></h3>
                            <p class="">List Petugas & Admin: <?php echo $jumlahPetugas ?></p>
                            
                        </div>
                    </div>
                </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-12 col-12 col-sm-12 mb-2">
                <a href="list_kontak.php" class="no-decoration">
                <div class="summary-comment p-3">
                    <div class="row">
                        <div class="col-6 ">
                            <i class="fa fa-address-book fa-3x text-black-50 position-absolute mt-2"></i>
                        </div>

                        <div class="text-black text-end">
                            <h3 class=""><strong>Kontak</strong></h3>
                            <p class="">List Kontak: <?php echo $jumlahKontak ?></p>
                            
                        </div>
                    </div>
                </div>
                </a>
            </div>

            <div class="col-lg-12 col-md-12 col-12 col-sm-12 ">
                <a href="tambah_akun.php" class="no-decoration">
                <div class="summary-comment p-3">
                    <div class="row">
                        <div class="col-12 justify-content-center align-items-center p-2">
                            <i class="fas fa-circle-plus fa-4x text-black-50 container"></i>
                        </div>

                        <div class="text-black text-center">
                            <p class=" ms-4">Tambah Akun</p>
                        </div>
                    </div>
                </div>
                </a>
            </div>





    <script src="../assets/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="../assets/fontawesome/js/all.min.js"></script>
</body>

</html>