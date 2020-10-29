<?php
defined('BASEPATH') or exit('No direct script access allowed');
ini_set('max_execution_time', 0);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Cpe extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function index()
    {
        echo 'Hello world!';
    }

    public function enviar()
    {
        try {
            if (!(isset($_POST['id']) && isset($_POST['serie']) && isset($_POST['numero']) && isset($_POST['tipo']))) {
                throw new Exception('Datos incompletos!');
            }
            $id = $_POST['id'];
            $serie = $_POST['serie'];
            $numero = $_POST['numero'];
            $tipo = $_POST['tipo'];
            $_doc = array();
            if ($tipo == 'boleta') {
                $_doc = $this->venta_model->boletaById($id, $numero, $serie);
            } else if ($tipo == 'factura') {
                $_doc = $this->venta_model->facturaById($id, $numero, $serie);
            } else {
                exit();
            }
            $_items = $this->venta_model->ventaProductoByIdVenta($_doc->venta_id);
            //api
            $codigo_tipo_documento = $_doc->tipo_doc;
            $serie_documento = $_doc->serie;
            $numero_documento = $_doc->numero;
            $fecha_de_emision = $_doc->fecha;
            $hora_de_emision = $_doc->hora_emision;
            $cliente_tipodocumento = $tipo == 'factura' ? 6 : 1;
            $cliente_numerodocumento = $_doc->numero_doc;
            $cliente_nombre = $_doc->cliente;
            $cliente_direccion = $_doc->direccion;
            $total = 0;
            $total_igv = 0;
            $total_operaciones_gravadas = 0;

            $items = array();
            foreach ($_items as $value) {
                $i_total_igv = (float) $value->total - $value->subtotal;
                $i_item = array(
                    "codigo_interno" => substr(md5(uniqid() . mt_rand()), 0, 10),
                    "descripcion" => isset($value->p_nombre) ? "$value->p_nombre" . ":" : ""  . $value->texto_ref,
                    "codigo_items_sunat" => '10000000',
                    "unidad_de_medida" => "NIU",
                    "cantidad" => $value->cantidad, //2,
                    "valor_unitario" => round((($value->precio_unidad / 1.18) * 100) / 100, 2), //50,
                    "codigo_tipo_precio" => '01', //"01",
                    "precio_unitario" => $value->precio_unidad, //59,
                    "codigo_tipo_afectacion_igv" => '10', //"10",
                    "total_base_igv" => $value->subtotal, //100.00,
                    "porcentaje_igv" => 18, //18,
                    "total_igv" => $i_total_igv, //18,
                    "total_impuestos" => $i_total_igv, //18,
                    "total_valor_item" => $value->subtotal, //100,
                    "total_item" => $value->total, //118
                );
                $items[] = $i_item;
                $total = $total + $value->total;
                $total_igv = $total_igv + $i_total_igv;
                $total_operaciones_gravadas = $total_operaciones_gravadas + $value->subtotal;
            }
            $datos_del_cliente_o_receptor = array(
                "codigo_tipo_documento_identidad" => $cliente_tipodocumento,
                "numero_documento" => $cliente_numerodocumento,
                "apellidos_y_nombres_o_razon_social" => $cliente_nombre,
                "codigo_pais" => "PE",
                "ubigeo" => '',
                "direccion" => $cliente_direccion,
                "correo_electronico" => "",
                "telefono" => ""
            );
            $totales = array(
                "total_exportacion" => 0,
                "total_operaciones_gravadas" => $total_operaciones_gravadas,
                "total_operaciones_inafectas" => 0,
                "total_operaciones_exoneradas" => 0,
                "total_operaciones_gratuitas" => 0,
                "total_igv" => $total_igv,
                "total_impuestos" => $total_igv,
                "total_valor" => $total_operaciones_gravadas,
                "total_venta" => $total
            );
            $_dataCURL = array(
                "serie_documento" => $serie_documento,
                "numero_documento" => $numero_documento,
                "fecha_de_emision" => $fecha_de_emision, //"2019-09-17"
                "hora_de_emision" => $hora_de_emision, //"10:11:11"
                "codigo_tipo_operacion" => "0101",
                "codigo_tipo_documento" => $codigo_tipo_documento,
                "codigo_tipo_moneda" => "PEN",
                "fecha_de_vencimiento" => $fecha_de_emision,
                "numero_orden_de_compra" => "",
                "datos_del_cliente_o_receptor" => $datos_del_cliente_o_receptor,
                "totales" => $totales,
                "items" => $items,
                "informacion_adicional" => ""
            );
            //print_r($_dataCURL); exit();
            $CURLOPT_URL = $_SERVER['APP_CPE_URL'];
            $Authorization_token = $_SERVER['APP_CPE_TOKEN'];
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $CURLOPT_URL . '/documents',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($_dataCURL),
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "Authorization: Bearer " . $Authorization_token
                ),
            ));
            //exit();
            $responseAPI = curl_exec($curl);
            curl_close($curl);
            if (!empty($responseAPI)) {
                $rs = json_decode($responseAPI, true);
                if (is_array($rs)) {
                    if ($rs['success']) {
                        $external_id = isset($rs['data']['external_id']) ? $rs['data']['external_id'] : null;
                        $estado_api = isset($rs['data']['state_type_description']) ? $rs['data']['state_type_description'] : null;
                        $xml_link = isset($rs['links']['xml']) ? $rs['links']['xml'] : null;
                        $cdr_link = isset($rs['links']['cdr']) ? $rs['links']['cdr'] : null;
                        $pdf_link = isset($rs['links']['pdf']) ? $rs['links']['pdf'] : null;
                        $this->venta_model->updateCPE($tipo, $id, $external_id, $estado_api);
                        $this->venta_model->updateCPE_xml_cd($tipo, $id, $xml_link, $cdr_link, $pdf_link);
                    }
                }
                echo $responseAPI;
            } else {
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Error en el servidor API'
                ));
            }
            //var_dump($responseAPI);
            //print_r($_doc);
            //print_r($_items);
        } catch (Exception $exc) {
            echo json_encode(array(
                'success' => false,
                'message' => $exc->getMessage()
            ));
        }
    }

    public function enviar_nota_credito()
    {
        try {
            if (!(isset($_POST['id']) || !isset($_POST['serie']) || !isset($_POST['numero']) || !isset($_POST['tipo']))) {
                throw new Exception('Datos incompletos!');
            }
            $id = $_POST['id'];
            $serie = $_POST['serie'];
            $numero = $_POST['numero'];
            $tipo = $_POST['tipo'];
            $_doc = array();
            $_doc = $this->venta_model->notaCreditoById($id, $numero, $serie);

            $_items = $this->venta_model->ventaProductoByIdVenta($_doc->venta_id);

            $codigo_tipo_documento = $_doc->tipo_doc;
            $serie_documento = $_doc->serie_nota;
            $numero_documento = $_doc->numero_nota;
            $fecha_de_emision = $_doc->fecha;
            $hora_de_emision = $_doc->hora_emision;
            $cliente_tipodocumento = "6";
            $cliente_numerodocumento = $_doc->numero_doc;
            $cliente_nombre = $_doc->cliente;
            $cliente_direccion = $_doc->direccion;
            $external_id_modificado = $_doc->external_id_modificado;
            $tipo_nota = $_doc->tipo_nota;
            $motivo_o_sustento_de_nota = $_doc->descripcion_nota;
            $total = 0;
            $total_igv = 0;
            $total_operaciones_gravadas = 0;

            $datos_del_cliente_o_receptor = array(
                "codigo_tipo_documento_identidad" => $cliente_tipodocumento,
                "numero_documento" => $cliente_numerodocumento,
                "apellidos_y_nombres_o_razon_social" => $cliente_nombre,
                "codigo_pais" => "PE",
                "ubigeo" => '',
                "direccion" => $cliente_direccion,
                "correo_electronico" => "",
                "telefono" => ""
            );
            $documento_afectado = array(
                "external_id" => $external_id_modificado
            );

            $items = array();
            foreach ($_items as $value) {

                $i_total_igv = (float) $value->total - $value->subtotal;
                $items[] = array(
                    "codigo_interno" => substr(md5(uniqid() . mt_rand()), 0, 10),
                    "descripcion" => $value->p_nombre . ": " . $value->texto_ref,
                    "codigo_items_sunat" => '10000000',
                    "unidad_de_medida" => "NIU",
                    "cantidad" => $value->cantidad, //2,
                    "valor_unitario" => round((($value->precio_unidad / 1.18) * 100) / 100, 2), //50,
                    "codigo_tipo_precio" => '01', //"01",
                    "precio_unitario" => $value->precio_unidad, //59,
                    "codigo_tipo_afectacion_igv" => '10', //"10",
                    "total_base_igv" => $value->subtotal, //100.00,
                    "porcentaje_igv" => 18, //18,
                    "total_igv" => $i_total_igv, //18,
                    "total_impuestos" => $i_total_igv, //18,
                    "total_valor_item" => $value->subtotal, //100,
                    "total_item" => $value->total, //118

                );
                $total = $total + $value->total;
                $total_igv = $total_igv + $i_total_igv;
                $total_operaciones_gravadas = $total_operaciones_gravadas + $value->subtotal;
            }
            $totales = array(
                "total_exportacion" => 0,
                "total_operaciones_gravadas" => $total_operaciones_gravadas,
                "total_operaciones_inafectas" => 0,
                "total_operaciones_exoneradas" => 0,
                "total_operaciones_gratuitas" => 0,
                "total_igv" => $total_igv,
                "total_impuestos" => $total_igv,
                "total_valor" => $total_operaciones_gravadas,
                "total_venta" => $total
            );
            $_dataCURL = array(
                "serie_documento" => $serie_documento,
                "numero_documento" => $numero_documento,
                "fecha_de_emision" => $fecha_de_emision, //"2019-09-17"
                "hora_de_emision" => $hora_de_emision, //"10:11:11"
                "codigo_tipo_documento" => $codigo_tipo_documento,
                "codigo_tipo_nota" => $tipo_nota,
                "codigo_tipo_moneda" => "PEN",
                "numero_orden_de_compra" => "",
                "datos_del_cliente_o_receptor" => $datos_del_cliente_o_receptor,
                "totales" => $totales,
                "items" => $items,
                "documento_afectado" => $documento_afectado,
                "motivo_o_sustento_de_nota" => $motivo_o_sustento_de_nota
            );

            $CURLOPT_URL = $_SERVER['APP_CPE_URL'];
            $Authorization_token = $_SERVER['APP_CPE_TOKEN'];
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $CURLOPT_URL . '/documents',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($_dataCURL),
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "Authorization: Bearer " . $Authorization_token
                ),
            ));
            //exit();
            $responseAPI = curl_exec($curl);
            curl_close($curl);
            if (!empty($responseAPI)) {
                $rs = json_decode($responseAPI, true);
                if (is_array($rs)) {
                    if ($rs['success']) {
                        $external_id = isset($rs['data']['external_id']) ? $rs['data']['external_id'] : null;
                        $estado_api = isset($rs['data']['state_type_description']) ? $rs['data']['state_type_description'] : null;
                        $xml_link = isset($rs['links']['xml']) ? $rs['links']['xml'] : null;
                        $cdr_link = isset($rs['links']['cdr']) ? $rs['links']['cdr'] : null;
                        $pdf_link = isset($rs['links']['pdf']) ? $rs['links']['pdf'] : null;
                        $this->venta_model->updateCPE($tipo, $id, $external_id, $estado_api);
                        $this->venta_model->updateCPE_xml_cd($tipo, $id, $xml_link, $cdr_link, $pdf_link);
                    }
                }
                echo $responseAPI;
            } else {
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Error en el servidor API'
                ));
            }
            //var_dump($responseAPI);
            //print_r($_doc);
            //print_r($_items);
        } catch (Exception $exc) {
            echo json_encode(array(
                'success' => false,
                'message' => $exc->getMessage()
            ));
        }
    }

    public function anular()
    {
        try {
            if (!(isset($_POST['id']) && isset($_POST['serie']) && isset($_POST['numero']) && isset($_POST['tipo']))) {
                throw new Exception('Datos incompletos!');
            }
            $id = $_POST['id'];
            $serie = $_POST['serie'];
            $numero = $_POST['numero'];
            $tipo = $_POST['tipo'];
            $_doc = array();
            if ($tipo == 'boleta') {
                $_doc = $this->venta_model->boletaById($id, $numero, $serie);
            } else if ($tipo == 'factura') {
                $_doc = $this->venta_model->facturaById($id, $numero, $serie);
            } else if ($tipo == 'nota_credito_factura') {
                $_doc = $this->venta_model->notaCreditoById($id, $numero, $serie);
            } else {
                exit();
            }
            $_dataCURL = array(
                "fecha_de_emision_de_documentos" => $_doc->fecha, //"2018-10-09",
                "codigo_tipo_proceso" => "3",
                "documentos" => array(array(
                    "external_id" => $_doc->external_id,
                    "motivo_anulacion" => "Se duplico documento"
                ))
            );
            //print_r($_dataCURL);
            $CURLOPT_URL = $_SERVER['APP_CPE_URL'];
            $Authorization_token = $_SERVER['APP_CPE_TOKEN'];
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $CURLOPT_URL . '/voided',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($_dataCURL),
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "Authorization: Bearer " . $Authorization_token
                ),
            ));
            $responseAPI = curl_exec($curl);
            curl_close($curl);
            if (!empty($responseAPI)) {
                $rs = json_decode($responseAPI, true);
                if (is_array($rs)) {
                    if ($rs['success']) {
                        $external_id = $_doc->external_id;
                        $this->venta_model->updateEstadoCPE($tipo, $id, $external_id, 'Anulado');
                    }
                }
                echo $responseAPI;
            } else {
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Error en el servidor API'
                ));
            }
            //var_dump($responseAPI);
            //print_r($_doc);
            //print_r($_items);
        } catch (Exception $exc) {
            echo json_encode(array(
                'success' => false,
                'message' => $exc->getMessage()
            ));
        }
    }

    public function estado_cpe()
    {
        try {
            if (!(isset($_POST['id']) && isset($_POST['serie']) && isset($_POST['numero']) && isset($_POST['tipo']))) {
                throw new Exception('Datos incompletos!');
            }
            $id = $_POST['id'];
            $serie = $_POST['serie'];
            $numero = $_POST['numero'];
            $tipo = $_POST['tipo'];
            $_doc = array();
            if ($tipo == 'boleta') {
                $_doc = $this->venta_model->boletaById($id, $numero, $serie);
            } else if ($tipo == 'factura') {
                $_doc = $this->venta_model->facturaById($id, $numero, $serie);
            } else if ($tipo == 'nota_credito_factura') {
                $_doc = $this->venta_model->notaCreditoById($id, $numero, $serie);
            } else {
                exit();
            }
            $_dataCURL = array(
                "external_id" => $_doc->external_id,
                "serie_number" => $_doc->serie . '-' . $_doc->numero
            );
            //print_r($_dataCURL);
            $CURLOPT_URL = $_SERVER['APP_CPE_URL'];
            $Authorization_token = $_SERVER['APP_CPE_TOKEN'];
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $CURLOPT_URL . '/documents/status',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($_dataCURL),
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "Authorization: Bearer " . $Authorization_token
                ),
            ));
            $responseAPI = curl_exec($curl);
            curl_close($curl);
            if (!empty($responseAPI)) {
                $rs = json_decode($responseAPI, true);
                if (is_array($rs)) {
                    if ($rs['success']) {
                        $estado_api = isset($rs['data']['status']) ? $rs['data']['status'] : null;
                        if ($estado_api) {
                            $external_id = $_doc->external_id;
                            $this->venta_model->updateEstadoCPE($tipo, $id, $external_id, $estado_api);
                        }
                    }
                }
                echo $responseAPI;
            } else {
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Error en el servidor API'
                ));
            }
        } catch (Exception $exc) {
            echo json_encode(array(
                'success' => false,
                'message' => $exc->getMessage()
            ));
        }
    }

    public function enviar_guia()
    {
        try {
            if (!(isset($_POST['id']) && isset($_POST['serie']) && isset($_POST['numero']))) {
                throw new Exception('Datos incompletos!');
            }
            $id = $_POST['id'];
            $serie = $_POST['serie'];
            $numero = $_POST['numero'];
            $_empresa = $this->guia_model->getConfig();
            $_doc = $this->guia_model->getDatosRemision($id);
            $_items = $this->guia_model->getProductosRemision($id)->result();
            //api
            $serie_documento = $_doc->serie;
            $numero_documento = (int) $_doc->numero;
            $fecha_de_emision = $_doc->fecha_remision;
            $hora_de_emision = date('H:i:s');
            $cliente_tipodocumento = $_doc->destinatario_identidad_tipo;
            $cliente_numerodocumento = $_doc->destinatario_identidad_numero;
            $cliente_nombre = $_doc->destinatario_nombre;
            $cliente_direccion = $_doc->llegada_direccion;
            $items = array();
            foreach ($_items as $value) {
                $i_item = array(
                    "codigo_interno" => substr(md5(uniqid() . mt_rand()), 0, 10), //debe estar creado en el api
                    "cantidad" => $value->cantidad,
                );
                $items[] = $i_item;
            }
            $datos_del_emisor = array(
                "codigo_pais" => "PE",
                "ubigeo" => $_empresa->codigo_ubigeo,
                "direccion" => $_empresa->direccion,
                "correo_electronico" => "",
                "telefono" => "",
                "codigo_del_domicilio_fiscal" => "0000"
            );
            $datos_del_cliente_o_receptor = array(
                "codigo_tipo_documento_identidad" => $cliente_tipodocumento,
                "numero_documento" => $cliente_numerodocumento,
                "apellidos_y_nombres_o_razon_social" => $cliente_nombre,
                "nombre_comercial" => $cliente_nombre,
                "codigo_pais" => "PE",
                "ubigeo" => $_doc->llegada_ubigeo, //"150101",
                "direccion" => $cliente_direccion,
                "correo_electronico" => "",
                "telefono" => ""
            );
            $direccion_partida = array(
                "ubigeo" => $_doc->partida_ubigeo,
                "direccion" => $_doc->partida_direccion
            );
            $direccion_llegada = array(
                "ubigeo" => $_doc->llegada_ubigeo,
                "direccion" => $_doc->llegada_direccion,
            );
            $transportista = array(
                "codigo_tipo_documento_identidad" => $_doc->transportista_identidad_tipo,
                "numero_documento" => $_doc->transportista_identidad_numero,
                "apellidos_y_nombres_o_razon_social" => $_doc->transportista_nombre,
            );
            $chofer = array(
                "codigo_tipo_documento_identidad" => $_doc->conductor_identidad_tipo,
                "numero_documento" => $_doc->conductor_identidad_numero
            );
            $_dataCURL = array(
                "serie_documento" => $serie_documento,
                "numero_documento" => $numero_documento,
                "fecha_de_emision" => $fecha_de_emision, //"2019-09-17"
                "hora_de_emision" => $hora_de_emision, //"10:11:11"
                "codigo_tipo_documento" => '09',
                "datos_del_emisor" => $datos_del_emisor,
                "datos_del_cliente_o_receptor" => $datos_del_cliente_o_receptor,
                "observaciones" => "-",
                "codigo_modo_transporte" => $_doc->modalidad_transporte == 'Transporte publico' ? '01' : '02',
                "codigo_motivo_traslado" => $_doc->motivo_traslado_codigo,
                "descripcion_motivo_traslado" => $_doc->motivo_traslado_descripcion,
                "fecha_de_traslado" => $_doc->fecha_inicio_traslado, //"2019-01-16",
                "codigo_de_puerto" => "",
                "indicador_de_transbordo" => false,
                "unidad_peso_total" => "KGM",
                "peso_total" => $_doc->peso_bruto,
                "numero_de_bultos" => 1,
                "numero_de_contenedor" => "",
                "direccion_partida" => $direccion_partida,
                "direccion_llegada" => $direccion_llegada,
                "transportista" => $transportista,
                "chofer" => $chofer,
                "numero_de_placa" => $_doc->placa_vehiculo_transporte, //"A01-1254",
                "items" => $items
            );
            //print_r($_dataCURL); exit();
            $CURLOPT_URL = $_SERVER['APP_CPE_URL'];
            $Authorization_token = $_SERVER['APP_CPE_TOKEN'];
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $CURLOPT_URL . '/dispatchesZ',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($_dataCURL),
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "Authorization: Bearer " . $Authorization_token
                ),
            ));
            //exit();
            $responseAPI = curl_exec($curl);
            curl_close($curl);
            if (!empty($responseAPI)) {
                $rs = json_decode($responseAPI, true);
                if (is_array($rs)) {
                    if ($rs['success']) {
                        $external_id = isset($rs['data']['external_id']) ? $rs['data']['external_id'] : null;
                        $estado_api = isset($rs['data']['state_type_description']) ? $rs['data']['state_type_description'] : null;
                        //print_r($data);
                        //print_r($where);
                        $this->guia_model->updateCPE($id, $external_id, 'Registrado');
                    }
                }
                echo $responseAPI;
            } else {
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Error en el servidor API'
                ));
            }
            //var_dump($responseAPI);
            //print_r($_doc);
            //print_r($_items);
        } catch (Exception $exc) {
            echo json_encode(array(
                'success' => false,
                'message' => $exc->getMessage()
            ));
        }
    }

    public function estado_guia()
    {
        try {
            if (!(isset($_POST['id']) && isset($_POST['serie']) && isset($_POST['numero']))) {
                throw new Exception('Datos incompletos!');
            }
            $id = $_POST['id'];
            $serie = $_POST['serie'];
            $numero = $_POST['numero'];
            $_doc = $this->guia_model->getDatosRemision($id);
            $_dataCURL = array(
                "external_id" => $_doc->external_id,
                "serie_number" => $_doc->serie . '-' . (int) $_doc->numero
            );
            //print_r($_dataCURL);
            $CURLOPT_URL = $_SERVER['APP_CPE_URL'];
            $Authorization_token = $_SERVER['APP_CPE_TOKEN'];
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $CURLOPT_URL . '/dispatches/status',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($_dataCURL),
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "Authorization: Bearer " . $Authorization_token
                ),
            ));
            $responseAPI = curl_exec($curl);
            curl_close($curl);
            if (!empty($responseAPI)) {
                $rs = json_decode($responseAPI, true);
                if (is_array($rs)) {
                    if ($rs['success']) {
                        $estado_api = isset($rs['data']['status']) ? $rs['data']['status'] : null;
                        if ($estado_api) {
                            $external_id = $_doc->external_id;
                            $this->guia_model->updateEstadoCPE($id, $external_id, $estado_api);
                        }
                    }
                }
                echo $responseAPI;
            } else {
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Error en el servidor API'
                ));
            }
        } catch (Exception $exc) {
            echo json_encode(array(
                'success' => false,
                'message' => $exc->getMessage()
            ));
        }
    }
}
