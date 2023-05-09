<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Products_model extends CI_Model { 
	
	public function __construct() {
		parent::__construct();	
	}

    public function fetch($where=array(),$join=array(),$type='',$count=false,$select='*', $ordercoloumn='', $orderby='', $limit='', $group_by=''){
        $this->db->select($select);
        $this->db->from('products');
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
        $this->db->from('products');
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

    public function addProduct($data) {
        $this->db->insert('products', $data);
        return $this->db->insert_id();
    }

    public function addStock($data) {
        $this->db->insert('incoming_stocks', $data);
    }

    public function getProduct($id) {
        $this->db->select('products.id AS product_id, products.*, category_name');
        $this->db->from('products');
        $this->db->join('categories', 'categories.id=products.category_id', 'LEFT');
        $this->db->where('products.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function updateProduct($data, $id) {
        $this->db->where('id', $id);
		$this->db->update('products', $data);
    }

    public function checkSlug($slug) {
        $this->db->select('products.id AS product_id, products.*, category_name');
        $this->db->from('products');
        $this->db->join('categories', 'categories.id=products.category_id', 'LEFT');
        $this->db->where('slug', $slug);
        $query = $this->db->get();
        return $query->row();
    }

    public function fetchSearch($search) {
        $this->db->select('id, product_name AS text');
        $this->db->from('products');
        $this->db->where('status', 1);
        $this->db->group_start();
            $this->db->like('product_name', $search);
        $this->db->group_end();
        $query = $this->db->get();
        return $query->result();
    }

}