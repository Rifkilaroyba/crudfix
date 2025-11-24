<?php
include 'config.php';

$query = "SELECT * FROM karyawan ORDER BY id ASC";
$result = mysqli_query($conn, $query);

$status = isset($_GET['status']) ? $_GET['status'] : '';
$action = isset($_GET['action']) ? $_GET['action'] : '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Data Karyawan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
    <div class="page-header">
        <h1>Manajemen Data Karyawan</h1>
        <div class="credit">
            <p class="credit-name">Mohamad Fikri Isfahani</p>
            <p class="credit-nim">(1204230031)</p>
        </div>
    </div>
        
        <?php if ($status == 'success' && $action == 'create'): ?>
            <div class="alert alert-success" id="alertBox">✅ Data karyawan berhasil ditambahkan!</div>
        <?php elseif ($status == 'success' && $action == 'update'): ?>
            <div class="alert alert-success" id="alertBox">✅ Data karyawan berhasil diupdate!</div>
        <?php elseif ($status == 'success' && $action == 'delete'): ?>
            <div class="alert alert-success" id="alertBox">✅ Data karyawan berhasil dihapus!</div>
        <?php elseif ($status == 'error'): ?>
            <div class="alert alert-error" id="alertBox">❌ Terjadi kesalahan! Silakan coba lagi.</div>
        <?php endif; ?>
        
        <div class="action-bar">
            <a href="create.php" class="btn btn-add">Tambah Karyawan</a>
        </div>

        <?php if (mysqli_num_rows($result) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Gaji</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                while($row = mysqli_fetch_assoc($result)): 
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($row['nama']); ?></td>
                    <td><?php echo htmlspecialchars($row['jabatan']); ?></td>
                    <td>Rp <?php echo number_format($row['gaji'], 0, ',', '.'); ?></td>
                    <td class="action-buttons">
                        <a href="update.php?id=<?php echo $row['id']; ?>" class="btn btn-edit">Edit</a>
                        <button onclick="showDeleteModal(<?php echo $row['id']; ?>, '<?php echo htmlspecialchars($row['nama']); ?>')" class="btn btn-delete">Hapus</button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p class="no-data">Belum ada data karyawan.</p>
        <?php endif; ?>
    </div>

    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-icon">⚠️</span>
                <h2>Konfirmasi Hapus Data</h2>
            </div>
            <div class="modal-body">
                <p>Yakin mau hapus data <strong id="employeeName"></strong>?</p>
                <p class="modal-warning">Data yang dihapus tidak bisa dikembalikan!</p>
            </div>
            <div class="modal-footer">
                <button onclick="closeModal()" class="btn btn-cancel">Batal</button>
                <a href="#" id="confirmDelete" class="btn btn-confirm-delete">Ya, Hapus wae</a>
            </div>
        </div>
    </div>

    <script>
        const alertBox = document.getElementById('alertBox');
        if (alertBox) {
            setTimeout(function() {
                alertBox.style.opacity = '0';
                alertBox.style.transform = 'translateY(-20px)';
                
                setTimeout(function() {
                    alertBox.remove();
                }, 300);
            }, 3000);
            
            if (window.history.replaceState) {
                window.history.replaceState({}, document.title, "index.php");
            }
        }

        function showDeleteModal(id, name) {
            const modal = document.getElementById('deleteModal');
            const employeeName = document.getElementById('employeeName');
            const confirmBtn = document.getElementById('confirmDelete');
            
            employeeName.textContent = name;
            confirmBtn.href = 'delete.php?id=' + id;
            modal.style.display = 'flex';
            
            setTimeout(() => {
                modal.classList.add('show');
            }, 10);
        }

        function closeModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.remove('show');
            
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        }

        window.onclick = function(event) {
            const modal = document.getElementById('deleteModal');
            if (event.target == modal) {
                closeModal();
            }
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });
    </script>
</body>
</html>
