<?php
	class Bpcl_payment extends CI_Controller {
	private $_data = array();
	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('adminId') == ''){
			redirect($this->config->item('base_url'));
        }
        // error_reporting(E_ALL);
		// ini_set('display_errors', E_ALL);
		$this->load->model('bpcl_payment_model');
	}

	function add(){

		$L_strErrorMessage='';
		$form_field = $data = array(
			'user_id' => '',
			'user_vendor' => '',
			'amount' => '',
			'pdate' => '',
		);
		if($this->input->post('action') == 'add_bpcl_payment')
		{
			foreach($form_field as $key => $value)
			{

				$data[$key]=$this->input->post($key);
			}
			$this->load->library('validation');


			$rules['discount'] = "required";

			$this->validation->set_rules($rules);

			$fields['discount'] = "discount";

			$this->validation->set_fields($fields);

			
				$this->bpcl_payment_model->add($data);
				$this->session->set_flashdata('L_strErrorMessage','Bpcl Payment Added Successfully!');
				redirect($this->config->item('base_url').'bpcl_payment/lists');
			
						if ($this->validation->run() == FALSE){
				$data['L_strErrorMessage'] = $this->validation->error_string;
			}
		}
		//$data['allusers']= $this->bpcl_payment_model->show_user(1);
		
		$this->load->view('add_bpcl_payment',$data);
	}



    function edit($id)
	{

			if(is_numeric($id))
			{
				$result = $this->bpcl_payment_model->get_bpcl_payment($id);
				$form_field = $data = array(
						'L_strErrorMessage' => '',
						'id'		 => $result[0]->id,
						'user_id' =>  $result[0]->user_id,
						'user_vendor'  =>  $result[0]->user_vendor,
					    'amount' 	 => $result[0]->amount,
						'pdate'  =>  $result[0]->pdate,
						);

				if($this->input->post('action') == 'edit_bpcl_payment')
				{
					foreach($data as $key => $value) {  $form_field[$key]=$this->input->post($key);	}
					
							$ccid=$id;
								$this->bpcl_payment_model->edit($id, $form_field);
								$this->session->set_flashdata('L_strErrorMessage','Bpcl Payment Updated Successfully!');
								redirect($this->config->item('base_url').'bpcl_payment/lists');
					
					
				}

				$data['allusers']= $this->bpcl_payment_model->show_user( $result[0]->user_vendor);
				
				$this->load->view('edit_bpcl_payment',$data);
			}
			else
			{
				$this->session->set_flashdata('L_strErrorMessage','No Such Attribute !');
				redirect($this->config->item('base_url').'bpcl_payment/lists');
			}
	}

	function lists()
	{
		$this->load->library('pagination');
		$url_to_paging = $this->config->item('base_url');
		$config['base_url'] = $url_to_paging.'bpcl_payment/lists/';
		$config['per_page'] = '10000';
		$config['first_url']='0';
		$data = array();
		//using for searching data...
		$data['name'] = $this->input->post('name');
		$data['startdate'] = $this->input->post('startdate');
		$data['enddate'] = $this->input->post('enddate');
		$per_page = '1';
		$perpage = '3';
		//below is used in all perpose
		$return = $this->bpcl_payment_model->lists($config['per_page'],$this->uri->segment(3), $data);
		$data['result'] = $return['result'];
		$config['total_rows'] = $return['count'];
		//echo "<pre>";print_r($data);break;
		$this->pagination->initialize($config);

	$this->load->view('list_bpcl_payment', $data);
	}

	function deletes()
	{
		if(isset($_POST['selected']) && count($_POST['selected']) > 0) {
			foreach($_POST['selected'] as $selCheck) {
				if($this->bpcl_payment_model->deletes($selCheck)) {
					$this->session->set_flashdata('L_strErrorMessage','Bpcl Payment Deleted Successfully!');
				}
				else
				{
						$this->session->set_flashdata('flashError','Some Errors prevented from Deleting!');
						break;
				}
			}
		}
		redirect($this->config->item('base_url').'bpcl_payment/lists');
	}

	
	function show_user()
	{
		$cid = $_POST['cid'];
		$sid = $_POST['sid'];
		$data = '';
		if($cid != ''){
			$data = $this->bpcl_payment_model->show_user($cid);
		}
		
		$html = "<label for='user_id'>Select User</label><select id='user_id' name='user_id' class='form-control jobtext'>";
		$html .= "<option value=''> Select User </option>";
		if($data != '' && count($data) >0)
		{
			for($i=0;$i<count($data);$i++)
			{
				if($data[$i]->id==$sid){ $selected="selected"; } else { echo $selected="" ; }
				$html .= "<option value='".$data[$i]->id ."' ".$selected.">".$data[$i]->name ."</option>";
			}
		}
		$html .='</select><span id="usererror" class="valierror"></span>';
		
		echo $html;
 
	}

}

?>
