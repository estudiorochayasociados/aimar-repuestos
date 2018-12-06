<?php
$id = isset($_GET['id']) ? $_GET['id'] : '';
$rotar = isset($_GET['rotar']) ? $_GET['rotar'] : '';

if ($id != '') {
	$data = Categoria_TraerPorId($id);
	$titulo = isset($data["nombre_categoria"]) ? $data["nombre_categoria"] : '';
	$rubro = isset($data["rubro_categoria"]) ? $data["rubro_categoria"] : '';
	$filtro = isset($data["filtro_categoria"]) ? $data["filtro_categoria"] : '';
}

if (isset($_POST['agregar'])) {
	if ($_POST["nombre"] != '') {
		$titulo = $_POST["nombre"];
		$rubro = $_POST["rubro"];
		$filtro = implode(",", $_POST["filtros"]);

		$sql = "UPDATE `categorias` SET `nombre_categoria`= '$titulo', `rubro_categoria`= '$rubro' , `filtro_categoria`= '$filtro' WHERE `id_categoria`= '$id'";
		$link = Conectarse_Mysqli();
		$r = mysqli_query($link,$sql);

		header("location:index.php?op=verCategoria");
	}
}
?>
<div class="col-lg-12">
	<h4>Modificar Categoría</h4>
	<hr/>
	<form method="post" enctype="multipart/form-data">
		<div class="row" >
			<div class="clearfix"></div>	
			<label class="col-lg-4">Categoría:
				<br/>
				<input type="text" name="nombre" class="form-control" value="<?php echo $data["nombre_categoria"]; ?>" required>
			</label>
			<div class="clearfix"></div>	
			<label class="col-lg-4">Rubro (separados por coma):
				<br/>
				<input type="text" name="rubro" class="form-control" value="<?php echo $data["rubro_categoria"]; ?>" required>
			</label> 
			<div class="clearfix"></div>	
			<label class="col-md-4">Filtro:<br/>
				<label><input type="checkbox" name="filtros[]" value="marca" <?php if(preg_match("/marca/i",$data["filtro_categoria"])) { echo "checked"; } ?>> MARCA</label><br>
				<label><input type="checkbox" name="filtros[]" value="modelo" <?php if(preg_match("/modelo/i",$data["filtro_categoria"])) { echo "checked"; } ?>> MODELO</label><br>
				<label><input type="checkbox" name="filtros[]" value="codigo" <?php if(preg_match("/codigo/i",$data["filtro_categoria"])) { echo "checked"; } ?>> CODIGO</label><br>
				<label><input type="checkbox" name="filtros[]" value="diametro" <?php if(preg_match("/diametro/i",$data["filtro_categoria"])) { echo "checked"; } ?>> DIAMETRO</label><br>
				<label><input type="checkbox" name="filtros[]" value="largo" <?php if(preg_match("/largo/i",$data["filtro_categoria"])) { echo "checked"; } ?>> LARGO</label><br>
				<label><input type="checkbox" name="filtros[]" value="rosca" <?php if(preg_match("/rosca/i",$data["filtro_categoria"])) { echo "checked"; } ?>> ROSCA</label><br>
			</label>
			<div class="clearfix"></div>	
			<div class="col-md-4">
				<input type="submit" class="btn btn-primary " name="agregar" value="Modificar Categoría" />
			</div>
		</div>
	</div>
</form>
</div>
