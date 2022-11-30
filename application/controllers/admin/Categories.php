<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends MY_Controller {
    public function __construct() {
        parent::__construct();

        // validate admin session redirect to login if not
		if( !$this->admin_authenticated() ) {
            redirect(base_url());
        }
        
    }

    public function index() {
        $data['title'] = 'Personal Collections | Categories';
        $data['active'] = 'category';
        $data['scripts'] = [
            base_url('assets/js/admin/categories.js'),
        ];
		$this->admin('admin/categories', $data);
	}

    public function dtcategories() {
        $columns = [
            'category_name'
        ];
        $where = ['categories.status'=>1];
        $select = '*';
        $join = [];
        $join_type = '';
        $search_columns = [
            'category_name'
        ];

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $this->load->model('category_model');

        $totalData = $this->category_model->fetch($where,[],'',true);
            
        $totalFiltered = $totalData; 
            
        if(empty($this->input->post('search')['value']))
        {            
            $data = $this->category_model->get_datatable($limit,$start,$order,$dir,$where,$join,$join_type,$select);
        }
        else {
            $search = $this->input->post('search')['value']; 

            $data =  $this->category_model->get_datatable($limit,$start,$order,$dir,$where,$join,$join_type,$select,$search,$search_columns);

            $totalFiltered = $this->category_model->get_datatable($limit,$start,$order,$dir,$where,$join,$join_type,$select,$search,$search_columns,true);
        }

        $json_data = [
            "draw"            => intval($this->input->post('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data   
        ];
            
        echo json_encode($json_data);
    }

    public function insert() {
        $output = ['error'=>false];

        $this->load->model('category_model');

        try {

            $input = [
                'category_name' => $this->input->post('category_name'),
            ];

            $this->category_model->addCategory($input);

            $output['message'] = 'Category added successfully';

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

    public function getCategory() {
        $output = ['error'=>false];

        $this->load->model('category_model');

        try {

            $id = $this->input->post('categoryid');

            $category = $this->category_model->getCategory($id);

            $output['data'] = $category;

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

    public function update() {
        $output = ['error'=>false];

        $this->load->model('category_model');

        try {

            $id = $this->input->post('categoryid');

            $data = [
                'category_name' => $this->input->post('edit_category_name'),
            ];

            $this->category_model->updateCategory($data, $id);

            $output['message'] = 'Category updated successfully';

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

    public function delete() {
        $output = ['error'=>false];

        $this->load->model('category_model');

        try {

            $id = $this->input->post('categoryid');

            $data = [
                'status' => 0,
            ];

            $this->category_model->updateCategory($data, $id);

            $output['message'] = 'Category deleted successfully';

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