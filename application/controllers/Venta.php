<?php

defined('BASEPATH') or exit('No direct script access allowed');
ini_set('max_execution_time', 0);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Venta extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('url', 'language'));

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->config->load('qr_code');
        $this->load->library('ci_qr_code');
        $this->load->model('Cliente_model');
    }

    public function numero()
    {
        $tipo = $this->input->post('tipo');
        $serie = $this->input->post('serie');
        //$tipo='boleta';
        //$serie='F001';
        $rs = $this->venta_model->getCorrelativo($tipo, $serie);
        echo json_encode(array(
            'success' => true,
            'serie' => $serie,
            'numero' => $rs->numero
        ));
    }

    public function descargarCDR($serie, $numero, $venta_id)
    {
        $data = $_POST;
        $this->load->library('pdfdos');
        $pdf = $this->pdfdos;
        $nn = (int) $numero;
        $n = 6 - strlen($nn);
        $num = "";
        for ($i = 0; $i < $n; $i++) {
            $num .= "0";
        }
        $num .= (int) $numero;
        $r = "0";
        $prods = $this->venta_model->getProductosVenta($venta_id);
        $data['serie'] = $serie;
        $data['venta_id'] = $venta_id;
        $data['numero'] = $num;
        if (substr($serie, 0, 1) == "F") {
            $r = "01";
        } else {
            $r = "03";
        }
        $file_name = "R-20546439268-" . $r . "-" . $data["serie"] . "-" . str_pad($data["numero"], 8, "0", STR_PAD_LEFT) . ".XML";
        $ruta = $this->config->item('ruta_base') . "archivos_xml_sunat/cpe_xml/produccion/20546439268/" . $file_name;
        header("Content-Disposition: attachment; filename=" . $file_name);
        header("Content-Type: application/octet-stream");
        // header ("Content-Length: ".filesize($ruta));
        readfile($ruta);
    }

    public function descargarXML($serie, $numero, $venta_id)
    {
        $data = $_POST;
        $this->load->library('pdfdos');
        $pdf = $this->pdfdos;
        $num = "";
        $nn = (int) $numero;
        $n = 6 - strlen($nn);
        for ($i = 0; $i < $n; $i++) {
            $num .= "0";
        }
        $num .= (int) $numero;
        $r = "0";
        $prods = $this->venta_model->getProductosVenta($venta_id);
        $data['serie'] = $serie;
        $data['venta_id'] = $venta_id;
        $data['numero'] = $num;
        if (substr($serie, 0, 1) == "F") {
            $r = "01";
        } else {
            $r = "03";
        }
        $file_name = "20546439268-" . $r . "-" . $data["serie"] . "-" . str_pad($data["numero"], 8, "0", STR_PAD_LEFT) . ".XML";
        $ruta = $this->config->item('ruta_base') . "archivos_xml_sunat/cpe_xml/produccion/20546439268/" . $file_name;
        header("Content-Disposition: attachment; filename=" . $file_name);
        header("Content-Type: application/octet-stream");
        // header ("Content-Length: ".filesize($ruta));
        readfile($ruta);
    }

    public function enviar()
    {
        $data = $_POST;
        $this->load->library('pdfdos');
        $pdf = $this->pdfdos;
        $config['protocol'] = 'mail';
        $config = array(
            'protocol' => 'mail',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => 465,
            'smtp_user' => 'admin@tecnologiamedicacorporation.net',
            'smtp_pass' => 'josecarlos10',
            'charset' => 'iso-8859-1',
            'newline' => '\r\n'
        );

        $this->load->library('email', $config);
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $this->email->from('admin@tecnologiamedicacorporation.net', 'TMC E.I.R.L.');
        $this->email->to($data["correo"]);
        $this->email->subject("ENVIO DE COMPROBANTE ELECTRONICO");
        $this->email->message("Se envía los comprobantes electrónicos solicitados.\n Hasta Pronto.");
        $r = "0";
        $venta_id = $data["venta_id"];
        $prods = $this->venta_model->getProductosVenta($venta_id);
        if (substr($data["serie"], 0, 1) == "F") {
            $r = "01";
            $data['comprobante'] = "FACTURA";
            $data['prods'] = $prods;
            $data['ayuda'] = $this->config->item('ruta_base') . 'archivos_xml_sunat/';
            $datos = $this->venta_model->getDatosVentaFactura($venta_id);
            $qr_code_config = array();
            $qr_code_config['cacheable'] = $this->config->item('cacheable');
            $qr_code_config['cachedir'] = $this->config->item('cachedir');
            $qr_code_config['ruta_base'] = $this->config->item('ruta_base');
            $qr_code_config['errorlog'] = $this->config->item('errorlog');
            $qr_code_config['ciqrcodelib'] = $this->config->item('ciqrcodelib');
            $qr_code_config['quality'] = $this->config->item('quality');
            $qr_code_config['size'] = $this->config->item('size');
            $qr_code_config['black'] = $this->config->item('black');
            $qr_code_config['white'] = $this->config->item('white');
            $this->ci_qr_code->initialize($qr_code_config);
            $image_name = "qr.png";
            // create user content
            $codeContents = $datos->serie . '-';
            $codeContents .= $datos->numero . "||";
            $codeContents .= $datos->docum . "||";
            $codeContents .= $datos->created_at . "||";
            $codeContents .= $datos->hash;
            $params['data'] = $codeContents;
            $params['level'] = 'H';
            $params['size'] = 5;
            $params['savename'] = $this->config->item('ruta_base') . 'archivos_xml_sunat/' . $image_name;
            $this->ci_qr_code->generate($params);
            $data['url'] = $this->config->item('ruta_base') . 'archivos_xml_sunat/' . $image_name;
            $data['logo'] = $this->config->item('ruta_base') . 'archivos_xml_sunat/logodr.png';
            $pdf->mostrar($data, $datos);
        } else {
            $r = "03";
            $data['comprobante'] = "BOLETA";
            $data['prods'] = $prods;
            $data['ayuda'] = $this->config->item('ruta_base') . 'archivos_xml_sunat/';
            $datos = $this->venta_model->getDatosVentaBoleta($venta_id);
            $qr_code_config = array();
            $qr_code_config['cacheable'] = $this->config->item('cacheable');
            $qr_code_config['cachedir'] = $this->config->item('cachedir');
            $qr_code_config['ruta_base'] = $this->config->item('ruta_base');
            $qr_code_config['errorlog'] = $this->config->item('errorlog');
            $qr_code_config['ciqrcodelib'] = $this->config->item('ciqrcodelib');
            $qr_code_config['quality'] = $this->config->item('quality');
            $qr_code_config['size'] = $this->config->item('size');
            $qr_code_config['black'] = $this->config->item('black');
            $qr_code_config['white'] = $this->config->item('white');
            $this->ci_qr_code->initialize($qr_code_config);
            $image_name = "qr.png";
            // create user content
            $codeContents = $datos->serie . '-';
            $codeContents .= $datos->numero . "||";
            $codeContents .= $datos->docum . "||";
            $codeContents .= $datos->created_at . "||";
            $codeContents .= $datos->hash;
            $params['data'] = $codeContents;
            $params['level'] = 'H';
            $params['size'] = 5;
            $params['savename'] = $this->config->item('ruta_base') . 'archivos_xml_sunat/' . $image_name;
            $this->ci_qr_code->generate($params);
            $data['url'] = $this->config->item('ruta_base') . 'archivos_xml_sunat/' . $image_name;
            $data['logo'] = $this->config->item('ruta_base') . 'archivos_xml_sunat/logodr.png';
            $pdf->mostrar($data, $datos);
        }
        $this->email->attach($this->config->item('ruta_base') . "/archivos_xml_sunat/cpe_xml/produccion/20546439268/20546439268-" . $r . "-" . $data["serie"] . "-" . str_pad($data["numero"], 8, "0", STR_PAD_LEFT) . ".XML");
        $this->email->attach($this->config->item('ruta_base') . "/archivos_xml_sunat/comprobante.pdf");
        if ($this->email->send()) {
            echo "1";
        } else {
            echo "0";
            //var_dump($this->email->print_debugger());
        }
    }

    public function errors()
    {
        $errors = $this->venta_model->getErrors();
        foreach ($errors->result() as $e) {
            echo json_encode($e);
        }
        exit;
    }

    public function nota_credito()
    {
        if ($this->ion_auth->logged_in()) {
            $data = array('ventas' => $this->venta_model->getNotasCredito());
            $data['data_notas_credito'] = $this->venta_model->getAllNotasCredito();
            $this->load->view('/layout/top');
            $this->load->view('menu/venta/nota_credito', $data);
            $this->load->view('/layout/bottom');
        } else {
            redirect('auth/login', 'refresh');
        }
    }

    public function nota_debito()
    {
        if ($this->ion_auth->logged_in()) {
            $data = array('ventas' => $this->venta_model->getNotasDebito());
            $this->load->view('/layout/top');
            $this->load->view('menu/venta/nota_debito', $data);
            $this->load->view('/layout/bottom');
        } else {
            redirect('auth/login', 'refresh');
        }
    }

    public function create_nota_credito($id)
    {

        if ($this->ion_auth->logged_in()) {
            // $data = array('ventas' => $this->venta_model->getNotasCredito());
            //$data['data_notas_credito'] = $this->venta_model->getAllNotasCredito();
            $data['prods'] = $this->producto_model->getProductosComprobante();
            $data['numeros'] = $this->venta_model->getUltimoNumeroComprobante()->result();
            $data['data_venta'] = $this->venta_model->getVentaById($id);
            $data['detalle_venta'] = $this->venta_model->getDetalleVentaById($id);
            $data['id'] = $id;
            //$data['factura_nota_credito']= $this->venta_model->getFacturaNotaCreditoById($id);
            // print_r($data['detalle_venta']);
            //die;
            $this->load->view('/layout/top');
            $this->load->view('menu/venta/create_nota_credito', $data);
            $this->load->view('/layout/bottom');
        } else {
            redirect('auth/login', 'refresh');
        }
    }

    /**
     * Revisar si la factura actual está aceptada en el SUNAT
     */
    public function revisarEstadoSunat()
    {
        $parameters = $this->input->post();
        $curl = curl_init();
        $fields = [
            'numero_ruc_emisor' => $parameters['numero_ruc_emisor'] ?? '',
            'codigo_tipo_documento' => $parameters['codigo_tipo_documento'] ?? '',
            'serie_documento' => $parameters['serie_documento'] ?? '',
            'numero_documento' => $parameters['numero_documento'] ?? '',
            'fecha_de_emision' => $parameters['fecha_de_emision'] ?? '',
            'total' => $parameters['total'] ?? '',
        ];


        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://consulta.api-peru.com/api/cpe",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($fields),
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer 2e053151cf6d7efe3c2f2bfaa04484377d64fed0f17cd5ce01899165df8335a7",
                "Content-Type: application/json"
            ),
        ));

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(curl_exec($curl))
            ->_display();

        exit();
    }


    public function EstadoSunat()
    {

        // If there are data session, render page
        if ($this->ion_auth->logged_in()) {

            $tipo = $this->input->post('tipo');
            $estado = $this->input->post('estado');
            $id = $this->input->post('id');

            switch ($tipo) {
                case "01":
                    $data = $this->venta_model->updateEstadoFacturaSunat($id, $estado);
                    break;
                case "03":
                    $data = $this->venta_model->updateEstadoBoletaSunat($id, $estado);
                    break;
            }

            echo json_encode($data);
        } else {
            // Redirect to login
            redirect('auth/login', 'refresh');
        }
    }
    public function consulta_sunat()
    {
        $parameters = $this->input->post();
        $data       = $this->venta_model->getDocumentFromNumber($parameters['num_doc'], $parameters['isDni']);
        $curl       = curl_init();
        $url        = "https://consulta.api-peru.com/api/ruc/" . $parameters['num_doc'];
        $withData   = false;
        if (null !== $data) {
            $withData = true;
        }
        if ($parameters['isDni'] === 'true' && !$withData) {
            $url = "http://consulta.api-peru.com/api/dni/" . $parameters['num_doc'];

            if ($parameters['num_doc'] === '00000000') {
                $withData = true;
                $data = (object) [
                    'data' => [
                        'apellido_materno' => 'VARIOS',
                        'apellido_paterno' => '',
                        'codigo_verificacion' => '1',
                        'fecha_nacimiento' => null,
                        'nombre_completo' => 'CLIENTES VARIOS',
                        'nombres' => 'CLIENTES',
                        'numero' => '00000000',
                        "sexo" => null,
                    ],
                    'success' => true
                ];
            }
        }
        $headers = [
            "Content-Type: application/json"
        ];
        if ($parameters['isDni'] === 'true') {
            $headers[] = "Authorization: Bearer 2e053151cf6d7efe3c2f2bfaa04484377d64fed0f17cd5ce01899165df8335a7";
        } else {
            $headers[] = "Authorization: Bearer 2e053151cf6d7efe3c2f2bfaa04484377d64fed0f17cd5ce01899165df8335a7";
        }
        if (!$withData) {
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => $headers,
            ));

            $data = json_decode(curl_exec($curl));
        }
        $this->output
            ->set_status_header(($data->success ?? false) === true ? 200 : 428)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data))
            ->_display();
        exit();
    }
    public function index()
    {
        if ($this->ion_auth->logged_in()) {
            $series['factura']      = $this->venta_model->getSeriesData('factura');
            $series['boleta']       = $this->venta_model->getSeriesData('boleta');
            $data['ventas']         = $this->venta_model->getVentas(false);
            $data['seriesNumbers']  = $series;
            $this->load->view('/layout/top');
            $this->load->view('menu/venta/index', $data);
            $this->load->view('/layout/bottom');
        } else {
            redirect('auth/login', 'refresh');
        }
    } # end index
    public function getDataVenta()
    {
        $id                             = $_POST['id'];
        $data['data_venta']             = $this->venta_model->getVentaById($id);
        $data['factura_nota_credito']   = $this->venta_model->getFacturaNotaCreditoById($id);
        echo json_encode($data);
    }
    public function registraNotaDeCredito()
    {
        $data_nota_credito                  = $_POST['dnc'];
        $data_nota_credito['created_at']    = date('Y-m-d H:i:s');
        $data_nota_credito['updated_at']    = null;
        unset($data_nota_credito['id']);
        $data_nota_credito['id'] = $this->venta_model->registrarNotaCredito($data_nota_credito);
        echo json_encode($data_nota_credito);
    }
    public function generarNotaCreditoPdf($id_factura_nota_credito)
    {
        echo $id_factura_nota_credito;
    }
    public function create()
    {
        if ($this->ion_auth->logged_in()) {
            $data['prods']                      = $this->producto_model->getProductosComprobante();
            $data['numeros']                    = $this->venta_model->getUltimoNumeroComprobante();
            $data['servicios']                  = $this->producto_model->getServiciosActivos();
            $data['consulta_guias_disponibles'] = $this->guia_model->con_guias_disponibles();
            $data['clientes']                   = $this->venta_model->getClientes();
            $data['all_direcciones']            = $this->venta_model->getAllDirecciones();
            $this->load->view('menu/venta/create', $data);
        } else {
            redirect('auth/login', 'refresh');
        }
    }

    public function registrarCliente()
    {
        $data_cliente               = $_POST['df'];
        $data_cliente['segmento']   = '1'; # ? que es?
        $data_cliente['estado']     = '1';
        $data_cliente['created_at'] = date('Y-m-d H:i:s');
        $data_cliente['id']         = $this->Cliente_model->agregar($data_cliente);
        # registrar cliente direccion
        $data_cliente_direccion['id_cliente']   = $data_cliente['id'];
        $data_cliente_direccion['ubigeo']       = 0;
        $data_cliente_direccion['direccion']    = '';
        $data_cliente_direccion['telefono']     = '';
        $data_cliente_direccion['email']        = '';
        $this->Cliente_model->agregar_cliente_direccion($data_cliente_direccion);
        echo json_encode($data_cliente);
    }

    public function post()
    {
        try {
            //print_r($_POST); exit();
            $this->load->library('../controllers/fe/validaciondedatos');
            $validacion = $this->validaciondedatos;
            $data = $_POST;
            $d = DateTime::createFromFormat('Y-m-d', $data['fecha_comprobante']);
            if (!($d && $d->format('Y-m-d') === $data['fecha_comprobante'])) {
                throw new Exception('Fecha no válida');
            }

            $items_detalle = json_decode($data['datadetalle'], true);
            $productos = json_decode($this->input->post('datadetalle'));

            $oEmpresa = $this->getEmpresa();
            $ruc_emisor = $oEmpresa->getRuc();
            $emisor['ruc'] = $oEmpresa->getRuc();
            $emisor['tipo_doc'] = $oEmpresa->getTipoDoc();
            $emisor['nom_comercial'] = $oEmpresa->getNombreComercial();
            $emisor['razon_social'] = $oEmpresa->getRazonSocial();
            $emisor['codigo_ubigeo'] = $oEmpresa->getCodigoUbigeo();
            $emisor['direccion'] = $oEmpresa->getDireccion();
            $emisor['direccion_departamento'] = $oEmpresa->getDepartamento();
            $emisor['direccion_provincia'] = $oEmpresa->getProvincia();
            $emisor['direccion_distrito'] = $oEmpresa->getDistrito();
            $emisor['direccion_codigopais'] = $oEmpresa->getCodigoPais();
            $emisor['usuariosol'] = $oEmpresa->getUsuarioSol();
            $emisor['clavesol'] = $oEmpresa->getClaveSol();
            $tipodeproceso = $oEmpresa->getTipoProceso();
            $emisor['tipoproceso'] = $tipodeproceso;
            $pass_firma = $oEmpresa->getFirmaPassword();

            $url_base = dirname(dirname(__DIR__)) . '/archivos_xml_sunat/';

            $content_folder_xml = 'cpe_xml/';
            $content_firmas = 'certificados/';
            $archivo = $ruc_emisor . '-' . $data['tipo_comprobante'] . '-' . $data['serie_comprobante'] . '-' . $data['numero_comprobante'];
            set_time_limit(440);

            $ruta = $url_base . $content_folder_xml . $tipodeproceso . '/' . $ruc_emisor . "/" . $archivo;
            $ruta_cdr = $url_base . $content_folder_xml . $tipodeproceso . '/' . $ruc_emisor . "/";
            $ruta_firma = $url_base . $content_firmas . $tipodeproceso . '/' . $ruc_emisor . '.pfx';
            if (!file_exists($url_base . $content_folder_xml . $tipodeproceso)) {
                mkdir($url_base . $content_folder_xml . $tipodeproceso);
            }
            if (!file_exists($url_base . $content_folder_xml . $tipodeproceso . '/' . $ruc_emisor)) {
                mkdir($url_base . $content_folder_xml . $tipodeproceso . '/' . $ruc_emisor);
            }
            if ($tipodeproceso == 'produccion') {
                $ruta_ws = 'https://e-factura.sunat.gob.pe/ol-ti-itcpfegem/billService';
            }
            if ($tipodeproceso == 'homologacion') {
                $ruta_ws = 'https://www.sunat.gob.pe/ol-ti-itcpgem-sqa/billService';
            }
            if ($tipodeproceso == 'beta') {
                $ruta_firma = $url_base . $content_firmas . $tipodeproceso . '/demo.pfx';
                $pass_firma = '123456';
                $ruta_ws = 'https://e-beta.sunat.gob.pe:443/ol-ti-itcpfegem-beta/billService';
            }
            if ($tipodeproceso == 'nubefact') {
                $pass_firma = '123456';
                //$ruta_firma = $url_base . $content_firmas . $datosEmpresa['tipoproceso'] . '/demo.pfx';
                $ruta_ws = 'https://demo-ose.nubefact.com/ol-ti-itcpe/billService?wsdl';
            }
            // $v = array(
            //     'id' => '',
            //     'users_id' => $this->ion_auth->user()->row()->id,
            //     'estado' => '1',
            //     'created_at' => date('Y-m-d H:i:s'),
            //     'metodo_pago' => $data['metodo_pago'],
            //     'correo' => $data['cliente_correo'] ?? '',
            //     'orden_servicio' => $data['orden_servicio'],
            //     'guia_remision' => $data['guia_remision'],
            //     'celular' => $data['cliente_celular'] ?? '',
            //     'tipo_venta' => $data['tipo_venta'],
            //     'total' => $data['txt_total_comprobante'],
            //     'total_gravado' => $data['txt_subtotal_comprobante'],
            //     'cliente_tipo_documento' => $data['cliente_tipodocumento'],
            //     'cliente_numero_documento' => $data['cliente_numerodocumento'],
            //     'cliente_nombre' => $data['cliente_nombre'],
            //     'total_igv' => $data['txt_igv_comprobante'],
            //     'porcentaje_igv' => 18,
            //     'tipo_documento' => $data['tipo_comprobante'],
            //     'codigo_moneda' => $data['codmoneda_comprobante'],
            //     'total_letras' => $data['txt_total_letras'],
            //     'cliente_direccion' => $data['cliente_direccion'],
            //     'cliente_ubigeo' => $data['tarjeta_bonus']
            // );
            if ($data['remision_id'] == 0) {
                $remision_id = null;
            } else {
                $remision_id = $data['remision_id'];
            }
            // echo $remision_id;
            // die;
            $v = array(
                'id' => '',
                'users_id' => $this->ion_auth->user()->row()->id,
                'estado' => '1',
                'created_at' => date('Y-m-d H:i:s'),
                'metodo_pago' => $data['metodo_pago'],
                'correo' => $data['cliente_correo'],
                'orden_servicio' => $data['orden_servicio'],
                'remision_id' => $remision_id,
                'guia_remision' => $data['guia_remision'],
                'celular' => $data['cliente_celular'],
                'tipo_venta' => $data['tipo_venta'],
                'total' => $data['txt_total_comprobante'],
                'total_gravado' => $data['txt_subtotal_comprobante'],
                'cliente_tipo_documento' => $data['cliente_tipodocumento'],
                'cliente_numero_documento' => $data['cliente_numerodocumento'],
                'cliente_nombre' => $data['cliente_nombre'],
                'total_igv' => $data['txt_igv_comprobante'],
                'porcentaje_igv' => 18,
                'tipo_documento' => $data['tipo_comprobante'],
                'codigo_moneda' => $data['codmoneda_comprobante'],
                'total_letras' => $data['txt_total_letras'],
                'cliente_direccion' => $data['cliente_direccion'],
                'cliente_ubigeo' => $data['tarjeta_bonus'],
                'observacion' => $data["observacion_documento"]
            );
            $rutas = array();
            $rutas['nombre_archivo'] = $archivo;
            $rutas['ruta_xml'] = $ruta;
            $rutas['ruta_cdr'] = $ruta_cdr;
            $rutas['ruta_firma'] = $ruta_firma;
            $rutas['pass_firma'] = $pass_firma;
            $rutas['ruta_ws'] = $ruta_ws;

            $data_comprobante = $this->crear_cabecera($emisor, $data);

            $this->load->library('../controllers/fe/procesarcomprobante');
            $procesarcomprobante = $this->procesarcomprobante;

            $tipo_comprobante = $data['tipo_comprobante'];

            if ($tipo_comprobante == "01") {
                $resp = $procesarcomprobante->procesar_factura($data_comprobante, $items_detalle, $rutas);
                if ($resp['hash_cdr'] != '') {
                    $venta_id = $this->venta_model->crearVenta($v);
                    $resp['ruta_cdr'] = site_url() . 'archivos_xml_sunat/cpe_xml/beta/' . $ruc_emisor . '/R-' . $archivo . '.XML';
                    $resp['ruta_pdf'] = site_url() . 'prueba?tipo=facturaA4&id=' . $venta_id;
                    $resp['url_xml'] = '';
                    $resp['venta_id'] = $venta_id;
                    $resp['data_comprobante'] = $data_comprobante;

                    $f = array(
                        'id' => '',
                        'ruc' => $data['cliente_numerodocumento'],
                        'cliente' => $data['cliente_nombre'],
                        'direccion' => $data['cliente_direccion'],
                        'estado' => '1',
                        'venta_id' => $venta_id,
                        'serie' => $data['serie_comprobante'],
                        'numero' => $data['numero_comprobante'],
                        'fecha' => $data['fecha_comprobante'],
                        'vencimiento' => $data['fecha_vencimiento'],
                        'hash' => $resp['hash_cpe'],
                    );
                    $id_factura = $this->venta_model->crearFactura($f);

                    if (isset($data['remision_id'])) {
                        $this->guia_model->upd_estatus($data['remision_id']);
                    }

                    $hoydia = date("d", strtotime(date('Y-m-d')));
                    $hoymes = date("m", strtotime(date('Y-m-d')));
                    $hoyano = date("Y", strtotime(date('Y-m-d')));
                    $x = 0;
                    if ($data['tipo_venta'] == "PRODUCTOS") {
                        foreach ($productos as $item) {
                            $vp[$x] = array(
                                'venta_id' => $venta_id,
                                'producto_id' => $item->txtCODIGO_DET,
                                'servicio_id' => NULL,
                                'texto_ref' => $item->txtREF,
                                'precio_unidad' => $item->txtPRECIO_DET,
                                'cantidad' => $item->txtCANTIDAD_DET,
                                'subtotal' => $item->txtSUB_TOTAL_DET,
                                'total' => $item->txtIGV + $item->txtSUB_TOTAL_DET,
                            );

                            if ($hoydia == '1') {
                                $this->venta_model->verificarPrimeraVentaMes($item->txtCODIGO_DET, $hoymes, $hoyano);
                            }
                            $this->producto_model->restarStock($item->txtCODIGO_DET, $item->txtCANTIDAD_DET);
                            //                        $this->producto_model->cambiarEstado($productoSerie->id);
                            $x = $x + 1;
                        }
                    } else if ($data['tipo_venta'] == "SERVICIOS") {
                        foreach ($productos as $item) {
                            $vp[$x] = array(
                                'venta_id' => $venta_id,
                                'producto_id' => NULL,
                                'servicio_id' => $item->txtSERVICIOID,
                                'texto_ref' => $item->txtREF,
                                'precio_unidad' => $item->txtPRECIO_DET,
                                'cantidad' => $item->txtCANTIDAD_DET,
                                'subtotal' => $item->txtSUB_TOTAL_DET,
                                'total' => $item->txtIGV + $item->txtSUB_TOTAL_DET,
                            );
                            $x = $x + 1;
                        }
                    }
                    $this->venta_model->crearVentaProducto($vp);
                    $resp['numero'] = str_pad(intval($data['numero_comprobante']) + 1, 8, '0', STR_PAD_LEFT);
                    //ENVIO DIRECTO AL API
                    $responseAPI = $this->envio_directo($id_factura, $data['serie_comprobante'], $data['numero_comprobante'], 'factura');
                    if ($responseAPI !== 0) {
                        $rs = json_decode($responseAPI, true);
                        if (is_array($rs)) {
                            if ($rs['success']) {
                                $resp['link_xml'] = isset($rs['links']['xml']) ? $rs['links']['xml'] : null;
                                $resp['link_cdr'] = isset($rs['links']['cdr']) ? $rs['links']['cdr'] : null;
                                $resp['link_pdf'] = isset($rs['links']['pdf']) ? $rs['links']['pdf'] : null;
                                $resp['info_envio'] = "Correctamente enviado al API";
                            }
                        }
                    }
                } else {
                    $e = array(
                        'id' => '',
                        'tipo_comprobante' => 'FACTURA',
                        'serie' => $data['serie_comprobante'],
                        'numero' => str_pad(intval($data['numero_comprobante']), 8, '0', STR_PAD_LEFT),
                        'mensaje' => $resp["mensaje"],
                        'cod_sunat' => $resp["cod_sunat"],
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    $this->venta_model->guardarError($e);
                    $codigo = substr($resp["cod_sunat"], -4);
                    if ($codigo >= 2000 && $codigo <= 3999) {
                        $v['estado'] = '0';
                        $venta_id = $this->venta_model->crearVenta($v);
                        $f = array(
                            'id' => '',
                            'ruc' => $data['cliente_numerodocumento'],
                            'cliente' => $data['cliente_nombre'],
                            'direccion' => $data['cliente_direccion'],
                            'estado' => '0',
                            'venta_id' => $venta_id,
                            'serie' => $data['serie_comprobante'],
                            'numero' => $data['numero_comprobante'],
                            'fecha' => $data['fecha_comprobante'],
                            'hash' => '',
                        );
                        $this->venta_model->crearFactura($f);
                        $x = 0;
                        if ($data['tipo_venta'] == "PRODUCTOS") {
                            foreach ($productos as $item) {
                                $vp[$x] = array(
                                    'venta_id' => $venta_id,
                                    'producto_id' => $item->txtCODIGO_DET,
                                    'precio_unidad' => $item->txtPRECIO_DET,
                                    'cantidad' => $item->txtCANTIDAD_DET,
                                    'subtotal' => $item->txtSUB_TOTAL_DET,
                                    'total' => $item->txtIGV + $item->txtSUB_TOTAL_DET,
                                );
                                $x = $x + 1;
                            }
                        } else if ($data['tipo_venta'] == "SERVICIOS") {
                            foreach ($productos as $item) {
                                $vp[$x] = array(
                                    'venta_id' => $venta_id,
                                    'producto_id' => NULL,
                                    'servicio_id' => $item->txtSERVICIOID,
                                    'texto_ref' => $item->txtREF,
                                    'precio_unidad' => $item->txtPRECIO_DET,
                                    'cantidad' => $item->txtCANTIDAD_DET,
                                    'subtotal' => $item->txtSUB_TOTAL_DET,
                                    'total' => $item->txtIGV + $item->txtSUB_TOTAL_DET,
                                );
                                $x = $x + 1;
                            }
                        }
                        $this->venta_model->crearVentaProducto($vp);
                    }
                }
                echo json_encode($resp);
            }

            if ($tipo_comprobante == "03") {
                $resp = $procesarcomprobante->procesar_boleta($data_comprobante, $items_detalle, $rutas);
                if ($resp['hash_cdr'] != '') {
                    $venta_id = $this->venta_model->crearVenta($v);
                    $resp['venta_id'] = $venta_id;
                    $resp['ruta_cdr'] = site_url() . 'archivos_xml_sunat/cpe_xml/beta/' . $ruc_emisor . '/R-' . $archivo . '.XML';
                    $resp['ruta_pdf'] = site_url() . 'prueba?tipo=boleta&id=' . $venta_id;
                    $resp['url_xml'] = '';
                    $resp['data_comprobante'] = $data_comprobante;

                    $b = array(
                        'id' => '',
                        'dni' => $data['cliente_numerodocumento'],
                        'cliente' => $data['cliente_nombre'],
                        'direccion' => $data['cliente_direccion'],
                        'estado' => '1',
                        'venta_id' => $venta_id,
                        'serie' => $data['serie_comprobante'],
                        'numero' => $data['numero_comprobante'],
                        'fecha' => $data['fecha_comprobante'],
                        'hash' => $resp['hash_cpe'],
                    );
                    $rBoleta = $this->venta_model->crearBoleta($b);
                    $hoydia = date("d", strtotime(date('Y-m-d')));
                    $hoymes = date("m", strtotime(date('Y-m-d')));
                    $hoyano = date("Y", strtotime(date('Y-m-d')));
                    $x = 0;
                    if ($data['tipo_venta'] == "PRODUCTOS") {
                        foreach ($productos as $item) {
                            //                        $productoSerie = $this->producto_model->getProductoSerie($item->txtCODIGO_DET);
                            $vp[$x] = array(
                                'venta_id' => $venta_id,
                                'producto_id' => $item->txtCODIGO_DET,
                                'precio_unidad' => $item->txtPRECIO_DET,
                                'cantidad' => $item->txtCANTIDAD_DET,
                                'subtotal' => $item->txtSUB_TOTAL_DET,
                                'total' => $item->txtIGV + $item->txtSUB_TOTAL_DET,
                            );
                            if ($hoydia == '1') {
                                $this->venta_model->verificarPrimeraVentaMes($item->txtCODIGO_DET, $hoymes, $hoyano);
                            }
                            $this->producto_model->restarStock($item->txtCODIGO_DET, $item->txtCANTIDAD_DET);
                            //                        $this->producto_model->cambiarEstado($productoSerie->id);
                            $x = $x + 1;
                        }
                    } else if ($data['tipo_venta'] == "SERVICIOS") {
                        foreach ($productos as $item) {
                            $vp[$x] = array(
                                'venta_id' => $venta_id,
                                'producto_id' => NULL,
                                'servicio_id' => $item->txtSERVICIOID,
                                'texto_ref' => $item->txtREF,
                                'precio_unidad' => $item->txtPRECIO_DET,
                                'cantidad' => $item->txtCANTIDAD_DET,
                                'subtotal' => $item->txtSUB_TOTAL_DET,
                                'total' => $item->txtIGV + $item->txtSUB_TOTAL_DET,
                            );
                            $x = $x + 1;
                        }
                    }
                    $this->venta_model->crearVentaProducto($vp);
                    $resp['numero'] = str_pad(intval($data['numero_comprobante']) + 1, 8, '0', STR_PAD_LEFT);
                    //ENVIO DIRECTO AL API
                    $responseAPI = $this->envio_directo($rBoleta['id_boleta'], $data['serie_comprobante'], $data['numero_comprobante'], 'boleta');
                    if ($responseAPI !== 0) {
                        $rs = json_decode($responseAPI, true);
                        if (is_array($rs)) {
                            if ($rs['success']) {
                                $resp['link_xml'] = isset($rs['links']['xml']) ? $rs['links']['xml'] : null;
                                $resp['link_cdr'] = isset($rs['links']['cdr']) ? $rs['links']['cdr'] : null;
                                $resp['link_pdf'] = isset($rs['links']['pdf']) ? $rs['links']['pdf'] : null;
                                $resp['info_envio'] = "Correctamente enviado al API";
                            }
                        }
                    }
                } else {
                    $e = array(
                        'id' => '',
                        'tipo_comprobante' => 'BOLETA',
                        'serie' => $data['serie_comprobante'],
                        'numero' => str_pad(intval($data['numero_comprobante']), 8, '0', STR_PAD_LEFT),
                        'mensaje' => $resp["mensaje"],
                        'cod_sunat' => $resp["cod_sunat"],
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    $this->venta_model->guardarError($e);
                    $codigo = substr($resp["cod_sunat"], -4);
                    if ($codigo >= 2000 && $codigo <= 3999) {
                        $v['estado'] = '0';
                        $venta_id = $this->venta_model->crearVenta($v);
                        $b = array(
                            'id' => '',
                            'dni' => $data['cliente_numerodocumento'],
                            'cliente' => $data['cliente_nombre'],
                            'direccion' => $data['cliente_direccion'],
                            'estado' => '0',
                            'venta_id' => $venta_id,
                            'serie' => $data['serie_comprobante'],
                            'numero' => $data['numero_comprobante'],
                            'fecha' => $data['fecha_comprobante'],
                            'hash' => '',
                        );
                        $rBoleta = $this->venta_model->crearBoleta($b);
                        $x = 0;
                        if ($data['tipo_venta'] == "PRODUCTOS") {
                            foreach ($productos as $item) {
                                //                            $productoSerie = $this->producto_model->getProductoSerie($item->txtCODIGO_DET);
                                $vp[$x] = array(
                                    'venta_id' => $venta_id,
                                    'producto_id' => $item->txtCODIGO_DET,
                                    'precio_unidad' => $item->txtPRECIO_DET,
                                    'cantidad' => $item->txtCANTIDAD_DET,
                                    'subtotal' => $item->txtSUB_TOTAL_DET,
                                    'total' => $item->txtIGV + $item->txtSUB_TOTAL_DET,
                                );
                                $x = $x + 1;
                            }
                        } else if ($data['tipo_venta'] == "SERVICIOS") {
                            foreach ($productos as $item) {
                                $vp[$x] = array(
                                    'venta_id' => $venta_id,
                                    'producto_id' => NULL,
                                    'servicio_id' => $item->txtSERVICIOID,
                                    'texto_ref' => $item->txtREF,
                                    'precio_unidad' => $item->txtPRECIO_DET,
                                    'cantidad' => $item->txtCANTIDAD_DET,
                                    'subtotal' => $item->txtSUB_TOTAL_DET,
                                    'total' => $item->txtIGV + $item->txtSUB_TOTAL_DET,
                                );
                                $x = $x + 1;
                            }
                        }
                        $this->venta_model->crearVentaProducto($vp);
                    }
                }
                $data_comprobante['SERIE'] = str_replace('-', '', $data['fecha_comprobante']);
                $data_comprobante['SECUENCIA'] = $rBoleta['correlativo'];
                $_boletas[] = array(
                    'TIPO_COMPROBANTE' => '03',
                    'NRO_COMPROBANTE' => $data_comprobante['NRO_COMPROBANTE'],
                    'NRO_DOCUMENTO' => $data_comprobante['NRO_DOCUMENTO_CLIENTE'],
                    'TIPO_DOCUMENTO' => $data_comprobante['TIPO_DOCUMENTO_CLIENTE'],
                    'STATUS' => '1',
                    'COD_MONEDA' => $data_comprobante['COD_MONEDA'],
                    'TOTAL' => $data_comprobante['TOTAL'],
                    'GRAVADA' => $data_comprobante['TOTAL_GRAVADAS'],
                    'EXONERADO' => 0,
                    'INAFECTO' => 0,
                    'EXPORTACION' => 0,
                    'GRATUITAS' => 0,
                    'MONTO_CARGO_X_ASIG' => 0,
                    'ISC' => 0,
                    'IGV' => $data_comprobante['TOTAL_IGV'],
                    'OTROS' => 0,
                );
                $_rutasResumen = array(
                    'nombre_archivo' => $ruc_emisor . '-RC-' . $data_comprobante['SERIE'] . '-' . $data_comprobante['SECUENCIA'],
                    'ruta_xml' => $url_base . $content_folder_xml . $tipodeproceso . '/' . $ruc_emisor . "/" . $ruc_emisor . '-RC-' . $data_comprobante['SERIE'] . '-' . $data_comprobante['SECUENCIA'],
                    'ruta_cdr' => $url_base . $content_folder_xml . $tipodeproceso . '/' . $ruc_emisor . "/",
                    'ruta_firma' => $ruta_firma,
                    'pass_firma' => $pass_firma,
                    'ruta_ws' => $ruta_ws,
                );
                $resultResumen = $procesarcomprobante->procesar_resumen_boletas($data_comprobante, $_boletas, $_rutasResumen);
                echo json_encode($resp);
            }

            if ($tipo_comprobante == "07") {
                $resp = $procesarcomprobante->procesar_nota_de_credito($data_comprobante, $items_detalle, $rutas);
                if ($resp['respuesta'] == 'ok') {
                    //$resp['ruta_xml'] = 'archivos_xml_sunat/cpe_xml/beta/20534172304/'.$archivo.'.XML';
                    $venta_id = $this->venta_model->crearVenta($v);
                    $nc = array(
                        'id' => '',
                        'num_documento' => $data['cliente_numerodocumento'],
                        'cliente' => $data['cliente_nombre'],
                        'direccion' => $data['cliente_direccion'],
                        'doc_modificado' => $data['nombre_doc_modificado'],
                        'num_doc_modificado' => $data['num_comprobante_modificado'],
                        'motivo' => $data['motivo_nombre_nota_credito'],
                        'estado' => '1',
                        'venta_id' => $venta_id,
                        'serie' => $data['serie_comprobante'],
                        'numero' => $data['numero_comprobante'],
                        'fecha' => $data['fecha_comprobante'],
                        'hash' => $resp['hash_cpe'],
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    $this->venta_model->crearNotaCredito($nc);

                    $x = 0;
                    if ($data['tipo_venta'] == "PRODUCTOS") {
                        foreach ($productos as $item) {
                            //                        $productoSerie = $this->producto_model->getProductoSerie($item->txtCODIGO_DET);
                            $vp[$x] = array(
                                'venta_id' => $venta_id,
                                'producto_id' => $item->txtCODIGO_DET,
                                'precio_unidad' => $item->txtPRECIO_DET,
                                'cantidad' => $item->txtCANTIDAD_DET,
                                'subtotal' => $item->txtSUB_TOTAL_DET,
                                'total' => $item->txtIGV + $item->txtSUB_TOTAL_DET,
                            );
                            $x = $x + 1;
                        }
                    } else if ($data['tipo_venta'] == "SERVICIOS") {
                        foreach ($productos as $item) {
                            $vp[$x] = array(
                                'venta_id' => $venta_id,
                                'producto_id' => NULL,
                                'servicio_id' => $item->txtSERVICIOID,
                                'texto_ref' => $item->txtREF,
                                'precio_unidad' => $item->txtPRECIO_DET,
                                'cantidad' => $item->txtCANTIDAD_DET,
                                'subtotal' => $item->txtSUB_TOTAL_DET,
                                'total' => $item->txtIGV + $item->txtSUB_TOTAL_DET,
                            );
                            $x = $x + 1;
                        }
                    }
                    $this->venta_model->crearVentaProducto($vp);
                    $resp['numero'] = str_pad(intval($data['numero_comprobante']) + 1, 8, '0', STR_PAD_LEFT);

                    $resp['ruta_cdr'] = site_url() . 'archivos_xml_sunat/cpe_xml/beta/' . $ruc_emisor . '/R-' . $archivo . '.XML';
                    $resp['ruta_pdf'] = site_url() . 'prueba?tipo=notacredito&id=' . $venta_id;
                    $resp['url_xml'] = '';
                } else {
                    $e = array(
                        'id' => '',
                        'tipo_comprobante' => 'NOTA CREDITO',
                        'serie' => $data['serie_comprobante'],
                        'numero' => str_pad(intval($data['numero_comprobante']), 8, '0', STR_PAD_LEFT),
                        'mensaje' => $resp["mensaje"],
                        'cod_sunat' => $resp["cod_sunat"],
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    $this->venta_model->guardarError($e);
                    $codigo = substr($resp["cod_sunat"], -4);
                    if ($codigo >= 2000 && $codigo <= 3999) {
                        $v['estado'] = '0';
                        $venta_id = $this->venta_model->crearVenta($v);
                        $nc = array(
                            'id' => '',
                            'num_documento' => $data['cliente_numerodocumento'],
                            'cliente' => $data['cliente_nombre'],
                            'direccion' => $data['cliente_direccion'],
                            'doc_modificado' => $data['nombre_doc_modificado'],
                            'num_doc_modificado' => $data['num_comprobante_modificado'],
                            'motivo' => $data['motivo_nombre_nota_credito'],
                            'estado' => '0',
                            'venta_id' => $venta_id,
                            'serie' => $data['serie_comprobante'],
                            'numero' => $data['numero_comprobante'],
                            'fecha' => $data['fecha_comprobante'],
                            'hash' => '',
                            'created_at' => date('Y-m-d H:i:s')
                        );
                        $this->venta_model->crearNotaCredito($nc);

                        $x = 0;
                        if ($data['tipo_venta'] == "PRODUCTOS") {
                            foreach ($productos as $item) {
                                //                            $productoSerie = $this->producto_model->getProductoSerie($item->txtCODIGO_DET);
                                $vp[$x] = array(
                                    'venta_id' => $venta_id,
                                    'producto_id' => $item->txtCODIGO_DET,
                                    'precio_unidad' => $item->txtPRECIO_DET,
                                    'cantidad' => $item->txtCANTIDAD_DET,
                                    'subtotal' => $item->txtSUB_TOTAL_DET,
                                    'total' => $item->txtIGV + $item->txtSUB_TOTAL_DET,
                                );
                                $x = $x + 1;
                            }
                        } else if ($data['tipo_venta'] == "SERVICIOS") {
                            foreach ($productos as $item) {
                                $vp[$x] = array(
                                    'venta_id' => $venta_id,
                                    'producto_id' => NULL,
                                    'servicio_id' => $item->txtSERVICIOID,
                                    'texto_ref' => $item->txtREF,
                                    'precio_unidad' => $item->txtPRECIO_DET,
                                    'cantidad' => $item->txtCANTIDAD_DET,
                                    'subtotal' => $item->txtSUB_TOTAL_DET,
                                    'total' => $item->txtIGV + $item->txtSUB_TOTAL_DET,
                                );
                                $x = $x + 1;
                            }
                        }
                        $this->venta_model->crearVentaProducto($vp);
                        $resp['numero'] = str_pad(intval($data['numero_comprobante']) + 1, 8, '0', STR_PAD_LEFT);
                    }
                }
                echo json_encode($resp);
            }

            if ($tipo_comprobante == "08") {
                $resp = $procesarcomprobante->procesar_nota_de_debito($data_comprobante, $items_detalle, $rutas);
                if ($resp['respuesta'] == 'ok') {
                    //$resp['ruta_xml'] = 'archivos_xml_sunat/cpe_xml/beta/20534172304/'.$archivo.'.XML';
                    $v = array(
                        'id' => '',
                        'users_id' => $this->ion_auth->user()->row()->id,
                        'estado' => '1',
                        'created_at' => date('Y-m-d H:i:s'),
                        'correo' => $data['cliente_correo'],
                        'orden_servicio' => $data['orden_servicio'],
                        'guia_remision' => $data['guia_remision'],
                        'celular' => $data['cliente_celular'],
                        'tipo_venta' => $data['tipo_venta']
                    );
                    $venta_id = $this->venta_model->crearVenta($v);
                    $nc = array(
                        'id' => '',
                        'num_documento' => $data['cliente_numerodocumento'],
                        'cliente' => $data['cliente_nombre'],
                        'direccion' => $data['cliente_direccion'],
                        'doc_modificado' => $data['nombre_doc_modificado'],
                        'num_doc_modificado' => $data['num_comprobante_modificado'],
                        'motivo' => $data['motivo_nombre_nota_debito'],
                        'estado' => '1',
                        'venta_id' => $venta_id,
                        'serie' => $data['serie_comprobante'],
                        'numero' => $data['numero_comprobante'],
                        'fecha' => $data['fecha_comprobante'],
                        'hash' => $resp['hash_cpe'],
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    $this->venta_model->crearNotaDebito($nc);

                    $x = 0;
                    if ($data['tipo_venta'] == "PRODUCTOS") {
                        foreach ($productos as $item) {
                            //                        $productoSerie = $this->producto_model->getProductoSerie($item->txtCODIGO_DET);
                            $vp[$x] = array(
                                'venta_id' => $venta_id,
                                'producto_id' => $item->txtCODIGO_DET,
                                'precio_unidad' => $item->txtPRECIO_DET,
                                'cantidad' => $item->txtCANTIDAD_DET,
                                'subtotal' => $item->txtSUB_TOTAL_DET,
                                'total' => $item->txtIGV + $item->txtSUB_TOTAL_DET,
                            );
                            $x = $x + 1;
                        }
                    } else if ($data['tipo_venta'] == "SERVICIOS") {
                        foreach ($productos as $item) {
                            $vp[$x] = array(
                                'venta_id' => $venta_id,
                                'producto_id' => NULL,
                                'servicio_id' => $item->txtSERVICIOID,
                                'texto_ref' => $item->txtREF,
                                'precio_unidad' => $item->txtPRECIO_DET,
                                'cantidad' => $item->txtCANTIDAD_DET,
                                'subtotal' => $item->txtSUB_TOTAL_DET,
                                'total' => $item->txtIGV + $item->txtSUB_TOTAL_DET,
                            );
                            $x = $x + 1;
                        }
                    }
                    $this->venta_model->crearVentaProducto($vp);
                    $resp['numero'] = str_pad(intval($data['numero_comprobante']) + 1, 8, '0', STR_PAD_LEFT);

                    $resp['ruta_cdr'] = site_url() . 'archivos_xml_sunat/cpe_xml/beta/20534172304/R-' . $archivo . '.XML';
                    $resp['ruta_pdf'] = site_url() . 'prueba?tipo=notadebito&id=' . $venta_id;
                    $resp['url_xml'] = '';
                } else {
                    $e = array(
                        'id' => '',
                        'tipo_comprobante' => 'NOTA DEBITO',
                        'serie' => $data['serie_comprobante'],
                        'numero' => str_pad(intval($data['numero_comprobante']), 8, '0', STR_PAD_LEFT),
                        'mensaje' => $resp["mensaje"],
                        'cod_sunat' => $resp["cod_sunat"],
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    $this->venta_model->guardarError($e);
                    $codigo = substr($resp["cod_sunat"], -4);
                    if ($codigo >= 2000 && $codigo <= 3999) {
                        $v['estado'] = '0';
                        $venta_id = $this->venta_model->crearVenta($v);
                        $nc = array(
                            'id' => '',
                            'num_documento' => $data['cliente_numerodocumento'],
                            'cliente' => $data['cliente_nombre'],
                            'direccion' => $data['cliente_direccion'],
                            'doc_modificado' => $data['nombre_doc_modificado'],
                            'num_doc_modificado' => $data['num_comprobante_modificado'],
                            'motivo' => $data['motivo_nombre_nota_debito'],
                            'estado' => '0',
                            'venta_id' => $venta_id,
                            'serie' => $data['serie_comprobante'],
                            'numero' => $data['numero_comprobante'],
                            'fecha' => $data['fecha_comprobante'],
                            'hash' => '',
                            'created_at' => date('Y-m-d H:i:s')
                        );
                        $this->venta_model->crearNotaDebito($nc);

                        $x = 0;
                        if ($data['tipo_venta'] == "PRODUCTOS") {
                            foreach ($productos as $item) {
                                //                            $productoSerie = $this->producto_model->getProductoSerie($item->txtCODIGO_DET);
                                $vp[$x] = array(
                                    'venta_id' => $venta_id,
                                    'producto_id' => $item->txtCODIGO_DET,
                                    'precio_unidad' => $item->txtPRECIO_DET,
                                    'cantidad' => $item->txtCANTIDAD_DET,
                                    'subtotal' => $item->txtSUB_TOTAL_DET,
                                    'total' => $item->txtIGV + $item->txtSUB_TOTAL_DET,
                                );
                                $x = $x + 1;
                            }
                        } else if ($data['tipo_venta'] == "SERVICIOS") {
                            foreach ($productos as $item) {
                                $vp[$x] = array(
                                    'venta_id' => $venta_id,
                                    'producto_id' => NULL,
                                    'servicio_id' => $item->txtSERVICIOID,
                                    'texto_ref' => $item->txtREF,
                                    'precio_unidad' => $item->txtPRECIO_DET,
                                    'cantidad' => $item->txtCANTIDAD_DET,
                                    'subtotal' => $item->txtSUB_TOTAL_DET,
                                    'total' => $item->txtIGV + $item->txtSUB_TOTAL_DET,
                                );
                                $x = $x + 1;
                            }
                        }
                        $this->venta_model->crearVentaProducto($vp);
                        $resp['numero'] = str_pad(intval($data['numero_comprobante']) + 1, 8, '0', STR_PAD_LEFT);
                    }
                }
                echo json_encode($resp);
            }
            //lógica de registrar venta, productos y comprobantes aquí
            exit();
        } catch (Exception $exc) {
            echo json_encode(array(
                'error' => true,
                'mensaje' => $exc->getMessage()
            ));
        }
    }
    public function post_nota_credito()
    {
        if ($this->ion_auth->logged_in()) {

            $nc_data = $this->venta_model->getNumeroNotaCreditoFactura();
            $data['numero_comprobante'] = $nc_data->numero;

            $data['data_venta'] = $this->venta_model->getVentaGeneralById($this->input->post('id_nota_credito'));
            $data['data_venta_factura'] = $this->venta_model->getVentaById($this->input->post('id_nota_credito'));

            $v = array(
                'id' => '',
                'users_id' => $this->ion_auth->user()->row()->id,
                'estado' => '1',
                'created_at' => date('Y-m-d H:i:s'),
                'metodo_pago' => $data['data_venta']->metodo_pago,
                'correo' => $data['data_venta']->correo,
                'orden_servicio' => $data['data_venta']->orden_servicio,
                'remision_id' => $data['data_venta']->remision_id,
                'guia_remision' =>  $data['data_venta']->guia_remision,
                'celular' =>  $data['data_venta']->celular,
                'tipo_venta' => $data['data_venta']->tipo_venta,
                'total' => $this->input->post('total_nota_credito'),
                'total_gravado' => $this->input->post('subtotal_nota_credito'),
                'cliente_tipo_documento' =>  $data['data_venta']->cliente_tipo_documento,
                'cliente_numero_documento' =>  $data['data_venta']->cliente_numero_documento,
                'cliente_nombre' => $data['data_venta']->cliente_nombre,
                'total_igv' => $this->input->post('igv_nota_credito'),
                'porcentaje_igv' => 18,
                'tipo_documento' => "07",
                'codigo_moneda' => $data['data_venta']->codigo_moneda,
                'total_letras' => $this->input->post('total_letras_nota_credito'),
                'cliente_direccion' => $data['data_venta']->cliente_direccion,
                'cliente_ubigeo' => $data['data_venta']->cliente_ubigeo,
                'observacion' => $data['data_venta']->observacion,
            );

            $venta_id = $this->venta_model->crearVenta($v);

            $nc = array(
                'id' => '',
                'codigo' => "",
                'ruc' =>  $data['data_venta']->cliente_numero_documento,
                'cliente' => $data['data_venta']->cliente_nombre,
                'direccion' => $data['data_venta']->cliente_direccion,
                'estado' => '1',
                'venta_id' =>   $venta_id,
                'serie' => $this->input->post('serie_nota_credito_modificado'),
                'numero' =>  $this->input->post('numero_nota_credito_modificado'),
                'fecha' =>  $this->input->post('fecha_nota_credito'),
                'vencimiento' => $this->input->post('fecha_nota_credito'),
                'hash' => "",
                'updated_at' =>  date('Y-m-d H:i:s'),
                'serie_nota' => $this->input->post('serie_nota_credito'),
                'fecha_nota_credito' => $this->input->post('fecha_nota_credito'),
                'descripcion_nota' => $this->input->post('descripcion_nota_credito'),
                'numero_nota' => $data['numero_comprobante'],
                'external_id_modificado' => $data['data_venta_factura']->external_id,
                'tipo_nota' => $this->input->post('motivo_nota_credito'),

            );
            $id_nota_credito = $this->venta_model->crearNotaCreditoFactura($nc);



            $precio_unidad_detalle_s = $this->input->post('precio_unidad_detalle');
            $cantidad_detalle_s = $this->input->post('cantidad_detalle');
            $producto_id_detalle_s = $this->input->post('producto_id_detalle');
            $subtotal_detalle_s = $this->input->post('subtotal_detalle');
            $importe_detalle_s = $this->input->post('importe_detalle');
            $texto_ref_detalle_s = $this->input->post('texto_ref_detalle');

            for ($x = 0; $x < sizeof($producto_id_detalle_s); $x++) {

                $vp[$x] = array(
                    'precio_unidad' => $precio_unidad_detalle_s[$x],
                    'cantidad' => $cantidad_detalle_s[$x],
                    'venta_id' => $venta_id,
                    'producto_id' => $producto_id_detalle_s[$x],
                    'servicio_id' => "",
                    'subtotal' => $subtotal_detalle_s[$x],
                    'total' => $importe_detalle_s[$x],
                    'created_at' =>  date('Y-m-d H:i:s'),
                    'texto_ref' => $texto_ref_detalle_s[$x],
                    'producto_serie_id' => "",
                );
            }
            $this->venta_model->crearVentaProducto($vp);
            $responseAPI = $this->envio_directo_nota_credito($id_nota_credito, $this->input->post('serie_nota_credito'), $data['numero_comprobante'], 'factura_nota_credito');
            if ($responseAPI !== 0) {
                $rs = json_decode($responseAPI, true);
                if (is_array($rs)) {
                    if ($rs['success']) {
                        $resp['link_xml'] = isset($rs['links']['xml']) ? $rs['links']['xml'] : null;
                        $resp['link_cdr'] = isset($rs['links']['cdr']) ? $rs['links']['cdr'] : null;
                        $resp['link_pdf'] = isset($rs['links']['pdf']) ? $rs['links']['pdf'] : null;
                        $resp['info_envio'] = "Correctamente enviado al API";
                    }
                }
            }

            $status['insert'] = 'success';
            echo (json_encode($status));
        } else {
        }
    }

    public function envio_directo($id, $serie, $numero, $tipo)
    {
        try {

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
                $items[] = array(
                    "codigo_interno" => substr(md5(uniqid() . mt_rand()), 0, 10),
                    "descripcion" => isset($value->p_nombre)?"$value->p_nombre".":":""  . $value->texto_ref,
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
                        //print_r($data);
                        //print_r($where);
                        $this->venta_model->updateCPE($tipo, $id, $external_id, $estado_api);
                        $this->venta_model->updateCPE_xml_cd($tipo, $id, $xml_link, $cdr_link, $pdf_link);
                    }
                    return $responseAPI;
                }
            } else {
                return 0;
            }
            //var_dump($responseAPI);
            //print_r($_doc);
            //print_r($_items);
        } catch (Exception $exc) {
            echo "Error servicio API";
            return 0;
        }
    }

    public function envio_directo_nota_credito($id, $serie, $numero, $tipo)
    {
        try {

            $_doc = array();

            $_doc = $this->venta_model->notaCreditoById($id, $numero, $serie);

            $_items = $this->venta_model->ventaProductoByIdVenta($_doc->venta_id);
            //api
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
            $motivo_o_sustento_de_nota=$_doc->descripcion_nota;
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
                "motivo_o_sustento_de_nota" =>$motivo_o_sustento_de_nota
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
                        //print_r($data);
                        //print_r($where);
                        $this->venta_model->updateCPE($tipo, $id, $external_id, $estado_api);
                        $this->venta_model->updateCPE_xml_cd($tipo, $id, $xml_link, $cdr_link, $pdf_link);
                    }
                    return $responseAPI;
                }
            } else {
                return 0;
            }
            //var_dump($responseAPI);
            //print_r($_doc);
            //print_r($_items);
        } catch (Exception $exc) {
            echo "Error servicio API";
            return 0;
        }
    }

    function crear_cabecera($emisor, $data)
    {

        $notadebito_descripcion['01'] = 'INTERES POR MORA';
        $notadebito_descripcion['02'] = 'AUMENTO EN EL VALOR';
        $notadebito_descripcion['03'] = 'PENALIDADES';

        $notacredito_descripcion['01'] = 'ANULACION DE LA OPERACION';
        $notacredito_descripcion['02'] = 'ANULACION POR ERROR EN EL RUC';
        $notacredito_descripcion['03'] = 'CORRECION POR ERROR EN LA DESCRIPCION';
        $notacredito_descripcion['04'] = 'DESCUENTO GLOBAL';
        $notacredito_descripcion['05'] = 'DESCUENTO POR ITEM';
        $notacredito_descripcion['06'] = 'DEVOLUCION TOTAL';
        $notacredito_descripcion['07'] = 'DEVOLUCION POR ITEM';
        $notacredito_descripcion['08'] = 'BONIFICACION';
        $notacredito_descripcion['09'] = 'DISMINUCION EN EL VALOR';


        if (isset($data['tipo_comprobante'])) {
            if ($data['tipo_comprobante'] == '07') { //Nota de Crédito
                $codigo_motivo_modifica = $data['notacredito_motivo_id'];
                $descripcion_motivo_modifica = $notacredito_descripcion[$data['notacredito_motivo_id']];
            } else if ($data['tipo_comprobante'] == '08') { //Nota de Débito
                $codigo_motivo_modifica = $data['notadebito_motivo_id'];
                $descripcion_motivo_modifica = $notadebito_descripcion[$data['notadebito_motivo_id']];
            } else {
                $codigo_motivo_modifica = "";
                $descripcion_motivo_modifica = "";
            }
        }

        $cabecera = array(
            'TIPO_OPERACION' => '0101', //pag. 28
            'TOTAL_GRAVADAS' => (isset($data['txt_subtotal_comprobante'])) ? $data['txt_subtotal_comprobante'] : "0",
            'TOTAL_INAFECTA' => "0",
            'TOTAL_EXONERADAS' => (isset($data['txt_total_exoneradas'])) ? $data['txt_total_exoneradas'] : "0",
            'TOTAL_GRATUITAS' => "0",
            'TOTAL_PERCEPCIONES' => "0",
            'TOTAL_RETENCIONES' => "0",
            'TOTAL_DETRACCIONES' => "0",
            'TOTAL_BONIFICACIONES' => "0",
            'TOTAL_EXPORTACION' => "0",
            'TOTAL_DESCUENTO' => "0",
            'SUB_TOTAL' => (isset($data['txt_subtotal_comprobante'])) ? $data['txt_subtotal_comprobante'] : "0",
            'POR_IGV' => (isset($data['txt_igv_porcentaje'])) ? $data['txt_igv_porcentaje'] : "18.00", //Porcentaje del impuesto
            'TOTAL_IGV' => (isset($data['txt_igv_comprobante'])) ? $data['txt_igv_comprobante'] : "0",
            'TOTAL_ISC' => "0",
            'TOTAL_OTR_IMP' => "0",
            'TOTAL' => (isset($data['txt_total_comprobante'])) ? $data['txt_total_comprobante'] : "0",
            'TOTAL_LETRAS' => $data['txt_total_letras'],
            //==============================================
            'NRO_GUIA_REMISION' => "",
            'COD_GUIA_REMISION' => "",
            'NRO_OTR_COMPROBANTE' => "",
            'COD_OTR_COMPROBANTE' => "",
            //==============================================
            'TIPO_COMPROBANTE_MODIFICA' => (isset($data['tipo_comprobante_modificado'])) ? $data['tipo_comprobante_modificado'] : "",
            'NRO_DOCUMENTO_MODIFICA' => (isset($data['num_comprobante_modificado'])) ? $data['num_comprobante_modificado'] : "",
            'COD_TIPO_MOTIVO' => $codigo_motivo_modifica,
            'DESCRIPCION_MOTIVO' => $descripcion_motivo_modifica,
            //===============================================
            'NRO_COMPROBANTE' => $data['serie_comprobante'] . '-' . $data['numero_comprobante'],
            'FECHA_DOCUMENTO' => $data['fecha_comprobante'],
            'FECHA_VTO' => $data['fecha_comprobante'], //pag. 31 //fecha de vencimiento
            'COD_TIPO_DOCUMENTO' => $data['tipo_comprobante'],
            'COD_MONEDA' => $data['codmoneda_comprobante'],
            //==================================================
            'NRO_DOCUMENTO_CLIENTE' => $data['cliente_numerodocumento'],
            'RAZON_SOCIAL_CLIENTE' => $data['cliente_nombre'],
            'TIPO_DOCUMENTO_CLIENTE' => $data['cliente_tipodocumento'], //RUC
            'DIRECCION_CLIENTE' => $data['cliente_direccion'],
            'COD_UBIGEO_CLIENTE' => (isset($data['cliente_codigoubigeo'])) ? $data['cliente_codigoubigeo'] : "",
            'DEPARTAMENTO_CLIENTE' => (isset($data['cliente_departamento'])) ? $data['cliente_departamento'] : "",
            'PROVINCIA_CLIENTE' => (isset($data['cliente_provincia'])) ? $data['cliente_provincia'] : "",
            'DISTRITO_CLIENTE' => (isset($data['cliente_distrito'])) ? $data['cliente_distrito'] : "",
            'CIUDAD_CLIENTE' => $data['cliente_ciudad'],
            'COD_PAIS_CLIENTE' => $data['cliente_pais'],
            //===============================================
            'NRO_DOCUMENTO_EMPRESA' => $emisor['ruc'],
            'TIPO_DOCUMENTO_EMPRESA' => $emisor['tipo_doc'], //RUC
            'NOMBRE_COMERCIAL_EMPRESA' => $emisor['nom_comercial'],
            'CODIGO_UBIGEO_EMPRESA' => $emisor['codigo_ubigeo'],
            'DIRECCION_EMPRESA' => $emisor['direccion'],
            'DEPARTAMENTO_EMPRESA' => $emisor['direccion_departamento'],
            'PROVINCIA_EMPRESA' => $emisor['direccion_provincia'],
            'DISTRITO_EMPRESA' => $emisor['direccion_distrito'],
            'CODIGO_PAIS_EMPRESA' => $emisor['direccion_codigopais'],
            'RAZON_SOCIAL_EMPRESA' => $emisor['razon_social'],
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
            'EMISOR_RUC' => $emisor['ruc'],
            'EMISOR_USUARIO_SOL' => $emisor['usuariosol'],
            'EMISOR_PASS_SOL' => $emisor['clavesol'],
            //RESUMEN
            'SERIE' => '',
            'SECUENCIA' => ''
        );

        return $cabecera;
    }

    public function getEmpresa()
    {
        $this->config->load('empresa');
        $ruc = $this->config->item('ruc');
        $tipoDoc = $this->config->item('tipo_doc');
        $nombreComercial = $this->config->item('nom_comercial');
        $razonSocial = $this->config->item('razon_social');
        $codigoUbigeo = $this->config->item('codigo_ubigeo');
        $direccion = $this->config->item('direccion');
        $departamento = $this->config->item('direccion_departamento');
        $provincia = $this->config->item('direccion_provincia');
        $distrito = $this->config->item('direccion_distrito');
        $codigoPais = $this->config->item('direccion_codigopais');
        $usuarioSol = $this->config->item('usuariosol');
        $claveSol = $this->config->item('clavesol');
        $tipoProceso = $this->config->item('tipoproceso');
        $firmaPassword = $this->config->item('firma_password');
        $local = $this->config->item('local');
        return (new Empresa())
            ->setRuc($ruc)
            ->setTipoDoc($tipoDoc)
            ->setNombreComercial($nombreComercial)
            ->setRazonSocial($razonSocial)
            ->setCodigoUbigeo($codigoUbigeo)
            ->setDireccion($direccion)
            ->setDepartamento($departamento)
            ->setProvincia($provincia)
            ->setDistrito($distrito)
            ->setCodigoPais($codigoPais)
            ->setUsuarioSol($usuarioSol)
            ->setClaveSol($claveSol)
            ->setTipoProceso($tipoProceso)
            ->setFirmaPassword($firmaPassword)
            ->setLocal($local);
    }
}

class Empresa
{

    private $ruc;
    private $tipoDoc;
    private $nombreComercial;
    private $razonSocial;
    private $codigoUbigeo;
    private $direccion;
    private $departamento;
    private $provincia;
    private $distrito;
    private $codigoPais;
    private $usuarioSol;
    private $claveSol;
    private $tipoProceso;
    private $firmaPassword;
    private $local;

    function __construct()
    {
    }

    public function getRuc()
    {
        return $this->ruc;
    }

    public function getTipoDoc()
    {
        return $this->tipoDoc;
    }

    public function getNombreComercial()
    {
        return $this->nombreComercial;
    }

    public function getRazonSocial()
    {
        return $this->razonSocial;
    }

    public function getCodigoUbigeo()
    {
        return $this->codigoUbigeo;
    }

    public function getDireccion()
    {
        return $this->direccion;
    }

    public function getDepartamento()
    {
        return $this->departamento;
    }

    public function getProvincia()
    {
        return $this->provincia;
    }

    public function getDistrito()
    {
        return $this->distrito;
    }

    public function getCodigoPais()
    {
        return $this->codigoPais;
    }

    public function getUsuarioSol()
    {
        return $this->usuarioSol;
    }

    public function getClaveSol()
    {
        return $this->claveSol;
    }

    public function getTipoProceso()
    {
        return $this->tipoProceso;
    }

    public function getFirmaPassword()
    {
        return $this->firmaPassword;
    }

    public function getLocal()
    {
        return $this->local;
    }

    public function setRuc($ruc)
    {
        $this->ruc = $ruc;
        return $this;
    }

    public function setTipoDoc($tipoDoc)
    {
        $this->tipoDoc = $tipoDoc;
        return $this;
    }

    public function setNombreComercial($nombreComercial)
    {
        $this->nombreComercial = $nombreComercial;
        return $this;
    }

    public function setRazonSocial($razonSocial)
    {
        $this->razonSocial = $razonSocial;
        return $this;
    }

    public function setCodigoUbigeo($codigoUbigeo)
    {
        $this->codigoUbigeo = $codigoUbigeo;
        return $this;
    }

    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
        return $this;
    }

    public function setDepartamento($departamento)
    {
        $this->departamento = $departamento;
        return $this;
    }

    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;
        return $this;
    }

    public function setDistrito($distrito)
    {
        $this->distrito = $distrito;
        return $this;
    }

    public function setCodigoPais($codigoPais)
    {
        $this->codigoPais = $codigoPais;
        return $this;
    }

    public function setUsuarioSol($usuarioSol)
    {
        $this->usuarioSol = $usuarioSol;
        return $this;
    }

    public function setClaveSol($claveSol)
    {
        $this->claveSol = $claveSol;
        return $this;
    }

    public function setTipoProceso($tipoProceso)
    {
        $this->tipoProceso = $tipoProceso;
        return $this;
    }

    public function setFirmaPassword($firmaPassword)
    {
        $this->firmaPassword = $firmaPassword;
        return $this;
    }

    public function setLocal($local)
    {
        $this->local = $local;
        return $this;
    }
}
