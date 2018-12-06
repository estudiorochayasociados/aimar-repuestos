<div class="col-md-6">
	<h3>Pedidos</h3>
	<hr/>
	<?php
	$est = isset($_GET["est"]) ? $_GET["est"] : '0';
	$act = isset($_GET["act"]) ? $_GET["act"] : '';
	$id = isset($_GET["id"]) ? $_GET["id"] : '';
	$estadoFiltro = isset($_GET["estadoFiltro"]) ? $_GET["estadoFiltro"] : '3';
	$estado = isset($_GET["estado"]) ? $_GET["estado"] : '';
	$borrar = isset($_GET["borrar"]) ? $_GET["borrar"] : '';
	
	if($estado != '') {
		$link = Conectarse();
		$sql = "UPDATE `pedidos` SET `estado_pedidos`= '$estado' WHERE `id_pedidos` = '$id'";
		$resultado = mysql_query($sql,$link);
		header("location: index.php?op=verPedidos");
	}
	?>
	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
		<?php TraerPedidos_Admin('') ?>
	</div>
</div>
<div class="col-md-6">
	<h3>Pedidos por estado 
		<form method="get" class="fRight" action="index.php?op=verPedidos">
			<input type="hidden" name="op" value="verPedidos">
			<select name="estadoFiltro" onchange="this.form.submit()" >
				<option value="0" <?php if($estadoFiltro == 0) { echo "selected"; } ?> >Pago Pendiente</option>
				<option value="1" <?php if($estadoFiltro == 1) { echo "selected"; } ?> >Pago Exitoso</option>
				<option value="2" <?php if($estadoFiltro == 2) { echo "selected"; } ?> >Pago Erroneo</option>
				<option value="3" <?php if($estadoFiltro == 3) { echo "selected"; } ?> >Pedido Enviado</option>
			</select>
		</form>
	</h3>
	<hr/>
	<?php
	$est = isset($_GET["est"]) ? $_GET["est"] : '0';
	$act = isset($_GET["act"]) ? $_GET["act"] : '';
	$id = isset($_GET["id"]) ? $_GET["id"] : '';
	$estado = isset($_GET["estado"]) ? $_GET["estado"] : '';
	$borrar = isset($_GET["borrar"]) ? $_GET["borrar"] : '';
	
	if($estado != '') {
		$link = Conectarse();
		$sql = "UPDATE `pedidos` SET `estado_pedidos`= '$estado' WHERE `id_pedidos` = '$id'";
		$resultado = mysql_query($sql,$link);
		header("location: index.php?op=verPedidos");
	}
	?>
	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
		<?php TraerPedidos_Admin($estadoFiltro) ?>
	</div>
</div>