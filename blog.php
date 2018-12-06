<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head> 
	<?php include("inc/header.inc.php"); ?>
	<title><?php echo "Novedades"?> - Aimar Repuestos</title>
</head>
<body>
	<div id="page">
		<header class="header">
			<?php include("inc/nav.inc.php"); ?>
		</header>
		<div class="page-hero">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<h2 class="page-title"><?php echo "Novedades"?></h2>
					</div>
				</div>
			</div>
		</div>
		<main class="main">
			<div class="container">
				<div class="row">
					<div class="col-xl-9 col-lg-8 col-xs-12">
						<?php Notas_Read_Front("") ?>
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