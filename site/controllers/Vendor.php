<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Vendor extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');
		$this->load->model('home_model');
		$this->load->model('vendor_model');
		/*$this->load->model('cart_model');*/
		if($this->session->userdata('userid') == ''){
			redirect($this->config->item('base_url').'login');
		}
	}
	function dashboard()
	{
		$data['profile'] = $this->home_model->getuserdata($this->session->userdata('userid'));
		if($data['profile']->status == '1'){
		     redirect($this->config->item('base_url').'vendor/vendor_profile');
		}
		$data['productCount'] = $this->vendor_model->productCount($this->session->userdata('userid'));
		$data['orderCount'] = $this->vendor_model->getOrders($status='Success',$order_id ='');
		$data['getOrdersCount'] = $this->vendor_model->getPendingOrdersCount($order_id='','P');

		//echo "<pre>"; print_r($data['getOrdersCount']); die;
		//$data['addition_item'] = $this->home_model->addition_item($this->session->userdata('userid'));
		/*$data['get_vendor_product'] = $this->home_model->get_vendor_product($this->session->userdata('userid'),$id="");
	 	$data['productstatus'] = $this->home_model->productstatus($this->session->userdata('userid'));
	 	$data['orderstatus'] = $this->vendor_model->orderstatus($this->session->userdata('userid'));
	 	$data['paymentstatus'] = $this->vendor_model->paymentstatus($this->session->userdata('userid'));
		//$data['productorder'] = $this->home_model->productorder($this->session->userdata('userid'));
		$data['notifications'] = $this->vendor_model->notifications($this->session->userdata('userid'));*/
		$this->load->view('vendor_dashbord',$data);
	}
	function list_product()
	{
		$data['err_msg'] = '';
		$data["user_detail"] = $this->home_model->userdata($this->session->userdata('userid'));
		$data['getallproduct'] = $this->vendor_model->getallproduct();
		//print_r($data['getallproduct']); die;
		$this->load->view('vendor_list_product',$data);
	}
	function add_products()
	{
		$data['err_msg'] = '';
		$L_strErrorMessage='';
		$form_field = $data = array(
        	'material_type' => '',
			'material_name'=>'',
			'product_image'=>'',
			'material_code' => '',
			'product_description' => '',
			'billing_price' => '',
			'margin'=>'',
			'mrp' => '',
			'bpcl_special_price'=>'',
			'orc'=>'',
			'package' => '',
			// 'base_unit' => '',
			// 'base_pkg' => '',
			// 'sale_unit' => '',
			// 'price_unit' => '',
			'min_qty' => '',
			'page_url' => '',
			
		);
		if($this->input->post('action') == 'add_product')
		{
			foreach($form_field as $key => $value)
			{
				$data[$key]=$this->input->post($key);
			}
			 if($_FILES['product_image']['name'] != '')
            {
                $fileName = time().".".$_FILES["product_image"]["name"];
                $fileName = str_replace(' ', '_', $fileName);
                $fileTmpLoc = $_FILES["product_image"]["tmp_name"];
                $pathAndName = $this->config->item('upload')."product/".$fileName;
                $moveResult = move_uploaded_file($fileTmpLoc, $pathAndName);
                $data['product_image'] = $fileName;
            }
            else
            {
                $data['product_image']='';
            }
			$this->vendor_model->add_product($data);
			/*$email = $this->session->userdata('email');
			$message = '<!doctype html><html lang="en"><head>
	<title>Product Upload Request</title>
	<style>
		@import url("https://fonts.googleapis.com/css?family=Lato");
	</style> </head><body style="text-align: center;margin: 0;background: #ececec; font-family: "Lato", sans-serif;font-weight: 100;">
	<div style="max-width:630px;margin: 0 auto;border: thin solid #f3f0f0;background: #fff; border:1px solid #ccc">
		<div style="float: left; width: 100%; border-bottom:1px solid #ccc; text-align:center">
		<a href="'.$this->config->item('base_url').'"><img src="'.$this->config->item('base_url_views').'images/logo2-hori.png" style="margin-top:20px;max-width:200px;"></a>
		</div>
		 <div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
			<h3 style="color: #000; font-size: 21px;">Product Upload Request</h3>
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Hi there!</p>
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">We have received a product upload request. Your product is in review and will be live on successful verification.</p><br>
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">With Miles of Smiles,<BR>
			Team Happy Soul</p><br>
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Need Help?<br>
			<a href="'.$this->config->item('base_url').'contact-us" style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Contact Us for Help & Support</a></p>
		</div>
		<div style="clear: both">
	</div></div>
</body>
</html>';
        $subject = "Product Upload Request";
		$to = $email;
	
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: HappySoul <info@happysoul.in>' . "\r\n" .
			'Reply-To: info@happysoul.in' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
		$headers .= 'Cc: info@happysoul.in' . "\r\n";
		mail($to, $subject, $message, $headers);
		
		$to = $this->config->item('admin_email');
		mail($to, $subject, $message, $headers);*/
       		
		$this->session->set_flashdata('product_succsess','Product Added Successfully!');
		redirect($this->config->item('base_url').'list-product');
    	}
	  	$data['userid'] =  $this->session->userdata('userid');
		$data['allstate']= $this->home_model->alldata("state");
		$data['allcategory']= $this->home_model->alldata("category");
		$data['allmaterial']= $this->home_model->alldata("material");
		
		$this->load->view('add-product',$data);
	}
	function vendor_profile()
	{
		$data['err_msg'] = '';
		/*$data["user_detail"] = $this->home_model->userdata($this->session->userdata('userid'));
		$data['get_address'] = $this->vendor_model->get_address($this->session->userdata('userid'));*/
		$this->load->view('dashboard/verification-dash',$data);
	}
	function edit_product($id)
	{
			if(is_numeric($id))
			{
				$result = $this->vendor_model->get_product($id);
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
    				'orc'=>$result[0]->orc,
    				'package'=>$result[0]->package,
					// 'base_unit'=>$result[0]->base_unit,
    				// 'base_pkg'=>$result[0]->base_pkg,
    				// 'sale_unit'=>$result[0]->sale_unit,
    				// 'price_unit'=>$result[0]->price_unit,
    				'min_qty'=>$result[0]->min_qty,
    				'product_image'=>$result[0]->product_image,
    				
				);
				if($this->input->post('action') == 'edit_product')
				{
					foreach($data as $key => $value) {  $form_field[$key]=$this->input->post($key);	}
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
						$this->vendor_model->edit($id, $form_field);
						
						/*$this->load->model('account_model');
						$sellerdetails = $this->account_model->sellerdetails($result[0]->vendor_id);
						
					 
                    	$message = '<!doctype html><html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                    	<title>Vendor Edit Product</title>
                    	<style>
                    		@import url("https://fonts.googleapis.com/css?family=Lato");
                    	</style> </head><body style="text-align: center;margin: 0;background: #ececec; font-family: "Lato", sans-serif;font-weight: 100;">
                    	<div style="max-width:630px;margin: 0 auto;border: thin solid #f3f0f0;background: #fff; border:1px solid #ccc">
                    		<div style="float: left; width: 100%; border-bottom:1px solid #ccc; text-align:center">
                    		<a href="'.$this->config->item('base_url').'"><img src="'.$this->config->item('base_url_views').'images/logo2-hori.png" style="margin-top:20px;max-width:200px;"></a>
                    		</div>
                    		<div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
                     			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Hi</p>
                    			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Vendor changes by '.$sellerdetails->company_name.' have been initiated, its time to take a look!</p>
                    		</div>
                     		<div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
						<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">With Miles of Smiles,<BR>
			Team Happy Soul</p><br>
						<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Need Help?<br>
						<a href="'.$this->config->item('base_url').'contact-us" style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Contact Us for Help & Support</a></p>
					</div>
                    </body>
                    </html>';
                    
                            $subject = "Vendor Edit Product";
                     		$headers  = 'MIME-Version: 1.0' . "\r\n";
                    		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                    		$headers .= 'From: HappySoul <info@happysoul.in>' . "\r\n" .
                    			'Reply-To: info@happysoul.in' . "\r\n" .
                    			'X-Mailer: PHP/' . phpversion();
                    		$headers .= 'Cc: info@happysoul.in' . "\r\n";
                     		
                    		$to = $this->config->item('admin_email');
                    		mail($to, $subject, $message, $headers); */
						 
						$this->session->set_flashdata('product_succsess','Product Updated Successfully!');
						redirect($this->config->item('base_url').'list-product');
					
				}
				$data['userid'] =  $this->session->userdata('userid');
				$data['allstate']= $this->home_model->alldata("state");
				$data['allcategory']= $this->home_model->alldata("category");
				$data['addition_item']= $this->vendor_model->addition_item($id);
                $data['allmaterial']= $this->home_model->alldata("material");
				$this->load->view('edit_product',$data);
			}
			else
			{
				$this->session->set_flashdata('product_succsess','No Such Attribute!');
				redirect($this->config->item('base_url').'allproducts');
			}
	}
	function removeprice($product_id,$id)
	{
			if($this->vendor_model->removeattriute($product_id,$id))
			{
				$this->session->set_flashdata('product_succsess','Product Attribite Deleted Succcessfully!');
				redirect($this->config->item('base_url').'edit-product/'.$product_id);
			}
			else
			{
				$this->session->set_flashdata('flashError','Some Errors prevented from Deleting');
				//break;
			}
	}
	function delete_product()
	{
		if(isset($_POST['selected']) && count($_POST['selected']) > 0) {
			foreach($_POST['selected'] as $selCheck) {
				if($this->vendor_model->deletes($selCheck)) {
					$this->session->set_flashdata('product_succsess','Product Deleted Successfully!');
				}
				else
				{
						$this->session->set_flashdata('flashError','Some Errors prevented from Deleting');
						//break;
				}
			}
		}
		redirect($this->config->item('base_url').'list-product');
	}


	function vendor_my_account()
	{
		$data['err_msg'] = '';
		if($this->input->post("action")=="update_profile")
			{
				foreach($_POST as $key => $value)  
				{	
					$data[$key]=$this->input->post($key);
				}
				$content['fname']  = $data['fname']; 
				$content['mobile']  = $data['mobile'];
				$content['bank_name']  = $data['bank_name'];
				$content['account_no']  = $data['account_no'];
				$content['ifsc_code']  = $data['ifsc_code'];
							
				$this->vendor_model->vendor_update_profile($content);
				$this->session->set_flashdata('register_success','Profile updated successfully');
				redirect($this->config->item('base_url').'vendor-my-account', 'location');
			}

		$data['profile'] = $this->vendor_model->getuserdata($this->session->userdata('userid'));
		$this->load->view('vendor_my_account',$data);
	}

	function vendor_my_order()
	{
		$data['err_msg'] = '';
		$status = $this->input->get('status');
		$statuss = '';
		if($status)
		{
			$statuss = $status;
		}
		//echo $statuss; die;
		$data['orders_list'] = $this->vendor_model->getOrdersVendor($order_id='',$statuss);

		//echo $this->db->last_query(); die;
		//echo "<pre>"; print_r($data['orders_list']); die;
		$this->load->view('vendor_my_order',$data);
	}

	public function download_vendororder($status='')
    {
        $this->data['startdate'] = $startdate = $this->input->post('startdate');
		$this->data['enddate'] = $enddate = $this->input->post('enddate');
		$this->data['vendor_id'] = $vendor_id = $this->input->post('vendor_id');

        $orders_list =  $this->vendor_model->getOrdersVendor($order_id='',$statuss);
        //echo "<pre>";print_r($orders_list);echo "</pre>";
	    $output = 'OrderId,OrderDate,User Name,Email,Mobile,Total';
		$output .="\n";
		
                                 $i = 1;
                                 if($orders_list!='' && count($orders_list) > 0) {
                                 foreach($orders_list as  $key => $orders)
                                 {	
                                     $order_date = strtotime( $orders['cdate'] );
								     $mysqldate = date( 'F d, Y', $order_date );
                                   
            $output .= '"'.$orders['order_id'].'","'.$mysqldate.'","'.$orders['user_name'].'","'.$orders['user_email'].'","'.$orders['user_mobile'].'","'.number_format($orders['order_total'],false,'','').'"';
		    $output .="\n";
            $output .= ',Product Name,Unit price,Quantity,Total Price';
            $output .="\n";
            foreach ($orders['items'] as $item) {
                $output .= ',"'.$item['order_item_name'].'","'.number_format($item['product_item_price']).'","'.$item['product_quantity'].'","'.$item['product_item_price']*$item['product_quantity'].'"';
                $output .="\n";
            }

            $output .="\n";
		    
                              
                               $i++;   } }   
                              
		$filename = "distributor-order.csv";
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename='.$filename);
		echo $output;
        //echo "<pre>";print_r($output);echo "</pre>";
		exit;
    }

	function vendor_change_password()
	{
		$data['err_msg'] = '';
		if($this->input->post("action")=="update_profile")
			{
				foreach($_POST as $key => $value)  
				{	
					$data[$key]=$this->input->post($key);
				}
				$content['pass']  = $data['pass']; 
						
				$this->vendor_model->update_password($content);
				$this->session->set_flashdata('register_success','Password updated successfully');
				redirect($this->config->item('base_url').'vendor-change-password', 'location');
			}

		$data['profile'] = $this->vendor_model->getuserdata($this->session->userdata('userid'));
		$this->load->view('vendor_change_password',$data);
	}

	function changeStatusmail($status,$order_item_id,$orderid)   {	
   //$status=$this->input->post("status");	
   //$trackadd=$this->input->post("tracking");	
   if($status !='')		
   {	
		 $this->vendor_model->change_order_status($orderid,$status);
   if($status=='P'){							
   $this->vendor_model->status_pedning($order_item_id,$status);			
   }		
   if($status=='S')			{					
   $this->vendor_model->status_shiped($order_item_id,$status);		
   }						
   if($status=='D')			{	
   $this->vendor_model->status_deliver($order_item_id,$status);			
   }					

   if($status=='C')			{	
   $this->vendor_model->status_cancel($order_item_id,$status);		
   }					
   /*$order1 = $this->vendor_model->getOrders($order_item_id);		
   $order=$order1[0];				
   /*$productdetailmail = '';	
				$i=1;			
				$productdetailmail .= "<table cellpadding='5' style='border-top:2px solid #000;width: 600px;text-align: center;'>";			
				$productdetailmail .= "<tr>		
				<th>Sr.No</th>				
				<th>Product Name</th>		
				<th>Quantity</th>			
				<th>Price</th> 				
				<th>Total</th> 				
				</tr>";			
				$pvalue = '0';
				foreach($order['items'] as $items)  				
				{		
					$productdetailmail .= " 					
					<tr>						
					<td>".$i."</td>				
					<td>".$items['order_item_name']."</td>

					<td>".$items['product_quantity']."</td>						
					<td> ".number_format($items['product_item_price'])."</td>";

					$i++;				
					$pvalue=($pvalue+(($items['product_item_price'])*$items['product_quantity']));
					$productdetailmail .= " 	
					<td> ".number_format(($items['product_item_price']) * $items['product_quantity'])."</td>";	
					$productdetailmail .= "</tr>				
					";				
					}
				$productdetailmail .= "</table></br></br>";			
						$message = '<div style="width:600px; height:auto; margin:0 auto;">		
						<img src="'.$this->config->item('base_url_views').'images/logo.png" style="height:auto; margin-left:170px;">	
						<p>Hello '.$order['user_name'].',</p>';	
						if($status=='P'){				
						$message .= '<p>Your Order No '.$orderid.' is being processed. Your Tracking Detail is '.$trackadd.'</p>';			
						}
				if($status=='S'){					$message .= '<p>Your Order No '.$orderid.' is being Shipped. Your Tracking Detail is '.$trackadd.'</p>';				}
				if($status=='D'){					$message .= '<p>Your Order No '.$orderid.' is being Delivered. Your Tracking Detail is '.$trackadd.'</p>';				}
				if($status=='C'){					$message .= '<p>Your Order No '.$orderid.' is being Canceled. Your Tracking Detail is '.$trackadd.'</p>';				}	
				$message .= '<p> Order ID: '.$orderid.'</p>';
				$message .= $productdetailmail; 				
				$message .= "  				</br></br>			
					<table align='right'> 		 	 
				<tr><td>Sub Total Amount: </td><td>".number_format($pvalue)."</td></tr>";
				if($order['coupondiscount'] !='' && $order['coupondiscount'] != '0'){
					$message .= "<tr><td>Coupon Discount: </td><td>".number_format($order['coupondiscount'])."</td></tr>";
				}				
				$message .= "<tr><td>Total Amount: </td><td>".number_format($order['order_total'])."</td></tr>";
				$message .= '</table> ';

				$country_name = $this->orders_model->get_country_name($order['country']);
				$message .= "<table> 		

					<tr>			
						</br></br></br></br></br>	
										<td>			
				<table> 	
				<th align='left'>Shipping Address: </th>	
				<tr><td><b>Name</b> : ".$order['user_name']." </td></tr>		
				<tr><td>".$order['address1'].",</td></tr>		
				<tr><td> ".$order['city'].",</td></tr>
				<tr><td> ".$order['state']."-".$order['post_code'].",</td></tr>
				<tr><td> ".$country_name.".</td></tr>	
				<tr><td>Mo - ".$order['phone_number']."</td></tr>		
							</table>
				</td>
				</tr>
				</table>";

				$message .='
				</div>					 
				</div>'; 						
				$to=$order['user_email'];		
				if($status=='P'){				
				$subject  = 'Pending Order';			
				}			
				if($status=='S'){						$subject  = 'Shipped Order';					
				}			
				if($status=='D'){						$subject  = 'Delivered Order';		
				}	
				if($status=='C'){			
				$subject  = 'Canceled Order ';				
				}	

			if($status !='P'){

				$headers  = 'MIME-Version: 1.0' . "\r\n";		
						$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";		
								$headers .= 'From:lyngum.com <info@lyngum.com>' . "\r\n" .		
									'Reply-To: info@lyngum.com' . "\r\n" .				

					'X-Mailer: PHP/' . phpversion();	
							$headers .= 'Cc: info@lyngum.com' . "\r\n";

			mail($to, $subject, $message, $headers);			
						mail('amvi.himanshu@gmail.com', $subject, $message, $headers);				
								}*/	 			
			$this->session->set_flashdata('register_success','Your Order Status Update  successfully.');		
				}			
			else			
			{				
				$this->session->set_flashdata('register_success','Some Errors prevented from Adding!!!!');
			}
	   redirect($this->config->item('base_url').'vendor-my-order');   }
	
	
}