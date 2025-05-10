
<?php
require 'config/db.php';

$token = $_POST['token'];
$passwordBaru = $_POST['password_baru'];

$query = mysqli_query($conn, "SELECT * FROM petugas WHERE reset_token='$token'");
if (mysqli_num_rows($query) > 0) {
    $hashed = $passwordBaru; // Sebaiknya di-hash: password_hash($passwordBaru, PASSWORD_DEFAULT)
    mysqli_query($conn, "UPDATE petugas SET password='$hashed', reset_token=NULL, token_expiry=NULL WHERE reset_token='$token'");
  echo "
    <html>
    <head>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
        Swal.fire({ icon: 'success', title: 'Sukses!', text: 'Password telah berhasil diperbarui.' })
        .then(() => { window.location.href = 'login.php'; });
        </script>
    </body>
    </html>";
    exit;
} else {
   echo "
    <html>
    <head>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
        Swal.fire({ icon: 'error', title: 'Error!', text: 'Token tidak valid!' })
        .then(() => { window.location.href = 'lupa_password_masyarakat.php'; });
        </script>
    </body>
    </html>";
    exit;
}
