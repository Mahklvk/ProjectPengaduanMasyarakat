<?php
session_start();
session_destroy();
header("location: ../loginAdmin.php");
exit;
?>