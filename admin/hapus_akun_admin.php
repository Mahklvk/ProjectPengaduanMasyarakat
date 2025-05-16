<?php
require "config/sessionLogin.php";
require('../config/db.php');

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['id_petugas'])) {
    echo json_encode(['success' => false, 'message' => 'ID tidak ditemukan.']);
    exit;
}

$id = $data['id_petugas'];

$query = "DELETE FROM petugas WHERE id_petugas = '$id'";

if (mysqli_query($conn, $query)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal menghapus akun.']);
}
?>
