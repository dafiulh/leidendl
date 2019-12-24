<?php

require 'needs.php'; // Memuat skrip 'needs'

$quality=$_POST['quality']; // Ambil data parameter 'quality'
// Ambil data parameter 'mapsurl' lalu ubah definisikan nama maps
$parts = parse_url($_POST['mapsurl']);
parse_str($parts['query'], $query);
$nameraw=$query['name']; // Variabel berisi content parameter 'name' yang isinya nama maps
// Pendefinisian variabel nama maps tanpa extension
$name = explode('.', $nameraw);
array_pop($name);
$name = implode('.', $name); // Variabel berisi nama maps tanpa ekstension

// Bersih-bersih file gambar 'jpeg' dan hapus folder kosong
$indexjpeg = glob("images/*/*.jpeg"); // Cari file jpeg yg berada di subfolder 'images'
$indexdir = glob("images/*"); // Cari directory yg berada di folder 'images'
foreach($indexjpeg as $jpeg): if((time() - filemtime($jpeg)) > 600){
    if(strpos($jpeg,$name) == false) unlink($jpeg);
}
endforeach; // Hapus file jpeg yg ter-index variabel 'indexjpeg' yg dibuat lebih dari 10 menit yg lalu
foreach($indexdir as $folder): if(is_dir($folder) && (count(scandir($folder)) == 2)){rmdir($folder);} endforeach; // Hapus directory kosong yang ter-index variabel 'indexdir'

if(!isset($_POST['quality']) && !isset($_POST['mapsurl'])): // Jika parameter POST 'quality' dan 'mapsurl' tidak ada
    header("Location: ".siteURL()); // Redirect ke homepage
else:

$flformat='images/'.$nameraw.' - '.$res[$quality].' quality'; // Variabel berisi format nama folder
if (!file_exists('images')) mkdir('images', 0777, true); // Buat folder 'images' jika belum ada
if (!file_exists($flformat)): // Jika folder sudah ada jangan jalankan script
mkdir($flformat, 0777, true); // Buat folder berdasarkan format variabel 'flformat' didalam folder images
// Pengulangan men-download images ke server (copy) dari gambar pertama hingga terakhir
for($i=0;$i>=0;$i++): // Infinity loop
    $finalurl='http://maps.library.leiden.edu/fcgi-bin/iipsrv.fcgi?FIF=/home/maps/tif/'.$name.'.tif&jtl='.$quality.','.$i; // Variabel berisi url yang akan di download
    $headers=get_headers($finalurl); // Ambil headers dari url
    if($headers[0]=='HTTP/1.1 404 Not Found') break; // Jika headers berisi '404 Not Found' maka hentikan infinity loop
    copy($finalurl, $flformat.'/'.$name.' #'.($i+1).'.jpeg'); // Download image ke server
endfor;
endif;
$flurl=str_replace('images/','',$flformat); // Definisikan variabel baru berisi nama folder murni tanpa lokasi
$flurl_parts = explode(" ",$flurl); // Pisah string 'flurl' berdasarkan ' ' (spasi)

?>

<html>
<body>

<h1>Leiden Maps Download Tool - <a href="<?= siteURL(); ?>">Home</a></h1>

<p>You will download <?= (count(scandir('images/'.$flurl))-2); // Hitung jumlah file images jpeg pada folder ?> 
images from <?= $flurl_parts[0]; // Ambil nama image ?> with <?= $flurl_parts[2]; // Ambil ukuran kualitas gambar ?> quality</p>
<p><a href='merge.ph?fl=<?= openssl_encrypt($flurl,'aes128',$aes128_pw); // Encrypt nama url ?>p'>Download Now</a></p>
<p><small><a href='compress.php?fl=<?= openssl_encrypt($flurl,'aes128',$aes128_pw); ?>'>Download Raw Images</a></small></p>
<p>This website is not file storage, the image will be deleted automatically 10 minutes after it was created.</p>

</body>
</html>

<?php endif; ?>