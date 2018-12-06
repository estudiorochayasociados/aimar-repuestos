<div class="clear">
	&zwnj;
</div>
<div class="large-12 columns">
	<h3>Anuncios</h3>
	<hr/>
	<?php
		$est = isset($_GET["est"]) ? $_GET["est"] : '2';
		$act = isset($_GET["act"]) ? $_GET["act"] : '';
		$borrar = isset($_GET["borrar"]) ? $_GET["borrar"] : '';
	?>
	<ul class="button-group right">
		<li><a href="index.php?op=verAnuncios&est=2" class="<?php if($est == 2) {echo "active";} else {echo "button";} ?>" style="padding:10px;margin-right:2px" >PENDIENTES <?php Contar_Agencias(2) ?></a></li>
		<li><a href="index.php?op=verAnuncios&est=3"class="<?php  if($est == 3) {echo "active";} else {echo "button";} ?>" style="padding:10px;margin-right:2px" >RECHAZADOS <?php Contar_Agencias(3) ?></a></li>
		<li><a href="index.php?op=verAnuncios&est=1" class="<?php if($est == 1) {echo "active";} else {echo "button";} ?>" style="padding:10px;margin-right:2px" >EXITOSOS <?php Contar_Agencias(1) ?></a></li>
		<li><a href="index.php?op=verAnuncios&est=0" class="<?php if($est == 0) {echo "active";} else {echo "button";} ?>" style="padding:10px;margin-right:2px" >NULO <?php Contar_Agencias(0) ?></a></li>
	</ul>	
	<table width="100%">
		<thead>
			<th>Agencia</th>
			<th>Localidad</th>
			<th style="text-align:center">Estado</th>
			<th style="text-align: right">Ajustes</th>
		</thead>
		<tbody>
			<?php
			switch ($est) {
				case 1 :
					Agencias_Read_Admin(1);
					break;
				case 2 :
					Agencias_Read_Admin(2);
					break;
				case 3 :
					Agencias_Read_Admin(3);
					break;
				case 0 :
					Agencias_Read_Admin(0);
					break;
				default :
					Agencias_Read_Admin(2);
					break;
			}
			?>
			<?php
			if ($act != '') {
				Actualizar_Estado($act, 1);
				header("location: index.php?op=verAnuncios");
			}
			
			if ($borrar != '') {
				$sql = "DELETE FROM `agencias` WHERE `cod_agencia` = '$borrar'";
				$link = Conectarse();
				$r = mysql_query($sql, $link);	
				header("location: index.php?op=verAnuncios&est=$est");
			}
			?>
			
		</tbody>
	</table>
</div>
