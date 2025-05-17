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

    </head>
    <body>
        <div class="container-fluid p-0">
            <div class="login-container my-4">
                <div class="row g-0">
                    <!-- Header with back button and logo -->
                    <div class="col-12" style="height: 70px;">
                        <div class="d-flex justify-content-between align-items-center px-4 py-3 bg-white">
                            <a href="index.php"><div class="back-button">
                                <i class="bi bi-arrow-left"></i>
                            </div></a>
                            <div class="navbar-brand d-flex align-items-center">
                                <img src="storages/logo2.png" alt="MyReport Icon" class="logo-icon me-2">
                                <img src="storages/MyReport2.png" alt="MyReport Text" class="logo-text">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Main content -->
                    <div class="container-fluid login-container">
    <div class="row h-100">
        <div class="col-md-6 d-none d-md-flex illustration-col">
        <!-- Ilustrasi di sini -->
        <div class="illustration-container">
                                <img src="storages/loginUser.png" alt="Character with phone illustration" class="illustration-img">
                                
                                <!-- Decoration elements -->
                                <div class="decoration decoration-1"></div>
                                <div class="decoration decoration-2"></div>
                                <div class="decoration decoration-3"></div>
                            </div>
        </div>
                    
                    <!-- Login form -->
    <div class="col-md-6 login-form">
                            <div>
                                <h2 class="mb-2">Login</h2>
                                <p class="text-muted mb-4">Selamat datang, tolong login ke akun anda</p>
                                
                                <form method="POST">
                                <div class="mb-3">
                                            <label for="nik" class="form-label">Email</label>
                                            <input type="text" class="form-control" id="nik" placeholder="example@gmail.com" name="email">
                                        </div>
                                    
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <div class="password-container">
                                            <input type="password" class="form-control" id="password" placeholder="******" name="password">
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
                $_SESSION['role'] = $data['role'];
                $_SESSION['id_masyarakat'] = $data['id_masyarakat'];
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