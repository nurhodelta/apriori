<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class History extends MY_Controller {
    public function __construct() {
        parent::__construct();

        // validate admin session redirect to login if not
		if( !$this->admin_authenticated() ) {
            redirect(base_url());
        }
        
    }

	public function index() {
        $data['title'] = 'Personal Collections | View History';
        $data['active'] = 'history';
        $data['scripts'] = [
            base_url('assets/js/admin/history.js'),
        ];
		$this->admin('admin/history', $data);
	}

    public function dthistory() {
        $columns = [
            'date_viewed', 'first_name', 'product_name'
        ];
        $where = [];
        $select = 'date_viewed, first_name, last_name, product_name';
        $join = ['users'=>'users.id=history.user_id', 'products'=>'products.id=history.product_id'];
        $join_type = 'LEFT';
        $search_columns = [
            'first_name', 'last_name', 'product_name'
        ];

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $this->load->model('history_model');

        $totalData = $this->history_model->fetch($where,[],'',true);
            
        $totalFiltered = $totalData; 
            
        if(empty($this->input->post('search')['value']))
        {            
            $data = $this->history_model->get_datatable($limit,$start,$order,$dir,$where,$join,$join_type,$select);
        }
        else {
            $search = $this->input->post('search')['value']; 

            $data =  $this->history_model->get_datatable($limit,$start,$order,$dir,$where,$join,$join_type,$select,$search,$search_columns);

            $totalFiltered = $this->history_model->get_datatable($limit,$start,$order,$dir,$where,$join,$join_type,$select,$search,$search_columns,true);
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