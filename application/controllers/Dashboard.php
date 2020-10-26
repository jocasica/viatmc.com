<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('url', 'language'));

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');

        $this->load->model(array(
            ''
        ));
    }//end __construct

    public function index() {
        if ($this->ion_auth->logged_in()) {
            $data = array();
           
            $cotizaciones = $this->venta_model->getCotizaciones();
            $pendientes = 0;
            $aceptadas = 0;
            $rechazadas = 0;


            //NUEVO DASHBOARD
            $registrado = 0;
			$enviado = 0;
			$aceptado = 0;
			$observado = 0;
			$rechazado = 0;
			$anulado = 0;
			$por_anular = 0;
            $pendiente = 0;
            $ventas_de_hoy = 0;
            // $data['hora_llegada'] = ;
			$ventas = $this->venta_model->getDataVentasDashboard()->result_array();
			
			
			foreach ($ventas as $row) {
				
				
					switch ($row["estado_api"]) {
						case 'Registrado':
							$registrado++;
							break;
						case 'Enviado':
							$enviado++;
							break;
						case 'Aceptado':
							$aceptado++;
							break;
						case 'Observado':
							$observado++;
							break;
						case 'Rechazado':
							$rechazado++;
							break;
						case 'Anulado':
							$anulado++;
							break;
						case 'Por anular':
							$por_anular++;
							break;
						default:
							$pendiente++;
							break;
					}
					//$ventas_de_hoy = $ventas_de_hoy + $row['total'];
				 //end if
            } //end while
            // print("<pre>".print_r($data['griferos'],true)."</pre>");
			$data['enviados'] = $enviado;
			$data['pendiente'] = $pendiente;
			$data['observados'] = $observado;
			$data['anulados'] = $anulado;
			$data['por_anular'] = $por_anular;
			$data['aceptados'] = $aceptado;
			$data['rechazados'] = $rechazado;
			$data['por_anular'] = $por_anular;
			$data['ventas_de_hoy'] = $ventas_de_hoy;

            foreach ($cotizaciones->result() as $cotizacion) {
                if ($cotizacion->estado == 1) {
                    $pendientes++;
                } elseif ($cotizacion->estado == 2){
                    $aceptadas++;
                } else {
					$rechazadas++;
				}
            }//end foreach
            $data['pendientes'] = $pendientes;
            $data['aceptadas'] = $aceptadas;
            $data['rechazadas'] = $rechazadas;





            $fechas = $this->obtener_fechas_por_semana();
            $data['grafica'] = $this->grafica();
            $data['datos_semanales'] = $this->datos_semanales($fechas[0], $fechas[1]);
            $ventas_totales = $this->venta_model->getVentasTotales();
            $total_ventas = $ventas_totales->total_ventas;
            $data['ventas_totales'] = $total_ventas;

            // print("<pre>".print_r($data['datos_semanales'],true)."</pre>");
            $data['fecha_inicio'] = $fechas[0];
            $data['fecha_fin'] = $fechas[1];
            $this->load->view('/layout/top');
            $this->load->view('menu/dashboard/index', $data);
            $this->load->view('/layout/bottom');
        }//end else
        else {
            redirect('auth/login', 'refresh');
        }//end else
    }//end index

    public function grafica(){
        $html = '';
        $ventas_mensuales = $this->venta_model->ventas_mensuales_anio_actual();
        $datos = '["Mes", "Total S/", "Total $"]';
        $count = 0;
        foreach ($ventas_mensuales as $dato) {
            $count++;
            $datos.=',["'.$this->mes($dato->mes).'", '.$dato->total_soles.', '.$dato->total_dolares.']';
        }//end foreach
        $html.= '
            google.charts.load("current", {packages:["corechart"]});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
              var data = google.visualization.arrayToDataTable([
                  '.$datos.'
              ]);

              var options = {
                height: 400,
                bar: {groupWidth: "95%"},
                legend: { position: "none" },
              };
              var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
              chart.draw(data, options);
            }
            google.charts.setOnLoadCallback(drawChart);
        ';
        return $html;
    }//end grafica

    public function datos_semanales($fecha_inicio, $fecha_fin){
        $ventas_semanales = $this->venta_model->ventas_semanales($fecha_inicio, $fecha_fin);
        return $ventas_semanales;
    }//end datos_semanales

    public function mes($mes) {
        $mes_actual = '';
        $mes = (int) $mes;
        switch ($mes) {
            case 1:
                $mes_actual = 'Enero';
                break;
            case 2:
                $mes_actual = 'Febrero';
                break;
            case 3:
                $mes_actual = 'Marzo';
                break;
            case 4:
                $mes_actual = 'Abril';
                break;
            case 5:
                $mes_actual = 'Mayo';
                break;
            case 6:
                $mes_actual = 'Junio';
                break;
            case 7:
                $mes_actual = 'Julio';
                break;
            case 8:
                $mes_actual = 'Agosto';
                break;
            case 9:
                $mes_actual = 'Septiembre';
                break;
            case 10:
                $mes_actual = 'Octubre';
                break;
            case 11:
                $mes_actual = 'Noviembre';
                break;
            case 12:
                $mes_actual = 'Diciembre';
                break;

            default:
                $mes_actual = '';
                break;
        }//end switch
        return $mes_actual;
    }//end mes

    public function obtener_fechas_por_semana() {
        $temp = array();
        $fi = new DateTime();
        $fi->modify('first day of this month');
        $fecha_inicio = strtotime($fi->format('Y-m-d'));

        $ff = new DateTime();
        $ff->modify('last day of this month');
        $fecha_fin = strtotime($ff->format('Y-m-d'));
        $fecha_inicio_actual = '';
        $fecha_fin_actual = '';
        $fecha_actual = date('Y-m-d');

        //Recorro las fechas y con la función strotime obtengo los lunes
        for($i=$fecha_inicio; $i<=$fecha_fin; $i+=86400){
            //Sacar el dia de la semana con el modificador N de la funcion date
            $dia = date('N', $i);
            if($dia==1){
                $fecha_inicio_lunes = date("Y-m-d", $i);
                $fecha_fin_domingo = date("Y-m-d",strtotime($fecha_inicio_lunes."+ 6 days"));
                if($fecha_actual >= $fecha_inicio_lunes && $fecha_actual <= $fecha_fin_domingo) {
                    $fecha_inicio_actual = $fecha_inicio_lunes;
                    $fecha_fin_actual = $fecha_fin_domingo;
                }//end if
            }//en dif
        }//end else

        $temp[0] = $fecha_inicio_actual;
        $temp[1] = $fecha_fin_actual;
        return $temp;
    }//end obtener_fechas_por_semana

    public function envios_aceptados() {
        if ($this->ion_auth->logged_in()) {

            $data['boletas'] = $this->venta_model->getBoletasAceptadas();
            $data['facturas'] = $this->venta_model->getFacturasAceptadas();

            $this->load->view('/layout/top');
            $this->load->view('menu/dashboard/aceptados', $data);
            $this->load->view('/layout/bottom');
        }//end else
        else {
            redirect('auth/login', 'refresh');
        }//end else

    }

    public function envios_anulados() {
        if ($this->ion_auth->logged_in()) {

            $data['boletas'] = $this->venta_model->getBoletasAnuladas();
            $data['facturas'] = $this->venta_model->getFacturasAnuladas();

            $this->load->view('/layout/top');
            $this->load->view('menu/dashboard/anulados', $data);
            $this->load->view('/layout/bottom');
        }//end else
        else {
            redirect('auth/login', 'refresh');
        }//end else

    }

	public function envios_rechazados() {
		if ($this->ion_auth->logged_in()) {

			$data['boletas'] = $this->venta_model->getBoletasRechazadas();
			$data['facturas'] = $this->venta_model->getFacturasRechazadas();

			$this->load->view('/layout/top');
			$this->load->view('menu/dashboard/rechazados', $data);
			$this->load->view('/layout/bottom');
		}//end else
		else {
			redirect('auth/login', 'refresh');
		}//end else

	}

}//end class Dashboard
