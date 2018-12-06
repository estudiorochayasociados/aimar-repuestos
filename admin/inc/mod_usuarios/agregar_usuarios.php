<div class="col-md-12">
	<div class="main-content blog">
		<h3>Modificar usuario</h3>
		<span class="line-seperator"></span>
		<div class="row">
			<form method="post" class="form-group"  enctype="multipart/form-data" onsubmit="showLoading()">
				<?php
				if (isset($_POST["enviar"])) { 
					$emailRevisar = Revisar_Email("usuarios", "email", $_POST["email"]);
					if ($emailRevisar != "si" || $_POST["email"] == $_POST["email"] ) {
						$nombre = $_POST["nombre"];
						$empresa = $_POST["empresa"];
						$email = $_POST["email"];
						$dni = $_POST["dni"];
						$pass = $_POST["password1"];
						$localidad = $_POST["localidad"];
						$provincia = $_POST["provincia"];
						$domicilio = $_POST["domicilio"];
						$descuento = $_POST["descuento"];
						$vendedor = $_POST["vendedor"];
						$telefono = $_POST["telefono"];

						$sql = "
						INSERT INTO usuarios
						(`nombre`,`empresa`,`email`,`pass`,`cuit`,`direccion`,`vendedor`,`descuento`,`telefono`,`localidad`,`provincia`,`invitado`)
						VALUES ('$nombre','$empresa','$email','$pass','$dni','$domicilio','$vendedor','$descuento','$telefono','$localidad','$provincia',1)";

						$link = Conectarse();
						$r = mysqli_query($link,$sql); 
					} else {
						echo "<div class='alert alert-danger col-md-12'>Lo sentimos el correo electrónico ya existe.</div>";
					} 
				}
				?>
				<label class="col-md-3">Nombre:
					<br />
					<input class="form-control" required type="text" onkeypress="return textonly(event);"   name="nombre" placeholder="Nombre" value="<?php echo isset($_POST["nombre"]) ? $_POST["nombre"] : '' ?>"  />
				</label>
				<label class="col-md-3">Empresa:
					<br />
					<input class="form-control"  type="text" onkeypress="return textonly(event);"  name="empresa" placeholder="empresa" value="<?php echo isset($_POST["empresa"]) ? $_POST["empresa"] : '' ?>"  />
				</label>
				<label class="col-md-3">Descuento:
					<br />
					<input class="form-control"  required type="number" onkeypress="return isNumberKey(event)"   name="descuento" placeholder="descuento" value="<?php echo isset($_POST["descuento"]) ? $_POST["descuento"] : '' ?>"  />
				</label>
				<label class="col-md-3">Vendedor:
					<br />
					<input class="form-control"  required type="text"   name="vendedor" placeholder="vendedor" value="<?php echo isset($_POST["vendedor"]) ? $_POST["vendedor"] : '' ?>"  />
				</label>
				<label class="col-md-6">DNI / CUIT:
					<br />
					<input class="form-control" required type="text" name="dni" placeholder="dni" value="<?php echo isset($_POST["dni"]) ? $_POST["dni"] : '' ?>" />
				</label>
				<label class="col-md-6">E-mail:
					<br />
					<input class="form-control" required type="email" name="email" placeholder="E-mail" value="<?php echo isset($_POST["email"]) ? $_POST["email"] : '' ?>" />
				</label>
				<label class="col-md-6">Provincia
					<br/>
					<input class="form-control"  type="text" name="provincia" placeholder="Provincia" value="<?php echo isset($_POST["provincia"]) ? $_POST["provincia"] : '' ?>"  />
				</label>
				<label class="col-md-6">Localidad
					<br/> 
					<input class="form-control"  type="text" name="localidad" placeholder="Localidad" value="<?php echo isset($_POST["localidad"]) ? $_POST["localidad"] : '' ?>"  />
				</label> 
				<label class="col-md-12">Domicilio:
					<br />
					<input class="form-control"  type="text" name="domicilio" placeholder="Domicilio" value="<?php echo isset($_POST["domicilio"]) ? $_POST["domicilio"] : '' ?>"  />
				</label>
				<label class="col-md-6">Teléfono con característica:
					<br />
					<input class="form-control"  type="text" name="telefono" placeholder="011 4959..." onkeypress="return isNumberKey(event)" value="<?php echo isset($_POST["telefono"]) ? $_POST["telefono"] : '' ?>"  />
				</label> 
				<label class="col-md-6">Contraseña:
					<br />
					<input class="form-control" type="text" name="password1"   value="<?php echo isset($_POST["password1"]) ? $_POST["password1"] : '' ?>"  placeholder="Password" required/>
				</label> 			 
				<div class="clearfix"></div><br/>
				<div class="col-md-6">
					<input type="submit" class="btn btn-success" name="enviar" value="Modificar mis datos >" />
				</div>
			</form>
		</div>
		<div class="clearfix">
			<br />
			<br />
		</div>
	</div>
</div>