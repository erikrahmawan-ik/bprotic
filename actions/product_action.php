<?php
// actions/product_action.php
// Pemroses logika bisnis & form handler (Controller Sederhana)

require_once '../config/database.php';
require_once '../models/product_model.php';

$action = $_REQUEST['action'] ?? '';

// --- AKSI 1: TAMBAH PRODUK (CREATE) ---
if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = trim($_POST['nama_produk'] ?? '');
    $kategori = trim($_POST['kategori'] ?? '');
    $harga    = (int)($_POST['harga'] ?? 0);
    $stok     = (int)($_POST['stok'] ?? 0);

    if (empty($nama) || empty($kategori) || $harga <= 0) {
        header("Location: ../index.php?status=error&msg=Data tidak boleh kosong!");
        exit;
    }

    if (createProduct($conn, $nama, $kategori, $harga, $stok)) {
        header("Location: ../index.php?status=success&msg=Produk berhasil ditambahkan!");
    } else {
        header("Location: ../index.php?status=error&msg=Gagal menyimpan produk.");
    }
    exit;
}

// --- AKSI 2: UBAH PRODUK (UPDATE) ---
elseif ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id       = (int)($_POST['id'] ?? 0);
    $nama     = trim($_POST['nama_produk'] ?? '');
    $kategori = trim($_POST['kategori'] ?? '');
    $harga    = (int)($_POST['harga'] ?? 0);
    $stok     = (int)($_POST['stok'] ?? 0);

    if ($id <= 0 || empty($nama) || empty($kategori)) {
        header("Location: ../index.php?status=error&msg=ID atau data tidak valid!");
        exit;
    }

    if (updateProduct($conn, $id, $nama, $kategori, $harga, $stok)) {
        header("Location: ../index.php?status=success&msg=Produk berhasil diperbarui!");
    } else {
        header("Location: ../index.php?status=error&msg=Gagal memperbarui produk.");
    }
    exit;
}

// --- AKSI 3: HAPUS PRODUK (DELETE) ---
elseif ($action === 'delete') {
    $id = (int)($_GET['id'] ?? 0);

    if ($id > 0 && deleteProduct($conn, $id)) {
        header("Location: ../index.php?status=success&msg=Produk berhasil dihapus!");
    } else {
        header("Location: ../index.php?status=error&msg=Gagal menghapus produk.");
    }
    exit;
}

// Jika request tidak valid
header("Location: ../index.php");
exit;
?>