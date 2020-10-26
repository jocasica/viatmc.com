<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include "Documentos_html.php";

use Dompdf\Dompdf;


class Printpdf {
	public function get_factura($id) {
		/***** FACTURA: DATOS OBLIGATORIOS PARA EL CÓDIGO QR *****/
		/*RUC | TIPO DE DOCUMENTO | SERIE | NUMERO | MTO TOTAL IGV | MTO TOTAL DEL COMPROBANTE | FECHA DE EMISION |TIPO DE DOCUMENTO ADQUIRENTE | NUMERO DE DOCUMENTO ADQUIRENTE |*/
		
		
		$this->load->library('pdf');
		$html_documentos = new Documentos_html();
		
		
		
		$html = $html_documentos->get_html_factura('');

		define("DOMPDF_ENABLE_REMOTE", true);
        $dompdf = $this->pdf;
		$dompdf->loadHtml($html['html']);
		$dompdf->setPaper('A4');
		$dompdf->render();
		$dompdf->stream("factura_n_".$id.".pdf");
	}

	public function get_boleta($id) {
		$this->load->library('../controllers/fe/documentos_html');
		$html_documentos = $this->documentos_html;
		$html = $html_documentos->get_html_boleta('');

		define("DOMPDF_ENABLE_REMOTE", true);
        $dompdf = new Dompdf();
		$dompdf->loadHtml($html['html']);
		$dompdf->setPaper('A4');
		$dompdf->render();
		$dompdf->stream("boleta_n_".$id.".pdf");
	}

	public function get_notacredito($id) {
		$this->load->library('../controllers/fe/documentos_html');
		$html_documentos = $this->documentos_html;
		$html = $html_documentos->get_html_nota_credito('');

		define("DOMPDF_ENABLE_REMOTE", true);
        $dompdf = new Dompdf();
		$dompdf->loadHtml($html['html']);
		$dompdf->setPaper('A4');
		$dompdf->render();
		$dompdf->stream("notacredito_n_".$id.".pdf");
	}

	public function get_notadebito($id) {
		$this->load->library('../controllers/fe/documentos_html');
		$html_documentos = $this->documentos_html;
		$html = $html_documentos->get_html_nota_debito('');

		define("DOMPDF_ENABLE_REMOTE", true);
        $dompdf = new Dompdf();
		$dompdf->loadHtml($html['html']);
		$dompdf->setPaper('A4');
		$dompdf->render();
		$dompdf->stream("notadebito_n_".$id.".pdf");
	}
}
?>