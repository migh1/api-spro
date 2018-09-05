<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_api extends CI_Model {

	public function get_usuario_by_parametro($parametro, $valor){
		$this->load->database();
		$this->db->where($parametro, trim($valor));
		$query = $this->db->get('cad_usuarios')->row_array();

		return empty($query);
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

	public function edit($id, $post){
		$this->load->database();
		if (!empty($id)) {
			$this->db->trans_start();
			$this->db->where('id', $id);
			$this->db->update('cad_usuarios', $post);

			if($this->db->trans_complete()){
				$this->db->where('id', $id);
				return $this->db->get('cad_usuarios')->row_array();
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function autenticaUsuario($login, $password, $parametro){
		$this->load->database();
		$this->db->select('id, email, username, admin');
		$this->db->where($parametro, $login);
		$this->db->where('senha', sha1($password));
		$query = $this->db->get('cad_usuarios')->row_array();

		return $query;
	}

	public function valida_usuario_edit($login, $parametro){
		if (!empty($parametro)) {
			$this->db->select('id');
			$this->db->where($parametro, $login);
			$query = $this->db->get('cad_usuarios')->row_array();
		}
	
		return !empty($query) ? $query['id'] : null;
	}

	public function valida_edit($parametro, $valor, $post_id){
		$this->load->database();
		$this->db->where($parametro, $valor);
		$this->db->where_not_in('id', $post_id);
		return $this->db->get('cad_usuarios')->row_array();
	}

	public function consulta_por_id($id){
		$this->load->database();
		$this->db->select('id, email, username, nome, data_criacao');
		$this->db->where('id', $id);
		return $this->db->get('cad_usuarios')->row_array();
	}

	public function consulta_por_username($username){
		$this->load->database();
		$this->db->select('id, email, username, nome, data_criacao');
		$this->db->where('username', $username);
		return $this->db->get('cad_usuarios')->row_array();
	}

	public function delete_por_id($id){
		$this->load->database();
		$this->db->where('id', $id);
		return $this->db->delete('cad_usuarios');
	}

	public function delete_por_username($username){
		$this->load->database();
		$this->db->where('username', $username);
		return $this->db->delete('cad_usuarios');
	}

}

?>
