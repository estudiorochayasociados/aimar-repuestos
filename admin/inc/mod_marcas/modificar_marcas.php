<?php
$id = isset($_GET['id']) ? $_GET['id'] : '';

if ($id != '') {
    $data = Marcas_TraerPorId($id);
}

?>
<div class="col-md-12">
    <h4>
        Modificar Marcas
    </h4>
    <hr/>
    <form  method="post" class="row">
        <?php
        if (isset($_POST["publicar"])) {
            $marca = $_POST["marca"];
            $sql = "UPDATE `marcas_autos` SET `marca_marcas`= '$marca' WHERE `id_marcas`= '$id'";
            $link = Conectarse_Mysqli();
            $r = mysqli_query($link, $sql);

            header("location:index.php?op=verMarcas");
        }
        ?>
        <div class="clearfix">
        </div>
        <label class="col-md-4">
            Marcas:
            <input type="text" name="marca" placeholder="Marcas" value="<?= isset($data["marca_marcas"]) ? $data["marca_marcas"] : '' ?>" class="form-control" />
        </label>
        <div class="col-md-4"><br/>
            <input type="submit" class="btn btn-success" name="publicar" value="Modificar"/>
        </div>
    </form>
</div>