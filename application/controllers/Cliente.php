<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('url', 'language'));
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('auth');

        $this->load->model(array(
            'Cliente_model',
            'Cliente_direccion_model',
        ));
    } # end __construct

    public function index() {
        if ($this->ion_auth->logged_in()) {
            $data       = array();
            $clientes   = $this->Cliente_model->seleccionar_todo();
            foreach ($clientes as $cliente) {
                $cliente->direcciones_secundarias = $this->Cliente_direccion_model->seleccionar_donde(array('id_cliente'=>$cliente->id));
            }
            $data['clientes'] = $clientes;
            $this->load->view('/layout/top');
            $this->load->view('menu/cliente/index', $data);
            $this->load->view('/layout/bottom');
        } else {
            redirect('auth/login', 'refresh');
        }
    } # end index

    public function registro() {
        if ($this->ion_auth->logged_in()) {
            $data['data_vendedores'] = $this->Cliente_model->getVendedores();
            $this->load->view('/layout/top');
            $this->load->view('menu/cliente/registro', $data);
            $this->load->view('/layout/bottom');
        }else {
            redirect('auth/login', 'refresh');
        }
    } # end registro

    public function agregar() {
        if ($this->ion_auth->logged_in()) {
            $cliente['tipo_documento']      = $this->input->post('tipo_documento');
            $cliente['numero_documento']    = $this->input->post('numero_sunat');
            $cliente['nombre_cliente']      = $this->input->post('nombre_cliente');
            $cliente['nombre_cotizacion']   = $this->input->post('nombre_cotizacion');
            $cliente['segmento']            = $this->input->post('segmento');
            $cliente['departamento']        = $this->input->post('departamento');
            $cliente['providencia']         = $this->input->post('providencia');
            $cliente['distrito']            = $this->input->post('distrito');
            $cliente['direccion_principal'] = $this->input->post('direccion');
            $cliente['telefono_principal']  = $this->input->post('telefono');
            $cliente['email_principal']     = $this->input->post('email');
            $cliente['id_vendedor']         = $this->input->post('id_vendedor'); # campo nuevo

            if($id_cliente = $this->Cliente_model->agregar($cliente)) {
                $ubigeo     = $this->input->post('ubigeo[]');
                $dir        = $this->input->post('direccion2[]');
                $telefono   = $this->input->post('telefono2[]');
                $email      = $this->input->post('email2[]');
                for($i=0; $i < sizeof($ubigeo); $i++) {
                    $direccion                  = array();
                    $direccion['id_cliente']    = $id_cliente;
                    $direccion['ubigeo']        = $ubigeo[$i];
                    $direccion['direccion']     = $dir[$i];
                    $direccion['telefono']      = $telefono[$i];
                    $direccion['email']         = $email[$i];
                    $this->Cliente_direccion_model->agregar($direccion);
                }
            }
        } else {
            redirect('auth/login', 'refresh');
        }
    } # end agregar

    public function detalles($id_cliente = null) {
        if ($this->ion_auth->logged_in()) {
            $data['data_cliente']       = $this->Cliente_model->getClienteById($id_cliente);
            if($data['data_cliente'] == '') {
                redirect('cliente', 'refresh');
            }
            $data['data_vendedores']    = $this->Cliente_model->getVendedores();
            $data['data_direcciones']   = $this->Cliente_direccion_model->seleccionar_donde(array('id_cliente'=>$id_cliente));
            $this->load->view('/layout/top');
            $this->load->view('menu/cliente/detalles', $data);
            $this->load->view('/layout/bottom');
        } else {
            redirect('auth/login', 'refresh');
        }
    } # end detalles

    public function editar($id_cliente) {
        if ($this->ion_auth->logged_in()) {
            $cliente['updated_at']          = date("Y-m-d H:i:s");
            $cliente['tipo_documento']      = $this->input->post('tipo_documento');
            $cliente['numero_documento']    = $this->input->post('numero_sunat');
            $cliente['nombre_cliente']      = $this->input->post('nombre_cliente');
            $cliente['nombre_cotizacion']   = $this->input->post('nombre_cotizacion');
            $cliente['segmento']            = $this->input->post('segmento');
            $cliente['departamento']        = $this->input->post('departamento');
            $cliente['providencia']         = $this->input->post('providencia');
            $cliente['distrito']            = $this->input->post('distrito');
            $cliente['direccion_principal'] = $this->input->post('direccion');
            $cliente['telefono_principal']  = $this->input->post('telefono');
            $cliente['email_principal']     = $this->input->post('email');
            $cliente['id_vendedor']         = $this->input->post('id_vendedor'); # campo nuevo

            if($this->Cliente_model->actualizar($id_cliente, $cliente)) {
                $this->Cliente_direccion_model->eliminar($id_cliente);
                $ubigeo     = $this->input->post('ubigeo[]');
                $tipo_direccion        = $this->input->post('tipo_direccion2[]');
                $dir        = $this->input->post('direccion2[]');
                $telefono   = $this->input->post('telefono2[]');
                $email      = $this->input->post('email2[]');
                for($i=0; $i < sizeof($ubigeo); $i++) {
                    $direccion                  = array();
                    $direccion['id_cliente']    = $id_cliente;
                    $direccion['tipo_direccion']        = $tipo_direccion[$i];
                    $direccion['ubigeo']        = $ubigeo[$i];
                    $direccion['direccion']     = $dir[$i];
                    $direccion['telefono']      = $telefono[$i];
                    $direccion['email']         = $email[$i];
                    $this->Cliente_direccion_model->agregar($direccion);
                }
            }
        } else {
            redirect('auth/login', 'refresh');
        }
    } # end editar

} # end class Cliente