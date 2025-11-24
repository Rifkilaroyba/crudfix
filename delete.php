<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $query = "DELETE FROM karyawan WHERE id = $id";
    
    if (mysqli_query($conn, $query)) {
        header("Location: index.php?status=success&action=delete");
        exit();
    } else {
        header("Location: index.php?status=error");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>
