<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Incoming extends MY_Controller {
    public function __construct() {
        parent::__construct();

        // validate admin session redirect to login if not
		if( !$this->admin_authenticated() ) {
            redirect(base_url());
        }
        
    }

	public function index() {
        $data['title'] = 'Personal Collections | Incoming Stocks';
        $data['active'] = 'incoming';
        $data['scripts'] = [
            base_url('assets/js/admin/incoming.js'),
        ];
		$this->admin('admin/incoming', $data);
	}

    public function dtincoming() {
        $columns = [
            'date_added', 'product_name', 'incoming_stocks.quantity'
        ];
        $where = [];
        $select = 'incoming_stocks.date_added, product_name, incoming_stocks.quantity';
        $join = ['products'=>'products.id=incoming_stocks.product_id'];
        $join_type = 'LEFT';
        $search_columns = [
            'product_name',
        ];

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $this->load->model('orders_model');

        $totalData = $this->orders_model->fetchIncoming($where,$join,$join_type,true);
            
        $totalFiltered = $totalData; 
            
        if(empty($this->input->post('search')['value']))
        {            
            $data = $this->orders_model->get_datatableIncoming($limit,$start,$order,$dir,$where,$join,$join_type,$select);
        }
        else {
            $search = $this->input->post('search')['value']; 

            $data =  $this->orders_model->get_datatableIncoming($limit,$start,$order,$dir,$where,$join,$join_type,$select,$search,$search_columns);

            $totalFiltered = $this->orders_model->get_datatableIncoming($limit,$start,$order,$dir,$where,$join,$join_type,$select,$search,$search_columns,true);
        }

        $json_data = [
            "draw"            => intval($this->input->post('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data   
        ];
            
        echo json_encode($json_data);
    }

    public function products() {
        $this->load->model('products_model');
        if (isset($_GET['term'])) {
            $search = $_GET['term']['term'];
            $products = $this->products_model->fetchSearch($search);
            echo json_encode($products);
            exit();
        }
        $products = $this->products_model->fetch(['status'=>1],[],'',false,'id, product_name AS text');
        echo json_encode($products);
    }

    public function insert() {
        $output = ['error'=>false];

        $this->load->model('products_model');

        try {

            $product_id = $this->input->post('product_id');

            // update product
            $product = $this->products_model->getProduct($product_id);

            $pdata = [
                'quantity' => $product->quantity + $this->input->post('quantity')
            ];

            $this->products_model->updateProduct($pdata, $product_id);

            // add to incoming
            $data = [
                'product_id' => $product_id,
                'quantity' => $this->input->post('quantity'),
                'date_added' => date('Y-m-d H:i:s')
            ];

            $this->products_model->addStock($data);

            $output['message'] = 'Incoming stock added successfully';

        } catch (Throwable $t) {
            // Executed only in PHP 7, will not match in PHP 5

            $output['error'] = TRUE;
            $output['message'] = 'An error occured';

        } catch (Exception $e) {
            // Executed only in PHP 5, will not be reached in PHP 7

            $output['error'] = TRUE;
            $output['message'] = 'An error occured';
        }

        echo json_encode($output);
    }

}