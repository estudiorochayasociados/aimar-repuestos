<?php
ob_start();
session_start();
$op = isset($_GET["op"]) ? $_GET["op"] : '';
include("../admin/dal/data.php");
if($op == 1) {
  $password = antihack_mysqli($_POST["password"]);
  $email = antihack_mysqli($_POST["email"]);
  if (!empty($password) && !empty($email)) {
    $data = RLogin($email, $password);  
    if($data == 0) {
      headerMove(BASE_URL."/checkout/finalizar-carrito");  
    }
  }
} else {  
  ?>
  <form method="post" id="formAjax" class="mt-0 pt-0" onsubmit="ajaxPost('<?php echo BASE_URL."/inc/login.inc.php?op=1"; ?>')">
    <div id="resultado" class="mt-10 mb-10" ></div>
    <div class="row">
      <div class="col-md-12 col-xs-12">Email:<br/>
        <input class="form-control mb-10" type="email" value="<?php echo isset($_POST["email"]) ? $_POST["email"] : '' ?>" placeholder="Escribir email" name="email" />
      </div>
      <div class="col-md-12 col-xs-12">Contraseña:<br/>
        <input class="form-control mb-10" type="password" value="<?php echo isset($_POST["password"]) ? $_POST["password"] : '' ?>" placeholder="Escribir contraseña"  name="password" />
      </div>
      <div class="col-md-12 col-xs-12 mt-10"> 
        <input class="btn btn-success" type="submit" value="Iniciar Sesión" name="ingresarBtn" />
      </div>      
    </div>
  </form>
<?php } ?>

<script type="text/javascript">
  function ajaxPost(url) {   
    console.log(url); 
    event.preventDefault();
    var form = $("#formAjax").serialize();
    $.ajax({method: "POST", url: url, data: form, dataType: "html",
      beforeSend: function() {
        $("#resultado").html("CARGANDO");
      },
      success: function(result){
        $("#resultado").html(result);
      }});        
    event.preventDefault();
  }
</script>