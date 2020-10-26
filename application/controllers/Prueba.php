<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Prueba extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('ci_qr_code');
        $this->config->load('qr_code');
        $this->load->model(array(
            'Compra_model', 'Reporte_model'

        ));
    }

    public function index()
    {
        $this->load->library('../controllers/fe/printpdf');
        $this->load->library('pdfdos');
        $print = $this->printpdf;
        $pdf = $this->pdfdos;

        $this->load->library('pdf');
        $dompdf = $this->pdf;

        if (isset($_GET['tipo']) && $_GET['tipo'] != "") {
            $tipo_cpe = $_GET['tipo'];
        } else {
            $tipo_cpe = "";
        }
        if (isset($_GET['id']) && $_GET['id'] != "") {
            $venta_id = $_GET['id'];
        } else {
            $venta_id = "";
        }
        if (isset($_GET['idcotizacion']) && $_GET['idcotizacion'] != "") {
            $cotizacion_id = $_GET['idcotizacion'];
        } else {
            $cotizacion_id = "";
        }
        /*
          $tipo_cpe = $_GET['tipo'];
          $venta_id = $_GET['id'];
          $cotizacion_id = $_GET['idcotizacion'];
         */

        if ($tipo_cpe == 'factura') {
            $prods = $this->venta_model->getProductosVenta($venta_id);
            $data['comprobante'] = "FACTURA";
            $data['prods'] = $prods;
            $datos = $this->venta_model->getDatosVentaFactura($venta_id);
            $qr_code_config = array();
            $qr_code_config['cacheable'] = $this->config->item('cacheable');
            $qr_code_config['cachedir'] = $this->config->item('cachedir');
            $qr_code_config['ruta_base'] = $this->config->item('ruta_base');
            $qr_code_config['errorlog'] = $this->config->item('errorlog');
            $qr_code_config['ciqrcodelib'] = $this->config->item('ciqrcodelib');
            $qr_code_config['quality'] = $this->config->item('quality');
            $qr_code_config['size'] = $this->config->item('size');
            $qr_code_config['black'] = $this->config->item('black');
            $qr_code_config['white'] = $this->config->item('white');
            $this->ci_qr_code->initialize($qr_code_config);
            $image_name = "qr.png";
            // create user content
            $codeContents = $datos->serie . '-';
            $codeContents .= $datos->numero . "||";
            $codeContents .= $datos->docum . "||";
            $codeContents .= $datos->created_at . "||";
            $codeContents .= $datos->hash;
            $params['data'] = $codeContents;
            $params['level'] = 'H';
            $params['size'] = 5;
            $params['savename'] = $this->config->item('ruta_base') . 'archivos_xml_sunat/' . $image_name;
            $this->ci_qr_code->generate($params);
            $data['url'] = $this->config->item('ruta_base') . 'archivos_xml_sunat/' . $image_name;
            $data['logo'] = $this->config->item('ruta_base') . 'images/imagen-header-ticket.png';
            $pdf->mostrar($data, $datos);
        }

        if ($tipo_cpe == 'compra_productos') {
            $mes = $_GET['mes'];
            $ano = $_GET['ano'];
            $product = $_GET['product'];
            $data = $this->venta_model->getCompraProductos($mes, $ano, $product);
            $datos = [];
            $datos["mes"] = $mes;
            $datos["ano"] = $ano;
            $datos["product"] = $product;
            $datos["doc"] = "COMPRA";
            $pdf->mostrarListaProductos($data, $datos);
        } elseif ($tipo_cpe == 'venta_productos') {
            $mes = $_GET['mes'];
            $ano = $_GET['ano'];
            $product = $_GET['product'];
            $data = $this->venta_model->getVentaProductos($mes, $ano, $product);
            $datos = [];
            $datos["mes"] = $mes;
            $datos["ano"] = $ano;
            $datos["product"] = $product;
            $datos["doc"] = "VENTA";
            $pdf->mostrarListaProductos($data, $datos);
        }

        if ($tipo_cpe == 'facturaA4') {
            $prods = $this->venta_model->getProductosVentaA4($venta_id);
            $data = $this->venta_model->getDatosVentaFacturaA4($venta_id);
            $this->load->library('../controllers/fe/documentos_html');
            $html_documentos = $this->documentos_html;
            $html = $html_documentos->get_html_factura($data, $prods);
            define("DOMPDF_ENABLE_REMOTE", false);
            $dompdf->loadHtml($html['html']);
            $dompdf->setPaper('A4');
            $dompdf->render();
            $dompdf->stream($data->serie . " - " . $data->numero . ".pdf", array('Attachment' => 0));
        }
        if ($tipo_cpe == 'factura_nota_creditoA4') {
            $prods = $this->venta_model->getProductosVentaA4($venta_id);
            #$data = $this->venta_model->getDatosVentaFacturaA4($venta_id);
            $data = $this->venta_model->getDatosVentaFacturaNotaCreditoA4($venta_id);
            $this->load->library('../controllers/fe/documentos_html');
            $html_documentos = $this->documentos_html;
            $html = $html_documentos->get_html_factura_nota_credito($data, $prods);
            define("DOMPDF_ENABLE_REMOTE", false);
            $dompdf->loadHtml($html['html']);
            $dompdf->setPaper('A4');
            $dompdf->render();
            $dompdf->stream($data->serie . " - " . $data->numero . ".pdf", array('Attachment' => 0));
        }
        if ($tipo_cpe == 'cotizacionA4') {
            # reporte -> cotizacion
            $this->load->model(array('Producto_cotizacion_caracteristica_model', 'Cliente_model'));
            $data['data_cotizacion']                = $this->venta_model->getCotizacionId($cotizacion_id);
            $data['cotizacion_detalle_productos']   = $this->venta_model->getCotizacionDetalleProductosById($cotizacion_id);

            #$prods  = $this->venta_model->getProductosCotizacion($cotizacion_id);
            $prods  = $this->venta_model->getCotizacionDetalleProductosById($cotizacion_id);
            $data   = $this->venta_model->getDatosTicket($cotizacion_id);
            $data->nombre_clientes = $this->Cliente_model->cliente_cotizacion($data->cliente_id);

            $this->load->library('../controllers/fe/documentos_html');
            $html_documentos = $this->documentos_html;
            $html = $html_documentos->get_html_cotizacion($data, $prods);
            define("DOMPDF_ENABLE_REMOTE", false);
            $dompdf->loadHtml($html['html']);
            $dompdf->setPaper('A4');
            #$dompdf->set_option('dpi', 256);
            $dompdf->render();
            $dompdf->stream("cotizacion_n_" . $cotizacion_id . ".pdf", array('Attachment' => 0));
        }
        if ($tipo_cpe == 'remisionA4') {
            // cotizacion_id = remision_id OJO
            $prods = $this->venta_model->getProductosRemision($cotizacion_id);

            $data = $this->venta_model->getDatosRemision($cotizacion_id);

            // Nombre de la factura generada
            $nombreFactura = $data->serie . "-" . $data->numero . ".pdf";
            $path = "uploads/subida-documentos/";

            // $prods = $this->venta_model->getProductosVentaA4($cotizacion_id);
            //$data = $this->venta_model->getDatosVentaFacturaA4($cotizacion_id);
            //$this->load->library('../controllers/fe/documentos_html');
            // $html_documentos = $this->documentos_html;

            /**
             * Validación de punto de llegada y partida para evitar mostrar '-' cuando el dato venga vacío
             * por algún motivo, mostrar '{ubigeo} -' en el documento html
             */
            $data->partida_ubigeo = empty($data->partida_ubigeo) ? '' : $data->partida_ubigeo . ' - ';
            $data->llegada_ubigeo = empty($data->llegada_ubigeo) ? '' : $data->llegada_ubigeo . ' - ';
            $data->transportista_identidad_tipo = $this->constantes->DOCUMENTO_IDENTIDAD_TRANSPORTISTA[$data->conductor_identidad_tipo];

            //$html = $html_documentos->get_html_remision($data, $prods);
            $this->load->library('pdfdos');
            $pdf = $this->pdfdos;
            //$compras = $this->Compra_model->getComprasReporte();

            $pdf->reporte_remision_A4($data, $prods);
        }
        if ($tipo_cpe == 'cotizacionServA4') {
            $this->load->model(array(
                'Producto_cotizacion_caracteristica_model',
                'Cliente_model',
            ));
            $prods = $this->venta_model->getServiciosCotizacion($cotizacion_id);

            $data = $this->venta_model->getDatosTicket($cotizacion_id);
            $data->nombre_clientes = $this->Cliente_model->cliente_cotizacion($data->cliente_id);

            // $prods = $this->venta_model->getProductosVentaA4($cotizacion_id);
            //$data = $this->venta_model->getDatosVentaFacturaA4($cotizacion_id);
            $this->load->library('../controllers/fe/documentos_html');
            $html_documentos = $this->documentos_html;
            $html = $html_documentos->get_html_cotizacion_servicio($data, $prods);
            define("DOMPDF_ENABLE_REMOTE", false);
            $dompdf->loadHtml($html['html']);
            $dompdf->setPaper('A4');
            $dompdf->render();
            $dompdf->stream("cotizacion_n_" . $cotizacion_id . ".pdf", array('Attachment' => 0));
        }

        if ($tipo_cpe == 'boleta') {
            $prods = $this->venta_model->getProductosVenta($venta_id);
            $data['comprobante'] = "BOLETA";
            $data['prods'] = $prods;
            $datos = $this->venta_model->getDatosVentaBoleta($venta_id);
            $qr_code_config = array();
            $qr_code_config['cacheable'] = $this->config->item('cacheable');
            $qr_code_config['cachedir'] = $this->config->item('cachedir');
            $qr_code_config['ruta_base'] = $this->config->item('ruta_base');
            $qr_code_config['errorlog'] = $this->config->item('errorlog');
            $qr_code_config['ciqrcodelib'] = $this->config->item('ciqrcodelib');
            $qr_code_config['quality'] = $this->config->item('quality');
            $qr_code_config['size'] = $this->config->item('size');
            $qr_code_config['black'] = $this->config->item('black');
            $qr_code_config['white'] = $this->config->item('white');
            $this->ci_qr_code->initialize($qr_code_config);
            $image_name = "qr.png";
            // create user content
            $codeContents = $datos->serie . '-';
            $codeContents .= $datos->numero . "||";
            $codeContents .= $datos->docum . "||";
            $codeContents .= $datos->created_at . "||";
            $codeContents .= $datos->hash;
            $params['data'] = $codeContents;
            $params['level'] = 'H';
            $params['size'] = 5;
            $params['savename'] = $this->config->item('ruta_base') . 'archivos_xml_sunat/' . $image_name;
            $this->ci_qr_code->generate($params);
            $data['url'] = $this->config->item('ruta_base') . 'archivos_xml_sunat/' . $image_name;
            $data['logo'] = $this->config->item('ruta_base') . 'archivos_xml_sunat/logodr.png';
            $pdf->mostrar($data, $datos);
        }

        if ($tipo_cpe == 'boletaA4') {
            $prods = $this->venta_model->getProductosVentaA4($venta_id);
            $data = $this->venta_model->getDatosVentaBoletaA4($venta_id);
            $this->load->library('../controllers/fe/documentos_html');
            $html_documentos = $this->documentos_html;
            $html = $html_documentos->get_html_boleta($data, $prods);
            define("DOMPDF_ENABLE_REMOTE", false);
            $dompdf->loadHtml($html['html']);
            $dompdf->setPaper('A4');
            $dompdf->render();
            $dompdf->stream("boleta_n_" . $venta_id . ".pdf", array('Attachment' => 0));
        }

        if ($tipo_cpe == 'notadebito') {
            $prods = $this->venta_model->getProductosVenta($venta_id);
            $data['comprobante'] = "NOTA DE DEBITO";
            $data['prods'] = $prods;
            $datos = $this->venta_model->getDatosVentaNotaDebito($venta_id);
            $data['logo'] = $this->config->item('ruta_base') . 'archivos_xml_sunat/logodr.png';
            $pdf->mostrarNota($data, $datos);
        }

        if ($tipo_cpe == 'notacredito') {
            $prods = $this->venta_model->getProductosVenta($venta_id);
            $data['comprobante'] = "NOTA DE CREDITO";
            $data['prods'] = $prods;
            $datos = $this->venta_model->getDatosVentaNotaCredito($venta_id);
            $data['logo'] = $this->config->item('ruta_base') . 'archivos_xml_sunat/logodr.png';
            $pdf->mostrarNota($data, $datos);
        }
        if ($tipo_cpe == 'venta') {
            $prods = $this->venta_model->getProductosVenta($venta_id);
            $mes = $_GET['mes'];
            $ano = $_GET['ano'];
            $doc = $_GET['doc'];

            $this->load->library('../controllers/fe/documentos_html');
            $html_documentos = $this->documentos_html;
            $mes_buscar = 0;
            $ano_buscar = 0;
            if ($mes == 1) {
                $mes_buscar = 12;
                $ano_buscar = $ano - 1;
            } else {
                $mes_buscar = $mes - 1;
                $ano_buscar = $ano;
            }
            $data = $this->venta_model->getListaComprobantes($mes, $ano, $doc);
            $datos = [];
            $datos["mes"] = $mes;
            $datos["ano"] = $ano;
            $datos["doc"] = $doc;

            $pdf->mostrarListaComprobantes($data, $datos);
        }

        if ($tipo_cpe == 'reporteventa') {
            $date = $_GET['date'];
            $data = $this->venta_model->getVentasReport($date);
            $datos = [];
            $datos["date"] = $date;
            $pdf->mostrarVentasReport($data, $datos);
        }

        if ($tipo_cpe == 'comprobantes') {
            $date1 = $_GET['date1'];
            $date2 = $_GET['date2'];
            $doc = $_GET['doc'];
            $data = $this->venta_model->getListaComprobantesPeriodo($date1, $date2, $doc);
            $datos = [];
            $datos["date1"] = $date1;
            $datos["date2"] = $date2;
            $datos["doc"] = $doc;
            $pdf->mostrarListaComprobantesPeriodo($data, $datos);
        }

        if ($tipo_cpe == 'documentos') {
            $mes = $_GET['mes'];
            $ano = $_GET['ano'];
            $doc = $_GET['doc'];
            if ($doc == "PRUEBA DE MÁQUINA") {
                $data = $this->venta_model->getListaComprobantesMaquina($mes, $ano, $doc);
            } else {
                $data = $this->venta_model->getListaComprobantes($mes, $ano, $doc);
            }
            $datos = [];
            $datos["mes"] = $mes;
            $datos["ano"] = $ano;
            $datos["doc"] = $doc;
            if ($doc == "PRUEBA DE MÁQUINA") {
                $pdf->mostrarListaComprobantesMaquina($data, $datos);
            } else {
                $pdf->mostrarListaComprobantes($data, $datos);
            }
        }

        if ($tipo_cpe == 'kardex') {
            $prods = $this->venta_model->getProductosVenta($venta_id);
            $mes = $_GET['mes'];
            $ano = $_GET['ano'];

            $this->load->library('../controllers/fe/documentos_html');
            $html_documentos = $this->documentos_html;
            $mes_buscar = 0;
            $ano_buscar = 0;
            if ($mes == 1) {
                $mes_buscar = 12;
                $ano_buscar = $ano - 1;
            } else {
                $mes_buscar = $mes - 1;
                $ano_buscar = $ano;
            }
            $data_ex = $this->venta_model->stockMesAnterior($venta_id, $mes_buscar, $ano_buscar);

            $data = $this->venta_model->kardexProductoMesAno($venta_id, $mes, $ano);
            $prod = $this->producto_model->getProductoById($venta_id)->nombre;

            $datos = [];
            $datos["mes"] = $mes;
            $datos["ano"] = $ano;
            $datos["id"] = $venta_id;
            $datos["producto"] = $prod;
            if ($data_ex == null) {
                echo "Datos insuficientes.";
            } else {
                $pdf->mostrarKardex($data, $data_ex, $datos);
            }
        }
        set_time_limit(0);

        if ($tipo_cpe == 'kardex_excel') {
            // $prods = $this->venta_model->getProductosVenta($venta_id);
            $mes = $_GET['mes'];
            $ano = $_GET['ano'];

            $mes_buscar = $mes;
            $ano_buscar = $ano;

            //$data_ex = $this->venta_model->stockMesAnterior($venta_id, $mes_buscar, $ano_buscar);         

            $data = $this->venta_model->kardexProductoMesAno($venta_id, $mes, $ano);
            $prod = $this->producto_model->getProductoById($venta_id)->nombre;

            $producto_id = $venta_id;
            $movimientos = array();
            //$totales_por_villa[$arr_tot_ins->insumo_id . ',' . $arr_villa->id] = $totales_por_villa[$arr_tot_ins->insumo_id . ',' . $arr_villa->id] + $arr_tot_ins->total_usado;
            $data = array(
                //'entradas' => $this->Inventario_model->getEntradasBetweenDateAndProduct($fecha_inicio, $fecha_fin, $producto_id)->result(),
                //'salidas' => $this->Inventario_model->getSalidasBetweenDateAndProduct($fecha_inicio, $fecha_fin, $producto_id)->result(),
                'facturas' => $this->Reporte_model->getFacturasBetweenDateAndProduct($mes_buscar, $ano_buscar, $producto_id)->result(),
                'boletas' => $this->Reporte_model->getBoletasBetweenDateAndProduct($mes_buscar, $ano_buscar, $producto_id)->result(),
                'facturas_anuladas' => $this->Reporte_model->getFacturasAnuladasBetweenDateAndProduct($mes_buscar, $ano_buscar, $producto_id)->result(),
                'boletas_anuladas' => $this->Reporte_model->getBoletasAnuladasBetweenDateAndProduct($mes_buscar, $ano_buscar, $producto_id)->result(),
                'compras' => $this->Reporte_model->getComprasBetweenDateAndProduct($mes_buscar, $ano_buscar, $producto_id)->result(),
                'stock_inicial' => $this->Reporte_model->getStock_inicialByIdAndDate($mes_buscar, $ano_buscar, $producto_id)
                //'creditos' => $this->Inventario_model->getCreditosBetweenDateAndProduct($fecha_inicio, $fecha_fin, $producto_id)->result(),
            );

            $i = 1;
            foreach ($data['facturas'] as $facturas) {
                $movimientos[$i] = array('id' => $i, 'remision' => $facturas->remision, 'fecha_remision' => $facturas->fecha_remision, 'fecha_emision' => $facturas->fecha_emision, 'fecha' => $facturas->fecha, 'tipo_transaccion' => '2', 'numero' => $facturas->numero, 'cantidad' => $facturas->cantidad, 'descripcion' => "Venta (Factura)", 'tercero' => $facturas->tercero, 'usuario' => $facturas->usuario);
                $i++;
            }
            foreach ($data['boletas'] as $boletas) {
                $movimientos[$i] = array('id' => $i, 'remision' => $boletas->remision, 'fecha_remision' => $facturas->fecha_remision, 'fecha_emision' => $boletas->fecha_emision, 'fecha' => $boletas->fecha, 'tipo_transaccion' => '2', 'numero' => $boletas->numero, 'cantidad' => $boletas->cantidad, 'descripcion' => "Venta (Boleta)", 'tercero' => $boletas->tercero, 'usuario' => $boletas->usuario);
                $i++;
            }
            foreach ($data['compras'] as $compras) {
                $movimientos[$i] = array('id' => $i, 'remision' => "-", 'fecha_remision' => "-", 'fecha_emision' => $compras->fecha_emision, 'fecha' => $compras->fecha, 'tipo_transaccion' => '1', 'numero' => $compras->numero, 'cantidad' => $compras->cantidad, 'descripcion' => "Compra", 'tercero' => $compras->tercero, 'usuario' => $compras->usuario);
                $i++;
            }
            //anuladas
            foreach ($data['facturas_anuladas'] as $facturas_anuladas) {
                $movimientos[$i] = array('id' => $i, 'remision' => $facturas_anuladas->remision, 'fecha_remision' => $facturas->fecha_remision, 'fecha_emision' => $facturas_anuladas->fecha_emision, 'fecha' => $facturas_anuladas->fecha, 'tipo_transaccion' => '1', 'numero' => $facturas_anuladas->numero, 'cantidad' => $facturas_anuladas->cantidad, 'descripcion' => "Venta Anulada (Factura)", 'tercero' => $facturas_anuladas->tercero, 'usuario' => $facturas_anuladas->usuario);
                $i++;
            }
            foreach ($data['boletas_anuladas'] as $boletas_anuladas) {
                $movimientos[$i] = array('id' => $i, 'remision' => $boletas_anuladas->remision, 'fecha_remision' => $facturas->fecha_remision, 'fecha_emision' => $boletas_anuladas->fecha_emision, 'fecha' => $boletas_anuladas->fecha, 'tipo_transaccion' => '1', 'numero' => $boletas_anuladas->numero, 'cantidad' => $boletas_anuladas->cantidad, 'descripcion' => "Venta Anulada(Boleta)", 'tercero' => $boletas_anuladas->tercero, 'usuario' => $boletas_anuladas->usuario);
                $i++;
            }

            usort($movimientos, function ($a, $b) {
                return strcmp($a["fecha_emision"], $b["fecha_emision"]);
            });
            if ($data["stock_inicial"] != null) {
                array_unshift($movimientos, array('id' => 0, 'remision' => "-", 'fecha_emision' => ($data["stock_inicial"]->fecha_stock), 'fecha_remision' => "-", 'fecha' => ($data["stock_inicial"]->fecha_stock), 'tipo_transaccion' => '1', 'numero' => "", 'cantidad' => $data["stock_inicial"]->cantidad, 'descripcion' => "Stock inicial", 'tercero' => "-", 'usuario' => "-"));
            }
            $data_movimientos['movimientos'] = $movimientos;
            $data_movimientos['producto'] = $this->Reporte_model->getProductoById($producto_id);
            $data_movimientos['month'] = $mes_buscar;
            $data_movimientos['year'] = $ano_buscar;

            //if ($data_ex == null) {
            //     echo "Datos insuficientes.";
            // } else {
            $this->generarKardexExcel($data_movimientos);
            // }
        }
        set_time_limit(0);
        if ($tipo_cpe == 'concar') {
            $mes = $_GET['mes'];
            $ano = $_GET['ano'];
            $tipo = $_GET['doc'];


            require(APPPATH . 'third_party/PHPExcel-1.8/Classes/PHPExcel.php');
            require(APPPATH . 'third_party/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php');
            $excel = new PHPExcel();

            $excel->getProperties()->setCreator("Escienza");
            $excel->getProperties()->setLastModifiedBy("");
            $excel->getProperties()->setTitle("Concar " . $mes . "/" . $ano);
            $excel->getProperties()->setSubject("");
            $excel->getProperties()->setDescription("");
            $excel->setActiveSheetIndex(0);

            $styleArray = array(
                'font' => array(
                    'bold' => false,
                    'size' => 10,
                    'name' => 'Arial'
                )
            );


            $excel->getActiveSheet()->getColumnDimension('B')->setWidth(9.72);
            $excel->getActiveSheet()->getColumnDimension('C')->setWidth(23);
            $excel->getActiveSheet()->getColumnDimension('D')->setWidth(22);
            $excel->getActiveSheet()->getColumnDimension('E')->setWidth(17.3);
            $excel->getActiveSheet()->getColumnDimension('F')->setWidth(17.3);
            $excel->getActiveSheet()->getColumnDimension('G')->setWidth(17.3);
            $excel->getActiveSheet()->getColumnDimension('H')->setWidth(17.3);
            $excel->getActiveSheet()->getColumnDimension('I')->setWidth(24);
            $excel->getActiveSheet()->getColumnDimension('J')->setWidth(23);
            $excel->getActiveSheet()->getColumnDimension('K')->setWidth(19);
            $excel->getActiveSheet()->getColumnDimension('L')->setWidth(17);
            $excel->getActiveSheet()->getColumnDimension('M')->setWidth(22);
            $excel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
            $excel->getActiveSheet()->getColumnDimension('O')->setWidth(16);
            $excel->getActiveSheet()->getColumnDimension('P')->setWidth(24);
            $excel->getActiveSheet()->getColumnDimension('Q')->setWidth(21);
            $excel->getActiveSheet()->getColumnDimension('R')->setWidth(19);
            $excel->getActiveSheet()->getColumnDimension('S')->setWidth(27);
            $excel->getActiveSheet()->getColumnDimension('T')->setWidth(21);
            $excel->getActiveSheet()->getColumnDimension('U')->setWidth(21);
            $excel->getActiveSheet()->getColumnDimension('V')->setWidth(15);
            $excel->getActiveSheet()->getColumnDimension('W')->setWidth(14);
            $excel->getActiveSheet()->getColumnDimension('X')->setWidth(21);
            $excel->getActiveSheet()->getColumnDimension('Y')->setWidth(13);
            $excel->getActiveSheet()->getColumnDimension('Z')->setWidth(20);
            $excel->getActiveSheet()->getColumnDimension('AA')->setWidth(26);
            $excel->getActiveSheet()->getColumnDimension('AB')->setWidth(25);
            $excel->getActiveSheet()->getColumnDimension('AC')->setWidth(27);
            $excel->getActiveSheet()->getColumnDimension('AD')->setWidth(27);
            $excel->getActiveSheet()->getColumnDimension('AE')->setWidth(27);
            $excel->getActiveSheet()->getColumnDimension('AF')->setWidth(27);
            $excel->getActiveSheet()->getColumnDimension('AG')->setWidth(27);
            $excel->getActiveSheet()->getColumnDimension('AH')->setWidth(27);
            $excel->getActiveSheet()->getColumnDimension('AI')->setWidth(27);
            $excel->getActiveSheet()->getColumnDimension('AJ')->setWidth(27);
            $excel->getActiveSheet()->getColumnDimension('AK')->setWidth(27);
            $excel->getActiveSheet()->getColumnDimension('AL')->setWidth(27);

            //FILA 1
            $excel->getActiveSheet()->SetCellValue('A1', 'Campo');
            $excel->getActiveSheet()->SetCellValue("B1", "Sub Diario");
            $excel->getActiveSheet()->SetCellValue("C1", "Número de Comprobante");
            $excel->getActiveSheet()->SetCellValue("D1", "Fecha de Comprobante");
            $excel->getActiveSheet()->SetCellValue("E1", "Código de Moneda");
            $excel->getActiveSheet()->SetCellValue("F1", "Glosa Principal");
            $excel->getActiveSheet()->SetCellValue("G1", "Tipo de Cambio");
            $excel->getActiveSheet()->SetCellValue("H1", "Tipo de Conversión");
            $excel->getActiveSheet()->SetCellValue("I1", "Flag de Conversión de Moneda");
            $excel->getActiveSheet()->SetCellValue("J1", "Fecha Tipo de Cambio");
            $excel->getActiveSheet()->SetCellValue("K1", "Cuenta Contable");
            $excel->getActiveSheet()->SetCellValue("L1", "Código de Anexo");
            $excel->getActiveSheet()->SetCellValue("M1", "Código de Centro de Costo");
            $excel->getActiveSheet()->SetCellValue("N1", "Debe / Haber");
            $excel->getActiveSheet()->SetCellValue("O1", "Importe Original");
            $excel->getActiveSheet()->SetCellValue("P1", "Importe en Dólares");
            $excel->getActiveSheet()->SetCellValue("Q1", "Importe en Soles");
            $excel->getActiveSheet()->SetCellValue("R1", "Tipo de Documento");
            $excel->getActiveSheet()->SetCellValue("S1", "Número de Documento");
            $excel->getActiveSheet()->SetCellValue("T1", "Fecha de Documento");
            $excel->getActiveSheet()->SetCellValue("U1", "Fecha de Vencimiento");
            $excel->getActiveSheet()->SetCellValue("V1", "Código de Area");
            $excel->getActiveSheet()->SetCellValue("W1", "Glosa Detalle");
            $excel->getActiveSheet()->SetCellValue("X1", "Código de Anexo Auxiliar");
            $excel->getActiveSheet()->SetCellValue("Y1", "Medio de Pago");
            $excel->getActiveSheet()->SetCellValue("Z1", "Tipo de Documento de Referencia");
            $excel->getActiveSheet()->SetCellValue("AA1", "Número de Documento Referencia");
            $excel->getActiveSheet()->SetCellValue("AB1", "Fecha Documento Referencia");
            $excel->getActiveSheet()->SetCellValue("AC1", "Base Imponible Documento Referencia");
            $excel->getActiveSheet()->SetCellValue("AD1", "IGV Documento Provisión");
            $excel->getActiveSheet()->SetCellValue("AE1", "Tipo Referencia en estado MQ");
            $excel->getActiveSheet()->SetCellValue("AF1", "Número Serie Caja Registradora");
            $excel->getActiveSheet()->SetCellValue("AG1", "Fecha de Operación");
            $excel->getActiveSheet()->SetCellValue("AH1", "Tipo de Tasa");
            $excel->getActiveSheet()->SetCellValue("AI1", "Tasa Detracción/Percepción");
            $excel->getActiveSheet()->SetCellValue("AJ1", "Importe Base Detracción/Percepción Dólares");
            $excel->getActiveSheet()->SetCellValue("AK1", "Importe Base Detracción/Percepción Soles");
            $excel->getActiveSheet()->SetCellValue("AL1", "Tipo Cambio para 'F'");

            //FILA 2
            $excel->getActiveSheet()->SetCellValue("A2", "Restricciones");
            $excel->getActiveSheet()->SetCellValue("B2", "Ver T.G.02");
            $excel->getActiveSheet()->SetCellValue("C2", "Los dos primero digitos son el mes y
      los otros 4
      siguientes un
      correlativo");
            $excel->getActiveSheet()->SetCellValue("D2", "");
            $excel->getActiveSheet()->SetCellValue("E2", "Ver T.G. 03");
            $excel->getActiveSheet()->SetCellValue("F2", "");
            $excel->getActiveSheet()->SetCellValue("G2", "Llenar  solo si Tipo
      de Conversión es
      'C'. Debe estar entre
      >=0 y <=9999.999999");
            $excel->getActiveSheet()->SetCellValue("H2", "Solo: 'C'= Especial,
      'M'=Compra, 
    'V'=Venta , 'F' De 
      acuerdo a fecha");
            $excel->getActiveSheet()->SetCellValue("I2", "Solo: 'S' = Si se
      convierte, 'N'= No
      se convierte");
            $excel->getActiveSheet()->SetCellValue("J2", "Si Tipo de
      Conversión 'F'");
            $excel->getActiveSheet()->SetCellValue("K2", "Debe existir en 
      el Plan de 
      Cuentas");
            $excel->getActiveSheet()->SetCellValue("L2", "Si Cuenta 
      Contable tiene
      seleccionado 
      Tipo de Anexo,
      debe existir en
      la tabla de
      Anexos");
            $excel->getActiveSheet()->SetCellValue("M2", "Si Cuenta 
      Contable tiene 
      habilitado C.
      Costo, Ver T.G. 05");
            $excel->getActiveSheet()->SetCellValue("N2", "'D' ó 'H'");
            $excel->getActiveSheet()->SetCellValue("O2", "Importe original de 
      la cuenta contable.
      Obligatorio, debe 
      estar entre >=0 y 
      <=99999999999.99 ");
            $excel->getActiveSheet()->SetCellValue("P2", "Importe de la 
      Cuenta Contable en
      Dólares. Obligatorio
      si Flag de
      Conversión de 
      Moneda esta en 'N',
      debe estar entre
      >=0 y
      <=99999999999.99 ");
            $excel->getActiveSheet()->SetCellValue("Q2", "Importe de la
      Cuenta Contable en 
    Soles. Obligatorio si 
    Flag de Conversión 
    de Moneda esta en 
    'N', debe estra entre 
    >=0 y 
    <=99999999999.99 ");
            $excel->getActiveSheet()->SetCellValue("R2", "Si Cuenta Contable 
      tiene habilitado el 
      Documento 
      Referencia Ver T.G.
      06");
            $excel->getActiveSheet()->SetCellValue("S2", "Si Cuenta Contable 
      tiene habilitado el 
      Documento 
      Referencia Incluye 
      Serie y Número");
            $excel->getActiveSheet()->SetCellValue("T2", "Si Cuenta 
      Contable tiene 
      habilitado el 
      Documento 
      Referencia");
            $excel->getActiveSheet()->SetCellValue("U2", "Si Cuenta 
      Contable tiene 
      habilitada la 
      Fecha de 
      Vencimiento");
            $excel->getActiveSheet()->SetCellValue("V2", "Si Cuenta 
      Contable tiene 
      habilitada el 
      Area. Ver T.G. 26");
            $excel->getActiveSheet()->SetCellValue("W2", "");
            $excel->getActiveSheet()->SetCellValue("X2", "Si Cuenta 
      Contable tiene 
      seleccionado 
      Tipo de Anexo 
      Referencia");
            $excel->getActiveSheet()->SetCellValue("Y2", "Si Cuenta Contable 
      tiene habilitado 
      Tipo Medio Pago. 
      Ver T.G. 'S1'");
            $excel->getActiveSheet()->SetCellValue("Z2", "Si Tipo de 
      Documento es 
      'NA' ó 'ND' Ver 
      T.G. 06");
            $excel->getActiveSheet()->SetCellValue("AA2", "Si Tipo de 
      Documento es 
      'NC', 'NA' ó 'ND', 
      incluye Serie y 
      Número");
            $excel->getActiveSheet()->SetCellValue("AB2", "Si Tipo de 
      Documento es 
      'NC', 'NA' ó 'ND'");
            $excel->getActiveSheet()->SetCellValue("AC2", "Si Tipo de 
      Documento es 
      'NC', 'NA' ó 'ND'");
            $excel->getActiveSheet()->SetCellValue("AD2", "Si Tipo de 
      Documento es 
      'NC', 'NA' ó 'ND'");
            $excel->getActiveSheet()->SetCellValue("AE2", "Si la Cuenta Contable 
      tiene Habilitado 
      Documento 
      Referencia 2 y  Tipo 
      de Documento es 'TK'");
            $excel->getActiveSheet()->SetCellValue("AF2", "Si la Cuenta Contable 
      teinen Habilitado 
      Documento 
      Referencia 2 y  Tipo 
      de Documento es 'TK'");
            $excel->getActiveSheet()->SetCellValue("AG2", "Si la Cuenta Contable 
      tiene Habilitado 
      Documento 
      Referencia 2. Cuando 
      Tipo de Documento 
      es 'TK', consignar la 
      fecha de emision del 
      ticket");
            $excel->getActiveSheet()->SetCellValue("AH2", "Si la Cuenta 
      Contable tiene 
      configurada la 
      Tasa:  Si es '1' ver 
      T.G. 28 y '2' ver T.G. 
      29");
            $excel->getActiveSheet()->SetCellValue("AI2", "Si la Cuenta Contable 
      tiene conf. een Tasa:  Si 
      es '1' ver T.G. 28 y '2' ver 
      T.G. 29. Debe estar entre 
      >=0 y <=999.99");
            $excel->getActiveSheet()->SetCellValue("AJ2", "Si la Cuenta Contable 
      tiene configurada la 
      Tasa. Debe ser el 
      importe total del 
      documento y estar entre 
      >=0 y <=99999999999.99");
            $excel->getActiveSheet()->SetCellValue("AK2", "Si la Cuenta Contable 
      tiene configurada la 
      Tasa. Debe ser el 
      importe total del 
      documento y estar entre 
      >=0 y <=99999999999.99");
            $excel->getActiveSheet()->SetCellValue("AL2", "Especificar solo si 
      Tipo Conversión es 
      'F'. Se permite 'M' 
      Compra y 'V' Venta.");

            //FILA 3
            $excel->getActiveSheet()->SetCellValue('A3', 'Numérico 11,6');
            $excel->getActiveSheet()->SetCellValue("B3", "2 Caracteres");
            $excel->getActiveSheet()->SetCellValue("C3", "6 caracteres");
            $excel->getActiveSheet()->SetCellValue("D3", "dd/mm/aaaa");
            $excel->getActiveSheet()->SetCellValue("E3", "2 Caracteres");
            $excel->getActiveSheet()->SetCellValue("F3", "40 Caracteres");
            $excel->getActiveSheet()->SetCellValue("G3", "");
            $excel->getActiveSheet()->SetCellValue("H3", "1 Caracteres");
            $excel->getActiveSheet()->SetCellValue("I3", "1 Caracteres");
            $excel->getActiveSheet()->SetCellValue("J3", "dd/mm/aaaa");
            $excel->getActiveSheet()->SetCellValue("K3", "8 Caracteres");
            $excel->getActiveSheet()->SetCellValue("L3", "18 Caracteres");
            $excel->getActiveSheet()->SetCellValue("M3", "6 Caracteres");
            $excel->getActiveSheet()->SetCellValue("N3", "1 Carácter");
            $excel->getActiveSheet()->SetCellValue("O3", "Numérico 14,2");
            $excel->getActiveSheet()->SetCellValue("P3", "Numérico 14,2");
            $excel->getActiveSheet()->SetCellValue("Q3", "Numérico 14,2");
            $excel->getActiveSheet()->SetCellValue("R3", "2 Caracteres");
            $excel->getActiveSheet()->SetCellValue("S3", "20 Caracteres");
            $excel->getActiveSheet()->SetCellValue("T3", "dd/mm/aaaa");
            $excel->getActiveSheet()->SetCellValue("U3", "dd/mm/aaaa");
            $excel->getActiveSheet()->SetCellValue("V3", "3 Caracteres");
            $excel->getActiveSheet()->SetCellValue("W3", "30 Caracteres");
            $excel->getActiveSheet()->SetCellValue("X3", "18 Caracteres");
            $excel->getActiveSheet()->SetCellValue("Y3", "8 Caracteres");
            $excel->getActiveSheet()->SetCellValue("Z3", "2 Caracteres");
            $excel->getActiveSheet()->SetCellValue("AA3", "20 Caracteres");
            $excel->getActiveSheet()->SetCellValue("AB3", "dd/mm");
            $excel->getActiveSheet()->SetCellValue("AC3", "Numérico 14,2 ");
            $excel->getActiveSheet()->SetCellValue("AD3", "Numérico 14,2");
            $excel->getActiveSheet()->SetCellValue("AE3", "'MQ'");
            $excel->getActiveSheet()->SetCellValue("AF3", "15 Caracteres");
            $excel->getActiveSheet()->SetCellValue("AG3", "dd/mm/aaaa");
            $excel->getActiveSheet()->SetCellValue("AH3", "5 Caracteres");
            $excel->getActiveSheet()->SetCellValue("AI3", "Numérico 14,2");
            $excel->getActiveSheet()->SetCellValue("AJ3", "Numérico 14,2");
            $excel->getActiveSheet()->SetCellValue("AK3", "Numérico 14,2");
            $excel->getActiveSheet()->SetCellValue("AL3", "1 Caracter");
            $r = 4;
            if ($tipo == "BOLETA") {
                $data = $this->venta_model->getDataConcarBoleta($mes, $ano);
                foreach ($data->result() as $row) {
                    $date = new DateTime($row->fecha);
                    $fecha = $date->format('d/m/Y');
                    $excel->getActiveSheet()->SetCellValue('B' . $r, '04');
                    $excel->getActiveSheet()->SetCellValue('C' . $r, $row->mes . $row->count);
                    $excel->getActiveSheet()->SetCellValue('D' . $r, $fecha);
                    $excel->getActiveSheet()->SetCellValue('E' . $r, 'MN');
                    $excel->getActiveSheet()->SetCellValue('F' . $r, 'datos de bl');
                    $excel->getActiveSheet()->SetCellValue('G' . $r, '0');
                    $excel->getActiveSheet()->SetCellValue('H' . $r, 'V');
                    $excel->getActiveSheet()->SetCellValue('I' . $r, 'S');
                    if ($row->tipo_venta == "PRODUCTOS") {
                        $excel->getActiveSheet()->SetCellValue('K' . $r, '701111');
                    } else if ($row->tipo_venta == "SERVICIOS") {
                        $excel->getActiveSheet()->SetCellValue('K' . $r, '704111');
                    }
                    $excel->getActiveSheet()->SetCellValue('L' . $r, '0002');
                    $excel->getActiveSheet()->SetCellValue('N' . $r, 'H');
                    $excel->getActiveSheet()->SetCellValue('O' . $r, $row->subtotal);
                    $excel->getActiveSheet()->SetCellValue('R' . $r, 'BV');
                    $excel->getActiveSheet()->SetCellValue('S' . $r, substr($row->serie, 1, 3) . '-' . $row->numero);
                    $excel->getActiveSheet()->SetCellValue('T' . $r, $fecha);
                    $r++;
                    $excel->getActiveSheet()->SetCellValue('B' . $r, '04');
                    $excel->getActiveSheet()->SetCellValue('C' . $r, $row->mes . $row->count);
                    $excel->getActiveSheet()->SetCellValue('D' . $r, $fecha);
                    $excel->getActiveSheet()->SetCellValue('E' . $r, 'MN');
                    $excel->getActiveSheet()->SetCellValue('F' . $r, 'datos de bl');
                    $excel->getActiveSheet()->SetCellValue('G' . $r, '0');
                    $excel->getActiveSheet()->SetCellValue('H' . $r, 'V');
                    $excel->getActiveSheet()->SetCellValue('I' . $r, 'S');
                    $excel->getActiveSheet()->SetCellValue('K' . $r, '401111');
                    $excel->getActiveSheet()->SetCellValue('N' . $r, 'H');
                    $excel->getActiveSheet()->SetCellValue('O' . $r, $row->igv);
                    $excel->getActiveSheet()->SetCellValue('R' . $r, 'BV');
                    $excel->getActiveSheet()->SetCellValue('S' . $r, substr($row->serie, 1, 3) . '-' . $row->numero);
                    $excel->getActiveSheet()->SetCellValue('T' . $r, $fecha);
                    $r++;
                    $excel->getActiveSheet()->SetCellValue('B' . $r, '04');
                    $excel->getActiveSheet()->SetCellValue('C' . $r, $row->mes . $row->count);
                    $excel->getActiveSheet()->SetCellValue('D' . $r, $fecha);
                    $excel->getActiveSheet()->SetCellValue('E' . $r, 'MN');
                    $excel->getActiveSheet()->SetCellValue('F' . $r, 'datos de bl');
                    $excel->getActiveSheet()->SetCellValue('G' . $r, '0');
                    $excel->getActiveSheet()->SetCellValue('H' . $r, 'V');
                    $excel->getActiveSheet()->SetCellValue('I' . $r, 'S');
                    $excel->getActiveSheet()->SetCellValue('K' . $r, '121203');
                    $excel->getActiveSheet()->SetCellValue('L' . $r, '0002');
                    $excel->getActiveSheet()->SetCellValue('N' . $r, 'D');
                    $excel->getActiveSheet()->SetCellValue('O' . $r, $row->total);
                    $excel->getActiveSheet()->SetCellValue('R' . $r, 'BV');
                    $excel->getActiveSheet()->SetCellValue('S' . $r, substr($row->serie, 1, 3) . '-' . $row->numero);
                    $excel->getActiveSheet()->SetCellValue('T' . $r, $fecha);
                    $excel->getActiveSheet()->SetCellValue('U' . $r, $fecha);
                    $r++;
                }
            } else if ($tipo == "FACTURA") {
                $data = $this->venta_model->getDataConcarFactura($mes, $ano);
                foreach ($data->result() as $row) {
                    $date = new DateTime($row->fecha);
                    $fecha = $date->format('d/m/Y');
                    $excel->getActiveSheet()->SetCellValue('B' . $r, '05');
                    $excel->getActiveSheet()->SetCellValue('C' . $r, $row->mes . $row->count);
                    $excel->getActiveSheet()->SetCellValue('D' . $r, $fecha);
                    $excel->getActiveSheet()->SetCellValue('E' . $r, 'MN');
                    $excel->getActiveSheet()->SetCellValue('F' . $r, 'datos de ft');
                    $excel->getActiveSheet()->SetCellValue('G' . $r, '0');
                    $excel->getActiveSheet()->SetCellValue('H' . $r, 'V');
                    $excel->getActiveSheet()->SetCellValue('I' . $r, 'S');
                    if ($row->tipo_venta == "PRODUCTOS") {
                        $excel->getActiveSheet()->SetCellValue('K' . $r, '701111');
                    } else if ($row->tipo_venta == "SERVICIOS") {
                        $excel->getActiveSheet()->SetCellValue('K' . $r, '704111');
                    }
                    $excel->getActiveSheet()->SetCellValue('L' . $r, $row->ruc);
                    $excel->getActiveSheet()->SetCellValue('N' . $r, 'H');
                    $excel->getActiveSheet()->SetCellValue('O' . $r, $row->subtotal);
                    $excel->getActiveSheet()->SetCellValue('R' . $r, 'FT');
                    $excel->getActiveSheet()->SetCellValue('S' . $r, substr($row->serie, 1, 3) . '-' . $row->numero);
                    $excel->getActiveSheet()->SetCellValue('T' . $r, $fecha);
                    $r++;
                    $excel->getActiveSheet()->SetCellValue('B' . $r, '05');
                    $excel->getActiveSheet()->SetCellValue('C' . $r, $row->mes . $row->count);
                    $excel->getActiveSheet()->SetCellValue('D' . $r, $fecha);
                    $excel->getActiveSheet()->SetCellValue('E' . $r, 'MN');
                    $excel->getActiveSheet()->SetCellValue('F' . $r, 'datos de ft');
                    $excel->getActiveSheet()->SetCellValue('G' . $r, '0');
                    $excel->getActiveSheet()->SetCellValue('H' . $r, 'V');
                    $excel->getActiveSheet()->SetCellValue('I' . $r, 'S');
                    $excel->getActiveSheet()->SetCellValue('K' . $r, '401111');
                    $excel->getActiveSheet()->SetCellValue('N' . $r, 'H');
                    $excel->getActiveSheet()->SetCellValue('O' . $r, $row->igv);
                    $excel->getActiveSheet()->SetCellValue('R' . $r, 'FT');
                    $excel->getActiveSheet()->SetCellValue('S' . $r, substr($row->serie, 1, 3) . '-' . $row->numero);
                    $excel->getActiveSheet()->SetCellValue('T' . $r, $fecha);
                    $r++;
                    $excel->getActiveSheet()->SetCellValue('B' . $r, '05');
                    $excel->getActiveSheet()->SetCellValue('C' . $r, $row->mes . $row->count);
                    $excel->getActiveSheet()->SetCellValue('D' . $r, $fecha);
                    $excel->getActiveSheet()->SetCellValue('E' . $r, 'MN');
                    $excel->getActiveSheet()->SetCellValue('F' . $r, 'datos de ft');
                    $excel->getActiveSheet()->SetCellValue('G' . $r, '0');
                    $excel->getActiveSheet()->SetCellValue('H' . $r, 'V');
                    $excel->getActiveSheet()->SetCellValue('I' . $r, 'S');
                    $excel->getActiveSheet()->SetCellValue('K' . $r, '121201');
                    $excel->getActiveSheet()->SetCellValue('L' . $r, $row->ruc);
                    $excel->getActiveSheet()->SetCellValue('N' . $r, 'D');
                    $excel->getActiveSheet()->SetCellValue('O' . $r, $row->total);
                    $excel->getActiveSheet()->SetCellValue('R' . $r, 'FT');
                    $excel->getActiveSheet()->SetCellValue('S' . $r, substr($row->serie, 1, 3) . '-' . $row->numero);
                    $excel->getActiveSheet()->SetCellValue('T' . $r, $fecha);
                    $excel->getActiveSheet()->SetCellValue('U' . $r, $fecha);
                    $r++;
                }
            }

            $excel->getActiveSheet()
                ->getStyle("A1:" . $excel->getActiveSheet()->getHighestDataColumn() . $excel->getActiveSheet()->getHighestDataRow())
                ->getAlignment()
                ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $excel->getActiveSheet()->getStyle("A1:" . $excel->getActiveSheet()->getHighestDataColumn() . $excel->getActiveSheet()->getHighestDataRow())->applyFromArray($styleArray);

            $filename = "CONCAR_" . $tipo . "_" . $mes . "/" . $ano . ".xls";
            $excel->getActiveSheet()->setTitle("Parte 1");
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
            $writer->save('php://output');
            exit;
        }
        if ($tipo_cpe == 'dbf') {
            $mes = $_GET['mes'];
            $ano = $_GET['ano'];
            $tipo = $_GET['doc'];


            require(APPPATH . 'third_party/PHPExcel-1.8/Classes/PHPExcel.php');
            require(APPPATH . 'third_party/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php');
            $excel = new PHPExcel();

            $excel->getProperties()->setCreator("Escienza");
            $excel->getProperties()->setLastModifiedBy("");
            $excel->getProperties()->setTitle("DBF " . $mes . "/" . $ano);
            $excel->getProperties()->setSubject("");
            $excel->getProperties()->setDescription("");
            $excel->setActiveSheetIndex(0);

            $styleArray = array(
                'font' => array(
                    'bold' => false,
                    'size' => 10,
                    'name' => 'Arial'
                )
            );


            $excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
            $excel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
            $excel->getActiveSheet()->getColumnDimension('E')->setWidth(17.3);
            $excel->getActiveSheet()->getColumnDimension('F')->setWidth(17.3);
            $excel->getActiveSheet()->getColumnDimension('G')->setWidth(17.3);
            $excel->getActiveSheet()->getColumnDimension('H')->setWidth(17.3);
            $excel->getActiveSheet()->getColumnDimension('I')->setWidth(24);
            //FILA 1
            $excel->getActiveSheet()->SetCellValue('A1', 'AVANEXO');
            $excel->getActiveSheet()->SetCellValue("B1", "ACODANE");
            $excel->getActiveSheet()->SetCellValue("C1", "ADESANE");
            $excel->getActiveSheet()->SetCellValue("D1", "AREFANE");
            $excel->getActiveSheet()->SetCellValue("E1", "ARUC");
            $excel->getActiveSheet()->SetCellValue("F1", "ACODMON");
            $excel->getActiveSheet()->SetCellValue("G1", "AESTADO");
            $excel->getActiveSheet()->SetCellValue("H1", "ADATE");
            $excel->getActiveSheet()->SetCellValue("I1", "AHORA");


            $r = 2;
            if ($tipo == "FACTURA") {
                $data = $this->venta_model->getDataDBF($mes, $ano);
                foreach ($data->result() as $row) {
                    $date = new DateTime($row->fecha);
                    $date2 = new DateTime($row->created_at);
                    $fecha = $date->format('d/m/Y');
                    $hora = $date->format('H:i');
                    $excel->getActiveSheet()->SetCellValue('A' . $r, 'C');
                    $excel->getActiveSheet()->SetCellValue('B' . $r, $row->ruc);
                    $excel->getActiveSheet()->SetCellValue('C' . $r, $row->cliente);
                    $excel->getActiveSheet()->SetCellValue('D' . $r, '');
                    $excel->getActiveSheet()->SetCellValue('E' . $r, $row->ruc);
                    $excel->getActiveSheet()->SetCellValue('F' . $r, 'MN');
                    $excel->getActiveSheet()->SetCellValue('G' . $r, 'V');
                    $excel->getActiveSheet()->SetCellValue('H' . $r, $fecha);
                    $excel->getActiveSheet()->SetCellValue('I' . $r, $hora);
                    $r++;
                }
            }

            $excel->getActiveSheet()
                ->getStyle("A1:" . $excel->getActiveSheet()->getHighestDataColumn() . $excel->getActiveSheet()->getHighestDataRow())
                ->getAlignment()
                ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $excel->getActiveSheet()->getStyle("A1:" . $excel->getActiveSheet()->getHighestDataColumn() . $excel->getActiveSheet()->getHighestDataRow())->applyFromArray($styleArray);

            $filename = "DBF_" . $tipo . "_" . $mes . "/" . $ano . ".dbf";
            $excel->getActiveSheet()->setTitle("Parte 1");
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
            $writer->save('php://output');
            exit;
        }
    }
    //EXCEL KARDEX
    public function generarKardexExcel($data_movimientos)
    {



        require(APPPATH . 'third_party/PHPExcel-1.8/Classes/PHPExcel.php');
        require(APPPATH . 'third_party/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php');
        $excel = new PHPExcel();

        $excel->getProperties()->setCreator("Escienza");
        $excel->getProperties()->setLastModifiedBy("");
        $excel->getProperties()->setTitle("Reporte_kardex");
        $excel->getProperties()->setSubject("");
        $excel->getProperties()->setDescription("");
        $excel->setActiveSheetIndex(0);



        //Estilos
        $estilo_cabecera_principal = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'CBDCE7'),
            ),
            'font' => array(
                'bold' => false,
                'size' => 14,
                'name' => 'Calibri',
                'color' => array('rgb' => '001E5A'),
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            )
        );
        $estilo_cabecera_secundaria = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'font' => array(
                'bold' => false,
                'size' => 10,
                'name' => 'Calibri'
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            )
        );

        $estilo_cabecera_secundaria_bold = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'font' => array(
                'bold' => true,
                'size' => 14,
                'name' => 'Calibri'
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            )
        );

        $estilo_cabecera_datos = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'CBDCE7'),
            ),
            'font' => array(
                'bold' => true,
                'size' => 10,
                'name' => 'Calibri'
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            )
        );

        $estilo_datos_bold = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'font' => array(
                'bold' => true,
                'size' => 10,
                'name' => 'Calibri'
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            )
        );
        $estilo_datos = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'font' => array(
                'bold' => false,
                'size' => 10,
                'name' => 'Calibri'
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            )
        );

        $celda_resaltada = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '808080'),
            ),
            'font' => array(
                'bold' => false,
                'size' => 10,
                'name' => 'Calibri',
                'color' => array('rgb' => 'FFFFFF'),
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            )
        );

        $celda_resaltada_naranja = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'F89532'),
            ),
            'font' => array(
                'bold' => true,
                'size' => 10,
                'name' => 'Calibri'

            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            )
        );

        //Freeze
        $excel->getActiveSheet()->freezePane('A12');
        //Tamaño 
        //--Filas
        $excel->getActiveSheet()->getRowDimension('1')->setRowHeight(25);
        $excel->getActiveSheet()->getRowDimension('3')->setRowHeight(40);
        $excel->getActiveSheet()->getRowDimension('10')->setRowHeight(25);
        $excel->getActiveSheet()->getRowDimension('11')->setRowHeight(25);
        //--Columnas
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(50);
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
        $excel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
        $excel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
        $excel->getActiveSheet()->getColumnDimension('M')->setWidth(25);
        $excel->getActiveSheet()->getColumnDimension('N')->setWidth(30);
        //MERGE
        $excel->getActiveSheet()->mergeCells("A1:N1");
        $excel->getActiveSheet()->mergeCells("A2:E3");
        $excel->getActiveSheet()->mergeCells("F2:M3");

        $excel->getActiveSheet()->mergeCells("A5:E5");
        $excel->getActiveSheet()->mergeCells("A6:E6");
        $excel->getActiveSheet()->mergeCells("A7:E7");
        $excel->getActiveSheet()->mergeCells("A8:E8");

        $excel->getActiveSheet()->mergeCells("F5:N5");
        $excel->getActiveSheet()->mergeCells("G6:H6");
        $excel->getActiveSheet()->mergeCells("G7:H7");
        $excel->getActiveSheet()->mergeCells("G8:H8");

        $excel->getActiveSheet()->mergeCells("I6:K6");
        $excel->getActiveSheet()->mergeCells("I7:K7");
        $excel->getActiveSheet()->mergeCells("I8:K8");

        $excel->getActiveSheet()->mergeCells("L6:M6");
        $excel->getActiveSheet()->mergeCells("L7:M7");
        $excel->getActiveSheet()->mergeCells("L8:M8");

        $excel->getActiveSheet()->mergeCells("A10:B10");
        $excel->getActiveSheet()->mergeCells("C10:E10");
        $excel->getActiveSheet()->mergeCells("F10:F11");
        $excel->getActiveSheet()->mergeCells("G10:H10");
        $excel->getActiveSheet()->mergeCells("I10:K10");
        $excel->getActiveSheet()->mergeCells("L10:L11");
        $excel->getActiveSheet()->mergeCells("M10:M11");
        $excel->getActiveSheet()->mergeCells("N10:N11");










        //Asignando estilo
        $excel->getActiveSheet()->getStyle("A1:N1")->applyFromArray($estilo_cabecera_principal);
        $excel->getActiveSheet()->getStyle("A2:E3")->applyFromArray($estilo_cabecera_secundaria);
        $excel->getActiveSheet()->getStyle("F2:M3")->applyFromArray($estilo_cabecera_secundaria_bold);
        $excel->getActiveSheet()->getStyle("N2:N3")->applyFromArray($estilo_cabecera_secundaria);

        $excel->getActiveSheet()->getStyle("A5:E8")->applyFromArray($estilo_cabecera_datos);
        $excel->getActiveSheet()->getStyle("G6:H8")->applyFromArray($estilo_cabecera_datos);
        $excel->getActiveSheet()->getStyle("L6:M8")->applyFromArray($estilo_cabecera_datos);

        $excel->getActiveSheet()->getStyle("F5:M5")->applyFromArray($estilo_datos_bold);
        $excel->getActiveSheet()->getStyle("F6:F8")->applyFromArray($estilo_datos_bold);
        $excel->getActiveSheet()->getStyle("N7:N8")->applyFromArray($estilo_datos_bold);

        $excel->getActiveSheet()->getStyle("I6:K8")->applyFromArray($estilo_datos);

        $excel->getActiveSheet()->getStyle("N6")->applyFromArray($celda_resaltada);

        $excel->getActiveSheet()->getStyle("A10:N11")->applyFromArray($estilo_cabecera_datos);

        $excel->getActiveSheet()->getStyle("G11")->applyFromArray($celda_resaltada_naranja);


        //Ajustando texto
        $excel->getActiveSheet()->getStyle('A10:N11')
            ->getAlignment()->setWrapText(true);
        //Aignando valores
        $excel->getActiveSheet()->SetCellValue('A1', 'REPORTE KARDEX EXCEL');
        $excel->getActiveSheet()->SetCellValue('A2', '');
        $excel->getActiveSheet()->SetCellValue('F2', 'CONTROL DE EXISTENCIAS DE PRODUCTOS');
        $excel->getActiveSheet()->SetCellValue('N2', 'AREA: ALMACEN');
        $excel->getActiveSheet()->SetCellValue('N3', 'PAGINA 1 DE 1');

        $excel->getActiveSheet()->SetCellValue('A5', 'NOMBRE DEL PRODUCTO');
        $excel->getActiveSheet()->SetCellValue('A6', 'FABRICANTE');
        $excel->getActiveSheet()->SetCellValue('A7', 'MODELO');
        $excel->getActiveSheet()->SetCellValue('A8', 'N° DUA');
      
        $excel->getActiveSheet()->SetCellValue('F5', (isset($data_movimientos['producto']->nombre)) ? strtoupper($data_movimientos['producto']->nombre) : "-");
        $excel->getActiveSheet()->SetCellValue('F6', (isset($data_movimientos['producto']->fabricante)) ? strtoupper($data_movimientos['producto']->fabricante) : "-");
        $excel->getActiveSheet()->SetCellValue('F7', (isset($data_movimientos['producto']->modelo)) ? strtoupper($data_movimientos['producto']->modelo) : "-");
        $excel->getActiveSheet()->SetCellValue('F8', (isset($data_movimientos['producto']->numero_dua)) ? strtoupper($data_movimientos['producto']->numero_dua) : "-");

        $excel->getActiveSheet()->SetCellValue('G6', 'PRESENTACION');
        $excel->getActiveSheet()->SetCellValue('G7', 'PAIS');
        $excel->getActiveSheet()->SetCellValue('G8', 'UBICACION');

        $excel->getActiveSheet()->SetCellValue('I6', (isset($data_movimientos['producto']->presentacion)) ? strtoupper($data_movimientos['producto']->presentacion) : "-");
        $excel->getActiveSheet()->SetCellValue('I7', (isset($data_movimientos['producto']->procedencia)) ? strtoupper($data_movimientos['producto']->procedencia) : "-");
        $excel->getActiveSheet()->SetCellValue('I8', (isset($data_movimientos['producto']->ubicacion)) ? strtoupper($data_movimientos['producto']->ubicacion) : "-");

        $excel->getActiveSheet()->SetCellValue('L6', 'CODIGO TMC');
        $excel->getActiveSheet()->SetCellValue('L7', 'TIPO COMPRA');
        $excel->getActiveSheet()->SetCellValue('L8', 'REG. SANITARIO N°');

        $excel->getActiveSheet()->SetCellValue('N6', (isset($data_movimientos['producto']->codigo_barra)) ? strtoupper(" ".$data_movimientos['producto']->codigo_barra) : "-");
        $excel->getActiveSheet()->SetCellValue('N7', (isset($data_movimientos['producto']->tipo_compra)) ? strtoupper($data_movimientos['producto']->tipo_compra) : "-");
        $excel->getActiveSheet()->SetCellValue('N8', (isset($data_movimientos['producto']->registro_sanitario)) ? strtoupper($data_movimientos['producto']->registro_sanitario) : "-");

        $excel->getActiveSheet()->SetCellValue('A10', 'GUIA R');
        $excel->getActiveSheet()->SetCellValue('A11', 'FECHA');
        $excel->getActiveSheet()->SetCellValue('B11', 'NUM.');
        $excel->getActiveSheet()->SetCellValue('C10', 'DOCUMENTO');
        $excel->getActiveSheet()->SetCellValue('C11', 'TIPO');
        $excel->getActiveSheet()->SetCellValue('D11', 'N°');
        $excel->getActiveSheet()->SetCellValue('E11', 'FECHA');
        $excel->getActiveSheet()->SetCellValue('F10', 'PROVEEDOR / CLIENTE');
        $excel->getActiveSheet()->SetCellValue('G10', 'PRODUCTO');
        $excel->getActiveSheet()->SetCellValue('G11', 'N° LOTE/SERIE');
        $excel->getActiveSheet()->SetCellValue('H11', 'FECHA DE VENC.');
        $excel->getActiveSheet()->SetCellValue('I10', 'OPERACION / CANTIDAD');
        $excel->getActiveSheet()->SetCellValue('I11', 'INGRESO');
        $excel->getActiveSheet()->SetCellValue('J11', 'SALIDA');
        $excel->getActiveSheet()->SetCellValue('K11', 'SALDO');
        $excel->getActiveSheet()->SetCellValue('L10', 'REALIZADO POR');
        $excel->getActiveSheet()->SetCellValue('M10', 'VERIFICADO POR');
        $excel->getActiveSheet()->SetCellValue('N10', 'OBSERVACIONES');

        $numero_fila = 12;
        $total = 0;
        $primer_registro = 0;


        foreach ($data_movimientos['movimientos'] as $m) {
            if ($primer_registro == 0) {
                $total = $m['cantidad'];
                $primer_registro++;
            } else {
                if ($m['tipo_transaccion'] == 1) {
                    $total = $total + $m['cantidad'];
                }
                if ($m['tipo_transaccion'] == 2) {
                    $total = $total - $m['cantidad'];
                }
            }
            //$pdf->Cell(10, 10, $fake_id, 1, 0, 'C');
            $excel->getActiveSheet()->SetCellValue('A' . $numero_fila, $m['fecha_remision']);
            $excel->getActiveSheet()->SetCellValue('B' . $numero_fila, $m['remision']);
            //$pdf->Cell(40, 10,  $m['fecha_emision'], 1, 0, 'C');
            /*
            if ($m['tipo_transaccion'] == 1) {
      
              $pdf->Cell(35, 10, "Entrada", 1, 0, 'C');
            } else {
      
              $pdf->Cell(35, 10, "Salida", 1, 0, 'C');
            }
            */
            $excel->getActiveSheet()->SetCellValue('C' . $numero_fila, $m['descripcion']);
            $excel->getActiveSheet()->SetCellValue('D' . $numero_fila, $m['numero']);
            $excel->getActiveSheet()->SetCellValue('E' . $numero_fila, $m['fecha']);
            $excel->getActiveSheet()->SetCellValue('F' . $numero_fila, $m['tercero']);
            $excel->getActiveSheet()->SetCellValue('L' . $numero_fila, $m['usuario']);

            if ($m['tipo_transaccion'] == 1) {

                $excel->getActiveSheet()->SetCellValue('I' . $numero_fila, $m['cantidad']);
            } else {
                $excel->getActiveSheet()->SetCellValue('I' . $numero_fila, "-");
            }
            if ($m['tipo_transaccion'] == 2) {

                $excel->getActiveSheet()->SetCellValue('J' . $numero_fila, $m['cantidad']);
            } else {
                $excel->getActiveSheet()->SetCellValue('J' . $numero_fila, "-");
            }
            $excel->getActiveSheet()->SetCellValue('K' . $numero_fila, $total);
            $numero_fila++;
        }

        $excel->getActiveSheet()->getStyle("A12:N" . $excel->getActiveSheet()->getHighestRow())->applyFromArray($estilo_datos);


        //imagen
        $gdImage = imagecreatefromjpeg(base_url('images/logo_excel.jpg'));
        // Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
        $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $objDrawing->setImageResource($gdImage);
        $objDrawing->setCoordinates('C2');
        $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
        $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
        $objDrawing->setResizeProportional(false);
        $objDrawing->setHeight(70);
        $objDrawing->setWidth(155);
        $objDrawing->setOffsetX(0);
        $objDrawing->setOffsetY(2);
        $objDrawing->setWorksheet($excel->getActiveSheet());


        $filename = "Reporte_Kardex.xlsx";
        $excel->getActiveSheet()->setTitle("KARDEX");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $writer->save('php://output');
        exit;
    }

    public function reporte_compra()
    {
        $this->load->library('pdfdos');
        $pdf = $this->pdfdos;
        $compras = $this->Compra_model->getComprasReporte();

        $pdf->reporte_compra($compras);
    }
}
