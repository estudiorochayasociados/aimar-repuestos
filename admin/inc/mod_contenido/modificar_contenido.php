<?php
$id = isset($_GET['id']) ? $_GET['id'] : '';

if ($id != '') {
    $data = Contenido_AdminTraerPorId($id);
}

if (isset($_POST['agregar'])) {
       $desarrollo = $_POST["desarrollo"];

      $sql = "
      UPDATE `contenidos` 
      SET `contenido`='$desarrollo'
      WHERE `id`= '$id'";
      $link = Conectarse();
      $r = mysqli_query($link,$sql);

      header("location:index.php?op=modificarContenidos&id=$id");
 
}
?>

<div class="col-lg-10 col-md-12">
	<h4>Modificar &rarr; <?php echo strtoupper($data["codigo"]); ?></h4>
	<hr/>
	<form method="post" onsubmit="showLoading()">
		<label class="col-lg-4">Título:
			<br/>
			<input type="text" name="titulo" value="<?php echo strtoupper($data["codigo"]); ?>" readonly class="form-control" size="50" />
		</label>
       <label class="col-lg-12" >Desarrollo: 
         <br/>
         <textarea name="desarrollo"  class="form-control"><?php echo $data["contenido"]; ?></textarea>
         <script>
        //     CKEDITOR.replace('desarrollo');
         </script> 
     </label>  
     <div class="clearfix"></div>
     <label class="col-lg-12">
         <input type="submit" class="btn btn-primary" name="agregar" value="Modificar Contenido" />
     </label>
 </form>
</div>
