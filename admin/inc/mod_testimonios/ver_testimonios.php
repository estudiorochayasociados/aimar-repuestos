<div class="col-lg-12 col-md-12">
	<h4>Testimonio</h4>
	<hr/>
	<table class="table  table-bordered  ">
		<thead>
			<th>Usuario</th>
			<th width="70%">Testimonio</th>
			<th></th>
		</thead>
		<tbody>
			<?php
			Testimonio_Read();
			?>
		</tbody>
	</table>
</div>
<?php
$borrar = isset($_GET["borrar"]) ? $_GET["borrar"] : '';

if ($borrar != '') {
	$sql = "DELETE FROM `testimonios` WHERE `id_testimonios` = '$borrar'";
	$link = Conectarse();
	$r = mysql_query($sql, $link);
	header("location: index.php?op=verTestimonio");
}
?>

