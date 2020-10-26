<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pendientes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('url', 'language'));

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
    }

    public function index() {
        if ($this->ion_auth->logged_in()) {
            $data = array('boletas' => $this->venta_model->getBoletasPendientes(),
                'facturas' => $this->venta_model->getFacturasPendientes());
            $this->load->view('/layout/top');
            $this->load->view('menu/pendientes/index', $data);
            $this->load->view('/layout/bottom');
        } else {
            redirect('auth/login', 'refresh');
        }
    }

    public function productos() {
        if ($this->ion_auth->logged_in()) {
            $data = array('prods' => $this->producto->getProductos());
            $this->load->view('/layout/top');
            $this->load->view('menu/productos', $data);
            $this->load->view('/layout/bottom');
        } else {
            redirect('auth/login', 'refresh');
        }
    }

    public function boletas() {

        date_default_timezone_set('America/Lima');

        $fecha = date('Y-m-d');

        $conexion = new PDO("mysql:host=" . $this->db->hostname . ";dbname=" . $this->db->database . "", "" . $this->db->username . "", "" . $this->db->password . "", array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"
                )
        );
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $query = "SELECT 
        
        b.id,
        b.serie,
        LPAD(b.numero,8,'0')numero,
        DATE_FORMAT(b.fecha,'%d/%m/%Y')fecha,
        b.venta_id,
        b.dni,
        b.cliente,
        v.total,
        TIMESTAMPDIFF(DAY, b.fecha, :fecha) AS dias_transcurridos
        ,
        b.estado_api
        
        FROM boleta b 
        INNER  JOIN 
        ( 
        SELECT 
        SUM(total) total, 
        venta_id FROM venta_producto 
        GROUP BY venta_id 
        
        )v 
        ON b.venta_id=v.venta_id WHERE b.estado_api=''";

        $statement = $conexion->prepare($query);
        $statement->bindParam(':fecha', $fecha);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(array('data' => $result));
    }

    public function facturas() {


        date_default_timezone_set('America/Lima');

        $fecha = date('Y-m-d');


        $conexion = new PDO("mysql:host=" . $this->db->hostname . ";dbname=" . $this->db->database . "", "" . $this->db->username . "", "" . $this->db->password . "", array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"
                )
        );
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $query = "
        
        SELECT 
        f.id,
        f.serie,
        LPAD(f.numero,8,'0')numero,
        DATE_FORMAT(f.fecha,'%d/%m/%Y')fecha,
        f.venta_id,
        f.ruc,
        f.cliente,
        v.total,
        TIMESTAMPDIFF(DAY, f.fecha, :fecha) AS dias_transcurridos
        ,
        f.estado_api
        
        FROM factura f
        INNER JOIN 
        ( 
        SELECT 
        SUM(total) total, 
        venta_id FROM venta_producto 
        GROUP BY venta_id 
        
        )v 
        ON f.venta_id=v.venta_id WHERE f.estado_api=''

        
        
        ";

        $statement = $conexion->prepare($query);
        $statement->bindParam(':fecha', $fecha);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(array('data' => $result));
    }

    function documentos_pendientes() {

        $conexion = new PDO("mysql:host=" . $this->db->hostname . ";dbname=" . $this->db->database . "", "" . $this->db->username . "", "" . $this->db->password . "", array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"
                )
        );
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "SELECT 
        
        COUNT(*)cantidad
        
        FROM boleta b
        INNER JOIN 
        ( 
        SELECT 
        SUM(total) total, 
        venta_id FROM venta_producto 
        GROUP BY venta_id 
        
        )v 
        ON b.venta_id=v.venta_id WHERE b.envio='pendiente'
        
        UNION
        
        SELECT 
        
        COUNT(*)cantidad
        
        FROM factura f
        INNER JOIN 
        ( 
        SELECT 
        SUM(total) total, 
        venta_id FROM venta_producto 
        GROUP BY venta_id 
        
        )v 
        ON f.venta_id=v.venta_id WHERE f.estado_api=''";


        $statement = $conexion->prepare($query);

        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        //echo json_encode(array('data'=>$result));

        $cant = 0;

        foreach ($result as $key => $value) {

            $cant = $value['cantidad'] + $cant;
        }

        echo json_encode(array('cantidad' => $cant));
    }

}
