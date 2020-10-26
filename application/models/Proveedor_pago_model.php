<?php
    class Proveedor_pago_model extends CI_Model{
        private $tabla = 'proveedor_pago';

        public function __construct(){
            parent::__construct();
        }//end __construct

        public function agregar($data) {
            $this->db->insert($this->tabla, $data);
            return $this->db->insert_id();
        }//end agregar

        public function seleccionar_todo(){
            $this->db->select('*');
            $this->db->from($this->tabla);
            return $this->db->get()->result();
        }//end seleccionar_todo

        public function eliminar($id){
            $this->db->where('id', $id);
            return $this->db->delete($this->tabla);
        }//end eliminar

        public function actualizar($id, $data){
            $this->db->where("id", $id);
            return $this->db->update($this->tabla, $data);
        }//end actualizar

        public function seleccionar_donde($constraints){
            $query = $this->db->get_where($this->tabla, $constraints);
            return $query->result();
        }//end seleccionar_donde

        public function obtener_pago($proveedor_id) {
            $this->db->select('pago');
            $this->db->from($this->tabla);
            $this->db->where('proveedor_id', $proveedor_id);
            $this->db->order_by('id', 'DESC');
            $this->db->limit(1);
            $resultado = $this->db->get()->result();
            if (sizeof($resultado) > 0) {
                return $resultado[0]->pago;
            }//end if
            else {
                return sizeof($resultado);
            }//end else
        }//end obtener_pago

        public function obtener_ultimo_pago($proveedor_id) {
            $this->db->select('pagar');
            $this->db->from($this->tabla);
            $this->db->where('proveedor_id', $proveedor_id);
            $this->db->order_by('id', 'DESC');
            $this->db->limit(1);
            $resultado = $this->db->get()->result();
            if (sizeof($resultado) > 0) {
                return $resultado[0]->pagar;
            }//end if
            else {
                return sizeof($resultado);
            }//end else
        }//end obtener_ultimo_pago

        public function obtener_total($proveedor_id) {
            $this->db->select('total');
            $this->db->from($this->tabla);
            $this->db->where('proveedor_id', $proveedor_id);
            $this->db->order_by('id', 'DESC');
            $this->db->limit(1);
            $resultado = $this->db->get()->result();
            if (sizeof($resultado) > 0) {
                return $resultado[0]->total;
            }//end if
            else {
                return sizeof($resultado);
            }//end else
        }//end obtener_total

        public function seleccionar() {
            $this->db->select("proveedor_pago.*, proveedor.id as proveedor_id, proveedor.nombre_proveedor");
            $this->db->from($this->tabla);
            $this->db->join('proveedor', 'proveedor.id=proveedor_pago.proveedor_id');
            return $this->db->get()->result();
        }//end seleccionar

        public function getNumero(){
            $this->db->select('numero');
            $this->db->from($this->tabla);
            $resultado = $this->db->get()->result();
            if (sizeof($resultado) > 0) {
                return $resultado[0]->numero;
            }//end else
            else {
                return 0;
            }//end else
        }//end getNumero

    }//end class Proveedor_pago_model
?>
