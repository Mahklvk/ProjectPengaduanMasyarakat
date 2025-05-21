<?php
require 'vendor/autoload.php';
require 'config/db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

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
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css"> <!-- link bootstrap untuk bisa styling bootstrap -->
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css"> <!-- link fontawesome untuk bisa mengakses icon -->
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Lupa password admin - MyReport</title>
</head>

<body>
    <h1 class="container mt-5">Lupa Password?</h1>
    <div class="container justify-content-center align-items-center mt-5">
        <div class="row">
            <div class="col-12 border border-dark rounded p-5">
                <div class="container">
                    <form class="container w-10" enctype="multipart/form-data" method="post">

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="username" placeholder="Example@gmail.com" name="email">
                        </div>
                        <div class="row">
                            <div class="container align-items-center justify-content-center d-flex mt-2">
                                <button class="btn btn-primary col-md-2" name="submit" id="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                    <?= $message ?>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="assets/fontawesome/js/all.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
</body>

</html>