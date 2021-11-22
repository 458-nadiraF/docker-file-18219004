<!-- file : config.php
Nama : Nadira Fawziyya Masnur
NIM  : 18219004 -->


<?php
// deklarasi variabel
$host = 'db';
$user = 'MYSQL_USER';
$pass = 'MYSQL_PASSWORD';
$mydatabase = 'MYSQL_DATABASE';

$link = new mysqli($host, $user, $pass, $mydatabase);
 
// Cek koneksi
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>