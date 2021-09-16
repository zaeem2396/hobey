<?php
class Users extends CI_Controller {
	private $_data = array();
	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('adminId') == ''){
			redirect($this->config->item('base_url'));
        }
		$this->load->model('users_model');
	}
	
	function add()
	{
		//$L_strErrorMessage='';
		$form_field = $data = array(  
				'L_strErrorMessage' => '',
				'ucategory' => '',
		        'name' => '',
			    'login' => '',
				'password' => '',
				'email' => ' ',
				'mobile' => '',
				
				
			);
			
		if($this->input->post('action') == 'add_users') 
		{
			foreach($form_field as $key => $value)
			{	
				$data[$key]=$this->input->post($key);	
				
			}
			$this->load->library('validation');
			$rules['name'] = "trim|required";
			
			
			$this->validation->set_rules($rules);
			$fields['name'] = "name";
			
			$this->validation->set_fields($fields);
			
			   if ($this->validation->run() == FALSE){
				$data['L_strErrorMessage'] = $this->validation->error_string;
			   } else {
				
					if(!$this->users_model->is_users_already_exist_add($this->input->post('email')))
					{
						if($response = $this->users_model->add($data))
						{
					  
						$this->session->set_flashdata('L_strErrorMessage','Users Added Successfully!!!!');
						redirect($this->config->item('base_url').'users/lists');
						}
						else 
						{
							$data['L_strErrorMessage'] = 'Some Errors prevented from adding data,please try later.';
						}
					}	
					else
					{
						$data['L_strErrorMessage'] = 'User already exist!';
					}
			}
		}
		 $data['utype_list'] = $this->users_model->utype_list();
		
		$this->load->view('add_users',$data);
	}
	
    function edit($id)
	{	 
			if(is_numeric($id))
			{
				$result = $this->users_model->get_user($id);  
				//print_r($result);die();
				$form_field = $data = array(
						'L_strErrorMessage' => '',
						'id'	=> $result[0]->id,
						'name' =>  $result[0]->name,
						'login' =>  $result[0]->login,
						'password' => $result[0]->password,
						'email' => $result[0]->email,
						'ucategory' => $result[0]->role_id,
						'mobile' => $result[0]->mobile,	
									
					
						);  
					
				if($this->input->post('action') == 'edit_users') 
				{
					foreach($data as $key => $value) {  $form_field[$key]=$this->input->post($key);	}
					
					$this->load->library('validation');
					$rules['name'] = "trim|required";
					
  					$this->validation->set_rules($rules);
					$fields['name']   = "name";
					
				 
					$this->validation->set_fields($fields);
					if ($this->validation->run() == FALSE) {
					$data = $form_field;
					$data['L_strErrorMessage'] = $this->validation->error_string;
					$data['id'] = $id;

				} 
				else 
				{
					
					if(!$this->users_model->is_users_already_exist($this->input->post('email'),$id))
					{
						if($response = $this->users_model->edit($id, $form_field)) {
						
							$this->users_model->edit($id, $form_field);
							$this->session->set_flashdata('L_strErrorMessage','Users Updated Successfully!!!!');
							redirect($this->config->item('base_url').'users/lists');
					} else {
							$data['L_strErrorMessage'] = 'Some Errors prevented from update data,please try again later.';
						}
					}
					else
					{
						$data['L_strErrorMessage'] = 'Username or Email already exist!';
					}
				}
			}
				$data['utype_list'] = $this->users_model->utype_list();
				$this->load->view('edit_users',$data);
			} 
			else 
			{
				$this->session->set_flashdata('L_strErrorMessage','No Such Attribute !!!!');
				redirect($this->config->item('base_url').'users/lists');
			}
	}
	
	function lists()
	{
		$this->load->library('pagination');
		$url_to_paging = $this->config->item('base_url');
		
		$config['base_url'] = $url_to_paging.'users/lists/';
		$config['per_page'] = '100000';
		$config['first_url']='0';
		$data = array();
		//using for searching data...
		$data['name'] = $this->input->post('name');
		
		$per_page = '1';
		$perpage = '3';
		//below is used in all perpose
		$return = $this->users_model->list_user($config['per_page'],$this->uri->segment(3), $data);
		
		$data['result'] = $return['result'];
		$config['total_rows'] = $return['count'];
		//echo "<pre>";print_r($data);break;
		$this->pagination->initialize($config);
		$this->load->view('list_users', $data);
	}
	
	
	function deletes()
	{
		if(isset($_POST['selected']) && count($_POST['selected']) > 0) {
	
			foreach($_POST['selected'] as $selCheck) {
				if($this->users_model->deletes($selCheck)) {
					$this->session->set_flashdata('L_strErrorMessage','Users Deleted Successfully!!!');
				}  
				else 
				{
						$this->session->set_flashdata('flashError','Some Errors prevented from Deleting!!!!');
						break;
				}
			}
		}
		redirect($this->config->item('base_url').'users/lists');
	}
	function get_city()
	{
		$sid = $_POST['sid'];
		
		//print_r($cid); die;
		$data = $this->users_model->show_city($sid);
		//exit;
	//print_r($data); die;
		$html = "<select id='cid' name='cid' class='form-control jobtext'>";
		$html .= "<option value=''> --Select City-- </option>";
		if($data != '' && count($data) >0)
		{
			for($i=0;$i<count($data);$i++)
			{
				$html .= "<option value='".$data[$i]->city_id ."'>".$data[$i]->city_name ."</option>";
			}
		}
		$html .="</select>";
		
		echo $html;
 
	}
	function show_subcategory()
	{
		$cid = $_POST['cid'];
		$data = $this->users_model->allsubcategory($cid);
		
		$html = "<select id='subcategoryid' name='subcategoryid' class='form-control'>";
	$html .= "<option value=''>Select Sub Category</option>";
		
		if($data!=''&& count($data) >0)
		{
		for($i=0;$i<count($data);$i++)
		{
			
			$html .= "<option value='".$data[$i]->id ."'>".$data[$i]->subcategoryname ."</option>";
			
		}
		}
		
		$html .="</select>";
		echo $html;
	}
 
}
?>