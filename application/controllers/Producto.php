<?php

defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Producto extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('url', 'language'));
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('auth');
        $this->load->model(array(
            'Producto_serie_model'
        ));
    }

    public function index()
    {
        if ($this->ion_auth->logged_in()) {
            $data = array();
            $this->load->view('/guest/top');
            $this->load->view('productos', $data);
            $this->load->view('/guest/bottom');
        } //end if
        else {
            redirect('auth/login', 'refresh');
        } //end else
    } //end index

    public function menu() {
        if ($this->ion_auth->logged_in()) {
            $data['data_productos'] = $this->producto_model->getProductosMapped();
            $this->load->view('/layout/top');
            $this->load->view('menu/producto/index', $data);
            $this->load->view('/layout/bottom');
        } else {
            redirect('auth/login', 'refresh');
        }
    }

    public function create() { # crear nuevo producto
        if ($this->ion_auth->logged_in()) {
            $data['unidades_medida']    = $this->venta_model->getUnidadesMedida();
            #$data['prods']              = $this->producto_model->getAllProductos();
            $this->load->view('/layout/top');
            $this->load->view('/menu/producto/create', $data);
            $this->load->view('/layout/bottom');
        } else {
            redirect('auth/login', 'refresh');
        }
    }

    public function post() {
        if ($this->ion_auth->logged_in()) {
            # data del producto
            $data_producto                      = (array) json_decode($_POST['data']);
            $data_producto['unidad_medida_id']  = 1;
            $data_producto['caracteristica1']   = '';
            $data_producto['caracteristica2']   = '';
            $data_producto['caracteristica3']   = '';
            $data_producto['estado']            = '1';
            $data_producto['created_at']        = date("Y-m-d H:i:s");

            # imagen del producto -> $_FILES['image'];
            $uploaded = true;
            $fileName = null;
            try {
                if(!empty($_FILES['image'])) {
                    $path = "uploads/productos/";
                    $name = explode('.', basename($_FILES['image']['name']));
                    $path .= "producto_" . time() . "." . end($name);
                    $fileName = $path;
                    if(move_uploaded_file($_FILES['image']['tmp_name'], $path)) {
                        $uploaded = true;
                    } else{
                        $uploaded = false;
                    }
                }
            } catch (Exception $exception) { /** No hacer nada si no se puede subir la foto **/ }
            if($uploaded) {
                $data_producto['image'] = $fileName;
            }
            # registrar producto
            $id_producto = $this->venta_model->crearProducto($data_producto);

            # series de los productos
            $data_series_producto   = (array) json_decode($_POST['data_series']);
            for ($i = 0; $i < count($data_series_producto); $i++) {
                if (sizeof($this->Producto_serie_model->seleccionar_donde(array('producto_id' => $id_producto, 'serie' => $data_series_producto[$i]))) == 0) {
                    $temp = array(
                        'producto_id' => $id_producto,
                        'serie' => $data_series_producto[$i],
                        'created_at' => date("Y-m-d H:i:s"),
                        'estado' => 1 # Uno es el estado de disponible y 2 el estado de vendido
                    );
                    $this->Producto_serie_model->agregar($temp);
                }
            }
            echo json_encode($data_producto);
        } else {
            redirect('auth/login', 'refresh');
        }
    }

    public function series_de_producto()
    {
        if ($this->ion_auth->logged_in()) {
            $data = array();
            $data['productos'] = $this->producto_model->productos_con_id();
            $this->load->view('/layout/top');
            $this->load->view('/menu/producto/serie', $data);
            $this->load->view('/layout/bottom');
        } //end if
        else {
            redirect('auth/login', 'refresh');
        } //end else
    } //end series_de_producto

    public function verificar_serie()
    {
        $data = $_POST;
        $serie = $data["serie"];
        $producto_id = $data["producto_id"];
        $resp = $this->producto_model->getSeriesRepetidos($serie, $producto_id)->respuesta;
        echo json_encode($resp);
        exit;
    }

    public function verificar_cod_barra()
    {
        $data = $_POST;
        $resp = $this->producto_model->getCodigoBarraExiste($data["codigo_barra"])->respuesta;
        echo json_encode($resp);
        exit;
    }

    public function series()
    {
        $data = $_POST;
        $resp = $this->producto_model->getProductosSerieActivos($data["producto_id"]);
        echo json_encode($resp->result());
        exit;
    } //end series


    public function obtener_series($id)
    {
        $resp = $this->Producto_serie_model->seleccionar_donde(array('producto_id' => $id));
        echo json_encode($resp);
    } //end series

    public function agregar_serie()
    {
        if ($this->ion_auth->logged_in()) {
            $id_producto = $this->input->post('producto_id');
            $serie = $this->input->post('serie[]');
            for ($i = 0; $i < sizeof($serie); $i++) {
                if (sizeof($this->Producto_serie_model->seleccionar_donde(array('producto_id' => $id_producto, 'serie' => $serie[$i]))) == 0) {
                    $temp = array(
                        'producto_id' => $id_producto,
                        'serie' => $serie[$i],
                        'created_at' => date("Y-m-d H:i:s"),
                        'estado' => 1 /* Uno es el estado de disponible y 2 el estado de vendido */
                    );
                    $this->Producto_serie_model->agregar($temp);
                } //end if
            } //end ofr
            echo $id_producto;
        } //end if
        else {
            redirect('auth/login', 'refresh');
        } //end else
    } //end agregar_serie

    public function post_anterior()
    {
        if ($this->ion_auth->logged_in()) {
            $serie = $this->input->post('serie[]') ?? [];
            $p = array(
                'id' => '',
                'nombre' => $this->input->post('nombre'),
                'stock' => $this->input->post('stock'),
                'unidad_medida_id' => 1,
                'precio_venta' => $this->input->post('precio_venta'),
                'precio_compra' => $this->input->post('precio_compra'),
                'marca' => $this->input->post('marca'),
                'caracteristica1' => $this->input->post('caracteristica1'),
                'caracteristica2' => $this->input->post('caracteristica2'),
                'caracteristica3' => $this->input->post('caracteristica3'),
                'estado' => '1',
                'created_at' => date("Y-m-d H:i:s"),
                'codigo_referencia' => $this->input->post('codigo_referencia'),
                'modelo' => $this->input->post('modelo'),
                'nro_seccion' => $this->input->post('nro_seccion'),
                'lote' => $this->input->post('lote'),
                'precio_institucional' => $this->input->post('precio_institucional'),
                'precio_compra_extranjero' => $this->input->post('precio_compra_extranjero'),
                'procedencia' => $this->input->post('procedencia'),
                'numero_dua' => $this->input->post('numero_dua'),
                'presentacion' => $this->input->post('presentacion'),
                'ubicacion' => $this->input->post('ubicacion'),
                'tipo_compra' => $this->input->post('tipo_compra'),
                'registro_sanitario' => $this->input->post('registro_sanitario'),
                'fabricante' => $this->input->post('fabricante'),
                'codigo_barra' => $this->input->post('codigo_barra'),
                'estado_serie' => $this->input->post('trabajarConSeries')
            );

            $uploaded = true;
            $fileName = null;

            try {
				if(!empty($_FILES['productImage']))
				{
					$path = "uploads/productos/";
					$name = explode('.', basename($_FILES['productImage']['name']));
					$path .= "producto_" . time() . "." . end($name);
					$fileName = $path;

					if(move_uploaded_file($_FILES['productImage']['tmp_name'], $path)) {
						$uploaded = true;
					} else{
						$uploaded = false;
					}
				}
			} catch (Exception $exception) { /** No hacer nada si no se puede subir la foto **/ }


			if ($uploaded) {
				$p['image'] = $fileName;
			}

            $id_producto = $this->venta_model->crearProducto($p);
            for ($i = 0; $i < sizeof($serie); $i++) {
                if (sizeof($this->Producto_serie_model->seleccionar_donde(array('producto_id' => $id_producto, 'serie' => $serie[$i]))) == 0) {
                    $temp = array(
                        'producto_id' => $id_producto,
                        'serie' => $serie[$i],
                        'created_at' => date("Y-m-d H:i:s"),
                        'estado' => 1 /* Uno es el estado de disponible y 2 el estado de vendido */
                    );
                    $this->Producto_serie_model->agregar($temp);
                } //end if
            } //end ofr

            redirect('producto/menu', 'refresh');
        } else {
            redirect('auth/login', 'refresh');
        }
    }

    public function guardar_imagenes_cotizacion() {
        if ($this->ion_auth->logged_in()) {
            $this->load->model('Producto_cotizacion_caracteristica_model');

            $file   = $_FILES['image1']['tmp_name'];
            $file2  = $_FILES['image2']['tmp_name'];
            $image  = $_FILES['image1']['name'];
            $image2 = $_FILES['image2']['name'];

            if (!empty($file)) {
                if (is_uploaded_file($file)) {
                    $target = "uploads/" . time() . "_" . basename($image);
                } else {
                    $target = $this->input->post('image1Set');
                }
                if (move_uploaded_file($_FILES['image1']['tmp_name'], $target)) {}
            }
            if (!empty($file2)) {
                if (is_uploaded_file($file2)) {
                    $target2 = "uploads/" . time() . "_" . basename($image2);
                } else {
                    $target2 = "";
                }
                if (move_uploaded_file($_FILES['image2']['tmp_name'], $target2)) {}
            }
            $data_imagenes = [];
            $data_imagenes['image1'] = null;
            $data_imagenes['image2'] = null;
            if (!empty($target)) {
                $data_imagenes['image1'] = $target;
            }
            if (!empty($target2)) {
                $data_imagenes['image2'] = $target2;
            }
            echo json_encode($data_imagenes);
        } else {
            redirect('auth/login', 'refresh');
        }
    }

    public function postProductoRemision()
    {
        if ($this->ion_auth->logged_in()) {
        	$productId = (int)$this->input->post('productId');
			// $id= $this->input->post('id');
			$cod = $this->input->post('cod');
			$descripcion = $this->input->post('descripcion');
			$unidad_medida = $this->input->post('unidad_medida');
			$cantidad = $this->input->post('cantidad');

			$p = array(
				'id' => $productId !== 0 ? ($productId ?? '') : '',
				'cod' => $cod,
				'descripcion' => $descripcion,
				'unidad_medida' => $unidad_medida,
				'cantidad' => $cantidad
			);

			if ($productId === 0) {
				$remision_producto_id = $this->venta_model->crearProductoRemision($p);
			} else {
				$remision_producto_id = $this->venta_model->actualizarProductoRemision($productId, $p);
			}
            //   $result = '<input name="producto_id[]" value="'.$cotizacion_producto_id.'" hidden>';
            echo $remision_producto_id;
        } else {
            redirect('auth/login', 'refresh');
        }
    }

    public function edit($id) {
        if ($this->ion_auth->logged_in()) {
            $data['data_producto']          = $this->producto_model->getProductoById($id);
            $data['data_series_producto']   = $this->producto_model->getProductoSerie($id, true);
            $this->load->view('/layout/top');
            $this->load->view('/menu/producto/edit', $data);
            $this->load->view('/layout/bottom');
        } else {
            redirect('auth/login', 'refresh');
        }
    }

    public function update() {
        if ($this->ion_auth->logged_in()) {
            # data del producto
            $data_producto                  = (array) json_decode($_POST['data']);
            $data_producto['updated_at']    = date("Y-m-d H:i:s");

            # imagen del producto -> $_FILES['image'];
            $fileName = null;
            try {
                if(!empty($_FILES['image'])) {
                    $path = "uploads/productos/";
                    $name = explode('.', basename($_FILES['image']['name']));
                    $path .= "producto_" . time() . "." . end($name);
                    $fileName = $path;
                    if(move_uploaded_file($_FILES['image']['tmp_name'], $path)) {}
                }
            } catch (Exception $exception) { /** No hacer nada si no se puede subir la foto **/ }
            $data_producto['image'] = $fileName;

            if($data_producto['image'] == null) # no actualizamos si no hay una imagen cargada
                unset($data_producto['image']);

            # actualizar producto
            $id_producto    = $data_producto['id'];
            $this->venta_model->actualizarProductoById($id_producto, $data_producto);

            # PENDIENTE como identificar que fueron las series que registré
            # series de los productos
            if($data_producto['tipo_registro_producto']=='1' || $data_producto['tipo_registro_producto']=='3') {
                # obtener series anteriores
                # eliminar series antiguas
            }
            # registrar nuevas series
            $data_series_producto   = (array) json_decode($_POST['data_series']);
            for ($i = 0; $i < count($data_series_producto); $i++) {
                if (sizeof($this->Producto_serie_model->seleccionar_donde(array('producto_id' => $id_producto, 'serie' => $data_series_producto[$i]))) == 0) {
                    $temp = array(
                        'producto_id' => $id_producto,
                        'serie' => $data_series_producto[$i],
                        'created_at' => date("Y-m-d H:i:s"),
                        'estado' => 1 # Uno es el estado de disponible y 2 el estado de vendido
                    );
                    #$this->Producto_serie_model->agregar($temp);
                }
            }

            /*
                $serie = $this->input->post('serie[]') ?? [];
			$deletedSeries = explode(',', $this->input->post('deletedSeries'));
			foreach ($deletedSeries as $deletedId) {
				$this->Producto_serie_model->eliminar($deletedId);
			}
			for ($i = 0; $i < sizeof($serie); $i++) {
				if (sizeof($this->Producto_serie_model->seleccionar_donde(array('producto_id' => $this->input->post("id"), 'serie' => $serie[$i]))) == 0) {
					$temp = array(
						'producto_id' => $this->input->post("id"),
						'serie' => $serie[$i],
						'created_at' => date("Y-m-d H:i:s"),
						'estado' => 1 // Uno es el estado de disponible y 2 el estado de vendido 
					);
					$this->Producto_serie_model->agregar($temp);
				} //end if
			} //end ofr
            */
            echo json_encode($data_producto);
        } else {
            redirect('auth/login', 'refresh');
        }
    }
    public function serie($id)
    {
        if ($this->ion_auth->logged_in()) {
            $data = array('prods' => $this->producto_model->getProductosSerie($id));

            $this->load->view('/layout/top');
            $this->load->view('/menu/producto/serie', $data);
            $this->load->view('/layout/bottom');
        } else {
            redirect('auth/login', 'refresh');
        }
    }

    

    public function importar()
    {
        if ($this->ion_auth->logged_in()) {

            // print_r($this->input->post());
            // print_r($this->input->file('archivo'));

            $config['upload_path']          = './uploads/';
            $config['allowed_types']        = 'csv|xls|xlsx';
            $config['max_size']             = 100;
            $config['max_width']            = 1024;
            $config['max_height']           = 768;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('archivo')) {
                // $error = array('error' => $this->upload->display_errors());
                $dataReturn["msg"]=$this->upload->display_errors();
                $dataReturn["error"]=true;
                $dataReturn["status"]=false;

            } else {
                $uploadData = $this->upload->data();
                // $data = array('upload_data' => $this->upload->data());
                $fullPath = $uploadData['full_path'];

                switch ($uploadData['file_ext']) {
                    case '.csv':
                        $reader = new Csv();
                        break;
                    case '.xls':
                        $reader = new Xls();
                        break;
                    case '.xlsx':
                        $reader = new Xlsx();
                        break;
        
                    default:
                        $reader = new Csv();
                        break;
                }

                // cargamos el archivo
                $spreadsheet = $reader->load($fullPath);

                // iniciamos la transaccion
                $this->db->trans_begin();
                $terminar = true;

                $loadedSheetNames = $spreadsheet->getSheetNames();
                foreach ($loadedSheetNames as $sheetIndex => $loadedSheetName) {
                    $spreadsheet->setActiveSheetIndexByName($loadedSheetName);
                    $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
    
                    foreach ($sheetData as $key => $value) {
                        if (!empty($value['A'])) {
                            // preparamos los registros a almacenar
                            $dataSave = [
                                'nombre' => $value['A'],
                                'stock' => $value['B'],
                                'tipo' => $value['C'],
                                'unidad_medida_id' => $value['D'],
                                'codigo_barra' => $value['E'],
                                'precio_venta' => $value['F'],
                                'precio_compra' => $value['G'],
                                'fabricante' => $value['H'],
                                'estado' => $value['I'],
                                'eliminado' => $value['J'],
                                'caracteristica1' => $value['K'],
                                'marca' => $value['L'],
                                'procedencia' => $value['M'],
                                'image' => $value['N'],
                                'caracteristica2' => $value['O'],
                                'caracteristica3' => $value['P'],
                                'modelo' => $value['Q'],
                                'nro_seccion' => $value['R'],
                                'serie' => $value['S'],
                                'lote' => $value['T'],
                                'precio_institucional' => $value['U'],
                                'precio_compra_extranjero' => $value['V'],
                                'codigo_referencia' => $value['W'],
                            ];
                            // procedemos a guardar el registro
                            $resultadoGuardar = $this->producto_model->guardar($dataSave);
                            if (!$resultadoGuardar['status']) {
                                $terminar = false;
                            }
                        }
                    }
                }
                if ($terminar) {
                    //terminamos la transaccion
                    $this->db->trans_commit();
                    $dataReturn["msg"]="Importación Finalizada con Exito.";
                    $dataReturn["status"]=true;
                    $dataReturn["redirect"]=site_url('producto/menu');

                } else {
                    // devolvemos la transaccion
                    $this->db->trans_rollback();
                    $dataReturn["msg"]='No Se Pudo Finalizar La Importación';
                    // $dataReturn["error"]=true;
                    $dataReturn["status"]=false;
                }
            }

            // preparamos la respuesta
            echo json_encode($dataReturn);		
        } else {
            redirect('auth/login', 'refresh');
        }
    }
    public function getDataProducto() {
        $producto_id    = $_POST['id'];
        $producto       = $this->producto_model->getProductoById($producto_id);
        echo json_encode($producto);
    }

}