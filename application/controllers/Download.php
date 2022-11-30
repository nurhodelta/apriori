<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Download extends MY_Controller {
    public function __construct() {
        parent::__construct();
    }

	public function index($type, $code){
        if ($type == 'member') {
            $data = base_url('scan/member/'.$code);
            $this->load->model('member_model');
            $member = $this->member_model->getMemberByCode($code);
            $filename = $member->firstname.' '.$member->lastname.'.png';
        }
        header('Content-Type: image/png');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        $image = file_get_contents('https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl='.$data);
        header('Content-Length: ' . strlen($image));
        echo $image;
	}
}