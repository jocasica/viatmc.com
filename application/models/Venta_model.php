<?php

class Venta_model extends CI_Model
{
    private $tabla = 'venta';

    public function getCorrelativo($tipo, $serie)
    {
        return $this->db->query("SELECT CASE WHEN MAX(numero) IS NULL THEN LPAD(1, 8, '0') ELSE LPAD(MAX(numero)+1, 8, '0') END AS numero FROM " . $tipo . " WHERE serie= '" . $serie . "'")->row();
    }

    /**
     * Filtrar los números de serie obtenidos del query
     *
     * @param string $type
     * @return array
     */
    // public function getSeriesData($type = null): array
    public function getSeriesData($type = null)
    {
        return array_map(static function ($a) {
            return $a[0];
        }, mysqli_fetch_all($this->getSeriesNumbers($type)));
    }

    /**
     * Obtener todos los números de serie de acorde al estado de la cookie
     * @param bool $ignoreCookies
     * @param string $type
     * @return bool|mysqli_result
     */
    public function getSeriesNumbers($type = null)
    {
        $sqlFacturas = "SELECT DISTINCT serie FROM factura";
        $sqlBoletas = "SELECT DISTINCT serie FROM boleta";

        if ($type !== null) {
            if ($type === 'boleta') {
                $sql = $sqlBoletas;
            } else {
                $sql = $sqlFacturas;
            }
        } else {
            $sql = $this->createQueryForSales($sqlFacturas, $sqlBoletas, true);
        }

        return mysqli_query($this->getDatabaseConnection(), $sql);
    }

    /**
     * Crear y unir los queries de facturas y boletas dependiendo del status de la cookie actual
     *
     * @param $sqlFacturas
     * @param $sqlBoletas
     * @param bool $ignoredCookies
     * @return string
     */
    private function createQueryForSales($sqlFacturas, $sqlBoletas, $ignoredCookies = true)
    {
        $tipoComprobante = ($ignoredCookies) ? 'all' : $this->getTipoComprobante();

        if ($tipoComprobante === 'all') {
            $sql = $sqlFacturas . " UNION " . $sqlBoletas;
        } elseif ($tipoComprobante === 'factura') {
            $sql = $sqlFacturas;
        } elseif ($tipoComprobante === 'boleta') {
            $sql = $sqlBoletas;
        }

        // return $sql ?? '';

        $resultSql = $sql ?? "";
        return $resultSql;
    }

    /**
     * Obtener el tipo de comprobante actual mediante la cookie
     * @return string
     */
    private function getTipoComprobante()
    {
        return isset($_COOKIE['tipoComprobante']) ? strtolower($_COOKIE['tipoComprobante']) : 'all';
    }

    /**
     * Obtener la conexión de la base de datos actual
     * @return false|mysqli
     */
    private function getDatabaseConnection()
    {
        return mysqli_connect($this->db->hostname, $this->db->username, $this->db->password, $this->db->database);
    }

    /**
     * Obtener todas las ventas actuales pasando como parámetro $ignoreCookie para contemplar el caso del Dashboard donde
     * no es necesario hacer el filtro si no ahí se requiere obtener el valor completo, $ignoreCookie habilita
     * el filtro por tipo de comprobante y número de serie generados por la cookie
     *
     * @param bool $ignoreCookie
     * @return bool|mysqli_result
     */
    public function getVentas($ignoreCookie = true)
    {
        $condition =  isset($_COOKIE['serieNumber']) && $_COOKIE['serieNumber'] !== 'all' ? " WHERE f.serie = '" . $_COOKIE['serieNumber'] . "' " : '';
        $sqlFacturas = "
        SELECT 
        f.id factura_id, 
        f.fecha fecha_sunat,
        CONCAT(u.first_name, ' ', u.last_name) as vendedor_name,
        v.codigo_moneda, 
        f.fecha fecha_emision, 
        f.cliente, 
        f.ruc, 
        f.estado_sunat,
        v.id, 
        f.serie, 
        LPAD(f.numero, 8, '0') numero,
        v.guia_remision,
        f.estado ,f.xml_link,f.cdr_link,f.pdf_link,
        v.created_at fecha, 
        SUM(vp.total) total, 
        f.envio, f.id id_doc, 
        'factura' tipo,
        estado_api,f.external_id,v.guia_remision_numeros,f.estado_sunat
        FROM venta v
        INNER JOIN users u ON u.id=v.users_id
        INNER JOIN factura f ON f.venta_id=v.id
        INNER JOIN venta_producto vp ON vp.venta_id=v.id " . $condition . "
        GROUP BY v.id, f.serie, LPAD(f.numero, 8, '0'), f.estado, v.created_at, f.envio, f.id";

        $sqlBoletas = "
        SELECT f.id factura_id, 
        f.fecha fecha_sunat, 
        CONCAT(u.first_name, ' ', u.last_name) as vendedor_name, 
        v.codigo_moneda, 
        f.estado_sunat,
        f.fecha fecha_emision, 
        f.cliente, 
        f.dni as ruc,  
        v.id, f.serie, 
        LPAD(f.numero, 8, '0') numero,
        v.guia_remision,
        f.estado, v.created_at fecha ,f.xml_link,f.cdr_link,f.pdf_link,
        SUM(vp.total) total, 
        f.envio, f.id id_doc, 
        'boleta' tipo,
        estado_api,f.external_id,v.guia_remision_numeros,f.estado_sunat
        FROM venta v
        INNER JOIN users u ON u.id=v.users_id
        INNER JOIN boleta f ON f.venta_id=v.id
        INNER JOIN venta_producto vp ON vp.venta_id=v.id " . $condition . "
        GROUP BY v.id, f.serie, LPAD(f.numero, 8, '0') , f.estado, v.created_at ,f.envio, f.id";

        $sql = $this->createQueryForSales($sqlFacturas, $sqlBoletas, $ignoreCookie);
        $orderBy = " order by fecha desc";
        $sql .= $orderBy;

        return mysqli_query($this->getDatabaseConnection(), $sql); //$this->db->query("select v.id, f.serie, LPAD(f.numero, 8, '0') numero, f.estado, v.created_at fecha, sum(vp.total) total from venta v inner join factura f on f.venta_id=v.id inner join venta_producto vp on vp.venta_id=v.id group by (v.id) union select v.id, f.serie, LPAD(f.numero, 8, '0') numero, f.estado, v.created_at fecha, sum(vp.total) total from venta v inner join boleta f on f.venta_id=v.id inner join venta_producto vp on vp.venta_id=v.id group by (v.id) order by fecha desc Limit $start");
    }
    public function getVentaById($id) {
        $this->db->select('f.*');
        $this->db->where('f.venta_id', $id);
        $res = $this->db->get('factura f');
        return $res->row();
    }
    public function getVentaGeneralById($id) {
        $this->db->select('*');
        $this->db->where('id', $id);
        $res = $this->db->get('venta');
        return $res->row();
    }

    public function getDetalleVentaById($id) {
        $this->db->select('vp.*,um.descripcion as unidad_medidad_descripcion');
        $this->db->from('venta_producto vp');
        $this->db->join('producto p','p.id=vp.producto_id','LEFT');
        $this->db->join('unidad_medida um','um.id=p.unidad_medida_id','LEFT');
        $this->db->where('vp.venta_id', $id);
        return $this->db->get()->result();
        
        //print_r($this->db->last_query());
    }
    public function getFacturaNotaCreditoById($id) {
        $this->db->select('fnc.*');
        $this->db->where('fnc.venta_id', $id);
        $res = $this->db->get('factura_nota_credito fnc');
        return $res->row();
    }
    public function registrarNotaCredito($data) {
        $this->db->insert('factura_nota_credito', $data);
        return $this->db->insert_id();
    }
    public function getAllNotasCredito() {
        $this->db->select('nc.*, CONCAT(u.first_name, " ", u.last_name) as vendedor_name,nc.external_id, v.guia_remision, "factura" tipo, v.total, v.codigo_moneda,v.id as venta_id');
        $this->db->join('venta v', 'v.id = nc.venta_id');
        $this->db->join('users u', 'u.id = v.users_id');
        $this->db->order_by('nc.id','DESC');
        $res = $this->db->get('factura_nota_credito nc');
        return $res->result();
    }


    public function getCotizacion_Producto_ById($id)
    {
        return $this->db->query("SELECT pc.id, p.id as producto_id, pc.serie as serie, pc.marca as marcaproducto, pc.procedencia as procedenciaproducto,
										pc.image1 as imagen1, pc.image2 as imagen2, pc.precioproducto as precioproducto, pc.cantidad as cantidad,
										pc.validezOferta as validezOferta, pc.entrega as entrega, pc.formaPago as formaPago, pc.garantiaMeses as garantiaMeses,
										pc.montoproducto as montoproducto, pc.producto_descripcion as producto_descripcion, pc.created_at,
										p.unidad_medida_id as medida, p.nombre as nombre, p.precio_venta as precio, NULL as características
									FROM producto_cotizacion pc
									RIGHT JOIN producto p ON p.id = pc.id_producto 
									WHERE pc.cotizacion_id = $id AND p.id IS NOT NULL");
    }
    public function getCaracteristicasProductoCotizacionById($id) {
        $this->db->select('caracteristica');
        $this->db->where('producto_cotizacion_id', $id);
        $res = $this->db->get('producto_cotizacion_caracteristica');
        return $res->result();
    }
    public function getCotizacionDetalleProductosById($id) {
        $this->db->select('cp.*, p.nombre');
        $this->db->where('cp.cotizacion_id', $id);
        $this->db->join('producto p', 'cp.id_producto = p.id');
        $res = $this->db->get('cotizacion_producto cp');
        return $res->result();
    }
    public function getCotizacionDetalleProductosVerificacionById($id) {
        $this->db->select('cp.*, p.nombre, p.tipo_registro_producto');
        $this->db->where('cp.cotizacion_id', $id);
        $this->db->join('producto p', 'cp.id_producto = p.id');
        $res = $this->db->get('cotizacion_producto cp');
        return $res->result();
    }
    public function eliminarProductosDetalleCotizacionById($id) {
        $this->db->where('cotizacion_id', $id);
        return $this->db->delete('cotizacion_producto');
    }
    public function getProductosCotizacionDetalleById($id) {
        $this->db->select('pc.*');
        $this->db->where('cp.cotizacion_id', $id);
        $this->db->join('producto_cotizacion pc', 'cp.producto_cotizacion_id = pc.id');
        $this->db->join('producto p', 'cp.producto_id = p.id');
        $res = $this->db->get('cotizacion_producto cp');
        if ($res->num_rows() > 0) {
            $response = array();
            foreach($res->result() as $r) {
                $aux                    = (array)$r;
                $aux['caracteristicas'] = $this->getCaracteristicasProductoCotizacionById($r->id);
                array_push($response, $aux);
            }
            return $response;
        }
        return [];
    }
    public function getCotizacion_Producto()
    {
        return $this->db->query("SELECT cp.producto_descripcion, p.id as pId, p.nombre, p.unidad_medida_id as medida, cp.cantidad, p.precio_venta as precio, p.precio_venta*cp.cantidad as monto, cp.cotizacion_id, cp.created_at, cp.validezOferta, cp.formaPago, cp.garantiaMeses, cp.entrega FROM producto p inner join cotizacion_producto cp on p.id = cp.producto_id");
    }

    public function crearCotizacionProducto($cp) {
        $re = $this->db->insert('cotizacion_producto', $cp);
        return $re;
    }

    public function crearCotizacionServicio($vp)
    {
        $re = $this->db->insert('cotizacion_servicio', $vp);
        return $re;
    }

    public function getDatosTicket($cotizacion_id)
    {
        $result = $this->db->query("SELECT * FROM cotizacion c WHERE c.id=" . $cotizacion_id);
        return $result->row();
    }

    public function getDatosRemision($cotizacion_id)
    {
        $result = $this->db->query("SELECT * FROM remision c WHERE c.id=" . $cotizacion_id);
        return $result->row();
    }

    public function getProductosCotizacion($cotizacion_id)
    {
        return $this->db->query("SELECT p.*, pr.nombre, pr.serie
        FROM cotizacion c
        INNER JOIN producto_cotizacion p ON p.cotizacion_id = c.id
        INNER JOIN producto pr ON pr.id = p.id_producto
        WHERE c.id = " . $cotizacion_id);
    }

    public function getProductosRemision($cotizacion_id)
    {

        return $this->db->query("SELECT p.*
        FROM remision c
        INNER JOIN remision_producto p ON p.remision_id = c.id
        WHERE c.id = " . $cotizacion_id);
    }

    public function getServiciosCotizacion($cotizacion_id)
    {
        return $this->db->query("SELECT cp.*
            FROM cotizacion c
            INNER JOIN cotizacion_servicio cp ON c.id = cp.cotizacion_id
            LEFT JOIN servicio pr on pr.id = cp.servicio_id
            WHERE c.id =" . $cotizacion_id);
    }

    public function getNotasCredito()
    {
        return $this->db->query("select v.id, f.serie, LPAD(f.numero, 8, '0') numero, f.estado, v.created_at fecha, sum(vp.total) total from venta v inner join nota_credito f on f.venta_id=v.id inner join venta_producto vp on vp.venta_id=v.id group by (v.id) order by fecha desc limit 400");
    }

    public function getCotizacionId($id) {
        $this->db->select('co.*, cl.nombre_cliente, ve.nombre_vendedor');
        $this->db->where('co.id', $id);
        $this->db->join('cliente cl', 'cl.id = co.cliente_id');
        $this->db->join('vendedor ve', 've.id = co.vendedor_id');
        $res = $this->db->get('cotizacion co');
        return $res->row();
    }

    public function getNotasDebito()
    {
        return $this->db->query("select v.id, f.serie, LPAD(f.numero, 8, '0') numero, f.estado, v.created_at fecha, sum(vp.total) total from venta v inner join nota_debito f on f.venta_id=v.id inner join venta_producto vp on vp.venta_id=v.id group by (v.id) order by fecha desc limit 400");
    }

    public function getNumeroFactura()
    {
        $result = $this->db->query("select case when max(numero) IS NULL then LPAD(1, 8, '0') else LPAD(max(numero)+1, 8, '0') end as numero from factura LIMIT 1");
        return $result->row();
    }

    public function getNumeroBoleta()
    {
        $result = $this->db->query("select case when max(numero) IS NULL then LPAD(1, 8, '0') else LPAD(max(numero)+1, 8, '0') end as numero from boleta LIMIT 1");
        return $result->row();
    }

    public function getUnidadesMedida()
    {
        return $this->db->query("select * from unidad_medida");
    }

    public function getClientesActivos()
    {
        return $this->db->query("select * from cliente where estado = 1 order by nombre");
    }

    public function getProductosActivos()
    {
        return $this->db->query("select * from producto where estado = 1");
    }

    public function getServiciosActivos()
    {
        return $this->db->query("select * from servicio where estado = 1");
    }

    public function getAcabados()
    {
        return $this->db->query("select * from acabado where estado = 1");
    }

    public function getCotizaciones() {
        return $this->db->query("select * from cotizacion ORDER BY id desc");
    }
    public function getCotizacionesByEstado($estado) {
        $this->db->select('*');
        $this->db->from('cotizacion');
        $this->db->order_by('id', 'desc');
        $this->db->where('estado', $estado);
        $res = $this->db->get();
        return $res->result();
    }

    /**
     * Obtener todas las remisiones de acorde de la página actual
     *
     * @return bool|mysqli_result
     */
    public function getRemisiones()
    {
        $sql = " SELECT r.*, CONCAT(f.serie,'-',LPAD(f.numero,6,'0')) factura
            FROM remision r
            LEFT JOIN venta v ON v.remision_id = r.id
            LEFT JOIN factura f ON f.venta_id = v.id
            WHERE r.estado = 1";
        $orderBy = " ORDER BY r.id DESC ";
        $sql .= $orderBy;
        return mysqli_query($this->getDatabaseConnection(), $sql);
    }

    public function getSerieNumeroRemision($id_cotizacon)
    {
        // $sql = " SELECT CONCAT(r.serie,'-',LPAD(r.numero,6,'0'))guia
        // FROM remision r
        // WHERE r.id = ".$id_cotizacon;

        // return mysqli_query($this->getDatabaseConnection(), $sql);

        $query = $this->db->query("SELECT id, serie, numero, CONCAT(r.serie,'-',LPAD(r.numero,8,'0')) guia
        FROM remision r
        WHERE r.id = " . $id_cotizacon);

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    /**
     * Obtener el total de las remisiones actuales
     *
     * @return false|float
     */
    public function getRemisionesRows()
    {
        $conn = mysqli_connect($this->db->hostname, $this->db->username, $this->db->password, $this->db->database);
        $results_per_page = 20;
        $query = "select * from remision where estado = 1";
        $result = mysqli_query($conn, $query);
        $number_of_results = mysqli_num_rows($result);
        $number_of_pages = ceil($number_of_results / $results_per_page);
        return $number_of_pages;
    }

    public function getCotizacionesServicio()
    {
        return $this->db->query("select * from cotizacion where tipo_cotizacion = 'SERVICIO' ORDER BY id desc");
    }

    public function deleteCotizacion($id) {
        return $this->db->query(" DELETE FROM cotizacion WHERE id = " . $id);
    }
    public function deleteDetalleCotizacion($id) {
        return $this->db->query(" DELETE FROM cotizacion_producto WHERE cotizacion_id = " . $id);
    }

    public function getCotizacionFromRemisionId($id)
    {
        return $this->db->query("select id_cotizacion from remision_producto where remision_id = " . $id . " LIMIT 1");
    }

    public function deleteCotizacion_Producto($idC, $idP, $date)
    {
        return $this->db->query(" DELETE FROM producto_cotizacion WHERE cotizacion_id =" . $idC . " and id_producto = " . $idP);
    }

    public function getCodigosInternacionales()
    {
        return $this->db->query("select * from codigo_internacional");
    }

    public function getCotizacionesPendientes()
    {
        return $this->db->query("select * from cotizacion where estado = 1");
    }

    public function getCotizacionesAceptadas()
    {
        return $this->db->query("select * from cotizacion where estado = 2");
    }

    public function getAutorizantes()
    {
        return $this->db->query("select concat(u.first_name,' ',u.last_name) nombre, u.id from users u inner join users_groups ug on u.id = ug.user_id where ug.group_id=5");
    }

    public function getDisenadores()
    {
        return $this->db->query("select concat(u.first_name,' ',u.last_name) nombre, u.id from users u inner join users_groups ug on u.id = ug.user_id where ug.group_id=3");
    }

    public function crearVenta($venta)
    {
        $this->db->insert('venta', $venta);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function crearProducto($p) {
        $this->db->insert('producto', $p);
        return $this->db->insert_id(); # retorna el id del registro creado
    }
    public function actualizarProductoById($id, $p) {
        $this->db->where('id', $id);
        return $this->db->update('producto', $p);
    }

    public function crearProductoCotizacion($p)
    {
        if (!empty($p['id'])) {
            $insert_id = $p['id'];
            unset($p['id']);
            $this->db->where('id', $insert_id);
            $this->db->update('producto_cotizacion', $p);
        } else {
            $this->db->insert('producto_cotizacion', $p);
            $insert_id = $this->db->insert_id();
        }

        return $insert_id;
    }

    public function crearProductoRemision($p)
    {
        $this->db->insert('remision_producto', $p);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function actualizarProductoRemision($id, $p)
    {
        $this->db->where("id", $id);
        $this->db->update('remision_producto', $p);
        return $id;
    }

    public function crearFactura($f)
    {
        $this->db->insert('factura', $f);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function getDocumentFromNumber($num, $type)
    {
        $type = (string) $type;
        $whereType = '';

        if ('false' === $type) {
            $whereType = " AND (tipo_documento = 'ruc' OR tipo_documento = '6')";
        }

        if ('true' === $type) {
            $whereType = " AND (tipo_documento = 'dni' OR tipo_documento = '1')";
        }

        $result = $this->db->query("SELECT * FROM cliente WHERE numero_documento = '$num' $whereType LIMIT 1");

        $result = $result->result();
        $data = null;

        if (!empty($result)) {
            $result = current($result);

            if ('false' === $type) {
                $data = (object) [
                    'data' => [
                        'nombre_o_razon_social' => $result->nombre_cotizacion,
                        'direccion_completa' => $result->direccion ?? '-',
                        'estado' => $result->estado, # estado sunat
                        #'condicion' => $result->condicion_sunat,
                        'nombres' => $result->nombre_cliente, #nombre,
                        'numero' => $result->numero_documento,
                        'sexo' => null,
                    ],
                    'success' => true
                ];
            } else {
                $data = (object) [
                    'data' => [
                        'apellido_materno' => '',
                        'apellido_paterno' => '',
                        'codigo_verificacion' => '1',
                        'fecha_nacimiento' => null,
                        'nombre_completo' => $result->nombre_cotizacion,
                        'nombres' => $result->nombre_cliente, #nombre,
                        'numero' => $result->numero_documento,
                        'sexo' => null,
                    ],
                    'success' => true
                ];
            }
        }
        return $data;
    }

    public function crearBoleta($b)
    {
        $this->db->insert('boleta', $b);
        $boleta_id = $this->db->insert_id();
        $result = $this->db->query("SELECT COUNT(id_resumen_diario)+1 c FROM resumen_diario WHERE fecha='" . $b['fecha'] . "'");
        $_resumen = array(
            'id_resumen_diario' => '',
            'fecha' => $b['fecha'],
            'correlativo' => $result->row()->c
        );
        $this->db->insert('resumen_diario', $_resumen);
        $resumen_id = $this->db->insert_id();
        $this->db->insert(
            'resumen_diario_item',
            array(
                'id_resumen_diario' => $resumen_id,
                'id_boleta' => $boleta_id,
                'tipo' => 1 //emision
            )
        );
        return array(
            'id_boleta' => $boleta_id,
            'id_resumen_diario' => $resumen_id,
            'correlativo' => $result->row()->c
        );
    }

    public function crearVentaProducto($vp)
    {
        $re = $this->db->insert_batch('venta_producto', $vp);
        return $re;
    }

    public function getProductosVenta($venta_id)
    {
        $tipo_venta = $this->db->query("select tipo_venta from venta where id=" . $venta_id)->result();
        if (sizeof($tipo_venta) > 0) {
            $tipo_venta = $tipo_venta[0]->tipo_venta;
        } //end if
        else {
            $tipo_venta = 'PRODUCTOS';
        } //end else

        if ($tipo_venta == "PRODUCTOS") {
            return $this->db->query("select vp.cantidad, '' serie, p.nombre, vp.precio_unidad, vp.subtotal, vp.total FROM venta v inner join venta_producto vp on v.id = vp.venta_id inner join producto p on p.id=vp.producto_id inner join unidad_medida um on um.id = p.unidad_medida_id WHERE v.id=" . $venta_id);
        } else if ($tipo_venta == "SERVICIOS") {
            return $this->db->query("select vp.cantidad, '' serie, vp.texto_ref nombre, vp.precio_unidad, vp.subtotal, vp.total FROM venta v inner join venta_producto vp on v.id = vp.venta_id LEFT join servicio s on s.id=vp.servicio_id WHERE v.id=" . $venta_id);
        }
    }

    public function getProductosVentaA4($venta_id)
    {
        $tipo_venta = $this->db->query("select tipo_venta from venta where id=" . $venta_id)->row()->tipo_venta;
        if ($tipo_venta == "PRODUCTOS") {
            return $this->db->query("select vp.precio_unidad, p.serie, p.marca, p.procedencia, vp.producto_id as codigo_producto, '' serie, vp.cantidad, p.nombre as nombre_producto1, vp.precio_unidad as precio, vp.subtotal, vp.total,um.descripcion as unidad,(vp.total - vp.subtotal) as IGV, vp.texto_ref as nombre_producto   FROM venta v inner join venta_producto vp on v.id = vp.venta_id inner join producto p on p.id=vp.producto_id inner join unidad_medida um on um.id = p.unidad_medida_id WHERE v.id=" . $venta_id);
        } else if ($tipo_venta == "SERVICIOS") {
            return $this->db->query("select vp.precio_unidad, vp.producto_id as codigo_producto, null serie, vp.cantidad, vp.texto_ref as nombre_producto,
      vp.precio_unidad as precio, vp.subtotal, vp.total
      FROM venta v
      inner join venta_producto vp on v.id = vp.venta_id WHERE v.id=" . $venta_id);
        }
    }

    public function getTipoVenta($venta_id)
    {
        return $this->db->query("select tipo_venta from venta where id=" . $venta_id)->row()->tipo_venta;
    }

    public function getDatosVentaFactura($venta_id)
    {
        $result = $this->db->query("select v.codigo_moneda, f.hash, v.correo, v.tipo_venta, v.celular, f.ruc docum, f.direccion,f.cliente, f.serie, LPAD(f.numero, 8, '0') numero, v.created_at, concat(u.first_name,' ',u.last_name) username "
            . " from venta v "
            . " INNER JOIN users u ON v.users_id=u.id "
            . " INNER JOIN factura f ON f.venta_id=v.id where v.id=" . $venta_id);
        return $result->row();
    }

    public function getDatosVentaFacturaA4($venta_id)
    {
        $result = $this->db->query("select f.estado_api,v.codigo_moneda, f.fecha, f.vencimiento,f.hash, f.ruc docum, f.direccion,f.cliente, f.serie, LPAD(f.numero, 8, '0') numero, v.created_at,v.guia_remision,v.orden_servicio
    ,case when f.envio = 'enviado' then 'Aceptado'
    when f.envio = 'rechazado' then 'Rechazado' when f.envio = 'pendiente' then 'Pendiente'
    end as envio,v.tipo_venta, v.metodo_pago,v.observacion,v.guia_remision_numeros 
    from venta v inner join factura f on f.venta_id=v.id where v.id=" . $venta_id . " LIMIT 1");
        return $result->row();
    }
    public function getDatosVentaFacturaNotaCreditoA4($venta_id)
    {
        $result = $this->db->query("select f.estado_api,v.codigo_moneda, f.fecha, f.vencimiento,f.hash, f.ruc docum, f.direccion,f.cliente, f.serie, LPAD(f.numero, 8, '0') numero, v.created_at,v.guia_remision,v.orden_servicio, f.fecha_nota_credito, f.tipo_nota, f.descripcion_nota, f.id id_factura_nota_credito, f.serie_nota
    ,case when f.envio = 'enviado' then 'Aceptado'
    when f.envio = 'rechazado' then 'Rechazado' when f.envio = 'pendiente' then 'Pendiente'
    end as envio,v.tipo_venta, v.metodo_pago,f.numero_nota,v.observacion
    from venta v inner join factura_nota_credito f on f.venta_id=v.id where v.id=" . $venta_id . " LIMIT 1");
        return $result->row();
    }

    public function getDatosVentaBoleta($venta_id)
    {
        $result = $this->db->query("select v.codigo_moneda, f.hash, v.correo, v.tipo_venta, v.celular, f.dni docum, f.direccion,f.cliente, f.serie, LPAD(f.numero, 8, '0') numero, v.created_at, concat(u.first_name,' ',u.last_name) username "
            . " from venta v "
            . " inner join users u on v.users_id=u.id "
            . " inner join boleta f on f.venta_id=v.id "
            . " where v.id=" . $venta_id . " LIMIT 1");
        return $result->row();
    }

    public function getDatosVentaBoletaA4($venta_id)
    {
        $result = $this->db->query("select v.codigo_moneda, f.fecha,f.hash, f.dni docum, f.direccion,f.cliente, f.serie, LPAD(f.numero, 8, '0') numero, v.created_at,v.guia_remision,v.orden_servicio
    ,case when f.envio = 'enviado' then 'Aceptado'
    when f.envio = 'rechazado' then 'Rechazado' when f.envio = 'pendiente' then 'Pendiente'
    end as envio,v.tipo_venta
    from venta v inner join boleta f on f.venta_id=v.id where v.id=" . $venta_id . " LIMIT 1");
        return $result->row();
    }

    public function stockMesAnterior($producto_id, $mes, $ano)
    {
        $result = $this->db->query("select * from stock_fin_mes_producto where producto_id=" . $producto_id . " and mes=" . $mes . " and ano=" . $ano . " LIMIT 1");
        return $result->row();
    }

    public function getUltimoNumeroComprobante()
    {
        return $this->db->query("select case when max(numero) IS NULL then LPAD(1, 8, '0') else LPAD(max(numero)+1, 8, '0') end as numero,'factura' tipo from factura UNION select case when max(numero) IS NULL then LPAD(1, 8, '0') else LPAD(max(numero)+1, 8, '0') end as numero,'boleta' tipo from boleta UNION SELECT IFNULL(LPAD(max(numero_nota)+1, 8, '0'),'000001') as numero, 'factura_nota_credito' as tipo FROM factura_nota_credito UNION SELECT IFNULL(LPAD(max(numero)+1, 8, '0'),'000001') as numero, 'nota_debito' as tipo FROM nota_debito");
    }

    public function kardexProductoMesAno($producto_id, $mes, $ano)
    {
        return $this->db->query("SELECT b.serie,LPAD(numero, 8, '0') numero,vp.cantidad,vp.precio_unidad,vp.total,b.created_at,b.fecha,'VENTA' tipo FROM boleta b inner join venta v on b.venta_id=v.id inner join venta_producto vp on v.id=vp.venta_id
    where (select producto_id from producto_serie where id = vp.producto_serie_id)=" . $producto_id . " and month(b.created_at)=" . $mes . " and year(b.created_at)=" . $ano . "
    UNION     SELECT f.serie,LPAD(numero, 8, '0') numero,vp.cantidad,vp.precio_unidad,vp.total,f.created_at,f.fecha,'VENTA' tipo FROM factura f
    inner join venta v on f.venta_id=v.id
    inner join venta_producto vp on v.id=vp.venta_id
    where (select producto_id from producto_serie where id = vp.producto_serie_id)=" . $producto_id . " and month(f.created_at)=" . $mes . " and year(f.created_at)=" . $ano . "
    UNION
    SELECT c.serie,LPAD(c.numero, 8, '0') numero,cp.cantidad,cp.precio_unidad * ifnull(c.tipocambio,1),cp.total * ifnull(c.tipocambio,1),c.fecha,c.fecha,'COMPRA' tipo FROM compra c
    inner join compra_producto cp on c.id=cp.compra_id
    where (select producto_id from producto_serie where id = cp.producto_serie_id)=" . $producto_id . " and month(c.fecha)=" . $mes . " and year(c.fecha)=" . $ano . "
    order by created_at");
    }

    public function verificarPrimeraVentaMes($producto_id, $mes, $ano)
    {
        $result = $this->db->query("select count(*) cant_regs,p.stock from venta v inner join venta_producto vp on v.id=vp.venta_id inner join producto p on p.id=vp.producto_id where day(v.created_at)=1 and month(v.created_at)=" . $mes . " and year(v.created_at)=" . $ano . " and v.estado=1 and vp.producto_id=" . $producto_id . " LIMIT 1");
        if ($result->row()->cant_regs == 0) {
            $mes_insert = 0;
            $ano_insert = 0;
            if ($mes == 1) {
                $mes_insert = 12;
                $ano_insert = $ano - 1;
            } else {
                $mes_insert = $mes - 1;
                $ano_insert = $ano;
            }
            $s = array(
                'id' => '',
                'producto_id' => $producto_id,
                'mes' => $mes_insert,
                'ano' => $ano_insert,
                'cantidad' => $result->row()->stock
            );
            $this->db->insert('stock_fin_mes_producto', $s);
        }
    }

    public function getDataConcarFactura($mes, $ano)
    {
        return $this->db->query("select LPAD(@i := @i + 1, 4, '0') as count, f.ruc,f.serie, LPAD(f.numero, 6, '0') numero, v.tipo_venta, f.fecha, LPAD(month(f.fecha), 2, '0') mes, (select sum(subtotal) from venta_producto where venta_id=v.id) subtotal, (select sum(total)-sum(subtotal) from venta_producto where venta_id=v.id) igv, (select sum(total) from venta_producto where venta_id=v.id) total from venta v inner join factura f on v.id=f.venta_id cross join (select @i := 0) vp where v.estado=1 and month(f.fecha)=" . $mes . " and year(f.fecha)=" . $ano . " order by f.created_at");
    }

    public function getDataConcarBoleta($mes, $ano)
    {
        return $this->db->query("select LPAD(@i := @i + 1, 4, '0') as count, f.serie, LPAD(f.numero, 6, '0') numero, v.tipo_venta, f.fecha, LPAD(month(f.fecha), 2, '0') mes, (select sum(subtotal) from venta_producto where venta_id=v.id) subtotal, (select sum(total)-sum(subtotal) from venta_producto where venta_id=v.id) igv, (select sum(total) from venta_producto where venta_id=v.id) total from venta v inner join boleta f on v.id=f.venta_id cross join (select @i := 0) vp where v.estado=1 and month(f.fecha)=" . $mes . " and year(f.fecha)=" . $ano . " order by f.created_at");
    }

    public function getDataDBF($mes, $ano)
    {
        return $this->db->query("select DISTINCT ruc,fecha, created_at, cliente from factura where MONTH(fecha)=" . $mes . " and YEAR(fecha)=" . $ano . " and LENGTH(ruc)=11");
    }

    public function getErrors()
    {
        return $this->db->query("select * from error");
    }

    public function guardarError($e)
    {
        return $this->db->insert('error', $e);
    }

    public function getListaComprobantes($mes, $ano, $doc)
    {

        if ($doc == "BOLETA") {
            return $this->db->query("select v.created_at as fecha, concat(f.serie,'-',LPAD(f.numero, 8, '0')) as numero, f.cliente, sum(vp.subtotal) subtotal ,sum(vp.total)-sum(vp.subtotal) igv, sum(vp.total) total, v.metodo_pago from venta v inner join boleta f on f.venta_id=v.id inner join venta_producto vp on vp.venta_id=v.id where v.estado=1 and month(f.created_at)=" . $mes . " and year(f.created_at)=" . $ano . " group by (v.id)");
        } else if ($doc == "FACTURA") {
            return $this->db->query("select v.created_at as fecha, concat(f.serie,'-',LPAD(f.numero, 8, '0')) as numero, f.cliente, sum(vp.subtotal) subtotal ,sum(vp.total)-sum(vp.subtotal) igv, sum(vp.total) total, v.metodo_pago from venta v inner join factura f on f.venta_id=v.id inner join venta_producto vp on vp.venta_id=v.id where v.estado=1 and MONTH(f.created_at)=" . $mes . " and YEAR(f.created_at)=" . $ano . " group by v.id ");
        }
    }

    public function crearNotaCredito($b)
    {
        $this->db->insert('nota_credito', $b);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function crearNotaCreditoFactura($b)
    {
        $this->db->insert('factura_nota_credito', $b);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }


    public function crearNotaDebito($b)
    {
        $this->db->insert('nota_debito', $b);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function getNumeroNotaCredito()
    {
        $result = $this->db->query("select case when max(numero_nota) IS NULL then LPAD(1, 8, '0') else LPAD(max(numero)+1, 8, '0') end as numero from factura_nota_credito LIMIT 1");
        return $result->row();
    }
    public function getNumeroNotaCreditoFactura()
    {
        $result = $this->db->query("select case when max(numero_nota) IS NULL then LPAD(1, 8, '0') else LPAD(max(numero_nota)+1, 8, '0') end as numero from factura_nota_credito LIMIT 1");
        return $result->row();
    }
    public function getNumeroNotaDebito()
    {
        $result = $this->db->query("select case when max(numero) IS NULL then LPAD(1, 8, '0') else LPAD(max(numero)+1, 8, '0') end as numero from nota_debito LIMIT 1");
        return $result->row();
    }

    public function getDatosVentaNotaDebito($venta_id)
    {

        $result = $this->db->query("select f.motivo,f.hash, f.num_documento docum, f.direccion,f.cliente, f.serie, LPAD(f.numero, 8, '0') numero, v.created_at, concat(u.first_name,' ',u.last_name) username, f.doc_modificado, f.num_doc_modificado from venta v inner join users u on v.users_id=u.id inner join nota_debito f on f.venta_id=v.id where v.id=" . $venta_id . " LIMIT 1");
        return $result->row();
    }

    public function getDatosVentaNotaCredito($venta_id)
    {

        $result = $this->db->query("select f.motivo,f.hash, f.num_documento docum, f.direccion,f.cliente, f.serie, LPAD(f.numero, 8, '0') numero, v.created_at, concat(u.first_name,' ',u.last_name) username, f.doc_modificado, f.num_doc_modificado from venta v inner join users u on v.users_id=u.id inner join nota_credito f on f.venta_id=v.id where v.id=" . $venta_id . " LIMIT 1");

        return $result->row();
    }

    public function getClientes()
    {
        return $this->db->query("select * from cliente where estado = 1 order by nombre_cliente");
    }
    public function getAllDirecciones() {
        return $this->db->query("select cliente_direccion.*,cliente.numero_documento from cliente_direccion inner join cliente on cliente.id=cliente_direccion.id_cliente");
    }

    public function getClientesFactura()
    {
        return $this->db->query("SELECT ruc, cliente, direccion FROM factura group by ruc");
    }

    public function getClientesBoleta()
    {
        return $this->db->query("SELECT dni, cliente, direccion FROM boleta group by dni");
    }

    public function getVentasRows()
    {
        $conn = mysqli_connect($this->db->hostname, $this->db->username, $this->db->password, $this->db->database);
        $results_per_page = 20;
        $query = "SELECT v.id, f.serie, LPAD(f.numero, 8, '0') numero, f.estado, v.created_at fecha, SUM(vp.total) total 
        FROM venta v
        INNER JOIN factura f ON f.venta_id=v.id 
        INNER JOIN venta_producto vp ON vp.venta_id=v.id
        GROUP BY v.id, f.serie, LPAD(f.numero, 8, '0'), f.estado, v.created_at

        UNION

        SELECT v.id, f.serie, LPAD(f.numero, 8, '0') numero, f.estado, v.created_at fecha, SUM(vp.total) total
        FROM venta v 
        INNER JOIN boleta f ON f.venta_id=v.id
        INNER JOIN venta_producto vp ON vp.venta_id=v.id
        GROUP BY v.id, f.serie, LPAD(f.numero, 8, '0'), f.estado, v.created_at
        ORDER BY fecha DESC LIMIT 100";

        $result = mysqli_query($conn, $query);
        $number_of_results = mysqli_num_rows($result);
        $number_of_pages = ceil($number_of_results / $results_per_page);
        return $number_of_pages;
    }

    public function getBoletasPendientes()
    {
        return $this->db->query("select b.serie, b.id, b.dni, b.cliente, b.fecha, v.total FROM boleta b inner join venta_producto v on b.venta_id = v.venta_id WHERE b.procesado = 1 GROUP BY b.venta_id");
    }

    public function getFacturasPendientes()
    {
        return $this->db->query("select b.serie, b.id, b.ruc, b.cliente, b.fecha, b.estado_api,v.total FROM factura b inner join venta_producto v on b.venta_id = v.venta_id WHERE b.procesado = 1 GROUP BY b.venta_id");
    }

    public function getBoletasAceptadas()
    {
        return $this->db->query("select b.serie, b.numero, b.id, b.dni, b.cliente, b.fecha, b.estado_api,v.total FROM boleta b inner join venta_producto v on b.venta_id = v.venta_id WHERE b.estado_api = 'Aceptado' GROUP BY b.venta_id");
    }

    public function getFacturasAceptadas()
    {
        return $this->db->query("select b.serie, b.numero, b.id, b.ruc, b.cliente, b.fecha,b.estado_api, v.total FROM factura b inner join venta_producto v on b.venta_id = v.venta_id WHERE b.estado_api = 'Aceptado' GROUP BY b.venta_id");
    }
    public function getBoletasAnuladas()
    {
        return $this->db->query("select b.serie, b.numero, b.id, b.dni, b.cliente, b.estado_api,b.estado_sunat,b.fecha, v.total FROM boleta b inner join venta_producto v on b.venta_id = v.venta_id WHERE b.estado_api = 'Anulado' order by b.id DESC");
    }

    public function getFacturasAnuladas()
    {
        return $this->db->query("select b.serie, b.numero, b.id, b.ruc, b.cliente, b.estado_api,b.estado_sunat, b.fecha, v.total FROM factura b inner join venta_producto v on b.venta_id = v.venta_id WHERE b.estado_api = 'Anulado' order by b.id DESC");
    }

    public function getNotaCreditoFacturasAnuladas()
    {
        return $this->db->query("select b.serie_nota as serie, b.numero_nota as numero, b.id, b.ruc, b.cliente, b.estado_api,b.estado_sunat, b.fecha, v.total FROM factura_nota_credito b inner join venta_producto v on b.venta_id = v.venta_id WHERE b.estado_api = 'Anulado' order by b.id DESC");
    }


    public function getBoletasRechazadas()
    {
        return $this->db->query("select b.serie, b.numero, b.id, b.dni, b.cliente, b.fecha, b.estado_api,v.total FROM boleta b inner join venta_producto v on b.venta_id = v.venta_id WHERE b.envio = 'rechazado' GROUP BY b.venta_id");
    }

    public function getFacturasRechazadas()
    {
        return $this->db->query("select b.serie, b.numero, b.id, b.ruc, b.cliente, b.fecha, b.estado_api,v.total FROM factura b inner join venta_producto v on b.venta_id = v.venta_id WHERE b.envio = 'rechazado' GROUP BY b.venta_id");
    }

    public function obtener_nombre_cliente($id_cotizacion)
    {
        $this->load->model('Cliente_model');
        $this->db->select('cotizacion.cliente_id');
        $this->db->from('cotizacion');
        $this->db->join('cliente', 'cliente.id=cotizacion.cliente_id');
        $this->db->where('cotizacion.id', $id_cotizacion);
        $resultado = $this->db->get()->result();
        if (sizeof($resultado) > 0) {
            return $this->Cliente_model->obtener_nombre($resultado[0]->cliente_id);
        } //end if
        else {
            return '';
        } //end else
    } //end obtener_nombre_cliente

    public function obtener_direccion_cliente($id_cotizacion)
    {
        $this->load->model('Cliente_model');
        $this->db->select('cotizacion.cliente_id');
        $this->db->from('cotizacion');
        $this->db->join('cliente', 'cliente.id=cotizacion.cliente_id');
        $this->db->where('cotizacion.id', $id_cotizacion);
        $resultado = $this->db->get()->result();
        if (sizeof($resultado) > 0) {
            return $this->Cliente_model->obtener_direccion_principal($resultado[0]->cliente_id);
        } //end if
        else {
            return '';
        } //end else
    } //end obtener_direccion_cliente

    public function obtener_email_cliente($id_cotizacion)
    {
        $this->load->model('Cliente_model');
        $this->db->select('cotizacion.cliente_id');
        $this->db->from('cotizacion');
        $this->db->join('cliente', 'cliente.id=cotizacion.cliente_id');
        $this->db->where('cotizacion.id', $id_cotizacion);
        $resultado = $this->db->get()->result();
        if (sizeof($resultado) > 0) {
            return $this->Cliente_model->obtener_email_principal($resultado[0]->cliente_id);
        } //end if
        else {
            return '';
        } //end else
    } //end obtener_email_cliente

    public function obtener_telefono_cliente($id_cotizacion)
    {
        $this->load->model('Cliente_model');
        $this->db->select('cotizacion.cliente_id');
        $this->db->from('cotizacion');
        $this->db->join('cliente', 'cliente.id=cotizacion.cliente_id');
        $this->db->where('cotizacion.id', $id_cotizacion);
        $resultado = $this->db->get()->result();
        if (sizeof($resultado) > 0) {
            return $this->Cliente_model->obtener_telefono_principal($resultado[0]->cliente_id);
        } //end if
        else {
            return '';
        } //end else
    } //end obtener_telefono_cliente

    public function obtener_numero_documento($id_cotizacion)
    {
        $this->load->model('Cliente_model');
        $this->db->select('cotizacion.cliente_id');
        $this->db->from('cotizacion');
        $this->db->join('cliente', 'cliente.id=cotizacion.cliente_id');
        $this->db->where('cotizacion.id', $id_cotizacion);
        $resultado = $this->db->get()->result();
        if (sizeof($resultado) > 0) {
            return $this->Cliente_model->obtener_numero_documento($resultado[0]->cliente_id);
        } //end if
        else {
            return '';
        } //end else
    } //end obtener_numero_documento

    public function obtener_tipo_documento($id_cotizacion)
    {
        $this->load->model('Cliente_model');
        $this->db->select('cotizacion.cliente_id');
        $this->db->from('cotizacion');
        $this->db->join('cliente', 'cliente.id=cotizacion.cliente_id');
        $this->db->where('cotizacion.id', $id_cotizacion);
        $resultado = $this->db->get()->result();
        if (sizeof($resultado) > 0) {
            return $this->Cliente_model->obtener_tipo_documento($resultado[0]->cliente_id);
        } //end if
        else {
            return '';
        } //end else
    } //end obtener_tipo_documento

    public function obtener_id_venta_por_cliente($id_cliente, $fecha_inicio, $fecha_fin)
    {
        $this->db->select('id');
        $this->db->from($this->tabla);
        $this->db->where('id', $id_cliente);
        $this->db->where(array("date_format(created_at, '%Y-%m-%d') >= " => $fecha_inicio, "date_format(created_at, '%Y-%m-%d') <= " => $fecha_fin));
        $resultado = $this->db->get()->result();
        if (sizeof($resultado) > 0) {
            return $resultado[0]->id;
        } //end if
        else {
            return '';
        } //end else
    } //end obtener_id_venta_por_cliente

    public function tipo_cotizacion($id_cotizacion)
    {
        $this->db->select('cotizacion.tipo_cotizacion');
        $this->db->from('cotizacion');
        $this->db->where('cotizacion.id', $id_cotizacion);
        $resultado = $this->db->get()->result();
        if (sizeof($resultado) > 0) {
            return $resultado[0]->tipo_cotizacion;
        } //end if
        else {
            return '';
        } //end else
    } //end tipo_cotizacion

    public function obtener_serie_numero($id_cotizacion)
    {
        $this->db->select('remision_id');
        $this->db->from('remision_producto');
        $this->db->where('id_cotizacion', $id_cotizacion);
        $resultado = $this->db->get()->result();
        if (sizeof($resultado) > 0) {
            $this->load->model('Guia_model');
            return $this->Guia_model->obtener_serie_numero($resultado[0]->remision_id);
        } //end if
        else {
            return '';
        } //end else
    } //end obtener_serie_numero

    public function obtener_remision($id_cotizacion)
    {
        $this->db->select('remision_id');
        $this->db->from('remision_producto');
        $this->db->where('id_cotizacion', $id_cotizacion);
        $resultado = $this->db->get()->result();
        if (sizeof($resultado) > 0) {
            $this->load->model('Remision_producto_model');
            return $this->Remision_producto_model->obtener_remision($resultado[0]->remision_id);
        } //end if
        else {
            return '';
        } //end else
    } //end obtener_remision

    public function obtener_id_cliente($id_cotizacion)
    {
        $this->load->model('Cliente_model');
        $this->db->select('cotizacion.cliente_id');
        $this->db->from('cotizacion');
        $this->db->join('cliente', 'cliente.id=cotizacion.cliente_id');
        $this->db->where('cotizacion.id', $id_cotizacion);
        $resultado = $this->db->get()->result();
        if (sizeof($resultado) > 0) {
            return $this->Cliente_model->obtener_id_cliente($resultado[0]->cliente_id);
        } //end if
        else {
            return '';
        } //end else
    } //end obtener_id_cliente

    public function actualizar($id, $data) {
        $this->db->where("id", $id);
        return $this->db->update('cotizacion', $data);
    } # end actualizar
    public function actualizar_cotizacion_producto($id_cotizacion, $id_producto, $data) {
        $this->db->where("cotizacion_id", $id_cotizacion);
        $this->db->where("id_producto", $id_producto);
        return $this->db->update('cotizacion_producto', $data);
    } # end actualizar_cotizacion_producto

    public function ventas_mensuales_anio_actual()
    {
        $this->db->select("DATE_FORMAT(created_at, '%m') as mes, SUM(CASE WHEN codigo_moneda = 'PEN' THEN total else 0 END) as total_soles, SUM(CASE WHEN codigo_moneda = 'USD' THEN total else 0 END) as total_dolares");
        $this->db->from('venta');
        $this->db->where("DATE_FORMAT(created_at, '%Y')=", date('Y'));
        $this->db->group_by('mes');
        $this->db->order_by('mes', 'ASC');
        return $this->db->get()->result();
    } //end ventas_mensuales_anio_actual

    public function ventas_semanales($fecha_inicio, $fecha_fin)
    {
        $query = $this->db->query("select (ELT(WEEKDAY(created_at) + 1, '1', '2', '3', '4', '5', '6', '7')) as dia_semana, SUM(CASE WHEN codigo_moneda = 'PEN' THEN total END) as total_soles, SUM(CASE WHEN codigo_moneda = 'USD' THEN total END) as total_dolares from venta where DATE_FORMAT(created_at, '%Y-%m-%d') >= '" . $fecha_inicio . "' and DATE_FORMAT(created_at, '%Y-%m-%d') <= '" . $fecha_fin . "' group by dia_semana order by dia_semana asc");
        return $query->result();
    } //end ventas_semanales

    public function total_trimestre($inicio, $fin)
    {
        $this->db->select("SUM(total) as total");
        $this->db->from('venta');
        $this->db->where(array("date_format(created_At, '%m') >= " => $inicio, "date_format(created_At, '%m') <= " => $fin, "date_format(created_At, '%Y') = " => date('Y')));
        $resultado =  $this->db->get()->result();
        if (sizeof($resultado) > 0) {
            return $resultado[0]->total;
        } //end if
        else {
            return sizeof($resultado);
        } //end else
    } //end total_trimestre

    public function total_anual()
    {
        $this->db->select("SUM(total) as total");
        $this->db->from('venta');
        $this->db->where(array("date_format(created_At, '%Y') = " => date('Y')));
        $resultado =  $this->db->get()->result();
        if (sizeof($resultado) > 0) {
            return $resultado[0]->total;
        } //end if
        else {
            return sizeof($resultado);
        } //end else
    } //end total_anual

    public function obtener_numero($venta_id)
    {
        $this->db->select("LPDA(numero, 8, '0') as numero");
        $this->db->from('factura');
        $this->db->where('venta_id', $venta_id);
        $resultado =  $this->db->get()->result();
        if (sizeof($resultado) > 0) {
            return $resultado[0]->numero;
        } //end if
        else {
            return '';
        } //end else
    } //end obtener_numero

    public function guia_remision($venta_id)
    {
        $this->db->select("guia_remision");
        $this->db->from($this->tabla);
        $this->db->where('venta_id', $venta_id);
        $resultado =  $this->db->get()->result();
        if (sizeof($resultado) > 0) {
            return $resultado[0]->guia_remision;
        } //end if
        else {
            return '';
        } //end else
    } //end guia_remision

    public function getCompraProductos($mes, $ano, $product)
    {
        return $this->db->query("select c.serie, c.numero, c.created_at fecha, p.nombre, cp.precio_unidad, cp.total FROM compra as c INNER JOIN compra_producto as cp on c.id = cp.compra_id INNER JOIN producto as p on p.id = cp.producto_id where month(c.fecha) =" . $mes . " and year(c.fecha) =" . $ano . " and p.id =" . $product);
        //return $result->row();
    }

    public function getVentaProductos($mes, $ano, $product)
    {
        return $this->db->query("select f.serie, LPAD(f.numero, 6, '0') numero, v.created_at fecha, p.nombre, vp.precio_unidad, vp.total from venta v inner join factura f on f.venta_id=v.id inner join venta_producto vp on vp.venta_id=v.id inner join producto p on vp.producto_id = p.id where date_format(v.created_at, '%m') =" . $mes . " and date_format(v.created_at, '%Y') =" . $ano . " and p.id = " . $product . " group by (v.id) union select f.serie, LPAD(f.numero, 6, '0') numero, v.created_at fecha, p.nombre, vp.precio_unidad, vp.total from venta v inner join boleta f on f.venta_id=v.id inner join venta_producto vp on vp.venta_id=v.id inner join producto p on vp.producto_id = p.id where date_format(v.created_at, '%m') =" . $mes . " and date_format(v.created_at, '%Y') =" . $ano . " and p.id = " . $product . " group by (v.id) order by fecha desc");
        //return $result->row();
    }

    public function getListaComprobantesPeriodo($date1, $date2, $doc)
    {
        if ($doc == "BOLETA") {
            return $this->db->query("select v.created_at as fecha, concat(f.serie,'-',LPAD(f.numero, 6, '0')) as numero, f.cliente, p.nombre, sum(vp.subtotal) subtotal ,sum(vp.total)-sum(vp.subtotal) igv, sum(vp.total) total, v.metodo_pago from venta v inner join boleta f on f.venta_id=v.id inner join venta_producto vp on vp.venta_id=v.id inner join producto p on vp.producto_id = p.id where v.estado=1 and f.created_at BETWEEN '" . $date1 . "' and '" . $date2 . " 23:59:59' group by v.id");
        } else if ($doc == "FACTURA") {
            return $this->db->query("select v.created_at as fecha, concat(f.serie,'-',LPAD(f.numero, 6, '0')) as numero, f.cliente, p.nombre, sum(vp.subtotal) subtotal ,sum(vp.total)-sum(vp.subtotal) igv, sum(vp.total) total, v.metodo_pago from venta v inner join factura f on f.venta_id=v.id inner join venta_producto vp on vp.venta_id=v.id inner join producto p on vp.producto_id = p.id where v.estado=1 and f.created_at BETWEEN '" . $date1 . "' and '" . $date2 . " 23:59:59' group by v.id");
        }
    }

    public function getVentasReport($date)
    {
        return $this->db->query("SELECT vp.created_at, vp.venta_id, p.nombre, vp.precio_unidad, vp.cantidad, vp.total FROM factura f, boleta b, venta_producto vp inner join producto p on vp.producto_id = p.id where date_format(vp.created_at, '%Y-%m-%d') = '" . $date . "' and date_format(f.created_at, '%Y-%m-%d') = '" . $date . "' and date_format(b.created_at, '%Y-%m-%d') = '" . $date . "' group by vp.venta_id");
    }

    public function getListaComprobantesMaquina($mes, $ano, $doc)
    {
        if ($doc == "PRUEBA DE MÁQUINA") {
            return $this->db->query("SELECT pm.fecha, p.nombre, pm.monto FROM prueba_maquina pm inner join producto p on pm.producto_id = p.id where month(pm.fecha)=" . $mes . " and year(pm.fecha)=" . $ano . "  group by pm.id");
        }
    }

    public function getVentasTotales()
    {
        $result = $this->db->query("SELECT COUNT(id) as total_ventas FROM factura");
        return $result->row();
    }

    public function updateEstadoFacturaSunat($id, $estado)
    {
        return $this->db->query("update factura set estado_sunat = '" . $estado . "' where id = '" . $id . "'");
    }

    public function updateEstadoBoletaSunat($id, $estado)
    {
        return $this->db->query("update boleta set estado_sunat = '" . $estado . "' where id = '" . $id . "'");
    }
    public function updateEstadoNotaCreditoSunat($id, $estado)
    {
        return $this->db->query("update factura_nota_credito set estado_sunat = '" . $estado . "' where id = '" . $id . "'");
    }
    public function getVentasSeaceFormat($id, $fecha_inicio, $fecha_fin)
    {
        $sql = "SELECT v.*, LPAD(f.numero, 8, '0') as numero, r.numero as remisionNumero, r.serie as remisionSerie, r.correlativo, r.documento_conformidad 
				FROM `venta` v
				INNER JOIN factura f ON f.venta_id = v.id
				LEFT JOIN remision r ON (r.serie = CONVERT(SUBSTRING_INDEX(TRIM(v.guia_remision), '-', 1) USING utf8) AND  LPAD(r.numero, 8, '0') = CONVERT(SUBSTRING_INDEX(TRIM(v.guia_remision), '-', -1) USING utf8))
				WHERE v.`users_id` = $id
					AND date_format(v.created_at, '%Y-%m-%d') >= '$fecha_inicio' 
					AND date_format(v.created_at, '%Y-%m-%d') <= '$fecha_fin' 
					AND v.guia_remision LIKE '%-%'
		";

        $data = $this->db->query($sql);
        return $data->result();
    }

    public function getFacturasSeaceFormat($id, $fecha_inicio, $fecha_fin)
    {
    }

    public function getVentasFromProductId($productId)
    {
        $sql = $this->db->query("SELECT DISTINCT(venta_id) FROM `venta_producto` WHERE producto_id = $productId");
        $ventas = $sql->result();

        return array_map(function ($venta) {
            return (int) $venta->venta_id;
        }, $ventas);
    }


    public function getAllProducts($fecha_inicio, $fecha_fin, $ventas, $clientes, $segmento)
    {
        $ids = empty($ventas) ? '0' : implode(', ', $ventas);
        $clientesIds = empty($clientes) ? '0' : implode(', ', $clientes);
        $query = 'f.cliente IN (' . $clientesIds . ')';

        if ($segmento === 'todos' && '0' === $clientesIds) {
            $query = 'f.cliente IS NOT NULL';
        }

        $sql = "SELECT r.id remisionid,r.documento_conformidad, r.correlativo, pc.cotizacion_id AS id_cotizacion, v.guia_remision AS remision, 
					   f.id factura_id, f.fecha fecha_sunat,CONCAT(u.first_name, ' ', u.last_name) AS vendedor_name,v.codigo_moneda,
					   f.fecha fecha_emision, f.cliente, f.ruc, v.id, f.serie, LPAD(f.numero, 8, '0') numero, f.estado,
					   v.created_at fecha, SUM(vp.total) total, f.envio, f.id id_doc, 'factura' tipo
				FROM venta v
					INNER JOIN users u ON u.id=v.users_id
					INNER JOIN factura f ON f.venta_id=v.id
					INNER JOIN venta_producto vp ON vp.venta_id=v.id
					LEFT JOIN remision r ON LPAD(r.numero, 8, '0') = LPAD(f.numero, 8, '0')
					LEFT JOIN producto_cotizacion pc on vp.producto_id = pc.id_producto
				WHERE f.venta_id IN (" . $ids . ")
				AND date_format(v.created_at, '%Y-%m-%d') >= '$fecha_inicio' 
				AND date_format(v.created_at, '%Y-%m-%d') <= '$fecha_fin'
				AND $query
				GROUP BY v.id, f.serie, LPAD(f.numero, 8, '0'), f.estado, v.created_at, f.envio, f.id
				UNION
				SELECT r.id remisionid, r.documento_conformidad, r.correlativo, pc.cotizacion_id AS id_cotizacion, v.guia_remision AS remision, 
					   f.id factura_id, f.fecha fecha_sunat, CONCAT(u.first_name, ' ', u.last_name) AS vendedor_name, v.codigo_moneda,
					   f.fecha fecha_emision,f.cliente, f.dni as ruc, v.id, f.serie, LPAD(f.numero, 8, '0') numero, f.estado, v.created_at fecha,
					   SUM(vp.total) total, f.envio, f.id id_doc, 'boleta' tipo
				FROM venta v
					INNER JOIN users u ON u.id=v.users_id
					INNER JOIN boleta f ON f.venta_id=v.id
					INNER JOIN venta_producto vp ON vp.venta_id=v.id
					LEFT JOIN remision r ON LPAD(r.numero, 8, '0') = LPAD(f.numero, 8, '0')
					LEFT JOIN producto_cotizacion pc on vp.producto_id = pc.id_producto
				WHERE f.venta_id IN (" . $ids . ")
				AND date_format(v.created_at, '%Y-%m-%d') >= '$fecha_inicio' 
				AND date_format(v.created_at, '%Y-%m-%d') <= '$fecha_fin'
				AND $query
				GROUP BY v.id, f.serie, LPAD(f.numero, 8, '0') , f.estado, v.created_at ,f.envio, f.id
				ORDER BY fecha DESC
				";

        return $this->db->query($sql);
    }
    //api
    //
    public function facturaById($id, $numero, $serie)
    {
        $query = "SELECT f.id, f.codigo, f.ruc numero_doc, f.cliente, f.direccion, f.estado,
            f.venta_id, f.serie, f.numero, f.fecha, f.created_at, f.updated_at, f.hash, f.procesado, f.envio,
            DATE_FORMAT(f.created_at, '%H:%i:%s') AS hora_emision,
            '01' tipo_doc,
            f.external_id,v.guia_remision,v.guia_remision_numeros,v.guia_remision_ids,v.observacion,f.vencimiento,
            v.metodo_pago, v.condicion_pago, v.credito_con_cuotas, v.credito_metodo_pago, v.credito_fecha, v.credito_monto
            FROM factura f
            INNER JOIN venta v ON v.id=f.venta_id
            WHERE 1=1
            AND f.serie='" . $serie . "'
            AND f.numero=" . $numero . "
            AND f.id=" . $id . "
            LIMIT 1";
        //echo $query;
        return $this->db->query($query)->row();
    }
    public function notaCreditoById($id, $numero, $serie)
    {
        $query = "SELECT id, codigo, ruc numero_doc, cliente, direccion, estado,
            venta_id, serie, numero, fecha, created_at, updated_at, hash, procesado, envio,
            DATE_FORMAT(created_at, '%H:%i:%s') AS hora_emision,
            '07' tipo_doc,serie_nota,numero_nota,
            external_id,tipo_nota,descripcion_nota,external_id_modificado
            FROM factura_nota_credito
            WHERE 1=1
            AND serie_nota='" . $serie . "'
            AND numero_nota=" . $numero . "
            AND id=" . $id . "
            LIMIT 1";
        //echo $query;
        return $this->db->query($query)->row();
    }
    
    public function boletaById($id, $numero, $serie)
    {
        $query = "SELECT id, codigo, dni numero_doc, cliente, direccion, estado, 
            venta_id, serie, numero, fecha, hash, created_at, updated_at, procesado, envio,
            DATE_FORMAT(created_at, '%H:%i:%s') AS hora_emision,
            '03' tipo_doc,
            external_id,v.guia_remision_numeros,f.vencimiento
            FROM boleta
            WHERE 1=1
            AND serie='" . $serie . "'
            AND numero=" . $numero . "
            AND id=" . $id . "
            LIMIT 1";
        //echo $query;
        return $this->db->query($query)->row();
    }

    public function ventaProductoByIdVenta($id)
    {
      $query = "SELECT vp.id, vp.precio_unidad, vp.cantidad, vp.venta_id, vp.created_at,
            vp.producto_id, vp.subtotal, vp.total,
            p.nombre p_nombre, p.tipo p_tipo, p.precio_venta p_precio_venta,vp.texto_ref
            FROM venta_producto vp
            LEFT JOIN producto p ON (vp.producto_id=p.id)
            WHERE 1=1
            AND vp.venta_id=" . $id;
      return $this->db->query($query)->result();
    }
    
    public function updateCPE($tipo, $id, $external_id, $estado_api)
    {
        $query = "update $tipo set external_id ='" . $external_id . "', estado_api='" . $estado_api . "' "
            . " where id=" . $id;
        //echo $query;
        return $this->db->query($query);
    }
    public function updateEstadoCPE($tipo, $id, $external_id, $estado_api)
    {
        $query = "update $tipo set estado_api='" . $estado_api . "' "
            . " where id=" . $id . " AND external_id='" . $external_id . "' ";
        //echo $query;
        return $this->db->query($query);
    }

    public function updateCPE_xml_cd($tipo, $id, $xml_link, $cdr_link, $pdf_link)
    {
        $query = "update $tipo set xml_link ='" . $xml_link . "', cdr_link='" . $cdr_link . "', pdf_link= '" . $pdf_link . "'"
            . " where id=" . $id;
        //echo $query;
        return $this->db->query($query);
    }
    public function getDataVentasDashboard()
    {

        $sql = "SELECT f.fecha fecha_emision,v.id, CONCAT(u.first_name, ' ', u.last_name) AS grifero, f.cliente AS nombre_cliente,
        v.cliente_numero_documento, f.ruc as ruc, f.serie, LPAD(f.numero, 6, '0') numero, 
        f.estado, v.created_at fecha, SUM(vp.total) total,f.envio,f.id id_doc, 'factura' tipo,
        f.estado_api,f.xml_link,f.cdr_link,f.pdf_link,f.estado_sunat
        FROM venta v
        INNER JOIN factura f ON f.venta_id=v.id
        INNER JOIN users u ON u.id=v.users_id
        INNER JOIN venta_producto vp ON vp.venta_id=v.id
       
        GROUP BY f.fecha, v.id, u.first_name, u.last_name, f.cliente,
        v.cliente_numero_documento,  f.serie, f.numero,
        f.estado, v.created_at, f.envio,f.id, tipo
        UNION
        SELECT f.fecha fecha_emision, v.id, CONCAT(u.first_name, ' ', u.last_name) AS grifero,
        f.cliente AS nombre_cliente, v.cliente_numero_documento, f.dni as ruc, f.serie, 
        LPAD(f.numero, 6, '0') numero, f.estado, v.created_at fecha, SUM(vp.total) total,f.envio,f.id id_doc, 'boleta' tipo,
        f.estado_api,f.xml_link,f.cdr_link,f.pdf_link,f.estado_sunat
        FROM venta v
        INNER JOIN boleta f ON f.venta_id=v.id
        INNER JOIN venta_producto vp ON vp.venta_id=v.id
        INNER JOIN users u ON u.id=v.users_id
       
        GROUP BY f.id, u.first_name, u.last_name, f.cliente,
        v.cliente_numero_documento,  f.serie, f.numero,
        f.estado, v.created_at, f.envio,f.id, tipo
       ";

        $query = $this->db->query($sql);

        //echo $sql;

        return  $query;
    }
    
}
