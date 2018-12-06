<div class="large-12 column">
	<br/>
	<h3>Micrositio</h3>
	<hr/>
	<center id="loading" class="loading" style="display: none">
	<div class='clearfix'>
		&zwnj;
	</div><img src='../img/loader.gif' />
	<br>
	<p style="color:#2980B9">Subiendo imagen de publcidad y datos</p>
	<div class='clearfix'>
		&zwnj;
	</div>
</center> 
	<?php
	$id = isset($_GET["id"]) ? $_GET["id"] : '';
	$mod = isset($_GET["mod"]) ? $_GET["mod"] : '';
	$destino = array();
	
	if($mod != '') { 
		$dataMicro = Micrositio_TraerPorId($mod);
			$descripcion = isset($dataMicro["descripcion_micrositio"]) ? $dataMicro["descripcion_micrositio"] : '';
			$mapa = isset($dataMicro["maps_micrositio"]) ? $dataMicro["maps_micrositio"] : '';
			$img1 = isset($dataMicro["img1_micrositio"]) ? $dataMicro["img1_micrositio"] : '';
			$img2 = isset($dataMicro["img2_micrositio"]) ? $dataMicro["img2_micrositio"] : '';
			$img3= isset($dataMicro["img3_micrositio"]) ? $dataMicro["img3_micrositio"] : '';
			$img4 = isset($dataMicro["img4_micrositio"]) ? $dataMicro["img4_micrositio"] : '';
			$img5 = isset($dataMicro["img5_micrositio"]) ? $dataMicro["img5_micrositio"] : '';	
	
			if (isset($_POST["publicar"])) {
				if ($_POST["descripcion"] != '' && $_POST["maps"] != '') {
					for ($i = 1; $i <= 5; $i++) {
						if($_FILES["img$i"]["name"] != '') {			
							$imgInicio = "";
							$destinoImg = "";				
							$prefijo = substr(md5(uniqid(rand())), 0, 6);
							$imgInicio = $_FILES["img$i"]["tmp_name"];
							$tucadena = $_FILES["img$i"]["name"];
							$partes = explode(".", $tucadena);
							$dominio = $partes[1];
							$destinoFinal = "../archivos/micrositio/" . $prefijo . "." . $dominio;
							$destinoImg = "archivos/micrositio/" . $prefijo . "." . $dominio;
							move_uploaded_file($imgInicio, $destinoFinal);
							chmod($destinoFinal, 0777);
						} else {
							$destinoImg = $dataMicro["img".$i."_micrositio"];
						}
						
						array_push($destino, $destinoImg);		
					}
		
				
				$descripcion2 = isset($_POST["descripcion"]) ? $_POST["descripcion"] : $descripcion;
		
				
				if($_POST["maps"] != '') {
				$cadena = $_POST["maps"];
				$maximo = strlen($cadena);
				$ide = 'src="';
				$ide2 = 'embed">';
				$total = stripos($cadena, $ide);
				$total2 = stripos($cadena, $ide2);
				$total3 = ($maximo - $total2 - 7);
				$final = substr($cadena, $total, -$total3);
				} else {
					$final = $mapa;
				} 
						
				if ($_POST["maps"] != '') {
					if ($total != '') {
						$sql = "UPDATE `micrositio` SET `descripcion_micrositio`='$descripcion2',`maps_micrositio`='$final',`img1_micrositio`= '$destino[0]',`img2_micrositio`='$destino[1]',`img3_micrositio`='$destino[2]',`img4_micrositio`='$destino[3]',`img5_micrositio`='$destino[4]' WHERE `cod_micrositio`= '$mod'";
						$link = Conectarse();
						$r = mysql_query($sql, $link);																	
					} else {
					echo "<span class='alert-box error'>Hay un error a la hora de cargar Google Maps</span>";
					}
				} else {
				$sql = "UPDATE `micrositio` SET `descripcion_micrositio`='$descripcion2',`maps_micrositio`='$final',`img1_micrositio`= '$destino[0]',`img2_micrositio`='$destino[1]',`img3_micrositio`='$destino[2]',`img4_micrositio`='$destino[3]',`img5_micrositio`='$destino[4]' WHERE `cod_micrositio`= '$mod'";
				$link = Conectarse();
				$r = mysql_query($sql, $link);															
				}		
			}
		}
		
		?>
		<form method="post" enctype="multipart/form-data" onsubmit="loadingShow()">
		<label style="width:49%" class="left">Descripción:
			<br/>
			<br/>
			<textarea name="descripcion" style="height: 250px"><?php echo $descripcion ?></textarea> </label>
		<label style="width:49%" class="right">Google Maps:
			<br/>
			<br/>
			<textarea name="maps" style="height: 250px"><?php echo $mapa ?></textarea> </label>

		<div class="clearfix">
			&zwnj;
		</div>

		<?php for($i = 1; $i <= 5; $i++) { ?>
		<label class="large-2 column">
		<span class='error' id="imgError" style="display: none"></span>	
			<?php if($img1 === '') {
				
			?>
			<input type="file" name="img<?php echo $i ?>" onchange="checkFile2(this)"/>
			<?php }else { ?>
			<div style="overflow: hidden;">
				<br/>
				<label>Imágen
					<br/>
					<br/>
					<a href="../<?php echo $dataMicro["img".$i."_micrositio"] ?>" rel="lightbox" ><img src="../<?php echo $dataMicro["img".$i."_micrositio"] ?>" width="100%"; ></a></label>
				<br/>
				<p onclick="" class="button" >
					Cambiar
				</p>
			</div>
			<div id="imgDiv" style=";display:none">
				<input type="file" name="img<?php echo $i ?>" id="img2" onchange="checkFile2(this)" />
			</div>
			<?php } ?></label>
		<?php } ?>	
			
		<div class="clearfix">&zwnj;</div>
		<button onclick="window.location.back()" class="button left" style="background:#333">VOLVER</button>
		<input type="submit" class="button right" name="publicar"  id="botonPubli" value="MODIFICAR MICROSITIO"/>		
	</form>
		<?php
		die();
		}
 ?>
</div>
