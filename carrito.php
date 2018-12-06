<?php
session_start();
if(!isset($_SESSION["carrito"]) ){
	$_SESSION["carrito"] = array();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php 
	include("inc/header.inc.php");  
	?>
	<title>Carrito - Aimar Repuestos</title>
</head>
<body>
	<header class="header">
		<?php include("inc/nav.inc.php"); ?>
	</header>
	
	<div class="page-hero">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<h1 class="page-title text-uppercase">
						CARRITO DE COMPRA
					</h1>
				</div>
			</div>
		</div>
	</div>

	<div class="container cuerpoContenedor">   
		<div class="row">   
			<div class="col-md-12 col-xs-12" style="margin-top:10px"> 
				<?php include("inc/ver-carrito.inc.php"); ?> 
			</div> 
		</div>
	</div>  
	<?php include("inc/footer.inc.php"); ?>
</body>
</html> 