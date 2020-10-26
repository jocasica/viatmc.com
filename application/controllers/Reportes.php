<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes extends CI_Controller {


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
			$this->load->view('/layout/top');
			$this->load->view('menu/reportes/index');
			$this->load->view('/layout/bottom');
    	}
		else {
			redirect('auth/login', 'refresh');
		}
	}

	public function documentos()
	{
    if ($this->ion_auth->logged_in())
    	{
			$this->load->view('/layout/top');
			$this->load->view('menu/reportes/documentos');
			$this->load->view('/layout/bottom');
    	}
		else {
			redirect('auth/login', 'refresh');
		}
		
	}

	public function comprobantes()
	{
    if ($this->ion_auth->logged_in())
    	{
			$this->load->view('/layout/top');
			$this->load->view('menu/reportes/comprobantes');
			$this->load->view('/layout/bottom');
    	}
		else {
			redirect('auth/login', 'refresh');
		}		
	}
	
	public function compra_productos()
	{
    if ($this->ion_auth->logged_in())
    	{
			$data = array();
			$data['productos'] = $this->producto_model->productos_con_id();
			$this->load->view('/layout/top');
			$this->load->view('menu/reportes/compra_productos', $data);
			$this->load->view('/layout/bottom');
    	}
		else {
			redirect('auth/login', 'refresh');
		}		
	}

	public function venta_productos()
	{
    if ($this->ion_auth->logged_in())
    	{
			$data = array();
			$data['productos'] = $this->producto_model->productos_con_id();
			$this->load->view('/layout/top');
			$this->load->view('menu/reportes/venta_productos', $data);
			$this->load->view('/layout/bottom');
    	}
		else {
			redirect('auth/login', 'refresh');
		}		
	}

	public function turnos()
	{
    if ($this->ion_auth->logged_in())
    	{
			$this->load->view('/layout/top');
			$this->load->view('menu/reportes/turnos');
			$this->load->view('/layout/bottom');
    	}
		else {
			redirect('auth/login', 'refresh');
		}		
	}

	public function ventas()
	{
    if ($this->ion_auth->logged_in())
    	{
			$this->load->view('/layout/top');
			$this->load->view('menu/reportes/ventas');
			$this->load->view('/layout/bottom');
    	}
		else {
			redirect('auth/login', 'refresh');
		}		
	}


	public function resumen_ventas() {
		if ($this->ion_auth->logged_in()) {


			date_default_timezone_set('America/Lima');

			$conexion = new PDO("mysql:host=" . $this->db->hostname . ";dbname=" . $this->db->database . "", "" . $this->db->username . "", "" . $this->db->password . "", array(
					PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"
				)
			);
			$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



			switch ($_REQUEST['tipo']) {
				case 'boleta':


					$query = "

						SELECT

					DATE_FORMAT(c.fecha,'%d/%m/%Y') fecha,
						CONCAT(c.serie,'-',LPAD(c.numero,6,'0'))numero,
						c.cliente,
						c.envio,
						v.total_gravado as subtotal ,
						v.total_igv as igv,
						v.total,
						c.dni documento,
						v.metodo_pago



						FROM venta v

						INNER JOIN boleta c ON v.id=c.venta_id


						WHERE DATE_FORMAT(c.fecha,'%Y-%m')=:periodo

						";
								break;
							case 'factura':

								$query = "SELECT

					DATE_FORMAT(c.fecha,'%d/%m/%Y') fecha,
					CONCAT(c.serie,'-',LPAD(c.numero,6,'0'))numero,
					c.cliente,
					c.envio,
					v.total_gravado as subtotal ,
					v.total_igv as igv,
					v.total,
					c.ruc documento,
					v.metodo_pago



					FROM venta v


					INNER JOIN factura c ON v.id=c.venta_id

					WHERE DATE_FORMAT(c.fecha,'%Y-%m')=:periodo";



								break;
							case 'facturaboleta':

								$query = "
					SELECT

							DATE_FORMAT(c.fecha,'%d/%m/%Y') fecha,
								CONCAT(c.serie,'-',LPAD(c.numero,6,'0'))numero,
								c.cliente,
								c.envio,
								v.total_gravado as subtotal ,
								v.total_igv as igv,
								v.total,
								c.dni documento,
								v.metodo_pago



								FROM venta v

								INNER JOIN boleta c ON v.id=c.venta_id


								WHERE DATE_FORMAT(c.fecha,'%Y-%m')=:periodo


					UNION
					SELECT

					DATE_FORMAT(c.fecha,'%d/%m/%Y') fecha,
					CONCAT(c.serie,'-',LPAD(c.numero,6,'0'))numero,
					c.cliente,
					c.envio,
					v.total_gravado as subtotal ,
					v.total_igv as igv,
					v.total,
					c.ruc documento,
					v.metodo_pago



					FROM venta v


					INNER JOIN factura c ON v.id=c.venta_id

					WHERE DATE_FORMAT(c.fecha,'%Y-%m')=:periodo



					";







								break;

							default:
								# code...
								break;
			}

			$statement = $conexion->prepare($query);
			$statement->bindParam(':periodo', $_REQUEST['periodo']);
			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);

			echo json_encode(array('data' => $result));
		} else {
			redirect('auth/login', 'refresh');
		}
	}


	public function resumen_compra_productos()
    {
    if ($this->ion_auth->logged_in())
        {
            
            
           
        date_default_timezone_set('America/Lima');
        
        $conexion = new PDO("mysql:host=".$this->db->hostname.";dbname=".$this->db->database."","".$this->db->username."","".$this->db->password."",
        array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"
        )
        
        );
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        
        
          $query  =  "
         
       		SELECT 

			c.precio_unidad,
			c.cantidad,
			c.total,
			f.serie,
			f.numero,
			p.nombre,
			DATE_FORMAT(f.created_at,'%d/%m/%Y %H:%i:%s') fecha




			FROM compra_producto c

			INNER JOIN compra f ON c.compra_id=f.id

			INNER JOIN producto p ON c.producto_id=p.id

			WHERE DATE_FORMAT(f.fecha,'%Y-%m')=:periodo
         
         ";


        $statement = $conexion->prepare($query);
        $statement->bindParam(':periodo',$_REQUEST['periodo']);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode(array('data'=>$result));

        
        }
        else {
            redirect('auth/login', 'refresh');
        }       
    }
	

}
