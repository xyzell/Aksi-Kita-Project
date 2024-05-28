<?php
session_start();

session_start();

// Hapus semua variabel sesi
session_unset();

// Hancurkan sesi
session_destroy();

// Redirect ke halaman login
header('location: ../index.php');
exit;
?>