<?php
// require ('config/session.php');
require ('../config/db.php');

if (isset($_GET['search']) && $_GET['search'] != '') {
    $filtervalues = $_GET['search'];
    $queryGetData = "SELECT * FROM pengaduan WHERE CONCAT(judul_laporan,tgl_pengaduan,nik,isi_laporan) LIKE '%$filtervalues%' ";
    $result = mysqli_query($conn, $queryGetData);
} else {
    // Tidak ada pencarian, ambil semua data
    $queryGetData = "SELECT * FROM pengaduan";
    $result = mysqli_query($conn, $queryGetData);
}
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
    <!-- sweetalert -->
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        
        .btn-generate {
            position: fixed;
            bottom: 5rem;
            right: 4rem;
            background-color: #3E6EA2;
            border-color: #3E6EA2;
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
         <form action="" method="GET" role="search">
        <div class="search-container">
            <div class="search-box">
                <i class="bi bi-search search-icon"></i>
                <input type="text" class="form-control d-inline" placeholder="Cari Laporan" id="searchInput" name="search">
                <button class="btn btn-outline-dark rounded-pill mt-2" type="submit">Search</button>
                <button class="btn btn-outline-danger rounded-pill mt-2">Reset</button>
            </div>
        </div>
        </form>
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
                <button class="btn btn-primary btn-generate" id="generatePdfBtn">
                <i class="bi bi-file-earmark-pdf"></i> Generate Laporan
            </button>
                <tbody>
                    <?php
if (mysqli_num_rows($result) > 0) {
    $no = 1;
    while ($data = mysqli_fetch_array($result)) { ?>
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


require '../vendor/autoload.php'; // pastikan path benar

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML('<h1>Hello World!</h1>');
$mpdf->Output();
?>
                </tbody>
            </table>
        </div>
    </div>


    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    
document.getElementById('generatePdfBtn').addEventListener('click', function() {
    Swal.fire({
        title: 'Generate PDF?',
        text: 'Yakin ingin meng-generate semua laporan menjadi PDF?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, generate!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // SweetAlert loading
            Swal.fire({
                title: 'Sedang diproses...',
                text: 'Mohon tunggu beberapa detik',
                didOpen: () => {
                    Swal.showLoading();
                },
                allowOutsideClick: false
            });

            fetch('generate_pdf.php')
            .then(response => response.blob())
            .then(blob => {
                Swal.close(); // Tutup loading

                // Buat link download
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'Laporan_Pengaduan.pdf';
                document.body.appendChild(a);
                a.click();
                a.remove();
                window.URL.revokeObjectURL(url);
            })
            .catch(error => {
                Swal.fire('Gagal!', 'Terjadi kesalahan saat generate PDF.', 'error');
            });
        }
    });
});
</script>
</body>
</html>