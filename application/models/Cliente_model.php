<?php
    class Cliente_model extends CI_Model{
        private $tabla = 'cliente';

        public function __construct(){
            parent::__construct();
        }//end __construct

        public function getClientes() {
            $this->db->select('*');
            $this->db->from($this->tabla);
            $this->db->order_by('nombre_cotizacion', 'ASC');
            $res = $this->db->get();
            return $res->result();
        } # end getClientes

        public function getClienteById($id) {
            $this->db->select('*');
            $this->db->from($this->tabla);
            $this->db->where('id', $id);
            $res = $this->db->get();
            return $res->row();
        } # end getClienteById

        public function getVendedores() {
            $this->db->select('*');
            $this->db->from('vendedor');
            $res = $this->db->get();
            return $res->result();
        } # end getVendedores

        public function agregar($data) {
            $this->db->insert($this->tabla, $data);
            return $this->db->insert_id();
        } # end agregar

        public function agregar_cliente_direccion($data) {
            $this->db->insert('cliente_direccion', $data);
            return $this->db->insert_id();
        } # end agregar cliente direccion

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

        public function obtener_con_id() {
            $this->db->select('id, nombre_cotizacion');
            $this->db->from($this->tabla);
            $this->db->order_by('nombre_cotizacion', 'ASC');
            $resultado = $this->db->get()->result();
            $temp = array();
            foreach ($resultado as $key) {
                $temp[$key->id] = $key->nombre_cotizacion;
            }//end foreach
            return $temp;
        }//end obtener_con_id

        public function obtener_nombre($id) {
            $this->db->select('nombre_cliente');
            $this->db->from($this->tabla);
            $this->db->where('id', $id);
            $resultado = $this->db->get()->result();
            if (sizeof($resultado) > 0) {
                return $resultado[0]->nombre_cliente;
            }//end if
            else {
                return '';
            }//end else
        }//end obtener_nombre

        public function obtener_numero_documento($id) {
            $this->db->select('numero_documento');
            $this->db->from($this->tabla);
            $this->db->where('id', $id);
            $resultado = $this->db->get()->result();
            if (sizeof($resultado) > 0) {
                return $resultado[0]->numero_documento;
            }//end if
            else {
                return '';
            }//end else
        }//end obtener_numero_documento

        public function obtener_tipo_documento($id) {
            $this->db->select('tipo_documento');
            $this->db->from($this->tabla);
            $this->db->where('id', $id);
            $resultado = $this->db->get()->result();
            if (sizeof($resultado) > 0) {
                return $resultado[0]->tipo_documento;
            }//end if
            else {
                return '';
            }//end else
        }//end obtener_tipo_documento

        public function obtener_direccion_principal($id) {
            $this->db->select('direccion_principal');
            $this->db->from($this->tabla);
            $this->db->where('id', $id);
            $resultado = $this->db->get()->result();
            if (sizeof($resultado) > 0) {
                return $resultado[0]->direccion_principal;
            }//end if
            else {
                return '';
            }//end else
        }//end obtener_direccion

        public function obtener_id($nombre) {
            $this->db->select('id');
            $this->db->from($this->tabla);
            $this->db->where('nombre_cliente', $nombre);
            $resultado = $this->db->get()->result();
            if (sizeof($resultado) > 0) {
                return $resultado[0]->id;
            }//end if
            else {
                return '';
            }//end else
        }//end obtener_dirobtener_ideccion

        public function obtener_telefono_principal($id) {
            $this->db->select('telefono_principal');
            $this->db->from($this->tabla);
            $this->db->where('id', $id);
            $resultado = $this->db->get()->result();
            if (sizeof($resultado) > 0) {
                return $resultado[0]->telefono_principal;
            }//end if
            else {
                return '';
            }//end else
        }//end obtener_telefono_principal

        public function obtener_email_principal($id) {
            $this->db->select('email_principal');
            $this->db->from($this->tabla);
            $this->db->where('id', $id);
            $resultado = $this->db->get()->result();
            if (sizeof($resultado) > 0) {
                return $resultado[0]->email_principal;
            }//end if
            else {
                return '';
            }//end else
        }//end obtener_email_principal

        public function obtener_id_cliente($id) {
            $this->db->select('id');
            $this->db->from($this->tabla);
            $this->db->where('id', $id);
            $resultado = $this->db->get()->result();
            if (sizeof($resultado) > 0) {
                return $resultado[0]->id;
            }//end if
            else {
                return '';
            }//end else
        }//end obtener_id_cliente

        public function cliente_cotizacion($id) {
            $this->db->select('nombre_cotizacion');
            $this->db->from($this->tabla);
            $this->db->where('id', $id);
            return $this->db->get()->result();
        }//end cliente_cotizacion
        
    }//end class Cliente_model
?>