<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Home extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');
		$this->load->model('home_model');
		$this->load->model('vendor_model');
		$this->load->model('cart_model');
	}

	function index()
	{
		$data['err_msg'] = '';
		//$return = $this->home_model->allproductCustomerlatest();
		$data['allproductLatest'] = $return['result'];
		//print_R($data['allproductLatest']); die;
		$data['allproductfeatured'] = $this->home_model->allproductCustomerFeatured();
		$data['allbanners'] = $this->home_model->allbanners();
		//echo "<pre>"; print_r($data['allproductfeatured']); die;
		$this->load->view('customer/index', $data);
	}

	function product_listing($subcategory = '')
	{
		$data['err_msg'] = '';
		$data['subcategory'] = $subcategory;
		$this->load->library('pagination');

		$config['per_page'] = $per_page  = '12';
		$pageno = $this->input->get('per_page');

		$url_to_paging = $this->config->item('base_url') . '/product-listing/' . $subcategory;

		if ($pageno == '') {
			$pageno = '0';
		}

		$data['pageno'] = $pageno;
		$data['per_page'] = $per_page;

		if ($subcategory == 'all') {
			$data['subcateid'] = '';
			$data['subcatename'] =  '';
			$data['subcatepageurl'] = '';
			$data['catepageurl'] = '';
			$data['catename'] = '';

			$data['meta_title'] = '';
			$data['meta_keyword'] = '';
			$data['meta_description'] = '';
		} else {
			if ($subcategory != '') {
				$sub_cate_data = $this->home_model->subcateid($subcategory);
				$data['subcateid'] =  $sub_cate_data->id;
				$data['subcatename'] =  $sub_cate_data->name;
				$data['subcatepageurl'] =  $sub_cate_data->page_url;
				$data['catepageurl'] =  $sub_cate_data->category_page_url;
				$data['catename'] =  $sub_cate_data->category_name;

				$data['meta_title'] = $sub_cate_data->meta_title;
				$data['meta_keyword'] = $sub_cate_data->meta_keyword;
				$data['meta_description'] = $sub_cate_data->meta_description;
			} else {
				$data['subcateid'] = '';
				$data['subcatename'] =  '';
				$data['subcatepageurl'] = '';
				$data['catepageurl'] = '';
				$data['catename'] = '';

				$data['meta_title'] = '';
				$data['meta_keyword'] = '';
				$data['meta_description'] = '';
			}
		}
		$data['search'] = $this->input->get('search');
		//$data['sort_by'] = '';

		if ($this->input->get('brand') != '') {
			$data['brand'] = $colour1 = implode(',', $this->input->get('brand'));
		} else {
			$data['brand'] = $colour1 = "";
		}
		$data['sort_by'] = $this->input->get('sort_by');
		$return = $this->home_model->allproductCustomer($per_page, $pageno, $data);

		$data['url_to_paging'] = $config['base_url'] = $url_to_paging . '/?sort_by=' . $this->input->get("sort_by");

		$config['total_rows'] = $return['count'];
		$data['totalcount'] = $return['count'];
		$data['allproduct'] = $return['result'];
		//echo "<pre>"; print_r($data['allproduct']); die;
		$base_url_views = $this->config->item('base_url_views');

		$config['full_tag_open'] = '<div class="pagination margin-ten no-margin-bottom">';
		$config['full_tag_close'] = '</div>';

		/*$config['first_link'] = 'First';
		$config['first_tag_open'] = '';
		$config['first_tag_close'] = '';

		$config['last_link'] = 'Last ';
		$config['last_tag_open'] = '';
		$config['last_tag_close'] = ''; 
			
		$config['next_link'] = '<img src="'.$base_url_views.'images/arrow-next-small.png" alt=""/>';
		$config['next_tag_open'] = '';
		$config['next_tag_close'] = '';

		$config['prev_link'] = '<img src="'.$base_url_views.'images/arrow-pre-small.png" alt=""/>';
		$config['prev_tag_open'] = '';
		$config['prev_tag_close'] = '';

		$config['cur_tag_open'] = '<a href="#" class="active">';
		$config['cur_tag_close'] = '</a>';
			
		$config['num_tag_open'] = '';
		$config['num_tag_close'] = ''; */

		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';

		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';

		$config['next_link'] = 'Next';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';

		$config['prev_link'] = 'Previous';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';

		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';

		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		$config['page_query_string'] = TRUE;

		$this->pagination->initialize($config);

		$this->load->view('customer/product_listing', $data);
	}


	function special_products()
	{
		$data['err_msg'] = '';
		$productList = '';
		$data['subcategory'] = $subcategory;
		$data['all_collections'] = $this->home_model->all_collections();
		$data['alldistributors'] = $this->home_model->spdistributors();
		// echo "<pre>";
		// var_dump($data['all_collections']);exit;
		$this->load->view('customer/special_products', $data);
	}

	function product_detail_customer($urlid)
	{
		$data['err_msg'] = '';
		$array_new = explode('-', $urlid);
		$eee = array_pop($array_new);
		//echo "<pre>";
		//print_r($array_new); die;
		$id = implode('-', $array_new);
		$data['distributor_id'] = $eee;
		$data['product_details'] = $this->home_model->get_product_detail($id);

		$data['relatedproduct_cat'] = $this->home_model->relatedproduct_cat($data['product_details']->id, $data['product_details']->material_type);
		$this->load->view('customer/product_detail', $data);
	}

	function customer_cart()
	{
		$data['err_msg'] = '';
		var_dump($data);
		exit;
		$this->load->view('customer/cart', $data);
	}

	function customer_checkout()
	{
		$data['err_msg'] = '';
		$data['user_address'] = $this->cart_model->user_address();
		$data['all_state'] = $this->home_model->all_state();
		$this->load->view('customer/checkout', $data);
	}

	/*function customer_myaccount()
	{
		$data['err_msg'] = '';
		$this->load->view('customer/customer_myaccount',$data);
	}*/

	function login()
	{
		//echo $this->session->userdata('user_vendor'); die;
		if ($this->session->userdata('userid') != "") {
			if ($this->session->userdata('user_vendor') == '1') {
				redirect($this->config->item('base_url') . 'vendor-dashboard');
			} else if ($this->session->userdata('user_vendor') == '2') {
				redirect($this->config->item('base_url') . 'distributor-profile');
			}
		}
		$data['err_msg'] = '';
		$this->load->view('login', $data);
	}

	public function checlogin()
	{
		$data['email'] = $_POST['email'];
		$data['password'] = $_POST['password'];
		$data2 = $this->home_model->checkLogin($data);

		if ($data2 == '0') {
			echo $data2;
		} else {

			$data1 = $this->home_model->checkLogin_active_new($data);
			//print_R($data1); die;
			if ($data1 == '') {
				echo '2';
			} else if ($data1->status != '0') {
				echo "1";
			}
		}
	}

	function login1()
	{
		// echo "<pre>";
		// var_dump($_POST);exit;
		$data = array();
		$data['err_msg'] = '';
		$data['flashError'] = '';
		$this->load->library('session');
		$data = array();

		if ($this->input->post("action") == "login") {
			foreach ($_POST as $key => $value) {
				$data[$key] = $this->input->post($key);
			}

			$content['email'] = $data['login_email'];
			$content['password'] = $data['login_password'];
			$checklogin = $this->home_model->userlogin($content);
			if ($checklogin != '') {

				$newuserdata = array(
					'userid'  => $checklogin->id,
					'name'  => $checklogin->name,
					'email'  => $checklogin->email,
					'mobile'  => $checklogin->mobile,
					'user_vendor'  => $checklogin->user_vendor,
					'city_id'  => $checklogin->city_id,
					'state_id'  => $checklogin->state_id,
					'pincode'  => $checklogin->pincode,
					'status'  => $checklogin->status,
					'logged_in' => true
				);
				// echo "<pre>";
				// var_dump($newuserdata);exit;
				$check = $this->session->set_userdata($newuserdata);

				$this->session->set_flashdata('success_login', 'Login Successfull!!!!');

				if ($checklogin->user_vendor == 1) {
					if ($checklogin->status == '0') {
						redirect($this->config->item('base_url') . 'vendor/dashboard');
					} else {
						redirect($this->config->item('base_url') . 'vendor/vendor_profile');
					}
				} else if ($checklogin->user_vendor == 3) {
					redirect($this->config->item('base_url') . 'deliveryboy-customer-my-order');
				} else {
					redirect($this->config->item('base_url') . 'distributor-profile');

					/*if($this->cart->total_items() > 0)
    					{
    						redirect($this->config->item('base_url').'checkout');
    					}
    					else
    					{
    					    if($this->session->userdata('redirect_url') != '') {
    					          redirect($this->session->userdata('redirect_url'));
    					    } else {
    					         redirect($this->config->item('base_url').'my-account');
    					    }
    					}*/
				}
			} else {
				$this->session->set_flashdata('error_login', 'Please enter Correct Email & Password.');
				redirect($this->config->item('base_url') . 'login');
			}
		}
	}

	function distributor_profile()
	{
		$data['err_msg'] = '';
		//$data['productCount'] = $this->home_model->productCount($this->session->userdata('userid'));
		$data['orderCount'] = $this->home_model->getDistributorTotalOrders($order_id = '', $status = '');
		$data['getOrdersCount'] = $this->home_model->getDistributorOrderscount($order_id = '', 'P');
		// echo "<pre>";var_dump($data);exit;
		$this->load->view('distributor_profile', $data);
	}

	function distributor_my_inventory()
	{
		$data['err_msg'] = '';
		$data['getDistributorOrdersCustomerStock'] = $this->home_model->getDistributorOrdersCustomerStock();
		//echo "<pre>"; print_R($data['getDistributorOrdersCustomerStock']); die;
		$this->load->view('distributor_my_inventory', $data);
	}

	function vendor_my_inventory()
	{
		$data['err_msg'] = '';
		$data['getVendorOrdersCustomerStock'] = $this->home_model->getVendorOrdersCustomerStock();
		//echo "<pre>";print_r($data['getVendorOrdersCustomerStock']);echo "</pre>";
		$this->load->view('vendor_my_inventory', $data);
	}


	function distributor_cart()
	{
		$data['err_msg'] = '';

		if ($this->cart->total_items() == '') {

			redirect($this->config->item('base_url') . 'distributor-product-listing');
		}
		$this->load->view('distributor_cart', $data);
	}

	function distributor_checkout()
	{
		$data['err_msg'] = '';
		$data['disti_address'] = $this->cart_model->disti_address();
		$data['all_state'] = $this->home_model->all_state();
		$this->load->view('distributor_checkout', $data);
	}

	function distributor_my_account()
	{
		$data['err_msg'] = '';
		if ($this->input->post("action") == "update_profile") {
			foreach ($_POST as $key => $value) {
				$data[$key] = $this->input->post($key);
			}
			$content['fname']  = $data['fname'];
			$content['mobile']  = $data['mobile'];

			$this->vendor_model->update_profile($content);
			$this->session->set_flashdata('register_success', 'Profile updated successfully');
			redirect($this->config->item('base_url') . 'distributor-my-account', 'location');
		}

		$data['profile'] = $this->vendor_model->getuserdata($this->session->userdata('userid'));
		$this->load->view('distributor_my_account', $data);
	}




	function logout()
	{
		$this->load->library('session');
		$this->session->sess_destroy();
		if ($this->session->userdata('user_vendor') != '0') {
			redirect($this->config->item('base_url') . 'login');
		} else {
			redirect($this->config->item('base_url'));
		}
	}


	function show_city()
	{
		$cid = $_POST['cid'];
		$sid = $_POST['sid'];
		$show_id = $_POST['show_id'];
		$data = $this->home_model->show_subcategory($cid);

		$html = "<select id='city_id' name='city_id[]' class='form-control jobtext' onchange='get_area(this.value," . $show_id . ")'>";
		$html .= "<option value=''> All City* </option>";
		if ($data != '' && count($data) > 0) {
			for ($i = 0; $i < count($data); $i++) {
				if ($data[$i]->id == $sid) {
					$selected = "selected";
				} else {
					echo $selected = "";
				}
				$html .= "<option value='" . $data[$i]->id . "' " . $selected . ">" . $data[$i]->name . "</option>";
			}
		}
		$html .= "</select>";

		echo $html;
	}

	function show_city_change()
	{
		$cid = $_POST['cid'];
		$sid = $_POST['sid'];
		$show_id = $_POST['show_id'];
		$data = $this->home_model->show_subcategory($cid);

		$html = "<select id='city_id' name='city_id[]' class='form-control jobtext' onchange='get_pincode1(this.value," . $show_id . ")'>";
		$html .= "<option value=''> All District* </option>";
		if ($data != '' && count($data) > 0) {
			for ($i = 0; $i < count($data); $i++) {
				if ($data[$i]->id == $sid) {
					$selected = "selected";
				} else {
					echo $selected = "";
				}
				$html .= "<option value='" . $data[$i]->id . "' " . $selected . ">" . $data[$i]->name . "</option>";
			}
		}
		$html .= "</select>";

		echo $html;
	}
	function show_city1_change()
	{
		$cid = $_POST['cid'];
		$sid = $_POST['sid'];
		$show_id = $_POST['show_id'];
		$data = $this->home_model->show_subcategory($cid);

		$html = "<select id='city_id' name='city_id1[]' class='form-control jobtext' onchange='get_pincode1(this.value," . $show_id . ")'>";
		$html .= "<option value=''> All District* </option>";
		if ($data != '' && count($data) > 0) {
			for ($i = 0; $i < count($data); $i++) {
				if ($data[$i]->id == $sid) {
					$selected = "selected";
				} else {
					echo $selected = "";
				}
				$html .= "<option value='" . $data[$i]->id . "' " . $selected . ">" . $data[$i]->name . "</option>";
			}
		}
		$html .= "</select>";

		echo $html;
	}

	function show_city1()
	{
		$cid = $_POST['cid'];
		$sid = $_POST['sid'];
		$show_id = $_POST['show_id'];
		$data = $this->home_model->show_subcategory($cid);

		$html = "<select id='city_id' name='city_id1[]' class='form-control jobtext' onchange='get_pincode1(this.value," . $show_id . ")'>";
		$html .= "<option value=''> All District* </option>";
		if ($data != '' && count($data) > 0) {
			for ($i = 0; $i < count($data); $i++) {
				if ($data[$i]->id == $sid) {
					$selected = "selected";
				} else {
					echo $selected = "";
				}
				$html .= "<option value='" . $data[$i]->id . "' " . $selected . ">" . $data[$i]->name . "</option>";
			}
		}
		$html .= "</select>";

		echo $html;
	}

	function show_area()
	{

		$cid = $_POST['cid'];
		$sid = $_POST['sid'];
		$show_id = $_POST['show_id'];
		$data = $this->home_model->show_area($cid);

		$html = "<select id='area_id' name='area_id[]' class='form-control jobtext' onchange='get_pincode1(this.value," . $show_id . ")' >";
		$html .= "<option value=''> All Area* </option>";
		if ($data != '' && count($data) > 0) {
			for ($i = 0; $i < count($data); $i++) {
				if ($data[$i]->id == $sid) {
					$selected = "selected";
				} else {
					echo $selected = "";
				}
				$html .= "<option value='" . $data[$i]->id . "' " . $selected . ">" . $data[$i]->name . "</option>";
			}
		}
		$html .= "</select>";

		echo $html;
	}

	function show_area1()
	{

		$cid = $_POST['cid'];
		$sid = $_POST['sid'];
		$show_id = $_POST['show_id'];
		$data = $this->home_model->show_area($cid);

		$html = "<select id='area_id' name='area_id1[]' class='form-control jobtext' onchange='get_pincode1(this.value," . $show_id . ")' >";
		$html .= "<option value=''> All Area* </option>";
		if ($data != '' && count($data) > 0) {
			for ($i = 0; $i < count($data); $i++) {
				if ($data[$i]->id == $sid) {
					$selected = "selected";
				} else {
					echo $selected = "";
				}
				$html .= "<option value='" . $data[$i]->id . "' " . $selected . ">" . $data[$i]->name . "</option>";
			}
		}
		$html .= "</select>";

		echo $html;
	}

	function show_pincode()
	{

		$cid = $_POST['cid'];
		$sid = $_POST['sid'];
		$data = $this->home_model->show_pincode_change($cid);

		$html = "<select id='pincode_id' name='pincode_id[]' class='form-control jobtext' >";
		$html .= "<option value=''> All Pincode* </option>";
		if ($data != '' && count($data) > 0) {
			for ($i = 0; $i < count($data); $i++) {
				if ($data[$i]->id == $sid) {
					$selected = "selected";
				} else {
					echo $selected = "";
				}
				$html .= "<option value='" . $data[$i]->id . "' " . $selected . ">" . $data[$i]->name . "</option>";
			}
		}
		$html .= "</select>";

		echo $html;
	}
	function show_pincode1_change()
	{

		$cid = $_POST['cid'];
		$sid = $_POST['sid'];
		$data = $this->home_model->show_pincode_change($cid);

		$html = "<select id='pincode_id' name='pincode_id1[]' class='form-control jobtext' >";
		$html .= "<option value=''> All Pincode* </option>";
		if ($data != '' && count($data) > 0) {
			for ($i = 0; $i < count($data); $i++) {
				if ($data[$i]->id == $sid) {
					$selected = "selected";
				} else {
					echo $selected = "";
				}
				$html .= "<option value='" . $data[$i]->id . "' " . $selected . ">" . $data[$i]->name . "</option>";
			}
		}
		$html .= "</select>";

		echo $html;
	}

	function show_pincode1()
	{

		$cid = $_POST['cid'];
		$sid = $_POST['sid'];
		$data = $this->home_model->show_pincode($cid);

		$html = "<select id='pincode_id' name='pincode_id1[]' class='form-control jobtext' >";
		$html .= "<option value=''> All Pincode* </option>";
		if ($data != '' && count($data) > 0) {
			for ($i = 0; $i < count($data); $i++) {
				if ($data[$i]->id == $sid) {
					$selected = "selected";
				} else {
					echo $selected = "";
				}
				$html .= "<option value='" . $data[$i]->id . "' " . $selected . ">" . $data[$i]->name . "</option>";
			}
		}
		$html .= "</select>";

		echo $html;
	}

	function distributor_product_listing($subcategory = '')
	{
		$data['err_msg'] = '';

		$data['subcategory'] = $subcategory;
		$this->load->library('pagination');

		$config['per_page'] = $per_page  = '100000000000';
		$pageno = $this->input->get('per_page');

		$url_to_paging = $this->config->item('base_url') . 'distributor-product-listing' . $subcategory;

		if ($pageno == '') {
			$pageno = '0';
		}

		$data['pageno'] = $pageno;
		$data['per_page'] = $per_page;

		if ($subcategory == 'all') {
			$data['subcateid'] = '';
			$data['subcatename'] =  '';
			$data['subcatepageurl'] = '';
			$data['catepageurl'] = '';
			$data['catename'] = '';

			$data['meta_title'] = '';
			$data['meta_keyword'] = '';
			$data['meta_description'] = '';
		} else {
			if ($subcategory != '') {
				$sub_cate_data = $this->home_model->subcateid($subcategory);
				$data['subcateid'] =  $sub_cate_data->id;
				$data['subcatename'] =  $sub_cate_data->name;
				$data['subcatepageurl'] =  $sub_cate_data->page_url;
				$data['catepageurl'] =  $sub_cate_data->category_page_url;
				$data['catename'] =  $sub_cate_data->category_name;

				$data['meta_title'] = $sub_cate_data->meta_title;
				$data['meta_keyword'] = $sub_cate_data->meta_keyword;
				$data['meta_description'] = $sub_cate_data->meta_description;
			} else {
				$data['subcateid'] = '';
				$data['subcatename'] =  '';
				$data['subcatepageurl'] = '';
				$data['catepageurl'] = '';
				$data['catename'] = '';

				$data['meta_title'] = '';
				$data['meta_keyword'] = '';
				$data['meta_description'] = '';
			}
		}
		$data['search'] = $this->input->get('search');
		//$data['sort_by'] = '';

		if ($this->input->get('brand') != '') {
			$data['brand'] = $colour1 = implode(',', $this->input->get('brand'));
		} else {
			$data['brand'] = $colour1 = "";
		}

		$data['sort_by'] = $this->input->get('sort_by');
		$return = $this->home_model->allproduct($per_page, $pageno, $data);
		$data['url_to_paging'] = $config['base_url'] = $url_to_paging . '/?sort_by=' . $this->input->get("sort_by");

		$config['total_rows'] = $return['count'];
		$data['totalcount'] = $return['count'];
		$data['allproduct'] = $return['result'];
		//echo "<pre>"; print_r($data['allproduct']); die;
		$base_url_views = $this->config->item('base_url_views');

		$config['full_tag_open'] = '<div class="pagination margin-ten no-margin-bottom">';
		$config['full_tag_close'] = '</div>';

		$config['first_link'] = 'First';
		$config['first_tag_open'] = '';
		$config['first_tag_close'] = '';

		$config['last_link'] = 'Last ';
		$config['last_tag_open'] = '';
		$config['last_tag_close'] = '';

		$config['next_link'] = '<img src="' . $base_url_views . 'images/arrow-next-small.png" alt=""/>';
		$config['next_tag_open'] = '';
		$config['next_tag_close'] = '';

		$config['prev_link'] = '<img src="' . $base_url_views . 'images/arrow-pre-small.png" alt=""/>';
		$config['prev_tag_open'] = '';
		$config['prev_tag_close'] = '';

		$config['cur_tag_open'] = '<a href="#" class="active">';
		$config['cur_tag_close'] = '</a>';

		$config['num_tag_open'] = '';
		$config['num_tag_close'] = '';

		$config['page_query_string'] = TRUE;

		$this->pagination->initialize($config);

		//$data['all_brand'] = $this->home_model->all_brand();
		$this->load->view('distributor_product_listing', $data);
	}

	function product_details($id)
	{
		$data['err_msg'] = '';
		$data['product_details'] = $this->home_model->get_product_detail($id);

		//echo "<pre>";print_r($product_details);echo "</pre>";exit;

		$data['relatedproduct_cat'] = $this->home_model->relatedproduct_cat($data['product_details']->id, $data['product_details']->material_type);
		//print_r($data['relatedproduct_cat']); die;
		$this->load->view('distributor_product_detail', $data);
	}


	function distributor_change_password()
	{
		$data['err_msg'] = '';
		if ($this->input->post("action") == "update_profile") {
			foreach ($_POST as $key => $value) {
				$data[$key] = $this->input->post($key);
			}
			$content['pass']  = $data['pass'];

			$this->vendor_model->update_password($content);
			$this->session->set_flashdata('register_success', 'Password updated successfully');
			redirect($this->config->item('base_url') . 'distributor-change-password', 'location');
		}

		$data['profile'] = $this->vendor_model->getuserdata($this->session->userdata('userid'));
		$this->load->view('distributor_change_password', $data);
	}

	function distributor_my_order()
	{
		$data['err_msg'] = '';
		$status = $this->input->get('status');
		$statuss = '';
		if ($status) {
			$statuss = $status;
		}
		$data['orders_list'] = $this->home_model->getDistributorOrders($id = '', $statuss);
		// echo "<pre>"; var_dump($data['orders_list']); exit;
		$this->load->view('distributor_my_order', $data);
	}

	function distributor_customer_my_order()
	{
		$data['err_msg'] = '';
		$status = $this->input->get('status');
		$statuss = '';
		if ($status) {
			$statuss = $status;
		}
		//echo $this->session->userdata("userid"); die;
		$data['orders_list'] = $this->home_model->getDistributorOrdersCustomer($id = '', $statuss);
		$data['allDeliveryBoys'] = $this->home_model->getDistributorDeliveryBoys();
		// echo "<pre>"; var_dump($data['orders_list']); exit;
		$this->load->view('distributor_customer_my_order', $data);
	}
	function deliveryboy_customer_my_order()
	{
		$data['err_msg'] = '';
		$data['orders_list'] = $this->home_model->getDeliveryBoyOrdersCustomer($id = '', $status = '');
		$this->load->view('deliveryboy_customer_my_order', $data);
	}

	function addtowishlist()
	{
		$id = $this->input->post('id');
		$rvalue =  $this->home_model->addtowishlistajax($id);
		echo $rvalue;
	}
	function distributor_wishlist()
	{
		$data['allwishlist'] = $this->home_model->wishlist($this->session->userdata('userid'));
		//echo "<pre>"; print_R($data['allwishlist']); die;
		$this->load->view('distributor_wishlist', $data);
	}

	function delete_wishlist_distributor($deleteid)
	{
		$data['L_strErrorMessage'] = "";
		$data['err_msg'] = "";
		$this->load->model('account_model');
		if ($this->account_model->delete_wishlist($deleteid)) {
			$this->session->set_flashdata('register_success', 'Product removed from Wishlist Successfully!');
		}
		redirect($this->config->item('base_url') . 'distributor-wishlist', 'location');
	}

	public function checlogin_customer()
	{
		$data['email'] = $_POST['email'];
		$data['password'] = $_POST['password'];
		$data2 = $this->home_model->checkLoginCustomer($data);
		if ($data2 == '0') {
			echo $data2;
		} else {
			$data1 = $this->home_model->checkLogin_active_new_customer($data);
			if ($data1 != '') {
				echo '2';
			} else if ($data1->status != '0') {
				echo "1";
			}
		}
	}

	function login_customer()
	{
		$data = array();
		$data['err_msg'] = '';
		$data['flashError'] = '';
		$this->load->library('session');
		$data = array();

		if ($this->input->post("action") == "login") {
			foreach ($_POST as $key => $value) {
				$data[$key] = $this->input->post($key);
			}
			$content['email'] = $data['login_email'];
			$content['password'] = $data['login_password'];
			$checklogin = $this->home_model->userlogincustomer($content);
			if ($checklogin != '') {
				$newuserdata = array(
					'userid'  => $checklogin->id,
					'name'  => $checklogin->name,
					'email'  => $checklogin->email,
					'mobile'  => $checklogin->mobile,
					'user_vendor'  => $checklogin->user_vendor,
					'status'  => $checklogin->status,
					'city_id'  => $checklogin->city_id,
					'state_id'  => $checklogin->state_id,
					'pincode'  => $checklogin->pincode,
					'logged_in' => true
				);

				$check = $this->session->set_userdata($newuserdata);

				$this->session->set_flashdata('success_login', 'Login Successfull!!!!');
				//redirect($this->config->item('base_url').'distributor-profile');					 
				if ($this->cart->total_items() > 0) {
					redirect($this->config->item('base_url') . 'customer-checkout');
				} else {
					if ($this->session->userdata('redirect_url') != '') {
						redirect($this->session->userdata('redirect_url'));
					} else {
						redirect($this->config->item('base_url'));
					}
				}
			} else {
				$this->session->set_flashdata('error_login', 'Please enter Correct Email & Password.');
				redirect($this->config->item('base_url') . 'login');
			}
		}
	}

	function checkemail()
	{
		$email = $_POST['email'];
		$data = $this->home_model->checkemail($email);
		if ($data != "") {
			echo "0";
			die;
		} else {
			echo "1";
			die;
		}
	}

	function checkemail_vendor()
	{
		$email = $_POST['email'];
		$data = $this->home_model->checkemail_vendor($email);
		if ($data != "") {
			echo "0";
			die;
		} else {
			echo "1";
			die;
		}
	}

	function register()
	{
		$data['L_strErrorMessage'] = '';
		foreach ($_POST as $key => $value) {
			$data[$key] = $this->input->post($key);
		}

		$content['name']  = $data['name'];
		$content['email']  = $data['register_email'];
		$content['password'] = $data['register_password'];
		$content['pincode'] = $data['register_pincode'];
		$content['mobile'] = $data['register_mobile'];


		if ($this->input->post("action") == "registration") {
			$id = $this->home_model->add_user_data($content);
			$userdata = $this->home_model->userdata($id);
			$this->load->library('session');

			$newuserdata = array(
				'userid'  => $userdata->id,
				'name'  => $userdata->name,
				'email'  => $userdata->email,
				'mobile'  => $userdata->mobile,
				'user_vendor'  => $userdata->user_vendor,
				'status'  => $userdata->status,
				'city_id'  => $userdata->city_id,
				'state_id'  => $userdata->state_id,
				'pincode'  => $userdata->pincode,
				'logged_in' => true
			);

			$check = $this->session->set_userdata($newuserdata);

			$message = '<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Registration Email</title>

        <style>
            .logo {
                text-align: center;
                width: 100%;
            }
            .wrapper {
                width: 100%;
                max-width:500px;
                margin:auto;               
                font-size:14px;
                line-height:24px;
                font-family:Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;
                color:#555;
            }
            .wrapper div {                
                height: auto;
                float: left;
                margin-bottom: 15px;
				width:100%;
            }
            .text-center {
                text-align: center;                
            }
            .email-wrapper {
                padding:5px;
                border:1px solid #ccc;
				width:100%;
				
            }
            .big {
                text-align: center;
                font-size: 26px;
                color: #e31e24;
                font-weight: bold;
                margin-bottom: 0 !important;
                text-transform: uppercase;
                line-height: 34px;
            }
            .welcome {                
                font-size: 17px;                
                font-weight: bold;
            }
            .footer {
                text-align: center;
                color: #999;
                font-size: 13px;
            }
        </style>
    </head>
	
	<body>
        <div class="wrapper" >
            <div class="logo">
                <img src="' . $this->config->item('base_url_views') . 'customer/images/logo-new.png" >
            </div>
            <div class="email-wrapper" >

                <table style="border-collapse:collapse;" width="100%" border="0" cellspacing="0" cellpadding="10">                    
                  
                    <tr>
                        <td>
                            <table width="100%" border="0" cellspacing="0" cellpadding="5">                    
                               
                                <tr>
                                    <td style="font-size:18px;">Hello ,</td>
                                </tr>
                                <tr>
                                    <td style="line-height:20px;">
                                       Please find the below Register details
                                    </td>                        
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table style="border-top:3px solid #333;" bgcolor="#f7f7f7" width="100%" border="0" cellspacing="0" cellpadding="5">                    
                                <tr>
                                    <td width="50%">
									<table width="100%" border="0" cellspacing="0" cellpadding="5">    
                                        <tr><td width="100px">Name: </td><td>' . $userdata->name . '</td></tr>						
										<tr><td width="100px">Email Id: </td><td>' . $userdata->email . '</td></tr>	
										<tr><td width="100px"> Password : </td><td>' . $userdata->password . '</td></tr>
										<tr><td width="100px">Mobile No:</td><td>' . $userdata->mobile . '</td></tr>			
										<tr><td width="100px">Pincode:</td><td>' . $userdata->pincode . '</td></tr>
									</table>
									</td>	
									</tr>			
									</table>
									</td>	
									</tr>
									</table>	
					</div>
		</div>
    </body>
</html>
                ';

			$subject = "Thank you for Registration with BPCL ";
			$to = $userdata->email;

			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From:bpsmart.in <info@bpsmart.in>' . "\r\n" .
				'Reply-To: info@bpsmart.in' . "\r\n" .
				'X-Mailer: PHP/' . phpversion();
			$headers .= 'Cc: info@bpsmart.in' . "\r\n";

			mail('himansuprajapati9@gmail.com', $subject, $message, $headers);
			mail('amvisolution@gmail.com', $subject, $message, $headers);
			mail($to, $subject, $message, $headers);
			$this->session->set_flashdata('register_success', 'Your account is created sucessfully !!!!');

			redirect($_SERVER['HTTP_REFERER']);
		}
	}

	function about_bpcl()
	{
		$data['err_msg'] = '';
		$this->load->view('customer/about_bpcl', $data);
	}

	function book_form()
	{
		$data['err_msg'] = '';
		$this->load->view('customer/book_form', $data);
	}



	function contact_us()
	{
		$data['err_msg'] = '';
		$this->load->view('customer/contact_us', $data);
	}

	function complaint()
	{
		$data['err_msg'] = '';
		$this->load->view('customer/complaint', $data);
	}

	function customer_support()
	{
		$data['err_msg'] = '';
		$this->load->view('customer/customer_support', $data);
	}

	function reset_password()
	{
		$reset_email = $this->input->post("reset_email");
		$data = $this->home_model->checkemail($reset_email);
		if ($data != '') {
			$message = '<!DOCTYPE html>
			<html>
			<head>
			<title>SQ Emailer</title>
			</head>
			<body style="font-family: Arial, Helvetica, sans-serif;">
				<div  style="max-width:620px;margin: 0 auto;padding-top:20px;border: thin solid #f3f0f0;">
					<header style="text-align:center;">
						<a href="' . $this->config->item("base_url") . '"><img style="max-width:100%;display: block; text-align: center;" src="' . $this->config->item('base_url_views') . 'customer/images/logo-new.png"></a>
					</header>
					<div style="background:#ababab;padding: 7% 8% 2%;">
						<p style="font-size: 17px;letter-spacing: 0.5px;text-align:center;line-height: 30px;color:#fff;margin:0;">
							Hi ' . $data->fname . ', To reset your BPCL password, <br>
							please click the following link:
						</p>
						<h5 style="text-align: center;"><a href="' . $this->config->item("base_url") . 'home/update_password/' . $data->id . '" style="background:#fff;color:#000;text-decoration: navajowhite;padding: 8px 20px;">' . $this->config->item("base_url") . 'home/update_password/' . $data->id . '</a></h5>
					</div>
					<div style="background:#F1F1F2;text-align:center;padding: 3% 5% 1%;margin-top: 7%;">
						<p style="line-height: 30px;">If clicking the link above does not work, copy and paste the URL
						in a new browser window. The URL will expire in 24 hours for security reasons.
						If you did not make this request, simply ignore this message.</p>
						<h4 style="line-height: 30px;">Regards,<br>
						BPCL Team</h4>
					</div>
				</div>
			</body>
			</html>';

			$subject = "BPCL: Password Assistance";
			$to = $reset_email;
			$addcc = array();
			$AddAttachment = array();

			$to = $data->email;

			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: BPCL <info@bpsmart.in>' . "\r\n" .
				'Reply-To: info@bpsmart.in' . "\r\n" .
				'X-Mailer: PHP/' . phpversion();
			$headers .= 'Cc: info@bpsmart.in' . "\r\n";

			mail($to, $subject, $message, $headers);
			echo "1";
			die;
		} else {
			echo "2";
			die;
			//$this->load->view('update_password',$data);	
		}
	}

	function update_password($id)
	{
		$data['err_msg'] = '';
		if ($this->input->post('action') == 'reset_password') {
			$password = $this->input->post('new_password');
			$user_id = $this->input->post('user_id');
			$this->home_model->updatepassword($password, $user_id);
			$this->session->set_flashdata('enquery', 'Password updated successfully.');
			redirect($this->config->item('base_url'), 'location');
			/*redirect($this->config->item('base_url').'home/update_password/'.$id, 'location');*/
		}
		$data['id'] = $id;
		$this->load->view('customer/update_password', $data);
	}

	function reset_password_vendor_distri()
	{
		$reset_email = $this->input->post("reset_email");
		$data = $this->home_model->checkemail_vendor($reset_email);
		//print_r($data); die;
		if ($data != '') {
			$message = '<!DOCTYPE html>
			<html>
			<head>
			<title>SQ Emailer</title>
			</head>
			<body style="font-family: Arial, Helvetica, sans-serif;">
				<div  style="max-width:620px;margin: 0 auto;padding-top:20px;border: thin solid #f3f0f0;">
					<header style="text-align:center;">
						<a href="' . $this->config->item("base_url") . '"><img style="max-width:100%;display: block;" src="' . $this->config->item('base_url_views') . 'customer/images/logo-new.png"></a>
					</header>
					<div style="background:#ababab;padding: 7% 8% 2%;">
						<p style="font-size: 17px;letter-spacing: 0.5px;text-align:center;line-height: 30px;color:#fff;margin:0;">
							Hi ' . $data->name . ', To reset your BPCL password, <br>
							please click the following link:
						</p>
						<h5 style="text-align: center;"><a href="' . $this->config->item("base_url") . 'home/update_password/' . $data->id . '" style="background:#fff;color:#000;text-decoration: navajowhite;padding: 8px 20px;">' . $this->config->item("base_url") . 'home/update_password/' . $data->id . '</a></h5>
					</div>
					<div style="background:#F1F1F2;text-align:center;padding: 3% 5% 1%;margin-top: 7%;">
						<p style="line-height: 30px;">If clicking the link above does not work, copy and paste the URL
						in a new browser window. The URL will expire in 24 hours for security reasons.
						If you did not make this request, simply ignore this message.</p>
						<h4 style="line-height: 30px;">Regards,<br>
						BPCL Team</h4>
					</div>
				</div>
			</body>
			</html>';

			$subject = "BPCL: Password Assistance";
			$to = $reset_email;
			$addcc = array();
			$AddAttachment = array();

			$to = $data->email;

			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: BPCL <info@bpsmart.in>' . "\r\n" .
				'Reply-To: info@bpsmart.in' . "\r\n" .
				'X-Mailer: PHP/' . phpversion();
			$headers .= 'Cc: info@bpsmart.in' . "\r\n";

			mail($to, $subject, $message, $headers);
			mail('himansuprajapati9@gmail.com', $subject, $message, $headers);
			echo "1";
			die;
		} else {
			echo "2";
			die;
			//$this->load->view('update_password',$data);	
		}
	}

	function add_review()
	{
		$user_info_id = $this->input->post('user_info_id');
		$check_reivew =   $this->home_model->check_review($this->input->post('product_id'));
		// if($check_reivew =='')
		// {
		$data = array(
			'review_name' => $this->input->post('review_name'),
			'review_email' => $this->input->post('review_email'),
			'review_title' => $this->input->post('review_title'),
			'description' => $this->input->post('review_description'),
			'rating' => $this->input->post('rating_value'),
			'productid' => $this->input->post('product_id'),
			'userid' => $this->session->userdata('userid'),
			'added_date' => date('Y-m-d')
		);

		$return = $this->home_model->add_review($data);


		$this->session->set_flashdata('register_success', 'Review Added Successfully!');
		// }
		// else
		// {
		// 	$this->session->set_flashdata('register_success','Review Already added!');
		// }
		$page_url = $this->input->post('product_url');
		redirect($this->config->item('base_url') . 'product-detail/' . $page_url . '-' . $user_info_id);
	}

	function set_pincode()
	{
		$newuserdata = array(
			'check_pincode'  => $this->input->post('check_pincode'),
		);
		$this->session->set_userdata($newuserdata);
		//redirect($this->config->item('base_url'));
		redirect($_SERVER['HTTP_REFERER']);
	}

	function changeStatusmail($status, $order_item_id, $orderid)
	{
		//$status=$this->input->post("status");	
		//$trackadd=$this->input->post("tracking");	
		$this->load->model('vendor_model');
		if ($status != '') {
			$this->vendor_model->change_order_status($orderid, $status);
			if ($status == 'P') {
				$this->vendor_model->status_pedning($order_item_id, $status);
			}
			if ($status == 'S') {
				$this->vendor_model->status_shiped($order_item_id, $status);
			}
			if ($status == 'D') {
				$this->vendor_model->status_deliver($order_item_id, $status);
			}

			if ($status == 'C') {
				$this->vendor_model->status_cancel($order_item_id, $status);
			}
			$order1 = $this->home_model->getOrdersDistributor($orderid);
			//echo "<pre>"; print_R($order1); die; 
			$order = $order1[0];
			$productdetailmail = '';
			$i = 1;
			$productdetailmail .= "<table cellpadding='5' style='border-top:2px solid #000;width: 600px;text-align: center;'>";
			$productdetailmail .= "<tr>		
				<th>Sr.No</th>				
				<th>Product Name</th>		
				<th>Quantity</th>			
				<th>Price</th> 				
				<th>Total</th> 				
				</tr>";
			$pvalue = '0';
			foreach ($order['items'] as $items) {
				$productdetailmail .= " 					
					<tr>						
					<td>" . $i . "</td>				
					<td>" . $items['order_item_name'] . "</td>

					<td>" . $items['product_quantity'] . "</td>						
					<td> " . number_format($items['product_item_price']) . "</td>";

				$i++;
				$pvalue = ($pvalue + (($items['product_item_price']) * $items['product_quantity']));
				$productdetailmail .= " 	
					<td> " . number_format(($items['product_item_price']) * $items['product_quantity']) . "</td>";
				$productdetailmail .= "</tr>				
					";
			}
			$productdetailmail .= "</table></br></br>";
			$message = '<div style="width:600px; height:auto; margin:0 auto;">		
						<img src="' . $this->config->item('base_url_views') . 'customer/images/logo-new.png" style="height:auto; margin-left:170px;">	
						<p>Hello ' . $order['user_name'] . ',</p>';
			if ($status == 'P') {
				$message .= '<p>Your Order No ' . $orderid . ' is being processed. </p>';
			}
			if ($status == 'S') {
				$message .= '<p>Your Order No ' . $orderid . ' is being Shipped. </p>';
			}
			if ($status == 'D') {
				$message .= '<p>Your Order No ' . $orderid . ' is being Delivered. </p>';
			}
			if ($status == 'C') {
				$message .= '<p>Your Order No ' . $orderid . ' is being Canceled. </p>';
			}
			$message .= '<p> Order ID: ' . $orderid . '</p>';
			$message .= $productdetailmail;
			$message .= "  				</br></br>			
					<table align='right'> 		 	 
				<tr><td>Sub Total Amount: </td><td>" . number_format($pvalue) . "</td></tr>";
			if ($order['coupondiscount'] != '' && $order['coupondiscount'] != '0') {
				$message .= "<tr><td>Coupon Discount: </td><td>" . number_format($order['coupondiscount']) . "</td></tr>";
			}
			$message .= "<tr><td>Total Amount: </td><td>" . number_format($order['order_total']) . "</td></tr>";
			$message .= '</table> ';

			//$country_name = $this->orders_model->get_country_name($order['country']);
			$message .= "<table> 		

					<tr>			
						</br></br></br></br></br>	
										<td>			
				<table> 	
				<th align='left'>Shipping Address: </th>	
				<tr><td><b>Name</b> : " . $order['user_name'] . " </td></tr>		
				<tr><td>" . $order['address1'] . ",</td></tr>		
				<tr><td> " . $order['city'] . ",</td></tr>
				<tr><td> " . $order['state'] . "-" . $order['post_code'] . ",</td></tr>
				
				<tr><td>Mo - " . $order['phone_number'] . "</td></tr>		
							</table>
				</td>
				</tr>
				</table>";

			$message .= '
				</div>					 
				</div>';
			$to = $order['user_email'];
			if ($status == 'P') {
				$subject  = 'Pending Order';
			}
			if ($status == 'S') {
				$subject  = 'Shipped Order';
			}
			if ($status == 'D') {
				$subject  = 'Delivered Order';
			}
			if ($status == 'C') {
				$subject  = 'Canceled Order ';
			}
			//echo $message; die;
			if ($status != 'P') {

				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From:bpsmart.in <info@bpsmart.in>' . "\r\n" .
					'Reply-To: info@bpsmart.in' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();
				$headers .= 'Cc: info@bpsmart.in' . "\r\n";

				mail($to, $subject, $message, $headers);
				mail('amvi.himanshu@gmail.com', $subject, $message, $headers);
			}
			$this->session->set_flashdata('register_success', 'Your Order Status Update  successfully.');
		} else {
			$this->session->set_flashdata('register_success', 'Some Errors prevented from Adding!!!!');
		}
		redirect($this->config->item('base_url') . 'distributor-customer-my-order');
	}

	function assignDeliveryBoyOrder($deliveryBoyId, $orderid)
	{

		if ($deliveryBoyId != '') {
			$this->home_model->assign_delivery_boy_order($deliveryBoyId, $orderid);
			$this->session->set_flashdata('register_success', 'Delivery boy assigned successfully.');
		} else {
			$this->session->set_flashdata('register_success', 'Some Errors prevented from Adding!!!!');
		}
		redirect($this->config->item('base_url') . 'distributor-customer-my-order');
	}

	public function download_distiorder($status = '')
	{
		$this->data['startdate'] = $startdate = $this->input->post('startdate');
		$this->data['enddate'] = $enddate = $this->input->post('enddate');
		$this->data['distributor_id'] = $distributor_id = $this->input->post('distributor_id');

		$orders_list =  $this->home_model->getOrdersDistributors($order_id = '', $statuss, $startdate, $enddate, $distributor_id);
		//echo "<pre>";print_r($orders_list);echo "</pre>";
		$output = 'OrderId,OrderDate,User Name,Email,Mobile,Total';
		$output .= "\n";

		$i = 1;
		if ($orders_list != '' && count($orders_list) > 0) {
			foreach ($orders_list as  $key => $orders) {
				$order_date = strtotime($orders['cdate']);
				$mysqldate = date('F d, Y', $order_date);

				$output .= '"' . $orders['order_id'] . '","' . $mysqldate . '","' . $orders['user_name'] . '","' . $orders['user_email'] . '","' . $orders['user_mobile'] . '","' . number_format($orders['order_total'], false, '', '') . '"';
				$output .= "\n";
				$output .= ',Product Name,Unit price,Quantity,Total Price';
				$output .= "\n";
				foreach ($orders['items'] as $item) {
					$output .= ',"' . $item['order_item_name'] . '","' . number_format($item['product_item_price']) . '","' . $item['product_quantity'] . '","' . $item['product_item_price'] * $item['product_quantity'] . '"';
					$output .= "\n";
				}

				$output .= "\n";


				$i++;
			}
		}

		$filename = "distributor-order.csv";
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename=' . $filename);
		echo $output;
		//echo "<pre>";print_r($output);echo "</pre>";
		exit;
	}

	function changereceived($status, $order_item_id, $orderid)
	{
		if ($status != '') {
			$this->vendor_model->change_order_status($orderid, $status);
			$this->vendor_model->status_received($order_item_id, $status);
			$this->session->set_flashdata('register_success', 'Your Order Status Update  successfully.');
		} else {
			$this->session->set_flashdata('register_success', 'Some Errors prevented from Adding!!!!');
		}
		redirect($this->config->item('base_url') . 'distributor-my-order');
	}
	function createinvoice()
	{
		$orderid = $this->input->post("itemid");
		$data['orderid'] = $orderid;
		$this->load->model('account_model');
		$data["orderdetails"] = $this->account_model->getorderinvoice($orderid);

		$data["vendordetails"] = $this->account_model->vendordetails($data["orderdetails"][0]->vendor_id);
		$data["ship_address"] = $this->account_model->ship_address($orderid);
		$data['profile'] = $this->account_model->getuserdata($this->session->userdata('userid'));
		$html = $this->load->view('invoice', $data, true);
		echo $html;
	}
	function createinvoice_vendor()
	{
		$orderid = $this->input->post("itemid");
		$data['panel'] = $this->input->post("panel");
		$data['orderid'] = $orderid;
		$this->load->model('account_model');
		$data["orderdetails"] = $this->account_model->getorderinvoice($orderid);
		//print_r($data["orderdetails"]);die;
		$data["vendordetails"] = $this->account_model->vendordetails($data["orderdetails"][0]->distributor_id);

		$data["ship_address"] = $this->account_model->ship_address($data["orderdetails"][0]->order_id);
		$data['profile'] = $this->account_model->getuserdata($data["orderdetails"][0]->user_id);
		$html = $this->load->view('invoice', $data, true);
		echo $html;
	}

	function createinvoice_vendor_sp()
	{
		$orderid = $this->input->post("itemid");
		$data['panel'] = $this->input->post("panel");
		$data['orderid'] = $orderid;
		$this->load->model('account_model');
		$data["orderdetails"] = $this->account_model->getorderinvoice($orderid);
		//print_r($data["orderdetails"]);die;
		$data["vendordetails"] = $this->account_model->vendordetails($data["orderdetails"][0]->distributor_id);

		$data["ship_address"] = $this->account_model->ship_address($data["orderdetails"][0]->order_id);
		$data['profile'] = $this->account_model->getuserdata($data["orderdetails"][0]->user_id);
		$html = $this->load->view('invoiceSp', $data, true);
		echo $html;
	}

	function distributor_monthly_order() 
	{
		$data['all_collections'] = $this->home_model->all_collections();
		$data['alldistributors'] = $this->home_model->spdistributors();
		$data['distributorName'] = $this->home_model->getDistributorName($this->session->userdata('userid'));
		// echo "<pre>";var_dump($data['distributorName']);exit;
		$this->load->view('distributor_monthly_order', $data);
	}
}
