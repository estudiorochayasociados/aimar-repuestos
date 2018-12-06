<div class="pb-60">
	<?php
	contar_repeticiones($_SESSION["carrito"]);	
	if(empty($_SESSION["carrito"])) {
		header("location:sesion.php");
	}

	$finalizar = isset($_GET["finalizar"]) ? $_GET["finalizar"] : '';
	$pago = isset($_GET["pago"]) ? $_GET["pago"] : '';
	
	if($finalizar != ''){
		if($pago == '') {
			include("inc/sesion/mercadopago.inc.php");	
		} else {
			include("inc/sesion/aviso.inc.php");	
		}	
	} else { 
		?>
		<h1 class="titular"><i class="fa fa-caret-right"></i> Carrito</h1>      					
		<table class="table table-striped table-responsive">
			<thead>
				<th>Producto</th>
				<th>Cantidad</th> 
				<th>Precio</th>
				<th>Total</th>
				<th></th>
			</thead>
			<?php
			$eliminar = isset($_GET["eliminar"]) ? $_GET["eliminar"] : '';
			if($eliminar != '') {
				unset($_SESSION["carrito"][$eliminar]);
				header("location:".BASE_URL."/carrito");
			}
			$contaCarrito = count($_SESSION["carrito"]);
			end($_SESSION["carrito"]);
			$contaCarrito = key($_SESSION["carrito"]);
			$precioFinal = 0;
			$carroFinal = '';
			for($i = 0; $i <= $contaCarrito; $i++) {		 
				if(isset($_SESSION["carrito"][$i])) {	
					$carrito = explode("|",$_SESSION["carrito"][$i]);
					$dataProducto = Productos_TraerPorId($carrito[0]); 	
					$precio = $dataProducto['precio'];					 
					$precio = @number_format($precio, 2, '.', '');
					$impuesto = "";		
					$car= array(" ", "?", "-", "%");
					$urlLink = mb_strtolower(trim(normaliza_acentos($dataProducto["descripcion"])));	 
					$precioTotal = $precio * $carrito[1];
					$precioTotal = number_format($precioTotal,2, '.', '');
					$precioFinal = $precioFinal + $precioTotal;	
					$precioFinal = number_format($precioFinal, 2 , '.', '');
					$carroFinal .= "<tr><td>".$dataProducto["descripcion"]."</td><td>".$carrito[1]."</td><td>$".$precio."</td><td>$".$precioTotal."</td></tr>";	
					?>
					<tr>
						<td style="font-size:13px">
							<?php echo $dataProducto["descripcion"] ?>
						</td>
						<td style="font-size:13px">
							<?php echo $carrito[1] ?>
						</td> 
						<td style="font-size:13px">
							<?php echo "$".$precio ?>
						</td>
						<td style="font-size:13px" class="hidden-xs hidden-sm">
							<?php echo "$".$precioTotal ?>
						</td>	
						<td style="font-size:13px">
							<a href="<?php echo BASE_URL ?>/sesion.php?op=ver-carrito&eliminar=<?php echo $i ?>"><i class="fa fa-close"></i></a>										
						</td>		
					</tr>
					<?php
				}
			}

			$_SESSION["precioFinal"] = number_format($precioFinal, 2, '.', '');
			$_SESSION["carritoFinal"] = $carroFinal;			
			$_SESSION["carritoFinal"] .= "<tr><td><b>Precio Final Total</b></td><td></td><td></td><td><b>$$precioFinal</b></td></tr>";

			?>
			<tr>
				<td><b>Precio Final Total</b></td>
				<td></td>
				<td></td>
				<td><b>$<?php echo $precioFinal ?></b></td>
				<td></td>
			</tr>
		</table>

		<div class="clearfix"></div>
		<div class="aLoad mb-100">
			<a href="<?php echo BASE_URL ?>/productos.php" class="btn  btn-info pull-left"> <i class="fa fa-shopping-cart"></i> Seguir comprando</a>

			 <?php if(isset($_SESSION["user"]["id"])) { ?> 
         <a href="<?php echo BASE_URL ?>/sesion.php?op=ver-carrito&finalizar=ok" id="finalizarCarrito" class="btn  btn-success pull-right" > <i class="fa fa-check"></i> Finalizar</a>
        <?php } else { ?>
         <a href="<?php echo BASE_URL ?>/usuarios.php?link=ver-carrito&finalizar=ok" id="finalizarCarrito" class="btn  btn-success pull-right" > <i class="fa fa-check"></i> Finalizar</a>
        <?php } ?>


			
		</div>
		<?php
	}
	?> 
</div>
