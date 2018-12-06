<div class="col-md-12">
	<div class="main-content blog">
		<h3>Modificar usuario</h3>
		<span class="line-seperator"></span>
		<div class="row">
			<?php
			$id = $_GET["id"];
			$data = Usuario_TraerPorId($id);
			$img = isset($data["imagen"]) ? $data["imagen"] : 'img/sin_imagen_perfil.png';
			?>
			<form method="post" class="form-group"  enctype="multipart/form-data" onsubmit="showLoading()">
				<?php
				if (isset($_POST["enviar"])) { 
					$emailRevisar = Revisar_Email("usuarios", "email", $_POST["email"]);
					if ($emailRevisar != "si" || $_POST["email"] == $data["email"] ) {

						$nombre = $_POST["nombre"];
						$empresa = $_POST["empresa"];
						$email = $_POST["email"];
						$cuit = $_POST["cuit"];
						$pass = $_POST["password1"];
						$localidad = $_POST["localidad"];
						$provincia = $_POST["provincia"];
						$postal = $_POST["postal"];						
						$domicilio = $_POST["domicilio"];
						$descuento = $_POST["descuento"];
						$telefono = $_POST["telefono"];

						$sql = "
						UPDATE `usuarios` 
						SET `nombre`= '$nombre',
						`empresa`= '$empresa',
						`email`= '$email',
						`pass`='$pass',
						`cuit`='$cuit',
						`direccion`= '$domicilio',
						`descuento`= '$descuento',
						`telefono`= '$telefono',
						`localidad`= '$localidad',
						`postal`= '$postal',
						`provincia`= '$provincia'
						WHERE `id`= '$id'";

						$link = Conectarse();
						$r = mysqli_query($link,$sql); 
						headerMove(BASE_URL."/admin/index.php?op=modUsuarios&id=".$id);
					} else {
						echo "<div class='alert alert-danger col-md-12'>Lo sentimos el correo electrónico ya existe.</div>";
					} 
				}
				?>
				<label class="col-md-4">Nombre:
					<br />
					<input class="form-control" required type="text" onkeypress="return textonly(event);"   name="nombre" placeholder="Nombre" value="<?php echo isset($data["nombre"]) ? $data["nombre"] : '' ?>"  />
				</label>
				<label class="col-md-4">Empresa:
					<br />
					<input class="form-control"  type="text" onkeypress="return textonly(event);"  name="empresa" placeholder="empresa" value="<?php echo isset($data["empresa"]) ? $data["empresa"] : '' ?>"  />
				</label>
				<label class="col-md-4">Aplicar descuento (%):
					<br />
					<input class="form-control" required type="number" onkeypress="return isNumberKey(event)"   name="descuento" placeholder="descuento" value="<?php echo isset($data["descuento"]) ? $data["descuento"] : '' ?>"  />
				</label>
				<label class="col-md-6">CUIT:
					<br />
					<input class="form-control" required type="text" name="cuit" placeholder="cuit" value="<?php echo isset($data["cuit"]) ? $data["cuit"] : '' ?>" />
				</label>
				<label class="col-md-6">E-mail:
					<br />
					<input class="form-control" required type="email" name="email" placeholder="E-mail" value="<?php echo isset($data["email"]) ? $data["email"] : '' ?>" />
				</label>
				<label class="col-md-3">Provincia
					<br/>
					<input class="form-control"  type="text" name="provincia" placeholder="Provincia" value="<?php echo isset($data["provincia"]) ? $data["provincia"] : '' ?>"  />
				</label>
				<label class="col-md-3">Localidad
					<br/> 
					<input class="form-control"  type="text" name="localidad" placeholder="Localidad" value="<?php echo isset($data["localidad"]) ? $data["localidad"] : '' ?>"  />
				</label> 
				<label class="col-md-3">Código Postal
					<br/> 
					<input class="form-control"  type="text" name="postal" placeholder="postal" value="<?php echo isset($data["postal"]) ? $data["postal"] : '' ?>"  />
				</label> 
				<label class="col-md-3">Domicilio:
					<br />
					<input class="form-control"  type="text" name="domicilio" placeholder="Domicilio" value="<?php echo isset($data["direccion"]) ? $data["direccion"] : '' ?>"  />
				</label>
				<label class="col-md-6">Teléfono con característica:
					<br />
					<input class="form-control"  type="text" name="telefono" placeholder="011 4959..." onkeypress="return isNumberKey(event)" value="<?php echo isset($data["telefono"]) ? $data["telefono"] : '' ?>"  />
				</label> 
				<label class="col-md-6">Contraseña:
					<br />
					<input class="form-control" type="text" name="password1"   value="<?php echo isset($data["pass"]) ? $data["pass"] : '' ?>"  placeholder="Password" required/>
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