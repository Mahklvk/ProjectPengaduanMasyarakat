<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyReport - Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Menggunakan Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .form-control {
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 20px;
        }
        .btn-register {
            background-color: #0d6efd;
            color: white;
            border-radius: 8px;
            padding: 12px;
            width: 100%;
            font-weight: bold;
        }
        .back-button {
            width: 40px;
            height: 40px;
            background-color: #3871c1;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            margin-bottom: 15px;
        }
        .back-button:hover {
            background-color: #2d5a9e;
            color: white;
        }
        .logo-icon {
            height: auto;
            max-height: 40px;
            position: absolute;
            top: 15px;
            right: 190px;
        }

        .logo-text {
            height: auto;
            max-height: 30px;
            position: absolute;
            top: 20px;
            right: 40px;
            }

        .logo img {
            width: 30px;
        }
        .welcome-section {
            text-align: center;
            padding: 20px;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .welcome-text {
            color: #1a3747;
            font-weight: bold;
            font-size: 2.2rem;
            margin-bottom: 10px;
        }
        .sub-text {
            color: #1a3747;
            font-size: 1.2rem;
            margin-bottom: 5px;
        }
        .illustration {
            text-align: center;
            margin-top: 30px;
        }
        .illustration img {
            max-width: 100%;
            height: auto;
            max-height: 500px;
        }
        .password-toggle {
            position: relative;
        }
        .password-toggle i {
            position: absolute;
            right: 15px;
            top: 15px;
            cursor: pointer;
            color: #6c757d;
        }
        .right-side-header {
            background-color: white;
            padding: 20px;
            border-radius: 0 10px 0 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .right-side-content {
            display: flex;
            flex-direction: column;
            height: calc(100% - 70px);
        }
    </style>
</head>
<body>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="row g-0">
                            <div class="col-md-6 p-4">
                                <a href="#" class="back-button">
                                    <i class="bi bi-arrow-left"></i>
                                </a>
                                <h2 class="mb-1">Register</h2>
                                <p class="mb-4 text-muted">Daftarkan Akun Anda</p>

                                <form>
                                    <div class="mb-3">
                                        <label for="nik" class="form-label">NIK</label>
                                        <input type="text" class="form-control" id="nik" placeholder="320xxxxxxxxxxx">
                                    </div>
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" placeholder="Name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" placeholder="Name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <div class="password-toggle">
                                            <input type="password" class="form-control" id="password" placeholder="*">
                                            <i class="bi bi-eye" id="togglePassword"></i>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">No Telp</label>
                                        <input type="text" class="form-control" id="phone" placeholder="08xxxxxxxxx">
                                    </div>

                                    <button type="submit" class="btn btn-register">Register</button>
                                </form>
                            </div>

                            <div class="col-md-6 p-0">
                                <div class="right-side-header">
                                    <div class="navbar-brand d-flex align-items-center">
                                        <img src="storages/logo2.png" alt="MyReport Icon" class="logo-icon me-2">
                                        <img src="storages/MyReport2.png" alt="MyReport Text" class="logo-text">
                                    </div>
                                </div>
                                <div class="right-side-content">
                                    <div class="welcome-section">
                                        <h1 class="welcome-text">Selamat datang</h1>
                                        <p class="sub-text">Di Pengaduan Masyarakat</p>
                                        
                                        <div class="illustration">
                                            <img src="storages/register.png" alt="Ilustrasi Welcome">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });
    </script>
</body>
</html>