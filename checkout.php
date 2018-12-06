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
  <title>Finalizar tu carrito - Aimar Repuestos</title>
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
              FINALIZAR TU CARRITO
            </h1>
          </div>
        </div>
      </div>
    </div>
    <div class="container cuerpoContenedor"> 
      <div class="col-md-12">
       <?php
       $paso = isset($_GET["paso"]) ? $_GET["paso"] : '';
       if($paso != '') {
        $paso = explode("/", $paso);   
      }
      
      switch ($paso[1]) {
        case 'crear-usuario':
        include("inc/checkout/crear-usuario.inc.php");
        break;
        case 'finalizar-carrito':
        include("inc/checkout/finalizar-carrito.inc.php");
        break; 
        default:
        include("inc/ver-carrito.inc.php");
        break;
      }
      ?>
    </div>
  </div>  
  <?php include("inc/footer.inc.php"); ?>
</body>
</html>
<?php
@ob_end_flush();
?>