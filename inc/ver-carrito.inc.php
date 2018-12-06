<?php
$descuentoSacar = isset($_GET["descuento"]) ? $_GET["descuento"] : '';
$_SESSION["envioTipo"] = isset($_SESSION["envioTipo"]) ? $_SESSION["envioTipo"] : '';
$_SESSION["envio"] = isset($_SESSION["envio"]) ? $_SESSION["envio"] : '';
$_SESSION["envioDomSuc"] = isset($_SESSION["envioDomSuc"]) ? $_SESSION["envioDomSuc"] : '';

if($_SESSION["envio"] == ''){
  $displockEnvio = "block";
} else {
  $displockEnvio = "none";
}

if (empty($_SESSION["carrito"])) {
  headerMove(BASE_URL."/productos");
}

$codPedido = substr(md5(uniqid(rand())), 0, 15);
$finalizar = isset($_GET["finalizar"]) ? $_GET["finalizar"] : '';
$pago = isset($_GET["pago"]) ? $_GET["pago"] : '';
$_SESSION["codcompra"] = rand(1,999999999);

$asunto = "Nueva compra de productos desde la web";
$receptor = EMAIL; 
$asuntoUsuario = "¡Gracias por tu compra!";
$bancos = Contenido_TraerPorId("bancos");
$datosBancarios = $bancos[1];
$error = 0;
?>

<div>
  <h3 class="mb-20 mt-0"> Carrito de compra</h3>
</div>
<table class="table table-bordered table-striped">
  <thead>
    <th>Compra N° <?php echo $_SESSION["codcompra"]; ?></th>
    <th>Cantidad</th>
    <th>Precio unidad</th>
    <th>Precio total</th>
    <th></th>
  </thead>
  <?php

  $eliminar = isset($_GET["eliminar"]) ? $_GET["eliminar"] : '';
  if ($eliminar != '') {
    if(count($_SESSION["carrito"]) == 1){
      unset($_SESSION["envioTipo"]);
      unset($_SESSION["envio"]);
      unset($_SESSION["envioDomSuc"]);
    }
    unset($_SESSION["carrito"][$eliminar]);
    headerMove(BASE_URL."/carrito");
  }

  $contaCarrito = count($_SESSION["carrito"]);
  end($_SESSION["carrito"]);
  $contaCarrito = key($_SESSION["carrito"]);
  $precioFinal = 0;
  $carroFinal = '';
  $codigoDescuento = isset($_SESSION["codigoDescuento"]) ? $_SESSION["codigoDescuento"] : '';
   for ($i = 0; $i<= $contaCarrito; $i++) {
    if (isset($_SESSION["carrito"][$i])) {
      @$carrito = explode("|", $_SESSION["carrito"][$i]);
      $dataProducto = Productos_TraerXId($carrito[0]);

      $pesoProducto = Rubro_TraerPorCod($dataProducto["rubro"]);
      @$peso += $pesoProducto["peso_rubros"] *$carrito[1];
      $moneda = "ARS";

      if($_SESSION["descuento"] == 0){
       $precio = ($dataProducto["precio"]);
       $precio = number_format($precio, 2, '.', '');
       $precioTotal = $precio * $carrito[1];
       $precioTotal = number_format($precioTotal, 2, '.', '');
       $precioFinal = $precioFinal + $precioTotal;
       $precioFinal = number_format($precioFinal, 2, '.', '');
     } else {
      $precio = ($dataProducto["precio"]*0.79)-(($dataProducto["precio"]*$_SESSION["descuento"])/100);
      $precio = number_format($precio, 2, '.', '');
      $precioTotal = $precio * $carrito[1];
      $precioTotal = number_format($precioTotal, 2, '.', '');
      $precioFinal = $precioFinal + $precioTotal;
      $precioFinal = number_format($precioFinal, 2, '.', '');        
    }


    $carroFinal .= "<tr><td>" . $dataProducto["descripcion"] . "  (".$dataProducto["rubro"]."/".$dataProducto["codigo_para_web"].")</td><td>" . $carrito[1] . "</td><td>$" . $precio . "</td><td>$" . $precioTotal . "</td></tr>";
    ?>

    <td>
      <b><?php echo $dataProducto["codigo_para_web"] ?></b> | <?php echo $dataProducto["descripcion"] ?>
    </td>
    <td>
      <?php echo $carrito[1] ?>
    </td>
    <td>
      <?php echo "$" . $precio ?>
    </td>
    <td>
      <?php echo "$" . $precioTotal ?>
    </td>
    <td>
      <a href="carrito.php?eliminar=<?php echo $i ?>"><i class="fa fa-close"></i></a>
    </td>
  </tr>
  <?php
}
}

$precioEnvio = '';

if ($peso <= 1) {
  $precioEnvioDomicilio = Precio_Envio(1,"dom");
  $precioEnvioSucursal = Precio_Envio(1,"suc");
} elseif ($peso <= 3) {
  $precioEnvioDomicilio = Precio_Envio(3,"dom");
  $precioEnvioSucursal = Precio_Envio(3,"suc");
} elseif ($peso <= 5) {
  $precioEnvioDomicilio = Precio_Envio(5,"dom");
  $precioEnvioSucursal = Precio_Envio(5,"suc");
} elseif ($peso <= 10) {
  $precioEnvioDomicilio = Precio_Envio(10,"dom");
  $precioEnvioSucursal = Precio_Envio(10,"suc");
} elseif ($peso <= 15) {
  $precioEnvioDomicilio = Precio_Envio(15,"dom");
  $precioEnvioSucursal = Precio_Envio(15,"suc");
} elseif ($peso <= 20) {
  $precioEnvioDomicilio = Precio_Envio(20,"dom");
  $precioEnvioSucursal = Precio_Envio(20,"suc");
} elseif ($peso <= 25) {
  $precioEnvioDomicilio = Precio_Envio(25,"dom");
  $precioEnvioSucursal = Precio_Envio(25,"suc");
} elseif ($peso <= 35) {
  $precioEnvioDomicilio = Precio_Envio(35,"dom");
  $precioEnvioSucursal = Precio_Envio(35,"suc");
} elseif ($peso <= 45) {
  $precioEnvioDomicilio = Precio_Envio(45,"dom");
  $precioEnvioSucursal = Precio_Envio(45,"suc");
} 
$ivaTotal = 0;
$precioFinal = $ivaTotal + $precioFinal;

if (isset($_POST["envio"])) {
  $envioExplotado = explode("|", $_POST["envio"]);
  $envioFinal = $envioExplotado[0];
  @$_SESSION["envioTipo"] = $envioExplotado[1];
  @$_SESSION["envioDomSuc"] = $envioExplotado[2];
  @$_SESSION["envio"] = $envioFinal;
  $displockEnvio = "none";
}

if($_SESSION["envio"] != ''){
  if($precioEnvioDomicilio == $_SESSION["envio"] || $precioEnvioSucursal == $_SESSION["envio"]){
  } else {
    if($_SESSION["envioDomSuc"] == 0) 
    {
      $_SESSION["envio"] = $precioEnvioSucursal;
    }
    elseif($_SESSION["envioDomSuc"] == 1){
      $_SESSION["envio"] = $precioEnvioDomicilio;
    }
    elseif($_SESSION["envioDomSuc"] == 2)
    {
      $_SESSION["envio"] = 0;
    }
  }
}

if ($peso <= 45) { 
 ?>
 <div id="formEnvio" class="alert alert-warning animated fadeIn"
 style="display: <?php echo $displockEnvio ?>">
 <b>Elegí el tipo de envío para tus productos: </b><i style="float:right;font-size:12px">* Seleccionar la mejor opción y presionar Finalizar Carrito</i><br/>
 <form method="post">
  <select name="envio" class="form-control" id="envio" onchange="this.form.submit()">
    <option value="" selected disabled>Elegir envío</option>
    <option value="<?php echo $precioEnvioSucursal; ?>|Retiro en sucursal de Correo Argentino|0" <?php if (isset($_POST["envio"])) { if ($_POST["envio"] == $precioEnvioSucursal) { echo "selected"; }        } ?>>
      Retiro en sucursal de Correo Argentino $<?php echo $precioEnvioSucursal ?>
    </option>
    <option value="<?php echo $precioEnvioDomicilio ?>|Entrega a domicilio por Correo Argentino|1" <?php if (isset($_POST["envio"])) { if ($_POST["envio"] == $precioEnvioDomicilio) { echo "selected"; }    } ?>>
      Entrega a domicilio por Correo Argentino $<?php echo $precioEnvioDomicilio ?>
    </option> 
    <option value="0|Retiro en San Francisco Córdoba|2" <?php if (isset($_POST["envio"])) { if ($_POST["envio"] == "0|Retiro en San Francisco Córdoba") { echo "selected"; }} ?>>
      Retiro en Sucursal San Francisco Córdoba
    </option>
    <?php if($precioFinal >= 500) { ?>
      <option value="0|Envío gratis a domicilio de San Francisco Córdoba|2" <?php if (isset($_POST["envio"])) { if ($_POST["envio"] == "0|Envío gratis a domicilio de San Francisco Córdoba") { echo "selected"; }} ?> style=" font-weight:bold;">
        <b>Envío gratis a domicilio de San Francisco Córdoba
        </option> 
      <?php } ?>
      <option value="0|Coordinar con vendedor|2" <?php if (isset($_POST["envio"])) { if ($_POST["envio"] == "0|Coordinar con vendedor") { echo "selected"; }} ?>>
        Coordinar con vendedor
      </option>        
    </select>
  </form>
</div>
<?php
} else {
  @$_SESSION["envioTipo"] = "Envío especial por cuenta del cliente";
  @$_SESSION["envio"] = "0";
  ?>
  <div id="formEnvio" class="alert alert-danger animated fadeIn">
    Tu pedido necesita ENVÍO ESPECIAL debido a su gran peso, debemos contactarnos con un transporte que pueda realizar tu envío.
  </div>
  <?php
}
?>

<?php
if (!is_numeric($_SESSION["envio"])) {
  $error = 1;
} 
?>  

<tr>
  <td><b>Tipo de envío: <?php echo $_SESSION["envioTipo"]; ?></b></td>
  <td></td>
  <td></td>
  <td>
    <?php
    if (isset($_SESSION["envio"])) {
      if ($_SESSION["envio"] != '') {
        if ($_SESSION["envio"] === 0) {
         echo "Gratis";
       } else {
         echo "$" . $_SESSION["envio"];
       }
     }
   }
   ?>
 </td>
 <td><a href="#" onclick="$('#formEnvio').show()"><i class="fa fa-refresh"></i></a></td>
</tr>

<tr>
  <td><b>TOTAL DE LA COMPRA</b></td>
  <td></td>
  <td></td>
  <td id="precioFinalFinal"><b>$<?php echo @(($precioFinal - $descuento) + $_SESSION["envio"]); ?></b></td>
  <td></td>
</tr>
</table>

<?php 
$displayCodigo = 'block';

if(isset($_POST["btn_codigo"])) {
 $codigo = isset($_POST["codigoDescuento"]) ? $_POST["codigoDescuento"] : '';
 if($codigo != '') {
  $dataCodigo = Buscar_Codigo_Descuento($codigo);
  if($dataCodigo[0] != '') {
    if($precioFinal >= $dataCodigo["minimo"]) {
      $_SESSION["descuento"] = $dataCodigo;
      if($dataCodigo["tipo"] == 0) {
       ?>
       <span class="alert alert-success" style="display: block">¡Excelente! tenes un<? echo $dataCodigo["descuento"] ?>% de descuento en tus compras.</span>
       <div class="clearfix"></div>
       <?php
       headerMove(BASE_URL."/carrito");
     } else {
       ?>
       <span class="alert alert-success" style="display: block">¡Excelente! tenes un descuento de $<? echo $dataCodigo["descuento"] ?> pesos en tus compras.</span>
       <div class="clearfix"></div>
       <?php
       headerMove(BASE_URL."/carrito");
     }
   } else {
    ?><span class="alert alert-danger" style="display: block">Lo sentimos este cupón es para compras mayores a $<? echo $dataCodigo["minimo"] ?> pesos en tus compras.</span><?php
  }
}
} 
}
?>
<?php 
if(@!isset($_SESSION["descuento"]) || $_SESSION["descuento"] == '') { 
 if(@$_SESSION["descuento"]["codigo"] == '') {
  ?>
  <form method="post" class="row" style="display: none">
    <div class="col-md-6 text-right">
      <p style="margin-top: 7px"><b>¿Tenés algún código de descuento para tus compras?</b></p>
    </div>
    <div class="col-md-4">
      <input type="text" name="codigoDescuento" class="form-control" placeholder="CÓDIGO DE DESCUENTO">
    </div>
    <div class="col-md-2">
      <input type="submit" value="USAR CÓDIGO" name="btn_codigo" class="btn btn-info" />
    </div>
  </form>
  <?php 
}
} 
?> 

<a href="<?php echo BASE_URL ?>/productos" class="btn btn-info pull-left hidden-xs hidden-sm">
  <i class="fa fa-shopping-cart"></i> Seguir comprando
</a>
<a href="<?php echo BASE_URL ?>/checkout/crear-usuario" class="btn btn-success pull-right"<?php if ($error == 1) { echo 'data-toggle="tooltip" alt="ELEGÍ TU FORMA DE ENVÍOS" title="ELEGÍ TU FORMA DE ENVÍOS" disabled onclick="return false;"'; } ?>>
  <i class="fa fa-check"></i> Proceder a pagar tu carrito
</a>

<?php
$precioFinal = @(($precioFinal - $descuento) + $_SESSION["envio"]);
$_SESSION["precioFinal"] = number_format($precioFinal, 2, '.', '');
$_SESSION["carritoFinal"] = $carroFinal;
$_SESSION["carritoFinal"] .= "<tr><td><b>" . $_SESSION["envioTipo"] . "</b></td><td></td><td></td><td><b>$" . $_SESSION["envio"] . "</b></td></tr>";
$_SESSION["carritoFinal"] .= "<tr><td><b>TOTAL DE LA COMPRA</b></td><td></td><td></td><td><b>$$precioFinal</b></td></tr>";
?> 

