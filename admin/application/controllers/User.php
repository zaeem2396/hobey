<?php
	class User extends CI_Controller {
	private $_data = array();
	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('adminId') == ''){
			redirect($this->config->item('base_url'));
        }
		$this->load->model('user_model'); 
	}

	function add(){
        
		$L_strErrorMessage='';
		$form_field = $data = array(
            
			'title' => '',
			'date'=>'',
			
			'image' => '',
			'description' => '',
			
		);
		if($this->input->post('action') == 'add_news') 
		{ 
			foreach($form_field as $key => $value)
			{	
           
				$data[$key]=$this->input->post($key);	
			}
			$this->load->library('validation');
           
			
			$rules['title'] = "required";
			
			$this->validation->set_rules($rules);
			
			$fields['title'] = "title";
			
			$this->validation->set_fields($fields);
			
			if($_FILES['image']['name'] !='')
				{
				$tmp_name1 =  $_FILES['image']['tmp_name']; 
		 		$rootpath1 =  $this->config->item('upload')."latest_news/";
				$logoname = time().$_FILES['image']['name'];
				move_uploaded_file( $tmp_name1 , $rootpath1.$logoname );
				$data['image']=$logoname;
			}else{
				$data['image'] ='';
				 }
				 
			/* if(!$this->user_model->is_add($this->input->post('coupancode')))
			{*/
					 $this->user_model->add($data);
						$this->session->set_flashdata('L_strErrorMessage','Latest News Added Successfully!!!!');
						redirect($this->config->item('base_url').'latest_news/lists');
						
			/*	}

			else

			{

				$this->session->set_flashdata('flashError','Coupan Code Already Exist!');

			} */
						if ($this->validation->run() == FALSE){
				$data['L_strErrorMessage'] = $this->validation->error_string;
			} 
    }
	
    $this->load->view('add_latest_news',$data);
}



    function edit($id)
	{	 
   
			if(is_numeric($id))
			{
				$result = $this->user_model->get_news($id);  
			
				$form_field = $data = array(
						'L_strErrorMessage' => '',
						'id'	=> $result[0]->id,                        
						'name' =>  $result[0]->name,
						//'lname'=>$result[0]->lname,						
						'email' =>  $result[0]->email,						
						'mobile' => $result[0]->mobile,
						//'address' =>  $result[0]->address,
						//'country'=>$result[0]->country,						
						//'state' =>  $result[0]->state,						
						//'city' => $result[0]->city,
						'pincode' => $result[0]->pincode,
						);  

				if($this->input->post('action') == 'edit_user') 
				{
					foreach($data as $key => $value) {  $form_field[$key]=$this->input->post($key);	}
					$this->load->library('validation');
                   
					
					$rules['name'] = "trim|required";
					$this->validation->set_rules($rules);
					
					$fields['name'] = "title";
					
					$this->validation->set_fields($fields);
					if ($this->validation->run() == FALSE) 
					{
							$data = $form_field;
							$data['L_strErrorMessage'] = $this->validation->error_string;
							$data['id'] = $id;
					} 
					else 
					{
						
							$ccid=$id;
					/*	if(!$this->user_model->is_exist($this->input->post('coupancode'),$ccid))

						{*/
								$this->user_model->edit($id, $form_field);
								$this->session->set_flashdata('L_strErrorMessage','User Updated Successfully!!!!');
								redirect($this->config->item('base_url').'user/lists');
						/*}

						else

						{

							$this->session->set_flashdata('flashError','Coupan Code Already Exist!!!!');

						}*/
					}
				}
				
				$this->load->view('edit_user',$data);
			} 
			else 
			{
				$this->session->set_flashdata('L_strErrorMessage','No Such Users !!!!');
				redirect($this->config->item('base_url').'user/lists');
			}
	}

	function lists()
	{
		$this->load->library('pagination');
		$url_to_paging = $this->config->item('base_url');
		$config['base_url'] = $url_to_paging.'user/lists/';
		$config['per_page'] = '10000';
		$config['first_url']='0';
		$data = array();
		//using for searching data...
		$data['title'] = $this->input->post('title');
		$data['startdate'] = $this->input->post('startdate');
		$data['enddate'] = $this->input->post('enddate');
		$per_page = '1';
		$perpage = '3';
		//below is used in all perpose
		$return = $this->user_model->lists($config['per_page'],$this->uri->segment(3), $data);
		$data['result'] = $return['result'];
		$config['total_rows'] = $return['count'];
		//echo "<pre>";print_r($data);break;
		$this->pagination->initialize($config);
       
	    $this->load->view('list_user', $data);
	}
	
	function lists_subscribe()
	{
		$this->load->library('pagination');
		$url_to_paging = $this->config->item('base_url');
		$config['base_url'] = $url_to_paging.'user/lists/';
		$config['per_page'] = '10000';
		$config['first_url']='0';
		$data = array();
		//using for searching data...
		$data['title'] = $this->input->post('title');
		$data['startdate'] = $this->input->post('startdate');
		$data['enddate'] = $this->input->post('enddate');
		$per_page = '1';
		$perpage = '3';
		//below is used in all perpose
		$return = $this->user_model->lists_subscribe($config['per_page'],$this->uri->segment(3), $data);
		$data['result'] = $return['result'];
		$config['total_rows'] = $return['count'];
		//echo "<pre>";print_r($data);break;
		$this->pagination->initialize($config);
       
	    $this->load->view('lists_subscribe', $data);
	}

	function lists_franchise()
	{
		$this->load->library('pagination');
		$url_to_paging = $this->config->item('base_url');
		$config['base_url'] = $url_to_paging.'user/lists/';
		$config['per_page'] = '10000';
		$config['first_url']='0';
		$data = array();
		//using for searching data...
		$data['title'] = $this->input->post('title');
		$data['startdate'] = $this->input->post('startdate');
		$data['enddate'] = $this->input->post('enddate');
		$per_page = '1';
		$perpage = '3';
		//below is used in all perpose
		$return = $this->user_model->lists_franchise($config['per_page'],$this->uri->segment(3), $data);
		$data['result'] = $return['result'];
		$config['total_rows'] = $return['count'];
		//echo "<pre>";print_r($data);break;
		$this->pagination->initialize($config);
       
	    $this->load->view('lists_franchise', $data);
	}

	function lists_contactus()
	{
		$this->load->library('pagination');
		$url_to_paging = $this->config->item('base_url');
		$config['base_url'] = $url_to_paging.'user/lists/';
		$config['per_page'] = '10000';
		$config['first_url']='0';
		$data = array();
		//using for searching data...
		$data['title'] = $this->input->post('title');
		$data['startdate'] = $this->input->post('startdate');
		$data['enddate'] = $this->input->post('enddate');
		$per_page = '1';
		$perpage = '3';
		//below is used in all perpose
		$return = $this->user_model->lists_contactus($config['per_page'],$this->uri->segment(3), $data);
		$data['result'] = $return['result'];
		$config['total_rows'] = $return['count'];
		//echo "<pre>";print_r($data);break;
		$this->pagination->initialize($config);
       
	    $this->load->view('lists_contactus', $data);
	}

	function lists_notify()
	{
		$this->load->library('pagination');
		$url_to_paging = $this->config->item('base_url');
		$config['base_url'] = $url_to_paging.'user/lists/';
		$config['per_page'] = '10000';
		$config['first_url']='0';
		$data = array();
		//using for searching data...
		$data['title'] = $this->input->post('title');
		$data['startdate'] = $this->input->post('startdate');
		$data['enddate'] = $this->input->post('enddate');
		$per_page = '1';
		$perpage = '3';
		//below is used in all perpose
		$return = $this->user_model->lists_notify($config['per_page'],$this->uri->segment(3), $data);
		$data['result'] = $return['result'];
		$config['total_rows'] = $return['count'];
		//echo "<pre>";print_r($data);break;
		$this->pagination->initialize($config);
       
	    $this->load->view('lists_notify', $data);
	}

	function deletes()
	{
		if(isset($_POST['selected']) && count($_POST['selected']) > 0) {
			foreach($_POST['selected'] as $selCheck) {
				if($this->user_model->deletes($selCheck)) {
					$this->session->set_flashdata('L_strErrorMessage','User Deleted Successfully!!!!');
				}  
				else 
				{
						$this->session->set_flashdata('L_strErrorMessage','Some Errors prevented from Deleting!!!!');
						break;
				}
			}
		}
		redirect($this->config->item('base_url').'user/lists');
	}
	function show_subcategory()
	{
		$cid = $_POST['cid'];
		$data = $this->user_model->allsubcategory($cid);
		$html = "<select id='subcategoryid' name='subcategoryid' class='form-control'>";
		$html .= "<option value=''>Select Sub Category</option>";
		if($data!=''){
		for($i=0;$i<count($data);$i++)
		{
			$html .= "<option value='".$data[$i]->id ."'>".$data[$i]->subcategoryname ."</option>";
		}
		}
		$html .="</select>";
		echo $html;
	}
	function updatestatus($id,$value)
	{	
		$result=$this->user_model->updatestatus($id,$value);
		$this->session->set_flashdata('L_strErrorMessage','Status Updated Succcessfully!!!!');
		redirect($this->config->item('base_url').'user/lists');
		//$this->load->view('users/list_user', $data);
	}
	
	function downloadsubscribe(){
		    $subscribe = $this->user_model->subscribelists();
			$output = '';
			$output .= 'Email';
			$output .="\n";
			// Get Records from the table
			if($subscribe != '' && count($subscribe) > 0) {
				foreach($subscribe as $subd) {
					$output .= '"'.$subd->email.'"';  
					$output .="\n";
				}
			}
	 		$filename = "Subscribe.csv";
			header('Content-type: application/csv');
			header('Content-Disposition: attachment; filename='.$filename);
			echo $output;
			exit;
	}
	
	function downloadfranchise(){
		$subscribe = $this->user_model->downloadfranchise();
		$output = '';
		$output .= 'Date,Name,Email,City,Mobile,Message';
		$output .="\n";
		// Get Records from the table
		if($subscribe != '' && count($subscribe) > 0) {
			foreach($subscribe as $subd) {
				$output .= '"'.date('d/m/Y',strtotime($subd->added_date)).'","'.$subd->txtName.'","'.$subd->txtEmail.'","'.$subd->txtCity.'","'.$subd->txtMobile.'","'.$subd->txtMessage.'"';  
				$output .="\n";
			}
		}
		$filename = "franchisenquirylist.csv";
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename='.$filename);
		echo $output;
		exit;
	}

	function downloadcontact(){
		$subscribe = $this->user_model->downloadcontact();
		$output = '';
		$output .= 'Date,Name,Email,Mobile,Message';
		$output .="\n";
		// Get Records from the table
		if($subscribe != '' && count($subscribe) > 0) {
			foreach($subscribe as $subd) {
				$output .= '"'.date('d/m/Y',strtotime($subd->added_date)).'","'.$subd->txtName.'","'.$subd->txtEmail.'","'.$subd->txtMobile.'","'.$subd->txtMessage.'"';  
				$output .="\n";
			}
		}
		$filename = "contactenquirylist.csv";
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename='.$filename);
		echo $output;
		exit;
	}

	function downloadnotify(){
		$subscribe = $this->user_model->downloadnotify();
		$output = '';
		$output .= 'Date,Name,Email,Mobile,Message';
		$output .="\n";
		// Get Records from the table
		if($subscribe != '' && count($subscribe) > 0) {
			foreach($subscribe as $subd) {
				$output .= '"'.date('d/m/Y',strtotime($subd->added_date)).'","'.$subd->txtName.'","'.$subd->txtEmail.'","'.$subd->txtMobile.'","'.$subd->txtMessage.'"';  
				$output .="\n";
			}
		}
		$filename = "notifymeusers.csv";
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename='.$filename);
		echo $output;
		exit;
	}
	 
	function deletefranchise()
	{
		if(isset($_POST['selected']) && count($_POST['selected']) > 0) {

			foreach($_POST['selected'] as $selCheck) {

				if($this->user_model->deletefranchise($selCheck)) {
					$this->session->set_flashdata('L_strErrorMessage','Franchise Enquiry Deleted Successfully!');
				}
				else
				{
						$this->session->set_flashdata('flashError','Some Errors prevented from Deleting!');

				}
			}
		}
		redirect($this->config->item('base_url').'user/lists_franchise');
	}
	
	function deletecontact(){
		if(isset($_POST['selected']) && count($_POST['selected']) > 0) {

			foreach($_POST['selected'] as $selCheck) {

				if($this->user_model->deletecontact($selCheck)) {
					$this->session->set_flashdata('L_strErrorMessage','Contact Us Enquiry Deleted Successfully!');
				}
				else
				{
						$this->session->set_flashdata('flashError','Some Errors prevented from Deleting!');

				}
			}
		}
		redirect($this->config->item('base_url').'user/lists_contactus');
	}
	
	function deletenotify(){
		if(isset($_POST['selected']) && count($_POST['selected']) > 0) {

			foreach($_POST['selected'] as $selCheck) {

				if($this->user_model->deletenotify($selCheck)) {
					$this->session->set_flashdata('L_strErrorMessage','Notify Me Users Deleted Successfully!');
				}
				else
				{
						$this->session->set_flashdata('flashError','Some Errors prevented from Deleting!');

				}
			}
		}
		redirect($this->config->item('base_url').'user/lists_notify');
	}
}

?>
