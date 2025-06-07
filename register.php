<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Register - MyReport</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap dan Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
body {
    background: linear-gradient(135deg, rgba(0, 0, 0, 0.6), rgba(0, 123, 255, 0.4));
    background-size: cover;
    font-family: Arial;
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

        .login-link {
            margin-top: 16px;
            text-align: center;
            font-size: 14px;
        }

        .login-link a {
            color: #aad8ff;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .btn-register {
            background-color: #0d6efd;
            color: white;
            border-radius: 8px;
            width: 100%;
            font-weight: bold;
            padding: 12px;
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

        .logo-icon,
        .logo-text {
            position: absolute;
            top: 15px;
        }

        .logo-icon {
            right: 190px;
            max-height: 40px;
        }

        .logo-text {
            right: 40px;
            max-height: 30px;
            top: 20px;
        }

        .welcome-text {
            color: #1a3747;
            font-weight: bold;
            font-size: 2.2rem;
        }

        .sub-text {
            color: #1a3747;
            font-size: 1.2rem;
        }

        .illustration img {
            max-width: 100%;
            max-height: 500px;
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
    </style>
</head>

<body>
    <div class="container mt-3 card mb-4">
        <a href="index.php" class="back-button"><i class="bi bi-arrow-left"></i></a>
        <div class="row">
            <div class="col-md-12">
                <div class="p-4">
                    <div class="row g-0">
                        <div class="col-lg-6 col-12">
                            <h2>Register</h2>
                            <p class="text-muted">Daftarkan Akun Anda</p>
                            <form method="POST" autocomplete="off" id="form">
                            <div>
                                <input type="text" name="nik" class="form-control" placeholder="NIK" maxlength="19" id="nik"  oninput="formatNumber(this)" required>
                                <div id="nikError" class="text-danger small"></div>
                            </div>

                            <div>
                                <input type="email" name="email" class="form-control" placeholder="Email" id="email" required>
                                <div id="emailError" class="text-danger small"></div>
                                </div>

                                <div>
                                <input type="text" name="username" class="form-control" placeholder="Username" id="username" required>
                                </div>
                                <div class="password-toggle">
                                    <input type="password" name="password" class="form-control" id="password" placeholder="Password" required
                                        pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,}$"
                                        title="Minimal 8 karakter, 1 huruf besar, 1 angka, dan 1 karakter spesial">
                                    <i class="bi bi-eye" id="togglePassword"></i>
                                </div>
                                <small class="text-muted">Password harus 8 karakter, 1 huruf besar, 1 angka & 1 simbol.</small>
                                
                                <div>
                                <input type="text" name="telp" class="form-control" placeholder="No Telp" minlength="13" maxlength="18" id="phone"required  oninput="formatNumber(this)">
                                <div id="telpError" class="text-danger small"></div>
                                </div>
                                <button name="submit" type="submit" class="btn btn-outline-dark mt-3">Register</button>
                            </form>
                        </div>
                        <div class="col-lg-6 d-none d-lg-block p-4">
                            <div class="text-center">
                                <img src="storages/logo2.png" class="logo-icon" alt="Icon">
                                <img src="storages/MyReport2.png" class="logo-text" alt="Text">
                                <h1 class="welcome-text mt-5">Selamat Datang</h1>
                                <p class="sub-text">Di Pengaduan Masyarakat</p>
                                <div class="illustration">
                                    <img src="storages/registerv2.0.png" alt="Register Illustration">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php
include 'config/db.php';
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $nik = preg_replace('/\D/', '', $_POST['nik']); // bersihkan NIK dari non-angka
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password_raw = $_POST['password'];
    $password = password_hash($password_raw, PASSWORD_DEFAULT);
    $telp = preg_replace('/\D/', '', $_POST['telp']);

    $errors = [];

    if (strlen($nik) !== 16) {
        $errors[] = "NIK harus 16 digit angka.";
    }
    if (strlen($telp) < 12) {
        $errors[] = "Nomor telepon minimal 12 digit.";
    }

    // Cek duplikat
    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM masyarakat WHERE nik='$nik'")) > 0) {
        $errors[] = "NIK sudah terdaftar.";
    }
    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM masyarakat WHERE email='$email'")) > 0) {
        $errors[] = "Email sudah digunakan.";
    }
    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM masyarakat WHERE username='$username'")) > 0) {
        $errors[] = "Username sudah digunakan.";
    }
    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM masyarakat WHERE telp='$telp'")) > 0) {
        $errors[] = "Nomor telepon sudah terdaftar.";
    }

    if (empty($errors)) {
        $insert = mysqli_query($conn, "INSERT INTO masyarakat (nik, email, username, password, telp)
        VALUES ('$nik', '$email', '$username', '$password', '$telp')");

        if ($insert) {
            echo "<script>
                Swal.fire({
                    title: 'Registrasi Berhasil!',
                    text: 'Sekarang kamu bisa login.',
                    icon: 'success'
                }).then(() => {
                    window.location.href = 'login.php';
                });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan saat menyimpan data.',
                    icon: 'error'
                });
            </script>";
        }
    } else {
        $allErrors = implode('\\n', $errors);
        echo "<script>
            Swal.fire({
                title: 'Registrasi Gagal!',
                text: '$allErrors',
                icon: 'error'
            });
        </script>";
    }
}
?>
</div>
</div>
</div>
</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById("togglePassword").addEventListener("click", function() {
        const passwordInput = document.getElementById("password");
        const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
        passwordInput.setAttribute("type", type);
        this.classList.toggle("bi-eye");
        this.classList.toggle("bi-eye-slash");
    });


    function formatNumber(input) {
    const value = input.value.replace(/\D/g, '');
    const formatted = value.match(/.{1,4}/g);
    input.value = formatted ? formatted.join('-') : '';
  }

  document.getElementById("form").addEventListener("submit", function(e) {
    let isValid = true;

    const email = document.getElementById("email").value;
    if (!email.endsWith(".com")) {
      document.getElementById("emailError").textContent = "Email Setidaknya berakhiran .com";
      isValid = false;
    } else {
      document.getElementById("emailError").textContent = "";
    }

    const nik = document.getElementById("nik").value.replace(/\D/g, '');
    if (nik.length !== 16) {
      document.getElementById("nikError").textContent = "NIK harus 16 digit";
      isValid = false;
    } else {
      document.getElementById("nikError").textContent = "";
    }

    const telp = document.getElementById("phone").value.replace(/\D/g, '');
    if (telp.length < 12) {
      document.getElementById("telpError").textContent = "No. Telp minimal 12 digit";
      isValid = false;
    } else {
      document.getElementById("telpError").textContent = "";
    }

    if (!isValid) e.preventDefault();
  });

    
</script>
</body>
</html>