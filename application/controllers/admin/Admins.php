<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admins extends MY_Controller {
    public function __construct() {
        parent::__construct();

        // validate admin session redirect to login if not
		if( !$this->admin_authenticated() ) {
            redirect(base_url());
        }
        
    }

	public function index() {
        $data['title'] = 'Personal Collections | Admins';
        $data['active'] = 'admins';
        $data['scripts'] = [
            base_url('assets/js/admin/admins.js'),
        ];
		$this->admin('admin/admins', $data);
	}

    public function dtadmins() {
        $columns = [
            'first_name', 'last_name', 'email'
        ];
        $where = ['users.status'=>1];
        $select = 'first_name, last_name, id, email, user_type';
        $join = [];
        $join_type = '';
        $search_columns = [
            'first_name', 'last_name', 'email'
        ];

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $this->load->model('admin_model');

        $totalData = $this->admin_model->fetch($where,[],'',true);
            
        $totalFiltered = $totalData; 
            
        if(empty($this->input->post('search')['value']))
        {            
            $data = $this->admin_model->get_datatable($limit,$start,$order,$dir,$where,$join,$join_type,$select);
        }
        else {
            $search = $this->input->post('search')['value']; 

            $data =  $this->admin_model->get_datatable($limit,$start,$order,$dir,$where,$join,$join_type,$select,$search,$search_columns);

            $totalFiltered = $this->admin_model->get_datatable($limit,$start,$order,$dir,$where,$join,$join_type,$select,$search,$search_columns,true);
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

        $this->load->model('admin_model');

        // check if email already exist

        $exist = $this->admin_model->checkEmailExist();

        if ($exist) {
            $output['error'] = TRUE;
            $output['message'] = 'Email already exist';
        } else {

            try {

                $input = [
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'email' => $this->input->post('email'),
                    'user_type' => $this->input->post('user_type'),
                    'password' => password_hash('123', PASSWORD_DEFAULT)
                ];

                $this->admin_model->addAdmin($input);

                $output['message'] = 'User added successfully';

            } catch (Throwable $t) {
                // Executed only in PHP 7, will not match in PHP 5

                $output['error'] = TRUE;
                $output['message'] = 'An error occured';

            } catch (Exception $e) {
                // Executed only in PHP 5, will not be reached in PHP 7

                $output['error'] = TRUE;
                $output['message'] = 'An error occured';
            }

        }

        echo json_encode($output);
    }

    public function getAdmin() {
        $output = ['error'=>false];

        $this->load->model('admin_model');

        try {

            $id = $this->input->post('adminid');

            $admin = $this->admin_model->getAdmin($id);

            $output['data'] = $admin;

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

        $this->load->model('admin_model');

        try {

            $id = $this->input->post('adminid');

            // get row to check email password
            $admin = $this->admin_model->getAdmin($id);

            $old_email = $admin->email;

            $data = [
                'first_name' => $this->input->post('edit_firstname'),
                'last_name' => $this->input->post('edit_lastname'),
                'user_type' => $this->input->post('edit_user_type'),
            ];

            $this->admin_model->updateAdmin($data, $id);

            $output['message'] = 'User updated successfully';

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

        $this->load->model('admin_model');

        try {

            $id = $this->input->post('adminid');

            $data = [
                'status' => 0,
            ];

            $this->admin_model->updateAdmin($data, $id);

            $output['message'] = 'User deleted successfully';

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