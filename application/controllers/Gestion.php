<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Gestion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('url', 'language'));
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('auth');
        $this->load->model(array(
            'Vendedor_model',
            'Meta_model',
            'Cotizacion_model',
            'Cliente_model',
            'Guia_model',
        ));
    }//end __construct

    public function efectividad() {
        if ($this->ion_auth->logged_in()) {
            $data = array();
            $data['cotizaciones'] = $this->Cotizacion_model->cotizaciones_mensuales($anio_mes = date('Y-m'));
            // print("<pre>".print_r($data['cotizaciones'],TRUE)."</pre>");

            $this->load->view('/layout/top');
            $this->load->view('menu/gestion/index', $data);
            $this->load->view('/layout/bottom');
        }//end else
        else {
            redirect('auth/login', 'refresh');
        }//end else
    }//end efectividad

    public function meta() {
        if ($this->ion_auth->logged_in()) {
            $data = array();
            $data['existe_meta_trimestral'] = $this->Meta_model->seleccionar_donde(array("date_format(created_at, '%Y') = "=> date('Y'), 'estado'=>1));
            $data['existe_meta_anual'] = $this->Meta_model->seleccionar_donde(array("anio = "=> date('Y'), 'estado'=>2));
            $data['grafica_trimestral'] = $this->grafica_trimestral($data['existe_meta_trimestral']);
            $data['grafica_anual'] = $this->grafica_anual($data['existe_meta_anual']);
            // print("<pre>".print_r($this->venta_model->total_trimestre(1, 3),true)."</pre>");
            $this->load->view('/layout/top');
            $this->load->view('menu/gestion/meta', $data);
            $this->load->view('/layout/bottom');
        }//end else
        else {
            redirect('auth/login', 'refresh');
        }//end else
    }//end meta

    public function seace() {
        if ($this->ion_auth->logged_in()) {
            $data = array();
            $data['productos'] = $this->producto_model->productos_con_id();
            // print("<pre>".print_r($this->venta_model->total_trimestre(1, 3),true)."</pre>");
            $this->load->view('/layout/top');
            $this->load->view('menu/gestion/seace', $data);
            $this->load->view('/layout/bottom');
        }//end else
        else {
            redirect('auth/login', 'refresh');
        }//end else
    }//end seace

    public function digemid() {
        if ($this->ion_auth->logged_in()) {
            $data = array();
            $data['productos'] = $this->producto_model->productos_con_id();
            // print("<pre>".print_r($this->venta_model->total_trimestre(1, 3),true)."</pre>");
            $this->load->view('/layout/top');
            $this->load->view('menu/gestion/digemid', $data);
            $this->load->view('/layout/bottom');
        }//end else
        else {
            redirect('auth/login', 'refresh');
        }//end else
    }//end seace

    public function resumen_ventas_digemid() {
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
                                
                    b.cliente,
                    b.direccion,
                    f.ruc,
                    b.serie,
                    CONCAT(b.serie,'-',LPAD(b.numero,6,'0'))numero,
                    v.metodo_pago,
                    DATE_FORMAT(b.fecha,'%d/%m/%Y') fecha,
                    DATE_FORMAT(f.vencimiento,'%d/%m/%Y') vencimiento,
                    vp.texto_ref as detalle_producto,
                    vp.cantidad,
                    vp.precio_unidad,
                    v.total_igv as igv,
                    vp.subtotal,
                    vp.total,
                    v.orden_servicio,
                    v.guia_remision,
                    rp.descripcion as bienes,
                    r.partida_direccion,
                    r.llegada_direccion,
                    v.guia_remision_numeros 
                    

                    FROM boleta b

                    INNER JOIN venta v ON v.id=b.venta_id
                    LEFT JOIN factura f ON v.id=f.venta_id
                    LEFT JOIN venta_producto vp ON v.id=vp.venta_id
                    LEFT JOIN remision r ON v.remision_id=r.id
                    LEFT JOIN remision_producto rp ON r.id=rp.remision_id

                    WHERE DATE_FORMAT(b.fecha,'%Y-%m') 
                    BETWEEN :periodoInicio AND :periodoFin

                    ";
                    break;
                    case 'factura':

                        $query = "
                        
                            SELECT

                            f.cliente,
                            f.direccion,
                            f.ruc,
                            f.serie,
                            CONCAT(f.serie,'-',LPAD(f.numero,6,'0'))numero,
                            v.metodo_pago,
                            DATE_FORMAT(f.fecha,'%d/%m/%Y') fecha,
                            DATE_FORMAT(f.vencimiento,'%d/%m/%Y') vencimiento,
                            vp.texto_ref as detalle_producto,
                            vp.cantidad,
                            vp.precio_unidad,
                            v.total_igv as igv,
                            vp.subtotal,
                            vp.total,
                            v.orden_servicio,
                            v.guia_remision,
                            rp.descripcion as bienes,
                            r.partida_direccion,
                            r.llegada_direccion,
                            v.guia_remision_numeros 

                            FROM factura f

                            INNER JOIN venta v ON f.venta_id=v.id
                            LEFT JOIN venta_producto vp ON v.id=vp.venta_id
                            LEFT JOIN remision r ON v.remision_id=r.id
                            LEFT JOIN remision_producto rp ON r.id=rp.remision_id

                            WHERE DATE_FORMAT(f.fecha,'%Y-%m')
                            BETWEEN :periodoInicio AND :periodoFin
                        ";

                        break;
                    case 'facturaboleta':

                        $query = "
                            SELECT
                                    
                            b.cliente,
                            b.direccion,
                            f.ruc,
                            b.serie,
                            CONCAT(b.serie,'-',LPAD(b.numero,6,'0'))numero,
                            v.metodo_pago,
                            DATE_FORMAT(b.fecha,'%d/%m/%Y') fecha,
                            DATE_FORMAT(f.vencimiento,'%d/%m/%Y') vencimiento,
                            vp.texto_ref as detalle_producto,
                            vp.cantidad,
                            vp.precio_unidad,
                            v.total_igv as igv,
                            vp.subtotal,
                            vp.total,
                            v.orden_servicio,
                            v.guia_remision,
                            rp.descripcion as bienes,
                            r.partida_direccion,
                            r.llegada_direccion,
                            v.guia_remision_numeros 

                            FROM venta v

                            INNER JOIN boleta b ON v.id=b.venta_id
                            LEFT JOIN factura f ON v.id=f.venta_id
                            LEFT JOIN venta_producto vp ON v.id=vp.venta_id
                            LEFT JOIN remision r ON v.remision_id=r.id
                            LEFT JOIN remision_producto rp ON r.id=rp.remision_id

                            WHERE DATE_FORMAT(b.fecha,'%Y-%m')
                            BETWEEN :periodoInicio AND :periodoFin

                            UNION

                            SELECT

                            f.cliente,
                            f.direccion,
                            f.ruc,
                            f.serie,
                            CONCAT(f.serie,'-',LPAD(f.numero,6,'0'))numero,
                            v.metodo_pago,
                            DATE_FORMAT(f.fecha,'%d/%m/%Y') fecha,
                            DATE_FORMAT(f.vencimiento,'%d/%m/%Y') vencimiento,
                            vp.texto_ref as detalle_producto,
                            vp.cantidad,
                            vp.precio_unidad,
                            v.total_igv as igv,
                            vp.subtotal,
                            vp.total,
                            v.orden_servicio,
                            v.guia_remision,
                            rp.descripcion as bienes,
                            r.partida_direccion,
                            r.llegada_direccion,
                            v.guia_remision_numeros 

                            FROM factura f

                            INNER JOIN venta v ON f.venta_id=v.id
                            LEFT JOIN venta_producto vp ON v.id=vp.venta_id
                            LEFT JOIN remision r ON v.remision_id=r.id
                            LEFT JOIN remision_producto rp ON r.id=rp.remision_id

                            WHERE DATE_FORMAT(f.fecha,'%Y-%m')
                            BETWEEN :periodoInicio AND :periodoFin

					    ";
                            break;
                        default;
                            break;
			}

			$statement = $conexion->prepare($query);
			$statement->bindParam(':periodoInicio', $_REQUEST['periodo_inicio']);
			$statement->bindParam(':periodoFin', $_REQUEST['periodo_fin']);
			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);

			echo json_encode(array('data' => $result));
		} else {
			redirect('auth/login', 'refresh');
		}
	}

    public function agregar_meta_trimestral() {
        if ($this->ion_auth->logged_in()) {
            $trimestres = $this->input->post('trimestre[]');
            $count = 0;
            for ($i=0; $i < sizeof($trimestres); $i++) {
                $temp = array(
                    'estado' => 1, /* Uno es para trimestral*/
                    'meta' => $trimestres[$i],
                    'trimestre' => ++$count
                );
                $this->Meta_model->agregar($temp);
            }//end for

            redirect('gestion/meta', 'refresh');
        }//end else
        else {
            redirect('auth/login', 'refresh');
        }//end else
    }//end agregar_meta_trimestral

    public function editar_meta_trimestral() {
        if ($this->ion_auth->logged_in()) {
            $trimestres = $this->input->post('trimestre[]');
            $ids = $this->input->post('i[]');
            for ($i=0; $i < sizeof($trimestres); $i++) {
                $temp = array(
                    'meta' => $trimestres[$i]
                );
                $this->Meta_model->actualizar($ids[$i], $temp);
            }//end for

            redirect('gestion/meta', 'refresh');
        }//end else
        else {
            redirect('auth/login', 'refresh');
        }//end else
    }//end editar_meta_trimestral

    public function agregar_meta_anual() {
        if ($this->ion_auth->logged_in()) {
            $anual['meta'] = $this->input->post('meta_anio');
            $anual['anio'] = date('Y');
            $anual['estado'] = 2;

            $this->Meta_model->agregar($anual);

            redirect('gestion/meta', 'refresh');
        }//end else
        else {
            redirect('auth/login', 'refresh');
        }//end else
    }//end agregar_meta_anual

    public function editar_meta_anual() {
        if ($this->ion_auth->logged_in()) {
            $id = $this->input->post('i');
            $anual['meta'] = $this->input->post('meta_anio');

            $this->Meta_model->actualizar($id, $anual);
            redirect('gestion/meta', 'refresh');
        }//end else
        else {
            redirect('auth/login', 'refresh');
        }//end else
    }//end editar_meta_anual

	public function reporte() {
		if ($this->ion_auth->logged_in()) {
			$fecha_inicio = $this->input->post('fecha_inicio');
			$fecha_fin = $this->input->post('fecha_fin');
			$segmento = $this->input->post('rubro');
			$id_producto = $this->input->post('id_producto');
			$clientesIds = [];
			$ventasIds = $this->venta_model->getVentasFromProductId($id_producto);

			if($segmento == 'todos') {
				$clientes = $this->Cliente_model->seleccionar_todo();
			}
			else {
				$clientes = $this->Cliente_model->seleccionar_donde(array('segmento'=>$segmento));
			}

			foreach ($clientes as $cliente) {
				$clientesIds[] = "'" . $cliente->nombre_cliente . "'";
			}

			if (empty($clientes)) {
				$resultadoFacturas = [];
			} else {
				$resultadoFacturas = $this->venta_model->getAllProducts($fecha_inicio, $fecha_fin, $ventasIds, $clientesIds, $segmento)->result();
			}

			$facturas = [];
			foreach ($resultadoFacturas as $factura) {
				$options = '';
				$options .= '<a href="/prueba?tipo=facturaA4&id=' . $factura->id . '" target="_blank"><i class="far fa-file-alt"></i> &nbsp;Factura</a><br>';
				$options .= '<a href="/prueba?tipo=remisionA4&idcotizacion=' . $factura->remisionid . '" target="_blank"><i class="far fa-file-alt"></i> &nbsp;Remisión</a><br>';
				// $options .= '<a href="http://viatmcpro.local/cotizacion/factura/93?remision=true" target="_blank"><i class="far fa-file-alt"></i> &nbsp;Cotización</a><br>';
				$facturas[] = [
					$factura->serie,
					$factura->numero,
					$factura->fecha_emision,
					$factura->cliente,
					$factura->ruc,
					$options
				];
			}//end foreach

			header('Content-type: application/json');
			echo json_encode($facturas);
		}//end else
		else {
			redirect('auth/login', 'refresh');
		}//end else
	}//end reporte

    public function grafica_trimestral($datos) {
        $html = '';
        if(sizeof($datos) > 0) {
            $html .='
            google.charts.load("current", {"packages":["bar"]});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ["Trimestres", "Meta", "Total"],
                    ["Ene-Mar", '.$datos[0]->meta.', '.($this->venta_model->total_trimestre(1, 3) == 0 ? 0.0 : $this->venta_model->total_trimestre(1, 3)).'],
                    ["Abr-Jun", '.$datos[1]->meta.', '.($this->venta_model->total_trimestre(4, 6) == 0 ? 0.0 : $this->venta_model->total_trimestre(4, 6)).'],
                    ["Jul-Sep", '.$datos[2]->meta.', '.($this->venta_model->total_trimestre(7, 9) == 0 ? 0.0 : $this->venta_model->total_trimestre(7, 9)).'],
                    ["Oct-Dic", '.$datos[3]->meta.', '.($this->venta_model->total_trimestre(10, 12) == 0 ? 0.0 : $this->venta_model->total_trimestre(10, 12)).']
                ]);

                var options = {};

                    var chart = new google.charts.Bar(document.getElementById("columnchart_material"));

                    chart.draw(data, google.charts.Bar.convertOptions(options));
                }
                ';
        }//end if
        return $html;
    }//end grafica_trimestral

    public function grafica_anual($datos) {
        $html = '';
        if (sizeof($datos) > 0) {
            $html.='
            google.charts.load("current", {packages:["corechart"]});
            google.charts.setOnLoadCallback(drawChart2);
            function drawChart2() {
                var data2 = google.visualization.arrayToDataTable([
                    ["Meta", "Total", { role: "style" } ],
                    ["Meta", '.$datos[0]->meta.', "color: #808080"],
                    ["Total", '.$this->venta_model->total_anual().', "color: #F3F15B"]
                ]);

                var view2 = new google.visualization.DataView(data2);
                view2.setColumns([0, 1,
                { calc: "stringify",
                    sourceColumn: 1,
                    type: "string",
                    role: "annotation" },
                    2]);

                    var options2 = {
                        bar: {groupWidth: "95%"},
                        legend: { position: "none" },
                    };
                    var chart2 = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
                    chart2.draw(view2, options2);
                }
            ';
        }//end if
        return $html;
    }//end grafica_anual
}//end class Gestion
