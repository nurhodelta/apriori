<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Category_model extends CI_Model { 
	
	public function __construct() {
		parent::__construct();	
	}

    public function fetch($where=array(),$join=array(),$type='',$count=false,$select='*', $ordercoloumn='', $orderby='', $limit='', $group_by=''){
        $this->db->select($select);
        $this->db->from('categories');
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
        $this->db->from('categories');
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

    public function addCategory($data) {
        $this->db->insert('categories', $data);
    }

    public function getCategory($id) {
        $this->db->select('*');
        $this->db->from('categories');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function updateCategory($data, $id) {
        $this->db->where('id', $id);
		$this->db->update('categories', $data);
    }

}