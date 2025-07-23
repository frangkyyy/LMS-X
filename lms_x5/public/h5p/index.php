<?php
// Menggunakan autoloader Composer
require_once 'vendor/autoload.php';

// Tentukan konfigurasi untuk H5P
use H5P\H5PCore;
use H5P\H5PStorage;
use H5P\H5PEventDispatcher;
use H5P\H5PValidator;
use H5P\H5PUtil;

// Inisialisasi core H5P
$h5p = new H5PCore();
$h5pStorage = new H5PStorage();
$h5pValidator = new H5PValidator();
$h5pEventDispatcher = new H5PEventDispatcher();
$h5pUtil = new H5PUtil();

// Lokasi file H5P yang akan digunakan (file .h5p)
$filePath = 'path/to/your/h5p/file.h5p'; // Ganti dengan path file H5P kamu

// Panggil H5P untuk memuat konten
$h5p->setContent($filePath);
$content = $h5p->getContent();

// Tampilkan H5P
echo $content;
?>

