<?php
// Mengambil konfigurasi session dan database
require ('config/session.php');
require ('config/db.php');

// Ambil data user dari database berdasarkan session
// Cek terlebih dahulu apakah variabel session nik ada
if(isset($_SESSION['nik'])) {
    $nik = $_SESSION['nik'];
}

// Query database dengan error handling
$query = "SELECT * FROM masyarakat WHERE nik = '$nik'";
$result = mysqli_query($conn, $query);

// Cek apakah query berhasil
if(!$result) {
    // Jika query gagal, tampilkan error
    echo "Error dalam query: " . mysqli_error($conn);
    exit();
}

if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    $nik = isset($user['nik']) ? $user['nik'] : '';
    $email = isset($user['email']) ? $user['email'] : '';
    $username = isset($user['username']) ? $user['username'] : '';
    $telp = isset($user['telp']) ? $user['telp'] : '';
    // Password tidak ditampilkan langsung karena alasan keamanan
} else {
    // // Jika data user tidak ditemukan, logout
    header("Location: login.php");
    exit();
}

// Proses update data user
if (isset($_POST['save_changes'])) {
    $new_username = mysqli_real_escape_string($conn, $_POST['username']);
    $new_password = $_POST['password'];

    // Jika password diubah, hash password baru
    if (!empty($new_password)) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_query = "UPDATE masyarakat SET username = '$new_username', password = '$hashed_password' WHERE nik = '$nik'";
    } else {
        // Jika password tidak diubah
        $update_query = "UPDATE masyarakat SET username = '$new_username' WHERE nik = '$nik'";
    }

    if (mysqli_query($conn, $update_query)) {
        $_SESSION['message'] = "Perubahan berhasil disimpan!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Terjadi kesalahan: " . mysqli_error($conn);
        $_SESSION['message_type'] = "error";
    }

    // Refresh halaman untuk menampilkan data terbaru
    header("Location: dashboard.php");
    exit();
}

// Proses hapus akun
if (isset($_POST['delete_account'])) {
    $delete_query = "DELETE FROM masyarakat WHERE nik = '$nik'";

    if (mysqli_query($conn, $delete_query)) {
        session_destroy();
        $_SESSION['message'] = "Akun Anda telah dihapus!";
        $_SESSION['message_type'] = "success";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['message'] = "Terjadi kesalahan saat menghapus akun: " . mysqli_error($conn);
        $_SESSION['message_type'] = "error";
    }
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Account User</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- fontawesome -->
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.6), rgba(0, 123, 255, 0.4));
            color: white;
            min-height: 100vh;
            z-index: -1;
        }

        .profile-image {
            width: 60px;
            height: 60px;
            background-color: #3373b5;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            object-fit: cover;
        }

        .btn-simpan {
            background-color: #0000ff;
        }

        .btn-danger {
            background-color: #ff0000;
        }

                .form-control:read-only {
            cursor: not-allowed;
        }

        .dashboard-header {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .btn-outline-secondary:hover {
            background-color: #0000ff;
            color: white;
        }

        .dashboard-header i {
            margin-right: 0.5rem;
            font-size: 1.5rem;
        }

        .user-card{
                  backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      background: rgba(255, 255, 255, 0.15);
      border-radius: 18px;
      box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2);
      border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .user-form{
                  backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      background: rgba(255, 255, 255, 0.15);
      border-radius: 18px;
      box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2);
      border: 1px solid rgba(255, 255, 255, 0.18);
      padding: 2rem 2.5rem;
      margin-top: 2rem;
      margin-bottom: 2rem;
        }
              .nik, .email, .password, .telp, .username{
      width: 100%;
      padding: 12px;
            border: none;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            outline: none;
            transition: background 0.3s;
    }
    
              .nik:focus, .email:focus, .password:focus, .telp:focus, .username:focus{
                color: white;
            background: rgba(255, 255, 255,0.2);
    }
    .form-control:read-only{
        cursor: not-allowed;
    }
    </style>
</head>
<body>
    <?php include('config/navbar.php')?>
    <!-- Main Content -->
    <div class="container">
        <!-- Dashboard Title -->
        <div class="dashboard-header">
            <i class="bi bi-grid-3x3-gap-fill"></i>
            <h4 class="mb-0">Dashboard</h4>
        </div>

        <!-- User Card -->
        <div class="card mb-4 user-card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="profile-image me-3">
                        <i class="bi bi-person-fill fs-3"></i>
                    </div>
                    <h5 class="mb-0"><?php echo htmlspecialchars($username); ?></h5>
                </div>
                <a href="history_laporan.php" class="btn btn-outline-dark">
                    <i class="bi bi-list-ul me-2"></i>
                    List Laporan
                </a>
            </div>
        </div>

        <!-- User Form -->
        <div class="card user-form">
            <div class="card-body">
                <form id="userForm" method="POST">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nik" class="form-label fw-bold">NIK</label>
                            <input type="text" class="form-control nik" id="nik" name="nik" value="<?php echo htmlspecialchars($nik); ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="text" class="form-control email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="telp" class="form-label fw-bold">Telp</label>
                            <input type="text" class="form-control telp" id="telp" name="telp" value="<?php echo htmlspecialchars($telp); ?>" readonly>
                        </div>
                     <div class="col-md-6">
                            <label for="username" class="form-label fw-bold">Username</label>
                            <input type="text" class="form-control username" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>">
                        </div>
                        
                    </div>
                    <div class="row mb-3">
        <div class="col-md-12">
                            <label for="password" class="form-label fw-bold">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control password" id="password" name="password" placeholder="Masukkan password baru" pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,}$"
                 title="Minimal 8 karakter, 1 huruf besar, 1 angka, dan 1 karakter spesial">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">
                                    <i class="bi bi-eye" id="passwordToggleIcon"></i>
                                </button>
                            </div>
                            <small class="text-muted">Minimal 8 karakter, 1 huruf besar, 1 angka, dan 1 karakter spesial</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 mt-3">
                            <button type="button" class="btn btn-primary btn-simpan w-100" onclick="confirmSaveChanges()">
                                Simpan Perubahan
                            </button>
                        </div>
                        <div class="col-md-6 mt-3">
                            <button type="button" class="btn btn-danger w-100" onclick="confirmDeleteAccount()">
                                Hapus Akun <i class="bi bi-trash ms-1"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Hidden buttons for form submission -->
                    <input type="submit" name="save_changes" id="save_changes_submit" style="display: none;">
                    <input type="submit" name="logout" id="logout_submit" style="display: none;">
                    <input type="submit" name="delete_account" id="delete_account_submit" style="display: none;">
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Tampilkan SweetAlert jika ada pesan dari PHP
        <?php if(isset($_SESSION['message'])): ?>
        Swal.fire({
            icon: '<?php echo $_SESSION['message_type']; ?>',
            title: '<?php echo $_SESSION['message']; ?>',
            showConfirmButton: false,
        });
        <?php 
            // Hapus pesan setelah ditampilkan
            unset($_SESSION['message']); 
            unset($_SESSION['message_type']); 
        endif; 
        ?>

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

        function confirmSaveChanges() {
            Swal.fire({
                title: 'Simpan Perubahan?',
                text: 'Apakah Anda yakin ingin menyimpan perubahan?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0000ff',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('save_changes_submit').click();
                }
            });
        }

        function confirmLogout() {
            Swal.fire({
                title: 'Logout?',
                text: 'Apakah Anda yakin ingin keluar dari sistem?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Logout!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout_submit').click();
                }
            });
        }

        function confirmDeleteAccount() {
            Swal.fire({
                title: 'Hapus Akun?',
                text: 'Apakah Anda yakin ingin menghapus akun? Tindakan ini tidak dapat dibatalkan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus Akun!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete_account_submit').click();
                }
            });
        }
    </script>
</body>
</html>