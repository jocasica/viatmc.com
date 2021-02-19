<?php

class Documentos_html {

    /**
     *
     * @var type 
     */
    private $_moneda = array(
        'PEN' => 'SOLES',
        'USD' => 'DÓLARES AMERICANOS'
    );

    public function get_html_boleta($data, $prods) {
        $date = new DateTime($data->fecha);
        $html = '
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html lang="es-ES" prefix="og: http://ogp.me/ns#" xmlns="https://www.w3.org/1999/xhtml">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport" />
			<link href="https://fonts.googleapis.com/css?family=Josefin+Sans:400,700" rel="stylesheet" type="text/css">
			<link href="plantilla/assets/theme_doc_elect/font-awesome-4.6.1/css/font-awesome.css" rel="stylesheet">
			<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet">
			<link href="plantilla/assets/theme_doc_elect/css/estilo.css" rel="stylesheet">
		</head>
		<style>
		.tablaproductos{
			font-size: 10px;
		}
		tableproductos {
  border-collapse: collapse;
}

tableproductos {
  border: 1px solid black;
}
			.footer {
			position: fixed;
			left: 0;
			top: 90%;
			width: 100%;
			//background-color: red;
			color: white;
			text-align: center;
			}
			.header {
			position: fixed;
				left: 0;
				top: 0%;
				color: white;
				text-align: center;
				}
				.container {
					width: 100%;
					margin: 0 auto;
				  }
				.img {
					width: 100%;
				}
		</style>
		<body>

		<div class="container">
			<table class="tablareceipt">
				<tbody style="width: 100%">
					<tr style="width: 100%">
						<td colspan="2" style="text-align:left;width:50%;"   ><img style="width: 450px"  src="images/foto1.jpg"></td>

						<td  style="width:50%;"   class="datoruc">
							<p>R.U.C. 20546439268</p>
							<p>Boleta electrónica</p>
							<p>' . $data->serie . ' - ' . $data->numero . '</p>
						</td>

					</tr>
					<tr>

						<td style="width:33%;">
							<p style="text-transform: none; text-align:right;">Jr. Pataz Nº 1243 Mz. Q Lt. 30</p>
							<p style="text-transform: none; text-align:right;">2do Piso. Urb. Covida II Etapa</p>
							<p style="text-transform: none; text-align:right;">Los Olivos - Lima</p>
							<p style="text-transform: none; text-align:right;">Referencia: En paralelo con</p>
							<p style="text-transform: none; text-align:right;">Av. Antunez de Mayolo</p>
							<p style="text-transform: none; text-align:right;">(a espaldas del Banco Scotiabank)</p>
						</td>
						<td style="width:33%;"><img style="width: 100px"  class="img" src="images/foto2.png"></td>
						<td style="width:33%;" class="">
							<p style="text-transform: none; text-align:left; ">Cnt. Dolares BBVA:0011-0342-38-0100024845</p>
							<p style="text-transform: none; text-align:left;">Cnt Soles  BBVA:0011-0312-01-0000896</p>
							<p style="text-transform: none; text-align:left;">TELF.: 4851187 CEL.: 968 871 841</p>
							<p style="text-transform: none; text-align:left;">tecnologia.medica.corporation@gmail.com</p>
							<p style="text-transform: none; text-align:left;">ventas@tecnologiamedicacorporation.com</p>
							<p style="text-transform: none; text-align:left;">www.tecnologiamedicacorporation.com</p>
						</td>
					</tr>

				</tbody>
			</table>

			<table style="margin-top:15px;" class="tabladatos" >
				<tbody style="line-height:5px;">
					<tr>
						<td class="tdatoslabel">
							<div style="padding-bottom: 10px; padding-right: 19px;">
								<span style="float: left;">Nombre/Razón Social:</span>
								<div style="margin-left: 140px; ">' . $data->cliente . '</div>
							</div>
						</td>
						<td class="tdatoslabel">
							<div style="padding-bottom: 10px; padding-right: 19px;">
								<span style="float: left;">DNI N°:</span>
								<div style="margin-left: 141px; "> ' . $data->docum . ' </div>
							</div>
						</td>

					</tr>
					<tr>
						<td class="tdatoslabel">
							<div style="padding-bottom: 10px; padding-right: 19px;">
								<span style="float: left;">Dirección:</span>
								<div style="margin-left: 140px; ">' . $data->direccion . '</div>
							</div>
						</td>


						<td class="tdatoslabel tdatodlabeldos">
							<div>
								<span style="float: left;">Fecha de Emisión:</span>
								<div style="margin-left: 141px; ">' . $date->format('d/m/Y') . '</div>
							</div>
						</td>
					</tr>
						<tr>
						<td class="tdatoslabel">
							<div style="padding-bottom: 10px; padding-right: 19px;">
								<span style="float: left;">Moneda:</span>
								<div style="margin-left: 140px; ">' . $data->codigo_moneda . '</div>
							</div>
						</td>


						<td class="tdatoslabel tdatodlabeldos">
							<div>
								<span style="float: left;">Fecha de Vencimiento:</span>
								<div style="margin-left: 141px; ">.</div>
							</div>
						</td>
					</tr>

					<tr>
						<td class="tdatoslabel">
							<div style="padding-bottom: 10px; padding-right: 19px;">';
        $html .= ($data->tipo_venta == "PRODUCTOS") ? '<span style="float: left;">Orden de Compra:</span>' : '<span style="float: left;">Orden de Servicio: </span>';
        $html .= '<div style="margin-left: 140px; ">' . $data->orden_servicio . '</div>
							</div>
						</td>


						<td class="tdatoslabel tdatodlabeldos">
							<div>
								<span style="float: left;">Sunat:</span>
								<div style="margin-left: 141px; ">' . $data->envio . '</div>
							</div>
						</td>
					</tr>

				</tbody>
			</table>

			<div class="tablageneral">
				<table class="" cellpadding="0" cellspacing="0" border="1">
					<tbody style="line-height:6px;">
					<tr class="titulotable">
							<th class="tablaproductos  " style="padding:10px;">Ítem</th>
					        <th class="tablaproductos  " style="padding:10px;">Código</th>
					        <th class="tablaproductos  " style="padding:10px;">Descripción</th>
					        <th class="tablaproductos  " style="padding:10px;">Und.</th>
							<th class="tablaproductos  " style="padding:10px;">Cantidad</th>
							<th class="tablaproductos  " style="padding:10px;">V. Unitario</th>
							<th class="tablaproductos  "  style="padding:10px;">P. Unitario</th>
							<th class="tablaproductos  " style="padding:10px;">Descuento (afecto al IGV)</th>
							<th class="tablaproductos "  style="padding:10px;">Valor de venta</th>
						</tr>';
        $html2 = '';
        $subtotal = 0;
        $total = 0;
        $i = 1;
        foreach ($prods->result() as $pro) {
            if (!isset($pro->unidad)) {
                $pro->unidad = '';
            }
            $html2 = $html2 . '<tr  style="padding-left:10px; padding-right:0px; padding-bottom: 0px; padding-top:0px;" class="detalletable tablaproductos">
						  	<td  style="padding-left:10px; padding-right:0px; padding-bottom: 0px; padding-top:0px;" class="tablaproductos ">' . $i . '</td>
						    <td  style="padding-left:10px; padding-right:0px; padding-bottom: 0px; padding-top:0px;" class="tablaproductos ">' . $pro->codigo_producto . '</td>
							<td style="padding-left:10px; padding-right:0px; padding-bottom: 0px; padding-top:0px;"  class="tablaproductos ">' . $pro->nombre_producto . ' ' . /* $pro->serie. */'</td>
						 	<td style="padding-left:10px; padding-right:0px; padding-bottom: 0px; padding-top:0px;"  class="tablaproductos ">' . $pro->unidad . '</td>
							<td style="padding-left:10px; padding-right:0px; padding-bottom: 0px; padding-top:0px;"  class="nombredetalle tablaproductos">' . round($pro->cantidad, 2) . '</td>
							<td style="padding-left:10px; padding-right:0px; padding-bottom: 0px; padding-top:0px;"  class="tablaproductos ">' . number_format($pro->subtotal, 2) . '</td>
							<td style="padding-left:10px; padding-right:0px; padding-bottom: 0px; padding-top:0px;"  class=" tablaproductos">' . number_format($pro->total, 2) . '</td>

							<td class=""></td>
							<td class="ulttable tablaproductos">' . number_format($pro->total, 2) . '</td>
						</tr>';
            $subtotal += $pro->subtotal;
            $total += $pro->total;
            $i = $i + 1;
        }
        $html3 = '</tbody></table></div>
			<div style="margin-top: 15px;" class="tablageneral tablacostos">
				<table cellpadding="0" cellspacing="0">
					<tbody style="line-height:1px;">
						<tr class="detalletable">

							<td></td>
							<td></td>

							<td class="  "><b>Op. Gravada</b></td>
							<td>' . $data->codigo_moneda . '</td>

							<td class="  ">' . number_format($subtotal, 2) . '</td>
						</tr>
						<tr class="detalletable">
							<td></td>
							<td></td>
							<td class=""><b>I.G.V. (18%)</b></td>
							<td>' . $data->codigo_moneda . '</td>
							<td class="">' . number_format($total - $subtotal, 2) . '</td>
						</tr>
						<tr class="detalletable">
							<td></td>
							<td></td>
							<td class=""><b>Op. Inafecta</b></td>
							<td>' . $data->codigo_moneda . '</td>
							<td class="">0.00</td>
						</tr>
						<tr class="detalletable">
							<td></td>
							<td></td>
							<td class=""><b>Op. Exonerada</b></td>
							<td>' . $data->codigo_moneda . '</td>
							<td class="">0.00</td>
						</tr>
						<tr class="detalletable">
							<td></td>
							<td></td>
							<td class=""><b>Op. Exportación</b></td>
							<td>' . $data->codigo_moneda . '</td>
							<td class="preciotabla ulttable fintabla">0.00</td>
						</tr>
						<tr class="detalletable">
							<td></td>
							<td></td>
							<td class=""><b>Importe Total</b></td>
							<td>' . $data->codigo_moneda . '</td>
							<td class=" ">' . number_format($total, 2) . '</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div style="margin-top: 15px;" class="tablageneral tablacostos">
				<table cellpadding="0" cellspacing="0" border="1">
					<tbody style="line-height:1px;">
						<tr class="detalletable">
							<td><div style="margin-bottom:15px;margin-top:5px;"><b>Observaciones de SUNAT:</b></div><div> El comprobante numero ' . $data->serie . ' - ' . $data->numero . ', ha sido aceptado.</div> </td>
						</tr>

					</tbody>
				</table>
			</div>
			<div style="margin-top: 15px;"><b>Información Adicional</b></div>
			<div style="margin-top: 15px;" class="tablageneral tablacostos">
				<table cellpadding="0" cellspacing="0" border="1">
					<tbody style="line-height:5px;">
						<tr class="detalletable">
							<td style="width:15px;">1</td>
							<td style="width:200px;">Orden de Servicio </td>
							<td>' . $data->orden_servicio . '</td>

						</tr>
						<tr class="detalletable">
							<td style="width:15px;">2</td>
							<td style="width:200px;">Guía de Remisión </td>
							<td>' . $data->guia_remision . '</td>

						</tr>
					</tbody>
				</table>
			</div>
			<div style="margin-top: 15px; font-size:12px;"><em>Autorizado a ser emisor electrónico mediante R.I. SUNAT Nº</em></div>

			</div>
			<div class="footer">
			<img style="width: 620px;float:left;" src="images/imagen-footer.png">
			<img style="width: 70px;" src="plantilla/assets/theme_doc_elect/images/qr.png" />
			</div>
			</div>
		</body>
		</html>
		';

        $resp['respuesta'] = 'ok';
        $resp['html'] = $html . $html2 . $html3;
        return $resp;
    }

	public function get_html_cotizacion($data, $prods) {
		# Formato reporte cotización
		$date = new DateTime($data->fecha);
		$html = '
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html lang="es-ES" prefix="og: http://ogp.me/ns#" xmlns="https://www.w3.org/1999/xhtml">
			<head>
				<title>Cotización N° '.$data->id.'</title>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport" />
				<link href="https://fonts.googleapis.com/css?family=Josefin+Sans:400,700" rel="stylesheet" type="text/css">
				<link href="plantilla/assets/theme_doc_elect/font-awesome-4.6.1/css/font-awesome.css" rel="stylesheet">
				<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet">
				<link href="plantilla/assets/theme_doc_elect/css/estilo.css" rel="stylesheet">
			</head>
			<style>
				@page{ margin: 160px 40px 60px 40px !important; } /* top right bottom left*/
				table { page-break-after:auto }
				tr    { page-break-inside:avoid; page-break-after:auto }
				td    { page-break-inside:avoid; page-break-after:auto }
				thead { display:table-header-group }
				tfoot { display:table-footer-group }
				.tablaproductos{ font-size: 10px; }
				.container{ width: 100%; margin: 0 auto; }
				.img { width: 100%; }
				u { text-decoration: underline; }
				.page_break { page-break-before: always; }
				/* Define the width, height, margins and position of the watermark. */
				#watermark {
					position: fixed;
					top:			-160px;
					bottom:   0px;
					left:     -40px;
					/* The width and height may change according to the dimensions of your letterhead */
					width:    21.8cm;
					height:   29.7cm;
					/* Your watermark should be behind every content */
					z-index:  -1000;
				}
				ol { margin-bottom: 10px; }
				ul { margin-bottom: 10px; }
				li  { font-size: 14px !important; line-height: 1; margin-left: 20px; }
			</style>
			<body>
				<div id="watermark">
					<img src="./imagenes/margen.jpg" height="100%" width="100%" />
				</div>';
				# generar fecha literal
				$meses_nombre		= ['enero', 'febreo', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
				list($c_año, $c_mes, $c_dia) = explode('-', $data->fecha);
				$fecha_literal	= $c_dia.' de '.$meses_nombre[$c_mes-1].' de '.$c_año;
				# gestion cotización (2 digitos)
				$gestion2d			= substr($c_año, 2, 2);
				# cantidad digitos cotizacion
				$cantida_digitos		= 4;
				$numero_cotizacion	= str_repeat('0', $cantida_digitos-strlen($data->id)).$data->id;
				# ---------------------
				$html2 = '';
				$precioproducto = 0;
				$montoproducto = 0;
				$i = 1;
				$masDeDosProductos = false;
				foreach ($prods as $pro) {
					if (!$masDeDosProductos) {
						$masDeDosProductos = true;
					} else {
						$html2 .= '<div style="page-break-after:always;"></div>';
					}
					$html2 = $html2 . '
				<div class="container">
					<table>
						<tbody>
							<tr>
								<td style="text-align:right;"><b>COTIZACIÓN N°: ' . $numero_cotizacion . '-' . $i . 'TMC - MHE/' . $gestion2d . '</b></td>
							</tr>
							<tr>
								<td style="text-align:left; font-size:14px">Lima, '.$fecha_literal.'</td>
							</tr>
							<tr>
								<td style="text-align:left; font-size:14px">Señores: </td>
							</tr>
							<tr>
								<td  style="text-align:left; font-size:14px"><b>';
									foreach ($data->nombre_clientes as $cliente) {
										$html2 .= $cliente->nombre_cotizacion;
									}
									$html2 .= '</b>
								</td>
							</tr>
							<tr>
								<td  style="text-align:left; font-size:14px;">Presente</td>
							</tr>
							<tr>
								<td  style="text-align:left; font-size:14px"><b>Estimados Señores:</b></td>
							</tr>
							<tr>
								<td  style="text-align:left; font-size:14px;">En respuesta a su solicitud, tenemos el agrado de hacerles llegar nuestra propuesta TECNICA - ECONOMICA</td>
							</tr>
						</tbody>
					</table>
					<table class="" cellpadding="0" cellspacing="0" border="1" id="tabla_detalle_cotizacion">
						<thead>
							<tr class="titulotable">
								<th class="tablaproductos" style="padding:10px; text-align: center;">ITEM</th>
								<th class="tablaproductos" style="padding:10px; text-align: center;">DESCRIPCION</th>
								<th class="tablaproductos" style="padding:10px; text-align: center;">CANT.</th>
								<th class="tablaproductos" style="padding:10px; text-align: center;">P.U. (S/.)</th>
								<th class="tablaproductos" style="padding:10px; text-align: center;">P.T. (S/.)</th>
							</tr>
						</thead>
						<tbody>
							<tr class="detalletable tablaproductos">
								<td style="text-align:center;font-size:18px;" class="tablaproductos">' . $i . '</td>
								<td class="tablaproductos ">
									<p style="text-align:center;font-weight:700;text-decoration:underline;">' . $pro->nombre . '</p>';
									if ($pro->producto_descripcion != "") {
										$html2 .= '<br><p style="text-align:left;font-weight:700;" class="producto_descripcion">' . $pro->producto_descripcion . '</p>';
									}
									if ($pro->marca != "") {
										$html2 .= '<p style="text-align:left;font-weight:700;">MARCA: ' . $pro->marca . '</p>';
									}
									if ($pro->procedencia != "") {
										$html2 .= '<p style="text-align:left;font-weight:700;">PROCEDENCIA: ' . $pro->procedencia . '</p>';
									}
									if ($pro->modelo != "") {
										$html2 .= '<p style="text-align:left;font-weight:700;">MODELO: ' . $pro->modelo . '</p>';
									}
								$html2 .= '</td>';
								$html2 .= '<td style="padding-left:10px; padding-right:0px; padding-bottom: 0px; padding-top:0px;font-size:18px;"  class="nombredetalle tablaproductos">' . round($pro->cantidad, 2) . '</td>
								<td style="padding-left:10px; padding-right:0px; padding-bottom: 0px; padding-top:0px;font-size:18px;"  class="tablaproductos ">' . number_format($pro->precioproducto, 2) . '</td>
								<td style="padding-left:10px; padding-right:0px; padding-bottom: 0px; padding-top:0px;font-size:18px;"  class=" tablaproductos">' . number_format($pro->montoproducto, 2) . '</td>
							</tr>
						</tbody>
					</table>';
					$ruta1 = './' . $pro->image1;
					$ruta2 = './' . $pro->image2;
					if(is_file($ruta1)) {
						$html2 = $html2 . '<img style="margin-top:100px;margin-left:315px;" width="120px" src="' . $pro->image1 . '"  />';
					}
					if(is_file($ruta2)) {
						$html2 = $html2 . '<img style="margin-top:100px;margin-left:315px;" width="100px" src="' . $pro->image2 . '"  />';
					}
					if(is_file($ruta1) || is_file($ruta2)) {
						$html2 = $html2 . '<br>
							<br><p style="text-align:center;font-weight:700;">IMAGEN REFERENCIAL</p>';
					} else {
						$html2 = $html2 . '<br>';
					}
					$html2 = $html2 . '
					<br>
					<p style="text-align:left;font-weight:700;text-decoration:underline;margin-left:80px;margin-top:30px;">Precios Incluyen I.G.V. (18%)</p>';
					$html2 .= ($pro->validezOferta != "") ? '<p style="text-align:left;font-weight:700;margin-left:80px;">Validez de oferta :   <span style="margin-left:15px;">' . $pro->validezOferta . '</span></p>' : "";
					$html2 .= ($pro->entrega != "") ? '<p style="text-align:left;font-weight:700;margin-left:80px;">Entrega :<span style="margin-left:80px;">' . $pro->entrega . ' </span></p>' : "";
					$html2 .= ($pro->formaPago != "") ? '<p style="text-align:left;font-weight:700;margin-left:80px;">Forma de pago : <span style="margin-left:28px;">' . $pro->formaPago . '</span></p>' : "";
					$html2 .= ($pro->garantiaMeses != "") ? '<p style="text-align:left;font-weight:700;margin-left:80px;">Garantía : <span style="margin-left:70px;">' . $pro->garantiaMeses . ' </span></p>' : "";
					$html2 = $html2 . '<p style="text-align:left;margin-left:80px;margin-top:20px;">Agradeciendo siempre vuestra preferencia, quedamos de ustedes.</p>
					<p style="text-align:left;margin-left:80px;">Atentamente.</p>
					<img style="margin-top:20px;margin-left:220px;" width="300" height="150" src="./imagenes/firma.png"  />
					<br>
					<br>
					<br>';
					$precioproducto += $pro->precioproducto;
					$montoproducto += $pro->montoproducto;
					$i = $i + 1;
				};
				$html3 = '
				</div>
			</body>
		</html>';
		$resp['respuesta'] = 'ok';
		$resp['html'] = $html . $html2 . $html3;
		return $resp;
  }

    public function get_html_cotizacion_servicio($data, $prods) {
        $date = new DateTime($data->fecha);
        $html = '
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html lang="es-ES" prefix="og: http://ogp.me/ns#" xmlns="https://www.w3.org/1999/xhtml">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport" />
			<link href="https://fonts.googleapis.com/css?family=Josefin+Sans:400,700" rel="stylesheet" type="text/css">
			<link href="plantilla/assets/theme_doc_elect/font-awesome-4.6.1/css/font-awesome.css" rel="stylesheet">
			<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet">
			<link href="plantilla/assets/theme_doc_elect/css/estilo.css" rel="stylesheet">
		</head>
		<style>
		.tablaproductos{
			font-size: 10px;
		}
		tableproductos {
  border-collapse: collapse;
}

tableproductos {
  border: 1px solid black;
}
			.footer {
			position: fixed;
			left: 0;
			top: 90%;
			width: 100%;
			//background-color: red;
			color: white;
			text-align: center;
			}
			.header {
			position: fixed;
				left: 0;
				top: 0%;
				color: white;
				text-align: center;
				}
				.container {
					width: 100%;
					margin: 0 auto;
				  }
				.img {
					width: 100%;
				}
				u {
				  text-decoration: underline;
				}
				.page_break { page-break-before: always; }
				.imagefront{  z-index: 99999999999;
   }

   .borderCeldas {
	width: 25%;
	text-align: center;
	vertical-align: top;
	border: 1px solid #000;
	border-spacing: 0;

	}

			/**
			* Define the width, height, margins and position of the watermark.
			**/
			#watermark {
				position: fixed;
				bottom:   0px;
				left:     0px;
				/** The width and height may change
					according to the dimensions of your letterhead
				**/
				width:    21.8cm;
				height:   29.7cm;

				/** Your watermark should be behind every content**/
				z-index:  -1000;
			}
		</style>
		<body>
			<div id="watermark">
				<img src="./imagenes/margen.jpg" height="100%" width="100%" />
			</div>';

        $html2 = '';

        $i = 1;


        foreach ($prods->result() as $pro) {
            $mes = date("F");
            $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
            $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            $nombreMes = str_replace($meses_EN, $meses_ES, $mes);

            $html2 = $html2 . '<div class="container" style="margin-top:150px;" >
		<br><br><br>
			<table class="tablareceipt">
				<tbody style="line-height: 1px;">
					<tr >
						<td  style="margin-right:200px; text-align:right;"><b style="text-align:left;">COTIZACIÓN N°:' . $data->id . '-' . $i . 'TMC- MHE/19</b></td>

					</tr>
					<tr >
						<td  style="margin-right:200px; text-align:left; font-size:14px">Lima, ' . date("d") . ' de ' . $nombreMes . ' de ' . date("Y") . ' </td>

					</tr>
					<tr >
						<td  style="margin-right:200px; text-align:left; font-size:14px">Señores: </td>

					</tr>
					<tr >
						<td  style="margin-right:200px; text-align:left; font-size:14px"><b>';
            foreach ($data->nombre_clientes as $cliente) {
                $html2 .= $cliente->nombre_cotizacion;
            }
            $html2 .= '</b>
						</td>
					</tr>
					<tr >
						<td  style="margin-right:200px; text-align:left; font-size:14px;">Presente.-</td>

					</tr>
					<tr><td></td></tr>
					<tr >
						<td  style="margin-right:200px; text-align:left; font-size:14px;">At: Unidad Logística</td>

					</tr>
					<tr >
						<td  style="margin-right:200px; text-align:left; font-size:14px;">Referencia <b>' . $pro->referencia . '</b></td>

					</tr>
					<tr><td></td></tr>
					<tr >

						<td  style="margin-right:200px; text-align:left; font-size:14px"><b>Estimados Señores:</b></td>

					</tr>
										<tr >
						<td  style="margin-right:200px; text-align:left; font-size:14px;">En respuesta a su solicitud, tenemos el agrado de hacerles llegar nuestra propuesta TECNICA - ECONOMICA</td>

					</tr>
				</tbody>
			</table>
			<div style="text-align:center;margin-left:80px;margin-top:20px;"><p style="text-align:center;margin-left:80px;"><h3>SERVICIO: ' . $pro->servicio_id . '</h3></p></div>
			<table style="margin-left:20px;  border: 1px solid #000;" class="tablaServicios" cellspacing="0">
				<tr style="background-color:	#C7D9F1;">
					<th class="borderCeldas">' . $pro->equipoTitulo . '</th>
					<th class="borderCeldas">' . $pro->MarcaTitulo . '</th>
					<th class="borderCeldas">' . $pro->ModeloTitulo . '</th>
					<th class="borderCeldas">' . $pro->NroSerieTitulo . '</th>
					<th class="borderCeldas">' . $pro->CodInvTitulo . '</th>
				</tr>
				<tr style="background-color:#F2F2F2;">
					<td class="borderCeldas">' . $pro->equipoDetalle . '</td>
					<td class="borderCeldas">' . $pro->MarcaDetalle . '</td>
					<td class="borderCeldas">' . $pro->ModeloDetalle . '</td>
					<td class="borderCeldas">' . $pro->NroSerieDetalle . '</td>
					<td class="borderCeldas">' . $pro->CodInvDetalle . '</td>

				</tr>
			</table>

			<br>

			<br><div style="text-align:center;margin-left:80px;margin-top:20px;"><p style="text-align:center;margin-left:80px;"><h2>MONTO TOTAL ' . $data->montototal . '</h2></p></div>
			<br>
			<div style="text-align:left;margin-left:80px;margin-top:20px;">
			<p style="text-align:left;"><b>' . $pro->MantenimientoTitulo . '</b>
			<ul>';
            $html2 .= ($pro->MantenimientoDetalle1 != "") ? '<li>' . $pro->MantenimientoDetalle1 . '</li>' : "";
            $html2 .= ($pro->MantenimientoDetalle2 != "") ? '<li>' . $pro->MantenimientoDetalle2 . '</li>' : "";
            $html2 .= ($pro->MantenimientoDetalle3 != "") ? '<li>' . $pro->MantenimientoDetalle3 . '</li>' : "";
            $html2 .= ($pro->MantenimientoDetalle4 != "") ? '<li>' . $pro->MantenimientoDetalle4 . '</li>' : "";
            $html2 .= ($pro->MantenimientoDetalle5 != "") ? '<li>' . $pro->MantenimientoDetalle5 . '</li>' : "";

            $html2 .= '</ul>
			</p>
			<p style="text-align:left;"><b>' . $pro->CambioPartesTitulo . '</b>
			<ul>';
            $html2 .= ($pro->CambioPartesDetalle != "") ? '<li>' . $pro->CambioPartesDetalle . '</li>' : "";


            $html2 .= '</ul>
			</p>
			<p style="text-align:left;"><b>' . $pro->VerificacionTitulo . '</b>
			<ul>';

            $html2 .= ($pro->VerificacionDetalle != "") ? '<li>' . $pro->VerificacionDetalle . '</li>' : "";


            $html2 .= '</ul></p>
			<div class="page_break"></div>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<p style="text-align:left;"><b>' . $pro->TerminosComercialesTitulo . '</b>
			<ul>';
            $html2 .= ($pro->TerminosComercialesDetalle1 != "") ? '<li>' . $pro->TerminosComercialesDetalle1 . '</li>' : "";
            $html2 .= ($pro->TerminosComercialesDetalle2 != "") ? '<li>' . $pro->TerminosComercialesDetalle2 . '</li>' : "";
            $html2 .= ($pro->TerminosComercialesDetalle3 != "") ? '<li>' . $pro->TerminosComercialesDetalle3 . '</li>' : "";


            $html2 .= '</ul></p>
			</div>


			';

            // $html2 = $html2.'<img style="margin-top:100px;margin-left:100px;" width="250" height="200" src="'.base_url().$pro->image2.'"  />';
            $html2 = $html2 . '



			<p style="text-align:left;margin-left:80px;margin-top:20px;">Agradeciendo siempre vuestra preferencia, quedamos de ustedes.</p>
			<p style="text-align:left;margin-left:80px;">Atentamente.</p>
			<img style="margin-top:20px;margin-left:220px;" width="300" height="150" src="./imagenes/firma.png"  />
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>

			<br>
			<br>
			';


            $i = $i + 1;
        }

        $html3 = '</div></body>
		</html>
		';


        $resp['respuesta'] = 'ok';
        $resp['html'] = $html . $html2 . $html3;
        return $resp;
    }

    public function get_html_factura($data, $prods) {
		$CI = &get_instance();
		$CI->load->library('numero_a_letras');
        $date = new DateTime($data->fecha);


        if ($data->vencimiento === null || $data->vencimiento === "") {
        	$vencimiento = "";
		} else {
			$vencimiento = new DateTime($data->vencimiento);
			$vencimiento = $vencimiento->format('d/m/Y');
		}

        ob_start();
        ?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="https://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport" />
            <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:400,700" rel="stylesheet" type="text/css" />
            <link href="plantilla/assets/theme_doc_elect/font-awesome-4.6.1/css/font-awesome.css" rel="stylesheet" />
            <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet" />
            <link href="plantilla/assets/theme_doc_elect/css/estilo.css" rel="stylesheet" />
        </head>
        <style>
            .tablaproductos{
                font-size: 11px;
            }
            tableproductos {
                border-collapse: collapse;
            }
            tableproductos {
                border: 1px solid black;
            }
            .footer {
                position: fixed;
                left: 0;
                top: 90%;
                width: 100%;
                color: white;
                text-align: center;
            }
            .header {
                position: fixed;
                left: 0;
                top: 0%;
                color: white;
                text-align: center;
            }
            .container {
                width: 100%;
                margin: 0 auto;
            }
            .img {
                width: 100%;
            }
        </style>
        <body>
            <div class="container">
                <table class="tablareceipt">
                    <tbody style="width: 100%">
                        <tr style="width: 100%">
                            <td colspan="2" style="text-align:left;width:50%;" >
                                <img style="width: 450px" src="images/foto1.jpg">
                            </td>
                            <td  style="width:50%;" class="datoruc">
                                <p>R.U.C. 20546439268</p>
                                <p>Factura electrónica</p>
                                <p><?php echo $data->serie . ' - ' . $data->numero; ?></p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:33%;">
                                <p style="text-transform: none; text-align:right;">Jr. Pataz Nº 1243 Int. B Urb. Covida</p>
                                <p style="text-transform: none; text-align:right;">Etapa Los Olivos</p>
                                <p style="text-transform: none; text-align:right;">Los Olivos - Lima</p>
                                <p style="text-transform: none; text-align:right;">Referencia: En paralelo con</p>
                                <p style="text-transform: none; text-align:right;">Av. Antunez de Mayolo</p>
                                <p style="text-transform: none; text-align:right;">(a espaldas del Banco Scotiabank)</p>
                            </td>
                            <td style="width:33%;"><img style="width: 100px"  class="img" src="images/foto2.png"></td>
                            <td style="width:33%;" class="">
                                <p style="text-transform: none; text-align:left; ">Cnt. Dolares BBVA:0011-0342-38-0100024845</p>
                                <p style="text-transform: none; text-align:left;">Cnt Soles  BBVA:0011-0312-01-0000896</p>
                                <p style="text-transform: none; text-align:left;">TELF.: 4851187 CEL.: 968 871 841</p>
                                <p style="text-transform: none; text-align:left;">tecnologia.medica.corporation@gmail.com</p>
                                <p style="text-transform: none; text-align:left;">ventas@tecnologiamedicacorporation.com</p>
                                <p style="text-transform: none; text-align:left;">www.viatmc.com</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="tabladatos" style="font-size:12px;line-height:14px;vertical-align: text-top" valign=" ">
                    <tbody>
                        <tr>
                            <td class="tdatoslabel" width="10%"><b>Nombre/Razón Social:</b></td>
                            <td class="tdatoslabel" width="60%"><?php echo $data->cliente; ?></td>
                            <td class="tdatoslabel" width="10%"><b>RUC N°:</b></td>
                            <td class="tdatoslabel" width="20%"><?php echo $data->docum; ?></td>
                        </tr>
                        <tr>
                            <td class="tdatoslabel"><b>Dirección:</b></td>
                            <td class="tdatoslabel"><?php echo $data->direccion; ?></td>
                            <td class="tdatoslabel"><b>Fecha de Emisión:</b></td>
                            <td class="tdatoslabel"><?php echo $date->format('d/m/Y'); ?></td>
                        </tr>
                        <tr>
                            <td class="tdatoslabel"><b>Moneda:</b></td>
                            <td class="tdatoslabel"><?php echo $data->codigo_moneda; ?></td>
                            <td class="tdatoslabel"><b>Fecha de Vencimiento:</b></td>
                            <td class="tdatoslabel"><?php echo $vencimiento; ?></td>
                        </tr>
                        <tr>
                            <td class="tdatoslabel">
                                <b><?php echo ($data->tipo_venta == "PRODUCTOS") ? 'Orden de Compra:' : 'Orden de Servicio:'; ?></b>
                            </td>
                            <td class="tdatoslabel"><?php echo $data->orden_servicio; ?></td>
                            <td class="tdatoslabel"><b>Forma de Pago:</b></td>
                            <td class="tdatoslabel"><?php echo $data->metodo_pago; ?></td>
                        </tr>
                    </tbody>
                </table>
                <table cellpadding="0" cellspacing="0" style="border: 1px solid black;">
                    <thead>
                        <tr style="background-color: #a2a2a2 !important;">
                            <th width="8%" >Ítem</th>
                            <th width="8%" >Código</th>
                            <th width="52%" >Descripción</th>
                            <th width="8%" >U.M.</th>
                            <th width="8%"  >Cantidad</th>
                            <th width="8%"  >Precio</th>
                            <th width="8%"  >Total</th>
                        </tr>
                    </thead>
                    <tbody style="line-height: 12px">
                        <?php  $subtotal = 0; $total = 0; $i = 1;
                        foreach ($prods->result() as $pro) {
                            if (!isset($pro->unidad)) {
                                $pro->unidad = '';
                            } ?>
                            <tr>
                                <td style="border-top: 1px solid black; padding-left:10px; padding-right:0px; padding-bottom: 3px; padding-top:3px;" class="tablaproductos "><?php echo $i; ?></td>
                                <td style="border-top: 1px solid black; padding-left:10px; padding-right:0px; padding-bottom: 3px; padding-top:3px;" class="tablaproductos "><?php echo $pro->codigo_producto; ?></td>
                                <td style="border-top: 1px solid black; padding-left:10px; padding-right:0px; padding-bottom: 3px; padding-top:3px;" class="tablaproductos "><?php echo $pro->nombre_producto; ?>
								</td>
                                <td style="border-top: 1px solid black; padding-left:10px; padding-right:0px; padding-bottom: 3px; padding-top:3px;" class="tablaproductos "><?php echo $pro->unidad; ?></td>
                                <td style="border-top: 1px solid black; padding-left:10px; padding-right:0px; padding-bottom: 3px; padding-top:3px;" class="tablaproductos"><?php echo round($pro->cantidad, 2); ?></td>
                                <td style="border-top: 1px solid black; padding-left:10px; padding-right:0px; padding-bottom: 0px; padding-top:0px;" class=" tablaproductos"><?php echo number_format($pro->precio_unidad, 2); ?></td>
                                <td class="tablaproductos" style="border-top: 1px solid black; "><?php echo number_format($pro->total, 2); ?></td>
                            </tr>
                        <?php
                            $subtotal += $pro->subtotal;
                            $total += $pro->total;
                            $i = $i + 1;
                        } ?>
                    </tbody>
                </table>
                <table cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td width="55%"></td>
                            <td width="15%"><b>Op. Gravada</b></td>
                            <td width="15%"><?php echo $data->codigo_moneda; ?></td>
                            <td width="15%" style="text-align: right;"><?php echo number_format($subtotal, 2); ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><b>I.G.V. (18%)</b></td>
                            <td><?php echo $data->codigo_moneda; ?></td>
                            <td style="text-align: right;"><?php echo number_format($total - $subtotal, 2); ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><b>Op. Inafecta</b></td>
                            <td><?php echo $data->codigo_moneda; ?></td>
                            <td style="text-align: right;">0.00</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><b>Op. Exonerada</b></td>
                            <td><?php echo $data->codigo_moneda; ?></td>
                            <td style="text-align: right;">0.00</td>
                            </tr>
                        <tr>
                            <td></td>
                            <td><b>Op. Exportación</b></td>
                            <td><?php echo $data->codigo_moneda; ?></td>
                            <td style="text-align: right;">0.00</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><b>Importe Total</b></td>
                            <td><?php echo $data->codigo_moneda; ?></td>
                            <td style="text-align: right;border-top: solid 1px #a09f9f !important;"><?php echo number_format($total, 2); ?></td>
                        </tr>
                    </tbody>
                </table>
                <span><b>SON:</b> <?php echo $CI->numero_a_letras->convert($total, $this->_moneda[$data->codigo_moneda], TRUE); ?></span>
                <table cellpadding="0" cellspacing="0" border="1">
                    <tbody>
                        <tr class="detalletable">
                            <td><b>Observaciones de SUNAT:</b> El comprobante numero <?php echo $data->serie . ' - ' . $data->numero . ', se encuentra ' . ($data->estado_api != NULL ? $data->estado_api : 'registrado' ); ?></td>
                        </tr>
                    </tbody>
                </table>
                <div style="margin-top: 15px;"><b>Información Adicional</b></div>
                <div style="margin-top: 15px;" class="tablageneral tablacostos">
                    <table cellpadding="0" cellspacing="0" border="1">
                        <tbody>
                            <tr class="detalletable">
                                <td style="width:15px;">2</td>
                                <td style="width:200px;">Guía de Remisión </td>
                                <td><?php echo $data->guia_remision; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="footer">
                <img style="width: 620px;float:left;" src="images/imagen-footer.png" />
                <img style="width: 70px;" src="plantilla/assets/theme_doc_elect/images/qr.png" />
            </div>
        </body>
        </html>
        <?php 
        $html= ob_get_clean();
        $resp['respuesta'] = 'ok';
        $resp['html'] = $html;
        return $resp;
    }
		public function get_html_factura_nota_credito($data, $prods) {
			$CI = &get_instance();
			$CI->load->library('numero_a_letras');
					$date = new DateTime($data->fecha);
					if ($data->vencimiento === null || $data->vencimiento === "") {
						$vencimiento = "";
			} else {
				$vencimiento = new DateTime($data->vencimiento);
				$vencimiento = $vencimiento->format('d/m/Y');
			}

					ob_start();
					?>
					<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
					<html xmlns="https://www.w3.org/1999/xhtml">
					<head>
							<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
							<meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport" />
							<link href="https://fonts.googleapis.com/css?family=Josefin+Sans:400,700" rel="stylesheet" type="text/css" />
							<link href="plantilla/assets/theme_doc_elect/font-awesome-4.6.1/css/font-awesome.css" rel="stylesheet" />
							<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet" />
							<link href="plantilla/assets/theme_doc_elect/css/estilo.css" rel="stylesheet" />
					</head>
					<style>
							.tablaproductos{
									font-size: 11px;
							}
							tableproductos {
									border-collapse: collapse;
							}
							tableproductos {
									border: 1px solid black;
							}
							.footer {
									position: fixed;
									left: 0;
									top: 90%;
									width: 100%;
									color: white;
									text-align: center;
							}
							.header {
									position: fixed;
									left: 0;
									top: 0%;
									color: white;
									text-align: center;
							}
							.container {
									width: 100%;
									margin: 0 auto;
							}
							.img {
									width: 100%;
							}
					</style>
					<body>
							<div class="container">
								<?php
									$num_digitos = 8; 
									$numero_nota_credito = str_repeat('0', $num_digitos-strlen($data->id_factura_nota_credito)).$data->id_factura_nota_credito;
								?>
									<table class="tablareceipt">
											<tbody style="width: 100%">
													<tr style="width: 100%">
															<td colspan="2" style="text-align:left;width:50%;" >
																	<img style="width: 450px" src="images/foto1.jpg">
															</td>
															<td  style="width:50%;" class="datoruc">
																	<p>R.U.C. 20546439268</p>
																	<p>Nota de Crédito</p>
																	<p><?php echo $data->serie_nota.' - '.$numero_nota_credito; ?></p>
															</td>
													</tr>
													<tr>
															<td style="width:33%;">
																	<p style="text-transform: none; text-align:right;">Jr. Pataz Nº 1243 Int. B Urb. Covida</p>
																	<p style="text-transform: none; text-align:right;">Etapa Los Olivos</p>
																	<p style="text-transform: none; text-align:right;">Los Olivos - Lima</p>
																	<p style="text-transform: none; text-align:right;">Referencia: En paralelo con</p>
																	<p style="text-transform: none; text-align:right;">Av. Antunez de Mayolo</p>
																	<p style="text-transform: none; text-align:right;">(a espaldas del Banco Scotiabank)</p>
															</td>
															<td style="width:33%;"><img style="width: 100px"  class="img" src="images/foto2.png"></td>
															<td style="width:33%;" class="">
																	<p style="text-transform: none; text-align:left; ">Cnt. Dolares BBVA:0011-0342-38-0100024845</p>
																	<p style="text-transform: none; text-align:left;">Cnt Soles  BBVA:0011-0312-01-0000896</p>
																	<p style="text-transform: none; text-align:left;">TELF.: 4851187 CEL.: 968 871 841</p>
																	<p style="text-transform: none; text-align:left;">tecnologia.medica.corporation@gmail.com</p>
																	<p style="text-transform: none; text-align:left;">ventas@tecnologiamedicacorporation.com</p>
																	<p style="text-transform: none; text-align:left;">www.viatmc.com</p>
															</td>
													</tr>
											</tbody>
									</table>
									<table class="tabladatos" style="font-size:12px; line-height:8px; vertical-align: text-top;" valign=" ">
											<tbody>
												<tr>
													<td class="tdatoslabel" width="30%">FECHA DE EMISIÓN: </td>
													<td>: <?php echo $data->fecha_nota_credito; ?></td>
												</tr>
												<tr>
													<td class="tdatoslabel">CLIENTE </td>
													<td>: <?php echo $data->cliente; ?></td>
												</tr>
												<tr>
													<td class="tdatoslabel">RUC </td>
													<td>: <?php echo $data->docum; ?></td>
												</tr>
												<tr>
													<td class="tdatoslabel">DIRECCIÓN </td>
													<td>: <?php echo $data->direccion; ?></td>
												</tr>
												<tr><td colspan="2">&nbsp;</td></tr>
												<tr>
													<th>Guias de remisión</th>
													<td>: <?php echo $data->guia_remision; ?></td>
												</tr>
												<tr><td colspan="2">&nbsp;</td></tr>
												<tr>
													<td class="tdatoslabel">DOC. AFECTADO </td>
													<td>: <?php echo $data->serie.' - '.$data->numero; ?></td>
												</tr>
												<tr>
													<td class="tdatoslabel">TIPO DE NOTA </td>
													<td>: <?php echo $data->tipo_nota; ?></td>
												</tr>
												<tr>
													<td class="tdatoslabel">DESCRIPCION </td>
													<td>: <?php echo $data->descripcion_nota; ?></td>
												</tr>
												<tr><td colspan="2">&nbsp;</td></tr>
											</tbody>
									</table>
									<table cellpadding="0" cellspacing="0" style="border: 1px solid black;">
											<thead>
													<tr style="background-color: #a2a2a2 !important;">
															<th width="8%" >Ítem</th>
															<th width="8%" >Código</th>
															<th width="52%" >Descripción</th>
															<th width="8%" >U.M.</th>
															<th width="8%"  >Cantidad</th>
															<th width="8%"  >Precio</th>
															<th width="8%"  >Total</th>
													</tr>
											</thead>
											<tbody style="line-height: 12px">
													<?php  $subtotal = 0; $total = 0; $i = 1;
													foreach ($prods->result() as $pro) {
															if (!isset($pro->unidad)) {
																	$pro->unidad = '';
															} ?>
															<tr>
																	<td style="border-top: 1px solid black; padding-left:10px; padding-right:0px; padding-bottom: 3px; padding-top:3px;" class="tablaproductos "><?php echo $i; ?></td>
																	<td style="border-top: 1px solid black; padding-left:10px; padding-right:0px; padding-bottom: 3px; padding-top:3px;" class="tablaproductos "><?php echo $pro->codigo_producto; ?></td>
																	<td style="border-top: 1px solid black; padding-left:10px; padding-right:0px; padding-bottom: 3px; padding-top:3px;" class="tablaproductos "><?php echo $pro->nombre_producto; ?>
									</td>
																	<td style="border-top: 1px solid black; padding-left:10px; padding-right:0px; padding-bottom: 3px; padding-top:3px;" class="tablaproductos "><?php echo $pro->unidad; ?></td>
																	<td style="border-top: 1px solid black; padding-left:10px; padding-right:0px; padding-bottom: 3px; padding-top:3px;" class="tablaproductos"><?php echo round($pro->cantidad, 2); ?></td>
																	<td style="border-top: 1px solid black; padding-left:10px; padding-right:0px; padding-bottom: 0px; padding-top:0px;" class=" tablaproductos"><?php echo number_format($pro->precio_unidad, 2); ?></td>
																	<td class="tablaproductos" style="border-top: 1px solid black; "><?php echo number_format($pro->total, 2); ?></td>
															</tr>
													<?php
															$subtotal += $pro->subtotal;
															$total += $pro->total;
															$i = $i + 1;
													} ?>
											</tbody>
									</table>
									<table cellpadding="0" cellspacing="0">
											<tbody>
													<tr>
															<td width="55%"></td>
															<td width="15%"><b>Op. Gravada</b></td>
															<td width="15%"><?php echo $data->codigo_moneda; ?></td>
															<td width="15%" style="text-align: right;"><?php echo number_format($subtotal, 2); ?></td>
													</tr>
													<tr>
															<td></td>
															<td><b>I.G.V. (18%)</b></td>
															<td><?php echo $data->codigo_moneda; ?></td>
															<td style="text-align: right;"><?php echo number_format($total - $subtotal, 2); ?></td>
													</tr>
													<tr>
															<td></td>
															<td><b>Op. Inafecta</b></td>
															<td><?php echo $data->codigo_moneda; ?></td>
															<td style="text-align: right;">0.00</td>
													</tr>
													<tr>
															<td></td>
															<td><b>Op. Exonerada</b></td>
															<td><?php echo $data->codigo_moneda; ?></td>
															<td style="text-align: right;">0.00</td>
															</tr>
													<tr>
															<td></td>
															<td><b>Op. Exportación</b></td>
															<td><?php echo $data->codigo_moneda; ?></td>
															<td style="text-align: right;">0.00</td>
													</tr>
													<tr>
															<td></td>
															<td><b>Importe Total</b></td>
															<td><?php echo $data->codigo_moneda; ?></td>
															<td style="text-align: right;border-top: solid 1px #a09f9f !important;"><?php echo number_format($total, 2); ?></td>
													</tr>
											</tbody>
									</table>
									<span><b>SON:</b> <?php echo $CI->numero_a_letras->convert($total, $this->_moneda[$data->codigo_moneda], TRUE); ?></span>
									<table cellpadding="0" cellspacing="0" border="1">
											<tbody>
													<tr class="detalletable">
															<td><b>Observaciones de SUNAT:</b> El comprobante numero <?php echo $data->serie_nota . ' - ' . $numero_nota_credito . ', se encuentra ' . 'Aceptado';#($data->estado_api != NULL ? $data->estado_api : 'registrado' ); ?></td>
													</tr>
											</tbody>
									</table>
							</div>
							<div class="footer">
									<img style="width: 620px;float:left;" src="images/imagen-footer.png" />
									<img style="width: 70px;" src="plantilla/assets/theme_doc_elect/images/qr.png" />
							</div>
					</body>
					</html>
					<?php
					$html= ob_get_clean();
					$resp['respuesta'] = 'ok';
					$resp['html'] = $html;
					return $resp;
			}
    public function get_html_remision($data, $prods) {
        ob_start();
        ?>
        <!DOCTYPE html>
        <html lang="es-ES" prefix="og: http://ogp.me/ns#" xmlns="https://www.w3.org/1999/xhtml">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:400,700" rel="stylesheet" type="text/css">
                <link href="plantilla/assets/theme_doc_elect/font-awesome-4.6.1/css/font-awesome.css" rel="stylesheet">
                <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet">
                <link href="plantilla/assets/theme_doc_elect/css/estilo.css" rel="stylesheet">
            </head>
            <style>
                .tablaproductos{
                    font-size: 14px;
                }
                td.tablaproductos{
                    padding-top: 7px;
                    padding-bottom: 7px;
                    padding-left:10px;
                    padding-right:0px;
                }
                .tabladatos{
                    font-size: 14px;
                    padding-top:10px;
                }
                tableproductos {
                    border-collapse: collapse;
                }
                .marginTop{
                    margin-top:100px !important;
                }
                tableproductos {
                    border: 1px solid black;
                }
                .footer {
                    position: fixed;
                    left: 0;
                    top: 90%;
                    width: 100%;
                    color: white;
                    text-align: center;
                }
                .header {
                    position: fixed;
                    left: 0;
                    top: 0%;
                    color: white;
                    text-align: center;
                }
                .container {
                    width: 100%;
                    margin: 0 auto;
                }
                .img {
                    width: 100%;
                }
                .noShow{
                    visibility: hidden;
                }

				.transportation {
					padding: 0;
					margin-top: 15px;
				}

				.transportation th {
					background: #999; color: white;
				}

				.transportation tr td, .transportation tr th {
					padding:5px 10px;
				}
            </style>
            <body>
                <div class="container">
                    <table class="tablareceipt">
                        <tbody style="width: 100%">
                            <tr style="width: 100%">
                                <td colspan="2" style="text-align:left;width:50%;" ><img style="width: 450px"  src="images/foto1.jpg"></td>
                                <td  style="width:50%;"   class="datoruc">
                                    <p>R.U.C. 20546439268</p>
                                    <p>GUIA DE REMISION ELECTRONICA - REMITENTE</p>
                                    <p><?php echo $data->serie . ' - ' . $data->numero; ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:33%;">
                                    <p style="text-transform: none; text-align:right;">Jr. Pataz Nº 1243 Int. A Urb. Covida</p>
                                    <p style="text-transform: none; text-align:right;">Etapa Los Olivos</p>
                                    <p style="text-transform: none; text-align:right;">Los Olivos - Lima</p>
                                    <p style="text-transform: none; text-align:right;">Referencia: En paralelo con</p>
                                    <p style="text-transform: none; text-align:right;">Av. Antunez de Mayolo</p>
                                    <p style="text-transform: none; text-align:right;">(a espaldas del Banco Scotiabank)</p>
                                </td>
                                <td style="width:33%;"><img style="width: 100px"  class="img" src="images/foto2.png"></td>
                                <td style="width:33%;" class="">
                                    <p style="text-transform: none; text-align:left; ">Cnt. Dolares BBVA:0011-0342-38-0100024845</p>
                                    <p style="text-transform: none; text-align:left;">Cnt Soles  BBVA:0011-0312-01-0000896</p>
                                    <p style="text-transform: none; text-align:left;">TELF.: 4851187 CEL.: 968 871 841</p>
                                    <p style="text-transform: none; text-align:left;">tecnologia.medica.corporation@gmail.com</p>
                                    <p style="text-transform: none; text-align:left;">ventas@tecnologiamedicacorporation.com</p>
                                    <p style="text-transform: none; text-align:left;">www.viatmc.com</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table cellpadding="0" cellspacing="0" style="padding: 0;">
                        <tr>
                            <th colspan="2">DATOS DEL TRASLADO</th>
                        </tr>
                        <tr>
                            <td width="30%">Fecha emision:</td>
                            <td width="70%"><?php echo $data->fecha_remision; ?></td>
                        </tr>
                        <tr>
                            <td width="30%">Fecha de inicio del traslado:</td>
                            <td width="70%"><?php echo $data->fecha_inicio_traslado; ?></td>
                        </tr>
                        <tr>
                            <td width="30%">Motivo de traslado:</td>
                            <td width="70%"><?php echo $data->motivo_traslado_descripcion; ?></td>
                        </tr>
                        <tr>
                            <td width="30%">Modalidad Transporte:</td>
                            <td width="70%"><?php echo $data->modalidad_transporte ?></td>
                        </tr>
                        <tr>
                            <td width="30%">Peso bruto(KGM):</td>
                            <td width="70%"><?php echo $data->peso_bruto; ?></td>
                        </tr>
                    </table>
                    <br/>
                    <table cellpadding="0" cellspacing="0" style="padding: 0">
                        <tr>
                            <th colspan="2">DATOS DEL DESTINATARIO</th>
                        </tr>
                        <tr>
                            <td width="30%">Razón Social o Denominación:</td>
                            <td width="70%"><?php echo $data->destinatario_nombre; ?></td>
                        </tr>
                        <tr>
                            <td width="30%">Documento de identidad:</td>
                            <td width="70%"><?php echo $data->destinatario_identidad_numero; ?></td>
                        </tr>
                    </table>
                    <br/>
                    <table cellpadding="0" cellspacing="0" style="padding: 0">
                        <tr>
                            <th colspan="2">DATOS DEL PUNTO DE PARTIDA Y PUNTO DE LLEGADA</th>
                        </tr>
                        <tr>
                            <td width="30%">Direccion del punto de partida:</td>
                            <td width="70%"><?php echo $data->partida_ubigeo . $data->partida_direccion; ?></td>
                        </tr>
                        <tr>
                            <td width="30%">Direccion del punto de llegada:</td>
                            <td width="70%"><?php echo $data->llegada_ubigeo . $data->llegada_direccion; ?></td>
                        </tr>
                    </table>
                    <br/>
					<p><b>DATOS DEL TRANSPORTE</b></p>
					<p><b>Datos de los vehículos</b></p>
                    <table cellpadding="0" cellspacing="0" class="transportation">
                        <tr>
                            <th>Nro. Placa:</th>
                        </tr>
						<tr>
							<td><?php echo $data->placa_vehiculo_transporte; ?></td>
						</tr>
                    </table>
					<br>
					<p><b>Datos de los conductores</b></p>
					<table cellpadding="0" cellspacing="0" class="transportation">
						<tr>
							<th width="20%">Nro.</th>
							<th width="20%">Tipo doc.</th>
							<th width="60%">Nro docu</th>
						</tr>
						<tr>
							<td width="20%"><?php echo "1" ?></td>
							<td width="20%"><?php echo $data->transportista_identidad_tipo ; ?></td>
							<td width="60%"><?php echo $data->conductor_identidad_numero; ?></td>
						</tr>
					</table>
                    <div class="tablageneral" style="width: 100%;">
						<p><b>DATOS DE LOS BIENES</b></p>
                        <table cellpadding="0" cellspacing="0" border="0" width="100%" class="transportation">
                            <thead>
                                <tr class="titulotable">
                                    <th class="tablaproductos" width="5%" style="padding:5px;line-height:120%;">Nro</th>
                                    <th class="tablaproductos" width="7%" style="padding:5px;line-height:120%;">Cod bien</th>
                                    <th class="tablaproductos" width="35%" style="padding:5px;line-height:120%;">Descripción</th>
                                    <th class="tablaproductos" width="8%" style="padding:5px;line-height:120%;">Unidad de medida</th>
                                    <th class="tablaproductos" width="5%" style="padding:5px;line-height:120%;">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($prods->result() as $pro) {
                                    if (!isset($pro->unidad_medida)) {
                                        $pro->unidad_medida = '';
                                    }
                                    ?>
                                    <tr class="detalletable">
                                        <td class="tablaproductos" width="5%" style="padding:5px;line-height:120%;" ><?php echo $i; ?></td>
                                        <td class="tablaproductos" width="5%" style="padding:5px;line-height:120%;"><?php echo $pro->cod; ?></td>
                                        <td class="tablaproductos" width="35%" style="padding:5px;line-height:120%;"><?php echo $pro->descripcion; ?></td>
                                        <td class="tablaproductos" width="5%" style="padding:5px;line-height:120%;"><?php echo $pro->unidad_medida; ?></td>
                                        <td class="tablaproductos" width="5%" style="padding:5px;line-height:120%;"><?php echo $pro->cantidad; ?></td>
                                    </tr>
                                    <?php
                                    $i = $i + 1;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <table style="margin-top:12px;" class="tabladatos" >
                        <tbody style="line-height:15px;">
                            <tr">
                                <td class="tdatoslabel" colspan="2" align="center">
                                    <div style="padding-right: 20px;">
                                        <div>Observaciones <?php echo $data->observaciones; ?></div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </body>
        </html>
        <?php
        $html = ob_get_clean();
        $resp['respuesta'] = 'ok';
        $resp['html'] = $html;
        return $resp;
    }

    public function get_html_nota_credito($data) {
        $html = '
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html lang="es-ES" prefix="og: http://ogp.me/ns#" xmlns="https://www.w3.org/1999/xhtml">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport" />
			<link href="https://fonts.googleapis.com/css?family=Josefin+Sans:400,700" rel="stylesheet" type="text/css">
			<link href="../assets/theme_doc_elect/font-awesome-4.6.1/css/font-awesome.css" rel="stylesheet">
			<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet">
			<link href="../assets/theme_doc_elect/css/estilo.css" rel="stylesheet">
		</head>
		<body>
			<table class="tablareceipt">
				<tbody>
					<tr>
						<td>
							<p>Textiles el telar S.A.C.</p>
							<img class="logofactura" src="../assets/theme_doc_elect/images/logo.png">
							<p style="text-transform: none !important;">Av. Siempre via #456 - Surco - Lima</p>
							<p style="text-transform: none !important;"><img src="../assets/theme_doc_elect/images/telephone.png" style="width: 12px;" /> Telf.: 677899900 / Cel.: 677788999</p>
							<p style="text-transform: none !important;"><img src="../assets/theme_doc_elect/images/email.svg" style="width: 12px;" /> Email: ventas@dominio.com</p>
						</td>
						<td class="datoruc">
							<p>R.U.C. 34567890345</p>
							<p>Nota de Crédito</p>
							<p>001 - 005346</p>
						</td>
					</tr>
				</tbody>
			</table>

			<table class="tabladatos">
				<tbody>
					<tr>
						<td class="tdatoslabel" style="width: 50%; padding-right: 19px;">
							<div style="padding-bottom: 10px">
								<span style="float: left;">Nombre Cliente:</span>
								<div style="margin-left: 105px; border-bottom: dashed 1px #000 !important;">Textiles Castro Import SAC</div>
							</div>
						</td>
						<td class="tdatoslabel tdatodlabeldos">
							<div>
								<span style="float: left;"><b>DOCUMENTO QUE MODIFICA:</b></span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<table class="tabladatos">
				<tbody>
					<tr>
						<td class="tdatoslabel" style="width: 50%; padding-right: 19px;">
							<div style="padding-bottom: 10px">
								<span style="float: left;">Dirección:</span>
								<div style="margin-left: 68px; border-bottom: dashed 1px #000 !important;"> Jr. Italia N. 453 - La Victoria Lima - Perú </div>
							</div>
						</td>
						<td class="tdatoslabel tdatodlabeldos">
							<div>
								<span style="float: left;">Denominación: </span>
								<div style="margin-left: 118px; border-bottom: dashed 1px #000 !important;">Factura</div>
							</div>
						</td>
					</tr>
					<tr>
						<td class="tdatoslabel" style="width: 50%; padding-right: 19px;">
							<div style="padding-bottom: 10px">
								<span style="float: left;">Fecha de Emisión:</span>
								<div style="margin-left: 115px; border-bottom: dashed 1px #000 !important;"> 26/06/2018 </div>
							</div>
						</td>
						<td class="tdatoslabel tdatodlabeldos">
							<div>
								<span style="float: left;">N°: </span>
								<div style="margin-left: 25px; border-bottom: dashed 1px #000 !important;">34567890345</div>
							</div>
						</td>
					</tr>
					<tr>
						<td class="tdatoslabel tdatonombre tdatocre tdatocons"><p>Por los consiguiente:</p></td>
						<td class="tdatoslabel tdatofecha tdatocre"><p><span>Emisión del Comprobante de pago que modifica:</span></p> 10/05/2018</td>
					</tr>
				</tbody>
			</table>

			<div class="tablageneral">
				<table cellpadding="0" cellspacing="0">
					<tbody>
						<tr class="titulotable">
							<td class="cantidadtabla">Cantidad</td>
							<td class="cantidadtabla">Código</td>
							<td>Descripción</td>
							<td class="preciotabla">Precio Unitario</td>
							<td class="preciotabla ulttable">Valor de venta o servicio prestado</td>
						</tr>
						<tr class="detalletable" style="height: 120px;">
							<td class="nombredetalle">1</td>
							<td class="nombredetalle">HUS87</td>
							<td style="font-size: 18px;">Por Anulación Total de la Comisión por Servicios de Alquiler de Auto. Pasajero. Huaman Juan</td>
							<td></td>
							<td class="ulttable">$100.00</td>
						</tr>
						<tr class="detalletable">
							<td class="nombredetalle"></td>
							<td class="nombredetalle"></td>
							<td style="font-weight: bold;">Son ciento dieciocho y 00/100 soles</td>
							<td></td>
							<td class="ulttable"></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="tablageneral tablacostos">
				<table cellpadding="0" cellspacing="0">
					<tbody>
						<tr class="detalletable">
							<td rowspan="3" style="padding: 0px !important;">
								<b>MOTIVOS DE LA EMISIÓN DE LA NOTA DE CRÉDITO</b>
								<table style="width:100%">
									<tr>
										<th style="font-weight: normal; font-size: 12px;">
											<input type="checkbox" id="cbox1" value="first_checkbox"> Anulación de la Operación
										</th>
										<th style="font-weight: normal; font-size: 12px;">
											<input type="checkbox" id="cbox1" value="first_checkbox">Anulación por Error en RUC
										</th>
									</tr>
									<tr>
										<th style="font-weight: normal; font-size: 12px;">
											<input type="checkbox" id="cbox1" value="first_checkbox">Corrección Error en Descripción
										</th>
										<th style="font-weight: normal; font-size: 12px;">
											<input type="checkbox" id="cbox1" value="first_checkbox">Devolución Global
										</th>
									</tr>
									<tr>
										<th style="font-weight: normal; font-size: 12px;">
											<input type="checkbox" id="cbox1" value="first_checkbox">Descuento por Item
										</th>
										<th style="font-weight: normal; font-size: 12px;">
											<input type="checkbox" id="cbox1" value="first_checkbox" checked>Devolución Total
										</th>
									</tr>
									<tr>
										<th style="font-weight: normal; font-size: 12px;">
											<input type="checkbox" id="cbox1" value="first_checkbox">Devolución por Item
										</th>
										<th style="font-weight: normal; font-size: 12px;">
											<input type="checkbox" id="cbox1" value="first_checkbox">Bonificación
										</th>
									</tr>
									<tr>
										<th style="font-weight: normal; font-size: 12px;">
											<input type="checkbox" id="cbox1" value="first_checkbox">Disminución en el Valor
										</th>
										<th></th>
									</tr>
								</table>
							</td>
							<td class="preciotabla fintabla fintablados"><b>I.G.V.</b></td>
							<td class="preciotabla ulttable fintabla">$18.00</td>
						</tr>
						<tr class="detalletable">
							<td class="preciotabla fintabla fintablados"><b>OTROS</b></td>
							<td class="preciotabla ulttable fintabla"> -- </td>
						</tr>
						<tr class="detalletable">
							<td class="preciotabla fintabla fintabla fintablados"><b>TOTAL</b></td>
							<td class=" preciotabla ulttable fintabla">$118.00</td>
						</tr>
					</tbody>
				</table>
			</div>
			<table>
				<tbody>
					<tr>
						<td style="width: 34%;">
							<p>
								<b>Recepción de la nota de credito</b><br />
							</p>
							<p><span>Apellidos y nombres de quien recepciona la nota de crédito:</span> Cristopher Andréz Villanueva Paz</p>
							<p><span>DNI:</span> 78869955</p>
							<p><span>Fecha de recepción:</span> 26/05/2018</p>
						</td>
						<td style="width: 33%; text-align: center;">
							<img style="width: 124px; margin-bottom: 11px;" src="../assets/theme_doc_elect/images/qr.png" />
						</td>
						<td style="width: 33%;">
							Autorizado mediante Resolución de Intendencia N° 032-005-Representación impresa de la Nota de Crédito. Consulte su documento electrónico en:
							<span style="font-size: 10px">https://bit.ly/2HiRWZI</span>
						</td>
					</tr>
					<tr>
						<td style="width: 34%;">
						</td>
						<td style="text-align: center;" colspan="2">
							<span class="codigofac">HASH: dGp1cUib9QWXjNEFDUqjDGszUKw=</span>
						</td>
					</tr>
				</tbody>
			</table>

		</body>
		</html>
		';

        $resp['respuesta'] = 'ok';
        $resp['html'] = $html;
        return $resp;
    }

    public function get_html_nota_debito($data) {
        $html = '
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html lang="es-ES" prefix="og: http://ogp.me/ns#" xmlns="https://www.w3.org/1999/xhtml">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport" />
			<link href="https://fonts.googleapis.com/css?family=Josefin+Sans:400,700" rel="stylesheet" type="text/css">
			<link href="../assets/theme_doc_elect/font-awesome-4.6.1/css/font-awesome.css" rel="stylesheet">
			<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet">
			<link href="../assets/theme_doc_elect/css/estilo.css" rel="stylesheet">
		</head>
		<body>
			<table class="tablareceipt">
				<tbody>
					<tr>
						<td>
							<p>Textiles el telar S.A.C.</p>
							<img class="logofactura" src="../assets/theme_doc_elect/images/logo.png">
							<p style="text-transform: none !important;">Av. Siempre via #456 - Surco - Lima</p>
							<p style="text-transform: none !important;"><img src="../assets/theme_doc_elect/images/telephone.png" style="width: 12px;" /> Telf.: 677899900 / Cel.: 677788999</p>
							<p style="text-transform: none !important;"><img src="../assets/theme_doc_elect/images/email.svg" style="width: 12px;" /> Email: ventas@dominio.com</p>
						</td>
						<td class="datoruc">
							<p>R.U.C. 34567890345</p>
							<p>Nota de Débito</p>
							<p>001 - 005346</p>
						</td>
					</tr>
				</tbody>
			</table>

			<table class="tabladatos">
					<tbody>
						<tr>
							<td class="tdatoslabel" style="width: 50%; padding-right: 19px;">
								<div style="padding-bottom: 10px">
									<span style="float: left;">Nombre Cliente:</span>
									<div style="margin-left: 105px; border-bottom: dashed 1px #000 !important;">Textiles Castro Import SAC</div>
								</div>
							</td>
							<td class="tdatoslabel tdatodlabeldos">
								<div>
									<span style="float: left;"><b>DOCUMENTO QUE MODIFICA:</b></span>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
				<table class="tabladatos">
					<tbody>
						<tr>
							<td class="tdatoslabel" style="width: 50%; padding-right: 19px;">
								<div style="padding-bottom: 10px">
									<span style="float: left;">Dirección:</span>
									<div style="margin-left: 68px; border-bottom: dashed 1px #000 !important;"> Jr. Italia N. 453 - La Victoria Lima - Perú </div>
								</div>
							</td>
							<td class="tdatoslabel tdatodlabeldos">
								<div>
									<span style="float: left;">Denominación: </span>
									<div style="margin-left: 118px; border-bottom: dashed 1px #000 !important;">Factura</div>
								</div>
							</td>
						</tr>
						<tr>
							<td class="tdatoslabel" style="width: 50%; padding-right: 19px;">
								<div style="padding-bottom: 10px">
									<span style="float: left;">Fecha de Emisión:</span>
									<div style="margin-left: 115px; border-bottom: dashed 1px #000 !important;"> 26/06/2018 </div>
								</div>
							</td>
							<td class="tdatoslabel tdatodlabeldos">
								<div>
									<span style="float: left;">N°: </span>
									<div style="margin-left: 25px; border-bottom: dashed 1px #000 !important;">34567890345</div>
								</div>
							</td>
						</tr>
						<tr>
							<td class="tdatoslabel tdatonombre tdatocre tdatocons"><p>Por los consiguiente:</p></td>
							<td class="tdatoslabel tdatofecha tdatocre"><p><span>Emisión del Comprobante de pago que modifica:</span></p> 10/05/2018</td>
						</tr>
					</tbody>
				</table>

			<div class="tablageneral">
				<table cellpadding="0" cellspacing="0">
					<tbody>
						<tr class="titulotable">
							<td class="cantidadtabla">Cantidad</td>
							<td class="cantidadtabla">Código</td>
							<td>Descripción</td>
							<td class="preciotabla">Precio Unitario</td>
							<td class="preciotabla ulttable">Valor de venta o servicio prestado</td>
						</tr>
						<tr class="detalletable" style="height: 120px;">
							<td class="nombredetalle">1</td>
							<td class="nombredetalle">HUS87</td>
							<td style="font-size: 18px;">Intereses Moratorios por atraso en el pago de la factura 5346</td>
							<td></td>
							<td class="ulttable">$100.00</td>
						</tr>
						<tr class="detalletable">
							<td class="nombredetalle"></td>
							<td class="nombredetalle"></td>
							<td style="font-weight: bold;">Son ciento dieciocho y 00/100 soles</td>
							<td></td>
							<td class="ulttable"></td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="tablageneral tablacostos">
				<table cellpadding="0" cellspacing="0">
					<tbody>
						<tr class="detalletable">
							<td rowspan="3" style="padding: 0px !important; vertical-align: sub !important;">
								<b>MOTIVOS DE LA EMISIÓN DE LA NOTA DE DÉBITO</b>
								<table style="width:100%">
									<tr>
										<th style="font-weight: normal; font-size: 12px;">
											<input type="checkbox" id="cbox1" value="first_checkbox" checked> Intereses por Mora
										</th>
										<th style="font-weight: normal; font-size: 12px;">
											<input type="checkbox" id="cbox1" value="first_checkbox"> Aumento en el Valor
										</th>
									</tr>
									<tr>
										<th style="font-weight: normal; font-size: 12px;">
											<input type="checkbox" id="cbox1" value="first_checkbox"> Penalidades
										</th>
										<th>
										</th>
									</tr>
								</table>
							</td>
							<td class="preciotabla fintabla fintablados"><b>I.G.V.</b></td>
							<td class="preciotabla ulttable fintabla">$18.00</td>
						</tr>
						<tr class="detalletable">
							<td class="preciotabla fintabla fintablados"><b>OTROS</b></td>
							<td class="preciotabla ulttable fintabla"> -- </td>
						</tr>
						<tr class="detalletable">
							<td class="preciotabla fintabla fintabla fintablados"><b>TOTAL</b></td>
							<td class=" preciotabla ulttable fintabla">$118.00</td>
						</tr>
					</tbody>
				</table>
			</div>
			<table>
				<tbody>
					<tr>
						<td style="width: 34%;">
							<p>
								<b>Recepción de la nota de credito</b><br />
							</p>
							<p><span>Apellidos y nombres de quien recepciona la nota de crédito:</span> Cristopher Andréz Villanueva Paz</p>
							<p><span>DNI:</span> 78869955</p>
							<p><span>Fecha de recepción:</span> 26/05/2018</p>
						</td>
						<td style="width: 33%; text-align: center;">
							<img style="width: 124px; margin-bottom: 11px;" src="../assets/theme_doc_elect/images/qr.png" />
						</td>
						<td style="width: 33%;">
							Autorizado mediante Resolución de Intendencia N° 032-005-Representación impresa de la Nota de Crédito. Consulte su documento electrónico en:
							<span style="font-size: 10px">https://bit.ly/2HiRWZI</span>
						</td>
					</tr>
					<tr>
						<td style="width: 34%;">
						</td>
						<td style="text-align: center;" colspan="2">
							<span class="codigofac">HASH: dGp1cUib9QWXjNEFDUqjDGszUKw=</span>
						</td>
					</tr>
				</tbody>
			</table>

		</body>
		</html>
		';

        $resp['respuesta'] = 'ok';
        $resp['html'] = $html;
        return $resp;
    }

    public function get_html_kardex($data) {
        $html = '
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html lang="es-ES" prefix="og: http://ogp.me/ns#" xmlns="https://www.w3.org/1999/xhtml">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport" />
			<link href="https://fonts.googleapis.com/css?family=Josefin+Sans:400,700" rel="stylesheet" type="text/css">
			<link href="plantilla/assets/theme_doc_elect/font-awesome-4.6.1/css/font-awesome.css" rel="stylesheet">
			<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet">
			<link href="plantilla/assets/theme_doc_elect/css/estilo.css" rel="stylesheet">
		</head>
		<body>

			<table class="tabladatos" >
				<tbody>
					<tr>
						<td class="tdatoslabel">
							<div style="padding-bottom: 10px; padding-right: 19px;">
								<span style="float: left;">Razón Social:</span>
								<div style="margin-left: 95px; border-bottom: solid 1px #000;">' . '</div>
							</div>
						</td>
						<td class="tdatoslabel tdatodlabeldos">
							<div>
								<span style="float: left;">Fecha de Emisión:</span>
								<div style="margin-left: 118px; border-bottom: solid 1px #000;">' . '</div>
							</div>
						</td>
					</tr>
					<tr>
						<td class="tdatoslabel">
							<div style="padding-bottom: 10px; padding-right: 19px;">
								<span style="float: left;">RUC N°:</span>
								<div style="margin-left: 95px; border-bottom: solid 1px #000;"> ' . ' </div>
							</div>
						</td>
						<td class="tdatoslabel tdatodlabeldos">
							<div>
								<span style="float: left;">Guía de Remisión: </span>
								<div style="margin-left: 118px; border-bottom: solid 1px #000;">.</div>
							</div>
						</td>
					</tr>
					<tr>
						<td class="tdatoslabel">
							<div style="padding-bottom: 10px; padding-right: 19px;">
								<span style="float: left;">Dirección:</span>
								<div style="margin-left: 95px; border-bottom: solid 1px #000;">' . '</div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>

			<div class="tablageneral">
				<table cellpadding="0" cellspacing="0">
					<tbody>
					<tr class="titulotable">
							<td class="cantidadtabla" style="text-align: center;" rowspan="2">Fecha</td>
							<td style="text-align: center;" rowspan="2">Descripción</td>
							<td class="preciotabla" colspan="3" style="text-align: center;">Entrada</td>
							<td class="preciotabla"  colspan="3" style="text-align: center;">Salida</td>
							<td class="preciotabla"  colspan="3" style="text-align: center;">Existencias</td>
						</tr>
					<tr class="titulotable">

						<td class="cantidadtabla">Cantidad</td>
						<td class="cantidadtabla">P.U.</td>
						<td class="cantidadtabla">Total</td>

						<td class="cantidadtabla">Cantidad</td>
						<td class="cantidadtabla">P.U.</td>
						<td class="cantidadtabla">Total</td>

						<td class="cantidadtabla">Cantidad</td>
						<td class="cantidadtabla">P.U.</td>
						<td class="cantidadtabla">Total</td>
					</tr>';
        $html2 = '';
        $cantidad_ex = 5000.00;
        $subtotal = 0;
        $total = 0;
        foreach ($data->result() as $pro) {
            $date = new DateTime($pro->fecha);
            $html2 = $html2 . '<tr class="detalletable">
							<td class="cantidadtabla">' . $date->format('d/m/Y') . '</td>
							<td>' . $pro->tipo . ' ' . $pro->serie . '-' . $pro->numero . '</td>';

            if ($pro->tipo == "VENTA") {
                $cantidad_ex -= $pro->cantidad;
                $html2 = $html2 . '<td></td>
								<td></td>
								<td></td>
								<td>' . $pro->cantidad . '</td>
								<td>' . $pro->precio_unidad . '</td>
								<td>' . $pro->total . '</td>';
            } else if ($pro->tipo == "COMPRA") {
                $cantidad_ex += $pro->cantidad;
                $html2 = $html2 . '
								<td>' . $pro->cantidad . '</td>
								<td>' . $pro->precio_unidad . '</td>
								<td>' . $pro->total . '</td>
								<td></td>
								<td></td>
								<td></td>';
            }
            $html2 = $html2 . '
								<td>' . $cantidad_ex . '</td>
								<td></td>
								<td></td>
							</tr>';
            /* $subtotal += $pro->subtotal;
              $total += $pro->total; */
        };
        $html3 = '
					</tbody>
				</table>
			</div>

		</body>
		</html>
		';

        $resp['respuesta'] = 'ok';
        $resp['html'] = $html . $html2 . $html3;
        return $resp;
    }

}
