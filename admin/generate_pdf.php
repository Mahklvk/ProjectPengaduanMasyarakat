<?php
require "config/sessionLogin.php";
require('../config/db.php');
require_once __DIR__ . '/../vendor/autoload.php';

use TCPDF;

// Buffer output untuk hindari corrupt PDF
ob_clean();
ob_start();

// Query data
$query = mysqli_query($conn, "SELECT * FROM pengaduan");

// Buat PDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Laporan Pengaduan');
$pdf->SetMargins(10, 10, 10);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->AddPage();

// HTML ke PDF
$html = '<h2 style="text-align:center;">Daftar Laporan Pengaduan</h2>';
$html .= '<table border="1" cellpadding="4">
<tr style="background-color:#f2f2f2;">
    <th width="5%">No</th>
    <th width="20%">Judul</th>
    <th width="15%">Tanggal</th>
    <th width="15%">NIK</th>
    <th width="30%">Isi</th>
    <th width="15%">Status</th>
</tr>';

$no = 1;
while ($data = mysqli_fetch_assoc($query)) {
    $html .= '<tr>
        <td>' . $no++ . '</td>
        <td>' . htmlspecialchars($data['judul_laporan']) . '</td>
        <td>' . $data['tgl_pengaduan'] . '</td>
        <td>' . $data['nik'] . '</td>
        <td>' . htmlspecialchars($data['isi_laporan']) . '</td>
        <td>' . $data['status'] . '</td>
    </tr>';
}

$html .= '</table>';

$pdf->writeHTML($html, true, false, true, false, '');

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="Laporan_Pengaduan.pdf"');
$pdf->Output('Laporan_Pengaduan.pdf', 'D'); // D = Download

exit;