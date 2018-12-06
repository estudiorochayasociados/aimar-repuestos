<?php
define("TITULO","AIMAR REPUESTOS");
define("BASE_URL_ANTERIOR","http://192.168.0.14:8888//aimar/repuestos");
define("BASE_URL","http://".$_SERVER['HTTP_HOST']."");
define("TELEFONOS","+54-3564-423407");
define("WHATSAPP","0");/**/
define("EMAIL","info@aimarrepuestos.com.ar");
define("DIRECCION","Colón 1150 - X2400ISX - Ciudad de San Francisco - Provincia de Córdoba - República Argentina");
define("LOGO",BASE_URL."/images/logo.png");
define("PASS_EMAIL","Cp8wC3aTs");
define("SMTP_EMAIL","c1390794.ferozo.com");
define("PUERTO_EMAIL","465");
define("APP_ID_FACEBOOK","687357508322489");
define("META_POSITION","");
define("META_COPY","2018");
define("META_PLACE","");
define("META_PAIS","ARGENTINA");
define("CANONICAL",$_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"]);
define("USUARIO_DB","c1390794_sitio");
define("PASS_DB","faAr2010");
define("BASE_DB","c1390794_sitio");
function Conectarse()
{
    $connId = mysqli_connect("localhost",USUARIO_DB,PASS_DB,BASE_DB) or die("Error en el server".mysqli_error($con));
    mysqli_set_charset($connId,'utf8');
    return $connId;
}

function Conectarse_Mysqli()
{
    $connId = mysqli_connect("localhost",USUARIO_DB,PASS_DB,BASE_DB) or die("Error en el server".mysqli_error($con));
    mysqli_set_charset($connId,'utf8');
    return $connId;
}

function cambiarBase()
{
    $sql_contenido = "UPDATE contenidos SET contenido = REPLACE(contenido, '".BASE_URL_ANTERIOR."', '".BASE_URL."') WHERE contenido LIKE ('%".BASE_URL_ANTERIOR."%');";
    $sql_portfolio = "UPDATE portfolio SET `descripcion_portfolio` = REPLACE(`descripcion_portfolio`, '".BASE_URL_ANTERIOR."', '".BASE_URL."') WHERE `descripcion_portfolio` LIKE ('%".BASE_URL_ANTERIOR."%');";
    $cnx           = Conectarse();
    $r1            = mysqli_query($cnx,$sql_portfolio);
    $r2            = mysqli_query($cnx,$sql_contenido);

    echo $sql_contenido."<br/>";
    echo $sql_portfolio."<br/>";
}
 
//cambiarBase();
?>
