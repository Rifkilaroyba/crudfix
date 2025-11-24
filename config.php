<?php
// Config untuk Azure MySQL
$host = "db-karyawan-fikri.mysql.database.azure.com"; 
$username = "admindb";
$password = "Fikri@2025!";
$database = "db_karyawan";

// SSL connection untuk Azure
$conn = mysqli_init();

if (!$conn) {
    die("mysqli_init failed");
}

mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL);

if (!mysqli_real_connect($conn, $host, $username, $password, $database, 3306, NULL, MYSQLI_CLIENT_SSL)) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");
?>
