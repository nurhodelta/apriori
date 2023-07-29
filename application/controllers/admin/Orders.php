<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends MY_Controller {
    public function __construct() {
        parent::__construct();

        // validate admin session redirect to login if not
		if( !$this->admin_authenticated() ) {
            redirect(base_url());
        }
        
    }

    public function index() {
        $data['title'] = 'Personal Collections | Orders';
        $data['active'] = 'orders';
        $data['scripts'] = [
            base_url('assets/js/admin/orders.js'),
        ];
		$this->admin('admin/orders', $data);
	}

    public function dtorders() {
        $columns = [
            'order_date', 'order_number', 'first_name', 'total'
        ];
        $where = [];
        $select = 'orders.id AS order_id, orders.*, first_name, last_name';
        $join = ['members'=>'members.id=orders.member_id'];
        $join_type = 'LEFT';
        $search_columns = [
            'first_name', 'last_name', 'order_number'
        ];

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $this->load->model('orders_model');

        $totalData = $this->orders_model->fetch($where,$join,$join_type,true);
            
        $totalFiltered = $totalData;
            
        if(empty($this->input->post('search')['value']))
        {            
            $data = $this->orders_model->get_datatable($limit,$start,$order,$dir,$where,$join,$join_type,$select);
        }
        else {
            $search = $this->input->post('search')['value']; 

            $data =  $this->orders_model->get_datatable($limit,$start,$order,$dir,$where,$join,$join_type,$select,$search,$search_columns);

            $totalFiltered = $this->orders_model->get_datatable($limit,$start,$order,$dir,$where,$join,$join_type,$select,$search,$search_columns,true);
        }

        $json_data = [
            "draw"            => intval($this->input->post('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data   
        ];
            
        echo json_encode($json_data);
    }

    public function members() {
        $this->load->model('member_model');
        if (isset($_GET['term'])) {
            $search = $_GET['term']['term'];
            $members = $this->member_model->fetchSearch($search);
            echo json_encode($members);
            exit();
        }
        $members = $this->member_model->fetch(['status'=>1],[],'',false,'id, CONCAT(first_name, " ", last_name) AS text');
        echo json_encode($members);
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

        $this->load->model('orders_model');
        $this->load->model('products_model');

        try {

            // check if order session is set
            if ($this->session->userdata('order')) {
                // insert order
                $tz = 'Asia/Manila';
                $timestamp = time();
                $dt = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
                $dt->setTimestamp($timestamp);
                $odata = [
                    'total' => $this->session->userdata('total'),
                    'order_date' => $dt->format('Y-m-d H:i:s'),
                    'member_id' => $this->session->userdata('member_id'),
                    'order_number' => $this->generateRandomString(20)
                ];

                $order_id = $this->orders_model->addOrder($odata);

                // insert order products
                foreach ($this->session->userdata('order') as $order) {
                    $product = $this->products_model->getProduct($order['product_id']);
                    $data = [
                        'product_id' => $order['product_id'],
                        'order_price' => $product->price,
                        'quantity' => $order['quantity'],
                        'order_id' => $order_id
                    ];
                    
                    $this->orders_model->addProductOrder($data);
                    // add outgoing stock
                    $odata = [
                        'product_id' => $order['product_id'],
                        'order_id' => $order_id,
                        'quantity' => $order['quantity'],
                        'date_added' => date('Y-m-d H:i:s')
                    ];
                    $this->orders_model->addOutgoingStock($odata);
                    
                    // subtract product quantity
                    $this->load->model('products_model');
                    $pdata = [
                        'quantity' => $product->quantity - $order['quantity']
                    ];
                    $this->products_model->updateProduct($pdata, $order['product_id']);
                }

                $output['message'] = 'Order added successfully';

            } else {
                $output['error'] = TRUE;
                $output['message'] = 'Something went wrong. Please make another transaction.';
            }

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

    public function display() {
        $output = ['error'=>false];

        $this->load->model('orders_model');
        $this->load->model('products_model');

        try {

            // check if any dupe product
            if (count($this->input->post('product_id')) !== count(array_unique($this->input->post('product_id')))) {
                $output['error'] = true;
                $output['message'] = 'Duplicate products detected';
                echo json_encode($output);
                exit();
            }

            // check if any of the product is out of stock
            foreach ($this->input->post('product_id') as $index => $product_id) {
                $product = $this->products_model->getProduct($product_id);
                if ($product->quantity < $this->input->post('quantity')[$index]) {
                    $output['error'] = true;
                    $output['message'] = 'Product quantity lesser than ordered quantity: '.$product->product_name.', Qty: '.$product->quantity;
                    echo json_encode($output);
                    exit();
                }
            }

            $html = '<table class="table table-bordered">';
            $html .= '<thead>';
            $html .= '<th>Product Name</th>';
            $html .= '<th>Price</th>';
            $html .= '<th>Qty</th>';
            $html .= '<th>Subtotal</th>';
            $html .= '</thead>';
            $html .= '<tbody>';

            $total = 0;
            $order = [];

            foreach ($this->input->post('product_id') as $index => $product_id) {
                $product = $this->products_model->getProduct($product_id);
                $html .= '<tr>';
                $html .= '<td>'.$product->product_name.'</td>';
                $html .= '<td>'.$product->price.'</td>';
                $html .= '<td>'.$this->input->post('quantity')[$index].'</td>';
                $html .= '<td>'.$this->input->post('quantity')[$index] * $product->price.'</td>';
                $html .= '</tr>';
                $total += $this->input->post('quantity')[$index] * $product->price;

                $order[] = [
                    'product_id' => $product_id,
                    'quantity' => $this->input->post('quantity')[$index]
                ];
            }

            $html .= '</tbody>';
            $html .= '<table>';

            // save order to session
            $this->session->set_userdata('order', $order);
            $this->session->set_userdata('total', $total);
            $this->session->set_userdata('member_id', $this->input->post('member_id'));

            $output['html'] = $html;
            $output['total'] = $total;

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

    public function getProducts() {
        $output = ['error'=>false];

        $this->load->model('orders_model');

        try {

            $id = $this->input->post('orderid');

            $products = $this->orders_model->getProducts($id);

            $output['data'] = $products;

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

    public function order($order_number) {
        $this->load->model('orders_model');
        // check if order_number exist
        $order = $this->orders_model->getOrderByNumber($order_number);
        if ($order) {
            // get pproducts
            $products = $this->orders_model->getProducts($order->id);

            $data['title'] = 'Personal Collections | Order Details';
            $data['active'] = 'orders';
            $data['scripts'] = [
                base_url('assets/js/admin/order_details.js'),
            ];
            $data['products'] = $products;
            $data['order'] = $order;
            $this->admin('admin/order_details', $data);
        } else {
            show_404();
        }
    }

}