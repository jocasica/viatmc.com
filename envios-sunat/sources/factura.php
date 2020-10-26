<?php
define('BASEPATH', dirname(dirname(__DIR__)));
require_once '../config/database.php';
require_once '../modelo/Conexion.php';
require_once BASEPATH.'/application/config/empresa.php';
require_once BASEPATH.'/application/controllers/fe/Procesarcomprobante.php';
require_once BASEPATH.'/application/controllers/fe/Validaciondedatos.php';

$opcion = $_REQUEST['op'];
$configEmpresa= $config;
$modo = $configEmpresa['tipoproceso'];
$pass_firma= $config['firma_password'];
$ruta_firma = BASEPATH . '/archivos_xml_sunat/certificados/' . $modo . '/' . $configEmpresa['ruc'] . '.pfx';
$ruta_ws = array(
    'beta' => 'https://e-beta.sunat.gob.pe:443/ol-ti-itcpfegem-beta/billService',
    'produccion' => 'https://e-factura.sunat.gob.pe/ol-ti-itcpfegem/billService',
    'nubefact' => 'https://demo-ose.nubefact.com/ol-ti-itcpe/billService?wsdl'
);
try {
    if ($modo == 'beta') {
        $ruta_firma = BASEPATH . '/archivos_xml_sunat/certificados/' . $modo . '/demo.pfx';
        $pass_firma = '123456';
    }
    if ($modo == 'nubefact') {
        $pass_firma = '123456';
    }
    $directorio = dirname(dirname(__DIR__));
    $conexion = new Conexion();
    $conexion = $conexion->get_conexion();
    switch ($opcion) {
        case 'anular':
                $serie = trim($_REQUEST['serie']);
                $numero = trim($_REQUEST['numero']);
                $id = trim($_REQUEST['id']);
                $query = 'SELECT f.id f_id, f.serie, f.numero, f.fecha f_fecha, v.total, v.total_gravado, v.cliente_tipo_documento, v.cliente_numero_documento, 
                            v.cliente_nombre, v.total_igv, v.porcentaje_igv, v.tipo_documento, v.codigo_moneda,
                            v.total_letras, v.cliente_direccion, v.cliente_ubigeo'
                        . ' FROM factura f '
                        . ' INNER JOIN venta v ON (v.id=f.venta_id)'
                        . ' INNER JOIN venta_producto vp ON (v.id=vp.venta_id)'
                        . ' WHERE f.id=:id LIMIT 1';
                $stmt = $conexion->prepare($query);
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $_Venta= $stmt->fetch();
                if(is_array($_Venta) && count($_Venta)>0){
                    $fechaVenta= $_Venta['f_fecha'];
                    $fechaBaja= date('Y-m-d');
                    $query= 'SELECT COUNT(id_comunicacion_baja)+1 c FROM comunicacion_baja WHERE fecha= :fecha';
                    $stmt = $conexion->prepare($query);
                    $stmt->bindParam(':fecha', $fechaBaja);
                    $stmt->execute();
                    $_Correlativo= $stmt->fetch();
                    $query= 'INSERT INTO comunicacion_baja(fecha, correlativo)'
                            . ' VALUES (:fecha, :correlativo)';
                    $stmt = $conexion->prepare($query);
                    $stmt->bindParam(':fecha', $fechaBaja);
                    $stmt->bindParam(':correlativo', $_Correlativo['c']);
                    $stmt->execute();
                    $id_resumen = $conexion->lastInsertId();
                    $query= 'INSERT INTO comunicacion_baja_item (id_comunicacion_baja,id_factura)'
                            . ' VALUES (:id_comunicacion_baja,:id_factura)';
                    $stmt = $conexion->prepare($query);
                    $stmt->bindParam(':id_comunicacion_baja', $id_resumen);
                    $stmt->bindParam(':id_factura', $_Venta['f_id']);
                    $stmt->execute();
                    $procesarcomprobante = new Procesarcomprobante();
                    $_data_comprobante= array(
                        'TIPO_OPERACION' => '0101',
                        'TOTAL_GRAVADAS' => $_Venta['total_gravado'],
                        'TOTAL_INAFECTA' => "0",
                        'TOTAL_EXONERADAS' => '0',
                        'TOTAL_GRATUITAS' => "0",
                        'TOTAL_PERCEPCIONES' => "0",
                        'TOTAL_RETENCIONES' => "0",
                        'TOTAL_DETRACCIONES' => "0",
                        'TOTAL_BONIFICACIONES' => "0",
                        'TOTAL_EXPORTACION' => "0",
                        'TOTAL_DESCUENTO' => "0",
                        'SUB_TOTAL' => $_Venta['total_gravado'],
                        'POR_IGV' => $_Venta['porcentaje_igv'],
                        'TOTAL_IGV' => $_Venta['total_igv'],
                        'TOTAL_ISC' => "0",
                        'TOTAL_OTR_IMP' => "0",
                        'TOTAL' => $_Venta['total'],
                        'TOTAL_LETRAS' => $_Venta['total_letras'],
                        'NRO_GUIA_REMISION' => '',
                        'COD_GUIA_REMISION' => '',
                        'NRO_OTR_COMPROBANTE' => '',
                        'COD_OTR_COMPROBANTE' => '',
                        'TIPO_COMPROBANTE_MODIFICA' => '',
                        'NRO_DOCUMENTO_MODIFICA' => '',
                        'COD_TIPO_MOTIVO' => '',
                        'DESCRIPCION_MOTIVO' => '',
                        //===============================================
                        'NRO_COMPROBANTE' => '',
                        'FECHA_DOCUMENTO' => $fechaVenta,
                        'FECHA_VTO' => '',
                        'COD_TIPO_DOCUMENTO' => '',
                        'COD_MONEDA' => $_Venta['codigo_moneda'],
                        //==================================================
                        'NRO_DOCUMENTO_CLIENTE' => $_Venta['cliente_numero_documento'],
                        'RAZON_SOCIAL_CLIENTE' => $_Venta['cliente_nombre'],
                        'TIPO_DOCUMENTO_CLIENTE' => $_Venta['cliente_tipo_documento'],
                        'DIRECCION_CLIENTE' => $_Venta['cliente_direccion'],
                        'COD_UBIGEO_CLIENTE' => $_Venta['cliente_ubigeo'],
                        'DEPARTAMENTO_CLIENTE' => '',
                        'PROVINCIA_CLIENTE' => '',
                        'DISTRITO_CLIENTE' => '',
                        'CIUDAD_CLIENTE' => '',
                        'COD_PAIS_CLIENTE' => '',
                        //===============================================
                        'NRO_DOCUMENTO_EMPRESA' => $configEmpresa['ruc'],
                        'TIPO_DOCUMENTO_EMPRESA' => $configEmpresa['tipo_doc'],
                        'NOMBRE_COMERCIAL_EMPRESA' => $configEmpresa['nom_comercial'],
                        'CODIGO_UBIGEO_EMPRESA' => $configEmpresa['codigo_ubigeo'],
                        'DIRECCION_EMPRESA' => $configEmpresa['direccion'],
                        'DEPARTAMENTO_EMPRESA' => $configEmpresa['direccion_departamento'],
                        'PROVINCIA_EMPRESA' => $configEmpresa['direccion_provincia'],
                        'DISTRITO_EMPRESA' => $configEmpresa['direccion_distrito'],
                        'CODIGO_PAIS_EMPRESA' => $configEmpresa['direccion_codigopais'],
                        'RAZON_SOCIAL_EMPRESA' => $configEmpresa['razon_social'],
                        'CONTACTO_EMPRESA' => "",
                        //====================INFORMACION PARA ANTICIPO=====================//
                        'FLG_ANTICIPO' => "0",
                        //====================REGULAR ANTICIPO=====================//
                        'FLG_REGU_ANTICIPO' => "0",
                        'NRO_COMPROBANTE_REF_ANT' => "",
                        'MONEDA_REGU_ANTICIPO' => "",
                        'MONTO_REGU_ANTICIPO' => "0",
                        'TIPO_DOCUMENTO_EMP_REGU_ANT' => "",
                        'NRO_DOCUMENTO_EMP_REGU_ANT' => "",
                        //===================CLAVES SOL EMISOR====================//
                        'EMISOR_RUC' => $configEmpresa['ruc'],
                        'EMISOR_USUARIO_SOL' => $configEmpresa['usuariosol'],
                        'EMISOR_PASS_SOL' => $configEmpresa['clavesol'],
                        //RESUMEN
                        'SERIE'=> str_replace('-', '', $fechaBaja), //YYYYMMDD
                        'SECUENCIA'=> $_Correlativo['c']
                    );
                    $_comprobantes[]= array(
                        'TIPO_COMPROBANTE'=>'01',
                        'NRO_COMPROBANTE'=> $_Venta['serie'].'-'.$_Venta['numero'],
                        'SERIE'=> $_Venta['serie'],
                        'NUMERO'=> $_Venta['numero'],
                        'MOTIVO'=> 'ERROR DE FACTURACION',
                        'NRO_DOCUMENTO'=> $_Venta['cliente_numero_documento'],
                        'TIPO_DOCUMENTO'=> $_Venta['cliente_tipo_documento'],
                        'STATUS'=> '3', //anulado
                        'COD_MONEDA'=> $_Venta['codigo_moneda'],
                        'TOTAL'=> $_Venta['total'],
                        'GRAVADA'=> $_Venta['total_gravado'],
                        'EXONERADO'=> 0,
                        'INAFECTO'=> 0,
                        'EXPORTACION'=> 0,
                        'GRATUITAS'=> 0,
                        'MONTO_CARGO_X_ASIG'=> 0,
                        'ISC'=> 0,
                        'IGV'=> $_Venta['total_igv'],
                        'OTROS'=> 0,
                        'FECHA'=> $_Venta['f_fecha'],
                    );
                    $_ruta_comprobante= array(
                        'nombre_archivo' => $configEmpresa['ruc'] . '-RA-' . str_replace('-', '', $fechaBaja) . '-' . $_Correlativo['c'],
                        'ruta_xml' => BASEPATH . '/archivos_xml_sunat/cpe_xml/' . $modo . '/' . $configEmpresa['ruc'] . '/' . $configEmpresa['ruc'] . '-RA-' . str_replace('-', '', $fechaBaja) . '-' . $_Correlativo['c'],
                        'ruta_cdr' => BASEPATH . '/archivos_xml_sunat/cpe_xml/' . $modo . '/' . $configEmpresa['ruc'] . '/',
                        'ruta_firma' => $ruta_firma,
                        'pass_firma' => $pass_firma,
                        'ruta_ws' => $ruta_ws[$modo]
                    );
                    $resp_proceso = $procesarcomprobante->procesar_baja_sunat($_data_comprobante, $_comprobantes, $_ruta_comprobante);
                    if ($resp_proceso['error'] == false) {
                        $apisunat = new Apisunat();
                        $resp_envio = $apisunat->enviar_documento_para_baja(
                            $configEmpresa['ruc'], 
                            $configEmpresa['usuariosol'],
                            $configEmpresa['clavesol'], 
                            BASEPATH . '/archivos_xml_sunat/cpe_xml/' . $modo . '/' . $configEmpresa['ruc'] . '/' . $configEmpresa['ruc'] . '-RA-' . str_replace('-', '', $fechaBaja) . '-' . $_Correlativo['c'], 
                            BASEPATH . '/archivos_xml_sunat/cpe_xml/' . $modo . '/' . $configEmpresa['ruc'] . '/', 
                            $configEmpresa['ruc'] . '-RA-' . str_replace('-', '', $fechaBaja) . '-' . $_Correlativo['c'], 
                            $ruta_ws[$modo]
                        );
                        if($resp_envio['error'] == false) {
                            $query = 'UPDATE comunicacion_baja SET ticket= :ticket WHERE id_comunicacion_baja= :id_comunicacion_baja';
                            $statement = $conexion->prepare($query);
                            $statement->bindParam(':ticket', $resp_envio['cod_ticket']);
                            $statement->bindParam(':id_comunicacion_baja', $id_resumen);
                            $statement->execute();
                            $resp_ticket = $apisunat->consultar_envio_ticket(
                                $configEmpresa['ruc'], 
                                $configEmpresa['usuariosol'], 
                                $configEmpresa['clavesol'], 
                                $resp_envio['cod_ticket'], 
                                $configEmpresa['ruc'] . '-RA-' . str_replace('-', '', $fechaBaja) . '-' . $_Correlativo['c'], 
                                BASEPATH . '/archivos_xml_sunat/cpe_xml/' . $modo . '/' . $configEmpresa['ruc'] . '/', 
                                $ruta_ws[$modo]
                            );
                            $envio= 'anulado';
                            if($resp_ticket['error'] == false){
                                $envio= 'anulado';
                            }
                            $query = "UPDATE factura SET envio='".$envio."' WHERE id=:id";
                            $statement = $conexion->prepare($query);
                            $statement->bindParam(':id', $id);
                            $statement->execute();
                            echo json_encode($resp_ticket);
                        }else{
                            echo json_encode($resp_envio);
                        }
                    }else{
                        echo json_encode($resp_proceso);
                    }
                }else{
                    throw new Exception('Venta no disponible');
                }
                break;
        case 2:
                $serie = trim($_REQUEST['serie']);
                $numero = trim($_REQUEST['numero']);
                $id = trim($_REQUEST['id']);
                $folio = "01";
                $data_comprobante = array(
                    'EMISOR_RUC' => $configEmpresa['ruc'],
                    'EMISOR_USUARIO_SOL' => $configEmpresa['usuariosol'],
                    'EMISOR_PASS_SOL' => $configEmpresa['clavesol']
                );
                $rutas = array(
                    'ruta_xml' => $directorio . '/archivos_xml_sunat/cpe_xml/' . $modo . '/' . $configEmpresa['ruc'] . '/' . $configEmpresa['ruc'] . '-' . $folio . '-' . $serie . '-' . $numero . '',
                    'ruta_cdr' => $directorio . '/archivos_xml_sunat/cpe_xml/' . $modo . '/' . $configEmpresa['ruc'] . '/',
                    'nombre_archivo' => $configEmpresa['ruc'] . '-' . $folio . '-' . $serie . '-' . $numero . '',
                    'ruta_ws' => $ruta_ws[$modo]
                );
                $apisunat = new Apisunat();
                $resp_envio = $apisunat->enviar_documento(
                    $data_comprobante['EMISOR_RUC'], 
                    $data_comprobante['EMISOR_USUARIO_SOL'], 
                    $data_comprobante['EMISOR_PASS_SOL'], 
                    $rutas['ruta_xml'], 
                    $rutas['ruta_cdr'], 
                    $rutas['nombre_archivo'], 
                    $rutas['ruta_ws']
                );
                if ($resp_envio['error'] == false) {
                    $query = "UPDATE factura SET envio='enviado', msj_sunat=:msj_sunat WHERE id=:id";
                    $statement = $conexion->prepare($query);
                    $statement->bindParam(':id', $id);
                    $statement->bindParam(':msj_sunat',$resp_envio['mensaje']);
                    $statement->execute();
                    echo json_encode($resp_envio);
                } else {
                    echo json_encode($resp_envio);
                }
            break;
        case 'generarxml':
            $serie = trim($_REQUEST['serie']);
            $numero = trim($_REQUEST['numero']);
            $folio = "01";
            $id = trim($_REQUEST['id']);
            $query = 'SELECT f.id f_id, f.serie, f.numero, f.placa f_placa, v.total, v.total_gravado, v.cliente_tipo_documento, v.cliente_numero_documento, 
                        v.cliente_nombre, v.total_igv, v.porcentaje_igv, v.tipo_documento, v.codigo_moneda,
                        v.total_letras, v.cliente_direccion, v.cliente_ubigeo, f.fecha f_fecha,
                        vp.precio_unidad  vp_precio_unidad,
                        vp.cantidad vp_cantidad,
                        vp.venta_id vp_venta_id,
                        vp.producto_id vp_producto_id,
                        vp.subtotal vp_subtotal,
                        vp.total vp_total,
                        vp.maquina_id vp_maquina_id,
                        p.nombre p_nombre,
                        um.descripcion um_descripcion'
                    . ' FROM factura f '
                    . ' INNER JOIN venta v ON (v.id=f.venta_id)'
                    . ' INNER JOIN venta_producto vp ON (v.id=vp.venta_id)'
                    . ' INNER JOIN producto p ON (vp.producto_id=p.id)'
                    . ' INNER JOIN unidad_medida um ON (um.id=p.unidad_medida_id)'
                    . ' WHERE f.id=:id';
            $stmt = $conexion->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $_Venta= $stmt->fetchAll();
            if(is_array($_Venta) && count($_Venta)>0){
                $fecha= $_Venta[0]['f_fecha'];
                $procesarcomprobante = new Procesarcomprobante();
                $_data_comprobante= array(
                    'TIPO_OPERACION' => '0101',
                    'TOTAL_GRAVADAS' => $_Venta[0]['total_gravado'],
                    'TOTAL_INAFECTA' => "0",
                    'TOTAL_EXONERADAS' => '0',
                    'TOTAL_GRATUITAS' => "0",
                    'TOTAL_PERCEPCIONES' => "0",
                    'TOTAL_RETENCIONES' => "0",
                    'TOTAL_DETRACCIONES' => "0",
                    'TOTAL_BONIFICACIONES' => "0",
                    'TOTAL_EXPORTACION' => "0",
                    'TOTAL_DESCUENTO' => "0",
                    'SUB_TOTAL' => $_Venta[0]['total_gravado'],
                    'POR_IGV' => $_Venta[0]['porcentaje_igv'],
                    'TOTAL_IGV' => $_Venta[0]['total_igv'],
                    'TOTAL_ISC' => "0",
                    'TOTAL_OTR_IMP' => "0",
                    'TOTAL' => $_Venta[0]['total'],
                    'TOTAL_LETRAS' => $_Venta[0]['total_letras'],
                    'NRO_GUIA_REMISION' => '',
                    'COD_GUIA_REMISION' => '',
                    'NRO_OTR_COMPROBANTE' => '',
                    'COD_OTR_COMPROBANTE' => '',
                    'TIPO_COMPROBANTE_MODIFICA' => '',
                    'NRO_DOCUMENTO_MODIFICA' => '',
                    'COD_TIPO_MOTIVO' => '',
                    'DESCRIPCION_MOTIVO' => '',
                    //===============================================
                    'NRO_COMPROBANTE' => $_Venta[0]['serie'].'-'.str_pad((int)$_Venta[0]['numero'], 8, "0", STR_PAD_LEFT),
                    'FECHA_DOCUMENTO' => $fecha,
                    'FECHA_VTO' => $fecha,
                    'COD_TIPO_DOCUMENTO' => '01',
                    'COD_MONEDA' => $_Venta[0]['codigo_moneda'],
                    //==================================================
                    'NRO_DOCUMENTO_CLIENTE' => $_Venta[0]['cliente_numero_documento'],
                    'RAZON_SOCIAL_CLIENTE' => $_Venta[0]['cliente_nombre'],
                    'TIPO_DOCUMENTO_CLIENTE' => $_Venta[0]['cliente_tipo_documento'],
                    'DIRECCION_CLIENTE' => $_Venta[0]['cliente_direccion'],
                    'COD_UBIGEO_CLIENTE' => $_Venta[0]['cliente_ubigeo'],
                    'DEPARTAMENTO_CLIENTE' => '',
                    'PROVINCIA_CLIENTE' => '',
                    'DISTRITO_CLIENTE' => '',
                    'CIUDAD_CLIENTE' => '',
                    'COD_PAIS_CLIENTE' => '',
                    //===============================================
                    'NRO_DOCUMENTO_EMPRESA' => $configEmpresa['ruc'],
                    'TIPO_DOCUMENTO_EMPRESA' => $configEmpresa['tipo_doc'],
                    'NOMBRE_COMERCIAL_EMPRESA' => $configEmpresa['nom_comercial'],
                    'CODIGO_UBIGEO_EMPRESA' => $configEmpresa['codigo_ubigeo'],
                    'DIRECCION_EMPRESA' => $configEmpresa['direccion'],
                    'DEPARTAMENTO_EMPRESA' => $configEmpresa['direccion_departamento'],
                    'PROVINCIA_EMPRESA' => $configEmpresa['direccion_provincia'],
                    'DISTRITO_EMPRESA' => $configEmpresa['direccion_distrito'],
                    'CODIGO_PAIS_EMPRESA' => $configEmpresa['direccion_codigopais'],
                    'RAZON_SOCIAL_EMPRESA' => $configEmpresa['razon_social'],
                    'CONTACTO_EMPRESA' => "",
                    //====================INFORMACION PARA ANTICIPO=====================//
                    'FLG_ANTICIPO' => "0",
                    //====================REGULAR ANTICIPO=====================//
                    'FLG_REGU_ANTICIPO' => "0",
                    'NRO_COMPROBANTE_REF_ANT' => "",
                    'MONEDA_REGU_ANTICIPO' => "",
                    'MONTO_REGU_ANTICIPO' => "0",
                    'TIPO_DOCUMENTO_EMP_REGU_ANT' => "",
                    'NRO_DOCUMENTO_EMP_REGU_ANT' => "",
                    //===================CLAVES SOL EMISOR====================//
                    'EMISOR_RUC' => $configEmpresa['ruc'],
                    'EMISOR_USUARIO_SOL' => $configEmpresa['usuariosol'],
                    'EMISOR_PASS_SOL' => $configEmpresa['clavesol'],
                    //RESUMEN
                    'SERIE'=> '', //YYYYMMDD
                    'SECUENCIA'=> '',
                    'PLACA' => $_Venta[0]['f_placa']
                );
                $items_detalle= array();
                foreach ($_Venta as $item) {
                    $items_detalle[] = array(
                        'txtUNIDAD_MEDIDA_DET' => $item['um_descripcion'],
                        'txtCANTIDAD_DET' => $item['vp_cantidad'],
                        'txtPRECIO_DET' => $item['vp_precio_unidad'],
                        'txtSUB_TOTAL_DET' => $item['vp_subtotal'],
                        'txtPRECIO_TIPO_CODIGO' => '01',
                        'txtIGV' => round(($item['vp_total']-$item['vp_subtotal'])*100)/100,
                        'txtISC' => '0',
                        'txtIMPORTE_DET' => $item['vp_subtotal'],
                        'txtCOD_TIPO_OPERACION' => '10',
                        'txtCODIGO_DET' => $item['vp_producto_id'],
                        'txtDESCRIPCION_DET' => $item['p_nombre'],
                        'txtPRECIO_SIN_IGV_DET' => round((float)$item['vp_precio_unidad']/1.18*100000)/100000,
                        'txtTOTAL_DET' => $item['vp_total'],
                        'txtCODIGO_PLU' => ''
                    );
                }
                $rutas = array(
                    'nombre_archivo' => $configEmpresa['ruc'] . '-' . $folio . '-' . $serie . '-' . $numero,
                    'ruta_xml' => $directorio . '/archivos_xml_sunat/cpe_xml/' . $modo . '/' . $configEmpresa['ruc'] . '/' . $configEmpresa['ruc'] . '-' . $folio . '-' . $serie . '-' . $numero,
                    'ruta_cdr' => $directorio . '/archivos_xml_sunat/cpe_xml/' . $modo . '/' . $configEmpresa['ruc'] . '/',
                    'ruta_firma' => $ruta_firma,
                    'pass_firma' => $pass_firma,
                    'ruta_ws' => $ruta_ws[$modo]
                );
                $resp_proceso = $procesarcomprobante->procesar_factura($_data_comprobante, $items_detalle, $rutas);
                echo json_encode($resp_proceso);
            }else{
                throw new Exception('Venta no disponible');
            }
            break;
        default:
            throw new Exception('Opción no disponible');
            break;
    }
} catch (Exception $exc) {
    echo json_encode(array(
        'error'=>true,
        'mensaje'=>$exc->getMessage()
    ));
}