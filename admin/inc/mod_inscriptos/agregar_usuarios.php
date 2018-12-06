<div class="large-12 column">	
	<h3>Agregar Usuarios</h3>
	<hr/>
	<form  method="post">
		<?php
		if (isset($_POST["publicar"])) {
			if ($_POST["nombre"] != '' && $_POST["email"] != '' && $_POST["contra"] != '' && $_POST["recontra"] != '') {
				$data = Revisar_Email($_POST["email"]);
				if ($data != "si") {
					if ($_POST["contra"] == $_POST["recontra"]) {
						Insertar_Usuario($_POST["nombre"], $_POST["email"], $_POST["contra"]);																		
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
		<input type="text" name="nombre" placeholder="Nombre de Agencia" value="<?php echo isset($_POST["nombre"]) ? $_POST["nombre"] : ''  ?>"/>
		<input type="text" name="email" placeholder="Email" value="<?php echo isset($_POST["email"]) ? $_POST["email"] : ''  ?>"/>
		<input type="password" name="contra" class="left" style="width:49%" placeholder="Contraseña" value="<?php echo isset($_POST["contra"]) ? $_POST["contra"] : ''  ?>"/>
		<input type="password" name="recontra" class="right"  style="width:49%" placeholder="Repetir Contraseña" value="<?php echo isset($_POST["recontra"]) ? $_POST["recontra"] : ''  ?>"/>				
		<button onclick="window.location.back()" class="button left" style="background:#333">VOLVER</button>
		<input type="submit" class="button right" name="publicar" value="CREAR CUENTA"/>			
	</form>
</div>
