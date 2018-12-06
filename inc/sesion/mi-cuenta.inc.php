<div class="col-md-12 aLoad">
  <h1 class="titular"><i class="fa fa-caret-right"></i> Mi cuenta</h1>                
  <?php
  $data = Usuario_TraerPorId($_SESSION["user"]["id"]);
  if (isset($_POST["registrarmeBtn"])) {
    if (!empty($_POST["nombre"]) && !empty($_POST["password1"]) && !empty($_POST["password2"]) && !empty($_POST["email"])) {
      if ($_POST["password1"] == $_POST["password2"]) {
        if($data["email"] != $_POST["email"]) {
          $emailRevisar = Revisar_Email("usuarios", "email", $_POST["email"]);  
        } else {
          $emailRevisar = "no";
        }

        if ($emailRevisar != "si") {
          $id = $_SESSION['user']['id'];
          $nombre = $_POST["nombre"];
          $dni = $_POST["dni"];
          $email = $_POST["email"];
          $pass = $_POST["password1"];
          $telefono = $_POST["telefono"];
          $domicilio = $_POST["domicilio"];
          $localidad = $_POST["localidad"];
          $provincia = $_POST["provincia"];
          $postal = $_POST["postal"];

          $sql =  "
          UPDATE `usuarios`
          SET
          `nombre` = '$nombre',
          `email` = '$email',
          `pass` = '$pass',
          `dni` = '$dni',
          `postal` = '$postal',
          `telefono` = '$telefono',
          `direccion` = '$domicilio',
          `localidad` = '$localidad',
          `provincia` = '$provincia'
          WHERE `id` = '$id' ";

          $link = Conectarse();
          $r = mysqli_query($link, $sql);

          RLogin($email, $pass);

          echo '<div class="alert alert-success animated fadeInDown" id="" role="alert">Muchas gracias ' . strtoupper(strtoupper($nombre)) . ', se modificó exitosamente!.</div>';
          header("location: sesion.php?op=mi-cuenta");
        } else {
          echo "<div class='alert alert-danger'>Lo sentimos el correo electrónico ya existe.</div>";
        }
      } else {
        echo "<div class='alert alert-danger'>Lo sentimos las contraseñas no coindicen.</div>";
      }
    } else {
      echo '<div class="alert alert-danger animated fadeInDown" id="" role="alert">Te pedimos disculpas , pero no podemos enviar tu mensaje , porque son necesarios todos los datos.</div>';
    }
  }
  ?>
  <form method="post" autocomplete="off" class="formFilterMiCuenta">
    <div class="row">
     <label class="mb-20 col-md-12 col-xs-12">Nombre y Apellido: <i class="pull-right icon-form fa fa-user"></i>
      <input class="form-control" type="text" value="<?php echo isset($data["nombre"]) ? $data["nombre"] : '' ?>" placeholder="Escribir tu nombre" name="nombre" required/>
    </label> 
    <label class="mb-20 col-md-12 col-xs-12">Email: <i class="pull-right icon-form fa fa-envelope"></i>
      <input class="form-control" type="email" value="<?php echo isset($data["email"]) ? $data["email"] : '' ?>" placeholder="Escribir tu email" name="email" required/>
    </label> 
    <label class="mb-20 col-md-6 col-xs-12">Contraseña: <i class="pull-right icon-form fa fa-lock"></i>
      <input class="form-control" type="password" value="<?php echo isset($data["pass"]) ? $data["pass"] : '' ?>" placeholder="Escribir tu password"  name="password1" required/>
    </label>
    <label class="mb-20 col-md-6 col-xs-12">Repetir Contraseña: <i class="pull-right icon-form fa fa-lock"></i>
      <input class="form-control" type="password" value="<?php echo isset($data["pass"]) ? $data["pass"] : '' ?>" placeholder="Escribir tu repassword"  name="password2" required/>
    </label> 
     <label class="mb-20 col-md-6 col-xs-12">Dni / Cuil / Cuit: <i class="pull-right icon-form fa fa-list-alt"></i>
      <input class="form-control" type="text" value="<?php echo isset($data["dni"]) ? $data["dni"] : '' ?>" placeholder="Escribir tu dni"  onkeypress="return onlyNumbersDano(event)" name="dni" required/>
    </label>  
    <label class="mb-20 col-md-6 col-xs-12">Teléfono: <i class="pull-right icon-form fa fa-phone"></i>
      <input class="form-control" type="text" value="<?php echo isset($data["telefono"]) ? $data["telefono"] : '' ?>" placeholder="Escribir tu teléfono"  onkeypress="return onlyNumbersDano(event)" name="telefono" required/>
    </label>  
    <label class="mb-20 col-md-6 col-xs-12">Domicilio: <i class="pull-right icon-form fa fa-home"></i>
      <input class="form-control" type="text" value="<?php echo isset($data["direccion"]) ? $data["direccion"] : '' ?>" placeholder="Escribir tu direccion"  name="domicilio" required/>
    </label>
    <label class="mb-20 col-md-6 col-xs-12">Código Postal: <i class="pull-right icon-form fa fa-map-marker"></i>
      <input class="form-control" type="text" value="<?php echo isset($data["postal"]) ? $data["postal"] : '' ?>" placeholder="Escribir tu código postal"  name="postal" onkeypress="return onlyNumbersDano(event)" required/>
    </label>
    <label class="mb-20 col-md-6 col-xs-12">Provincia: <select class="pull-right form-control" name="provincia" placeholder="Escribir tu provincia" required>
              <option value="<?php echo isset($data["provincia"]) ? $data["provincia"] : '' ?>"><?php echo isset($data["provincia"]) ? $data["provincia"] : '' ?></option>
              <option value="Buenos Aires">Buenos Aires</option>
              <option value="Catamarca">Catamarca</option>
              <option value="Chaco">Chaco</option>
              <option value="Chubut">Chubut</option>
              <option value="Córdoba">Córdoba</option>
              <option value="Corrientes">Corrientes</option>
              <option value="Entre Ríos">Entre Ríos</option>
              <option value="Formosa">Formosa</option>
              <option value="Jujuy">Jujuy</option>
              <option value="La Pampa">La Pampa</option>
              <option value="La Rioja">La Rioja</option>
              <option value="Mendoza">Mendoza</option>
              <option value="Misiones">Misiones</option>
              <option value="Neuquén">Neuquén</option>
              <option value="Río Negro">Río Negro</option>
              <option value="Salta">Salta</option>
              <option value="San Juan">San Juan</option>
              <option value="San Luis">San Luis</option>
              <option value="Santa Cruz">Santa Cruz</option>
              <option value="Santa Fe">Santa Fe</option>
              <option value="Santiago del Estero">Santiago del Estero</option>
              <option value="Tierra del Fuego">Tierra del Fuego</option>
              <option value="Tucumán">Tucumán</option>
            </select>
    </label>
    <label class="mb-20 col-md-6 col-xs-12">Localidad: <i class="pull-right icon-form fa fa-map-marker"></i>
      <input class="form-control" type="text" value="<?php echo isset($data["localidad"]) ? $data["localidad"] : '' ?>" placeholder="Escribir tu localidad"  name="localidad" required />
    </label>
    <label class="col-md-12 col-xs-12"><br/>
      <input class="btn btn-success" type="submit" value="Modificar" name="registrarmeBtn" />
    </label>         
  </div>
</form>
</div>
<div class="clearfix"></div><br><br>
</div>