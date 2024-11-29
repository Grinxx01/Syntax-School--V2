

<div class="container">
    <h1>Upload Materi</h1>
    <form action="process_upload_materi.php" method="POST" enctype="multipart/form-data" class="form">
        <label for="judul">Judul Materi:</label>
        <input type="text" id="judul" name="judul" required>

        <label for="deskripsi">Deskripsi:</label>
        <textarea id="deskripsi" name="deskripsi" required></textarea>

        <label for="tipe_input">Tipe Input:</label>
        <select id="tipe_input" name="tipe_input" onchange="handleInputChange()" required>
            <option value="text">Text</option>
            <option value="code">Code</option>
            <option value="file">File</option>
        </select>

        <div id="additional_input" style="margin-top: 20px;">
            <!-- Ipt tmbhan utk perkembangan selanjutnya -->
        </div>

        <button type="submit" class="btn">Upload</button>
    </form>
</div>

<script src="resources/js/script.js"></script>
