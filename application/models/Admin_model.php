<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Admin_model extends CI_Model { 
	
	public function __construct() {
		parent::__construct();	
	}

    public function adminValidateToken() {
        $this->db->select('*');
		$this->db->where(array(
			'token_id'		=>	$this->session->userdata('token_id'),
			'session_id'	=>	$this->session->userdata('session_id'),
		));

		$query = $this->db->get('users');

		return ($query->num_rows() == 1) ? TRUE : FALSE;
    }

    public function getAdminDetails() {
        $id = $this->session->userdata('admin_id');
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function fetch($where=array(),$join=array(),$type='',$count=false,$select='*', $ordercoloumn='', $orderby='', $limit='', $group_by=''){
        $this->db->select($select);
        $this->db->from('users');
        if($where){
            foreach($where as $key => $value){
                $this->db->where($key, $value);
            }
        }
        if($join){
            foreach($join as $key => $value){
                $this->db->join($key, $value, $type);
            }
        }
        if($ordercoloumn) {
            $this->db->order_by($ordercoloumn, $orderby);
        }
        if($limit) {
            $this->db->limit($limit);
        }
        if($group_by) {
            $this->db->group_by($group_by);
        }
        if($count){
            return $this->db->count_all_results();
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_datatable($limit,$start,$order,$dir,$where=[],$join=[], $join_type='', $select='*',$search='',$search_columns=[],$count=false,$group_by=''){
        $this->db->select($select);
        $this->db->from('users');
        if($where){
            foreach($where as $key => $value){
                $this->db->where($key, $value);
            }
        }
        if($join){
            foreach($join as $key => $value){
                $this->db->join($key, $value, $join_type);
            }
        }
        if($search){
            $this->db->group_start();
            $num = 0;
            foreach($search_columns as $search_column){
                if($num == 0){
                    $this->db->like($search_column, $search);
                } else {
                    $this->db->or_like($search_column, $search);
                }
                $num++;
            } 
            $this->db->group_end();
        }
        $this->db->limit($limit,$start);
        $this->db->order_by($order,$dir);
        if($group_by) {
            $this->db->group_by($group_by);
        }
        if($count){
            return $this->db->count_all_results();
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function checkEmailExist() {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('email', $this->input->post('email'));
        $this->db->where('status', 1);
        $query = $this->db->get();
        return $query->row() ? TRUE : FALSE;
    }

    public function addAdmin($data) {
        $this->db->insert('users', $data);
    }

    public function getAdmin($id) {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function updateAdmin($data, $id) {
        $this->db->where('id', $id);
		$this->db->update('users', $data);
    }

    public function deleteAdmin($id) {
        $data = [
            'status' => 0
        ];
        $this->db->where('id', $id);
		$this->db->update('users', $data);
    }

    public function checkEditEmail($email) {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('email', $email);
        $this->db->where('status', 1);
        $query = $this->db->get();
        return $query->row() ? TRUE : FALSE;
    }

}