<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_api extends CI_Model {

	public function get_usuario_by_parametro($parametro, $valor){
		$this->load->database();
		$this->db->select($parametro);
		$this->db->where($parametro, trim($valor));
		$query = $this->db->get('cad_usuarios')->row_array();

		return empty($query) ? true : false;
	}

	public function create($post){
		$this->load->database();
		$this->db->insert('cad_usuarios', $post);
		$id = $this->db->insert_id();

		if (!empty($id)) {
			$this->db->select('id, data_criacao');
			$this->db->where('id', $id);
			return $this->db->get('cad_usuarios')->row_array();
		} else {
			return false;
		}
	}
	

}

?>
