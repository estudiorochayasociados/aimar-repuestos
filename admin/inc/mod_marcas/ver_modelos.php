<?php
$id = isset($_GET["id"]) ? $_GET["id"] : '';
$borrar = isset($_GET["borrar"]) ? $_GET["borrar"] : '';

if ($borrar != '') {
    $sql = "DELETE FROM `modelos_autos` WHERE `id_autos` = '$borrar'";
    $link = Conectarse_Mysqli();
    $r = mysqli_query($link, $sql);
    header("location:index.php?op=verModelos&id=$id");
}
?>
<div class="col-md-12">
    <h3>
          Modelos
    </h3>
    <hr/>
    <form method="post" class="form-inline">
        <div class="form-group">
            <?php
            if (isset($_POST["publicar"])) {
                $idConn = Conectarse();
                $modelo = isset($_POST["modelo"]) ? $_POST["modelo"] : '';
                $sql = "INSERT INTO `modelos_autos` (`modelo_autos`,`marca_autos`)  VALUES ('$modelo','$id')";
                $resultado = mysqli_query($idConn, $sql);
                header("location:index.php?op=verModelos&id=$id");
            }
            ?>
            <label for="exampleInputName2">
                AGREGAR UN NUEVO MODELO
            </label>
            <input type="hidden" class="form-control" name="id" value="<?= $id ?>"  >
            <input type="text" class="form-control" name="modelo" value="<?= isset($_POST["modelo"]) ? $_POST["modelo"] : ''; ?>"  >
        </div>
        <button type="submit" class="btn btn-default" name="publicar">
            Guardar
        </button>
    </form>
    <hr/>
    <table class="table  table-bordered table-hovered table-striped" width="100%">
        <thead>
            <th>
                Modelo
            </th>
            <th>
            </th>
        </thead>
        <tbody>
            <?php
            Modelos_Read($id);
            ?>
        </tbody>
    </table>
</div>
