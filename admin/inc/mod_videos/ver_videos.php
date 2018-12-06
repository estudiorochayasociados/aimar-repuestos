<div class="col-lg-12 col-md-12">
	<h4>Videos</h4>
	<hr/>
	<table class="table  table-bordered  ">
		<thead>
			<th width="70%">Titulo</th>
			<th>Categoría</th>
			<th>Ajustes</th>
		</thead>
		<tbody>
			<?php
			Videos_Read();
			?>
		</tbody>
	</table>
</div>
<?php
$borrar = isset($_GET["borrar"]) ? $_GET["borrar"] : '';

if ($borrar != '') {
	$sql = "DELETE FROM `videos` WHERE `IdVideos` = '$borrar'";
	$link = Conectarse();
	$r = mysql_query($sql, $link);
	header("location: index.php?op=verVideos");
}
?>

