<?php
session_start();

// hapus semua data sesi
session_unset();
session_destroy();

// redirect ke halaman login setelah logout
header("Location: login.php");
exit();
