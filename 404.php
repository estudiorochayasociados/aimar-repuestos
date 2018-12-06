<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head> 
	<?php include("inc/header.inc.php"); ?>
	<title>Error 404 - Aimar Repuestos</title>
</head>
<body>
	<div id="page">
		<header class="header">
			<?php include("inc/nav.inc.php"); ?>
		</header>
		<div class="page-hero">
			<div class="container">
				<div class="row text-center pt-100 pb-100">
					<div class="col-xs-12">
						<h1 style="font-size: 70px">
							ERROR 404
						</h1>
						<h1>
							<?php echo $error404["error"][$lenguaje]; ?>
						</h1>
					</div>
				</div>
			</div>
		</div>	
	</div>	
	<?php include("inc/footer.inc.php"); ?>
</body>
</html>