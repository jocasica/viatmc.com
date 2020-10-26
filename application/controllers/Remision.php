<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Remision extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('url', 'language'));
        // $this->load->model('Guia_model');

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
    }

    /**
     * Mapear las remisiones actuales devolviendo un array de objetos
     *
     * @param bool $json
     * @return array
     */
    private function getRemisiones($json = false) {
        $series = [];
        $result = $this->venta_model->getRemisiones();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            if ($json) {
                $fields = [];
                foreach ($row as $key => $field) {
                    $fields[$key] = mb_convert_encoding($field, 'UTF-8');
                }

                $series[] = $fields;
            } else {
                $series[] = (object) $row;
            }
        }
        return array_map(static function ($a) { return $a; }, $series);
    }

     public function numero() {
        $serie = $this->input->post('serie');
        $rs = $this->guia_model->getCorrelativo($serie)->row();
        echo json_encode(array(
            'success' => true,
            'serie' => $serie,
            'numero' => $rs->numero
        ));
    }
    
    public function index() {
        if ($this->ion_auth->logged_in()) {
            $data = array(
                'cots' => $this->getRemisiones()
            );
            $this->load->view('/layout/top');
            $this->load->view('menu/remision/index', $data);
            $this->load->view('/layout/bottom');
        } else {
            redirect('auth/login', 'refresh');
        }
    }

    public function delete($id) {
        if ($this->ion_auth->logged_in()) {
            $this->venta_model->deleteCotizacion($id);
            $data = array('cots' => $this->venta_model->getCotizaciones());
            $this->load->view('/layout/top');
            $this->load->view('menu/remision/index', $data);
            $this->load->view('/layout/bottom');
        } else {
            redirect('auth/login', 'refresh');
        }
    }

    public function create() {
        if ($this->ion_auth->logged_in()) {
            $data = array(
                'serie' => array('T001','T002'),
                'correlativo' => $this->guia_model->getCorrelativo('T001')->result()[0]->numero,
                'productos' => $this->venta_model->getProductosActivos(),
            );
            $this->load->view('/layout/top');
            $this->load->view('menu/remision/create', $data);
            $this->load->view('/layout/bottom');
        } else {
            redirect('auth/login', 'refresh');
        }
    }

    public function edit($id) {
        if ($this->ion_auth->logged_in()) {
            $data = array('productos' => $this->venta_model->getProductosActivos(),
                'cotizacion' => $this->venta_model->getCotizacionId($id),
                'cot_prod' => $this->venta_model->getCotizacion_Producto());

            $this->load->view('/layout/top');
            $this->load->view('/menu/remision/edit', $data);
            $this->load->view('/layout/bottom');
        } else {
            redirect('auth/login', 'refresh');
        }
    }

    public function post() {
        $this->load->library('../controllers/fe/validaciondedatos');
        $validacion = $this->validaciondedatos;
        $this->load->library('../controllers/fe/procesarcomprobante');
        $procesarcomprobante = $this->procesarcomprobante;
        if ($this->ion_auth->logged_in()) {
            $serie = $this->input->post('serie');
            $numero = $this->input->post('numero');
            $fecha_remision = $this->input->post('fecha');
            $hora_remision = date('H:i:s');
            $fecha_inicio_traslado = $this->input->post('fecha_inicio_traslado');
            $motivo_traslado_descripcion = $this->input->post('motivo_traslado');
            $motivo_traslado_codigo = $this->input->post('hid_motivo_traslado_codigo');
            $modalidad_transporte = $this->input->post('modalidad_transporte');
            $modalidad_transporte_codigo = $this->input->post('hid_modalidad_transporte_codigo');
            $transportista_nombre = $this->input->post('transportista_nombre');
            $transportista_ruc = $this->input->post('transportista_ruc');
            $transportista_direccion = $this->input->post('transportista_direccion');
            $peso_bruto = $this->input->post('peso_bruto');
            $destinatario_nombre = $this->input->post('cliente_nombre');
            $destinatario_identidad_tipo = $this->input->post('cliente_tipo_documento');
            $destinatario_identidad_numero = $this->input->post('cliente_numero_documento');
            $ubigeo_partida = $this->input->post('ubigeo_partida');
            $departamento_partida = $this->input->post('departamento_partida');
            $provincia_partida = $this->input->post('provincia_partida');
            $distrito_partida = $this->input->post('distrito_partida');
            $ubigeo_llegada = $this->input->post('ubigeo_llegada');
            $departamento_llegada = $this->input->post('departamento_llegada');
            $provincia_llegada = $this->input->post('provincia_llegada');
            $distrito_llegada = $this->input->post('distrito_llegada');
            $placa_vehiculo_transporte = $this->input->post('vehiculo_placa');
            $conductor_identidad_numero = $this->input->post('conductor_documento');
            $conductor_nombre = $this->input->post('conductor_nombre');
            $conductor_licencia = $this->input->post('conductor_licencia');
            $conductor_identidad_tipo = $this->input->post('conductor_tipo_documento');
            $observacion = $this->input->post('observacion');
            $direccion_llegada = $this->input->post('direccion_llegada');
            $direccion_partida = $this->input->post('direccion_partida');
            //
            $id_remision_producto = $this->input->post('id_remision_producto');
            $codigo_producto = $this->input->post('codigo_producto');
            $descripcion = $this->input->post('descripcion');
            $unidad_medida = $this->input->post('unidad_medida');
            $cantidad = $this->input->post('cantidad');
            $estado = 1;
            $estatus_id = 1;
            $this->config->load('empresa');
            $datosEmpresa = array(
                'ruc' => $this->config->item('ruc'),
                'tipo_doc' => $this->config->item('tipo_doc'),
                'nom_comercial' => $this->config->item('nom_comercial'),
                'razon_social' => $this->config->item('razon_social'),
                'codigo_ubigeo' => $this->config->item('codigo_ubigeo'),
                'direccion' => $this->config->item('direccion'),
                'direccion_departamento' => $this->config->item('direccion_departamento'),
                'direccion_provincia' => $this->config->item('direccion_provincia'),
                'direccion_distrito' => $this->config->item('direccion_distrito'),
                'direccion_codigopais' => $this->config->item('direccion_codigopais'),
                'usuariosol' => $this->config->item('usuariosol'),
                'clavesol' => $this->config->item('clavesol'),
                'tipoproceso' => $this->config->item('tipoproceso'),
                'firma_password' => $this->config->item('firma_password'),
                'local' => $this->config->item('local')
            );
            $remision = array(
                'id' => '',
                'serie' => $serie,
                'numero' => $numero,
                'tipo_doc' => '09',
                'fecha_remision' => $fecha_remision,
                'hora_remision' => $hora_remision,
                'fecha_inicio_traslado' => $fecha_inicio_traslado,
                'motivo_traslado_codigo' => $motivo_traslado_codigo,
                'motivo_traslado_descripcion' => $motivo_traslado_descripcion,
                'modalidad_transporte' => $modalidad_transporte,
                'modalidad_transporte_codigo' => $modalidad_transporte_codigo,
                'transportista_identidad_numero' => $transportista_ruc,
                'transportista_identidad_tipo' => '6',
                'transportista_nombre' => $transportista_nombre,
                'peso_bruto' => $peso_bruto,
                'destinatario_nombre' => $destinatario_nombre,
                'destinatario_identidad_tipo' => $destinatario_identidad_tipo,
                'destinatario_identidad_numero' => $destinatario_identidad_numero,
                'placa_vehiculo_transporte' => $placa_vehiculo_transporte,
                'conductor_nombre' => $conductor_nombre,
                'conductor_identidad_tipo' => $conductor_identidad_tipo,
                'conductor_identidad_numero' => $conductor_identidad_numero,
                'conductor_licencia' => $conductor_licencia,
                'observaciones' => $observacion,
                'estado' => $estado,
                'departamento_partida' => $departamento_partida,
                'provincia_partida' => $provincia_partida,
                'distrito_partida' => $distrito_partida,
                'departamento_llegada' => $departamento_llegada,
                'provincia_llegada' => $provincia_llegada,
                'distrito_llegada' => $distrito_llegada,
                'partida_ubigeo' => $ubigeo_partida,
                'llegada_ubigeo' => $ubigeo_llegada,
                'llegada_direccion' => $direccion_llegada,
                'partida_direccion' => $direccion_partida,
                'estatus_id' => $estatus_id
            );
            $result = $this->guia_model->crearRemision($remision);
            $producto_id_s = $this->input->post('cod');
            $detalle_xml = array();
            if (is_array($id_remision_producto)) {
                for ($i = 0; $i < count($id_remision_producto); $i++) {
                    $detalle_xml[] = array(
                        'CODIGO_PRODUCTO' => $codigo_producto[$i],
                        'DESCRIPCION' => $descripcion[$i],
                        'UNIDAD_MEDIDA' => $unidad_medida[$i],
                        'CANTIDAD' => $cantidad[$i],
                    );
                    $this->guia_model->updateRemisionIdInRemisionProducto($result, $id_remision_producto[$i]);
                }
            }
            $cabecera = array(
                'SERIE' => $serie,
                'SECUENCIA' => $numero,
                'FECHA_DOCUMENTO' => $fecha_remision,
                'HORA_DOCUMENTO' => $hora_remision,
                'COD_TIPO_DOCUMENTO' => '09',
                'NOTA' => $observacion,
                //
                'NRO_DOCUMENTO_CLIENTE' => $destinatario_identidad_numero,
                'RAZON_SOCIAL_CLIENTE' => $destinatario_nombre,
                'TIPO_DOCUMENTO_CLIENTE' => $destinatario_identidad_tipo,
                //
                'NRO_DOCUMENTO_EMPRESA' => $datosEmpresa['ruc'],
                'TIPO_DOCUMENTO_EMPRESA' => $datosEmpresa['tipo_doc'],
                'RAZON_SOCIAL_EMPRESA' => $datosEmpresa['razon_social'],
                //
                'CODMOTIVO_TRASLADO' => $motivo_traslado_codigo,
                'MOTIVO_TRASLADO' => $motivo_traslado_descripcion,
                'PESO' => $peso_bruto,
                'CODTIPO_TRANSPORTISTA' => $modalidad_transporte_codigo,
                'FECHA_INICIO_TRASLADO' => $fecha_inicio_traslado,
                'TIPO_DOCUMENTO_TRANSPORTE' => '6',
                'NRO_DOCUMENTO_TRANSPORTE' => $transportista_ruc,
                'RAZON_SOCIAL_TRANSPORTE' => $transportista_nombre,
                //
                'CHOFER_LICENCIA' => $conductor_licencia,
                'CHOFER_DOCUMENTO' => $conductor_identidad_numero,
                //
                'UBIGEO_DESTINO' => $ubigeo_llegada,
                'DIR_DESTINO' => $direccion_llegada,
                'UBIGEO_PARTIDA' => $ubigeo_partida,
                'DIR_PARTIDA' => $direccion_partida,
                //===================CLAVES SOL EMISOR====================//
                'EMISOR_RUC' => $datosEmpresa['ruc'],
                'EMISOR_USUARIO_SOL' => $datosEmpresa['usuariosol'],
                'EMISOR_PASS_SOL' => $datosEmpresa['clavesol']
            );
            $url_base = dirname(dirname(__DIR__)) . '/archivos_xml_sunat/';
            $content_folder_xml = 'cpe_xml/';
            $content_firmas = 'certificados/';
            $archivo = $datosEmpresa['ruc'] . '-09-' . $serie . '-' . $numero;
            $ruta = $url_base . $content_folder_xml . $datosEmpresa['tipoproceso'] . '/' . $datosEmpresa['ruc'] . "/" . $archivo;
            $ruta_cdr = $url_base . $content_folder_xml . $datosEmpresa['tipoproceso'] . '/' . $datosEmpresa['ruc'] . "/";
            $ruta_firma = $url_base . $content_firmas . $datosEmpresa['tipoproceso'] . '/' . $datosEmpresa['ruc'] . '.pfx';
            if ($datosEmpresa['tipoproceso'] == 'produccion') {
                $ruta_ws = 'https://e-guiaremision.sunat.gob.pe/ol-ti-itemision-guia-gem/billService';
            } else if ($datosEmpresa['tipoproceso'] == 'beta') {
                $datosEmpresa['firma_password'] = '123456';
                $ruta_ws = 'https://e-beta.sunat.gob.pe/ol-ti-itemision-guia-gem-beta/billService';
                $ruta_firma = $url_base . $content_firmas . 'beta/demo.pfx';
            } else if ($datosEmpresa['tipoproceso'] == 'nubefact') {
                $datosEmpresa['firma_password'] = '123456';
                $ruta_firma = $url_base . $content_firmas . 'beta/demo.pfx';
                $ruta_ws = 'https://demo-ose.nubefact.com/ol-ti-itcpe/billService?wsdl';
            }
            set_time_limit(440);
            $rutas = array(
                'nombre_archivo' => $archivo,
                'ruta_xml' => $ruta,
                'ruta_cdr' => $ruta_cdr,
                'ruta_firma' => $ruta_firma,
                'pass_firma' => $datosEmpresa['firma_password'],
                'ruta_ws' => $ruta_ws,
            );
            $resp = $procesarcomprobante->procesar_guia_de_remision($cabecera, $detalle_xml, $rutas);
            redirect('remision', 'refresh');
        } else {
            redirect('auth/login', 'refresh');
        }
    }

    public function postservicio() {
        if ($this->ion_auth->logged_in()) {
            //$cot = $this->producto_model->getSerieCotizacion();

            $cotizacion = array(
                'id' => '',
                'fecha' => date('Y-m-d'),
                'cliente_id' => $this->input->post("cliente_id"),
                'moneda' => $this->input->post("moneda"),
                'montototal' => $this->input->post("montototal"),
                'users_id' => $this->ion_auth->user()->row()->id,
                'created_at' => date('Y-m-d H:i:s'),
                'estado' => '1',
                'tipo_cotizacion' => 'SERVICIO'
            );

            $result = $this->producto_model->crearCotizacion($cotizacion);
            $servicio_id_s = $this->input->post('servicio_id');
            $referencia = $this->input->post('referencia');

            // $editordata = 'sss';

            $equipoTitulo = $this->input->post('equipoTitulo');
            $equipoDetalle = $this->input->post('equipoDetalle');
            $MarcaTitulo = $this->input->post('MarcaTitulo');
            $MarcaDetalle = $this->input->post('MarcaDetalle');
            $ModeloTitulo = $this->input->post('ModeloTitulo');
            $ModeloDetalle = $this->input->post('ModeloDetalle');
            $NroSerieTitulo = $this->input->post('NroSerieTitulo');
            $NroSerieDetalle = $this->input->post('NroSerieDetalle');
            $CodInvTitulo = $this->input->post('CodInvTitulo');
            $CodInvDetalle = $this->input->post('CodInvDetalle');

            $MantenimientoTitulo = $this->input->post('MantenimientoTitulo');
            $MantenimientoDetalle1 = $this->input->post('MantenimientoDetalle1');
            $MantenimientoDetalle2 = $this->input->post('MantenimientoDetalle2');
            $MantenimientoDetalle3 = $this->input->post('MantenimientoDetalle3');
            $MantenimientoDetalle4 = $this->input->post('MantenimientoDetalle4');
            $MantenimientoDetalle5 = $this->input->post('MantenimientoDetalle5');
            $CambioPartesTitulo = $this->input->post('CambioPartesTitulo');
            $CambioPartesDetalle = $this->input->post('CambioPartesDetalle');
            $VerificacionTitulo = $this->input->post('VerificacionTitulo');
            $VerificacionDetalle = $this->input->post('VerificacionDetalle');
            $TerminosComercialesTitulo = $this->input->post('TerminosComercialesTitulo');
            $TerminosComercialesDetalle1 = $this->input->post('TerminosComercialesDetalle1');
            $TerminosComercialesDetalle2 = $this->input->post('TerminosComercialesDetalle2');
            $TerminosComercialesDetalle3 = $this->input->post('TerminosComercialesDetalle3');



            $co = array(
                'id' => '',
                'cotizacion_id' => $result,
                'servicio_id' => $servicio_id_s,
                'referencia' => $referencia,
                'equipoTitulo' => $equipoTitulo,
                'equipoDetalle' => $equipoDetalle,
                'MarcaTitulo' => $MarcaTitulo,
                'MarcaDetalle' => $MarcaDetalle,
                'ModeloTitulo' => $ModeloTitulo,
                'ModeloDetalle' => $ModeloDetalle,
                'NroSerieTitulo' => $NroSerieTitulo,
                'NroSerieDetalle' => $NroSerieDetalle,
                'CodInvTitulo' => $CodInvTitulo,
                'CodInvDetalle' => $CodInvDetalle,
                'MantenimientoTitulo' => $MantenimientoTitulo,
                'MantenimientoDetalle1' => $MantenimientoDetalle1,
                'MantenimientoDetalle2' => $MantenimientoDetalle2,
                'MantenimientoDetalle3' => $MantenimientoDetalle3,
                'MantenimientoDetalle4' => $MantenimientoDetalle4,
                'MantenimientoDetalle5' => $MantenimientoDetalle5,
                'CambioPartesTitulo' => $CambioPartesTitulo,
                'CambioPartesDetalle' => $CambioPartesDetalle,
                'VerificacionTitulo' => $VerificacionTitulo,
                'VerificacionDetalle' => $VerificacionDetalle,
                'TerminosComercialesTitulo' => $TerminosComercialesTitulo,
                'TerminosComercialesDetalle1' => $TerminosComercialesDetalle1,
                'TerminosComercialesDetalle2' => $TerminosComercialesDetalle2,
                'TerminosComercialesDetalle3' => $TerminosComercialesDetalle3,
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->venta_model->crearCotizacionServicio($co);

            redirect('cotizacion/servicio', 'refresh');
        } else {
            redirect('auth/login', 'refresh');
        }
    }

    public function update($id) {
        if ($this->ion_auth->logged_in()) {
            $moneda = $this->input->post("moneda");
            $cliente_id = $this->input->post("cliente_id");
            $diseno = $this->input->post("diseno");
            if ($diseno == "SI") {
                $diseno = 1;
            } else {
                $diseno = 0;
            }
            $montodiseno = $this->input->post("montodiseno");
            $acabado = $this->input->post("acabado");
            $precioacabado = $this->input->post("precioacabado");
            if ($precioacabado == "") {
                $precioacabado = 0;
            }
            $cantidadacabado = $this->input->post("cantidadacabado");
            $montoacabado = $this->input->post("montoacabado");
            $montototal = $this->input->post("montototal");
            $totalpagar = $this->input->post("totalpagar");
            $users_id = $this->ion_auth->user()->row()->id;
            $descuento = $this->input->post("descuento");
            $autorizante_id = $this->input->post("autorizante_id");
            if ($autorizante_id == "") {
                $autorizante_id = 0;
            }
            $result = $this->producto_model->updateCotizacion2($id, $moneda, $cliente_id, $diseno, $montodiseno, $acabado, $precioacabado, $cantidadacabado, $montoacabado, $autorizante_id, $descuento, $montototal, $totalpagar, $users_id);

            $producto_id_s = $this->input->post('producto_id');
            // $tipo_prod_s = $this->input->post('tipo_prod');
            $ancho_s = $this->input->post('ancho');
            $largo_s = $this->input->post('largo');
            $area_s = $this->input->post('area');
            $precio_unidad_s = $this->input->post('precio_unidad');
            $cantidad_s = $this->input->post('cantidad');
            $total_s = $this->input->post('total');

            if ($producto_id_s != 0) {
                for ($x = 0; $x < sizeof($producto_id_s); $x++) {
                    $ci[$x] = array(
                        'cotizacion_id' => $id,
                        'producto_id' => $producto_id_s[$x],
                        'tipo' => 0,
                        'precioproducto' => $precio_unidad_s[$x],
                        'cantidad' => $cantidad_s[$x],
                        'largo' => $largo_s[$x],
                        'ancho' => $ancho_s[$x],
                        'area' => $area_s[$x],
                        'montoproducto' => $total_s[$x],
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    //$this->producto_model->restarStock($producto_id_s[$x], $cantidad_s[$x]);
                }
                $this->venta_model->crearCotizacionProducto($ci);
            }
            redirect('cotizacion', 'refresh');
        } else {
            redirect('auth/login', 'refresh');
        }
    }

    public function crearAcabado() {
        if ($this->ion_auth->logged_in()) {
            $a = array(
                'id' => '',
                'nombre' => $this->input->post('nombre'),
                'precio' => $this->input->post('precio'),
                'created_at' => date('Y-m-d H:i:s'),
                'estado' => '1',
            );
            $result = $this->producto_model->crearAcabado($a);
            echo json_encode($result);
            exit;
        } else {
            redirect('auth/login', 'refresh');
        }
    }

    public function deleteCotizacion_Producto($idC, $idP, $date, $time) {
        if ($this->ion_auth->logged_in()) {
            $dateFull = $date . " " . $time;
            $this->venta_model->deleteCotizacion_Producto($idC, $idP, $dateFull);
            $this->edit($idC);
        } else {
            redirect('auth/login', 'refresh');
        }
    }

    public function subir_orden() {
        if ($this->ion_auth->logged_in()) {
            $id_remision = $this->input->post('id');

            if ($_FILES['documento']['name'] != NULL) {
                //esta configuración es pra ver si la imágen cuenta con las caracteriticas necesarias
                $config['upload_path'] = './documentos/remisiones/ordenes';
                $config['allowed_types'] = 'jpg|jpeg|png|pdf';
                $config['max_size'] = '10000';
                // $config['max_width'] = '512';
                // $config['max_height'] = '512';
                //esta pare simplemente recibe la configuración echa anteriormente
                $this->load->library('upload', $config);

                //SI LA IMAGEN FALLA AL SUBIR MOSTRAMOS EL ERROR EN LA VISTA UPLOAD_VIEW
                if (!$this->upload->do_upload('documento')) {
                    $error = array('error' => $this->upload->display_errors());
                    $status = TRUE;
                    $this->index();
                }//end of if
                else {
                    //EN OTRO CASO SUBIMOS LA IMAGEN, CREAMOS LA MINIATURA Y HACEMOS
                    //ENVÍAMOS LOS DATOS AL MODELO PARA HACER LA INSERCIÓN
                    $file_info = $this->upload->data();
                    $data = array('upload_data' => $this->upload->data());
                    $remision['documento_orden'] = $file_info['file_name'];
                    $remision['correlativo'] = $this->input->post('correlativo');
                    $this->guia_model->actualizar($id_remision, $remision);
                }//end of else
            }//end of if
            redirect('remision', 'refresh');
        }//end if
        else {
            redirect('auth/login', 'refresh');
        }//end else
    }

//end subir_orden

    public function subir_documento_conformidad() {
        if ($this->ion_auth->logged_in()) {
            $id_remision = $this->input->post('id');

            if ($_FILES['documento']['name'] != NULL) {
                //esta configuración es pra ver si la imágen cuenta con las caracteriticas necesarias
                $config['upload_path'] = './documentos/remisiones/documentos_conformidad';
                $config['allowed_types'] = 'pdf';
                $config['max_size'] = '10000';
                // $config['max_width'] = '512';
                // $config['max_height'] = '512';
                //esta pare simplemente recibe la configuración echa anteriormente
                $this->load->library('upload', $config);

                //SI LA IMAGEN FALLA AL SUBIR MOSTRAMOS EL ERROR EN LA VISTA UPLOAD_VIEW
                if (!$this->upload->do_upload('documento')) {
                    $error = array('error' => $this->upload->display_errors());
                    $this->index();
                    // print("<pre>".print_r($error,true)."</pre>");
                }//end of if
                else {
                    //EN OTRO CASO SUBIMOS LA IMAGEN, CREAMOS LA MINIATURA Y HACEMOS
                    //ENVÍAMOS LOS DATOS AL MODELO PARA HACER LA INSERCIÓN
                    $file_info = $this->upload->data();
                    $data = array('upload_data' => $this->upload->data());
                    $remision['documento_conformidad'] = $file_info['file_name'];
                    $this->guia_model->actualizar($id_remision, $remision);
                }//end of else
            }//end of if

            redirect('remision', 'refresh');
        }//end if
        else {
            redirect('auth/login', 'refresh');
        }//end else
    }

//end subir_documento_conformidad
}
