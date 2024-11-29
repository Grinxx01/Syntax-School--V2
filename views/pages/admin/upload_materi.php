<div class="container">
    <h1>Upload Materi</h1>
    <form action="process_upload_materi.php" method="POST" enctype="multipart/form-data" class="form">
        <label for="judul">Judul Materi:</label>
        <input type="text" id="judul" name="judul" required>

        <label for="deskripsi">Deskripsi:</label>
        <textarea id="deskripsi" name="deskripsi" required></textarea>

        <div id="input_sections">
            <h3>Input Materi</h3>
            <div class="input_section">
                <label for="tipe_input">Tipe Input:</label>
                <select name="tipe_input[]" onchange="handleInputChange(this)" required>
                    <option value="">Pilih Tipe Input</option>
                    <option value="text">Text</option>
                    <option value="code">Code</option>
                    <option value="file">File</option>
                </select>

                <div class="additional_input"></div>
                <button type="button" onclick="removeInput(this)">Hapus</button>
            </div>
        </div>

        <button type="button" onclick="addInput()">Tambah Input</button>
        <button type="submit" class="btn">Upload</button>
    </form>
</div>

<script src="resources/js/script.js"></script>