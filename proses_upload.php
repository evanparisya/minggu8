<?php
// Lokasi penyimpanan file yang diunggah (khusus gambar)
$targetDirectory = "images/";

// Periksa dan buat direktori jika belum ada
if (!file_exists($targetDirectory)) {
    mkdir($targetDirectory, 0755, true); // Perizinan yang lebih aman (0755)
}

// Jenis file gambar yang diizinkan
$allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['files']) && !empty($_FILES['files']['name'])) {
        $totalFiles = count($_FILES['files']['name']);

        for ($i = 0; $i < $totalFiles; $i++) {
            $fileName = basename($_FILES['files']['name'][$i]);
            $targetFilePath = $targetDirectory . $fileName;

            // Periksa ekstensi file
            $fileExtension = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
                echo "Hanya file gambar (jpg, jpeg, png, gif) yang diizinkan.<br>";
                continue;
            }

            // Periksa ukuran file (sesuaikan dengan kebutuhan Anda)
            $fileSize = $_FILES['files']['size'][$i];
            $maxFileSize = 1048576; // 1MB
            if ($fileSize > $maxFileSize) {
                echo "Ukuran file $fileName terlalu besar.<br>";
                continue;
            }

            // Pindahkan file
            if (move_uploaded_file($_FILES['files']['tmp_name'][$i], $targetFilePath)) {
                echo "File $fileName berhasil diunggah.<br>";
            } else {
                echo "Gagal mengunggah file $fileName.<br>";
            }
        }
    } else {
        echo "Tidak ada file yang diunggah.";
    }
}
?>