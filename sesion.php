<?php
session_start();
if(!isset($_SESSION["carrito"]) ){
	$_SESSION["carrito"] = array();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include("inc/header.inc.php"); ?>
	<?php
	if (@$_SESSION["user"]["id"] == '') {
		headerMove(BASE_URL."/usuario.php");  
	}
	?>
	<title>Ingreso de Usuarios - Aimar Repuestos</title>

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
						<h1 class="page-title text-uppercase">
							SESION
						</h1>
					</div>
				</div>
			</div>
		</div>
		<div class="container cuerpoContenedor">
			<div class="row">  
				<div class="col-md-3">
					<h1 class="titular"><i class="fa fa-caret-right"></i> Sesión</h1>      					

					<div class="menuSesion hidden-xs hidden-sm">
						<li><a href="<?php echo BASE_URL ?>/sesion.php?op=pedidos"><i class="fa fa-list"></i> Ver Pedidos</a></li>
						<hr class="mt-5 mb-5 pt-0 pb-0" />
						<li><a href="<?php echo BASE_URL ?>/sesion.php?op=mi-cuenta"><i class="fa fa-user"></i> Mi cuenta</a></li>
						<hr class="mt-5 mb-5 pt-0 pb-0" />
						<li><a href="<?php echo BASE_URL ?>/sesion.php?op=salir"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a></li>
						<hr class="mt-5 mb-5 pt-0 pb-0" />
					</div>

					<div class="hidden-lg hidden-md">
						<select id="seleccion" onchange="$(location).attr('href', $('#seleccion').val());" class="form-control"> 
							<option value="<?php echo BASE_URL ?>/sesion.php?op=pedidos">Ver Pedidos</option>						
							<option value="<?php echo BASE_URL ?>/sesion.php?op=mi-cuenta">Mi cuenta</option>						
							<option value="<?php echo BASE_URL ?>/sesion.php?op=salir">Cerrar sesión</option>						
						</select>						
					</div>


					<?php  Traer_Contenidos("alerta sesion"); ?>
					<hr/>
				</div>
				<div class="col-md-9">
					<div class="row">
						<?php
						$op = isset($_GET["op"]) ? $_GET["op"] : '';
						switch($op) {

							case "pedidos":
							include('inc/sesion/pedidos.inc.php');
							break;
							case "mi-cuenta":
							include('inc/sesion/mi-cuenta.inc.php');
							break;
							case "ver-carrito":
							include('inc/sesion/ver-carrito.inc.php');
							break;
							case "salir":
							session_destroy();
							headerMove("usuarios.php");
							break;
							default:
							include('inc/sesion/pedidos.inc.php');
							break;
						}
						?> 
					</div>  
				</div>
			</div>  
		</div>
		<?php include("inc/footer.inc.php"); ?>
		<script>
			var txt = $("#envio option:selected").text();
			alert(text);
		</script>
	</body>
	</html>
	<?php
	ob_end_flush();
	?>
