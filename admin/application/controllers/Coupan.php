<?php
	class Coupan extends CI_Controller {
	private $_data = array();
	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('adminId') == ''){
			redirect($this->config->item('base_url'));
        }
        error_reporting(E_ALL);
		ini_set('display_errors', E_ALL);
		$this->load->model('Coupan_model');
	}

	function add(){

		$L_strErrorMessage='';
		$form_field = $data = array(
			'coupanname' => '',
			'coupancode'=>'',
			'discount' => '',
			'coupanvalue' => '',
			'startdate' => '',
			'enddate' => '',
			//'subcategoryid'=>'',
			'description' => '',
			/*'category' => '',
			'subcategory' => '',
			'wellness_category' => '',
			'gift_hamper_category' => '',
			'service_category' => '',
			'minimum_order'=>'',*/
			//'start_time' => '',
			//'end_time' => '',
			/*'no_of_coupons' => '',
			'no_of_coupons_user' => '',
			'type' => '',
			'workshop_id' => '',
			'is_discounted' => '',
			'allowed_discount' => ''*/
		);
		if($this->input->post('action') == 'add_coupan')
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

			if(!$this->Coupan_model->is_add($this->input->post('coupancode')))
			{
				$this->Coupan_model->add($data);
				$this->session->set_flashdata('L_strErrorMessage','Coupan Added Successfully!');
				redirect($this->config->item('base_url').'coupan/lists');
			}else {
				$this->session->set_flashdata('flashError','Coupan Code Already Exist!');
			}
						if ($this->validation->run() == FALSE){
				$data['L_strErrorMessage'] = $this->validation->error_string;
			}
		}
		/*$this->load->model('wellness_category_model');
		$this->load->model('gift_hamper_category_model');
		$this->load->model('service_category_model');*/
		/*$data["allcategory"] = $this->Coupan_model->allcategory();
		$data["allworkshop"] = $this->Coupan_model->allworkshop();
		$data["wellness_category_list"] = $this->wellness_category_model->getWellnessCategory();
		$data["gift_hamper_category_list"] = $this->Coupan_model->getgifthampercategory();*/
		//$data["service_category_list"] = $this->service_category_model->get();
		$this->load->view('add_coupan',$data);
	}



    function edit($id)
	{

			if(is_numeric($id))
			{
				$result = $this->Coupan_model->get_coupan($id);
				$form_field = $data = array(
						'L_strErrorMessage' => '',
						'id'		 => $result[0]->id,
						'coupanname' =>  $result[0]->name,
						'coupancode' =>$result[0]->code,
						'discount'   =>  $result[0]->discount,
						'coupanvalue'=>  $result[0]->value,
						'description'=> $result[0]->description,
						'startdate'  =>  $result[0]->start_date,
					    'enddate' 	 => $result[0]->end_date,
						);

				if($this->input->post('action') == 'edit_coupan')
				{
					foreach($data as $key => $value) {  $form_field[$key]=$this->input->post($key);	}
					$this->load->library('validation');


					$rules['discount'] = "trim|required";
					$this->validation->set_rules($rules);

					$fields['discount'] = "discount";

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
						if(!$this->Coupan_model->is_exist($this->input->post('coupancode'),$ccid))

						{
								$this->Coupan_model->edit($id, $form_field);
								$this->session->set_flashdata('L_strErrorMessage','Coupan Updated Successfully!');
								redirect($this->config->item('base_url').'coupan/lists');
						}

						else

						{

							$this->session->set_flashdata('flashError','Coupan Code Already Exist!');

						}
					}
				}
				
				$this->load->view('edit_coupan',$data);
			}
			else
			{
				$this->session->set_flashdata('L_strErrorMessage','No Such Attribute !');
				redirect($this->config->item('base_url').'coupan/lists');
			}
	}

	function lists()
	{
		$this->load->library('pagination');
		$url_to_paging = $this->config->item('base_url');
		$config['base_url'] = $url_to_paging.'coupan/lists/';
		$config['per_page'] = '10000';
		$config['first_url']='0';
		$data = array();
		//using for searching data...
		$data['coupanname'] = $this->input->post('coupanname');
		$data['startdate'] = $this->input->post('startdate');
		$data['enddate'] = $this->input->post('enddate');
		$per_page = '1';
		$perpage = '3';
		//below is used in all perpose
		$return = $this->Coupan_model->lists($config['per_page'],$this->uri->segment(3), $data);
		$data['result'] = $return['result'];
		$config['total_rows'] = $return['count'];
		//echo "<pre>";print_r($data);break;
		$this->pagination->initialize($config);

	$this->load->view('list_coupan', $data);
	}

	function deletes()
	{
		if(isset($_POST['selected']) && count($_POST['selected']) > 0) {
			foreach($_POST['selected'] as $selCheck) {
				if($this->Coupan_model->deletes($selCheck)) {
					$this->session->set_flashdata('L_strErrorMessage','Coupan Deleted Successfully!');
				}
				else
				{
						$this->session->set_flashdata('flashError','Some Errors prevented from Deleting!');
						break;
				}
			}
		}
		redirect($this->config->item('base_url').'coupan/lists');
	}

	function show_subcategory()
	{
		$cid = $_POST['cid'];
		$data = $this->Coupan_model->allsubcategory($cid);
		$html = "<option value=''>Select Sub Category</option>";
		if($data!=''){
		for($i=0;$i<count($data);$i++)
		{
			$html .= "<option value='".$data[$i]->id ."'>".$data[$i]->name ."</option>";
		}
		}
		$html .="</select>";
		echo $html;
	}

	function featured_product($pid,$value)
	{
		$return = $this->Coupan_model->featured_product($pid,$value);
		$this->session->set_flashdata('L_strErrorMessage', 'Display In Front Updated Successfully');
		redirect($this->config->item('base_url').'coupan/lists');
	}

	function updatestatus($id,$value)
	{
		$result=$this->Coupan_model->updatestatus($id,$value);
		$this->session->set_flashdata('L_strErrorMessage','Status Updated Succcessfully!');
		redirect($this->config->item('base_url').'coupan/lists');
		//$this->load->view('users/list_user', $data);
	}
	function download($value,$abc)
		{
					//echo $abc;
					$planning = $this->Coupan_model->getallvoucher($value,$abc);
					//echo "<pre>";print_r($planning);die;

			$output = '';

			$output .= 'Voucher Name, Code, Price, Free / Paid';
			$output .="\n";
			// Get Records from the table
			if($planning != '' && count($planning) > 0) {
			foreach($planning as $planning) {

			$output .= '"'.$planning->vouchername.'","'.$planning->code.'","'.$planning->price.'","'.$planning->value.'"';
			$output .="\n";
			}
		}

			$filename = "GiftVoucher.csv";
			header('Content-type: application/csv');
			header('Content-Disposition: attachment; filename='.$filename);
			echo $output;
			exit;

		}



}

?>
