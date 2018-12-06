<div ><h3 class="mb-20 mt-0 pull-left">Registrate para la compra</h3>
  <a href="<?php echo BASE_URL ?>/inc/login.inc.php"  data-title="Iniciar Sesión" class="linkModal pull-right btn btn-info hidden-xs hidden-sm">Ya tenés tu cuenta de cliente, <b>ingresá ahora</b></a></div>
  <div class="clearfix"></div>

  <nav class="navbar navbar-inverse navbar-fixed-bottom text-center hidden-md hidden-lg" style="box-shadow: -10px 10px 10px rgba(0,0,0,0.4)">
    <div class="row">
      <a href="<?php echo BASE_URL ?>/inc/login.inc.php"  data-title="Iniciar Sesión" class="linkModal btn btn-lg btn-block btn-primary">Ya tenés tu cuenta de cliente <b class='btn btn-sm btn-success'>ingresá ahora</b></a>
    </div>  
  </nav>

  <?php
  if(isset($_SESSION["user"])) {
    headerMove(BASE_URL."/checkout/finalizar-carrito");  
  }

  if (isset($_POST["registrarmeBtn"])) {
    $nombre = antihack_mysqli(isset($_POST["nombre"]) ? $_POST["nombre"] : '');
    $apellido = antihack_mysqli(isset($_POST["apellido"]) ? $_POST["apellido"] : '');
    $nombreFinal = $nombre." ".$apellido;
    $email = antihack_mysqli(isset($_POST["email"]) ? $_POST["email"] : '');
    $telefono = antihack_mysqli(isset($_POST["telefono"]) ? $_POST["telefono"] : '');
    $postal = antihack_mysqli(isset($_POST["postal"]) ? $_POST["postal"] : '');
    $direccion = antihack_mysqli(isset($_POST["direccion"]) ? $_POST["direccion"] : '');
    $localidad = antihack_mysqli(isset($_POST["localidad"]) ? $_POST["localidad"] : '');
    $provincia = antihack_mysqli(isset($_POST["provincia"]) ? $_POST["provincia"] : '');
    $crear = antihack_mysqli(isset($_POST["crear"]) ? $_POST["crear"] : '0');
    $password1 = antihack_mysqli(isset($_POST["password1"]) ? $_POST["password1"] : '');
    $password2 = antihack_mysqli(isset($_POST["password2"]) ? $_POST["password2"] : '');
    $cuit = antihack_mysqli(isset($_POST["cuit"]) ? $_POST["cuit"] : '');

    echo "<script>fbq('track', 'CompleteRegistration');</script>";

    if($crear == 1) {
      if (!empty($nombre) && !empty($password1) && !empty($password2) && !empty($email)) {
        if ($password1 == $password2) {
          $emailRevisar = Revisar_Email("usuarios", "email", $_POST["email"]);
          $revision = @count($emailRevisar);
          if ($revision == 0) {
            $array = array(
              'properties' => array(
                array('property' => 'email','value' => $email),
                array('property' => 'firstname','value' =>  $nombre),
                array('property' => 'lastname','value' =>  $apellido),
                array('property' => 'phone','value' => $telefono)
              )
            );

            $url = "https://api.hubapi.com/contacts/v1/contact";
            Hubspot_Dev($array,$url,"NOTES");

            $sql = "INSERT INTO `usuarios`
            (`nombre`, `email`, `pass`, `telefono`, `cuit`, `postal`,`direccion`,`localidad`, `provincia`, `inscripto`,`invitado`) 
            VALUES
            ('$nombreFinal','$email', '$password1','$telefono','$cuit', '$postal', '$direccion','$localidad','$provincia', NOW(), '$crear')";
            $link = Conectarse();
            $r = mysqli_query($link,$sql);
            RLogin($email, $password1);
            if($r) {
              headerMove(BASE_URL."/checkout/finalizar-carrito");
            }
          } else {
            echo "<div class='alert alert-danger'>Lo sentimos el correo electrónico ya existe.</div>";
          }
        } else {
          echo "<div class='alert alert-danger'>Lo sentimos las contraseñas no coindicen.</div>";
        }
      } else {
        echo '<div class="alert alert-danger animated fadeInDown" id="" role="alert">Te pedimos disculpas , pero no podemos registrate porque son necesarios todos los datos.</div>';
      }
    }  else {
     if (!empty($nombre) && !empty($email)) {
      $emailRevisar = Revisar_Email("usuarios", "email", $email);
      $revision = @count($emailRevisar);
      if ($revision == 0) {
        $sql = "INSERT INTO `usuarios`
        (`nombre`, `email`,   `telefono`, `cuit`, `postal`,`localidad`, `provincia`, `inscripto`,`invitado`) 
        VALUES
        ('$nombreFinal','$email',  '$telefono', '$cuit','$postal','$localidad','$provincia', NOW(), '$crear')";
        $link = Conectarse();
        $r = mysqli_query($link,$sql);
        $idUsuario=mysqli_insert_id($link);
        $_SESSION["user"] = Usuario_TraerPorId($idUsuario);  
        if($r) {
          headerMove(BASE_URL."/checkout/finalizar-carrito");
        }
      } else {
        $_SESSION["user"] = Usuario_TraerPorId($emailRevisar["id"]);  
        headerMove(BASE_URL."/checkout/finalizar-carrito");
      }

      $array = array(
        'properties' => array(
          array('property' => 'email','value' => $email),
          array('property' => 'firstname','value' =>  $nombre),
          array('property' => 'lastname','value' =>  $apellido),
          array('property' => 'phone','value' => $telefono)
        )
      );

      $url = "https://api.hubapi.com/contacts/v1/contact";
      Hubspot_Dev($array,$url,"NOTES");

    } else {
      echo '<div class="alert alert-danger animated fadeInDown" id="" role="alert">Te pedimos disculpas , pero no podemos registrate porque son necesarios todos los datos.</div>';
    }
  } 
}

?>
<form method="post" >
  <div class="row">
    <div class="col-md-6 col-xs-6">Nombre:<br/>
      <input class="form-control  mb-10" type="text" value="<?php echo isset($_POST["nombre"]) ? $_POST["nombre"] : '' ?>" placeholder="Escribir nombre" name="nombre" required/>
    </div>
    <div class="col-md-6 col-xs-6">Apellido:<br/>
      <input class="form-control  mb-10" type="text" value="<?php echo isset($_POST["apellido"]) ? $_POST["apellido"] : '' ?>" placeholder="Escribir apellido" name="apellido" required/>
    </div>
    <div class="col-md-6 col-xs-6">Email:<br/>
      <input class="form-control  mb-10" type="email" value="<?php echo isset($_POST["email"]) ? $_POST["email"] : '' ?>" placeholder="Escribir email" name="email" required/>
    </div>     
    <div class="col-md-6 col-xs-6">Teléfono:<br/>
      <input class="form-control  mb-10" type="text" value="<?php echo isset($_POST["telefono"]) ? $_POST["telefono"] : '' ?>" placeholder="Escribir telefono"  name="telefono" required/>
    </div>  
    <div class="col-md-6 col-xs-6">Provincia:<br/>
      <select class="form-control" name="provincia" id="provincia"  required>
        <option></option>
        <?php Provincias_Read_Front(); ?>
      </select>
    </div> 
    <div class="col-md-6 col-xs-6">Localidad:<br/>
      <select class="form-control" name="localidad" id="localidad"  required>            
      </select>
    </div>
    <div class="col-md-7 col-xs-7">Dirección:<br/>
      <input class="form-control  mb-10" type="text" value="<?php echo isset($_POST["direccion"]) ? $_POST["direccion"] : '' ?>" placeholder="Escribir dirección" name="direccion" required/>
    </div>
    <div class="col-md-3 col-xs-3">C. Postal:<br/>
      <input class="form-control  mb-10" type="text" value="<?php echo isset($_POST["postal"]) ? $_POST["postal"] : '' ?>" placeholder="Escribir código postal"  name="postal"  required/>
    </div>   
    <div class="col-md-2 col-xs-2"><br/>
     <input type="checkbox" name="postal" value="zona rural sin cp"> Zona rural sin cp
   </div>  
   <label  class="col-md-12 col-xs-12 mt-10 mb-10 crear" style="font-size:16px">
    <input type="checkbox" name="crear" value="1" onchange="$('.password').slideToggle()"> ¿Deseas crear una cuenta de usuario y dejar tus datos grabados para la próxima compra?
  </label>       
  <div class="col-md-6 col-xs-6 password" style="display: none;">Contraseña:<br/>
    <input class="form-control  mb-10" type="password" value="<?php echo isset($_POST["password1"]) ? $_POST["password1"] : '' ?>" placeholder="Escribir password"  name="password1" />
  </div>
  <div class="col-md-6 col-xs-6 password" style="display: none;">Repetir Contraseña:<br/>
    <input class="form-control  mb-10" type="password" value="<?php echo isset($_POST["password2"]) ? $_POST["password2"] : '' ?>" placeholder="Escribir repassword"  name="password2" />
  </div>  

  <label  class="col-md-12 col-xs-12 mt-10 mb-10" style="font-size:16px">
    <input type="checkbox" name="factura" value="0" onchange="$('.factura').slideToggle()"> Solicitar FACTURA A
  </label>       
  <div class="col-md-12 col-xs-12 factura" style="display: none;">CUIT:<br/>
    <input class="form-control  mb-10" type="number" value="<?php echo isset($_POST["cuit"]) ? $_POST["cuit"] : '' ?>" placeholder="Escribir CUIT"  name="cuit"  />
  </div>         
  <div class="col-md-12 col-xs-12 mb-50">
    <input class="btn btn-success" type="submit" value="¡Finalizar la compra!" name="registrarmeBtn" />
  </div>      
</div>
</form>