<?php
// index.php - View Utama

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/product_model.php';

// Ambil data produk melalui model
$products = getAllProducts($conn);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Buku BPROTIC</title>
    <!-- Bootstrap 5 & Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Custom Style -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="py-5">

    <div class="container">
        <!-- Header & Tombol Tambah -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <div>
                <span class="badge bg-primary px-3 py-1 rounded-pill mb-2">BPROTIC WEB COURSE</span>
                <h2 class="fw-bold text-white mb-1">📦 Manajemen Data Produk</h2>
                <p class="text-secondary mb-0">Sistem CRUD Single Page dengan Modal Bootstrap & Arsitektur MVC</p>
            </div>
            <button type="button" class="btn btn-primary btn-lg rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="bi bi-plus-circle-fill me-2"></i>Tambah Produk
            </button>
        </div>

        <!-- Notifikasi Feedback (Alert) -->
        <?php if (isset($_GET['status'])): ?>
            <?php if ($_GET['status'] === 'success'): ?>
                <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i><?= htmlspecialchars($_GET['msg'] ?? 'Operasi berhasil!'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php elseif ($_GET['status'] === 'error'): ?>
                <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i><?= htmlspecialchars($_GET['msg'] ?? 'Terjadi kesalahan!'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Tabel Produk -->
        <div class="card card-main overflow-hidden">
            <div class="table-responsive">
                <table class="table table-custom table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4" style="width: 5%;">No</th>
                            <th style="width: 35%;">Nama Produk</th>
                            <th style="width: 20%;">Kategori</th>
                            <th style="width: 15%;">Harga</th>
                            <th style="width: 10%;">Stok</th>
                            <th class="text-center" style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($products)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-secondary">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>Belum ada data produk.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1; foreach ($products as $row): ?>
                                <tr>
                                    <td class="ps-4 text-secondary"><?= $no++; ?></td>
                                    <td><strong class="text-black"><?= htmlspecialchars($row['nama_produk']); ?></strong></td>
                                    <td><span class="badge-kategori"><?= htmlspecialchars($row['kategori']); ?></span></td>
                                    <td class="text-info fw-bold">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                                    <td><span class="badge bg-dark border border-secondary"><?= $row['stok']; ?> unit</span></td>
                                    <td class="text-center">
                                        <!-- Tombol Edit (Memicu Modal Edit Tanpa Pindah Halaman) -->
                                        <button type="button" 
                                            class="btn btn-warning btn-sm me-1 btn-edit"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalEdit"
                                            data-id="<?= $row['id']; ?>"
                                            data-nama="<?= htmlspecialchars($row['nama_produk']); ?>"
                                            data-kategori="<?= htmlspecialchars($row['kategori']); ?>"
                                            data-harga="<?= $row['harga']; ?>"
                                            data-stok="<?= $row['stok']; ?>">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        
                                        <!-- Tombol Hapus -->
                                        <a href="actions/product_action.php?action=delete&id=<?= $row['id']; ?>" 
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ================= MODAL TAMBAH PRODUK ================= -->
    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title text-primary fw-bold"><i class="bi bi-plus-circle me-2"></i>Tambah Produk Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="actions/product_action.php" method="POST">
                    <input type="hidden" name="action" value="create">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label text-light">Nama Produk</label>
                            <input type="text" name="nama_produk" class="form-control" placeholder="Contoh: Headset Gaming" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-light">Kategori</label>
                            <select name="kategori" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="Elektronik">Elektronik</option>
                                <option value="Aksesoris">Aksesoris</option>
                                <option value="Komputer">Komputer</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-light">Harga (Rp)</label>
                                <input type="number" name="harga" class="form-control" placeholder="Contoh: 350000" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-light">Stok Unit</label>
                                <input type="number" name="stok" class="form-control" placeholder="Contoh: 15" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4 fw-bold">Simpan Produk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ================= MODAL EDIT PRODUK ================= -->
    <div class="modal fade" id="modalEdit" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title text-warning fw-bold"><i class="bi bi-pencil-square me-2"></i>Edit Data Produk</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="actions/product_action.php" method="POST">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label text-light">Nama Produk</label>
                            <input type="text" name="nama_produk" id="edit_nama_produk" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-light">Kategori</label>
                            <select name="kategori" id="edit_kategori" class="form-select" required>
                                <option value="Elektronik">Elektronik</option>
                                <option value="Aksesoris">Aksesoris</option>
                                <option value="Komputer">Komputer</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-light">Harga (Rp)</label>
                                <input type="number" name="harga" id="edit_harga" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-light">Stok Unit</label>
                                <input type="number" name="stok" id="edit_stok" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning px-4 fw-bold text-dark">Perbarui Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>