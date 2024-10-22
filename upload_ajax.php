<?php
if (isset($_FILES['files'])) {
    $errors = array();
    $allowed_types = array('jpg', 'jpeg', 'png', 'gif');

    // Loop melalui setiap file yang diungggah
    foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
        $file_name = $_FILES['files']['name'][$key];
        $file_size = $_FILES['files']['size'][$key];
        $file_tmp = $_FILES['files']['tmp_name'][$key];
        $file_type = $_FILES['files']['type'][$key];

        $file_ext = strtolower(end(explode('.', $file_name)));

        if (!in_array($file_ext, $allowed_types)) {
            $errors[] = "Ekstensi file yang diizinkan adalah JPG, JPEG, PNG, atau GIF.";
        }else if ($file_size > 2097152) {
            $errors[] = 'Ukuran file tidak boleh lebih dari 2 MB';
        }

        if (empty($errors) == true) {
            move_uploaded_file($file_tmp, "documents/" . $file_name);
            echo "File berhasil diunggah.";
        } else {
            echo implode(" ", $errors);
        }
    }
}
?>