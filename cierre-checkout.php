<?php
session_start();
if (!isset($_SESSION["carrito"])) {
    $_SESSION["carrito"] = array();
}
$senalEnvio = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php include "inc/header.inc.php";?>
  <title>Finalizar tu carrito - Aimar Repuestos</title>
</head>
<body>
  <div id="page">
    <header class="header">
      <?php include "inc/nav.inc.php";?>
  </header>

  <div class="page-hero">
      <div class="container">
        <div class="row">
          <div class="col-xs-12">
            <h1 class="page-title text-uppercase">
              FINALIZAR TU CARRITO
          </h1>
      </div>
  </div>
</div>
</div>
<div class="container cuerpoContenedor">
  <div class="col-md-12">
    <?php

    $con = Conectarse_Mysqli();

    $pago         = isset($_GET["pago"]) ? $_GET["pago"] : '';
    $cupon        = isset($_GET["collection_id"]) ? $_GET["collection_id"] : '';
    $status       = isset($_GET["collection_status"]) ? $_GET["collection_status"] : '';
    $payment_type = isset($_GET["payment_type"]) ? $_GET["payment_type"] : '';
    $cod          = isset($_GET["cod"]) ? $_GET["cod"] : '';
    $error        = 0;

    $contacto       = Contenido_TraerPorId("contacto");
    $datosBancarios = Contenido_TraerPorId("datos bancarios");
    $carrito        = $_SESSION["carritoFinal"];

    if ($carrito == '') {
        headerMove(BASE_URL . "/tienda");
    }

    $descripcionHubspot = str_replace("<td>", "", $_SESSION["carritoFinal"]);
    $descripcionHubspot = str_replace("</td>", " ", $descripcionHubspot);
    $descripcionHubspot = str_replace("<tr>", "", $descripcionHubspot);
    $descripcionHubspot = str_replace("<b>", "", $descripcionHubspot);
    $descripcionHubspot = str_replace("</b>", "", $descripcionHubspot);
    $descripcionHubspot = str_replace("</tr>", "\n", $descripcionHubspot);

    echo "<script>fbq('track', 'Purchase');</script>";

    switch ($pago) {
// Tipo 1 transferencia - 2 tarjeta - 3 acordar con vendedor
    // Estado 0 pendiente de pago - 1 pago exitoso - 2 problemas con el pago - 3 enviado
        case 1:
        $_SESSION["carritoFinal"] .= '</table><hr><b>Datos del pago:</b><br/><span style="font-size:12px">Transferencia Bancaria</span><br/>'.$datosBancarios[1];
        echo "<div class='mb-10 alert alert-success btn-block'><b>¡Excelente, finalizaste tu carrito!.</b> <br/>El importe a transferir es de $" . $_SESSION["precioFinal"] . "<br/>          A continuación encontraras los datos de la cuenta bancaria y recibirás un correo con el detalle de tu compra. Recuerda enviarnos el comprobante de transferencia por correo o whatsapp así despachamos inmediatamente tu pedido<br/>
        <i style='font-size: 12px;' >*La mercadería será despachada cuando los fondos se encuentren disponibles en nuestra cuenta bancaria</i>
        </div>";
        /*echo '<table class="table table-hovered table-bordered"><thead><th>Nombre producto</th><th>Cantidad</th><th>Precio unidad</th><th>Precio total</th></thead>';
        echo $_SESSION["carritoFinal"];
        echo '<div class="clearfix"></div><br/>';*/
        echo $datosBancarios[1];
        /*echo '<div class="clearfix"></div>';
        echo $contacto[1];*/
        echo '<div class="clearfix"></div><br/>';
        echo '<a href="'.BASE_URL.'/sesion.php?op=pedidos" class="btn btn-success"><i class="fa fa-list"></i> Volver al inicio</a>';
        echo '<div class="clearfix"></div><br/>';
        $user         = $_SESSION["user"]["id"];
        $contaCarrito = count($_SESSION["carrito"]);
        $precioFinal  = 0;
        $carroFinal   = '';

        $sql       = "UPDATE `pedidos` SET `tipo_pedidos`=1,`estado_pedidos`=0 WHERE `cod_pedidos`= '$cod'";
        $resultado = mysqli_query($con, $sql);

        break;
        case 2:
        $cupon        = isset($_GET["collection_id"]) ? $_GET["collection_id"] : '';
        $status       = isset($_GET["collection_status"]) ? $_GET["collection_status"] : '';
        $payment_type = isset($_GET["payment_type"]) ? $_GET["payment_type"] : '';
        
        if ($status != "null") {
            $senalEnvio = 1;
            if ($status == "approved") {
                $estado     = "1";
                $estadoPago = "aprobado";
                $alert      = "alert alert-success";
            } elseif ($status == "pending") {
                $estado     = "0";
                $estadoPago = "pendiente";
                $alert      = "alert alert-warning";
            } elseif ($status == "rejected") {
                $estado     = "2";
                $estadoPago = "rechazado";
                $alert      = "alert alert-danger";
            }

            $descripcion = "Cupón de mercadopago: " . $cupon . " / ";
            $descripcion .= "Estado del pago: " . $estadoPago . " / ";
            $descripcion .= "Tipo de pago: " . $payment_type . " / ";

            $_SESSION["carritoFinal"] .= '</table><hr><b>Datos del pago:</b><br/><span style="font-size:12px">' . $descripcion . "</span>";

            echo "<div class='mb-10 " . $alert . " btn-block'><b>Excelente ¡finalizaste tu carrito!. Tu pago esta: <b>$estadoPago</b>. En breve recibirás un mail con el detalle de tu compra.</div>";
            /*echo '<table class="table table-hovered table-bordered" style="text-align:left;width:100%;font-size:13px !important"><thead><th>Nombre producto</th><th>Cantidad</th><th>Precio unidad</th><th>Precio total</th></thead>';
            echo $_SESSION["carritoFinal"];
            echo '<div class="clearfix"></div><br/>';
            echo $contacto[1];*/
            echo '<div class="clearfix"></div><br/>';
            echo '<a href="'.BASE_URL.'/sesion.php?op=pedidos" class="btn btn-success"><i class="fa fa-list"></i> Volver al inicio</a>';
            echo '<div class="clearfix"></div><br/>';
            $user = $_SESSION["user"]["id"];

            $contaCarrito = count($_SESSION["carrito"]);
            $precioFinal  = 0;
            $carroFinal   = '';

            $sql       = "UPDATE `pedidos` SET `tipo_pedidos`=2,`estado_pedidos`='$estado' WHERE `cod_pedidos`= '$cod'";
            $resultado = mysqli_query($con, $sql);
        } else {
            echo "<div class='alert alert-danger'>No se pudo realizar el pago</div>";
            echo '<a href="'.BASE_URL.'/productos" class="btn btn-success"><i class="fa fa-list"></i> Volver al inicio</a>';
            $error = 1;
            headerMove(BASE_URL . "/checkout/finalizar-carrito");

        }
        break;
        case 3:
        $_SESSION["carritoFinal"] .= '</table><hr><b>Datos del pago:</b><br/><span style="font-size:12px">De Contado en Sucursal</span>';

        echo "<div class='mb-10 alert alert-success btn-block'><b>¡Excelente, finalizaste tu carrito!. En breve te estaremos llamando para coordinar la entrega y recibirás un mail con el detalle de tu compra.</div>";
        /*echo '<table class="table table-hovered table-bordered" style="text-align:left;width:100%;font-size:13px !important"><thead><th>Nombre producto</th><th>Cantidad</th><th>Precio unidad</th><th>Precio total</th></thead>';
        echo $_SESSION["carritoFinal"];
        echo '<div class="clearfix"></div><br/>';
        echo $contacto[1];*/
        echo '<div class="clearfix"></div><br/>';
        echo '<a href="'.BASE_URL.'/sesion.php?op=pedidos" class="btn btn-success"><i class="fa fa-list"></i> Volver al inicio</a>';
        echo '<div class="clearfix"></div><br/>';
        $user = $_SESSION["user"]["id"];

        $contaCarrito = count($_SESSION["carrito"]);
        $precioFinal  = 0;
        $carroFinal   = '';

        $sql       = "UPDATE `pedidos` SET `tipo_pedidos`=3,`estado_pedidos`=0 WHERE `cod_pedidos`= '$cod'";
        $resultado = mysqli_query($con, $sql);
        break;
    }

    if ($carrito != '' && $error == 0) {
        $asuntoUsuario = $_SESSION["user"]["nombre"] . " ¡Gracias por tu compra!";
        $asunto        = "Nueva compra de productos";
        $receptor      = EMAIL;
        $emailUsuario  = $_SESSION["user"]["email"];

        $mensaje = 'Nueva compra a través sitio web:  <br/>';
        $mensaje .= '<table border="1" style="text-align:left;width:100%;font-size:13px !important"><thead><th>Compra N° ' . $cod . '</th><th>Cantidad</th><th>Precio unidad</th><th>Precio total</th></thead>';
        $mensaje .= $_SESSION["carritoFinal"];
        $mensaje .= '</table>';
        $mensaje .= '<br/><hr/>';
        $mensaje .= '<br/><b>Datos del usuario:</b><br/>';
        $mensaje .= "<b>Nombre y apellido</b>: " . $_SESSION["user"]["nombre"] . "<br/>";
        $mensaje .= "<b>Email</b>: " . $_SESSION["user"]["email"] . "<br/>";
        $mensaje .= "<b>Provincia</b>: " . $_SESSION["user"]["provincia"] . "<br/>";
        $mensaje .= "<b>Localidad</b>: " . $_SESSION["user"]["localidad"] . "<br/>";
        $mensaje .= "<b>Dirección</b>: " . $_SESSION["user"]["direccion"] . "<br/>";
        $mensaje .= "<b>Teléfono</b>: " . $_SESSION["user"]["telefono"] . "<br/>";

        $mensajeUsuario = 'Agradecemos tu compra, el detalle de tu pedido es: <br/><hr/>';
        $mensajeUsuario .= '<table border="1" style="text-align:left;width:100%;font-size:13px !important"><thead><th>Compra N° ' . $cod . '</th><th>Cantidad</th><th>Precio unidad</th><th>Precio total</th></thead>';
        $mensajeUsuario .= $_SESSION["carritoFinal"];
        $mensajeUsuario .= '</table>';
        $mensajeUsuario .= "<br><i><b><br/>Ante cualquier consulta no dudes en comunicarte con nosotros. Saludos</b></i>";

        if($senalEnvio == 0){
            Enviar_User_Admin($asunto, $mensaje, $receptor);
            Enviar_User($asuntoUsuario, $mensajeUsuario, $emailUsuario);
        }


        unset($_SESSION["carrito"]);
        unset($_SESSION["carritoFinal"]);
        unset($_SESSION["precioFinal"]);
        unset($_SESSION["envio"]);
        unset($_SESSION["envioTipo"]);
        unset($_SESSION["envioDomSuc"]);
       if ($_SESSION["user"]["invitado"] == 0) {
            /*$user_del = $_SESSION['user']['email'];
            $sql_del = "DELETE FROM usuarios WHERE email = '$user_del'";
            $resultado_del = mysqli_query($con, $sql_del);*/
            unset($_SESSION["user"]);
        }
    }
    ?>

</div>
</div>
<?php include "inc/footer.inc.php";?>
</body>
</html>
<?php
@ob_end_flush();
?>