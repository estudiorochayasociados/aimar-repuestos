<?php
include("admin/dal/cnx.php");

$xml = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">    ';

$xml .= '<url>
<loc>'.BASE_URL.'</loc>
<lastmod>'.date("Y-m-d").'</lastmod>
<changefreq>weekly</changefreq>
<priority>1</priority>
</url>
<url>
<loc>'.BASE_URL.'/index</loc>
<lastmod>'.date("Y-m-d").'</lastmod>
<changefreq>weekly</changefreq>
<priority>1</priority>
</url>
<url>
<loc>'.BASE_URL.'/c/empresa</loc>
<lastmod>'.date("Y-m-d").'</lastmod>
<changefreq>weekly</changefreq>
<priority>1</priority>
</url>
<url>
<loc>'.BASE_URL.'/productos</loc>
<lastmod>'.date("Y-m-d").'</lastmod>
<changefreq>weekly</changefreq>
<priority>1</priority>
</url>
<url>
<loc>'.BASE_URL.'/redes</loc>
<lastmod>'.date("Y-m-d").'</lastmod>
<changefreq>weekly</changefreq>
<priority>1</priority>
</url>
<url>
<loc>'.BASE_URL.'/contacto</loc>
<lastmod>'.date("Y-m-d").'</lastmod>
<changefreq>weekly</changefreq>
<priority>1</priority>
</url> 
<url>
<loc>'.BASE_URL.'/usuarios</loc>
<lastmod>'.date("Y-m-d").'</lastmod>
<changefreq>weekly</changefreq>
<priority>1</priority>
</url> 
';

$sql = "SELECT * FROM `productos`";     
$link = Conectarse();
$result = mysqli_query($link, $sql);
$contar = mysqli_num_rows($result);
if ($contar != 0) { 
	while ($data = mysqli_fetch_array($result)) {
 		$cod = $data["id"];
 		$titulo = normaliza_acentos($data["descripcion"]);
		$xml .= '<url>
		<loc>'.BASE_URL.'/producto/'.$titulo.'/'.$cod.'</loc>
		<lastmod>'.date("Y-m-d").'</lastmod>
		<changefreq>weekly</changefreq>
		<priority>0.8</priority></url>';
	}
} 
$sql = "SELECT * FROM `notabase`";     
$link = Conectarse();
$result = mysqli_query($link, $sql);
$contar = mysqli_num_rows($result);
if ($contar != 0) { 
	while ($data = mysqli_fetch_array($result)) {
 		$cod = $data["IdNotas"];
 		//$titulo = normaliza_acentos($data["TituloNotas"]);
    $titulo = '';
		$xml .= '<url>
		<loc>'.BASE_URL.'/notas/'.$titulo.'/'.$cod.'</loc>
		<lastmod>'.date("Y-m-d").'</lastmod>
		<changefreq>weekly</changefreq>
		<priority>0.8</priority></url>';
	}
}

$xml .='</urlset>';

// Opcion 2
header('Content-type:text/xml;charset:utf8');
echo $xml; 

/*$arxivo = fopen(BASE_URL."/sitemap.xml", "w");
fwrite($arxivo, $this->xml);
fclose($archivo);*/


function normaliza_acentos($s) {
  $s = trim($s);
  $s = str_replace("á","a",$s);
  $s = str_replace("Á","A",$s);
  $s = str_replace("é","e",$s);
  $s = str_replace("É","E",$s);
  $s = str_replace("í","i",$s);
  $s = str_replace("Í","I",$s);
  $s = str_replace("ó","o",$s);
  $s = str_replace("Ó","O",$s);
  $s = str_replace("ú","u",$s);
  $s = str_replace("Ú","U",$s);
  $s = str_replace(" ","-",$s);
  $s = str_replace("ñ","n",$s);
  $s = str_replace("Ñ","N",$s);
  $s = str_replace("?","",$s);
  $s = str_replace("¿","",$s);
  $s = str_replace("¡","",$s);
  $s = str_replace("!","",$s);
  $s = str_replace(",","",$s);
  $s = str_replace(";","",$s);
  $s = str_replace(":","",$s);
  $s = str_replace("%","",$s);
  $s = str_replace("/","",$s);
  $s = str_replace("(","",$s);
  $s = str_replace(")","",$s);
  $s = str_replace("\"","",$s);
  $s = str_replace("\"","",$s);
  $s = mb_strtolower($s);
  return $s;
}

?>


