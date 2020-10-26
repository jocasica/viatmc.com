<?php
    class Proveedor_model extends CI_Model{
        private $tabla = 'proveedor';

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

        public function seleccionar_con_id() {
            $this->db->select('id, nombre_proveedor');
            $this->db->from($this->tabla);
            $this->db->order_by('nombre_proveedor', 'ASC');
            $resultado = $this->db->get()->result();
            $temp = array();
            foreach ($resultado as $key) {
                $temp[$key->id] = $key->nombre_proveedor;
            }//end foreahc
            return $temp;
        }//end seleccionar_con_id

        public function obtener_nombre($id) {
            $this->db->select('nombre_proveedor');
            $this->db->from($this->tabla);
            $this->db->where('id', $id);
            $resultado = $this->db->get()->result();
            if (sizeof($resultado) > 0) {
                return $resultado[0]->nombre_proveedor;
            }//end if
            else {
                return '';
            }//end else
        }//end obtener_nombre
        
    }//end class Proveedor_model
?>