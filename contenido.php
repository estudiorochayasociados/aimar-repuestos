<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
include "inc/header.inc.php";
$contenido = isset($_GET["id"]) ? $_GET["id"] : '';
$contenido = explode("/", $contenido);
$contenido = $contenido[1];
$contenidoData = Contenido_TraerPorId($contenido);
?>
	<title><?php echo $contenidoData["codigo"]; ?> - Aimar Repuestos</title>
</head>

<body>
	<div id="page" class="index">
		<header class="header">
			<?php include "inc/nav.inc.php"; ?>
		</header>
		<div class="page-hero">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<h1 class="page-title text-uppercase">
							<?php echo $contenidoData["codigo"]; ?>
						</h1>
					</div>
				</div>
			</div>
		</div>
		<main class="main main-home">
			<div class="container  pb-50">
				<?php echo $contenidoData["contenido"]; ?>
			</div>
		</main>
		<?php include "inc/footer.inc.php"; ?>
	</div>
</body>
</html>