<?php
    class Producto_serie_model extends CI_Model{
        private $tabla = 'producto_serie';

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
            $this->db->order_by('id', 'DESC');
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

        public function seleccionar($id_producto) {
            $this->db->select('id, serie');
            $this->db->from($this->tabla);
            $this->db->where('producto_id', $id_producto);
            $this->db->where('estado', 1);
            return $this->db->get()->result();
        }//end seleccionar

    }//end class Producto_serie_model
?>
