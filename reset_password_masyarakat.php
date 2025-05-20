<?php
require 'config/db.php';

$token = $_GET['token'];
$query = mysqli_query($conn, "SELECT * FROM masyarakat WHERE reset_token = '$token' AND token_expiry > NOW()");
if (mysqli_num_rows($query) == 0) {
    echo"
    <html>
    <head>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({ 
                icon: 'error', 
                title: 'Error!', 
                text: 'Token tidak valid atau kadaluwarsa!' 
            }).then(() => { 
                window.location.href = 'lupa_password_masyarakat.php'; 
            });
        </script>
    </body>
    </html>";
    exit;
}
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
    <title>Reset Password - MyReport</title>
</head>

<body>
    <h1 class="container mt-5">Lupa Password?</h1>
    <div class="container justify-content-center align-items-center mt-5">
        <div class="row">
            <div class="col-12 border border-dark rounded p-5">
                <div class="container">
                    <form class="container w-10" enctype="multipart/form-data" method="post" action="update_password_masyarakat.php">
        <input type="hidden" name="token" value="<?php echo $token; ?>">
<div class="mb-3">
    <label for="password" class="form-label">New Password</label>
    <div class="position-relative">
        <input type="password" name="password_baru" class="form-control pe-5" id="password" placeholder="******">
        <button type="button" class="btn position-absolute end-0 top-50 translate-middle-y me-2 toggle-password password-toggle">
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
                </div>
            </div>
        </div>
    </div>

    <script src="assets/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="assets/fontawesome/js/all.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
document.querySelector('.password-toggle').addEventListener('click', function() {
            const passwordInput = document.querySelector('#password');
            const icon = this.querySelector('i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    </script>
</body>

</html>