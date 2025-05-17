<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyReport - Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Menggunakan Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #fff;
            font-family: Arial, sans-serif;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .form-control {
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 20px;
        }
        .btn-register {
            background-color: #0d6efd;
            color: white;
            border-radius: 8px;
            padding: 12px;
            width: 100%;
            font-weight: bold;
        }
        .back-button {
            width: 40px;
            height: 40px;
            background-color: #3871c1;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            margin-bottom: 15px;
        }
        .back-button:hover {
            background-color: #2d5a9e;
            color: white;
        }
        .logo-icon {
            height: auto;
            max-height: 40px;
            position: absolute;
            top: 15px;
            right: 190px;
        }

        .logo-text {
            height: auto;
            max-height: 30px;
            position: absolute;
            top: 20px;
            right: 40px;
            }

        .logo img {
            width: 30px;
        }
        .welcome-section {
            text-align: center;
            padding: 20px;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .welcome-text {
            color: #1a3747;
            font-weight: bold;
            font-size: 2.2rem;
            margin-bottom: 10px;
        }
        .sub-text {
            color: #1a3747;
            font-size: 1.2rem;
            margin-bottom: 5px;
        }
        .illustration {
            text-align: center;
            margin-top: 30px;
        }
        .illustration img {
            max-width: 100%;
            height: auto;
            max-height: 500px;
        }
        .password-toggle {
            position: relative;
        }
        .password-toggle i {
            position: absolute;
            right: 15px;
            top: 15px;
            cursor: pointer;
            color: #6c757d;
        }
        .right-side-header {
            background-color: white;
            padding: 20px;
            border-radius: 0 10px 0 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .right-side-content {
            display: flex;
            flex-direction: column;
            height: calc(100% - 70px);
        }
    </style>
</head>
<body>
    <div class="container mt-3">
    <a href="index.php" class="back-button">
        <i class="bi bi-arrow-left"></i>
    </a>
        <div class="row">
            <div class="col-md-12">
                    <div class="card-body p-0">
                        <div class="row g-0">
                            <div class="col-md-6 p-4">
                                <h2 class="mb-1">Register</h2>
                                <p class="mb-4 text-muted">Daftarkan Akun Anda</p>

                                <form method="POST">
                                    <div class="mb-3">
                                        <label for="nik" class="form-label">NIK</label>
                                        <input type="text" class="form-control" id="nik" placeholder="320x-xxxx-xxxx-xxxx" name="nik" maxlength="19" autocomplete="off"   oninput="formatNumber(this)">
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" placeholder="example@gmail.com" name="email" autocomplete="off">
                                    </div>

                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="name" class="form-control" id="name" placeholder="Name" name="nama" autocomplete="off">
                                    </div>
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="username" class="form-control" id="username" placeholder="Name" name="username" autocomplete="off">
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <div class="password-toggle">
                                            <input type="password" class="form-control" id="password" placeholder="*" name="password" autocomplete="off">
                                            <i class="bi bi-eye" id="togglePassword"></i>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">No Telp</label>
                                        <input type="text" class="form-control" id="phone" placeholder="08xx-xxxx-xxxx" name="telp" autocomplete="off" oninput="formatNumber(this)" minlength="13" maxlength="18">
                                    </div>

                                    <button name="submit" type="submit" class="btn btn-register">Register</button>
                                </form>
                                <?php

                                echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';

                                if(isset($_POST['submit'])){
                                include 'config/db.php';
                                $email = mysqli_real_escape_string($conn, $_POST['email']);
                                $nik = mysqli_real_escape_string($conn, $_POST['nik']);
                                $nama = mysqli_real_escape_string($conn, $_POST['nama']);
                                $username = mysqli_real_escape_string($conn, $_POST['username']);
                                //hash password mencegah hacker
                                $password_raw = $_POST['password'];
                                $password = password_hash($password_raw, PASSWORD_DEFAULT);
                                $telp = mysqli_real_escape_string($conn, $_POST['telp']);
    
                                // Validasi input
                                $errors = array();
    
                                // Validasi NIK (harus berupa 16 digit angka)
                                $nik = preg_replace('/\D/', '', $_POST['nik']); // pembersihan karakter & hanya angka
                                $telp = preg_replace('/\D/', '', $_POST['telp']);
                                if(strlen($nik) != 16) {
                                    $errors[] = "NIK harus berupa 16 digit angka";
                                }
                                
                                $check_nik = mysqli_query($conn, "SELECT * FROM masyarakat WHERE nik='$nik'");
                                if(mysqli_num_rows($check_nik) > 0) {
                                    $errors[] = "NIK sudah terdaftar";
                                }

                                $check_email = mysqli_query($conn, "SELECT * FROM masyarakat WHERE email='$email'");
                                if(mysqli_num_rows($check_email) > 0) {
                                    $errors[] = "Email sudah digunakan";
                                }

                                // Cek apakah username sudah ada di database
                                $check_username = mysqli_query($conn, "SELECT * FROM masyarakat WHERE username='$username'");
                                if(mysqli_num_rows($check_username) > 0) {
                                    $errors[] = "Username sudah digunakan";
                                }

                                $check_telp = mysqli_query($conn, "SELECT * FROM masyarakat WHERE telp='$telp'");
                                if(mysqli_num_rows($check_telp) > 0) {
                                    $errors[] = "Nomor sudah terdaftar";
                                }
                                
                                if(strlen($telp) < 10) {
                                    $errors[] = "Nomor minimal 10 digit angka";
                                }
                                // Jika tidak ada error, lanjutkan dengan penyimpanan data
                                if(empty($errors)) {
                                    // Gunakan query langsung seperti kode asli
                                    $data = mysqli_query($conn, "INSERT INTO masyarakat (nik, email, nama, username, password, telp) 
                                        VALUES ('$nik', '$email', '$nama', '$username', '$password', '$telp')");
        
                                if($data) {
                                        // Tampilkan pesan sukses
                                echo "<script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        Swal.fire({
                                            title: 'Data terkirim',
                                            text: 'Data terkirim, sekarang kamu bisa login',
                                            icon: 'success'
                                        }).then(() => {
                                        window.location.href = 'login.php';
                                        });
                                    });
                                        </script>";
                                    } else {
                                    // Tampilkan pesan gagal
                                    echo "<script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            Swal.fire({
                                                title: 'Data gagal terkirim',
                                                text: 'Tidak bisa login',
                                                icon: 'error'
                                        });
                                    });
                                    </script>";
                                    }
                                } else {
                                    // Tampilkan error validasi
                                    $error_message = implode(', ', $errors);
                                    echo "<script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            Swal.fire({
                                                title: 'Register Gagal!',
                                                text: '$error_message',
                                                icon: 'error'
                                        });
                                    });
                                    </script>";
                                }
                            }
                            ?>
                            </div>

                            <div class="col-md-6 p-0">
                                <div class="right-side-header">
                                    <div class="navbar-brand d-flex align-items-center">
                                        <img src="storages/logo2.png" alt="MyReport Icon" class="logo-icon me-2">
                                        <img src="storages/MyReport2.png" alt="MyReport Text" class="logo-text">
                                    </div>
                                </div>
                                <div class="right-side-content">
                                    <div class="welcome-section">
                                        <h1 class="welcome-text">Selamat datang</h1>
                                        <p class="sub-text">Di Pengaduan Masyarakat</p>
                                        
                                        <div class="illustration">
                                            <img src="storages/register.png" alt="Ilustrasi Welcome">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });

        function formatNumber(input) {
  // Ambil angka saja, tanpa karakter selain digit
  let value = input.value.replace(/\D/g, '');

  // Potong jadi per 4 digit
  let formatted = value.match(/.{1,4}/g);
  
  // Gabungkan dengan "-"
  if (formatted) {
    input.value = formatted.join('-');
  } else {
    input.value = '';
  }
}
    </script>
</body>
</html>