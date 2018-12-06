<?php
include 'cnx.php';

$op = isset($_GET['op']) ? $_GET['op'] : '';
$pagina = isset($_GET['pag']) ? $_GET['pag'] : '';
$_SESSION["descuento"] = isset($_SESSION["user"]["descuento"]) ? $_SESSION["user"]["descuento"] : 0;

if (isset($_SESSION["user"])) {
    Revisar_Tipo_Lista($_SESSION["user"]["id"]);
}


/****************************** READ DE TABLAS */

function Contenidos_Read()
{
    $idConn = Conectarse();
    $sql = "
    SELECT *
    FROM contenidos
    ORDER BY id ASC
    ";
    $resultado = mysqli_query($idConn, $sql);
    //Carga del array de datos

    while ($row = mysqli_fetch_array($resultado)) {
        $codigo = $row['codigo'];
        ?>
        <tr>
            <td class="maxwidth">
                <?php echo ($row['id']) ?>
            </td>
            <td style="text-transform:uppercase">
                <?php echo strtoupper($codigo) ?>
            </td>
            <td>
                <center>
                    <a href="index.php?op=modificarContenidos&id=<?php echo $row['id'] ?>" style="width:20px" data-toggle="tooltip" alt="Modificar" title="Modificar">
                        <i class="glyphicon glyphicon-cog" >
                        </i>
                    </a>

                </center>
            </td>
        </tr>
        <?php

    }
}

function Productos_Sin_Imagen()
{
    $idConn = Conectarse();
    $sql = "
    SELECT *
    FROM productos
    ORDER BY id DESC
    ";
    $resultado = mysqli_query($idConn, $sql);
    $contar = mysqli_num_rows($resultado);
    $i=0;
    while ($row = mysqli_fetch_array($resultado)) {
        $ruta_mostrar = '<b>Guardar en</b>: '.$row["rubro"].'/'.str_replace("/","-",$row["codigo_para_web"]).'.jpg';
        $ruta = '../archivos/productos/'.$row["rubro"].'/'.str_replace("/","-",$row["codigo_para_web"]).'.jpg';
        if(is_file($ruta) === false){
            $i++;
            $codigo = $row['codigo_para_web'];
            $descripcion = $row['descripcion'];
            ?>
            <tr>
                <td style="text-transform:uppercase">
                    <?php echo strtoupper($codigo); ?>
                </td>
                <td style="text-transform:uppercase">
                    <?php echo strtoupper($descripcion); ?>
                </td>
                <td>
                    <?php echo $ruta_mostrar; ?>
                </td>
            </tr>
            <?php
        }        
    }
    echo "Hay <b>".$i."</b> productos sin imágenes";
}

function Contenido_AdminTraerPorId($id)
{
    $sql = "SELECT *
    FROM contenidos
    WHERE id = '$id'";
    $link = Conectarse();
    $result = mysqli_query($link, $sql);
    $data = mysqli_fetch_array($result);

    return $data;
}


function Contenido_TraerPorId($id)
{
    $sql = "SELECT *
    FROM contenidos
    WHERE codigo = '$id'";
    $link = Conectarse();
    $result = mysqli_query($link, $sql);
    $data = mysqli_fetch_array($result);

    return $data;
}


function Traer_Contenidos($codigo)
{
    $sql = "SELECT *
    FROM contenidos
    WHERE codigo = '$codigo'";
    $link = Conectarse();
    $result = mysqli_query($link, $sql);
    while ($data = mysqli_fetch_array($result)) {
        echo $data["contenido"];
    }
}

function Traer_Productos($codigo)
{
    $sql = "SELECT *
    FROM contenidos
    WHERE codigo = '$codigo'";
    $link = Conectarse();
    $result = mysqli_query($link, $sql);
    while ($data = mysqli_fetch_array($result)) {
        echo $data["contenido"];
    }
}

function Categoria_Read()
{
    $idConn = Conectarse_Mysqli();
    $sql = "
    SELECT *
    FROM categorias
    ORDER BY id_categoria DESC
    ";
    $resultado = mysqli_query($idConn, $sql);

    while ($row = mysqli_fetch_array($resultado)) {
        $id = $row['id_categoria'];
        ?>
        <tr>
            <td>
                <?php echo $id; ?>
            </td>
            <td style="text-transform:uppercase">
                <?php echo $row['nombre_categoria'] ?>
            </td>
            <td style="text-transform:uppercase">
                <?php echo $row['rubro_categoria'] ?>
            </td>
            <td style="text-transform:uppercase">
                <?php echo $row['filtro_categoria'] ?>
            </td>
            <td>
                <a href="index.php?op=modificarCategoria&id=<?php echo $row['id_categoria'] ?>" data-toggle="tooltip" alt="Modificar" title="Modificar">
                    <i class="glyphicon glyphicon-cog">
                    </i>
                </a>
                <a href="index.php?op=verCategoria&borrar=<?php echo $row["id_categoria"] ?>" onClick="return confirm('¿Seguro querés eliminar?')" data-toggle="tooltip" alt="Eliminar" title="Eliminar">
                    <i class="glyphicon glyphicon-trash">
                    </i>
                </a>
            </td>
        </tr>
        <?php

    }
}

function Rubros_Read()
{
    $idConn = Conectarse_Mysqli();
    $sql = "
    SELECT *
    FROM rubros
    ORDER BY cod_rubros ASC
    ";
    $resultado = mysqli_query($idConn, $sql);

    while ($row = mysqli_fetch_array($resultado)) {
        $id = $row['cod_rubros'];
        ?>
        <tr>
            <td>
                <?php echo $id; ?>
            </td>
            <td style="text-transform:uppercase">
                <?php echo substr(strtoupper($row['titulo_rubros']), 0, 50) ?>
            </td>
            <td>
                <a href="index.php?op=modificarRubro&id=<?php echo $row['id_rubros'] ?>" data-toggle="tooltip" alt="Modificar" title="Modificar">
                    <i class="glyphicon glyphicon-cog">
                    </i>
                </a>
                <a href="index.php?op=verRubro&borrar=<?php echo $row["id_rubros"] ?>" onClick="return confirm('¿Seguro querés eliminar el rubro?')" data-toggle="tooltip" alt="Eliminar" title="Eliminar">
                    <i class="glyphicon glyphicon-trash">
                    </i>
                </a>
            </td>
        </tr>
        <?php

    }
}

function Traer_Contenidos_index($codigo)
{
    $sql = "SELECT *
    FROM contenidos
    WHERE codigo = '$codigo'";
    $link = Conectarse();
    $result = mysqli_query($link, $sql);
    while ($data = mysqli_fetch_array($result)) {
        ?>

        <a href="#">
            <h1>
                <?php echo $data["codigo"] ?>
            </h1>
            <div>
                <?php echo $data["contenido"] ?>
            </div>
        </a>

        <?php

    }
}



function Categoria_Read_Option($categoria)
{
    $idConn = Conectarse_Mysqli();
    $sql = "SELECT * FROM categorias ORDER BY nombre_categoria ASC";
    $resultado = mysqli_query($idConn, $sql);
    while ($row = mysqli_fetch_array($resultado)) {
        ?>
    <option value="<?php echo $row["rubro_categoria"] ?>" <?php
    if ($categoria == $row['rubro_categoria']) {
        echo "selected";
    } ?>>
    <?php echo $row["nombre_categoria"] ?>
</option>
<?php

}
}

function Subcategoria_Read()
{
    $idConn = Conectarse_Mysqli();
    $sql = "
    SELECT *
    FROM subcategorias,categorias
    WHERE id_categoria = categoria_subcategoria
    ORDER BY id_subcategoria DESC
    ";
    $resultado = mysqli_query($idConn, $sql);

    while ($row = mysqli_fetch_array($resultado)) {
        $id = $row['id_subcategoria'];
        $categoria = $row['nombre_categoria'];
        ?>
        <tr>
            <td>
                <?php echo $id; ?>
            </td>
            <td style="text-transform:uppercase">
                <?php echo substr(strtoupper($row['nombre_subcategoria']), 0, 50) ?>
            </td>
            <td style="text-transform:uppercase">
                <?php echo substr(strtoupper($categoria), 0, 50) ?>
            </td>
        </td>
        <td>
            <a href="index.php?op=modificarSubcategoria&id=<?php echo $row['id_subcategoria'] ?>" data-toggle="tooltip" alt="Modificar" title="Modificar">
                <i class="glyphicon glyphicon-cog">
                </i>
            </a>
            <a href="index.php?op=verSubcategoria&borrar=<?php echo $row["id_subcategoria"] ?>" onClick="return confirm('¿Seguro querés eliminar el producto?')" data-toggle="tooltip" alt="Eliminar" title="Eliminar">
                <i class="glyphicon glyphicon-trash">
                </i>
            </a>
        </td>
    </tr>
    <?php

}
}

function Financiacion_Read()
{
    $idConn = Conectarse();
    $sql = "SELECT * FROM `financiacion` ORDER BY id_financiacion DESC";
    $resultado = mysqli_query($idConn, $sql);

    while ($row = mysqli_fetch_array($resultado)) {
        ?>
        <tr>
            <td>
                <?php echo strtoupper($row["id_financiacion"]) ?>
            </td>
            <td>
                <?php echo strtoupper($row["banco_financiacion"]) ?>
            </td>
            <td style="text-align: right">
                <a href="index.php?op=modificarFinanciacion&id=<?php echo $row["id_financiacion"] ?>" data-toggle="tooltip" alt="Modificar" title="Modificar" >
                    <i class="glyphicon glyphicon-cog">
                    </i>
                </a>
                <a href="index.php?op=verFinanciacion&borrar=<?php echo $row["cod_financiacion"] ?>" data-toggle="tooltip" alt="Eliminar" title="Eliminar" onClick="return confirm('¿Seguro querés eliminar el video?')" >
                    <i class="glyphicon glyphicon-trash">
                    </i>
                </a>
            </td>
        </tr>
        <?php

    }
}

function mEnvio($ca_subtotal, $zip, $dimensions)
{
    require_once('mercadopago/mercadopago.php');
    $path = "http://" . $_SERVER["SERVER_NAME"] . "/";
    $mp = new MP('1825498612181369', 'GFpgYd6Gz8yDnOxZdzpCZE4w4qJJS6aC');

    if (strlen($dimensions) < 9) {
        $dimensions = "30x30x30, 500";
    }

    $params = array(
        "dimensions" => $dimensions,//"30x30x30,500",
        "item_price" => $ca_subtotal, "zip_code" => $zip
    );


    $response = $mp->get("/shipping_options", $params);
    $shipping_options = $response['response']['options'];
    $cost = round($shipping_options[0]['list_cost'], 2);
    return $cost;
}


function Financiacion_Read_Front()
{
    $idConn = Conectarse();
    $sql = "SELECT * FROM `financiacion` ORDER BY id_financiacion DESC";
    $resultado = mysqli_query($idConn, $sql);
    $i = 0;
    while ($row = mysqli_fetch_array($resultado)) {
        $cod = $row["cod_financiacion"];
        $sql2 = "SELECT * FROM `imagenes` WHERE `codigo` = '$cod'";
        $res = mysqli_query($idConn, $sql2);
        $imagen = mysqli_fetch_row($res);

        if (is_file($imagen[1])) {
            $imagenFinal = $imagen[1];
        } else {
            $imagenFinal = "img/sin_imagen.jpg";
        }
        ?>
        <div class="col-md-2 col-xs-12" data-toggle="modal" data-target="#myModal<?php echo $row["id_financiacion"] ?>" >
            <div class="thumbnail" style="background:url('<?php echo $imagenFinal ?>') no-repeat center center;background-size:75%;height:200px;padding:10px">
            </div>
        </div>
        <div class="modal fade" id="myModal<?php echo $row["id_financiacion"] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">
                                &times;
                            </span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">
                            <?php echo strtoupper($row["banco_financiacion"]) ?>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <img src='<?php echo $imagenFinal ?>' class="fleft" style="margin:10px;width:200px"  />
                        <?php echo $row["desarrollo_financiacion"] ?>
                        <div class="clearfix">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $i++;
    }
}


function Suscripto_TraerPorId($email)
{
    $sql = "SELECT *
    FROM suscriptobase
    WHERE EmailSuscriptos LIKE '%$email%'";
    $link = Conectarse();
    $result = mysqli_query($link, $sql);
    $data = mysqli_fetch_array($result);

    return $data;
}

function Testimonio_TraerPorId($id)
{
    $sql = "SELECT *
    FROM testimonios
    WHERE id_testimonios = '$id'";
    $link = Conectarse();
    $result = mysqli_query($link, $sql);
    $data = mysqli_fetch_array($result);

    return $data;
}



function Contacto_Read($pag)
{
    $limit = "";

    if ($pag == "inicio") {
        $limit = "LIMIT 0,10";
    } else {
        $limit = "";
    }

    $idConn = Conectarse();
    $sql = "SELECT * FROM `contacto` ORDER BY  IdContacto Desc, EstadoContacto ASC $limit";
    $resultado = mysqli_query($idConn, $sql);

    while ($row = mysqli_fetch_array($resultado)) {

        $date = explode("-", $row["FechaContacto"]);
        ?>
        <tr>
            <td>
                <?php echo $date[2] . "/" . $date[1] . "/" . $date[0] ?>
            </td>
            <td>
                <?php echo strtoupper($row["NombreContacto"] . " " . $row["ApellidoContacto"]) ?>
            </td>
            <td style="text-transform: none">
                <?php echo strtolower($row["EmailContacto"]) ?>
            </td>
            <td>
                <?php echo $row["TelefonoContacto"] ?>
            </td>
            <td>
                <?php echo $row["CelularContacto"] ?>
            </td>
            <td>
                <?php echo $row["MensajeContacto"] ?>
            </td>
            <td style="text-align: right">
                <a href=<?php echo 'mailto:' . $row["EmailContacto"] . '?Subject=Respuesta%20a%20la%20Consulta%20TV5' ?> style="margin:5px">
                    <span class="glyphicon glyphicon-envelope">
                    </span>
                </a>
                <?php
                if ($row["EstadoContacto"] != 0) {
                    ?>
                    <a href="index.php?op=verContacto&borrar=<?php echo $row["IdContacto"] ?>&upd=0" style="margin:5px">
                        <span class="glyphicon glyphicon-ok">
                        </span>
                    </a>
                    <?php

                } else {
                    ?>
                    <a href="index.php?op=verContacto&borrar=<?php echo $row["IdContacto"] ?>&upd=1" style="margin:5px">
                        <span class="glyphicon glyphicon-time">
                        </span>
                    </a>
                    <?php

                } ?>
            </td>
        </tr>
        <?php

    }
}

function Suscriptos_Read($promo)
{

    $idConn = Conectarse();
    $sql = "SELECT * FROM `suscriptos` WHERE PromoSuscripto = $promo ORDER BY  IdSuscripto Desc, EstadoSuscripto ASC";
    $resultado = mysqli_query($idConn, $sql);

    while ($row = mysqli_fetch_array($resultado)) {
        $fecha = explode(" ", $row["FechaSuscripto"]);
        $date = explode("-", $fecha[0]);
        ?>
        <tr>
            <td>
                <?php echo $date[2] . "/" . $date[1] . "/" . $date[0] . " " . $fecha[1] ?>
            </td>
            <td>
                <?php echo strtoupper($row["NombreSuscripto"]) ?>
            </td>
            <td style="text-transform: none">
                <?php echo strtolower($row["EmailSuscripto"]); ?>
            </td>
            <td>
                <?php echo $row["TelefonoSuscripto"]; ?>
            </td>
            <td>
                <?php echo $row["DireccionSuscripto"]; ?>
            </td>
            <td style="text-align: right">
                <a href=<?php echo 'mailto:' . $row["EmailSuscripto"] . '?Subject=Respuesta%20a%20la%20Suscripción%20TV5' ?> style="margin:5px">
                    <span class="glyphicon glyphicon-envelope">
                    </span>
                </a>
                <?php
                if ($row["EstadoSuscripto"] != 0) {
                    ?>
                    <a href="index.php?op=verSuscriptos&promo=<?php echo $promo ?>&borrar=<?php echo $row["IdSuscripto"] ?>&upd=0" style="margin:5px">
                        <span class="glyphicon glyphicon-ok">
                        </span>
                    </a>
                    <?php

                } else {
                    ?>
                    <a href="index.php?op=verSuscriptos&promo=<?php echo $promo ?>&borrar=<?php echo $row["IdSuscripto"] ?>&upd=1" style="margin:5px">
                        <span class="glyphicon glyphicon-time">
                        </span>
                    </a>
                    <?php

                } ?>
                <a href="index.php?op=verSuscriptos&promo=<?php echo $promo ?>&borrar=<?php echo $row["IdSuscripto"] ?>" style="margin:5px">
                    <span class="glyphicon glyphicon-trash">
                    </span>
                </a>
            </td>
        </tr>
        <?php

    }
}

function Inscriptos_Read($pag)
{
    $limit = '';
    if ($pag == "inicio") {
        $limit = "LIMIT 0,10";
    }

    $idConn = Conectarse();
    $sql = "SELECT * FROM `inscriptos_socios` ORDER BY fecha_inscriptosocio DESC $limit ";
    $resultado = mysqli_query($idConn, $sql);

    while ($row = mysqli_fetch_array($resultado)) {
        $fecha = explode(" ", $row["fecha_inscriptosocio"]);
        $date = explode("-", $fecha[0]);
        ?>
        <tr>
            <td>
                <?php echo $date[2] . "/" . $date[1] . "/" . $date[0] . " " . $fecha[1]; ?>
            </td>
            <td>
                <?php echo $row["socio_inscriptosocio"] ?>
            </td>
            <td>
                <?php echo strtoupper($row["nombre_inscriptosocio"]) ?>
            </td>
            <td class="hidden-xs">
                <?php echo strtoupper($row["cargo_inscriptosocio"]) ?>
            </td>
            <td class="hidden-xs" style="text-transform: none">
                <?php echo strtolower($row["email_inscriptosocio"]) ?>
            </td>
            <td style="text-align: center">
                <a href="../<?php echo $row["invitacion_inscriptosocio"]; ?>" target="_blank" style="margin:5px">
                    <span class="glyphicon glyphicon-file">
                    </span>
                </a>
                <a href=<?php echo 'mailto:' . $row["email_inscriptosocio"] . '?Subject=Respuesta%20a%20la%20Consulta%20Evento%20Acorca' ?> style="margin:5px">
                    <span class="glyphicon glyphicon-envelope">
                    </span>
                </a>
                <?php
                if ($row["estado_inscriptosocio"] != 0) {
                    ?>
                    <a href="index.php?op=verInscriptosS&borrar=<?php echo $row["id_inscriptosocio"] ?>&upd=0" style="margin:5px">
                        <span class="glyphicon glyphicon-ok">
                        </span>
                    </a>
                    <?php

                } else {
                    ?>
                    <a href="index.php?op=verInscriptosS&borrar=<?php echo $row["id_inscriptosocio"] ?>&upd=1" style="margin:5px">
                        <span class="glyphicon glyphicon-time">
                        </span>
                    </a>
                    <?php

                } ?>
                <a href="index.php?op=verInscriptosS&elim=<?php echo $row["id_inscriptosocio"] ?>" style="margin:5px" title="Borrar">
                    <span class="glyphicons glyphicon glyphicon-remove-circle">
                    </span>
                </a>
            </td>
        </tr>
        <?php

    }
}

function Usuarios_Inscriptos_Read($pag)
{
    $limit = "";
    if ($pag == "inicio") {
        $limit = "LIMIT 0,10";
    }

    $idConn = Conectarse();
    $sql = "SELECT * FROM `inscriptos_usuarios` ORDER BY fecha_inscripto  DESC $limit ";
    $resultado = mysqli_query($idConn, $sql);

    while ($row = mysqli_fetch_array($resultado)) {
        $fecha = explode(" ", $row["fecha_inscripto"]);
        $date = explode("-", $fecha[0]);
        ?>
        <tr>
            <td>
                <?php echo $date[2] . "/" . $date[1] . "/" . $date[0] . " " . $fecha[1]; ?>
            </td>
            <td>
                <?php echo strtoupper($row["nombre_inscripto"]) ?>
            </td>
            <td class="hidden-xs">
                <?php echo $row["empresa_inscripto"] ?>
            </td>
            <td  class="hidden-xs"  style="text-transform: none">
                <?php echo $row["telefono_inscripto"] ?>
            </td>
            <td  style="text-transform: none">
                <?php echo $row["celular_inscripto"] ?>
            </td>
            <td class="hidden-xs" style="text-transform: none">
                <?php echo strtolower($row["email_inscripto"]) ?>
            </td>

            <td class="hidden-xs" style="text-transform: none">
                <?php echo $row["localidad_inscripto"] ?>
            </td>
            <td class="hidden-xs"  style="text-transform: none">
                <?php echo $row["provincia_inscripto"] ?>
            </td>
            <td style="text-align: center">
                <a href="index.php?op=verInscriptosI&email=<?php echo $row["email_inscripto"] ?>&archivo=<?php echo $row["invitacion_inscripto"]; ?>"  style="margin:5px" title="Reenviar Invitación">
                    <span class="fa fa-share-square fa-fw">
                    </span>
                </a>
                <a href="../<?php echo $row["invitacion_inscripto"]; ?>" target="_blank" style="margin:5px" title="Ver Invitación">
                    <span class="glyphicon glyphicon-file">
                    </span>
                </a>
                <a href=<?php echo 'mailto:' . $row["email_inscripto"] . '?Subject=Respuesta%20a%20la%20Consulta%20Evento%20Acorca' ?> title="Enviar Email" style="margin:5px">
                    <span class="glyphicon glyphicon-envelope">
                    </span>
                </a>
                <?php
                if ($row["estado_inscripto"] != 0) {
                    ?>
                    <a href="index.php?op=verInscriptosI&borrar=<?php echo $row["id_inscripto"] ?>&upd=0" style="margin:5px" title="Cerrado!">
                        <span class="glyphicon glyphicon-ok">
                        </span>
                    </a>
                    <?php

                } else {
                    ?>
                    <a href="index.php?op=verInscriptosI&borrar=<?php echo $row["id_inscripto"] ?>&upd=1" style="margin:5px" title="Esperando...">
                        <span class="glyphicon glyphicon-time">
                        </span>
                    </a>
                    <?php

                } ?>
                <a href="index.php?op=verInscriptosI&elim=<?php echo $row["id_inscripto"] ?>" style="margin:5px" title="Borrar">
                    <span class="glyphicons glyphicon glyphicon-remove-circle">
                    </span>
                </a>
            </td>
        </tr>
        <?php

    }
}

function Videos_Read()
{
    $idConn = Conectarse();
    $sql = "SELECT * FROM videos ORDER BY IdVideos DESC";
    $resultado = mysqli_query($idConn, $sql);
    //Carga del array de datos

    while ($row = mysqli_fetch_array($resultado)) {
        if ($row['CategoriaVideos'] == 1) {
            $categoria = "Nutrición";
            $verMas = "nutricion";
        } elseif ($row['CategoriaVideos'] == 2) {
            $categoria = "Conservación de Forrajes";
            $verMas = "forrajes";
        } elseif ($row['CategoriaVideos'] == 3) {
            $categoria = "Efluentes";
            $verMas = "efluentes";
        }
        ?>
        <tr>
            <td>
                <?php echo $row['TituloVideos'] ?>
            </td>
            <td>
                <?php echo $categoria ?>
            </td>
            <td>
                <div style="width:60px;margin: auto;display:block">
                    <a href="index.php?op=modificarVideos&id=<?php echo $row['IdVideos'] ?>" style="width:20px" data-toggle="tooltip" alt="Modificar" title="Modificar">
                        <i class="glyphicon glyphicon-cog" >
                        </i>
                    </a>
                    <a href="index.php?op=verVideos&borrar=<?php echo $row['IdVideos'] ?>" style="width:20px" data-toggle="tooltip" alt="Eliminar" title="Eliminar" onClick="return confirm('¿Seguro querés eliminar el video?')" >
                        <i class="glyphicon glyphicon-trash">
                        </i>
                    </a>
                </div>
            </td>
        </tr>
        <?php

    }
}

function Testimonio_Read()
{
    $idConn = Conectarse();
    $sql = "SELECT * FROM testimonios ORDER BY id_testimonios DESC";
    $resultado = mysqli_query($idConn, $sql);

    while ($row = mysqli_fetch_array($resultado)) {
        ?>
        <tr>
            <td>
                <?php echo $row['usuario_testimonios'] ?>
            </td>
            <td>
                <?php echo $row['texto_testimonios'] ?>
            </td>
            <td>
                <div style="width:60px;margin: auto;display:block">
                    <a href="index.php?op=modificarTestimonio&id=<?php echo $row['id_testimonios'] ?>" style="width:20px" data-toggle="tooltip" alt="Modificar" title="Modificar">
                        <i class="glyphicon glyphicon-cog" >
                        </i>
                    </a>
                    <a href="index.php?op=verTestimonio&borrar=<?php echo $row['id_testimonios'] ?>" style="width:20px" data-toggle="tooltip" alt="Eliminar" title="Eliminar" onClick="return confirm('¿Seguro querés eliminar el testimonio?')" >
                        <i class="glyphicon glyphicon-trash">
                        </i>
                    </a>
                </div>
            </td>
        </tr>

        <?php

    }
}


function Testimonio_Read_Front()
{
    $idConn = Conectarse();
    $sql = "SELECT * FROM testimonios ORDER BY id_testimonios DESC";
    $resultado = mysqli_query($idConn, $sql);

    while ($row = mysqli_fetch_array($resultado)) {
        ?>
        <div class="testimonios col-md-4">
            <div>
                <h1>
                    "<?php echo $row['texto_testimonios'] ?>"
                </h1>
                <h2>
                    <i class="fa fa-user">
                        </i><?php echo $row['usuario_testimonios'] ?>
                    </h2>
                </div>
            </div>
            <?php

        }
    }



    function Videos_Read_Front()
    {
        $idConn = Conectarse();
        $sql = "SELECT * FROM videos ORDER BY IdVideos DESC";
        $resultado = mysqli_query($idConn, $sql);
    //Carga del array de datos

        while ($row = mysqli_fetch_array($resultado)) {
            ?>
            <div class="column c-33 clearfix">
                <div class="box" style="height:270px">
                    <h4>
                        <?php echo $row["TituloVideos"] ?>
                    </h4>
                    <div class="boxInfo">
                        <iframe width="100%" height="150px" src="//www.youtube.com/embed/<?php echo $row["UrlVideos"] ?>" frameborder="0" allowfullscreen>
                        </iframe>

                    </div>
                </div>
            </div>
            <?php

        }
    }

    function Videos_Read_Front_Lauti()
    {
        $idConn = Conectarse();
        $sql = "SELECT * FROM videos ORDER BY IdVideos DESC";
        $resultado = mysqli_query($idConn, $sql);
    //Carga del array de datos

        while ($row = mysqli_fetch_array($resultado)) {
            ?>
            <div class="column c-33 clearfix">
                <div class="box" style="height:270px">
                    <h4>
                        <?php echo $row["TituloVideos"] ?>
                    </h4>
                    <div class="boxInfo">
                    </div>
                </div>
            </div>
            <?php

        }
    }

    function Videos_Read_Side()
    {
        $idConn = Conectarse();
        $sql = "SELECT * FROM videos ORDER BY RAND() LIMIT 0,1";
        $resultado = mysqli_query($idConn, $sql);
        while ($row = mysqli_fetch_array($resultado)) {
            ?>
            <iframe width="100%" height="250px" src="//www.youtube.com/embed/<?php echo $row["UrlVideos"] ?>" frameborder="0" allowfullscreen>
            </iframe>
            <?php

        }
    }

    function Slider_Read($tipo)
    {
        $idConn = Conectarse();
        $sql = "SELECT * FROM sliderbase WHERE TipoSlider='$tipo' ORDER BY IdSlider DESC";
        $resultado = mysqli_query($idConn, $sql);
        $i = 0;
        while ($row = mysqli_fetch_array($resultado)) {
            $pos = strpos($row["LinkSlider"], "http");

            $titulo = trim($row["TituloSlider"]);
            $subtitulo = trim($row["SubtituloSlider"]);
            if ($tipo == "marcas") {
                ?>
                <div style='background:url(<?php echo BASE_URL; ?>/<?php echo $row["ImgSlider"] ?>) no-repeat center center;background-size:60%;padding:20px;width: 100px;height:100px;'>
                </div>
                <?php

            } else {
                ?>
                
                <div class="item <?php if ($i == 0) { echo 'active'; } ?>" style="background:url(<?php echo BASE_URL; ?>/<?php echo $row["ImgSlider"] ?>) no-repeat center center/cover;height: 650px;width: 100%">
                    <a href="<?php if($row['LinkSlider'] != '') { echo BASE_URL.'/'.$row['LinkSlider']; } else { echo '#'; } ?>">
                        <div style="width: 100%;height: 100%;"></div>
                    </a>
                </div>

                <?php

            }
            $i++;
        }
    }

    function Slider_Read_Index_Productos()
    {
        $idConn = Conectarse();
        $sql = "SELECT * FROM productos ORDER BY id DESC LIMIT 8";
        $resultado = mysqli_query($idConn, $sql);
        $i = 0;
        while ($row = mysqli_fetch_array($resultado)) {
            $car = array(" ", "?", "-", "%");
            $urlLink = mb_strtolower(trim(normaliza_acentos($row["titulo"])));
            $cod = $row["codigo_para_web"];
            if (@getimagesize(BASE_URL . "/archivos/productos/".$row["rubro"]."/". $cod . ".jpg")) {
                $imagen = BASE_URL . "/archivos/productos/".$row["rubro"]."/". $cod . ".jpg";
            } else {
                $imagen = BASE_URL . "/img/sin_imagen.jpg";
            }
            ?>
            <div class="col-md-3 col-xs-6 itemProducto">
                <div class="">
                    <figure>
                        <a href="<?php echo BASE_URL ?>/producto/<?php echo $urlLink ?>">
                            <div class="imgVistos2" style="background-image:url('<?php echo $imagen; ?>');">
                            </div>
                        </a>
                    </figure>
                    <hr/>
                    <div class="white-background team-desc-block">
                        <ul class=" text-center clean-list" >
                            <li class="cat-item cat-item-1">
                                <a href="<?php echo BASE_URL ?>/producto/<?php echo $urlLink ?>">
                                    <?php echo $row["descripcion"] ?>
                                </a>
                            </li>
                            <li class="cat-item cat-item-1">
                                <a href="<?php echo BASE_URL ?>/producto/<?php echo $urlLink ?>" class="precio" >
                                    $<?php echo $row['precio'] ?>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php
            $i++;
        }
    }

    function Slider_Read_Marcas($tipo)
    {
        $idConn = Conectarse();
        $sql = "SELECT * FROM sliderbase WHERE TipoSlider='$tipo' ORDER BY IdSlider DESC";
        $resultado = mysqli_query($idConn, $sql);
        $i = 0;
        while ($row = mysqli_fetch_array($resultado)) {
            $pos = strpos($row["LinkSlider"], "http");

            $titulo = trim($row["TituloSlider"]);
            $subtitulo = trim($row["SubtituloSlider"]);
            ?>
            <div class="item <?php
            if ($i == '0') echo 'active' ?>">
            <div class="col-md-2 col-sm-6 col-xs-12">
                <a href="#">
                    <img src="<?php echo BASE_URL; ?>/<?php echo $row["ImgSlider"] ?>" class="img-responsive">
                </a>
            </div>
        </div>
        <?php
        $i++;
    }
}


function Slider_Read_Admin()
{
    $idConn = Conectarse();
    $sql = "SELECT * FROM sliderbase ORDER BY IdSlider DESC";
    $resultado = mysqli_query($idConn, $sql);
    //Carga del array de datos
    $i = 0;
    while ($row = mysqli_fetch_array($resultado)) {
        ?>
        <tr>
            <td>
                <?php echo $row['IdSlider'] ?>
            </td>
            <td>
                <?php echo $row['TituloSlider'] ?>
            </td>
            <td>
                <?php echo $row['TipoSlider'] ?>
            </td>
            <td>
                <center>
                    <?php
                    switch ($row['EstadoSlider']) {
                        case 0:
                        ?>
                        <a href="index.php?op=verSlider&upd=1&borrar=<?php echo $row[0] ?>" id="tooltip<?php echo $i++ ?>" style="width:20px">
                            <i class="glyphicon glyphicon-ok-circle" >
                            </i>
                            </a><?php
                            break;
                            case 1:
                            ?>
                            <a href="index.php?op=verSlider&upd=0&borrar=<?php echo $row[0] ?>" id="tooltip<?php echo $i++ ?>" style="width:20px">
                                <i class="glyphicon glyphicon-ban-circle" >
                                </i>
                                </a><?php
                                break;
                            }
                            ?>
                        </center>
                    </td>
                    <td>
                        <center>
                            <a href="index.php?op=modificarSlider&id=<?php echo $row[0] ?>" >
                                <i class="glyphicon glyphicon-cog">
                                </i>
                            </a>
                            <a href="index.php?op=verSlider&borrar=<?php echo $row[0] ?>" >
                                <i class="glyphicon glyphicon-trash">
                                </i>
                            </a>
                        </center>
                    </td>
                </tr>

                <?php

            }
        }


        function Leer_Pedidos($id_usuario)
        {
            $idConn = Conectarse();
            $sql = "SELECT * FROM pedidos WHERE usuario_pedido =  '2' ORDER BY estado_pedido ASC";
            $resultado = mysqli_query($idConn, $sql);
    //Carga del array de datos
            $i = 0;
            while ($row = mysqli_fetch_array($resultado)) {
                ?>

                <li class="listado" <?php
                if ($row["estado_pedido"] == 1) {
                    echo "style='background:#4393C3'";
                } else {
                    echo "style='background:#2166AC'";
                }
                ?>>
                <p>
                    <?php echo "Pedido &rarr; " . strtoupper($row["categoria_pedido"]) . "<br/>Solicitado &rarr; " . $row["fecha_pedidos"] ?>
                </p>
                <button onclick=($("#pedido<?php echo $i ?>").slideToggle('500'))>
                    Ver +
                </button>
            </li>
            <span class="listadoSpan" id="pedido<?php echo $i ?>" style="display:none">
                <?php echo $row["contenido_pedido"] ?>
                <?php
                if ($row["estado_pedido"] == 1) {
                    echo "Presupuesto &rarr; $" . $row["costo_pedido"] . " <a href='pedido.php?op=pagar'>PAGAR</a>";
                }
                ?>
            </span>

            <?php
            $i++;
        }
    }

    function CategoriaPro_Read_Agregar()
    {
        $idConn = Conectarse();
        $sql = "SELECT * FROM categoriaproducto ORDER BY IdCategoriaProducto DESC";
        $resultado = mysqli_query($idConn, $sql);
    //Carga del array de datos
        while ($row = mysqli_fetch_row($resultado)) {
            ?>
            <option value="<?php echo $row[0] ?>">
                <?php echo $row[1] ?>
            </option>
            <?php

        }
    }

    function Banner_Read_Agregar()
    {
        $idConn = Conectarse();
        $sql = "SELECT * FROM bannersize";
        $resultado = mysqli_query($idConn, $sql);
    //Carga del array de datos
        while ($row = mysqli_fetch_row($resultado)) {
            ?>
            <option value="<?php echo $row[0] ?>">
                <?php echo $row[1] ?> x <?php echo $row[2] ?>
            </option>
            <?php

        }
    }

    function Notas_Read()
    {
        $idConn = Conectarse();
        $sql = "
        SELECT *
        FROM notabase
        ORDER BY IdNotas DESC
        ";
        $resultado = mysqli_query($idConn, $sql);

        while ($row = mysqli_fetch_array($resultado)) {
            ?>
            <tr>
                <td class="maxwidth">
                    <?php echo ($row['IdNotas']) ?>
                </td>
                <td style="text-transform:uppercase">
                    <?php echo strtoupper($row['TituloNotas']) ?>
                </td>
                <td style="text-transform:uppercase">
                    <?php echo strtoupper($row['CategoriaNotas']) ?>
                </td>
                <td>

                    <Center>
                        <a href="index.php?op=modificarNotas&id=<?php echo $row['IdNotas'] ?>" style="width:20px"
                           data-toggle="tooltip" alt="Modificar" title="Modificar">
                           <i
                           class="glyphicon glyphicon-cog">
                       </i>
                   </a>
                   <a href="index.php?op=verNotas&borrar=<?php echo $row["CodNotas"] ?>" style="width:20px"
                    data-toggle="tooltip" alt="Eliminar" title="Eliminar"
                    onClick="return confirm('¿Seguro querés eliminar la novedad?')">
                    <i
                    class="glyphicon glyphicon-trash">
                </i>
            </a>
        </Center>
    </td>
</tr>
<?php

}
}

function Cursos_Read()
{
    $idConn = Conectarse();
    $sql = "
    SELECT *
    FROM cursos
    ORDER BY IdCursos DESC
    ";

    $resultado = mysqli_query($idConn, $sql);
    while ($row = mysqli_fetch_array($resultado)) {
        ?>
        <tr>
            <td>
                <?php echo $row['IdCursos'] ?>
            </td>
            <td class="maxwidth">
                <?php echo substr($row['TituloCursos'], 0, 50) . "..." ?>
            </td>
            <td>

                <?php
                switch ($row["DestacarCurso"]) {
                    case 1: ?>
                    <a href="index.php?op=verCursos&es=<?php echo $row["IdCursos"] ?>&estado=0" >
                        <img src="img/estado2.jpg" width="20">
                    </a>
                    <?php
                    break;
                    case 0:
                    ?>
                    <a href="index.php?op=verCursos&es=<?php echo $row["IdCursos"] ?>&estado=1">
                        <img src="img/estado3.jpg" width="20">
                    </a>
                    <?php
                    break;
                }
                ?>


                <a href="index.php?op=modificarCursos&id=<?php echo $row['IdCursos'] ?>">
                    <img src="img/modif.png" width="20" style="margin:2px">
                </a>
                <a href="index.php?op=verCursos&borrar=<?php echo $row["IdCursos"] ?>">
                    <img src="img/elim.jpg" width="20" style="margin:2px">
                </a>
            </td>
        </tr>
        <?php

    }
}

function Cursos_Read_Front($cantidad)
{
    $idConn = Conectarse();
    $sql = "
    SELECT SocioCursos
    FROM cursos
    GROUP BY SocioCursos
    ";

    $resultado = mysqli_query($idConn, $sql);

    $i = 0;

    while ($row = mysqli_fetch_array($resultado)) {
        $socio = $row["SocioCursos"];
        $i++;
        ?>
        <div class="news column c-<?php echo $cantidad ?> clearfix" >
            <h2 style="width:100%;padding-bottom:6px;font-size:15px;color:#4496D2">
                <?php echo $row["SocioCursos"] ?>
            </h2>
            <div style="width:100%;border-bottom:1px solid #EEEEEE;">
            </div>

            <div class="arrows" style="position:relative; top:30px;margin-bottom:10px">
            </div>
            <div class="cContent clearfix rotator ">
                <ul class="slides">
                    <?php


                    $sql2 = "
                    SELECT *
                    FROM cursos
                    WHERE SocioCursos = '$socio'
                    ORDER BY IdCursos desc
                    ";

                    $resultado2 = mysqli_query($idConn, $sql2);
                    while ($row2 = mysqli_fetch_array($resultado2)) {
                        ?>
                        <li>
                            <div class="post">
                                <div class="imagen">
                                    <a href="capacitacion.php?cap=<?php echo $row2['IdCursos'] ?>">
                                        <img src="<?php echo $row2['ImgCursos'] ?>" class="imgCurso" >
                                    </a>
                                </div>

                                <div class="info" style="border-left:#003F54 2px solid;">
                                    <a href="capacitacion.php?cap=<?php echo $row2['IdCursos'] ?>">
                                        <h5>
                                            <?php echo $row2['TituloCursos'] ?>
                                        </h5>
                                    </a>
                                    <br/>
                                    <p style="text-align: justify">
                                        <?php echo ltrim(strip_tags(substr($row2['DesarrolloCursos'], 0, 150) . "...")) ?>
                                    </p>
                                    <br/>
                                    <a href="capacitacion.php?cap=<?php echo $row2['IdCursos'] ?>" class="right">
                                        ver +
                                    </a>
                                </div>
                            </div>
                        </li>
                        <?php

                    } ?>
                </ul>
            </div>
        </div>
        <?php

    }
}

function Portfolio_Read()
{
    $idConn = Conectarse();
    $sql = "
    SELECT *
    FROM portfolio
    ORDER BY id_portfolio DESC
    ";
    $resultado = mysqli_query($idConn, $sql);

    while ($row = mysqli_fetch_array($resultado)) {
        if ($row['categoria_portfolio'] == 1) {
            $categoria = "Nutrición";
        } elseif ($row['categoria_portfolio'] == 2) {
            $categoria = "Conservación de Forrajes";
        } elseif ($row['categoria_portfolio'] == 3) {
            $categoria = "Efluentes";
        }
        ?>
        <tr>
            <td>
                <?php echo $row['id_portfolio']; ?>
            </td>
            <td style="text-transform:uppercase">
                <?php echo substr(strtoupper($row['nombre_portfolio']), 0, 50) ?>
            </td>
            <td style="text-transform:uppercase">
                <?php echo strtoupper($categoria); ?>
            </td>
            <td style="text-align:center">
                <a href="index.php?op=modificarPortfolio&id=<?php echo $row['id_portfolio'] ?>" data-toggle="tooltip" alt="Modificar" title="Modificar">
                    <i class="glyphicon glyphicon-cog">
                    </i>
                </a>
                <a href="index.php?op=verPortfolio&borrar=<?php echo $row["id_portfolio"] ?>" onClick="return confirm('¿Seguro querés eliminar el producto?')" data-toggle="tooltip" alt="Eliminar" title="Eliminar">
                    <i class="glyphicon glyphicon-trash">
                    </i>
                </a>
            </td>
        </tr>
        <?php

    }
}



function Maquinas_Read()
{
    $idConn = Conectarse();
    $sql = "
    SELECT *
    FROM maquinas
    ORDER BY id_portfolio DESC
    ";
    $resultado = mysqli_query($idConn, $sql);

    while ($row = mysqli_fetch_array($resultado)) {
        if ($row['categoria_portfolio'] == 1) {
            $categoria = "Internacionales";
        } elseif ($row['categoria_portfolio'] == 2) {
            $categoria = "Nacionales";
        }
        ?>
        <tr>
            <td>
                <?php echo $row['id_portfolio']; ?>
            </td>
            <td style="text-transform:uppercase">
                <?php echo substr(strtoupper($row['nombre_portfolio']), 0, 50) ?>
            </td>
            <td style="text-transform:uppercase">
                <?php echo strtoupper($categoria); ?>
            </td>
            <td style="text-transform:uppercase">
                <?php
                if ($row['destacado_portfolio'] != 0) {
                    ?>
                    <a href="index.php?op=verPaquetes&upd=0&id=<?php echo $row['id_portfolio'] ?>">
                        <i class="fa fa-check-circle-o">
                        </i>
                    </a>
                    <?php

                } else {
                    ?>
                    <a href="index.php?op=verPaquetes&upd=1&id=<?php echo $row['id_portfolio'] ?>">
                        <i class="fa fa-circle-thin">
                        </i>
                    </a>
                    <?php

                }
                ?>
            </td>
            <td style="text-align:center">
                <a href="index.php?op=modificarPaquetes&id=<?php echo $row['id_portfolio'] ?>" data-toggle="tooltip" alt="Modificar" title="Modificar">
                    <i class="glyphicon glyphicon-cog">
                    </i>
                </a>
                <a href="index.php?op=verPaquetes&borrar=<?php echo $row["cod_portfolio"] ?>" onClick="return confirm('¿Seguro querés eliminar el producto?')" data-toggle="tooltip" alt="Eliminar" title="Eliminar">
                    <i class="glyphicon glyphicon-trash">
                    </i>
                </a>
            </td>
        </tr>
        <?php

    }
}


function Albums_Read()
{
    $idConn = Conectarse();
    $sql = "
    SELECT *
    FROM album
    ORDER BY id_album DESC
    ";
    $resultado = mysqli_query($idConn, $sql);

    while ($row = mysqli_fetch_array($resultado)) {
        if ($row['categoria_album'] == 1) {
            $categoria = "Internacionales";
        } elseif ($row['categoria_album'] == 2) {
            $categoria = "Nacionales";
        }
        ?>
        <tr>
            <td>
                <?php echo $row['id_album']; ?>
            </td>
            <td style="text-transform:uppercase">
                <?php echo substr(strtoupper($row['titulo_album']), 0, 50) ?>
            </td>
            <td style="text-transform:uppercase">
                <?php echo strtoupper($categoria); ?>
            </td>
            <td style="text-align:center">
                <a href="index.php?op=modificarAlbums&id=<?php echo $row['id_album'] ?>" data-toggle="tooltip" alt="Modificar" title="Modificar">
                    <i class="glyphicon glyphicon-cog">
                    </i>
                </a>
                <a href="index.php?op=verAlbums&borrar=<?php echo $row["cod_album"] ?>" onClick="return confirm('¿Seguro querés eliminar el producto?')" data-toggle="tooltip" alt="Eliminar" title="Eliminar">
                    <i class="glyphicon glyphicon-trash">
                    </i>
                </a>
            </td>
        </tr>
        <?php

    }
}

function Maquinas_Read_Front($categoria)
{
    $idConn = Conectarse();
    if ($categoria != '') {
        $sql = "
        SELECT *
        FROM maquinas
        WHERE categoria_portfolio = '$categoria'
        ORDER BY id_portfolio DESC
        ";
    } else {
        $sql = "
        SELECT *
        FROM maquinas
        ORDER BY id_portfolio DESC";
    }

    $resultado = mysqli_query($idConn, $sql);

    while ($row = mysqli_fetch_array($resultado)) {
        if ($row['categoria_portfolio'] == 1) {
            $categoria = "Internacional";
        } elseif ($row['categoria_portfolio'] == 2) {
            $categoria = "Nacional";
        }

        $cod = $row["cod_portfolio"];

        $sql2 = "SELECT * FROM `imagenes` WHERE `codigo` = '$cod'";
        $res = mysqli_query($idConn, $sql2);
        $imagen = mysqli_fetch_row($res);

        if ($row["moneda_portfolio"] == 1) {
            $moneda = "ARS";
        } else {
            $moneda = "USD";
        }
        if (is_file($imagen[1])) {
            $imagenFinal = $imagen[1];
        } else {
            $imagenFinal = "img/sin_imagen.jpg";
        }
        ?>
        <article class="col-md-4 portfolio-item">
            <div class="portfolio-image">
                <a href="paquete.php?id=<?php echo $row["id_portfolio"] ?>">
                    <div style="background-image:url('<?php echo $imagenFinal ?>');" class="imgPaquetes">
                    </div>
                    <div class="portfolio-overlay">
                        <div class="portfolio-desc">
                            <h3>
                                <?php echo htmlspecialchars(($row["nombre_portfolio"])) ?>
                            </h3>
                            <h5>
                                Precio:  <?php echo $moneda ?>$  <?php echo number_format($row["precio_portfolio"], 2, ',', '.') ?>
                            </h5>
                            <a href="paquete.php?id=<?php echo $row["id_portfolio"] ?>" class="btn btn-primary-nar">
                                ver más información
                            </a>
                        </div>
                    </div>
                </a>
            </div>
        </article>
        <div class="clearfix hidden-md hidden-lg">
            <br/>
        </div>
        <?php

    }
}


function Albums_Read_Front($categoria)
{
    $idConn = Conectarse();
    if ($categoria != '') {
        $sql = "
        SELECT *
        FROM album
        WHERE categoria_album = '$categoria'
        ORDER BY id_album DESC
        ";
    } else {
        $sql = "
        SELECT *
        FROM album
        ORDER BY id_album DESC";
    }

    $resultado = mysqli_query($idConn, $sql);

    while ($row = mysqli_fetch_array($resultado)) {
        if ($row['categoria_album'] == 1) {
            $categoria = "Internacional";
        } elseif ($row['categoria_album'] == 2) {
            $categoria = "Nacional";
        }



        $cod = $row["cod_album"];

        $sql2 = "SELECT * FROM `imagenes` WHERE `codigo` = '$cod'";
        $res = mysqli_query($idConn, $sql2);
        $imagen = mysqli_fetch_row($res);

        if (is_file($imagen[1])) {
            $imagenFinal = $imagen[1];
        } else {
            $imagenFinal = "img/sin_imagen.jpg";
        }
        $fecha = explode("-", $row["fecha_album"]);
        ?>
        <div class="col-md-4 col-xs-12 col-sm-12 paquetesP">
            <div class="imgPaquetes" style="background:url('<?php echo $imagenFinal ?>') no-repeat;  transition: all 0.6s !important;">
                <h1 class="paquetesTitulo">
                    <?php echo htmlspecialchars(utf8_encode($row["titulo_album"])) ?>
                </h1>
                <div class="row metaPaquetes">
                    <div class="col-md-6">
                        <div style="padding-top:7px !important">
                            <i class="fa fa-calendar">
                                </i>Fecha: <?php echo $fecha[2] . "/" . $fecha[1] . "/" . $fecha[0] ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <a href="albums.php?id=<?php echo $row["id_album"] ?>" class="btn btn-success verPaquetes2 pull-right">
                                VER MÁS
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php

        }
    }


    function Maquinas_Read_Front_Destacado()
    {
        $idConn = Conectarse();
        $sql = "
        SELECT *
        FROM maquinas
        WHERE destacado_portfolio = 1
        ORDER BY id_portfolio DESC
        LIMIT 0,6
        ";

        $resultado = mysqli_query($idConn, $sql);

        while ($row = mysqli_fetch_array($resultado)) {
            if ($row['categoria_portfolio'] == 1) {
                $categoria = "Internacional";
            } elseif ($row['categoria_portfolio'] == 2) {
                $categoria = "Nacional";
            }

            $cod = $row["cod_portfolio"];

            $sql2 = "SELECT * FROM `imagenes` WHERE `codigo` = '$cod'";
            $res = mysqli_query($idConn, $sql2);
            $imagen = mysqli_fetch_row($res);

            if ($row["moneda_portfolio"] == 1) {
                $moneda = "ARS";
            } else {
                $moneda = "USD";
            }

            if (is_file($imagen[1])) {
                $imagenFinal = $imagen[1];
            } else {
                $imagenFinal = "img/sin_imagen.jpg";
            }
            ?>
            <article class="col-md-4 portfolio-item pf-graphics">
                <div class="portfolio-image">
                    <a href="paquete.php?id=<?php echo $row["id_portfolio"] ?>">
                        <div style="background-image:url('<?php echo $imagenFinal ?>');" class="imgPaquetes">
                        </div>
                        <div class="portfolio-overlay">
                            <div class="portfolio-desc">
                                <h3>
                                    <?php echo htmlspecialchars(($row["nombre_portfolio"])) ?>
                                </h3>
                                <h5>
                                    Precio: <?php echo $moneda ?>$  <?php echo number_format($row["precio_portfolio"], 2, ',', '.') ?>
                                </h5>
                            </div>
                        </div>
                    </a>
                </div>
            </article>
            <?php

        }
    }




    function Portfolio_Read_Front($categoria)
    {
        require_once("paginacion/Zebra_Pagination.php");
        $con = Conectarse_Mysqli();
        $query = "SELECT * FROM  `portfolio` where categoria_portfolio = $categoria ORDER BY id_portfolio Desc";
        $res = $con->query($query);
        $num_registros = mysqli_num_rows($res);
        $resul_x_pagina = 5;
        $paginacion = new Zebra_Pagination();
        $paginacion->records($num_registros);
        $paginacion->records_per_page($resul_x_pagina);
        $consulta = "SELECT * FROM  `portfolio` where categoria_portfolio = $categoria ORDER BY  id_portfolio Desc
        LIMIT " . (($paginacion->get_page() - 1) * $resul_x_pagina) . ',' . $resul_x_pagina;
        $result = $con->query($consulta);
        while ($row = mysqli_fetch_array($result)) {
            $fecha = explode("-", $row["fecha_portfolio"]);
            ?>
            <div class="col-md-4 col-sm-6 product-box">
                <!-- product box start -->
                <a href="repuestos.php?id=<?php echo strtoupper($row["id_portfolio"]) ?>">
                    <div class="product-wrap" style="height:150px;overflow:hidden;background:url('<?php echo $row["imagen1_portfolio"] ?>') no-repeat center center;background-size:cover">
                    </div>
                </a>
                <h2>
                    <a href="repuestos.php?id=<?php echo $row["id_portfolio"] ?>"  style="font-size:25px">
                        <?php echo strtoupper(utf8_encode($row["nombre_portfolio"])) ?>
                    </a>
                </h2>
                <a href="repuestos.php?id=<?php echo $row["id_portfolio"] ?>" class="btn btn-outline"  >
                    <i class="fa fa-plus">
                    </i>VER  MÁS
                </a>
            </div>
            <?php

        }
        echo '<div class="col-md-12 blog-pagination">';
        $paginacion->render();
        echo '</div>';
    }





    function Variable_Form($variable, $categoriaA, $marca, $modelo, $palabra)
    {
        $order = "ORDER BY `$variable` ASC";

        $buscar = ' descripcion != "" ';

        if (trim($palabra) != '') {
            $buscar .= " AND (codigo_para_web = '$palabra' OR codigo_para_web = '$palabra')";
        }

        if (trim($modelo) != '') {
            $buscar .= " AND (descripcion LIKE '%" . $modelo . "%')";
        }

        if (trim($marca) != '') {
            $buscar .= " AND (descripcion LIKE '%" . $marca . "%')";
        }

        if ($categoriaA != '') {
            if (strpos($categoriaA, ",")) {
                $categoria = explode(",", $categoriaA);
                $buscar .= " AND (";
                for ($i = 0; $i <= (count($categoria) - 1); $i++) {
                    if ($i != (count($categoria) - 1)) {
                        $buscar .= "(rubro = '" . $categoria[$i] . "') OR ";
                    } else {
                        $buscar .= "  (rubro = '" . $categoria[$i] . "')";
                    }
                }
                $buscar .= ")";
            } else {
                $buscar .= " AND (rubro = '" . $categoriaA . "')";
            }
        }

        $con = Conectarse_Mysqli();

        if ($variable == "rosca") {
            $variable = "medida_de_rosca";
        }

        $query = "SELECT $variable FROM `productos` WHERE  $buscar GROUP BY `$variable` $order ";
        $result = mysqli_query($con, $query);
        while ($row = mysqli_fetch_row($result)) {
            echo "<option value='" . $row[0] . "'>" . strtoupper($row[0]) . "</option>";
        }
    }




    function Productos_Front($categoriaA, $marca, $modelo, $palabra, $rosca, $largo, $diametro)
    {
        $order = "ORDER BY `id` DESC";

        $buscar = "descripcion != ''";

        if (trim($palabra) != '') {
            $buscar .= " AND (codigo_para_web = '$palabra' OR equivalencias LIKE '%$palabra%')";
        }

        if (trim($modelo) != '') {
            $buscar .= " AND (descripcion LIKE '%" . $modelo . "%')";
        }

        if (trim($marca) != '') {
            $buscar .= " AND (descripcion LIKE '" . $marca . "%')";
        }

        if (trim($diametro) != '') {
            $buscar .= " AND (diametro BETWEEN '" . ($diametro - 10) . "' AND '" . ($diametro + 10) . "')";
        }
        if (trim($rosca) != '') {
            $buscar .= " AND (medida_de_rosca = '" . $rosca . "')";
        }
        if (trim($largo) != '') {
            $buscar .= " AND (largo BETWEEN '" . ($largo - 10) . "' AND '" . ($largo + 10) . "')";
        }

        if ($categoriaA != '') {
            if (strpos($categoriaA, ",")) {
                $categoria = explode(",", $categoriaA);
                $buscar .= " AND (";
                for ($i = 0; $i <= (count($categoria) - 1); $i++) {
                    if ($i != (count($categoria) - 1)) {
                        $buscar .= "(rubro = '" . $categoria[$i] . "') OR ";
                    } else {
                        $buscar .= "  (rubro = '" . $categoria[$i] . "')";
                    }
                }
                $buscar .= ")";
            } else {
                $buscar .= " AND (rubro = '" . $categoriaA . "')";
            }
        }

        require_once("paginacion/Zebra_Pagination.php");
        $con = Conectarse_Mysqli();
        $query = "SELECT * FROM `productos` WHERE  $buscar GROUP BY `id` $order ";
        $res = $con->query($query);
        $num_registros = mysqli_num_rows($res);
        $resul_x_pagina = 12;
        $paginacion = new Zebra_Pagination();
        $paginacion->records($num_registros);
        $paginacion->records_per_page($resul_x_pagina);
        $consulta = "SELECT * FROM `productos` WHERE  $buscar GROUP BY `id` $order  LIMIT " . (($paginacion->get_page() - 1) * $resul_x_pagina) . ',' . $resul_x_pagina;

        $result = $con->query($consulta);

        if ($marca != '' || $modelo != '') {
            $display = 1;
        } else {
            $display = 0;
        }

        if ($num_registros != 0) {
            echo '<table class="table table-hover table-responsive  table-stripped">';
            echo '<thead><th class="hidden-xs hidden-sm">CODIGO</th><th width="60%">PRODUCTO</th><th class="hidden-xs hidden-sm">CATEGORÍA</th><th class="hidden-xs hidden-sm">PRECIO</th><th class="hidden-xs hidden-sm"></th></thead>';
            while ($row = mysqli_fetch_array($result)) {
                $car = array(" ", "?", "-", "%");
                $cod = trim($row["codigo_para_web"]);
                $id = trim($row["id"]);
                $categoria = Rubro_Read_Solo($row["rubro"]);
                if (@getimagesize(BASE_URL . "/archivos/productos/".$row["rubro"]."/". $cod . ".jpg")) {
                    $imagen = BASE_URL . "/archivos/productos/".$row["rubro"]."/". $cod . ".jpg";
                } else {
                    $imagen = BASE_URL . "/img/sin_imagen.jpg";
                }

                if (!strpos($row["descripcion"], "-")) {
                    ?>
                    <tr class="pb-50">
                        <td   class="hidden-xs hidden-sm">
                            <b>
                                <?php echo $cod ?>
                            </b>
                        </td>
                        <td>
                            <div class="col-md-2 hidden-xs hidden-sm">
                                <?php
                                if (is_file("archivos/productos/". $row["rubro"] ."/". str_replace("/","-",$row["codigo_para_web"]) . ".jpg")) {
                                    ?>
                                    <a style="z-index:1 !important;position:relative !important" data-lightbox="image-1" data-title="<?php echo $cod ?>" href="<?php echo BASE_URL ?>/archivos/productos/<?php echo $row["rubro"] ?>/<?php echo str_replace("/","-",$row["codigo_para_web"]) ?>.jpg" class="lightbox">
                                        <img src="<?php echo BASE_URL ?>/archivos/productos/<?php echo $row["rubro"] ?>/<?php echo str_replace("/","-",$row["codigo_para_web"]) ?>.jpg" width="100%" />
                                    </a>
                                    <?php

                                } else {
                                    ?>
                                    <img src="<?php echo BASE_URL ?>/img/sin_imagen.jpg" width="100%" />
                                    <?php

                                } ?>
                                <div class="clearfix">
                                </div>
                            </div>
                            <div class="col-md-10 col-xs-12">
                                <b>
                                    <?php echo $row["descripcion"] ?>
                                    <span class="hidden-md hidden-lg">
                                        (<?php echo $cod ?>)
                                    </span>
                                </b>
                                <div class="pt-10 mt-10 text-uppercase" style="font-size: 13px;width: 100%;border-top:1px solid #e1e1e1">
                                    <div class='hidden-lg hidden-md mb-10'>
                                        <b>
                                            <span class='mt-10 mb-0 pb-0'>
                                                <?php echo $categoria["titulo_rubros"] ?>
                                            </span>
                                        </b>
                                    </div>
                                    <?php
                                    if ($row["posicion"] != '') {
                                        echo "posicion: " . $row["posicion"] . " |  ";
                                    }
                                    if ($row["diametro"] != '') {
                                        echo "diametro: " . $row["diametro"] . " |  ";
                                    }
                                    if ($row["altura"] != '') {
                                        echo "altura: " . $row["altura"] . " |  ";
                                    }
                                    if ($row["diametro_agujero_copa"] != '') {
                                        echo "diametro agujero copa: " . $row["diametro_agujero_copa"] . " | ";
                                    }
                                    if ($row["cantidad_de_agujeros_agujeros"] != '') {
                                        echo "cantidad de agujeros agujeros: " . $row["cantidad_de_agujeros_agujeros"] . " | ";
                                    }
                                    if ($row["espesor"] != '') {
                                        echo "espesor: " . $row["espesor"] . " | ";
                                    }
                                    if ($row["largo"] != '') {
                                        echo "largo: " . $row["largo"] . " | ";
                                    }
                                    if ($row["cantidad_de_salidas"] != '') {
                                        echo "cantidad de salidas: " . $row["cantidad_de_salidas"] . " | ";
                                    }
                                    if ($row["medida_de_rosca"] != '') {
                                        echo "medida de rosca: " . $row["medida_de_rosca"] . " | ";
                                    }
                                    if ($row["lado"] != '') {
                                        echo "lado: " . $row["lado"] . " |  ";
                                    }
                                    if ($row["sistema"] != '') {
                                        echo "sistema: " . $row["sistema"] . " | ";
                                    }
                                    if ($row["observaciones"] != '') {
                                        echo "observaciones: " . $row["observaciones"] . " | ";
                                    }
                                    ?>
                                    <div class="clearfix hidden-md hidden-lg">
                                        <br/>
                                    </div>
                                    <?php
                                    if ($_SESSION["descuento"] == 0) {
                                        ?>
                                        <div class='original hidden-lg hidden-md'>
                                            <h4 class='mt-10 mb-0 pb-0'>
                                                $<?php echo $row["precio"] ?>
                                            </h4>
                                        </div>
                                        <?php

                                    } else {
                                        ?>
                                        <div class='tachado hidden-lg hidden-md'>
                                            <h4 class='mt-10 mb-0 pb-0'>
                                                $<?php echo $row["precio"] ?>
                                            </h4>
                                        </div><br/>
                                        <div class='originalDescuento hidden-lg hidden-md'>
                                            <h4 class='mt-10 mb-0 pb-0'>
                                                $<?= number_format(($row["precio"] / 1.21) - (($row["precio"] / 1.21) * ($_SESSION["descuento"]/100)), 2, '.', '') ?>
                                            </h4>
                                        </div>
                                        <?php

                                    } ?>
                                    <a href="<?php echo BASE_URL ?>/api/carrito/agregar_a_carrito.php?idProducto=<?php echo $id ?>" class="linkModal hidden-md hidden-lg btn btn-info mt-10 btn-sm"  data-title="Agregar a Carrito">
                                        <i class="fa fa-shopping-cart">
                                        </i> Agregar carrito
                                    </a>
                                </div>
                            </div>
                            <br/>
                        </td>
                        <td   class="hidden-xs hidden-sm">
                            <b>
                                <?php echo $categoria['titulo_rubros'] ?>
                            </b>
                        </td>
                        <td class="hidden-xs hidden-sm">
                            <?php
                            if ($_SESSION["descuento"] == 0) {
                                ?>
                                <b class="original">
                                    <?php
                                    if ($row['precio'] != 0) {
                                        echo "$" . $row['precio'];
                                    } else {
                                        echo "<b>Consultar Precio</b>";
                                    } ?>
                                </b>
                                <?php

                            } else {
                                ?>
                                <?php
                                if ($row["precio"] != 0) {
                                    ?>
                                    <b class="tachado">
                                        $<?php echo $row["precio"] ?>
                                    </b><br/>
                                    <b class="originalDescuento">
                                        $<?= number_format(($row["precio"] / 1.21) - (($row["precio"] / 1.21) * ($_SESSION["descuento"]/100)), 2, '.', '') ?>
                                    </b>
                                    <?php

                                } else {
                                    ?>
                                    <b>
                                        Consultar Precio
                                    </b>
                                    <?php

                                } ?>
                                <?php

                            } ?>
                        </td>
                        <td  class="hidden-xs hidden-sm">
                            <a href="<?php echo BASE_URL ?>/api/carrito/agregar_a_carrito.php?idProducto=<?php echo $id ?>" class="linkModal  btn btn-info btn-sm" data-title="Agregar a Carrito">
                                <i class="fa fa-shopping-cart">
                                </i> Agregar
                            </a>
                        </td>
                    </tr>
                    <?php

                } else {
                    $caso = '';

                    $valor = explode("-", $row["descripcion"]);
                    $contarValores = count($valor);
                    for ($i = 0; $i < $contarValores; $i++) {
                        $marcaBuscar = @strpos(strtolower($valor[$i]), strtolower($marca));
                        $modeloBuscar = @strpos(strtolower($valor[$i]), strtolower($modelo));

                        if ($marca != '') {
                            $caso = 1;
                        }

                        if ($modelo != '') {
                            $caso = 2;
                        }

                        if ($marca != '' && $modelo != '') {
                            $caso = 3;
                        }

                        switch ($caso) {
                            case 1:
                            if ($marcaBuscar !== false) {
                                ?>
                                <tr class="pb-50">
                                    <td   class="hidden-xs hidden-sm">
                                        <b>
                                            <?php echo $cod ?>
                                        </b>
                                    </td>
                                    <td>
                                        <div class="clearfix">
                                        </div>
                                        <div class="col-md-2 hidden-xs hidden-sm">
                                            <?php
                                            if (is_file("archivos/productos/". $row["rubro"] ."/". str_replace("/","-",$row["codigo_para_web"]) . ".jpg")) {
                                                ?>
                                                <a style="z-index:1 !important;position:relative !important" data-lightbox="image-1" data-title="<?php echo $valor[$i] ?>" href="<?php echo BASE_URL ?>/archivos/productos/<?php echo $row["rubro"] ?>/<?php echo str_replace("/","-",$row["codigo_para_web"]) ?>.jpg" class="lightbox">
                                                    <img src="<?php echo BASE_URL ?>/archivos/productos/<?php echo $row["rubro"] ?>/<?php echo str_replace("/","-",$row["codigo_para_web"]) ?>.jpg" width="100%" />
                                                </a>
                                                <?php

                                            } else {
                                                ?>
                                                <img src="<?php echo BASE_URL ?>/img/sin_imagen.jpg" width="100%" />
                                                <?php

                                            } ?>
                                            <div class="clearfix">
                                            </div>
                                        </div>
                                        <div class="col-md-10 col-xs-12">
                                            <b>
                                                <?php echo $valor[$i] ?>
                                                <span class="hidden-md hidden-lg">
                                                    (<?php echo $cod ?>)
                                                </span>
                                            </b>
                                            <div class="pt-10 mt-10 text-uppercase" style="font-size: 13px;width: 100%;border-top:1px solid #e1e1e1">
                                                <div class='hidden-lg hidden-md mb-10'>
                                                    <b>
                                                        <span class='mt-10 mb-0 pb-0'>
                                                            <?php echo $categoria["titulo_rubros"] ?>
                                                        </span>
                                                    </b>
                                                </div>
                                                <?php
                                                if ($row["posicion"] != '') {
                                                    echo "posicion: " . $row["posicion"] . " | ";
                                                }
                                                if ($row["diametro"] != '') {
                                                    echo "diametro: " . $row["diametro"] . " | ";
                                                }
                                                if ($row["altura"] != '') {
                                                    echo "altura: " . $row["altura"] . " | ";
                                                }
                                                if ($row["diametro_agujero_copa"] != '') {
                                                    echo "diametro agujero copa: " . $row["diametro_agujero_copa"] . " | ";
                                                }
                                                if ($row["cantidad_de_agujeros_agujeros"] != '') {
                                                    echo "cantidad de agujeros agujeros: " . $row["cantidad_de_agujeros_agujeros"] . " | ";
                                                }
                                                if ($row["espesor"] != '') {
                                                    echo "espesor: " . $row["espesor"] . " | ";
                                                }
                                                if ($row["largo"] != '') {
                                                    echo "largo: " . $row["largo"] . " | ";
                                                }
                                                if ($row["cantidad_de_salidas"] != '') {
                                                    echo "cantidad de salidas: " . $row["cantidad_de_salidas"] . " | ";
                                                }
                                                if ($row["medida_de_rosca"] != '') {
                                                    echo "medida de rosca: " . $row["medida_de_rosca"] . " | ";
                                                }
                                                if ($row["lado"] != '') {
                                                    echo "lado: " . $row["lado"] . " | ";
                                                }
                                                if ($row["sistema"] != '') {
                                                    echo "sistema: " . $row["sistema"] . " | ";
                                                }
                                                if ($row["observaciones"] != '') {
                                                    echo "observaciones: " . $row["observaciones"] . " | ";
                                                }
                                                ?>
                                                <div class="clearfix hidden-md hidden-lg">
                                                    <br/>
                                                </div>
                                                <?php
                                                if ($_SESSION["descuento"] == 0) {
                                                    ?>
                                                    <div class='original hidden-lg hidden-md'>
                                                        <h4 class='mt-10 mb-0 pb-0'>
                                                            $<?php echo $row["precio"] ?>
                                                        </h4>
                                                    </div>
                                                    <?php

                                                } else {
                                                    ?>
                                                    <div class='tachado hidden-lg hidden-md'>
                                                        <h4 class='mt-10 mb-0 pb-0'>
                                                            $<?php echo $row["precio"] ?>
                                                        </h4>
                                                    </div><br/>
                                                    <div class='originalDescuento hidden-lg hidden-md'>
                                                        <h4 class='mt-10 mb-0 pb-0'>
                                                            $<?= number_format(($row["precio"] / 1.21) - (($row["precio"] / 1.21) * ($_SESSION["descuento"]/100)), 2, '.', '') ?>
                                                        </h4>
                                                    </div>
                                                    <?php

                                                } ?>
                                                <a href="<?php echo BASE_URL ?>/api/carrito/agregar_a_carrito.php?idProducto=<?php echo $id ?>" class="linkModal hidden-md hidden-lg btn btn-info mt-10 btn-sm" data-title="Agregar a Carrito | <?php echo $valor[$i] ?>">
                                                    <i class="fa fa-shopping-cart">
                                                    </i> Agregar carrito
                                                </a>
                                            </div>
                                        </div>
                                        <br/>
                                    </td>
                                    <td   class="hidden-xs hidden-sm">
                                        <b>
                                            <?php echo $categoria['titulo_rubros'] ?>
                                        </b>
                                    </td>
                                    <td class="hidden-xs hidden-sm">
                                        <?php
                                        if ($_SESSION["descuento"] == 0) {
                                            ?>
                                            <b class="original">
                                                <?php
                                                if ($row['precio'] != 0) {
                                                    echo "$" . $row['precio'];
                                                } else {
                                                    echo "<b>Consultar Precio</b>";
                                                } ?>
                                            </b>
                                            <?php

                                        } else {
                                            ?>
                                            <?php
                                            if ($row["precio"] != 0) {
                                                ?>
                                                <b class="tachado">
                                                    $<?php echo $row["precio"] ?>
                                                </b><br/>
                                                <b class="originalDescuento">
                                                    $<?= number_format(($row["precio"] / 1.21) - (($row["precio"] / 1.21) * ($_SESSION["descuento"]/100)), 2, '.', '') ?>
                                                </b>
                                                <?php

                                            } else {
                                                ?>
                                                <b>
                                                    Consultar Precio
                                                </b>
                                                <?php

                                            } ?>
                                            <?php

                                        } ?>
                                    </td>
                                    <td   class="hidden-xs hidden-sm">
                                        <a href="<?php echo BASE_URL ?>/api/carrito/agregar_a_carrito.php?idProducto=<?php echo $id ?>" class="linkModal  btn btn-info btn-sm" data-title="Agregar a Carrito | <?php echo $valor[$i] ?>">
                                            <i class="fa fa-shopping-cart">
                                            </i> Agregar
                                        </a>
                                    </td>
                                </tr>
                                <?php

                            }
                            break;
                            case 2:
                            if ($modeloBuscar !== false) {
                                ?>
                                <tr class="pb-50">
                                    <td   class="hidden-xs hidden-sm">
                                        <b>
                                            <?php echo $cod ?>
                                        </b>
                                    </td>
                                    <td>
                                        <div class="clearfix">
                                        </div>
                                        <div class="col-md-2 hidden-xs hidden-sm">
                                            <?php
                                            if (is_file("archivos/productos/". $row["rubro"] ."/". str_replace("/","-",$row["codigo_para_web"]) . ".jpg")) {
                                                ?>
                                                <a style="z-index:1 !important;position:relative !important" data-lightbox="image-1" data-title="<?php echo $valor[$i] ?>" href="<?php echo BASE_URL ?>/archivos/productos/<?php echo $row["rubro"] ?>/<?php echo str_replace("/","-",$row["codigo_para_web"]) ?>.jpg" class="lightbox">
                                                    <img src="<?php echo BASE_URL ?>/archivos/productos/<?php echo $row["rubro"] ?>/<?php echo str_replace("/","-",$row["codigo_para_web"]) ?>.jpg" width="100%" />
                                                </a>
                                                <?php

                                            } else {
                                                ?>
                                                <img src="<?php echo BASE_URL ?>/img/sin_imagen.jpg" width="100%" />
                                                <?php

                                            } ?>
                                            <div class="clearfix">
                                            </div>
                                        </div>
                                        <div class="col-md-10 col-xs-12">
                                            <b>
                                                <?php echo $valor[$i] ?>
                                                <span class="hidden-md hidden-lg">
                                                    (<?php echo $cod ?>)
                                                </span>
                                            </b>
                                            <div class="pt-10 mt-10 text-uppercase" style="font-size: 13px;width: 100%;border-top:1px solid #e1e1e1">
                                                <div class='hidden-lg hidden-md mb-10'>
                                                    <b>
                                                        <span class='mt-10 mb-0 pb-0'>
                                                            <?php echo $categoria["titulo_rubros"] ?>
                                                        </span>
                                                    </b>
                                                </div>
                                                <?php
                                                if ($row["posicion"] != '') {
                                                    echo "posicion: " . $row["posicion"] . " | ";
                                                }
                                                if ($row["diametro"] != '') {
                                                    echo "diametro: " . $row["diametro"] . " | ";
                                                }
                                                if ($row["altura"] != '') {
                                                    echo "altura: " . $row["altura"] . " | ";
                                                }
                                                if ($row["diametro_agujero_copa"] != '') {
                                                    echo "diametro agujero copa: " . $row["diametro_agujero_copa"] . " | ";
                                                }
                                                if ($row["cantidad_de_agujeros_agujeros"] != '') {
                                                    echo "cantidad de agujeros agujeros: " . $row["cantidad_de_agujeros_agujeros"] . " | ";
                                                }
                                                if ($row["espesor"] != '') {
                                                    echo "espesor: " . $row["espesor"] . " | ";
                                                }
                                                if ($row["largo"] != '') {
                                                    echo "largo: " . $row["largo"] . " | ";
                                                }
                                                if ($row["cantidad_de_salidas"] != '') {
                                                    echo "cantidad de salidas: " . $row["cantidad_de_salidas"] . " | ";
                                                }
                                                if ($row["medida_de_rosca"] != '') {
                                                    echo "medida de rosca: " . $row["medida_de_rosca"] . " | ";
                                                }
                                                if ($row["lado"] != '') {
                                                    echo "lado: " . $row["lado"] . " | ";
                                                }
                                                if ($row["sistema"] != '') {
                                                    echo "sistema: " . $row["sistema"] . " | ";
                                                }
                                                if ($row["observaciones"] != '') {
                                                    echo "observaciones: " . $row["observaciones"] . " | ";
                                                }
                                                ?>
                                                <div class="clearfix hidden-md hidden-lg">
                                                    <br/>
                                                </div>
                                                <?php
                                                if ($_SESSION["descuento"] == 0) {
                                                    ?>
                                                    <div class='original hidden-lg hidden-md'>
                                                        <h4 class='mt-10 mb-0 pb-0'>
                                                            $<?php echo $row["precio"] ?>
                                                        </h4>
                                                    </div>
                                                    <?php

                                                } else {
                                                    ?>
                                                    <div class='tachado hidden-lg hidden-md'>
                                                        <h4 class='mt-10 mb-0 pb-0'>
                                                            $<?php echo $row["precio"] ?>
                                                        </h4>
                                                    </div><br/>
                                                    <div class='originalDescuento hidden-lg hidden-md'>
                                                        <h4 class='mt-10 mb-0 pb-0'>
                                                            $<?= number_format(($row["precio"] / 1.21) - (($row["precio"] / 1.21) * ($_SESSION["descuento"]/100)), 2, '.', '') ?>
                                                        </h4>
                                                    </div>
                                                    <?php

                                                } ?>
                                                <a href="<?php echo BASE_URL ?>/api/carrito/agregar_a_carrito.php?idProducto=<?php echo $id ?>" class="linkModal hidden-md hidden-lg btn btn-info mt-10 btn-sm" data-title="Agregar a Carrito | <?php echo $valor[$i] ?>">
                                                    <i class="fa fa-shopping-cart">
                                                    </i> Agregar carrito
                                                </a>
                                            </div>
                                        </div>
                                        <br/>
                                    </td>
                                    <td   class="hidden-xs hidden-sm">
                                        <b>
                                            <?php echo $categoria['titulo_rubros'] ?>
                                        </b>
                                    </td>
                                    <td class="hidden-xs hidden-sm">
                                        <?php
                                        if ($_SESSION["descuento"] == 0) {
                                            ?>
                                            <b class="original">
                                                <?php
                                                if ($row['precio'] != 0) {
                                                    echo "$" . $row['precio'];
                                                } else {
                                                    echo "<b>Consultar Precio</b>";
                                                } ?>
                                            </b>
                                            <?php

                                        } else {
                                            ?>
                                            <?php
                                            if ($row["precio"] != 0) {
                                                ?>
                                                <b class="tachado">
                                                    $<?php echo $row["precio"] ?>
                                                </b><br/>
                                                <b class="originalDescuento">
                                                    $<?= number_format(($row["precio"] / 1.21) - (($row["precio"] / 1.21) * ($_SESSION["descuento"]/100)), 2, '.', '') ?>
                                                </b>
                                                <?php

                                            } else {
                                                ?>
                                                <b>
                                                    Consultar Precio
                                                </b>
                                                <?php

                                            } ?>
                                            <?php

                                        } ?>
                                    </td>
                                    <td   class="hidden-xs hidden-sm">
                                        <?php
                                        if ($_SESSION["descuento"] == 0) {
                                            ?>
                                            <div class='original hidden-lg hidden-md'>
                                                <h4 class='mt-10 mb-0 pb-0'>
                                                    $<?php echo $row["precio"] ?>
                                                </h4>
                                            </div>
                                            <?php

                                        } else {
                                            ?>
                                            <div class='tachado hidden-lg hidden-md'>
                                                <h4 class='mt-10 mb-0 pb-0'>
                                                    $<?php echo $row["precio"] ?>
                                                </h4>
                                            </div><br/>
                                            <div class='originalDescuento hidden-lg hidden-md'>
                                                <h4 class='mt-10 mb-0 pb-0'>
                                                    $<?= number_format(($row["precio"] / 1.21) - (($row["precio"] / 1.21) * ($_SESSION["descuento"]/100)), 2, '.', '') ?>
                                                </h4>
                                            </div>
                                            <?php

                                        } ?>
                                        <a href="<?php echo BASE_URL ?>/api/carrito/agregar_a_carrito.php?idProducto=<?php echo $id ?>" class="linkModal hidden-md hidden-lg btn btn-info mt-10 btn-sm" data-title="Agregar a Carrito | <?php echo $valor[$i] ?>">
                                            <i class="fa fa-shopping-cart">
                                            </i> Agregar a Carrito
                                        </a>
                                    </td>
                                </tr>
                                <?php

                            }
                            break;
                            case 3:
                            if ($marcaBuscar !== false && $modeloBuscar !== false) {
                                ?>
                                <tr class="pb-50">
                                    <td   class="hidden-xs hidden-sm">
                                        <b>
                                            <?php echo $cod ?>
                                        </b>
                                    </td>
                                    <td>
                                        <div class="clearfix">
                                        </div>
                                        <div class="col-md-2 hidden-xs hidden-sm">
                                            <?php
                                            if (is_file("archivos/productos/". $row["rubro"] ."/". str_replace("/","-",$row["codigo_para_web"]) . ".jpg")) {
                                                ?>
                                                <a style="z-index:1 !important;position:relative !important" data-lightbox="image-1" data-title="" href="<?php echo BASE_URL ?>/archivos/productos/<?php echo $row["rubro"] ?>/<?php echo str_replace("/","-",$row["codigo_para_web"]) ?>.jpg" class="lightbox">
                                                    <img src="<?php echo BASE_URL ?>/archivos/productos/<?php echo $row["rubro"] ?>/<?php echo str_replace("/","-",$row["codigo_para_web"]) ?>.jpg" height="50px" />
                                                </a>
                                                <?php

                                            } else {
                                                ?>
                                                <img src="<?php echo BASE_URL ?>/img/sin_imagen.jpg" width="100%" />
                                                <?php

                                            } ?>
                                            <div class="clearfix">
                                            </div>
                                        </div>
                                        <div class="col-md-10 col-xs-12">
                                            <b>
                                                <?php echo $valor[$i] ?>
                                                <span class="hidden-md hidden-lg">
                                                    (<?php echo $cod ?>)
                                                </span>
                                            </b>
                                            <div class="pt-10 mt-10 text-uppercase" style="font-size: 13px;width: 100%;border-top:1px solid #e1e1e1">
                                                <div class='hidden-lg hidden-md mb-10'>
                                                    <b>
                                                        <span class='mt-10 mb-0 pb-0'>
                                                            <?php echo $categoria["titulo_rubros"] ?>
                                                        </span>
                                                    </b>
                                                </div>
                                                <?php
                                                if ($row["posicion"] != '') {
                                                    echo "posicion: " . $row["posicion"] . " | ";
                                                }
                                                if ($row["diametro"] != '') {
                                                    echo "diametro: " . $row["diametro"] . " | ";
                                                }
                                                if ($row["altura"] != '') {
                                                    echo "altura: " . $row["altura"] . " | ";
                                                }
                                                if ($row["diametro_agujero_copa"] != '') {
                                                    echo "diametro agujero copa: " . $row["diametro_agujero_copa"] . " | ";
                                                }
                                                if ($row["cantidad_de_agujeros_agujeros"] != '') {
                                                    echo "cantidad de agujeros agujeros: " . $row["cantidad_de_agujeros_agujeros"] . " | ";
                                                }
                                                if ($row["espesor"] != '') {
                                                    echo "espesor: " . $row["espesor"] . " | ";
                                                }
                                                if ($row["largo"] != '') {
                                                    echo "largo: " . $row["largo"] . " | ";
                                                }
                                                if ($row["cantidad_de_salidas"] != '') {
                                                    echo "cantidad de salidas: " . $row["cantidad_de_salidas"] . " | ";
                                                }
                                                if ($row["medida_de_rosca"] != '') {
                                                    echo "medida de rosca: " . $row["medida_de_rosca"] . " | ";
                                                }
                                                if ($row["lado"] != '') {
                                                    echo "lado: " . $row["lado"] . " | ";
                                                }
                                                if ($row["sistema"] != '') {
                                                    echo "sistema: " . $row["sistema"] . " | ";
                                                }
                                                if ($row["observaciones"] != '') {
                                                    echo "observaciones: " . $row["observaciones"] . " | ";
                                                }
                                                ?>
                                                <div class="clearfix hidden-md hidden-lg">
                                                    <br/>
                                                </div>
                                                <?php
                                                if ($_SESSION["descuento"] == 0) {
                                                    ?>
                                                    <div class='original hidden-lg hidden-md'>
                                                        <h4 class='mt-10 mb-0 pb-0'>
                                                            $<?php echo $row["precio"] ?>
                                                        </h4>
                                                    </div>
                                                    <?php

                                                } else {
                                                    ?>
                                                    <div class='tachado hidden-lg hidden-md'>
                                                        <h4 class='mt-10 mb-0 pb-0'>
                                                            $<?php echo $row["precio"] ?>
                                                        </h4>
                                                    </div><br/>
                                                    <div class='originalDescuento hidden-lg hidden-md'>
                                                        <h4 class='mt-10 mb-0 pb-0'>
                                                            $<?= number_format(($row["precio"] / 1.21) - (($row["precio"] / 1.21) * ($_SESSION["descuento"]/100)), 2, '.', '') ?>
                                                        </h4>
                                                    </div>
                                                    <?php

                                                } ?>
                                                <a href="<?php echo BASE_URL ?>/api/carrito/agregar_a_carrito.php?idProducto=<?php echo $id ?>" class="linkModal hidden-md hidden-lg btn btn-info mt-10 btn-sm" data-title="Agregar a Carrito | <?php echo $valor[$i] ?>">
                                                    <i class="fa fa-shopping-cart">
                                                    </i> Agregar carrito
                                                </a>
                                            </div>
                                        </div>
                                        <br/>
                                    </td>
                                    <td   class="hidden-xs hidden-sm">
                                        <b>
                                            <?php echo $categoria['titulo_rubros'] ?>
                                        </b>
                                    </td>
                                    <td class="hidden-xs hidden-sm">
                                        <?php
                                        if ($_SESSION["descuento"] == 0) {
                                            ?>
                                            <b class="original">
                                                <?php
                                                if ($row['precio'] != 0) {
                                                    echo "$" . $row['precio'];
                                                } else {
                                                    echo "<b>Consultar Precio</b>";
                                                } ?>
                                            </b>
                                            <?php

                                        } else {
                                            ?>
                                            <?php
                                            if ($row["precio"] != 0) {
                                                ?>
                                                <b class="tachado">
                                                    $<?php echo $row["precio"] ?>
                                                </b><br/>
                                                <b class="originalDescuento">
                                                    $<?= number_format(($row["precio"] / 1.21) - (($row["precio"] / 1.21) * ($_SESSION["descuento"]/100)), 2, '.', '') ?>
                                                </b>
                                                <?php

                                            } else {
                                                ?>
                                                <b>
                                                    Consultar Precio
                                                </b>
                                                <?php

                                            } ?>
                                            <?php

                                        } ?>
                                    </td>
                                    <td   class="hidden-xs hidden-sm">
                                        <a href="<?php echo BASE_URL ?>/api/carrito/agregar_a_carrito.php?idProducto=<?php echo $id ?>" class="linkModal  btn btn-info btn-sm" data-title="Agregar a Carrito | <?php echo $valor[$i] ?>">
                                            <i class="fa fa-shopping-cart">
                                            </i> Agregar
                                        </a>
                                    </td>
                                </tr>
                                <?php

                            }
                            break;
                            default:
                            ?>
                            <tr class="pb-50">
                                <td   class="hidden-xs hidden-sm">
                                    <b>
                                        <?php echo $cod ?>
                                    </b>
                                </td>
                                <td>
                                    <div class="clearfix">
                                    </div>
                                    <div class="col-md-2 hidden-xs hidden-sm">
                                        <?php
                                        if (is_file("archivos/productos/". $row["rubro"] ."/". str_replace("/","-",$row["codigo_para_web"]) . ".jpg")) {
                                            ?>
                                            <a style="z-index:1 !important;position:relative !important" data-lightbox="image-1" data-title="<?php echo $valor[$i] ?>" href="<?php echo BASE_URL ?>/archivos/productos/<?php echo $row["rubro"] ?>/<?php echo str_replace("/","-",$row["codigo_para_web"]) ?>.jpg" class="lightbox">
                                                <img src="<?php echo BASE_URL ?>/archivos/productos/<?php echo $row["rubro"] ?>/<?php echo str_replace("/","-",$row["codigo_para_web"]) ?>.jpg" width="100%" />
                                            </a>
                                            <?php

                                        } ?>
                                        <div class="clearfix">
                                        </div>
                                    </div>
                                    <div class="col-md-10 col-xs-12">
                                        <b>
                                            <?php echo $valor[$i] ?>
                                            <span class="hidden-md hidden-lg">
                                                (<?php echo $cod ?>)
                                            </span>
                                        </b>
                                        <div class="pt-10 mt-10 text-uppercase" style="font-size: 13px;width: 100%;border-top:1px solid #e1e1e1">
                                            <div class='hidden-lg hidden-md mb-10'>
                                                <b>
                                                    <span class='mt-10 mb-0 pb-0'>
                                                        <?php echo $categoria["titulo_rubros"] ?>
                                                    </span>
                                                </b>
                                            </div>
                                            <?php
                                            if ($row["posicion"] != '') {
                                                echo "posicion: " . $row["posicion"] . " | ";
                                            }
                                            if ($row["diametro"] != '') {
                                                echo "diametro: " . $row["diametro"] . " | ";
                                            }
                                            if ($row["altura"] != '') {
                                                echo "altura: " . $row["altura"] . " | ";
                                            }
                                            if ($row["diametro_agujero_copa"] != '') {
                                                echo "diametro agujero copa: " . $row["diametro_agujero_copa"] . " | ";
                                            }
                                            if ($row["cantidad_de_agujeros_agujeros"] != '') {
                                                echo "cantidad de agujeros agujeros: " . $row["cantidad_de_agujeros_agujeros"] . " | ";
                                            }
                                            if ($row["espesor"] != '') {
                                                echo "espesor: " . $row["espesor"] . " | ";
                                            }
                                            if ($row["largo"] != '') {
                                                echo "largo: " . $row["largo"] . " | ";
                                            }
                                            if ($row["cantidad_de_salidas"] != '') {
                                                echo "cantidad de salidas: " . $row["cantidad_de_salidas"] . " | ";
                                            }
                                            if ($row["medida_de_rosca"] != '') {
                                                echo "medida de rosca: " . $row["medida_de_rosca"] . " | ";
                                            }
                                            if ($row["lado"] != '') {
                                                echo "lado: " . $row["lado"] . " | ";
                                            }
                                            if ($row["sistema"] != '') {
                                                echo "sistema: " . $row["sistema"] . " | ";
                                            }
                                            if ($row["observaciones"] != '') {
                                                echo "observaciones: " . $row["observaciones"] . " | ";
                                            }
                                            ?>
                                            <?php
                                            if ($_SESSION["descuento"] == 0) {
                                                ?>
                                                <div class='original hidden-lg hidden-md'>
                                                    <h4 class='mt-10 mb-0 pb-0'>
                                                        $<?php echo $row["precio"] ?>
                                                    </h4>
                                                </div>
                                                <?php

                                            } else {
                                                ?>
                                                <div class='tachado hidden-lg hidden-md'>
                                                    <h4 class='mt-10 mb-0 pb-0'>
                                                        $<?php echo $row["precio"] ?>
                                                    </h4>
                                                </div><br/>
                                                <div class='originalDescuento hidden-lg hidden-md'>
                                                    <h4 class='mt-10 mb-0 pb-0'>
                                                        $<?= number_format(($row["precio"] / 1.21) - (($row["precio"] / 1.21) * ($_SESSION["descuento"]/100)), 2, '.', '') ?>
                                                    </h4>
                                                </div>
                                                <?php

                                            } ?>
                                            <a href="<?php echo BASE_URL ?>/api/carrito/agregar_a_carrito.php?idProducto=<?php echo $id ?>" class="linkModal hidden-md hidden-lg btn btn-info mt-10 btn-sm" data-title="Agregar a Carrito | <?php echo $valor[$i] ?>">
                                                <i class="fa fa-shopping-cart">
                                                </i> Agregar carrito
                                            </a>

                                        </div>
                                    </div>
                                    <br/>
                                </td>
                                <td   class="hidden-xs hidden-sm">
                                    <b>
                                        <?php echo $categoria['titulo_rubros'] ?>
                                    </b>
                                </td>
                                <td class="hidden-xs hidden-sm">
                                    <?php
                                    if ($_SESSION["descuento"] == 0) {
                                        ?>
                                        <b class="original">
                                            <?php
                                            if ($row['precio'] != 0) {
                                                echo "$" . $row['precio'];
                                            } else {
                                                echo "<b>Consultar Precio</b>";
                                            } ?>
                                        </b>
                                        <?php

                                    } else {
                                        ?>
                                        <?php
                                        if ($row["precio"] != 0) {
                                            ?>
                                            <b class="tachado">
                                                $<?php echo $row["precio"] ?>
                                            </b><br/>
                                            <b class="originalDescuento">
                                                $<?= number_format(($row["precio"] / 1.21) - (($row["precio"] / 1.21) * ($_SESSION["descuento"]/100)), 2, '.', '') ?>
                                            </b>
                                            <?php

                                        } else {
                                            ?>
                                            <b>
                                                Consultar Precio
                                            </b>
                                            <?php

                                        } ?>
                                        <?php

                                    } ?>
                                </td>
                                <td   class="hidden-xs hidden-sm">
                                    <a href="<?php echo BASE_URL ?>/api/carrito/agregar_a_carrito.php?idProducto=<?php echo $id ?>" class="linkModal  btn btn-info btn-sm" data-title="Agregar a Carrito | <?php echo $valor[$i] ?>">
                                        <i class="fa fa-shopping-cart">
                                        </i> Agregar
                                    </a>
                                </td>
                            </tr>
                            <?php
                            break;
                        }
                    }
                }
            }
            echo "</table>";
            echo '<center class="col-md-12 text-center mt-20 mb-20">';
            $paginacion->render();
            echo '</center>';
        } else {
            echo "<div class='alert alert-danger'>Ups! No encontramos productos con éstas especificaciones.</div>";
        }
    }


    function Productos_Front_Buscar($buscar, $order, $talles)
    {
        if ($order != '') {
            $order = $order;
        } else {
            $order = "ORDER BY id DESC";
        }

        $sql_query = "SELECT * FROM productos WHERE titulo != '' $buscar ";
        $i = 0;

    /*if($talles != '') {
    if($buscar != ''){
    $sql_query .= " AND (". $talles.")";
    } else {
    $sql_query .= " WHERE (". $talles.")";
    }
    }
     */
    $sql_query .= " GROUP BY id";


    require_once("paginacion/Zebra_Pagination.php");
    $con = Conectarse_Mysqli();
    $query = $sql_query . " $order";
    $res = $con->query($query);
    $num_registros = mysqli_num_rows($res);
    $resul_x_pagina = 12;
    $paginacion = new Zebra_Pagination();
    $paginacion->records($num_registros);
    $paginacion->records_per_page($resul_x_pagina);
    $consulta = $sql_query . " $order LIMIT " . (($paginacion->get_page() - 1) * $resul_x_pagina) . ',' . $resul_x_pagina;

    $result = $con->query($consulta);
    while ($row = mysqli_fetch_array($result)) {
        $car = array(" ", "?", "-", "%");
        $cod = trim($row["codigo_para_web"]);
        $urlLink = str_replace($car, "+", strtolower(substr($row["codigo_para_web"], 0, 120)));
        if (@getimagesize("archivos/productos/".$row["rubro"]."/". $cod . ".jpg")) {
            $imagen = BASE_URL . "/archivos/productos/".$row["rubro"]."/". $cod . ".jpg";
        } else {
            $imagen = BASE_URL . "/img/sin_imagen.jpg";
        }
        ?>
        <div class="col-md-4 col-sm-6 col-xs-12 itemProducto">
            <div class="team-item hover-scale-120 transition-medium">
                <header>
                    <a href="<?php echo BASE_URL; ?>/producto.php?id=<?php echo $cod ?>" class="text-dark-blue hover-text-blue wrapword transition-medium"><?php echo trim(str_replace('"', "", $row["descripcion"])) ?>
                </header>
                <figure>
                    <a href="<?php echo BASE_URL; ?>/producto.php?id=<?php echo $cod ?>">
                        <div class="imgVistos" style="background-image:url('<?php echo $imagen; ?>');">
                        </div>
                    </a>
                </figure>
                <div class="white-background team-desc-block">
                    <ul class=" text-center clean-list" >
                        <li class="cat-item cat-item-1">
                            <a href="<?php echo BASE_URL; ?>/producto.php?id=<?php echo $cod ?>">
                                <?php echo $row["categoria"] ?>
                            </a>
                        </li>
                        <li class="cat-item cat-item-1">
                            <a href="<?php echo BASE_URL; ?>/producto.php?id=<?php echo $cod ?>" class="precio" >
                                $<?php echo $row['precio'] ?>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <?php

    }

    if ($num_registros == 0) {
        echo "<br/><span class='alert alert-warning' style='display:block'><i class='fa fa-meh-o'></i> Lo sentimos, no tenemos productos con esas características.</span>";
    }

    echo '<center class="col-md-12 pagination">';
    $paginacion->render();
    echo '</center>';
}





function Productos_Front_Ofertas($order)
{

    if ($order != '') {
        $order = $order;
    } else {
        $order = "ORDER BY id DESC";
    }

    $order .= "GROUP BY id";

    require_once("paginacion/Zebra_Pagination.php");
    $con = Conectarse_Mysqli();
    $query = "SELECT * FROM  `productos` WHERE  `unico` = 'S' $order GROUP BY id";
    $res = $con->query($query);
    $num_registros = mysqli_num_rows($res);
    $resul_x_pagina = 12;
    $paginacion = new Zebra_Pagination();
    $paginacion->records($num_registros);
    $paginacion->records_per_page($resul_x_pagina);
    $consulta = "SELECT * FROM  `productos` WHERE  `unico` = 'S' $order GROUP BY id  LIMIT " . (($paginacion->get_page() - 1) * $resul_x_pagina) . ',' . $resul_x_pagina;


    $result = $con->query($consulta);

    while ($row = mysqli_fetch_array($result)) {
        $car = array(" ", "?", "-", "%");
        $cod = trim($row["codigo_para_web"]);
        $urlLink = str_replace($car, "+", strtolower(substr($row["codigo_para_web"], 0, 120)));
        ?>

        <div class="col-md-3 productosLista wow fadeInUp">
            <div style="margin-bottom:40px" class="productoInt">
                <?php
                if (@getimagesize(BASE_URL . "/archivos/productos/".$row["rubro"]."/". $cod . ".jpg")) {
                    $imagen = BASE_URL . "/archivos/productos/".$row["rubro"]."/". $cod . ".jpg";
                } else {
                    $imagen = BASE_URL . "/img/sin_imagen.jpg";
                }

                if ($row["unico"] == "S") {
                    ?>
                    <div class="oferta">
                        ¡OFERTA!
                    </div>
                    <?php

                }
                ?>
                <a href="<?php echo BASE_URL; ?>/producto.php?id=<?php echo $cod ?>" alt="<?php echo strtoupper($row["descripcion"]); ?>">
                    <div class="imgVistos" style="background-image:url('<?php echo $imagen; ?>');">
                    </div>
                </a>
                <h1 class="tituloVistos">
                    <?php echo utf8_encode($row["descripcion"]) ?>
                </h1>
                <h3 class="categoriaVistos">
                    <?php echo $row["categoria"] ?><br/>
                    <span style="font-size:11px !important;text-align:right !important">
                        Cod.: <?php echo $cod ?>
                    </span>
                </h3>
                <div class="clearfix">
                </div><br/>
                <div class="row">
                    <div class="col-md-8 col-sm-12" style="margin:0;padding:0 5px">
                        <a href="<?php echo BASE_URL; ?>/producto.php?id=<?php echo $cod ?>" class="btn btnSlide btn-info btn-block">
                            ver más
                            <i class="fa fa-info-circle">
                            </i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php

    }
    echo '<div class="col-md-12 pagination">';
    $paginacion->render();
    echo '</div>';
}


function Productos_Front_Buscar_Ofertas($filter_array, $order, $talles)
{
    if ($order != '') {
        $order = $order;
    } else {
        $order = "ORDER BY id DESC";
    }

    $sql_query = "SELECT * FROM productos ";
    $i = 0;




    if ($talles != '') {
        if ($filter_array != '') {
            $sql_query .= " WHERE (" . $talles . ")";
        }

        if ($filter_array != '') {
            $productos = explode("*", $filter_array);
            $countProductos = count($productos) - 1;

            for ($d = 0; $d <= $countProductos; $d++) {
                $sql_query .= " AND ";
                $productosBuscar = explode("=", $productos[$d]);
                if ($productosBuscar[0] == "categoria" || $productosBuscar[0] == "fc_sexo" || $productosBuscar[0] == "deporte") {
                    $sql_query .= "`" . $productosBuscar[0] . "` = '" . $productosBuscar[1] . "' ";
                } else {
                    $sql_query .= "`" . $productosBuscar[0] . "` LIKE '%" . $productosBuscar[1] . "%' ";
                }
                $i++;
            }
        }
    } else {
        if ($filter_array != '') {
            $productos = explode("*", $filter_array);
            $countProductos = count($productos) - 1;

            for ($d = 0; $d <= $countProductos; $d++) {
                if ($d == 0) {
                    $sql_query .= " WHERE ";
                } else {
                    $sql_query .= " AND ";
                }
                $productosBuscar = explode("=", $productos[$d]);
                if ($productosBuscar[0] == "categoria" || $productosBuscar[0] == "fc_sexo" || $productosBuscar[0] == "deporte") {
                    $sql_query .= "`" . $productosBuscar[0] . "` = '" . $productosBuscar[1] . "' ";
                } else {
                    $sql_query .= "`" . $productosBuscar[0] . "` LIKE '%" . $productosBuscar[1] . "%' ";
                }
                $i++;
            }
        }

    }

    if ($sql_query != "SELECT * FROM productos ") {
        $sql_query .= " AND unico = 'S'";
    } else {
        $sql_query .= " WHERE unico = 'S'";
    }

    //echo $sql_query;

    require_once("paginacion/Zebra_Pagination.php");
    $con = Conectarse_Mysqli();
    $query = $sql_query;
    $res = $con->query($query);
    $num_registros = mysqli_num_rows($res);
    $resul_x_pagina = 12;
    $paginacion = new Zebra_Pagination();
    $paginacion->records($num_registros);
    $paginacion->records_per_page($resul_x_pagina);
    $consulta = $sql_query . " $order LIMIT " . (($paginacion->get_page() - 1) * $resul_x_pagina) . ',' . $resul_x_pagina;


    $result = $con->query($consulta);

    while ($row = mysqli_fetch_array($result)) {
        $car = array(" ", "?", "-", "%");
        $cod = trim($row["codigo_para_web"]);
        $urlLink = str_replace($car, "+", strtolower(substr($row["codigo_para_web"], 0, 120)));
        ?>
        <div class="col-md-3 productosLista wow fadeInUp">
            <div style="margin-bottom:40px" class="productoInt">
                <?php
                if (@getimagesize("archivos/productos/".$row["rubro"]."/". $cod . ".jpg")) {
                    $imagen = BASE_URL . "/archivos/productos/".$row["rubro"]."/". $cod . ".jpg";
                } else {
                    $imagen = BASE_URL . "/img/sin_imagen.jpg";
                }
                ?>
                <a href="<?php echo BASE_URL; ?>/producto.php?id=<?php echo $cod ?>" alt="<?php echo strtoupper($row["descripcion"]); ?>">
                    <div class="imgVistos" style="background-image:url('<?php echo $imagen; ?>');">
                    </div>
                </a>
                <h1 class="tituloVistos">
                    <?php echo utf8_encode($row["descripcion"]) ?>
                </h1>
                <h3 class="categoriaVistos">
                    <?php echo $row["categoria"] ?><br/>
                    <span style="font-size:11px !important;text-align:right !important">
                        Cod.: <?php echo $cod ?>
                    </span>
                </h3>
                <div class="clearfix">
                </div><br/>
                <div class="row">
                    <div class="col-md-8 col-sm-12" style="margin:0;padding:0 5px">
                        <a href="<?php echo BASE_URL; ?>/producto.php?id=<?php echo $cod ?>"  class="btn btnSlide btn-info btn-block">
                            ver más
                            <i class="fa fa-info-circle">
                            </i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php

    }
    echo '<div class="col-md-12 pagination">';
    $paginacion->render();
    echo '</div>';
}


function Portfolio_Read_Front_Relacionados($categoria)
{
    $idConn = Conectarse();
    $sql = "
    SELECT *
    FROM portfolio
    WHERE categoria_portfolio = $categoria
    ORDER BY RAND()
    LIMIT 4
    ";
    $resultado = mysqli_query($idConn, $sql);
    while ($row = mysqli_fetch_array($resultado)) {
        $car = array(" ", "?", "-", "%");
        $cod = trim($row["codigo_para_web"]);
        $urlLink = str_replace($car, "+", strtolower(substr($row["codigo_para_web"], 0, 120)));
        ?>
        <div class="col-md-3 productosLista wow fadeInUp">
            <div style="margin-bottom:40px" class="productoInt">
                <?php
                if (@getimagesize("archivos/productos/".$row["rubro"]."/". $cod . ".jpg")) {
                    $imagen = BASE_URL . "/archivos/productos/".$row["rubro"]."/". $cod . ".jpg";
                } else {
                    $imagen = BASE_URL . "/img/sin_imagen.jpg";
                }

                if ($row["unico"] == "S") {
                    ?>
                    <div class="oferta">
                        ¡OFERTA!
                    </div>
                    <?php

                }
                ?>
                <a href="<?php echo BASE_URL; ?>/producto.php?id=<?php echo $cod ?>" alt="<?php echo strtoupper($row["descripcion"]); ?>">
                    <div class="imgVistos" style="background-image:url('<?php echo $imagen; ?>');">
                    </div>
                </a>
                <h1 class="tituloVistos">
                    <?php echo utf8_encode($row["descripcion"]) ?>
                </h1>
                <h3 class="categoriaVistos">
                    <?php echo $row["categoria"] ?><br/>
                    <span style="font-size:11px !important;text-align:right !important">
                        Cod.: <?php echo $cod ?>
                    </span>
                </h3>
                <div class="clearfix">
                </div><br/>
                <div class="row">
                    <div class="col-md-8 col-sm-12" style="margin:0;padding:0 5px">
                        <a href="<?php echo BASE_URL; ?>/producto.php?id=<?php echo $cod ?>" alt="<?php echo strtoupper($row["descripcion"]); ?>" class="btn btnSlide btn-info btn-block">
                            ver más
                            <i class="fa fa-info-circle">
                            </i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php

    }
}




function Portfolio_Read_Front_Side()
{
    $idConn = Conectarse();
    $sql = "
    SELECT *
    FROM portfolio
    ORDER BY RAND()";
    $resultado = mysqli_query($idConn, $sql);
    //Carga del array de datos
    while ($row = mysqli_fetch_array($resultado)) {
        ?>
        <div class="row product-box">
            <div class="col-md-4"style="overflow:hidden;height:60px">
                <!-- product photo -->
                <div class="product-wrap">
                    <img src="<?php echo $row["imagen1_portfolio"] ?>" width="100%" class="img-responsive" />
                </div>
            </div>
            <div class="col-md-8">
                <!-- product info -->
                <h3>
                    <a href="repuestos.php?id=<?php echo $row["id_portfolio"] ?>" >
                        <?php echo htmlspecialchars($row["nombre_portfolio"]) ?>
                    </a>
                </h3>
            </div>
        </div>
        <div class="clearfix">
        </div>
        <?php

    }
}


function Portfolio_Read_Front_Busqueda($palabra)
{
    $idConn = Conectarse();
    $sql = "
    SELECT *
    FROM portfolio
    WHERE categoria_portfolio LIKE '%$palabra%'
    ORDER BY 'id_portfolio' ASC
    ";
    $resultado = mysqli_query($idConn, $sql);
    //Carga del array de datos
    while ($row = mysqli_fetch_array($resultado)) {
        ?>
        <!-- <div class="col-sm-4 col-md-3" >
        <div class="thumbnail" style="height:400px">
        <h3 style="text-transform:uppercase;font-size:16px"><?php echo utf8_encode($row["nombre_portfolio"]) ?></h3>
        <a href="productos.php?id=<?php echo $row["id_portfolio"] ?>" title="<?php echo utf8_encode($row["nombre_portfolio"]) ?>" ><div style="background: url(<?php echo $row["imagen1_portfolio"] ?>) center center;background-size:cover;height:200px;"></div></a>
        <div class="caption">
        <p><a href="productos.php?id=<?php echo $row["id_portfolio"] ?>" title="<?php echo utf8_encode($row["nombre_portfolio"]) ?>" class="btn btn-primary2" style="background: #E64A50" role="button">Ver más</a><br /><br />
        <a href="#" class="btn btn-default" disabled role="button" style="border:none"><i class="glyphicon glyphicon-chevron-right" style="margin-right:10px"></i><?php echo strtoupper($row["categoria_portfolio"]) ?></a></p>
        </div>
        </div>
    </div> -->

    <div class="column dt-sc-one-third catelog-menu all-sort non-veg-receipes-sort soups-sort isotope-item" style="position: absolute; left: 0px; top: 0px; transform: translate3d(0px, 0px, 0px);">
        <!--catelog-menu Starts Here-->
        <a href="images/shop-item1.jpg" data-gal="prettyPhoto[gallery]">
            <div class="catelog-thumb">
                <img src="images/shop-item1.jpg" alt="" title="The Buffet Corner">
            </div>
        </a>
        <h5>
            <a href="#">
                Turkish Cream Delight
            </a>
        </h5>
        <span class="price">
            $14.55
        </span>
    </div>
    <?php

}
}

function Ver_Control($cod)
{
    $idConn = Conectarse();

    if ($cod != 0) {
        $sql = "
        SELECT *
        FROM `interno`
        WHERE `control` = '$cod'
        ORDER BY `fecha` DESC
        ";
    } else {
        $sql = "
        SELECT *
        FROM interno
        ORDER BY fecha DESC
        ";
    }

    $resultado = mysqli_query($idConn, $sql);
    //Carga del array de datos

    while ($row = mysqli_fetch_array($resultado)) {
        $f = explode(" ", $row["fecha"]);
        $fecha = explode("-", $f[0]);
        ?>
        <tr>
            <?php
            if ($row["control"] != 0) {
                ?>
                <td>
                    <?php echo $row["control"] ?>
                </td>
                <?php

            } else {
                echo "<td>Sin Orden</td>";
            }
            ?>
            <td>
                <?php echo $fecha[2] . "/" . $fecha[1] . "/" . $fecha[0] ?>
            </td>
            <td>
                <?php echo $row["cliente"] ?>
            </td>
            <td>
                <?php echo $row["tiempo"] ?>
            </td>
            <td>
                <?php echo $row["estado"] ?>
            </td>
            <td>
                <center>
                    <a href="index.php?op=infoControl&id=<?php echo $row["id"] ?>">
                        <img src="img/ver.jpg" width="20" style="margin:2px">
                    </a>
                    <a href="index.php?pag=control&op=e&id=<?php echo $row["id"] ?>">
                        <img src="img/elim.jpg" width="15" style="margin:2px">
                    </a>
                </center>
            </td>
        </tr>
        <?php

    }
}

function Ver_Orden($estado)
{
    $idConn = Conectarse();
    $sql = "
    SELECT nombre_usuario,id_orden,cliente_orden,trabajo_orden,area_orden,cod_orden,pedido_orden,estado_usuario,estado_orden
    FROM orden, empleados
    WHERE user_orden = id_usuario AND estado_orden = $estado
    ORDER BY id_orden DESC
    ";
    $resultado = mysqli_query($idConn, $sql);
    //Carga del array de datos

    while ($row = mysqli_fetch_array($resultado)) {
        $fecha = explode("-", $row["pedido_orden"]);
        $usuario = explode(" ", $row["nombre_usuario"]);
        ?>
        <tr>
            <td>
                <?php echo strtoupper($row["id_orden"]) ?>
            </td>
            <td>
                <?php echo $fecha[2] . "/" . $fecha[1] . "/" . $fecha[0] ?>
            </td>
            <td>
                <?php echo strtoupper($usuario[0]) ?>
            </td>
            <td>
                <?php echo strtoupper($row["cliente_orden"]) ?>
            </td>
            <td>
                <?php echo strtoupper(substr($row["trabajo_orden"], 0, 22)) ?>...
            </td>
            <td>
                <?php echo strtoupper($row["area_orden"]) ?>
            </td>
            <td>
                <center>
                    <a href="index.php?op=agregarControl&id=<?php echo $row["cod_orden"] ?>">
                        <img src="img/add.jpg" width="20" style="margin:2px">
                    </a>
                    <a href="index.php?op=modificarOrden&id=<?php echo $row["cod_orden"] ?>">
                        <img src="img/modif.png" width="20" style="margin:2px">
                    </a>
                    <a href="index.php?op=verControl&id=<?php echo $row["cod_orden"] ?>">
                        <img src="img/repo.jpg" width="20" style="margin:2px">
                    </a>


                    <?php
                    if ($_SESSION["usuario"]["estado_usuario"] != 0) {
                        ?>
                        <a href="index.php?pag=orden&op=e&id=<?php echo $row["id_orden"] ?>">
                            <img src="img/elim.jpg" width="15" style="margin:2px">
                        </a>
                        <a href="index.php?pag=orden&op=infoOrden&id=<?php echo $row["id_orden"] ?>">
                            <img src="img/info.jpg" width="20" style="margin:2px">
                            </a><?php

                        } ?>
                    </center>
                </td>
                <td>
                    <center>
                        <?php
                        switch ($row["estado_orden"]) {
                            case 1: ?>
                            <a href="index.php?op=verOrden&es=<?php echo $row["id_orden"] ?>&estado=0">
                                <img src="img/estado2.jpg">
                            </a>
                            <?php
                            break;
                            case 0:
                            ?>
                            <a href="index.php?op=verOrden&es=<?php echo $row["id_orden"] ?>&estado=1">
                                <img src="img/estado.jpg">
                            </a>
                            <?php
                            break;
                            case 2:
                            ?>
                            <a href="index.php?op=verOrden&es=<?php echo $row["id_orden"] ?>&estado=1">
                                <img src="img/estado3.jpg">
                            </a>
                            <?php
                            break;
                        }
                        ?>

                    </center>
                </td>
            </tr>
            <?php

        }
    }

    function Ver_Resumen()
    {
        $idConn = Conectarse();
        $sql = "
        SELECT *
        FROM  `subcategorias` ,  `categorias` ,  `usuarios` ,  `pedidos`
        WHERE  `usuario_pedido` =  `id`
        AND  `categoria_pedido` =  `id_categoria`
        ";
        $resultado = mysqli_query($idConn, $sql);
    //Carga del array de datos

        while ($row = mysqli_fetch_array($resultado)) {
            $fecha = explode("-", $row["pedido_orden"]);
            $usuario = explode(" ", $row["nombre_usuario"]);
            ?>
            <tr>
                <td>
                    <?php echo strtoupper($row["id_orden"]) ?>
                </td>
                <td>
                    <?php echo $fecha[2] . "/" . $fecha[1] . "/" . $fecha[0] ?>
                </td>
                <td>
                    <?php echo strtoupper($usuario[0]) ?>
                </td>
                <td>
                    <?php echo strtoupper($row["cliente_orden"]) ?>
                </td>
                <td>
                    <?php echo strtoupper(substr($row["trabajo_orden"], 0, 22)) ?>...
                </td>
                <td>
                    <?php echo strtoupper($row["area_orden"]) ?>
                </td>
                <td>
                    <center>
                        <a href="index.php?op=agregarControl&id=<?php echo $row["cod_orden"] ?>">
                            <img src="img/add.jpg" width="20" style="margin:2px">
                        </a>
                        <a href="index.php?op=modificarOrden&id=<?php echo $row["cod_orden"] ?>">
                            <img src="img/modif.png" width="20" style="margin:2px">
                        </a>
                        <a href="index.php?op=verControl&id=<?php echo $row["cod_orden"] ?>">
                            <img src="img/repo.jpg" width="20" style="margin:2px">
                        </a>


                        <?php
                        if ($_SESSION["usuario"]["estado_usuario"] != 0) {
                            ?>
                            <a href="index.php?pag=orden&op=e&id=<?php echo $row["id_orden"] ?>">
                                <img src="img/elim.jpg" width="15" style="margin:2px">
                            </a>
                            <a href="index.php?pag=orden&op=infoOrden&id=<?php echo $row["id_orden"] ?>">
                                <img src="img/info.jpg" width="20" style="margin:2px">
                                </a><?php

                            } ?>
                        </center>
                    </td>
                    <td>
                        <center>
                            <?php
                            switch ($row["estado_orden"]) {
                                case 1: ?>
                                <a href="index.php?op=verOrden&es=<?php echo $row["id_orden"] ?>&estado=0">
                                    <img src="img/estado2.jpg">
                                </a>
                                <?php
                                break;
                                case 0:
                                ?>
                                <a href="index.php?op=verOrden&es=<?php echo $row["id_orden"] ?>&estado=1">
                                    <img src="img/estado.jpg">
                                </a>
                                <?php
                                break;
                                case 2:
                                ?>
                                <a href="index.php?op=verOrden&es=<?php echo $row["id_orden"] ?>&estado=1">
                                    <img src="img/estado3.jpg">
                                </a>
                                <?php
                                break;
                            }
                            ?>

                        </center>
                    </td>
                </tr>
                <?php

            }
        }




        function Ver_Orden_RRHH()
        {
            $idConn = Conectarse();
            $sql = "
            SELECT nombre_usuario,id_orden,cliente_orden,busqueda_orden,puesto_orden,cod_orden,ingreso_orden,estado_usuario,estado_orden
            FROM rrhh, empleados
            WHERE user_orden = id_usuario
            ORDER BY id_orden DESC
            ";
            $resultado = mysqli_query($idConn, $sql);
    //Carga del array de datos

            while ($row = mysqli_fetch_array($resultado)) {
                $fecha = explode("-", $row["ingreso_orden"]);
                $usuario = explode(" ", $row["nombre_usuario"]);
                ?>
                <tr>
                    <td>
                        <?php echo strtoupper($row["id_orden"]) ?>
                    </td>
                    <td>
                        <?php echo $fecha[2] . "/" . $fecha[1] . "/" . $fecha[0] ?>
                    </td>
                    <td>
                        <?php echo strtoupper($usuario[0]) ?>
                    </td>
                    <td>
                        <?php echo strtoupper($row["cliente_orden"]) ?>
                    </td>
                    <td>
                        <?php echo strtoupper(substr($row["busqueda_orden"], 0, 22)) ?>...
                    </td>
                    <td>
                        <?php echo strtoupper($row["puesto_orden"]) ?>
                    </td>
                    <td>
                        <center>
                            <a href="index.php?op=modificarRRHH&id=<?php echo $row["cod_orden"] ?>">
                                <img src="img/modif.png" width="20" style="margin:2px">
                            </a>
                            <?php
                            if ($_SESSION["usuario"]["estado_usuario"] != 0) {
                                ?>
                                <a href="index.php?pag=orden&op=infoRRHH&id=<?php echo $row["id_orden"] ?>">
                                    <img src="img/info.jpg" width="20" style="margin:2px">
                                    </a><?php

                                }
                                ?>
                            </center>
                        </td>
                        <td>
                            <center>
                                <?php
                                if ($row["estado_orden"] != 0) {
                                    ?>
                                    <a href="index.php?op=verRRHH&es=<?php echo $row["id_orden"] ?>&estado=0">
                                        <img src="img/estado2.jpg">
                                    </a>
                                    <?php

                                } else {
                                    ?>
                                    <a href="index.php?op=verRRHH&es=<?php echo $row["id_orden"] ?>&estado=1">
                                        <img src="img/estado.jpg">
                                    </a>
                                    <?php

                                } ?>
                            </center>
                        </td>
                    </tr>
                    <?php

                }
            }

            function Buscar($palabra)
            {

                $sql = "SELECT * FROM notabase WHERE `TituloNotas` LIKE '%$palabra%' ";

                $link = Conectarse();
                $result = mysqli_query($link, $sql);

                while ($row = mysqli_fetch_array($result)) {
                    ?>
                    <div class="span4">
                        <div class="blog-post-overview-2 alt fixed">
                            <div class="blog-post-title">
                                <img src="_layout/images/icons/45x45/white/pen.png" alt="">
                                <h3>
                                    <a href="nota.php?id=<?php echo $row["IdNotas"] ?>">
                                        <?php echo $row["TituloNotas"] ?>
                                    </a>
                                </h3>
                            </div><!-- .blog-post-title -->

                            <p>
                                <?php echo (substr(strip_tags($row["DesarrolloNotas"]), 0, 250)) . "..." ?>
                            </p>

                            <img src="<?php echo $row["ImgPortadaNotas"] ?>" alt="">
                            <div class="blog-post-readmore">
                                <a href="nota.php?id=<?php echo $row["IdNotas"] ?>">
                                    <img src="_layout/images/icons/icon-arrow-8.png" alt=""> ver más
                                </a>
                                <div class="arrow">
                                </div>
                            </div><!-- end .blog-post-readmore -->
                        </div><!-- blog-post-overview-2 -->
                    </div>
                    <?php

                }

            }

            function Notas_Read_Front()
            {
                require_once("paginacion/Zebra_Pagination.php");
                $con = Conectarse_Mysqli();
                $query = "SELECT * FROM  `notabase` ORDER BY IdNotas Desc";
                $res = $con->query($query);
                $num_registros = mysqli_num_rows($res);
                $resul_x_pagina = 4;
                $paginacion = new Zebra_Pagination();
                $paginacion->records($num_registros);
                $paginacion->records_per_page($resul_x_pagina);
                $consulta = "SELECT * FROM  `notabase` ORDER BY IdNotas Desc
                LIMIT " . (($paginacion->get_page() - 1) * $resul_x_pagina) . ',' . $resul_x_pagina;
                $result = $con->query($consulta);
                while ($row = mysqli_fetch_array($result)) {
                    $titulo = $row["TituloNotas"];
                    $urlLink = normaliza_acentos($titulo)."/".$row["IdNotas"];

                    $fecha = explode("-", $row["FechaNotas"]);
                    $cod = $row["CodNotas"];
                    $sqlImagen = "SELECT `ruta` FROM `imagenes` WHERE `codigo` = '$cod'";
                    $idConn = Conectarse();
                    $resultadoImagen = mysqli_query($idConn, $sqlImagen);
                    while ($imagenes = mysqli_fetch_row($resultadoImagen)) {
                        $imagen = $imagenes[0];
                    }
                    ?>
                    <div class="col-md-12">
                        <div class="thumbnail" style="background:url('<?php echo BASE_URL . "/" . $imagen ?>') no-repeat;height:400px;background-size:cover;">
                        </div>
                        <div class="meta">
                            <span class="meta-date">
                                <i class="fa fa-calendar">
                                    </i><?php echo $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0] ?>
                                </span>
                                <br>
                            </div>
                            <h1>
                                <?php echo ($row['TituloNotas']); ?>
                            </h1>
                            <div class="blog-content">
                                <p>
                                    <?php echo strip_tags(substr($row["DesarrolloNotas"], 0, 300)) ?>
                                </p>
                                <a href="<?php echo BASE_URL; ?>/blog/<?php echo $urlLink; ?>" class="btn btn-primary">
                                    Ver más
                                </a>
                            </div>
                            <br><hr>
                        </div>
                        <?php

                    }
                    $paginacion->render();
                }


                function Notas_Read_Front_Clientes()
                {
                    require_once("paginacion/Zebra_Pagination.php");
                    $con = Conectarse_Mysqli();
                    $query = "SELECT * FROM  `notabase` WHERE `VipNotas` = 1 ORDER BY IdNotas Desc";
                    $res = $con->query($query);
                    $num_registros = mysqli_num_rows($res);
                    $resul_x_pagina = 6;
                    $paginacion = new Zebra_Pagination();
                    $paginacion->records($num_registros);
                    $paginacion->records_per_page($resul_x_pagina);
                    $consulta = "SELECT * FROM  `notabase` WHERE `VipNotas` = 1 ORDER BY IdNotas Desc
                    LIMIT " . (($paginacion->get_page() - 1) * $resul_x_pagina) . ',' . $resul_x_pagina;


                    $result = $con->query($consulta);

                    while ($row = mysqli_fetch_array($result)) {
                        $fecha = explode("-", $row["FechaNotas"]);

                        ?>
                        <div class="row">
                            <div class="blog-thumbnail col-md-3">
                                <a href="<?php echo BASE_URL; ?>/notas.php?id=<?php echo $row["IdNotas"] ?>">
                                    <img src="<?php echo $row["ImgPortadaNotas"] ?>" alt="" width="100%">
                                </a>
                            </div>
                            <div class="col-md-9" style="margin:0;padding:0">
                                <a href="<?php echo BASE_URL; ?>/notas.php?id=<?php echo $row["IdNotas"] ?>" style="margin:0;padding:0">
                                    <?php echo utf8_encode($row['TituloNotas']); ?>
                                </a>
                            </div>
                            <div class="meta">
                                <p style="font-size:14px">
                                    <span class="meta-date">
                                        <?php echo $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0] ?>
                                    </span>
                                    ·
                                    <b>
                                        <?php echo $categoria ?>
                                    </b></span><br/>
                                    <a href="<?php echo BASE_URL; ?>/notas.php?id=<?php echo $row["IdNotas"] ?>" >
                                        Ver más
                                    </a>
                                </div>
                            </div>
                            <div class="clearfix">
                            </div>
                            <?php

                        }
                        $paginacion->render();
                    }



                    function Notas_Read_Front_Categoria($categoria)
                    {
                        require_once("paginacion/Zebra_Pagination.php");
                        $con = Conectarse_Mysqli();
                        $query = "SELECT * FROM  `notabase` WHERE `CategoriaNotas` = '$categoria' ORDER BY IdNotas Desc";
                        $res = $con->query($query);
                        $num_registros = mysqli_num_rows($res);
                        $resul_x_pagina = 5;
                        $paginacion = new Zebra_Pagination();
                        $paginacion->records($num_registros);
                        $paginacion->records_per_page($resul_x_pagina);
                        $consulta = "SELECT * FROM  `notabase` WHERE `CategoriaNotas` = '$categoria' ORDER BY IdNotas Desc
                        LIMIT " . (($paginacion->get_page() - 1) * $resul_x_pagina) . ',' . $resul_x_pagina;


                        $result = $con->query($consulta);

                        while ($row = mysqli_fetch_array($result)) {
                            $cod = $row["CodNotas"];
                            $sqlImagen = "SELECT `ruta` FROM `imagenes` WHERE `codigo` = '$cod'";
                            $idConn = Conectarse();
                            $resultadoImagen = mysqli_query($idConn, $sqlImagen);
                            while ($imagenes = mysqli_fetch_row($resultadoImagen)) {
                                $imagen = $imagenes[0];
                            }

                            $fecha = explode("-", $row["FechaNotas"]);
                            if ($row['CategoriaNotas'] == 1) {
                                $categoria = "Nutrición";
                                $verMas = "nutricion";
                            } elseif ($row['CategoriaNotas'] == 2) {
                                $categoria = "Conservación de Forrajes";
                                $verMas = "forrajes";
                            } elseif ($row['CategoriaNotas'] == 3) {
                                $categoria = "Efluentes";
                                $verMas = "efluentes";
                            } elseif ($row['CategoriaNotas'] == 4) {
                                $categoria = "Implecor Social";
                                $verMas = "social";
                            }
                            ?>
                            <div class="col-md-12 blog-post">
                                <div class="blog-thumbnail">
                                    <a href="<?php echo BASE_URL; ?>/notas.php?id=<?php echo $row["IdNotas"] ?>">
                                        <img src="<?php echo $imagen ?>" alt="">
                                    </a>
                                </div>
                                <h2 class="blog-title">
                                    <a href="<?php echo BASE_URL; ?>/notas.php?id=<?php echo $row["IdNotas"] ?>">
                                        <?php echo utf8_encode($row['TituloNotas']); ?>
                                    </a>
                                </h2>
                                <div class="meta">
                                    <p>
                                        <span class="meta-date">
                                            <?php echo $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0] ?>
                                        </span>
                                        <span class="tags">
                                            <?php echo utf8_encode($row["EtiquetasNotas"]) ?></a>,
                                            <a href="<?php echo $verMas ?>.php?op=notas">
                                                <?php echo $categoria ?>
                                            </a>
                                        </span>
                                    </p>
                                </div>
                                <div class="blog-content">
                                    <p>
                                        <?php echo strip_tags(substr($row["DesarrolloNotas"], 0, 500), "<a><span>") ?>
                                    </p>
                                    <a href="<?php echo BASE_URL; ?>/notas.php?id=<?php echo $row["IdNotas"] ?>" class="btn btn-outline">
                                        Ver más
                                    </a>
                                </div>
                            </div>
                            <?php

                        }
                        echo '<div class="col-md-12">';
                        $paginacion->render();
                        echo '</div>';
                        echo '<div class="clearfix"></div><br/>';
                    }

                    function Read_Agenda($letra)
                    {

                        $Letra = isset($letra) ? $letra : '';

                        require_once("paginacion/Zebra_Pagination.php");

                        $con = mysqli_connect("localhost", "root", "", "braver") or die("Error en el server" . mysqli_error($con));

    //$con = mysqli_connect("localhost","root","","tv5") or die("Error en el server".mysqli_error($con));
                        $query = "SELECT * FROM  `agenda` WHERE nombre LIKE '$Letra%' ORDER BY nombre asc";
                        $res = $con->query($query);
                        $num_registros = mysqli_num_rows($res);
                        $resul_x_pagina = 20;
                        $paginacion = new Zebra_Pagination();
                        $paginacion->records($num_registros);
                        $paginacion->records_per_page($resul_x_pagina);
                        $consulta = "SELECT * FROM  `agenda` WHERE nombre LIKE '$letra%' ORDER BY nombre ascPortfolio_Read_Front
                        LIMIT " . (($paginacion->get_page() - 1) * $resul_x_pagina) . ',' . $resul_x_pagina;

                        $result = $con->query($consulta);

                        while ($row = mysqli_fetch_array($result)) {
                            ?>
                            <tr>
                                <td>
                                    <?php echo $row["nombre"] ?>
                                </td>
                                <td>
                                    <?php echo $row["direccion"] ?>
                                </td>
                                <td>
                                    <?php echo $row["telefono"] ?>
                                </td>
                            </tr>
                            <?php

                        }
                        ?>
                    </tbody>
                </table>
                <div class="clearfix">
                </div>
                <?php
                $paginacion->render();
            }



            function Videos_Read_Front_Categoria($categoria)
            {
                require_once("paginacion/Zebra_Pagination.php");
                $con = Conectarse_Mysqli();
                $query = "SELECT * FROM  `videos` WHERE `CategoriaVideos` = '$categoria' ORDER BY IdVideos Desc";
                $res = $con->query($query);
                $num_registros = mysqli_num_rows($res);
                $resul_x_pagina = 5;
                $paginacion = new Zebra_Pagination();
                $paginacion->records($num_registros);
                $paginacion->records_per_page($resul_x_pagina);
                $consulta = "SELECT * FROM  `videos` WHERE `CategoriaVideos` = '$categoria' ORDER BY IdVideos Desc
                LIMIT " . (($paginacion->get_page() - 1) * $resul_x_pagina) . ',' . $resul_x_pagina;


                $result = $con->query($consulta);

                while ($row = mysqli_fetch_array($result)) {

                    if ($row['CategoriaVideos'] == 1) {
                        $categoria = "Nutrición";
                        $verMas = "nutricion";
                    } elseif ($row['CategoriaVideos'] == 2) {
                        $categoria = "Conservación de Forrajes";
                        $verMas = "forrajes";
                    } elseif ($row['CategoriaVideos'] == 3) {
                        $categoria = "Efluentes";
                        $verMas = "efluentes";
                    }
                    ?>
                    <div class="col-md-6 blog-post">
                        <div class="blog-thumbnail">
                            <iframe width="100%" height="350px" src="//www.youtube.com/embed/<?php echo $row["UrlVideos"] ?>" frameborder="0" allowfullscreen>
                            </iframe>
                        </div>
                        <h2 class="blog-title">
                            <?php echo utf8_encode($row['TituloVideos']); ?>
                        </h2>
                        <div class="meta">
                            <p>
                                <span>
                                    <i class="fa fa-archive">
                                        </i><?php echo $categoria ?>
                                    </span>
                                </p>
                            </div>
                            <div class="blog-content">
                            </div>
                        </div>
                        <?php

                    }
                    echo '<div class="col-md-12">';
                    $paginacion->render();
                    echo '</div>';
                    echo '<div class="clearfix"></div><br/>';
                }

                function Notas_Read_Front_Side()
                {
                    $idConn = Conectarse();
                    $sql = "
                    SELECT *
                    FROM notabase
                    ORDER BY IdNotas DESC
                    LIMIT 0,5
                    ";
                    $resultado = mysqli_query($idConn, $sql);
                    while ($row = mysqli_fetch_array($resultado)) {
                        $date = $row["FechaNotas"];
                        $explode = explode("-", $date);
                        $titulo = $row["TituloNotas"];
                        $urlLink = mb_strtolower(normaliza_acentos($titulo));

                        $cod = $row["CodNotas"];
                        $sqlImagen = "SELECT `ruta` FROM `imagenes` WHERE `codigo` = '$cod'";
                        $idConn = Conectarse();
                        $resultadoImagen = mysqli_query($idConn, $sqlImagen);
                        if ($imagenes = mysqli_fetch_row($resultadoImagen)) {
                            $imagen = BASE_URL . "/" . $imagenes[0];
                        } else {
                            $imagen = BASE_URL . '/images/producto_sin_imagen.jpg';
                        }

                        $fecha = $explode[2] . " - " . $explode[1] . " - " . $explode[0];
                        ?>
                        <li class="row" style="list-style: none;">
                            <div class="col-md-4" style="overflow:hidden;height:60px">
                                <a href="<?php echo BASE_URL; ?>/blog/<?php echo $urlLink; ?>">
                                    <img src="<?php echo $imagen ?>" width="100%">
                                </a>
                            </div>
                            <div class="col-md-8">
                                <a href="<?php echo BASE_URL; ?>/blog/<?php echo $urlLink; ?>">
                                    <?php echo substr(strtoupper(htmlspecialchars($titulo)), 0, 40) . "..." ?>
                                </a><br/>
                                <span class="meta-date" style="font-size:13px">
                                    <i class="fa fa-calendar">
                                        </i><?php echo $fecha ?>
                                    </span>
                                </div>
                            </li>
                            <?php

                        }
                    }

                    function Notas_Read_Front_Index()
                    {
                        $idConn = Conectarse();
                        $sql = "
                        SELECT *
                        FROM notabase
                        ORDER BY IdNotas DESC
                        LIMIT 0,4
                        ";
                        $resultado = mysqli_query($idConn, $sql);
    //Carga del array de datos
                        while ($row = mysqli_fetch_array($resultado)) {

                            $cod = $row["CodNotas"];
                            $sqlImagen = "SELECT `ruta` FROM `imagenes` WHERE `codigo` = '$cod'";
                            $idConn = Conectarse();
                            $resultadoImagen = mysqli_query($idConn, $sqlImagen);
                            while ($imagenes = mysqli_fetch_row($resultadoImagen)) {
                                $imagen = $imagenes[0];
                            }

                            ?>

                            <div class="col-md-6">
                                <div class="entry-image nobottommargin">
                                    <a href="<?php echo BASE_URL; ?>/notas.php?id=<?php echo $row["IdNotas"] ?>">
                                        <div style="background:url('<?php echo $imagen ?>') no-repeat center center;background-size:cover;height:200px;width:100%">
                                        </div>
                                    </a>
                                </div>
                                <div class="entry-title">
                                    <h3>
                                        <a href="<?php echo BASE_URL; ?>/notas.php?id=<?php echo $row["IdNotas"] ?>">
                                            <?php echo $row["TituloNotas"] ?>
                                        </a>
                                    </h3>
                                </div>

                                <ul class="entry-meta">
                                    <li>
                                        <img src="font/calendar.png" width="20" /> 10/02/2015
                                    </li>
                                </ul>
                                <div class="entry-content">
                                    <a href="<?php echo BASE_URL; ?>/notas.php?id=<?php echo $row["IdNotas"] ?>" class="btn btn-primary-nar">
                                        Ver más
                                    </a>
                                </div>
                            </div>
                            <?php

                        }
                    }


                    function Notas_Read_Carousel()
                    {
                        $idConn = Conectarse();
                        $sql = "
                        SELECT *
                        FROM notabase
                        ORDER BY IdNotas DESC
                        LIMIT 0,12
                        ";
                        $resultado = mysqli_query($idConn, $sql);
    //Carga del array de datos
                        $i = 1;
                        while ($row = mysqli_fetch_array($resultado)) {
                            if ($i == 1 || $i == 5 || $i == 9) {
                                if ($i == 1) {
                                    echo '
                                    <div class="item active">
                                    <div class="row text-center">';
                                } else {
                                    echo '
                                    <div class="item">
                                    <div class="row text-center">';
                                }
                            }

                            $cod = $row["CodNotas"];
                            $sqlImagen = "SELECT `ruta` FROM `imagenes` WHERE `codigo` = '$cod'";
                            $idConn = Conectarse();
                            $resultadoImagen = mysqli_query($idConn, $sqlImagen);
                            while ($imagenes = mysqli_fetch_row($resultadoImagen)) {
                                $imagen = $imagenes[0];
                            } ?>

                            <div class="col-md-3">
                                <div class="thumbnail product-item" style="background:url('<?php echo BASE_URL . "/" . $imagen ?>') no-repeat center top;background-size:cover;height:200px">
                                </div>
                                <h3>
                                    <?php echo $row["TituloNotas"] ?>
                                </h3>
                                <p>
                                    <a class="btn btn-large btn-block" href="<?php echo BASE_URL; ?>/notas.php?id=<?php echo $row["IdNotas"] ?>">
                                        ver nota »
                                    </a>
                                </p>
                            </div>

                            <?php
                            if ($i == 4 || $i == 8 || $i == 12) {
                                echo '
                                </div>
                                </div>';
                            }
                            $i++;
                        }
                    }

                    function Capacitaciones_Read_Front_Side()
                    {
                        $idConn = Conectarse();
                        $sql = "
                        SELECT *
                        FROM cursos
                        ORDER BY IdCursos DESC
                        LIMIT 0,4
                        ";
                        $resultado = mysqli_query($idConn, $sql);
    //Carga del array de datos
                        while ($row = mysqli_fetch_array($resultado)) {

                            ?>
                            <div class="boxInfo">
                                <div style="width:100%;max-width:82px;height:60px;overflow:hidden;float:left;">
                                    <img class="fwidth" src="<?php echo $row["ImgCursos"] ?>" alt="" style="position:relative;bottom:10%;float:right;">
                                </div>
                                <p>
                                    <a  href="capacitacion.php?cap=<?php echo $row["IdCursos"] ?>">
                                        <?php echo substr(strtoupper($row["TituloCursos"]), 0, 40) . "..." ?>
                                    </a>
                                </p>
                                <span>
                                    <?php echo $fecha ?>
                                </span>
                            </div>
                            <?php

                        }
                    }

                    function Contar_Notas()
                    {
                        $idConn = Conectarse();
                        $sql = "
                        SELECT IdNotas
                        FROM notabase
                        ";
                        $resultado = mysqli_query($idConn, $sql);
    //Carga del array de datos
                        $row = mysqli_num_rows($resultado);
                        return $row;
                    }

                    function Notas_Recientes()
                    {
                        $idConn = Conectarse();
                        $sql = "
                        SELECT IdNotas, ImgPortadaNotas , TituloNotas, DesarrolloNotas
                        FROM notabase
                        ORDER BY IdNotas DESC
                        LIMIT 0,4
                        ";
                        $resultado = mysqli_query($idConn, $sql);
    //Carga del array de datos
                        while ($row = mysqli_fetch_array($resultado)) {
                            ?>
                            <li>
                                <figure class="thumb" style="width:150px;height:150px;overflow:hidden">
                                    <a href="nota.php?id=<?php echo $row["IdNotas"] ?>">
                                        <img src="<?php echo $row["ImgPortadaNotas"] ?>" alt="" class="alignnone" hieght="100%">
                                    </a>
                                </figure>
                                <h5 class="post-title">
                                    <a href="nota.php?id=<?php echo $row["IdNotas"] ?>">
                                        <?php echo $row["TituloNotas"] ?>
                                    </a>
                                </h5>
                            </li>
                            <?php

                        }
                    }

                    function Notas_Read_Front_2($a)
                    {
                        $idConn = Conectarse();
                        $sql = "
                        SELECT IdNotas, ImgPortadaNotas , TituloNotas, DesarrolloNotas, FiltroNotas, FechaNotas, ClienteNotas
                        FROM notabase
                        ORDER BY IdNotas DESC
                        LIMIT $a, 4
                        ";
                        $resultado = mysqli_query($idConn, $sql);
    //Carga del array de datos

                        while ($row = mysqli_fetch_array($resultado)) {

                            switch ($row["FiltroNotas"]) {
                                case "mkt":
                                $filtro = "Marketing";
                                break;
                                case "publi":
                                $filtro = "Publicidad";
                                break;
                                case "web":
                                $filtro = "Web";
                                break;
                                case "rrhh":
                                $filtro = "RR.HH";
                                break;
                                case "comer":
                                $filtro = "Comercialización";
                                break;
                                case "pymes":
                                $filtro = "Pymes";
                                break;
                                case "eventos":
                                $filtro = "Eventos";
                                break;
                                case "global":
                                $filtro = "Global";
                                break;
                            }
                            ?>
                            <li>
                                <div class="thumb-hover">
                                    <figure>
                                        <a href="nota.php?id=<?php echo $row["IdNotas"] ?>">
                                            <div class="cover">
                                                <div class="plus-hover">
                                                </div>
                                                <div class="cover-background">
                                                </div>
                                            </div>
                                            <img src="<?php echo $row["ImgPortadaNotas"] ?>" width="710" />
                                        </a>
                                    </figure>
                                </div>
                                <div class="blog-details">
                                    <h2>
                                        <a href="blog-single.html">
                                            <?php echo $row["TituloNotas"] ?>
                                        </a>
                                    </h2>
                                    <p>
                                        <?php echo strip_tags(substr($row["DesarrolloNotas"], 0, 250)) . "..." ?>
                                    </p>
                                    <div class="bottom-active">
                                        <nav class="blog-meta">
                                            <span class="status">
                                                Cliente
                                            </span>
                                            <span class="blog-meta-details">
                                                <?php echo $row["ClienteNotas"] ?>
                                            </span>
                                            <span class="status">
                                                Fecha
                                            </span>
                                            <span class="blog-meta-details">
                                                <?php echo $row["FechaNotas"] ?>
                                            </span>
                                            <span class="status">
                                                Área
                                            </span>
                                            <span class="blog-meta-details">
                                                <?php echo $filtro ?>
                                            </span>
                                        </nav>
                                        <a href="nota.php?id=<?php echo $row["IdNotas"] ?>">
                                            <div class="readmore-button">
                                                <span>
                                                    Ver más
                                                </span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <?php

                        }
                    }

                    function Productos_Read()
                    {
                        $idConn = Conectarse();
                        $sql = "
                        SELECT *
                        FROM productobase
                        ORDER BY IdProducto DESC
                        ";
                        $resultado = mysqli_query($idConn, $sql);
    //Carga del array de datos

                        while ($row = mysqli_fetch_array($resultado)) {
                            ?>
                            <tr>
                                <td>
                                    <?php echo $row['SubCategoriaProducto'] ?>
                                </td>
                                <td>
                                    <?php echo ucfirst(substr($row['NombreProducto'], 0, 60)) . "..." ?>
                                </td>
                                <td>
                                    <?php echo strtolower($row['DireccionProducto']) ?>
                                </td>
                                <td>
                                    $ <?php echo ucfirst($row['PrecioProducto']) ?>
                                </td>
                                <td>
                                    <center>
                                        <a href="index.php?pag=productos&id=<?php echo $row['IdProducto'] ?>&op=m" title="Modificar">
                                            <img src="img/iconos/Settings.png" width="25px" >
                                        </a>
                                        <a href="index.php?pag=productos&id=<?php echo $row['IdProducto'] ?>&op=e" title="Eliminar">
                                            <img src="img/iconos/Recycle_Bin_Empty.png" width="25px">
                                        </a>
                                    </div>
                                </td>
                            </tr>



                            <?php

                        }
                    }

                    function Promociones_Read()
                    {
                        $idConn = Conectarse();
                        $sql = "
                        SELECT *
                        FROM promociones
                        ORDER BY IdPromociones DESC
                        ";
                        $resultado = mysqli_query($idConn, $sql);
    //Carga del array de datos

                        while ($row = mysqli_fetch_array($resultado)) {
                            ?>
                            <tr>
                                <td>
                                    <?php echo $row['IdPromociones'] ?>
                                </td>
                                <td>
                                    <?php echo $row['TituloPromociones'] ?>
                                </td>
                                <td>
                                    <?php echo $row['TipoPromociones']; ?>
                                </td>
                                <td>
                                    <center>
                                        <?php
                                        switch ($row['EstadoPromociones']) {
                                            case 0:
                                            ?>
                                            <a href="index.php?op=verPromos&upd=1&borrar=<?php echo $row[0] ?>"  style="width:20px">
                                                <i class="glyphicon glyphicon-ok-circle" >
                                                </i>
                                                </a><?php
                                                break;
                                                case 1:
                                                ?>
                                                <a href="index.php?op=verPromos&upd=0&borrar=<?php echo $row[0] ?>"  style="width:20px">
                                                    <i class="glyphicon glyphicon-ban-circle" >
                                                    </i>
                                                    </a><?php
                                                    break;
                                                }
                                                ?>
                                            </center>
                                        </td>
                                        <td>
                                            <center>
                                                <a href="index.php?op=verSuscriptos&promo=<?php echo $row[0] ?>" >
                                                    <i class="glyphicon glyphicon-user">
                                                    </i>
                                                </a>
                                                <a href="index.php?op=modificarPromos&id=<?php echo $row[0] ?>" >
                                                    <i class="glyphicon glyphicon-cog">
                                                    </i>
                                                </a>
                                                <a href="index.php?op=verPromos&borrar=<?php echo $row[0] ?>" >
                                                    <i class="glyphicon glyphicon-trash">
                                                    </i>
                                                </a>
                                            </center>
                                        </td>
                                    </tr>



                                    <?php

                                }
                            }

                            function Promociones_Read_Front()
                            {
                                $idConn = Conectarse();
                                $sql = "
                                SELECT *
                                FROM promociones
                                ORDER BY IdPromociones DESC
                                ";
                                $resultado = mysqli_query($idConn, $sql);
    //Carga del array de datos

                                while ($row = mysqli_fetch_array($resultado)) {
                                    ?>
                                    <div class="col-lg-3 col-md-4 col-sm-5 col-xs-8">
                                        <div style="width:100%;max-height:350px;display:inline-block;margin-bottom: 15px">
                                            <a href="promociones.php?suscripcion=<?php echo $row["IdPromociones"] ?>">
                                                <img src="<?php echo $row["ImgPromociones"] ?>" style="height: 100%;width:100%">
                                            </a>
                                            <center>
                                                <img src="img/sombra_slider_s.png" class="sombraSliders" style="position:relative;bottom:5px;" />
                                            </center>
                                        </div>
                                    </div>
                                    <?php

                                }
                            }

                            function Compras_Read()
                            {
                                $idConn = Conectarse();
                                $sql = "
                                SELECT *
                                FROM  `comprasbase`
                                ORDER BY  `comprasbase`.`fecha` DESC
                                ";
                                $resultado = mysqli_query($idConn, $sql);
    //Carga del array de datos
                                $i = 0;
                                while ($row = mysqli_fetch_array($resultado)) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo ucfirst(substr($row['nombre'], 0, 60)) . "..." ?>
                                        </td>
                                        <td>
                                            <?php echo $row['email'] ?>
                                        </td>
                                        <td>
                                            <?php echo $row['descripcion'] ?>
                                        </td>
                                        <td>
                                            <?php echo $row['fecha'] ?>
                                        </td>
                                        <td>
                                            $ <?php echo ucfirst($row['total']) ?>
                                        </td>
                                        <td>
                                            <?php
                                            switch ($row['estado']) {
                                                case "0":
                                                echo "Exitoso";
                                                break;
                                                case "1":
                                                echo "Pendiente";
                                                break;
                                                case "2":
                                                echo "Proceso";
                                                break;
                                                case "3":
                                                echo "Rechazado";
                                                break;
                                                case "4":
                                                echo "Anulado";
                                                break;
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <a href='index.php?pag=compra&op=e&id=<?php echo $row["id"]; ?>' title="Eliminar" onClick="return confirm('¿Seguro quiere eliminar la compra?')" class="icon-2 info-tooltip">
                                                <img src="img/iconos/Recycle_Bin_Empty.png" width="25px">
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            }

                            function Compra($id)
                            {
                                $idConn = Conectarse();

                                $sql = "SELECT *
                                FROM  comprasbase
                                WHERE  id = $id
                                ";
                                $resultado = mysqli_query($idConn, $sql);

                                while ($row2 = mysqli_fetch_array($resultado)) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo ucfirst($row2["nombre"]) ?>
                                        </td>
                                        <td>
                                            <?php echo ucfirst($row2["tipo_dni"]) ?>/<?php echo $row2["documento"] ?>
                                        </td>
                                        <td>
                                            <?php echo ucfirst($row2["email"]) ?>
                                        </td>
                                        <td>
                                            <?php echo ucfirst($row2["telefono"]) ?>
                                        </td>
                                        <td>
                                            <?php echo ucfirst($row2["celular"]) ?>
                                        </td>
                                        <td>
                                            <?php echo ucfirst($row2["provincia"]) ?>
                                        </td>
                                        <td>
                                            <?php echo ucfirst($row2["localidad"]) ?>
                                        </td>
                                        <td>
                                            <?php echo ucfirst($row2["direccion"]) ?>
                                        </td>
                                        <td>
                                            <?php echo ucfirst($row2["postal"]) ?>
                                        </td>
                                    </tr>
                                    <?php

                                }
                            }

                            function Banner_Read()
                            {
                                $idConn = Conectarse();
                                $sql = "SELECT *
                                FROM banner_fijo, bannersize
                                WHERE SizeBanner = IdSizeBanner
                                ORDER BY IdBanner DESC
                                ";
                                $resultado = mysqli_query($idConn, $sql);
    //Carga del array de datos

                                while ($row = mysqli_fetch_array($resultado)) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $row['IdBanner'] ?>
                                        </td>
                                        <td>
                                            <?php echo $row['TituloBanner'] ?>
                                        </td>
                                        <td>
                                            <?php echo $row['LinkBanner'] ?>
                                        </td>
                                        <td>
                                            <?php echo $row['AnchoBanner'] ?> x <?php echo $row['AltoBanner'] ?>
                                        </td>
                                        <td>
                                            <div style="width:60px;margin: auto;display:block">
                                                <a href="index.php?pag=banner&id=<?php echo $row['IdBanner'] ?>&op=m">
                                                    <img src="img/iconos/Settings.png" width="20px" style="margin-right:10px;">
                                                </a>
                                                <a href="index.php?pag=banner&id=<?php echo $row['IdBanner'] ?>&op=e">
                                                    <img src="img/iconos/Recycle_Bin_Empty.png" width="20px">
                                                </a>
                                            </div>
                                        </td>
                                    </tr>

                                    <?php

                                }
                            }

                            function Banner_A_Read()
                            {
                                $idConn = Conectarse();
                                $sql = "SELECT *
                                FROM banner_animado
                                ORDER BY IdBanner DESC
                                ";
                                $resultado = mysqli_query($idConn, $sql);
    //Carga del array de datos

                                while ($row = mysqli_fetch_row($resultado)) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $row[0] ?>
                                        </td>
                                        <td>
                                            <?php echo $row[2] ?>
                                        </td>

                                        <td class="options-width">
                                            <a href="index2.php?pagina=animadoModif&op=m&banner=<?php echo $row[0] ?>" title="Editar" onClick="return confirm('¿Seguro quiere editar la nota?')" class="icon-1 info-tooltip">
                                            </a>
                                            <a href='index2.php?pagina=animadoElim&op=e&sup=<?php echo $row[0]; ?>' title="Eliminar" onClick="return confirm('¿Seguro quiere eliminar la nota?')" class="icon-2 info-tooltip">
                                            </a>
                                        </td>
                                    </tr>

                                    <?php

                                }
                            }

                            /* * **************************** INSERCION DE TABLAS */

                            function Nota_Create()
                            {
                                $idConn = Conectarse();

                                $TituloNota = $_POST["descripcion"];
                                $DescripcionNota = $_POST['descripcion'];
                                $AutorNota = $_POST["autor"];
                                $FechaNota = $_POST["fecha"];
                                $Suplemento = "";
                                $CitaNota = $_POST["cita"];

    //Archivos Imagen
                                $imgInicio = "";
                                $destinoImg = "";
                                $prefijo = substr(md5(uniqid(rand())), 0, 6);
                                $imgInicio = $_FILES["img"]["tmp_name"];
                                $tucadena = $_FILES["img"]["name"];
                                $partes = explode(".", $tucadena);
                                $dominio = $partes[1];
                                $destinoImg = "../archivos/notas/" . $prefijo . "." . $dominio;
                                move_uploaded_file($imgInicio, $destinoImg);
                                chmod($destinoImg, 0777);

                                $sql =
                                "INSERT INTO `notabase`
                                (`IdNotas`, `TituloNotas`, `DesarrolloNotas`, `FechaNotas`, `AutorNotas`, `IdSuplementos`, `ImgNotas`, `CitaNotas`)
                                VALUES
                                (NULL, '$TituloNota', '$DescripcionNota', '$FechaNota', '$AutorNota', '$Suplemento', '$destinoImg', '$CitaNota')";
                                $resultado = mysqli_query($idConn, $sql);

                                echo "<script language=Javascript> location.href=\"index.php?pag=notas&op=A\"; </script>";

                            }

                            function Insertar_Categoria($categoria, $trabajo)
                            {
                                $idConn = Conectarse();
                                $sql =
                                "INSERT INTO `categorias`(`nombre_categoria`, `trabajo_categoria`)
                                VALUES
                                ('$categoria','$trabajo')";
                                $resultado = mysqli_query($idConn, $sql);
                                ?>
                                <script>
                                    parent.window.location.reload();
                                    </script><?php

                                }

                                function Insertar_SubCategoria($categoria, $subcategoria)
                                {
                                    $idConn = Conectarse();
                                    $sql =
                                    "INSERT INTO `subcategorias`(`categorias`, `nombre_subcategorias`)
                                    VALUES
                                    ('$categoria','$subcategoria')";
                                    $resultado = mysqli_query($idConn, $sql);
                                }

                                function Insertar_Sesion($nombre, $email, $telefono, $fecha)
                                {
                                    $idConn = Conectarse();
                                    $sql =
                                    "INSERT INTO `sesiones`
                                    (`NombreSesion`, `TelefonoSesion`, `EmailSesion`, `FechaSesion`, `InicioSesion`)
                                    VALUES ('$nombre','$telefono','$email','$fecha', NOW())";
                                    $resultado = mysqli_query($idConn, $sql);
                                }

                                function Insertar_Control($user, $control, $opciones_final)
                                {
                                    $idConn = Conectarse();

                                    $nombre = $_POST["nombre"];
                                    $cliente = $_POST["cliente"];
                                    $fecha = $_POST["fecha"];
                                    $tiempo = $_POST["tiempo"];
                                    $control = isset($_POST["control"]) ? $_POST["control"] : $control;
                                    $estado = $_POST["estado"];
                                    $opciones = $opciones_final;
                                    $trabajo = $_POST["trabajo"];
                                    $observaciones = $_POST["observaciones"];

                                    $sql =
                                    "INSERT INTO `interno`
                                    (`id`, `nombre`, `cliente`, `opciones`, `trabajo`, `observacion`, `control`, `tiempo`, `estado`, `fecha`, `usuario`)
                                    VALUES
                                    (NULL, '$nombre', '$cliente', '$opciones', '$trabajo', '$observaciones', '$control', '$tiempo', '$estado', '$fecha', '$user')";
                                    $resultado = mysqli_query($idConn, $sql);
                                }

                                function Insertar_Agencia($nombre, $tel, $direccion, $email, $provincia, $localidad, $destino, $tipo, $cod)
                                {
                                    $idConn = Conectarse();
                                    $sql =
                                    "INSERT INTO `agencias`
                                    (`nombre_agencia`, `direccion_agencia`, `localidad_agencia`, `provincia_agencia`, `tel_agencia`, `email_agencia`, `logo_agencia`, `tipo_agencia`, `cod_agencia`, `fecha_agencia`)
                                    VALUES
                                    ('$nombre', '$direccion', '$localidad', '$provincia', '$tel', '$email', '$destino', '$tipo', '$cod', NOW())";
                                    $resultado = mysqli_query($idConn, $sql);
                                }

                                function Insertar_Publicidad($url, $img, $provincia, $localidad, $usuario, $tipo, $cod)
                                {
                                    $idConn = Conectarse();
                                    $sql =
                                    "INSERT INTO `publicidad`
                                    (`url_publicidad`, `img_publicidad`, `provincia_publicidad`, `localidad_publicidad`, `usuario_publicidad`, `tipo_publicidad`, `inicio_publicidad`, `cierre_publicidad`,`cod_publicidad`)
                                    VALUES
                                    ('$url', '$img', '$provincia','$localidad', '$usuario', '$tipo', NOW(), ADDDATE(NOW(), INTERVAL 31 DAY), '$cod')";
                                    $resultado = mysqli_query($idConn, $sql);
                                }

                                function Insertar_Micrositio($cod, $descripcion, $maps, $img1, $img2, $img3, $img4, $img5)
                                {
                                    $idConn = Conectarse();
                                    $sql =
                                    "INSERT INTO `micrositio`(`cod_micrositio`, `descripcion_micrositio`, `maps_micrositio`, `img1_micrositio`, `img2_micrositio`, `img3_micrositio`, `img4_micrositio`, `img5_micrositio`, `fecha_micrositio`)
                                    VALUES
                                    ('$cod', '$descripcion', '$maps', '$img1', '$img2', '$img3', '$img4', '$img5', NOW())";
                                    $resultado = mysqli_query($idConn, $sql);
                                }

                                function Insertar_Usuario($nombre, $email, $postal, $direccion, $localidad, $provincia, $pass)
                                {
                                    $idConn = Conectarse();
                                    $sql =
                                    "INSERT INTO `usuarios`
                                    (`nombre`, `email`, `pass`, `postal`, `direccion`, `localidad`, `provincia`, `inscripto`)
                                    VALUES
                                    ('$nombre','$email','$pass','$postal','$direccion','$localidad','$provincia', NOW())";
                                    $resultado = mysqli_query($idConn, $sql);

                                    Enviar_Usuario($nombre, $email, $pass);
                                    Enviar_Nuevo_Usuario($nombre, $email, $pass);

                                }

                                function Insertar_Orden($user, $cod, $texto, $tipo, $tipo2, $img)
                                {
                                    $idConn = Conectarse();
                                    $sql =
                                    "INSERT INTO `pedidos`
                                    (`cod_pedido`, `categoria_pedido`, `contenido_pedido`,`tipo_pedido`, `img_pedido`, `usuario_pedido`, `fecha_pedidos`)
                                    VALUES
                                    ('$cod','$tipo','$texto','$tipo2','$img','$user', NOW())";
                                    $resultado = mysqli_query($idConn, $sql);
                                    header("Location: pedido.php?op=pedido");
                                }

                                function Insertar_Orden_RRHH($user, $cod, $publicidad, $examenes)
                                {
                                    $idConn = Conectarse();

                                    $orden = $cod;
                                    $ingreso = isset($_POST["ingreso"]) ? $_POST["ingreso"] : '';
                                    $facturacion = isset($_POST["facturacion"]) ? $_POST["facturacion"] : '';
                                    $puesto = isset($_POST["puesto"]) ? $_POST["puesto"] : '';
                                    $cliente = isset($_POST["cliente"]) ? $_POST["cliente"] : '';
                                    $contacto = isset($_POST["contacto"]) ? $_POST["contacto"] : '';
                                    $posicion = isset($_POST["posicion"]) ? $_POST["posicion"] : '';
                                    $busqueda = isset($_POST["busqueda"]) ? $_POST["busqueda"] : '';
                                    $observaciones = isset($_POST["observaciones"]) ? $_POST["observaciones"] : '';
                                    $presupuesto = isset($_POST["presupuesto"]) ? $_POST["presupuesto"] : '';
    // PUBLICIDAD
                                    $detallepubli = isset($_POST["detallepubli"]) ? $_POST["detallepubli"] : '';
                                    $gastopubli = isset($_POST["gastopubli"]) ? $_POST["gastopubli"] : '';
                                    $presupuestopubli = isset($_POST["presupuestopubli"]) ? $_POST["presupuestopubli"] : '';
    // EXAMENES
                                    $psicologo = isset($_POST["psicologo"]) ? $_POST["psicologo"] : '';
                                    $psicologoCosto = isset($_POST["psicologocosto"]) ? $_POST["psicologocosto"] : '';
                                    $medico = isset($_POST["medico"]) ? $_POST["medico"] : '';
                                    $medicoCosto = isset($_POST["medicocosto"]) ? $_POST["medicocosto"] : '';
                                    $profesional = isset($_POST["profesional"]) ? $_POST["profesional"] : '';
                                    $profesionalCosto = isset($_POST["profesionalcosto"]) ? $_POST["profesionalcosto"] : '';

                                    $medicos = $profesional . "-" . $medico . "-" . $psicologo;

                                    $sql =
                                    "
                                    INSERT INTO `rrhh`
                                    (`cod_orden`, `ingreso_orden`, `facturacion_orden`, `cliente_orden`, `contacto_orden`, `posicion_orden`, `puesto_orden`, `busqueda_orden`, `observacion_orden`, `publicidad_orden`, `costopubli_orden`, `detallepubli_orden`, `presupuestopubli_orden`, `examenes_orden`, `drexamenes_orden`, `costo_psico`, `costo_fisico`, `costo_ambiental`, `user_orden`, `final_orden`)
                                    VALUES
                                    ('$orden', '$ingreso', '$facturacion', '$cliente', '$contacto', '$posicion', '$puesto', '$busqueda', '$observaciones', '$publicidad', '$gastopubli', '$detallepubli', '$presupuestopubli', '$examenes', '$medicos', '$psicologoCosto', '$medicoCosto', '$profesionalCosto', '$user','$presupuesto')";
                                    $resultado = mysqli_query($idConn, $sql);
                                }

                                function Insertar_Compra($nombre, $email, $titulo, $texto, $total, $estado)
                                {
                                    $idConn = Conectarse();

                                    $rand = rand(0, 100000000);

                                    $fecha = date("Y-m-d H:i:s");

                                    $sql =
                                    "INSERT INTO `comprasbase`
                                    (`id`, `nombre`, `email`, `codigo`,`descripcion`, `total`, `fecha`, `estado`)
                                    VALUES
                                    ('$rand','$nombre','$email','0','$texto','$total','$fecha','$estado')";
                                    $resultado = mysqli_query($idConn, $sql);

                                    switch ($estado) {
                                        case "0":
                                        @Enviar_Compra($nombre, $email, $titulo . "<br/>" . $texto . "<br/><b>Precio</b>" . $total, "Exitoso");
                                        break;
                                        case "1":
                                        @Enviar_Compra($nombre, $email, $titulo . "<br/>" . $texto . "<br/><b>Precio</b>" . $total, "Pendiente");
                                        break;
                                        case "2":
                                        @Enviar_Compra($nombre, $email, $titulo . "<br/>" . $texto . "<br/><b>Precio</b>" . $total, "Proceso");
                                        break;
                                        case "3":
                                        @Enviar_Compra($nombre, $email, $titulo . "<br/>" . $texto . "<br/><b>Precio</b>" . $total, "Rechazado");
                                        break;
                                        case "4":
                                        @Enviar_Compra($nombre, $email, $titulo . "<br/>" . $texto . "<br/><b>Precio</b>" . $total, "Anulado");
                                        break;
                                    }

                                    session_destroy();
                                }



                                function Producto_Create()
                                {
                                    $idConn = Conectarse();

                                    $Cod = $_POST["cod"];
                                    $Nombre = $_POST["descripcion"];
                                    $Slogan = $_POST["slogan"];
                                    $Descripcion = $_POST['descripcion'];
                                    $Precio = $_POST["precio"];

                                    $sql =
                                    "INSERT INTO `productobase`
                                    (`NombreProducto`,`DireccionProducto`, `PrecioProducto`, `DescripcionProducto`, `SubCategoriaProducto`)
                                    VALUES
                                    ('$Nombre', '$Slogan', '$Precio', '$Descripcion', '$Cod')";
                                    $resultado = mysqli_query($idConn, $sql);

                                    echo "<script language=Javascript> location.href=\"index.php?pag=productos&op=A\"; </script>";

                                }

                                function Promocion_Create()
                                {
                                    $idConn = Conectarse();

                                    $Nombre = $_POST["descripcion"];
                                    $Slogan = $_POST["slogan"];
                                    $Descripcion = $_POST['descripcion'];
                                    $precio = $_POST["precio"];
                                    $Precio2 = $_POST["precio2"];

                                    $imgInicio1 = "";
                                    $destinoImg1 = "";
                                    $prefijo1 = substr(md5(uniqid(rand())), 0, 6);
                                    $imgInicio1 = $_FILES["img1"]["tmp_name"];
                                    $tucadena1 = $_FILES["img1"]["name"];
                                    $partes1 = explode(".", $tucadena1);
                                    $dominio1 = $partes1[1];
                                    if ($dominio1 != '') {
                                        $destinoImg1 = "../archivos/promociones/" . $prefijo1 . "." . $dominio1;
                                        move_uploaded_file($imgInicio1, $destinoImg1);
                                        chmod($destinoImg1, 0777);
                                    } else {
                                        $destinoImg1 = '';
                                    }

                                    $sql =
                                    "INSERT INTO `promocionbase`
                                    (`titulo`, `subtitulo`, `descripcion`, `precio`, `precio2`, `imagen`)
                                    VALUES
                                    ('$Nombre', '$Slogan', '$Descripcion','$precio','$Precio2', '$destinoImg1')";
                                    $resultado = mysqli_query($idConn, $sql);

                                }

                                function Promocion_Read()
                                {
                                    $idConn = Conectarse();

                                    $sql =
                                    "
                                    SELECT *
                                    FROM `promocionbase`
                                    ORDER BY  `promocionbase`.`id` desc ";
                                    $result = mysqli_query($idConn, $sql);

                                    while ($resultado = mysqli_fetch_array($result)) {
                                        $imagen = explode("/", $resultado["imagen"]);
                                        ?>
                                        <div style="width:100%;height:250px; overflow:hidden; display: block ">
                                            <div class="four columns picture alpha" style="height: 150px;overflow: hidden">
                                                <a href="<?php echo $imagen[1] . "/" . $imagen[2] . "/" . $imagen[3] ?>" data-rel="prettyPhoto" title="">
                                                    <span class="magnify">
                                                    </span>
                                                    <img src="<?php echo $imagen[1] . "/" . $imagen[2] . "/" . $imagen[3] ?>" alt="" class="scale-with-grid">
                                                </a>
                                                <em>
                                                </em><!-- end room picture-->
                                            </div>
                                            <div class="seven columns omega">
                                                <h3>
                                                    <?php echo $resultado["descripcion"] ?>
                                                    <span>
                                                        <?php echo $resultado["subtitulo"] ?>
                                                    </span>
                                                </h3>
                                                <p>
                                                    <?php echo $resultado["descripcion"] ?>
                                                </p>
                                                <h4 style="color:#69B10B;font-weight:bold;float:right ">
                                                    $<?php echo $resultado["precio2"] ?>
                                                </h4>
                                                <h4 style="float:right ">
                                                    /
                                                </h4>
                                                <h4 style="text-decoration:line-through;color:#FF0000;float:right">
                                                    $<?php echo $resultado["precio"] ?>
                                                </h4>
                                                <br class="clear"/><br class="clear"/><br class="clear"/><br class="clear"/><br class="clear"/><br class="clear"/><br class="clear"/>
                                            </div>
                                        </div>
                                        <?php

                                    }
                                }

                                function Slider_Create()
                                {
                                    $idConn = Conectarse();

                                    $nombre = $_POST["descripcion"];
                                    $descripcion = $_POST["descripcion"];

                                    $imgInicio = "";
                                    $destinoImg = "";
                                    $prefijo = substr(md5(uniqid(rand())), 0, 6);
                                    $imgInicio = $_FILES["img"]["tmp_name"];
                                    $tucadena = $_FILES["img"]["name"];
                                    $partes = explode(".", $tucadena);
                                    $dominio = $partes[1];
                                    $destinoImg = "archivos/slider/" . $prefijo . "." . $dominio;
                                    move_uploaded_file($imgInicio, $destinoImg);
                                    chmod($destinoImg, 0777);

                                    $sql =
                                    "
                                    INSERT INTO `sliderbase`
                                    (`TituloSlider`, `DescripcionSlider`, `ImgSlider`)
                                    VALUES
                                    ('$nombre','$descripcion','$destinoImg')
                                    ";
                                    $resultado = mysqli_query($idConn, $sql);
                                    echo "<script language=Javascript> location.href=\"index.php?pag=slider&op=A\"; </script>";
                                }

                                function Banner_Create()
                                {
                                    $idConn = Conectarse();

                                    $titulo = $_POST["descripcion"];
                                    $link = $_POST["link"];
                                    $size = $_POST["categoria"];

                                    $imgInicio = "";
                                    $destinoImg = "";
                                    $prefijo = substr(md5(uniqid(rand())), 0, 6);
                                    $imgInicio = $_FILES["img"]["tmp_name"];
                                    $tucadena = $_FILES["img"]["name"];
                                    $partes = explode(".", $tucadena);
                                    $dominio = $partes[1];
                                    $destinoImg = "archivos/banner/" . $prefijo . "." . $dominio;
                                    move_uploaded_file($imgInicio, $destinoImg);
                                    chmod($destinoImg, 0777);

                                    $sql =
                                    "INSERT INTO `banner_fijo`
                                    (`TituloBanner`, `LinkBanner`, `RutaBanner`,  `SizeBanner`)
                                    VALUES
                                    ('$titulo', '$link', '$destinoImg', '$size')";
                                    $resultado = mysqli_query($idConn, $sql);
                                    echo "<script language=Javascript> location.href=\"index.php?pag=banner&op=A\"; </script>";

                                }

                                function Insertar_Reserva($nombre, $email, $descripcion, $categoria)
                                {
                                    $idConn = Conectarse();

                                    $rand = rand(0, 100000000);
                                    $fecha = date("Y-m-d H:i:s");

                                    $sql =
                                    "INSERT INTO `consultasbase`(`id`,`nombre`, `email`, `consulta`, `fecha`, `estado`, `categoria`)
                                    VALUES ('$rand','$nombre', '$email', '$descripcion', '$fecha', 0, '$categoria')";
                                    $resultado = mysqli_query($idConn, $sql);
                                }

                                function TraerConsultas($categoria)
                                {
                                    $idConn = Conectarse();
                                    $sql = "SELECT * FROM consultasbase WHERE`estado` = 0 AND `categoria` = $categoria ORDER BY fecha DESC";
                                    $resultado = mysqli_query($idConn, $sql);
    //Carga del array de datos

                                    while ($row = mysqli_fetch_row($resultado)) {
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo strtoupper($row[1]) ?>
                                            </td>
                                            <td>
                                                <?php echo $row[2] ?>
                                            </td>
                                            <td>
                                                <?php echo $row[3] ?>
                                            </td>
                                            <td>
                                                <?php echo $row[4] ?>
                                            </td>
                                            <td>
                                                <div style="width:60px;margin: auto;display:block">
                                                    <?php
                                                    if ($row[6] != 3) {
                                                        ?>
                                                        <a href="mailto:<?php echo $row[2] ?>?Subject=Respuesta de la consulta realizada">
                                                            <img src="img/iconos/Chat.png" width="20px" style="margin-right:10px;">
                                                        </a>
                                                        <a href="index.php?pag=consultas&id=<?php echo $row[0] ?>&op=m">
                                                            <img src="img/iconos/Recycle_Bin_Empty.png" width="20px">
                                                        </a>
                                                        <?php

                                                    } else {
                                                        ?>
                                                        <a href="mailto:<?php echo $row[2] ?>?Subject=Respuesta de la consulta realizada">
                                                            <img src="img/iconos/Chat.png" width="20px" style="margin-right:10px;">
                                                        </a>
                                                        <?php

                                                    } ?>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php

                                    }
                                }

                                function TraerPedidos($id)
                                {
                                    $idConn = Conectarse();
                                    $sql = "SELECT * FROM `pedidos` WHERE `usuario_pedidos` = '$id' AND estado_pedidos != 9 ORDER BY id_pedidos DESC";
                                    $resultado = mysqli_query($idConn, $sql);

                                    if (mysqli_num_rows($resultado) != 0) {
                                        while ($row = mysqli_fetch_array($resultado)) {
                                            $fecha = explode(" ", $row["fecha_pedidos"]);
                                            $fechaF = explode("-", $fecha[0]);

                                            $producto = explode("-", $row["productos_pedidos"]);
                                            $tipo = explode("-", $row["tipo_pedidos"]);
                                            $countProductos = count($producto) - 2;

                                            ?>
                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="heading<?php echo $row["id_pedido"]; ?>">
                                                    <h5 class="panel-title">
                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $row["id_pedidos"]; ?>" aria-expanded="true" aria-controls="collapse<?php echo $row["id_pedidos"]; ?>">
                                                            Pedido <?php echo $row["cod_pedidos"]; ?>
                                                            <span class="hidden-xs hidden-sm">
                                                                - Fecha <?php echo $fechaF[2] . "-" . $fechaF[1] . "-" . $fechaF[0] . " " . $fecha[1]; ?>
                                                            </span>
                                                            <?php
                                                            switch ($row["estado_pedidos"]) {
                                                                case 0:
                                                                echo "<span  style='padding:4px;font-size:13px;margin-top:-3px' class='btn-warning pull-right'>Estado: Pago pendiente</span>";
                                                                break;
                                                                case 1:
                                                                echo "<span  style='padding:4px;font-size:13px;margin-top:-3px' class='btn-success pull-right'>Estado: Pago exitoso</span>";
                                                                break;
                                                                case 2:
                                                                echo "<span  style='padding:4px;font-size:13px;margin-top:-3px' class='btn-danger pull-right'>Estado: Pago erroneo</span>";
                                                                break;
                                                                case 3:
                                                                echo "<span  style='padding:4px;font-size:13px;margin-top:-3px' class='btn-info pull-right'>Estado: Enviado</span>";
                                                                break;
                                                            }
                                                            ?>
                                                        </a>
                                                    </h5>
                                                </div>
                                                <div id="collapse<?php echo $row["id_pedidos"]; ?>" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
                                                    <div class="panel-body">
                                                        <table class="table table-striped table-responsive">
                                                            <thead>
                                                                <th>
                                                                    Producto
                                                                </th>
                                                                <th>
                                                                    Cantidad
                                                                </th>
                                                                <th class="hidden-xs hidden-sm">
                                                                    Precio
                                                                </th>
                                                                <th>
                                                                    Precio Final
                                                                </th>
                                                            </thead>
                                                            <tbody>
                                                                <?php echo $row["productos_pedidos"]; ?>
                                                            </tbody>
                                                        </table>
                                                        <?php
                                                        switch ($row["tipo_pedidos"]) {
                                                            case 3:
                                                            $tipoPedido = "Coordino con el vendedor";
                                                            break;
                                                            case 2:
                                                            $tipoPedido = "Tarjeta de Crédito";
                                                            break;
                                                            case 1:
                                                            $tipoPedido = "Transferencia Bancaria";
                                                            break;

                                                        }
                                                        echo "<hr/><span style='font-size:16px'><b>FORMA DE PAGO</b> <div class='btn btn-primary pull-right'>" . $tipoPedido . "</div></span>";
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php

                                        }
                                    } else {
                                        ?>
                                        <div class="alert alert-danger animated fadeInDown" role="alert">
                                            ¡No tenés ningún pedido añadido!
                                            <a href="productos.php" class="btn btn-default" style="float:right;position:relative;bottom:7px;">
                                                AÑADIR PRODUCTOS
                                            </a>
                                            </div><?php

                                        }
                                    }

                                    function TraerPedidos_Admin($tipo)
                                    {
                                        $idConn = Conectarse();
                                        if ($tipo == '') {
                                            $sql = "SELECT * FROM `usuarios`, `pedidos` WHERE `usuario_pedidos` = `id` ORDER BY id_pedidos DESC";
                                        } else {
                                            $sql = "SELECT * FROM `usuarios`, `pedidos` WHERE `usuario_pedidos` = `id` and `estado_pedidos` = '$tipo' ORDER BY id_pedidos DESC";
                                        }
                                        $resultado = mysqli_query($idConn, $sql);
    //Carga del array de datos
                                        if (mysqli_num_rows($resultado) != 0) {
                                            while ($row = mysqli_fetch_array($resultado)) {
                                                $fecha = explode(" ", $row["fecha_pedidos"]);
                                                $fechaF = explode("-", $fecha[0]);
                                                $usuario = "<h3>Datos del usuario</h3><b>Nombre:</b> " . $row['nombre'] . "<br/> <b>CUIT:</b> " . $row['cuit'] . "<br/> <b>Email:</b> " . $row['email'] . "<br/> <b>Teléfono:</b> " . $row['telefono'] . "<br/> <b>Domicilio:</b> " . $row['direccion'] . "<br/> <b>Localidad:</b> " . $row['localidad'] . "<br/> <b>Provincia:</b> " . $row['provincia'] . "<br/> <b>Cod. Postal:</b> " . $row['postal'] . "<br/> <b>Fecha de inscripción:</b> " . $row['inscripto'] . "<br/>";
                                                ?>
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab" id="heading<?php echo $row["id_pedido"]; ?>" >
                                                        <h5 class="panel-title" >
                                                            <a data-toggle="collapse" data-parent="#accordion" href="#<?= $tipo ?>collapse<?php echo $row["id_pedidos"]; ?>" aria-expanded="true" aria-controls="<?= $tipo ?>collapse<?php echo $row["id_pedidos"]; ?>" >
                                                                <i class="fa fa-angle-right">
                                                                </i> Cod. Pedido nº: <?php echo $row["cod_pedidos"]; ?> -
                                                                <i class="fa fa-calendar">
                                                                    </i> <?php echo $fechaF[2] . "-" . $fechaF[1] . "-" . $fechaF[0] ?>
                                                                    <?php
                                                                    $contacto = Contenido_TraerPorId("contacto");
                                                                    switch ($row["estado_pedidos"]) {
                                                                        case 0:
                                                                        echo "<span  style='padding:4px;font-size:13px;margin-top:-3px' class='btn-warning pull-right'>Estado: Pago pendiente</span>";
                                                                        $leyenda = "<b>Estaríamos necesitando el pago para poder proseguir con el pedido solicitado.</b><br/>" . $contacto[1];
                                                                        break;
                                                                        case 1:
                                                                        echo "<span  style='padding:4px;font-size:13px;margin-top:-3px' class='btn-success pull-right'>Estado: Pago exitoso</span>";
                                                                        $leyenda = "<b>Excelente el pago fue acreditado, para poder proseguir con el pedido solicitado.</b><br/>" . $contacto[1];
                                                                        break;
                                                                        case 2:
                                                                        echo "<span  style='padding:4px;font-size:13px;margin-top:-3px' class='btn-danger pull-right'>Estado: Pago erroneo</span>";
                                                                        $leyenda = "<b>Tuvimos problemas con el pago para poder proseguir con el pedido solicitado.</b><br/>" . $contacto[1];
                                                                        break;
                                                                        case 3:
                                                                        echo "<span  style='padding:4px;font-size:13px;margin-top:-3px' class='btn-info pull-right'>Estado: Enviado</span>";
                                                                        $leyenda = "<b>Excelente el pago y el envío fueron exitosos.<br/>Muchas gracias por su compra.</b><br/>" . $contacto[1];
                                                                        break;
                                                                        case 9:
                                                                        echo "<span  style='padding:4px;font-size:13px;margin-top:-3px' class='btn-info pull-right'>Estado: Carrito no cerrado</span>";
                                                                        $leyenda = "<b>Excelente el pago y el envío fueron exitosos.<br/>Muchas gracias por su compra.</b><br/>" . $contacto[1];
                                                                        break;
                                                                    }
                                                                    ?>
                                                                </a>
                                                            </h5>
                                                        </div>
                                                        <div id="<?= $tipo ?>collapse<?php echo $row["id_pedidos"]; ?>" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
                                                            <div class="panel-body">
                                                                <table class="table table-striped">
                                                                    <thead>
                                                                        <th>
                                                                            Nombre producto
                                                                        </th>
                                                                        <th>
                                                                            Cantidad
                                                                        </th>
                                                                        <th>
                                                                            Precio unidad
                                                                        </th>
                                                                        <th>
                                                                            Precio total
                                                                        </th>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php echo $row["productos_pedidos"]; ?>
                                                                    </tbody>
                                                                </table>
                                                                <hr/>
                                                                <div class="col-md-12 col-xs-12">
                                                                    <?php echo $leyenda ?>
                                                                </div>
                                                                <div class="col-md-12 col-xs-12">
                                                                    <br/>
                                                                    <span>
                                                                        Cambiar estado por:
                                                                    </span>
                                                                    <div class="clearfix">
                                                                    </div><br/>
                                                                    <a href="index.php?op=verPedidos&estado=0&id=<?php echo $row["id_pedidos"]; ?>" class=" btnPedidosAdmin <?php
                                                                    if ($row["estado_pedidos"] == 0) {
                                                                        echo "btnPedidosAdminOk";
                                                                    } ?> btn btn-warning">
                                                                    Pago pendiente
                                                                </a>

                                                                <a href="index.php?op=verPedidos&estado=1&id=<?php echo $row["id_pedidos"]; ?>" class=" btnPedidosAdmin <?php
                                                                if ($row["estado_pedidos"] == 1) {
                                                                    echo "btnPedidosAdminOk";
                                                                } ?> btn btn-success">
                                                                Pago exitoso
                                                            </a>

                                                            <a href="index.php?op=verPedidos&estado=2&id=<?php echo $row["id_pedidos"]; ?>"  class=" btnPedidosAdmin <?php
                                                            if ($row["estado_pedidos"] == 2) {
                                                                echo "btnPedidosAdminOk";
                                                            } ?> btn btn-danger">
                                                            Pago erróneo
                                                        </a>

                                                        <a href="index.php?op=verPedidos&estado=3&id=<?php echo $row["id_pedidos"]; ?>"  class=" btnPedidosAdmin <?php
                                                        if ($row["estado_pedidos"] == 3) {
                                                            echo "btnPedidosAdminOk";
                                                        } ?> btn  btn-info">
                                                        Pedido enviado
                                                    </a>
                                                </div>
                                                <div class="clearfix">
                                                </div>
                                                <hr/>
                                                <div class="col-md-12 col-xs-12">
                                                    <?php echo $usuario ?>

                                                    <?php
                                                    switch ($row["tipo_pedidos"]) {
                                                        case 3:
                                                        $tipoPedido = "Coordino con el vendedor";
                                                        break;
                                                        case 2:
                                                        $tipoPedido = "Tarjeta de Crédito";
                                                        break;
                                                        case 1:
                                                        $tipoPedido = "Transferencia Bancaria";
                                                        break;

                                                    }
                                                    echo "<hr/><span style='font-size:16px'><b>FORMA DE PAGO</b> <div class='btn btn-primary pull-right'>" . $tipoPedido . "</div></span>";
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php

                                }
                            } else {
                                ?>
                                <div class="alert alert-danger animated fadeInDown" role="alert">
                                    ¡No tenés ningún pedido añadido!
                                    </div><?php

                                }
                            }

                            function Banner_A_Create()
                            {
                                $idConn = Conectarse();

                                $nombre = $_POST["link"];

                                $imgInicio = "";
                                $destinoImg = "";
                                $prefijo = substr(md5(uniqid(rand())), 0, 6);
                                $imgInicio = $_FILES["archivo_subir"]["tmp_name"];
                                $tucadena = $_FILES["archivo_subir"]["name"];
                                $partes = explode(".", $tucadena);
                                $dominio = $partes[1];
                                $destinoImg = "../bannerF/" . $prefijo . "." . $dominio;
                                move_uploaded_file($imgInicio, $destinoImg);
                                $destinoFinal = "bannerF/" . $prefijo . "." . $dominio;
                                chmod($destinoImg, 0777);

                                $sql =
                                "INSERT INTO `banner_animado`
                                (`LinkBanner`, `RutaBanner`)
                                VALUES
                                ('$nombre', '$destinoFinal')";
                                $resultado = mysqli_query($idConn, $sql);
                            }

                            function Categoria_Create()
                            {

                                $TituloSuplemento = $_POST["descripcion"];

                                $sql =
                                "INSERT INTO `categoriabase`
                                (`IdSuplementos`,`TituloSuplementos`)
                                VALUES
                                (NULL, '$TituloSuplemento')";
                                $idConn = Conectarse();

                                $resultado = mysqli_query($idConn, $sql);
                                echo "<script language=Javascript> location.href=\"index.php?pag=notas&op=A\"; </script>";

                            }

                            function CategoriaPro_Create()
                            {

                                $nombre = $_POST["descripcion"];

                                $sql =
                                "INSERT INTO `categoriaproducto`
                                (`IdCategoriaProducto`,`NombreCategoriaProducto`)
                                VALUES
                                (NULL, '$nombre')";
                                $idConn = Conectarse();

                                $resultado = mysqli_query($idConn, $sql);
                                echo "<script language=Javascript> location.href=\"index.php?pag=productos&op=A\"; </script>";

                            }

                            function Video_Create()
                            {

                                $TituloSuplemento = $_POST["descripcion"];

                                $sql =
                                "INSERT INTO `videosbase` VALUES
                                (NULL, '$TituloSuplemento')";
                                $idConn = Conectarse();

                                $resultado = mysqli_query($idConn, $sql);
                                echo "<script language=Javascript> location.href=\"index.php?pag=videos&op=A\"; </script>";

                            }

                            function Registro_Create()
                            {

                                $nombre = $_POST["nombre"];
                                $email = $_POST["email"];
                                $pass = $_POST["pass"];
                                $direccion = $_POST["direccion"];
                                $provincia = $_POST["provincia"];
                                $localidad = $_POST["localidad"];
                                $telefono = $_POST["telefono"];

                                $sql =
                                "INSERT INTO `registrobase`
                                (`NombreRegistro`, `EmailRegistro`,`PasswordRegistro`  , `ProvinciaRegistro`, `LocalidadRegistro`,`DireccionRegistro`,  `TelefonoRegistro`)
                                VALUES
                                ('$nombre' , '$email' ,'$pass' , '$provincia' , '$localidad' ,'$direccion' ,'$telefono')";
                                $idConn = Conectarse();

                                $resultado = mysqli_query($idConn, $sql);
                                echo "<script language=Javascript> location.href=\"index.php?pag=registros&op=A\"; </script>";

                            }

                            function Precio_Create()
                            {

                                $titulo = $_POST["descripcion"];
                                $periodo = $_POST["periodo"];
                                $precio = $_POST["precio"];
                                $descripcion = $_POST["caracteristicas"];

                                $sql =
                                "INSERT INTO `preciosbase`
                                VALUES
                                (NULL,'$titulo' , '$periodo' ,'$descripcion' , '$precio')";
                                $idConn = Conectarse();

                                $resultado = mysqli_query($idConn, $sql);
                                echo "<script language=Javascript> location.href=\"index.php?pag=precios&op=A\"; </script>";

                            }

                            function Revisar_Registro($email)
                            {
                                $sql = "SELECT  `EmailRegistro`
                                FROM registrobase
                                WHERE  `EmailRegistro` = '$email'";

                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);
                                return $data;
                            }

                            function Revisar_Compras($email)
                            {
                                $sql = "SELECT  *
                                FROM `registrobase`, `comprasbase`
                                WHERE  `EmailRegistro` = `email` AND `IdRegistro` = $email";

                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);

                                while ($row = mysqli_fetch_array($result)) {
                                    $f = explode(" ", $row["fecha"]);
                                    $fecha = explode("-", $f[0]);
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo strtoupper($row["descripcion"]) ?>
                                        </td>
                                        <td>
                                            $<?php echo $row["total"] ?>
                                        </td>
                                        <td>
                                            <?php echo $fecha[2] . "/" . $fecha[1] . "/" . $fecha[0] . " " . $f[1] ?>
                                        </td>
                                        <td>
                                            <?php
                                            switch ($row['estado']) {
                                                case "0":
                                                echo "Exitoso";
                                                break;
                                                case "1":
                                                echo "Pendiente";
                                                break;
                                                case "2":
                                                echo "Proceso";
                                                break;
                                                case "3":
                                                echo "Rechazado";
                                                break;
                                                case "4":
                                                echo "Anulado";
                                                break;
                                            }
                                            ?>
                                        </td>
                                    </tr>

                                    <?php

                                }
                            }

                            function Registro_Create_Front()
                            {

                                $nombre = $_POST["nombre"];
                                $email = $_POST["email"];
                                $pass = $_POST["pass"];
                                $direccion = $_POST["direccion"];
                                $provincia = $_POST["provincia"];
                                $localidad = $_POST["localidad"];
                                $telefono = $_POST["telefono"];

                                $sql =
                                "INSERT INTO `registrobase`
                                (`NombreRegistro`, `UsuarioRegistro`, `EmailRegistro`,`PasswordRegistro`  , `ProvinciaRegistro`, `LocalidadRegistro`,`DireccionRegistro`,  `TelefonoRegistro`)
                                VALUES
                                ('$nombre' , '$email' , '$email' ,'$pass' , '$provincia' , '$localidad' ,'$direccion' ,'$telefono')";
                                $idConn = Conectarse();

                                $resultado = mysqli_query($idConn, $sql);

                            }

                            function Suscripto_Create()
                            {

                                if (isset($_POST['Enviar'])) {
                                    $fecha = date("j, n, Y");
                                    $email = $_POST['suscripto'];

                                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                        $idConn = Conectarse();

                                        $sql = "INSERT INTO `suscriptobase`(`EmailSuscriptos`, `FechaSuscriptos`)VALUES ('$email', '$fecha')";
                                        $resultado = mysqli_query($idConn, $sql);

                                        unset($email);
                                    }
                                }
                            }

                            /* * **************************** ELIMINAR DE TABLAS */

                            if ($pagina == "notas" && $op == "e") {
                                $idCategoria = $_GET["id"];
                                $Base = "notabase";
                                $Tabla = "IdNotas";
                                Categoria_Eliminar($idCategoria, $Base, $Tabla, $pagina);

                            } elseif ($pagina == "videos" && $op == "e") {
                                $idNota = $_GET["id"];
                                $Base = "videosbase";
                                $Tabla = "IdVideo";
                                Categoria_Eliminar($idNota, $Base, $Tabla, $pagina);
                            } elseif ($pagina == "banner" && $op == "e") {
                                $idSuscrpito = $_GET["id"];
                                $Base = "banner_fijo";
                                $Tabla = "IdBanner";
                                Categoria_Eliminar($idSuscrpito, $Base, $Tabla, $pagina);
                            } elseif ($pagina == "slider" && $op == "e") {
                                $idSuscrpito = $_GET["id"];
                                $Base = "sliderbase";
                                $Tabla = "IdSlider";
                                Categoria_Eliminar($idSuscrpito, $Base, $Tabla, $pagina);
                            } elseif ($pagina == "registros" && $op == "e") {
                                $idSuscrpito = $_GET["id"];
                                $Base = "registrobase";
                                $Tabla = "IdRegistro";
                                Categoria_Eliminar($idSuscrpito, $Base, $Tabla, $pagina);
                            } elseif ($pagina == "productos" && $op == "e") {
                                $idSuscrpito = $_GET["id"];
                                $Base = "productobase";
                                $Tabla = "IdProducto";
                                Categoria_Eliminar($idSuscrpito, $Base, $Tabla, $pagina);
                            } elseif ($pagina == "promociones" && $op == "e") {
                                $idSuscrpito = $_GET["id"];
                                $Base = "promocionbase";
                                $Tabla = "id";
                                Categoria_Eliminar($idSuscrpito, $Base, $Tabla, $pagina);
                            } elseif ($pagina == "home" && $op == "e") {
                                $idSuscrpito = $_GET["id"];
                                $Base = "consultasbase";
                                $Tabla = "id";
                                Categoria_Eliminar($idSuscrpito, $Base, $Tabla, $pagina);
                            } elseif ($pagina == "compra" && $op == "e") {
                                $idSuscrpito = $_GET["id"];
                                $Base = "comprasbase";
                                $Tabla = "id";
                                Categoria_Eliminar($idSuscrpito, $Base, $Tabla, $pagina);
                            } elseif ($pagina == "precios" && $op == "e") {
                                $idSuscrpito = $_GET["id"];
                                $Base = "preciosbase";
                                $Tabla = "id";
                                Categoria_Eliminar($idSuscrpito, $Base, $Tabla, $pagina);
                            } elseif ($pagina == "control" && $op == "e") {
                                $idSuscrpito = $_GET["id"];
                                $Base = "interno";
                                $Tabla = "id";
                                Categoria_Eliminar($idSuscrpito, $Base, $Tabla, $pagina);
                            } elseif ($pagina == "orden" && $op == "e") {
                                $idSuscrpito = $_GET["id"];
                                $Base = "orden";
                                $Tabla = "id_orden";
                                Categoria_Eliminar($idSuscrpito, $Base, $Tabla, $pagina);
                            } elseif ($pagina == "portfolio" && $op == "e") {
                                $idSuscrpito = $_GET["id"];
                                $Base = "portfolio";
                                $Tabla = "IdPortfolio";
                                Categoria_Eliminar($idSuscrpito, $Base, $Tabla, $pagina);
                            }

                            function Categoria_Eliminar($id, $base, $tabla, $pagina)
                            {
                                $sql = "DELETE FROM $base WHERE $tabla = $id";
                                $link = Conectarse();
                                $r = mysqli_query($link, $sql);
                                return $r;
                                echo "<script language=Javascript> location.href=\"index.php?pag=$pagina&op=A\"; </script>";
                            }

                            /* * ***************************** */

                            function Categoria_Read_Solo($categoriaSelect)
                            {
                                $sql = "SELECT * FROM `categorias` WHERE `rubro_categoria` = '$categoriaSelect'";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);
                                return $data;
                            }

                            function Rubro_Read_Solo($categoriaSelect)
                            {
                                $sql = "SELECT * FROM `rubros` WHERE `cod_rubros` = '$categoriaSelect'";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);
                                return $data;
                            }


                            function Traer_Marcas($marca)
                            {
                                $sql = "SELECT marca_marcas FROM `marcas_autos` GROUP BY marca_marcas";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                while ($data = mysqli_fetch_row($result)) {
                                    if (($marca) == $data[0]) {
                                        echo '<option value="' . ($data[0]) . '" selected>' . $data[0] . '</option> ';
                                    } else {
                                        echo '<option value="' . ($data[0]) . '">' . $data[0] . '</option> ';
                                    }
                                }
                            }


                            function Traer_Marcas_Admin($id)
                            {
                                $sql = "SELECT marca_marcas FROM `marcas_autos` GROUP BY marca_marcas";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                while ($data = mysqli_fetch_row($result)) {
                                    if (($id) == $data[0]) {
                                        echo '<option value="' . ($data[0]) . '" selected>' . $data[0] . '</option> ';
                                    } else {
                                        echo '<option value="' . ($data[0]) . '">' . $data[0] . '</option> ';
                                    }
                                }
                            }

                            function Marcas_TraerPorId($id)
                            {
                                $sql = "SELECT * FROM `marcas_autos` WHERE id_marcas = '" . $id . "'";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_assoc($result);
                                return $data;
                            }

                            function Marcas_Read()
                            {
                                $sql = "SELECT * FROM `marcas_autos` ORDER BY marca_marcas ASC";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                while ($data = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo strtoupper($data["marca_marcas"]) ?>
                                        </td>
                                        <td style="text-align: right">
                                            <a href="index.php?op=verModelos&id=<?php echo $data["id_marcas"] ?>" class="btn btn-default"  data-toggle="tooltip" alt="Ver Modelos" title="Ver Modelos">
                                                MODELOS
                                            </a>
                                            <a href="index.php?op=modificarMarcas&id=<?php echo $data["id_marcas"] ?>"  class="btn btn-default" data-toggle="tooltip" alt="Modificar" title="Modificar">
                                                <i class="glyphicon glyphicon-cog" >
                                                </i>
                                            </a>
                                            <a href="index.php?op=verMarcas&borrar=<?php echo $data["id_marcas"] ?>"  class="btn btn-default"  alt="Eliminar" title="Eliminar" onClick="return confirm('¿Seguro querés eliminar?')" >
                                                <i class="glyphicon glyphicon-trash">
                                                </i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php

                                }
                            }



                            function Modelos_Read($id)
                            {
                                $sql = "SELECT * FROM `modelos_autos` WHERE marca_autos = $id  ORDER BY `modelos_autos`.`modelo_autos` ASC";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                while ($data = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo strtoupper($data["modelo_autos"]) ?>
                                        </td>
                                        <td style="text-align: right"> 
                                            <a href="index.php?op=verModelos&id=<?= $id ?>&borrar=<?php echo $data["id_autos"] ?>" style="width:20px"  alt="Eliminar" title="Eliminar" onClick="return confirm('¿Seguro querés eliminar?')" >
                                                <i class="glyphicon glyphicon-trash">
                                                </i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php

                                }
                            }

                            function Traer_Modelos($modelo, $marca)
                            {
                                $sql = "SELECT modelo_autos FROM `modelos_autos`, `marcas_autos` WHERE id_marcas = marca_autos AND marca_marcas =  '$marca' ORDER BY marca_marcas, modelo_autos";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                while ($data = mysqli_fetch_row($result)) {
                                    if ($modelo == $data[0]) {
                                        echo '<option value="' . $data[0] . '" selected>' . $data[0] . '</option> ';
                                    } else {
                                        echo '<option value="' . $data[0] . '">' . $data[0] . '</option> ';
                                    }
                                }
                            }

                            function Slider_TraerPorId($id)
                            {
                                $sql = "SELECT *
                                FROM sliderbase
                                WHERE IdSlider = $id";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);

                                return $data;
                            }

                            function Productos_TraerXId($id)
                            {
                                $sql = "SELECT DISTINCT * FROM productos WHERE id = '$id'";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);
                                return $data;
                            }


                            function Productos_TraerPorId($id)
                            {
                                $sql = "SELECT DISTINCT * FROM productos WHERE codigo_para_web = '$id'";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);
                                return $data;
                            }

                            function Productos_TraerPorCod($id)
                            {
                                $sql = "SELECT DISTINCT * FROM productos WHERE codigo_para_web = '$id'";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);
                                return $data;
                            }

                            function Productos_TraerPorNombre($id)
                            {
                                $sql = "SELECT *
                                FROM productos
                                WHERE titulo = '$id'";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);
                                return $data;
                            }

                            function Talles_Stock_TraerPorId($id)
                            {
                                $sql = "SELECT `talle_fabrica` FROM `productos`  WHERE `articulo` = '$id'  ORDER BY `articulo` asc";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $i = 0;
                                while ($data = mysqli_fetch_array($result)) {
                                    if ($data["talle_fabrica"] != '') {
                                        echo ' <input type="radio" id="radio' . $i . '" name="talle" value="' . $data["talle_fabrica"] . '"><label for="radio' . $i . '"><b>' . $data["talle_fabrica"] . '</b></label>';
                                        $i++;
                                    } else {
                                        echo ' <input type="radio" id="radio" name="talle" value="1"><label for="radio"><b>1</b></label>';
                                    }
                                }
                            }



                            function Albums_TraerPorId($id)
                            {
                                $sql = "SELECT *
                                FROM album
                                WHERE id_album = $id";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);

                                return $data;
                            }


                            function Promociones_TraerPorId($id)
                            {
                                $idConn = Conectarse();
                                $sql = "
                                SELECT *
                                FROM promociones
                                WHERE IdPromociones = $id
                                ";
                                $resultado = mysqli_query($idConn, $sql);

                                $data = mysqli_fetch_array($resultado);

                                return $data;
                            }

                            function Traer_Subcategorias($id)
                            {
                                $sql = "SELECT *
                                FROM subcategorias
                                WHERE categorias = $id";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                while ($data = mysqli_fetch_array($result)) {
                                    echo "<span style='margin-right:10px;'>" . strtoupper($data["nombre_subcategorias"]) . " <a href='index.php?op=subCategoria&borrar=" . $data['id_subcategorias'] . "'><img src='img/borrar2.png' width='12'></a></span> ";
                                }
                            }



                            function Buscar_Select($buscar)
                            {
                                $sql = "SELECT `$buscar`
                                FROM productos
                                GROUP BY `$buscar`";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                while ($data = mysqli_fetch_array($result)) {
                                    $data = $data[0];
                                    echo "<option value='$data'>$data</option>";
                                }
                            }


                            function Buscar_Anchor($buscar)
                            {
                                $sql = "SELECT `$buscar`
                                FROM productos
                                GROUP BY `$buscar`";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                while ($data = mysqli_fetch_array($result)) {
                                    $data = $data[0];
                                    echo "<a href='&=$data'>$data</option>";
                                }
                            }

                            function Categoria_Read_Nav()
                            {
                                $sql = "SELECT `categoria`
                                FROM productos
                                GROUP BY `categoria`";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $i = 1;
                                while ($data = mysqli_fetch_array($result)) {
                                    $data = $data[0];
                                    if ($i == 1) {
            //    echo " < div class = 'megaCol col - md - 6' > ";
                                    }
                                    echo "<li><a class='load' href='" . BASE_URL . "/productos?categoria=$data'>$data</a></li>";
                                    $i++;
                                    if ($i == 2) {
            //  echo "</div > ";
            //$i = 1;
                                    }
                                }
                            }

                            function Marcas_Read_Nav()
                            {
                                $sql = "SELECT `marca`
                                FROM productos
                                GROUP BY `marca`";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $i = 1;
                                while ($data = mysqli_fetch_array($result)) {
                                    $data = $data[0];
                                    if ($i == 1) {
            //echo " < div class = 'megaCol col - md - 3' > ";
                                    }
                                    echo "<li><a href='" . BASE_URL . "/productos?marca=$data'>$data</a></li>";
        //$i++;
                                    if ($i == 5) {
            //  echo "</div > ";
            //$i = 1;
                                    }
                                }
                            }



                            function Talles_Calzados_Talles($id)
                            {
                                $sql = "SELECT `talle_fabrica`,`stock`
                                FROM `productos`
                                WHERE `articulo` = '$id'
                                ORDER BY `articulo` asc";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                while ($data = mysqli_fetch_array($result)) {
                                    $talle = $data[0];
                                    $stock = $data[1];
                                    echo "<div class='btn btn-lg btn-info' style='margin-right:4px;margin-bottom:4px'>" . $talle . " (" . $stock . " unidades)</div>";
                                }
                                echo "<div class='clearfix'></div>";
                            }


                            function Buscar_Select_Talles($buscar, $categoria, $seleccionado)
                            {
                                $sql = "SELECT `$buscar`
                                FROM `productos`
                                WHERE `categoria` = '$categoria'
                                GROUP BY `$buscar`
                                ORDER BY `fn_desco` DESC";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                echo "<option value=''></option>";
                                echo "<option value='XXL'>XXL</option>";
                                while ($data = mysqli_fetch_array($result)) {
                                    $data = str_replace(".0", "", $data[0]);
                                    if ($data == $seleccionado) {
                                        echo "<option value='$data' selected>$data</option>";
                                    } else {
                                        echo "<option value='$data'>$data</option>";
                                    }
                                }
                            }

                            function Revisar_Talle($talleS, $cantidadS, $cod)
                            {
                                $data = Productos_TraerPorId($cod);
                                if ((trim($data["unico"])) != '') {
                                    echo "<br/><span class='alert alert-danger' style='display:block;margin-bottom:0px'>El producto " . $data["descripcion"] . " es único par, por ende debe llevar 1 solo.</span>";
                                    echo "<style>#finalizarCarrito {display:none;}</style>";
                                }
                            }

                            function contar_repeticiones($array)
                            {
                                $cantidad = array_count_values($_SESSION["carrito"]);
                                $resultado = array_unique($cantidad);
                                $contar = count($array);
                                $contarResultado = count($resultado);
                                foreach ($resultado as $clave => $valor) {
                                    if ($valor > 1) {
            //echo $clave." < br > ";
                                        $explotarProducto = explode("-", $clave);
                                        @Revisar_Talle($explotarProducto[1], $valor, $explotarProducto[0]);
                                    }
                                }
                            }

                            function Buscar_Select_Talles_Calzados($buscar, $categoria, $seleccionado)
                            {
                                $sql = "SELECT `$buscar`
                                FROM `productos`
                                WHERE `categoria` = '$categoria'
                                GROUP BY `$buscar`
                                ORDER BY `fc_stock` DESC";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                echo "<option value=''></option>";
                                while ($data = mysqli_fetch_array($result)) {
                                    $stock = $data["fc_stock"];
                                    $buscar = array("(", ")", ".0");
                                    $stockFinal = str_replace($buscar, "", $stock);
                                    $stockExplotado = explode("/", $stockFinal);
                                    $contarExplotado = (count($stockExplotado) - 1);

                                    for ($i = 0; $i <= $contarExplotado; $i++) {
                                        $stockSeparados = explode("-", $stockExplotado[$i]);
                                        if ($contarExplotado != $i) {
                                            @$stockProducto .= $stockSeparados[1] . "-";
                                        } else {
                                            @$stockProducto .= $stockSeparados[1];
                                        }
                                    }
                                }

                                $stockFinal = explode("-", $stockProducto);
                                $stockFinal = array_unique($stockFinal);

                                $stockFinal = array_values($stockFinal);
                                rsort($stockFinal);
                                var_dump($stockFinal);

                                $contar = (count($stockFinal));
                                for ($d = 0; $d <= $contar; $d++) {
                                    if ($stockFinal[$d] != '') {
                                        if ($stockFinal[$d] >= 15) {
                                            if ($stockFinal[$d] == $seleccionado) {
                                                echo '<option value="' . $stockFinal[$d] . '" selected>' . $stockFinal[$d] . '</option>';
                                            } else {
                                                echo '<option value="' . $stockFinal[$d] . '">' . $stockFinal[$d] . '</option>';
                                            }
                                        }
                                    }
                                }
                            }

                            function TraerDatos_DB($db)
                            {
                                $sql = "SELECT COUNT(*)
                                FROM $db";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);
                                return $data;
                            }



                            function Cursos_TraerPorId($id)
                            {
                                $sql = "SELECT *
                                FROM cursos
                                WHERE IdCursos = $id";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);

                                return $data;
                            }

                            function Agencias_TraerPorId($id)
                            {
                                $sql = "SELECT *
                                FROM agencias
                                WHERE id_agencia = $id";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);

                                return $data;
                            }

                            function Publicidad_TraerPorId($id)
                            {
                                $sql = "SELECT *
                                FROM publicidad
                                WHERE id_publicidad = $id";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);

                                return $data;
                            }

                            function Micrositio_TraerPorId($id)
                            {
                                $sql = "SELECT *
                                FROM agencias, micrositio
                                WHERE cod_agencia = cod_micrositio  AND cod_micrositio = '$id' ";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);

                                return $data;
                            }

                            function TraerServer($id)
                            {
                                $sql = "SELECT *
                                FROM server
                                WHERE id = $id";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);

                                return $data;
                            }

                            function Precios_TraerPorId($id)
                            {
                                $sql = "SELECT *
                                FROM preciosbase
                                WHERE id = $id";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);

                                return $data;
                            }

                            function porcentaje($cantidad, $porciento, $decimales)
                            {
                                return number_format($cantidad * $porciento / 100, $decimales, '.', '');
                            }

                            function TraerCodigo($id)
                            {
                                $sql = "SELECT *
                                FROM productobase
                                WHERE SubCategoriaProducto = $id";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);

                                return $data;
                            }

                            function Promocion_TraerPorId($id)
                            {
                                $sql = "SELECT *
                                FROM promocionbase
                                WHERE promocionbase.id = $id";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);

                                return $data;
                            }

                            function Registro_TraerPorId($id)
                            {
                                $sql = "SELECT *
                                FROM usuarios
                                WHERE id = $id";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);
                                return $data;
                            }

                            function Precios_Envio_Read()
                            {
                                $cnx = Conectarse();
                                $sql = "SELECT *  FROM `envio` ORDER BY peso ASC";
                                $result = mysqli_query($cnx, $sql);
                                while ($data = mysqli_fetch_array($result)) {
                                    ?>
                                    <tr>
                                        <td>
                                            Hasta <?php echo $data["peso"] ?>kg <?php
                                            if ($data["tipo"] == "dom") {
                                                echo " a Domicilio";
                                            } else {
                                                echo " a Sucursal";
                                            } ?>
                                        </td>
                                        <td>
                                            <span class="pull-left">
                                                <b>
                                                    $
                                                </b>
                                            </span>
                                            <form method="post" class="pull-left">
                                                <input type="hidden" name="id" value="<?php echo $data["id"] ?>" />
                                                <input type="number" name="precio" value="<?php echo $data["precio"] ?>" style="margin:0 5px;width:70px" />
                                                <button type="submit" name="enviarEnvio" class="btn btn-info btn-sm" style="margin:0 5px;">
                                                    <i class="fa fa-save">
                                                    </i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php

                                }
                            }

                            function Precio_Envio($peso, $tipo)
                            {
                                $cnx = Conectarse();
                                $peso = mysqli_real_escape_string($cnx, $peso);
                                $tipo = mysqli_real_escape_string($cnx, $tipo);
                                $sql = "SELECT precio  FROM `envio`  WHERE `peso` = '$peso' AND `tipo` = '$tipo'";
                                $result = mysqli_query($cnx, $sql);
                                $data = mysqli_fetch_array($result);
                                return $data[0];
                            }



                            function Categoria_TraerPorId($id)
                            {
                                $sql = "SELECT *
                                FROM categorias
                                WHERE id_categoria = $id";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);

                                return $data;
                            }

                            function Rubro_TraerPorId($id)
                            {
                                $sql = "SELECT *
                                FROM rubros
                                WHERE id_rubros = $id";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);

                                return $data;
                            }

                            function Rubro_TraerPorCod($id)
                            {
                                $sql = "SELECT *
                                FROM rubros
                                WHERE cod_rubros = '$id'";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);

                                return $data;
                            }


                            function Banner_TraerPorId($id)
                            {
                                $sql = "SELECT *
                                FROM banner_fijo, bannersize
                                WHERE IdSizeBanner = SizeBanner && IdBanner = $id";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);

                                return $data;
                            }

                            function Banner_A_TraerPorId($id)
                            {
                                $sql = "SELECT *
                                FROM banner_animado
                                WHERE IdBanner = $id";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);

                                return $data;
                            }

                            function Nota_TraerPorId($id)
                            {
                                $sql = "SELECT *
                                FROM notabase
                                WHERE  IdNotas = $id";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);

                                return $data;
                            }

                            function Nota_TraerPorNombre($id)
                            {
                                $sql = "SELECT *
                                FROM notabase
                                WHERE  TituloNotas LIKE '%$id%'";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);

                                return $data;
                            }

                            function Financiacion_TraerPorId($id)
                            {
                                $sql = "SELECT *
                                FROM financiacion
                                WHERE  id_financiacion = $id";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);

                                return $data;
                            }

                            function Portfolio_TraerPorId($id)
                            {
                                $sql = "SELECT *
                                FROM productos
                                WHERE  id_portfolio = $id";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);

                                return $data;
                            }


                            function Usuario_TraerPorId($id)
                            {
                                $sql = "SELECT *
                                FROM usuarios
                                WHERE id = '$id'";
                                $link = Conectarse_Mysqli();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);

                                return $data;
                            }


                            function Portfolio_TraerPorCod($id)
                            {
                                $sql = "SELECT *
                                FROM productos
                                WHERE  codigo_para_web = '$id'";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);

                                return $data;
                            }

                            function Imagenes_Reconstruidos_TraerPorId($id)
                            {
                                $sql = "SELECT ruta
                                FROM `imagenes_maquinas`
                                WHERE  `maquina` = '$id'";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                while ($data = mysqli_fetch_array($result)) {
                                    @$imagenes .= $data[0] . "-";
                                };
                                return $imagenes;
                            }

                            function Imagenes_TraerPorId($id)
                            {
                                $sql = "SELECT ruta
                                FROM `imagenes`
                                WHERE  `codigo` = '$id'";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                while ($data = mysqli_fetch_array($result)) {
                                    @$imagenes .= $data[0] . "-";
                                };
                                return @$imagenes;
                            }

                            function Reconstruidos_TraerPorId($id)
                            {
                                $sql = "SELECT *
                                FROM maquinas
                                WHERE  id_portfolio = $id";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);

                                return $data;
                            }

                            function Nota_TraerPorId_Front($id)
                            {
                                $sql = "SELECT *
                                FROM notabase
                                WHERE IdNotas = $id";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);

                                return $data;
                            }

                            function Producto_TraerPorId($id)
                            {
                                $sql = "SELECT *
                                FROM productobase
                                WHERE IdProducto = $id";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);

                                return $data;
                            }

                            function Control_TraerPorId($id)
                            {
                                $sql = "SELECT *
                                FROM interno
                                WHERE id = $id";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);

                                return $data;
                            }

                            function Orden_TraerPorId($id)
                            {
                                $sql = "SELECT *
                                FROM orden
                                WHERE cod_orden = $id";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);

                                return $data;
                            }

                            function RRHH_TraerPorId($id)
                            {
                                $sql = "SELECT *
                                FROM rrhh
                                WHERE cod_orden = $id";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);

                                return $data;
                            }

                            function Orden_TraerPorId_Info($id)
                            {
                                $sql = "SELECT *
                                FROM orden, `interno`
                                WHERE `cod_orden` = `control` AND `id_orden` = $id";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);

                                return $data;
                            }

                            function Orden_TraerPorId_Info2($id)
                            {
                                $sql = "SELECT *
                                FROM orden
                                WHERE `id_orden` = $id";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);

                                return $data;
                            }

                            function RRHH_TraerPorId_Info($id)
                            {
                                $sql = "SELECT *
                                FROM rrhh
                                WHERE `id_orden` = $id";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);

                                return $data;
                            }

                            function Suma_Tiempo_Orden($id)
                            {
                                $sql = "SELECT SUM(tiempo)
                                FROM orden, interno
                                WHERE cod_orden = control AND id_orden = $id";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);

                                return $data;
                            }

                            function Video_TraerPorId($id)
                            {
                                $sql = "SELECT *
                                FROM videos
                                WHERE  IdVideos = $id";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);

                                return $data;
                            }

                            function Suplemendo_Modificar($arrData)
                            {
                                $sql =
                                "UPDATE categoriabase
                                SET
                                TituloSuplementos='$arrData[TituloSuplementos]'
                                , FechaSuplementos='$arrData[FechaSuplementos]'
                                , AutorSuplemento = '$arrData[AutorSuplemento]'
                                , DescripcionSuplemento='$arrData[DescripcionSuplemento]'
                                WHERE IdSuplementos=$arrData[IdSuplementos]";
                                $link = Conectarse();
                                $r = mysqli_query($link, $sql);
                            }

                            function ModificarServer($server)
                            {
                                $sql =
                                "UPDATE server
                                SET
                                server='$server'
                                WHERE id=1";
                                $link = Conectarse();
                                $r = mysqli_query($link, $sql);
                            }

                            function Actualizar_Stock($id, $stock)
                            {
                                $sql =
                                "UPDATE productobase
                                SET
                                FiltroProducto='$stock'
                                WHERE IdProducto= '$id'";
                                $link = Conectarse();
                                $r = mysqli_query($link, $sql);
                                echo "<script language=Javascript> location.href=\"index.php?pag=productos&op=A\"; </script>";
                            }

                            function Sumar_Micrositio($id)
                            {
                                $sql =
                                "UPDATE micrositio
                                SET
                                visitas_micrositio = visitas_micrositio+1
                                WHERE cod_micrositio = '$id'";
                                $link = Conectarse();
                                $r = mysqli_query($link, $sql);
                            }

                            function Sumar_Visitas($pag)
                            {
                                $link = Conectarse();
                                $ip = getenv('REMOTE_ADDR');
                                $consulta = "select * from  `visitas` where `ip_visita`='$ip' AND `pag_visita` = $pag AND fecha_visita = NOW()";
                                $resultado = mysqli_query($link, $consulta);
                                $fila = mysqli_fetch_array($resultado);
                                if ($fila == "") {
                                    $consulta2 = "INSERT INTO `visitas`(`fecha_visita`, `pag_visita`, `ip_visita`) VALUES (NOW(), '$pag', '$ip')";
                                    $resultado2 = mysqli_query($link, $consulta2);
                                }
                            }

                            function Actualizar_Estado($id, $estado)
                            {
                                $sql =
                                "UPDATE cursos
                                SET DestacarCurso = '$estado'
                                WHERE IdCursos = '$id'";
                                $link = Conectarse();
                                $r = mysqli_query($link, $sql);
                            }

                            function Actualizar_Estado_Publi($id, $estado)
                            {
                                $sql =
                                "UPDATE publicidad
                                SET estado_publicidad = '$estado'
                                WHERE cod_publicidad = '$id'";
                                $link = Conectarse();
                                $r = mysqli_query($link, $sql);
                            }

                            function Actualizar_Tipo($id, $estado)
                            {
                                $sql =
                                "UPDATE agencias
                                SET tipo_agencia = '$estado'
                                WHERE cod_agencia = '$id'";
                                $link = Conectarse();
                                $r = mysqli_query($link, $sql);
                            }

                            function Actualizar_Estado_RRHH($id, $estado)
                            {
                                $sql =
                                "UPDATE rrhh
                                SET
                                estado_orden = '$estado'
                                WHERE id_orden = '$id'";
                                $link = Conectarse();
                                $r = mysqli_query($link, $sql);
                                header("Location: index.php?op=verRRHH");
                            }

                            function Pasar_Vistos($id, $categoria)
                            {
                                $sql =
                                "UPDATE consultasbase
                                SET
                                categoria = '$categoria'
                                WHERE id= '$id'";
                                $link = Conectarse();
                                $r = mysqli_query($link, $sql);
                                header("Refresh: 2; URL='index.php?pag=consultas'");
                            }

                            function Restar_Stock($id, $stock)
                            {
                                $sql =
                                "UPDATE productobase
                                SET
                                FiltroProducto='$stock'
                                WHERE IdProducto= '$id'";
                                $link = Conectarse();
                                $r = mysqli_query($link, $sql);

                            }

                            function Slider_Modificar($arrData)
                            {
                                $sql =
                                "UPDATE sliderbase
                                SET
                                TituloSlider='$arrData[TituloSlider]'
                                , DescripcionSlider='$arrData[DescripcionSlider]'
                                , ImgSlider='$arrData[ImgSlider]'
                                WHERE IdSlider=$arrData[IdSlider]";
                                $link = Conectarse();
                                $r = mysqli_query($link, $sql);
                            }

                            function Banner_Modificar($arrData)
                            {
                                $sql =
                                "UPDATE banner_fijo
                                SET
                                LinkBanner='$arrData[LinkBanner]'
                                , RutaBanner='$arrData[RutaBanner]'
                                WHERE IdBanner=$arrData[IdBanner]";
                                $link = Conectarse();
                                $r = mysqli_query($link, $sql);

                                echo "<script language=Javascript> location.href=\"index2.php?pagina=bannerTodos\"; </script>";
                            }

                            function Banner_Modificar_A($arrData)
                            {
                                $sql =
                                "UPDATE banner_animado
                                SET
                                LinkBanner='$arrData[LinkBanner]'
                                , RutaBanner='$arrData[RutaBanner]'
                                WHERE IdBanner=$arrData[IdBanner]";
                                $link = Conectarse();
                                $r = mysqli_query($link, $sql);

                                echo "<script language=Javascript> location.href=\"index2.php?pagina=animadoTodos\"; </script>";
                            }

                            function Nota_Modificar($arrData)
                            {
                                $sql =
                                "UPDATE notabase
                                SET
                                TituloNotas='$arrData[TituloNotas]'
                                , CitasNotas='$arrData[CitasNotas]'
                                , FechaNotas='$arrData[FechaNotas]'
                                , IdSumplemento=''
                                , AutorNotas = '$arrData[AutorNotas]'
                                , DesarrolloNotas='$arrData[DesarrolloNotas]'
                                , ImgNotas='$arrData[ImgNotas]'
                                WHERE IdNotas=$arrData[IdNotas]";
                                $link = Conectarse();
                                $r = mysqli_query($link, $sql);

                            }

                            /* * **************************** USUARIO */

                            function Usuario_Login($user, $pass)
                            {
                                $sql = "
                                SELECT  *
                                FROM  `empleados`
                                WHERE  `usuario_usuario` =  '$user'
                                AND  `pass_usuario` =  '$pass'
                                ";

                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                return $result;
                            }

                            function Registros_Login($user, $pass)
                            {
                                $sql = "
                                SELECT  *
                                FROM  `usuarios`
                                WHERE  `email` =  '$user' AND  `pass` =  '$pass'
                                ";

                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                return $result;
                            }

                            function RLogin($usuario, $clave)
                            {
                                $result = Registros_Login($usuario, $clave);
                                $data = mysqli_fetch_array($result);
                                if ($data) {
                                    $_SESSION['user'] = $data;
                                    return 1;
                                } else {
                                    echo "<span style='color:#e74c3c'>Los datos son incorrectos</span><br/><br/>";
                                    return 0;
                                }
                            }

                            function Login($usuario, $clave)
                            {
                                $result = Usuario_Login($usuario, $clave);
                                $data = mysqli_fetch_array($result);
                                if ($data) {
                                    session_start();
                                    $_SESSION['usuario'] = $data;
                                    echo "<script>location.reload();</script>";
                                } else {
                                    ?>
                                    <script>
                                        alert("No puede ingresar ya que los datos no son los correctos.")
                                    </script>
                                    <?php

                                }
                            }

                            function Revisar_Tipo_Lista($id)
                            {
                                $sql = "SELECT  descuento FROM  `usuarios` WHERE  `id` =  '$id'";
                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $row = mysqli_fetch_array($result);
                                if ($_SESSION["descuento"] != $row["descuento"]) {
                                    $_SESSION["descuento"] = $row["descuento"];
                                }
                            }

                            function Verificar_Sorteo($email, $dni)
                            {
                                $sql = "
                                SELECT  *
                                FROM  `sorteo`
                                WHERE  `email` =  '$email' OR  `dni` =  '$dni'
                                ";

                                $link = Conectarse();
                                $result = mysqli_query($link, $sql);
                                $i = 0;
                                while ($data = mysqli_fetch_array($result)) {
                                    $i++;
                                }
                                return $i;
                            }

                            function normaliza($cadena)
                            {
                                $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞ
                                ßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
                                $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuy
                                bsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
                                $cadena = utf8_decode($cadena);
                                $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
                                $cadena = strtolower($cadena);
                                return utf8_encode($cadena);
                            }

                            function LogOut()
                            {
                                unset($_SESSION['usuario']);
                                session_unset();
                                session_destroy();
                            }


                            function Revisar_Email($base, $tabla, $email)
                            {
                                $sql = "
                                SELECT  *
                                FROM  `$base`
                                WHERE  `$tabla` =  '$email'";

                                $link = Conectarse_Mysqli();
                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);
                                return $data;
                            }

                            function Crear_PDF_S($nombre, $socio, $email, $cargo, $cod, $archivo)
                            {
                                $nombreF = iconv('UTF-8', 'windows-1252', strtoupper($nombre));
                                $socioF = iconv('UTF-8', 'windows-1252', strtoupper($socio));
                                $cargoF = iconv('UTF-8', 'windows-1252', strtoupper($cargo));
                                $emailF = iconv('UTF-8', 'windows-1252', strtolower($email));

                                $pdf = new FPDF();
                                $pdf->AddPage();
                                $pdf->SetFont('Arial', '', 11);
    //inserto la cabecera poniendo una imagen dentro de una celda
                                $pdf->SetMargins(105, 140);

                                $pdf->Cell(700, 85, $pdf->Image('img/entrada_socios.jpg', 30, 12, 160), 0, 0, 'C');
                                $pdf->Ln(50);
                                $pdf->Cell(40, 12, date('d/m/Y'), 0, "L");
                                $pdf->Cell(60, 12, $cod, 0, "R");
                                $pdf->Ln(7);
                                $pdf->Cell(100, 12, "Nombre : " . $nombreF);
                                $pdf->Ln(7);
                                $pdf->Cell(100, 12, "Email: " . $emailF);
                                $pdf->Ln(7);
                                $pdf->Cell(100, 12, "Cargo / Puesto: " . $cargoF);
                                $pdf->Ln(7);
                                $pdf->Cell(100, 12, "Asociado: " . $socioF);
                                $pdf->Ln(7);

                                $pdf->SetFont('Arial', '', 8);

                                $pdf->Output($archivo);

                            }

                            function Crear_PDF_I($empresa, $nombre, $email, $archivo, $cod)
                            {
                                $nombreF = iconv('UTF-8', 'windows-1252', strtoupper($nombre));
                                $emailF = iconv('UTF-8', 'windows-1252', strtolower($email));
                                $empresaF = iconv('UTF-8', 'windows-1252', strtoupper($empresa));

                                $pdf = new FPDF();
                                $pdf->AddPage();
                                $pdf->SetFont('Arial', '', 11);
    //inserto la cabecera poniendo una imagen dentro de una celda
                                $pdf->SetMargins(105, 140);

                                $pdf->Cell(700, 85, $pdf->Image('img/entrada_usuarios.jpg', 30, 12, 160), 0, 0, 'C');
                                $pdf->Ln(47);
                                $pdf->Ln(3);
                                $pdf->Cell(40, 12, date('d/m/Y'), 0, "L");
                                $pdf->Cell(60, 12, $cod, 0, "R");
                                $pdf->Ln(12);
                                $pdf->Cell(100, 12, "Empresa : " . $empresaF);
                                $pdf->Ln(7);
                                $pdf->Cell(100, 12, "Nombre : " . $nombreF);
                                $pdf->Ln(7);
                                $pdf->Cell(100, 12, "Email: " . $emailF);

                                $pdf->SetFont('Arial', '', 8);

                                $pdf->Output($archivo);

                            }

                            /* * ************************ ARCHIVOS */

                            function Subir_Archivos_Suplementos()
                            {
                                $img = "";
                                $pdf = "";
                                $destinoImg = "";
                                $destinoPdf = "";
    //img
                                $img = $_FILES["img_suplemento"]["tmp_name"];
                                $destinoImg = "suplemento/img_suplemento/" . $_FILES["img_suplemento"]["name"];
                                move_uploaded_file($img, $destinoImg);
                                echo "Imagen Subida";
    //pdf
                                $pdf = $_FILES["pdf_suplemento"]["tmp_name"];
                                $destinoPdf = "suplemento/pdf_suplemento/" . $_FILES["pdf_suplemento"]["name"];
                                move_uploaded_file($pdf, $destinoPdf);
                                echo "Suplemento Subido";
                            }

                            /* * ****** ORDENAR DATOS */

                            function reordenar()
                            {
                                if (isset($_POST['Reordenar'])) {
                                    $sql = "ALTER TABLE notabase AUTO_INCREMENT=1";
                                    $link = Conectarse();
                                    $result = mysqli_query($link, $sql);
                                    return $result;
                                    echo "<script language=Javascript> location.href=\"index2.php?pagina=notasTodas\"; </script>";
                                }
                            }

                            /************************************** PAGINA ****************************************/

                            function Propiedades_Read()
                            {
                                $idConn = Conectarse();
                                $sql = "
                                SELECT *
                                FROM productobase, categoriaproducto
                                WHERE CategoriaProducto = IdCategoriaProducto
                                ORDER BY IdProducto DESC
                                ";
                                $resultado = mysqli_query($idConn, $sql);
    //Carga del array de datos

                                while ($row = mysqli_fetch_array($resultado)) {
                                    $descripcion = ucfirst(strtolower(trim(strip_tags($row["DescripcionProducto"]))));
                                    ?>
                                    <div class="anuncio">
                                        <center class="contImg">
                                            <img src="../admin/<?php echo $row["ImgProducto1"] ?>" width="200">
                                        </center>
                                        <center>
                                            <h4 class="robo azul">
                                                <?php echo $row["NombreProducto"] ?>
                                            </h4>
                                            <img src="img/separador.png" width="90%" />
                                            <span class="abajo robo">
                                                <?php echo strtoupper($row["LocalidadProducto"]) ?>
                                            </span>
                                            <p class="noto">

                                                <?php echo substr($descripcion, 0, 200) ?>
                                            </p>
                                            <div class="boton noto">
                                                <a href="index.php?pag=propiedad&id=<?php echo $row["IdProducto"] ?>&op=1">
                                                    QUIERO VIVIR ACÁ
                                                </a>
                                                <a href="index.php?pag=propiedad&id=<?php echo $row["IdProducto"] ?>">
                                                    VER +
                                                </a>
                                            </div>
                                        </center>
                                    </div>



                                    <?php

                                }
                            }

                            function Propiedad_Cada_Read($id)
                            {
                                $link = Conectarse();
                                $sql = "
                                SELECT *
                                FROM productobase, categoriaproducto
                                WHERE IdProducto = $id
                                ";

                                $result = mysqli_query($link, $sql);
                                $data = mysqli_fetch_array($result);

                                return $data;
                            }

                            function Localidades_Read($palabra)
                            {
                                $idConn = Conectarse();
                                $sql = "SELECT  `localidad_agencia`
                                FROM  `agencias`
                                WHERE  `provincia_agencia` LIKE  '%$palabra%'
                                GROUP BY `localidad_agencia`
                                ";
                                $resultado = mysqli_query($idConn, $sql);

                                while ($row = mysqli_fetch_array($resultado)) {
                                    $contar = "SELECT COUNT('localidad_agencia') FROM  `agencias` WHERE  `localidad_agencia` LIKE  '%" . $row['localidad_agencia'] . "%'  GROUP BY  `localidad_agencia`";
                                    $resultContar = mysqli_query($idConn, $contar);
                                    $row2 = mysqli_fetch_row($resultContar)
                                    ?>
                                    <option value="<?php echo $row['localidad_agencia'] ?>">
                                        <?php echo strtoupper($row['localidad_agencia']) ?> (<?php echo ($row2[0]) ?>)
                                    </option>
                                    <?php

                                }
                            }

                            function Traer_Options($palabra)
                            {
                                $idConn = Conectarse();
                                $sql = "SELECT *
                                FROM  `categorias`
                                WHERE  `trabajo_categoria` LIKE  '%$palabra%'
                                GROUP BY `nombre_categoria`
                                ";
                                $resultado = mysqli_query($idConn, $sql);

                                while ($row = mysqli_fetch_array($resultado)) {
                                    ?>
                                    <option value="<?php echo $row['nombre_categoria'] ?>">
                                        <?php echo strtoupper($row['nombre_categoria']) ?>
                                    </option>
                                    <?php

                                }
                            }

                            function Provincias_Read_Front()
                            {
                                $idConn = Conectarse_Mysqli();
                                $sql = "SELECT `nombre` FROM  `_provincias` ORDER BY nombre";
                                $resultado = mysqli_query($idConn, $sql);
                                while ($row = mysqli_fetch_row($resultado)) {
                                    ?>
                                    <option value="<?php echo limpiar_caracteres_especiales($row[0]) ?>">
                                        <?php echo mb_strtoupper($row[0]) ?>
                                    </option>
                                    <?php

                                }
                            }

                            function Calles_Read($prov, $loc)
                            {
                                $idConn = Conectarse();
                                $sql = "SELECT  `direccion_agencia`
                                FROM  `agencias`
                                WHERE  `provincia_agencia` LIKE  '%$prov%' AND `localidad_agencia` LIKE  '%$loc%'
                                ORDER BY `direccion_agencia` ASC
                                ";
                                $resultado = mysqli_query($idConn, $sql);

                                while ($row = mysqli_fetch_array($resultado)) {
                                    ?>
                                    <option value="<?php echo $row['direccion_agencia'] ?>">
                                        <?php echo strtoupper($row['direccion_agencia']) ?>
                                    </option>
                                    <?php

                                }
                            }

                            function Promociones_Option()
                            {
                                $idConn = Conectarse();
                                $sql = "SELECT * FROM  `promocionbase`";
                                $resultado = mysqli_query($idConn, $sql);
    //Carga del array de datos

                                while ($row = mysqli_fetch_row($resultado)) {
                                    ?>

                                    <option value="<?php echo $row[1] ?>">
                                        <?php echo strtoupper($row[1]) ?>
                                    </option>


                                    <?php

                                }
                            }

                            function Provincias_Read()
                            {
                                $idConn = Conectarse();
                                $sql = "SELECT nombre FROM  `provincias` ORDER BY nombre";
                                $resultado = mysqli_query($idConn, $sql);
                                while ($row = mysqli_fetch_row($resultado)) {
                                    ?>
                                    <li class="listProv">
                                        <a href="busqueda.php?prov=<?php echo $row[0] ?>">
                                            <?php echo strtoupper($row[0]) ?>
                                        </a>
                                    </li>
                                    <?php

                                }
                            }

                            function Agencias_Read($prov, $loc, $calle, $agencia)
                            {
                                $idConn = Conectarse();

                                if ($agencia != '') {
                                    $sql = "SELECT * FROM  `agencias` WHERE  `nombre_agencia` LIKE  '%$agencia%' ORDER BY tipo_agencia desc";
                                    $sql2 = "SELECT COUNT('id') FROM `agencias` WHERE  `nombre_agencia` LIKE  '%$agencia%'";
                                } elseif ($calle != '') {
                                    $sql = "SELECT * FROM  `agencias` WHERE  `provincia_agencia` LIKE  '%$prov%' AND `localidad_agencia` LIKE  '%$loc%' AND `direccion_agencia` LIKE  '%$calle%' ORDER BY tipo_agencia desc";
                                    $sql2 = "SELECT COUNT('id') FROM  `agencias` WHERE  `provincia_agencia` LIKE  '%$prov%' AND `localidad_agencia` LIKE  '%$loc%' AND `direccion_agencia` LIKE  '%$calle%'";
                                } elseif ($loc != '') {
                                    $sql = "SELECT * FROM  `agencias` WHERE  `provincia_agencia` LIKE  '%$prov%' AND `localidad_agencia` LIKE  '%$loc%'  ORDER BY tipo_agencia desc";
                                    $sql2 = "SELECT COUNT('id') FROM  `agencias` WHERE  `provincia_agencia` LIKE  '%$prov%' AND `localidad_agencia` LIKE  '%$loc%'";
                                } elseif ($prov != '') {
                                    $sql = "SELECT * FROM  `agencias` WHERE  `provincia_agencia` LIKE  '%$prov%' ORDER BY tipo_agencia desc";
                                    $sql2 = "SELECT COUNT('id') FROM  `agencias` WHERE  `provincia_agencia` LIKE  '%$prov%'";
                                } else {
                                    $sql = "SELECT * FROM  `agencias` ORDER BY tipo_agencia desc LIMIT 30";
                                    $sql2 = "SELECT COUNT('id') FROM  `agencias`";
                                }

                                $resultado = mysqli_query($idConn, $sql);
                                $resultado2 = mysqli_query($idConn, $sql2);

                                $row2 = mysqli_fetch_row($resultado2);

                                $count = $row2[0];

                                if ($count != 0) {
                                    while ($row = mysqli_fetch_array($resultado)) {
                                        ?>
                                        <hr/>
                                        <div class="row listado">
                                            <div class="large-3 small-3 medium-3 column">
                                                <?php
                                                if ($row["logo_agencia"] == '') {
                                                    ?><img src="img/foto.jpg" width="100%" ><?php

                                                } else {
                                                    ?><img src="<?php echo $row["logo_agencia"] ?>" width="100%" ><?php

                                                }
                                                ?>
                                            </div>
                                            <div class="large-9 small-9 medium-9 column" style="display: block;">
                                                <h3>
                                                    <?php echo $row["nombre_agencia"] ?>
                                                </h3>
                                                <?php
                                                switch ($row["tipo_agencia"]) {
                                                    case 0:
                                                    ?>
                                                    <p>
                                                        <?php echo strtoupper($row["localidad_agencia"]) ?> -
                                                        <?php echo strtoupper($row["provincia_agencia"]) ?>
                                                    </p>
                                                    <?php
                                                    break;
                                                    case 1:
                                                    ?>
                                                    <p>
                                                        <?php echo $row["tel_agencia"] ?>
                                                    </p>
                                                    <p>
                                                        <?php echo strtoupper($row["localidad_agencia"]) ?> -
                                                        <?php echo strtoupper($row["provincia_agencia"]) ?>
                                                    </p>
                                                    <?php
                                                    break;
                                                    case 2:
                                                    ?>
                                                    <p>
                                                        <?php echo $row["tel_agencia"] ?>
                                                    </p>
                                                    <p>
                                                        <?php echo strtoupper($row["direccion_agencia"]) ?> -
                                                        <?php echo strtoupper($row["localidad_agencia"]) ?> -
                                                        <?php echo strtoupper($row["provincia_agencia"]) ?>
                                                    </p>
                                                    <?php
                                                    break;
                                                    case 3:
                                                    ?>
                                                    <p>
                                                        <?php echo $row["tel_agencia"] ?>
                                                    </p>
                                                    <p>
                                                        <?php echo strtoupper($row["direccion_agencia"]) ?> -
                                                        <?php echo strtoupper($row["localidad_agencia"]) ?> -
                                                        <?php echo strtoupper($row["provincia_agencia"]) ?>
                                                    </p>
                                                    <?php
                                                    break;
                                                    ?>
                                                    <?php

                                                } ?>
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            &zwnj;
                                        </div>
                                        <div class="row listado">
                                            <ul class="right">
                                                <a href="micrositio.php?cod=<?php echo $row["cod_agencia"] ?>" class="botonCustom" <?php
                                                if ($row["tipo_agencia"] != 3) {
                                                    echo "style='display:none'";
                                                } else {
                                                    echo "style='font-size:14px;padding:10px;'";
                                                }
                                                ?> >
                                                Ver Agencia
                                            </a>
                                            <a href="mailto: <?php echo $row["email_agencia"] ?>" class="botonCustom" <?php
                                            if ($row["tipo_agencia"] <= 1) {
                                                echo "style='display:none'";
                                            } else {
                                                echo "style='font-size:14px;padding:10px;'";
                                            }
                                            ?>>
                                            Contactar Agencia
                                        </a>
                                    </ul>
                                </div>
                                <div class="clearfix">
                                    &zwnj;
                                </div>
                                <?php

                            }
                        } else {
                            echo "No se ha encontrado ningún registro.";
                        }
                    }

                    function Ver_Anuncio($id)
                    {
                        $idConn = Conectarse();
                        $sql = "SELECT * FROM  `agencias` WHERE  `id_agencia` = '$id'";
                        $resultado = mysqli_query($idConn, $sql);
                        while ($row = mysqli_fetch_array($resultado)) {
                            ?>
                            <hr/>
                            <div class="row listado">
                                <div class="large-3 column">
                                    <?php
                                    if ($row["logo_agencia"] == '') {
                                        ?><img src="img/foto.jpg" width="100%" ><?php

                                    } else {
                                        ?><img src="<?php echo $row["logo_agencia"] ?>" width="100%" ><?php

                                    }
                                    ?>
                                </div>
                                <div class="large-9 column" style="display: block;">
                                    <h3>
                                        <?php echo $row["nombre_agencia"] ?>
                                    </h3>
                                    <p>
                                        <?php echo $row["tel_agencia"] ?>
                                    </p>
                                    <p <?php
                                    if ($row["tipo_agencia"] <= 1) {
                                        echo "style='display:none'";
                                    }
                                    ?>>
                                    <?php echo $row["direccion_agencia"] ?> - <?php echo $row["localidad_agencia"] ?> - <?php echo $row["provincia_agencia"] ?>
                                </p>
                            </div>
                        </div>
                        <div class="row listado" >
                            <ul class="right">
                                <a href="" class="botonCustom" <?php
                                if ($row["tipo_agencia"] != 3) {
                                    echo "style='display:none'";
                                } else {
                                    echo "style='font-size:14px;padding:10px;'";
                                }
                                ?> >
                                Ver Agencia
                            </a>
                            <a href="mailto: <?php echo $row["email_agencia"] ?>" class="botonCustom" <?php
                            if ($row["tipo_agencia"] <= 2) {
                                echo "style='display:none'";
                            } else {
                                echo "style='font-size:14px;padding:10px;'";
                            }
                            ?>>
                            Contactar Agencia
                        </a>
                    </ul>
                </div>
                <div class="clearfix">
                    &zwnj;
                </div>
                <hr/>

                <?php

            }
        }

        function Agencias_Read_Sesion($email)
        {
            $idConn = Conectarse();

            $sql = "SELECT * FROM  `agencias` WHERE  `email_agencia` = '$email' ORDER BY `id_agencia` DESC";
            $sql2 = "SELECT COUNT('id') FROM  `agencias`";

            $resultado = mysqli_query($idConn, $sql);
            $resultado2 = mysqli_query($idConn, $sql2);

            $row2 = mysqli_fetch_row($resultado2);

            $count = $row2[0];

            if ($count != 0) {
                while ($row = mysqli_fetch_array($resultado)) {
                    ?>
                    <tr>
                        <td>
                            <?php echo strtoupper($row["nombre_agencia"]) ?>
                        </td>
                        <td>
                            <?php echo $row["localidad_agencia"] ?>
                        </td>
                        <td style="text-align: center">
                            <?php
                            switch ($row["estado_agencia"]) {
                                case 1:
                                ?><img src="img/estado1.png" title="Acreditado y anuncio activado" width="20" /><?php
                                break;
                                case 2: ?><img src="img/estado2.png" title="Pendiente y Revisión" width="20" /><?php
                                break;
                                case 0:
                                ?><img src="img/estado0.png" title="Rechazado" width="20" />
                                <?php
                                break;
                            }
                            ?>
                        </td>
                        <td style="text-align: right">
                            <a href="sesion.php?op=verAnuncio&id=<?php echo $row["id_agencia"] ?>">
                                <img src="img/anuncio.png" width="20" style="margin-right:7px;" title="Ver Anuncio"/>
                            </a>
                            <a href="sesion.php?op=modificar&id=<?php echo $row["id_agencia"] ?>">
                                <img src="img/ajustes.png" width="20" style="margin-right:7px;" title="Ajustes Anuncio"/>
                            </a>
                            <a href="sesion.php?op=pagar&id=<?php echo $row["id_agencia"] ?>" <?php
                            if ($row["estado_agencia"] != 0) {
                                echo "style='display:none'";
                            }
                            ?>>
                            <img src="img/pagar.png" width="20" style="margin-right:7px;" title="Pagar Anuncio"/>
                        </a>
                        <a href="sesion.php?op=micrositio&id=<?php echo $row["cod_agencia"] ?>" <?php
                        if ($row["tipo_agencia"] != 3) {
                            echo "style='display:none'";
                        }
                        ?>>
                        <img src="img/micrositio.png" width="20" style="margin-right:7px;" title="Micrositio Agencia"/>
                    </a>
                    <a href="sesion.php?op=anuncios&msj=borrar&cod=<?php echo $row["cod_agencia"] ?>">
                        <img src="img/borrar2.png" width="15" style="margin-right:7px;" title="Borrar Anuncio"/>
                    </a>
                </td>
            </tr>
            <?php

        }
    } else {
        echo "No se ha encontrado ningún registro.";
    }
}

function Contar_Agencias($estado)
{
    $idConn = Conectarse();

    $sql2 = "SELECT COUNT('id_agencia') FROM  `agencias` WHERE estado_agencia = $estado";
    $resultado2 = mysqli_query($idConn, $sql2);

    $row2 = mysqli_fetch_row($resultado2);
    echo "(" . $row2[0] . ")";
}

function Contar_Publicidad($estado)
{
    $idConn = Conectarse();

    $sql2 = "SELECT COUNT('id_publicidad') FROM  `publicidad` WHERE estado_publicidad = $estado";
    $resultado2 = mysqli_query($idConn, $sql2);

    $row2 = mysqli_fetch_row($resultado2);
    echo "(" . $row2[0] . ")";
}


function Contar_Notas_Categoria($categoria)
{
    $idConn = Conectarse();

    $sql2 = "SELECT COUNT('IdNotas') FROM  `notabase` WHERE CategoriaNotas = $categoria AND VipNotas = 0";
    $resultado2 = mysqli_query($idConn, $sql2);

    $row2 = mysqli_fetch_row($resultado2);
    echo $row2[0];
}

function Contar_Videos_Categoria($categoria)
{
    $idConn = Conectarse();

    $sql2 = "SELECT COUNT('IdVideos') FROM  `videos` WHERE CategoriaVideos = $categoria";
    $resultado2 = mysqli_query($idConn, $sql2);

    $row2 = mysqli_fetch_row($resultado2);
    echo $row2[0];
}


function Contar_Reconstruidos_Categoria($categoria)
{
    $idConn = Conectarse();

    $sql2 = "SELECT COUNT('id_portfolio') FROM  `maquinas` WHERE categoria_portfolio = $categoria AND tipo_portfolio = 1";
    $resultado2 = mysqli_query($idConn, $sql2);

    $row2 = mysqli_fetch_row($resultado2);

    return $row2;

}

function Contar_Usados_Categoria($categoria)
{
    $idConn = Conectarse();

    $sql2 = "SELECT COUNT('id_portfolio') FROM  `maquinas` WHERE categoria_portfolio = $categoria AND tipo_portfolio = 2";
    $resultado2 = mysqli_query($idConn, $sql2);

    $row2 = mysqli_fetch_row($resultado2);

    return $row2;

}

function Pedidos_Read_Admin($estado)
{
    $idConn = Conectarse();

    $sql = "SELECT * FROM  `pedidos`,`usuarios`  WHERE estado_pedido = $estado AND usuario_pedido = id ORDER BY `id_pedido` DESC";
    $sql2 = "SELECT COUNT('id_pedido') FROM  `pedidos` WHERE estado_pedido = $estado ORDER BY `id_pedido` DESC";

    $resultado = mysqli_query($idConn, $sql);
    $resultado2 = mysqli_query($idConn, $sql2);

    $row2 = mysqli_fetch_row($resultado2);

    $count = $row2[0];
    $i = 1;
    if ($count != 0) {
        while ($row = mysqli_fetch_array($resultado)) {
            ?>
            <dd class="">
                <a href="#panel<?php echo $i ?>b">
                    Pedido de: <?php echo $row["nombre"] ?>
                </a>
                <div id="panel<?php echo $i ?>b" class="content">
                    <?php echo $row["contenido_pedido"] ?>
                    <?php
                    if ($row["costo_pedido"] != '') {
                        echo "Presupuestado: $" . $row["costo_pedido"];
                    }
                    ?>
                    <form method="post">
                        <input type="hidden" value="<?php echo $row["cod_pedido"] ?>" name="cod">
                        <input type="number" name="presupuesto" placeholder="Costo" style="width:50%;float:left;">
                        <input type="submit" name="enviar" class="button" value="Modificar">
                    </form>
                </div>
            </dd>
            <?php
            $i++;
        }
    } else {
        echo "No se ha encontrado ningún registro.";
    }
}

function Usuarios_Read_Admin()
{
    $idConn = Conectarse();

    $sql = "SELECT * FROM  `usuarios` ORDER BY `id` DESC";
    $sql2 = "SELECT count(id) FROM  `usuarios` ORDER BY `id` DESC";

    $resultado = mysqli_query($idConn, $sql);
    $resultado2 = mysqli_query($idConn, $sql2);

    $row2 = mysqli_fetch_row($resultado2);

    $count = $row2[0];

    if ($count != 0) {
        while ($row = mysqli_fetch_array($resultado)) {
            ?>
            <tr>
                <td>
                    <?php echo strtoupper($row["nombre"]) ?>
                </td>
                <td>
                    <?php echo $row["email"] ?>
                </td>
                <td>
                    <?php echo $row["telefono"] ?>
                </td>
                <td>
                    <?php echo $row["localidad"] ?>,<?php echo $row["provincia"] ?> (<?php echo $row["postal"] ?>)
                </td>
                <td>
                    <?php
                    if ($row["invitado"] == 0) {
                        echo "SI";
                    } else {
                        echo "NO";
                    } ?>
                </td>
                <td style="text-align: right">
                    <a href="index.php?op=modUsuarios&id=<?php echo $row["id"] ?>" style="width:20px" data-toggle="tooltip" alt="Modificar" title="Modificar">
                        <i class="glyphicon glyphicon-cog" >
                        </i>
                    </a>
                    <a href="index.php?op=verUsuarios&borrar=<?php echo $row["id"] ?>" style="width:20px"  alt="Eliminar" title="Eliminar" onClick="return confirm('¿Seguro querés eliminar el usuario?')" >
                        <i class="glyphicon glyphicon-trash">
                        </i>
                    </a>
                </td>
            </tr>
            <?php

        }
    } else {
        echo "No se ha encontrado ningún registro.";
    }
}


function Publicidad_Read_Sesion($id)
{
    $idConn = Conectarse();

    $sql = "SELECT * FROM  `publicidad` WHERE  `usuario_publicidad` = '$id' ORDER BY `id_publicidad` DESC";
    $sql2 = "SELECT COUNT('id') FROM  `agencias`";

    $resultado = mysqli_query($idConn, $sql);
    $resultado2 = mysqli_query($idConn, $sql2);

    $row2 = mysqli_fetch_row($resultado2);

    $count = $row2[0];

    if ($count != 0) {
        while ($row = mysqli_fetch_array($resultado)) {
            $fecha = explode("-", $row["cierre_publicidad"]);
            ?>
            <tr>
                <td>
                    <a href="http://<?php echo $row["url_publicidad"] ?>" target="_blank">
                        <?php echo $row["url_publicidad"] ?>
                    </a>
                </td>
                <td>
                    <a href="<?php echo $row["img_publicidad"] ?>" target="_blank" rel="lightbox">
                        IMAGEN
                    </a>
                </td>
                <td>
                    <?php echo $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0] ?>
                </td>
                <td style="text-align: center">
                    <?php
                    switch ($row["estado_publicidad"]) {
                        case 1:
                        ?><img src="img/estado1.png" title="Acreditado y anuncio activado" width="20" /><?php
                        break;
                        case 2:
                        ?><img src="img/estado2.png" title="Pendiente y Revisión" width="20" /><?php
                        break;
                        case 0:
                        ?><img src="img/estado0.png" title="Rechazado" width="20" />
                        <?php
                        break;
                    }
                    ?>
                </td>
                <td style="text-align: right">
                    <a href="<?php echo $row["img_publicidad"] ?>" rel="lightbox">
                        <img src="img/anuncio.png" width="20" style="margin-right:7px;" title="Ver Anuncio"/>
                    </a>
                    <a href="sesion.php?op=publicidad&mod=<?php echo $row["id_publicidad"] ?>">
                        <img src="img/ajustes.png" width="20" style="margin-right:7px;" title="Ajustes Anuncio"/>
                    </a>
                    <a href="sesion.php?op=publicidad&pagar=<?php echo $row["id_publicidad"] ?>" <?php
                    if ($row["estado_publicidad"] != 0) {
                        echo "style='display:none'";
                    }
                    ?>>
                    <img src="img/pagar.png" width="20" style="margin-right:7px;" title="Pagar Anuncio"/>
                </a>
                <a href="sesion.php?op=publicidad&msj=borrar&cod=<?php echo $row["id_publicidad"] ?>">
                    <img src="img/borrar2.png" width="15" style="margin-right:7px;" title="Borrar Anuncio"/>
                </a>
            </td>
        </tr>
        <?php

    }
}
}

function Publicidad_Read_Admin($estado)
{
    $idConn = Conectarse();

    $sql = "SELECT * FROM  `publicidad` WHERE  `estado_publicidad` = '$estado' ORDER BY `id_publicidad` DESC";
    $sql2 = "SELECT COUNT('id_publicidad') FROM  `publicidad`";

    $resultado = mysqli_query($idConn, $sql);
    $resultado2 = mysqli_query($idConn, $sql2);

    $row2 = mysqli_fetch_row($resultado2);

    $count = $row2[0];

    if ($count != 0) {
        while ($row = mysqli_fetch_array($resultado)) {
            $fecha = explode("-", $row["cierre_publicidad"]);
            ?>
            <tr>
                <td>
                    <a href="http://<?php echo $row["url_publicidad"] ?>" target="_blank">
                        <?php echo $row["url_publicidad"] ?>
                    </a>
                </td>
                <td>
                    <?php echo $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0] ?>
                </td>
                <td style="text-align: center">
                    <?php
                    switch ($row["estado_publicidad"]) {
                        case 1:
                        ?><img src="img/estado1.png" title="Acreditado y anuncio activado" width="20" /><?php
                        break;
                        case 2:
                        ?>
                        <a href="index.php?op=verPublicidad&act=<?php echo $row["cod_publicidad"] ?>">
                            <img src="img/estado2.png" title="Pendiente y Revisión" width="20" />
                            </a><?php
                            break;
                            case 0:
                            ?><img src="img/estado0.png" title="Rechazado" width="20" />
                            <?php
                            break;
                        }
                        ?>
                    </td>
                    <td style="text-align: right">
                        <a href="../<?php echo $row["img_publicidad"] ?>" rel="lightbox">
                            <img src="img/anuncio.png" width="20" style="margin-right:7px;" title="Ver Anuncio"/>
                        </a>
                        <a href="index.php?op=publicidad&mod=<?php echo $row["id_publicidad"] ?>">
                            <img src="img/ajustes.png" width="20" style="margin-right:7px;" title="Ajustes Anuncio"/>
                        </a>
                        <a href="index.php?op=verPublicidad&borrar=<?php echo $row["id_publicidad"] ?>">
                            <img src="img/borrar2.png" width="15" style="margin-right:7px;" title="Borrar Anuncio"/>
                        </a>
                    </td>
                </tr>
                <?php

            }
        }
    }

    function Publicidad_Read_Front($tipo)
    {
        $idConn = Conectarse();

        switch ($tipo) {
            case 1:
            $sql = "SELECT * FROM publicidad WHERE tipo_publicidad = $tipo AND cierre_publicidad >= NOW()  ORDER BY RAND() LIMIT 7";
            $sql2 = "SELECT COUNT(*) FROM publicidad WHERE tipo_publicidad = $tipo AND cierre_publicidad >= NOW() ";
            break;
            case 2:
            $sql = "SELECT * FROM publicidad WHERE tipo_publicidad = $tipo AND cierre_publicidad >= NOW() ORDER BY RAND() LIMIT 2";
            $sql2 = "SELECT COUNT(*) FROM publicidad WHERE tipo_publicidad = $tipo AND cierre_publicidad >= NOW() ";
            break;
            case 3:
            $sql = "SELECT * FROM publicidad WHERE tipo_publicidad = $tipo AND cierre_publicidad >= NOW() ORDER BY RAND() LIMIT 3";
            $sql2 = "SELECT COUNT(*) FROM publicidad WHERE tipo_publicidad = $tipo AND cierre_publicidad >= NOW() ";
            break;
        }

        $resultado = mysqli_query($idConn, $sql);
        $resultado2 = mysqli_query($idConn, $sql2);

        $row2 = mysqli_fetch_row($resultado2);

        $count = $row2[0];

        if ($count != 0) {
            switch ($tipo) {
                case 1:
                while ($row = mysqli_fetch_array($resultado)) {
                    ?>
                    <div class="hide-for-medium-down" style="width:200px;overflow:hidden;">
                        <hr width="200px" class="right"/>
                        <a href="http://<?php echo $row['url_publicidad'] ?>" target="_blank">
                            <img src="<?php echo $row['img_publicidad'] ?>" style="width:200px;" class="right"/>
                        </a>
                    </div>
                    <?php

                }
                break;
                case 2:
                while ($row = mysqli_fetch_array($resultado)) {
                    ?>
                    <div class="large-6 column" style="height:100px; overflow:hidden;">
                        <a href="http://<?php echo $row['url_publicidad'] ?>" target="_blank">
                            <img src="<?php echo $row['img_publicidad'] ?>" heigth="100%"/>
                        </a>
                    </div>
                    <div class="clearfix show-for-medium-down">
                        &zwnj;
                    </div>
                    <?php

                }
                break;
                case 3:
                while ($row = mysqli_fetch_array($resultado)) {
                    ?>
                    <center class="large-4 column" style="max-width:300px;height:120px; overflow:hidden;">
                        <a href="http://<?php echo $row['url_publicidad'] ?>" target="_blank">
                            <img src="<?php echo $row['img_publicidad'] ?>" heigth="100%" style="margin: auto"/>
                        </a>
                    </center>
                    <center class="clearfix hide-for-large">
                        &zwnj;
                    </center>
                    <?php

                }
                break;
            }
        }
    }

    function Productos_Read_Front($filtro)
    {
        $idConn = Conectarse();
        if ($filtro == '0') {
            $sql = "
            SELECT *
            FROM productobase, categoriaproducto
            WHERE CategoriaProducto = IdCategoriaProducto AND FiltroProducto != 0
            ORDER BY IdProducto DESC
            ";
        } else {
            $sql = "
            SELECT *
            FROM productobase, categoriaproducto
            WHERE CategoriaProducto = IdCategoriaProducto AND CategoriaProducto = $filtro AND FiltroProducto != 0
            ORDER BY IdProducto DESC
            ";
        }
        $resultado = mysqli_query($idConn, $sql);
    //Carga del array de datos

        while ($row = mysqli_fetch_array($resultado)) {
            $fecha = explode("-", $row['LocalidadProducto']);

            ?>
            <div class="col_6 viaje">
                <h1>
                    <?php echo strtoupper($row['NombreProducto']) ?>
                </h1>
                <h3>
                    Salida el <?php echo $fecha[2] . "/" . $fecha[1] . "/" . $fecha[0] ?>
                </h3>
                <div class="overImg">
                    <img src="<?php echo $row["ImgProducto1"] ?>" width="100%" />
                </div>
                <h2>
                    <?php echo $row["DireccionProducto"] ?>
                </h2>
                <hr class="alt1" />
                <p>
                    <?php echo substr(strip_tags($row["Descripcionroducto"]), 0, 200) . "..." ?>
                </p>
                <div class="clear">
                </div>
                <a href="index.php?op=viaje&id=<?php echo $row["IdProducto"] ?>" class="boton_ver" alt="Más Info" title="Más Info">
                    Más Info
                </a>
                <a href="index.php?op=pasajeros&id=<?php echo $row["IdProducto"] ?>" class="boton_reser" alt="Reservá Ahora" title="Reservá Ahora">
                    Reservá Ahora
                </a>
                <img src="img/sombra.png" class="sombra hide-phone  hide-tablet ">
            </div>
            <?php

        }
    }

    function Recomendacion_Read($categoria)
    {
        $idConn = Conectarse();

        $sql = "
        SELECT *
        FROM productobase, categoriaproducto
        WHERE `CategoriaProducto` = $categoria
        GROUP BY IdProducto
        ORDER BY IdProducto DESC
        LIMIT 0,3
        ";

        $resultado = mysqli_query($idConn, $sql);
    //Carga del array de datos

        while ($row = mysqli_fetch_array($resultado)) {
            $fecha = explode("-", $row['LocalidadProducto']);
            ?>
            <div class="col_4">
                <center class="recomendaciones" style='background-repeat:no-repeat;background-size:110%;background-position:bottom;background-image:url("<?php echo $row["ImgProducto1"] ?>" );'>
                    <div class="encaRecom">
                        <h3>
                            <?php echo strtoupper($row['NombreProducto']) ?>
                        </h3>
                        <p>
                            Salida el <?php echo $fecha[2] . "/" . $fecha[1] . "/" . $fecha[0] ?>
                        </p>
                    </div>
                    <a href="index.php?op=pasajeros&id=<?php echo $row["IdProducto"] ?>" class="boton_ver botonRe">
                        Reservar ahora
                    </a>
                </center>
            </div>
            <?php

        }
    }

    function Productos_Read_Front_Busqueda($filtro)
    {
        $idConn = Conectarse();

        $sql = "
        SELECT *
        FROM productobase, categoriaproducto
        WHERE  `DescripcionProducto` LIKE '%$filtro%' OR `NombreProducto` LIKE '%$filtro%'
        GROUP BY IdProducto
        ORDER BY IdProducto DESC
        ";

        $resultado = mysqli_query($idConn, $sql);
    //Carga del array de datos

        while ($row = mysqli_fetch_array($resultado)) {
            $fecha = explode("-", $row['LocalidadProducto']);
            if ($row["FiltroProducto"] != 0) {
                ?>
                <div class="col_6 viaje">
                    <h1>
                        <?php echo strtoupper($row['NombreProducto']) ?>
                    </h1>
                    <h3>
                        Salida el <?php echo $fecha[2] . "/" . $fecha[1] . "/" . $fecha[0] ?>
                    </h3>
                    <div class="overImg">
                        <img src="<?php echo $row["ImgProducto1"] ?>" width="100%"  />
                    </div>
                    <h2>
                        <?php echo $row["DireccionProducto"] ?>
                    </h2>
                    <hr class="alt1" />
                    <p>
                        <?php echo substr(strip_tags($row["DescripcionProducto"]), 0, 200) . "..." ?>
                    </p>
                    <div class="clear">
                    </div>
                    <a href="index.php?op=viaje&id=<?php echo $row["IdProducto"] ?>" class="boton_ver" alt="Más Info" title="Más Info">
                        Más Info
                    </a>
                    <a href="index.php?op=pasajeros&id=<?php echo $row["IdProducto"] ?>" class="boton_reser" alt="Reservá Ahora" title="Reservá Ahora">
                        Reservá Ahora
                    </a>
                    <img src="img/sombra.png" class="sombra hide-phone  hide-tablet ">
                </div>
                <?php

            }
        }
    }

    function Operacion_Read()
    {
        $idConn = Conectarse();
        $sql = "SELECT CategoriaProducto, NombreCategoriaProducto FROM  `productobase`, `categoriaproducto` WHERE `IdCategoriaProducto` = `CategoriaProducto` GROUP BY CategoriaProducto";
        $resultado = mysqli_query($idConn, $sql);
    //Carga del array de datos

        while ($row = mysqli_fetch_row($resultado)) {
            ?>

            <option value="<?php echo $row[0] ?>">
                <?php echo strtoupper($row[1]) ?>
            </option>


            <?php

        }
    }

    function Filtrado_Busqueda($tipo, $pcia, $localidad)
    {
        $idConn = Conectarse();

        if ($tipo != '' && $pcia != '' && $localidad == '') {
            $sql = "
            SELECT * FROM  `productobase`, `categoriaproducto`
            WHERE `IdCategoriaProducto` = `CategoriaProducto` AND `CategoriaProducto` = '$tipo' AND `ProvinciaProducto` = '$pcia'";
        } elseif ($tipo != '' && $localidad != '' && $pcia == '') {
            $sql = "
            SELECT * FROM  `productobase`, `categoriaproducto`
            WHERE `IdCategoriaProducto` = `CategoriaProducto` AND `CategoriaProducto` = '$tipo' AND `LocalidadProducto` = '$localidad'";
        } elseif ($tipo != '' && $localidad != '' && $pcia != '') {
            $sql = "
            SELECT * FROM  `productobase`, `categoriaproducto`
            WHERE `IdCategoriaProducto` = `CategoriaProducto` AND `CategoriaProducto` = '$tipo' AND `LocalidadProducto` = '$localidad' AND `ProvinciaProducto` = '$pcia'";
        } elseif ($tipo != '' && $pcia == '' && $localidad == '') {
            $sql = "
            SELECT * FROM  `productobase`, `categoriaproducto`
            WHERE `IdCategoriaProducto` = `CategoriaProducto` AND `CategoriaProducto` = '$tipo'";
        } elseif ($localidad != '' && $pcia != '' && $tipo == '') {
            $sql = "
            SELECT * FROM  `productobase`, `categoriaproducto`
            WHERE `IdCategoriaProducto` = `CategoriaProducto` AND `ProvinciaProducto` = '$pcia' AND `LocalidadProducto` = '$localidad'";
        } elseif ($localidad != '' && $pcia == '' && $tipo == '') {
            $sql = "
            SELECT * FROM  `productobase`, `categoriaproducto`
            WHERE `IdCategoriaProducto` = `CategoriaProducto` AND `LocalidadProducto` = '$localidad'";
        } elseif ($pcia != '' && $localidad == '' && $tipo == '') {
            $sql = "
            SELECT * FROM  `productobase`, `categoriaproducto`
            WHERE `IdCategoriaProducto` = `CategoriaProducto` AND `ProvinciaProducto` = '$pcia' ";
        }

        $resultado = mysqli_query($idConn, $sql);
    //Carga del array de datos

        while ($row = mysqli_fetch_array($resultado)) {

            $descripcion = ucfirst(strtolower(trim(strip_tags($row["DescripcionProducto"]))));
            ?>
            <div class="anuncio">
                <center class="contImg">
                    <img src="../admin/<?php echo $row["ImgProducto1"] ?>" width="200">
                </center>
                <center>
                    <h4 class="robo azul">
                        <?php echo $row["NombreProducto"] ?>
                    </h4>
                    <img src="img/separador.png" width="90%" />
                    <span class="abajo robo">
                        <?php echo strtoupper($row["LocalidadProducto"]) ?>
                    </span>
                    <p class="noto">

                        <?php echo substr($descripcion, 0, 200) ?>
                    </p>
                    <div class="boton noto">
                        <a href="index.php?pag=propiedad&id=<?php echo $row["IdProducto"] ?>&op=1">
                            QUIERO VIVIR ACÁ
                        </a>
                        <a href="index.php?pag=propiedad&id=<?php echo $row["IdProducto"] ?>">
                            VER +
                        </a>
                    </div>
                </center>
            </div>

            <?php

        }
    }


    function Recuperar_Pass($user)
    {
        $sql = "
        SELECT  *
        FROM  `usuarios`
        WHERE  `email` =  '$user'
        ";

        $link = Conectarse();
        $result = mysqli_query($link, $sql);
        $contar = mysqli_num_rows($result);
        if ($contar == 0) {
            echo "<div class='alert alert-danger' style='display:block' >No existe ese usuario en nuestras bases de usuario.</div>";
        } else {
            while ($row = mysqli_fetch_assoc($result)) {
                $mensaje = "<br/><b>Nombre:</b> " . utf8_encode($row['nombre']) . "<br/> <b>Empresa:</b> " . utf8_encode($row['empresa']) . "<br/> <b>Email:</b> " . utf8_encode($row['email']) . "<br/> <b>Contraseña:</b> " . utf8_encode($row['pass']) . "<br/> <b>Teléfono:</b> " . utf8_encode($row['telefono']) . "<br/> <b>Domicilio:</b> " . utf8_encode($row['direccion']) . "<br/> <b>Localidad:</b> " . utf8_encode($row['localidad']) . "<br/> <b>Provincia:</b> " . utf8_encode($row['provincia']) . "<br/><br/><b>Fecha de inscripción:</b> " . utf8_encode($row['inscripto']) . "<br/>";
                $asunto = "Recuperar contraseña de Aimar Repuestos";
                $receptor = $row['email'];
                echo "<div class='alert alert-success' style='display:block' >Recibiste en tu correo (" . $row["email"] . ") todos los datos de tu cuenta.</div>";
                Enviar_User_Olvidaste($asunto, $mensaje, $receptor);
            }
        }
    }


    /**** EMAIL ****/

    function Enviar($sPara, $sAsunto, $sTexto, $sDe)
    {
        $bHayFicheros = 0;
        $sCabeceraTexto = "";
        $sAdjuntos = '';
        if ($sDe) $sCabeceras = "From:" . $sDe . "n";
        else $sCabeceras = "";
        $sCabeceras .= "MIME-version: 1.0n";
        foreach ($_POST as $sNombre => $sValor)
            $sTexto = $sTexto . "n" . $sNombre . " = " . $sValor;
        foreach ($_FILES as $vAdjunto) {
            if ($bHayFicheros == 0) {
                $bHayFicheros = 1;
                $sCabeceras .= "Content-type: multipart/mixed;";
                $sCabeceras .= "boundary=" - "n";
                $sCabeceraTexto = "----_Separador-de-mensajes_--n";
                $sCabeceraTexto .= "Content-type: text/plain;charset=iso-8859-1n";
                $sCabeceraTexto .= "Content-transfer-encoding: 7BITn";
                $sTexto = $sCabeceraTexto . $sTexto;
            }
            if ($vAdjunto["size"] > 0) {
                $sAdjuntos .= "nn----_Separador-de-mensajes_--n";
                $sAdjuntos .= "Content-type: " . $vAdjunto["type"] . ";name=" . $vAdjunto['name'] . "n";;
                $sAdjuntos .= "Content-Transfer-Encoding: BASE64n";
                $sAdjuntos .= "Content-disposition: attachment;filename=" . $vAdjunto['name'] . "nn";
                $oFichero = fopen($vAdjunto["tmp_name"], 'r');
                $sContenido = fread($oFichero, filesize($vAdjunto["tmp_name"]));
                $sAdjuntos .= chunk_split(base64_encode($sContenido));
                fclose($oFichero);
            }
        }
        if ($bHayFicheros)
            $sTexto .= $sAdjuntos . "nn----_Separador-de-mensajes_----n";
        return (mail($sPara, $sAsunto, $sTexto, $sCabeceras));
    }

    function Enviar_User($asunto, $mensaje, $receptor)
    {
        $mail = new PHPMailer();
        $mail->CharSet = 'UTF-8';
        $mail->IsSMTP();
        $mail->SMTPDebug = 1;
        $mail->SMTPAuth = true;
        $mail->Host = SMTP_EMAIL;
        $mail->Port = 587;
        $mail->Username = EMAIL;
        $mail->Password = PASS_EMAIL;
        $mail->SetFrom(EMAIL, TITULO);
        $fecha = date("Y-m-d H:i:s");
        $pie = Contenido_TraerPorId("pie email");
        $cabecera = Contenido_TraerPorId("cabecera email");

        $cuerpo = "
        <body style='background:#fff fixed;  font-family: Tahoma,Verdana,Segoe,sans-serif; '>
        <div style='min-height:900px;height:100% !important;margin:0 !important;padding:0 !important'>
        <div style='width:700px;margin:auto;padding:20px;background:#fff;'>
        <img src='" . LOGO . "' style='width:230px'>
        </div>
        <div style='width:700px;margin:auto;padding:20px;background:#fff;'>
        <h3>" . TITULO . "</h3>
        <p style='font-size:14px'>$mensaje</p><br/>
        <span style='font-size:13px'>
        <b>INFORMACIÓN DE CONTACTO</b>
        <hr/>
        $pie[1]
        <br/>
        </span><br/><br/>
        <hr/>
        <p>Fecha del email:" . $fecha . "</p>
        </div>
        </div>
        </body>
        ";

        $cuerpo = $cuerpo;
        $mail->AddReplyTo(EMAIL, TITULO);
        $mail->Subject = $asunto;
        $mail->AltBody = "Para ver el mensaje, por favor use Thunderbird o algún programa que vea HTML!";
        $mail->MsgHTML($cuerpo);
        $mail->AddAddress($receptor, "");

        if (!$mail->Send()) {
            echo "<script>alert('Su mensaje no se ha podido enviar, vuelva a intentarlo')</script>";
        } else {
            echo "<script>alert('Su mensaje se ha podido enviar, muchas gracias')</script>";
        }
    }

    function Enviar_User_Admin($asunto, $mensaje, $receptor)
    {
        $mail = new PHPMailer();
        $mail->CharSet = 'UTF-8';

        $mail->IsSMTP();
        $mail->SMTPDebug = 1;
        $mail->SMTPAuth = true;
        $mail->Host = SMTP_EMAIL;
        $mail->Port = 587;
        $mail->Username = EMAIL;
        $mail->Password = PASS_EMAIL;
        $mail->SetFrom(EMAIL, TITULO);
        $fecha = date("Y-m-d H:i:s");

        $cuerpo = "
        <body style='background:#fff fixed;  font-family: Tahoma,Verdana,Segoe,sans-serif; '>
        <div style='min-height:900px;height:100% !important;margin:0 !important;padding:0 !important'>
        <div style='width:700px;margin:auto;padding:20px;background:#fff;'>
        <img src='" . LOGO . "' style='width:230px'>
        </div>
        <div style='width:700px;margin:auto;padding:20px;background:#fff;'>
        <p style='font-size:14px'>$mensaje</p><br/>
        <br/>
        <hr/>
        <p>Fecha del email:" . $fecha . "</p>
        </div>
        </div>
        </body>
        ";

        $cuerpo = $cuerpo;
        $mail->AddReplyTo(EMAIL, TITULO);
        $mail->Subject = $asunto;
        $mail->AltBody = "Para ver el mensaje, por favor use Thunderbird o algún programa que vea HTML!";
        $mail->MsgHTML($cuerpo);
        $mail->AddAddress($receptor, "");

        if (!$mail->Send()) {
        //echo " < script > alert('Su mensaje no se ha podido enviar, vuelva a intentarlo')</script > ";
        } else {
        //echo " < script > alert('Su mensaje se ha podido enviar, muchas gracias')</script > ";
        }
    }

    function Enviar_User_Admin_Sin_Notificar($asunto, $mensaje, $receptor)
    {
        $mail = new PHPMailer();
        $mail->CharSet = 'UTF-8';

        $mail->CharSet = 'UTF-8';
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = "mail.aimarrepuestos.com.ar";
        $mail->Port = 587;
        $mail->Username = "info@aimarrepuestos.com.ar";
        $mail->Password = "Cp8wC3aTs";
        $mail->SetFrom('info@aimarrepuestos.com.ar', 'Aimar Repuestos');
        $fecha = date("Y-m-d H:i:s");
        $cuerpo = "
        <body style='font-family: Tahoma,Verdana,Segoe,sans-serif; '>
        <img src='img/logo.png' style='width:150px'>
        <hr/>
        <h3>¡Hola! ¿cómo están?</h3>
        <p style='font-size:14px'>Llego un nuevo mensaje de consulta.</p>
        <p style='font-size:14px'>$mensaje</p><br/>
        <span style='font-size:13px'>
        <b>Atte. Aimar Repuestos</b><br/>
        <br/>
        </span><br/><br/>
        <hr/>
        <p>Fecha del email:" . $fecha . "</p>
        </body>
        ";

        $cuerpo = $cuerpo;
        $mail->AddReplyTo(EMAIL, 'Aimar Repuestos');
        $mail->Subject = $asunto;
        $mail->AltBody = "Para ver el mensaje, por favor use Thunderbird o algún programa que vea HTML!";
        $mail->MsgHTML($cuerpo);
        $mail->AddAddress($receptor, "");

        if (!$mail->Send()) {
        // echo " < script > alert('Su mensaje no se ha podido enviar, vuelva a intentarlo')</script > ";
        } else {
        //echo " < script > alert('Su mensaje se ha podido enviar, muchas gracias')</script > ";
        }
    }



    function Enviar_User_Olvidaste($asunto, $mensaje, $receptor)
    {
        $mail = new PHPMailer();
        $mail->CharSet = 'UTF-8';

        $mail->IsSMTP();
        $mail->SMTPDebug = 1;
        $mail->SMTPAuth = true;
        $mail->Host = "mail.aimarrepuestos.com.ar";
        $mail->Port = 587;
        $mail->Username = "info@aimarrepuestos.com.ar";
        $mail->Password = "Cp8wC3aTs";
        $mail->SetFrom(EMAIL, 'Aimar Repuestos');
        $fecha = date("Y-m-d H:i:s");
        $cuerpo = "
        <body style='font-family: Tahoma,Verdana,Segoe,sans-serif; '>
        <img src='img/logo.png' style='width:250px'>
        <hr/>
        <h3>¡Hola! ¿cómo estás?</h3>
        <p style='font-size:14px'>Te dejamos los datos de tu cuenta para que puedas acceder</p>
        <p style='font-size:14px'>$mensaje</p><br/>
        <span style='font-size:13px'>
        <b>Atte. Aimar Repuestos</b><br/>
        <br/>
        </span><br/><br/>
        <hr/>
        <p>Fecha del email:" . $fecha . "</p>
        </body>
        ";

        $cuerpo = $cuerpo;
        $mail->AddReplyTo(EMAIL, 'Aimar Repuestos');
        $mail->Subject = $asunto;
        $mail->AltBody = "Para ver el mensaje, por favor use Thunderbird o algún programa que vea HTML!";
        $mail->MsgHTML($cuerpo);
        $mail->AddAddress($receptor, "");

        if (!$mail->Send()) {
            echo "<script>alert('Su mensaje no se ha podido enviar, vuelva a intentarlo')</script>";
        } else {
            echo "<script>alert('Su mensaje se ha podido enviar, muchas gracias')</script>";
        }
    }


    function EscalarImagen($ancho, $alto, $imagen, $guardar, $calidad)
    {
    // create a new instance of the class
        $image = new Zebra_Image();

    // indicate a source image (a GIF, PNG or JPEG file)
        $image->source_path = $imagen;

    // indicate a target image
    // note that there's no extra property to set in order to specify the target
    // image's type - simply by writing '.jpg' as extension will instruct the script
    // to create a 'jpg' file
        $image->target_path = $guardar;

    // since in this example we're going to have a jpeg file, let's set the output
    // image's quality
        $image->jpeg_quality = $calidad;

    // some additional properties that can be set
    // read about them in the documentation
        $image->preserve_aspect_ratio = true;
        $image->enlarge_smaller_images = true;
        $image->preserve_time = true;

    // resize the image to exactly 100x100 pixels by using the "crop from center" method
    // (read more in the overview section or in the documentation)
    //  and if there is an error, check what the error is about
        if (!$image->resize($ancho, $alto, ZEBRA_IMAGE_NOT_BOXED)) {

        // if there was an error, let's see what the error is about
            switch ($image->error) {

                case 1:
                echo 'Source file could not be found!';
                break;
                case 2:
                echo 'Source file is not readable!';
                break;
                case 3:
                echo 'Could not write target file!';
                break;
                case 4:
                echo 'Unsupported source file format!';
                break;
                case 5:
                echo 'Unsupported target file format!';
                break;
                case 6:
                echo 'GD library version does not support target file format!';
                break;
                case 7:
                echo 'GD library is not installed!';
                break;
            }
        }
    }



function normaliza_acentos($s) {
  $s = trim($s);
  $s = str_replace("á","a",$s);
  $s = str_replace("Á","A",$s);
  $s = str_replace("é","e",$s);
  $s = str_replace("É","E",$s);
  $s = str_replace("í","i",$s);
  $s = str_replace("Í","I",$s);
  $s = str_replace("ó","o",$s);
  $s = str_replace("Ó","O",$s);
  $s = str_replace("ú","u",$s);
  $s = str_replace("Ú","U",$s);
  $s = str_replace(" ","-",$s);
  $s = str_replace("ñ","n",$s);
  $s = str_replace("Ñ","N",$s);
  $s = str_replace("?","",$s);
  $s = str_replace("¿","",$s);
  $s = str_replace("¡","",$s);
  $s = str_replace("!","",$s);
  $s = str_replace(",","",$s);
  $s = str_replace(";","",$s);
  $s = str_replace(":","",$s);
  $s = str_replace("%","",$s);
  $s = str_replace("/","",$s);
  $s = str_replace("(","",$s);
  $s = str_replace(")","",$s);
  $s = str_replace("\"","",$s);
  $s = str_replace("\"","",$s);
  $s = mb_strtolower($s);
  return $s;
}
    function antihack_mysqli($var)
    {
        $cnx = Conectarse();
        $var = stripslashes($var);
        $var = strip_tags($var);
        $var = htmlentities($var);
        $var = mysqli_real_escape_string($cnx, $var);
        return $var;
    }

    function antihack($var)
    {
        $var = stripslashes($var);
        $var = strip_tags($var);
        $var = htmlentities($var);
        return $var;
    }


    function headerMove($l)
    {
        echo "<script> document.location.href='" . $l . "';</script>";
    }

    function limpiar_caracteres_especiales($s)
    {
        $s = str_replace("á", "a", $s);
        $s = str_replace("Á", "A", $s);
        $s = str_replace("é", "e", $s);
        $s = str_replace("É", "E", $s);
        $s = str_replace("í", "i", $s);
        $s = str_replace("Í", "I", $s);
        $s = str_replace("ó", "o", $s);
        $s = str_replace("Ó", "O", $s);
        $s = str_replace("ú", "u", $s);
        $s = str_replace("Ú", "U", $s);
        $s = str_replace("ñ", "n", $s);
        $s = str_replace("Ñ", "N", $s);
    //para ampliar los caracteres a reemplazar agregar lineas de este tipo:
    //$s = str_replace("caracter - que - queremos - cambiar","caracter - por - el - cual - lo - vamos - a - cambiar",$s);
        return $s;
    }


    function Hubspot_Dev($arr, $url)
    {
        $post_json = json_encode($arr);
        $hapikey = HUBSPOT;
        $endpoint = $url . '?hapikey=' . $hapikey;
        $ch = @curl_init();
        @curl_setopt($ch, CURLOPT_POST, true);
        @curl_setopt($ch, CURLOPT_POSTFIELDS, $post_json);
        @curl_setopt($ch, CURLOPT_URL, $endpoint);
        @curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        @curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = @curl_exec($ch);
        $status_code = @curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_errors = curl_error($ch);
        @curl_close($ch);
    //echo " < pre > curl Errors: " . $curl_errors."</pre > ";
    //echo " < pre > \nStatus code: " . $status_code."</pre > ";
    //echo " < pre > \nResponse: " . $response."</pre > ";
    // var_dump($response);
    }

    function Hubspot_Get($url)
    {
        $hapikey = HUBSPOT;
        $endpoint = $url . '?hapikey=' . $hapikey;
        $json = file_get_contents($endpoint);
        $obj = json_decode($json);
        return $obj;
    }

    function Hubspot_Note($id, $body, $type)
    {
        $array = array("engagement" => array("active" => true, "ownerId" => 1, "type" => $type), "associations" => array("contactIds" => $id), "metadata" => array("body" => $body));
        $url = "https://api.hubapi.com/engagements/v1/engagements";
        Hubspot_Dev($array, $url);
    }

    function Hubspot_AddContact($email, $nombre, $apellido, $telefono, $localidad, $provincia)
    {
        $array = array('properties' => array(
            array('property' => 'firstname', 'value' => $nombre),
            array('property' => 'lastname', 'value' => $apellido),
            array('property' => 'email', 'value' => $email),
            array('property' => 'phone', 'value' => $telefono),
            array('property' => 'city', 'value' => $localidad),
            array('property' => 'state', 'value' => $provincia)
        ));
        $url = "https://api.hubapi.com/contacts/v1/contact";
        Hubspot_Dev($array, $url, "NOTES");
    }


    ?>
