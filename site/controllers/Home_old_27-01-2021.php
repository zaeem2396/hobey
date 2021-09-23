<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller
{
	function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');
		$this->load->model('home_model');
		
	}
	
	function index()
	{
		$data['err_msg'] = '';
		$this->load->view('customer/index',$data);
	}
	
	function product_listing()
	{
		$data['err_msg'] = '';
		$this->load->view('customer/product_listing',$data);
	}

	function product_detail_customer($id)
	{
		$data['err_msg'] = '';
		$this->load->view('customer/product_detail',$data);
	}

	function customer_cart()
	{
		$data['err_msg'] = '';
		$this->load->view('customer/cart',$data);
	}

	function customer_checkout()
	{
		$data['err_msg'] = '';
		$this->load->view('customer/checkout',$data);
	}
	
	function customer_myaccount()
	{
		$data['err_msg'] = '';
		$this->load->view('customer/customer_myaccount',$data);
	}
	
	function login()
	{
		if($this->session->userdata('userid') != ""){
			redirect($this->config->item('base_url'));
		}
		$data['err_msg'] = '';
		$this->load->view('login',$data);
	}
	
	public function checlogin()
	{
		$data['email'] = $_POST['email'];
		$data['password'] = $_POST['password'];
		$data2 = $this->home_model->checkLogin($data);
		if($data2 == '0')
		{
			echo $data2;
		}
		else
		{
			$data1 = $this->home_model->checkLogin_active($data);
			if($data1->user_vendor == '1')
			{
				echo '2';
			}
			else if($data1->status != '0')
			{
				echo "1";
			} 
		}
	}

	function login1()
	{
        $data = array();
		$data['err_msg'] = '';
		$data['flashError'] = '';
		$this->load->library('session');
        $data = array();

			if($this->input->post("action")=="login") {
				foreach($_POST as $key => $value) {	$data[$key]=$this->input->post($key); }

				$content['email'] = $data['login_email'];
                $content['password'] = $data['login_password'];
				$checklogin = $this->home_model->userlogin($content);

				if($checklogin !='')
				{

                   $newuserdata = array(
                        'userid'  => $checklogin->id,
                        'name'  => $checklogin->name,
                        'email'  => $checklogin->email,
						'mobile'  => $checklogin->mobile,
						'user_vendor'  => $checklogin->user_vendor,
						'status'  => $checklogin->status,
						
						'logged_in' => true
					);

					$check = $this->session->set_userdata($newuserdata);

					$this->session->set_flashdata('success_login','Login Successfull!!!!');

					if($checklogin->user_vendor == 1)
					{
						if($checklogin->status == '0'){
						    redirect($this->config->item('base_url').'vendor/dashboard');
						} else {
						    redirect($this->config->item('base_url').'vendor/vendor_profile');
						}
					}
					else
					{
						 redirect($this->config->item('base_url').'distributor-profile');
						 
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
            }
			else
			{
				$this->session->set_flashdata('error_login','Please enter Correct Email & Password.');
				redirect($this->config->item('base_url').'login');
			}
			}
		}

	function distributor_profile()
	{
		$data['err_msg'] = '';
		$this->load->view('distributor_profile',$data);
	}

	function distributor_cart()
	{
		$data['err_msg'] = '';
		$this->load->view('distributor_cart',$data);
	}

	function distributor_checkout()
	{
		$data['err_msg'] = '';
		$this->load->view('distributor_checkout',$data);
	}

	function distributor_my_account()
	{
		$data['err_msg'] = '';
		$this->load->view('distributor_my_account',$data);
	}
	

	function logout()
	{
		$this->load->library('session');
		$this->session->sess_destroy();
		redirect($this->config->item('base_url'));
	}


function show_city()
	{
		$cid = $_POST['cid'];
		$sid = $_POST['sid'];
		$show_id = $_POST['show_id'];
		$data = $this->home_model->show_subcategory($cid);
		
		$html = "<select id='city_id' name='city_id[]' class='form-control jobtext' onchange='get_area(this.value,".$show_id.")'>";
		$html .= "<option value=''> Select City* </option>";
		if($data != '' && count($data) >0)
		{
			for($i=0;$i<count($data);$i++)
			{
				if($data[$i]->id==$sid){ $selected="selected"; } else { echo $selected="" ; }
				$html .= "<option value='".$data[$i]->id ."' ".$selected.">".$data[$i]->name ."</option>";
			}
		}
		$html .="</select>";
		
		echo $html;
 
	}
 

 	function show_city1()
	{
		$cid = $_POST['cid'];
		$sid = $_POST['sid'];
		$show_id = $_POST['show_id'];
		$data = $this->home_model->show_subcategory($cid);
		
		$html = "<select id='city_id' name='city_id1[]' class='form-control jobtext' onchange='get_area1(this.value,".$show_id.")'>";
		$html .= "<option value=''> Select City* </option>";
		if($data != '' && count($data) >0)
		{
			for($i=0;$i<count($data);$i++)
			{
				if($data[$i]->id==$sid){ $selected="selected"; } else { echo $selected="" ; }
				$html .= "<option value='".$data[$i]->id ."' ".$selected.">".$data[$i]->name ."</option>";
			}
		}
		$html .="</select>";
		
		echo $html;
 
	}

function show_area()
	{
		
		$cid = $_POST['cid'];
		$sid = $_POST['sid'];
		$show_id = $_POST['show_id'];
		$data = $this->home_model->show_area($cid);
		
		$html = "<select id='area_id' name='area_id[]' class='form-control jobtext' onchange='get_pincode1(this.value,".$show_id.")' >";
		$html .= "<option value=''> Select Area* </option>";
		if($data != '' && count($data) >0)
		{
			for($i=0;$i<count($data);$i++)
			{
				if($data[$i]->id==$sid){ $selected="selected"; } else { echo $selected="" ; }
				$html .= "<option value='".$data[$i]->id ."' ".$selected.">".$data[$i]->name ."</option>";
			}
		}
		$html .="</select>";
		
		echo $html;
 
	}

	function show_area1()
	{
		
		$cid = $_POST['cid'];
		$sid = $_POST['sid'];
		$show_id = $_POST['show_id'];
		$data = $this->home_model->show_area($cid);
		
		$html = "<select id='area_id' name='area_id1[]' class='form-control jobtext' onchange='get_pincode1(this.value,".$show_id.")' >";
		$html .= "<option value=''> Select Area* </option>";
		if($data != '' && count($data) >0)
		{
			for($i=0;$i<count($data);$i++)
			{
				if($data[$i]->id==$sid){ $selected="selected"; } else { echo $selected="" ; }
				$html .= "<option value='".$data[$i]->id ."' ".$selected.">".$data[$i]->name ."</option>";
			}
		}
		$html .="</select>";
		
		echo $html;
 
	}

	function show_pincode()
	{
		
		$cid = $_POST['cid'];
		$sid = $_POST['sid'];
		$data = $this->home_model->show_pincode($cid);
		
		$html = "<select id='pincode_id' name='pincode_id[]' class='form-control jobtext' >";
		$html .= "<option value=''> Select Area* </option>";
		if($data != '' && count($data) >0)
		{
			for($i=0;$i<count($data);$i++)
			{
				if($data[$i]->id==$sid){ $selected="selected"; } else { echo $selected="" ; }
				$html .= "<option value='".$data[$i]->id ."' ".$selected.">".$data[$i]->name ."</option>";
			}
		}
		$html .="</select>";
		
		echo $html;
 
	}

	function show_pincode1()
	{
		
		$cid = $_POST['cid'];
		$sid = $_POST['sid'];
		$data = $this->home_model->show_pincode($cid);
		
		$html = "<select id='pincode_id' name='pincode_id1[]' class='form-control jobtext' >";
		$html .= "<option value=''> Select Area* </option>";
		if($data != '' && count($data) >0)
		{
			for($i=0;$i<count($data);$i++)
			{
				if($data[$i]->id==$sid){ $selected="selected"; } else { echo $selected="" ; }
				$html .= "<option value='".$data[$i]->id ."' ".$selected.">".$data[$i]->name ."</option>";
			}
		}
		$html .="</select>";
		
		echo $html;
 
	}

	function distributor_product_listing($subcategory='')
	{
		$data['err_msg'] = '';
		
		$data['subcategory'] = $subcategory;
		$this->load->library('pagination');
				
		$config['per_page']= $per_page  = '100000000000';
		$pageno = $this->input->get('per_page');
		
		$url_to_paging = $this->config->item('base_url').$subcategory;

		if($pageno == '')
		{
			$pageno = '0';
		} 
		
		$data['pageno'] = $pageno;
		$data['per_page'] = $per_page;

		if($subcategory == 'all')
		{
			$data['subcateid'] = '';
			$data['subcatename'] =  '';
			$data['subcatepageurl'] = '';
			$data['catepageurl'] = '';
			$data['catename'] = '';

			$data['meta_title'] = '';
			$data['meta_keyword'] = '';
			$data['meta_description'] = '';
			
		}
		else
		{
		if($subcategory !='')
		{
			$sub_cate_data = $this->home_model->subcateid($subcategory);
			$data['subcateid'] =  $sub_cate_data->id;
			$data['subcatename'] =  $sub_cate_data->name;
			$data['subcatepageurl'] =  $sub_cate_data->page_url;
			$data['catepageurl'] =  $sub_cate_data->category_page_url;
			$data['catename'] =  $sub_cate_data->category_name;

			$data['meta_title'] = $sub_cate_data->meta_title;
			$data['meta_keyword'] = $sub_cate_data->meta_keyword;
			$data['meta_description'] = $sub_cate_data->meta_description;

		}
		else
		{
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
		$data['sort_by'] = '';
		
		if($this->input->get('brand') != ''){
			$data['brand'] = $colour1= implode(',',$this->input->get('brand'));
		} else {
			$data['brand'] = $colour1 = "";
		}

		$return = $this->home_model->allproduct($per_page,$pageno, $data);
			
		$config['base_url'] = $url_to_paging.'/?&colour[]='.$colour1.'&search='.$this->input->get("search");
			
		$config['total_rows'] = $return['count'];
		$data['totalcount'] = $return['count'];
		$data['allproduct'] = $return['result'];
		//print_r($data['allproduct']); die;
		$base_url_views =$this->config->item('base_url_views');
			  
		$config['full_tag_open'] = '<div class="pagination margin-ten no-margin-bottom">';
		$config['full_tag_close'] = '</div>';
			
		$config['first_link'] = 'First';
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
		$config['num_tag_close'] = ''; 
			
		$config['page_query_string'] = TRUE;
			
		$this->pagination->initialize($config);
		
		//$data['all_brand'] = $this->home_model->all_brand();
		$this->load->view('distributor_product_listing',$data);
	}

	function product_details($id)
	{
		$data['err_msg'] = '';
		$data['product_details'] = $this->home_model->get_product_detail($id);
		$data['relatedproduct_cat'] = $this->home_model->relatedproduct_cat($data['product_details']->id,$data['product_details']->category_id);
		//print_r($data['relatedproduct_cat']); die;
		$this->load->view('distributor_product_detail',$data);
	}

	

/* ==================sssss================ */

}