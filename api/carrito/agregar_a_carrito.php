<?php
ob_start();
session_start();
include("../../admin/dal/data.php");
$_SESSION["carrito"] = isset($_SESSION["carrito"]) ? $_SESSION["carrito"] : array();
$op = isset($_GET["op"]) ? $_GET["op"] : '';
if($op == 1) {
	$id = isset($_POST["id"]) ? $_POST["id"] : '';
	$data = Productos_TraerXId($id);  
		
	$codigo_para_web = isset($data["codigo_para_web"]) ? $data["codigo_para_web"] : '1';
	$cantidad = isset($_POST["cantidad"]) ? $_POST["cantidad"] : '1';
	$var = $codigo_para_web."|".$cantidad;
	
	if($data["stock"] >= $cantidad) {
		array_push($_SESSION["carrito"], $var);
		echo "<span class='alert alert-success btn-block'> <i class='fa fa-cart-plus'> </i> Excelente, añadiste un nuevo producto a tu carro. <a href='".BASE_URL."/carrito'>Ir a mi carrito</a></span><div class='clearfix'></div>";
		echo "<script>fbq('track', 'AddToCart');</script>";
		headerMove(BASE_URL."/carrito");
	} else {
		echo "<div class='alert alert-danger'>No contamos con esa cantidad, consultanos haciendo <a href='".BASE_URL."/contacto'>click aquí</a></div>";
	}
} else {
	$idProducto = isset($_GET["idProducto"]) ? $_GET["idProducto"] : '';
	$data = Productos_TraerXId($idProducto);  
	?>
	<form id="formAjax" onsubmit="ajaxPost('<?php echo BASE_URL ?>/api/carrito/agregar_a_carrito.php?op=1');">
		<div id="resultado"></div>
		<div class="col-md-4 col-xs-4">
			<?php if(is_file("../../archivos/productos/".$data["rubro"]."/".str_replace("/","-",$data["codigo_para_web"]).".jpg")) { ?>
				<img src="<?php echo BASE_URL ?>/archivos/productos/<?php echo $data["rubro"]."/".str_replace("/","-",$data["codigo_para_web"]) ?>.jpg" width="100%" />
			<?php } else { ?> 
				<img src="<?php echo BASE_URL ?>/img/sin_imagen.jpg" width="100%"/>
			<?php } ?> 
		</div>
		<div class="col-md-8 col-xs-8">
			<h2 class='mb-0' style="font-size: 16px">
				<?php echo $data["descripcion"] ?>
			</h2>		
			<i>¿Cuántos estás necesitando?</i>
			<div class="clearfix"></div>
			<b>Cantidad: </b>
			<input type="hidden" name="id" class="form-control" value="<?php echo $data["id"] ?>">
			<input type="number" name="cantidad" min="1"  class="form-control" value="1" required="">
			<div class="clearfix"></div>
		</div>                      
		<div class="col-md-12 col-xs-12 mt-10"> 
			<div class="clearfix">
			</div> 
			<div class="hidden-md hidden-lg">
				<div class="mt-20"></div>
			</div>
			<input name="agregarSubmitCarro" type="submit" class="btn btn-success pull-right" value=" AGREGAR A CARRITO " />
		</div>
	</form>
	<div class='clearfix'></div>
<?php } ?>
