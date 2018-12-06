<?php include("inc/encabezado.inc.php")
?>

<?php
if(!isset($_SESSION["usuario"]["nombre_usuario"])) {
	?>
	<center class="container">
		<center class="col-lg-12">
			<img src="<?= LOGO ?>"  width="300">
		</center>
	</center>
	<?php
}



if(isset($_SESSION["usuario"]["nombre_usuario"])) {
	?>
	<div id="wrapper">

		<?php
		include ("inc/nav.inc.php");
		?>
		<center id="loading" class="loading" style="display: none">
			<div class='clearfix'>
				&zwnj;
			</div><img src='img/loader.gif' />
			<br>
			<p style="color:#2980B9">
			Cargando...			</p>
			<div class='clearfix'>
				&zwnj;
			</div>
		</center>
		<div id="page-wrapper">
			<div class=" ">
				<div class="col-lg-12">

					<div class="row">
						<div class="col-lg-12">
							<h1  >Hola <?php echo $_SESSION["usuario"]["nombre_usuario"] ?></h1>							
						</div>            
					</div>
				</div>
				<?php
				switch($op) {
					case 'importarProductos' :
					include ("inc/mod_importar_productos/index.php");
					break; 
					case 'verificarImagenes' :
					include ("inc/mod_importar_productos/verificar.php");
					break; 
					case 'verContenidos' :
					include ("inc/mod_contenido/ver_contenido.php");
					break; 
					case 'modificarContenidos' :
					include ("inc/mod_contenido/modificar_contenido.php");
					break;
					case 'agregarContenidos' :
					include ("inc/mod_contenido/agregar_contenido.php");
					break; 
					case 'verPagos' :
					include ("inc/mod_mp/buscar.inc.php");
					break;
					case 'verContacto' :
					include ("inc/mod_contacto/ver_contacto.php");
					break;
					case 'verSuscriptos' :
					include ("inc/mod_suscriptos/ver_suscriptos.php");
					break;	
					case 'agregarCategoria' :
					include ("inc/mod_categoria/agregar_categoria.php");
					break;
					case 'modificarCategoria' :
					include ("inc/mod_categoria/modificar_categoria.php");
					break;
					case 'verCategoria' :
					include ("inc/mod_categoria/ver_categoria.php");
					break;
					case 'agregarRubro' :
					include ("inc/mod_rubro/agregar_rubro.php");
					break;
					case 'modificarRubro' :
					include ("inc/mod_rubro/modificar_rubro.php");
					break;
					case 'verRubro' :
					include ("inc/mod_rubro/ver_rubro.php");
					break;
					case 'verEnvios' :
					include ("inc/mod_envios/ver_envios.php");
					break;
					case 'agregarMarcas' :
					include ("inc/mod_marcas/agregar_marcas.php");
					break;
					case 'modificarMarcas' :
					include ("inc/mod_marcas/modificar_marcas.php");
					break;
					case 'verMarcas' :
					include ("inc/mod_marcas/ver_marcas.php");
					break;
					case 'verModelos' :
					include ("inc/mod_marcas/ver_modelos.php");
					break;
					case 'verPromos' :
					include ("inc/mod_promos/ver_promos.php");
					break;
					case 'agregarPromos' :
					include ("inc/mod_promos/agregar_promos.php");
					break;
					case 'modificarPromos' :
					include ("inc/mod_promos/modificar_promos.php");
					break;	
					case 'verCategoria' :
					include ("inc/mod_categoria/ver_categoria.php");
					break;
					case 'agregarSubcategoria' :
					include ("inc/mod_categoria/agregar_subcategoria.php");
					break;
					case 'verSubcategoria' :
					include ("inc/mod_categoria/ver_subcategoria.php");
					break;
					case 'modificarSubcategoria' :
					include ("inc/mod_categoria/modificar_subcategoria.php");
					break;
					case 'agregarPortfolio' :
					include ("inc/mod_portfolio/agregar_portfolio.php");
					break;
					case 'modificarPortfolio' :
					include ("inc/mod_portfolio/modificar_portfolio.php");
					break;
					case 'verPortfolio' :
					include ("inc/mod_portfolio/ver_portfolio.php");
					break;
					case 'agregarTestimonio' :
					include ("inc/mod_testimonios/agregar_testimonios.php");
					break;
					case 'modificarTestimonio' :
					include ("inc/mod_testimonios/modificar_testimonios.php");
					break;
					case 'verTestimonio' :
					include ("inc/mod_testimonios/ver_testimonios.php");
					break;
					case 'agregarFinanciacion' :
					include ("inc/mod_financiacion/agregar_financiacion.php");
					break;
					case 'modificarFinanciacion' :
					include ("inc/mod_financiacion/modificar_financiacion.php");
					break;
					case 'verFinanciacion' :
					include ("inc/mod_financiacion/ver_financiacion.php");
					break;
					case 'agregarAlbums' :
					include ("inc/mod_albums/agregar_albums.php");
					break;
					case 'modificarAlbums' :
					include ("inc/mod_albums/modificar_albums.php");
					break;
					case 'verAlbums' :
					include ("inc/mod_albums/ver_albums.php");
					break;
					case 'agregarPaquetes' :
					include ("inc/mod_maquinas/agregar_maquinas.php");
					break;
					case 'modificarPaquetes' :
					include ("inc/mod_maquinas/modificar_maquinas.php");
					break;
					case 'verPaquetes' :
					include ("inc/mod_maquinas/ver_maquinas.php");
					break;
					case 'verSesiones' :
					include ("inc/mod_sesiones/ver_sesiones.php");
					break;
					case 'verPedidos' :
					include ("inc/mod_pedidos/ver_pedidos.php");
					break;	
					case 'modPedidos' :
					include ("inc/mod_pedidos/modificar_pedidos.php");
					break;
					case 'verUsuarios' :
					include ("inc/mod_usuarios/ver_usuarios.php");
					break;
					case 'verInscriptosI' :
					include ("inc/mod_inscriptos/ver_inscriptosI.php");
					break;
					case 'verInscriptosS' :
					include ("inc/mod_inscriptos/ver_inscriptosS.php");
					break;
					case 'agregarUsuarios' :
					include ("inc/mod_usuarios/agregar_usuarios.php");
					break;
					case 'modUsuarios' :
					include ("inc/mod_usuarios/modificar_usuario.php");
					break;
					case 'verNotas' :
					include ("inc/mod_notas/ver_notas.php");
					break;
					case 'agregarNotas' :
					include ("inc/mod_notas/agregar_notas.php");
					break;
					case 'modificarNotas' :
					include ("inc/mod_notas/modificar_notas.php");
					break;
					case 'verSlider' :
					include ("inc/mod_sliders/ver_slider.php");
					break;
					case 'agregarSlider' :
					include ("inc/mod_sliders/agregar_slider.php");
					break;
					case 'modificarSlider' :
					include ("inc/mod_sliders/modificar_slider.php");
					break;
					case 'verVideos' :
					include ("inc/mod_videos/ver_videos.php");
					break;
					case 'agregarVideos' :
					include ("inc/mod_videos/agregar_videos.php");
					break;
					case 'modificarVideos' :
					include ("inc/mod_videos/modificar_videos.php");
					break;
					case 'verCursos' :
					include ("inc/mod_cursos/ver_cursos.php");
					break;
					case 'agregarCursos' :
					include ("inc/mod_cursos/agregar_cursos.php");
					break;
					case 'verMensajes' :
					include ("inc/mod_sms/ver_sms.php");
					break;
					case 'agregarBases' :
					include ("inc/mod_sms/agregar_base.php");
					break;
					case 'agregarMensajes' :
					include ("inc/mod_sms/agregar_sms.php");
					break;
					case 'modificarCursos' :
					include ("inc/mod_cursos/modificar_cursos.php");
					break;
					case 'verBases' :
					include ("inc/mod_db/ver_bases.php");
					break;
					case 'salir' :
					LogOut();
					header("location:index.php");
					break;
					default :
					include ("inc/home.php");
					break;
				}
				?>
			</div>
		</div>
	</div>
</div>
<?php
} else {
	?>
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="login-panel panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Ingresar al administrador</h3>
					</div>
					<div class="panel-body">
						<form role="form" method="post">
							<?php
							if (isset($_POST["login"])) {
								if ($_POST["user"] != '' && $_POST["pass"] != '') {
									@Login($_POST["user"], $_POST["pass"]);
								}
							}
							?>
							<fieldset>
								<div class="form-group">
									<input class="form-control" placeholder="E-mail" name="user" type="text" autofocus>
								</div>
								<div class="form-group">
									<input class="form-control" placeholder="Password" name="pass" type="password" value="">
								</div>
								<input type="submit" class="btn btn-lg btn-success btn-block" value="Ingresar" name="login" />
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
<?php include("inc/pie.inc.php")
?>