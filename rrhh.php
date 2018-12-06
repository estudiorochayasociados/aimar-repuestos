<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head> 
	<?php include("inc/header.inc.php"); ?>
	<title>RRHH - Aimar Repuestos</title>
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
						<h2 class="page-title">
							RRHH								
						</h2>
					</div>
				</div>
			</div>
		</div>
		<main class="main">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 col-xs-12">
						<script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/shell.js"></script>
						<script>
							hbspt.forms.create({
								portalId: "4788560",
								formId: "e8db88c8-76e1-4a78-ac79-34dd3247a352"
							});
						</script>
					</div>
					<div class="col-lg-6 col-xs-12">
						<h2>
							Nuestros datos de contacto
						</h2>						
						<p>
							<?php Traer_Contenidos("contacto") ?>
						</p>
						<h2>
							¿Cómo llegar?
						</h2>						
						<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3404.7149148237595!2d-62.091797184417295!3d-31.42197978140218!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95cb283c802f0e67%3A0x42f385f21c4cb2fd!2sCalle+Castelli+2260%2C+San+Francisco%2C+C%C3%B3rdoba!5e0!3m2!1ses!2sar!4v1538421648558" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
					</div>
				</div>
			</div>
		</main>	
	</div>
	<?php include("inc/footer.inc.php"); ?>
</body>
</html>