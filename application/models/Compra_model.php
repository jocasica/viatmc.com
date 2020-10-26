<?php


class Compra_model extends CI_Model
{
  public function getCompras(){
    return $this->db->query("select c.id, c.serie, c.proveedor, c.numero, c.fecha, sum(total) total, c.tipocambio, c.moneda, c.estado from compra c inner join compra_producto cp on c.id=cp.compra_id group by (c.id) order by c.created_at desc;");
  }
  public function crearCompra($compra){
    $this->db->insert('compra',$compra);
    $insert_id = $this->db->insert_id();
    return $insert_id;
  }
  public function crearCompraProducto($compra_detalle){
    #$re = $this->db->insert_batch('compra_producto',$cp);
    $re = $this->db->insert('compra_producto', $compra_detalle);
    return $re;
  }
  public function obtProductosCompra($compra_id){
    return $this->db->query("SELECT p.id, c.proveedor,c.garantia, p.nombre, '' serie, cp.cantidad, cp.precio_unidad, cp.precio_unidad_extranjero, '' estado FROM compra c inner join compra_producto cp on c.id=cp.compra_id inner join producto p on p.id=cp.producto_id where c.id=".$compra_id);
  }
  public function getComprasReporte()
  {

      $query = $this->db->select('c.*,u.first_name,u.last_name,p.ruc,p.nombre_proveedor')
          ->from("compra c")
          ->join('users u', ' u.id = c.users_id')
          ->join('proveedor p', ' p.id = c.proveedor')
          ->where('c.estado', 1)
          ->order_by('c.id', "DESC")
          ->get();
      return $query->result();
  }
}