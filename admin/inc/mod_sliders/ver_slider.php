<div class="col-lg-12">
	<h4>Slider</h4>	 
	<hr/>
	<table class="table  table-bordered table-striped">
		<thead>
			<th>Id</th>
			<th width="60%">Título</th>
 			<th>Tipo</th>
 			<th>Visibilidad</th>
			<th>Ajustes</th>
		</thead>
		<tbody>
			<?php
			Slider_Read_Admin();
			?>
		</tbody>
	</table>
</div>

<?php
if (isset($_GET["upd"]) && isset($_GET["borrar"])) {
	$sql = "UPDATE `sliderbase` SET `EstadoSlider` = ". $_GET["upd"] . " WHERE `IdSlider` = " . $_GET["borrar"];
	$link = Conectarse();
	$r = mysqli_query($link,$sql);
	header("location: index.php?op=verSlider");
}

if (isset($_GET["borrar"]) && !isset($_GET["upd"]) ) {
	$sql = "DELETE FROM `sliderbase` WHERE `IdSlider` =" . $_GET["borrar"];
	$link = Conectarse();
	$r = mysqli_query($link,$sql);
	header("location: index.php?op=verSlider");
}
?>