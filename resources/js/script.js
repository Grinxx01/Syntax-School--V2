document.addEventListener("DOMContentLoaded", function () {
    const dropdownBtn = document.querySelector(".dropdown-btn");
    const profile = document.querySelector(".profile");

    if (dropdownBtn && profile) {
        dropdownBtn.addEventListener("click", function () {
            profile.classList.toggle("show"); // Toggle class 'show'
        });

        // Menutup dropdown jika klik di luar
        document.addEventListener("click", function (e) {
            if (!profile.contains(e.target)) {
                profile.classList.remove("show");
            }
        });
    }
});

function handleInputChange() {
    const type = document.getElementById('tipe_input').value;
    const container = document.getElementById('additional_input');
    container.innerHTML = '';

    if (type === 'code') {
        container.innerHTML = `
            <label for="contoh_code">Contoh Code:</label>
            <textarea id="contoh_code" name="contoh_code" placeholder="Tulis contoh code di sini"></textarea>
        `;
    } else if (type === 'file') {
        container.innerHTML = `
            <label for="file">Upload File:</label>
            <input type="file" id="file" name="file">
        `;
    }
}