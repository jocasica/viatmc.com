<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedor extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('url', 'language'));
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('auth');
        $this->load->model(array(
            'Proveedor_model',
            'Proveedor_pago_model',
        ));
    }//end __construct

	public function index() {
		if ($this->ion_auth->logged_in()) {
			$data['proveedores'] = $this->Proveedor_model->seleccionar_todo();
			$this->load->view('/layout/top');
			$this->load->view('menu/proveedores/index', $data);
			$this->load->view('/layout/bottom');
		} else {
			redirect('auth/login', 'refresh');
		}
	} # end index

	public function agregar() {
		if ($this->ion_auth->logged_in()) {
            $proveedor['ruc'] = $this->input->post('ruc');
            $proveedor['nombre_proveedor'] = $this->input->post('nombre_proveedor');
            $proveedor['telefono'] = $this->input->post('telefono');
            $this->Proveedor_model->agregar($proveedor);
            redirect('proveedor', 'refresh');
		}//end if
		else {
            redirect('auth/login', 'refresh');
        }//end else
	}//end agregar

	public function editar() {
		if ($this->ion_auth->logged_in()) {
                  $id_proveedor = $this->input->post('id');
                  $proveedor['updated_at'] = date('Y-m-d H:i:s');
                  $proveedor['ruc'] = $this->input->post('ruc');
                  $proveedor['nombre_proveedor'] = $this->input->post('nombre_proveedor');
                  $proveedor['telefono'] = $this->input->post('telefono');
                  $this->Proveedor_model->actualizar($id_proveedor, $proveedor);
                  redirect('proveedor', 'refresh');
		}//end if
		else {
                  redirect('auth/login', 'refresh');
            }//end else
	}//end editar

	public function pago_proveedor() {
		if ($this->ion_auth->logged_in()) {
			$data = array();
			$data['proveedor_pagos'] = $this->Proveedor_pago_model->seleccionar();
			$data['proveedores'] = $this->Proveedor_model->seleccionar_con_id();
			$numero = $this->Proveedor_pago_model->getNumero();
			if($numero == NULL) {
				$numero = 'F'.date('Ym').'-01';
			}//end if
			else {
				$numero = explode('-', $numero);
				$n = (int)$numero[1]+1;
				$numero = 'F'.date('Ym').'-0'.$n;
			}//end else
			$data['numero'] = $numero;
			$this->load->view('/layout/top');
			$this->load->view('menu/proveedores/pago_proveedor', $data);
			$this->load->view('/layout/bottom');
		}//end if
		else {
			redirect('auth/login', 'refresh');
		}//end else
	}//end pago_proveedor

	public function realizarPago() {
		if ($this->ion_auth->logged_in()) {
			$pago['created_at'] = date("Y-m-d H:i:s");
			$pago['fecha_pago'] = date("Y-m-d H:i:s");
			$pago['numero'] = $this->input->post('numero');
			$pago['proveedor_id'] = $this->input->post('id_proveedor');
			$pago['total'] = $this->input->post('total');
			$this->Proveedor_pago_model->agregar($pago);
			redirect('proveedor/pago_proveedor', 'refresh');
		}//end if
		else {
		  redirect('auth/login', 'refresh');
	  }//end else
	}//end realizarPago

	public function confirmarPago() {
		if ($this->ion_auth->logged_in()) {
			$id = $this->input->post('id');
			$pago['cuenta_bancaria'] = $this->input->post('cuenta_bancaria');
			$pago['tipo_pago'] = $this->input->post('tipo_pago');
			$pago['fecha_pago'] = $this->input->post('fecha_pago');
			$pago['tipo_moneda'] = $this->input->post('tipo_moneda');
			$total = $this->input->post('total');
			$pago['pagado'] = $this->input->post('pagado');
			$pagar = $total - $this->input->post('pagado');
			if($pagar <= 0 ) {
				$pago['pagar'] = 0.0;
				$pago['estado'] = 1;
			}//end if
			else {
				$pago['pagar'] = $pagar;
			}//end else

			$this->Proveedor_pago_model->actualizar_pago($id, $pago);
			redirect('proveedor/pago_proveedor', 'refresh');
		}//end if
		else {
		  redirect('auth/login', 'refresh');
	  }//end else
	}//end realizarPago

}//end class Proveedor
