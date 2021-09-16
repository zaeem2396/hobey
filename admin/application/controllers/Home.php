<?php
class Home extends CI_Controller {
	private $_data = array();
	function __construct() {
		parent::__construct();
		if($this->session->userdata('adminId') == ''){
			redirect($this->config->item('base_url'));
		}
	}
	function index()
	{	
 		$this->load->model('admin');
		$data = array();
		$data['L_strErrorMessage']='';
	    /*$data['orderstatus'] = $this->admin->orderstatus();
	    $data['topproducts'] = $this->admin->topproducts();
	    $data['topvendors'] = $this->admin->topvendors();
	    $data['newproducts'] = $this->admin->newproducts();
	    $data['updatedproducts'] = $this->admin->updatedproducts();
	    $data['notifications'] = $this->admin->notifications('0');*/
		$this->load->view('dashboard',$data);
	}	
	
	function change_password(){		
    	$this->load->model('admin');
    	$result = $this->admin->get_user($this->session->userdata('adminId'));  
    	$form_field = $data = array(				
    	'L_strErrorMessage' => '',	
    	'id'	=> $result[0]->id,	
    	'password'	=> $result[0]->password,	
    	'newpassword'	=>"",		
    	);				
    	if($this->input->post('action') == 'edit_pass') 	
    	{				
    	foreach($data as $key => $value) 		
    	{					
    	$form_field[$key]=$this->input->post($key);		
    	}				
    	$this->load->library('validation');			
    	$rules['newpassword'] = "trim|required";		
    	$this->validation->set_rules($rules);		
    	$fields['newpassword']   = "tutorial Category Name";
    	$this->validation->set_fields($fields);			
    	if ($this->validation->run() == FALSE) 		
    		{						
    	$data = $form_field;	
    	$data['L_strErrorMessage'] = $this->validation->error_string;	
    		}else{						
    	if($response = $this->admin->edit_pass($form_field))	
    		{					
    	$this->session->set_flashdata('L_strErrorMessage','Password Updated Successfully!!!!');	
    	redirect($this->config->item('base_url').'home/change_password');		
    	}			
    	else 		
    		{		
    	$data['L_strErrorMessage'] = 'Some Errors prevented from update data,please try again later.';
    	}		
    	}	
    	}		
    	$this->load->view('edit_password',$data);	
	}
	
	
	function download_user()
	{
		$this->load->model('admin');
		$orders_list  = $this->admin->list_user1();
		$output = '';
		$output .= 'Sr No.,First Name,Last Name, Email,Mobile';
		$output .="\n";
		if($orders_list != '' && count($orders_list) > 0) {
			$i=1;
		foreach($orders_list as $orders) {
			
		$output .= '"'.$i.'","'.$orders['fname'].'","'.$orders['lname'].'","'.$orders['email'].'","'.$orders['mobile'].'"';  
		$output .="\n";
		$i++; }
		}
		$filename = "users.csv";
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename='.$filename);
		echo $output;
		exit;	
		
	}
	
	function download_subscribe()
	{
		$this->load->model('admin');
		$orders_list  = $this->admin->list_subscribe1();
		$output = '';
		$output .= 'Sr No.,Email,Type';
		$output .="\n";
		if($orders_list != '' && count($orders_list) > 0) {
			$i=1;
		foreach($orders_list as $orders) {
			if($orders['flage']==0)
			{
				$flage="Say YAA to Yoga";
			}else
			{
				$flage="YogiTribe";
			}
		$output .= '"'.$i.'","'.$orders['email'].'","'.$flage.'"';  
		$output .="\n";
		$i++; }
		}
		$filename = "subscribe.csv";
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename='.$filename);
		echo $output;
		exit;	
		
	}
	
	function productchange(){
	    
	   $this->load->model('vendor_model');
	   $this->load->model('product_model');
	   $productid = $this->input->post('productid');
	   $comment = $this->input->post('comment');
	   
	   $result_product = $this->product_model->get($productid);
       $result_data = $this->vendor_model->get_news($result_product[0]->vendor_id); 

	   $comment = "Product Name: ".$result_product[0]->name." <br/> Message: ".$comment; 

	   $this->product_model->adminmessage($result_data,$comment);
	   
	    $email = $result_data[0]->email; //$this->config->item('admin_email');
		$message = '<!doctype html><html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Message from Happy Soul Admin</title>
	<style>
		@import url("https://fonts.googleapis.com/css?family=Lato");
	</style> </head><body style="text-align: center;margin: 0;background: #ececec; font-family: "Lato", sans-serif;font-weight: 100;">
	<div style="max-width:630px;margin: 0 auto;border: thin solid #f3f0f0;background: #fff; border:1px solid #ccc">
		<div style="float: left; width: 100%; border-bottom:1px solid #ccc; text-align:center">
		<a href="'.$this->config->item('front_base_url').'"><img src="'.$this->config->item('front_base_url').'site/views/images/logo2-hori.png" style="margin-top:20px;max-width:200px;"></a>
		</div>
		<div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
 			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Hi</p>
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Message from Happy Soul Admin:</p>
		</div>
		<div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
 		 	<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">'.$comment.'</p>
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

        $subject = "Message from Happy Soul Admin";
		$to = $email;
	
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: Happysoul <info@happysoul.in>' . "\r\n" .
			'Reply-To: info@happysoul.in' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
		$headers .= 'Cc: info@happysoul.in' . "\r\n";
		mail($to, $subject, $message, $headers);

		$to = $this->config->item('admin_email');
        mail($to, $subject, $message, $headers);  
            
		$this->session->set_flashdata('L_strErrorMessage','Message has been sent to vendor succesfully!');
	    redirect($this->config->item('base_url').'home');
	}
	
	function notifications()
	{
	    $this->load->model('admin');
		$this->load->library('pagination');
		$url_to_paging = $this->config->item('base_url');
		$config['base_url'] = $url_to_paging.'home/notifications/';
		$config['per_page'] = '10000';
		$config['first_url']='0';
		$data = array();
		//using for searching data...
		$data['colour'] = $this->input->post('colour');
		$per_page = '1';
		$perpage = '3';
		//below is used in all perpose
		$return = $this->admin->list_notifications($config['per_page'],$this->uri->segment(3), $data);
		$data['result'] = $return['result'];
		$config['total_rows'] = $return['count'];
		//echo "<pre>";print_r($data);break;
		$this->pagination->initialize($config);
		$this->load->view('list_notifications', $data);
	}
	
	function topproducts()
	{
	    $this->load->model('admin');
		$this->load->library('pagination');
		$url_to_paging = $this->config->item('base_url');
		$config['base_url'] = $url_to_paging.'home/notifications/';
		$config['per_page'] = '10000';
		$config['first_url']='0';
		$data = array();
		//using for searching data...
		$data['colour'] = $this->input->post('colour');
		$per_page = '1';
		$perpage = '3';
		//below is used in all perpose
		$return = $this->admin->listtopproducts($config['per_page'],$this->uri->segment(3), $data);
		$data['result'] = $return['result'];
		$config['total_rows'] = $return['count'];
		//echo "<pre>";print_r($data);break;
		$this->pagination->initialize($config);
		$this->load->view('topproducts', $data);
	}
	
	function topvendors()
	{
	    $this->load->model('admin');
		$this->load->library('pagination');
		$url_to_paging = $this->config->item('base_url');
		$config['base_url'] = $url_to_paging.'home/notifications/';
		$config['per_page'] = '10000';
		$config['first_url']='0';
		$data = array();
		//using for searching data...
		$data['colour'] = $this->input->post('colour');
		$per_page = '1';
		$perpage = '3';
		//below is used in all perpose
		$return = $this->admin->listtopvendors($config['per_page'],$this->uri->segment(3), $data);
		$data['result'] = $return['result'];
		$config['total_rows'] = $return['count'];
		//echo "<pre>";print_r($data);break;
		$this->pagination->initialize($config);
		$this->load->view('topvendors', $data);
	}
	 
}