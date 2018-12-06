<?php
$random = substr(md5(uniqid(rand())), 0, 10);
$codigo = $random;
$area = "notas";

if (isset($_POST["agregar"])) {
    $titulo = isset($_POST["titulo"]) ? $_POST["titulo"] : '';
    $categorias = isset($_POST["categoria"]) ? $_POST["categoria"] : '';
    $desarrollo = isset($_POST["desarrollo"]) ? $_POST["desarrollo"] : '';
    $cita = isset($_POST["cita"]) ? $_POST["cita"] : '';

    $seo_descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : '';
    $seo_autor = isset($_POST["autor"]) ? $_POST["autor"] : '';
    $seo_etiquetas = isset($_POST["etiquetas"]) ? $_POST["etiquetas"] : '';


    $count = '';

    foreach ($_FILES['files']['name'] as $f => $name) {
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
            //Saber tamaño
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
        $r = mysqli_query($link, $sql);
    }


    $sql2 = "
	INSERT INTO `notabase`
	( `TituloNotas`, `DesarrolloNotas`, `CategoriaNotas`, `FechaNotas`, `CodNotas`) 
	VALUES
	('$titulo','$desarrollo', '$categorias', NOW(),'$codigo')";
    $link2 = Conectarse();
    $r2 = mysqli_query($link2, $sql2);

    header("location:index.php?op=verNotas");

}
?>

<div class="col-md-12 ">
    <h4>Novedades</h4>
    <hr/>
    <form method="post" enctype="multipart/form-data" onsubmit="showLoading()">
        <label class="col-md-8">Título:<br/>
            <input type="text" name="titulo" value="" required class="form-control" size="50">
        </label>
        <label class="col-md-4">Categoría:<br/>
            <select name="categoria" class="form-control">
                <option value="">-- categorías --</option>
              </select>
        </label>

        <div class="clearfix"></div>
        <label class="col-md-12">Desarrollo:<br/>
            <textarea name="desarrollo" class="form-control" style="height:300px;display:block"></textarea>
        </label>

        <div class="clearfix"></div>
        <br/>
        <label class="col-md-7">Imágenes:<br/>
            <input type="file" id="file" name="files[]" multiple="multiple" accept="image/*"/>
        </label>

        <div class="clearfix"></div>
        <br/>

        <div class="col-md-12">
            <input type="submit" class="btn btn-primary" name="agregar" value="Crear Novedad"/>
        </div>
    </form>
</div>
