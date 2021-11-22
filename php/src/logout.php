<!-- file : logout.php
Nama : Nadira Fawziyya Masnur
NIM  : 18219004 -->

<?php
// Inisialisasi sesi
session_start();

$_SESSION = array();
 
// Destroy the session.
session_destroy();
 
// Redirect ke login page atau index.php
header("location: index.php");
exit;
?>