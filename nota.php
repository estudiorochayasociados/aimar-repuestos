<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php 
	include("inc/header.inc.php"); 
	$url= $_SERVER["REQUEST_URI"];
	$id = antihack_mysqli(isset($_GET["id"]) ? $_GET["id"] : '');
	$data = Nota_TraerPorId($id);
	$fecha = explode("-",$data["FechaNotas"]);
	$titulo = $data["TituloNotas"]; 
	$descripcion = $data["DesarrolloNotas"]; 

	$cod = $data["CodNotas"];
	$sqlImagen = "SELECT `ruta` FROM `imagenes` WHERE `codigo` = '$cod'";
	$idConn = Conectarse();
	$resultadoImagen = mysqli_query($idConn,$sqlImagen);
	if ($imagenes = mysqli_fetch_row($resultadoImagen)) {
		$imagen = BASE_URL . "/" . $imagenes[0];
	} else {
		$imagen = BASE_URL . '/images/producto_sin_imagen.jpg';
	}

	$keywords = "";
	$description = $data["DesarrolloNotas"]; 
	?>
	<title><?php echo $titulo; ?> - <?php echo TITULO; ?></title>
	<meta http-equiv="title" content="<?php echo $title; ?>" />
	<meta name="description" lang=es content="<?php echo substr(strip_tags($description),0,160); ?>" />
	<meta name="keywords" lang=es content="<?php echo $keywords; ?>" />
	<link href="<?php echo $imagen ?>" rel="Shortcut Icon" />
	<meta name="DC.title" content="<?php echo $title; ?>" />
	<meta name="DC.subject" content="<?php echo substr(strip_tags($description),0,160); ?>" />
	<meta name="DC.description" content="<?php echo substr(strip_tags($description),0,160); ?>" />

	<meta property="og:title" content="<?php echo $title; ?>" />
	<meta property="og:description" content="<?php echo substr(strip_tags($description),0,160); ?>" />
	<meta property="og:image" content="<?php echo $imagen ?>" />
	<meta property="fb:app_id" content="<?php echo APP_ID_FACEBOOK; ?>" /> 
</head>
<body>
	<div id="page"  itemscope itemtype="http://schema.org/Article" itemid="<?php echo "http://".CANONICAL ?>">
		<header class="header">
			<?php include("inc/nav.inc.php"); ?>
		</header>
		<div class="page-hero">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<span itemprop="mainEntityOfPage" href="<?php echo "http://".CANONICAL ?>">
							<h2 class="page-title" itemprop="name">
								<?php echo $data["TituloNotas"] ?>
							</h2>
						</span>
					</div>
				</div>
			</div>
		</div>
		<main class="main">
			<div class="container">
				<div class="row">
					<div class="col-xl-9 col-lg-8 col-xs-12">
						<article class="entry">
							<img  itemprop="image" src="<?php echo $imagen ?>" width="100%"><br><br>
							<span  itemprop="description"><?php echo $data["DesarrolloNotas"] ?></span>
						</article>

						<div class="leader-half kids0514-share">
							<h5>Compartir en:</h5>
							<a href="https://facebook.com/sharer.php?u=https://<?= CANONICAL ?>" target="_blank" class="btn btn-info" style="font-weight: normal"><i class="fab fa-2x fa-facebook"></i></a>
							<a href="https://twitter.com/intent/tweet?url=https://<?= CANONICAL ?>" target="_blank" class="btn btn-info" style="font-weight: normal"><i class="fab fa-2x fa-twitter"></i></a>
							<a href="http://pinterest.com/pin/create/button/?url=https://<?= CANONICAL ?>" target="_blank" class="btn btn-info" style="font-weight: normal"><i class="fab fa-2x fa-pinterest"></i></a>
							<a href="https://plus.google.com/share?url=https://<?= CANONICAL ?>" target="_blank" class="btn btn-info" style="font-weight: normal"><i class="fab fa-2x fa-google"></i></a>
							<hr/>
						</div> 
					</div>
					<div class="col-xl-3 col-lg-4 col-xs-12">
						<div class="sidebar">
							<?php include("inc/sidebar.inc.php"); ?>
						</div>
					</div>
				</div>
			</div>
		</main>
		<?php include("inc/footer.inc.php"); ?>
	</body>
	</html>