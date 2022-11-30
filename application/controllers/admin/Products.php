<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends MY_Controller {
    public function __construct() {
        parent::__construct();

        // validate admin session redirect to login if not
		if( !$this->admin_authenticated() ) {
            redirect(base_url());
        }
        
    }

    public function index() {
        $data['title'] = 'Personal Collections | Products';
        $data['active'] = 'products';
        $data['scripts'] = [
            base_url('assets/js/admin/products.js'),
        ];
		$this->admin('admin/products', $data);
	}

    public function dtproducts() {
        $columns = [
            'product_name', 'location', 'categories.category_name', 'price'
        ];
        $where = ['products.status'=>1];
        $select = 'products.id AS product_id, products.*, category_name';
        $join = ['categories'=>'categories.id=products.category_id'];
        $join_type = 'LEFT';
        $search_columns = [
            'product_name', 'categories.category_name'
        ];

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $this->load->model('products_model');

        $totalData = $this->products_model->fetch($where,$join,$join_type,true);
            
        $totalFiltered = $totalData; 
            
        if(empty($this->input->post('search')['value']))
        {            
            $data = $this->products_model->get_datatable($limit,$start,$order,$dir,$where,$join,$join_type,$select);
        }
        else {
            $search = $this->input->post('search')['value']; 

            $data =  $this->products_model->get_datatable($limit,$start,$order,$dir,$where,$join,$join_type,$select,$search,$search_columns);

            $totalFiltered = $this->products_model->get_datatable($limit,$start,$order,$dir,$where,$join,$join_type,$select,$search,$search_columns,true);
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

        $this->load->model('products_model');

        try {

            if (!empty($_FILES['photo']['name'])) {	

                $product_photo = 'product-photo-'.rand(0,99999).'-'.strtotime(date("His"));

                $product_photo_config = [
                    'allowed_types'		=>		'jpg|jpeg|png',
                    'upload_path'		=>		realpath('assets/uploads/products'),
                    'max_size'			=>		2000,
                    'file_name'			=>		$product_photo,
                    'overwrite'			=>		TRUE
                ];

                $this->load->library('upload');

                $this->upload->initialize($product_photo_config);

                if ($this->upload->do_upload('photo')) {
                    $product_photo_data = $this->upload->data();
                } else {
                    $output['error'] = true;
                    $output['message'] = $this->upload->display_errors();
                    echo json_encode($output);
                    exit();
                }

            }

            $input = [
                'category_id' => $this->input->post('category_id'),
                'product_name' => $this->input->post('product_name'),
                'price' => $this->input->post('price'),
                'description' => $this->input->post('description'),
                'slug' => $this->slugify($this->input->post('product_name'))
            ];

            if (isset($product_photo_data)) {
                $input['location'] = $product_photo_data['file_name'];
            }

            $this->products_model->addProduct($input);

            $output['message'] = 'Product added successfully';

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

    public function getProduct() {
        $output = ['error'=>false];

        $this->load->model('products_model');

        try {

            $id = $this->input->post('productid');

            $product = $this->products_model->getProduct($id);

            $output['data'] = $product;

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

        $this->load->model('products_model');

        try {

            if (!empty($_FILES['photo']['name'])) {	

                $product_photo = 'product-photo-'.rand(0,99999).'-'.strtotime(date("His"));

                $product_photo_config = [
                    'allowed_types'		=>		'jpg|jpeg|png',
                    'upload_path'		=>		realpath('assets/uploads/products'),
                    'max_size'			=>		2000,
                    'file_name'			=>		$product_photo,
                    'overwrite'			=>		TRUE
                ];

                $this->load->library('upload');

                $this->upload->initialize($product_photo_config);

                if ($this->upload->do_upload('photo')) {
                    $product_photo_data = $this->upload->data();
                } else {
                    $output['error'] = true;
                    $output['message'] = $this->upload->display_errors();
                    echo json_encode($output);
                    exit();
                }

            }

            $id = $this->input->post('productid');

            $product = $this->products_model->getProduct($id);

            $data = [
                'category_id' => $this->input->post('category_id'),
                'product_name' => $this->input->post('product_name'),
                'price' => $this->input->post('price'),
                'description' => $this->input->post('description'),
            ];

            if ($product->product_name !== $this->input->post('product_name')) {
                $data['slug'] = $this->slugify($this->input->post('product_name'));
            }

            if (isset($product_photo_data)) {
                $data['location'] = $product_photo_data['file_name'];
            }

            $this->products_model->updateProduct($data, $id);

            $output['message'] = 'Product updated successfully';

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

        $this->load->model('products_model');

        try {

            $id = $this->input->post('productid');

            $data = [
                'status' => 0,
            ];

            $this->products_model->updateProduct($data, $id);

            $output['message'] = 'Product deleted successfully';

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

    public function slugify($text, string $divider = '-')
    {
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        // check if slug is present
        $this->load->model('products_model');

        $present = $this->products_model->checkSlug($text);

        if ($present) {
            return $this->slugify($text.'-1');
        }

        return $text;
    }

    public function categories() {
        $output = ['error'=>false];

        $this->load->model('category_model');

        try {

            $categories = $this->category_model->fetch(['status'=>1]);

            $output['data'] = $categories;

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

    public function product($slug) {
        // check if slug exist
        $this->load->model('products_model');
        $product = $this->products_model->checkSlug($slug);
        if (!$product) {
            show_404();
            exit();
        }

        // add to view history
        $tz = 'Asia/Manila';
        $timestamp = time();
        $dt = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
        $dt->setTimestamp($timestamp);
        $vdata = [
            'product_id' => $product->product_id,
            'user_id' => $this->session->userdata('admin_id'),
            'date_viewed' => $dt->format('Y-m-d H:i:s'),
        ];
        $this->load->model('history_model');
        $this->history_model->addHistory($vdata);

        $data['title'] = 'Personal Collections | '.$product->product_name;
        $data['active'] = 'products';
        $data['scripts'] = [
            base_url('assets/js/admin/product.js'),
        ];
        $data['product'] = $product;
		$this->admin('admin/product', $data);
        
    }

    public function apriori() {
        $output = ['error'=>false];

        $this->load->model('orders_model');
        $this->load->model('products_model');

        try {

            $associated_products = [];
            $return_products = [];

            $product_id = $this->input->post('product_id');

            $orders = $this->orders_model->getOrdersByProduct($product_id);

            foreach ($orders as $order) {
                $order_id = $order->order_id;
                $products = $this->orders_model->getProducts($order_id);
                foreach ($products as $product) {
                    if ($product->product_id !== $product_id) {
                        if (array_key_exists($product->product_id,$associated_products)) {
                            $associated_products[$product->product_id] = $associated_products[$product->product_id] + 1;
                        } else {
                            $associated_products[$product->product_id] = 1;
                        }
                    }
                }

            }

            if ($associated_products) {
                arsort($associated_products);
                $num = 1;
                foreach ($associated_products as $product_key => $product_value) {
                    if ($num < 5) {
                        $return_products[] = $this->products_model->getProduct($product_key);
                    }
                    $num++;
                }

                $output['data'] = $return_products;
            } else {
                $output['error'] = TRUE;
                $output['message'] = 'No products to show';
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

}