<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Servicio extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
	}

	public function index()
	{
		if ($this->ion_auth->logged_in())
    {
      $data = array('servicios' => $this->producto_model->getServicios());
			$this->load->view('/layout/top');
			$this->load->view('menu/servicio/index',$data);
			$this->load->view('/layout/bottom');
    }
    else {
      redirect('auth/login', 'refresh');
    }
	}
	
	public function create()
	{
		if ($this->ion_auth->logged_in())
    {
			$this->load->view('/layout/top');
		  $this->load->view('/menu/servicio/create');
			$this->load->view('/layout/bottom');
    }
    else {
      redirect('auth/login', 'refresh');
    }
	}
  public function post()
	{
    if ($this->ion_auth->logged_in())
    {
      $p = array(
        'id'      => '',
        'descripcion' =>  $this->input->post('descripcion'),
				'estado'  =>  '1'
      );
      $this->producto_model->crearServicio($p);
      redirect('servicio', 'refresh');
    }
    else {
      redirect('auth/login', 'refresh');
    }
  }
	public function edit($id)
	{
		if ($this->ion_auth->logged_in())
    {
			$data = array('servicio' => $this->producto_model->getServicioById($id));
     
			$this->load->view('/layout/top');
		  $this->load->view('/menu/servicio/edit',$data);
			$this->load->view('/layout/bottom');
			
    }
    else {
      redirect('auth/login', 'refresh');
    }
	}
	public function update()
	{
		if ($this->ion_auth->logged_in())
    {
			$estado="";
			if(is_null($this->input->post("estado"))){
				$estado = "0";
			}else{
				$estado = $this->input->post("estado");
			}
			$result =$this->producto_model->editServicio(
				$this->input->post("id"),
				$this->input->post("descripcion"),
				$estado);
			//echo $this->input->post("estado").'-'.$this->input->post("descripcion");
			redirect('servicio', 'refresh');
			
    }
    else {
      redirect('auth/login', 'refresh');
    }
	}
}