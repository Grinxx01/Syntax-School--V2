<?php
include_once 'config/db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php?page=login");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    
    $tipe_inputs = $_POST['tipe_input'];
    $isi_materi = isset($_POST['isi_materi']) ? $_POST['isi_materi'] : [];
    $contoh_code = isset($_POST['contoh_code']) ? $_POST['contoh_code'] : [];
    $file_paths = [];

    foreach ($tipe_inputs as $index => $tipe_input) {
        $file_path = null;

        if ($tipe_input === 'file' && isset($_FILES['file_materi']['name'][$index])) {
            $target_dir = "uploads/";
            $file_name = time() . "_" . basename($_FILES["file_materi"]["name"][$index]);
            $target_file = $target_dir . $file_name;

            if (move_uploaded_file($_FILES["file_materi"]["tmp_name"][$index], $target_file)) {
                $file_path = $target_file;
                $file_paths[] = $file_path;
            } else {
                echo "File gagal diupload.";
                exit;
            }
        }

        $sql = "INSERT INTO upload_materi (judul, deskripsi, tipe_input, contoh_code, file_path, isi_materi) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        $judul_var = $judul;
        $deskripsi_var = $deskripsi;
        $tipe_input_var = $tipe_input;
        $contoh_code_var = null;
        $file_path_var = $file_path;
        $isi_materi_var = null;

        if ($tipe_input === 'text') {
            $isi_materi_var = $isi_materi[$index];
            $stmt->bind_param("sssss", $judul_var, $deskripsi_var, $tipe_input_var, $contoh_code_var, $isi_materi_var);
        } elseif ($tipe_input === 'code') {
            $contoh_code_var = $contoh_code[$index];
            $isi_materi_var = $isi_materi[$index];
            $stmt->bind_param("sssss", $judul_var, $deskripsi_var, $tipe_input_var, $contoh_code_var, $isi_materi_var);
        } elseif ($tipe_input === 'file') { 
            $stmt->bind_param("ssssss", $judul_var, $deskripsi_var, $tipe_input_var, $contoh_code_var, $file_path_var, $isi_materi_var);
        }

        if (!$stmt->execute()) {
            echo "Gagal menyimpan materi: " . $stmt->error;
        }
    }

    header("Location: index.php?page=admin/admin");
    exit;

    $stmt->close();
    $conn->close();
}
?>