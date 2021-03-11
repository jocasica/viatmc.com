<?php

class Guia_model extends CI_Model {
    
    public function getCorrelativo($serie) {
        return $this->db->query("SELECT CASE WHEN MAX(numero) IS NULL THEN LPAD(1, 8, '0') ELSE LPAD(MAX(numero)+1, 8, '0') END AS numero "
                . " FROM remision"
                . " WHERE serie='".$serie."'");
    }
    
    public function getRemisiones() {
        return $this->db->query("select * from remision where estado = 1 ORDER BY id desc");
    }
    
    public function crearProductoRemision($p) {
        $this->db->insert('remision_producto', $p);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    
    public function getDatosRemision($id) {
        $result = $this->db->query("select * from remision c WHERE c.id=" . $id);
        return $result->row();
    }
    
    public function getProductosRemision($id) {
        return $this->db->query("SELECT p.*,um.descripcion as unidad_medida_nombre,pr.precio_venta
        FROM remision c
        INNER JOIN remision_producto p ON p.remision_id = c.id
        INNER JOIN producto pr ON p.producto_id = pr.id
        INNER JOIN unidad_medida um ON pr.unidad_medida_id = um.id
        WHERE c.id = " . $id);
    }
    public function crearRemision($c) {
        $this->db->insert("remision", $c);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function updateRemisionIdInRemisionProducto($remisionId, $id) {
        return $this->db->query('update remision_producto set remision_id = "' . $remisionId . '" where id=' . $id);
    } 

    public function actualizar($id, $data){
        $this->db->where("id", $id);
        return $this->db->update('remision', $data);
    }//end actualizar

    
    public function obtener_serie_numero($id) {
        $this->db->select("concat(serie,'-',numero) as serie_numero");
        $this->db->from('remision');
        $this->db->where('id', $id);
        $resultado = $this->db->get()->result();
        if (sizeof($resultado) > 0) {
            return $resultado[0]->serie_numero;
        }//end if
        else {
            return '';
        }//end else
    }//end obtener_serie_numero
    
    public function obtener_correlativo($serie, $numero) {
        $this->db->select("correlativo");
        $this->db->from('remision');
        $this->db->where('serie', $serie);
        $this->db->where('numero', $numero);
        $resultado = $this->db->get()->result();
        if (sizeof($resultado) > 0) {
            return $resultado[0]->correlativo;
        }//end if
        else {
            return '';
        }//end else
    }//end obtener_correlativo
    
    public function obtener_documento_conformidad($serie, $numero) {
        $this->db->select("documento_conformidad");
        $this->db->from('remision');
        $this->db->where('serie', $serie);
        $this->db->where('numero', $numero);
        $resultado = $this->db->get()->result();
        if (sizeof($resultado) > 0) {
            return $resultado[0]->documento_conformidad;
        }//end if
        else {
            return '';
        }//end else
    }//end obtener_documento_conformidad

    public function con_guias_disponibles() {
        $query = $this->db->query(
            "SELECT r.id, r.serie, r.numero, r.estatus_id
            FROM remision r
            WHERE estatus_id = 1"
        );
        if ($query->num_rows()>0) {
            return $query->result();
        }
    }//...con_guias_disponibles

    public function upd_estatus($remision_id) {
        $data = array(
            'estatus_id' => 2
        );
        $this->db->where('id', $remision_id);
        $this->db->update('remision', $data);
    }
    public function upd_estatus_back($remision_id) {
        $data = array(
            'estatus_id' => 1
        );
        $this->db->where('id', $remision_id);
        $this->db->update('remision', $data);
    }


    public function getConfig() {
        return $this->db->query("select * from config where id=1")->row();
    }
    
    public function updateCPE($id, $external_id, $estado_api) {
        $query= "update remision set external_id ='" . $external_id . "', estado_api='". $estado_api."' "
                . " where id=" . $id;
        //echo $query;
        return $this->db->query($query);
    }
    public function updateEstadoCPE($id, $external_id, $estado_api) {
        $query= "update remision set estado_api='".$estado_api."' "
                . " where id=" . $id . " AND external_id='".$external_id."' ";
        //echo $query;
        return $this->db->query($query);
    }
}
