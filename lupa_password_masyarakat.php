<?php
require 'vendor/autoload.php';
require 'config/db.php';


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $query = mysqli_query($conn, "SELECT * FROM masyarakat WHERE email = '$email'");

    if ($query && mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
        $token = bin2hex(random_bytes(32));
        $resetLink = "http://localhost/ProjectPengaduanMasyarakat/reset_password_masyarakat.php?token=$token";
        date_default_timezone_set('Asia/Jakarta');
        $expires = date("Y-m-d H:i:s", strtotime("+1 hour"));
        $update = mysqli_query($conn, "UPDATE masyarakat SET reset_token='$token', token_expiry='$expires' WHERE email='$email'");

        if ($update) {
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
$mail->Host       = $_ENV['MAIL_HOST'];
$mail->SMTPAuth   = true;
$mail->Username   = $_ENV['MAIL_USERNAME'];
$mail->Password   = $_ENV['MAIL_PASSWORD'];
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port       = $_ENV['MAIL_PORT'];

$mail->setFrom($_ENV['MAIL_FROM_ADDRESS'], $_ENV['MAIL_FROM_NAME']);
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'Reset Password MyReport';

                $template = file_get_contents('config/email_lupa_password_masyarakat.html');
                $template = str_replace('{link_reset}', $resetLink, $template);
                $mail->Body = $template;

                $mail->send();

                $message = "<script>
                    Swal.fire({ icon: 'success', title: 'Sukses!', text: 'Link reset telah dikirim ke email Anda.' })
                    .then(() => { window.location.href = 'login.php'; });
                </script>";
            } catch (Exception $e) {
                $message = "<script>
                    Swal.fire({ icon: 'error', title: 'Email gagal dikirim!', text: 'Terjadi kesalahan saat mengirim email.' });
                </script>";
            }
        }
    } else {
        $message = "<script>
            Swal.fire({ icon: 'error', title: 'Gagal!', text: 'Email tidak ditemukan dalam database.' });
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lupa password masyarakat - MyReport</title>
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body {
      min-height: 100vh;
      background: linear-gradient(135deg, rgba(0, 0, 0, 0.6), rgba(0, 123, 255, 0.4));
      font-family: 'Segoe UI', sans-serif;
      color: white;
    }

    .glass-card {
      background: rgba(255, 255, 255, 0.1);
      border-radius: 20px;
      padding: 30px;
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
  </style>
</head>

<body>
    <?php include('config/navbar.php');?>
  <div class="glass-card text-white container py-5 mt-5">
    <h2 class="text-center mb-4">Lupa Password?</h2>
    <form method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="username" placeholder="Example@gmail.com" name="email" required>
      </div>
      <div class="d-flex justify-content-center">
        <button class="btn btn-primary px-4" name="submit" id="submit">Submit</button>
      </div>
    </form>
    <div class="mt-3">
      <?= $message ?>
    </div>
  </div>

  <script src="assets/bootstrap/js/bootstrap.bundle.js"></script>
  <script src="assets/fontawesome/js/all.min.js"></script>
  <script src="https://unpkg.com/feather-icons"></script>
</body>

</html>
