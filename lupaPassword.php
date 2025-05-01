<?php
require ('config/db.php');

$queryGetPasswordMasyarakat = mysqli_query($conn, "SELECT password FROM masyarakat");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css"> <!-- link bootstrap untuk bisa styling bootstrap -->
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css"> <!-- link fontawesome untuk bisa mengakses icon -->
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Document</title>
</head>
<body>
    <h1 class="container mt-5">Lupa Password?</h1>
<div class="container justify-content-center align-items-center mt-5">
    <div class="row">
      <div class="col-12 border border-dark rounded p-5">
        <div class="container">
          <form action="" class="container w-10" enctype="multipart/form-data" method="post">

            <label for="username" class="form-label">Nama</label>
            <input type="username" class="form-control" name="username" id="username" required>

            <label for="password" class="form-label">Password Lama</label>
            <input type="password" class="form-control" name="password-lama" id="password-lama" required>
            <div class="form-check">
            <input type="checkbox" id="lihatPassword-lama">
            <label for="lihatPassword-lama">Tampilkan Password</label>
            </div>
            

            <label for="password" class="form-label mt-2">Password Baru</label>
            <input type="password" class="form-control" name="password-baru" id="password-baru" required>
            <div class="form-check">
            <input type="checkbox" id="lihatPassword-baru">
            <label for="lihatPassword-baru">Tampilkan Password</label>
            </div>

            <div class="row">
              <div class="container align-items-center justify-content-center d-flex mt-2">
                <button class="btn btn-primary col-2" name="submit" id="submit">Submit</button>
              </div>
            </div>
          </form>

          <?php
if (isset($_POST['submit'])) {
    $name = htmlspecialchars($_POST['username']);
    $passwordLama = htmlspecialchars($_POST['password-lama']);
    $passwordBaru = htmlspecialchars($_POST['password-baru']);

    // Ganti sesuai dengan query Anda untuk cek user
    $queryGetPasswordMasyarakat = mysqli_query($conn, "SELECT password FROM masyarakat WHERE username = '$name'");

    if ($data = mysqli_fetch_array($queryGetPasswordMasyarakat)) {
        if ($passwordLama == $data['password']) {
            $queryUpdatePassword = mysqli_query($conn, "UPDATE masyarakat SET password = '$passwordBaru' WHERE username = '$name'");
            if ($queryUpdatePassword) {
                ?>
                <script>
                    Swal.fire({
                        title: "Sukses!",
                        text: "Password Telah Terupdate",
                        icon: "success"
                    });
                </script>
                <?php
            }
        } else {
            ?>
            <script>
                Swal.fire({
                    title: "ERROR",
                    text: "Password Salah tidak ditemukan",
                    icon: "error"
                });
            </script>
            <?php
        }
    } else {
        ?>
        <script>
            Swal.fire({
                title: "ERROR",
                text: "Username tidak ditemukan",
                icon: "error"
            });
        </script>
        <?php
    }
}
?>
          </div>
          </div>
          </div>
          </div>

          <script src="assets/bootstrap/js/bootstrap.bundle.js"></script>
  <script src="assets/fontawesome/js/all.min.js"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <script>
     document.getElementById('lihatPassword-lama').addEventListener('change', function () {
    const passwordLama = document.getElementById('password-lama');
    passwordLama.type = this.checked ? 'text' : 'password';
     });

     document.getElementById('lihatPassword-baru').addEventListener('change', function () {
    const passwordBaru = document.getElementById('password-baru');
    passwordBaru.type = this.checked ? 'text' : 'password';
     });
  </script>
</body>
</html>