<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Auth_model extends CI_Model { 
	
	public function __construct() {
		parent::__construct();	
	}

	public function validate_admin() {
        $this->db->select('*');
        $this->db->from('users');
		$this->db->where('status', 1);
        $this->db->where('email', $this->input->post('email'));
		$query = $this->db->get();
		return ($query->num_rows() == 1) ? $query->row() : NULL;
	}

    public function updateAdminToken($tokenID, $sessionID) {
        $data = [
			'token_id'			=>		$tokenID,
			'session_id'		=>		$sessionID
        ];	
		$this->db->where('id', $this->session->userdata('admin_id'));
		$result = $this->db->update('users', $data);
		return ($result > 0) ? TRUE : FALSE;
    }

}