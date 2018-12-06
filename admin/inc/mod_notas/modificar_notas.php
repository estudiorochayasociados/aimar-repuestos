<?php
$id = isset($_GET['id']) ? $_GET['id'] : '';

if ($id != '') {
    $data = Nota_TraerPorId($id);
    $titulo = isset($data["TituloNotas"]) ? $data["TituloNotas"] : '';
    $desarrollo = isset($data["DesarrolloNotas"]) ? $data["DesarrolloNotas"] : '';
    $categoria = isset($data["CategoriaNotas"]) ? $data["CategoriaNotas"] : '';
    $codigo = isset($data["CodNotas"]) ? $data["CodNotas"] : '';
    $img = isset($data["ImgPortadaNotas"]) ? $data["ImgPortadaNotas"] : '';
    $imagen = Imagenes_TraerPorId($data["CodNotas"]);
    $imagenes = explode("-", $imagen);
    $count = '';
}

$area = "notas";

if (isset($_POST['agregar'])) {
    if ($_POST["titulo"] != '' && $_POST["desarrollo"] != '') {
        foreach ($_FILES['files']['name'] as $f => $name) {
            if (!empty($_FILES["files"]["tmp_name"][$f])) {
                $imgInicio = $_FILES["files"]["tmp_name"][$f];
                $tucadena = $_FILES["files"]["name"][$f];
                $partes = explode(".", $tucadena);
                $dom = (count($partes) - 1);
                $dominio = $partes[$dom];
                $prefijo = rand(0, 10000000);

                if ($dominio != '') {
                    $destinoImg = "archivos/" . $area . "/" . $prefijo . "." . $dominio;
                    $destinoFinal = "../archivos/" . $area . "/" . $prefijo . "." . $dominio;
                    move_uploaded_file($imgInicio, $destinoFinal);
                    chmod($destinoFinal, 0777);
                    $destinoRecortado = "../archivos/" . $area . "/recortadas/a_" . $prefijo . "." . $dominio;
                    $destinoRecortadoFinal = "archivos/" . $area . "/recortadas/a_" . $prefijo . "." . $dominio;

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
                $sql = "INSERT INTO `imagenes`(`ruta`, `codigo`) VALUES ('$destinoRecortadoFinal','$codigo')";
                $link = Conectarse();
                $r = mysqli_query($link, $sql);
            }
        }
        $titulo = $_POST["titulo"];
        $desarrollo = $_POST["desarrollo"];
        $categoria = $_POST["categoria"];
        $sql = "
        UPDATE `notabase` 
        SET             
        `TituloNotas`= '$titulo',
        `DesarrolloNotas`='$desarrollo',
        `CategoriaNotas`= '$categoria'
        WHERE `IdNotas`= '$id'";
        $link = Conectarse();
        $r = mysqli_query($link, $sql);
        header("location:index.php?op=modificarNotas&id=$id");

    }
}
?>

<div class="col-lg-10 col-md-12">
    <h4>Modificar &rarr; <?php echo $data["TituloNotas"]; ?></h4>
    <hr/>
    <form method="post" enctype="multipart/form-data" onsubmit="showLoading()">
        <label class="col-lg-8">Título:
            <br/>
            <input type="text" name="titulo" value="<?php echo $data["TituloNotas"]; ?>" class="form-control"
                   size="50"/>
        </label>
        <label class="col-md-4">Categoría:<br/>
            <select name="categoria" class="form-control">
                <option value="" disabled selected>-- categorías --</option>
                <option value="Iluminación" <?php if ($categoria == "Iluminación") {
                    echo "selected";
                } ?> >Iluminación
                </option>
                <option value="Materiales Electricos" <?php if ($categoria == "Materiales Electricos") {
                    echo "selected";
                } ?> >Materiales Eléctricos
                </option>
            </select>
        </label>

        <div class="clearfix"></div>
        <label class="col-lg-12">Desarrollo:
            <br/>
            <textarea name="desarrollo" class="form-control"><?php echo $data["DesarrolloNotas"]; ?></textarea>
        </label>

        <div class="clearfix"></div>
        <br/>

        <div class="clearfix"></div>
        <div class="col-md-12" style="display:block"><br/>

            <div class="row">
                <?php
                $countImagen = (count($imagenes)) - 1;
                for ($i = 0; $i < $countImagen; $i++) {
                    echo '<div class="col-md-3 col-xs-12" style="margin-bottom:65px;height:200px;"><div class="thumbnail" style="height:200px;overflow:hidden" ><img src="../' . $imagenes[$i] . '" width="100%" ></div><a class="btn-primary btn btn-block" href="index.php?op=modificarNotas&id=' . $id . '&borrar=' . $imagenes[$i] . '">BORRAR IMAGEN</a></div>';
                }
                ?>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr/>
        <label class="col-md-12">
            Imágenes:<br/><br/>
            <input type="file" id="file" name="files[]" multiple="multiple" accept="image/*"/>
        </label>

        <div class="clearfix"></div>
        <div class="col-lg-12">
            <div class="clearfix">
                <br/>
            </div>
            <label class="col-lg-12">
                <input type="submit" class="btn btn-primary" name="agregar" value="Modificar Novedad"/>
            </label>
        </div>
    </form>
</div>

<?php

$borrar = isset($_GET["borrar"]) ? $_GET["borrar"] : '';

if ($borrar != '') {
    unlink("../" . $borrar);
    $sql = "DELETE FROM `imagenes` WHERE `ruta` = '$borrar'";
    $link = Conectarse();
    $r = mysqli_query($link, $sql);
    header("location: index.php?op=modificarNotas&id=$id");
}

?>

