<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Members extends MY_Controller {
    public function __construct() {
        parent::__construct();

        // validate admin session redirect to login if not
		if( !$this->admin_authenticated() ) {
            redirect(base_url());
        }
        
    }

    public function index() {
        $data['title'] = 'Personal Collections | Members';
        $data['active'] = 'members';
        $data['scripts'] = [
            base_url('assets/js/admin/members.js'),
        ];
		$this->admin('admin/members', $data);
	}

    public function dtmembers() {
        $columns = [
            'first_name', 'last_name', 'email'
        ];
        $where = ['members.status'=>1];
        $select = '*';
        $join = [];
        $join_type = '';
        $search_columns = [
            'first_name', 'last_name', 'email', 'contact_info'
        ];

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $this->load->model('member_model');

        $totalData = $this->member_model->fetch($where,[],'',true);
            
        $totalFiltered = $totalData; 
            
        if(empty($this->input->post('search')['value']))
        {            
            $data = $this->member_model->get_datatable($limit,$start,$order,$dir,$where,$join,$join_type,$select);
        }
        else {
            $search = $this->input->post('search')['value']; 

            $data =  $this->member_model->get_datatable($limit,$start,$order,$dir,$where,$join,$join_type,$select,$search,$search_columns);

            $totalFiltered = $this->member_model->get_datatable($limit,$start,$order,$dir,$where,$join,$join_type,$select,$search,$search_columns,true);
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

        $this->load->model('member_model');

        // check if email already exist

        $exist = $this->member_model->checkEmailExist();

        if ($exist) {
            $output['error'] = TRUE;
            $output['message'] = 'Email already exist';
        } else {

            try {

                $input = [
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'email' => $this->input->post('email'),
                    'password' => password_hash('123', PASSWORD_DEFAULT),
                    'birthdate' => $this->input->post('birthdate'),
                    'address' => $this->input->post('address'),
                    'contact_info' => $this->input->post('contact_info'),
                ];

                $this->member_model->addMember($input);

                $output['message'] = 'Member added successfully';

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

    public function getMember() {
        $output = ['error'=>false];

        $this->load->model('member_model');

        try {

            $id = $this->input->post('memberid');

            $member = $this->member_model->getMember($id);

            $output['data'] = $member;

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

        $this->load->model('member_model');

        try {

            $id = $this->input->post('memberid');

            $data = [
                'first_name' => $this->input->post('edit_firstname'),
                'last_name' => $this->input->post('edit_lastname'),
                'birthdate' => $this->input->post('edit_birthdate'),
                'contact_info' => $this->input->post('edit_contact_info'),
                'address' => $this->input->post('edit_address'),
            ];

            $this->member_model->updateMember($data, $id);

            $output['message'] = 'Member updated successfully';

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

        $this->load->model('member_model');

        try {

            $id = $this->input->post('memberid');

            $data = [
                'status' => 0,
            ];

            $this->member_model->updateMember($data, $id);

            $output['message'] = 'Member deleted successfully';

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