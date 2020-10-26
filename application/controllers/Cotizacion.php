<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cotizacion extends CI_Controller {
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
			'Vendedor_model',
		));
	}
	# -------------------------------------------------------------------------------------------------
	# ------------------------------------------ Area Ventas ------------------------------------------
	# -------------------------------------------------------------------------------------------------
	public function index() {
		if ($this->ion_auth->logged_in()) {
			$data = array();
			$cots = $this->venta_model->getCotizaciones();
			foreach ($cots->result() as $cot) {
				$cot->user_name = $this->ion_auth->getName($cot->users_id);
				$cot->nombre_vendedor = $this->Vendedor_model->getName($cot->vendedor_id);
			} # end foreach
			$data['cots'] = $cots;
			$this->load->view('/layout/top');
			$this->load->view('menu/cotizacion/ventas/index',$data);
			$this->load->view('/layout/bottom');
		} else {
			redirect('auth/login', 'refresh');
		}
	} # end index

	public function servicio()
	{
		if ($this->ion_auth->logged_in())
    {
			$data = array('cots' => $this->venta_model->getCotizacionesServicio());
      $this->load->view('/layout/top');
		  $this->load->view('menu/cotizacionservicio/index',$data);
			$this->load->view('/layout/bottom');

    }
    else {
      redirect('auth/login', 'refresh');
    }
	}

	public function delete() {
		if ($this->ion_auth->logged_in()) {
			$id 		= $_POST['id'];
			$res[0] = $this->venta_model->deleteCotizacion($id);
			$res[1] = $this->venta_model->deleteDetalleCotizacion($id);
			echo json_encode($res);
		} else {
			redirect('auth/login', 'refresh');
		}
	} # end delete

	public function deleteServicio($id)
	{
		if ($this->ion_auth->logged_in())
    {
        $this->venta_model->deleteCotizacion($id);
			$data = array('cots' => $this->venta_model->getCotizacionesServicio());
      $this->load->view('/layout/top');
		  $this->load->view('menu/cotizacionservicio/index',$data);
			$this->load->view('/layout/bottom');

    }
    else {
      redirect('auth/login', 'refresh');
    }
	}

	public function create() {
		if ($this->ion_auth->logged_in()) {
			$data['data_productos']		= $this->producto_model->productos_con_id();
			$data['data_clientes']		= $this->Cliente_model->getClientes();
			$data['data_vendedores']	= $this->Vendedor_model->getVendedores();
			$this->load->view('/layout/top');
			$this->load->view('menu/cotizacion/ventas/create',$data);
			$this->load->view('/layout/bottom');
		} else {
			redirect('auth/login', 'refresh');
		}
	} # end create

	public function createservicio()
	{
		if ($this->ion_auth->logged_in())
    {
			$data = array('servicios' => $this->venta_model->getServiciosActivos(),
							'autorizantes' => $this->venta_model->getAutorizantes());

			$this->load->view('/layout/top');
		  $this->load->view('menu/cotizacionservicio/create',$data);
			$this->load->view('/layout/bottom');
    }
    else {
      redirect('auth/login', 'refresh');
    }
	}
	public function edit($id) {
		if ($this->ion_auth->logged_in()) {
			$data['data_productos']								= $this->producto_model->productos_con_id();
			$data['data_cotizacion'] 							= $this->venta_model->getCotizacionId($id);
			$data['cotizacion_detalle_productos']	= $this->venta_model->getCotizacionDetalleProductosById($id);
			$this->load->view('/layout/top');
			$this->load->view('/menu/cotizacion/ventas/edit',$data);
			$this->load->view('/layout/bottom');
    } else {
      redirect('auth/login', 'refresh');
    }
	}
	public function ticket($cotizacion_id)
	{
	    $this->load->library('pdfdos');
	    $prods = $this->venta_model->getProductosCotizacion($cotizacion_id);
        $pdf = $this->pdfdos;
          $data['comprobante'] = "TICKET";
          $data['prods'] = $prods;
          $datos = $this->venta_model->getDatosTicket($cotizacion_id);
          $pdf->mostrar_ticket($prods,$datos);
    }
	public function getClaveAdmin()
	{
	    $clave = $_POST['clave'];
	    $admins = $this->venta_model->getUsuariosAdmin();
	    $resultado = null;
	    foreach($admins->result() as $a){
	        $resultado = $this->ion_auth->hash_password_db($a->id, $clave);
	        if($resultado == "1"){
		        echo $resultado;

	        }
	    }
	    exit;
	    echo "dwew";
	    echo json_encode($admins->result());
		exit;
	}

	public function post() {
		if ($this->ion_auth->logged_in()) {
			$tipo_cotizacion 								= $_POST['tc'];
			$data_cotizacion 								= $_POST['dc'];
			$data_cotizacion['fecha']				= date('Y-m-d');
			$data_cotizacion['users_id']		= $this->ion_auth->user()->row()->id;
			$data_cotizacion['created_at']	= date('Y-m-d H:i:s');

			if($tipo_cotizacion == 1) { # Cotización - Productos
				# Registro de la cotización -> 'cotizacion'
				$data_cotizacion['tipo_cotizacion']	= 'PRODUCTO';
				$id_cotizacion 											= $this->producto_model->crearCotizacion($data_cotizacion);
				$data_lista_productos_cotizacion		= $_POST['dcd'];

				# registrar nueva lista de productos
				foreach($data_lista_productos_cotizacion as $dcd) {
					$detalle										= $dcd;
					$detalle['cotizacion_id']		= $id_cotizacion;
					$detalle['created_at']			= date('Y-m-d H:i:s');
					$this->venta_model->crearCotizacionProducto($detalle);
				}
				$data['tc']		= $tipo_cotizacion;
				$data['dc']		= $data_cotizacion;
				$data['dcd']	= $data_lista_productos_cotizacion;
				echo json_encode($data);
			} else {
				//$cot = $this->producto_model->getSerieCotizacion();

				$cotizacion = array(
					'montototal'	=> $this->input->post("montototals"),
					'tipo_cotizacion' => 'SERVICIO'
				);

				$result =$this->producto_model->crearCotizacion($cotizacion);
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
					'cotizacion_id'	=> $result,
					'servicio_id'	=> $servicio_id_s,
					'referencia'	=> $referencia,
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
					'created_at'	=> date('Y-m-d H:i:s')

				);

				$this->venta_model->crearCotizacionServicio($co);
			}//end else

			redirect('cotizacion', 'refresh');
    	}
		else {
			redirect('auth/login', 'refresh');
		}
	}

	public function postservicio()
	{
		if ($this->ion_auth->logged_in())
    {
			//$cot = $this->producto_model->getSerieCotizacion();

			$cotizacion = array(
				'id'      => '',

				'fecha'	=> date('Y-m-d'),

				'cliente_id'	=> $this->input->post("cliente_id"),
				'moneda' => $this->input->post("moneda"),
				'montototal'	=> $this->input->post("montototal"),

				'users_id'	=> $this->ion_auth->user()->row()->id,
				'created_at'	=> date('Y-m-d H:i:s'),
				'estado'  =>  '1',

				'tipo_cotizacion' => 'SERVICIO'
			);

		    $result =$this->producto_model->crearCotizacion($cotizacion);
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
				'id'      => '',

				'cotizacion_id'	=> $result,
				'servicio_id'	=> $servicio_id_s,
				'referencia'	=> $referencia,
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
				'created_at'	=> date('Y-m-d H:i:s')

			);
	            $this->venta_model->crearCotizacionServicio($co);

				redirect('cotizacion/servicio', 'refresh');
            }


    else {
      redirect('auth/login', 'refresh');
    }
	}




	public function update() { # actualizar cotización
		if ($this->ion_auth->logged_in()) {
			$id_cotizacion										= $_POST['id'];
			$data_cotizacion									= $_POST['dc'];
			$data_lista_productos_cotizacion	= $_POST['dcd'];

			# Actualizar data general de la cotización -> 'cotizacion'
			$data_cotizacion['users_id']		= $this->ion_auth->user()->row()->id;
			$data_cotizacion['updated_at']	= date('Y-m-d H:i:s');
			$this->producto_model->actualizarCotizacion($id_cotizacion, $data_cotizacion);

			# Eliminar lista anterior de cotizacion_producto
			$this->venta_model->eliminarProductosDetalleCotizacionById($id_cotizacion);
			# Registrar nueva lista de producto en cotizacion_producto
			foreach($data_lista_productos_cotizacion as $dcd) {
				unset($dcd['id'], $dcd['nombre']);
				$detalle										= $dcd;
				$detalle['cotizacion_id']		= $id_cotizacion;
				$detalle['created_at']			= date('Y-m-d H:i:s');
				$detalle['updated_at']			= date('Y-m-d H:i:s');
				$this->venta_model->crearCotizacionProducto($detalle);
			}
			$data['dc']		= $data_cotizacion;
			$data['dcd']	= $data_lista_productos_cotizacion;
			echo json_encode($data);
    } else {
      redirect('auth/login', 'refresh');
    }
	}
	public function crearAcabado()
	{
		if ($this->ion_auth->logged_in())
        {
			$a = array(
				'id'      => '',
				'nombre'	=> $this->input->post('nombre'),
				'precio'	=> $this->input->post('precio'),
				'created_at'	=> date('Y-m-d H:i:s'),
				'estado'  =>  '1',
			);
		    $result =$this->producto_model->crearAcabado($a);
			echo json_encode($result);
			exit;
        }
        else
        {
          redirect('auth/login', 'refresh');
        }
	}

	public function deleteCotizacion_Producto($idC, $idP, $date, $time) {
	    if ($this->ion_auth->logged_in())
        {
            $dateFull = $date." ".$time;
    	    $this->venta_model->deleteCotizacion_Producto($idC, $idP, $dateFull);
			redirect('cotizacion/edit/' . $idC, 'refresh');
        }
        else {
          redirect('auth/login', 'refresh');
        }
	}

	public function aprobarCotizacion() {
		$id_cotizacion	= $_POST['id'];
		$res						= $this->venta_model->actualizar($id_cotizacion, array('estado' => 2));
		echo json_encode($res);
	}

	public function guia_remision($id_cotizacion) {
		if ($this->ion_auth->logged_in()){
			$this->venta_model->actualizar($id_cotizacion, array('estado'=>0));
			$data = array();
			$data = array(
                'serie' => 'T001',
                'correlativo' => $this->guia_model->getCorrelativo()->result()[0]->numero,
				'productos' => $this->venta_model->getProductosActivos(),
				'nombre_cliente' => $this->venta_model->obtener_nombre_cliente($id_cotizacion),
				'numero_documento' => $this->venta_model->obtener_numero_documento($id_cotizacion),
				'tipo_documento' => $this->venta_model->obtener_tipo_documento($id_cotizacion),
				'tipo_cotizacion' => $this->venta_model->tipo_cotizacion($id_cotizacion),
			);
			if ($data['tipo_cotizacion'] == 'PRODUCTO') {
				$this->load->model('Cotizacion_producto_model');
				$this->load->model('Remision_producto_model');
				$cotizacion_productos = $this->Cotizacion_producto_model->seleccionar_donde(array('cotizacion_id'=>$id_cotizacion));
				$temp = array();
				$id_remision_producto = array();
				foreach ($cotizacion_productos as $key) {
					$key->nombre_producto = $this->producto_model->obtener_nombre_producto($key->producto_id);
					if(sizeof($this->Remision_producto_model->seleccionar_donde(array('id_cotizacion'=>$id_cotizacion, 'cod'=>$key->producto_id))) == 0) {
						$temp['cod'] = $key->producto_id;
						$temp['descripcion'] = $key->nombre_producto;
						$temp['unidad_medida'] = 'Unidades';
						$temp['cantidad'] = $key->cantidad;
						$temp['create_at'] = date('Y-m-d H:i:s');
						$temp['id_cotizacion'] = $id_cotizacion;

						$id_remision_producto[] = $this->Remision_producto_model->agregar($temp);
					}//end if
				}//end foreach

				if(sizeof($id_remision_producto) == 0) {
					$remision_producto = $this->Remision_producto_model->seleccionar_donde(array('id_cotizacion'=>$id_cotizacion));
					foreach ($remision_producto as $r) {
						$id_remision_producto[] = $r->id;
					}//end foreach
				}//end if
				$data['id_remision_producto'] = $id_remision_producto;
				$data['cotizacion_productos'] = $cotizacion_productos;
			}//end if
			$this->load->view('/layout/top');
			$this->load->view('/menu/cotizacion/guia_remision',$data);
			$this->load->view('/layout/bottom');
        }//end if
        else {
          redirect('auth/login', 'refresh');
        }//end else
	}//end guia_remision

	public function factura($id_cotizacion) {
		$remision = $this->input->get('remision');
		
		if ($remision === 'true') {
			$cotizacionId = $this->venta_model->getCotizacionFromRemisionId($id_cotizacion);
			$remision_id_factura = $this->venta_model->getSerieNumeroRemision($id_cotizacion);
			
			
			if (isset($cotizacionId)) {
				$id_cotizacion = current($cotizacionId->result())->id_cotizacion;
			}
		}
		
		if ($this->ion_auth->logged_in()){
			$id_cliente = $this->venta_model->obtener_id_cliente($id_cotizacion);
			// print_r($id_cliente);
			// die;
			
			$direcciones = array(0=>$this->Cliente_model->obtener_direccion_principal($id_cliente));

			$direcciones = array_merge($direcciones, $this->Cliente_direccion_model->seleccionar_direcciones_con_id($id_cliente));
			
			
			$data = array(
				'remision_id_factura' => $remision_id_factura,
				'prods' => $this->producto_model->getProductosComprobante(),
				'numeros' => $this->venta_model->getUltimoNumeroComprobante(),
				'servicios' => $this->producto_model->getServiciosActivos(),
				'direcciones' => $direcciones,
				'numero_documento' => $this->venta_model->obtener_numero_documento($id_cotizacion),
				'nombre_cliente' => $this->venta_model->obtener_nombre_cliente($id_cotizacion),
				'direccion_cliente' => $this->venta_model->obtener_direccion_cliente($id_cotizacion),
				'telefono_cliente' => $this->venta_model->obtener_telefono_cliente($id_cotizacion),
				'email_cliente' => $this->venta_model->obtener_email_cliente($id_cotizacion),
				'serie_numero_remision' => $this->venta_model->obtener_serie_numero($id_cotizacion),
				'tipo_cotizacion' => $this->venta_model->tipo_cotizacion($id_cotizacion),
				'correlativo' => $this->venta_model->obtener_remision($id_cotizacion),
			);
			if ($data['tipo_cotizacion'] == 'PRODUCTO') {
				$this->load->model('Cotizacion_producto_model');
				$this->load->model('Remision_producto_model');
				$cotizacion_productos = $this->Cotizacion_producto_model->seleccionar_donde(array('cotizacion_id'=>$id_cotizacion));
				foreach ($cotizacion_productos as $key) {
					$key->nombre_producto = $this->producto_model->obtener_nombre_producto($key->producto_id);
				}//end foreach
				$data['cotizacion_productos'] = json_encode($cotizacion_productos);
			}//end if
			$this->load->view('menu/venta/create', $data);
		}//end if
		else {
			redirect('auth/login', 'refresh');
		}//end else
	}//end factura

	public function pendiente() {
		if ($this->ion_auth->logged_in()) {
			$data = array();
			$cots = $this->venta_model->getCotizacionesPendientes();
			foreach ($cots->result() as $cot) {
				$cot->user_name = $this->ion_auth->getName($cot->users_id);
				$cot->nombre_vendedor = $this->Vendedor_model->getName($cot->vendedor_id);
			}//end foreach
			$data['cots'] = $cots;
      		$this->load->view('/layout/top');
		  	$this->load->view('menu/cotizacion/pendiente', $data);
			$this->load->view('/layout/bottom');

		}//end if
		else {
			redirect('auth/login', 'refresh');
		}//end else
    }//end pendiente

    public function aceptada() {
		if ($this->ion_auth->logged_in()) {
			$data = array();
			$cots = $this->venta_model->getCotizacionesAceptadas();
			foreach ($cots->result() as $cot) {
				$cot->user_name = $this->ion_auth->getName($cot->users_id);
				$cot->nombre_vendedor = $this->Vendedor_model->getName($cot->vendedor_id);
			}//end foreach
			$data['cots'] = $cots;
      		$this->load->view('/layout/top');
		  	$this->load->view('menu/cotizacion/aceptada', $data);
			$this->load->view('/layout/bottom');

		}//end if
		else {
			redirect('auth/login', 'refresh');
		}//end else
	}//end aceptada

	# aprobados
	public function aprobadas() {
		if ($this->ion_auth->logged_in()) {
			$data_cotizaciones			= $this->venta_model->getCotizacionesByEstado('2'); # 2 -> COTIZACIONES APROBADAS
			foreach ($data_cotizaciones as $cot) {
				$cot->user_name				= $this->ion_auth->getName($cot->users_id);
				$cot->nombre_vendedor	= $this->Vendedor_model->getName($cot->vendedor_id);
			}
			$data['data_cotizaciones']	= $data_cotizaciones;
			$this->load->view('/layout/top');
			$this->load->view('menu/cotizacion/ventas/index_aprobadas', $data);
			$this->load->view('/layout/bottom');
		} else {
			redirect('auth/login', 'refresh');
		}
	}
	# verificados
	public function verificadas() {
		if ($this->ion_auth->logged_in()) {
			$data_cotizaciones			= $this->venta_model->getCotizacionesByEstado('3'); # 3 -> COTIZACIONES VERIFICADAS
			foreach ($data_cotizaciones as $cot) {
				$cot->user_name				= $this->ion_auth->getName($cot->users_id);
				$cot->nombre_vendedor	= $this->Vendedor_model->getName($cot->vendedor_id);
			}
			$data['data_cotizaciones']	= $data_cotizaciones;
			$this->load->view('/layout/top');
			$this->load->view('menu/cotizacion/ventas/index_verificadas', $data);
			$this->load->view('/layout/bottom');
		} else {
			redirect('auth/login', 'refresh');
		}
	}

	# -------------------------------------------------------------------------------------------------
	# ----------------------------------------- Area Logistica ----------------------------------------
	# -------------------------------------------------------------------------------------------------
	// Bandeja de cotizaciones aprobadas, para verificar la existencia de los mismos en almacenes
	public function logistica() {
		if ($this->ion_auth->logged_in()) {
			$data_cotizaciones			= $this->venta_model->getCotizacionesByEstado('2'); # 2 -> COTIZACIONES APROBADAS
			foreach ($data_cotizaciones as $cot) {
				$cot->user_name				= $this->ion_auth->getName($cot->users_id);
				$cot->nombre_vendedor	= $this->Vendedor_model->getName($cot->vendedor_id);
			}
			$data['data_cotizaciones']	= $data_cotizaciones;
			$this->load->view('/layout/top');
			$this->load->view('menu/cotizacion/logistica/index', $data);
			$this->load->view('/layout/bottom');
		} else {
			redirect('auth/login', 'refresh');
		}
	}

	public function verificar($id) {
		if ($this->ion_auth->logged_in()) {
			$data['data_productos']								= $this->producto_model->productos_con_id();
			$data['data_cotizacion'] 							= $this->venta_model->getCotizacionId($id);
			$data['cotizacion_detalle_productos']	= $this->venta_model->getCotizacionDetalleProductosVerificacionById($id);
			#$data['producto_cotizacion_detalle']	= $this->venta_model->getProductosCotizacionDetalleById($id);
			$this->load->view('/layout/top');
			$this->load->view('menu/cotizacion/logistica/verificar_productos',$data);
			$this->load->view('/layout/bottom');
		} else {
			redirect('auth/login', 'refresh');
		}
	}
	public function obtenerSeriesProducto() {
		$id		= $_POST['id'];
		$res	= $this->producto_model->getProductosSerieActivosById($id);
		echo json_encode($res);
	}
	public function obtenerCodigoLoteProducto() {
		$id		= $_POST['id'];
		$res	= '444'; #$this->producto_model->getProductosSerieActivosById($id);
		echo json_encode($res);
	}
	public function marcarCotizacionVerificada() {
		$id_cotizacion							= $_POST['id'];
		$data_series_productos			= $_POST['dsp'];
		$data_codigo_lote_productos	= $_POST['dclp'];
		# Registrar series productos cotizacion
		foreach($data_series_productos as $sp) {
			$data['series']						= $sp['series'];
			$response['series']				= $this->venta_model->actualizar_cotizacion_producto($id_cotizacion, $sp['id_producto'], $data);
		}
		# Registrar código de lote productos cotizacion
		foreach($data_codigo_lote_productos as $clp) {
			$data['codigo_lote']			= $clp['codigo_lote'];
			$response['codigo_lote']	= $this->venta_model->actualizar_cotizacion_producto($id_cotizacion, $clp['id_producto'], $data);
		}
		# Actualizar cotización como VERIFICADO
		$response['cotizacion']			= $this->venta_model->actualizar($id_cotizacion, array('estado' => 3)); # 3: VERIFICADO
		echo json_encode($response);
	}
}
