<?php 
$id = isset($_GET["id"]) ? $_GET["id"] : '';
$dataUser = Usuario_TraerPorId($id);
?>
<div class="large-12 column">
	
	<center id="loading" class="loading" style="display: none">
	<div class='clearfix'>
		&zwnj;
	</div><img src='../img/loader.gif' />
	<br>
	<p style="color:#2980B9">Subiendo imagen de publcidad y datos</p>	
</center> 
	
	<h3>Modificar Usuarios</h3>
	<hr/>
	<form  method="post" onsubmit="showLoading()">
		<?php
		if (isset($_POST["publicar"])) {
			if ($_POST["nombre"] != '' && $_POST["email"] != '' && $_POST["contra"] != '' && $_POST["recontra"] != '') {
				$data = Revisar_Email($_POST["email"]);
				if ($data != "si") {
					if ($_POST["contra"] == $_POST["recontra"]) {
						$nombre = $_POST["nombre"];
						$email = $_POST["email"];
						$contra = $_POST["contra"];					
						$link = Conectarse();
						$sql = "UPDATE `usuarios` SET `nombre`= '$nombre' ,`email`='$email',`pass`='$contra' WHERE id = $id";
						mysql_query($sql, $link);																		
					} else {
						echo "<span class='error'>Lo sentimos, las contraseñas no coinciden.</span>";
					}
				} else {
					echo "<span class='error'>Lo sentimos, el email ya se encuentra registrado.</span>";
				}
			} else {
				echo "<span class='error'>Lo sentimos, todos los datos deben ser completados para publicar el anuncio.</span>";
			}
		}
		?>		
		<input type="text" name="nombre" placeholder="Nombre de Agencia" value="<?php echo isset($_POST["nombre"]) ? $_POST["nombre"] : $dataUser["nombre"]  ?>"/>
		<input type="text" name="email" placeholder="Email" value="<?php echo isset($_POST["email"]) ? $_POST["email"] : $dataUser["email"]  ?>"/>
		<input type="text" name="contra" class="left" style="width:49%" placeholder="Contraseña" value="<?php echo isset($_POST["contra"]) ? $_POST["contra"] : $dataUser["pass"]  ?>"/>
		<input type="text" name="recontra" class="right"  style="width:49%" placeholder="Repetir Contraseña" value="<?php echo isset($_POST["recontra"]) ? $_POST["recontra"] : $dataUser["pass"]  ?>"/>				
		<button onclick="window.location.back()" class="button left" style="background:#333">VOLVER</button>
		<input type="submit" class="button right" name="publicar" value="MODIFICAR CUENTA"/>			
	</form>
</div>