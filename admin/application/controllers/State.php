<?php
	class State extends CI_Controller {
	private $_data = array();
	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('adminId') == ''){
			redirect($this->config->item('base_url'));
        }
		$this->load->model('state_model');
	}
	function add()
	{
		
		$form_field = $data = array(  
				'name' => '',
			);
			
		if($this->input->post('action') == 'add_state') 
		{
			foreach($form_field as $key => $value)
			{	
				$data[$key]=$this->input->post($key);		
			}
			$this->load->library('validation');
			$rules['name'] = "trim|required";			
			
			$this->validation->set_rules($rules);
			$fields['name'] = "State";
			
			$this->validation->set_fields($fields);
			
			$this->state_model->add($data);
			$this->session->set_flashdata('L_strErrorMessage','State Added Successfully!');
			redirect($this->config->item('base_url').'state/lists');
			
			if ($this->validation->run() == FALSE){
			$data['L_strErrorMessage'] = $this->validation->error_string;
			}				
		}		
		$this->load->view('add_state',$data);
	}
	
    function edit($id)
	{	 
	   		if(is_numeric($id))
			{
				$result = $this->state_model->get_category($id);  
				
					$form_field = $data = array(
						'L_strErrorMessage' => '',
						'id'	=> $result->id,
						'name' =>  $result->name,
						'image' =>  $result->image,
						'page_url' =>  $result->page_url,
						'columndisplay' =>  $result->columndisplay,
						'metatitle' =>  $result->metatitle,
        				'metakeywords' =>  $result->metakeywords,
        				'metadescription' => $result->metadescription,
        				'categorydescription' => $result->categorydescription,
					);

				if($this->input->post('action') == 'edit_category') 
				{
				
					foreach($data as $key => $value) {  $form_field[$key]=$this->input->post($key);	}
					
					$this->load->library('validation');
					$rules['name'] = "trim|required";
					
  					$this->validation->set_rules($rules);
					$fields['name']   = "State";
					
				 
					$this->validation->set_fields($fields);
					if ($this->validation->run() == FALSE) 
					{
							$data = $form_field;
							$data['L_strErrorMessage'] = $this->validation->error_string;
							$data['category_id'] = $id;
					} 
					else 
					{
						
					$this->state_model->edit($id, $form_field);
					$this->session->set_flashdata('L_strErrorMessage','State Updated Successfully!');
					redirect($this->config->item('base_url').'state/lists');
					
					}
				}
				$this->load->view('edit_state',$data);
			} 
			else 
			{
				$this->session->set_flashdata('L_strErrorMessage','No Such State !');
				redirect($this->config->item('base_url').'state/lists');
			}
	}
	
	function lists()
	{
		$this->load->library('pagination');
		$url_to_paging = $this->config->item('base_url');
		
		$config['base_url'] = $url_to_paging.'state/lists/';
		$config['per_page'] = '10000';
		$config['first_url']='0';
		$data = array();
		//using for searching data...
		$data['categoryname'] = $this->input->post('categoryname');
		
		$per_page = '1';
		$perpage = '3';
		//below is used in all perpose
		$return = $this->state_model->lists($config['per_page'],$this->uri->segment(3), $data);
		
		$data['result'] = $return['result'];
		$config['total_rows'] = $return['count'];
		//echo "<pre>";print_r($data);break;
		$this->pagination->initialize($config);
		$this->load->view('list_state', $data);
	}
	
	
	function deletes()
	{
		if(isset($_POST['selected']) && count($_POST['selected']) > 0) {
	
			foreach($_POST['selected'] as $selCheck) {
				
				if($this->state_model->deletes($selCheck)) {
					$this->session->set_flashdata('L_strErrorMessage','State Deleted Successfully!');
				}  
				else 
				{
						$this->session->set_flashdata('flashError','Some Errors prevented from Deleting!');
						
				}
				 
				
			}
		}
		
		redirect($this->config->item('base_url').'state/lists');
	}
	function userstatus($id,$value)	{	
	$result=$this->state_model->updatestatus($id,$value);
	$this->session->set_flashdata('L_strErrorMessage','Status Updated Succcessfully!');
	redirect($this->config->item('base_url').'state/lists');
	}
 
 
function featured_product($pid,$value)
	{
		$return = $this->state_model->featured_product($pid,$value);
		$this->session->set_flashdata('L_strErrorMessage', 'Set As Home Page Updated Successfully');
		redirect($this->config->item('base_url').'state/lists');
	}	
	
	
	function updateorder($id,$val){
		
		$this->state_model->updateorder($id,$val);
		$this->session->set_flashdata("L_strErrorMessage","Set Order updated succesfully");
		redirect($this->config->item('base_url').'state/lists');
	}
	
	function removeinput($product_id,$id)
	{
		if($this->state_model->removeinput($product_id,$id))
		{
			$this->session->set_flashdata('L_strErrorMessage','Attribite Deleted Succcessfully!');
		}
		else
		{
			$this->session->set_flashdata('flashError','Some Errors prevented from Deleting!');
		}
		redirect($this->config->item('base_url').'state/edit/'.$product_id);
	}
	
	function remove_keyname($pid,$value)
	{
	    $this->load->model('substate_model');     
		$return = $this->substate_model->remove_keyname($value);
		$this->session->set_flashdata('L_strErrorMessage', 'Keywords Deleted Successfully');
		redirect($this->config->item('base_url').'state/edit/'.$pid);
	}
	
	function remove_name($pid,$value)
	{
	    $this->load->model('substate_model');  
		$return = $this->substate_model->remove_name($value);
		$this->session->set_flashdata('L_strErrorMessage', 'Name Deleted Successfully');
		redirect($this->config->item('base_url').'state/edit/'.$pid);
	}
	
	function remove_value($pid,$value)
	{
	    $this->load->model('substate_model');  
		$return = $this->substate_model->remove_value($value);
		$this->session->set_flashdata('L_strErrorMessage', 'Value Deleted Successfully');
		redirect($this->config->item('base_url').'state/edit/'.$pid);
	}

	/*public function add_xlsstate()
    {

        ini_set('memory_limit', -1);
        if ($this->input->post('action') == 'add_XLS') {
            $data['error'] = '';
           
            $file_path = $_FILES['csv']['tmp_name'];
            $file_type = $_FILES['csv']['type'];
            $this->load->library('PHPExcel');
            if ($file_type == 'text/csv') {
                $objReader = new PHPExcel_Reader_CSV();
                $PHPExcel = $objReader->load($file_path);
            } else {
                $PHPExcel = PHPExcel_IOFactory::load($file_path);
            }
            $objWorksheet = $PHPExcel->getActiveSheet();
            $highestrow = $objWorksheet->getHighestRow();
            if ($highestrow != 0) {
                for ($i = 2; $i <= $highestrow; $i++) {
                    $obj_insData = array(
                        'code.' => addslashes($PHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue()));

					if ($obj_insData == '' && count($obj_insData) == '0') {
                       // continue;
                    } else {

						$state_id = $this->state_model->commonGetId("state", "name", "id", addslashes($PHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue()));
                        
						$city_id = $this->state_model->commonGetId("city", "name", "id", addslashes($PHPExcel->getActiveSheet()->getCell('B' . $i)->getCalculatedValue()));
						
						$pincode_id = $this->state_model->commonGetId("pincode", "name", "id", addslashes($PHPExcel->getActiveSheet()->getCell('C' . $i)->getCalculatedValue()));
						
						$PinCode = addslashes($PHPExcel->getActiveSheet()->getCell('C' . $i)->getCalculatedValue());
						
						if($pincode_id == '' & $pincode_id == 0){
							//$pincode_id = $this->state_model->addPincode($state_id,$city_id,$PinCode);
						}
																	
                    }
                }
            }
            
            //$this->session->set_flashdata('L_strErrorMessage', 'Your Data File Uploaded Successfully.!!');
        }
        $data = array();
        $this->load->view('add_xlsstate', $data);
    }*/
	
}
?>