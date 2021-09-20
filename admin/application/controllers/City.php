<?php
	class City extends CI_Controller {
	private $_data = array();
	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('adminId') == ''){
			redirect($this->config->item('base_url'));
        }
		$this->load->model('city_model');
	}
	function add()
	{
		$form_field = $data = array(  		
				'state_id' => '',
				'name' => '',
				
			);
			
		if($this->input->post('action') == 'add_category') 
		{
			foreach($form_field as $key => $value)
			{	
				$data[$key]=$this->input->post($key);	
				
			}
			$this->load->library('validation');
			$rules['name'] = "trim|required";
			
			
			$this->validation->set_rules($rules);
			$fields['name'] = "District";
			
			$this->validation->set_fields($fields);
						
			$this->city_model->add($data);
			$this->session->set_flashdata('L_strErrorMessage','District Added Successfully!');
			redirect($this->config->item('base_url').'city/lists');
				
			if ($this->validation->run() == FALSE){
			$data['L_strErrorMessage'] = $this->validation->error_string;
			} 
				
		}		
		$data["allstate"]= $this->city_model->allstate();
		$this->load->view('add_city',$data);
	}
	
    function edit($id)
	{	 
			if(is_numeric($id))
			{
					$result = $this->city_model->get_category($id);  
					$form_field = $data = array(
						'L_strErrorMessage' => '',
						'id'	=> $result->id,
						'state_id' => $result->state_id,
						'name' => $result->name,
						
					);
					
				if($this->input->post('action') == 'edit_category') 
				{
					foreach($data as $key => $value) {  $form_field[$key]=$this->input->post($key);	}
					$this->load->library('validation');
					$rules['name'] = "trim|required";
					
  					$this->validation->set_rules($rules);
					$fields['name']   = "District";

					$this->validation->set_fields($fields);
					if ($this->validation->run() == FALSE) 
					{
							$data = $form_field;
							$data['L_strErrorMessage'] = $this->validation->error_string;
							$data['category_id'] = $id;
					} 
					else 
					{
						$this->city_model->edit($id, $form_field);
						$this->session->set_flashdata('L_strErrorMessage','District Updated Successfully!');
						redirect($this->config->item('base_url').'city/lists');
					}
				}
				
				$data["allstate"] = $this->city_model->allstate();
				
				$this->load->view('edit_city',$data);
			} 
			else 
			{
				$this->session->set_flashdata('L_strErrorMessage','No District !');
				redirect($this->config->item('base_url').'city/lists');
			}
	}
	function lists()
	{
		$this->load->library('pagination');
		$url_to_paging = $this->config->item('base_url');
		
		$config['base_url'] = $url_to_paging.'city/lists/';
		$config['per_page'] = '10000';
		$config['first_url']='0';
		$data = array();
		//using for searching data...
		$data['categoryname'] = $this->input->post('categoryname');
		
		$per_page = '1';
		$perpage = '3';
		//below is used in all perpose
		$return = $this->city_model->lists($config['per_page'],$this->uri->segment(3), $data);
		
		$data['result'] = $return['result'];
		$config['total_rows'] = $return['count'];
		$this->pagination->initialize($config);
		// echo "<pre>";var_dump($data);exit;
		$this->load->view('list_city', $data);
	}
	
	
	function deletes()
	{
		if(isset($_POST['selected']) && count($_POST['selected']) > 0) {
	
			foreach($_POST['selected'] as $selCheck) {
				
				if($this->city_model->deletes($selCheck)) {
					$this->session->set_flashdata('L_strErrorMessage','District Deleted Successfully!');
				}  
				else 
				{
						$this->session->set_flashdata('flashError','Some Errors prevented from Deleting!');					
				}
			}
		}		
		redirect($this->config->item('base_url').'city/lists');
	}
	
function remove_value($pid,$value)
	{
		$return = $this->city_model->remove_value($value);
		$this->session->set_flashdata('L_strErrorMessage', 'Value Deleted Successfully');
		redirect($this->config->item('base_url').'subcategory/edit/'.$pid);
	}
function remove_name($pid,$value)
	{
		$return = $this->city_model->remove_name($value);
		$this->session->set_flashdata('L_strErrorMessage', 'Name Deleted Successfully');
		redirect($this->config->item('base_url').'subcategory/edit/'.$pid);
	}
	
	function remove_keyname($pid,$value)
	{
		$return = $this->city_model->remove_keyname($value);
		$this->session->set_flashdata('L_strErrorMessage', 'Keywords Deleted Successfully');
		redirect($this->config->item('base_url').'subcategory/edit/'.$pid);
	}
	
function featured_product($pid,$value)
	{
		$return = $this->city_model->featured_product($pid,$value);
		$this->session->set_flashdata('L_strErrorMessage', 'Set As Home Page Updated Successfully');
		redirect($this->config->item('base_url').'subcategory/lists');
	}	
	
	function updateorder($id,$val)
	{	
		$this->city_model->updateorder($id,$val);
		$this->session->set_flashdata("L_strErrorMessage","Set Order updated succesfully");
		redirect($this->config->item('base_url').'subcategory/lists');
	}
	
	function userstatus($id,$value)	{	
	$result=$this->city_model->updatestatus($id,$value);
	$this->session->set_flashdata('L_strErrorMessage','Status Updated Succcessfully!');
	redirect($this->config->item('base_url').'user/lists');
	}
	function show_subcategory()
	{
		
		$cid = $_POST['cid'];
		$sid = $_POST['sid'];
		$data = $this->city_model->show_subcategory($cid);
		
		$html = "<select id='category_id' name='category_id' class='form-control jobtext'>";
		$html .= "<option value=''> -- Select Category -- </option>";
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
 
}
