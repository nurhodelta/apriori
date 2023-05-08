<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Outgoing extends MY_Controller {
    public function __construct() {
        parent::__construct();

        // validate admin session redirect to login if not
		if( !$this->admin_authenticated() ) {
            redirect(base_url());
        }
        
    }

	public function index() {
        $data['title'] = 'Personal Collections | Outgoing Stocks';
        $data['active'] = 'outgoing';
        $data['scripts'] = [
            base_url('assets/js/admin/outgoing.js'),
        ];
		$this->admin('admin/outgoing', $data);
	}

    public function dtoutgoing() {
        $columns = [
            'date_added', 'order_number', 'product_name', 'outgoing_stocks.quantity'
        ];
        $where = [];
        $select = 'outgoing_stocks.date_added, order_number, product_name, outgoing_stocks.quantity';
        $join = ['products'=>'products.id=outgoing_stocks.product_id', 'orders'=>'orders.id=outgoing_stocks.order_id'];
        $join_type = 'LEFT';
        $search_columns = [
            'product_name', 'order_number'
        ];

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $this->load->model('orders_model');

        $totalData = $this->orders_model->fetchOutgoing($where,$join,$join_type,true);
            
        $totalFiltered = $totalData; 
            
        if(empty($this->input->post('search')['value']))
        {            
            $data = $this->orders_model->get_datatableOutgoing($limit,$start,$order,$dir,$where,$join,$join_type,$select);
        }
        else {
            $search = $this->input->post('search')['value']; 

            $data =  $this->orders_model->get_datatableOutgoing($limit,$start,$order,$dir,$where,$join,$join_type,$select,$search,$search_columns);

            $totalFiltered = $this->orders_model->get_datatableOutgoing($limit,$start,$order,$dir,$where,$join,$join_type,$select,$search,$search_columns,true);
        }

        $json_data = [
            "draw"            => intval($this->input->post('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data   
        ];
            
        echo json_encode($json_data);
    }

}