<?php
	class Product extends CI_Controller {
	private $_data = array();
	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('adminId') == ''){
			redirect($this->config->item('base_url'));
        }
		$this->load->model('product_model');
		ini_set('max_execution_time', 30000);
		ini_set("allow_url_fopen", 1);
	}

    function lists()
	{

		$data['vendors'] = $this->input->post('vendors');
		$data['categorys'] = $this->input->post('categorys');
		$data['sub_category'] = $this->input->post('sub_category');
		
		$this->data['vendors'] = $this->input->post('vendors');
		$this->data['categorys'] = $this->input->post('categorys');
		$this->data['sub_category'] = $this->input->post('sub_category');

		$this->load->library('pagination');
		$url_to_paging = $this->config->item('base_url');
		$config['base_url'] = $url_to_paging.'coupan/lists/';
		$config['per_page'] = '1000000';
		$config['first_url']='0';
		$data = array();

		$data['vendors'] = $this->input->post('vendors');
		$data['categorys'] = $this->input->post('categorys');
		$data['sub_category'] = $this->input->post('sub_category');

		$data['coupanname'] = $this->input->post('coupanname');
		$data['startdate'] = $this->input->post('startdate');
		$data['enddate'] = $this->input->post('enddate');
		$per_page = '1';
		$perpage = '3';

		$return = $this->product_model->lists($config['per_page'],$this->uri->segment(3), $data);
		$data['result'] = $return['result'];
		$config['total_rows'] = $return['count'];

		$this->pagination->initialize($config);
		$data['vendor'] = $this->product_model->get_vendor();
		$data['allcategory'] = $this->product_model->alldata("material");
		// echo "<pre>"; print_r($data['category']); echo "</pre>"; exit();
		//$data['subcategory'] = $this->product_model->alldata("subcategory");
		// echo "<pre>";
		// var_dump($data);exit;
		$this->load->view('list_product', $data);
	}
	
	function deletedlists()
	{
		$this->load->library('pagination');
		$url_to_paging = $this->config->item('base_url');
		$config['base_url'] = $url_to_paging.'coupan/lists/';
		$config['per_page'] = '10000';
		$config['first_url']='0';
		$data = array();

		$data['coupanname'] = $this->input->post('coupanname');
		$data['startdate'] = $this->input->post('startdate');
		$data['enddate'] = $this->input->post('enddate');
		$per_page = '1';
		$perpage = '3';

		$return = $this->product_model->deletedlists($config['per_page'],$this->uri->segment(3), $data);
		$data['result'] = $return['result'];
		$config['total_rows'] = $return['count'];

		$this->pagination->initialize($config);
		$this->load->view('list_product', $data);
	}
	
	function deactivatedlists()
	{
		$this->load->library('pagination');
		$url_to_paging = $this->config->item('base_url');
		$config['base_url'] = $url_to_paging.'coupan/lists/';
		$config['per_page'] = '10000';
		$config['first_url']='0';
		$data = array();

		$data['coupanname'] = $this->input->post('coupanname');
		$data['startdate'] = $this->input->post('startdate');
		$data['enddate'] = $this->input->post('enddate');
		$per_page = '1';
		$perpage = '3';

		$return = $this->product_model->deactivatedlists($config['per_page'],$this->uri->segment(3), $data);
		$data['result'] = $return['result'];
		$config['total_rows'] = $return['count'];

		$this->pagination->initialize($config);
		$this->load->view('list_product', $data);
	}
	
	function blockedlists()
	{
		$this->load->library('pagination');
		$url_to_paging = $this->config->item('base_url');
		$config['base_url'] = $url_to_paging.'coupan/lists/';
		$config['per_page'] = '10000';
		$config['first_url']='0';
		$data = array();

		$data['coupanname'] = $this->input->post('coupanname');
		$data['startdate'] = $this->input->post('startdate');
		$data['enddate'] = $this->input->post('enddate');
		$per_page = '1';
		$perpage = '3';

		$return = $this->product_model->blockedlists($config['per_page'],$this->uri->segment(3), $data);
		$data['result'] = $return['result'];
		$config['total_rows'] = $return['count'];

		$this->pagination->initialize($config);
		$this->load->view('list_product', $data);
	}

	function add(){

		$L_strErrorMessage='';
		$form_field = $data = array(
			'name' => '',
			'page_url'=>'',
			'sku_code'=>'',
			'wllness_category_id'=>'',
			'category_id' => '',
			'subcatefory_id' => '',
			'pincode' => '',
			//'discount' => '',
			'short_desc'=>'',
			'description' => '',
			'specification'=>'',
			'howtouse' => '',
			'ingredients' => '',
			'vendor_id' => '',
			'video_url' => '',
			'funfacts' => '',
			'metatitle' => '',
			'metakeywords' => '',
			'metadescription' => '',
			'tags' => '',
			'gst' => '',
			'hsn_code' => '',
			'vendor_percentage' => '',
			'product_filter' => '',
			'is_perishable'=>'',
			'keywords_filter' => '',
            'badgesfil'  => '',
            'countryorigin'  => '',
        );
		
		if($this->input->post('action') == 'add_product')
		{
			foreach($form_field as $key => $value){
				$data[$key]=$this->input->post($key);
			}
			$this->product_model->add($data);			$this->session->set_flashdata('L_strErrorMessage','Product Added Successfully!');
			redirect($this->config->item('base_url').'product/lists');    }

        	$this->load->model('subcategory_model');
        	$data['allcategory']= $this->product_model->alldata("category");
        	$data['allsubcategory']= $this->product_model->alldata("subcategory");
        	$data['allwellness_category']= $this->product_model->alldata("wellness_category");
        	/*$data['allsize']= $this->product_model->alldata("gram");*/
        	$data['allsize']= $this->product_model->alldata("size");
        	$data['allpincode']= $this->product_model->alldata("pincode");
        	$data['allcolour'] = $this->product_model->allcolour();
        	$data['allvendor'] = $this->product_model->allvendor();
        	$data["allfilter"]= $this->subcategory_model->getfiltername();
        	$data["getkeywordsname"]= $this->subcategory_model->getkeywordsname();
			$data["allbadges"]= $this->product_model->alldata('badges');
        	$this->load->view('add_product',$data);
        }

    function edit($id)	{
		if(is_numeric($id)){
				$result = $this->product_model->get($id);
				$form_field = $data = array(
    				'L_strErrorMessage' => '',
    				'id'	=> $result[0]->id,
    				'material_type' =>  $result[0]->material_type,
    				'material_name'=>$result[0]->material_name,
    				'page_url'=>$result[0]->page_url,
    				'material_code'=>$result[0]->material_code,
    				'product_description'=>$result[0]->product_description,
    				'billing_price'=>$result[0]->billing_price,
    				'margin'=>$result[0]->margin,
    				'mrp'=>$result[0]->mrp,
    				'bpcl_special_price'=>$result[0]->bpcl_special_price,
    				'distributorpay'=>$result[0]->distributorpay,
    				'deliverypay'=>$result[0]->deliverypay,
    				'bpclpay'=>$result[0]->bpclpay,
    				'package'=>$result[0]->package,
    				'base_pkg'=>$result[0]->base_pkg,
    				'sale_unit'=>$result[0]->sale_unit,
    				'price_unit'=>$result[0]->price_unit,
    				'min_qty'=>$result[0]->min_qty,
    				'product_image'=>$result[0]->product_image,
    			);


				if($this->input->post('action') == 'edit_product') 				
					{					
						foreach($data as $key => $value) { 
						 $form_field[$key]=$this->input->post($key);
					}
					$this->load->library('validation');
					$rules['material_name'] = "trim|required";				
					$this->validation->set_rules($rules);
					$fields['material_name'] = "name";
					$this->validation->set_fields($fields);

					if ($this->validation->run() == FALSE) 		
						{
							$data = $form_field;		
							$data['L_strErrorMessage'] = $this->validation->error_string;	
							$data['id'] = $id;			
							} 				
							else 	
						{

						if($_FILES['product_image']['name'] != '')
			            {
			                $fileName = time().".".$_FILES["product_image"]["name"];
			                $fileName = str_replace(' ', '_', $fileName);
			                $fileTmpLoc = $_FILES["product_image"]["tmp_name"];
			                $pathAndName = $this->config->item('upload')."product/".$fileName;
			                $moveResult = move_uploaded_file($fileTmpLoc, $pathAndName);
			                $form_field['product_image'] = $fileName;
			            }
			            else
			            {
			                $form_field['product_image']='';
			            }

						$this->product_model->edit($id, $form_field);
						$this->session->set_flashdata('L_strErrorMessage','Product Updated Successfully!');
						redirect($this->config->item('base_url').'product/lists');					
					}
				}
				$data['addition_item'] = $this->product_model->addition_item($id);
				$data['userid'] =  $this->session->userdata('userid');
				$data['allstate']= $this->product_model->alldata("state");
				$data['allcategory']= $this->product_model->alldata("category");
				 $data['allmaterial']= $this->product_model->alldata("material");
				$this->load->view('edit_product',$data);
			}
			else
			{
				$this->session->set_flashdata('L_strErrorMessage','No Such Attribute ');
				redirect($this->config->item('base_url').'product/lists');
			}
	}
    
    function updatestatus($id,$value) {	
        
        $this->load->model('vendor_model');
        
        $result=$this->product_model->updatestatus($id,$value);	
        //$result_product = $this->product_model->get($id);
        //$result_data = $this->vendor_model->get_news($result_product[0]->vendor_id); 

        if($value == '0') {
           /* $email = $result_data[0]->email; //$this->config->item('admin_email');
			$message = '<!doctype html><html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Uploaded Product approval email</title>
	<style>
		@import url("https://fonts.googleapis.com/css?family=Lato");
	</style> </head><body style="text-align: center;margin: 0;background: #ececec; font-family: "Lato", sans-serif;font-weight: 100;">
	<div style="max-width:630px;margin: 0 auto;border: thin solid #f3f0f0;background: #fff; border:1px solid #ccc">
		<div style="float: left; width: 100%; border-bottom:1px solid #ccc; text-align:center">
		<a href="'.$this->config->item('front_base_url').'"><img src="'.$this->config->item('front_base_url').'site/views/images/logo2-hori.png" style="margin-top:20px;max-width:200px;"></a>
		</div>
			<div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
 			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Hi</p>
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Green Signal!!! '.$result_data[0]->fname.' product '.$result_product[0]->name.' is now has been approved!</p>
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

        $subject = "Vendor's product is got approved";
		$to = $email;
	
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: Happysoul <info@happysoul.in>' . "\r\n" .
			'Reply-To: info@happysoul.in' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
		$headers .= 'Cc: info@happysoul.in' . "\r\n";
		mail($to, $subject, $message, $headers); */

		/*$to = $this->config->item('admin_email');
        mail($to, $subject, $message, $headers);  */  
		$this->session->set_flashdata('L_strErrorMessage','Product Approved Succcessfully!');
    } else {
            $this->session->set_flashdata('L_strErrorMessage','Product Deactivated Succcessfully!');
    }
	
    redirect($this->config->item('base_url').'product/lists');	
}


function updatestatusd($id,$value) {	
        
        $this->load->model('vendor_model');
        
        $result=$this->product_model->updatestatus($id,$value);	
        $result_product = $this->product_model->get($id);
        $result_data = $this->vendor_model->get_news($result_product[0]->vendor_id); 

        if($value == '0') {
            $email = $result_data[0]->email; //$this->config->item('admin_email');
			$message = '<!doctype html><html lang="en"><head>
	<title>Uploaded Product approval email</title>
	<style>
		@import url("https://fonts.googleapis.com/css?family=Lato");
	</style> </head><body style="text-align: center;margin: 0;background: #ececec; font-family: "Lato", sans-serif;font-weight: 100;">
	<div style="max-width:630px;margin: 0 auto;border: thin solid #f3f0f0;background: #fff; border:1px solid #ccc">
		<div style="float: left; width: 100%; border-bottom:1px solid #ccc; text-align:center">
		<a href="'.$this->config->item('front_base_url').'"><img src="'.$this->config->item('front_base_url').'site/views/images/logo2-hori.png" style="margin-top:20px;max-width:200px;"></a>
		</div>
			<div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
 			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Hi</p>
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Green Signal!!! '.$result_data[0]->fname.' product '.$result_product[0]->name.' is now has been approved!</p>
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

        $subject = "Vendor's product is got approved";
		$to = $email;
	
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: Happysoul <info@happysoul.in>' . "\r\n" .
			'Reply-To: info@happysoul.in' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
		$headers .= 'Cc: info@happysoul.in' . "\r\n";
		mail($to, $subject, $message, $headers);


		/*$to = $this->config->item('admin_email');
        mail($to, $subject, $message, $headers);  */  
            
		$this->session->set_flashdata('L_strErrorMessage','Product Approved Succcessfully!');
    } else {
            $this->session->set_flashdata('L_strErrorMessage','Product Deactivated Succcessfully!');
    }
	
    redirect($this->config->item('base_url').'home');	
}

	function updateblocked($id,$value)
	{
		$result=$this->product_model->updateblocked($id,$value);
		$this->session->set_flashdata('L_strErrorMessage','Product Blocked Succcessfully!');
		redirect($this->config->item('base_url').'product/lists');
	}
	
	function updateblockedd($id,$value)
	{
		$result=$this->product_model->updateblocked($id,$value);
		$this->session->set_flashdata('L_strErrorMessage','Product Blocked Succcessfully!');
		redirect($this->config->item('base_url').'home');
	}

	function removeprices($product_id,$id)
	{
			if($this->product_model->removeattriute($product_id,$id))
			{
				$this->session->set_flashdata('L_strErrorMessage','Product Attribite Deleted Succcessfully!');
				redirect($this->config->item('base_url').'product/edit/'.$product_id);
			}
			else
			{
				$this->session->set_flashdata('flashError','Some Errors prevented from Deleting');
				//break;
			}
	}

	function deleteSingle($id)
	{
		if($this->product_model->deletes($id)) {
			$this->session->set_flashdata('L_strErrorMessage','Product Deleted Successfully!');
		}
		else
		{
				$this->session->set_flashdata('flashError','Some Errors prevented from Deleting');
		}
		redirect($this->config->item('base_url').'product/lists');
	}

 
	function deletes()
	{
		if(isset($_POST['selected']) && count($_POST['selected']) > 0) {
			foreach($_POST['selected'] as $selCheck) {
				if($this->product_model->deletes($selCheck)) {
					$this->session->set_flashdata('L_strErrorMessage','Product Deleted Successfully!');
				}
				else
				{
						$this->session->set_flashdata('flashError','Some Errors prevented from Deleting');
						//break;
				}
			}
		}
		redirect($this->config->item('base_url').'product/lists');
	}
 function show_category()
	{
		$group = $_POST['group'];
		$cid = $_POST['cid'];
		$data = $this->product_model->category($group);
		$html = '<select id="category_id" name="category_id" onchange="subcategory(this.value);" class="form-control">';
		$html .= "<option value=''>Select Category</option>";
		if($data!=''){
		for($i=0;$i<count($data);$i++)
		{
			if($cid==$data[$i]->id){ $selected="selected"; }else{ $selected=""; }
			$html .= "<option value='".$data[$i]->id."' ".$selected.">".$data[$i]->name ."</option>";
		}
		}
		$html .="</select>";
		echo $html;
	}
	function show_subcategory()
	{
		$cid = $_POST['cid'];
		$in_sid = explode(",",$_POST['sid']);
		$data = $this->product_model->subcategory($cid);
		$html = '<select id="subcatefory_id" name="subcatefory_id[]" multiple class="form-control">';
		$html .= "<option value=''>Select Sub Category</option>";
		if($data!='')
		{
			for($i=0;$i<count($data);$i++)
			{
				if(in_array($data[$i]->id,$in_sid)){ $selected="selected"; }else{ $selected=""; }
				$html .= "<option value='".$data[$i]->id."' ".$selected.">".$data[$i]->name ."</option>";
			}
		}
		$html .="</select>";
		echo $html;
	}

	function show_input()
	{
		$cid = $_POST['cid'];
		$product_id = $_POST['pro_id'];
		$data = $this->product_model->show_input($cid);
		$html = "";
		if($data !='' && count($data) > 0)
		{
			for($i=0;$i<count($data);$i++)
			{
				$value = $this->product_model->show_input_value($product_id,$data[$i]->category_id,$data[$i]->id);
				$html .= "<div class='form-group'>
                  <label for='input_value'>".$data[$i]->input_name."</label>
                   <textarea id='".$i."' name='input_value[]' class='form-control jquery_ckeditor'>".$value."</textarea>
				   <INPUT TYPE='hidden' NAME='cat_id[]' VALUE='".$data[$i]->category_id."'>
				   <INPUT TYPE='hidden' NAME='cat_input_id[]' VALUE='".$data[$i]->id."'>
                </div>";

				/* <script>jQuery(document).ready(function () {\"use strict\";CKEDITOR.replace('".$i."',{});CKEDITOR.disableAutoInline = false;});</script> */
				/* $html .= "<option value='".$data[$i]->id."' ".$selected.">".$data[$i]->name ."</option>";*/
			}
		}
		echo $html;
	}
	function editimage($id)
	{

	$data['L_strErrorMessage'] = '';

 		if ($this->input->post('action') == 'edit' && is_numeric($id)) {
 		for($i = 0; $i < count($_FILES['attachment1']['name']); $i++)
		{
			$bytes = 1024;
            $allowedKB = 100;
            $totalBytes = "1000000"; //$allowedKB * $bytes;
			$message = "";
			if($_FILES['attachment1']['name'][$i] != '') {

				if($_FILES["attachment1"]["size"][$i] <= $totalBytes) {

				$tmp_name1 =  $_FILES['attachment1']['tmp_name'][$i];
		 		$rootpath1 =  $this->config->item('upload')."product/";

				$remove_space = str_replace(' ', '-',$_FILES['attachment1']['name'][$i]);

				$logoname = time().$remove_space;
				move_uploaded_file( $tmp_name1 , $rootpath1.$logoname );

				$tmp_path = $this->config->item('upload')."product/".$logoname;
				$image_thumb= $this->config->item('upload')."product/medium/".$logoname;

				$height=500;
				$width=370;
				$this->load->library('image_lib');

				$config['image_library']    = 'gd2';
				$config['source_image']     = $tmp_path;
				$config['new_image']        = $image_thumb;
				$config['maintain_ratio']   = true;
				$config['height']           = $height;
				$config['width']            = $width;

				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				$this->image_lib->clear();

				$tmp_path = $this->config->item('upload')."product/".$logoname;
				$image_thumb= $this->config->item('upload')."product/large/".$logoname;


				$height=850;
				$width=600;


				$this->load->library('image_lib');


				$config['image_library']    = 'gd2';
				$config['source_image']     = $tmp_path;
				$config['new_image']        = $image_thumb;
				$config['maintain_ratio']   = true;
				$config['height']           = $height;
				$config['width']            = $width;

				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				$this->image_lib->clear();


				$tmp_path = $this->config->item('upload')."product/".$logoname;
				$image_thumb= $this->config->item('upload')."product/small/".$logoname;

				$height=70;
				$width=70;

				$this->load->library('image_lib');


				$config['image_library']    = 'gd2';
				$config['source_image']     = $tmp_path;
				$config['new_image']        = $image_thumb;
				$config['maintain_ratio']   = true;
				$config['height']           = $height;
				$config['width']            = $width;

				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				$this->image_lib->clear();


				$newdata1 = array(
					'pid'   => $id,
					'image'	=> $logoname,
				);

				$id222 = $this->product_model->add_product_image($newdata1);
				} else {
			        $message .= $_FILES['attachment1']['name'][$i]. " files is greater than 1 MB"; 
			    }
			}
		}

		if($message ==''){
		    $this->session->set_flashdata('L_strErrorMessage', 'Image Added Successfully');
        } else {
            $this->session->set_flashdata('flashError',$message);
        }
		redirect($this->config->item('base_url').'product/editimage/'.$id);

		}

		$data['result'] = $this->product_model->presult($id);
		$data['productimages'] = $this->product_model->productimages($id);
		$this->load->view('edit_product_image',$data);


	}

	function updateorder($val,$id,$pid)
	{
		$return = $this->product_model->updateorder($id,$val);
		$this->session->set_flashdata('L_strErrorMessage', 'Product Image Order Updated Successfully!');
		redirect($this->config->item('base_url').'product/editimage/'.$pid);

	}
	function setbaseimg($id,$pid)
	{

		$return = $this->product_model->setbaseimg($id,$pid);
		$this->session->set_flashdata('L_strErrorMessage', 'Base Image Set Successfully!');
		redirect($this->config->item('base_url').'product/editimage/'.$pid);
	}
	function removeimage($id,$pid)
	{

		$return = $this->product_model->removeimage($id);
		$this->session->set_flashdata('L_strErrorMessage', 'Image deleted Successfully!');
		redirect($this->config->item('base_url').'product/editimage/'.$pid);
	}

	function featured_product($pid,$value)
	{


		$return = $this->product_model->featured_product($pid,$value);
		$this->session->set_flashdata('L_strErrorMessage', 'Featured Product Updated Successfully!');
		redirect($this->config->item('base_url').'product/lists');
	}


	function lists1()
	{
		$this->load->library('pagination');
		$url_to_paging = $this->config->item('base_url');
		$config['base_url'] = $url_to_paging.'coupan/lists/';
		$config['per_page'] = '10000';
		$config['first_url']='0';
		$data = array();

		$data['coupanname'] = $this->input->post('coupanname');
		$data['startdate'] = $this->input->post('startdate');
		$data['enddate'] = $this->input->post('enddate');
		$per_page = '1';
		$perpage = '3';

		$return = $this->product_model->lists1($config['per_page'],$this->uri->segment(3), $data);

		$data['result'] = $return['result'];
		$config['total_rows'] = $return['count'];

		$this->pagination->initialize($config);
		$this->load->view('list_product_stock', $data);
	}




    function edit1($id)
	{

			if(is_numeric($id))
			{
				$result = $this->product_model->get($id);


				$form_field = $data = array(
						'L_strErrorMessage' => '',
						'id'	=> $result[0]->id,
						'name' =>  $result[0]->name,
						'group_id'=>$result[0]->group_id,
						'category_id'=>$result[0]->category_id,
						'subcatefory_id'=>$result[0]->subcatefory_id,
						'fabric_id'=>$result[0]->fabric_id,
						'neck_id'=>$result[0]->neck_id,
						'fit_id'=>$result[0]->fit_id,
						'occasion_id'=>$result[0]->occasion_id,
						'sleeve_id'=>$result[0]->sleeve_id,
						'pattern_id'=>$result[0]->pattern_id,
						/*'wash_care'=>$result[0]->wash_care, */
						/* 'size'=>$result[0]->size, */
						'description'=>$result[0]->description,
						'wash_and_care'=>$result[0]->wash_and_care,
						'discount'=>$result[0]->discount,
						'image'=>$result[0]->image,
						'product_code'=>$result[0]->product_code,

						'diff_color'=>$result[0]->diff_color,

						'model_height'=>$result[0]->model_height,
						'model_wearing_size'=>$result[0]->model_wearing_size,
						'model_wearing_fir'=>$result[0]->model_wearing_fir,

						'specification'=>$result[0]->specification,



						'size1' => '',
						'colour1' => '',
						'price1' => '',


						);

				if($this->input->post('action') == 'edit_product')
				{
					foreach($data as $key => $value) {  $form_field[$key]=$this->input->post($key);	}
					$this->load->library('validation');


					$rules['name'] = "trim|required";
					$this->validation->set_rules($rules);

					$fields['name'] = "name";

					$this->validation->set_fields($fields);
					if ($this->validation->run() == FALSE)
					{
							$data = $form_field;
							$data['L_strErrorMessage'] = $this->validation->error_string;
							$data['id'] = $id;
					}
					else
					{


			if($_FILES['image']['name'] != ''){
				$tmp_name1 =  $_FILES['image']['tmp_name'];
		 		$rootpath1 =  $this->config->item('upload')."products/listimg/";
				$remove_space = str_replace(' ', '-',$_FILES['image']['name']);
				$logoname = time().$remove_space;
				move_uploaded_file( $tmp_name1 , $rootpath1.$logoname );
				$tmp_path = $this->config->item('upload')."products/listimg/".$logoname;
				$image_thumb= $this->config->item('upload')."products/listimg/medium/".$logoname;

				$height=500;
				$width=370;

				$this->load->library('image_lib');


				$config['image_library']    = 'gd2';
				$config['source_image']     = $tmp_path;
				$config['new_image']        = $image_thumb;
				$config['maintain_ratio']   = false;
				$config['height']           = $height;
				$config['width']            = $width;

				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				$this->image_lib->clear();

				$tmp_path = $this->config->item('upload')."products/listimg/".$logoname;
				$image_thumb= $this->config->item('upload')."products/listimg/large/".$logoname;


				$height=720;
				$width=625;


				$this->load->library('image_lib');


				$config['image_library']    = 'gd2';
				$config['source_image']     = $tmp_path;
				$config['new_image']        = $image_thumb;
				$config['maintain_ratio']   = false;
				$config['height']           = $height;
				$config['width']            = $width;

				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				$this->image_lib->clear();


				$tmp_path = $this->config->item('upload')."products/listimg/".$logoname;
				$image_thumb= $this->config->item('upload')."products/listimg/small/".$logoname;

				$height=50;
				$width=50;

				$this->load->library('image_lib');


				$config['image_library']    = 'gd2';
				$config['source_image']     = $tmp_path;
				$config['new_image']        = $image_thumb;
				$config['maintain_ratio']   = false;
				$config['height']           = $height;
				$config['width']            = $width;

				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				$this->image_lib->clear();
				$form_field["image"] = $logoname;
			}


								$this->product_model->edit($id, $form_field);
								$this->session->set_flashdata('L_strErrorMessage','Product Updated Successfully!');
								redirect($this->config->item('base_url').'product/lists1');

					}
				}
				$data['allgroup']= $this->product_model->alldata("group1");
				$data['allcategory']= $this->product_model->category($result[0]->group_id);
				$data['allsubcategory']= $this->product_model->subcategory($result[0]->category_id);

				$data['allcolour'] = $this->product_model->allcolour();

				$data['addition_item'] = $this->product_model->addition_item($id);

				$data['allfabric']= $this->product_model->alldata("fabric");
				$data['allneck']= $this->product_model->alldata("neck");
				$data['allfit']= $this->product_model->alldata("fit");
				$data['alloccasion']= $this->product_model->alldata("occasion");
				$data['allsleeve']= $this->product_model->alldata("sleeve");

				$data['allsize']= $this->product_model->alldata("size");
				$data['allpattern']= $this->product_model->alldata("pattern");

				$data['allproduct'] = $this->product_model->allproduct_diff($id);

				$this->load->view('edit_limited_stock',$data);
			}
			else
			{
				$this->session->set_flashdata('L_strErrorMessage','No Such Attribute ');
				redirect($this->config->item('base_url').'product/lists1');
			}
	}

	function xlsuploadproduct()
	{
		if($this->input->post('action') == 'add_XLS')
		{
			$data['error'] = '';
			ini_set('memory_limit', '512M');
			$file_path = $_FILES['csv']['tmp_name'];
			$file_type = $_FILES['csv']['type'];
			$this->load->library('PHPExcel');
			if($file_type == 'text/csv')
			{
				$objReader = new PHPExcel_Reader_CSV();
				$PHPExcel = $objReader->load($file_path);
			}
			else
			{
				$PHPExcel = PHPExcel_IOFactory::load($file_path);
			}

			$objWorksheet = $PHPExcel->getActiveSheet();
			$highestrow = $objWorksheet->getHighestRow();
			if($highestrow != 0)
			{
			for($i=2;$i<=$highestrow;$i++)
			{
			$obj_insData = array(
			'code.'=> addslashes($PHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue()) );
			if($obj_insData == '' && count($obj_insData) == '0')
			{
				continue;
			}
			else
			{

			/*$group 		 		= $this->product_model->commangetid("group1","name","id",addslashes($PHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue()));
			$category_id 		= $this->product_model->commangetid("category","name","id",addslashes($PHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue()));
			$subcatefory_id 	= $this->product_model->commangetid("subcategory","name","id",addslashes($PHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue()));
			$fabric_id			= $this->product_model->commangetid("fabric","name","id",addslashes($PHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue()));
			$neck_id			= $this->product_model->commangetid("neck","name","id",addslashes($PHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue()));
			$fit_id 			= $this->product_model->commangetid("fit","name","id",addslashes($PHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue()));
			$occasion_id 		= $this->product_model->commangetid("occasion","name","id",addslashes($PHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue()));
			$sleeve_id 			= $this->product_model->commangetid("sleeve","name","id",addslashes($PHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue()));
			$pattern_id			= $this->product_model->commangetid("pattern","name","id",addslashes($PHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue()));

			$model_wearing_size	= $this->product_model->commangetid("size","name","id",addslashes($PHPExcel->getActiveSheet()->getCell('M'.$i)->getCalculatedValue()));
			$model_wearing_fir 	= $this->product_model->commangetid("fit","name","id",addslashes($PHPExcel->getActiveSheet()->getCell('N'.$i)->getCalculatedValue()));

			$diffproduct	= explode(",",addslashes($PHPExcel->getActiveSheet()->getCell('S'.$i)->getCalculatedValue()));
			$features='';
			$features1='';
			if($diffproduct !='' && count($diffproduct) > 0 )
			{ foreach($diffproduct as $key => $value) {
				$features1[]= $this->product_model->commangetid("product","name","id",$value);
			}
			$features = implode(",",$features1);
			}
				*/


			$data=array(
			'name'=>addslashes($PHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue()),
			'product_code'=>addslashes($PHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue()),
			'group_id'=> $group,
			'category_id'=>$category_id,
			'subcatefory_id'=>$subcatefory_id,
			'fabric_id'=>$fabric_id,
			'neck_id'=>$neck_id,
			'fit_id'=>$fit_id,
			'occasion_id'=>$occasion_id,
			'sleeve_id'=>$sleeve_id,
			'pattern_id'=>$pattern_id,

			'diff_color'=>$features,

			'model_wearing_size'=>$model_wearing_size,
			'model_wearing_fir'=>$model_wearing_fir,

			'model_height'=>addslashes($PHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue()),
			'description'=>addslashes($PHPExcel->getActiveSheet()->getCell('O'.$i)->getCalculatedValue()),
			'wash_and_care'=>addslashes($PHPExcel->getActiveSheet()->getCell('P'.$i)->getCalculatedValue()),
			'specification'=>addslashes($PHPExcel->getActiveSheet()->getCell('Q'.$i)->getCalculatedValue()),
			'discount'=>addslashes($PHPExcel->getActiveSheet()->getCell('R'.$i)->getCalculatedValue()),
			'image'=>addslashes($PHPExcel->getActiveSheet()->getCell('T'.$i)->getCalculatedValue()),
			'meta_title'=>addslashes($PHPExcel->getActiveSheet()->getCell('U'.$i)->getCalculatedValue()),
			'meta_keyword'=>addslashes($PHPExcel->getActiveSheet()->getCell('V'.$i)->getCalculatedValue()),
			'meta_desc'=>addslashes($PHPExcel->getActiveSheet()->getCell('W'.$i)->getCalculatedValue()),
			'product_size'=>addslashes($PHPExcel->getActiveSheet()->getCell('X'.$i)->getCalculatedValue()),
			'product_price'=>addslashes($PHPExcel->getActiveSheet()->getCell('Y'.$i)->getCalculatedValue()),
			'product_color'=>addslashes($PHPExcel->getActiveSheet()->getCell('AB'.$i)->getCalculatedValue()),
			);
			 
			
			echo "<pre>";
			print_r($data); die; 


			if($product = $this->product_model->get_id(addslashes($PHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue()))){
			if($response = $this->product_model->adddata($data))
			{

			}
			}else
			{
			if($response = $this->product_model->insert($data,1))
			{

			}
			}
			}
	}
}
			$this->session->set_flashdata('L_strErrorMessage','Your Data File Uploaded Successfully!');
			redirect($this->config->item('base_url').'product/lists');
		}
		$data = array();
		$this->load->view('add_xlsproduct',$data);
	}


	function imageupload($logoname)
	{
					$tmp_path = $this->config->item('upload')."products/listimg/".$logoname;
					$image_thumb= $this->config->item('upload')."products/listimg/medium/".$logoname;

					$height=500;
					$width=370;

					$this->load->library('image_lib');


					$config['image_library']    = 'gd2';
					$config['source_image']     = $tmp_path;
					$config['new_image']        = $image_thumb;
					$config['maintain_ratio']   = false;
					$config['height']           = $height;
					$config['width']            = $width;

					$this->image_lib->initialize($config);
					$this->image_lib->resize();
					$this->image_lib->clear();

					$tmp_path = $this->config->item('upload')."products/listimg/".$logoname;
					$image_thumb= $this->config->item('upload')."products/listimg/large/".$logoname;


					$height=720;
					$width=625;


					$this->load->library('image_lib');


					$config['image_library']    = 'gd2';
					$config['source_image']     = $tmp_path;
					$config['new_image']        = $image_thumb;
					$config['maintain_ratio']   = false;
					$config['height']           = $height;
					$config['width']            = $width;

					$this->image_lib->initialize($config);
					$this->image_lib->resize();
					$this->image_lib->clear();


					$tmp_path = $this->config->item('upload')."products/listimg/".$logoname;
					$image_thumb= $this->config->item('upload')."products/listimg/small/".$logoname;

					$height=50;
					$width=50;

					$this->load->library('image_lib');


					$config['image_library']    = 'gd2';
					$config['source_image']     = $tmp_path;
					$config['new_image']        = $image_thumb;
					$config['maintain_ratio']   = false;
					$config['height']           = $height;
					$config['width']            = $width;

					$this->image_lib->initialize($config);
					$this->image_lib->resize();
					$this->image_lib->clear();

	}
function imageuploads($logoname)
	{
				$tmp_path = $this->config->item('upload')."products/".$logoname;
				$image_thumb= $this->config->item('upload')."products/medium/".$logoname;

				$height=500;
				$width=370;

				$this->load->library('image_lib');


				$config['image_library']    = 'gd2';
				$config['source_image']     = $tmp_path;
				$config['new_image']        = $image_thumb;
				$config['maintain_ratio']   = false;
				$config['height']           = $height;
				$config['width']            = $width;

				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				$this->image_lib->clear();

				$tmp_path = $this->config->item('upload')."products/".$logoname;
				$image_thumb= $this->config->item('upload')."products/large/".$logoname;


				$height=720;
				$width=625;


				$this->load->library('image_lib');


				$config['image_library']    = 'gd2';
				$config['source_image']     = $tmp_path;
				$config['new_image']        = $image_thumb;
				$config['maintain_ratio']   = false;
				$config['height']           = $height;
				$config['width']            = $width;

				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				$this->image_lib->clear();


				$tmp_path = $this->config->item('upload')."products/".$logoname;
				$image_thumb= $this->config->item('upload')."products/small/".$logoname;

				$height=50;
				$width=150;

				$this->load->library('image_lib');


				$config['image_library']    = 'gd2';
				$config['source_image']     = $tmp_path;
				$config['new_image']        = $image_thumb;
				$config['maintain_ratio']   = false;
				$config['height']           = $height;
				$config['width']            = $width;

				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				$this->image_lib->clear();
			}
function download_attributes()
	{
		$attributes_list  = $this->product_model->getattributes();


		$output = '';
		$output .= 'Sr No.,Attribute ID,Product Name,Product Code,Size Name,Color Name,Price,Quantity';
		$output .="\n";
		if($attributes_list != '' && count($attributes_list) > 0) {
			$i=1;
		foreach($attributes_list as $attributes){
		$output .= '"'.$i.'","'.$attributes->id.'","'.$attributes->productname.'","'.$attributes->productcode.'","'.$attributes->sizename.'","'.$attributes->colourname.'","'.$attributes->price.'","'.$attributes->qty.'"';
		$output .="\n";
		$i++; }
		}
		$filename = "allattributes.csv";
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename='.$filename);
		echo $output;
		exit;
	}
function xlsuploadattributes()
{
		if($this->input->post('action') == 'add_XLS')
		{
		$data['error'] = '';
		ini_set('memory_limit', '512M');
		$file_path = $_FILES['csv']['tmp_name'];
		$file_type = $_FILES['csv']['type'];
		$this->load->library('PHPExcel');
		if($file_type == 'text/csv')
		{
			$objReader = new PHPExcel_Reader_CSV();
			$PHPExcel = $objReader->load($file_path);
		}
		else
		{
			$PHPExcel = PHPExcel_IOFactory::load($file_path);
		}

		$objWorksheet = $PHPExcel->getActiveSheet();
		$highestrow = $objWorksheet->getHighestRow();
	if($highestrow != 0)
	{


	for($i=2;$i<= $highestrow;$i++)
	{
			$obj_insData = array(
			'code.'=> addslashes($PHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue()) );
			if($obj_insData == '' && count($obj_insData) == '0')
			{
				continue;
			}
			else
			{

			$data=array(
			'id'=>addslashes($PHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue()),
			'price'=>addslashes($PHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue()),
			'qty'=>addslashes($PHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue()),
			);

			if($product = $this->product_model->get_id_atrribute(addslashes($PHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue()))){
			if($response = $this->product_model->adddata_atribute($data)){ } }
			}
	}
}
			$this->session->set_flashdata('L_strErrorMessage','Your Data File Uploaded Successfully!');
			redirect($this->config->item('base_url').'product/lists');
		}
		$data = array();
		$this->load->view('add_xlsattributes',$data);
}

function set_image_sequence() {
	$data['image_list'] = $this->input->post('image_list');
	$is_done = 0;
	if ($this->product_model->setImageSequence($data)) {
		$is_done = 1;
	}
	echo $is_done;
}

function show_city()
	{
		$cid = $_POST['cid'];
		$sid = $_POST['sid'];
		$show_id = $_POST['show_id'];
		$data = $this->product_model->show_subcategory($cid);
		
		$html = "<select id='city_id' name='city_id[]' class='form-control jobtext' onchange='get_area(this.value,".$show_id.")'>";
		$html .= "<option value=''> All City* </option>";
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
 

 	function show_city1()
	{
		$cid = $_POST['cid'];
		$sid = $_POST['sid'];
		$show_id = $_POST['show_id'];
		$data = $this->product_model->show_subcategory($cid);
		
		$html = "<select id='city_id' name='city_id1[]' class='form-control jobtext' onchange='get_area1(this.value,".$show_id.")'>";
		$html .= "<option value=''> All City* </option>";
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
		$show_id = $_POST['show_id'];
		$data = $this->product_model->show_area($cid);
		
		$html = "<select id='area_id' name='area_id[]' class='form-control jobtext' onchange='get_pincode1(this.value,".$show_id.")' >";
		$html .= "<option value=''> All Area* </option>";
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

	function show_area1()
	{
		
		$cid = $_POST['cid'];
		$sid = $_POST['sid'];
		$show_id = $_POST['show_id'];
		$data = $this->product_model->show_area($cid);
		
		$html = "<select id='area_id' name='area_id1[]' class='form-control jobtext' onchange='get_pincode1(this.value,".$show_id.")' >";
		$html .= "<option value=''> All Area* </option>";
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
		$data = $this->product_model->show_pincode($cid);
		
		$html = "<select id='pincode_id' name='pincode_id[]' class='form-control jobtext' >";
		$html .= "<option value=''> All Pincode* </option>";
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

	function show_pincode1()
	{
		
		$cid = $_POST['cid'];
		$sid = $_POST['sid'];
		$data = $this->product_model->show_pincode($cid);
		
		$html = "<select id='pincode_id' name='pincode_id1[]' class='form-control jobtext' >";
		$html .= "<option value=''> All Pincode* </option>";
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

	function removeprice($product_id,$id)
	{
			if($this->product_model->removeattriute($product_id,$id))
			{
				$this->session->set_flashdata('L_strErrorMessage','Product Attribite Deleted Succcessfully!');
				redirect($this->config->item('base_url').'product/edit/'.$product_id);
			}
			else
			{
				$this->session->set_flashdata('flashError','Some Errors prevented from Deleting');
				//break;
			}
	}
}
