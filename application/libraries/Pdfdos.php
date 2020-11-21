<?php

include "fpdf/fpdf.php";

class Pdfdos
{

    public function mostrar($data, $datos)
    {
        $pdf = new FPDF($orientation = 'P', $unit = 'mm', array(85, 800));
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 8);    //Letra Arial, negrita (Bold), tam. 20
        $textypos = 5;
        $pdf->setY(2);
        $pdf->setX(2);
        $pdf->SetFont('Arial', '', 9.5);
        $pdf->setX(20);
        $pdf->Cell(0, $textypos, $pdf->Image('images/logo-web-index.png', $pdf->GetX(), $pdf->GetY(), 45), 0, 0, 'C');
        $pdf->setY(10);
        $pdf->setX(12);
        $pdf->Cell(0, $textypos, "TECNOLOGIA MEDICA CORPORATION E.I.R.L", 0, 0, 'C');
        $textypos += 8;
        $pdf->setX(10);
        $pdf->Cell(0, $textypos, "RUC: 20546439268", 0, 0, 'C');
        $textypos += 8;
        $pdf->setX(10);
        $pdf->Cell(0, $textypos, "URB. COVIDA I ETP JR. PATAZ 1243 B", 0, 0, 'C');
        $textypos += 8;
        $pdf->setX(10);
        $pdf->Cell(0, $textypos, "Telefono: (01) 4851187", 0, 0, 'C');
        $textypos += 8;
        $pdf->setX(10);
        $pdf->Cell(0, $textypos, "Celular: (51) 968871841", 0, 0, 'C');
        $textypos += 8;
        $pdf->setX(13);
        $pdf->Cell(0, $textypos, $data["comprobante"] . " DE VENTA ELECTRONICA", 0, 0, 'C');
        $textypos += 10;
        $pdf->setX(10);
        $pdf->Cell(0, $textypos, $datos->serie . " - " . $datos->numero, 0, 0, 'C');

        //Letra Arial, negrita (Bold), tam. 20
        $textypos += 10;
        $pdf->setX(2);
        $pdf->Cell(5, $textypos, '---------------------------------------------------------------------');
        $textypos += 10;
        $pdf->setX(2);
        $pdf->Cell(5, $textypos, "Fecha y hora: " . $datos->created_at);

        $textypos += 10;
        $pdf->setX(2);
        $pdf->Cell(5, $textypos, "CLIENTE: " . $datos->cliente);
        $textypos += 10;
        $pdf->setX(2);
        if ($data["comprobante"] == "FACTURA") {
            $pdf->Cell(5, $textypos, "RUC: " . $datos->docum);
        } else if ($data["comprobante"] == "BOLETA") {
            $pdf->Cell(5, $textypos, "DNI: " . $datos->docum);
        }

        $textypos += 10;
        $pdf->setX(2);
        $pdf->Cell(5, $textypos, "DIRECCION: " . $datos->direccion);
        $textypos += 10;
        $pdf->setX(2);
        $pdf->Cell(5, $textypos, "CELULAR: " . $datos->celular);
        $textypos += 10;
        $pdf->setX(2);
        $pdf->Cell(5, $textypos, "CORREO: " . $datos->correo);
        $textypos += 10;
        $pdf->setX(2);
        $pdf->Cell(5, $textypos, '---------------------------------------------------------------------');
        $textypos += 10;
        $pdf->setX(2);
        $pdf->Cell(5, $textypos, 'CANT.        ' . $datos->tipo_venta . '         PRECIO         TOTAL');
        $textypos += 10;
        $pdf->setX(2);
        $pdf->Cell(0, $textypos, '---------------------------------------------------------------------');
        $total = 0;
        $textypos += 8;
        $subtotal = 0;
        $n = 0;

        foreach ($data["prods"]->result() as $pro) {
            $i = strlen($pro->nombre);
            $j = 13;
            $pdf->setX(2);
            $pdf->Cell(5, $textypos, $pro->cantidad);
            $pdf->setX(17);
            $pdf->Cell(37, $textypos, "" . strtoupper(substr($pro->nombre, 0, 13)));
            $pdf->setX(50);
            $pdf->Cell(11, $textypos, "" . number_format($pro->precio_unidad, 2, ".", ","), 0, 0, "R");
            $pdf->setX(70);
            $pdf->Cell(11, $textypos, "" . number_format($pro->total, 2, ".", ","), 0, 0, "R");
            while ($j < $i) {
                $textypos += 7;
                $pdf->setX(17);
                $pdf->Cell(37, $textypos, "" . strtoupper(substr($pro->nombre, $j, 13)));
                $j = $j + 13;
            }

            /* $textypos+=7;
              $pdf->setX(17);
              $pdf->Cell(20,$textypos,  "".strtoupper(substr($pro->nombre, 26,50))); */
            $textypos += 7;
            $pdf->setX(17);
            $pdf->Cell(37, $textypos, "" . $pro->serie);
            $total += $pro->total;
            $subtotal += $pro->subtotal;
            $textypos += 10;
            $n++;
        }
        $textypos += 4;
        $pdf->setX(35);
        $pdf->Cell(0, $textypos, "SUB TOTAL: ");
        $pdf->setX(75);
        $pdf->Cell(5, $textypos, "S/ " . number_format($subtotal, 2, ".", ","), 0, 0, "R");
        $textypos += 10;
        $pdf->setX(35);
        $pdf->Cell(5, $textypos, "IGV: ");
        $pdf->setX(75);
        $pdf->Cell(5, $textypos, "S/ " . number_format($total - $subtotal, 2, ".", ","), 0, 0, "R");
        $textypos += 10;
        $pdf->setX(35);
        $pdf->Cell(5, $textypos, "TOTAL: ");
        $pdf->setX(75);
        $pdf->Cell(5, $textypos, "S/ " . number_format($total, 2, ".", ","), 0, 0, "R");
        $textypos += 12;
        $pdf->setX(2);
        $pdf->Cell(5, $textypos, "USUARIO: " . $datos->username);
        $textypos += 10;
        $pdf->setX(2);
        $pdf->Cell(5, $textypos, "CAJA: 01");
        $pdf->setX(20);
        $pdf->Cell(5, $textypos, "TURNO: 02");
        $pdf->setX(2);
        $pdf->setX(7);
        $pdf->Cell(0, $textypos + 11, 'HASH: ' . $datos->hash, 0, 0, 'C');

        $pdf->setX(2);
        $pdf->setX(10);
        $pdf->Cell(0, $textypos + 23, 'GRACIAS POR SU PREFERENCIA ', 0, 0, 'C');
        $pdf->setX(27);
        $pdf->Cell(0, $textypos, $pdf->Image($data["url"], $pdf->GetX(), $textypos - 60 - ($n * 7), 31), 0, 0, 'C');
        if (!isset($data["ayuda"])) {
            $pdf->output('', $datos->serie . " - " . $datos->numero . '.pdf');
        } else {
            $pdf->output($data["ayuda"] . "comprobante.pdf", 'F');
        }
    }

    public function mostrar_ticket($data, $datos)
    {

        $pdf = new FPDF($orientation = 'P', $unit = 'mm', array(85, 300));
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 8);    //Letra Arial, negrita (Bold), tam. 20
        $textypos = 5;
        $pdf->setY(2);
        $pdf->setX(2);
        $pdf->SetFont('Arial', '', 9.5);
        $pdf->setX(10);
        $pdf->Cell(0, $textypos, "Tecnologia Medica Corporation", 0, 0, 'C');
        $textypos += 8;
        $pdf->setX(10);
        $pdf->Cell(0, $textypos, $datos->id . "-" . $datos->id, 0, 0, 'C');
        $textypos += 10;
        $pdf->setX(2);
        $pdf->Cell(5, $textypos, '---------------------------------------------------------------------');
        $textypos += 10;
        $pdf->setX(2);
        $pdf->Cell(5, $textypos, "Fecha y hora: " . $datos->created_at);
        $textypos += 10;
        $pdf->setX(2);
        $pdf->Cell(5, $textypos, "Cliente: " . $datos->cliente_id);
        $textypos += 10;
        $pdf->setX(2);
        $pdf->Cell(5, $textypos, "Moneda: " . $datos->moneda);

        $textypos += 10;
        $pdf->setX(2);
        $pdf->Cell(5, $textypos, '---------------------------------------------------------------------');
        $textypos += 10;
        $pdf->setX(2);
        $pdf->Cell(5, $textypos, 'Cant.     Producto                Precio(c/u)        Monto');
        $textypos += 10;
        $pdf->setX(2);
        $pdf->Cell(0, $textypos, '---------------------------------------------------------------------');

        $textypos += 8;
        foreach ($data->result() as $pro) {
            $pdf->setX(2);
            $pdf->Cell(5, $textypos, $pro->cantidad);
            $pdf->setX(11);
            $pdf->Cell(37, $textypos, "" . ucfirst(substr($pro->nombre, 0, 28)));
            $pdf->setX(50);
            $pdf->Cell(11, $textypos, number_format($pro->precioproducto, 2, ".", ","), 0, 0, "R");
            $pdf->setX(68);
            $pdf->Cell(11, $textypos, number_format($pro->montoproducto, 2, ".", ","), 0, 0, "R");
            $pdf->setX(68);
            $textypos += 10;
        }
        $pdf->setX(2);
        $pdf->Cell(0, $textypos, '---------------------------------------------------------------------');
        $textypos += 8;
        //$textypos+=10;
        /* $pdf->setX(44);
          $pdf->Cell(35,$textypos,"Diseno: ".$datos->montodiseno,0,0,"R");
          if($datos->nombreacabado != ""){
          $textypos+=10;
          $pdf->setX(2);
          $pdf->Cell(5,$textypos,"Cant.:".$datos->cantidadacabado."  Precio.Uni.:".$datos->precioacabado);
          $pdf->setX(44);
          $pdf->Cell(35,$textypos,"Acabado: ".$datos->montoacabado,0,0,"R");
          } */
        $textypos += 8;
        $pdf->setX(2);
        $pdf->Cell(0, $textypos, '                                           --------------------------------');
        $textypos += 8;
        $pdf->setX(44);
        $pdf->Cell(35, $textypos, "Total a pagar: " . $datos->montototal, 0, 0, "R");
        $textypos += 10;
        /*
          if($datos->autorizante != ""){
          $pdf->setX(2);
          $pdf->Cell(15,$textypos,"Autorizante : ".$datos->autorizante);
          } *//*
          $pdf->setX(44);
          $pdf->Cell(35,$textypos,"Descuento : ".$datos->descuento,0,0,"R");
          $textypos+=8;

          $pdf->setX(2);
          $pdf->Cell(0,$textypos,'                                            -------------------------------');
          $textypos+=10;
          $pdf->setX(44);
          $pdf->Cell(35,$textypos,"Total a pagar : ".$datos->totalpagar,0,0,"R");

          $textypos+=10;
         */
        $pdf->setX(7);
        $pdf->output('', $datos->id . '.pdf');
    }

    public function mostrarNota($data, $datos)
    {
        $pdf = new FPDF($orientation = 'P', $unit = 'mm', array(85, 300));
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 8);    //Letra Arial, negrita (Bold), tam. 20
        $textypos = 5;
        $pdf->setY(2);
        $pdf->setX(2);
        $pdf->SetFont('Arial', '', 9.5);
        $pdf->setX(10);
        $pdf->Cell(0, $textypos, "TECNOLOGIA MEDICA CORPORATION E.I.R.L", 0, 0, 'C');
        $textypos += 8;
        $pdf->setX(10);
        $pdf->Cell(0, $textypos, "RUC: 20546439268", 0, 0, 'C');
        $textypos += 8;
        $pdf->setX(10);
        $pdf->Cell(0, $textypos, "URB. COVIDA I ETP JR. PATAZ 1243 B", 0, 0, 'C');
        $textypos += 8;
        $pdf->setX(10);
        $pdf->Cell(0, $textypos, "Telefono: (01) 485 1187", 0, 0, 'C');
        $textypos += 8;
        $pdf->setX(10);
        $pdf->Cell(0, $textypos, "Celular: (51) 968871841", 0, 0, 'C');
        $textypos += 8;
        $pdf->setX(13);
        $pdf->Cell(0, $textypos, $data["comprobante"] . " ELECTRONICA", 0, 0, 'C');
        $textypos += 10;
        $pdf->setX(10);
        $pdf->Cell(0, $textypos, $datos->serie . " - " . $datos->numero, 0, 0, 'C');

        //Letra Arial, negrita (Bold), tam. 20
        $textypos += 10;
        $pdf->setX(2);
        $pdf->Cell(5, $textypos, '---------------------------------------------------------------------');
        $textypos += 10;
        $pdf->setX(2);
        $pdf->Cell(5, $textypos, "Fecha y hora: " . $datos->created_at);
        $textypos += 10;
        $pdf->setX(2);
        $pdf->Cell(5, $textypos, "Doc. Modificado : " . $datos->num_doc_modificado);
        $textypos += 10;
        $pdf->setX(2);
        $pdf->Cell(5, $textypos, "Motivo :" . $datos->motivo);

        $textypos += 10;
        $pdf->setX(2);
        $pdf->Cell(5, $textypos, "CLIENTE: " . iconv('UTF-8', 'windows-1252', $datos->cliente));
        $textypos += 10;
        $pdf->setX(2);
        if ($data["comprobante"] == "FACTURA") {
            $pdf->Cell(5, $textypos, "RUC: " . $datos->docum);
        } else if ($data["comprobante"] == "BOLETA") {
            $pdf->Cell(5, $textypos, "DNI: " . $datos->docum);
        } else {
            $pdf->Cell(5, $textypos, "NRO DOCUMENTO: " . $datos->docum);
        }

        $textypos += 10;
        $pdf->setX(2);
        $pdf->Cell(5, $textypos, "DIRECCION: " . $datos->direccion);
        $textypos += 10;
        $pdf->setX(2);
        $pdf->Cell(5, $textypos, '---------------------------------------------------------------------');
        $textypos += 10;
        $pdf->setX(2);
        $pdf->Cell(5, $textypos, 'CANT.        PRODUCTO         PRECIO         TOTAL');
        $textypos += 10;
        $pdf->setX(2);
        $pdf->Cell(0, $textypos, '---------------------------------------------------------------------');
        $total = 0;
        $textypos += 8;
        $subtotal = 0;
        foreach ($data["prods"]->result() as $pro) {
            $pdf->setX(2);
            $pdf->Cell(5, $textypos, $pro->cantidad);
            $pdf->setX(17);
            $pdf->Cell(37, $textypos, "" . strtoupper(substr($pro->nombre, 0, 12)));
            $pdf->setX(47);
            $pdf->Cell(11, $textypos, "" . number_format($pro->precio_unidad, 2, ".", ","), 0, 0, "R");
            $pdf->setX(68);
            $pdf->Cell(11, $textypos, "" . number_format($pro->total, 2, ".", ","), 0, 0, "R");
            $total += $pro->total;
            $subtotal += $pro->subtotal;
            $textypos += 10;
        }
        $textypos += 4;
        $pdf->setX(35);
        $pdf->Cell(0, $textypos, "SUB TOTAL: ");
        $pdf->setX(75);
        $pdf->Cell(5, $textypos, "S/ " . number_format($subtotal, 2, ".", ","), 0, 0, "R");
        $textypos += 10;
        $pdf->setX(35);
        $pdf->Cell(5, $textypos, "IGV: ");
        $pdf->setX(75);
        $pdf->Cell(5, $textypos, "S/ " . number_format($total - $subtotal, 2, ".", ","), 0, 0, "R");
        $textypos += 10;
        $pdf->setX(35);
        $pdf->Cell(5, $textypos, "TOTAL: ");
        $pdf->setX(75);
        $pdf->Cell(5, $textypos, "S/ " . number_format($total, 2, ".", ","), 0, 0, "R");
        $textypos += 12;
        $pdf->setX(2);
        $pdf->Cell(5, $textypos, "USUARIO: " . $datos->username);
        $textypos += 10;
        $pdf->setX(2);
        $pdf->Cell(5, $textypos, "CAJA: 01");
        $pdf->setX(20);
        $pdf->Cell(5, $textypos, "TURNO: 02");
        $pdf->setX(2);
        $pdf->setX(7);
        $pdf->Cell(0, $textypos + 11, 'HASH: ' . $datos->hash, 0, 0, 'C');

        $pdf->setX(2);
        $pdf->setX(10);
        $pdf->Cell(0, $textypos + 23, 'GRACIAS POR SU PREFERENCIA ', 0, 0, 'C');
        $pdf->output('', $datos->serie . " - " . $datos->numero . '.pdf');
    }

    public function mostrarKardex($data, $data_ex, $datos)
    {
        $pdf = new FPDF($orientation = 'L', $unit = 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 8, utf8_decode('FORMATO 12.1: "REGISTRO DEL INVENTARIO PERMANENTE EN UNIDADES FÍSICAS DETALLE DEL INVENTARIO PERMANENTE EN UNIDADES FÍSICAS"'), 0, 1, 'L');
        $pdf->Cell(0, 8, utf8_decode('PERÍODO: ' . $datos["mes"] . '/' . $datos["ano"]), 0, 1, 'L');
        $pdf->Cell(0, 8, utf8_decode('RUC: 20546439268'), 0, 1, 'L');
        $pdf->Cell(0, 8, utf8_decode('APELLIDOS Y NOMBRES, DENOMINACIÓN O RAZÓN SOCIAL: TMC'), 0, 1, 'L');
        $pdf->Cell(0, 8, utf8_decode('ESTABLECIMIENTO: 1'), 0, 1, 'L');
        $pdf->Cell(0, 8, utf8_decode('CÓDIGO DE LA EXISTENCIA: ' . $datos["id"]), 0, 1, 'L');
        $pdf->Cell(0, 8, utf8_decode('TIPO (TABLA 5): 01'), 0, 1, 'L');
        $pdf->Cell(0, 8, utf8_decode('DESCRIPCIÓN: ' . $datos["producto"]), 0, 1, 'L');
        $pdf->Cell(0, 8, utf8_decode('CÓDIGO DE LA UNIDAD DE MEDIDA (TABLA 6): 09'), 0, 1, 'L');




        $pdf->SetFillColor(100, 150, 250);
        $pdf->Cell(20, 10, 'FECHA', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'TIPO (Tabla 10)', 1, 0, 'C', true);
        $pdf->Cell(20, 10, 'SERIE', 1, 0, 'C', true);
        $pdf->Cell(40, 10, 'NUMERO', 1, 0, 'C', true);
        $pdf->Cell(50, 10, 'TIPO OPERACION Tabla 12', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'INGRESO (Gal.)', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'EGRESO(Gal.)', 1, 0, 'C', true);
        $pdf->Cell(35, 10, 'SALDO FINAL(Gal.)', 1, 0, 'C', true);
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 9);
        $cantidad_ex = $data_ex->cantidad;

        $pdf->Cell(20, 8, '', 1, 0, 'C');
        $pdf->Cell(30, 8, '00', 1, 0, 'C');

        $pdf->Cell(20, 8, '', 1, 0, 'C');
        $pdf->Cell(40, 8, '', 1, 0, 'C');

        $pdf->Cell(50, 8, '99', 1, 0, 'C');
        $pdf->Cell(30, 8, $data_ex->cantidad, 1, 0, 'C');
        $pdf->Cell(30, 8, '', 1, 0, 'C');

        $pdf->Cell(35, 8, $data_ex->cantidad, 1, 0, 'C');
        $pdf->Ln();
        foreach ($data->result() as $pro) {
            $date = new DateTime($pro->fecha);
            $pdf->Cell(20, 8, $date->format('d/m/Y'), 1, 0, 'C');
            if ($pro->serie[0] == "F") {
                $pdf->Cell(30, 8, '01', 1, 0, 'C');
            } else if ($pro->serie[0] == "B") {
                $pdf->Cell(30, 8, '03', 1, 0, 'C');
            }

            $pdf->Cell(20, 8, $pro->serie, 1, 0, 'C');
            $pdf->Cell(40, 8, $pro->numero, 1, 0, 'C');

            if ($pro->tipo == "VENTA") {
                $cantidad_ex -= $pro->cantidad;
                $pdf->Cell(50, 8, '01', 1, 0, 'C');
                $pdf->Cell(30, 8, '', 1, 0, 'C');
                $pdf->Cell(30, 8, $pro->cantidad, 1, 0, 'C');
            } else if ($pro->tipo == "COMPRA") {
                $cantidad_ex += $pro->cantidad;
                $pdf->Cell(50, 8, '02', 1, 0, 'C');
                $pdf->Cell(30, 8, $pro->cantidad, 1, 0, 'C');
                $pdf->Cell(30, 8, '', 1, 0, 'C');
            }
            $pdf->Cell(35, 8, number_format($cantidad_ex, 4, ".", ","), 1, 0, 'C');
            $pdf->Ln();
        }
        $pdf->Cell(20, 8, '', 0, 0, 'C');
        $pdf->Cell(30, 8, '', 0, 0, 'C');
        $pdf->Cell(20, 8, '', 0, 0, 'C');
        $pdf->Cell(40, 8, '', 0, 0, 'C');
        $pdf->Cell(50, 8, 'TOTALES', 0, 0, 'C');
        $pdf->Cell(30, 8, '', 1, 0, 'C');
        $pdf->Cell(30, 8, '', 1, 0, 'C');
        $pdf->Cell(35, 8, number_format($cantidad_ex, 4, ".", ","), 1, 0, 'C');
        $pdf->output('', 's.pdf');
    }

    public function mostrarListaProductos($data, $datos)
    {
        $pdf = new FPDF($orientation = 'L', $unit = 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'I', 14);

        $pdf->Cell(240, 8, utf8_decode('PERÍODO: ' . $datos["mes"] . '/' . $datos["ano"]), 0, 'L');
        $pdf->Cell(900, 8, utf8_decode('HORA: ' . date('H:i')), 0, 'L');
        $pdf->Ln();

        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 8, utf8_decode('TECNOLOGIA MEDICA CORPORATION E.I.R.L'), 0, 1, 'C');
        $pdf->Cell(0, 8, utf8_decode('REPORTE MENSUAL DE ' . $datos["doc"]), 0, 1, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(100, 150, 250);
        $pdf->Cell(25, 10, '', 2, 0, 'C');
        $pdf->Cell(35, 10, 'SERIE', 1, 0, 'C', true);
        $pdf->Cell(35, 10, 'NUMERO', 1, 0, 'C', true);
        $pdf->Cell(45, 10, 'FECHA', 1, 0, 'C', true);
        $pdf->Cell(45, 10, 'PRODUCTO', 1, 0, 'C', true);
        $pdf->Cell(35, 10, 'PRECIO UNIDAD', 1, 0, 'C', true);
        $pdf->Cell(35, 10, 'TOTAL', 1, 0, 'C', true);
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 9);
        $total = 0;
        foreach ($data->result() as $c) {
            $pdf->Cell(25, 10, '', 2, 0, 'C');
            $pdf->Cell(35, 8, $c->serie, 1, 0, 'C');
            $pdf->Cell(35, 8, $c->numero, 1, 0, 'C');
            $pdf->Cell(45, 8, $c->fecha, 1, 0, 'C');
            $pdf->Cell(45, 8, substr($c->nombre, 0, 48), 1, 0, 'C');
            $pdf->Cell(35, 8, $c->precio_unidad, 1, 0, 'C');
            $pdf->Cell(35, 8, $c->total, 1, 0, 'C');
            $total += $c->total;
            $pdf->Ln();
        }
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(100, 150, 250);
        $pdf->Cell(25, 10, '', 2, 0, 'C');
        $pdf->Cell(195, 8, 'TOTAL', 1, 0, 'C', true);
        $pdf->Cell(35, 8, $total, 1, 0, 'C');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Cell(280, 8, utf8_decode('------------------------------------------ Última línea ------------------------------------------'), 2, 0, 'C');
        $pdf->output('', 's.pdf');
    }

    public function mostrarListaComprobantesPeriodo($data, $datos)
    {
        $pdf = new FPDF($orientation = 'L', $unit = 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'I', 14);

        $pdf->Cell(240, 8, utf8_decode('Desde ' . $datos["date1"] . ' hasta ' . $datos["date2"]), 0, 'L');
        $pdf->Cell(900, 8, utf8_decode('HORA: ' . date('H:i')), 0, 'L');
        $pdf->Ln();

        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 8, utf8_decode('TECNOLOGIA MEDICA CORPORATION E.I.R.L'), 0, 1, 'C');
        $pdf->Cell(0, 8, utf8_decode('LISTA DE ' . $datos["doc"] . 'S'), 0, 1, 'C');
        $pdf->Ln();

        $pdf->SetFont('Arial', 'B', 10);

        $pdf->SetFillColor(100, 150, 250);
        $pdf->Cell(30, 10, 'FECHA', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'NUMERO', 1, 0, 'C', true);
        $pdf->Cell(70, 10, 'CLIENTE', 1, 0, 'C', true);
        $pdf->Cell(35, 10, 'PRODUCTO', 1, 0, 'C', true);
        $pdf->Cell(28, 10, 'SUB TOTAL', 1, 0, 'C', true);
        $pdf->Cell(18, 10, 'IGV', 1, 0, 'C', true);
        $pdf->Cell(28, 10, 'TOTAL', 1, 0, 'C', true);
        $pdf->Cell(35, 10, 'TIPO VENTA', 1, 0, 'C', true);
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 9);
        $total = 0;
        foreach ($data->result() as $pro) {
            $date = new DateTime($pro->fecha);
            $pdf->Cell(30, 8, $date->format('d/m/Y'), 1, 0, 'C');
            $pdf->Cell(30, 8, $pro->numero, 1, 0, 'C');
            $pdf->Cell(70, 8, substr($pro->cliente, 0, 48), 1, 0, 'C');
            $pdf->Cell(35, 8, $pro->nombre, 1, 0, 'C');
            $pdf->Cell(28, 8, $pro->subtotal, 1, 0, 'C');
            $pdf->Cell(18, 8, $pro->igv, 1, 0, 'C');
            $pdf->Cell(28, 8, $pro->total, 1, 0, 'C');
            $total = $total + (float) $pro->total;
            $pdf->Cell(35, 8, $pro->metodo_pago, 1, 0, 'C');
            $pdf->Ln();
        }
        $pdf->SetFillColor(100, 150, 250);
        $pdf->Ln();
        $pdf->Cell(239, 8, 'TOTAL', 1, 0, 'C', true);
        $pdf->Cell(35, 8, number_format($total, 2, '.', ''), 1, 0, 'C');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Cell(280, 8, utf8_decode('------------------------------------------ Última línea ------------------------------------------'), 2, 0, 'C');
        $pdf->output('', 's.pdf');
    }

    public function mostrarVentasReport($data, $datos)
    {
        $pdf = new FPDF($orientation = 'L', $unit = 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'I', 14);
        $pdf->Cell(240, 8, utf8_decode('PERÍODO: ' . $datos["date"]), 0, 'L');
        $pdf->Cell(900, 8, utf8_decode('HORA: ' . date('H:i')), 0, 'L');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 8, utf8_decode('TECNOLOGIA MEDICA CORPORATION E.I.R.L'), 0, 1, 'C');
        $pdf->Cell(0, 8, utf8_decode('VENTAS ENVIADAS A SUNAT'), 0, 1, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(100, 150, 250);
        $pdf->Cell(25, 10, '', 2, 0, 'C');
        $pdf->Cell(40, 10, 'FECHA', 1, 0, 'C', true);
        $pdf->Cell(40, 10, 'NUMERO DE VENTA', 1, 0, 'C', true);
        $pdf->Cell(45, 10, 'PRODUCTO', 1, 0, 'C', true);
        $pdf->Cell(35, 10, 'PRECIO', 1, 0, 'C', true);
        $pdf->Cell(35, 10, 'CANTIDAD', 1, 0, 'C', true);
        $pdf->Cell(35, 10, 'TOTAL', 1, 0, 'C', true);
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 9);
        $venta = 0;
        foreach ($data->result() as $pro) {
            $date1 = new DateTime($pro->created_at);
            $pdf->SetFillColor(100, 150, 250);
            $pdf->Cell(25, 10, '', 2, 0, 'C');
            $pdf->Cell(40, 8, $date1->format('d/m/Y H:i'), 1, 0, 'C');
            $pdf->Cell(40, 8, $pro->venta_id, 1, 0, 'C');
            $pdf->Cell(45, 8, $pro->nombre, 1, 0, 'C');
            $pdf->Cell(35, 8, $pro->precio_unidad, 1, 0, 'C');
            $pdf->Cell(35, 8, $pro->cantidad, 1, 0, 'C');
            $pdf->Cell(35, 8, $pro->total, 1, 0, 'C');
            $venta = $venta + (float) ($pro->total);
            $pdf->Ln();
        }
        $pdf->SetFillColor(100, 150, 250);
        $pdf->Ln();
        $pdf->Cell(25, 10, '', 2, 0, 'C');
        $pdf->Cell(195, 8, 'TOTAL', 1, 0, 'C', true);
        $pdf->Cell(35, 8, number_format($venta, 2, '.', ''), 1, 0, 'C');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Cell(280, 8, utf8_decode('------------------------------------------ Última línea ------------------------------------------'), 2, 0, 'C');
        $pdf->output('', 's.pdf');
    }

    public function mostrarListaComprobantesMaquina($data, $datos)
    {
        $pdf = new FPDF($orientation = 'L', $unit = 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'I', 14);

        $pdf->Cell(240, 8, utf8_decode('PERÍODO: ' . $datos["mes"] . '/' . $datos["ano"]), 0, 'L');
        $pdf->Cell(900, 8, utf8_decode('HORA: ' . date('H:i')), 0, 'L');
        $pdf->Ln();

        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 8, utf8_decode('TECNOLOGIA MEDICA CORPORATION E.I.R.L'), 0, 1, 'C');
        $pdf->Cell(0, 8, utf8_decode('LISTA DE ' . $datos["doc"] . 'S'), 0, 1, 'C');
        $pdf->Ln();

        $pdf->SetFont('Arial', 'B', 10);

        $pdf->SetFillColor(100, 150, 250);
        $pdf->Cell(55, 10, '', 2, 0, 'C');
        $pdf->Cell(40, 10, 'FECHA', 1, 0, 'C', true);
        $pdf->Cell(80, 10, 'PRODUCTO', 1, 0, 'C', true);
        $pdf->Cell(40, 10, 'TOTAL', 1, 0, 'C', true);
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 9);
        $total = 0;
        foreach ($data->result() as $pro) {
            $date = new DateTime($pro->fecha);
            $pdf->Cell(55, 10, '', 2, 0, 'C');
            $pdf->Cell(40, 8, $date->format('d/m/Y'), 1, 0, 'C');
            $pdf->Cell(80, 8, substr($pro->nombre, 0, 48), 1, 0, 'C');
            $pdf->Cell(40, 8, $pro->monto, 1, 0, 'C');
            $total = $total + (float) $pro->monto;
            $pdf->Ln();
        }
        $pdf->Ln();
        $pdf->Cell(55, 10, '', 2, 0, 'C');
        $pdf->Cell(120, 10, 'TOTAL', 1, 0, 'C', true);
        $pdf->Cell(40, 10, $total, 1, 0, 'C');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Cell(270, 8, utf8_decode('------------------------------------------ Última línea ------------------------------------------'), 2, 0, 'C');
        $pdf->output('', 's.pdf');
    }

    public function mostrarListaComprobantes($data, $datos)
    {
        $pdf = new FPDF($orientation = 'L', $unit = 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'I', 14);

        $pdf->Cell(240, 8, utf8_decode('PERÍODO: ' . $datos["mes"] . '/' . $datos["ano"]), 0, 'L');
        $pdf->Cell(900, 8, utf8_decode('HORA: ' . date('H:i')), 0, 'L');
        $pdf->Ln();

        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 8, utf8_decode('TMC E.I.R.L. '), 0, 1, 'C');
        $pdf->Cell(0, 8, utf8_decode('LISTA DE ' . $datos["doc"] . 'S'), 0, 1, 'C');
        $pdf->Ln();

        $pdf->SetFont('Arial', 'B', 10);

        $pdf->SetFillColor(100, 150, 250);
        $pdf->Cell(30, 10, 'FECHA', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'NUMERO', 1, 0, 'C', true);
        $pdf->Cell(96, 10, 'CLIENTE', 1, 0, 'C', true);
        $pdf->Cell(28, 10, 'SUB TOTAL', 1, 0, 'C', true);
        $pdf->Cell(28, 10, 'IGV', 1, 0, 'C', true);
        $pdf->Cell(28, 10, 'TOTAL', 1, 0, 'C', true);
        $pdf->Cell(35, 10, 'TIPO VENTA', 1, 0, 'C', true);
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 9);
        $total = 0;
        foreach ($data->result() as $pro) {
            $date = new DateTime($pro->fecha);
            $pdf->Cell(30, 8, $date->format('d/m/Y'), 1, 0, 'C');

            $pdf->Cell(30, 8, $pro->numero, 1, 0, 'C');
            $pdf->Cell(96, 8, substr($pro->cliente, 0, 48), 1, 0, 'C');
            $pdf->Cell(28, 8, $pro->subtotal, 1, 0, 'C');
            $pdf->Cell(28, 8, $pro->igv, 1, 0, 'C');
            $pdf->Cell(28, 8, $pro->total, 1, 0, 'C');
            $total = $total + (float) $pro->total;
            $pdf->Cell(35, 8, $pro->metodo_pago, 1, 0, 'C');
            $pdf->Ln();
        }
        $pdf->Cell(212, 8, 'TOTAL', 1, 0, 'C');
        $pdf->Cell(28, 8, $total, 1, 0, 'C');
        if ($data->result() != null) {
            $total = $total + (float) $pro->total;
        }
        $pdf->Cell(35, 8, '', 1, 0, 'C');
        $pdf->output('', 's.pdf');
    }

    public function reporte_compra($compras)
    {
        $pdf = new FPDF($orientation = 'L', $unit = 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'I', 14);



        $pdf->Ln();

        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 8, utf8_decode("REPORTE COMPRAS"), 0, 1, 'C');

        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(35, 8, 'EMPRESA: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(100, 8, utf8_decode('TECNOLOGIA MEDICA CORPORATION E.I.R.L'), 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(50, 8, utf8_decode('FECHA:'), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(85, 8, date("Y-m-d H:m:s"), 0, 0, 'L');

        $pdf->Ln(8);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(35, 8, 'RUC: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(100, 8, "20546439268", 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(50, 8, utf8_decode('ESTABLECIMIENTO:'), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(85, 8, utf8_decode("Jr. Pataz Nº 1243 Mz. Q Lt. 30"), 0, 0, 'L');


        $pdf->Ln(15);
        $pdf->SetFont('Arial', 'B', 8);

        $pdf->SetFillColor(0, 136, 207);
        $pdf->SetTextColor(256, 256, 256);
        $pdf->Cell(10, 10, '#', 1, 0, 'C', true);
        // $pdf->Cell(40, 10, 'TIPO COMPROBANTE', 1, 0, 'C', true);
        $pdf->Cell(35, 10, 'SERIE/NUMERO', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'RUC', 1, 0, 'C', true);
        $pdf->Cell(70, 10, 'RAZON SOCIAL', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'FECHA', 1, 0, 'C', true);
        $pdf->Cell(40, 10, 'CREACION', 1, 0, 'C', true);
        $pdf->Cell(65, 10, 'USUARIO', 1, 0, 'C', true);
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 9);
        //CONTENIDO

        $pdf->SetTextColor(0, 0, 0);

        foreach ($compras as $c) {

            //$date = new DateTime($v->createdAt_venta);
            $pdf->Cell(10, 10, utf8_decode($c->id), 1, 0, 'C');
            $pdf->Cell(35, 10, utf8_decode($c->serie . "-" . $c->numero), 1, 0, 'C');
            $pdf->Cell(30, 10, $c->ruc, 1, 0, 'C');
            $pdf->Cell(70, 10, utf8_decode($c->nombre_proveedor), 1, 0, 'C');
            $pdf->Cell(30, 10, $c->fecha, 1, 0, 'C');
            $pdf->Cell(40, 10, $c->created_at, 1, 0, 'C');
            $pdf->Cell(65, 10, utf8_decode($c->first_name . " " . $c->last_name), 1, 0, 'C');
            $pdf->Ln();
        }

        $pdf->output('', 'ReporteCompra'  . '.pdf');
    }

    public function reporte_remision_A4($data, $prods)
    {
        $pdf = new FPDF($orientation = 'P', $unit = 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 20);
        $pdf->SetTextColor(94, 94, 94);
        $pdf->setY(7);
        $pdf->setX(5);
        $pdf->Cell(15, 10, $pdf->Image('images/foto1.jpg', $pdf->GetX(), $pdf->GetY(), 120), 0, 0, 'C');
        $pdf->setX(80);
        $pdf->setY(46);
        $pdf->Cell(72, 10, "", 0, 0, 'C');
        $pdf->Cell(15, 10, $pdf->Image('images/foto2.png', $pdf->GetX(), $pdf->GetY(), 27), 0, 0, 'C');
        $pdf->Rect(125, 5, 80, 38, 'D');
        $pdf->setX(0);
        $pdf->setY(7);
        $pdf->Cell(110, 7, "", 0, 0, 'L');
        $pdf->Cell(90, 7, utf8_decode('RUC: 20546439268'), 0, 0, 'C');
        $pdf->Ln();
        $pdf->Cell(110, 7, "", 0, 0, 'L');
        $pdf->Cell(90, 7, utf8_decode('GUIA DE REMISIÓN'), 0, 0, 'C');
        $pdf->Ln();
        $pdf->Cell(110, 7, "", 0, 0, 'L');
        $pdf->Cell(90, 7, utf8_decode('ELECTRÓNICA -'), 0, 0, 'C');
        $pdf->Ln();
        $pdf->Cell(110, 7, "", 0, 0, 'L');
        $pdf->Cell(90, 7, utf8_decode('REMITENTE'), 0, 0, 'C');
        $pdf->Ln();
        $pdf->Cell(110, 7, "", 0, 0, 'L');
        $pdf->Cell(90, 7, $data->serie . ' - ' . $data->numero, 0, 0, 'C');

        $pdf->SetFont('Arial', '', 8.8);
        $pdf->Ln(13);
        $pdf->Cell(55, 4, utf8_decode('Jr. Pataz Nº 1243 Mz. Q Lt. 30'), 0, 0, 'R');
        $pdf->Cell(60, 4, "", 0, 0, 'C');
        $pdf->Cell(78, 4, utf8_decode('Cta. Cte. BBVA Soles:0011-0342-38-0100024845'), 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(55, 4, utf8_decode('2do Piso. Urb. Covida I Etapa'), 0, 0, 'R');
        $pdf->Cell(60, 4, "", 0, 0, 'C');
        $pdf->Cell(78, 4, utf8_decode('Cta. Cte. BBVA Dólares:0011-0312-01-0000896'), 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(55, 4, utf8_decode('Los Olivos - Lima'), 0, 0, 'R');
        $pdf->Cell(60, 4, "", 0, 0, 'C');
        $pdf->Cell(78, 4, utf8_decode('Telf:  +511  485-1187 Cel: +51 968-871-841'), 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(55, 4, utf8_decode('Referencia: En paralelo con'), 0, 0, 'R');
        $pdf->Cell(60, 4, "", 0, 0, 'C');
        $pdf->Cell(78, 4, utf8_decode('tecnologia.medica.corporation@gmail.com'), 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(55, 4, utf8_decode('Av. Antunez de Mayolo'), 0, 0, 'R');
        $pdf->Cell(60, 4, "", 0, 0, 'C');
        $pdf->Cell(78, 4, utf8_decode('cotizaciones1@viatmc.com'), 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(55, 4, utf8_decode('(a espaldas del Banco Scotiabank)'), 0, 0, 'R');
        $pdf->Cell(60, 4, "", 0, 0, 'C');
        $pdf->Cell(78, 4, utf8_decode('www.viatmc.com'), 0, 0, 'L');

        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(68, 68, 68);
        $pdf->Ln(7);
        $pdf->SetX(5);
        $pdf->Cell(60, 4, utf8_decode('DATOS DEL TRASLADO'), 0, 0, 'L');
        $pdf->Ln(4);
        $pdf->SetX(5);
        $pdf->Cell(60, 4, utf8_decode('Fecha de emisión:'), 0, 0, 'L');
        $pdf->Cell(40, 4, $data->fecha_remision, 0, 0, 'L');
        $pdf->Ln();
        $pdf->SetX(5);
        $pdf->Cell(60, 4, utf8_decode('Fecha de inicio del traslado:'), 0, 0, 'L');
        $pdf->Cell(40, 4, $data->fecha_inicio_traslado, 0, 0, 'L');
        $pdf->Ln();
        $pdf->SetX(5);
        $pdf->Cell(60, 4, utf8_decode('Motivo de traslado:'), 0, 0, 'L');
        $pdf->Cell(40, 4, utf8_decode($data->motivo_traslado_descripcion), 0, 0, 'L');
        $pdf->Ln();
        $pdf->SetX(5);
        $pdf->Cell(60, 4, utf8_decode('Modalidad Transporte:'), 0, 0, 'L');
        $pdf->Cell(40, 4, utf8_decode($data->modalidad_transporte), 0, 0, 'L');
        $pdf->Ln();
        $pdf->SetX(5);
        $pdf->Cell(60, 4, utf8_decode('Peso bruto (kg):'), 0, 0, 'L');
        $pdf->Cell(40, 4,  $data->peso_bruto, 0, 0, 'L');

        $pdf->Ln(8);
        $pdf->SetX(5);
        $pdf->Cell(190, 4, utf8_decode('DATOS DEL DESTINATARIO'), 0, 0, 'L');
        $pdf->Ln();
        $pdf->SetX(5);
        $pdf->Cell(60, 4, utf8_decode('Razón Social o Denominación:'), 0, 0, 'L');
        $pdf->Cell(130, 4, utf8_decode($data->destinatario_nombre), 0, 0, 'L');
        $pdf->Ln();
        $pdf->SetX(5);
        $pdf->Cell(60, 4, utf8_decode('Documento de identidad:'), 0, 0, 'L');
        $pdf->Cell(130, 4, utf8_decode($data->destinatario_identidad_numero), 0, 0, 'L');

        $pdf->Ln(10);
        $pdf->SetX(5);
        $pdf->Cell(190, 4, utf8_decode('DATOS DEL PUNTO DE PARTIDA Y PUNTO DE LLEGADA'), 0, 0, 'L');
        $pdf->Ln();
        $pdf->SetX(5);
        $pdf->Cell(60, 4, utf8_decode('Dirección del punto de partida:'), 0, 0, 'L');
        $pdf->setX(65);
        $pdf->MultiCell(135, 4, utf8_decode($data->partida_ubigeo . " " . $data->partida_direccion),  0, 'L');
        $pdf->setY($pdf->GetY() - 4);

        $pdf->Ln();
        $pdf->SetX(5);
        $pdf->Cell(60, 4, utf8_decode('Dirección del punto de llegada:'), 0, 0, 'L');
        $pdf->setX(65);
        $pdf->MultiCell(135, 4, utf8_decode($data->llegada_ubigeo . " " . $data->llegada_direccion),  0, 'L');
        $pdf->setY($pdf->GetY() - 4);


        $pdf->Ln(10);
        $pdf->SetX(5);
        $pdf->Cell(190, 4, utf8_decode('DATOS DEL TRANSPORTE'), 0, 0, 'L');
        $pdf->Ln(4);
        $pdf->SetX(5);
        $pdf->Cell(190, 4, utf8_decode('Datos de los vehículos     |    Datos de los conductores'), 0, 0, 'L');


        //tabla vehículos
        $pdf->SetFillColor(153, 153, 153);
        $pdf->SetTextColor(250, 250, 250);
        $pdf->Ln(4);
        $pdf->SetX(5);
        $pdf->Cell(50, 6, utf8_decode('Nro. Placa'), 0, 0, 'C', true);
        $pdf->Cell(25, 6, utf8_decode('Nro.'), 0, 0, 'C', true);
        $pdf->Cell(50, 6, utf8_decode('Tipo Doc.'), 0, 0, 'C', true);
        $pdf->Cell(65, 6, utf8_decode('Nro. Doc.'), 0, 0, 'C', true);
        $pdf->Ln();
        $pdf->SetX(5);
        $pdf->SetTextColor(68, 68, 68);
        $pdf->Cell(50, 8, utf8_decode($data->placa_vehiculo_transporte), 0, 0, 'C');
        $pdf->Cell(25, 8, utf8_decode("1"), 0, 0, 'C');
        $pdf->Cell(50, 8, utf8_decode($data->transportista_identidad_tipo), 0, 0, 'C');
        $pdf->Cell(65, 8, utf8_decode($data->conductor_identidad_numero), 0, 0, 'C');


        $pdf->Ln(10);
        $pdf->SetX(5);
        $pdf->Cell(190, 6, utf8_decode('DATOS DE LOS BIENES'), 0, 0, 'L');
        //tabla bienes
        $pdf->SetFillColor(153, 153, 153);
        $pdf->SetTextColor(250, 250, 250);
        $pdf->Ln(6);
        $pdf->SetX(5);
        $pdf->Cell(15, 6, utf8_decode('Nro.'), 0, 0, 'C', true);
        $pdf->Cell(25, 6, utf8_decode('Cod. Bien'), 0, 0, 'C', true);
        $pdf->Cell(105, 6, utf8_decode('Descripción'), 0, 0, 'C', true);
        $pdf->Cell(20, 6, utf8_decode('Und. Med.'), 0, 0, 'C', true);
        $pdf->Cell(25, 6, utf8_decode('Cantidad'), 0, 0, 'C', true);
        //$pdf->Ln();
        $pdf->SetTextColor(68, 68, 68);
        //contenido tablas
        $f = 1;
        foreach ($prods->result() as $pro) {
            if (!isset($pro->unidad_medida)) {
                $pro->unidad_medida = '';
            }
            if ($f % 2 == 0) {
                $pdf->SetFillColor(255, 255, 255);
            } else {
                $pdf->SetFillColor(255, 255, 255);
            }
            $pdf->Ln(7);
            $pdf->SetX(5);
            $pdf->Cell(15, 4, $f, 0, 0, 'C', true);
            $pdf->Cell(30, 4, utf8_decode($pro->cod), 0, 0, 'C', true);
            $pdf->Cell(100, 4, "", 0, 0, 'L');
            $pdf->Cell(20, 4, utf8_decode($pro->unidad_medida), 0, 0, 'C', true);
            $pdf->Cell(25, 4, $pro->cantidad, 0, 0, 'C', true);
            $pdf->setX(50);
            $pdf->MultiCell(100, 4, utf8_decode($pro->descripcion),  0, 'L', true);
            $pdf->setY($pdf->GetY() - 4);
            $f = $f + 1;
        }
        $pdf->Ln(12);
        $pdf->SetX(5);
        $pdf->Cell(190, 6, utf8_decode('OBSERVACIONES: ' . $data->observaciones), 0, 0, 'C');
        $pdf->output('', $data->serie . '-' . $data->numero . "_" . $data->destinatario_nombre . '.pdf');
    }
    public function reporte_factura_A4($data, $prods)
    {
        $pdf = new FPDF($orientation = 'P', $unit = 'mm', 'A4');
        $pdf->footer = true;
        $pdf->AddPage();
        $pdf->SetAutoPageBreak(true, 30);
        $pdf->SetFont('Arial', '', 20);
        if ($data->vencimiento === null || $data->vencimiento === "") {
            $vencimiento = "";
        } else {
            $vencimiento = new DateTime($data->vencimiento);
            $vencimiento = $vencimiento->format('d/m/Y');
        }
        $pdf->setY(7);
        $pdf->setX(5);
        $pdf->Cell(15, 10, $pdf->Image('images/foto1.jpg', $pdf->GetX(), $pdf->GetY(), 120), 0, 0, 'C');
        $pdf->setX(80);
        $pdf->setY(44);
        $pdf->Cell(72, 10, "", 0, 0, 'C');
        $pdf->Cell(15, 10, $pdf->Image('images/foto2.png', $pdf->GetX(), $pdf->GetY(), 27), 0, 0, 'C');
        $pdf->Rect(125, 5, 78, 39, 'D');
        $pdf->setX(0);
        $pdf->setY(7);
        $pdf->SetTextColor(94, 94, 94);
        $pdf->Cell(115, 7, "", 0, 0, 'L');
        $pdf->Cell(78, 7, utf8_decode('RUC: 20546439268'), 0, 0, 'C');
        $pdf->Ln(10);
        $pdf->Cell(115, 7, "", 0, 0, 'L');
        $pdf->Cell(78, 7, utf8_decode('FACTURA'), 0, 0, 'C');
        $pdf->Ln();
        $pdf->Cell(115, 7, "", 0, 0, 'L');
        $pdf->Cell(78, 7, utf8_decode('ELECTRÓNICA'), 0, 0, 'C');
        $pdf->Ln(10);
        $pdf->Cell(115, 7, "", 0, 0, 'L');
        $pdf->Cell(78, 7, $data->serie . ' - ' . $data->numero, 0, 0, 'C');

        $pdf->SetFont('Arial', '', 8.8);
        $pdf->Ln(12);
        $pdf->Cell(55, 4, utf8_decode('Jr. Pataz Nº 1243 Mz. Q Lt. 30'), 0, 0, 'R');
        $pdf->Cell(60, 4, "", 0, 0, 'C');
        $pdf->Cell(78, 4, utf8_decode('Cta. Cte. BBVA Soles:0011-0342-38-0100024845'), 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(55, 4, utf8_decode('2do Piso. Urb. Covida I Etapa'), 0, 0, 'R');
        $pdf->Cell(60, 4, "", 0, 0, 'C');
        $pdf->Cell(78, 4, utf8_decode('Cta. Cte. BBVA Dólares:0011-0312-01-0000896'), 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(55, 4, utf8_decode('Los Olivos - Lima'), 0, 0, 'R');
        $pdf->Cell(60, 4, "", 0, 0, 'C');
        $pdf->Cell(78, 4, utf8_decode('Telf:  +511  485-1187 Cel: +51 968-871-841'), 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(55, 4, utf8_decode('Referencia: En paralelo con'), 0, 0, 'R');
        $pdf->Cell(60, 4, "", 0, 0, 'C');
        $pdf->Cell(78, 4, utf8_decode('tecnologia.medica.corporation@gmail.com'), 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(55, 4, utf8_decode('Av. Antunez de Mayolo'), 0, 0, 'R');
        $pdf->Cell(60, 4, "", 0, 0, 'C');
        $pdf->Cell(78, 4, utf8_decode('cotizaciones1@viatmc.com'), 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(55, 4, utf8_decode('(a espaldas del Banco Scotiabank)'), 0, 0, 'R');
        $pdf->Cell(60, 4, "", 0, 0, 'C');
        $pdf->Cell(78, 4, utf8_decode('www.viatmc.com'), 0, 0, 'L');



        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->SetTextColor(68, 68, 68);
        $pdf->SetX(5);
        $pdf->Cell(45, 4, utf8_decode('Nombre/Razón Social: '), 0, 0, 'L');
        $pdf->Cell(82, 4, "", 0, 0, 'L');
        $pdf->Cell(38, 4, utf8_decode('RUC N°:'), 0, 0, 'L');
        $pdf->Cell(27, 4, utf8_decode($data->docum), 0, 0, 'L');
        $pdf->setX(50);
        $pdf->MultiCell(82, 4,  utf8_decode($data->cliente),  0, 'L');
        $pdf->setY($pdf->GetY() - 4);
        //$pdf->Cell(130, 6, utf8_decode($data->partida_ubigeo . " " . $data->partida_direccion), 0, 0, 'L');
        $pdf->Ln(4);
        $pdf->SetX(5);
        $pdf->Cell(45, 4, utf8_decode('Dirección: '), 0, 0, 'L');
        $pdf->Cell(82, 4, "", 0, 0, 'L');
        $pdf->Cell(38, 4, utf8_decode('Fecha de Emisión: '), 0, 0, 'L');
        $date = new DateTime($data->fecha);
        $pdf->Cell(27, 4, utf8_decode($date->format('d/m/Y')), 0, 0, 'L');
        $pdf->setX(50);
        $pdf->MultiCell(82, 4,  utf8_decode($data->direccion),  0, 'L');
        $pdf->setY($pdf->GetY() - 4);

        $pdf->Ln(4);
        $pdf->SetX(5);
        $pdf->Cell(45, 4, utf8_decode('Moneda: '), 0, 0, 'L');
        $pdf->Cell(82, 4, $data->codigo_moneda, 0, 0, 'L');
        $pdf->Cell(38, 4, utf8_decode('Fecha de Vencimiento:'), 0, 0, 'L');
        $pdf->Cell(27, 4, utf8_decode($vencimiento), 0, 0, 'L');

        $pdf->Ln(4);
        $pdf->SetX(5);
        $pdf->Cell(45, 4, ($data->tipo_venta == "PRODUCTOS") ? 'Orden de Compra:' : 'Orden de Servicio:', 0, 0, 'L');
        $pdf->Cell(82, 4, $data->orden_servicio, 0, 0, 'L');
        $pdf->Cell(38, 4, utf8_decode('Forma de Pago:'), 0, 0, 'L');
        $pdf->Cell(27, 4, utf8_decode($data->metodo_pago), 0, 0, 'L');


        $pdf->SetFillColor(153, 153, 153);
        $pdf->SetTextColor(68, 68, 68);

        $pdf->SetFont('Arial', 'B', 9);



        $pdf->Ln(5);
        $pdf->SetX(5);
        $pdf->Cell(15, 6, utf8_decode('Item.'), 1, 0, 'C', true);
        $pdf->Cell(20, 6, utf8_decode('Código'), 1, 0, 'C', true);
        $pdf->Cell(90, 6, utf8_decode('Descripción'), 1, 0, 'C', true);
        $pdf->Cell(15, 6, utf8_decode('U.M. '), 1, 0, 'C', true);
        $pdf->Cell(15, 6, utf8_decode('Cantidad'), 1, 0, 'C', true);
        $pdf->Cell(20, 6, utf8_decode('Precio'), 1, 0, 'C', true);
        $pdf->Cell(25, 6, utf8_decode('Total'), 1, 0, 'C', true);
        //$pdf->Ln();
        $pdf->SetTextColor(68, 68, 68);
        //contenido tablas
        $pdf->SetFont('Arial', '', 8);
        /*
        $pdf->Ln(6);
        $pdf->SetX(5);
         $pdf->SetWidths(array(15, 20, 85, 15, 15, 20, 25));
        $i = 1;
        foreach ($prods->result() as $pro) {
            $pdf->Row(array($i, utf8_decode($pro->codigo_producto), utf8_decode($pro->nombre_producto), utf8_decode($pro->unidad), round($pro->cantidad, 2), number_format($pro->precio_unidad, 2),number_format($pro->total, 2)));
            $i++;
        }

*/
        //$pdf->Ln(1);
        $pdf->SetX(5);
        $f = 1;
        $subtotal = 0;
        $total = 0;
        $pdf->Ln(6);
        $pdf->SetWidths(array(15, 20, 90, 15, 15, 20, 25));
        $pdf->SetAligns(array('C', 'C', 'L', 'C', 'C', 'R', 'R'));
        foreach ($prods->result() as $pro) {
            if (!isset($pro->unidad)) {
                $pro->unidad = 'ZZ';
            }
            $pdf->SetX(5);
            $pdf->Row(array($f, utf8_decode($pro->codigo_producto), utf8_decode($pro->nombre_producto), utf8_decode($pro->unidad), round($pro->cantidad, 2), number_format($pro->precio_unidad, 2), number_format($pro->total, 2)));
            $f = $f + 1;
            $subtotal += $pro->subtotal;
            $total += $pro->total;
        }
        /*
        foreach ($prods->result() as $pro) {

            if (!isset($pro->unidad_medida)) {
                $pro->unidad_medida = '';
            }
            if ($f % 2 == 0) {
                $pdf->SetFillColor(255, 255, 255);
            } else {
                $pdf->SetFillColor(255, 255, 255);
            }
            $pdf->Ln(6);
            $pdf->SetX(5);
            $pdf->Cell(15, 4, $f, 0, 0, 'C', true);
            $pdf->Cell(20, 4, utf8_decode($pro->codigo_producto), 0, 0, 'C', true);
            $pdf->Cell(90, 4, "", 0, 0, 'C', true);
            $pdf->Cell(15, 4, utf8_decode($pro->unidad), 0, 0, 'C', true);
            $pdf->Cell(15, 4, round($pro->cantidad, 2), 0, 0, 'C', true);
            $pdf->Cell(20, 4, number_format($pro->precio_unidad, 2), 0, 0, 'R', true);
            $pdf->Cell(25, 4, number_format($pro->total, 2), 0, 0, 'R', true);
            $pdf->setX(40);
            $pdf->MultiCell(90, 4, utf8_decode($pro->nombre_producto),  0, 'L', true);
            $pdf->Line(5, $pdf->GetY(), 205, $pdf->GetY());
            $pdf->setY($pdf->GetY() - 4);
            $pdf->SetDrawColor(0, 0, 0);

            $f = $f + 1;
            $subtotal += $pro->subtotal;
            $total += $pro->total;
        }
        */
        $pdf->SetFont('Arial', '', 10.5);
        $pdf->Ln(5);
        $pdf->Cell(105, 5, "", 0, 0, 'L');
        $pdf->Cell(30, 5, utf8_decode('Op. Gravada'), 0, 0, 'L');
        $pdf->Cell(10, 5, utf8_decode($data->codigo_moneda), 0, 0, 'L');
        $pdf->Cell(50, 5, number_format($subtotal, 2), 0, 0, 'R');

        $pdf->Ln(5);
        $pdf->Cell(105, 5, "", 0, 0, 'L');
        $pdf->Cell(30, 5, utf8_decode('I.G.V. (18%)'), 0, 0, 'L');
        $pdf->Cell(10, 5, utf8_decode($data->codigo_moneda), 0, 0, 'L');
        $pdf->Cell(50, 5, number_format($total - $subtotal, 2), 0, 0, 'R');

        $pdf->Ln(5);
        $pdf->Cell(105, 5, "", 0, 0, 'L');
        $pdf->Cell(30, 5, utf8_decode('Op. Inafecta'), 0, 0, 'L');
        $pdf->Cell(10, 5, utf8_decode($data->codigo_moneda), 0, 0, 'L');
        $pdf->Cell(50, 5, "0.00", 0, 0, 'R');

        $pdf->Ln(5);
        $pdf->Cell(105, 5, "", 0, 0, 'L');
        $pdf->Cell(30, 5, utf8_decode('Op. Exonerada'), 0, 0, 'L');
        $pdf->Cell(10, 5, utf8_decode($data->codigo_moneda), 0, 0, 'L');
        $pdf->Cell(50, 5, "0.00", 0, 0, 'R');

        $pdf->Ln(5);
        $pdf->Cell(105, 5, "", 0, 0, 'L');
        $pdf->Cell(30, 5, utf8_decode('Op. Exportación'), 0, 0, 'L');
        $pdf->Cell(10, 5, utf8_decode($data->codigo_moneda), 0, 0, 'L');
        $pdf->Cell(50, 5, "0.00", 0, 0, 'R');

        $pdf->Ln(5);
        $pdf->Cell(105, 5, "", 0, 0, 'L');
        $pdf->Cell(30, 5, utf8_decode('Importe Total'), 0, 0, 'L');
        $pdf->Cell(10, 5, utf8_decode($data->codigo_moneda), 0, 0, 'L');
        $pdf->Cell(50, 5, number_format($total, 2), 'T', 0, 'R');



        $CI = &get_instance();
        $CI->load->library('numero_a_letras');
        $numero_letra = $CI->numero_a_letras->convert($total, $this->_moneda[$data->codigo_moneda], TRUE);
        $pdf->Ln(7);
        $pdf->SetX(5);
        $pdf->Cell(10, 6, utf8_decode('SON:'), 0, 0, 'L');
        $pdf->MultiCell(185, 6,  utf8_decode($numero_letra),  0, 'L');
        $pdf->setY($pdf->GetY() - 6);

        $pdf->SetFont('Arial', '', 10);
        $pdf->Ln(6);
        $pdf->SetX(5);
        $pdf->Cell(50, 6, utf8_decode('Información Adicional:'), 0, 0, 'L');

        /*

        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->SetX(5);
        $pdf->Cell(50, 6, utf8_decode('Observación'), 1, 0, 'L');
        $pdf->MultiCell(145, 6,  utf8_decode("El comprobante numero " . $data->serie . " - " . $data->numero . " se encuentra " . ($data->estado_api != NULL ? $data->estado_api : 'registrado') . " por SUNAT. " . $data->observacion),  1, 'L');
        $pdf->setY($pdf->GetY() - 6);

        // $pdf->Ln(6);
        // $pdf->Cell(50, 6, utf8_decode('Observaciones comprobante:'), 0, 0, 'L');
        //$pdf->MultiCell(140, 6,  utf8_decode($data->observacion),  0, 'L');
        // $pdf->setY($pdf->GetY() - 6);
*/


        $pdf->Ln(6);
        $pdf->SetX(5);
        $pdf->Cell(5, 6, "1", 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode('Guía de Remisión'), 1, 0, 'L');
        //$pdf->Cell(150, 6, utf8_decode($data->guia_remision."SSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS"), 1, 0, 'L');
        $pdf->MultiCell(150, 6,  utf8_decode(trim(preg_replace('/\s\s+/', ' ', $data->guia_remision_numeros))),  1, 'L');
        
        $pdf->setY($pdf->GetY() + 6);

        $pdf->SetX(5);
        $pdf->Cell(5, 6, "2", 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode('Observación'), 1, 0, 'L');
        $pdf->MultiCell(150, 6,  utf8_decode("El comprobante numero " . $data->serie . " - " . $data->numero . " se encuentra " . ($data->estado_api != NULL ? $data->estado_api : 'registrado') . " por SUNAT. " . $data->observacion),  1, 'L');
        $pdf->setY($pdf->GetY() + 10);


        $pdf->output('', $data->serie . '-' . $data->numero . "_" . $data->cliente . '.pdf');
    }

    public function reporte_boleta_A4($data, $prods)
    {
        $pdf = new FPDF($orientation = 'P', $unit = 'mm', 'A4');
        $pdf->footer = true;
        $pdf->AddPage();
        $pdf->SetAutoPageBreak(true, 30);
        $pdf->SetFont('Arial', '', 19);
        if ($data->vencimiento === null || $data->vencimiento === "") {
            $vencimiento = "";
        } else {
            $vencimiento = new DateTime($data->vencimiento);
            $vencimiento = $vencimiento->format('d/m/Y');
        }
        $pdf->setY(7);
        $pdf->setX(5);
        $pdf->Cell(15, 10, $pdf->Image('images/foto1.jpg', $pdf->GetX(), $pdf->GetY(), 120), 0, 0, 'C');
        $pdf->setX(80);
        $pdf->setY(49);
        $pdf->Cell(75, 10, "", 0, 0, 'C');
        $pdf->Cell(15, 10, $pdf->Image('images/foto2.png', $pdf->GetX(), $pdf->GetY(), 30), 0, 0, 'C');
        $pdf->Rect(125, 8, 78, 39, 'D');
        $pdf->setX(0);
        $pdf->setY(10);
        $pdf->SetTextColor(94, 94, 94);
        $pdf->Cell(115, 7, "", 0, 0, 'L');
        $pdf->Cell(78, 7, utf8_decode('RUC: 20546439268'), 0, 0, 'C');
        $pdf->Ln(10);
        $pdf->Cell(115, 7, "", 0, 0, 'L');
        $pdf->Cell(78, 7, utf8_decode('BOLETA'), 0, 0, 'C');
        $pdf->Ln();
        $pdf->Cell(115, 7, "", 0, 0, 'L');
        $pdf->Cell(78, 7, utf8_decode('ELECTRONICA'), 0, 0, 'C');
        $pdf->Ln(10);
        $pdf->Cell(115, 7, "", 0, 0, 'L');
        $pdf->Cell(78, 7, $data->serie . ' - ' . $data->numero, 0, 0, 'C');

        $pdf->SetFont('Arial', '', 10);
        $pdf->Ln(14);
        $pdf->Cell(70, 5, utf8_decode('Jr. Pataz Nº 1243 Mz. Q Lt. 30'), 0, 0, 'R');
        $pdf->Cell(40, 5, "", 0, 0, 'C');
        $pdf->Cell(80, 5, utf8_decode('Cta. Cte. BBVA Soles:0011-0342-38-0100024845'), 0, 0, 'L');
        $pdf->Ln(4);
        $pdf->Cell(70, 5, utf8_decode('2do Piso. Urb. Covida II Etapa'), 0, 0, 'R');
        $pdf->Cell(40, 5, "", 0, 0, 'C');
        $pdf->Cell(80, 5, utf8_decode('Cta. Cte. BBVA Dólares:0011-0312-01-0000896'), 0, 0, 'L');
        $pdf->Ln(4);
        $pdf->Cell(70, 5, utf8_decode('Los Olivos - Lima'), 0, 0, 'R');
        $pdf->Cell(40, 5, "", 0, 0, 'C');
        $pdf->Cell(80, 5, utf8_decode('TELF.: 4851187 CEL.: 968 871 841'), 0, 0, 'L');
        $pdf->Ln(4);
        $pdf->Cell(70, 5, utf8_decode('Referencia: En paralelo con'), 0, 0, 'R');
        $pdf->Cell(40, 5, "", 0, 0, 'C');
        $pdf->Cell(80, 5, utf8_decode('tecnologia.medica.corporation@gmail.com'), 0, 0, 'L');
        $pdf->Ln(4);
        $pdf->Cell(70, 5, utf8_decode('Av. Antunez de Mayolo'), 0, 0, 'R');
        $pdf->Cell(40, 5, "", 0, 0, 'C');
        $pdf->Cell(80, 5, utf8_decode('ventas@tecnologiamedicacorporation.com'), 0, 0, 'L');
        $pdf->Ln(4);
        $pdf->Cell(70, 5, utf8_decode('(a espaldas del Banco Scotiabank)'), 0, 0, 'R');
        $pdf->Cell(40, 5, "", 0, 0, 'C');
        $pdf->Cell(80, 5, utf8_decode('www.tecnologiamedicacorporation.com'), 0, 0, 'L');


        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(12);
        $pdf->SetTextColor(68, 68, 68);

        $pdf->Cell(40, 6, utf8_decode('Nombre/Razón Social: '), 0, 0, 'L');
        $pdf->Cell(95, 6, "", 0, 0, 'L');
        $pdf->Cell(33, 6, utf8_decode('DNI N°:'), 0, 0, 'L');
        $pdf->Cell(27, 6, utf8_decode($data->docum), 0, 0, 'L');
        $pdf->setX(50);
        $pdf->MultiCell(90, 4,  utf8_decode($data->cliente),  0, 'L');
        $pdf->setY($pdf->GetY() - 4);
        //$pdf->Cell(130, 6, utf8_decode($data->partida_ubigeo . " " . $data->partida_direccion), 0, 0, 'L');
        $pdf->Ln(8);
        $pdf->Cell(40, 6, utf8_decode('Dirección: '), 0, 0, 'L');
        $pdf->Cell(95, 6, "", 0, 0, 'L');
        $pdf->Cell(33, 6, utf8_decode('Fecha de Emisión: '), 0, 0, 'L');
        $date = new DateTime($data->fecha);
        $pdf->Cell(27, 6, utf8_decode($date->format('d/m/Y')), 0, 0, 'L');
        $pdf->setX(50);
        $pdf->MultiCell(90, 4,  utf8_decode($data->direccion),  0, 'L');
        $pdf->setY($pdf->GetY() - 4);

        $pdf->Ln(6);
        $pdf->Cell(40, 6, utf8_decode('Moneda: '), 0, 0, 'L');
        $pdf->Cell(95, 6, $data->codigo_moneda, 0, 0, 'L');
        $pdf->Cell(33, 6, utf8_decode('Fecha de Vencimiento:'), 0, 0, 'L');
        $pdf->Cell(27, 6, utf8_decode($vencimiento), 0, 0, 'L');

        $pdf->Ln(6);
        $pdf->Cell(40, 6, ($data->tipo_venta == "PRODUCTOS") ? 'Orden de Compra:' : 'Orden de Servicio:', 0, 0, 'L');
        $pdf->Cell(95, 6, $data->orden_servicio, 0, 0, 'L');
        $pdf->Cell(33, 6, utf8_decode('Forma de Pago:'), 0, 0, 'L');
        $pdf->Cell(27, 6, utf8_decode($data->metodo_pago), 0, 0, 'L');


        $pdf->SetFillColor(153, 153, 153);
        $pdf->SetTextColor(68, 68, 68);

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Ln(10);
        $pdf->Cell(15, 6, utf8_decode('Item.'), 1, 0, 'L', true);
        $pdf->Cell(20, 6, utf8_decode('Código'), 1, 0, 'L', true);
        $pdf->Cell(85, 6, utf8_decode('Descripción'), 1, 0, 'L', true);
        $pdf->Cell(15, 6, utf8_decode('U.M. '), 1, 0, 'L', true);
        $pdf->Cell(15, 6, utf8_decode('Cantidad'), 1, 0, 'L', true);
        $pdf->Cell(20, 6, utf8_decode('Precio'), 1, 0, 'L', true);
        $pdf->Cell(25, 6, utf8_decode('Total'), 1, 0, 'L', true);
        //$pdf->Ln();
        $pdf->SetTextColor(68, 68, 68);
        //contenido tablas
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetX(5);
        $f = 1;
        $subtotal = 0;
        $total = 0;
        $pdf->Ln(6);
        $pdf->SetWidths(array(15, 20, 90, 15, 15, 20, 25));
        $pdf->SetAligns(array('C', 'L', 'L', 'C', 'C', 'R', 'R'));
        foreach ($prods->result() as $pro) {
            if (!isset($pro->unidad_medida)) {
                $pro->unidad_medida = 'ZZ';
            }
            $pdf->SetX(5);
            $pdf->Row(array($f, utf8_decode($pro->codigo_producto), utf8_decode($pro->nombre_producto), utf8_decode($pro->unidad), round($pro->cantidad, 2), number_format($pro->precio_unidad, 2), number_format($pro->total, 2)));
            $f = $f + 1;
            $subtotal += $pro->subtotal;
            $total += $pro->total;
        }
        $pdf->SetFont('Arial', '', 10);
        $pdf->Ln(7);
        $pdf->Cell(95, 6, "", 0, 0, 'L');
        $pdf->Cell(40, 6, utf8_decode('Op. Gravada'), 0, 0, 'L');
        $pdf->Cell(10, 6, utf8_decode($data->codigo_moneda), 0, 0, 'L');
        $pdf->Cell(50, 6, number_format($subtotal, 2), 0, 0, 'R');

        $pdf->Ln(6);
        $pdf->Cell(95, 6, "", 0, 0, 'L');
        $pdf->Cell(40, 6, utf8_decode('I.G.V. (18%)'), 0, 0, 'L');
        $pdf->Cell(10, 6, utf8_decode($data->codigo_moneda), 0, 0, 'L');
        $pdf->Cell(50, 6, number_format($total - $subtotal, 2), 0, 0, 'R');

        $pdf->Ln(6);
        $pdf->Cell(95, 6, "", 0, 0, 'L');
        $pdf->Cell(40, 6, utf8_decode('Op. Inafecta'), 0, 0, 'L');
        $pdf->Cell(10, 6, utf8_decode($data->codigo_moneda), 0, 0, 'L');
        $pdf->Cell(50, 6, "0.00", 0, 0, 'R');

        $pdf->Ln(6);
        $pdf->Cell(95, 6, "", 0, 0, 'L');
        $pdf->Cell(40, 6, utf8_decode('Op. Exonerada'), 0, 0, 'L');
        $pdf->Cell(10, 6, utf8_decode($data->codigo_moneda), 0, 0, 'L');
        $pdf->Cell(50, 6, "0.00", 0, 0, 'R');

        $pdf->Ln(6);
        $pdf->Cell(95, 6, "", 0, 0, 'L');
        $pdf->Cell(40, 6, utf8_decode('Op. Exportación'), 0, 0, 'L');
        $pdf->Cell(10, 6, utf8_decode($data->codigo_moneda), 0, 0, 'L');
        $pdf->Cell(50, 6, "0.00", 0, 0, 'R');

        $pdf->Ln(6);
        $pdf->Cell(95, 6, "", 0, 0, 'L');
        $pdf->Cell(40, 6, utf8_decode('Importe Total'), 0, 0, 'L');
        $pdf->Cell(10, 6, utf8_decode($data->codigo_moneda), 0, 0, 'L');
        $pdf->Cell(50, 6, number_format($total, 2), 'T', 0, 'R');



        $CI = &get_instance();
        $CI->load->library('numero_a_letras');
        $numero_letra = $CI->numero_a_letras->convert($total, $this->_moneda[$data->codigo_moneda], TRUE);
        $pdf->Ln(10);
        $pdf->Cell(10, 6, utf8_decode('SON:'), 0, 0, 'L');
        $pdf->MultiCell(185, 6,  utf8_decode($numero_letra),  0, 'L');
        $pdf->setY($pdf->GetY() - 6);

        $pdf->SetFont('Arial', '', 8);
        $pdf->Ln(6);
        $pdf->Cell(50, 6, utf8_decode('Observaciones de SUNAT:'), 0, 0, 'L');
        $pdf->MultiCell(140, 6,  utf8_decode("El comprobante numero " . $data->serie . " - " . $data->numero . " se encuentra " . ($data->estado_api != NULL ? $data->estado_api : 'registrado')),  0, 'L');
        $pdf->setY($pdf->GetY() - 6);

        $pdf->Ln(6);
        $pdf->Cell(50, 6, utf8_decode('Observaciones comprobante:'), 0, 0, 'L');
        $pdf->MultiCell(140, 6,  utf8_decode($data->observacion),  0, 'L');
        $pdf->setY($pdf->GetY() - 6);

        $pdf->SetFont('Arial', '', 10);
        $pdf->Ln(6);
        $pdf->Cell(50, 6, utf8_decode('Información Adicional'), 0, 0, 'L');


        $pdf->Ln(8);
        $pdf->Cell(5, 6, "2", 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode('Guía de Remisión'), 1, 0, 'L');
        $pdf->Cell(145, 6, utf8_decode($data->guia_remision), 1, 0, 'L');
        $pdf->setY($pdf->GetY() + 10);


        $pdf->output('', $data->serie . '-' . $data->numero . "_" . $data->cliente . '.pdf');
    }
    public function reporte_nota_credito_factura_A4($data, $prods)
    {
        $pdf = new FPDF($orientation = 'P', $unit = 'mm', 'A4');
        $pdf->footer = true;
        $pdf->AddPage();
        $pdf->SetAutoPageBreak(true, 30);
        $pdf->SetFont('Arial', '', 20);
        if ($data->vencimiento === null || $data->vencimiento === "") {
            $vencimiento = "";
        } else {
            $vencimiento = new DateTime($data->vencimiento);
            $vencimiento = $vencimiento->format('d/m/Y');
        }
        $pdf->setY(7);
        $pdf->setX(5);
        $pdf->Cell(15, 10, $pdf->Image('images/foto1.jpg', $pdf->GetX(), $pdf->GetY(), 120), 0, 0, 'C');
        $pdf->setX(80);
        $pdf->setY(44);
        $pdf->Cell(72, 10, "", 0, 0, 'C');
        $pdf->Cell(15, 10, $pdf->Image('images/foto2.png', $pdf->GetX(), $pdf->GetY(), 27), 0, 0, 'C');
        $pdf->Rect(125, 5, 78, 39, 'D');
        $pdf->setX(0);
        $pdf->setY(7);
        $pdf->SetTextColor(94, 94, 94);
        $pdf->Cell(115, 7, "", 0, 0, 'L');
        $pdf->Cell(78, 7, utf8_decode('RUC: 20546439268'), 0, 0, 'C');
        $pdf->Ln(10);
        $pdf->Cell(115, 7, "", 0, 0, 'L');
        $pdf->Cell(78, 7, utf8_decode('NOTA DE CRÉDITO'), 0, 0, 'C');
        $pdf->Ln();
        $pdf->Cell(115, 7, "", 0, 0, 'L');
        $pdf->Cell(78, 7, utf8_decode('ELECTRÓNICA'), 0, 0, 'C');
        $pdf->Ln(10);
        $pdf->Cell(115, 7, "", 0, 0, 'L');
        $pdf->Cell(78, 7, $data->serie_nota . ' - ' . str_pad($data->numero_nota, 8, "0", STR_PAD_LEFT), 0, 0, 'C');

        $pdf->SetFont('Arial', '', 8.8);
        $pdf->Ln(12);
        $pdf->Cell(55, 4, utf8_decode('Jr. Pataz Nº 1243 Mz. Q Lt. 30'), 0, 0, 'R');
        $pdf->Cell(60, 4, "", 0, 0, 'C');
        $pdf->Cell(78, 4, utf8_decode('Cta. Cte. BBVA Soles:0011-0342-38-0100024845'), 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(55, 4, utf8_decode('2do Piso. Urb. Covida I Etapa'), 0, 0, 'R');
        $pdf->Cell(60, 4, "", 0, 0, 'C');
        $pdf->Cell(78, 4, utf8_decode('Cta. Cte. BBVA Dólares:0011-0312-01-0000896'), 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(55, 4, utf8_decode('Los Olivos - Lima'), 0, 0, 'R');
        $pdf->Cell(60, 4, "", 0, 0, 'C');
        $pdf->Cell(78, 4, utf8_decode('Telf:  +511  485-1187 Cel: +51 968-871-841'), 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(55, 4, utf8_decode('Referencia: En paralelo con'), 0, 0, 'R');
        $pdf->Cell(60, 4, "", 0, 0, 'C');
        $pdf->Cell(78, 4, utf8_decode('tecnologia.medica.corporation@gmail.com'), 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(55, 4, utf8_decode('Av. Antunez de Mayolo'), 0, 0, 'R');
        $pdf->Cell(60, 4, "", 0, 0, 'C');
        $pdf->Cell(78, 4, utf8_decode('cotizaciones1@viatmc.com'), 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(55, 4, utf8_decode('(a espaldas del Banco Scotiabank)'), 0, 0, 'R');
        $pdf->Cell(60, 4, "", 0, 0, 'C');
        $pdf->Cell(78, 4, utf8_decode('www.viatmc.com'), 0, 0, 'L');



        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->SetTextColor(68, 68, 68);
        $pdf->SetX(5);
        $pdf->Cell(45, 4, utf8_decode('Nombre/Razón Social: '), 0, 0, 'L');
        $pdf->Cell(82, 4, "", 0, 0, 'L');
        $pdf->Cell(38, 4, utf8_decode('RUC N°:'), 0, 0, 'L');
        $pdf->Cell(27, 4, utf8_decode($data->docum), 0, 0, 'L');
        $pdf->setX(50);
        $pdf->MultiCell(82, 4,  utf8_decode($data->cliente),  0, 'L');
        $pdf->setY($pdf->GetY() - 4);
        //$pdf->Cell(130, 6, utf8_decode($data->partida_ubigeo . " " . $data->partida_direccion), 0, 0, 'L');
        $pdf->Ln(4);
        $pdf->SetX(5);
        $pdf->Cell(45, 4, utf8_decode('Dirección: '), 0, 0, 'L');
        $pdf->Cell(82, 4, "", 0, 0, 'L');
        $pdf->Cell(38, 4, utf8_decode('Fecha de Emisión: '), 0, 0, 'L');
        $date = new DateTime($data->fecha);
        $pdf->Cell(27, 4, utf8_decode($date->format('d/m/Y')), 0, 0, 'L');
        $pdf->setX(50);
        $pdf->MultiCell(82, 4,  utf8_decode($data->direccion),  0, 'L');
        $pdf->setY($pdf->GetY() - 4);

        $pdf->Ln(4);
        $pdf->SetX(5);
        $pdf->Cell(45, 4, utf8_decode('Moneda: '), 0, 0, 'L');
        $pdf->Cell(82, 4, $data->codigo_moneda, 0, 0, 'L');
        $pdf->Cell(38, 4, utf8_decode('Fecha de Vencimiento:'), 0, 0, 'L');
        $pdf->Cell(27, 4, utf8_decode($vencimiento), 0, 0, 'L');

        $pdf->Ln(4);
        $pdf->SetX(5);
        $pdf->Cell(45, 4, ($data->tipo_venta == "PRODUCTOS") ? 'Orden de Compra:' : 'Orden de Servicio:', 0, 0, 'L');
        $pdf->Cell(82, 4, $data->orden_servicio, 0, 0, 'L');
        $pdf->Cell(38, 4, utf8_decode('Forma de Pago:'), 0, 0, 'L');
        $pdf->Cell(27, 4, utf8_decode($data->metodo_pago), 0, 0, 'L');

        $descripcion_tipo_nota = "";
        switch ($data->tipo_nota) {
            case "01":
                $descripcion_tipo_nota = "ANULACION DE LA OPERACION";
                break;
            case "02":
                $descripcion_tipo_nota = "ANULACION POR ERROR EN EL RUC";
                break;
            case "03":
                $descripcion_tipo_nota = "CORRECCION POR ERROR EN LA DESCRIPCION";
                break;
            case "04":
                $descripcion_tipo_nota = "DESCUENTO GLOBAL";
                break;
            case "05":
                $descripcion_tipo_nota = "DESCUENTO POR ITEM";
                break;
            case "06":
                $descripcion_tipo_nota = "DEVOLUCION TOTAL";
                break;
            case "07":
                $descripcion_tipo_nota = "DEVOLUCION POR ITEM";
                break;
            case "08":
                $descripcion_tipo_nota = "BONIFICACION";
                break;
            case "09":
                $descripcion_tipo_nota = "DISMINUCION EN EL VALOR";
                break;
        }
        $pdf->Ln(9);
        $pdf->SetX(5);
        $pdf->Cell(45, 4, utf8_decode('DOC. AFECTADO: '), 0, 0, 'L');
        $pdf->Cell(82, 4, $data->serie . "-" . $data->numero, 0, 0, 'L');
        $pdf->Ln(4);
        $pdf->SetX(5);
        $pdf->Cell(45, 4, utf8_decode('TIPO DE NOTA: '), 0, 0, 'L');
        $pdf->Cell(82, 4, utf8_decode($descripcion_tipo_nota), 0, 0, 'L');
        $pdf->Ln(4);
        $pdf->SetX(5);
        $pdf->Cell(45, 4, utf8_decode('DESCRIPCION: '), 0, 0, 'L');
        $pdf->Cell(150, 4, utf8_decode($data->descripcion_nota), 0, 0, 'L');


        $pdf->SetFillColor(153, 153, 153);
        $pdf->SetTextColor(68, 68, 68);

        $pdf->SetFont('Arial', 'B', 9);



        $pdf->Ln(5);
        $pdf->SetX(5);
        $pdf->Cell(15, 6, utf8_decode('Item.'), 1, 0, 'C', true);
        $pdf->Cell(20, 6, utf8_decode('Código'), 1, 0, 'C', true);
        $pdf->Cell(90, 6, utf8_decode('Descripción'), 1, 0, 'C', true);
        $pdf->Cell(15, 6, utf8_decode('U.M. '), 1, 0, 'C', true);
        $pdf->Cell(15, 6, utf8_decode('Cantidad'), 1, 0, 'C', true);
        $pdf->Cell(20, 6, utf8_decode('Precio'), 1, 0, 'C', true);
        $pdf->Cell(25, 6, utf8_decode('Total'), 1, 0, 'C', true);
        //$pdf->Ln();
        $pdf->SetTextColor(68, 68, 68);
        //contenido tablas
        $pdf->SetFont('Arial', '', 8);
        /*
        $pdf->Ln(6);
        $pdf->SetX(5);
         $pdf->SetWidths(array(15, 20, 85, 15, 15, 20, 25));
        $i = 1;
        foreach ($prods->result() as $pro) {
            $pdf->Row(array($i, utf8_decode($pro->codigo_producto), utf8_decode($pro->nombre_producto), utf8_decode($pro->unidad), round($pro->cantidad, 2), number_format($pro->precio_unidad, 2),number_format($pro->total, 2)));
            $i++;
        }

*/
        $pdf->SetX(5);
        $f = 1;
        $subtotal = 0;
        $total = 0;
        $pdf->Ln(6);
        $pdf->SetWidths(array(15, 20, 90, 15, 15, 20, 25));
        $pdf->SetAligns(array('C', 'C', 'L', 'C', 'C', 'R', 'R'));
        foreach ($prods->result() as $pro) {
            if (!isset($pro->unidad_medida)) {
                $pro->unidad_medida = 'ZZ';
            }
            $pdf->SetX(5);
            $pdf->Row(array($f, utf8_decode($pro->codigo_producto), utf8_decode($pro->nombre_producto), utf8_decode($pro->unidad), round($pro->cantidad, 2), number_format($pro->precio_unidad, 2), number_format($pro->total, 2)));
            $f = $f + 1;
            $subtotal += $pro->subtotal;
            $total += $pro->total;
        }
        $pdf->SetFont('Arial', '', 10.5);
        $pdf->Ln(5);
        $pdf->Cell(105, 5, "", 0, 0, 'L');
        $pdf->Cell(30, 5, utf8_decode('Op. Gravada'), 0, 0, 'L');
        $pdf->Cell(10, 5, utf8_decode($data->codigo_moneda), 0, 0, 'L');
        $pdf->Cell(50, 5, number_format($subtotal, 2), 0, 0, 'R');

        $pdf->Ln(5);
        $pdf->Cell(105, 5, "", 0, 0, 'L');
        $pdf->Cell(30, 5, utf8_decode('I.G.V. (18%)'), 0, 0, 'L');
        $pdf->Cell(10, 5, utf8_decode($data->codigo_moneda), 0, 0, 'L');
        $pdf->Cell(50, 5, number_format($total - $subtotal, 2), 0, 0, 'R');

        $pdf->Ln(5);
        $pdf->Cell(105, 5, "", 0, 0, 'L');
        $pdf->Cell(30, 5, utf8_decode('Op. Inafecta'), 0, 0, 'L');
        $pdf->Cell(10, 5, utf8_decode($data->codigo_moneda), 0, 0, 'L');
        $pdf->Cell(50, 5, "0.00", 0, 0, 'R');

        $pdf->Ln(5);
        $pdf->Cell(105, 5, "", 0, 0, 'L');
        $pdf->Cell(30, 5, utf8_decode('Op. Exonerada'), 0, 0, 'L');
        $pdf->Cell(10, 5, utf8_decode($data->codigo_moneda), 0, 0, 'L');
        $pdf->Cell(50, 5, "0.00", 0, 0, 'R');

        $pdf->Ln(5);
        $pdf->Cell(105, 5, "", 0, 0, 'L');
        $pdf->Cell(30, 5, utf8_decode('Op. Exportación'), 0, 0, 'L');
        $pdf->Cell(10, 5, utf8_decode($data->codigo_moneda), 0, 0, 'L');
        $pdf->Cell(50, 5, "0.00", 0, 0, 'R');

        $pdf->Ln(5);
        $pdf->Cell(105, 5, "", 0, 0, 'L');
        $pdf->Cell(30, 5, utf8_decode('Importe Total'), 0, 0, 'L');
        $pdf->Cell(10, 5, utf8_decode($data->codigo_moneda), 0, 0, 'L');
        $pdf->Cell(50, 5, number_format($total, 2), 'T', 0, 'R');



        $CI = &get_instance();
        $CI->load->library('numero_a_letras');
        $numero_letra = $CI->numero_a_letras->convert($total, $this->_moneda[$data->codigo_moneda], TRUE);
        $pdf->Ln(7);
        $pdf->SetX(5);
        $pdf->Cell(10, 6, utf8_decode('SON:'), 0, 0, 'L');
        $pdf->MultiCell(185, 6,  utf8_decode($numero_letra),  0, 'L');
        $pdf->setY($pdf->GetY() - 6);

        $pdf->SetFont('Arial', '', 10);
        $pdf->Ln(6);
        $pdf->SetX(5);
        $pdf->Cell(50, 6, utf8_decode('Información Adicional:'), 0, 0, 'L');

        /*

        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->SetX(5);
        $pdf->Cell(50, 6, utf8_decode('Observación'), 1, 0, 'L');
        $pdf->MultiCell(145, 6,  utf8_decode("El comprobante numero " . $data->serie . " - " . $data->numero . " se encuentra " . ($data->estado_api != NULL ? $data->estado_api : 'registrado') . " por SUNAT. " . $data->observacion),  1, 'L');
        $pdf->setY($pdf->GetY() - 6);

        // $pdf->Ln(6);
        // $pdf->Cell(50, 6, utf8_decode('Observaciones comprobante:'), 0, 0, 'L');
        //$pdf->MultiCell(140, 6,  utf8_decode($data->observacion),  0, 'L');
        // $pdf->setY($pdf->GetY() - 6);
*/


        $pdf->Ln(6);
        $pdf->SetX(5);
        $pdf->Cell(5, 6, "1", 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode('Guía de Remisión'), 1, 0, 'L');
        $pdf->Cell(150, 6, utf8_decode($data->guia_remision), 1, 0, 'L');


        $pdf->Ln(6);
        $pdf->SetX(5);
        $pdf->Cell(5, 6, "2", 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode('Observación'), 1, 0, 'L');
        $pdf->MultiCell(150, 6,  utf8_decode("El comprobante numero " . $data->serie_nota . " - " . str_pad($data->numero_nota, 8, "0", STR_PAD_LEFT) . " se encuentra " . ($data->estado_api != NULL ? $data->estado_api : 'registrado') . " por SUNAT. " . $data->observacion),  1, 'L');
        $pdf->setY($pdf->GetY() + 10);


        $pdf->output('', $data->serie_nota . '-' . str_pad($data->numero_nota, 8, "0", STR_PAD_LEFT) . "_" . $data->cliente . '.pdf');
    }


    public function reporte_validez_sunat($data, $datos)
    {
        $pdf = new FPDF($orientation = 'P', $unit = 'mm', 'A4');
        //$pdf->footer = true;
        $pdf->AddPage();
        $pdf->SetAutoPageBreak(true, 30);
        $pdf->SetFont('Helvetica', 'B', 15);
        $pdf->SetFillColor(51, 153, 204);
        $pdf->SetDrawColor(51, 153, 204);
        $pdf->Rect(53, 6, 104, 14, 'D');
        $pdf->Rect(54, 7, 102, 12, 'DF');
        $pdf->setX(0);
        $pdf->setY(8);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(190, 5.5, utf8_decode("Consulta Validez del Comprobante de"), 0, 0, 'C');
        $pdf->Ln(5.5);
        $pdf->Cell(190, 5.5, utf8_decode("Pago Electrónico"), 0, 0, 'C');
        $pdf->Ln(10);
        if($data["comprobante"]=="Nota de Crédito")
        {
            $datos->serie=$datos->serie_nota;
            $datos->numero=str_pad($datos->numero_nota, 8, "0", STR_PAD_LEFT);
        }
        $pdf->SetFont('Helvetica', 'B', 8.5);
        $pdf->Cell(44, 4.5, "", 0, 0, 'C');
        $pdf->SetFillColor(182, 203, 235);
        $pdf->SetDrawColor(182, 203, 235);
      
        $pdf->Cell(102, 4.5, utf8_decode("Resultado de la Consulta"), 0, 0, 'L',true);
        $pdf->Ln(4.5);
        $pdf->Cell(44, 4.5, "", 0, 0, 'C');
        $pdf->MultiCell(102, 3.8, utf8_decode("La ".$data["comprobante"]." Electrónica ".$datos->serie."-".$datos->numero." es un comprobante de pago válido."), 1, 'L');
        $pdf->Ln(10);

        $pdf->SetDrawColor(51, 153, 204);
        $pdf->Rect(53, 22.5, 104, 14, 'D');


        $pdf->output('', 'SUNAT-'.$datos->serie . '-' . $datos->numero . "_" . $datos->cliente . '.pdf');
    }
    private $_moneda = array(
        'PEN' => 'SOLES',
        'USD' => 'DÓLARES AMERICANOS'
    );
}
