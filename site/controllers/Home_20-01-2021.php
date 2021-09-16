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
		$this->load->view('index',$data);
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


	function vendor_login()
	{
		$data['err_msg'] = '';
		$this->load->view('vendor_login',$data);
	}

	function user_register()
	{
		$data['err_msg'] = '';

		if($this->input->post("action")=='registration')
		{
			if($this->input->post("captachcode") == $this->session->userdata('randomdata'))
			{
			$content['fname']   = $this->input->post("fname");
			$content['lname']   = $this->input->post("lname");
			$content['email']   = $this->input->post("email");
			$content['password'] = $this->input->post("password");
			$content['mobile']   = $this->input->post("mobile");
			/*$content['address']    = $this->input->post("address");
			$content['country'] = $this->input->post("country");
			$content['state']   = $this->input->post("state");
			$content['city']     = $this->input->post("city");
			$content['pincode']    = $this->input->post("pincode");*/

			$alreadyexists = $this->home_model->checkvalidemail1($content);
            if($alreadyexists =="")
			{
				$id= $this->home_model->add($content);
				$userdata = $this->home_model->userdata($id);
				$newuserdata = array(
				'userid'  => $userdata->id,
                'fname'  => $userdata->fname,
				'lname'  => $userdata->lname,
				'mobile'  => $userdata->mobile,
				'email'  => $userdata->email,
				'user_vendor'  => $userdata->user_vendor,
				'logged_in' => true

				);
			 $this->session->set_userdata($newuserdata);
				
			 $message = '<!doctype html><html lang="en"><head>
	<title>Register Email</title>
	<style>
		@import url("https://fonts.googleapis.com/css?family=Lato");
	</style> </head><body style="text-align: center;margin: 0;background: #ececec; font-family: "Lato", sans-serif;font-weight: 100;">
	<div style="max-width:630px;margin: 0 auto;border: thin solid #f3f0f0;background: #fff; border:1px solid #ccc">
		<div style="float: left; width: 100%; border-bottom:1px solid #ccc; text-align:center">
		<a href="'.$this->config->item('base_url').'"><img src="'.$this->config->item('base_url_views').'images/logo2-hori.png" style="margin-top:20px;max-width:200px;"></a>
		</div>
		<div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Hello '.$userdata->fname.' ! A Very Warm Welcome to Happy Soul ! </p>
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">We are delighted to have you Join our Community. We look forward to give you all the Support through Health, Wellness & Happiness- Products & Services. Our connection will be focused on empowering you in every possible way. With Miles of Smiles.</p>
		</div>
		<div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
						<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">With Miles of Smiles,<BR>
			Team Happy Soul</p><br>
						<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Need Help?<br>
						<a href="'.$this->config->item('base_url').'contact-us" style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Contact Us for Help & Support</a></p>
					</div>
		<div style="clear: both">
	</div></div>
</body>
</html>';
				$subject = "Thank you for Registration with HappySoul";
				$to = $userdata->email;

				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From:HappySoul <info@happysoul.in>' . "\r\n" .
					'Reply-To: info@happysoul.in' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();
				$headers .= 'Cc: info@happysoul.in' . "\r\n";
				mail($to, $subject, $message, $headers);
				mail('hello@happysoul.in', $subject, $message, $headers);
				$email_ad = $this->config->item('admin_email');
				mail($email_ad, $subject, $message, $headers);
				$this->session->set_flashdata('success_register','Register Successfully!!!!');

				if($this->cart->total_items() > 0)
					{
						redirect($this->config->item('base_url').'cart/viewcart');
					}
					else
					{
						redirect($this->config->item('base_url').'my-account');

						/*redirect($this->input->post("redirects"));
						redirect($_SERVER['HTTP_REFERER']);	*/
					}
			} else {
			    $data['err_msg'] = 'Email Id Already Exits.';
			}
		} else {
			$data['err_msg'] = 'Invalid Captacha Code.';
		}

		} 
		//print_r($data); die;

		$this->load->view('user_register',$data);
	}

	function checkemail()
	{
		$email = $_POST['email'];
		$data = $this->home_model->checkemail($email);
		if($data !=""){
			echo "0"; die;
		}else
		{
			echo "1"; die;
		}
	}
	
	function checkemail_vendor()
	{
		$email = $_POST['email'];
		$data = $this->home_model->checkemail_vendor($email);
		if($data !=""){
			echo "0"; die;
		}else
		{
			echo "1"; die;
		}
	}

	function checkpincode()
	{
		$pincode = $_POST['pincode'];
		$data = $this->home_model->checkpincode($pincode);
		if($data !=""){
			echo $data; die;
		}else
		{
			echo "0"; die;

		}
	}

	
	
	public function vendor_checlogin()
	{
		$data['email'] = $_POST['email'];
		$data['password'] = $_POST['password'];
		$data2 = $this->home_model->vendor_checkLogin($data);
		if($data2 == '0')
		{
			echo $data2;
		}
		else
		{
			$data1 = $this->home_model->vendor_checkLogin_active($data);
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
	

	

	function vendor_login1()
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
				$checklogin = $this->home_model->vendor_userlogin($content);

				if($checklogin !='')
				{

                   $newuserdata = array(
                        'userid'  => $checklogin->id,
                        'fname'  => $checklogin->fname,
                        'company_name'  => $checklogin->company_name,
						'lname'  => $checklogin->lname,
						'mobile'  => $checklogin->mobile,
						'email'  => $checklogin->email,
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
    					if($this->cart->total_items() > 0)
    					{
    						redirect($this->config->item('base_url').'cart');
    					}
    					else
    					{
    					    redirect($this->config->item('base_url').'my-account');
    					}
			    	}
            }
			else
			{
				$this->session->set_flashdata('error_login','Please enter Correct Email & Password.');
				redirect($this->config->item('base_url').'vendor-login');
			}
			}
		}

	function forgot_password()
	{
		$data['err_msg'] = '';
		$this->load->view('forgot_password',$data);
	}
	function vendor_forgot_password()
	{
		$data['err_msg'] = '';
		$this->load->view('vendor_forgot_password',$data);
	}

	function forgotpassword(){

		$is_vendor = $this->input->post('is_vendor');
		$userdata = $this->home_model->userbyemail($this->input->post('lost_email'),$is_vendor);

		if($userdata !=''){

		$message = '<!doctype html>
<html lang="en">
<head>
	<title>Forgot Password</title>
	<style>
		@import url("https://fonts.googleapis.com/css?family=Lato");
	</style> 
</head>
<body style="text-align: center;margin: 0;background: #ececec; font-family:"Lato", sans-serif;font-weight: 100;">
	<div style="max-width:630px;margin: 0 auto;border: thin solid #f3f0f0;background: #fff; border:1px solid #ccc">
		<div style="float: left; width: 100%; border-bottom:1px solid #ccc; text-align: center;">
		<a href="'.$this->config->item('base_url').'"><img src="'.$this->config->item('base_url_views').'images/logo2-hori.png" style="margin-top:20px;max-width:200px;"></a>
		</div>
		<div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Hello Valuable Shopper !</p>
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Here is the link to reset your Happy Soul Password,</p>
			<a href="#" style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;"><a href="'.$this->config->item('base_url').'reset-password/'.$userdata->id.'" target="_blank"><strong>'.$this->config->item('base_url').'reset-password/'.$userdata->id.'</strong></a></a>
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0; margin-top: 10px;">If the above link does not work, copy and paste the URL into a new browser window. The URL will expire in 24 hours for security reasons.</p>
		</div>
		
		<div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
						<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">With Miles of Smiles,<BR>
			Team Happy Soul</p><br>
						<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Need Help?<br>
						<a href="'.$this->config->item('base_url').'contact-us" style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Contact Us for Help & Support</a></p>
					</div>
		<div style="clear: both">
	</div></div>
</body>
</html>';


				$subject = "Forgot Password";
				$to = $userdata->email;

				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From: HappySoul <info@happysoul.in>' . "\r\n" .
					'Reply-To: info@happysoul.in' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();
				$headers .= 'Cc: info@happysoul.in' . "\r\n";

				mail($to, $subject, $message, $headers);
				mail('hello@happysoul.in', $subject, $message, $headers);
				$this->session->set_flashdata('success_password','Your Password reset link has been sent to '.$this->input->post('lost_email').' ');
				
		} else {
			 $this->session->set_flashdata('error_password','The email ID does not exist.');
		}
		if($is_vendor==1)
		{
			redirect($this->config->item('base_url').'vendor-forgot-password');
		}else{
			redirect($this->config->item('base_url').'forgot-password');
		}
		
	}

	function reset_password($id)
	{
		$data['err_msg'] = '';
		$data['id'] = $id;

		if($this->input->post("action")=="new_password")
			{
				foreach($_POST as $key => $value)
				{
					$data[$key]=$this->input->post($key);
				}
				$content['new_password']  = $data['new_password'];

				$this->home_model->update_password($content,$id);
				$this->session->set_flashdata('success_password','Your Password updated successfully. ');
				redirect($this->config->item('base_url').'forgot-password');
			}

		$this->load->view('reset_password',$data);
	}

	function my_account()
	{
		$data['err_msg'] = '';
		$this->load->view('my-account',$data);
	}

	function cart()
	{
		$data['err_msg'] = '';
		$this->load->view('cart',$data);
	}
	function checkout()
	{
		$data['err_msg'] = '';
		$this->load->view('checkout',$data);
	}

	
	function registration()
	{
		$data['err_msg'] = '';
			if($this->input->post("action")=="add_vendor")
			{
				$this->home_model->vendor_registration($_POST);
				$this->session->set_flashdata('success','Vendor Registration successfully');
				redirect($this->config->item('base_url').'vendor-register-thanks', 'location');
			}
			$this->load->view('registration',$data);
	}
	
	function contactus()
	{
		$data['err_msg'] = '';
		$this->load->view('contactus',$data);
	}
	
	function vendor_registration()
	{
		$data['err_msg'] = '';
		if($this->input->post("action")=="step_1")
		{
			//$this->home_model->vendor_registration($_POST);
			//$this->session->set_flashdata('success','Vendor Registration successfully');
			$mobilecode = rand(1000,9999);
			$emailcode = rand(1000,9999);
			$mobilenumber = $this->input->post("mobile");
			$emailid = $this->input->post("email");
			if($this->input->post("mobile") != '' && $this->input->post("email") != '') {
				
    		//$msg = "Your Verification for Happy Soul Vendor Account is: ".$mobilecode.". Happy Soul Team";	
    		$msg = "".$mobilecode." is your verification code for happy soul vendor account. Happy Soul Team.";
    		$message = urlencode($msg);
            
            $curl = curl_init();
            curl_setopt_array($curl, array(CURLOPT_URL =>"https://api.msg91.com/api/sendhttp.php?mobiles=$mobilenumber&authkey=310365AyMSGJwWV5e06f4e7P1&route=4&sender=HPSOUL&message=$message&country=91",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
              CURLOPT_SSL_VERIFYHOST => 0,
              CURLOPT_SSL_VERIFYPEER => 0,
            ));
    
            $response = curl_exec($curl);
            $err = curl_error($curl);
			
            curl_close($curl);

            $message = '<!doctype html><html lang="en"><head><title>Vendor Verification</title><style>@import url("https://fonts.googleapis.com/css?family=Lato");</style></head><body style="text-align: center;margin: 0;background: #ececec; font-family: "Lato", sans-serif;font-weight: 100;">
	<div style="max-width:630px;margin: 0 auto;border: thin solid #f3f0f0;background: #fff; border:1px solid #ccc">
		<div style="float: left; width: 100%; border-bottom:1px solid #ccc;text-align: center;">
		<a href="#"><img src="'.$this->config->item('base_url_views').'images/logo2-hori.png" style="margin-top:20px;max-width:200px;"></a>
		</div>
		<div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
			<h3 style="color: #000; font-size: 21px;">Account Verification Request<h3>
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Hi there!</p>
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">We got a request to create a new Happy Soul vendor account with your mobile number '.$mobilenumber.' and email ID '.$emailid.'.</p>
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;    margin: 0; ">Use the OTP '.$emailcode.'  within 48 hours to verify your email id.</p>
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">If you have not created the account with mobile number '.$mobilenumber.' or should you need any further assistance, contact our Customer Support.</p><br>
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;  margin: 0;">With Miles of Smiles,<br>
			Team Happy Soul</p><br>
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Need Help?<br>
			<a href="'.$this->config->item('base_url').'contact-us" style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100; margin: 0;">Contact Us for Help & Support</a></p>
		</div><div style="clear: both"></div></body></html>';    
            
            $subject = "Otp Verification Code - Happy Soul";
			$to = $emailid;

    		$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: HappySoul <info@happysoul.in>' . "\r\n" .
			'Reply-To: info@happysoul.in' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
			$headers .= 'Cc: info@happysoul.in' . "\r\n";
        		
    		mail($to, $subject, $message, $headers);

			$to = $this->config->item('customercare_email');
			mail($to, $subject, $message, $headers);

		    $newuserdata = array(
			'mobilecode'  => $mobilecode,
            'emailcode'  => $emailcode,
			'mobilenumber'  => $this->input->post("mobile"),
			'emailid'  => $this->input->post("email"),
			);
			
		    $this->session->set_userdata($newuserdata);
			redirect($this->config->item('base_url').'home/vendor_signup', 'location');
			
			    
			} else {
			    $data['err_msg'] = 'Some Error In Mobile Number OR Email Id';
			    $this->load->view('dashboard/vender_register',$data);
			}

		}
		$this->load->view('dashboard/vender_register',$data);
	}
	
	function mail(){
	    echo $message = '<!doctype html><html lang="en"><head><title>Vendor Verification</title><style>@import url("https://fonts.googleapis.com/css?family=Lato");</style></head><body style="text-align: center;margin: 0;background: #ececec; font-family: "Lato", sans-serif;font-weight: 100;">
	<div style="max-width:630px;margin: 0 auto;border: thin solid #f3f0f0;background: #fff; border:1px solid #ccc">
		<div style="float: left; width: 100%; border-bottom:1px solid #ccc;text-align: center;">
		<a href="#"><img src="'.$this->config->item('base_url_views').'images/logo2-hori.png" style="margin-top:20px;max-width:200px;"></a>
		</div>
		<div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
			<h3 style="color: #000; font-size: 21px;">Register Account Request<h3>
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Hi there!</p>
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">We got a request to create a new Happy Soul vendor account with your mobile number '.$mobilenumber.' and email ID '.$emailid.'.</p>
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;    margin: 0; ">Use the OTP 123456 within 48 hours to verify your email id.</p>
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">If you have not created the account with mobile number '.$mobilenumber.' or should you need any further assistance, contact our Customer Support.</p><br>
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">With Miles of Smiles,<br>
			Team Happy Soul</p><br>
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Need Help?<br>
			<a href="'.$this->config->item('base_url').'contact-us" style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Contact Us for Help & Support</a></p>
		</div><div style="clear: both"></div></body></html>';    
            
            $subject = "OTP VERIFICATION CODE senttt - Happy Soul";
			$to = 'milan.sachinist@outlook.com';

    		$headers  = 'MIME-Version: 1.0' . "\r\n";
    		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    		$headers .= "X-Priority: 1\r\n";
    		$headers .= 'From:HappySoul <info@happysoul.in>' . "\r\n" .
    			'Reply-To:  info@happysoul.in' . "\r\n" .
    			'X-Mailer: PHP/' . phpversion();
    		$headers .= 'Cc:  info@happysoul.in' . "\r\n";

    		mail('patelnikul321@gmail.com', $subject, $message, $headers);
    		mail($to, $subject, $message, $headers);
	    
	}
	
	function vendor_signup()
	{
		$data['err_msg'] = '';
		if($this->input->post("action")=="step_2")
		{
		    $content['fname'] = $this->input->post('fname');
		    $content['mobile'] = $this->input->post('mobile');
		    $content['email'] = $this->input->post('email');
		    $content['password'] = $this->input->post('pwd');
		    
			$this->home_model->vendor_registration_step2($content);
			$checklogin = $this->home_model->vendor_userlogin($content);
        	if($checklogin !='')
			{
               $newuserdata = array(
                    'userid'  => $checklogin->id,
                    'fname'  => $checklogin->fname,
                    'company_name'  => $checklogin->company_name,
					'lname'  => $checklogin->lname,
					'mobile'  => $checklogin->mobile,
					'email'  => $checklogin->email,
					'user_vendor'  => $checklogin->user_vendor,
					'logged_in' => true
				);
				$check = $this->session->set_userdata($newuserdata);
			}
			
			$this->session->unset_userdata('mobilecode');
            $this->session->unset_userdata('emailcode');
            $this->session->unset_userdata('mobilenumber');
            $this->session->unset_userdata('emailid');

            $email = $this->config->item('admin_email');
			$message = '<!doctype html><html lang="en"><head>
	<title>Vendor Registration Email</title>
	<style>
		@import url("https://fonts.googleapis.com/css?family=Lato");
	</style> </head><body style="text-align: center;margin: 0;background: #ececec; font-family: "Lato", sans-serif;font-weight: 100;">
	<div style="max-width:630px;margin: 0 auto;border: thin solid #f3f0f0;background: #fff; border:1px solid #ccc">
		<div style="float: left; width: 100%; border-bottom:1px solid #ccc; text-align:center">
		<a href="'.$this->config->item('base_url').'"><img src="'.$this->config->item('base_url_views').'images/logo2-hori.png" style="margin-top:20px;max-width:200px;"></a>
		</div>
		 <div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Hi, </p>
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Our Tribe Is Growing! Do review the new vendor and their product\'s & credentials.</p>
		</div>
		<div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
						<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">With Miles of Smiles,<BR>
			Team Happy Soul</p><br>
						<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Need Help?<br>
						<a href="'.$this->config->item('base_url').'contact-us" style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Contact Us for Help & Support</a></p>
					</div>
		<div style="clear: both">
			</div></div>
		</body>
		</html>';

        $subject = "One new Vendor has signed up";
		$to = $email;
	
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: HappySoul <info@happysoul.in>' . "\r\n" .
			'Reply-To: info@happysoul.in' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
		$headers .= 'Cc: info@happysoul.in' . "\r\n";
		mail($to, $subject, $message, $headers);


		$message = '<!doctype html><html lang="en"><head>
	<title>Vendor Registration Email</title>
	<style>
		@import url("https://fonts.googleapis.com/css?family=Lato");
	</style> </head><body style="text-align: center;margin: 0;background: #ececec; font-family: "Lato", sans-serif;font-weight: 100;">
	<div style="max-width:630px;margin: 0 auto;border: thin solid #f3f0f0;background: #fff; border:1px solid #ccc">
		<div style="float: left; width: 100%; border-bottom:1px solid #ccc; text-align:center">
		<a href="'.$this->config->item('base_url').'"><img src="'.$this->config->item('base_url_views').'images/logo2-hori.png" style="margin-top:20px;max-width:200px;"></a>
		</div>
		 <div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Hi there, </p>
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Thank you for providing your company details. Its Wonderful to have you On-board. Kindly fill in your Bank Account and Pick-up Point details for initiating the process of Product-listing.</p>
		</div>
		<div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
						<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">With Miles of Smiles,<BR>
			Team Happy Soul</p><br>
						<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Need Help?<br>
						<a href="'.$this->config->item('base_url').'contact-us" style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Contact Us for Help & Support</a></p>
					</div>
		<div style="clear: both">
			</div></div>
		</body>
		</html>';

        $subject = "YOUR REGISTRATION IS ALMOST DONE !";
		$to = $content['email'];
	
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: HappySoul <info@happysoul.in>' . "\r\n" .
			'Reply-To: info@happysoul.in' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
		$headers .= 'Cc: info@happysoul.in' . "\r\n";
		mail($to, $subject, $message, $headers);
		$email = $this->config->item('admin_email');
		mail($email, $subject, $message, $headers);


			redirect($this->config->item('base_url').'vendor/vendor_profile');
			//$this->session->set_flashdata('success','Vendor Registration successfully');
			//redirect($this->config->item('base_url').'vendor/vendor_profile', 'location');
		}
		$this->load->model('page_model');
	    $data['cmsdata']         = $this->page_model->cms('4');
		$this->load->view('dashboard/vender-sing-up',$data);
	}
	
	function validate_vendor(){
	    $validate = '1';
	    $amobile = $this->session->userdata('mobilecode');
	    $aemailid = $this->session->userdata('emailcode');
	
	    $postmobile = $this->input->post('otp');
	    $postemail = $this->input->post('conf');
	    if($postmobile != $amobile){
	        $validate = '2';
	        echo $validate; die;
	    }
	    
	    if($aemailid != $postemail){
	        $validate = '3';
	        echo $validate;die;
	    }
	    echo $validate;die;
	}
	

	
	function registration_thanks()
	{
		$data['err_msg'] = '';
		$this->load->view('registration_thanks',$data);
	}


	function select_category()
	{
		$data['err_msg'] = '';
		$this->load->view('select_category',$data);
	}

	function select_category_subcategory()
	{
		$data['err_msg'] = '';
			$data['allcategory_select'] = $this->home_model->allcategory_select();
				$data['userid'] =  $this->session->userdata('userid');
		$this->load->view('select_category_subcategory',$data);
	}
	function updatecategory_sub()
	{

			$data['subcetagory_cate']= implode(',',$this->input->post('subcetagory_cate'));

				 $cetegory_sub =$this->home_model->select_cate($data['subcetagory_cate']);
				$cetegory2 = array();
				foreach($cetegory_sub as $cate)
				{
					$cetegory2[] = $cate->category_id;

				}
				$data['select_cate_id'] = implode(',',$cetegory2);
					$data['userid'] =  $this->session->userdata('userid');


				$cateid=$this->home_model->updatecategory_sub($data);
					$this->session->set_flashdata('profile_updatess','Category/Subcategory updated successfully');
				redirect($this->config->item('base_url').'select-category-subcategory');
	}

	function pickup()
	{

		$data['err_msg'] = '';


	$newdata = array
		(
			 'subcetagorysss' => implode(',',$this->input->post('subcetagorysss'))
		);

		$this->session->set_userdata($newdata);
		$this->load->view('pickup',$data);
	}

	function select_categorys()
	{
		$data['err_msg'] = '';
		$newuserdata = array(
				'company_name'  => $this->input->post("company_name"),
				'register_address'  => $this->input->post("register_address"),
				'address'  => $this->input->post("address"),
				'tel_no_a'  => $this->input->post("tel_no_a"),
				'tel_no'  => $this->input->post("tel_no"),
				'email_id'  => $this->input->post("email_id"),
				'password'  => $this->input->post("password"),
				'website'  => $this->input->post("website"),
				'service_tax_no'  => $this->input->post("service_tax_no"),
				'pancardnumber'  => $this->input->post("pancardnumber"),
				'excise_reg_no'  => $this->input->post("excise_reg_no"),
				'gumasta_lisence_no'  => $this->input->post("gumasta_lisence_no"),
				'contact_Person1'  => $this->input->post("contact_Person1"),
				'contact_person2'  => $this->input->post("contact_person2"),
				'distributor_wholeseller'  => $this->input->post("distributor_wholeseller"),
				'business_area'  => $this->input->post("business_area"),
				'bank_name'  => $this->input->post("bank_name"),
				'account_holder_name'  => $this->input->post("account_holder_name"),
				'account_no'  => $this->input->post("account_no"),
				'ifsc_code'  => $this->input->post("ifsc_code"),
				'no_of_years_in_business'  => $this->input->post("no_of_years_in_business"),
				'list_of_customers'  => $this->input->post("list_of_customers"),
				);


			 $this->session->set_userdata($newuserdata);
		$data['allcategory_select'] = $this->home_model->allcategory_select();

		$this->load->view('select_category',$data);
	}
	function add_vendor_pincode()
	{
		$data['err_msg'] = '';
		$content['company_name']     = $this->session->userdata('company_name');
		$content['register_address']     = $this->session->userdata('register_address');
		$content['address']     = $this->session->userdata('address');
		$content['tel_no_a']     = $this->session->userdata('tel_no_a');
		$content['tel_no']     = $this->session->userdata('tel_no');
		$content['email_id']     = $this->session->userdata('email_id');
		$content['password']     = $this->session->userdata('password');
		$content['website']     = $this->session->userdata('website');
		$content['service_tax_no']     = $this->session->userdata('service_tax_no');
		$content['pancardnumber']     = $this->session->userdata('pancardnumber');
		$content['excise_reg_no']     = $this->session->userdata('excise_reg_no');
		$content['gumasta_lisence_no']     = $this->session->userdata('gumasta_lisence_no');
		$content['contact_Person1']     = $this->session->userdata('contact_Person1');

		$content['contact_person2']     = $this->session->userdata('contact_person2');
		$content['distributor_wholeseller']     = $this->session->userdata('distributor_wholeseller');
		$content['business_area']     = $this->session->userdata('business_area');
		$content['bank_name']     = $this->session->userdata('bank_name');
		$content['account_holder_name']     = $this->session->userdata('account_holder_name');

		$content['account_no']     = $this->session->userdata('account_no');
		$content['ifsc_code']     = $this->session->userdata('ifsc_code');
		$content['no_of_years_in_business']     = $this->session->userdata('no_of_years_in_business');
		$content['list_of_customers']     = $this->session->userdata('list_of_customers');
		$content['subcetagorysss']    = $this->session->userdata('subcetagorysss');


		$cetegory =$this->home_model->select_cate($content['subcetagorysss']);
		$cetegory1 = array();
		foreach($cetegory as $cate)
		{
			$cetegory1[] = $cate->category_id;

		}
		$content['select_cate_id'] = implode(',',$cetegory1);

		$id= $this->home_model->add_vendor_detail($content);
		$userdata = $this->home_model->userdata($id);
		$newuserdata = array(
		'userid'  => $userdata->id,
		'company_name'  => $userdata->company_name,
		'mobile'  => $userdata->mobile,
		'email'  => $userdata->email,
		'user_vendor'  => $userdata->user_vendor,
		'logged_in' => true

		);
		$this->session->set_userdata($newuserdata);

		$message = ' <!doctype html>
			<html lang="en">
			<head>
				
				<title>Registration</title>
				<style>
					@import url("https://fonts.googleapis.com/css?family=Lato");
				</style>
			</head>
			<body style="text-align: center;margin: 0;">
				<div style="max-width:630px;margin: 0 auto;border: thin solid #f3f0f0;">
					<a href="#"><img src="'.$this->config->item('base_url_views').'images/logo2-hori.png" style="margin-top:20px;max-width:200px;"></a>
					<img src="'.$this->config->item('base_url_views').'emailer/images/banner.jpg" style="width:100%; margin-top:20px;display: block;">
					<p style="font-size: 16px;padding: 10px 9%;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;">
						Thank you for joining Happy Soul. You are now a part of our community of wellness and happiness. We aid you with all the support at every step towards spiritual and physical well being. By associating with us, we make sure you are empowered everyday.<br>
						You can connect with us and place your concerns and requirements.
					</p>
					<p style="font-size: 15px;line-height: 30px;font-family: "Lato", sans-serif;background: #edefea;margin: 20px 8%;">
						<a href="#" target="_blank" style="color: #58595b;text-decoration: none;padding: 15px;display: inline-block;">Visit our website and explore a plethora of products & services offered by us.</a>
					</p>

					<p style="font-size: 16px;padding: 10px 9%;line-height: 25px;color: #637F32;font-family: "Lato", sans-serif;">
						Wishing you a beautiful experience with us, Bloom in joy.<br>
						Regards<br>
						Happy soul.<br>
					</p>

					<div style="padding: 30px 0 60px 0;">
						<div style="display: inline-block;">
							<a href="#"><img style="max-width:100%;" src="'.$this->config->item('base_url_views').'emailer/images/yoga1.jpg"></a>
						</div>
						<div style="display: inline-block;padding: 0px 5%;">
							<a href="#"><img style="max-width:100%;" src="'.$this->config->item('base_url_views').'emailer/images/ayurveda1.jpg"></a>
						</div>
						<div style="display: inline-block;">
							<a href="#"><img style="max-width:100%;" src="'.$this->config->item('base_url_views').'emailer/images/metascience1.jpg"></a>
						</div>
					</div>
					<div style="background: #edefea;padding: 10px;">
							<a href="#" style="color: #58595B;text-decoration:none;font-size:14;">+91 98200 51120</a>&nbsp;&nbsp; | &nbsp;&nbsp;<a href="#" style="color: #58595B;text-decoration:none;font-size:14;">help@happysoul.in</a><br>
							<div style="text-align: center;margin-top:10px;">
								<a href="https://www.facebook.com/HappySoulIndiaOfficial/"><img style="max-width:100%;margin:0 5px" src="'.$this->config->item('base_url_views').'emailer/images/facebook.png"></a>
								<a href="#"><img style="max-width:100%;margin:0 5px" src="'.$this->config->item('base_url_views').'emailer/images/instagram.png"></a>
								<a href="#"><img style="max-width:100%;margin:0 5px" src="'.$this->config->item('base_url_views').'emailer/images/twitter.png"></a>
							</div>
					</div>
				</div>
				<br><br><br><br><br><br>
			</body>
			</html>';


			$subject = "Thank you for Registration ";
			$to = $userdata->email;


		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From:HappySoul < info@happysoul.in>' . "\r\n" .
			'Reply-To:  info@happysoul.in' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
		$headers .= 'Cc:  info@happysoul.in' . "\r\n";
 
		mail($to, $subject, $message, $headers);

		$this->session->set_flashdata('success_register','Register Successfully!!!!');

		if($this->cart->total_items() > 0)
		{
			redirect($this->config->item('base_url').'cart/viewcart');
		}
		else
		{
			redirect($this->config->item('base_url').'vendor-my-account');

			/*redirect($this->input->post("redirects"));
			redirect($_SERVER['HTTP_REFERER']);	*/
		}

	}

	function product_listing($wellness_category)
	{
		$data['err_msg'] = '';


		$this->load->view('product_listing',$data);
	}

	function vendor_my_account()
	{
		$data['err_msg'] = '';
 		if($this->input->post("action")=="edit_profile")
			{
				foreach($_POST as $key => $value)
				{
					$data[$key]=$this->input->post($key);
				}

				$content['company_name']  = $data['company_name'];
				$content['register_address'] = $data['register_address'];
				$content['address']  = $data['address'];
				$content['tel_no_a']  = $data['tel_no_a'];
				$content['tel_no'] = $data['tel_no'];
				$content['website']  = $data['website'];
				$content['service_tax_no']  = $data['service_tax_no'];
				$content['pancardnumber'] = $data['pancardnumber'];
				$content['excise_reg_no']  = $data['excise_reg_no'];
				$content['gumasta_lisence_no']  = $data['gumasta_lisence_no'];
				$content['contact_Person1'] = $data['contact_Person1'];
				$content['contact_person2']  = $data['contact_person2'];
				$content['distributor_wholeseller']  = $data['distributor_wholeseller'];
				$content['business_area'] = $data['business_area'];
				$content['bank_name']  = $data['bank_name'];
				$content['account_holder_name']  = $data['account_holder_name'];
				$content['account_no'] = $data['account_no'];
				$content['ifsc_code']  = $data['ifsc_code'];
				$content['no_of_years_in_business']  = $data['no_of_years_in_business'];
				$content['list_of_customers'] = $data['list_of_customers'];

				$id =  $this->session->userdata('userid');
				$this->home_model->update_profile($id,$content);
				$this->session->set_flashdata('profile_update','Profile updated successfully');
				redirect($this->config->item('base_url').'vendor-my-account', 'location');
			}

		$data['profile'] = $this->home_model->getuserdata($this->session->userdata('userid'));
		$data['addition_item'] = $this->home_model->addition_item($this->session->userdata('userid'));
		$this->load->view('vendor_my_account',$data);
	}

	function updatebank_dels()
	{
		if($this->input->post("account_no")!="")
		{
               $data['bank_name']= $this->input->post("bank_name");
               $data['account_holder_name']= $this->input->post("account_holder_name");
               $data['account_no']= $this->input->post("account_no");
               $data['ifsc_code']= $this->input->post("ifsc_code");

			   $data['id'] =  $this->session->userdata('userid');

            if($_FILES['kyc_documents']['name'] != '') {

                $tmp_name1 =  $_FILES['kyc_documents']['tmp_name'];
                $rootpath1 =  $this->config->item('upload')."kyc_document/";

                $logoname = time().$_FILES['kyc_documents']['name'];
                move_uploaded_file( $tmp_name1 , $rootpath1.$logoname );


                $tmp_path = $this->config->item('upload')."kyc_document/".$logoname;
					$data['kyc_documents']=$logoname;
            }
            else
            {

	         $data['kyc_documents']='';
            }


				$this->home_model->update_bankdeatial($data);
				$this->session->set_flashdata('profile_updateee','Bank Detail updated successfully');
					redirect($this->config->item('base_url').'bank-detail');
		}
		else
		{
			redirect($this->config->item('base_url').'bank-detail');
		}
	}


	function update_store_detail()
	{
		if($this->input->post("gstin")!="")
		{
               $data['website']= $this->input->post("website");
               $data['gstin']= $this->input->post("gstin");
               $data['pancard']= $this->input->post("pancard");
               $data['exciseno']= $this->input->post("exciseno");
               $data['lisenceno']= $this->input->post("lisenceno");
               $data['distributor_wholeseller']= $this->input->post("distributor_wholeseller");
               $data['business_area']= $this->input->post("business_area");

			   $data['id'] =  $this->session->userdata('userid');

				$this->home_model->update_storedeatial($data);
				$this->session->set_flashdata('profile_updateee','Store Detail updated successfully');
					redirect($this->config->item('base_url').'store-detail');
		}
		else
		{
			redirect($this->config->item('base_url').'store-detail');
		}
	}

	function update_personal_detail()
	{
		if($this->input->post("company_name")!="")
		{
               $data['company_name']= $this->input->post("company_name");
               $data['email']= $this->input->post("email");
               $data['tel_no_a']= $this->input->post("tel_no_a");
               $data['mobile']= $this->input->post("mobile");
               $data['register_address']= $this->input->post("register_address");
               $data['address']= $this->input->post("address");


			   $data['id'] =  $this->session->userdata('userid');

				$this->home_model->update_presoneldeatial($data);
				$this->session->set_flashdata('profile_updateee','Personal Detail updated successfully');
					redirect($this->config->item('base_url').'personal-detail');
		}
		else
		{
			redirect($this->config->item('base_url').'personal-detail');
		}
	}


	function single_product($url)
	{
		$data['err_msg'] = '';
		$data['product_detail'] = $this->home_model->product_detail($url);
		
		if($data['product_detail']->status==1 || $data['product_detail'] == '')
		{
			redirect($this->config->item('base_url'));
		}
		
		$data['product_images'] = $this->home_model->product_images($data['product_detail']->id);
        $data['product_add_fields'] = $this->home_model->product_add_fields($data['product_detail']->id);

		$data['relatedproduct'] = $this->home_model->relatedproduct($data['product_detail']->id,$data['product_detail']->subcatefory_id);
		$data['relatedproduct_cat'] = $this->home_model->relatedproduct_cat($data['product_detail']->id,$data['product_detail']->category_id);

		$data['getcolour'] = $this->home_model->getcolour($data['product_detail']->id);
		$data['product_size'] = $this->home_model->product_size($data['product_detail']->id);
		
		$data['product_attr'] = $this->home_model->product_attr($data['product_detail']->id);

		$data['metatitle'] = $data['product_detail']->metatitle;
		$data['metakeywords'] = $data['product_detail']->metakeywords;
		$data['metadescription'] = $data['product_detail']->metadescription;
		$this->load->view('single_product',$data);
	}

	function checkpincode_detail()
	{
		$pincode = $_POST['pincode'];
		$is_perishable_p = $_POST['is_perishable_p'];
		$vendor_id_p = $_POST['vendor_id_p'];
		
		/*$pincode = '734102';
		$is_perishable_p =  '1';
		$vendor_id_p = '4';*/

		if($is_perishable_p == '1'){ 
			$vendorperishabledata = $this->home_model->getvendorperishablepincode($vendor_id_p);
			if($vendorperishabledata == ''){
				echo "0"; exit();
			}
			$vendorpincode = $vendorperishabledata->pincode;
	
			$data = $this->home_model->controllingcity($vendorpincode);
			
			$noavaialble = '0';
			if($data != '' && count($data) > 0){
				foreach($data as $validatep){
					if($validatep->pincode == $pincode){
						$noavaialble = '1'; 
						echo $noavaialble;
						exit();
					}
				}
			}
			echo $noavaialble;
			exit();

		} else {
		
			$data = $this->home_model->checkpincode_detail($pincode);
			echo $data;
		}
	}

	function track_approval_request()
	{
		$data['err_msg'] = '';


		$this->load->view('track-approval-request',$data);
	}

	function bank_detail()
	{
		$data['err_msg'] = '';
		$data['user_bank_data'] = $this->home_model->getuser_bank_data($this->session->userdata('userid'));

		$this->load->view('bank-detail',$data);
	}

	function store_detail()
	{
		$data['err_msg'] = '';
		$data['user_store_data'] = $this->home_model->getuser_bank_data($this->session->userdata('userid'));

		$this->load->view('store-detail',$data);
	}

	function personal_detail()
	{
		$data['err_msg'] = '';

		$data['user_personal_detail_data'] = $this->home_model->getuser_bank_data($this->session->userdata('userid'));
		$this->load->view('personal-detail',$data);
	}

	function payment_overview()
	{
		$data['err_msg'] = '';
		$this->load->view('payment-overview',$data);
	}

	function previous_payments()
	{
		$data['err_msg'] = '';
		$this->load->view('previous-payments',$data);
	}

	function order_sold()
	{
		$data['err_msg'] = '';

		$this->load->model('account_model');

		$data['order_soldlisting'] = $this->home_model->order_soldlisting($this->session->userdata('userid'));
		$this->load->view('order-sold',$data);
	}

	function return_order()
	{
		$data['err_msg'] = '';


		$this->load->view('return-order',$data);
	}

	function cancellation_orders()
	{
		$data['err_msg'] = '';

		$data['order_canlisting'] = $this->home_model->order_canlisting($this->session->userdata('userid'));
		$this->load->view('cancellation-orders',$data);
	}


	function allproducts()
	{
		$data['err_msg'] = '';
		$data['get_vendor_product'] = $this->home_model->get_vendor_product($this->session->userdata('userid'));
		$this->load->view('all-products',$data);
	}


    function edit_product($id)
	{
			if(is_numeric($id))
			{
				$result = $this->home_model->get($id);
				$form_field = $data = array(
						'L_strErrorMessage' => '',
						'id'	=> $result[0]->id,
						'name' =>  $result[0]->name,
						'page_url'=>$result[0]->page_url,
						'category_id'=>$result[0]->category_id,
						'subcatefory_id'=>$result[0]->subcatefory_id,
						'pincode'=>$result[0]->pincode,
						'discount'=>$result[0]->discount,
						'short_desc'=>$result[0]->short_desc,
						'description'=>$result[0]->description,
						'specification'=>$result[0]->specification,
						'howtouse'=>$result[0]->howtouse,

						);

				if($this->input->post('action') == 'edit_product')
				{
					foreach($data as $key => $value) {  $form_field[$key]=$this->input->post($key);	}

					$this->load->library('validation');

					$rules['name'] = "trim|required";
					$this->validation->set_rules($rules);

					$fields['name'] = "name";

					$this->validation->set_fields($fields);

					if ($this->validation->run() == FALSE)
					{
							$data = $form_field;
							$data['L_strErrorMessage'] = $this->validation->error_string;
							$data['id'] = $id;
					}
					else
					{
						$this->home_model->edit($id, $form_field);
						$this->session->set_flashdata('product_succsess','Product Updated Successfully!!!!');
						redirect($this->config->item('base_url').'all-products');
					}
				}
				 $data['userid'] =  $this->session->userdata('userid');
				$data['allcategory']= $this->home_model->alldata("category");
				$data['allsubcategory']= $this->home_model->subcategory();
				$data['allcolour']= $this->home_model->alldata("colour");
				$data['addition_item'] = $this->home_model->addition_item_product($id);
				$data['allpincode']= $this->home_model->alldata("pincode");
				$data['allgram']= $this->home_model->alldata("gram");

				$this->load->view('edit_product',$data);

			}

			else

			{

				$this->session->set_flashdata('product_succsess','No Such Attribute !!!!');

				redirect($this->config->item('base_url').'all-products');

			}

	}

	function editimage($id)
	{
 		if ($this->input->post('action') == 'edit' && is_numeric($id)) {
 		for($i = 0; $i < count($_FILES['attachment1']['name']); $i++)
		{

			if($_FILES['attachment1']['name'][$i] != '') {
				$tmp_name1 =  $_FILES['attachment1']['tmp_name'][$i];
		 		$rootpath1 =  $this->config->item('upload')."products/";

				$remove_space = str_replace(' ', '-',$_FILES['attachment1']['name'][$i]);

				$logoname = time().$remove_space;
				move_uploaded_file( $tmp_name1 , $rootpath1.$logoname );

							$tmp_path = $this->config->item('upload')."products/".$logoname;
				$image_thumb= $this->config->item('upload')."products/medium/".$logoname;

				$height=450;
				$width=450;

				$this->load->library('image_lib');

				$config['image_library']    = 'gd2';
				$config['source_image']     = $tmp_path;
				$config['new_image']        = $image_thumb;
				$config['maintain_ratio']   = false;
				$config['height']           = $height;
				$config['width']            = $width;

				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				$this->image_lib->clear();

				$tmp_path = $this->config->item('upload')."products/".$logoname;
				$image_thumb= $this->config->item('upload')."products/large/".$logoname;

				$height=1400;
				$width=1200;

				$this->load->library('image_lib');

				$config['image_library']    = 'gd2';
				$config['source_image']     = $tmp_path;
				$config['new_image']        = $image_thumb;
				$config['maintain_ratio']   = false;
				$config['height']           = $height;
				$config['width']            = $width;

				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				$this->image_lib->clear();

				$tmp_path = $this->config->item('upload')."products/".$logoname;
				$image_thumb= $this->config->item('upload')."products/small/".$logoname;

				$height=50;
				$width=50;

				$this->load->library('image_lib');

				$config['image_library']    = 'gd2';
				$config['source_image']     = $tmp_path;
				$config['new_image']        = $image_thumb;
				$config['maintain_ratio']   = false;
				$config['height']           = $height;
				$config['width']            = $width;

				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				$this->image_lib->clear();

				$newdata1 = array(
					'pid'   => $id,
					'image'	=> $logoname,
				);

				$id222 = $this->home_model->add_product_image($newdata1);

			}
		}

		$this->session->set_flashdata('L_strErrorMessage', 'Image Added Successfully.!!');
		redirect($this->config->item('base_url').'edit-product-image/'.$id);
		}
		$data['result'] = $this->home_model->presult($id);

		$data['productimages'] = $this->home_model->productimages($id);
		//print_R($data['productimages']);die;
		$this->load->view('edit_product_image',$data);

	}

	function setbaseimg($id,$pid)
	{

		$return = $this->home_model->setbaseimg($id,$pid);
		$this->session->set_flashdata('L_strErrorMessage', 'Base Image Set Successfully.!!');
		redirect($this->config->item('base_url').'edit-product-image/'.$pid);
	}

	function removeimage($id,$pid)
	{
		$return = $this->home_model->removeimage($id);
		$this->session->set_flashdata('L_strErrorMessage', 'Image deleted Successfully.!!');
		redirect($this->config->item('base_url').'edit-product-image/'.$pid);
	}

	function add_products()
	{
		$data['err_msg'] = '';

		$L_strErrorMessage='';

		$form_field = $data = array(

			'name' => '',
			'page_url'=>'',
			'category_id' => '',
			'subcatefory_id' => '',
			'pincode' => '',
			'discount' => '',
			'short_desc'=>'',
			'description' => '',
			'specification'=>'',
			'howtouse' => '',

			'vendor_id' => '',

		);

		if($this->input->post('action') == 'add_product')
		{
			foreach($form_field as $key => $value)
			{
				$data[$key]=$this->input->post($key);
			}

			$this->home_model->add_product($data);
			$this->session->set_flashdata('product_succsess','Product Added Successfully!!!!');
			redirect($this->config->item('base_url').'all-products');
    	}
	  	$data['userid'] =  $this->session->userdata('userid');
		$data['allcategory']= $this->home_model->alldata("category");
		$data['allsubcategory']= $this->home_model->alldata("subcategory");
		$data['allsize']= $this->home_model->alldata("gram");
		$data['allpincode']= $this->home_model->alldata("pincode");
		$data['allcolour']= $this->home_model->alldata("colour");

		$this->load->view('add-product',$data);
	}



    function show_subcategory()
	{
		$cid = $_POST['cid'];
		$in_sid = explode(",",$_POST['sid']);
		$data = $this->home_model->subcategory_bycat($cid);
		$html = '<select id="subcatefory_id" name="subcatefory_id[]" multiple  class="form-control dropmultiple">';
		$html .= "<option value=''>Select Sub Category</option>";
		if($data!=''){
		for($i=0;$i<count($data);$i++)
		{
			if(in_array($data[$i]->id,$in_sid)){ $selected="selected"; }else{ $selected=""; }
			$html .= "<option value='".$data[$i]->id."' ".$selected.">".$data[$i]->name ."</option>";
		}
		}
		$html .="</select>";
		echo $html;
	}
	
	function show_subcategory_list()
	{
		$cid = str_replace('*','&',$_POST['cid']);
		//$in_sid = explode(",",$_POST['sid']);
		$data = $this->home_model->subcategory_byname($cid);
		$html = '<select class="form-control dropdown2">';
		$html .= "<option value=''>Select Sub Category</option>";
		if($data!=''){
		for($i=0;$i<count($data);$i++)
		{
			if(in_array($data[$i]->id,$in_sid)){ $selected="selected"; }else{ $selected=""; }
			$html .= "<option value='".$data[$i]->name."' ".$selected.">".$data[$i]->name."</option>";
		}
		}
		$html .="</select>";
		echo $html;
	}

	function orders()
	{
		$data['err_msg'] = '';

		$this->load->model('account_model');

		$data['order_detail'] = $this->home_model->order_detail($this->session->userdata('userid'));

		$this->load->view('orders',$data);
	}

	function order_details($order_id)
	{
		$data['err_msg'] = '';

			$order = $this->home_model->getOrders($order_id);
		 $this->data['order'] = $order[0];

		$this->load->view('view-order', $this->data);
	}

	function report()
	{
		$data['err_msg'] = '';
		$this->load->view('report',$data);
	}

	function removeprice($product_id,$id)
	{
			if($this->home_model->removeattriute($product_id,$id))
			{
				$this->session->set_flashdata('profile_update','Pincode Deleted Succcessfully!!!!');
				redirect($this->config->item('base_url').'vendor-my-account');
			}
			else
			{
				$this->session->set_flashdata('flashError','Some Errors prevented from Deleting!!!!');
				//break;
			}
	}



	
	
	public function ajaxsearch()
    {
		$product_list='';
		$this->data["base_url"] = $this->config->item('base_url');
		$this->data['front_base_url'] = $this->config->item('http_host');

		//$_GET[ "term" ] = 'test';
		if($this->input->get("term") !="")
		{
			 $this->data['search_term'] = $this->input->get("term");
			 $product_list = $this->home_model->getProductsAjax($this->data);
		}
		$html_image ='';
		$mobile_html_image ='';
		$htmls ='';
		$mobile_htmls ='';
	   
	   //print_r($product_list); die;
       if($product_list !="" && count($product_list)>0)
       {
       $title = '';   
       $i = '0';
       $j = '0';
	   foreach($product_list as $product)
	   {  $j++;  
 		  if(isset($product['image']))
		  {	
		        $i++;
			   /* $product['label'] */
 			   /*<div class="mb_pro">
				    <div class="m_img">
				        <img src="https://happysoul.in/beta/upload/products/medium/1570706506Bowel-Move-Front.jpg">
				    </div>
				    <div class="m_info">
				        <p class="product_title_name">Life &amp; Pursuits Natural Nourishing Baby Body Wash</p>
				        
				    </div>
				</div>*/
				if($i == '1'){
 				    if($j == '1'){ $pcl = ''; } else { $pcl = 'h_serch1'; }
 				    $htmls .='<h3 class="h_serch '.$pcl.'">Products</h3>';
				}
				$productminpricesearch = $this->home_model->productminpricesearch($product["pageurl"]);
 				$htmls .='<div class="col-md-6"><a href="'.$this->data["base_url"].'product/'.$product["pageurl"].'"><div class="mb_pro">
				    <div class="m_img">
				        <img src="'.$this->config->item('http_host').'upload/products/small/'.$product["image"].'">
				    </div>
				    <div class="m_info">
				        <p class="product_title_name">'.$product['label'].'</p>
				        <h6><span class="offer-price" ><i class="fa fa-inr" aria-hidden="true"></i> '.$productminpricesearch.'</span> <!-- del>₹ 449<del --></h6>
				     </div></div>
				     </a></div>'; 
 			  	/*$htmls .='
				<a href="'.$this->data["base_url"].'product/'.$product["pageurl"].'">					
				<div><p class="product_title_name">'.$product['label'].'</p>
				</div></a>
				'; */
				$mobile_htmls .='<a href="'.$this->data["base_url"].'product/'.$product["pageurl"].'"><div><p class="product_title_name">'.$product['label'].'</p></div></a>';
		    }
		    else
		    {
				if($product["label"] != '') 
				{
 				    if($product["title"] != '') {
 				        if($title != $product["title"]) {
 				            if($title != '') { $cl = 'bl'; } else { $cl == '';} 
 				            $htmls .='<div class="mh '.$cl.'"><h3 class="h_serch">'.$product["title"].'</h3></div>';
				        }
					    $htmls .='<p class="h_p"><a href="'.$this->data["base_url"].$product["url"].'">'.$product['label'].'</a></p>';
 				        $title = $product["title"];
				    }	
 			    	
				    //$mobile_htmls .='<p><a href="'.$this->data["base_url"].$product["url"].'">'.$product['label'].'</a></p>';
					$mobile_htmls .='<a href="'.$this->data["base_url"].$product["url"].'"><div><p class="product_title_name">'.$product['label'].'</p></div></a>';
				}       
		    }
	   }
  
		if($this->agent->is_mobile())
		{
			$html ='<div class="row"><div class="col-md-12 sak1"><div>'.$mobile_htmls.'</div></div></div>';
		} 
		else
		{
			$html ='<div class="container">
			<div class="row">
				<div class="col-md-12">
					<button type="button" class="close" aria-label="Close" style="margin-top:10px;" onclick="close_search();">
					<i class="fa fa-times" aria-hidden="true"></i></button>
				</div>
				<div class="col-xs-12 sak2">
					<div>'.$htmls.'</div>	
				</div>				
			</div>
		</div>';
		} 		
	}
			 echo $html;
    }


	/*function workshop($page_url)
	{
		$data['err_msg'] = '';

		$this->load->view('workshop',$data);
	}
	*/

	function workshop($page_url="")
	{
		$data['err_msg'] = '';
		$worksho_cate= $this->home_model->getcaworkshopcate($page_url);
		$data['worksho_cate'] = $worksho_cate->id;

		$this->load->library('pagination');
		$url_to_paging = $this->config->item('base_url')."workshops/".$page_url;
		$data['search'] = $this->input->get('search');

		$config['per_page']= $per_page  = '10';
		$pageno = $this->input->get('per_page');

		if($pageno == '')
		{
			$pageno = '0';
		}
		
		$data['minPrice'] = $this->input->get('minPrice');
		$data['maxPrice'] = $this->input->get('maxPrice');
		if($this->input->get('location')){
			$data['filters'] = $this->input->get('location');
		}
		$data['sort_by'] = $this->input->get('sort_by');
		
		$return = $this->home_model->lists_worshshop($per_page,$pageno, $data);
 
		$config['base_url'] = $url_to_paging;

		$config['total_rows'] = $return['count'];
		$data['totalcount'] = $return['count'];
		$data['all_workshop'] = $return['result'];
		
		$data['dataminprice'] = $return['minprice'];
		$data['datamaxprice'] = $return['maxprice'];

		$pastw = $this->home_model->lists_worshshop_past($per_page,$pageno, $data);
		$data['all_workshop_past'] = $pastw['result'];
		//$data['allproductprice'] = $return['allresult'];
		//$data['filter_query'] =	$return['filter_query'];

		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<div class="previousPage">';
		$config['first_tag_close'] = '</div>';

		$config['last_link'] = 'Last ';
		$config['last_tag_open'] = '<div class="nextPage">';
		$config['last_tag_close'] = '</div>';

		$config['next_link'] = '›';
		$config['next_tag_open'] = '<div class="nextPage">';
		$config['next_tag_close'] = '</div>';

		$config['prev_link'] = '‹';
		$config['prev_tag_open'] = '<div class="previousPage">';
		$config['prev_tag_close'] = '</div>';

		$config['cur_tag_open'] = '<div class="pageNumbers"><a href="#" class="pagination_active">';
		$config['cur_tag_close'] = '</a></div>';

		$config['num_tag_open'] = '<div class="pageNumbers">';
		$config['num_tag_close'] = '</div>';

		$config['page_query_string'] = TRUE;
		$this->pagination->initialize($config);

		$data['all_workshop_category'] = $this->home_model->all_workshop_category();
		
		$data['alllocation'] = $this->page_model->alllocation();
		
        $data['activeurl'] = $page_url;
		$this->load->view('workshop',$data);
		
	}


	

	function blogs_listing($pagurl='')
	{
		$data['err_msg'] = '';
		$cateid = $this->home_model->get_subcate_name_page_url($pagurl);
		/*$cateid = $this->home_model->get_subcate_name_page_url($pagurl);*/
		if($cateid != ''){
    		$data['sub_cate_name'] =  $cateid->subname;
    		$data['all_blog_category'] = $this->home_model->all_blog_category($cateid->blogcategory);
		} else {
		    $data['all_blog_category'] = $this->home_model->all_blog_category();
		}
		$data['get_journal'] = $this->home_model->get_blog($cateid->blogcategory);
		$this->load->view('blogs_listing',$data);
	}

	function spiritual_detail($page_url)
	{
		$data['err_msg'] = '';
		$data['get_journal_detail'] = $this->home_model->get_journal_detail($page_url);
		$data['all_blog_category'] = $this->home_model->all_blog_category();
		$data['all_related_blogs'] = $this->home_model->get_blog_related($data['get_journal_detail']->blogcategory);
		$this->load->view('travel_detail',$data);
	}


	function journal_tags()
	{
		$id = $this->input->get('tag');

		$data['err_msg'] = '';

		$data['get_tag_journal'] = $this->home_model->get_tag_journal($id);

		$this->load->view('blog_tags',$data);
	}

	function register_from()
	{
		$data['err_msg'] = '';
		$data['experiences_id'] = $this->input->get('experiences_id');
		$data['feesname'] = $this->input->get('feesname');
		$data['getdetail'] = $this->home_model->getfees($this->input->get('feesname'));
		$data['getevent'] = $this->home_model->getevent($this->input->get('experiences_id'));
		$this->load->view('workshop_checkout',$data);
	}

	function updatetotal()
	{

				$total = $this->input->post("price");
				$qty = $this->input->post("qty");
				if($qty =='')
				{
					$qty =1;
				}
				$total =($total*$qty);
				$html='';
				$discountamount='0';
				if($this->session->userdata('coupancode') !='')
				{
					$coupan_type=$this->session->userdata('coupanvalue');
					if($coupan_type==0){
						$discount=($total*$this->session->userdata('discount')/100);
						$discountamount = $discount;
					 }else{
						$discountamount = $this->session->userdata('discount');
					 }
				}
			if($discountamount !="0")
			{
				$remove	='<a title="Delete Coupon" onclick="removecoupon();" ><i class="fa fa-trash" aria-hidden="true"></i></a>';
			}else
			{
				$remove	='';
			}
						$html .='<p><span>Number Of Attendees </span>
								<span>'.$qty.'</span></p>';

						$html .='<p><span>Subtotal </span>
										<span>&#8377; '.$total.' </span>
								</p>';


					if($this->session->userdata('coupancode') !='')
					{
						$html .='<p><span>Coupon Discount </span>
										<span>&#8377; '.$discountamount.'  '.$remove.'</span>
									</p>';

					}
                          $html .='<p class="total_amt"><span>Order Total</span>
                                    <span>&#8377; '.($total-$discountamount).' </span>
                                </p>';

									$this->session->set_userdata("discountamount",$discountamount);
									$this->session->set_userdata("total_amount",$total-$discountamount);
		echo $html;
	}

	function removecoupon()
	{
		 $this->session->unset_userdata('coupanname');
		 $this->session->unset_userdata('coupancode');
		 $this->session->unset_userdata('discount');
		 $this->session->unset_userdata('coupanvalue');
		 $this->session->unset_userdata('couponid');
		 echo "0";
	}

	function couponcheck()
	{
				$coupan = $this->input->post("coupon");
				$minimum = $this->input->post("minimum");
				$e_id = $this->input->post("e_id");

				$select_coupan = $this->home_model->selectcoupancode($coupan);

				if($this->session->userdata('coupancode') !=  $coupan)
				{
					if($select_coupan !='')
					{
							if($select_coupan->workshop_id==0 || $select_coupan->workshop_id==$e_id)
							{
							$usage_coupon=$this->home_model->getusage_coupon($select_coupan->id);

							/*$userusage_coupon=$this->experiences_model->getusage_coupon($select_coupan->id,$this->session->userdata('userid'));*/


							if($usage_coupon < $select_coupan->no_of_coupons)
							{
								/* if($userusage_coupon < $select_coupan->number_coupan_per_person && $this->session->userdata('userid') !='')
								{ */
										if($minimum >= $select_coupan->minimum)
										{
												$coupan_data= array(

													'couponid'  => $select_coupan->id,
													'coupanname'  => $select_coupan->name,
													'coupancode'  => $select_coupan->code,
													'discount'  => $select_coupan->discount,
													'coupanvalue'  => $select_coupan->value,
												);
												$this->session->set_userdata($coupan_data);
												echo 'success';
										}else
										{
												echo $select_coupan->minimum;
										}

							/*	}else{
										echo "invalid";
									}*/
							}else{
								echo "invalid";
							}
						}else{
								echo "invalid";
							}
					}else
					{
						echo "invalid";
					}
				}
				else
				{
					echo "Already";
				}
	}


	function submitorder()
	{
		$data['first_name'] = $this->input->post('first_name');
		$data['last_name'] = $this->input->post('last_name');
		$data['phone_number'] = $this->input->post('phone_number');
		$data['email_address'] = $this->input->post('email_address');
		$data['event_name'] = $this->input->post('event_name');
		$alreadyexists = $this->home_model->checkvalidemail_workshop($data);
		if($alreadyexists=='')
		{
 			$id= $this->home_model->add_user($data);
			$userdata = $this->home_model->userdata($id);
			$this->load->library('session');
				$newuserdata = array(
				'userid'  => $userdata->id,
				'fname'  => $userdata->fname,
				'email'  => $userdata->email,
				'lname'=> $userdata->lname,
				'mobile'  => $userdata->mobile,
				'logged_in' => true
				);
			 $this->session->set_userdata($newuserdata);
 		}else
		{
  			$newuserdata = array(
				'userid'  => $alreadyexists->id,
				'fname'  => $alreadyexists->fname,
				'email'  => $alreadyexists->email,
				'lname'=> $alreadyexists->lname,
				'mobile'  => $alreadyexists->mobile,
				'logged_in' => true
				);
			$this->session->set_userdata($newuserdata);
			//$data['first_name']    = $alreadyexists->fname;
			//$data['last_name'] 	   = $alreadyexists->lname;
			//$data['phone_number']  = $this->input->post('phone_number');
			//$data['email_address'] = $alreadyexists->email;
		}

		$data['address'] = $this->input->post('address');
		$data['feesname'] = $this->input->post('feesname');
		$data['personnum'] = $this->input->post('personnum');

		$data['feesid'] = $this->input->post('feesid');
		$data['eventid'] = $this->input->post('eventid');

		$data['pricenum'] = $this->input->post('pricenum');
		$data['realprice'] = $this->input->post('realprice');
		$data['event_discount'] = $this->input->post('event_discount');
		$data['num_attendees'] = $this->input->post('count_attendees');

		if($this->session->userdata("coupancode") !='')
		{
				$data['coup_name'] =$this->session->userdata("coupanname");
				$data['coupondiscount'] = $this->session->userdata("discountamount");
				$data['coupon_code'] = $this->session->userdata("coupancode");
		}

		$data['order_total'] = $this->session->userdata("total_amount");
		$data['cdate'] = date('Y-m-d');
		$data['payment_status'] ="FAILED";
		$data['user_id'] = $this->session->userdata("userid");


		$id=$this->home_model->addorder($data);
		if($id !='')
		{
			$this->home_model->add_attendees($id);
		}
		redirect($this->config->item('base_url').'home/success/'.$id);
	}

	function success($id)
	{

		$content['payment_status']  = "SUCCESS";
		$content['id'] = $id;
		$data['getorder'] = $this->home_model->getorder($content['id']);

		//$data['getorder'] = $this->experiences_model->getorder($content['id']);
		$message1 = '';
		$message1 .= '<!doctype html>
		<html lang="en">
		<head>
			<title>Order Placed</title>
			<style>
				@import url("https://fonts.googleapis.com/css?family=Lato");
			</style> 
		</head>
		<body style="text-align: center;margin: 0;font-family: "Lato", sans-serif;font-weight: 100;">

			<div style="max-width:630px;margin: 0 auto;border: thin solid #f3f0f0;background: #fff; border:1px solid #ccc">
			
				<div style="float: left; width: 100%; border-bottom:1px solid #ccc; text-align:center">
					<a href="'.$this->config->item('base_url').'"><img src="'.$this->config->item('base_url_views').'images/logo2-hori.png" style="margin-top:20px;max-width:200px;"></a>
				</div>
				
				<div style="float: left; width: 92%;padding: 10px 4%;text-align: left;background:#fff;">
					<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Hi '.$data["getorder"]->first_name.' '.$data["getorder"]->last_name.',</p>
					<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Thank you for workshop registration of '.$data["getorder"]->event_name.'.</p>
				</div>
				
				<div style="float: left; width: 100%;text-align: left;background:#fff;">
					<div style="width:100%;text-align: left;display: inline-block;margin-bottom: 10px;font-family: "Lato", sans-serif;">
						<p style="padding-left:5%;margin:0">
						<strong>Customer Details</strong><br>
						'.$data["getorder"]->first_name.' '.$data["getorder"]->last_name.'<br>
						'.$data["getorder"]->phone_number.',<br>
						'.$data["getorder"]->email_address.',<br>
						'.$data["getorder"]->address.'<br>
						</p>
					</div>
				</div>

				<div style="float: left; width: 92%;padding: 10px 4%;text-align: left;background:#fff;">
					<p style="text-align: left;text-align: left;border-bottom: 1px solid #727171;padding-bottom: 4px;"><strong>Workshop Detail</strong></p>
					<table style="border-collapse: collapse;width: 100%;">
						<tr style="border-bottom: 1px solid #CCCECF;">

							<td style="width: 1px;padding-bottom: 10px;vertical-align: top;"></td>

							<td style="text-align: left;vertical-align: top;padding-bottom: 10px;">
								 
								<p style="margin: 0;">
									<span style="color:gray;">Package:</span> '.$data["getorder"]->feesname.' ( '.$data["getorder"]->personnum.' ) | <span style="color:gray;">Attendees:</span> '.$data["getorder"]->num_attendees.'
								</p>
								<br>
								<p style="margin: 0;"><strong></strong></p>
							</td>
							<td style="vertical-align: top;width: 150px;text-align: right;padding-bottom: 10px;">Rs.: '.$data["getorder"]->pricenum.' </td>
						</tr>
						<tr style="border-bottom: 1px solid #CCCECF;color: #808080;line-height: 25px;">
							<td style="text-align:left;" colspan="2">Price</td>
							<td style="text-align:right;">Rs.: '.$data["getorder"]->pricenum.'</td>
						</tr>';
						if($data["getorder"]->coupondiscount !='0')
						{
						$message1 .= '<tr style="color: #808080;line-height: 25px;">
							<td style="text-align:left;" colspan="2">Discount</td>
							<td style="text-align:right;">'.$data["getorder"]->coupondiscount.'</td>
						</tr>';
						}

						$message1 .= '<tr style="border-bottom: 1px solid #000;border-top: 1px solid #000;font-weight: bold;line-height: 25px;">
							<td style="text-align:left;" colspan="2">Total</td>
							<td style="text-align:right;">Rs.: '.$data["getorder"]->order_total.'</td>
						</tr>
					</table>
				</div>

				<div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
						<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">With Miles of Smiles,<BR>
			Team Happy Soul</p><br>
						<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Need Help?<br>
						<a href="'.$this->config->item('base_url').'contact-us" style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Contact Us for Help & Support</a></p>
					</div>
				
				<div style="clear: both"></div>
				
			</div>
		</body>
		
		</html>';
		 
		$subject1 = "Thank you for workshop registration of ".$data["getorder"]->event_name;
		$to1 = $data['getorder']->email_address;

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From:happysoul.in <info@happysoul.in>' . "\r\n" .
			'Reply-To: info@happysoul.in' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
		$headers .= 'Cc: info@happysoul.in' . "\r\n";
		
		mail($to1, $subject1, $message1, $headers); 

		$email_ad = $this->config->item('sales_email');
		
		mail($email_ad, $subject1, $message1, $headers);
		
		$this->home_model->updateOrderDetails($content);
		
		$this->home_model->updatestock($data["getorder"]->eventid,$data["getorder"]->num_attendees);

		if($this->session->userdata("coupancode") !='')
		{
			$coupon['user_id']=$this->session->userdata('userid');
			$coupon['orderid']=$id;
			$coupon['coupon_id']=$this->session->userdata('couponid');
			$coupon['couponcode']=$this->session->userdata('coupancode');
			$coupon['coupon_type']='1';
			$this->home_model->coupon_usage($coupon);
		}

		$coupan_data= array(
				'coupanname'  => "",
				'coupancode'  => "",
				'discount'  => "",
				'coupanvalue'  => "",
				'couponid'  => "",
			);
		$this->session->unset_userdata($coupan_data);
	
		$this->session->set_flashdata("success","Successfully Order");
		redirect($this->config->item('base_url').'home/thanks');
	}
	
	function thanks(){

		$data['err_msg'] = '';
		$data['message'] = 	"Thank you for booking the Experience with us. The details of the same have been mailed to you.";
		$this->load->view('thankyou_workshop',$data);
	}


	function gift_hamper_listing($page_url)
	{
		$data['err_msg'] = '';
		$gift_hamper_cate = $this->home_model->getgifthampercate($page_url);
		$data['gift_hamper_cate'] = $gift_hamper_cate->id;

		$this->load->library('pagination');
		$data['url_to_paging'] =  $url_to_paging =  $this->config->item('base_url')."gift-hampers/".$page_url;
		$data['search'] = $this->input->get('search');

		$config['per_page']= $per_page  = '10';
		$pageno = $this->input->get('per_page');

		if($pageno == '')
		{
			$pageno = '0';
		}
		$return = $this->home_model->lists_gift_hamper($per_page,$pageno, $data);

		$config['base_url'] = $url_to_paging;

		$config['total_rows'] = $return['count'];
		$data['totalcount'] = $return['count'];
		$data['all_gifthamper'] = $return['result'];

		//$data['allproductprice'] = $return['allresult'];
		//$data['filter_query'] =	$return['filter_query'];
		$config['first_link'] = 'First';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';

			$config['last_link'] = 'Last';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';

			$config['next_link'] = 'Next';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';

			$config['prev_link'] = 'Prev';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';

			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';

			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';

			$config['page_query_string'] = TRUE;
			$this->pagination->initialize($config);

		$data['all_gift_hamper_category'] = $this->home_model->all_gift_hamper_category();
        $data['mainttitle'] = $gift_hamper_cate->name;
		$this->load->view('gift_hamper_listing',$data);
	}


	function gift_hamper_detail($page_url)
	{
		$data['err_msg'] = '';
		$data['get_gift_hampers_detail'] = $this->home_model->get_gift_hampers_detail($page_url);
		$this->load->view('gift_hamper_category',$data);
	}

	 function changeStatusmail($orderid,$status)
   {
		/*$status=$this->input->post("status");
		$trackadd=$this->input->post("tracking");*/


	   	if($request=$this->home_model->update_status($orderid,$status))
		{
				$data['order'] = $this->home_model->order_detail_status($orderid);

				if($status=='S'){
						$message =  $this->load->view('emailer_status/order-shipped.php',$data,true);
				}
				if($status=='D'){
						$message =  $this->load->view('emailer_status/order-delivered.php',$data,true);
				}
				if($status=='C'){
						$message =  $this->load->view('emailer_status/order-cancelled.php',$data,true);
				}



			$to=$data["order"]->email_address;

			if($status=='P'){
					$subject  = 'Pending Order';
				}
			if($status=='S'){
					$subject  = 'Shipped Order';

				}
			if($status=='D'){
					$subject  = 'Delivered Order';

				}
			if($status=='C'){
			$subject  = 'Canceled Order ';

				}

			if($status !='P'){

			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: happysoul.in <info@happysoul.in>' . "\r\n" .
						'Reply-To: info@happysoul.in' . "\r\n" .
						'X-Mailer: PHP/' . phpversion();
			mail($to, $subject, $message, $headers);

			}
 			$this->session->set_flashdata('L_strErrorMessage','Your Order Status Update  successfully.');
			}
			else
			{
				$this->session->set_flashdata('flashError','Some Errors prevented from Adding!!!!');
			}
	   //redirect($this->config->item('base_url').'orders/lists');
	   redirect($this->config->item('base_url').'vendor-orders');

   }

	function services($page_url)
	{
		$data['err_msg'] = '';
		
		if($this->input->get('filters')){
			$data['filters'] = $this->input->get('filters');
		}
		$data['sort_by'] = $this->input->get('sort_by');
		
		$data['get_services'] = $this->home_model->get_services($page_url,$data);
		$data['get_services_category'] = $this->home_model->get_services_category($page_url);
		$data['allservicecategory'] = $this->home_model->allservicecategory();
		$data['filter_list'] = $this->home_model->getservicecategoryFilter($data['get_services_category']->id);
		$this->load->view('services',$data);
	}
	function services_detail($id)
	{
		$data['services_detail'] = $this->home_model->services_detail($id);
		$data['additional_details'] = $this->home_model->services_additional_details($id);
		$data['services_images'] = $this->home_model->services_images($id);
		$this->load->view('services_detail',$data);
	}

	function services_detail2()
	{
		$data['err_msg'] = '';
		$this->load->view('services_detail2',$data);
	}

	function services_detail3()
	{
		$data['err_msg'] = '';
		$this->load->view('services_detail3',$data);
	}

	function recipes()
	{
		$data['err_msg'] = '';
		$this->load->view('recipes',$data);
	}
	function show_input()
	{
		$cid = $_POST['cid'];
		$product_id = $_POST['pro_id'];
		$data = $this->home_model->show_input($cid);
		$html = "";
		if($data !='' && count($data) > 0)
		{
			for($i=0;$i<count($data);$i++)
			{
				$value = $this->home_model->show_input_value($product_id,$data[$i]->category_id,$data[$i]->id);
				$html .= "<div class='form-group'>
                  <label for='input_value'>".$data[$i]->input_name."</label>
                   <textarea id='".$i."' name='input_value[]' class='form-control jquery_ckeditor'>".$value."</textarea>
				   <INPUT TYPE='hidden' NAME='cat_id[]' VALUE='".$data[$i]->category_id."'>
				   <INPUT TYPE='hidden' NAME='cat_input_id[]' VALUE='".$data[$i]->id."'>
                </div>";
				
				/* <script>jQuery(document).ready(function () {\"use strict\";CKEDITOR.replace('".$i."',{});CKEDITOR.disableAutoInline = false;});</script> */
				/* $html .= "<option value='".$data[$i]->id."' ".$selected.">".$data[$i]->name ."</option>";*/
			}
		}
		echo $html;
	}

	function notifyme(){
	    if($this->input->post("captachcode") == $this->session->userdata('randomdata'))
		{
		$data['txtName']    = $this->input->post('txtName');
	    $data['txtMobile']  = $this->input->post('txtMobile');
	    $data['txtEmail']   = $this->input->post('txtEmail');
	    $data['txtMessage'] = $this->input->post('txtMessage');
	    $data['serviceId']  = $this->input->post('serviceId');
	    $data['page_url']  = $this->input->post('page_url');
	    $data['servicename']  = $this->input->post('servicename');
	    $this->home_model->notifymeenquriy($data);
		
		$message = '<!doctype html><html lang="en"><head>
	<title>Notify Me Enquiry</title>
	<style>
		@import url("https://fonts.googleapis.com/css?family=Lato");
	</style> </head><body style="text-align: center;margin: 0;background: #ececec; font-family: "Lato", sans-serif;font-weight: 100;">
	<div style="max-width:630px;margin: 0 auto;border: thin solid #f3f0f0;background: #fff; border:1px solid #ccc">
		<div style="float: left; width: 100%; border-bottom:1px solid #ccc; text-align:center">
		<a href="'.$this->config->item('base_url').'"><img src="'.$this->config->item('base_url_views').'images/logo2-hori.png" style="margin-top:20px;max-width:200px;"></a>
		</div>
		 <div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Hi '.$data['txtName'].',</p>
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Thank you for your interset we will notify you once this product is back in stock.</p>
		</div>
		<div style="float:left;width:92%;padding:10px 4%;text-align:left">
            <table style="width:100%; border: 1px solid black;border-collapse: collapse;">
              <tr>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">Product Name</td>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">'.$data['servicename'].'</td>
              </tr>
              <tr>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">Name</td>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">'.$data['txtName'].'</td>
              </tr>
              <tr>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">Mobile</td>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">'.$data['txtMobile'].'</td>
              </tr>
			  <tr>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">Email</td>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">'.$data['txtEmail'].'</td>
              </tr>
			  <tr>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">Message</td>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">'.$data['txtMessage'].'</td>
              </tr>
            </table>
        </div>

		<div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
						<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">With Miles of Smiles,<BR>
			Team Happy Soul</p><br>
						<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Need Help?<br>
						<a href="'.$this->config->item('base_url').'contact-us" style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Contact Us for Help & Support</a></p>
					</div>
		<div style="clear: both">
	</div></div>
</body>
</html>';

        $subject = "Notify Me for product ".$data['servicename'];
		$to = $data['txtEmail'];
		//$to = "patelnikul321@gmail.com";
		$contact_email = $this->config->item('contact_email');
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: HappySoul <info@happysoul.in>' . "\r\n" .
			'Reply-To: info@happysoul.in' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
		$headers .= 'Cc: info@happysoul.in' . "\r\n";

		mail($to, $subject, $message, $headers);
		mail($contact_email, $subject, $message, $headers);

	   $this->session->set_flashdata('L_strErrorMessage','Thank you for your enquiry. We will Notify you once the product is in stock.');
	    redirect($this->config->item('base_url').'product/'.$data['page_url']);
		} else {
			$this->session->set_flashdata('L_ErrorMessage','Invalid captcha code. Please enter valid captcha Code.');
			redirect($this->config->item('base_url').'product/'.$data['page_url']);
		}
	}
	
	function serviceenquriy(){
	    if($this->input->post("captachcode") == $this->session->userdata('randomdata'))
		{
		$data['txtName']    = $this->input->post('txtName');
	    $data['txtMobile']  = $this->input->post('txtMobile');
	    $data['txtEmail']   = $this->input->post('txtEmail');
	    $data['txtMessage'] = $this->input->post('txtMessage');
	    $data['serviceId']  = $this->input->post('serviceId');
	    $data['customerservice']  = $this->input->post('customerservice');
	    $data['servicename']  = $this->input->post('servicename');
	    $this->home_model->serviceenquriy($data);
		
		$message = '<!doctype html><html lang="en"><head>
	<title>Service Enquiry</title>
	<style>
		@import url("https://fonts.googleapis.com/css?family=Lato");
	</style> </head><body style="text-align: center;margin: 0;background: #ececec; font-family: "Lato", sans-serif;font-weight: 100;">
	<div style="max-width:630px;margin: 0 auto;border: thin solid #f3f0f0;background: #fff; border:1px solid #ccc">
		<div style="float: left; width: 100%; border-bottom:1px solid #ccc; text-align:center">
		<a href="'.$this->config->item('base_url').'"><img src="'.$this->config->item('base_url_views').'images/logo2-hori.png" style="margin-top:20px;max-width:200px;"></a>
		</div>
		 <div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Hi '.$data['servicename'].',</p>
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">New service enquiry. Please find all the details below:</p>
		</div>
		<div style="float:left;width:92%;padding:10px 4%;text-align:left">
            <table style="width:100%; border: 1px solid black;border-collapse: collapse;">
              <tr>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">Service Name</td>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">'.$data['servicename'].'</td>
              </tr>
              <tr>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">Name</td>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">'.$data['txtName'].'</td>
              </tr>
              <tr>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">Mobile</td>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">'.$data['txtMobile'].'</td>
              </tr>
			  <tr>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">Email</td>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">'.$data['txtEmail'].'</td>
              </tr>
			  <tr>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">Message</td>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">'.$data['txtMessage'].'</td>
              </tr>
            </table>
        </div>

		<div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
						<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">With Miles of Smiles,<BR>
			Team Happy Soul</p><br>
						<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Need Help?<br>
						<a href="'.$this->config->item('base_url').'contact-us" style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Contact Us for Help & Support</a></p>
					</div>
		<div style="clear: both">
	</div></div>
</body>
</html>';

        $subject = "New Service Enquiry";
		$to = $data['customerservice'];
		//$to = "patelnikul321@gmail.com";
		$contact_email = $this->config->item('contact_email');
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: HappySoul <info@happysoul.in>' . "\r\n" .
			'Reply-To: info@happysoul.in' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
		$headers .= 'Cc: info@happysoul.in' . "\r\n";

		mail($to, $subject, $message, $headers);
		mail($contact_email, $subject, $message, $headers);

	   $this->session->set_flashdata('L_strErrorMessage','Thank you for reaching out to us. Our team will contact you shortly');
	    redirect($this->config->item('base_url').'services-detail/'.$data['serviceId']);
		} else {
			$this->session->set_flashdata('L_ErrorMessage','Invalid captcha code. Please enter valid captcha Code.');
			redirect($this->config->item('base_url').'services-detail/'.$data['serviceId']);
		}
	}

	function farchisenquriy(){
	    
		if($this->input->post("captachcode") == $this->session->userdata('randomdata'))
		{
			$data['txtName']    = $this->input->post('txtName');
			$data['txtMobile']  = $this->input->post('txtMobile');
			$data['txtEmail']   = $this->input->post('txtEmail');
			$data['txtMessage'] = $this->input->post('txtMessage');
			$data['txtCity']	= $this->input->post('txtCity');
 			$data['serviceId']  = '0';
			$this->home_model->farchisenquriy($data);

			$message = '<!doctype html><html lang="en"><head>
	<title>FRANCHISE Enquiry</title>
	<style>
		@import url("https://fonts.googleapis.com/css?family=Lato");
	</style> </head><body style="text-align: center;margin: 0;background: #ececec; font-family: "Lato", sans-serif;font-weight: 100;">
	<div style="max-width:630px;margin: 0 auto;border: thin solid #f3f0f0;background: #fff; border:1px solid #ccc">
		<div style="float: left; width: 100%; border-bottom:1px solid #ccc; text-align:center">
		<a href="'.$this->config->item('base_url').'"><img src="'.$this->config->item('base_url_views').'images/logo2-hori.png" style="margin-top:20px;max-width:200px;"></a>
		</div>
		 <div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Hi Happysoul Team,</p>
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">New franchise enquiry. Please find all the details below:</p>
		</div>
		<div style="float:left;width:92%;padding:10px 4%;text-align:left">
            <table style="width:100%; border: 1px solid black;border-collapse: collapse;">
              <tr>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">Name</td>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">'.$data['txtName'].'</td>
              </tr>
              <tr>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">Mobile</td>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">'.$data['txtMobile'].'</td>
              </tr>
			  <tr>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">Email</td>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">'.$data['txtEmail'].'</td>
              </tr>
			  <tr>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">City</td>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">'.$data['txtCity'].'</td>
              </tr>
			  <tr>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">Message</td>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">'.$data['txtMessage'].'</td>
              </tr>
            </table>
        </div>
		<div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
						<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">With Miles of Smiles,<BR>
			Team Happy Soul</p><br>
						<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Need Help?<br>
						<a href="'.$this->config->item('base_url').'contact-us" style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Contact Us for Help & Support</a></p>
					</div>
		<div style="clear: both">
	</div></div>
</body>
</html>';

        $subject = "New Franchise Enquiry";
		$business_email = $this->config->item('business_email');
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: HappySoul <info@happysoul.in>' . "\r\n" .
			'Reply-To: info@happysoul.in' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
		$headers .= 'Cc: info@happysoul.in' . "\r\n";
  		mail($business_email, $subject, $message, $headers);
 
			$this->session->set_flashdata('L_strErrorMessage','Thank you for reaching out to us. Our team will contact you shortly');
			redirect($this->config->item('base_url').'store-locator');
		} else {
			$this->session->set_flashdata('L_ErrorMessage','Invalid captcha code. Please enter valid captcha Code.');
			redirect($this->config->item('base_url').'store-locator');
		}
	}

	function travelenquriy(){
	    
		if($this->input->post("captachcode") == $this->session->userdata('randomdata'))
		{
			$data['txtName']    = $this->input->post('txtName');
			$data['txtMobile']  = $this->input->post('txtMobile');
			$data['txtEmail']   = $this->input->post('txtEmail');
			$data['txtMessage'] = $this->input->post('txtMessage');
			$data['serviceId']  = $this->input->post('serviceId');
			$data['travelname']  = $this->input->post('travelname');
			$data['travelemail']  = $this->input->post('travelemail');

			$this->home_model->travelenquriy($data);

			$message = '<!doctype html><html lang="en"><head>
	<title>Travel Enquiry</title>
	<style>
		@import url("https://fonts.googleapis.com/css?family=Lato");
	</style> </head><body style="text-align: center;margin: 0;background: #ececec; font-family: "Lato", sans-serif;font-weight: 100;">
	<div style="max-width:630px;margin: 0 auto;border: thin solid #f3f0f0;background: #fff; border:1px solid #ccc">
		<div style="float: left; width: 100%; border-bottom:1px solid #ccc; text-align:center">
		<a href="'.$this->config->item('base_url').'"><img src="'.$this->config->item('base_url_views').'images/logo2-hori.png" style="margin-top:20px;max-width:200px;"></a>
		</div>
		 <div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Hi '.$data['travelname'].'</p>
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">New travel enquiry. Please find all the details below:</p>
		</div>
		<div style="float:left;width:92%;padding:10px 4%;text-align:left">
            <table style="width:100%; border: 1px solid black;border-collapse: collapse;">
               <tr>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">Travel Name</td>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">'.$data['travelname'].'</td>
              </tr>
              <tr>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">Name</td>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">'.$data['txtName'].'</td>
              </tr>
              <tr>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">Mobile</td>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">'.$data['txtMobile'].'</td>
              </tr>
			  <tr>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">Email</td>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">'.$data['txtEmail'].'</td>
              </tr>
			  <tr>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">Message</td>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">'.$data['txtMessage'].'</td>
              </tr>
            </table>
        </div>
		<div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
						<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">With Miles of Smiles,<BR>
			Team Happy Soul</p><br>
						<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Need Help?<br>
						<a href="'.$this->config->item('base_url').'contact-us" style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Contact Us for Help & Support</a></p>
					</div>
		<div style="clear: both">
	</div></div>
</body>
</html>';

        $subject = "New Travel Enquiry";
		$contact_email = $this->config->item('contact_email');
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: HappySoul <info@happysoul.in>' . "\r\n" .
			'Reply-To: info@happysoul.in' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
		$headers .= 'Cc: info@happysoul.in' . "\r\n";
		$to = $data['travelemail'];
		mail($to, $subject, $message, $headers);
		mail($contact_email, $subject, $message, $headers);
	

			$this->session->set_flashdata('L_strErrorMessage','Thank you for reaching out to us. Our team will contact you shortly');
			redirect($this->config->item('base_url').'travels/'.$this->input->post('pageurl'));
		} else {
			$this->session->set_flashdata('L_ErrorMessage','Invalid captcha code. Please enter valid captcha Code.');
			redirect($this->config->item('base_url').'travels/'.$this->input->post('pageurl'));
		}
	}

	function contactenquriy(){
	    
		if($this->input->post("captachcode") == $this->session->userdata('randomdata'))
		{
			$data['txtName']    = $this->input->post('txtName');
			$data['txtMobile']  = $this->input->post('txtMobile');
			$data['txtEmail']   = $this->input->post('txtEmail');
			$data['txtMessage'] = $this->input->post('txtMessage');
		
			$this->home_model->contactenquriy($data);

			$message = '<!doctype html><html lang="en"><head>
	<title>Contact Enquiry</title>
	<style>
		@import url("https://fonts.googleapis.com/css?family=Lato");
	</style> </head><body style="text-align: center;margin: 0;background: #ececec; font-family: "Lato", sans-serif;font-weight: 100;">
	<div style="max-width:630px;margin: 0 auto;border: thin solid #f3f0f0;background: #fff; border:1px solid #ccc">
		<div style="float: left; width: 100%; border-bottom:1px solid #ccc; text-align:center">
		<a href="'.$this->config->item('base_url').'"><img src="'.$this->config->item('base_url_views').'images/logo2-hori.png" style="margin-top:20px;max-width:200px;"></a>
		</div>
		 <div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Hi, </p>
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">New contact us enquiry. Please find all the details below:</p>
		</div>
		<div style="float:left;width:92%;padding:10px 4%;text-align:left">
            <table style="width:100%; border: 1px solid black;border-collapse: collapse;">
              <tr>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">Name</td>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">'.$data['txtName'].'</td>
              </tr>
              <tr>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">Mobile</td>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">'.$data['txtMobile'].'</td>
              </tr>
			  <tr>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">Email</td>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">'.$data['txtEmail'].'</td>
              </tr>
			  <tr>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">Message</td>
                <td style="border: 1px solid black;border-collapse: collapse;padding: 8px;">'.$data['txtMessage'].'</td>
              </tr>
            </table>
        </div>
		<div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
						<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">With Miles of Smiles,<BR>
			Team Happy Soul</p><br>
						<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Need Help?<br>
						<a href="'.$this->config->item('base_url').'contact-us" style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Contact Us for Help & Support</a></p>
					</div>
		<div style="clear: both">
	</div></div>
</body>
</html>';

        $subject = "Contact Us - Happy Soul";
		$contact_email = $this->config->item('customercare_email');
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: HappySoul <info@happysoul.in>' . "\r\n" .
			'Reply-To: info@happysoul.in' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
		$headers .= 'Cc: info@happysoul.in' . "\r\n";
		
		mail($contact_email, $subject, $message, $headers);
	

			$this->session->set_flashdata('L_strErrorMessage','Thank you for reaching out to us. Our team will contact you shortly');
			redirect($this->config->item('base_url').'contact-us/');
		} else {
			$this->session->set_flashdata('L_ErrorMessage','Invalid captcha code. Please enter valid captcha Code.');
			redirect($this->config->item('base_url').'contact-us/');
		}
	}

	 
	function unsubscribe($email){
	    $data = $this->home_model->unsubscribe($email);
	    $this->load->view('unsubscribe',$data);
	    //redirect($this->config->item('base_url'));
	} 
	
	function subscribe(){
	    $email = addslashes($_POST['email']);
	    $data = $this->home_model->subscribeemail($email);
	    if($data != '5'){
	        echo "0"; exit();
	    } else {
	    $message = '<!doctype html><html lang="en"><head>
	<title>Subscription Email</title>
	<style>
		@import url("https://fonts.googleapis.com/css?family=Lato");
	</style> </head><body style="text-align: center;margin: 0;background: #ececec; font-family: "Lato", sans-serif;font-weight: 100;">
	<div style="max-width:630px;margin: 0 auto;border: thin solid #f3f0f0;background: #fff; border:1px solid #ccc">
		<div style="float: left; width: 100%; border-bottom:1px solid #ccc; text-align:center">
		<a href="'.$this->config->item('base_url').'"><img src="'.$this->config->item('base_url_views').'images/logo2-hori.png" style="margin-top:20px;max-width:200px;"></a>
		</div>
		<div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Welcome to Happy Soul!</p>
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">We are a healthy & friendly community & we are excited that you are a part of it. We look forward to keeping you updated with the latest products and experiences in our wellness wonderland. Do look out for our promotions & discounts to keep both your wallet & your heart happy!</p>
		</div>
		
		<div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
						<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">With Miles of Smiles,<BR>
			Team Happy Soul</p><br>
						<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Need Help?<br>
						<a href="'.$this->config->item('base_url').'contact-us" style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Contact Us for Help & Support</a></p>
					</div>
		
		<div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
			<p><a href="'.$this->config->item('base_url').'/home/unsubscribe/'.$email.'" style="color:grey;font-size:12px;">Unsubscribe Mailing List</a></p>
		</div>
		
		<div style="clear: both"></div>
		
		
		</div>
</body>
</html>';

        $subject = "Thank You for subscribing to Happysoul's mailing list";
		$to = $email;
	
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From:HappySoul <info@happysoul.in>' . "\r\n" .
			'Reply-To: info@happysoul.in' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
		$headers .= 'Cc: info@happysoul.in' . "\r\n";

		mail($to, $subject, $message, $headers);
		$to = $this->config->item('hello_email');
		mail($to, $subject, $message, $headers);
        echo "1"; exit();
	    }
	}


	public function facebook(){
		$email = $this->input->post('email');
		$fname = $this->input->post('fname');

		$content['email'] = $email;
		$checklogin = $this->home_model->faceuserlogin($content);
		
		if($checklogin !='')
		{
			$newuserdata = array(
				'userid'  => $checklogin->id,
				'fname'  => $checklogin->fname,
				'company_name'  => $checklogin->company_name,
				'lname'  => $checklogin->lname,
				'mobile'  => $checklogin->mobile,
				'email'  => $checklogin->email,
				'user_vendor'  => $checklogin->user_vendor,
				'logged_in' => true
			);

			$check = $this->session->set_userdata($newuserdata);
		} else {
			$content['email'] = $email;
			$namearray = explode(' ',$fname);
			$content['name']  = $namearray[0]; 
			$content['lname']  = $namearray[1]; 
			$content['registerfrom']  = '1'; 
			$this->home_model->userfacebook($content);
			$checklogin = $this->home_model->faceuserlogin($content);

			$newuserdata = array(
				'userid'  => $checklogin->id,
				'fname'  => $checklogin->fname,
				'company_name'  => $checklogin->company_name,
				'lname'  => $checklogin->lname,
				'mobile'  => $checklogin->mobile,
				'email'  => $checklogin->email,
				'user_vendor'  => $checklogin->user_vendor,
				'logged_in' => true
			);
			$check = $this->session->set_userdata($newuserdata);
		}
	}
	
	public function gmail()
    {
		error_reporting('E_ALL');
		ini_set('display_errors','1');
	
	
        $google_client_id 		= '23299210493-vrafbra39akgnk3s89d211viqlb39u1o.apps.googleusercontent.com';
		$google_client_secret 	= 'hrBWy3OhxB8UZia1Dt1x-CNg';
		$google_redirect_url 	= 'https://www.happysoul.in/home/gmail/'; //path to your script
		$google_developer_key 	= '';
 
        
        require_once 'site/views/src/Google_Client.php';
        require_once 'site/views/src/contrib/Google_Oauth2Service.php';
       
        $gClient = new Google_Client();
        $gClient->setApplicationName('Login to Happsoul.in');
        $gClient->setClientId($google_client_id);
        $gClient->setClientSecret($google_client_secret);
        $gClient->setRedirectUri($google_redirect_url);
        $gClient->setDeveloperKey($google_developer_key);
        $google_oauthV2 = new Google_Oauth2Service($gClient);
        
        if (isset($_REQUEST['reset'])) {
            unset($_SESSION['token']);
            $gClient->revokeToken();
            header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL)); 
        }
        if (isset($_GET['code'])) {
            $gClient->authenticate($_GET['code']);
            $_SESSION['token'] = $gClient->getAccessToken();
            header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL));
            return;
        }
        if (isset($_SESSION['token'])) {
            $gClient->setAccessToken($_SESSION['token']);
        }
			
        if ($gClient->getAccessToken()) {
              
			$user               = $google_oauthV2->userinfo->get();
 			$user_id            = $user['id'];
			$user_name          = filter_var($user['name'], FILTER_SANITIZE_SPECIAL_CHARS);
			$email              = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
			$profile_url        = filter_var($user['link'], FILTER_VALIDATE_URL);
			$profile_image_url  = filter_var($user['picture'], FILTER_VALIDATE_URL);
			$personMarkup       = "$email<div><img src='$profile_image_url?sz=50'></div>";
			$_SESSION['token']  = $gClient->getAccessToken();
        } else {   
            $authUrl = $gClient->createAuthUrl();
        }
        if (isset($authUrl)) {
        } else { 



		$content['email'] = $email;
		$checklogin = $this->home_model->faceuserlogin($content);
		
		if($checklogin !='')
		{
			$newuserdata = array(
				'userid'  => $checklogin->id,
				'fname'  => $checklogin->fname,
				'company_name'  => $checklogin->company_name,
				'lname'  => $checklogin->lname,
				'mobile'  => $checklogin->mobile,
				'email'  => $checklogin->email,
				'user_vendor'  => $checklogin->user_vendor,
				'logged_in' => true
			);

			$check = $this->session->set_userdata($newuserdata);
		} else {
	
			$content['email'] = $email;
			$namearray = explode(' ',$user_name);
			$content['name']  = $namearray[0]; 
			$content['lname']  = $namearray[1]; 
			$content['registerfrom']  = '1'; 

			$this->home_model->userfacebook($content);
			$checklogin = $this->home_model->faceuserlogin($content);

			$newuserdata = array(
				'userid'  => $checklogin->id,
				'fname'  => $checklogin->fname,
				'company_name'  => $checklogin->company_name,
				'lname'  => $checklogin->lname,
				'mobile'  => $checklogin->mobile,
				'email'  => $checklogin->email,
				'user_vendor'  => $checklogin->user_vendor,
				'logged_in' => true
			);
			$check = $this->session->set_userdata($newuserdata);
		}

		if($this->cart->total_items() > 0)
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
		}
		 }

		  }


/*



			$checklogin = $this->register_model->userlogin_email($email);
                if($checklogin !='')
				{
                   $newuserdata = array(
                       'userid'  => $checklogin->id,
							'fname'  => $checklogin->fname,						
							'email'  => $checklogin->email,					
							'mobile'=> $checklogin->mobile,						
							'logged_in' => true
					);
					$check = $this->session->set_userdata($newuserdata);
				redirect($this->config->item('base_url').'home', 'location');
				}else {
                    $content['email'] = $email;
                    $content['name']  = $user_name;
                    $this->register_model->userfacebook($content);
                    $checklogin = $this->register_model->userlogin_email($email);
                    $newuserdata = array(
                        'userid'  => $checklogin->id,
							'fname'  => $checklogin->fname,						
							'email'  => $checklogin->email,					
							'mobile'=> $checklogin->mobile,						
							'logged_in' => true
					);
					$check = $this->session->set_userdata($newuserdata);
					redirect($this->config->item('base_url').'home', 'location');
                } 
        } */
   

	function delivered()
	{
		$this->load->library('shipping');
		$id = 'ECZ139812';//$this->input->post("bookingid");
		$postfields['order_ids'] = $id;
		$result = $this->shipping->deliveredstatus($postfields);
		$schedulepickuparray = json_decode($result);
		
		echo "<pre>";
		print_r($schedulepickuparray);


		if($schedulepickuparray->tracking_details != '' && count($schedulepickuparray->tracking_details) > 0){
			foreach($schedulepickuparray->tracking_details as $trackdetails){
				?>
				<div style="padding:20px;"><p>Order Id: <?php echo $trackdetails->order_id; ?></p>
				<p>Tracking Number: <?php echo $trackdetails->tracking_number; ?></p>
				<p>Tag: <?php echo $trackdetails->tag; ?></p>
				<p>Slug:  <?php echo $trackdetails->slug; ?></p>
				<table>
				<tr style="padding:5px;">
					<td>Message</td>
					<td>Time</td>
				</tr>
				<?php if($trackdetails->checkpoints != '' && count($trackdetails->checkpoints) > 0){
					foreach($trackdetails->checkpoints as $checkpoints){
						?>
						<tr style="padding:5px;">
							<td><?php echo $checkpoints->message; ?></td>
							<td><?php echo $checkpoints->checkpoint_time; ?></td>
						</tr>
						<?php
					}
				} ?>
				</table>
				</div>
			<?php }
		} else {
			echo "<p>No Records Found.</p>"; 
		}

		//echo "<pre>";	 
		//print_r($schedulepickuparray); die;
	}
	
	function our_story(){
	  //  $data = $this->home_model->unsubscribe($email);
	    $this->load->view('our-story');
	    //redirect($this->config->item('base_url'));
	} 

	function createinvoice_vendor()
	{
		$this->load->model('account_model');
		$orderid = $this->input->post("itemid");
		$data['panel'] = $this->input->post("panel");
		$data['orderid'] = $orderid;
		$data["orderdetails"] = $this->account_model->getorderinvoice_vendor($orderid);
		//print_r($data["orderdetails"]);die;
		$data["vendordetails"] = $this->account_model->vendordetails($data["orderdetails"][0]->vendor_id);
		
		$data["ship_address"] = $this->account_model->ship_address($data["orderdetails"][0]->order_id);
		$data['profile'] = $this->account_model->getuserdata($data["orderdetails"][0]->user_id);
 		$html = $this->load->view('invoice',$data,true);
		echo $html;
	}

	function createinvoice()
	{
		$this->load->model('account_model');
		$orderid = $this->input->post("itemid");
		$data['orderid'] = $orderid;
		$data["orderdetails"] = $this->account_model->getorderinvoice($orderid);
		$data["vendordetails"] = $this->account_model->vendordetails($data["orderdetails"][0]->vendor_id);
		$data["ship_address"] = $this->account_model->ship_address($orderid);
		$data['profile'] = $this->account_model->getuserdata($data["orderdetails"][0]->user_info_id);
 		$html = $this->load->view('invoice',$data,true);
		echo $html;
	}

	function shippinginvoice()
	{
		$this->load->model('account_model');
		$orderid = $this->input->post("itemid");
		$data['panel'] = $this->input->post("panel");
		$data['orderid'] = $orderid;
		$data["orderdetails"] = $this->account_model->getorderinvoice_vendor($orderid);
		//print_r($data["orderdetails"]);die;
		$data["vendordetails"] = $this->account_model->vendordetails($data["orderdetails"][0]->vendor_id);
		
		$data["ship_address"] = $this->account_model->ship_address($data["orderdetails"][0]->order_id);
		$data['profile'] = $this->account_model->getuserdata($data["orderdetails"][0]->user_id);
 		$html = $this->load->view('invoiceshipping',$data,true);
		echo $html;
 		 
	}

	function createcomminvoice()
	{
		$this->load->model('account_model');
		$orderid = $this->input->post("itemid");
		$data['panel'] = $this->input->post("panel");
		$data['orderid'] = $orderid;
		$data["orderdetails"] = $this->account_model->getorderinvoice_vendor($orderid);
		//print_r($data["orderdetails"]);die;
		$data["vendordetails"] = $this->account_model->vendordetails($data["orderdetails"][0]->vendor_id);
		
		$data["ship_address"] = $this->account_model->ship_address($data["orderdetails"][0]->order_id);
		$data['profile'] = $this->account_model->getuserdata($data["orderdetails"][0]->user_id);
 		$html = $this->load->view('comminvoice',$data,true);
		echo $html;
 		 
	}

	function trackpackage($bookingid)
	{
		$this->load->model('account_model');
		$id = $bookingid;
		$data['productid'] = $id;
		$data["order_detail"] = $this->account_model->getorderitem_bookingshipid($id);
		$data['schedulepickuparray'] = array();
		if($data["order_detail"]->api_booking_id != '') {
			$this->load->library('shipping');
			$id = $data["order_detail"]->api_booking_id;
			$postfields['order_ids'] = $id;
			$result = $this->shipping->deliveredstatus($postfields);
			$schedulepickuparray = json_decode($result); 
			$data['schedulepickuparray'] = $schedulepickuparray;
		}

		//print_r($schedulepickuparray); die;
		$this->load->view('track_package_view',$data);
 		//$html = $this->load->view('track_package',$data,true);
		//echo $html;
	}
	
	function mailreview(){
		$data = array();
		$data['err_msg'] = '';
		$data['product_id'] = $product_id = $this->input->get('product_id');		
		$data['order_item_id'] = $order_item_id = $this->input->get('order_item_id');		
		$data['user_name'] = $user_name = $this->input->get('user_name');		
		$data['review_score'] =$review_score=$this->input->get('review_score');		
		$data['review_message'] =$review_message=$this->input->get('review_message');
 
		$review = $this->account_model->get_review($product_id,$user_name);		
		/*if($review_message == '')	
		{
			$data['message'] = "You have not entered review description";
			$this->load->view('reviewthankyou',$data);
		}
		else
		{ */
			if($review!='')
			{
				$this->session->set_userdata('reviewalreadyexit','Your review have been already submitted for this product');
			}
			else
			{

				$content['user_id'] = $user_name;
				$content['starrating'] = $review_score;
				$content['description'] = $review_message;
				$content['product_id'] = $product_id;
				$content['added_date'] = date('Y-m-d');

				$review = $this->account_model->save_add_reviews($content);
				$userdetails = $this->account_model->getuserdata($user_name);
				$productdetails = $this->account_model->getproductdetails($product_id);

				$message = '<!doctype html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Reviews Submitted Email </title>
	<style>
		@import url("https://fonts.googleapis.com/css?family=Lato");
	</style> 
</head>
<body style="text-align: center;margin: 0;background: #ececec; font-family: "Lato", sans-serif;font-weight: 100;">
	<div style="max-width:630px;margin: 0 auto;border: thin solid #f3f0f0;background: #fff; border:1px solid #ccc">
		<div style="float: left; width: 100%; border-bottom:1px solid #ccc">
		<a href="'.$this->config->item('base_url').'"><img src="'.$this->config->item('base_url_views').'images/logo2-hori.png" style="margin-top:20px;max-width:200px;"></a>
		</div>
		<div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Dear '.ucfirst($userdetails->fname." ".$userdetails->lname).',</p>
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">We at Happy Soul would LOVE your valuable feedback on '.$productdetails->name.'. Your review would help us keep our selection and standards high. Our vendors would appreciate it too. We look forward to your next visit at our Wellness Wonderland!!!</p>
		</div>
		<div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">With Miles of Smiles,<BR>
Team Happy Soul</p><br>
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Need Help?<br>
			<a href="'.$this->config->item('base_url').'contact-us" style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Contact 24x7 Help & Support</a></p>
		</div>
		<div style="clear: both">
	</div></div>
</body>
</html>';

        $subject = "Thank You for Your Review.";
		$to = $userdetails->email;
	
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From:HappySoul <info@happysoul.in>' . "\r\n" .
			'Reply-To: info@happysoul.in' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
		$headers .= 'Cc: info@happysoul.in' . "\r\n";

		mail($to, $subject, $message, $headers);

		$to = $this->config->item('review_email');
		mail($to, $subject, $message, $headers);


				$this->session->set_userdata('review_thank','Thank you for your review of the product and we look forward to improve based on your experience and suggestions');
			}
			$this->load->view('reviewthankyou',$data);
		/* } */
	}

}
