<?php
class Reporte_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    } //end __construct

    public function getFacturasBetweenDateAndProduct($month, $year, $producto_id)
    {
        $query = $this->db->select('f.created_at as fecha_emision,IFNULL(CONCAT(r.serie,"-",r.numero),0) as remision,IFNULL(r.fecha_remision,0) as fecha_remision,f.cliente as tercero,CONCAT(u.first_name," ",u.last_name) as usuario,f.fecha as fecha,CONCAT(f.serie, "-",  LPAD(f.numero, 6, "0")) as numero, vp.cantidad')
            ->from('venta_producto vp')
            ->join('venta v', ' v.id = vp.venta_id')
            ->join('factura f', ' v.id = f.venta_id')
            ->join('users u', ' v.users_id = u.id')
            ->join('remision r', ' v.remision_id = r.id', 'left')
            ->where('month(v.created_at) =', $month)
            ->where('year(v.created_at) =', $year)
            ->where('vp.producto_id', $producto_id)
            ->group_start()
            ->where('f.estado_api !=', 'Anulado')
            ->or_where('f.estado_api !=', 'Por anular')
            ->group_end()
            ->get();
        return $query;
    }
    public function getFacturasAnuladasBetweenDateAndProduct($month, $year, $producto_id)
    {
        $query = $this->db->select('f.created_at as fecha_emision,IFNULL(CONCAT(r.serie,"-",r.numero),0) as remision,IFNULL(r.fecha_remision,0) as fecha_remision,f.cliente as tercero,CONCAT(u.first_name," ",u.last_name) as usuario,f.fecha as fecha,CONCAT(f.serie, "-",  LPAD(f.numero, 6, "0")) as numero, vp.cantidad')
            ->from('venta_producto vp')
            ->join('venta v', ' v.id = vp.venta_id')
            ->join('factura f', ' v.id = f.venta_id')
            ->join('users u', ' v.users_id = u.id')
            ->join('remision r', ' v.remision_id = r.id', 'left')
            ->where('month(v.created_at) =', $month)
            ->where('year(v.created_at) =', $year)
            ->where('vp.producto_id', $producto_id)
            ->group_start()
            ->where('f.estado_api =', 'Anulado')
            ->or_where('f.estado_api =', 'Por anular')
            ->group_end()
            ->get();

        return $query;
    }
    public function getBoletasBetweenDateAndProduct($month, $year, $producto_id)
    {
        $query = $this->db->select('f.created_at as fecha_emision,IFNULL(CONCAT(r.serie,"-",r.numero),0) as remision,IFNULL(r.fecha_remision,0) as fecha_remision,f.cliente as tercero,CONCAT(u.first_name," ",u.last_name) as usuario,f.fecha as fecha,CONCAT(f.serie, "-",  LPAD(f.numero, 6, "0")) as numero, vp.cantidad')
            ->from('venta_producto vp')
            ->join('venta v', ' v.id = vp.venta_id')
            ->join('boleta f', ' v.id = f.venta_id')
            ->join('users u', ' v.users_id = u.id')
            ->join('remision r', ' v.remision_id = r.id', 'left')
            ->where('month(v.created_at) =', $month)
            ->where('year(v.created_at) =', $year)
            ->where('vp.producto_id', $producto_id)
            ->group_start()
            ->where('f.estado_api !=', 'Anulado')
            ->or_where('f.estado_api !=', 'Por anular')
            ->group_end()
            ->get();
        return $query;
    }
    public function getBoletasAnuladasBetweenDateAndProduct($month, $year, $producto_id)
    {
        $query = $this->db->select('f.created_at as fecha_emision,IFNULL(CONCAT(r.serie,"-",r.numero),0) as remision,IFNULL(r.fecha_remision,0) as fecha_remision,f.cliente as tercero,CONCAT(u.first_name," ",u.last_name) as usuario,f.fecha as fecha,CONCAT(f.serie, "-",  LPAD(f.numero, 6, "0")) as numero, vp.cantidad')
            ->from('venta_producto vp')
            ->join('venta v', ' v.id = vp.venta_id')
            ->join('boleta f', ' v.id = f.venta_id')
            ->join('users u', ' v.users_id = u.id')
            ->join('remision r', ' v.remision_id = r.id', 'left')
            ->where('month(v.created_at) =', $month)
            ->where('year(v.created_at) =', $year)
            ->where('vp.producto_id', $producto_id)
            ->group_start()
            ->where('f.estado_api =', 'Anulado')
            ->or_where('f.estado_api =', 'Por anular')
            ->group_end()
            ->get();
        return $query;
    }

    public function getComprasBetweenDateAndProduct($month, $year, $producto_id)
    {
        $query = $this->db->select('c.created_at as fecha_emision,p.nombre_proveedor as tercero,CONCAT(u.first_name," ",u.last_name) as usuario,c.fecha as fecha,CONCAT(c.serie, "-",  LPAD(c.numero, 6, "0")) as numero, cp.cantidad')
            ->from('compra_producto cp')
            ->join('compra c', ' c.id = cp.compra_id')
            ->join('users u', ' c.users_id = u.id')
            ->join('proveedor p', ' c.proveedor = p.id')
            ->where('month(c.created_at) =', $month)
            ->where('year(c.created_at) =', $year)
            ->where('cp.producto_id', $producto_id)
            ->where('c.estado', 1)
            ->get();
        return $query;
    }
    public function getProductoById($producto_id)
    {
        $query = $this->db->select('*')
            ->from('producto')
            ->where('id', $producto_id)
            ->order_by('id', 'DESC')
            ->get()->row();

        return $query;
    }
    public function getStock_inicialByIdAndDate($month, $year, $producto_id)
    {
        $query = $this->db->select('*')
            ->from('stock_mensual')
            ->where('month(fecha_stock) =', $month)
            ->where('year(fecha_stock) =', $year)
            ->where('producto_id', $producto_id)
            ->order_by('id', 'DESC')
            ->get()->row();

        return $query;
    }
}//end class Proveedor_model
