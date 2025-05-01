<?php
require ('../config/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pengaduan = $_POST['id_pengaduan'];
    $action = $_POST['action'];

    // Update status laporan sesuai dengan aksi approve/reject
    if ($action == 'approve') {
        $queryUpdate = "UPDATE pengaduan SET status = 'selesai' WHERE id_pengaduan = '$id_pengaduan'";
    } elseif ($action == 'reject') {
        $queryUpdate = "UPDATE pengaduan SET status = 'ditolak' WHERE id_pengaduan = '$id_pengaduan'";
    }

    if (isset($queryUpdate)) {
        $query = mysqli_query($conn, $queryUpdate);
        if ($query) {
            // Update juga tabel tanggapan jika perlu
            $queryInsertTanggapan = "INSERT INTO tanggapan (id_pengaduan, tanggapan, id_petugas) VALUES ('$id_pengaduan', 'Tanggapan: $action', '1')";
            mysqli_query($conn, $queryInsertTanggapan);

            // Redirect atau notifikasi berhasil
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                Swal.fire({
                    title: 'Sukses!',
                    text: 'Laporan berhasil di-$action.',
                    icon: 'success',
                    confirmButtonText: 'Ok'
                }).then(() => {
                    window.location.href = 'listLaporan.php';
                });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan saat memperbarui status laporan.',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
            </script>";
        }
    }
}
?>