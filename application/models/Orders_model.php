<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Orders_model extends CI_Model { 
	
	public function __construct() {
		parent::__construct();	
	}

    public function fetch($where=array(),$join=array(),$type='',$count=false,$select='*', $ordercoloumn='', $orderby='', $limit='', $group_by=''){
        $this->db->select($select);
        $this->db->from('orders');
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
        $this->db->from('orders');
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

    public function addOrder($data) {
        $this->db->insert('orders', $data);
        return $this->db->insert_id();
    }

    public function addProductOrder($data) {
        $this->db->insert('order_products', $data);
    }

    public function addOutgoingStock($data) {
        $this->db->insert('outgoing_stocks', $data);
    }

    public function getProducts($id) {
        $this->db->select('products.product_name, order_products.quantity, order_price, product_id');
        $this->db->from('order_products');
        $this->db->join('products', 'products.id=order_products.product_id');
        $this->db->where('order_products.order_id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function updateOrder($data, $id) {
        $this->db->where('id', $id);
		$this->db->update('orders', $data);
    }

    public function getData($year, $month) {
        $this->db->select('SUM(total) AS total_sales');
        $this->db->from('orders');
        $this->db->where('MONTH(order_date)', $month);
        $this->db->where('YEAR(order_date)', $year);
        $query = $this->db->get();
        return $query->row();
    }

    public function getOrdersByProduct($product_id) {
        $this->db->select('*');
        $this->db->from('order_products');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function fetchIncoming($where=array(),$join=array(),$type='',$count=false,$select='*', $ordercoloumn='', $orderby='', $limit='', $group_by=''){
        $this->db->select($select);
        $this->db->from('incoming_stocks');
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

    public function get_datatableIncoming($limit,$start,$order,$dir,$where=[],$join=[], $join_type='', $select='*',$search='',$search_columns=[],$count=false,$group_by=''){
        $this->db->select($select);
        $this->db->from('incoming_stocks');
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

    public function fetchOutgoing($where=array(),$join=array(),$type='',$count=false,$select='*', $ordercoloumn='', $orderby='', $limit='', $group_by=''){
        $this->db->select($select);
        $this->db->from('outgoing_stocks');
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

    public function get_datatableOutgoing($limit,$start,$order,$dir,$where=[],$join=[], $join_type='', $select='*',$search='',$search_columns=[],$count=false,$group_by=''){
        $this->db->select($select);
        $this->db->from('outgoing_stocks');
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

}