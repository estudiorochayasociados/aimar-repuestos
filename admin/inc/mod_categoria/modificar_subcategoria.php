<?php
$id = isset($_GET['id']) ? $_GET['id'] : '';
$rotar = isset($_GET['rotar']) ? $_GET['rotar'] : '';

if ($id != '') {
	$data = Subcategoria_TraerPorId($id);
	$cate = Categoria_TraerPorId($data["categoria_subcategoria"]);
	$titulo = isset($data["nombre_subcategoria"]) ? $data["nombre_subcategoria"] : '';
	$categoria = isset($cate["nombre_categoria"]) ? $cate["nombre_categoria"] : '';
}

if (isset($_POST['agregar'])) {
	if ($_POST["nombre"] != '') {
		$titulo = $_POST["nombre"];
		$categoria = $_POST["categoria"];
		$sql = "UPDATE `subcategorias` SET `nombre_subcategoria`= '$titulo',`categoria_subcategoria`= '$categoria' WHERE `id_subcategoria`= $id";
		$link = Conectarse_Mysqli();
		$r = mysqli_query($link,$sql);
		header("location:index.php?op=verSubcategoria");
	}
}
?>
<div class="col-lg-12">
	<hr/>
	<form method="post">
		<div class="row" >
			<label class="col-md-6">
				Subcategoria:<br/>
				<input type="text" name="nombre" placeholder="Subcategoría" class="form-control" value="<?php echo $titulo  ?>" />
			</label>
			<label class="col-md-6">
				Categoria:<br/>
				<select type="text" name="categoria" class="form-control" >
					<option value="<?php echo $data["categoria_subcategoria"]; ?>" selected><?php echo $cate["nombre_categoria"]; ?></option>
					<?php Categoria_Read_Option(); ?>
				</select>
			</label>
			<div class="col-md-6">
				<input type="submit" class="btn btn-success" name="agregar" value="CREAR SUBCATEGORIA"/>
			</div>
		</div>
	</div>
</form>
</div>
