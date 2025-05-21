<?php
require "config/sessionLogin.php";
// require ('config/session.php');  // Baris ini di-comment, mungkin untuk session handling nanti
require ('../config/db.php');     // Koneksi ke database

// Cek apakah ada parameter 'search' di URL dan tidak kosong
if (isset($_GET['search']) && $_GET['search'] != '') {
    $filtervalues = $_GET['search'];
    // Query untuk mencari data berdasarkan kolom judul_laporan, tgl_pengaduan, nik, dan isi_laporan
    $queryGetData = "SELECT * FROM pengaduan WHERE CONCAT(judul_laporan,tgl_pengaduan,nik,isi_laporan) LIKE '%$filtervalues%' ";
    $result = mysqli_query($conn, $queryGetData);
} else {
    // Jika tidak ada pencarian, ambil semua data dari tabel pengaduan
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
    <!-- Bootstrap CSS dari CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons dari CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <!-- SweetAlert untuk alert interaktif -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- fontawesome -->
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        /* Styling container utama halaman */
        .content-container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        /* Styling judul halaman */
        .page-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        
        /* Styling area search */
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
            padding-left: 40px; /* Memberi ruang untuk icon search di kiri */
            border-radius: 20px; /* Membuat input search membulat */
        }
        
        /* Posisi dan warna icon search */
        .search-icon {
            position: absolute;
            left: 15px;
            top: 10px;
            color: #6c757d;
        }
        
        /* Tombol generate PDF yang fixed di kanan bawah */
        .btn-generate {
            position: fixed;
            bottom: 5rem;
            right: 4rem;
            background-color: #3E6EA2;
            border-color: #3E6EA2;
        }
        
        /* Styling tombol detail */
        .btn-details {
            background-color: #f8f9fa;
            border-color: #dee2e6;
            color: #212529;
        }
    </style>
</head>
<body>
    <!-- Navbar disisipkan dari file config/navbar.php -->
<?php  include('config/navbar.php')?>
    <!-- Main Content -->
    <div class="content-container">
        <h1 class="page-title">Daftar Laporan</h1>
        
        <!-- Form pencarian dengan metode GET -->
         <form action="" method="GET" role="search">
        <div class="search-container">
            <div class="search-box">
                <i class="fa fa-search search-icon"></i> <!-- Icon search -->
                <input type="text" class="form-control d-inline" placeholder="Cari Laporan" id="searchInput" name="search">
                <button class="btn btn-outline-dark rounded-pill mt-2" type="submit">Search</button> <!-- Tombol submit pencarian -->
                <a href="?" class="btn btn-outline-danger rounded-pill mt-2">Reset</a> <!-- Tombol reset (perlu diperbaiki agar benar-benar reset) -->
            </div>
        </div>
        </form>
        <!-- Table laporan -->
        <div class="report-table table-responsive">
            <table class="table" id="reportTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>judul laporan</th>
                        <th>Kategori</th>
                        <th>Tanggal laporan</th>
                        <th>Nik</th>
                        <th>Isi Laporan</th>
                        <th>Foto</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <?php
                if($_SESSION['level']  ==  'petugas'){
                    ?>
             <button class="btn btn-primary btn-generate d-none" id="generatePdfBtn">
                <i class="bi bi-file-earmark-pdf"></i> Generate Laporan
            </button>
                    <?php
                }else{
                    ?>
             <button class="btn btn-primary btn-generate" id="generatePdfBtn">
                <i class="bi bi-file-earmark-pdf"></i> Generate Laporan
            </button>
                    <?php
                }
                ?>
                <tbody>
                    <?php
// Cek apakah ada data hasil query
if (mysqli_num_rows($result) > 0) {
    $no = 1; // Nomor urut tabel
    while ($data = mysqli_fetch_array($result)) { ?>
        <tr>
            <td><?php echo $no++; ?></td> <!-- Nomor urut -->
            <td><?php echo $data['judul_laporan']; ?></td>
            <td><?php echo $data['kategori'];?></td>
            <td><?php echo $data['tgl_pengaduan']; ?></td>
            <td><?php echo $data['nik']; ?></td>
            <td><?php echo $data['isi_laporan']; ?></td>
            <td><?php echo $data['foto']; ?></td>
            <?php
            // Menentukan kelas tombol berdasarkan status laporan
            $status = trim($data['status']);
            switch ($status) {
                case 'diproses':
                    $class = 'badge rounded-pill text-bg-secondary';
                    break;
                case 'ditolak':
                    $class = 'badge rounded-pill text-bg-danger';
                    break;
                case 'selesai':
                    $class = 'badge rounded-pill text-bg-success';
                    break;
                default:
                    $class = 'btn btn-outline-secondary rounded-pill btn-sm';
                    break;
            }
            // Menampilkan status dengan style tombol
            echo '<td><span class="' . $class . '">' . htmlspecialchars($status) . '</span></td>';
            ?>
            <!-- Tombol aksi detail dan tanggapan -->
            <td><a href="detailLaporan.php?p=<?php echo $data['id_pengaduan']; ?>" class="btn btn-sm btn-outline-dark">Detail</a></td>
            <td><a href="tanggapan.php?p=<?php echo $data['id_pengaduan']; ?>" class="btn btn-sm btn-outline-dark">Tanggapan</a></td>
        </tr>
    <?php }
} else {
    // Jika tidak ada data yang ditemukan
    echo "<tr><td colspan='8' class='text-center'>Tidak ada data ditemukan.</td></tr>";
}
?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap Bundle dengan Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    // Event listener untuk tombol Generate PDF
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
            // Tampilkan loading sebentar sebelum redirect
            Swal.fire({
                title: 'Sedang diproses...',
                text: 'File akan diunduh otomatis',
                timer: 2000,
                didOpen: () => {
                    Swal.showLoading();
                },
                willClose: () => {
                    // Redirect ke file PHP yang langsung kirim PDF
                    window.location.href = 'generate_pdf.php';
                },
                allowOutsideClick: false
            });
        }
    });
});
</script>
</body>
</html>
