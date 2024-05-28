document.addEventListener("DOMContentLoaded", function() {
    // Mendapatkan elemen modal
    var modal = document.getElementById("modalForm");

    // Mendapatkan tombol yang membuka modal
    var btn = document.getElementById("openModalBtn");

    // Mendapatkan elemen <span> yang menutup modal
    var span = document.getElementsByClassName("custom-close")[0];

    // Ketika tombol diklik, buka modal
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // Ketika <span> diklik, tutup modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // Ketika pengguna mengklik di luar modal, tutup modal
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
});