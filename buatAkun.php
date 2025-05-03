<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Akun</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            max-width: 700px;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .navbar {
            background-color: #3464eb;
        }
        .navbar-brand, .nav-link {
            color: #fff !important;
        }

        .navbar-brand {
            transform: scale(0.6);
        }
        .form-title {
            margin-bottom: 25px;
            color: #333;
        }
        .btn-primary {
            background-color: #0d6efd;
            border: none;
            width: 100%;
        }
        .btn-primary:hover {
            background-color: #0b5ed7;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="storages/logo.png" alt="logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-house-door me-1"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-list-ul me-1"></i> List Laporan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-people me-1"></i> List Akun</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#"><i class="bi bi-person-plus me-1"></i> Buat Akun</a>
                    </li>
                </ul>
                <div class="ms-auto text-white">
                    <i class="bi bi-person-circle me-1"></i> <span id="currentUsername">Admin</span>
                </div>
            </div>
        </div>
    </nav>

    <!-- Form Container -->
    <div class="container">
        <div class="form-container">
            <h2 class="form-title">Tambah Akun</h2>
            <form>
                <!-- NIK -->
                <div class="mb-3">
                    <label for="nik" class="form-label">NIK</label>
                    <input type="text" class="form-control" id="nik" placeholder="320xxxx">
                </div>

                <!-- Nama -->
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" placeholder="nama">
                </div>

                <!-- Username -->
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" placeholder="username">
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" placeholder="••••••••">
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- No. Telp -->
                <div class="mb-3">
                    <label for="notelp" class="form-label">No.Telp</label>
                    <input type="text" class="form-control" id="notelp" placeholder="083xxxx">
                </div>

                <!-- Pilih Role Dropdown -->
                <div class="mb-3">
                    <label for="role" class="form-label">Pilih Role</label>
                    <select class="form-select" id="role">
                        <option selected disabled>Pilih Role</option>
                        <option value="admin">Admin</option>
                        <option value="petugas">Petugas</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
    <!-- Password toggle script -->
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });

        // Simulasi untuk menampilkan username pengguna yang sedang login
        // Dalam implementasi nyata, ini akan diambil dari session
        document.addEventListener('DOMContentLoaded', function() {
            // Contoh data pengguna (dalam aplikasi nyata, ini akan diambil dari sistem)
            const loggedInUser = {
                username: "John",
                role: "Admin"
            };
            
            // Tampilkan username di navbar
            document.getElementById('currentUsername').textContent = loggedInUser.username;
            
            // Ketika form di-submit, kita bisa mengupdate username di navbar jika diperlukan
            document.querySelector('form').addEventListener('submit', function(e) {
                e.preventDefault();
                alert('Akun berhasil ditambahkan!');
                
                // Kode untuk menyimpan data akun baru ke database akan ditambahkan di sini
            });
        });
    </script>
</body>
</html>