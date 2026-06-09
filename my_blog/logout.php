<?php
session_start();

// Mengosongkan semua data session yang tersimpan
$_SESSION = [];

// Menghancurkan session secara total
session_unset();
session_destroy();

// Melempar kembali admin ke halaman utama blog publik
header("Location: index.php");
exit;
?>