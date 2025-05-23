<?php
require "config/sessionLogin.php";
include '../config/db.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Akun - MyReport</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
  <style>
    body { background-color: #f8f9fa; }
    .btn-primary { width: 100%; }
  </style>
</head>
<body>
<?php include('config/navbar.php'); ?>

<div class="container mt-4">
  <h2>Tambah Akun</h2>
  <div class="p-5 border border-dark rounded mb-5">
    <form id="tambahAkunForm" method="POST" class="col-md-6 mx-auto">
      <div class="mb-3">
        <label for="nik" class="form-label">NIK</label>
        <input type="text" class="form-control" id="nik" name="nik" maxlength="19" required autocomplete="off" oninput="formatNumber(this)">
        <div id="nikError" class="text-danger small"></div>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" required autocomplete="off">
        <div id="emailError" class="text-danger small"></div>
      </div>

      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" required>
        <div id="userError" class="text-danger small"></div>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <div class="input-group">
          <input type="password" class="form-control" id="password" name="password"
                 placeholder="••••••••" required
                 pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,}$"
                 title="Minimal 8 karakter, 1 huruf besar, 1 angka, dan 1 karakter spesial">
          <button class="btn btn-outline-secondary" type="button" id="togglePassword"><i class="bi bi-eye"></i></button>
        </div>
        <small class="text-muted">Minimal 8 karakter, 1 huruf besar, 1 angka, dan 1 karakter spesial</small>
      </div>

      <div class="mb-3">
        <label for="notelp" class="form-label">No.Telp</label>
        <input type="text" class="form-control" id="notelp" name="notelp" minlength="13" maxlength="18" required oninput="formatNumber(this)">
        <div id="telpError" class="text-danger small"></div>
      </div>

      <div class="mb-3">
        <label for="role" class="form-label">Pilih Role</label>
        <select name="role" id="role" class="form-select" required>
          <option value="" disabled selected>Pilih Role</option>
          <option value="admin">Admin</option>
          <option value="petugas">Petugas</option>
        </select>
      </div>

      <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
      $nik     = preg_replace('/\D/', '', $_POST['nik']);
      $email   = mysqli_real_escape_string($conn, $_POST['email']);
      $username= mysqli_real_escape_string($conn, $_POST['username']);
      $telp    = preg_replace('/\D/', '', $_POST['notelp']);
      $level   = $_POST['role'];
      $password_raw = $_POST['password'];
      $password = password_hash($password_raw, PASSWORD_DEFAULT);

      $errors = [];

      if (strlen($nik) != 16) $errors[] = "NIK harus 16 digit angka";
      if (!in_array($level, ['admin', 'petugas'])) $errors[] = "Level tidak valid";
      if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM petugas WHERE username='$username'")) > 0)
        $errors[] = "Username sudah digunakan";
      if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM petugas WHERE email='$email'")) > 0)
        $errors[] = "Email sudah terdaftar";
      if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM petugas WHERE telp='$telp'")) > 0)
        $errors[] = "No. Telp sudah terdaftar";

      if (empty($errors)) {
        $query = "INSERT INTO petugas (nik, email, username, password, telp, level) VALUES ('$nik','$email','$username','$password','$telp','$level')";
        if (mysqli_query($conn, $query)) {
          echo "<script>
            document.addEventListener('DOMContentLoaded', () => {
              Swal.fire('Berhasil!', 'Akun berhasil ditambahkan.', 'success').then(() => window.location.href = 'index.php');
            });
          </script>";
        } else {
          echo "<script>
            document.addEventListener('DOMContentLoaded', () => {
              Swal.fire('Gagal!', 'Kesalahan sistem: " . mysqli_error($conn) . "', 'error');
            });
          </script>";
        }
      } else {
        $error_msg = implode(', ', $errors);
        echo "<script>
          document.addEventListener('DOMContentLoaded', () => {
            Swal.fire('Validasi Gagal!', '$error_msg', 'error');
          });
        </script>";
      }
    }
    ?>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.getElementById('togglePassword').addEventListener('click', function () {
    const input = document.getElementById('password');
    const icon = this.querySelector('i');
    input.type = input.type === 'password' ? 'text' : 'password';
    icon.classList.toggle('bi-eye');
    icon.classList.toggle('bi-eye-slash');
  });

  function formatNumber(input) {
    const value = input.value.replace(/\D/g, '');
    const formatted = value.match(/.{1,4}/g);
    input.value = formatted ? formatted.join('-') : '';
  }

  document.getElementById("tambahAkunForm").addEventListener("submit", function(e) {
    let isValid = true;

    const email = document.getElementById("email").value;
    if (!email.endsWith("@gmail.com") && !email.endsWith("@yahoo.com")) {
      document.getElementById("emailError").textContent = "Gunakan @gmail.com atau @yahoo.com";
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

    const telp = document.getElementById("notelp").value.replace(/\D/g, '');
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
