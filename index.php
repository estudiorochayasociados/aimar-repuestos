<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include("inc/header.inc.php"); ?>
	<script type="text/javascript" src="//cdn.jsdelivr.net/afterglow/latest/afterglow.min.js"></script>
	<title>Aimar Repuestos</title>
</head>

<body>
	<div id="page" class="index">
		<header class="header">
			<?php include("inc/nav.inc.php"); ?>
		</header>
		<main class="main main-home">
			<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
				<div class="carousel-inner" role="listbox">
					<?php Slider_Read("inicio") ?>
				</div>
				<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
			<div style="background:#F8E002" >
				<a target="_blank" href="https://listado.mercadolibre.com.ar/_CustId_223273281">
					<div class="container text-center pb-0 mb-0">
						<img src="<?php echo BASE_URL ?>/img/banner-mercadolibre.jpg" class="meli" width="60%" />		
					</div>
				</a>	
			</div> 
		</main>
		<?php include("inc/footer.inc.php"); ?> 		 
	</div>
</body>
</html>

