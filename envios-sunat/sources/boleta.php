<?php
define('BASEPATH', dirname(dirname(__DIR__)));
include '../config/database.php';
include '../modelo/Conexion.php';
include BASEPATH.'/application/config/empresa.php';
include BASEPATH.'/application/controllers/fe/Procesarcomprobante.php';

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
    $conexion = new Conexion();
    $conexion = $conexion->get_conexion();
    switch ($opcion) {
        case 'anular':
            $serie = trim($_REQUEST['serie']);
            $numero = trim($_REQUEST['numero']);
            $id = trim($_REQUEST['id']);
            $query = 'SELECT b.fecha b_fecha, b.id b_id, b.serie, b.numero,v.total, v.total_gravado, v.cliente_tipo_documento, v.cliente_numero_documento, 
                        v.cliente_nombre, v.total_igv, v.porcentaje_igv, v.tipo_documento, v.codigo_moneda,
                        v.total_letras, v.cliente_direccion, v.cliente_ubigeo'
                    . ' FROM boleta b '
                    . ' INNER JOIN venta v ON (b.venta_id=v.id)'
                    . ' INNER JOIN venta_producto vp ON (v.id=vp.venta_id)'
                    . ' INNER JOIN resumen_diario_item rdi ON (rdi.id_boleta=b.id)'
                    . ' INNER JOIN resumen_diario rd ON (rd.id_resumen_diario=rdi.id_resumen_diario)'
                    . ' WHERE rdi.tipo=1 AND b.id=:id LIMIT 1';
            $stmt = $conexion->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $resultVenta= $stmt->fetch();
            if(is_array($resultVenta) && count($resultVenta)>0){
                $fecha= $resultVenta['b_fecha'];
                $query= "SELECT COUNT(id_resumen_diario)+1 c FROM resumen_diario WHERE fecha= :fecha";
                $stmt = $conexion->prepare($query);
                $stmt->bindParam(':fecha', $fecha);
                $stmt->execute();
                $rResumenCorrelativo= $stmt->fetch();
                $query= 'INSERT INTO resumen_diario(fecha, correlativo)'
                        . ' VALUES (:fecha, :correlativo)';
                $stmt = $conexion->prepare($query);
                $stmt->bindParam(':fecha', $fecha);
                $stmt->bindParam(':correlativo', $rResumenCorrelativo['c']);
                $stmt->execute();
                $id_resumen = $conexion->lastInsertId();
                $query= 'INSERT INTO resumen_diario_item (id_resumen_diario,id_boleta, tipo) VALUES (:id_resumen_diario, :id_boleta, 3)';
                $stmt = $conexion->prepare($query);
                $stmt->bindParam(':id_resumen_diario', $id_resumen);
                $stmt->bindParam(':id_boleta', $resultVenta['b_id']);
                $stmt->execute();
                $procesarcomprobante = new Procesarcomprobante();
                $_data_comprobante= array(
                    'TIPO_OPERACION' => '0101',
                    'TOTAL_GRAVADAS' => $resultVenta['total_gravado'],
                    'TOTAL_INAFECTA' => "0",
                    'TOTAL_EXONERADAS' => '0',
                    'TOTAL_GRATUITAS' => "0",
                    'TOTAL_PERCEPCIONES' => "0",
                    'TOTAL_RETENCIONES' => "0",
                    'TOTAL_DETRACCIONES' => "0",
                    'TOTAL_BONIFICACIONES' => "0",
                    'TOTAL_EXPORTACION' => "0",
                    'TOTAL_DESCUENTO' => "0",
                    'SUB_TOTAL' => $resultVenta['total_gravado'],
                    'POR_IGV' => $resultVenta['porcentaje_igv'],
                    'TOTAL_IGV' => $resultVenta['total_igv'],
                    'TOTAL_ISC' => "0",
                    'TOTAL_OTR_IMP' => "0",
                    'TOTAL' => $resultVenta['total'],
                    'TOTAL_LETRAS' => $resultVenta['total_letras'],
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
                    'FECHA_DOCUMENTO' => $fecha,
                    'FECHA_VTO' => $fecha,
                    'COD_TIPO_DOCUMENTO' => '',
                    'COD_MONEDA' => $resultVenta['codigo_moneda'],
                    //==================================================
                    'NRO_DOCUMENTO_CLIENTE' => $resultVenta['cliente_numero_documento'],
                    'RAZON_SOCIAL_CLIENTE' => $resultVenta['cliente_nombre'],
                    'TIPO_DOCUMENTO_CLIENTE' => $resultVenta['cliente_tipo_documento'],
                    'DIRECCION_CLIENTE' => $resultVenta['cliente_direccion'],
                    'COD_UBIGEO_CLIENTE' => $resultVenta['cliente_ubigeo'],
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
                    'SERIE'=> str_replace('-', '', $fecha), //YYYYMMDD
                    'SECUENCIA'=> $rResumenCorrelativo['c']
                );
                $_boletas[]= array(
                    'TIPO_COMPROBANTE'=>'03',
                    'NRO_COMPROBANTE'=> $resultVenta['serie'].'-'.$resultVenta['numero'],
                    'NRO_DOCUMENTO'=> $resultVenta['cliente_numero_documento'],
                    'TIPO_DOCUMENTO'=> $resultVenta['cliente_tipo_documento'],
                    'STATUS'=> '3', //anulacion
                    'COD_MONEDA'=> $resultVenta['codigo_moneda'],
                    'TOTAL'=> $resultVenta['total'],
                    'GRAVADA'=> $resultVenta['total_gravado'],
                    'EXONERADO'=> 0,
                    'INAFECTO'=> 0,
                    'EXPORTACION'=> 0,
                    'GRATUITAS'=> 0,
                    'MONTO_CARGO_X_ASIG'=> 0,
                    'ISC'=> 0,
                    'IGV'=> $resultVenta['total_igv'],
                    'OTROS'=> 0,
                );
                $_ruta_comprobante= array(
                    'nombre_archivo' => $configEmpresa['ruc'] . '-RC-' . str_replace('-', '', $fecha) . '-' . $rResumenCorrelativo['c'],
                    'ruta_xml' => BASEPATH . '/archivos_xml_sunat/cpe_xml/' . $modo . '/' . $configEmpresa['ruc'] . '/' . $configEmpresa['ruc'] . '-RC-' . str_replace('-', '', $fecha) . '-' . $rResumenCorrelativo['c'],
                    'ruta_cdr' => BASEPATH . '/archivos_xml_sunat/cpe_xml/' . $modo . '/' . $configEmpresa['ruc'] . '/',
                    'ruta_firma' => $ruta_firma,
                    'pass_firma' => $pass_firma,
                    'ruta_ws' => $ruta_ws[$modo]
                );
                $resp_proceso = $procesarcomprobante->procesar_resumen_boletas($_data_comprobante, $_boletas, $_ruta_comprobante);
                if($resp_proceso['error']==false){
                    $apisunat = new Apisunat();
                    $resp_envio = $apisunat->enviar_resumen_boletas(
                        $configEmpresa['ruc'], 
                        $configEmpresa['usuariosol'],
                        $configEmpresa['clavesol'], 
                        BASEPATH . '/archivos_xml_sunat/cpe_xml/' . $modo . '/' . $configEmpresa['ruc'] . '/' . $configEmpresa['ruc'] . '-RC-' . str_replace('-', '', $fecha) . '-' . $rResumenCorrelativo['c'], 
                        BASEPATH . '/archivos_xml_sunat/cpe_xml/' . $modo . '/' . $configEmpresa['ruc'] . '/', 
                        $configEmpresa['ruc'] . '-RC-' . str_replace('-', '', $fecha) . '-' . $rResumenCorrelativo['c'], 
                        $ruta_ws[$modo]
                    );
                    if($resp_envio['error']==false){
                        $query = "UPDATE resumen_diario SET ticket= :ticket WHERE id_resumen_diario= :id_resumen_diario";
                        $statement = $conexion->prepare($query);
                        $statement->bindParam(':ticket', $resp_envio['cod_ticket']);
                        $statement->bindParam(':id_resumen_diario', $id_resumen);
                        $statement->execute();
                        $resp_ticket = $apisunat->consultar_envio_ticket(
                            $configEmpresa['ruc'], 
                            $configEmpresa['usuariosol'], 
                            $configEmpresa['clavesol'], 
                            $resp_envio['cod_ticket'], 
                            $configEmpresa['ruc'] . '-RC-' . str_replace('-', '', $fecha) . '-' . $rResumenCorrelativo['c'], 
                            BASEPATH . '/archivos_xml_sunat/cpe_xml/' . $modo . '/' . $configEmpresa['ruc'] . '/', 
                            $ruta_ws[$modo]
                        );
                        $envio= 'anulado';
                        if($resp_ticket['error'] == false){
                            $envio= 'anulado';
                        }
                        $query = "UPDATE boleta SET envio='".$envio."' WHERE id=:id";
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
                throw new Exception('Venta no disponible para anulación.');
            }
            break;
        case 2:
            $serie = trim($_REQUEST['serie']);
            $numero = trim($_REQUEST['numero']);
            $id = trim($_REQUEST['id']);
            $query = "SELECT b.fecha, rd.correlativo, rd.id_resumen_diario FROM boleta b "
                    . " INNER JOIN resumen_diario_item rdi ON (b.id=rdi.id_boleta) "
                    . " INNER JOIN resumen_diario rd ON (rd.id_resumen_diario=rdi.id_resumen_diario)"
                    . " WHERE id=:id LIMIT 1";
            $stmt = $conexion->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $result= $stmt->fetch();
            $fecha = str_replace('-','',$result['fecha']);
            $correlativo = $result['correlativo'];
            $resumen_id = $result['id_resumen_diario'];
            $serie= $fecha;
            $numero= $correlativo;
            $name = "Boleta";
            $user_sol = $configEmpresa['usuariosol'];
            $user_pass = $configEmpresa['clavesol'];
            $data_comprobante = array(
                'EMISOR_RUC' => $configEmpresa['ruc'],
                'EMISOR_USUARIO_SOL' => $user_sol,
                'EMISOR_PASS_SOL' => $user_pass
            );
            $rutas = array(
                'ruta_xml' => BASEPATH . '/archivos_xml_sunat/cpe_xml/' . $modo . '/' . $configEmpresa['ruc'] . '/' . $configEmpresa['ruc'] . '-RC-' . $serie . '-' . $numero,
                'ruta_cdr' => BASEPATH . '/archivos_xml_sunat/cpe_xml/' . $modo . '/' . $configEmpresa['ruc'] . '/',
                'nombre_archivo' => $configEmpresa['ruc'] . '-RC-' . $serie . '-' . $numero,
                'ruta_ws' => $ruta_ws[$modo]
            );
            $apisunat = new Apisunat();
            $resp_envio = $apisunat->enviar_resumen_boletas(
                $data_comprobante['EMISOR_RUC'], 
                $data_comprobante['EMISOR_USUARIO_SOL'], 
                $data_comprobante['EMISOR_PASS_SOL'], 
                $rutas['ruta_xml'], 
                $rutas['ruta_cdr'], 
                $rutas['nombre_archivo'], 
                $rutas['ruta_ws']
            );
            if ($resp_envio['error'] == false) {
                $query = "UPDATE resumen_diario SET ticket= :ticket WHERE id_resumen_diario= :id_resumen_diario";
                $statement = $conexion->prepare($query);
                $statement->bindParam(':ticket', $resp_envio['cod_ticket']);
                $statement->bindParam(':id_resumen_diario', $resumen_id);
                $statement->execute();
                $resp_ticket = $apisunat->consultar_envio_ticket(
                        $configEmpresa['ruc'], 
                        $user_sol, 
                        $user_pass, 
                        $resp_envio['cod_ticket'], 
                        $rutas['nombre_archivo'], 
                        $rutas['ruta_cdr'], 
                        $ruta_ws[$modo]);
                $envio='rechazado';
                if ($resp_ticket['error'] == false) {
                    $envio='enviado';
                }
                $query = "UPDATE boleta SET envio=:envio, msj_sunat=:msj_sunat  WHERE id=:id";
                $statement = $conexion->prepare($query);
                $statement->bindParam(':id', $id);
                $statement->bindParam(':envio',$envio);
                $statement->bindParam(':msj_sunat',$resp_ticket['msj_sunat']);
                $statement->execute();
                echo json_encode($resp_ticket);
                //var_dump($resp_envio);
            }else{
                echo json_encode($resp_envio);
            }
        break;
        case 'generarxml':
            $serie = trim($_REQUEST['serie']);
            $numero = trim($_REQUEST['numero']);
            $id = trim($_REQUEST['id']);
            $query = 'SELECT b.id b_id, b.serie, b.numero,v.total, v.total_gravado, v.cliente_tipo_documento, v.cliente_numero_documento, 
                        v.cliente_nombre, v.total_igv, v.porcentaje_igv, v.tipo_documento, v.codigo_moneda,
                        v.total_letras, v.cliente_direccion, v.cliente_ubigeo, rd.id_resumen_diario rd_id_resumen_diario, rd.fecha rd_fecha, rd.correlativo rd_correlativo'
                    . ' FROM boleta b '
                    . ' INNER JOIN venta v ON (b.venta_id=v.id)'
                    . ' INNER JOIN venta_producto vp ON (v.id=vp.venta_id)'
                    . ' INNER JOIN resumen_diario_item rdi ON (rdi.id_boleta=b.id)'
                    . ' INNER JOIN resumen_diario rd ON (rd.id_resumen_diario=rdi.id_resumen_diario)'
                    . ' WHERE rdi.tipo=1 AND b.id=:id LIMIT 1';
            $stmt = $conexion->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $resultVenta= $stmt->fetch();
            if(is_array($resultVenta) && count($resultVenta)>0){
                $fecha= $resultVenta['rd_fecha'];
                $procesarcomprobante = new Procesarcomprobante();
                $_data_comprobante= array(
                    'TIPO_OPERACION' => '0101',
                    'TOTAL_GRAVADAS' => $resultVenta['total_gravado'],
                    'TOTAL_INAFECTA' => "0",
                    'TOTAL_EXONERADAS' => '0',
                    'TOTAL_GRATUITAS' => "0",
                    'TOTAL_PERCEPCIONES' => "0",
                    'TOTAL_RETENCIONES' => "0",
                    'TOTAL_DETRACCIONES' => "0",
                    'TOTAL_BONIFICACIONES' => "0",
                    'TOTAL_EXPORTACION' => "0",
                    'TOTAL_DESCUENTO' => "0",
                    'SUB_TOTAL' => $resultVenta['total_gravado'],
                    'POR_IGV' => $resultVenta['porcentaje_igv'],
                    'TOTAL_IGV' => $resultVenta['total_igv'],
                    'TOTAL_ISC' => "0",
                    'TOTAL_OTR_IMP' => "0",
                    'TOTAL' => $resultVenta['total'],
                    'TOTAL_LETRAS' => $resultVenta['total_letras'],
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
                    'FECHA_DOCUMENTO' => $fecha,
                    'FECHA_VTO' => $fecha,
                    'COD_TIPO_DOCUMENTO' => '',
                    'COD_MONEDA' => $resultVenta['codigo_moneda'],
                    //==================================================
                    'NRO_DOCUMENTO_CLIENTE' => $resultVenta['cliente_numero_documento'],
                    'RAZON_SOCIAL_CLIENTE' => $resultVenta['cliente_nombre'],
                    'TIPO_DOCUMENTO_CLIENTE' => $resultVenta['cliente_tipo_documento'],
                    'DIRECCION_CLIENTE' => $resultVenta['cliente_direccion'],
                    'COD_UBIGEO_CLIENTE' => $resultVenta['cliente_ubigeo'],
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
                    'SERIE'=> str_replace('-', '', $fecha), //YYYYMMDD
                    'SECUENCIA'=> $resultVenta['rd_correlativo']
                );
                $_boletas[]= array(
                    'TIPO_COMPROBANTE'=>'03',
                    'NRO_COMPROBANTE'=> $resultVenta['serie'].'-'.$resultVenta['numero'],
                    'NRO_DOCUMENTO'=> $resultVenta['cliente_numero_documento'],
                    'TIPO_DOCUMENTO'=> $resultVenta['cliente_tipo_documento'],
                    'STATUS'=> '1', //emision
                    'COD_MONEDA'=> $resultVenta['codigo_moneda'],
                    'TOTAL'=> $resultVenta['total'],
                    'GRAVADA'=> $resultVenta['total_gravado'],
                    'EXONERADO'=> 0,
                    'INAFECTO'=> 0,
                    'EXPORTACION'=> 0,
                    'GRATUITAS'=> 0,
                    'MONTO_CARGO_X_ASIG'=> 0,
                    'ISC'=> 0,
                    'IGV'=> $resultVenta['total_igv'],
                    'OTROS'=> 0,
                );
                $_ruta_comprobante= array(
                    'nombre_archivo' => $configEmpresa['ruc'] . '-RC-' . str_replace('-', '', $fecha) . '-' . $resultVenta['rd_correlativo'],
                    'ruta_xml' => BASEPATH . '/archivos_xml_sunat/cpe_xml/' . $modo . '/' . $configEmpresa['ruc'] . '/' . $configEmpresa['ruc'] . '-RC-' . str_replace('-', '', $fecha) . '-' . $resultVenta['rd_correlativo'],
                    'ruta_cdr' => BASEPATH . '/archivos_xml_sunat/cpe_xml/' . $modo . '/' . $configEmpresa['ruc'] . '/',
                    'ruta_firma' => $ruta_firma,
                    'pass_firma' => $pass_firma,
                    'ruta_ws' => $ruta_ws[$modo]
                );
                $resp_proceso = $procesarcomprobante->procesar_resumen_boletas($_data_comprobante, $_boletas, $_ruta_comprobante);
                if($resp_proceso['error']==false){
                    $apisunat = new Apisunat();
                    $resp_envio = $apisunat->enviar_resumen_boletas(
                        $configEmpresa['ruc'], 
                        $configEmpresa['usuariosol'],
                        $configEmpresa['clavesol'], 
                        BASEPATH . '/archivos_xml_sunat/cpe_xml/' . $modo . '/' . $configEmpresa['ruc'] . '/' . $configEmpresa['ruc'] . '-RC-' . str_replace('-', '', $fecha) . '-' . $resultVenta['rd_correlativo'], 
                        BASEPATH . '/archivos_xml_sunat/cpe_xml/' . $modo . '/' . $configEmpresa['ruc'] . '/', 
                        $configEmpresa['ruc'] . '-RC-' . str_replace('-', '', $fecha) . '-' . $resultVenta['rd_correlativo'], 
                        $ruta_ws[$modo]
                    );
                    if($resp_envio['error']==false){
                        $query = "UPDATE resumen_diario SET ticket= :ticket WHERE id_resumen_diario= :id_resumen_diario";
                        $statement = $conexion->prepare($query);
                        $statement->bindParam(':ticket', $resp_envio['cod_ticket']);
                        $statement->bindParam(':id_resumen_diario', $resultVenta['rd_id_resumen_diario']);
                        $statement->execute();
                        $resp_ticket = $apisunat->consultar_envio_ticket(
                            $configEmpresa['ruc'], 
                            $configEmpresa['usuariosol'], 
                            $configEmpresa['clavesol'], 
                            $resp_envio['cod_ticket'], 
                            $configEmpresa['ruc'] . '-RC-' . str_replace('-', '', $fecha) . '-' . $resultVenta['rd_correlativo'], 
                            BASEPATH . '/archivos_xml_sunat/cpe_xml/' . $modo . '/' . $configEmpresa['ruc'] . '/', 
                            $ruta_ws[$modo]
                        );
                        $envio= 'anulado';
                        if($resp_ticket['error'] == false){
                            $envio= 'enviado';
                        }
                        $query = "UPDATE boleta SET envio='".$envio."' WHERE id=:id";
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
                throw new Exception('Venta no disponible para generar XML.');
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