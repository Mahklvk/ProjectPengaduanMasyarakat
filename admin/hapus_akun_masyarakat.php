<?php
require "config/sessionLogin.php";
require('../config/db.php');

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['id_masyarakat'])) {
    echo json_encode(['success' => false, 'message' => 'ID tidak ditemukan.']);
    exit;
}

$id = $data['id_masyarakat'];

$query = "DELETE FROM masyarakat WHERE id_masyarakat = '$id'";

if (mysqli_query($conn, $query)) {
    echo json_encode(['success' => true]);
    session_destroy();
    exit;
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal menghapus akun: ' . mysqli_error($conn)]);
}
?>
