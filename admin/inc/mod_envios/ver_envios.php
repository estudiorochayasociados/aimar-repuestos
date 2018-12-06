<div class="col-lg-12">
	<h4>Precios Correo Argentino</h4>
	<hr/>
	<table class="table  table-bordered table-hovered table-striped">
		<thead>
			<th>Envio x peso</th>			
			<th>Precio</th>		
		</thead>
		<tbody>
			<?php
			Precios_Envio_Read(); 
			
			if(isset($_POST["enviarEnvio"])) {
				$id = antihack(isset($_POST["id"]) ? $_POST["id"] : '');
				$precio = antihack(isset($_POST["precio"]) ? $_POST["precio"] : '');
				if($id != '' && $precio != '') {
					$sql = "UPDATE `envio` SET `precio`= '$precio'  WHERE `id` = '$id'";
					$link = Conectarse();
					$r = mysqli_query($link,$sql);
					headerMove("index.php?op=verEnvios");
				}			 
			}
			?>
		</tbody>
	</table>
</div>

