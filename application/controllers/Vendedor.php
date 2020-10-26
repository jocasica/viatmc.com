<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendedor extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('url', 'language'));
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('auth');
        $this->load->model(array(
            'Vendedor_model'
        ));
    } # end __construct

    public function index() {
        if ($this->ion_auth->logged_in()) {
            $data               = array();
            $data['vendedores'] = $this->Vendedor_model->seleccionar_todo();
            $this->load->view('/layout/top');
            $this->load->view('menu/vendedores/index', $data);
            $this->load->view('/layout/bottom');
        } else {
            redirect('auth/login', 'refresh');
        }
    } # end index

    public function agregar() {
        if ($this->ion_auth->logged_in()) {
            $vendedor['nombre_vendedor']    = $this->input->post('nombre');
            $vendedor['telefono']           = $this->input->post('telefono');
            $vendedor['email']              = $this->input->post('email');
            $this->Vendedor_model->agregar($vendedor);
            redirect('vendedor', 'refresh');
        } else {
            redirect('auth/login', 'refresh');
        }
    } # end agregar

    public function editar() {
        if ($this->ion_auth->logged_in()) {
            $id_vendedor                    = $this->input->post('id');
            $vendedor['updated_at']         = date("Y-m-d H:i:s");
            $vendedor['nombre_vendedor']    = $this->input->post('nombre');
            $vendedor['telefono']           = $this->input->post('telefono');
            $vendedor['email']              = $this->input->post('email');
            $this->Vendedor_model->actualizar($id_vendedor, $vendedor);
            redirect('vendedor', 'refresh');
        } else {
            redirect('auth/login', 'refresh');
        }
    } # end editar

} # end class Vendedor