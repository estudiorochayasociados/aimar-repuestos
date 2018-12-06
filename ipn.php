 <?php
include "admin/dal/data.php";

require_once "inc/mercadopago/mercadopago.php";

$mp = new MP('1223238149715294', 'wSyOHKGopR9UTGsZkRoSE5KUbwzB7OMh');

if (!isset($_GET["id"], $_GET["topic"]) || !ctype_digit($_GET["id"])) {
    http_response_code(400);
    return;
}

$payment_info = $mp->get_payment_info($_GET["id"]);
if ($payment_info["status"] == 200) {
    $json    = json_encode($payment_info);
    $cod     = $payment_info["response"]["collection"]["external_reference"];
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    mail("facundo@estudiorochayasoc.com.ar", "Notificación " . $cod, $json, $headers);

    if ($payment_info["response"]["collection"]["status"] == "approved") {
        $estado = "1";
    } elseif ($payment_info["response"]["collection"]["status"] == "pending") {
        $estado = "0";
    } elseif ($payment_info["response"]["collection"]["status"] == "rejected") {
        $estado = "2";
    } else {
        $estado = "0";
    }

    $con = Conectarse();

    if ($estado != '' && $cod != '') {
        $sql       = "UPDATE `pedidos` SET `tipo_pedidos`=2,`estado_pedidos`='$estado' WHERE `cod_pedidos`= '$cod'";
        $resultado = mysqli_query($con, $sql);
    }
}
?>