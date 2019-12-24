<?php

require 'needs.php'; // Memuat skrip 'needs'

// Cek apakah parameter 'fl' ada dan valid
if(isset($_GET['fl']) && ($_GET['fl']!='') && ($_GET['fl']!=NULL) && (base64_encode(base64_decode($_GET['fl'], true)) === $_GET['fl']) && is_readable('images/'.base64_decode($_GET['fl']))):
    // Cari seluruh file zip di dalam folder 'images' lalu hapus file tersebut
    $indexzip = glob("images/*.zip");
    foreach($indexzip as $zip) unlink($zip);
    // Buat file zip berisi raw images lalu download
    $folder=base64_decode($_GET['fl']); // Variabel berisi isi parameter 'fl' yaitu nama folder yg akan di zipping
    $rootPath = realpath('images/'.$folder); // Mendapatkan path lengkap dari letak folder
    // Eksekusi pembuatan zip baru berdasarkan path yg diberikan
    $zip = new ZipArchive();
    $zip->open('images/'.$folder.'.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE); // Berikan nama file zip lalu buat file-nya
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($rootPath),RecursiveIteratorIterator::LEAVES_ONLY);
    // Pengulangan memasukkan isi folder 'rootPath' yg berisi file images kedalam zip
    foreach ($files as $name => $file):
        // Jika index bukan directory (file) maka masukkan file tersebut ke zip
        if (!$file->isDir()):
            $filePath = $file->getRealPath();
            $relativePath = substr($filePath, strlen($rootPath) + 1);
            $zip->addFile($filePath, $relativePath);
        endif;
    endforeach;
    $zip->close(); // Selesaikan eksekusi zip, file telah dibuat
    // Lakukan proses download file zip ke komputer lokal
    $file_url = 'images/'.$folder.'.zip'; // Variabel berisi letak file zip yg akan di download
    header('Content-Type: application/zip');
    header("Content-Transfer-Encoding: Binary"); 
    header("Content-disposition: attachment; filename=\"".$folder.".zip"."\"");
    readfile($file_url); // Trigger download file zip
    unlink($file_url); // Hapus file zip yang barusan dibuat
    exit; // Akhiri pemrosesan kode
// Jika parameter 'fl' tidak valid maka redirect ke halaman utama
else:
    header("Location: ".siteURL()); 
endif; 