<?php
session_start();
include '../config/db.php';
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login - MyReport</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

<style>
body {
      background: linear-gradient(135deg, rgba(0, 0, 0, 0.6), rgba(0, 123, 255, 0.4));
    background-size: cover;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  margin: 0;
  padding: 0;
  /* overflow-x: hidden; */
}
.login-card {
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    backdrop-filter: blur(15px);
    background: rgba(255, 255, 255, 0.15);
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.2);
}
.login-container {
  width: 100%;
  height: auto;
  overflow: hidden;
  display: flex;
  flex-direction: column;
}

.row-content {
  flex: 1;
}

.back-button {
  background-color: #3465a4;
  color: white;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* .navbar-brand {
  padding: 0;
  display: flex;
  align-items: center;
} */

.logo-icon {
  height: auto;
  max-height: 40px;
}

.logo-text {
  height: auto;
  max-height: 30px;
}

.login-form {
  padding: 0 30px;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: center;
  margin-top: 50px; 
}

.illustration-col {
  padding: 0 30px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  height: 100%;
  
}

.welcome-text {
  color: #0d1e40;
  font-size: 2.5rem;
  font-weight: bold;
  margin-bottom: 30px;
  margin-top: -60px;
}

.illustration-img {
  max-width: 50%;
}

.form-label {
  font-weight: 500;
  margin-bottom: 8px;
}

.form-control {
  padding: 12px;
  border-radius: 8px;
  border: 1px solid #ced4da;
  margin-bottom: 20px;
}

.form-control:focus {
  border-color: #3465a4;
  box-shadow: 0 0 0 0.25rem rgba(52, 101, 164, 0.25);
}

.btn-login {
  background-color: #3465a4;
  color: white;
  border: none;
  border-radius: 8px;
  padding: 12px;
  font-weight: 500;
  width: 100%;
  margin-top: 10px;
}

.btn-login:hover {
  background-color:#4689e0;
  color: white;
}

.remember-me {
  display: flex;
  align-items: center;
  margin-bottom: 20px;
}

.remember-me input {
  margin-right: 5px;
}

.forgot-password {
  text-align: right;
  color: #0d1e40;
  text-decoration: none;
}

.register-link {
  margin-top: 20px;
  text-align: center;
}

.register-link a {
  color: #3465a4;
  text-decoration: none;
  font-weight: 500;
}

/* Character and phone illustration */
.character-phone {
  position: relative;
  max-width: 100%;
}

/* Add some decoration elements */
.decoration {
  position: absolute;
  /* background-color: #f0f2f5; */
  border-radius: 50%;
  z-index: -1;
}

/* Custom checkbox */
.custom-checkbox {
  accent-color: #3465a4;
  width: 18px;
  height: 18px;
}

/* Password visibility toggle */
.password-container {
  position: relative;
}

.password-toggle {
  position: absolute;
  right: 15px;
  top: 50%;
  transform: translateY(-50%);
  background: none;
  border: none;
  cursor: pointer;
  color: #6c757d;
}

/* Illustration container */
.illustration-container {
  display: flex;
  align-items: center;
  justify-content: center;
  max-width: 100%;
  position: relative;
}

.illustration-img {
  max-width: 85%;
  height: auto;
  z-index: 1;
}

.email, .password{
      width: 100%;
      padding: 12px;
            border: none;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            outline: none;
            transition: background 0.3s;
    }
</style>
</head>
<body>
    <div class="container-fluid p-3">
        <div class="login-container my-4 login-card ">
            <div class="row g-0">
                <!-- Header with back button and logo -->
                <div class="col-12" style="height: 70px;">
                    <div class="d-flex justify-content-between align-items-center px-4 py-3">
                      <a href="../index.php">
                        <div class="back-button">
                            <i class="bi bi-arrow-left"></i>
                        </div>
                        </a>
                        <div class="navbar-brand d-flex align-items-center">
                            <img src="../storages/logo2.png" alt="MyReport Icon" class="logo-icon me-2">
                            <img src="../storages/MyReport2.png" alt="MyReport Text" class="logo-text">
                        </div>
                    </div>
                </div>

                <!-- Main content -->
                <div class="col-md-6" style="padding-top: 75px">
                    <div class="illustration-col">
                        <h1 class="welcome-text mb-4">Selamat Datang</h1>

                        <!-- Illustration with character and phone -->
                        <div class="illustration-container">
                            <img src="../storages/loginAdminV2.png" alt="Character with phone illustration" class="illustration-img">

                            <!-- Decoration elements -->
                            <div class="decoration decoration-1"></div>
                            <div class="decoration decoration-2"></div>
                            <div class="decoration decoration-3"></div>
                        </div>
                    </div>
                </div>

                <!-- Login form -->
<div class="col-md-6 login-form h-100">
                        <div>
                            <h2 class="mb-2">Login Admin</h2>
                            <p class="text-muted mb-4">Selamat datang, tolong login ke akun anda</p>

                            <form method="POST">
                            <div class="mb-3">
                                        <input type="email" class="form-control email" id="username" placeholder="Email" name="email" required autocomplete="off">
                                    </div>

                                <div class="mb-3">
                                    <div class="password-container">
                                        <input type="password" class="form-control password" id="password" placeholder="Password" name="password" required>
                                        <button type="button" class="password-toggle">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input custom-checkbox" type="checkbox" id="rememberMe">
                                        <label class="form-check-label" for="rememberMe">Ingat Saya</label>
                                    </div>
                                    <a href="../lupa_password_admin.php" class="forgot-password">Lupa Password?</a>
                                </div>

                                <button name="submit" type="submit" class="btn btn-login mb-5">
                                    Login <i class="bi bi-arrow-right"></i>
                                </button>
                            </form>
                            <?php
                            // Memulai session jika belum dimulai
                            // Tambahkan script SweetAlert2
                            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';

                            if (isset($_POST['submit'])) {
                                // Mengambil input dari form login
                                $email = htmlspecialchars($_POST['email']);
                                $password = htmlspecialchars($_POST['password']);

                                // Memastikan koneksi ke database berhasil
                                if ($conn) {
                                    // Query untuk mencari username di database
                                    $query = "SELECT * FROM petugas WHERE email = ?";
                                    $stmt = mysqli_prepare($conn, $query);
                                    mysqli_stmt_bind_param($stmt, "s", $email);
                                    mysqli_stmt_execute($stmt);
                                    $result = mysqli_stmt_get_result($stmt);

                                    // Mengecek apakah data ada
                                    if ($data = mysqli_fetch_array($result)) {
                                        // Memverifikasi password
                                        if (password_verify($password, $data['password'])) {
                                            // Jika berhasil, buat session
                                            $_SESSION['username'] = $data['username'];
                                            $_SESSION['email'] = $data['email'];
                                            $_SESSION['id_petugas'] = $data['id_petugas'];
                                            $_SESSION['nik'] = $data['nik'];
                                            $_SESSION['level'] = $data['level'];
                                            $_SESSION['loginAdmin'] = true;
                                            $_SESSION['loginPetugas']= true;

                                            // Redirect berdasarkan level
                                            if ($data['level'] == 'admin') {
                                                $redirect_url = 'index.php';
                                                $welcome_message = 'Selamat datang, Admin ' . $data['username'] . '!';
                                            } else {
                                                $redirect_url = 'index.php';
                                                $welcome_message = 'Selamat datang, Petugas ' . $data['username'] . '!';
                                            }

                                            echo "<script>
                                                    Swal.fire({
                                                    title: 'Login Berhasil!',
                                                    text: '$welcome_message',
                                                    icon: 'success'
                                                }).then(() => {
                                                    window.location.href = '$redirect_url';
                                                });
                                                </script>";
                                            } else {
                                            echo '<script>
                                                    Swal.fire({
                                                        title: "Password Salah",
                                                        text: "Silakan coba lagi.",
                                                        icon: "error"
                                                    });
                                            </script>';
                                            }
                                            } else {
                                                echo '<script>
                                                    Swal.fire({
                                                        title: "Gagal Login",
                                                        text: "Email tidak ditemukan.",
                                                        icon: "error"
                                                    });
                                            </script>';
                                            }

                                            // Menutup statement
                                                mysqli_stmt_close($stmt);
                                            } else {
                                                echo '<script>
                                                    Swal.fire({
                                                        title: "Error",
                                                        text: "Koneksi database gagal",
                                                        icon: "error"
                                                    });
                                            </script>';
                                        }
                                    }
                                ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Password toggle script -->
    <script>
        document.querySelector('.password-toggle').addEventListener('click', function() {
            const passwordInput = document.querySelector('#password');
            const icon = this.querySelector('i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    </script>
</body>
</html>