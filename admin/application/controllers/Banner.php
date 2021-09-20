<?php
class Banner extends CI_Controller
{
	private $_data = array();
	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('adminId') == '') {
			redirect($this->config->item('base_url'));
		}
		$this->load->model('banner_model');
	}
	function add()
	{

		$bytes = 1024;
		$allowedKB = 100;
		$totalBytes = "1000000"; //$allowedKB * $bytes;

		//$L_strErrorMessage='';
		$form_field = $data = array(
			'title' => '',
			'image' => '',
			'url' => '',
			'title_2' => '',
			//'activepage'=>'',
		);

		if ($this->input->post('action') == 'add_banner') {
			foreach ($form_field as $key => $value) {
				$data[$key] = $this->input->post($key);
			}

			$this->load->library('validation');

			$rules['title'] = "trim|required";

			$this->validation->set_rules($rules);

			$fields['title'] = "Title";

			$this->validation->set_fields($fields);

			if ($_FILES['image']['name'] != '') {
				if ($_FILES["image"]["size"] <= $totalBytes) {
					$tmp_name1 =  $_FILES['image']['tmp_name'];
					$rootpath1 =  $this->config->item('upload') . "banner/";

					$logoname = time() . $_FILES['image']['name'];

					move_uploaded_file($tmp_name1, $rootpath1 . $logoname);
					$data['image'] = $logoname;
				} else {
					$this->session->set_flashdata('flashError', 'Image cannot be more than 1 MB.');
					redirect($this->config->item('base_url') . 'banner/lists');
				}

				/*$tmp_path = $this->config->item('upload')."banner/".$logoname;
				$image_thumb= $this->config->item('upload')."banner/medium/".$logoname; 
				
				$height=300;
				$width=250;
				
				$this->load->library('image_lib');

				// CONFIGURE IMAGE LIBRARY
				$config['image_library']    = 'gd2';
				$config['source_image']     = $tmp_path;
				$config['new_image']        = $image_thumb;
				$config['maintain_ratio']   = false;
				$config['height']           = $height;
				$config['width']            = $width;
				
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				$this->image_lib->clear();
				
				$tmp_path = $this->config->item('upload')."banner/".$logoname;
				$image_thumb= $this->config->item('upload')."banner/large/".$logoname; 
				
				$height=500;
				$width=1400;
				
				
				$this->load->library('image_lib');

				// CONFIGURE IMAGE LIBRARY
				$config['image_library']    = 'gd2';
				$config['source_image']     = $tmp_path;
				$config['new_image']        = $image_thumb;
				$config['maintain_ratio']   = false;
				$config['height']           = $height;
				$config['width']            = $width;
				
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				$this->image_lib->clear();


				$tmp_path = $this->config->item('upload')."banner/".$logoname;
				$image_thumb= $this->config->item('upload')."banner/small/".$logoname; 
				
				$height=50;
				$width=50;
				
				$this->load->library('image_lib');

				// CONFIGURE IMAGE LIBRARY
				$config['image_library']    = 'gd2';
				$config['source_image']     = $tmp_path;
				$config['new_image']        = $image_thumb;
				$config['maintain_ratio']   = false;
				$config['height']           = $height;
				$config['width']            = $width;
				
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				$this->image_lib->clear();*/
			} else {
				$data['image'] = '';
			}
			if (!$this->banner_model->is_already_exist_add($data)) {
				$this->banner_model->add($data);

				$this->session->set_flashdata('L_strErrorMessage', 'Banner  Added Successfully!!!!');

				redirect($this->config->item('base_url') . 'banner/lists');

				if ($this->validation->run() == FALSE) {

					$data['L_strErrorMessage'] = $this->validation->error_string;
				}
			} else {
				$this->session->set_flashdata('flashError2', 'Banner already exist!');
			}
		}
		//$data['allactivepages']=$this->banner_model->allactivepages();
		$this->load->view('add_banner', $data);
	}
	function edit($id)
	{
		$bytes = 1024;
		$allowedKB = 100;
		$totalBytes = "1000000"; //$allowedKB * $bytes;

		if (is_numeric($id)) {
			$result = $this->banner_model->get_banner($id);

			$form_field = $data = array(

				'L_strErrorMessage' => '',
				'id'	=> $result[0]->id,
				'title' =>  $result[0]->title,
				'image' => $result[0]->image,
				'url' => $result[0]->url,
				'title_2' => $result[0]->title_2,
				//'activepage'=>$result[0]->activepage,
			);

			if ($this->input->post('action') == 'edit_banner') {
				foreach ($data as $key => $value) {
					$form_field[$key] = $this->input->post($key);
				}
				$this->load->library('validation');
				$rules['title'] = "trim|required";

				$this->validation->set_rules($rules);
				$fields['title']   = "Title ";

				if ($_FILES['image']['name'] != '') {
					if ($_FILES["image"]["size"] <= $totalBytes) {
						$tmp_name1 =  $_FILES['image']['tmp_name'];
						$rootpath1 =  $this->config->item('upload') . "banner/";

						$logoname = time() . $_FILES['image']['name'];

						move_uploaded_file($tmp_name1, $rootpath1 . $logoname);

						$form_field['image'] = $logoname;
					} else {
						$this->session->set_flashdata('flashError', 'Image cannot be more than 1 MB.');
						redirect($this->config->item('base_url') . 'banner/lists');
					}

					/*$tmp_path = $this->config->item('upload')."banner/".$logoname;
						$image_thumb= $this->config->item('upload')."banner/medium/".$logoname; 
						
						$height=300;
						$width=250;
						
						$this->load->library('image_lib');

						// CONFIGURE IMAGE LIBRARY
						$config['image_library']    = 'gd2';
						$config['source_image']     = $tmp_path;
						$config['new_image']        = $image_thumb;
						$config['maintain_ratio']   = false;
						$config['height']           = $height;
						$config['width']            = $width;
						
						$this->image_lib->initialize($config);
						$this->image_lib->resize();
						$this->image_lib->clear();
						$tmp_path = $this->config->item('upload')."banner/".$logoname;
						$image_thumb= $this->config->item('upload')."banner/large/".$logoname; 
						
						$height=500;
						$width=1400;					
						
						$this->load->library('image_lib');

						// CONFIGURE IMAGE LIBRARY
						$config['image_library']    = 'gd2';
						$config['source_image']     = $tmp_path;
						$config['new_image']        = $image_thumb;
						$config['maintain_ratio']   = false;
						$config['height']           = $height;
						$config['width']            = $width;
						
						$this->image_lib->initialize($config);
						$this->image_lib->resize();
						$this->image_lib->clear();


						$tmp_path = $this->config->item('upload')."banner/".$logoname;
						$image_thumb= $this->config->item('upload')."banner/small/".$logoname; 
						
						$height=50;
						$width=50;
						
						$this->load->library('image_lib');

						// CONFIGURE IMAGE LIBRARY
						$config['image_library']    = 'gd2';
						$config['source_image']     = $tmp_path;
						$config['new_image']        = $image_thumb;
						$config['maintain_ratio']   = false;
						$config['height']           = $height;
						$config['width']            = $width;
						
						$this->image_lib->initialize($config);
						$this->image_lib->resize();
						$this->image_lib->clear();*/
				} else {
					$form_field['image'] = '';
				}

				$this->validation->set_fields($fields);

				if ($this->validation->run() == FALSE) {
					$data = $form_field;

					$data['L_strErrorMessage'] = $this->validation->error_string;

					$data['category_id'] = $id;
				} else {
					if (!$this->banner_model->is_already_exist_edit($form_field, $id)) {
						$this->banner_model->edit($id, $form_field);
						$this->session->set_flashdata('L_strErrorMessage', 'Banner  Updated Successfully!!!!');
						redirect($this->config->item('base_url') . 'banner/lists');
					} else {
						$this->session->set_flashdata('flashError3', 'Banner already exist!');
					}
				}
			}
			//$data['allactivepages']=$this->banner_model->allactivepages();
			$this->load->view('edit_banner', $data);
		} else {
			$this->session->set_flashdata('L_strErrorMessage', 'No Such Banner  !!!!');
			redirect($this->config->item('base_url') . 'banner/lists');
		}
	}
	function lists()
	{
		$this->load->library('pagination');

		$url_to_paging = $this->config->item('base_url');

		$config['base_url'] = $url_to_paging . 'banner/lists/';

		$config['per_page'] = '10000';

		$config['first_url'] = '0';

		$data = array();

		//using for searching data...

		$data['name'] = $this->input->post('name');

		$per_page = '1';

		$perpage = '3';

		//below is used in all perpose

		$return = $this->banner_model->lists($config['per_page'], $this->uri->segment(3), $data);

		$data['result'] = $return['result'];

		$config['total_rows'] = $return['count'];

		//echo "<pre>";print_r($data);break;

		$this->pagination->initialize($config);

		$this->load->view('list_banner', $data);
	}
	function deletes()
	{
		if (isset($_POST['selected']) && count($_POST['selected']) > 0) {

			foreach ($_POST['selected'] as $selCheck) {

				if ($this->banner_model->deletes($selCheck)) {

					$this->session->set_flashdata('L_strErrorMessage', 'Banner  Deleted Successfully!!!!');
				} else {
					$this->session->set_flashdata('flashError', 'Some Errors prevented from Deleting!!!!');
				}
			}
		}
		redirect($this->config->item('base_url') . 'banner/lists');
	}


	function updateorder($id, $val)
	{

		$this->banner_model->updateorder($id, $val);
		$this->session->set_flashdata("L_strErrorMessage", "Set Order updated succesfully");
		redirect($this->config->item('base_url') . 'banner/lists');
	}
}
