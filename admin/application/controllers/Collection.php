<?php
class Collection extends CI_Controller
{
	private $_data = array();
	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('adminId') == '') {
			redirect($this->config->item('base_url'));
		}
		// error_reporting(E_ALL);
		// ini_set('display_errors', E_ALL);
		$this->load->model('collection_model');
	}

	function add()
	{

		$L_strErrorMessage = '';
		$form_field = $data = array(
			'name' => '',
			'startdate' => '',
			'enddate' => '',
			'state_id' => '',
			'city_id' => '',
			'product_id' => '',
			// 'pincode_id'=>'',
		);

		if ($this->input->post('action') == 'add_collection') {
			foreach ($form_field as $key => $value) {
				$data[$key] = $this->input->post($key);
			}
			$this->load->library('validation');


			$rules['discount'] = "required";

			$this->validation->set_rules($rules);

			$fields['discount'] = "discount";

			$this->validation->set_fields($fields);


			$this->collection_model->add($data);
			$this->session->set_flashdata('L_strErrorMessage', 'Collection Added Successfully!');
			redirect($this->config->item('base_url') . 'collection/lists');

			if ($this->validation->run() == FALSE) {
				$data['L_strErrorMessage'] = $this->validation->error_string;
			}
		}
		$data['allstate'] = $this->collection_model->alldata("state");
		$data['allcity'] = $this->collection_model->alldata("city");
		$data['allPincode'] = $this->collection_model->alldata("pincode");
		$data["allcproducts"] = $this->collection_model->allcproducts();
		$this->load->view('add_collection', $data);
	}



	function edit($id)
	{

		if (is_numeric($id)) {
			$result = $this->collection_model->get_collection($id);
			$form_field = $data = array(
				'L_strErrorMessage' => '',
				'id'		 => $result[0]->id,
				'name' =>  $result[0]->name,
				'startdate'  =>  $result[0]->start_date,
				'enddate' 	 => $result[0]->end_date,
				'state_id' => $result[0]->state_id,
				'city_id' => $result[0]->city_id,
				'product_id' => $result[0]->product_id,
				// 'pincode_id'=> $result[0]->pincode_id,
			);

			if ($this->input->post('action') == 'edit_collection') {
				foreach ($data as $key => $value) {
					$form_field[$key] = $this->input->post($key);
				}

				$ccid = $id;
				$this->collection_model->edit($id, $form_field);
				$this->session->set_flashdata('L_strErrorMessage', 'Collection Updated Successfully!');
				redirect($this->config->item('base_url') . 'collection/lists');
			}

			$data['allstate'] = $this->collection_model->alldata("state");
			$data['allcity'] = $this->collection_model->alldata("city");
			$data['allPincode'] = $this->collection_model->alldata("pincode");
			$data["allcproducts"] = $this->collection_model->allcproducts();

			$this->load->view('edit_collection', $data);
		} else {
			$this->session->set_flashdata('L_strErrorMessage', 'No Such Attribute !');
			redirect($this->config->item('base_url') . 'collection/lists');
		}
	}

	function lists()
	{
		$this->load->library('pagination');
		$url_to_paging = $this->config->item('base_url');
		$config['base_url'] = $url_to_paging . 'collection/lists/';
		$config['per_page'] = '10000';
		$config['first_url'] = '0';
		$data = array();
		//using for searching data...
		$data['name'] = $this->input->post('name');
		$data['startdate'] = $this->input->post('startdate');
		$data['enddate'] = $this->input->post('enddate');
		$per_page = '1';
		$perpage = '3';
		//below is used in all perpose
		$return = $this->collection_model->lists($config['per_page'], $this->uri->segment(3), $data);
		$data['result'] = $return['result'];
		$config['total_rows'] = $return['count'];
		//echo "<pre>";print_r($data);break;
		$this->pagination->initialize($config);

		$this->load->view('list_collection', $data);
	}

	function deletes()
	{
		if (isset($_POST['selected']) && count($_POST['selected']) > 0) {
			foreach ($_POST['selected'] as $selCheck) {
				if ($this->collection_model->deletes($selCheck)) {
					$this->session->set_flashdata('L_strErrorMessage', 'Collection Deleted Successfully!');
				} else {
					$this->session->set_flashdata('flashError', 'Some Errors prevented from Deleting!');
					break;
				}
			}
		}
		redirect($this->config->item('base_url') . 'collection/lists');
	}


	function updatestatus($id, $value)
	{
		$result = $this->collection_model->updatestatus($id, $value);
		$this->session->set_flashdata('L_strErrorMessage', 'Status Updated Succcessfully!');
		redirect($this->config->item('base_url') . 'collection/lists');
		//$this->load->view('users/list_user', $data);
	}

	function show_city()
	{
		$cid = $_POST['cid'];
		$sid = $_POST['sid'];
		$data = $this->collection_model->show_cityajax($cid);

		$html = "<label for='city_id'>Select District</label><select id='city_id' name='city_id' onchange='get_city_pro(this.value);' class='form-control jobtext'>";
		$html .= "<option value=''> Select District </option>";
		if ($data != '' && count($data) > 0) {
			for ($i = 0; $i < count($data); $i++) {
				if ($data[$i]->id == $sid) {
					$selected = "selected";
				} else {
					echo $selected = "";
				}
				$html .= "<option value='" . $data[$i]->id . "' " . $selected . ">" . $data[$i]->name . "</option>";
			}
		}
		$html .= "</select>";

		echo $html;
	}

	function show_city_pro()
	{
		$cid = $_POST['cid'];
		$sid = $_POST['sid'];
		$data = $this->collection_model->show_cityajaxpro($cid);

		$html = "<label for='product_id'>Collection Products </label><select id='product_id' name='product_id[]' multiple class='form-control'>";
		if ($data != '' && count($data) > 0) {
			for ($i = 0; $i < count($data); $i++) {
				if ($data[$i]->id == $sid) {
					$selected = "selected";
				} else {
					echo $selected = "";
				}
				$html .= "<option value='" . $data[$i]->id . "' " . $selected . ">" . $data[$i]->material_name . "</option>";
			}
		}
		$html .= "</select>";

		echo $html;
	}
}
