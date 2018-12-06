<?php
$id = isset($_GET["id"]) ? $_GET["id"] : '';
$data = Testimonio_TraerPorId($id);
 if (isset($_POST["agregar"])) {
	if ($_POST["titulo"] != '') {
		$titulo = $_POST["titulo"];
		$texto = $_POST["texto"];
		$sql = "UPDATE `testimonios` SET `usuario_testimonios`= '$titulo',`texto_testimonios`='$texto' WHERE  `id_testimonios`= '$id'";
 
		$link = Conectarse();
		$r = mysql_query($sql, $link);

		header("location:index.php?op=verTestimonio");
	} 
}
?> 
<div class="col-lg-10 col-md-12">
	<br/>
	<h4>Agregar Testimonios</h4>
	<hr/>
	<form method="post" enctype="multipart/form-data">
		<div class="row">
			<label class="col-lg-4">Usuario:
				<br/>
				<input type="text" class="form-control" name="titulo" value="<?php echo (isset($data["usuario_testimonios"]) ? $data["usuario_testimonios"] : '') ?>" required>
			</label>	 	
			<div class="clearfix"></div>
			<label class="col-lg-4" >Testimonio:<br/>
				<textarea name="texto" class="form-control"  value="<?php echo (isset($data["texto_testimonios"]) ? $_POST["texto_testimonios"] : '') ?>" rows="4" required><?php echo (isset($data["texto_testimonios"]) ? $data["texto_testimonios"] : '') ?></textarea>
			</label> 
			<div class="clearfix"><br/></div>
			<label class="col-lg-6" ><br/>
				<input type="submit" class="btn btn-success" name="agregar" value="Modificar Testimonio" style="margin-right:20px;"/>
			</label>
		</div>
	</form>
</div>
