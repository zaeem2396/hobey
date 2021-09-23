<?php
	class Pincode extends CI_Controller {
	private $_data = array();
	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('adminId') == ''){
			redirect($this->config->item('base_url'));
        }
		$this->load->model('pincode_model');
	}
	function add()
	{
		$form_field = $data = array(  		
				'state_id' => '',
				'name' => '',
				'city_id' => '',
				//'area_id' => '',
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
			$fields['name'] = "Pincode";
			
			$this->validation->set_fields($fields);
						
			$this->pincode_model->add($data);
			$this->session->set_flashdata('L_strErrorMessage','Pincode Added Successfully!');
			redirect($this->config->item('base_url').'pincode/lists');
				
			if ($this->validation->run() == FALSE){
			$data['L_strErrorMessage'] = $this->validation->error_string;
			} 
				
		}		
		$data["allstate"]= $this->pincode_model->allstate();
		$this->load->view('add_pincode',$data);
	}
	
    function edit($id)
	{	 
			if(is_numeric($id))
			{
					$result = $this->pincode_model->get_category($id);  
					$form_field = $data = array(
						'L_strErrorMessage' => '',
						'id'	=> $result->id,
						'state_id' => $result->state_id,
						'name' => $result->name,
						'city_id' => $result->city_id,
						//'area_id' => $result->area_id,												
					);
					
				if($this->input->post('action') == 'edit_category') 
				{
					foreach($data as $key => $value) {  $form_field[$key]=$this->input->post($key);	}
					$this->load->library('validation');
					$rules['name'] = "trim|required";
					
  					$this->validation->set_rules($rules);
					$fields['name']   = "Pincode";
					$this->validation->set_fields($fields);
					if ($this->validation->run() == FALSE) 
					{
							$data = $form_field;
							$data['L_strErrorMessage'] = $this->validation->error_string;
							$data['category_id'] = $id;
					} 
					else 
					{
						$this->pincode_model->edit($id, $form_field);
						$this->session->set_flashdata('L_strErrorMessage','Pincode Updated Successfully!');
						redirect($this->config->item('base_url').'pincode/lists');
					}
				}
				
				$data["allstate"] = $this->pincode_model->allstate();
				$data["allcity"] = $this->pincode_model->show_subcategory($result->state_id);
				$data["allarea"] = $this->pincode_model->show_area($result->city_id);
				
				$this->load->view('edit_pincode',$data);
			} 
			else 
			{
				$this->session->set_flashdata('L_strErrorMessage','No Pincode !');
				redirect($this->config->item('base_url').'pincode/lists');
			}
	}
	function lists()
	{
		$this->load->library('pagination');
		$url_to_paging = $this->config->item('base_url');
		
		$config['base_url'] = $url_to_paging.'pincode/lists/';
		$config['per_page'] = '20000';
		$config['first_url']='0';
		$data = array();
		//using for searching data...
		$data['categoryname'] = $this->input->post('categoryname');
		
		$per_page = '1';
		$perpage = '3';
		//below is used in all perpose
		$return = $this->pincode_model->lists($config['per_page'],$this->uri->segment(3), $data);
		
		$data['result'] = $return['result'];
		$config['total_rows'] = $return['count'];
		$this->pagination->initialize($config);
		$this->load->view('list_pincode', $data);
	}
	
	
	function deletes()
	{
		if(isset($_POST['selected']) && count($_POST['selected']) > 0) {
	
			foreach($_POST['selected'] as $selCheck) {
				
				if($this->pincode_model->deletes($selCheck)) {
					$this->session->set_flashdata('L_strErrorMessage','Pincode Deleted Successfully!');
				}  
				else 
				{
						$this->session->set_flashdata('flashError','Some Errors prevented from Deleting!');					
				}
			}
		}		
		redirect($this->config->item('base_url').'pincode/lists');
	}
	
function remove_value($pid,$value)
	{
		$return = $this->pincode_model->remove_value($value);
		$this->session->set_flashdata('L_strErrorMessage', 'Value Deleted Successfully');
		redirect($this->config->item('base_url').'subcategory/edit/'.$pid);
	}
function remove_name($pid,$value)
	{
		$return = $this->pincode_model->remove_name($value);
		$this->session->set_flashdata('L_strErrorMessage', 'Name Deleted Successfully');
		redirect($this->config->item('base_url').'subcategory/edit/'.$pid);
	}
	
	function remove_keyname($pid,$value)
	{
		$return = $this->pincode_model->remove_keyname($value);
		$this->session->set_flashdata('L_strErrorMessage', 'Keywords Deleted Successfully');
		redirect($this->config->item('base_url').'subcategory/edit/'.$pid);
	}
	
function featured_product($pid,$value)
	{
		$return = $this->pincode_model->featured_product($pid,$value);
		$this->session->set_flashdata('L_strErrorMessage', 'Set As Home Page Updated Successfully');
		redirect($this->config->item('base_url').'subcategory/lists');
	}	
	
	function updateorder($id,$val)
	{	
		$this->pincode_model->updateorder($id,$val);
		$this->session->set_flashdata("L_strErrorMessage","Set Order updated succesfully");
		redirect($this->config->item('base_url').'subcategory/lists');
	}
	
	function userstatus($id,$value)	{	
	$result=$this->pincode_model->updatestatus($id,$value);
	$this->session->set_flashdata('L_strErrorMessage','Status Updated Succcessfully!');
	redirect($this->config->item('base_url').'user/lists');
	}
function show_city()
	{
		
		$cid = $_POST['cid'];
		$sid = $_POST['sid'];
		$data = $this->pincode_model->show_subcategory($cid);
		
		$html = '<select id="city_id" name="city_id" onchange="get_pincode(this.value);" class="form-control jobtext">';
		$html .= "<option value=''> -- Select District -- </option>";
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
		$data = $this->pincode_model->show_pincode_list($cid);
		
		$html = "<select id='pincode' name='pincode' class='form-control jobtext' >";
		$html .= "<option value=''> -- Select Pincode -- </option>";
		if($data != '' && count($data) >0)
		{
			for($i=0;$i<count($data);$i++)
			{
				if($data[$i]->id==$sid){ $selected="selected"; } else { echo $selected="" ; }
				$html .= "<option value='".$data[$i]->name ."' ".$selected.">".$data[$i]->name ."</option>";
			}
		}
		$html .="</select>";
		
		echo $html;
 
	}
 
function show_area()
	{
		
		$cid = $_POST['cid'];
		$sid = $_POST['sid'];
		$data = $this->pincode_model->show_area($cid);
		
		$html = "<select id='area_id' name='area_id' class='form-control jobtext' >";
		$html .= "<option value=''> -- Select Area -- </option>";
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
?>