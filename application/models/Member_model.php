<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Member_model extends CI_Model { 
	
	public function __construct() {
		parent::__construct();	
	}

    public function fetch($where=array(),$join=array(),$type='',$count=false,$select='*', $ordercoloumn='', $orderby='', $limit='', $group_by=''){
        $this->db->select($select);
        $this->db->from('members');
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
        $this->db->from('members');
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
        $this->db->from('members');
        $this->db->where('email', $this->input->post('email'));
        $this->db->where('status', 1);
        $query = $this->db->get();
        return $query->row() ? TRUE : FALSE;
    }

    public function addMember($data) {
        $this->db->insert('members', $data);
    }

    public function getMember($id) {
        $this->db->select('*');
        $this->db->from('members');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function updateMember($data, $id) {
        $this->db->where('id', $id);
		$this->db->update('members', $data);
    }

    public function checkEditEmail($email) {
        $this->db->select('*');
        $this->db->from('members');
        $this->db->where('email', $email);
        $this->db->where('status', 1);
        $query = $this->db->get();
        return $query->row() ? TRUE : FALSE;
    }

    public function getMemberByCode($code) {
        $this->db->select('*');
        $this->db->from('members');
        $this->db->where('member_code', $code);
        $query = $this->db->get();
        return $query->row();
    }

    public function fetchSearch($search) {
        $this->db->select('id, CONCAT(first_name, " ", last_name) AS text');
        $this->db->from('members');
        $this->db->group_start();
            $this->db->like('first_name', $search);
            $this->db->or_like('last_name', $search);
        $this->db->group_end();
        $query = $this->db->get();
        return $query->result();
    }

}