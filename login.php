    <?php
    session_start();
    include 'config/db.php';
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

        <!-- My Style -->
        <link rel="stylesheet" href="style.css" />

    <style>
body {
    background: linear-gradient(135deg, rgba(0, 0, 0, 0.6), rgba(0, 123, 255, 0.4));
    background-size: cover;
    font-family: Arial;
    /* height: 100vh; */
}

.login-container {
  width: 100%;
  height: auto;
  background-color: white;
  overflow: hidden;
  display: flex;
  flex-direction: column;
}
.card {
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    backdrop-filter: blur(15px);
    background: rgba(255, 255, 255, 0.15);
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.2);
    padding: 30px;
}

 input[type="text"],
        input[type="email"],
        input[type="password"] {
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
        input[type="password"]:focus {
            background: rgba(255, 255, 255, 0.2);
        }

        button {
            width: 100%;
            padding: 12px;
            background: rgba(0, 119, 182, 0.6);
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: bold;
            cursor: pointer;
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
            position: relative;
        }

        .password-toggle i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
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

    </style>
    </head>

    <body>
        <div class="container-fluid p-3">
            <div class="login-container card mb-5 mt-2">
                <div class="row g-0 ">
                    <!-- Header with back button and logo -->
                    <div class="col-12" style="height: 70px;">
                        <div class="d-flex justify-content-between align-items-center px-4 py-3">
                            <a href="index.php">
                                <div class="back-button">
                                    <i class="bi bi-arrow-left"></i>
                                </div>
                            </a>
                            <div class="navbar-brand d-flex align-items-center">
                                <img src="storages/logo2.png" alt="MyReport Icon" class="logo-icon me-2">
                                <img src="storages/MyReport2.png" alt="MyReport Text" class="logo-text">
                            </div>
                        </div>
                    </div>


                <div class="col-lg-6 col-md-6" style="padding-top: 75px">
                    <div class="illustration-col">
                        <h1 class="welcome-text mb-4">Selamat Datang</h1>

                        <!-- Illustration with character and phone -->
                        <div class="illustration-container">
                            <img src="storages/2.0.png" alt="Character with phone illustration" class="illustration-img">
                        </div>
                    </div>
                </div>

                            <!-- Login form -->
                            <div class="col-md-6 login-form">
                                <div>
                                    <h2 class="mb-2">Login</h2>
                                    <p class="text-muted mb-4">Selamat datang, tolong login ke akun anda</p>

                                    <form method="POST">
                                        <div class="mb-3">
                                            <input type="text" class="form-control" id="email" placeholder="Email" name="email" required autocomplete="off">
                                        </div>

                                        <div class="mb-3">
                                      <div class="password-toggle">
                                    <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                                    <i class="bi bi-eye" id="togglePassword"></i>
                                </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <div class="form-check">
                                                <input class="form-check-input custom-checkbox" type="checkbox" id="rememberMe" name="remember">
                                                <label class="form-check-label" for="rememberMe">Ingat Saya</label>
                                            </div>
                                            <a href="lupa_password_masyarakat.php" class="forgot-password">Lupa Password?</a>
                                        </div>

                                        <button name="submit" type="submit" class="btn btn-login">
                                            Login <i class="bi bi-arrow-right"></i>
                                        </button>

                                        <div class="register-link mt-4">
                                            <span>Pengguna Baru?</span>
                                            <a href="register.php">Daftar</a>
                                        </div>
                                    </form>
                                    <?php
                                    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';

                                    if (isset($_POST['submit'])) {
                                        // Mengambil input dari form login
                                        $email = htmlspecialchars($_POST['email']);
                                        $password = htmlspecialchars($_POST['password']);

                                        // Memastikan koneksi ke database berhasil
                                        if ($conn) {
                                            // Query untuk mencari email di database
                                            $query = "SELECT * FROM masyarakat WHERE email = ?";
                                            $stmt = mysqli_prepare($conn, $query);
                                            mysqli_stmt_bind_param($stmt, "s", $email);
                                            mysqli_stmt_execute($stmt);
                                            $result = mysqli_stmt_get_result($stmt);

                                            // Mengecek apakah data ada
                                            if ($data = mysqli_fetch_array($result)) {
                                                // Verifikasi password menggunakan password_verify
                                                if (password_verify($password, $data['password'])) {
                                                    // Jika berhasil, buat session
                                                    $_SESSION['email'] = $data['email'];
                                                    $_SESSION['username'] = $data['username'];
                                                    $_SESSION['nik'] = $data['nik'];
                                                    $_SESSION['level'] = $data['level'];
                                                    $_SESSION['id_masyarakat'] = $data['id_masyarakat'];
                                                    $_SESSION['telp'] = $data['telp'];
                                                    $_SESSION['login'] = true;
                                                    echo "<script>
                        Swal.fire({
                            title: 'Login Berhasil!',
                            text: 'Selamat datang, " . $data['username'] . "!',
                            icon: 'success'
                        }).then(() => {
                            window.location.href = 'index.php';
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
                                            echo '<div class="alert alert-danger" role="alert">Koneksi database gagal</div>';
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