<?php
session_start();

if ($_SESSION['admin'] == false) {
     echo "<script>
       document.addEventListener('DOMContentLoaded', function() {
          Swal.fire({
             title: 'Gagal!',
             text: 'Fitur khusus admin, petugas tidak bisa menggunakannya',
             icon: 'error'
             });
            });
  </script>";
}
