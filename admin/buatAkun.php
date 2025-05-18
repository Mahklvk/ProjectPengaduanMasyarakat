<?php
require "config/sessionLogin.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Akun</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- fontawesome -->
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        /* .width-form {
            max-width: 700px;

        } */
        /*.form-title {
            margin-bottom: 25px;
            color: #333;
        } */
        .btn-primary {
            /* background-color: #0d6efd;
            border: none; */
            width: 100%;
        }
        /* .btn-primary:hover {
            background-color: #0b5ed7;
        } */
    </style>
</head>

<body>
    <?php include('config/navbar.php')?>
    <!-- Form Container -->
    <div class="container ">
        <h2 class="mt-3 container">Tambah Akun</h2>
        <div class="p-5 border border-dark rounded mb-5">
            <form id="tambahAkunForm" method="POST" class="width-form container col-md-6">
                <!-- NIK -->
                <div class="mb-3">
                    <label for="nik" class="form-label">NIK</label>
                    <input name="nik" type="text" class="form-control" id="nik" placeholder="320xxxx" required maxlength="19" autocomplete="off"   oninput="formatNumber(this)">
                </div>

                <!-- Nama -->
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input name="nama" type="text" class="form-control" id="nama" placeholder="nama" required>
                </div>

                <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" placeholder="example@gmail.com" name="email" autocomplete="off">
                </div>

                <!-- Username -->
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input name="username" type="text" class="form-control" id="username" placeholder="username" required>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input name="password" type="password" class="form-control" id="password" placeholder="••••••••" required>
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- No. Telp -->
                <div class="mb-3">
                    <label for="notelp" class="form-label">No.Telp</label>
                    <input name="notelp" type="text" class="form-control" id="notelp" placeholder="083xxxx" required  oninput="formatNumber(this)" minlength="13" maxlength="18">
                </div>

                <!-- Pilih Role Dropdown -->
                <div class="mb-3">
                    <label for="role" class="form-label">Pilih Role</label>
                    <select name="role" class="form-select" id="role" required>
                        <option value="" selected disabled>Pilih Role</option>
                        <option value="admin">Admin</option>
                        <option value="petugas">Petugas</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="mb-3">
                    <button name="submit" type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>

            <?php
            // Mengecek koneksi database dahulu
            include '../config/db.php';

            // Memproses data ketika form dikirim
            if(isset($_POST['submit'])) {
                // Mengambil dan membersihkan data input dari form
                $nik = mysqli_real_escape_string($conn, $_POST['nik']);
                $nama_petugas = mysqli_real_escape_string($conn, $_POST['nama']);
                $email = mysqli_real_escape_string($conn, $_POST['email']);
                $username = mysqli_real_escape_string($conn, $_POST['username']);
                $password_raw = $_POST['password'];
                $password = password_hash($password_raw, PASSWORD_DEFAULT);
                $telp = mysqli_real_escape_string($conn, $_POST['notelp']);
                $level = mysqli_real_escape_string($conn, $_POST['role']);

                // Inisialisasi array untuk menyimpan pesan kesalahan validasi
                $errors = array();

                $nik = preg_replace('/\D/', '', $_POST['nik']); // pembersihan karakter & hanya angka
                $telp = preg_replace('/\D/', '', $_POST['notelp']);

                // Validasi NIK (harus 16 digit angka)
                if(strlen($nik) != 16) {
                    $errors[] = "NIK harus berupa 16 digit angka";
                }

                // Validasi username (memeriksa apakah sudah ada di database)
                $check_username = mysqli_query($conn, "SELECT * FROM petugas WHERE username='$username'");
                if($check_username && mysqli_num_rows($check_username) > 0) {
                    $errors[] = "Username sudah digunakan";
                }

                //validasi email
                $check_email = mysqli_query($conn, "SELECT * FROM petugas WHERE email='$email'");
                if($check_email && mysqli_num_rows($check_email) > 0) {
                    $errors[] = "Email sudah terdaftar";
                }

                $check_telp = mysqli_query($conn, "SELECT * FROM petugas WHERE telp='$telp'");
                if($check_telp && mysqli_num_rows($check_telp) > 0) {
                    $errors[] = "Nomor Telpon sudah terdaftar";
                }

                // Validasi level (harus 'admin' atau 'petugas')
                if($level != 'admin' && $level != 'petugas') {
                    $errors[] = "Level harus 'admin' atau 'petugas'";
                }

                // Jika tidak ada kesalahan validasi, simpan data ke database
                if(empty($errors)) {
                    // Memasukkan data petugas baru ke database
                    $query = "INSERT INTO petugas (nik, nama_petugas, email, username, password, telp, level) 
                              VALUES ('$nik', '$nama_petugas','$email', '$username', '$password', '$telp', '$level')";

                    $data = mysqli_query($conn, $query);

                    if($data) {
                        // Menampilkan pesan sukses menggunakan SweetAlert
                        echo "<script>
                            document.addEventListener('DOMContentLoaded', function() {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: 'Akun baru telah berhasil ditambahkan ke sistem',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = 'index.php';
                                    }
                                });
                            });
                        </script>";
                    } else {
                        // Menampilkan pesan error jika gagal menyimpan ke database
                        echo "<script>
                            document.addEventListener('DOMContentLoaded', function() {
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: 'Terjadi kesalahan saat menyimpan data: " . mysqli_error($conn) . "',
                                    icon: 'error',
                                    confirmButtonText: 'Coba Lagi'
                                });
                            });
                        </script>";
                    }
                } else {
                    // Menampilkan pesan kesalahan validasi
                    $error_message = implode(', ', $errors);
                    echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                title: 'Validasi Gagal!',
                                text: '$error_message',
                                icon: 'error',
                                confirmButtonText: 'Coba Lagi'
                            });
                        });
                    </script>";
                }
            }
            ?>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Password toggle script -->
    <script>

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

        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
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

        // Simulasi untuk menampilkan username pengguna yang sedang login
        document.addEventListener('DOMContentLoaded', function() {
            // Contoh data pengguna (dalam aplikasi nyata, ini akan diambil dari sistem)
            const loggedInUser = {
                username: "Admin",
                role: "Admin"
            };

            // Tampilkan username di navbar
            document.getElementById('currentUsername').textContent = loggedInUser.username;
        });
    </script>
</body>
</html>