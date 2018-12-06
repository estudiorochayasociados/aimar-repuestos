<?php
$id = isset($_GET['id']) ? $_GET['id'] : '';
$rotar = isset($_GET['rotar']) ? $_GET['rotar'] : '';

if ($id != '') {
	$data = Rubro_TraerPorId($id);
	$titulo = isset($data["titulo_rubros"]) ? $data["titulo_rubros"] : '';
}

if (isset($_POST['agregar'])) {
	if ($_POST["nombre"] != '') {
		$titulo = $_POST["nombre"];
		$cod = $_POST["codigo"];
		$peso = $_POST["peso"];
		$sql = "UPDATE `rubros` SET `titulo_rubros`= '$titulo', `cod_rubros`= '$cod', `peso_rubros`= '$peso' WHERE `id_rubros`= '$id'";
		$link = Conectarse_Mysqli();
		$r = mysqli_query($link,$sql);
		header("location:index.php?op=verRubro");
	}
}
?>
<div class="col-lg-12">
	<hr/>
	<form method="post" enctype="multipart/form-data">
		<div class="row" >
			<label class="col-md-3">Código:
				<br/>
				<input type="text" name="codigo" class="form-control" value="<?php echo $data["cod_rubros"]; ?>" required>
			</label>
			<label class="col-md-3">Rubros:
				<br/>
				<input type="text" name="nombre" class="form-control" value="<?php echo $data["titulo_rubros"]; ?>" required>
			</label> 
			<label class="col-md-3">Peso (decimales . ):
				<br/>
				<input type="text" name="peso" class="form-control" value="<?php echo $data["peso_rubros"]; ?>" required>
			</label>
			<label class="col-md-3"><br/>
				<input type="submit" class="btn btn-primary " name="agregar" value="Modificar Rubros" />
			</label>
		</div>
	</div>
</form>
</div>
