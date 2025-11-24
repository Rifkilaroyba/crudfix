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

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f2f5f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 950px;
            margin: 35px auto;
            background: white;
            padding: 30px 40px;
            border-radius: 20px;
            box-shadow: 0 6px 25px rgba(0,0,0,0.08);
        }

        /* HEADER */
        .page-header {
            display: flex;
            justify-content: space-between;
            padding-bottom: 15px;
        }

        .page-header h1 {
            margin: 0;
            font-size: 26px;
            font-weight: 600;
            color: #333;
        }

        .credit-name {
            font-size: 17px;
            font-weight: 600;
            color: #444;
            text-align: right;
        }
        .credit-nim {
            margin-top: -5px;
            font-size: 14px;
            color: #d9534f;
            text-align: right;
        }

        /* ALERT */
        .alert {
            padding: 12px 15px;
            border-radius: 12px;
            margin-top: 15px;
            font-weight: 500;
            animation: fadeIn .3s ease-in-out;
        }
        .alert-success {
            background: #e5f7e5;
            border-left: 6px solid #28a745;
            color: #125d28;
        }
        .alert-error {
            background: #ffecec;
            border-left: 6px solid #d93025;
            color: #8a1c12;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* BUTTON */
        .btn {
            padding: 9px 15px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 500;
            cursor: pointer;
            border: none;
            transition: .2s;
        }

        .btn-add {
            background: #3b82f6;
            color: white;
        }
        .btn-add:hover {
            background: #2165d6;
        }

        .btn-edit {
            background: #22c55e;
            color: white;
        }
        .btn-edit:hover {
            background: #16a34a;
        }

        .btn-delete {
            background: #ef4444;
            color: white;
        }
        .btn-delete:hover {
            background: #dc2626;
        }

        .btn-cancel {
            background: #9ca3af;
            color: white;
        }
        .btn-confirm-delete {
            background: #b91c1c;
            color: white;
        }

        /* TABLE */
        table {
            width: 100%;
            margin-top: 25px;
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        th {
            background: #4b5563;
            color: white;
            padding: 14px;
            border-radius: 10px 10px 0 0;
        }

        tr {
            background: #f9fafb;
            transition: .2s;
        }

        tr:hover {
            background: #f1f5f9;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
        }

        .action-buttons a, 
        .action-buttons button {
            margin-right: 8px;
        }

        .no-data {
            text-align: center;
            color: #666;
            padding: 25px;
        }

        /* MODAL */
        .modal {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.35);
            display: none;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            width: 330px;
            padding: 25px;
            border-radius: 18px;
            text-align: center;
            box-shadow: 0 7px 20px rgba(0,0,0,0.2);
        }

        .modal-icon { font-size: 45px; }
        .modal-warning { color: #b91c1c; font-size: 14px; margin-top: 6px; }

        .modal-footer {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }
    </style>

</head>
<body>

    <div class="container">
        <div class="page-header">
            <h1>Manajemen Data Karyawan</h1>

            <div class="credit">
                <p class="credit-name">Rifki Laroyba Ganteng</p>
                <p class="credit-nim">(1204230026)</p>
            </div>
        </div>

        <!-- Alert -->
        <?php if ($status == 'success' && $action == 'create'): ?>
            <div class="alert alert-success" id="alertBox">✔ Data karyawan berhasil ditambahkan!</div>
        <?php elseif ($status == 'success' && $action == 'update'): ?>
            <div class="alert alert-success" id="alertBox">✔ Data berhasil diperbarui!</div>
        <?php elseif ($status == 'success' && $action == 'delete'): ?>
            <div class="alert alert-success" id="alertBox">✔ Data berhasil dihapus!</div>
        <?php elseif ($status == 'error'): ?>
            <div class="alert alert-error" id="alertBox">✘ Terjadi kesalahan!</div>
        <?php endif; ?>

        <div class="action-bar">
            <a href="create.php" class="btn btn-add">+ Tambah Karyawan</a>
        </div>

        <?php if (mysqli_num_rows($result) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Gaji</th>
                    <th style="width: 160px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)): 
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row['nama']); ?></td>
                    <td><?= htmlspecialchars($row['jabatan']); ?></td>
                    <td>Rp <?= number_format($row['gaji'], 0, ',', '.'); ?></td>
                    <td class="action-buttons">
                        <a href="update.php?id=<?= $row['id']; ?>" class="btn btn-edit">Edit</a>
                        <button onclick="showDeleteModal(<?= $row['id']; ?>, '<?= htmlspecialchars($row['nama']); ?>')" class="btn btn-delete">Hapus</button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <?php else: ?>
            <p class="no-data">Belum ada data karyawan.</p>
        <?php endif; ?>
    </div>

    <!-- Modal Hapus -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="modal-icon">⚠️</span>
            <h2>Konfirmasi Hapus</h2>
            <p>Yakin mau hapus <strong id="employeeName"></strong>?</p>
            <p class="modal-warning">Data yang dihapus tidak bisa dikembalikan!</p>

            <div class="modal-footer">
                <button onclick="closeModal()" class="btn btn-cancel">Batal</button>
                <a href="#" id="confirmDelete" class="btn btn-confirm-delete">Hapus</a>
            </div>
        </div>
    </div>

    <script>
        function showDeleteModal(id, name) {
            document.getElementById('employeeName').textContent = name;
            document.getElementById('confirmDelete').href = 'delete.php?id=' + id;
            document.getElementById('deleteModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }

        const alertBox = document.getElementById('alertBox');
        if (alertBox) {
            setTimeout(() => {
                alertBox.style.opacity = '0';
                alertBox.style.transform = 'translateY(-20px)';
                setTimeout(() => alertBox.remove(), 300);
            }, 3000);
        }
    </script>

</body>
</html>
