// assets/js/script.js
// Mengisi data secara instan ke Modal Edit saat tombol edit di-klik

document.addEventListener("DOMContentLoaded", () => {
    const editButtons = document.querySelectorAll(".btn-edit");
    
    editButtons.forEach(btn => {
        btn.addEventListener("click", () => {
            // Ambil data dari atribut tombol
            const id       = btn.getAttribute("data-id");
            const nama     = btn.getAttribute("data-nama");
            const kategori = btn.getAttribute("data-kategori");
            const harga    = btn.getAttribute("data-harga");
            const stok     = btn.getAttribute("data-stok");

            // Masukkan data ke dalam input field Modal Edit
            document.getElementById("edit_id").value          = id;
            document.getElementById("edit_nama_produk").value = nama;
            document.getElementById("edit_kategori").value    = kategori;
            document.getElementById("edit_harga").value       = harga;
            document.getElementById("edit_stok").value        = stok;
        });
    });
});