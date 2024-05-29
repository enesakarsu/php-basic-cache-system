<?php
$cache_klasor = './cache/';

if(substr($_SERVER["REQUEST_URI"], -1) == "/"){
$dosya_isim = substr($_SERVER["REQUEST_URI"], 0, -1);
}else{
$dosya_isim= $_SERVER["REQUEST_URI"];
}

$dosya_yolu = $cache_klasor.$dosya_isim.'.html';
$cache_suresi = 3 * 60 * 60; // cache süresi 3 saat

if (file_exists($dosya_yolu)){ // cache dosyası var ise
	// filemtime() = dosyanın son düzenlenme zamanını bulur
	if(time() - $cache_suresi < filemtime($dosya_yolu)){ //cache dosyasının süresi bitmediyse
		include("".$dosya_yolu); //dosyayı oku


		exit; //aşağıdaki satırları okuma

	}else{ // cache süresi doldu ise
		unlink($dosya_yolu); //dosyayı, cache sil
	}
}

ob_start();
	?>



//Sayfanın Dahil Edildiği Kısım

<?php include("index.php"); ?>

//Sayfanın Dahil Edildiği Kısım



<?php
	$sayfa_verisi = ob_get_contents(); //sayfanın sonuç çıktısını al
ob_end_flush();

$dosya = fopen($dosya_yolu, 'w+'); //cache dosyasını aç
fwrite($dosya, $sayfa_verisi); //dosyaya yaz
fclose($dosya); //dosyayı kapat

?>


