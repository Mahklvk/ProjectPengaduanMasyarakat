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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Reset Password - MyReport</title>
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="assets/fontawesome/css/all.min.css" />
  <link rel="stylesheet" href="assets/css/style.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body {
      min-height: 100vh;
      margin: 0;
      background: linear-gradient(135deg, rgba(0, 0, 0, 0.6), rgba(0, 123, 255, 0.4));
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Segoe UI', sans-serif;
      color: white;
    }

    .glass-card {
      background: rgba(255, 255, 255, 0.1);
      border-radius: 20px;
      padding: 40px;
      backdrop-filter: blur(15px);
      -webkit-backdrop-filter: blur(15px);
      border: 1px solid rgba(255, 255, 255, 0.2);
      box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
      width: 100%;
      max-width: 500px;
    }

    .form-control {
      background: rgba(255, 255, 255, 0.2);
      border: none;
      color: white;
    }

    .form-control::placeholder {
      color: #ddd;
    }

    .form-control:focus {
      background: rgba(255, 255, 255, 0.3);
      color: white;
      box-shadow: none;
      border: 1px solid rgba(255, 255, 255, 0.4);
    }

    .btn-primary {
      background-color: rgba(0, 123, 255, 0.7);
      border: none;
      transition: 0.3s;
    }

    .btn-primary:hover {
      background-color: rgba(0, 123, 255, 1);
    }

    .password-toggle {
      background: transparent;
      border: none;
      color: white;
    }
  </style>
</head>

<body>
  <div class="glass-card">
    <h2 class="text-center mb-4">Reset Password</h2>
    <form method="post" enctype="multipart/form-data" action="update_password_masyarakat.php">
      <input type="hidden" name="token" value="<?php echo $token; ?>" />
      <div class="mb-3">
        <label for="password" class="form-label">New Password</label>
        <div class="position-relative">
          <input type="password" name="password_baru" class="form-control pe-5" id="password" placeholder="******" required                                         pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,}$"
                                        title="Minimal 8 karakter, 1 huruf besar, 1 angka, dan 1 karakter spesial"/>
          <button type="button" class="btn position-absolute end-0 top-50 translate-middle-y me-2 toggle-password password-toggle">
            <i class="fa fa-eye"></i>
        </button>
    </div>
    <small class="text-muted">Password harus 8 karakter, 1 huruf besar, 1 angka & 1 simbol.</small>
      </div>
      <div class="d-flex justify-content-center mt-3">
        <button class="btn btn-primary px-4" name="submit" id="submit">Submit</button>
      </div>
    </form>
  </div>

  <script src="assets/bootstrap/js/bootstrap.bundle.js"></script>
  <script src="assets/fontawesome/js/all.min.js"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <script>
    document.querySelector('.password-toggle').addEventListener('click', function () {
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