<?php
session_start();
ob_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php 
  include("inc/header.inc.php");
  $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

  $palabra = antihack_mysqli(isset($_GET["palabra"]) ? $_GET["palabra"] : '');      
  $modelo = antihack_mysqli(isset($_GET["modelo"]) ? $_GET["modelo"] : '');      
  $marca = antihack_mysqli(isset($_GET["marca"]) ? $_GET["marca"] : '');      
  $variable = antihack_mysqli(isset($_GET["variable"]) ? $_GET["variable"] : '');      
  $rosca = antihack_mysqli(isset($_GET["rosca"]) ? $_GET["rosca"] : '');      
  $largo = antihack_mysqli(isset($_GET["largo"]) ? $_GET["largo"] : '');      
  $diametro = antihack_mysqli(isset($_GET["diametro"]) ? $_GET["diametro"] : '');      
  $categoriaA = antihack_mysqli(isset($_GET["categoria"]) ? $_GET["categoria"] : '');   
  if($categoriaA != '') { 
    $categoriaNombre = Categoria_Read_Solo($categoriaA);
  }   
  ?>

  <title>Productos - Aimar Repuestos</title>
  <meta name="description" content="Encontrá los últimos productos de pinturas del mercado">
  <meta name="author" content="<?php echo TITULO ?>">
</head>
<body onload="$('.loader').hide()">
 <div id="page" class="index">
  <header class="header">
    <?php include("inc/nav.inc.php"); ?>
  </header>
  <div class="page-hero">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <h1 class="page-title text-uppercase">
            PRODUCTOS
          </h1>
        </div>
      </div>
    </div>
  </div>
  <?php $filtros = strtolower(isset($categoriaNombre["filtro_categoria"]) ? $categoriaNombre["filtro_categoria"] : ''); ?>
  <form class="container" id="filterForm" role="search" method="get" action="<?php echo BASE_URL ?>/productos.php"> 
    <div class="col-md-2 col-xs-6"  style="display:block;" ><b>Código:</b><br/>
      <input type="text"  name="palabra" value="<?php echo $palabra ?>"  placeholder="¿Código del producto?" class="inputPro form-control">
    </div>
    <div class="col-md-2 col-xs-6"><b>Categoría:</b><br/>
      <div class="ui-widget">
        <select id="combobox" class="form-control" name="categoria">
          <option value='' disabled selected>Elegir categoria</option>
          <option value=''>TODAS</option>
          <?php Categoria_Read_Option($categoriaA) ?>
        </select>
      </div>
    </div>
    <div class="col-md-2 col-xs-6" <?php if(preg_match("/marca/i",$filtros)) { echo "style='display:block;'"; } else {echo "style='display:none'";} ?>><b>Marca:</b><br/>
      <div class="ui-widget">
        <select  id="combobox1" class="form-control" name="marca" onchange="this.form.submit()">
          <option value='' disabled selected>Elegir marca</option>
          <option value=''>TODAS</option>
          <?php Traer_Marcas($marca) ?>
        </select>
      </div>
    </div>
    <div class="clearfix hidden-lg hidden-md mb-10"></div>
    <div class="col-md-2 col-xs-6" <?php if(preg_match("/modelo/i",$filtros)) { echo "style='display:block;'"; } else {echo "style='display:none'";} ?>><b>Modelo:</b><br/>
      <div class="ui-widget">
        <select id="combobox2"  name="modelo" onchange="this.form.submit()">
          <option value='' disabled selected>Elegir Modelo</option>
          <option value=''>TODAS</option>
          <?php if($marca != ''){Traer_Modelos($modelo,$marca);} ?>
        </select>
      </div>
    </div>
    <div class="col-md-2 col-xs-6" <?php if(preg_match("/largo/i",$filtros)) { echo "style='display:block;'"; } else {echo "style='display:none'";} ?> ><b>Largo:</b><br/>
      <input type="text"  name="largo" value="<?php echo $largo ?>"  placeholder="Largo en mm." class="inputPro form-control">
    </div>
    <div class="col-md-2 col-xs-6" <?php if(preg_match("/diametro/i",$filtros)) { echo "style='display:block;'"; } else {echo "style='display:none'";} ?> ><b>Diámetro:</b><br/>
      <input type="text"  name="diametro" value="<?php echo $diametro ?>"  placeholder="Diámetro en mm." class="inputPro form-control">
    </div>
    <div class="col-md-2 col-xs-6" <?php if(preg_match("/rosca/i",$filtros)) { echo "style='display:block;'"; } else {echo "style='display:none'";} ?> ><b>Rosca:</b><br/>
      <input type="text"  name="rosca" value="<?php echo $rosca ?>"  placeholder="Rosca en mm." class="inputPro form-control">
    </div>  
    <div class="clearfix hidden-lg hidden-md"></div>
    <div class="col-md-1"><br/>
      <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> BUSCAR</button>
    </div>
  </form>  
  <main class="main main-home">
    <div class="container-fluid pt-20 pb-20">
      <div id="resultados"></div>
      <?php if($palabra != '' || $marca != '' || $categoriaA != '' || $largo != '' || $diametro != '') { ?>
        <div class="col-md-12 ">
          <div class="alert alert-info text-uppercase">              
            Estás buscando por:<br/>
            <?php
            if($palabra != '') { echo "<b>CÓDIGO:</b> $palabra <br/>";};
            if($marca != '') { echo "<b>MARCA:</b> $marca <br/>";};
            if($modelo != '') { echo "<b>MODELO:</b> $modelo <br/>";};
            if($categoriaA != '') { 
             echo "<b>CATEGORIA:</b> ".$categoriaNombre['nombre_categoria']." <br/>";
           };
           if($rosca != '') { echo "<b>MEDIDA DE LA ROSCA:</b> $rosca <br/>";};
           if($largo != '') { echo "<b>LARGO:</b> $largo <br/>";};
           if($diametro != '') { echo "<b>DIAMETRO:</b> $diametro <br/>";};
           ?>
         </div>
       </div>
     <?php } ?>
     <div class="col-md-12 col-lg-12 flex-wrap"> 
      <?php 
      if($palabra != '' || $marca != '' || $categoriaA != '' || $largo != '' || $diametro != '') {
        Productos_Front($categoriaA,$marca,$modelo,$palabra,$rosca,$largo,$diametro);    
      }
      ?>
    </div>              
  </div>
</main>
<?php include("inc/footer.inc.php"); ?> 
<script type="text/javascript">
  function ResetSubmit() {    
    $("select[name*='marca']").val("");
    $("input[name*='modelo']").val("");
    $("input[name*='palabra']").val("");
    $("select[name*='largo']").val("");
    $("select[name*='diametro']").val("");
    $("select[name*='rosca']").val("");
    $("#filterForm").submit();
  }  
</script>

<script>
  $( function() {
    $.widget( "custom.combobox", {
      _create: function() {
        this.wrapper = $( "<span>" )
        .addClass( "custom-combobox" )
        .insertAfter( this.element );

        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
      },

      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
        value = selected.val() ? selected.text() : "";

        this.input = $( "<input>" )
        .appendTo( this.wrapper )
        .val( value )
        .attr( "title", "" )
        .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
        .autocomplete({
          delay: 0,
          minLength: 0,
          source: $.proxy( this, "_source" )
        })
        .tooltip({
          classes: {
            "ui-tooltip": "ui-state-highlight"
          }
        });

        this._on( this.input, {
          autocompleteselect: function( event, ui ) {
            ui.item.option.selected = true;
            this._trigger( "select", event, {
              item: ui.item.option
            });
          },

          autocompletechange: "_removeIfInvalid"
        });
      },

      _createShowAllButton: function() {
        var input = this.input,
        wasOpen = false;

        $( "<a>" )
        .attr( "tabIndex", -1 )
        .attr( "title", "Ver todos" )
        .tooltip()
        .appendTo( this.wrapper )
        .button({
          icons: {
            primary: "ui-icon-triangle-1-s"
          },
          text: false
        })
        .removeClass( "ui-corner-all" )
        .addClass( "custom-combobox-toggle ui-corner-right" )
        .on( "mousedown", function() {
          wasOpen = input.autocomplete( "widget" ).is( ":visible" );
        })
        .on( "click", function() {
          input.trigger( "focus" );

            // Close if already visible
            if ( wasOpen ) {
              return;
            }

            // Pass empty string as value to search for, displaying all results
            input.autocomplete( "search", "" );
          });
      },

      _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
          var text = $( this ).text();
          if ( this.value && ( !request.term || matcher.test(text) ) )
            return {
              label: text,
              value: text,
              option: this
            };
          }) );
      },

      _removeIfInvalid: function( event, ui ) {

        // Selected an item, nothing to do
        if ( ui.item ) {
          return;
        }

        // Search for a match (case-insensitive)
        var value = this.input.val(),
        valueLowerCase = value.toLowerCase(),
        valid = false;
        this.element.children( "option" ).each(function() {
          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            return false;
          }
        });

        // Found a match, nothing to do
        if ( valid ) {
          return;
        }

        // Remove invalid value
        this.input
        .val( "" )
        .attr( "title", value + " didn't match any item" )
        .tooltip( "open" );
        this.element.val( "" );
        this._delay(function() {
          this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
        this.input.autocomplete( "instance" ).term = "";
      },

      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
 

    $( "#combobox" ).combobox({select: function (event, ui) {this.form.submit();}});
    $( "#combobox1" ).combobox({select: function (event, ui) {this.form.submit();}});
    $( "#combobox2" ).combobox({select: function (event, ui) {this.form.submit();}});
    $( "#toggle" ).on( "click", function() {
      $( "#combobox" ).toggle();
    });
    $( "#toggle1" ).on( "click", function() {
      $( "#combobox1" ).toggle();
    });
    $( "#toggle2" ).on( "click", function() {
      $( "#combobox2" ).toggle();
    });
  } );
</script>
</div>
</body>
</html>
