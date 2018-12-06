<?php
$precio = (float)$_SESSION["precioFinal"];
$codigo = $_SESSION["codcompra"];
$pagar = $precio;
$user = $_SESSION["user"]["id"];
$carrito = $_SESSION["carritoFinal"];
$con = Conectarse();
$sql_verificar = "SELECT cod_pedidos FROM pedidos WHERE cod_pedidos = '$codigo'";
$res_verificar = mysqli_query($con,$sql_verificar);
$row_verificar = mysqli_fetch_array($res_verificar);

if($row_verificar == NULL){
	$sql = "INSERT INTO `pedidos`(`productos_pedidos`, `usuario_pedidos`, `estado_pedidos`, `fecha_pedidos`, `cod_pedidos`) VALUES ('$carrito','$user',9,NOW(),'$codigo')";
} else{
	$sql = "UPDATE `pedidos` SET  fecha_pedidos = NOW(), productos_pedidos = '$carrito' WHERE cod_pedidos = '$codigo'";
}

$mysql_query = mysqli_query($con,$sql);
echo "<script>fbq('track', 'InitiateCheckout');</script>";
?> 
<div class="mb-20" style="font-size:20px">
	<b><?php echo ucwords($_SESSION["user"]["nombre"]) ?></b>, el monto total del carrito es de: <b>$<?php echo $_SESSION["precioFinal"] ?></b>   
</div>
<table>
	<table class="table table-bordered table-striped">
		<thead>
			<th><b>Nombre producto</b></th>
			<th><b>Cantidad</b></th>
			<th><b>Precio unidad</b></th>
			<th><b>Precio total</b></th>
		</thead>
		<tbody>
			<?php echo $_SESSION["carritoFinal"]; ?>
		</tbody>
	</table>
	<div class="mb-20" style="font-size:20px">
		<b>¿Con qué te gustaría abonar?</b>
	</div>
	<hr/> 
	<?php
	require_once ('inc/mercadopago/mercadopago.php'); 
	$mp = new MP('1223238149715294', 'wSyOHKGopR9UTGsZkRoSE5KUbwzB7OMh');
	$preference_data = array(
		"items" => array(
			array(
				"title" => "COMPRA:".$codigo,			
				"currency_id" => "ARS", 
				"unit_price" => $pagar,
				"quantity" => 1
			)
		),
		"auto_return" => "approved",
		"back_urls"  => array(
			"failure" => BASE_URL."/cierre-checkout.php?pago=2&estado=2&cod=".$codigo,		
			//"failure" => "cierre-checkout.php?pago=2&estado=2&cod=".$codigo,		
			"pending" => BASE_URL."/cierre-checkout.php?pago=2&estado=0&cod=".$codigo,		
			//"pending" => "cierre-checkout.php?pago=2&estado=0&cod=".$codigo,		
			"success" => BASE_URL."/cierre-checkout.php?pago=2&estado=1&cod=".$codigo		
			//"success" => "cierre-checkout.php?pago=2&estado=1&cod=".$codigo		
		),
		"payment_methods" => array(
			"excluded_payment_types" => array(
				array ( "id" => "ticket"),
				array ( "id" => "atm" )
			)
		)
	);
	$preference = $mp->create_preference($preference_data);

	?>
	<a href="<?php echo $preference['response']['init_point']; ?>" class="mb-10 btn btn-success btn-block <?php echo $display ?>" name="MP-Checkout" mp-mode="modal">
		<i class="fa fa-credit-card"></i> 
		PAGAR CON TARJETAS DE CRÉDITO/DÉBITO
	</a>

	<hr class="hidden-xs hidden-sm" />
	<div class="row"> 
		<div class="col-md-6">
			<a href="<?php echo BASE_URL ?>/cierre-checkout.php?pago=1&cod=<?php echo $codigo ?>"  class="mb-10 btn btn-block btn-primary">
				<i class="fa fa-bank"></i>
				Pagar con Transferencia Bancaria
			</a>
		</div>
		<div class="col-md-6">
			<a href="<?php echo BASE_URL ?>/cierre-checkout.php?pago=3&cod=<?php echo $codigo ?>"  class="mb-10 btn btn-block btn-warning">
				<i class="fa fa-money"></i>
				Coordinar con el vendedor
			</a>
		</div>
	</div>
	<div class="clearfix"></div> 
	<br/>
	<center><img src="<?php echo BASE_URL; ?>/images/mp.jpg" title="MercadoPago - Medios de pago" alt="MercadoPago - Medios de pago" /></center>
	<script type="text/javascript">
		(function(){function $MPC_load(){window.$MPC_loaded !== true && (function(){var s = document.createElement("script");s.type = "text/javascript";s.async = true;
			s.src = document.location.protocol+"//resources.mlstatic.com/mptools/render.js";
			var x = document.getElementsByTagName('script')[0];x.parentNode.insertBefore(s, x);window.$MPC_loaded = true;})();}
			window.$MPC_loaded !== true ? (window.attachEvent ? window.attachEvent('onload', $MPC_load) : window.addEventListener('load', $MPC_load, false)) : null;})();
		</script> 