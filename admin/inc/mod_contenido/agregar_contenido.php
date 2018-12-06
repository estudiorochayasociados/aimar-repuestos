<?php
if (isset($_POST['agregar'])) {
    if ($_POST["titulo"] != '' && $_POST["desarrollo"] != '') {
      $desarrollo = $_POST["desarrollo"];
      $titulo = $_POST["titulo"];

      $sql = "INSERT INTO `contenidos`(`contenido`, `codigo`) VALUES ('$desarrollo','$titulo')";
      $link = Conectarse();
      $r = mysqli_query($link,$sql);

      header("location:index.php?op=verContenidos");
  }
}
?>

<div class="col-lg-12 col-md-12">
	<h4>Agregar contenido</h4>
	<hr/>
	<form method="post" onsubmit="showLoading()">
		<label class="col-lg-12">Título:
			<br/>
			<input type="text" name="titulo" value="" class="form-control" size="50" />
		</label>
       <label class="col-lg-12" >Desarrollo: 
         <br/>
         <textarea name="desarrollo"  class="form-control"></textarea>
         <script>
         CKEDITOR.replace('desarrollo');
         </script> 
     </label>  
     <div class="clearfix"></div>
     <label class="col-lg-12">
         <input type="submit" class="btn btn-primary" name="agregar" value="Modificar Contenido" />
     </label>
 </form>
</div>
