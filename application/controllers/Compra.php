
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Compra extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('url', 'language'));

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');

        $this->load->model(array(
            'Proveedor_model',
            'Producto_serie_model',
        ));
    }

    public function index() {

        if ($this->ion_auth->logged_in()) {
            $data = array();
            $compras = $this->compra_model->getCompras();
            foreach ($compras->result() as $compra) {
                $compra->proveedor = $this->Proveedor_model->obtener_nombre($compra->proveedor);
            }//end foreach
            $data['compras'] = $compras;
            $this->load->view('/layout/top');
            $this->load->view('menu/compra/index', $data);
            $this->load->view('/layout/bottom');
        } else {
            redirect('auth/login', 'refresh');
        }
    }

    public function create() {
        if ($this->ion_auth->logged_in()) {
            $data['data_productos']     = $this->producto_model->getProductosMapped();
            $data['proveedores']        = $this->Proveedor_model->seleccionar_con_id();
            $this->load->view('/layout/top');
            $this->load->view('menu/compra/create', $data);
            $this->load->view('/layout/bottom');
        } else {
            redirect('auth/login', 'refresh');
        }
    }

    public function obtener_productos_compra() {
        $data = $_POST;
        $productos = $this->compra_model->obtProductosCompra($data["compra_id"]);
        foreach ($productos->result() as $producto) {
            $producto->proveedor = $this->Proveedor_model->obtener_nombre($producto->proveedor);
        }//end foreach
        echo json_encode($productos->result());
        exit;
    }

    public function post() {
        if ($this->ion_auth->logged_in()) {
            # Registro de la compra (data compra)
            $data_compra                = $_POST['dc'];
            $data_compra['garantia']    = '';
            $data_compra['moneda']      = 'SOLES';
            $data_compra['tipocambio']  = null;
            $data_compra['estado']      = 1;
            $data_compra['users_id']    = $this->ion_auth->user()->row()->id;
            $compra_id                  = $this->compra_model->crearCompra($data_compra);
            $data_compra['id']          = $compra_id;

            # Data detalle compra (productos y actualizar stock) + lote y series de los productos
            $data_compra_detalle        = $_POST['ddc'];
            foreach($data_compra_detalle as $ddc) {
                if($ddc['tipo_registro_producto'] == 1) { # registrar SERIES
                    # REGISTRAR SERIES
                    $data_producto_serie = explode(',', $ddc['series_producto']);
                    foreach($data_producto_serie as $s) {
                        $data_serie['producto_id']  = $ddc['producto_id'];
                        $data_serie['serie']        = $s;
                        $data_serie['estado']       = '1'; # ?
                        $data_serie['created_at']   = date('Y-m-d H:i:s');
                        $this->Producto_serie_model->agregar($data_serie);
                    }
                } elseif($ddc['tipo_registro_producto'] == 2) { # registrar LOTE
                    $data_lote = []; # PENDIENTE
                } elseif($ddc['tipo_registro_producto'] == 3) { # registrar SERIES Y LOTE
                    # REGISTRAR SERIES
                    $data_producto_serie = explode(',', $ddc['series_producto']);
                    foreach($data_producto_serie as $s) {
                        $data_serie['producto_id']  = $ddc['producto_id'];
                        $data_serie['serie']        = $s;
                        $data_serie['estado']       = '1'; # ?
                        $data_serie['created_at']   = date('Y-m-d H:i:s');
                        $this->Producto_serie_model->agregar($data_serie);
                    }
                    # REGISTRAR LOTE
                    $data_lote = []; # PENDIENTE
                }
                # eliminamos data no necesaria para registrar la compra_producto
                unset($ddc['tipo_registro_producto'], $ddc['lote'], $ddc['series_producto']);
                # Registro de compra_producto
                $ddc['compra_id']           = $compra_id;
                $ddc['producto_serie_id']   = null; # ? cual de todos los producto_serie_id es ?
                $this->producto_model->sumarStock($ddc['producto_id'], (float) $ddc['cantidad']);
                $this->compra_model->crearCompraProducto($ddc);
            }
            echo json_encode($data_compra);
        } else {
            redirect('auth/login', 'refresh');
        }
    }

    public function obtener_series($id) {
        echo json_encode($this->Producto_serie_model->seleccionar($id));
    }//end obtener_series

}
