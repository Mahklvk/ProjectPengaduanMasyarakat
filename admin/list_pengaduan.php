<?php
// require ('config/session.php');
require ('../config/db.php');

$queryGetData= mysqli_query($conn, "SELECT * FROM pengaduan")

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
        
        .content-container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .page-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        
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
            border-radius: 20px;
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
        
        /* .report-table {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        } */
        
        /* .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
        } */
        
        .badge-success {
            background-color: #28a745;
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
        }
        
        .badge-danger {
            background-color: #dc3545;
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
        }
        
        .btn-details {
            background-color: #f8f9fa;
            border-color: #dee2e6;
            color: #212529;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
<?php  include('config/navbar.php')?>
    <!-- Main Content -->
    <div class="content-container">
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
            <table class="table" id="reportTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>judul laporan</th>
                        <th>Tanggal laporan</th>
                        <th>Nik</th>
                        <th>Isi Laporan</th>
                        <th>Foto</th>
                        <th>Status</th>
                        <th>Action</th>
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
            <td><a href="detailLaporan.php?p=<?php echo $data['id_pengaduan']; ?>" class="btn btn-sm btn-outline-dark">Detail</a></td>
            <td><a href="tanggapan.php?p=<?php echo $data['id_pengaduan']; ?>" class="btn btn-sm btn-outline-dark">Tanggapan</a></td>
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