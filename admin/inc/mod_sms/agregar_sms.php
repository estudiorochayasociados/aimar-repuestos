<?php
include ("dal/sms_data.php");
?>
<script language="JavaScript" type="text/javascript">
	function contador(campo, cuentacampo, limite) {
		if (campo.value.length > limite)
			campo.value = campo.value.substring(0, limite);
		else
			cuentacampo.value = limite - campo.value.length;
	}
</script>
<div class="large-12 columns">
	<h4>Enviar SMS</h4>
	<hr/>
	<a href="index.php?op=agregarBase"  class="button" style="padding:7px;font-size: 13px;float:right">Agregar Base</a>
	<hr/>
	<?php
	$archivoD = isset($_GET["archivo"]) ? $_GET["archivo"] : '';
	$enviar = isset($_GET["enviar"]) ? $_GET["enviar"] : '';

	if ($archivoD != '') {
	$final = '';
	$fila = 0;
	$gestor = fopen("../archivos/csv/$archivoD.csv", "r") or die("Problemas en cargar la base.");
	$crear = fopen("../archivos/csv/$archivoD.txt", "a") or die("Problemas en la creación.");

	while (($datos = fgetcsv($gestor, 1000, ";")) !== FALSE) {
	$celular = $datos[1];
	$nombre = $datos[0];
	$arreglos = array(" ", "+540", "+5490", "+54", "+549", "(0", "(", ")", "-15", "-");
	$celularArreglado = str_replace($arreglos, "", "$celular");
	$largoCel = strlen($celularArreglado);

	if (!empty($celularArreglado)) {
	if (is_numeric($celularArreglado)) {
	if ($largoCel == 10) {
	$final .= "|" . strtolower($nombre) . "-" . $celularArreglado;
	$fila++;
	}
	}
	}

	}

	fputs($crear, $final);
	fclose($crear);
	fclose($gestor);

	$sql = "
	UPDATE `archivos_sms`
	SET `TotalArchivo`='$fila'
	WHERE `TxtArchivo` = '$archivoD'
	";
	$link = ConSms();
	$r = mysql_query($sql, $link);

	/*header("location:index.php?op=agregarMensajes&enviar=$archivoD");*/

	}

	if ($enviar != '') {
		
	

	$crear = fopen("../archivos/csv/$enviar.txt", "r") or die("Problemas en la creación.");

	$data = fgets($crear);

	$datos = explode("|", $data);

	$cantDatos = count($datos);

	?>
	<form method="post">
		<label class="large-5 columns">Mensaje:
			<br/>
			<br/>
			<textarea maxlength="160" name="mensaje" style="height:150px"  onKeyDown="contador(this.form.mensaje,this.form.remLen,125);" onKeyUp="contador(this.form.mensaje,this.form.remLen,125);"></textarea> <span style="float:left;margin:10px 5px 0 0">Te quedan todavía</span>
			<input type="text" name="remLen" style="max-width: 50px;float:left" value="160" readonly>
			<div class="clearfix"></div> <label>
				<input type="submit" value="Enviar" name="enviar" class="button"/>
			</label> </label>
		<label class="large-3 columns"> <h5>Prueba:</h5>
			<hr/>
			<?php
			require_once ("SendSMS.php");
			$sms_username = "estudioroch1";
			$sms_password = "gmMISKIn";

			if (isset($_POST["enviar"])) {
				if (isset($_POST["mensaje"])) {
					$cadena_buscada = '$nombre';
					$cadena_de_texto = $_POST["mensaje"];
					$encontrado = strpos($cadena_de_texto, $cadena_buscada);
					if ($encontrado != '') {
						for ($i = 0; $i < $cantDatos; $i++) {
							if ($datos[$i] != '') {
								$datosFinales = explode("-", $datos[$i]);
								$nombreFinal = ucwords($datosFinales[0]);
								$phone = "54" . $datosFinales[1];
								$mensaje = str_replace("$cadena_buscada", "$nombreFinal", "$cadena_de_texto");

								print "Initialising library...\n";
								print "Library initialised.\n";
								$destination = $phone;
								$source = "3564570789";
								$message = $mensaje;
								print "Sending message...\n";
								$responses = send_sms($destination, $source, $message) or die("Error: " . $errstr . "\n");
								print "Message sent.\n";

								# Print the response to the screen
								print "Responses from the server:\n";
								foreach ($responses as $response) {
									echo "\t$response\n";
								}

							}
						}
						echo $mensaje;
					} else {
						for ($i = 0; $i < $cantDatos; $i++) {
							if ($datos[$i] != '') {
								$datosFinales = explode("-", $datos[$i]);
								$phone = "54" . $datosFinales[1];
								$mensaje = $cadena_de_texto;

								print "Initialising library...\n";
								print "Library initialised.\n";
								$destination = $phone;
								$source = $phone;
								$message = $mensaje;
								print "Sending message...\n";
								$responses = send_sms($destination, $source, $message) or die("Error: " . $errstr . "\n");
								print "Message sent.\n";

								# Print the response to the screen
								print "Responses from the server:\n";
								foreach ($responses as $response) {
									echo "\t$response\n";
								}
							}
						}

						echo $mensaje;
					}
				}
			}
			?></label>
		<label class="large-3 columns"><h5>Instrucciones de uso avanzado:</h5>
			<hr/>
			* Uso de variable de nombre ($nombre)
			<br>
			<br>
			* Caracteres Máximos 160 caract.)</label>

	</form>
	<?php
	fclose($crear);
	}
	?>
</div>
<?php
# Example PHP code to send an SMS to the recipient '447000000001', with sender set to 'James' and message 'Hello'.
/*
 print "Initialising library...\n";
 require_once("SendSMS.php");
 # Set global username and password for use by the library
 $sms_username = "estudioroch1";
 $sms_password = "gmMISKIn";
 print "Library initialised.\n";

 # Send a message to 447000000001 with sender 'James' and message 'Hello'
 # SourceTON (type of number) will be set automatically by the library.
 $destination = "543564570789";
 $source = "2020";
 $message = "Prueba 1";
 print "Enviando Mensaje...\n";
 $responses = send_sms($destination, $source, $message) or die ("Error: " . $errstr . "\n");
 print "Mensaje Enviado.\n";

 # Print the response to the screen
 print "Responses from the server:\n";
 foreach ($responses as $response) {
 echo "\t$response\n";
 }//*/
?>