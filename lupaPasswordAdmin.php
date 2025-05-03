<?php
require ('config/db.php');

$queryGetPasswordMasyarakat = mysqli_query($conn, "SELECT password FROM petugas");
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

          <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" placeholder="Example123">
                        </div>

            <div class="mb-3">
    <label for="password-lama" class="form-label">Password Lama</label>
    <div class="position-relative">
        <input type="password" name="password-lama" class="form-control pe-5" id="password-lama" placeholder="******">
        <button type="button" class="btn position-absolute end-0 top-50 translate-middle-y me-2 toggle-password-lama">
            <i class="fa fa-eye"></i>
        </button>
    </div>
</div>

<div class="mb-3">
    <label for="password-baru" class="form-label">Password Baru</label>
    <div class="position-relative">
        <input type="password" name="password-baru" class="form-control pe-5" id="password-baru" placeholder="******">
        <button type="button" class="btn position-absolute end-0 top-50 translate-middle-y me-2 toggle-password-baru">
            <i class="fa fa-eye"></i>
        </button>
    </div>
</div>

            <div class="row">
              <div class="container align-items-center justify-content-center d-flex mt-2">
                <button class="btn btn-primary col-md-2" name="submit" id="submit">Submit</button>
              </div>
            </div>
          </form>

          <?php
if (isset($_POST['submit'])) {
    $name = htmlspecialchars($_POST['username']);
    $passwordLama = htmlspecialchars($_POST['password-lama']);
    $passwordBaru = htmlspecialchars($_POST['password-baru']);

    // Ganti sesuai dengan query Anda untuk cek user
    $queryGetPassworPMasyarakat = mysqli_query($conn, "SELECT password FROM petugas WHERE username = '$name'");

    if ($data = mysqli_fetch_array($queryGetPasswordPetugas)) {
        if ($passwordLama == $data['password']) {
            $queryUpdatePassword = mysqli_query($conn, "UPDATE petugas SET password = '$passwordBaru' WHERE username = '$name'");
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
                    text: "Password Salah",
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
            function setupToggle(idInput, toggleClass) {
        document.querySelector(toggleClass).addEventListener('click', function () {
            const input = document.querySelector(idInput);
            const icon = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    }
  </script>
</body>
</html>