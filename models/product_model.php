<?php
// models/product_model.php
// Kumpulan fungsi pengolahan data query produk

// 1. READ: Ambil seluruh data produk
function getAllProducts($conn) {
    $sql = "SELECT * FROM products ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

// 2. READ: Ambil 1 produk berdasarkan ID
function getProductById($conn, $id) {
    $id = (int)$id;
    $sql = "SELECT * FROM products WHERE id = $id LIMIT 1";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

// 3. CREATE: Tambah produk baru
function createProduct($conn, $nama, $kategori, $harga, $stok) {
    $nama     = mysqli_real_escape_string($conn, $nama);
    $kategori = mysqli_real_escape_string($conn, $kategori);
    $harga    = (int)$harga;
    $stok     = (int)$stok;

    $sql = "INSERT INTO products (nama_produk, kategori, harga, stok) 
            VALUES ('$nama', '$kategori', $harga, $stok)";
    return mysqli_query($conn, $sql);
}

// 4. UPDATE: Ubah data produk
function updateProduct($conn, $id, $nama, $kategori, $harga, $stok) {
    $id       = (int)$id;
    $nama     = mysqli_real_escape_string($conn, $nama);
    $kategori = mysqli_real_escape_string($conn, $kategori);
    $harga    = (int)$harga;
    $stok     = (int)$stok;

    $sql = "UPDATE products SET 
            nama_produk = '$nama', 
            kategori = '$kategori', 
            harga = $harga, 
            stok = $stok 
            WHERE id = $id";
    return mysqli_query($conn, $sql);
}

// 5. DELETE: Hapus produk
function deleteProduct($conn, $id) {
    $id = (int)$id;
    $sql = "DELETE FROM products WHERE id = $id";
    return mysqli_query($conn, $sql);
}
?>