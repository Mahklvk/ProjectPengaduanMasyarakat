<?php
require "config/sessionLogin.php";
require('../config/db.php');
$id = $_GET['p'];
$querySelectLaporan = mysqli_query($conn, "SELECT * FROM petugas WHERE id_petugas='$id'");
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
    <title>Detail Akun Admin - MyReport</title>
</head>
<body>
    <?php include('config/navbar.php')?>
    <h2 class="text-center mt-4"><?php echo $fetch_data['username']?></h2>
    <div class="container mt-4">
        <div class="row items-start border border-dark rounded p-2">
            <div class="col-md-12 p-3">
                <form action="" method="post">
            <label class="form-label">NIK</label>
<input type="text" class="form-control" id="nik" value="<?php echo $fetch_data['nik']?>" name="nik" maxlength="19" autocomplete="off"   oninput="formatNumber(this)" readonly>

<label class="form-label">Email</label>
<input type="text" class="form-control" name="email" value="<?php echo $fetch_data['email']?>" readonly>

<label class="form-label">Username</label>
<input type="text" class="form-control" name="username" value="<?php echo $fetch_data['username']?>">


<label for="password" class="form-label fw-bold">Password</label>
<div class="input-group">
 <input type="password" class="form-control" id="password" name="password" placeholder="Password anda">
<button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">
<i class="fa fa-eye" id="passwordToggleIcon"></i>
</button>
</div>
<small class="text-muted">Password tidak ditampilkan untuk masalah keamanan</small><br>

<label class="form-label">No. Telp</label>
<input type="text" class="form-control" name="telp" value="<?php echo $fetch_data['telp']?>" oninput="formatNumber(this)" minlength="13" maxlength="18">


          <label for="date" class="form-label">Role</label>
          <input type="text" class="form-control" name="date" id="date" disabled value="<?php echo $fetch_data['level']?>">
          </form>
            </div>
             <div class="row">
            <div class="container align-items-center justify-content-center d-flex mt-2 col-md-6">
            <button type="button" class="btn btn-primary me-2" name="approve" onclick="editAkun(<?php echo $fetch_data['id_petugas']?>)">Simpan Perubahan</button>
            </div>
            <div class="container align-items-center justify-content-center d-flex mt-2 col-md-6">
            <button type="button" class="btn btn-danger" onclick="hapusAkun(<?php echo $fetch_data['id_petugas']?>)">Hapus Akun</button>
            </div>
          </div>
        </div>
    </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  
    function togglePassword() {
            const passwordField = document.getElementById('password');
            const eyeIcon = document.getElementById('passwordToggleIcon');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                passwordField.type = 'password';
                eyeIcon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        }
        
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
    function editAkun(idPetugas){
  Swal.fire({
    title: 'Apakah Kamu Yakin?',
    text: "Simpan perubahan?",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'IYA!'
  }).then((result) => {
    if (result.isConfirmed) {
      // Ambil nilai dari input form
      const nik = document.querySelector('input[name="nik"]').value;
      const email = document.querySelector('input[name="email"]').value;
      const username = document.querySelector('input[name="username"]').value;
      const password = document.querySelector('input[name="password"]').value;
      const telp = document.querySelector('input[name="telp"]').value;

      fetch('edit_akun_admin.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          id_petugas: idPetugas,
          nik: nik,
          email: email,
          username: username,
          password: password,
          telp: telp
        }),
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          Swal.fire(
            'Berhasil!',
            'Akun telah diperbarui.',
            'success'
          ).then(() => {
            window.location.href = 'listAccountAdmin.php';
          });
        } else {
          Swal.fire(
            'Error!',
            data.message || 'Gagal memperbarui akun.',
            'error'
          );
        }
      })
      .catch(error => {
        Swal.fire(
          'Error!',
          'Terjadi kesalahan saat menyimpan perubahan.',
          'error'
        );
      });
    }
  });
}

    function hapusAkun(idLaporan){
      Swal.fire({
  title: 'Apakah Kamu Yakin?',
  text: "Akun ini akan dihapus dan tidak bisa diulang lagi.",
  icon: 'question',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Hapus!'
}).then((result) => {
  if (result.isConfirmed) {
    fetch('hapus_akun_admin.php', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
  },
  body: JSON.stringify({
    id_petugas: idLaporan
  }),
})
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        Swal.fire(
          'Berhasil!',
          'Akun berhasil dihapus.',
          'success'
        ).then(() => {
          window.location.href = 'listAccountAdmin.php';
        });
      } else {
        Swal.fire(
          'Error!',
          data.message || 'Tidak bisa menghapus akun.',
          'error'
        );
      }
    })
    .catch(error => {
      Swal.fire(
        'Error!',
        'Ada yang salah ketika menghapus akun.',
        'error'
      );
    });
  }
});
    }
</script>
</body>
</html>