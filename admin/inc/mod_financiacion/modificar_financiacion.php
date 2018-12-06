<?php
$id = isset($_GET['id']) ? $_GET['id'] : '';

if ($id != '') {
    $data = Financiacion_TraerPorId($id);    
    $imagen = Imagenes_TraerPorId($data["cod_financiacion"]);
    $codigo = isset($data["cod_financiacion"]) ? $data["cod_financiacion"] : '';
    $imagenes = explode("-",$imagen);
    $count = '';
}

$area = "bancos";

if (isset($_POST['agregar'])) {
    if ($_POST["titulo"] != '') {
        foreach ($_FILES['files']['name'] as $f => $name) {     
            if(!empty($_FILES["files"]["tmp_name"][$f])) {
                $imgInicio = $_FILES["files"]["tmp_name"][$f];
                $tucadena = $_FILES["files"]["name"][$f];
                $partes = explode(".", $tucadena);
                $dom = (count($partes) - 1);
                $dominio = $partes[$dom];
                $prefijo = rand(0, 10000000);

                if ($dominio != '') {
                    $destinoImg = "archivos/".$area."/" . $prefijo . "." . $dominio;
                    $destinoFinal = "../archivos/".$area."/" . $prefijo . "." . $dominio;
                    move_uploaded_file($imgInicio, $destinoFinal);
                    chmod($destinoFinal, 0777); 
                    $destinoRecortado = "../archivos/".$area."/recortadas/a_" . $prefijo . "." . $dominio;
                    $destinoRecortadoFinal = "archivos/".$area."/recortadas/a_" . $prefijo . "." . $dominio;

                    $tamano = getimagesize($destinoFinal);
                    $tamano1 = explode(" ", $tamano[3]);
                    $anchoImagen = explode("=", $tamano1[0]);
                    $anchoFinal = str_replace('"', "", trim($anchoImagen[1]));
                    if ($anchoFinal >= 900) {
                        @EscalarImagen("900", "0", $destinoFinal, $destinoRecortado, "70");
                    } else {
                        @EscalarImagen($anchoFinal, "0", $destinoFinal, $destinoRecortado, "70");
                    }
                    unlink($destinoFinal);
                }    
                $count++;  
                $sql = "INSERT INTO `imagenes`(`ruta`, `codigo`, `area`) VALUES ('$destinoRecortadoFinal','$codigo','$area')";
                $link = Conectarse();
                $r = mysql_query($sql, $link);
            }
        }

        $titulo = isset($_POST["titulo"]) ? $_POST["titulo"] : '';
        $desarrollo = isset($_POST["desarrollo"]) ? $_POST["desarrollo"] : ''; 

        $sql = "
        UPDATE `financiacion` 
        SET 			
        `banco_financiacion`= '$titulo',
        `desarrollo_financiacion`='$desarrollo' 
        WHERE `id_financiacion`= $id";

        $link = Conectarse();
        $r = mysql_query($sql, $link);

        header("location:index.php?op=modificarFinanciacion&id=$id");

    }
}
?>

<div class="col-md-12 ">
    <h4>Modificar Financiación</h4>
    <hr/>
    <form method="post" enctype="multipart/form-data" onsubmit="showLoading()">
        <label class="col-md-12">Banco:<br/>
            <input type="text" name="titulo" value="<?php echo isset($data["banco_financiacion"]) ? $data["banco_financiacion"] : '' ; ?>" required class="form-control" size="50">
        </label>        
        <div class="clearfix"></div>
        <label class="col-md-12">Desarrollo:<br/>
            <textarea name="desarrollo" class="form-control"  style="height:300px;display:block"><?php echo isset($data["desarrollo_financiacion"]) ? $data["desarrollo_financiacion"] : ''; ?></textarea>
            <script>
            CKEDITOR.replace('desarrollo');
            </script> 
        </label>         
        <div class="clearfix"></div>
        <div class="col-md-12" style="display:block"><br/>
            <div class="row">
                <?php 
                $countImagen = (count($imagenes))-1;
                for ($i = 0;$i < $countImagen;$i++) {
                    echo '<div class="col-md-3 col-xs-12" style="margin-bottom:65px;height:200px;"><div class="thumbnail" style="height:200px;overflow:hidden" ><img src="../'.$imagenes[$i].'" width="100%" ></div><a class="btn-primary btn btn-block" href="index.php?op=modificarFinanciacion&id='.$id.'&borrar='.$imagenes[$i].'">BORRAR IMAGEN</a></div>';
                } 
                ?>
            </div>
        </div>
        <div class="clearfix"></div><hr/>
        <label class="col-md-12"> 
            Imágenes:<br/><br/>
            <input type="file" id="file" name="files[]"   accept="image/*" />
        </label>                 
        <div class="clearfix"></div>      
        <label class="col-lg-12"><br/>
            <input type="submit" class="btn btn-primary" name="agregar" value="Agregar Financiación" />
        </label>                
    </form>
</div>
<?php

$borrar = isset($_GET["borrar"]) ? $_GET["borrar"] : '';

if ($borrar != '') {
    unlink("../".$borrar);
    $sql = "DELETE FROM `imagenes` WHERE `ruta` = '$borrar'";
    $link = Conectarse();
    $r = mysql_query($sql, $link);
    header("location: index.php?op=modificarFinanciacion&id=$id");
}

?>

