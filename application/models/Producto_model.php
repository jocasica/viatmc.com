<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Producto_model extends CI_Model
{
    private $tabla = 'producto';

    public function __construct()
    {
        parent::__construct();
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
     * Obtener todas los productos de acorde de la página actual
     *
     * @return bool|mysqli_result
     */
    public function getProductos()
    {
        $sql = "select p.id, p.image, p.codigo_barra, p.codigo_referencia,p.nombre, p.marca,p.modelo,p.stock,p.nro_seccion,p.serie, p.lote, 
        p.precio_venta, p.precio_compra, p.precio_institucional,p.precio_compra_extranjero,
        p.estado, p.estado_serie, p.tipo_registro_producto from producto p inner join unidad_medida u on p.unidad_medida_id=u.id order by p.nombre asc";
        return mysqli_query($this->getDatabaseConnection(), $sql);
    }
    public function getProductosKardex()
    {
        return $this->db->query("select p.id, p.image, p.codigo_barra, p.codigo_referencia,p.nombre, p.marca,p.modelo,p.stock,p.nro_seccion,p.serie, p.lote, 
        p.precio_venta, p.precio_compra, p.precio_institucional,p.precio_compra_extranjero,
        p.estado from producto p inner join unidad_medida u on p.unidad_medida_id=u.id order by p.nombre asc");
    }
    /**
     * Obtener el total de los productos actuales
     *
     * @return false|float
     */
    public function getProductosRows()
    {
        $conn = mysqli_connect($this->db->hostname, $this->db->username, $this->db->password, $this->db->database);
        $results_per_page = 20;
        $query = "select p.id, p.codigo_barra, p.codigo_referencia,p.nombre, p.marca,p.modelo,p.stock,p.nro_seccion,p.serie, p.lote, 
        p.precio_venta, p.precio_compra, p.precio_institucional,p.precio_compra_extranjero,
        p.estado from producto p inner join unidad_medida u on p.unidad_medida_id=u.id order by p.nombre asc";
        $result = mysqli_query($conn, $query);
        $number_of_results = mysqli_num_rows($result);
        $number_of_pages = ceil($number_of_results / $results_per_page);
        return $number_of_pages;
    }

    /**
     * Mapear los productos actuales devolviendo un array de objetos
     *
     * @return array
     */
    public function getProductosMapped()
    {
        $productos = [];
        $result = $this->getProductos();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $productos[] = (object) $row;
        }
        return array_map(static function ($a) {
            return $a;
        }, $productos);
    }

    public function getTodoProductos()
    {
        return $this->db->query("select * from producto ");
    }
    public function getAllProductos() {
        $this->db->select('*');
        $this->db->from('producto');
        $res = $this->db->get();
        return $res->result();
    }

    public function crearCotizacion($data_cotizacion) {
        $this->db->insert("cotizacion", $data_cotizacion);
        return $this->db->insert_id();
    }
    public function actualizarCotizacion($id_cotizacion, $data_cotizacion) {
        $this->db->where('id', $id_cotizacion);
        return $this->db->update('cotizacion', $data_cotizacion);
    }
    public function eliminarProductoCotizacionById($id_registro) {
        $this->db->where('id', $id_registro);
        return $this->db->delete('producto_cotizacion');
    }
    public function eliminarProductoCotizacionCaracteristicasById($id_producto_cotizacion) {
        $this->db->where('producto_cotizacion_id', $id_producto_cotizacion);
        return $this->db->delete('producto_cotizacion_caracteristica');
    }
    public function eliminarListaProductosCotizacionById($id_cotizacion) {
        $this->db->where('cotizacion_id', $id_cotizacion);
        return $this->db->delete('cotizacion_producto');
    }

    public function crearRemision($c)
    {
        $this->db->insert("remision", $c);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function updateCotizacionIdInCotizacionProducto($cotizacionId, $id)
    {
        return $this->db->query('update producto_cotizacion set cotizacion_id = "' . $cotizacionId . '" where id=' . $id);
    }

    public function updateRemisionIdInRemisionProducto($remisionId, $id)
    {
        return $this->db->query('update remision_producto set remision_id = "' . $remisionId . '" where id=' . $id);
    }

    public function updateCotizacion1($id, $moneda, $cliente_id, $diseno, $montodiseno, $acabado, $precioacabado, $cantidadacabado, $montoacabado, $descuento, $montototal, $totalpagar, $users_id)
    {
        return $this->db->query('update cotizacion set moneda = "' . $moneda . '", cliente_id = ' . $cliente_id . ', diseno = ' . $diseno . ', montodiseno = ' . $montodiseno . ', acabado = "' . $acabado . '", precioacabado = ' . $precioacabado . ', cantidadacabado = ' . $cantidadacabado . ', montoacabado = ' . $montoacabado . ', descuento = ' . str_replace(',', '.', $descuento) . ', montototal = ' . $montototal . ', totalpagar = ' . $totalpagar . ', users_id = "' . $users_id . '" where id=' . $id);
    }

    public function updateCotizacion($id, $moneda, $cliente_id, $montototal)
    {
        $montototal = empty($montototal) ? 0 : (int) $montototal;
        return $this->db->query('update cotizacion set moneda = "' . $moneda . '", cliente_id = ' . $cliente_id . ', montototal = ' . $montototal . ' where id=' . $id);
    }

    public function updateCotizacion2($id, $moneda, $cliente_id, $diseno, $montodiseno, $acabado, $precioacabado, $cantidadacabado, $montoacabado, $autorizante_id, $descuento, $montototal, $totalpagar, $users_id)
    {
        return $this->db->query('update cotizacion set moneda = "' . $moneda . '", cliente_id = ' . $cliente_id . ', diseno = ' . $diseno . ', montodiseno = ' . $montodiseno . ', acabado = "' . $acabado . '", precioacabado = ' . $precioacabado . ', cantidadacabado = ' . $cantidadacabado . ', montoacabado = ' . $montoacabado . ', autorizante_id = ' . $autorizante_id . ', descuento = ' . $descuento . ', montototal = ' . $montototal . ', totalpagar = ' . $totalpagar . ', users_id = "' . $users_id . '" where id=' . $id);
    }

    public function getServicios()
    {
        return $this->db->query("select p.id, p.descripcion, p.estado from servicio p");
    }

    public function getServiciosActivos()
    {
        return $this->db->query("select p.id, p.descripcion, p.estado from servicio p where p.estado = 1");
    }

    /*
      public function getSerieCotizacion(){
      $result =  $this->db->query("select F_MAX_SERIE_COTIZACION() serie, (SELECT COALESCE(MAX(NUMERO),0)+1 FROM cotizacion where serie = F_MAX_SERIE_COTIZACION()) numero from dual");
      return $result->row();
      } */

    public function crearServicio($s)
    {
        $this->db->insert('servicio', $s);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function editServicio($id, $descripcion, $estado)
    {
        $result = $this->db->query("update servicio set descripcion='" . $descripcion . "', estado=" . $estado . " where id = " . $id);
        return $result;
    }

    public function getProductosSerie($producto_id)
    {
        return $this->db->query("select c.proveedor,p.id, p.serie, p.estado, p.created_at, case when b.dni is null then  f.ruc  else  b.dni  end docum,
    case when b.dni is null then  f.cliente  else  b.cliente  end cliente
    from producto_serie p
    inner join compra_producto cp on cp.producto_serie_id= p.id
    inner join compra c on c.id=cp.compra_id
    left join venta_producto vp on p.id = vp.producto_serie_id
    left join factura f on f.venta_id = vp.venta_id
    left join boleta b on b.venta_id = vp.venta_id
    where p.producto_id=" . $producto_id);
    }

    public function getProductosSerieActivos($producto_id)
    {
        return $this->db->query("select c.id, c.serie, c.estado, c.created_at from producto_serie c where producto_id=" . $producto_id . " and estado=1");
    }
    public function getProductosSerieActivosById($id){
        $this->db->select('*');
        $this->db->where('producto_id', $id);
        $this->db->where('estado', 1);
        $res = $this->db->get('producto_serie');
        return $res->result();
    }
    public function restarStock($p_id, $cantidad)
    {
        return $this->db->query("update producto set stock = stock -" . $cantidad . " where id=" . $p_id);
    }

    public function sumarStock($producto_id, $cantidad)
    {
        return $this->db->query("update producto set stock = stock + " . $cantidad . " where id=" . $producto_id);
    }

    public function cambiarEstado($producto_serie_id)
    {
        return $this->db->query("update producto_serie set estado = 2 where id=" . $producto_serie_id);
    }

    public function getProductoSerie($producto_id, $limit = false)
    {
        $l = "";
        if (!$limit) {
            $l = " LIMIT 1";
        }

        $result = $this->db->query("SELECT * FROM producto_serie WHERE producto_id = " . $producto_id . $l);

        if (!$limit) {
            return $result->row();
        }

        return $result->result();
    }

    public function getProductoById($id) {
        $result = $this->db->query("select * from producto where id = " . $id . " LIMIT 1");
        return $result->row();
    }

    public function getServicioById($id)
    {
        $result = $this->db->query("select * from servicio where id = " . $id . " LIMIT 1");
        return $result->row();
    }

    public function getCodigoBarraExiste($codigo_barra)
    {
        $result = $this->db->query("select count(1) respuesta from producto where codigo_barra = '" . $codigo_barra . "'");
        return $result->row();
    }

    public function editProducto(
        $id,
        $codigo_referencia,
        $nombre,
        $tipo,
        $precio_venta,
        $precio_compra,
        $serie,
        $fabricante,
        $stock,
        $marca,
        $procedencia,
        $caracteristica1,
        $caracteristica2,
        $caracteristica3,
        $modelo,
        $nro_seccion,
        $precio_institucional,
        $precio_compra_extranjero,
        $lote,
        $estado,
        $image = NULL,
        $numero_dua,
        $presentacion,
        $ubicacion,
        $tipo_compra,
        $registro_sanitario,
        $codigo_barra,
        $trabajarConSeries

    ) {
        $updateImage = '';
        $imgParts = explode('.', $image);
        if (isset($imgParts[1]) && !empty($imgParts[1])) {
            $updateImage = "image='" . $image . "',";
        }

        $result = $this->db->query("update producto set $updateImage nombre='" . $nombre . "', tipo='" . $tipo . "', lote='" . $lote . "',
      precio_venta='" . $precio_venta . "',marca='" . $marca . "',procedencia='" . $procedencia . "',caracteristica1='" . $caracteristica1 . "',caracteristica2='" . $caracteristica2 . "',caracteristica3='" . $caracteristica3 . "' , precio_compra='" . $precio_compra . "', estado='" . $estado . "', codigo_barra='" . $codigo_barra . "', stock='" . $stock . "', fabricante='" . $fabricante . "' ,
      codigo_referencia='" . $codigo_referencia . "',
      modelo='" . $modelo . "',
      nro_seccion='" . $nro_seccion . "',
      serie='" . $serie . "',
      precio_institucional='" . $precio_institucional . "',
      precio_compra_extranjero='" . $precio_compra_extranjero . "',
      numero_dua='" . $numero_dua . "',
      presentacion='" . $presentacion . "',
      ubicacion='" . $ubicacion . "',
      tipo_compra='" . $tipo_compra . "',
      registro_sanitario='" . $registro_sanitario . "',
      estado_serie='" . $trabajarConSeries . "'
      where id = " . $id);
        return $result;
    }

    public function getProductosComprobante()
    {
        // return $this->db->query("SELECT (@i := @i + 1) as contador,
        // p.codigo_barra, p.id producto_id, nombre, p.precio_venta,
        //  p.unidad_medida_id, um.descripcion unidad_medida
        //  from producto p inner join unidad_medida um on p.unidad_medida_id=um.id cross join (select @i := -1) c");
        $query = $this->db->query("SELECT (@i := @i + 1) as contador,
        p.codigo_barra, p.id producto_id, nombre, p.precio_venta,
         p.unidad_medida_id, um.descripcion unidad_medida
         from producto p inner join unidad_medida um on p.unidad_medida_id=um.id cross join (select @i := -1) c");
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    public function crearProductoSerie($ps)
    {
        $this->db->insert('producto_serie', $ps);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function getSeriesRepetidos($series, $producto_id)
    {
        $result = $this->db->query("select count(1) respuesta from producto_serie where producto_id = " . $producto_id . " and serie ='" . $series . "'");
        return $result->row();
    }

    public function productos_con_id()
    {
        $this->db->select('id, nombre');
        $this->db->from($this->tabla);
        $this->db->where('estado', 1);
        $this->db->order_by('nombre', 'ASC');
        $resultado = $this->db->get()->result();
        $temp = array();
        foreach ($resultado as $r) {
            $temp[$r->id] = $r->nombre;
        } //end foreach
        return $temp;
    } //end productos_con_id

    public function obtener_nombre_producto($id)
    {
        $this->db->select('nombre');
        $this->db->from($this->tabla);
        $this->db->where('id', $id);
        $resultado = $this->db->get()->result();
        if (sizeof($resultado) > 0) {
            return $resultado[0]->nombre;
        } //end if
        else {
            return '';
        } //end else
    } //end obtener_nombre_producto

    /**
     * guardar
     *
     * Metodo privado utilizado para almacenar los datos de una tabla.
     *
     * @param    array    $campos        strign $tabla
     *
     * @return    array
     */
    public function guardar($campos)
    {
        $this->db->insert($this->tabla, $campos);
        return ($this->db->affected_rows() >= 1) ? ["status" => true, "id" => $this->db->insert_id()] : ["status" => false];
    }
}
