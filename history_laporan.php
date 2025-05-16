<?php
require ('config/session.php');
require ('config/db.php');
$nik = $_SESSION['nik'];

// Ambil data user dari database berdasarkan session
// Cek terlebih dahulu apakah variabel session nik ada
if(isset($_SESSION['nik'])) {
    $nik = $_SESSION['nik'];
} else {
    // Jika tidak ada variabel nik, coba cek variabel lain yang mungkin menyimpan nik user
    if(isset($_SESSION['id_user'])) {
        $nik = $_SESSION['id_user'];
    } else if(isset($_SESSION['user_id'])) {
        $nik = $_SESSION['user_id'];
    } else if(isset($_SESSION['id'])) {
        $nik = $_SESSION['id'];
    } else {
        // Jika tidak ada variabel nik yang ditemukan, redirect ke login
        $_SESSION['message'] = "Sesi tidak valid. Silakan login kembali.";
        $_SESSION['message_type'] = "error";
        header("Location: login.php");
        exit();
    }
}


$queryGetData= mysqli_query($conn, "SELECT * FROM pengaduan WHERE nik= '$nik'")

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Laporan - MyReport</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <style> 
        .search-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .search-box {
            width: 800px;
            position: relative;
        }
        
        .search-box input {
            padding-left: 40px;
            border-radius: 5px;
        }
        
        .search-icon {
            position: absolute;
            left: 15px;
            top: 10px;
            color: #6c757d;
        }
        
        .btn-primary {
            position: fixed;
            bottom: 5rem;
            right: 4rem;
            background-color: #3E6EA2;
            border-color: #3E6EA2;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <?php include('config/navbar.php');?>

    <!-- Main Content -->
    <div class="container">
        <h1 class="page-title">Daftar Laporan</h1>
        
        <!-- Search -->
        <div class="search-container">
            <div class="search-box">
                <i class="bi bi-search search-icon"></i>
                <input type="text" class="form-control" placeholder="Cari Laporan" id="searchInput">
            </div>
        </div>
        
        <!-- Table -->
        <div class="report-table table-responsive">
            <table class="table table-hover " id="reportTable">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">judul laporan</th>
                        <th width="15%">Tanggal laporan</th>
                        <th width="15%">Nik</th>
                        <th width="15%">Isi Laporan</th>
                        <th width="15%">Foto</th>
                        <th width="10%">Status</th>
                        <th width="10%">Action</th>
                    </tr>
                </thead>


                <!-- add report-->
                <button class="btn btn-primary" id="addReportBtn">
                <i class="bi bi-plus-circle"></i> Buat laporan
            </button>
                <tbody>
                    <?php
if (mysqli_num_rows($queryGetData) > 0) {
    $no = 1;
    while ($data = mysqli_fetch_array($queryGetData)) { ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $data['judul_laporan']; ?></td>
            <td><?php echo $data['tgl_pengaduan']; ?></td>
            <td><?php echo $data['nik']; ?></td>
            <td><?php echo $data['isi_laporan']; ?></td>
            <td><?php echo $data['foto']; ?></td>
            <?php
            $status = trim($data['status']);
            switch ($status) {
                case 'diproses':
                    $class = 'btn btn-outline-secondary rounded-pill btn-sm';
                    break;
                case 'ditolak':
                    $class = 'btn btn-outline-danger rounded-pill btn-sm';
                    break;
                case 'selesai':
                    $class = 'btn btn-outline-success rounded-pill btn-sm';
                    break;
                default:
                    $class = 'btn btn-outline-secondary rounded-pill btn-sm';
                    break;
            }
            echo '<td><span class="' . $class . '">' . htmlspecialchars($status) . '</span></td>';
            ?>
            <td><a href="detailHistoryLaporan.php?p=<?php echo $data['id_pengaduan']; ?>" class="btn btn-sm btn-outline-dark">detail</a></td>
        </tr>
    <?php }
} else {
    echo "<tr><td colspan='8' class='text-center'>Tidak ada data ditemukan.</td></tr>";
}
?>
                </tbody>
            </table>
        </div>
    </div>


    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Function to filter table based on search
        function filterTable() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            
            if (searchTerm === '') {
                populateTable(reportData);
                return;
            }
            
            const filteredData = reportData.filter(report => {
                return (
                    report.nama.toLowerCase().includes(searchTerm) ||
                    report.nik.toLowerCase().includes(searchTerm) ||
                    report.kategori.toLowerCase().includes(searchTerm) ||
                    report.status.toLowerCase().includes(searchTerm)
                );
            });
            
            populateTable(filteredData);
        }

        // Add report button click handler
        document.getElementById('addReportBtn').addEventListener('click', function() {
            window.location.href = 'tulisLaporan.php';  
        });

        // Search input event listener
        document.getElementById('searchInput').addEventListener('input', filterTable);

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            displayUsername();
            populateTable(reportData);
        });
    </script>
</body>
</html>