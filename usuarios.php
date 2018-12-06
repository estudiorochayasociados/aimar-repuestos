<?php
session_start();
if(!isset($_SESSION["carrito"]) ){
  $_SESSION["carrito"] = array();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php include("inc/header.inc.php"); ?> 
  <?php 
  if(!empty($_SESSION["user"]["id"])) {
    headerMove(BASE_URL."/sesion.php");  }
    ?>
    <title>Ingreso de Usuarios - Aimar Repuestos</title>  

    <script>
      fbq('track', 'Lead');
    </script>

  </head>
  <body>
    <div id="page">
      <header class="header">
        <?php include("inc/nav.inc.php"); ?>
      </header>

      <div class="page-hero">
        <div class="container">
          <div class="row">
            <div class="col-xs-12">
              <h1 class="page-title text-uppercase">
                INGRESO DE USUARIOS
              </h1>
            </div>
          </div>
        </div>
      </div>
      <div class="container cuerpoContenedor"> 
        <div class="col-md-5 mb-20">
          <div ><h3>Iniciar Sesión</h3></div>
          <?php
          if (isset($_POST["ingresarBtn"])) {
            $password = antihack_mysqli($_POST["password"]);
            $email = antihack_mysqli($_POST["email"]);
            if (!empty($password) && !empty($email)) {
              $data = RLogin($email, $password);  
              if($data == 1) {
                headerMove(BASE_URL."/sesion");  
              }
            }
          }  
          ?>
          <form method="post">
            <div class="row">
              <div class="col-md-12 col-xs-12">Email:<br/>
                <input class="form-control  mb-10" type="email" value="<?php echo isset($_POST["email"]) ? $_POST["email"] : '' ?>" placeholder="Escribir email" name="email" required/>
              </div>     
              <div class="col-md-12 col-xs-12">Contraseña:<br/>
                <input class="form-control  mb-10" type="password" value="<?php echo isset($_POST["password1"]) ? $_POST["password1"] : '' ?>" placeholder="Escribir contraseña"  name="password" />
              </div>
              <div class="col-md-12 col-xs-12"> 
                <input class="btn btn-success" type="submit" value="Iniciar Sesión" name="ingresarBtn" />
              </div>      
            </div>
          </form>
        </div>
        <div class="col-md-7">
          <div><h3>Registrarme</h3></div>
          <?php
          if (isset($_POST["registrarmeBtn"])) {

           $nombre = antihack_mysqli(isset($_POST["nombre"]) ? $_POST["nombre"] : '');
           $apellido = antihack_mysqli(isset($_POST["apellido"]) ? $_POST["apellido"] : '');
           $nombreFinal = $nombre." ".$apellido;
           $email = antihack_mysqli(isset($_POST["email"]) ? $_POST["email"] : '');
           $telefono = antihack_mysqli(isset($_POST["telefono"]) ? $_POST["telefono"] : '');
           $postal = antihack_mysqli(isset($_POST["postal"]) ? $_POST["postal"] : '');
           $localidad = antihack_mysqli(isset($_POST["localidad"]) ? $_POST["localidad"] : '');
           $provincia = antihack_mysqli(isset($_POST["provincia"]) ? $_POST["provincia"] : '');
           $crear = antihack_mysqli(isset($_POST["crear"]) ? $_POST["crear"] : '1');
           $password1 = antihack_mysqli(isset($_POST["password1"]) ? $_POST["password1"] : '');
           $password2 = antihack_mysqli(isset($_POST["password2"]) ? $_POST["password2"] : '');
           $cuit = antihack_mysqli(isset($_POST["cuit"]) ? $_POST["cuit"] : '');

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
              (`nombre`, `email`, `pass`, `telefono`, `cuit`,`postal`,  `localidad`, `provincia`, `inscripto`,`invitado`) 
              VALUES
              ('$nombreFinal','$email', '$password1','$telefono', '$cuit','$postal','$localidad','$provincia', NOW(), '$crear')";

              $link = Conectarse();
              $r = mysqli_query($link,$sql);
              RLogin($email, $password1);

              echo "<script>fbq('track', 'CompleteRegistration');</script>";

              if($r) {
                headerMove(BASE_URL."/sesion");
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
            <input class="form-control  mb-10" type="text" value="<?php echo isset($_POST["telefono"]) ? $_POST["telefono"] : '' ?>" placeholder="Escribir teléfono"  name="telefono" required/>
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
          <div class="col-md-6 col-xs-6">Dirección:<br/>
            <input class="form-control  mb-10" type="text" value="<?php echo isset($_POST["direccion"]) ? $_POST["direccion"] : '' ?>" placeholder="Escribir direccion" name="direccion" required/>
          </div>
         <div class="col-md-3 col-xs-3">C. Postal:<br/>
          <input class="form-control  mb-10" type="text" value="<?php echo isset($_POST["postal"]) ? $_POST["postal"] : '' ?>" placeholder="Escribir código postal"  name="postal"  required/>
        </div>  
        <div class="col-md-3 col-xs-3"><br/>
          <input type="checkbox" name="postal" value="zona rural sin cp"> Zona rural sin cp
        </div>    
        <div class="col-md-6 col-xs-6">Contraseña:<br/>
          <input class="form-control  mb-10" type="password" value="<?php echo isset($_POST["password1"]) ? $_POST["password1"] : '' ?>" placeholder="Escribir password"  name="password1" />
        </div>
        <div class="col-md-6 col-xs-6">Repetir contraseña:<br/>
          <input class="form-control  mb-10" type="password" value="<?php echo isset($_POST["password2"]) ? $_POST["password2"] : '' ?>" placeholder="Escribir repassword"  name="password2" />
        </div>  
        <label  class="col-md-12 col-xs-12 mt-10 mb-10" style="font-size:16px">
          <input type="checkbox" name="factura" value="0" onchange="$('.factura').slideToggle()"> Solicitar FACTURA A
        </label>       
        <div class="col-md-12 col-xs-12 factura" style="display: none;">CUIT:<br/>
          <input class="form-control  mb-10" type="number" value="<?php echo isset($_POST["cuit"]) ? $_POST["cuit"] : '' ?>" placeholder="Escribir CUIT"  name="cuit" />
        </div> 
        <div class="col-md-12 col-xs-12">
          <input class="btn btn-success" type="submit" value="Registrarme" name="registrarmeBtn" />
        </div>      
      </div>
    </form>
  </div>
  <div class="clearfix"></div><br><br>
</div>  
<?php include("inc/footer.inc.php"); ?>
</body>
</html>
<?php
@ob_end_flush();
?>