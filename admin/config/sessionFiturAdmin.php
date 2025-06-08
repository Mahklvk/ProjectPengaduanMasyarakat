<?php
if ($_SESSION['level'] == 'petugas') {
     echo "<script>
       document.addEventListener('DOMContentLoaded', function() {
          Swal.fire({
             title: 'Gagal!',
             text: 'Fitur khusus admin, petugas tidak bisa menggunakannya',
             icon: 'error'
             }).then(() => window.location.href = 'index.php');
            });
  </script>";
}
