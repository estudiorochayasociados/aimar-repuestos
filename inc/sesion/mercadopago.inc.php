<?php
$cod = substr(md5(uniqid(rand())), 0, 7);
$precio = (float)$_SESSION["precioFinal"];
$pagar = $precio;
$moneda="ARS";
$pagar = $precio; 
$user = $_SESSION["user"]["id"];
$carrito = $_SESSION["carritoFinal"];
$con = Conectarse();
$sql = "INSERT INTO `pedidos`(`productos_pedidos`, `usuario_pedidos`, `estado_pedidos`, `fecha_pedidos`, `cod_pedidos`) VALUES ('$carrito','$user',9,NOW(),'$cod')";
$mysql_query = mysqli_query($con,$sql);  
?>
<div class="titular">
	<h1 class="titular"><i class="fa fa-caret-right"></i> Finalizar carrito</h1>      					
</div>
<b>Hola <?php echo $_SESSION["user"]["nombre"] ?></b>
<br/>El monto total del carrito es de: <b style="font-size: 25px">$<?php echo $_SESSION["precioFinal"] ?></b>  
<div class="clearfix"></div>
<b class="">¿Con qué te gustaría abonar?</b><br/>
<?php
//MERCADOPAGO
require_once ('mercadopago/mercadopago.php');
$mp = new MP('1593771261124394', 'mYbUuN2PQG9DXBValCyEpxS1Avu7slFZ');
$preference_data = array(
	"items" => array(
		array(
			"title" => "COMPRA EN ".TITULO." ORDEN: ".$cod,			
			"currency_id" => "ARS", 
			"unit_price" => $pagar,
			"quantity" => 1
		)
	),
	"auto_return" => "approved",
	"notification_url" => "http://www.aimarrepuestos.com.ar/ipn.php",
	"back_urls"  => array(
		//"failure" => BASE_URL."/sesion.php?op=ver-carrito&finalizar=ok&pago=2&estado=2&cod=".$cod,			
		"failure" => "sesion.php?op=ver-carrito&finalizar=ok&pago=2&estado=2&cod=".$cod,			
		//"pending" => BASE_URL."/sesion.php?op=ver-carrito&finalizar=ok&pago=2&estado=0&cod=".$cod,			
		"pending" => "sesion.php?op=ver-carrito&finalizar=ok&pago=2&estado=0&cod=".$cod,			
		//"success" => BASE_URL."/sesion.php?op=ver-carrito&finalizar=ok&pago=2&estado=1&cod=".$cod			
		"success" => "sesion.php?op=ver-carrito&finalizar=ok&pago=2&estado=1&cod=".$cod			
	)

);
$preference = $mp->create_preference($preference_data);
?> 
<div class="row mt-10"> 
	<div class="col-md-12 col-xs-12 mb-10">
		<a href="<?php echo $preference['response']['init_point']; ?>"  class="btn btn-info btn-block <?php echo $display ?>" name="MP-Checkout" mp-mode="modal" style="background: green"><i class="fas fa-credit-card"></i> PAGO CON MERCADO PAGO</a>
	</div>
	<div class="clearfix hidden-xs hidden-sm"></div>
	<div class="col-md-6 col-xs-12 mb-10">
		<a href="<?php echo BASE_URL ?>/sesion.php?op=ver-carrito&finalizar=ok&pago=1&cod=<?php echo $cod; ?>"  class="btn btn-block btn-success"  style="background: #2e2eba"><i class="fa fa-bank"></i> Pagar con Transferencia Bancaria</a>
	</div>
	<div class="col-md-6 col-xs-12 mb-10">
		<a href="<?php echo BASE_URL ?>/sesion.php?op=ver-carrito&finalizar=ok&pago=3&cod=<?php echo $cod; ?>"  class="btn btn-block btn-warning"   style="background: #2e2eba"><i class="fa fa-money"></i> Pagar de contado en sucursal</a>
	</div>
</div>
<div class="clearfix"></div><br/><br/>
<img src="https://imgmp.mlstatic.com/org-img/banners/ar/medios/785X40.jpg" title="MercadoPago - Medios de pago" alt="MercadoPago - Medios de pago" width="100%" />

<script type="text/javascript">
	(function(){function $MPC_load(){window.$MPC_loaded !== true && (function(){var s = document.createElement("script");s.type = "text/javascript";s.async = true;
		s.src = document.location.protocol+"//resources.mlstatic.com/mptools/render.js";
		var x = document.getElementsByTagName('script')[0];x.parentNode.insertBefore(s, x);window.$MPC_loaded = true;})();}
		window.$MPC_loaded !== true ? (window.attachEvent ? window.attachEvent('onload', $MPC_load) : window.addEventListener('load', $MPC_load, false)) : null;})();
	</script> 
