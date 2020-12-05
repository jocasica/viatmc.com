<?php
    class Cliente_direccion_model extends CI_Model{
        private $tabla = 'cliente_direccion';

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
            $this->db->where('id_cliente', $id);
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

        public function seleccionar_direcciones_con_id($id_cliente) {
            $this->db->select('id, direccion,tipo_direccion');
            $this->db->from($this->tabla);
            $this->db->where('id_cliente', $id_cliente);
            $this->db->order_by('direccion', 'ASC');
            $resultado = $this->db->get()->result();
            $temp = array();
            foreach ($resultado as $key) {
                $temp[$key->id] = $key->direccion;
            }//end foreach
            return $temp;
        }//end seleccionar_direcciones_con_id


        public function seleccionar_direcciones_con_id_normal($id_cliente) {
            $this->db->select('id, direccion,tipo_direccion');
            $this->db->from($this->tabla);
            $this->db->where('id_cliente', $id_cliente);
            $this->db->order_by('direccion', 'ASC');
          
            return $this->db->get();
        }//end seleccionar_direcciones_con_id

        public function obtener_direccion($id) {
            $this->db->select('direccion');
            $this->db->from($this->tabla);
            $this->db->where('id', $id);
            $resultado = $this->db->get()->result();
            if (sizeof($resultado) > 0) {
                return $resultado[0]->direccion;
            }//end if
            else {
                return '';
            }//end else
        }//end obtener_direccion
        
    }//end class Cliente_direccion_model
?>