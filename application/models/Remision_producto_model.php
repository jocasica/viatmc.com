<?php
    class Remision_producto_model extends CI_Model{
        private $tabla = 'remision_producto';

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

        public function obtener_remision($id) {
            $this->db->select('correlativo');
            $this->db->from('remision');
            $this->db->where('id', $id);
            $resultado = $this->db->get()->result();
            if (sizeof($resultado) > 0) {
                return $resultado[0]->correlativo;
            }//end if
            else {
                return '';
            }//end else
        }//end obtener_remision
        public function getRemisionProductosByRemision($id_remision)
        {
            $this->db->select('*');
            $this->db->from($this->tabla);
            $this->db->where('remision_id', $id_remision);
            return $this->db->get()->result();
        }
    
        public function updateCPE_remision($id, $external_id, $estado_api, $mensaje_api)
        {
            $query = "update remision set external_id ='" . $external_id . "',mensaje_api ='" . $mensaje_api . "', estado_api='" . $estado_api . "' "
                . " where id=" . $id;
            //echo $query;
            return $this->db->query($query);
        }
    }//end class Remision_producto_model
?>