<?php
include 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);
    $gaji = mysqli_real_escape_string($conn, $_POST['gaji']);
    
    if (empty($nama) || empty($jabatan) || empty($gaji)) {
        $error = "Semua field harus diisi!";
    } else {
        $query = "INSERT INTO karyawan (nama, jabatan, gaji) VALUES ('$nama', '$jabatan', '$gaji')";
        
        if (mysqli_query($conn, $query)) {
            header("Location: index.php?status=success&action=create");
            exit();
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Karyawan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Tambah Karyawan Baru</h1>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>Nama Lengkap:</label>
                <input type="text" name="nama" required>
            </div>
            
            <div class="form-group">
                <label>Jabatan:</label>
                <input type="text" name="jabatan" required>
            </div>
            
            <div class="form-group">
                <label>Gaji (Rp):</label>
                <input type="number" name="gaji" required min="0">
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="index.php" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>
