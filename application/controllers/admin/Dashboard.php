<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {
    public function __construct() {
        parent::__construct();

        // validate admin session redirect to login if not
		if( !$this->admin_authenticated() ) {
            redirect(base_url());
        }
        
    }

	public function index() {
        $data['title'] = 'Personal Collections | Dashboard';
        $data['active'] = 'dashboard';
        $data['scripts'] = [
            base_url('assets/js/Chart.js'),
            base_url('assets/js/admin/dashboard.js'),
        ];
        $this->load->model('orders_model');
        $this->load->model('products_model');
        $this->load->model('member_model');
        $this->load->model('admin_model');
        $data['orders'] = $this->orders_model->fetch([],[],'',true);
        $data['products'] = $this->products_model->fetch(['status'=>1],[],'',true);
        $data['members'] = $this->member_model->fetch(['status'=>1],[],'',true);
        $data['admins'] = $this->admin_model->fetch(['status'=>1],[],'',true);
		$this->admin('admin/dashboard', $data);
	}

    public function chartdata() {
        $output = ['error'=>FALSE];
        try {

            $year = $this->input->post('year');

            $this->load->model('orders_model');

            $data = [];

            for ($i=1; $i<=12; $i++) {
                $monthly = $this->orders_model->getData($year, $i);
                $data[] = $monthly->total_sales ? round($monthly->total_sales, 2) : 0;
            }

            $output = $data;

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