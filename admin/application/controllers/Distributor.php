<?php
	class Distributor extends CI_Controller {
	private $_data = array();
	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('adminId') == ''){
			redirect($this->config->item('base_url'));
        }
		$this->load->model('distributor_model'); 
		$this->load->model('pincode_model'); 
	}

	function add(){
        
		$L_strErrorMessage='';
		$form_field = $data = array(
						'name' =>"",
						'mobile'=>"",						
						'email' =>"",						
						'password' =>"",
						'address_1' =>"",
						'address_2'=>"",						
						'state_id' =>"",						
						'city_id' =>"",
						'pincode' =>"",
						'telephone' =>"",						
						'contact_title'=>"",						
						'contact_name' =>"",						
						'contact_email' =>"",
						'contact_phone' =>"",
						'contact_telephone'=>"",
						//'payment_code'=>"",						
						'gst_no' =>"",						
						'cc_code' =>"",
						'city_id_new' =>"",
						'bank_name' =>"",
						'account_no' =>"",
						'ifsc_code' =>"",
					);
		if($this->input->post('action') == 'add_vendor') 
		{ 
			foreach($form_field as $key => $value)
			{	
           
				$data[$key]=$this->input->post($key);	
			}
			$this->load->library('validation');
           
			
			$rules['name'] = "required";
			
			$this->validation->set_rules($rules);
			
			$fields['name'] = "name";
			
			$this->validation->set_fields($fields);
			
			/*if(!$this->distributor_model->is_add($this->input->post('coupancode')))
			{ */
				//print_r($data); die;
					 $this->distributor_model->add($data);
						$this->session->set_flashdata('L_strErrorMessage','Distributor Added Successfully!!!!');
						redirect($this->config->item('base_url').'distributor/lists');
						
			/*}else
			{

				$this->session->set_flashdata('flashError','Coupan Code Already Exist!');

			} */
			if ($this->validation->run() == FALSE){
				$data['L_strErrorMessage'] = $this->validation->error_string;
			} 
    }

	$data["allstate"]= $this->pincode_model->allstate();
	//$data["allpincode"]= $this->distributor_model->allpincode();
    $this->load->view('add_distributor',$data);
}



    function edit($id)
	{	 
   
			if(is_numeric($id))
			{
				$result = $this->distributor_model->get_news($id);  
			
				$form_field = $data = array(
						'L_strErrorMessage' => '',
						'id'	=> $result[0]->id,                        
						'name' =>  $result[0]->name,
						'mobile'=>$result[0]->mobile,						
						'email'=>$result[0]->email,
						'password'=>$result[0]->password,
						'address_1'=>$result[0]->address_1,
						'address_2'=>$result[0]->address_2,
						'state_id'=>$result[0]->state_id,
						'city_id' =>  $result[0]->city_id,
						'pincode' =>  $result[0]->pincode,						
						'telephone' => $result[0]->telephone,
						'contact_title' =>  $result[0]->contact_title,						
						'contact_name' => $result[0]->contact_name,
						'contact_email' =>  $result[0]->contact_email,
                        'contact_phone' => $result[0]->contact_phone,
                        'contact_telephone' => $result[0]->contact_telephone,
                        //'payment_code' => $result[0]->payment_code,                        
                        'gst_no' => $result[0]->gst_no,
                        'cc_code' => $result[0]->cc_code,

                        'city_id_new' =>  $result[0]->city_id_new,
                        'bank_name' => $result[0]->bank_name,
                        'account_no' => $result[0]->account_no,
                        'ifsc_code' => $result[0]->ifsc_code,

                        );  

				if($this->input->post('action') == 'edit_user') 
				{
					foreach($data as $key => $value) {  $form_field[$key]=$this->input->post($key);	}
					$this->load->library('validation');
                   
					
					$rules['name'] = "trim|required";
					$this->validation->set_rules($rules);
					
					$fields['name'] = "Name";
					
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
						$this->distributor_model->edit($id, $form_field);
						$this->session->set_flashdata('L_strErrorMessage','Distributor Updated Successfully!!!!');
						redirect($this->config->item('base_url').'distributor/lists');
						
					}
				}					
				$data['allstate'] = $this->pincode_model->allstate();
				$data["allcity"] = $this->pincode_model->show_subcategory($result[0]->state_id);
				$data["allpincode"] = $this->pincode_model->show_pincode_list($result[0]->city_id);
				$this->load->view('edit_distributor',$data);
			} 
			else 
			{
				$this->session->set_flashdata('L_strErrorMessage','No Such Distributor !!!!');
				redirect($this->config->item('base_url').'distributor/lists');
			}
	}

	
	function removeprice($product_id,$id)
	{
		
			if($this->distributor_model->removeattriute($product_id,$id)) 
			{
				$this->session->set_flashdata('L_strErrorMessage','Product Attribite Deleted Succcessfully!!!!');
				redirect($this->config->item('base_url').'vendor/edit/'.$product_id);
			}  
			else 
			{
				$this->session->set_flashdata('flashError','Some Errors prevented from Deleting!!!!');
				//break;
			}	
	}
	
	function checkemail()
	{
		$email = $_POST['email'];
		$data = $this->distributor_model->checkemail($email);
		if($data !=""){			
			echo $data; die;
		}else
		{
			echo "0"; die;
			
		}
	}
	
	function checkemailvalid()
	{
		$pincode = $_POST['pincode'];
		$vendor_id = $_POST['vendor_id'];
		$data = $this->distributor_model->checkemailvalid($pincode,$vendor_id);
		if($data !=""){			
			echo $data; die;
		}else
		{
			echo "0"; die;
			
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
		$return = $this->distributor_model->lists($config['per_page'],$this->uri->segment(3), $data);
		$data['result'] = $return['result'];
		$config['total_rows'] = $return['count'];
		//echo "<pre>";print_r($data);break;
		$this->pagination->initialize($config);
     	$this->load->view('list_distributor', $data);
	}

	function pickuppoints($vendorid)
	{
		$data['get_address'] = $this->distributor_model->pickuppointslist($vendorid);
		$data['allstates'] = $this->distributor_model->allstates();
		$data['vendorid'] = $vendorid; 
	 	$this->load->view('pickuppoints', $data);
	}

	function add_pick_up_point()
	{
		$data['err_msg'] = '';
		$data["update_id"] 						= $this->input->post("update_id");
		$data["perishable"] 				    = $this->input->post("perishable");
		if($this->input->post("action")=="add_pick_up_point")
		{
			if($data["perishable"] == '1'){
			if($data['update_id'] !='')
			{
				$checkperishableassigned = $this->distributor_model->checkperishableassigned1($data['update_id']);
				if($checkperishableassigned != ''){
					$this->session->set_flashdata('errormessage','You can assign only 1 address as perishable  product delivery');
					redirect($this->config->item('base_url').'vendor/pickuppoints/'.$this->input->post("user_id"), 'location');
				}
			} else {
				$checkperishableassigned = $this->distributor_model->checkperishableassigned();
				if($checkperishableassigned != ''){
					$this->session->set_flashdata('errormessage','You can assign only 1 address as perishable  product delivery');
					redirect($this->config->item('base_url').'vendor/pickuppoints/'.$this->input->post("user_id"), 'location');
				}	
			}
			}

			$validpincode = $this->distributor_model->check_pincode_data($this->input->post("pincode"));
 			
			if($validpincode == ''){
				$this->session->set_flashdata('errormessage','Pincode Doesn\'t exists for Pickup Service');
				redirect($this->config->item('base_url').'vendor/pickuppoints/'.$this->input->post("user_id"), 'location');
			}
			if($validpincode->service == 'Deliveries Only' || $validpincode->service == 'No Service'){
				$this->session->set_flashdata('errormessage','Pincode Doesn\'t exists for Pickup Service');
				redirect($this->config->item('base_url').'vendor/pickuppoints/'.$this->input->post("user_id"), 'location');
			}
			 
			$data["contact_persons_name"] 			= $this->input->post("contact_persons_name");
			$data["contact_persons_mobile_number"] 	= $this->input->post("contact_persons_mobile_number");
			$data["address"] 						= $this->input->post("address");
			$data["address2"] 						= $this->input->post("address2");
			$data["city"] 							= $this->input->post("city");
			$data["state"] 							= $this->input->post("state");
			$data["pincode"] 						= $this->input->post("pincode");
			$data["google_map_link"] 				= $this->input->post("google_map_link");
			$data["user_id"] 				= $this->input->post("user_id");
			
			

			$this->distributor_model->add_pick_up_point($data);
			if($data['update_id'] !='')
			{
				$this->session->set_flashdata('L_strErrorMessage','Vendor Pick Up Point Address Updated successfully');
			}else{
				$this->session->set_flashdata('L_strErrorMessage','Vendor Pick Up Point Address added successfully');
			}
		}
		 
		    redirect($this->config->item('base_url').'vendor/pickuppoints/'.$this->input->post("user_id"), 'location');
		 
		//redirect($this->config->item('base_url').'vendor/vendor_profile', 'location');
	}

	function addresspickup_delete($id,$userid)
	{
		$this->distributor_model->addresspickup_delete($id,$userid);
		$this->session->set_flashdata('L_strErrorMessage','Vendor Pick Up Point Address Deleted successfully');
		redirect($this->config->item('base_url').'vendor/pickuppoints/'.$userid, 'location');
		/* if($this->session->userdata('status') == '0'){
		    redirect($this->config->item('base_url').'vendor/dashboard', 'location');
		} else {
		    redirect($this->config->item('base_url').'vendor/vendor_profile', 'location');
		} */
	}

	function deletes()
	{
		if(isset($_POST['selected']) && count($_POST['selected']) > 0) {
			foreach($_POST['selected'] as $selCheck) {
				if($this->distributor_model->deletes($selCheck)) {
					$this->session->set_flashdata('L_strErrorMessage','Distributor Deleted Successfully!!!!');
				}  
				else 
				{
						$this->session->set_flashdata('L_strErrorMessage','Some Errors prevented from Deleting!!!!');
						//break;
				}
			}
		}
		redirect($this->config->item('base_url').'distributor/lists');
	}
    
    function show_subcategory()
	{
		$cid = $_POST['cid'];
		$data = $this->distributor_model->allsubcategory($cid);
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
		$result=$this->distributor_model->updatestatus($id,$value);
		$result_data = $this->distributor_model->get_news($id); 
        if($value == '0') {
            
           /* $email = $result_data[0]->email; //$this->config->item('admin_email');
			$message = '<!doctype html><html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Vendor Approval</title>
	<style>
		@import url("https://fonts.googleapis.com/css?family=Lato");
	</style> </head><body style="text-align: center;margin: 0;background: #ececec; font-family: "Lato", sans-serif;font-weight: 100;">
	<div style="max-width:630px;margin: 0 auto;border: thin solid #f3f0f0;background: #fff; border:1px solid #ccc">
		<div style="float: left; width: 100%; border-bottom:1px solid #ccc; text-align:center">
		<a href="'.$this->config->item('front_base_url').'"><img src="'.$this->config->item('front_base_url').'site/views/images/logo2-hori.png" style="margin-top:20px;max-width:200px;"></a>
		</div>
		<div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Dear '.$result_data[0]->fname.',</p>
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Happy Soul welcomes you to the wellness wonderland! We are delighted to have you onboard with us & look forward to spreading health & happiness together!  We will keep you updated about promotions, offers & discount schemes that will add to your product visibility and sales on our wellness portal.</p>
		</div>
		
		<div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Have a Fabulous Day<BR>
Team Happy Soul</p><br>
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Need Help?<br>
			<a href="'.$this->config->item('front_base_url').'contact-us" style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Contact Us for Help & Support</a></p>
		</div>
		<div style="clear: both">
	</div></div>
</body>
</html>';

        $subject = "Your Vendor registration with Happy soul is approved";
		$to = $email;
	
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: HappySoul <info@happysoul.in>' . "\r\n" .
			'Reply-To: info@happysoul.in' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
		$headers .= 'Cc: info@happysoul.in' . "\r\n";

		mail($to, $subject, $message, $headers);

        $email_ad = $this->config->item('business_email');
		mail($email_ad, $subject, $message, $headers);*/
    
            
		    $this->session->set_flashdata('L_strErrorMessage','Distributor Approved Succcessfully');
        } else {
            $this->session->set_flashdata('L_strErrorMessage','Distributor Deactivated Succcessfully');
        }
		redirect($this->config->item('base_url').'distributor/lists');
	
            
    }
	
	function download($value,$abc)
		{
					//echo $abc;
					$planning = $this->distributor_model->getallvoucher($value,$abc);
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

	function show_city()
	{
		$cid = $_POST['cid'];
		$sid = $_POST['sid'];
		$data = $this->distributor_model->show_subcategory($cid);
		$html = "<select id='city_id' name='city_id' class='form-control jobtext' onchange='get_pincode(this.value)'>";
		$html .= "<option value=''> -- Select City -- </option>";
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
		
		$html = "<select id='pincode' name='pincode[]' multiple='multiple' class='form-control jobtext mySelect' >";
		$html .= "<option value=''> -- Select Pincode -- </option>";
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
 

	function show_area()
	{
		$cid = $_POST['cid'];
		$sid = $_POST['sid'];
		$data = $this->distributor_model->show_area($cid);
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

	public function xlsuploaddistributor()
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
                        'code.' => addslashes($PHPExcel->getActiveSheet()->getCell('C' . $i)->getCalculatedValue()));
                    if ($obj_insData == '' && count($obj_insData) == '0') {
                       // continue;
                    } else {
						
                    $state_id = $this->distributor_model->commonGetId("state", "name", "id", addslashes($PHPExcel->getActiveSheet()->getCell('G' . $i)->getCalculatedValue()));
					
					$city_id = $this->distributor_model->commonGetId("city", "name", "id", addslashes($PHPExcel->getActiveSheet()->getCell('H' . $i)->getCalculatedValue()));

					$pincode = addslashes($PHPExcel->getActiveSheet()->getCell('J' . $i)->getCalculatedValue());
					
					$name = addslashes($PHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue());
					$mobile = addslashes($PHPExcel->getActiveSheet()->getCell('B' . $i)->getCalculatedValue());
					$email = addslashes($PHPExcel->getActiveSheet()->getCell('C' . $i)->getCalculatedValue());
					$password = addslashes($PHPExcel->getActiveSheet()->getCell('D' . $i)->getCalculatedValue());
					$address_1 = addslashes($PHPExcel->getActiveSheet()->getCell('E' . $i)->getCalculatedValue());
					$address_2 = addslashes($PHPExcel->getActiveSheet()->getCell('F' . $i)->getCalculatedValue());
					$city_id_new = addslashes($PHPExcel->getActiveSheet()->getCell('I' . $i)->getCalculatedValue());
					$telephone = addslashes($PHPExcel->getActiveSheet()->getCell('K' . $i)->getCalculatedValue());
					$bank_name = addslashes($PHPExcel->getActiveSheet()->getCell('L' . $i)->getCalculatedValue());
					$account_no = addslashes($PHPExcel->getActiveSheet()->getCell('M' . $i)->getCalculatedValue());
					$ifsc_code = addslashes($PHPExcel->getActiveSheet()->getCell('N' . $i)->getCalculatedValue());
					$contact_title = addslashes($PHPExcel->getActiveSheet()->getCell('O' . $i)->getCalculatedValue());
					$contact_name = addslashes($PHPExcel->getActiveSheet()->getCell('P' . $i)->getCalculatedValue());
					$contact_email = addslashes($PHPExcel->getActiveSheet()->getCell('Q' . $i)->getCalculatedValue());
					$contact_phone = addslashes($PHPExcel->getActiveSheet()->getCell('R' . $i)->getCalculatedValue());
					$contact_telephone = addslashes($PHPExcel->getActiveSheet()->getCell('S' . $i)->getCalculatedValue());
					$gst_no = addslashes($PHPExcel->getActiveSheet()->getCell('T' . $i)->getCalculatedValue());
					$cc_code = addslashes($PHPExcel->getActiveSheet()->getCell('U' . $i)->getCalculatedValue());
																	
						$data = array(
							'name'    => $name,
							'mobile'  => $mobile,
							'email'    => $email,
                            'password'       => $password,
							'address_1'    => $address_1,
                            'address_2'   => $address_2,
							'state_id'       => $state_id,
							'city_id'       => $city_id,
							'city_id_new'       => $city_id_new,
							'pincode'       => $pincode,
							'telephone'       => $telephone,
							'bank_name'       => $bank_name,
							'account_no'       => $account_no,
							'ifsc_code'       => $ifsc_code,
							'contact_title'       => $contact_title,
							'contact_name'       => $contact_name,
							'contact_email'       => $contact_email,
							'contact_phone'       => $contact_phone,
							'contact_telephone'       => $contact_telephone,
							'gst_no'       => $gst_no,
							'cc_code'       => $cc_code,
						);
						if ($data['email'] != '') {
							if ($this->distributor_model->isExistByEmail($data['email'])) {
								$userId = $this->distributor_model->commonGetId("users", "email", "id", $data['email']);
								$this->distributor_model->editUpload($userId, $data);
							} else {
								$this->distributor_model->addUpload($data);
							 }
						}
                    }
                }
            }

            $this->session->set_flashdata('L_strErrorMessage', 'Distributor added Successfully.!!');
            redirect($this->config->item('base_url') . 'distributor/lists');
        }
        $data = array();
		
        $this->load->view('add_xlsdistributor', $data);
		
    }


}

?>
