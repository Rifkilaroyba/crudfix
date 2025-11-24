<?php
include 'config.php';

$error = '';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

$query = "SELECT * FROM karyawan WHERE id = $id";
$result = mysqli_query($conn, $query);
$karyawan = mysqli_fetch_assoc($result);

if (!$karyawan) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);
    $gaji = mysqli_real_escape_string($conn, $_POST['gaji']);
    
    if (empty($nama) || empty($jabatan) || empty($gaji)) {
        $error = "Semua field harus diisi!";
    } else {
        $query = "UPDATE karyawan SET nama='$nama', jabatan='$jabatan', gaji='$gaji' WHERE id=$id";
        
        if (mysqli_query($conn, $query)) {
            header("Location: index.php?status=success&action=update");
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
    <title>Edit Karyawan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Edit Data Karyawan</h1>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>Nama Lengkap:</label>
                <input type="text" name="nama" value="<?php echo htmlspecialchars($karyawan['nama']); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Jabatan:</label>
                <input type="text" name="jabatan" value="<?php echo htmlspecialchars($karyawan['jabatan']); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Gaji (Rp):</label>
                <input type="number" name="gaji" value="<?php echo $karyawan['gaji']; ?>" required min="0">
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="index.php" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>
