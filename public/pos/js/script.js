const hamburger = document.querySelector("#hamburger-menu");
const sidebar = document.querySelector("#sidebar");
const mainContent = document.querySelector("#main-content");
const overlay = document.querySelector("#overlay");

hamburger.addEventListener("click", function (e) {
    e.stopPropagation();
    sidebar.classList.toggle("active");
    mainContent.classList.toggle("dimmed");
    overlay.classList.toggle("active");
});

document.addEventListener("click", function (event) {
    const isClickInsideSidebar = sidebar.contains(event.target);
    const isClickOnHamburger = hamburger.contains(event.target);

    if (!isClickInsideSidebar && !isClickOnHamburger) {
        sidebar.classList.remove("active");
        mainContent.classList.remove("dimmed");
        overlay.classList.remove("active");
    }
});

// Event listener untuk menampilkan modal setelah pembayaran berhasil
window.addEventListener("paymentSuccessful", () => {
    $("#successModal").modal("show"); // Menampilkan modal
});

// Fungsi untuk print receipt
function printReceipt() {
    window.print();
}
