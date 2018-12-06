<div class="row">
	<center>
		<div class="col-lg-3">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-briefcase fa-fw"></i> SOCIOS INSCRIPTOS
				</div>
				<div class="panel-body">
					<div class="row">
						<?php
						$data = TraerDatos_DB("inscriptos_socios");
						echo "<h1 style='font-size:50px;text-align:center'>$data[0] </h1>";
						?>
						<h3>socios registrados</h3>
						<br/>
						<a href="index.php?op=verBases&bajar=inscriptos_socios" class="btn btn-success ">ARMAR ARCHIVO DE SOCIOS</a>
						<br/>
						<br/>
						<a href="index.php?op=verInscriptosS" class="btn  btn-default ">VER DATOS DE USUARIOS</a>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-3">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-briefcase fa-fw"></i> USUARIOS INSCRIPTOS
				</div>
				<div class="panel-body">
					<div class="row">
						<?php $data1 = TraerDatos_DB("inscriptos_usuarios");
						echo "<h1 style='font-size:50px;text-align:center'>$data1[0]</h1>";
						?>
						<h3>usuarios registrados</h3>
						<br/>
						<a href="index.php?op=verBases&bajar=inscriptos_usuarios" class="btn  btn-success" onclick="loadingShow()">ARMAR ARCHIVO DE USUARIOS</a>
						<br/>
						<br/>
						<a href="index.php?op=verInscriptosI" class="btn  btn-default ">VER DATOS DE USUARIOS</a>
					</div>
				</div>
			</div>
		</div>
	</center>
</div>

<?php

if (isset($_GET["bajar"])) {
	include ("../fpdf/fpdf.php");
	switch($_GET["bajar"]) {
		case "inscriptos_socios" :
			$sql = "SELECT `nombre_inscriptosocio`,`socio_inscriptosocio`,`cargo_inscriptosocio`,`cod_inscriptosocio`FROM `inscriptos_socios` ORDER BY nombre_inscriptosocio ASC";
			$link = Conectarse();
			$result = mysql_query($sql, $link);

			$ar = fopen("../dbEx/socios.csv", "w+") or die("Problemas en la creacion");
			$i = 1;

			while ($row = mysql_fetch_array($result)) {
				fputs($ar, $i++ . ") " . iconv('UTF-8', 'windows-1252', strtoupper($row['0'])) . "  -  " . iconv('UTF-8', 'windows-1252', strtoupper($row['1'])) . "  -  " . iconv('UTF-8', 'windows-1252', strtoupper($row['2'])) . "  -  " . iconv('UTF-8', 'windows-1252', strtoupper($row['3'])));
				fputs($ar, "\n");
			}

			fclose($ar);

			echo "
			<div class='clearfix'></div>
			<center class='col-lg-6'>
			<h1>¡AHORA!</h1>
			<a href='../dbEx/socios.csv' target='_blank' class='btn btn-success btn-lg btn-block'>DESCARGAR ARCHIVO BASE SOCIOS</a>
			</center>";
			break;
		case "inscriptos_usuarios" :
			$sql = "SELECT	`nombre_inscripto`, `telefono_inscripto`, `cod_inscripto` FROM `inscriptos_usuarios`";
			$link = Conectarse();
			$result = mysql_query($sql, $link);

			$ar = fopen("../dbEx/usuarios.csv", "w+") or die("Problemas en la creacion");

			while ($row = mysql_fetch_array($result)) {
				fputs($ar, iconv('UTF-8', 'windows-1252', strtoupper($row['0'])) . "  -  " . iconv('UTF-8', 'windows-1252', strtoupper($row['1'])) . "  -  " . iconv('UTF-8', 'windows-1252', strtoupper($row['2'])));
				fputs($ar, "\n");
				$i++;
			}
			
			fputs($ar, "Total de Inscriptos : $i");
			
			fclose($ar);

			echo "
			<div class='clearfix'></div>
			<center class='col-lg-8'>
			<h1>¡AHORA!</h1>
			<a href='../dbEx/usuarios.csv' target='_blank' class='btn btn-success btn-lg btn-block'>DESCARGAR ARCHIVO BASE USUARIOS</a>
			</center>
			";

			break;
	}
}
?>