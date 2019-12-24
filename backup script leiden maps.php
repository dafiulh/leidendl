<?php

/*** Menampilkan gambar dengan output 'img' tag ***/

$img = '03865'; // Nama gambar
$scl = '5'; // Skala resolusi
$maxcol = '14'; // Kolom maksimal
$maxrow = '20'; // Baris maksimal

for($y=0;$y<$maxrow;$y++):
for($x=0;$x<$maxcol;$x++):
$loop = ($maxcol*$y)+$x;
$url = 'http://maps.library.leiden.edu/fcgi-bin/iipsrv.fcgi?FIF=/home/maps/tif/'.$img.'.tif&jtl='.$scl.','.$loop;
?>
<a href="<?= $url ?>" download="<?= $img.'-'.($loop+1).'.jpg' ?>">
	<img src="<?= $url ?>">
</a>
<?php endfor; ?>
<br/>
<?php endfor; 

/*** Mengecek status koneksi ***/

$img = '03865'; // Nama gambar
$scl = '5'; // Skala resolusi
$amnt = '5'; // Jumlah gambar

$url=array();
for($i=0;$i<=($amnt-1);$i++) $url[$i]="http://maps.library.leiden.edu/fcgi-bin/iipsrv.fcgi?FIF=/home/maps/tif/".$img.".tif&jtl=".$scl.",".$i;
foreach($url as $theurl):
$headers=get_headers($theurl);
$jtl=explode('&',$theurl);
echo "<p>".$headers[0].' - '.substr($jtl[1],4)."</p>";
endforeach;