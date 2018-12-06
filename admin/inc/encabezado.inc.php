<?php
session_start();
ob_start();
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>

	<title>ADMINISTRADOR WEB</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700' rel='stylesheet' type='text/css'>

	<!-- Core CSS - Include with every page -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

	<!-- SB Admin CSS - Include with every page -->
	<link href="css/sb-admin.css" rel="stylesheet">

	<!-- Page-Level Plugin CSS - Dashboard -->
	<link href="css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">
	<link href="css/plugins/timeline/timeline.css" rel="stylesheet">

	<meta charset="UTF-8">

	<?php
	include ("dal/data.php");
	include ("inc/zebra_image.php");
	$op = isset($_GET["op"]) ? $_GET["op"] : '';
	$pagina = isset($_GET["pag"]) ? $_GET["pag"] : '';
	?>

	<script>
		function onlyNumbersDano(evt) {
			var keyPressed = (evt.which) ? evt.which : event.keyCode
			return !(keyPressed > 31 && (keyPressed < 48 || keyPressed > 57));
		}

			//onkeypress="return onlyNumbersDano(event)"

			function ValidarNumFloat(e, obj) {
				tecla = (document.all) ? e.keyCode : e.which;
				if (tecla == 8)
					return true;

				Punto = obj.value.split('.');
				if (Punto.length >= 2) {
					patron = /[0-9]/;
				} else
				patron = /[0-9.]/;
				te = String.fromCharCode(tecla);

				return patron.test(te);
			}

			function loadingShow() {
				$('#loading').show();
				$('#form').hide();
			}

			function checkFile(fieldObj) {
				var FileName = fieldObj.value;
				var FileSize = fieldObj.files[0].size;
				var FileTotal = (FileSize.toFixed(2) / 1048576).toFixed(2) + "MB";

				if (FileSize > 1048576) {
					$("#imgError").show(200);
					$("#botonPubli").hide();
					$('#imgError').html("Su imagen pesa aproximadamente" + FileTotal + ", y debería pesar como máximo 0,5MB.");
					return false;
				}
				$("#imgError").hide();
				$("#botonPubli").show(100);

				return true;
			}

			function checkFile2(fieldObj) {
				var FileName = fieldObj.value;
				var FileSize = fieldObj.files[0].size;
				var FileTotal = (FileSize.toFixed(2) / 1048576).toFixed(2) + "MB";

				if (FileSize > 1048576) {
					$("#imgError").show(200);
					$("#botonPubli").hide();
					$('#imgError').html("Pesa " + FileTotal + ", máximo 0,5MB.");
					return false;
				}
				$("#imgError").hide();
				$("#botonPubli").show();

				return true;
			}
		</script>
		<style>
		.loading {
			padding-top: 20%;
			padding-bottom: 10%;
			width: 100%;
			height: 100vh;
			position: absolute;
			top: 0;
			left: 0;
			z-index: 9999;
			font-size: 15px;
			background: rgba(255, 255, 255, 0.9);
			color: #fff;
		}
		.active {
			position: relative;
			top: 5px;
		}
	</style>
</head>
<body>
