<?php
class Billship extends CI_Controller
{
	private $_data = array();
	function __construct()
	{
		parent::__construct();
		$this->load->model('bilship_model');
		$this->load->model('home_model');
	}
	function checkout($id)
	{
		if ($id == '1') {
			$payment_status = 'Success';
			$order_status = 'P';
			$paymentmode = $id;
			$additionalamt = '0';
		} else {
			$payment_status = 'FAILED';
			$order_status = 'P';
			$paymentmode = $id;
			$additionalamt = '0';
		}


		$intOrderNumber = $this->bilship_model->getOrderNumber();
		$order_number = array('order_number'  => $intOrderNumber);
		$this->session->set_userdata($order_number);
		$L_strErrorMessage = '';

		$shippaddress['first_name'] 	= $this->input->post("first_name");
		$shippaddress['address1'] 		= $this->input->post("address1");
		$shippaddress['address2'] 		= $this->input->post("address2");
		// $shippaddress['country'] 		= $this->input->post("country");
		$shippaddress['state'] 			= $this->input->post("state");
		$shippaddress['city'] 			= $this->input->post("city");
		$shippaddress['post_code'] 		= $this->input->post("post_code");
		$shippaddress['phone_number'] 	= $this->input->post("phone_number");
		if (isset($_POST['samebill'])) {
			$shippaddress['bill_first_name'] = $this->input->post("first_name");

			$shippaddress['bill_address1'] 	= $this->input->post("address1");
			$shippaddress['bill_address2'] 	= $this->input->post("address2");
			// $shippaddress['bill_country'] 	= $this->input->post("country");	
			$shippaddress['bill_state']  	= $this->input->post("state");
			$shippaddress['bill_city']		= $this->input->post("city");
			$shippaddress['bill_post_code']  = $this->input->post("post_code");
			$shippaddress['bill_phone_number'] = $this->input->post("phone_number");
		} else {
			$shippaddress['bill_first_name']  = $this->input->post("bill_first_name");
			$shippaddress['bill_address1'] 	 = $this->input->post("bill_address1");
			$shippaddress['bill_address2'] 	 = $this->input->post("bill_address2");
			// $shippaddress['bill_country'] 	 = $this->input->post("bill_country");	
			$shippaddress['bill_state'] 		 = $this->input->post("bill_state");
			$shippaddress['bill_city'] 		 = $this->input->post("bill_city");
			$shippaddress['bill_post_code']	 = $this->input->post("bill_post_code");
			$shippaddress['bill_phone_number'] = $this->input->post("bill_phone_number");
		}

		$ship_user_id = $this->session->userdata('userid');
		$shippaddress['user_id']  = $ship_user_id;
		$shippaddress['order_id'] = $this->session->userdata('order_number');
		$this->bilship_model->addaddress($shippaddress);

		if ($this->session->userdata('coupancode') != '') {
			$coupancode = $this->session->userdata('coupancode');
			$coupanname = $this->session->userdata('coupanname');
		} else {
			$coupancode = "";
			$coupanname = "";
		}
		$vendor_id = array();
		foreach ($this->cart->contents() as $arrRowDeailts) {
			$vendor_id[] = $arrRowDeailts['options']['vendor_id'];
		}
		//print_R($vendor_id); die;
		$content = array(
			'user_id'			=> $this->session->userdata('userid'),
			'order_number'		=> $intOrderNumber,
			'order_invoice'		=> $intOrderNumber,
			'user_info_id'		=> $this->session->userdata('userid'),
			'order_total'		=> $this->session->userdata('total_amount'),
			/*'order_currency'	=> $this->session->userdata('currencysymbol'),
			'order_currencyrate'=> $this->session->userdata('currencyrate'),
			'order_currencycode'=> $this->session->userdata('currencycode'),*/
			'order_status'		=> $order_status,
			'paymentmode'		=> $paymentmode,
			'additionalcharge'  => $additionalamt,
			'cdate'				=> date('Y-m-d H:i:s'),
			'payment_status'	=> $payment_status,
			'coupondiscount'	=> $this->session->userdata('discount_amount'),
			'coupon_code'		=> $coupancode,
			'coup_name'			=> $coupanname,
			'shippingcost'		=> $this->session->userdata('shipping_cost'),
			'ip_address'		=> $_SERVER['REMOTE_ADDR'],
			'vendor_id'		    => implode(',', $vendor_id),
		);

		$productdetailmail = '';
		$arrOrderId = $this->bilship_model->saveOrderInDatabase($content, $this->session->userdata('order_number'));
		$i = 1;
		$productdetailmail .= "<table cellpadding='5' style='border-top:2px solid #000;width: 600px;text-align: center;'>";
		$productdetailmail .= "<tr>
							<th>Sr.No</th>
							<th>Product Name</th>
							<th>Quantity</th>
							<th>Price</th> 
							<th>Total</th> 	
							</tr>";
		$pvalue = '0';
		$userid =  $this->session->userdata('userid');

		foreach ($this->cart->contents() as $arrRowDeailts) {
			$arrProddetails = $this->bilship_model->getproddetails($arrRowDeailts['id']);
			$product_id = $arrProddetails->id;
			$arrData = array(
				'order_id' => $arrOrderId,
				'user_info_id' => $userid,
				'product_id' => $product_id,
				'bpcl_special_price' => $arrProddetails->bpcl_special_price,
				'billing_price' => $arrProddetails->billing_price,
				'distributorpay' => $arrProddetails->distributorpay,
				'deliverypay' => $arrProddetails->deliverypay,
				'bpclpay' => $arrProddetails->bpclpay,
				'package' => $arrProddetails->package,

				'order_item_name' => $arrRowDeailts['name'],
				'product_quantity' => $arrRowDeailts['qty'],
				'product_item_price' => $arrRowDeailts['price'],
				'base_image' => $arrRowDeailts['options']['base_image'],
				'material' => $arrRowDeailts['options']['material_type'],
				'material_code' => $arrRowDeailts['options']['material_code'],
				'realprice' => $arrRowDeailts['options']['mrp'],
				'vendor_id' => $arrRowDeailts['options']['vendor_id'],
				'cdate' => date('Y-m-d'),
				'order_status'		=> $order_status,
			);

			$this->bilship_model->saveOrderFromCart($arrData);

			$productdetailmail .= " 
						<tr>
							<td>" . $i . "</td>
							<td>" . $arrRowDeailts['name'] . "</td>							
							<td>" . $arrRowDeailts['qty'] . "</td>
							<td><i class='fa fa-inr' aria-hidden='true'></i>  " . round($arrRowDeailts['price']) . "</td>";
			$i++;
			$pvalue = ($pvalue + (($arrRowDeailts['price']) * $arrRowDeailts['qty']));
			$productdetailmail .= " 
					<td> <i class='fa fa-inr' aria-hidden='true'></i> " . round(($arrRowDeailts['price']) * $arrRowDeailts['qty']) . "</td>";
			$productdetailmail .= "</tr>
					";

			$vendor_id = $arrRowDeailts['options']['vendor_id'];
		}

		$productdetailmail .= "</table></br></br>";
		$username = $this->session->userdata('name');
		$message = '<div style="width:600px; height:auto; margin:0 auto;">
				<img src="' . $this->config->item('base_url_views') . '/customer/images/logo-new.png" style="height:auto; margin-left:170px;">
					<p>Hello ' . $username . ',</p>
					<p>Your Order No ' . $this->session->userdata('order_number') . ' is being processed.</p>
					<p> Order ID: ' . $arrOrderId . '</p>
					';

		$message .= $productdetailmail;
		$message .= "  
										
				<table align='right'> 		 	 
				<tr><td>Sub Total Amount: </td><td><i class='fa fa-inr' aria-hidden='true'></i>  " . round($pvalue) . "</td></tr>";

		if ($this->session->userdata('coupancode') != "") {
			$message .= "<tr><td>Coupon Discount :</td><td> <i class='fa fa-inr' aria-hidden='true'></i> " . round($this->session->userdata('discount_amount')) . "</td></tr>";
		}
		if ($this->session->userdata('shipping_cost') != "0") {
			$message .= "<tr><td>Shipping Charge  :</td><td> <i class='fa fa-inr' aria-hidden='true'></i> " . round($this->session->userdata('shipping_cost')) . "</td></tr>";
		}
		$message .= "<tr><td>Total Amount: </td><td><i class='fa fa-inr' aria-hidden='true'></i> " . round($this->session->userdata('total_amount')) . "</td></tr>";
		$message .= '</table> ';

		$message .= "<table> 
			<tr>
				</br></br></br></br></br>
					<td>						
					<table> 
						<th align='left'>Shipping Address: </th>
						<tr><td><b>Name</b> : " . $shippaddress['first_name'] . " " . $shippaddress['last_name'] . "</td></tr>
						<tr><td>" . $shippaddress['address1'] . ",</td></tr>
						<tr><td>" . $shippaddress['address2'] . ",</td></tr>						
						<tr><td> " . $shippaddress['city'] . "-" . $shippaddress['post_code'] . ",</td></tr>						
						<tr><td>" . $shippaddress['state'] . ",</td></tr>																
						<tr><td>Mo - " . $shippaddress['phone_number'] . "</td></tr>
						<tr><td>Email - " . $this->session->userdata("email") . "</td></tr>
					</table>
					</td>
				</tr>
				</table>";

		$message .= '</div></div>';

		$user_details = $this->home_model->sellernamedetails($vendor_id);
		$to = $this->session->userdata('email');
		$subject  = 'Thank you for shopping from bpsmart.in';
		$subject_vendor  = 'You have received an order from bpsmart.in';

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From:bpsmart.in <info@bpsmart.in>' . "\r\n" .
			'Reply-To: info@bpsmart.in' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
		$headers .= 'Cc: info@bpsmart.in' . "\r\n";

		mail($user_details->email, $subject_vendor, $message, $headers);
		mail('amvisolution@gmail.com', $subject, $message, $headers);
		mail($to, $subject, $message, $headers);

		if ($id == '1') {
			redirect($this->config->item('base_url') . 'Billship/thanks/' . $intOrderNumber);
		} else {

			require_once("paytmchecksum/checksum/PaytmChecksum.php");
			$paytmParams = array();

			$paytmParams["body"] = array(
				"requestType"  => "Payment",
				"mid"      => "Bharat39191867247929",
				"websiteName"  => "WEBSTAGING",
				"orderId"    => $arrOrderId,
				"callbackUrl"  => $this->config->item('base_url') . 'billship/paytmsuccess',
				"txnAmount"   => array(
					"value"   => $this->session->userdata('total_amount'),
					"currency" => "INR",
				),
				"userInfo"   => array(
					"custId"  => $this->session->userdata('userid'),
				),
			);
			/*
					* Generate checksum by parameters we have in body
					* Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys
					*/
			$checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), "%V6wUj%cCDhRGEfq");

			$paytmParams["head"] = array(
				"signature" => $checksum
			);

			$post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);

			/* for Staging */
			$url = "https://securegw-stage.paytm.in/theia/api/v1/initiateTransaction?mid=Bharat39191867247929&orderId=$arrOrderId";

			/* for Production */
			//$url = "https://securegw.paytm.in/theia/api/v1/initiateTransaction?mid=BlueTi16643266802683&orderId=$arrOrderId";

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
			$response = curl_exec($ch);

			//echo "<pre>";
			$tokendata = json_decode($response);

			$tid = $tokendata->body->txnToken;

			redirect($this->config->item('base_url') . 'billship/paytm/' . $tid);
		}
		//if($id == '1') {

		/* if($this->cart->total_items() > 0)
			{ 	
				foreach($this->cart->contents() as $items)  
				{
					$this->bilship_model->updatestock($items['options']['attribute_id'],$items['qty']);
				}
			}*/
		//echo $message; die;

		/*	
			redirect($this->config->item('base_url').'billship/thanks/'.$intOrderNumber);*/

		/*}else if($id == '2'){
				redirect($this->config->item('base_url').'billship/rozarpay');
			}else{	
				redirect($this->config->item('base_url').'billship/paypal');	
			}*/
		//	echo $intOrderNumber; die;
	}

	function checkoutCustomer($id)
	{
		if ($id == '1') {
			$payment_status = 'Success';
			$order_status = 'P';
			$paymentmode = $id;
			$additionalamt = '0';
		} else {
			$payment_status = 'FAILED';
			$order_status = 'P';
			$paymentmode = $id;
			$additionalamt = '0';
		}

		$billaddress = array(
			'first_name' 	=> $this->input->post("first_name"),
			//'last_name'		=> $this->input->post("last_name"),
			'address1'      => $this->input->post("address1"),
			'address2'      => $this->input->post("address2"),
			'city'   		=> $this->input->post("city"),
			'state'   		=> $this->input->post("state"),
			'post_code'     => $this->input->post("post_code"),
			// 'country'      	=> $this->input->post("country"),
			'phone_number' 	=> $this->input->post("phone_number"),
			//'email_address' => $this->input->post("email_address"),
		);

		$intOrderNumber = $this->bilship_model->getOrderNumber();
		$order_number = array('order_number'  => $intOrderNumber);
		$ship_user_id = $this->session->userdata('userid');

		$this->session->set_userdata($order_number);

		if ($this->input->post('add_new_address') == '0' && $this->input->post('selectedaddress') != '') {
			$bill_address_id = $this->input->post('selectedaddress');
			$this->bilship_model->updatebilladd($bill_address_id);
		} else {
			$bill_address_id = $this->bilship_model->add_billaddress($ship_user_id, $billaddress);
		}
		//echo $bill_address_id; die;
		//print_R($bill_address_id); die;
		$getadd = $this->bilship_model->getaddnew($bill_address_id);
		//print_R($getadd); die;
		$L_strErrorMessage = '';

		$shippaddress['first_name'] 	= $getadd->first_name;
		$shippaddress['address1'] 		= $getadd->address1;
		$shippaddress['address2'] 		= $getadd->address2;
		// $shippaddress['country'] 		= $getadd->country;
		$shippaddress['state'] 			= $getadd->state;
		$shippaddress['city'] 			= $getadd->city;
		$shippaddress['post_code'] 		= $getadd->post_code;
		$shippaddress['phone_number'] 	= $getadd->phone_number;


		if (isset($_POST['samebill'])) {

			$shippaddress['bill_first_name'] = $getadd->first_name;
			$shippaddress['bill_address1'] 	= $getadd->address1;
			$shippaddress['bill_address2'] 	= $getadd->address2;
			// $shippaddress['bill_country'] 	= $getadd->country;
			$shippaddress['bill_state']  	= $getadd->state;
			$shippaddress['bill_city']		= $getadd->city;
			$shippaddress['bill_post_code']  = $getadd->post_code;
			$shippaddress['bill_phone_number'] = $getadd->phone_number;
		} else {
			$shippaddress['bill_first_name']  = $this->input->post("bill_first_name");
			$shippaddress['bill_address1'] 	 = $this->input->post("bill_address1");
			$shippaddress['bill_address2'] 	 = $this->input->post("bill_address2");
			// $shippaddress['bill_country'] 	 = $this->input->post("bill_country");	
			$shippaddress['bill_state'] 		 = $this->input->post("bill_state");
			$shippaddress['bill_city'] 		 = $this->input->post("bill_city");
			$shippaddress['bill_post_code']	 = $this->input->post("bill_post_code");
			$shippaddress['bill_phone_number'] = $this->input->post("bill_phone_number");
		}


		$shippaddress['user_id']  = $ship_user_id;
		$shippaddress['order_id'] = $this->session->userdata('order_number');
		$this->bilship_model->addaddress($shippaddress);

		if ($this->session->userdata('coupancode') != '') {
			$coupancode = $this->session->userdata('coupancode');
			$coupanname = $this->session->userdata('coupanname');
		} else {
			$coupancode = "";
			$coupanname = "";
		}
		$vendor_id = array();
		foreach ($this->cart->contents() as $arrRowDeailts) {
			$vendor_id[] = $arrRowDeailts['options']['vendor_id'];
			$distributor_id[] = $arrRowDeailts['options']['distributor_id'];
		}
		//print_R($vendor_id); die;
		$content = array(
			'user_id'			=> $this->session->userdata('userid'),
			'order_number'		=> $intOrderNumber,
			'order_invoice'		=> $intOrderNumber,
			'user_info_id'		=> $this->session->userdata('userid'),
			'order_total'		=> $this->session->userdata('total_amount'),
			/*'order_currency'	=> $this->session->userdata('currencysymbol'),
			'order_currencyrate'=> $this->session->userdata('currencyrate'),
			'order_currencycode'=> $this->session->userdata('currencycode'),*/
			'order_status'		=> $order_status,
			'paymentmode'		=> $paymentmode,
			'additionalcharge'  => $additionalamt,
			'cdate'				=> date('Y-m-d H:i:s'),
			'payment_status'	=> $payment_status,
			'coupondiscount'	=> $this->session->userdata('discount_amount'),
			'coupon_code'		=> $coupancode,
			'coup_name'			=> $coupanname,
			'shippingcost'		=> $this->session->userdata('shipping_cost'),
			'ip_address'		=> $_SERVER['REMOTE_ADDR'],
			'vendor_id'		=> implode(',', $vendor_id),
			'distributor_id'		=> implode(',', $distributor_id),
			'is_customer' => 1,
		);

		$productdetailmail = '';
		$arrOrderId = $this->bilship_model->saveOrderInDatabase($content, $this->session->userdata('order_number'));
		$i = 1;
		$productdetailmail .= "<table cellpadding='5' style='border-top:2px solid #000;width: 600px;text-align: center;'>";
		$productdetailmail .= "<tr>
							<th>Sr.No</th>
							<th>Product Name</th>
							<th>Quantity</th>
							<th>Price</th> 
							<th>Total</th> 	
							</tr>";
		$pvalue = '0';
		$userid =  $this->session->userdata('userid');

		foreach ($this->cart->contents() as $arrRowDeailts) {
			$arrProddetails = $this->bilship_model->getproddetails($arrRowDeailts['id']);
			$product_id = $arrProddetails->id;
			$arrData = array(
				'order_id' => $arrOrderId,
				'user_info_id' => $userid,
				'product_id' => $product_id,
				'bpcl_special_price' => $arrProddetails->bpcl_special_price,
				'billing_price' => $arrProddetails->billing_price,
				'distributorpay' => $arrProddetails->distributorpay,
				'deliverypay' => $arrProddetails->deliverypay,
				'bpclpay' => $arrProddetails->bpclpay,
				'package' => '1',

				'order_item_name' => $arrRowDeailts['name'],
				'product_quantity' => $arrRowDeailts['qty'],
				'product_item_price' => $arrRowDeailts['price'],

				'base_image' => $arrRowDeailts['options']['base_image'],
				'material' => $arrRowDeailts['options']['material_type'],
				'material_code' => $arrRowDeailts['options']['material_code'],
				'realprice' => $arrRowDeailts['options']['mrp'],
				'vendor_id' => $arrRowDeailts['options']['vendor_id'],
				'distributor_id' => $arrRowDeailts['options']['distributor_id'],
				'cdate' => date('Y-m-d'),
				'is_customer' => 1,
			);

			$this->bilship_model->saveOrderFromCart($arrData);

			$productdetailmail .= " 
						<tr>
							<td>" . $i . "</td>
							<td>" . $arrRowDeailts['name'] . "</td>							
							<td>" . $arrRowDeailts['qty'] . "</td>
							<td><i class='fa fa-inr' aria-hidden='true'></i>  " . round($arrRowDeailts['price']) . "</td>";
			$i++;
			$pvalue = ($pvalue + (($arrRowDeailts['price']) * $arrRowDeailts['qty']));
			$productdetailmail .= " 
					<td> <i class='fa fa-inr' aria-hidden='true'></i> " . round(($arrRowDeailts['price']) * $arrRowDeailts['qty']) . "</td>";
			$productdetailmail .= "</tr>
					";

			$distributor_id = $arrRowDeailts['options']['distributor_id'];
		}

		$productdetailmail .= "</table></br></br>";
		$username = $this->session->userdata('name');
		$message = '<div style="width:600px; height:auto; margin:0 auto;">
				<img src="' . $this->config->item('base_url_views') . '/customer/images/logo-new.png" style="height:auto; margin-left:170px;">
					<p>Hello ' . $username . ',</p>
					<p>Your Order No ' . $this->session->userdata('order_number') . ' is being processed.</p>
					<p> Order ID: ' . $arrOrderId . '</p>
					';

		$message .= $productdetailmail;
		$message .= "  
										
				<table align='right'> 		 	 
				<tr><td>Sub Total Amount: </td><td><i class='fa fa-inr' aria-hidden='true'></i>  " . round($pvalue) . "</td></tr>";

		if ($this->session->userdata('coupancode') != "") {
			$message .= "<tr><td>Coupon Discount :</td><td> <i class='fa fa-inr' aria-hidden='true'></i> " . round($this->session->userdata('discount_amount')) . "</td></tr>";
		}
		if ($this->session->userdata('shipping_cost') != "0") {
			$message .= "<tr><td>Shipping Charge  :</td><td> <i class='fa fa-inr' aria-hidden='true'></i> " . round($this->session->userdata('shipping_cost')) . "</td></tr>";
		}
		$message .= "<tr><td>Total Amount: </td><td><i class='fa fa-inr' aria-hidden='true'></i> " . round($this->session->userdata('total_amount')) . "</td></tr>";
		$message .= '</table> ';

		$message .= "<table> 
			<tr>
				</br></br></br></br></br>
					<td>						
					<table> 
						<th align='left'>Shipping Address: </th>
						<tr><td><b>Name</b> : " . $shippaddress['first_name'] . "</td></tr>
						<tr><td>" . $shippaddress['address1'] . ",</td></tr>
						<tr><td> " . $shippaddress['city'] . "-" . $shippaddress['post_code'] . ",</td></tr>					
							<tr><td>" . $shippaddress['state'] . ",</td></tr>																								
						<tr><td>Mo - " . $shippaddress['phone_number'] . "</td></tr>
						<tr><td>Email - " . $this->session->userdata("email") . "</td></tr>
					</table>
					</td>
				</tr>
				</table>";

		$message .= '</div></div>';


		//echo $message; die;

		$user_details = $this->home_model->sellernamedetails($distributor_id);

		$to = $this->session->userdata('email');
		$subject  = 'Thank you for shopping from bpsmart.in';
		$subject_distributor  = 'You have received an order from bpsmart.in';
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From:bpsmart.in <info@bpsmart.in>' . "\r\n" .
			'Reply-To: info@bpsmart.in' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
		$headers .= 'Cc: info@bpsmart.in' . "\r\n";

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From:bpsmart.in <info@bpsmart.in>' . "\r\n" .
			'Reply-To: info@bpsmart.in' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
		$headers .= 'Cc: info@bpsmart.in' . "\r\n";

		mail($user_details->email, $subject_distributor, $message, $headers);
		mail('amvisolution@gmail.com', $subject, $message, $headers);
		mail($to, $subject, $message, $headers);

		if ($id == '1') {
			redirect($this->config->item('base_url') . 'Billship/customerthanks/' . $intOrderNumber);
		} else {
			require_once("paytmchecksum/checksum/PaytmChecksum.php");
			$paytmParams = array();

			$paytmParams["body"] = array(
				"requestType"  => "Payment",
				"mid"      => "Bharat39191867247929",
				"websiteName"  => "WEBSTAGING",
				"orderId"    => $arrOrderId,
				"callbackUrl"  => $this->config->item('base_url') . 'billship/paytmsuccesscustomer',
				"txnAmount"   => array(
					"value"   => $this->session->userdata('total_amount'),
					"currency" => "INR",
				),
				"userInfo"   => array(
					"custId"  => $this->session->userdata('userid'),
				),
			);
			/*
				* Generate checksum by parameters we have in body
				* Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys
				*/
			$checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), "%V6wUj%cCDhRGEfq");

			$paytmParams["head"] = array(
				"signature" => $checksum
			);

			$post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);

			/* for Staging */
			$url = "https://securegw-stage.paytm.in/theia/api/v1/initiateTransaction?mid=Bharat39191867247929&orderId=$arrOrderId";

			/* for Production */
			//$url = "https://securegw.paytm.in/theia/api/v1/initiateTransaction?mid=BlueTi16643266802683&orderId=$arrOrderId";

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
			$response = curl_exec($ch);

			//echo "<pre>";
			$tokendata = json_decode($response);

			$tid = $tokendata->body->txnToken;

			redirect($this->config->item('base_url') . 'billship/paytm/' . $tid);
		}
	}

	function savespecialorders()
	{
		//echo $this->input->post("pincode");exit;
		$this->load->model('cart_model');
		$id = "";

		//print_r($_POST); die;

		$distributor_id = $_POST['distributorid'];
		$totalamount = '0';
		foreach ($_POST['productid'] as $key => $value) {



			if ($_POST['productqty'][$key] != '0') {


				$details = $this->cart_model->prodetailsspecial($value);

				$pid = $value;
				$qty = $_POST['productqty'][$key];
				$price = $details->price;
				$mrp = $details->mrp;


				$data['cartprod'] = array(
					'id'      => $details->id,
					'qty'     => $qty,
					'price'   => round($price),
					'name'    => $details->material_name,
					'options' => array('material_code' => @$details->material_code, 'material_type' => '', 'base_image' => @$details->product_image, 'mrp' => $mrp, 'vendor_id' => '0')
				);
				$this->cart->insert($data);


				$total_amount = ($total_amount + ($qty * $price));
			}
		}

		$this->session->set_userdata('total_amount', $total_amount);
		//$this->session->set_userdata('user_id',0);

		if ($id == '1') {
			$payment_status = 'Success';
			$order_status = 'P';
			$paymentmode = '1';
			$additionalamt = '0';
		} else {
			$payment_status = 'Success';
			$order_status = 'P';
			$paymentmode = '1';
			$additionalamt = '0';
		}

		$billaddress = array(
			'first_name' 	=> $this->input->post("fname"),
			'address1'      => $this->input->post("address"),
			'address2'      => "",
			'city'   		=> "",
			'state'   		=> "",
			'post_code'     => $this->input->post("pincode"),
			'phone_number' 	=> $this->input->post("phonenumber"),
		);

		$intOrderNumber = $this->bilship_model->getOrderNumber();
		$order_number = array('order_number'  => $intOrderNumber);
		$ship_user_id = '0'; //$this->session->userdata('userid');

		$this->session->set_userdata($order_number);

		$bill_address_id = $this->bilship_model->add_billaddress($ship_user_id, $billaddress);
		//echo $bill_address_id; die;
		//print_R($bill_address_id); die;
		$getadd = $this->bilship_model->getaddnew($bill_address_id);
		//print_R($getadd); die;
		$L_strErrorMessage = '';

		$shippaddress['first_name'] 	= $getadd->first_name;
		$shippaddress['address1'] 		= $getadd->address1;
		$shippaddress['address2'] 		= $getadd->address2;
		// $shippaddress['country'] 		= $getadd->country;
		$shippaddress['state'] 			= $getadd->state;
		$shippaddress['city'] 			= $getadd->city;
		$shippaddress['post_code'] 		= $getadd->post_code;
		$shippaddress['phone_number'] 	= $getadd->phone_number;


		if (isset($_POST['samebill'])) {
			$shippaddress['bill_first_name'] = $getadd->first_name;
			$shippaddress['bill_address1'] 	= $getadd->address1;
			$shippaddress['bill_address2'] 	= $getadd->address2;
			// $shippaddress['bill_country'] 	= $getadd->country;
			$shippaddress['bill_state']  	= $getadd->state;
			$shippaddress['bill_city']		= $getadd->city;
			$shippaddress['bill_post_code']  = $getadd->post_code;
			$shippaddress['bill_phone_number'] = $getadd->phone_number;
		} else {
			$shippaddress['bill_first_name']  = $this->input->post("bill_first_name");
			$shippaddress['bill_address1'] 	 = $this->input->post("bill_address1");
			$shippaddress['bill_address2'] 	 = $this->input->post("bill_address2");
			// $shippaddress['bill_country'] 	 = $this->input->post("bill_country");	
			$shippaddress['bill_state'] 		 = $this->input->post("bill_state");
			$shippaddress['bill_city'] 		 = $this->input->post("bill_city");
			$shippaddress['bill_post_code']	 = $this->input->post("bill_post_code");
			$shippaddress['bill_phone_number'] = $this->input->post("bill_phone_number");
		}




		$shippaddress['user_id']  = $ship_user_id;
		$shippaddress['order_id'] = $this->session->userdata('order_number');
		$this->bilship_model->addaddress($shippaddress);

		if ($this->session->userdata('coupancode') != '') {
			$coupancode = $this->session->userdata('coupancode');
			$coupanname = $this->session->userdata('coupanname');
		} else {
			$coupancode = "";
			$coupanname = "";
		}

		$vendor_id = array();
		/*foreach($this->cart->contents() as $arrRowDeailts )  
			{
				$vendor_id[] = $arrRowDeailts['options']['vendor_id'];
				$distributor_id[] = $arrRowDeailts['options']['distributor_id'];
			}*/
		//print_R($vendor_id); die;



		$content = array(
			'user_id'			=> $ship_user_id,
			'order_number'		=> $intOrderNumber,
			'order_invoice'		=> $intOrderNumber,
			'user_info_id'		=> $ship_user_id,
			'order_total'		=> $this->session->userdata('total_amount'),
			/*'order_currency'	=> $this->session->userdata('currencysymbol'),
			'order_currencyrate'=> $this->session->userdata('currencyrate'),
			'order_currencycode'=> $this->session->userdata('currencycode'),*/
			'order_status'		=> $order_status,
			'paymentmode'		=> $paymentmode,
			'additionalcharge'  => $additionalamt,
			'cdate'				=> date('Y-m-d H:i:s'),
			'payment_status'	=> $payment_status,
			'coupondiscount'	=> $this->session->userdata('discount_amount'),
			'coupon_code'		=> $coupancode,
			'coup_name'			=> $coupanname,
			'shippingcost'		=> $this->session->userdata('shipping_cost'),
			'ip_address'		=> $_SERVER['REMOTE_ADDR'],
			'vendor_id'	    	=> implode(',', $vendor_id),
			'distributor_id'	=> $distributor_id,
			'is_customer' => 2,
		);

		$productdetailmail = '';
		$arrOrderId = $this->bilship_model->saveOrderInDatabase($content, $this->session->userdata('order_number'));
		$i = 1;
		$productdetailmail .= "<table cellpadding='5' style='border-top:2px solid #000;width: 600px;text-align: center;'>";
		$productdetailmail .= "<tr>
							<th>Sr.No</th>
							<th>Product Name</th>
							<th>Quantity</th>
							<th>Price</th> 
							<th>Total</th> 	
							</tr>";
		$pvalue = '0';
		$userid =  $this->session->userdata('userid');

		foreach ($this->cart->contents() as $arrRowDeailts) {
			$arrProddetails = $this->bilship_model->getproddetails($arrRowDeailts['id']);
			$product_id = $arrProddetails->id;
			$arrData = array(
				'order_id' => $arrOrderId,
				'user_info_id' => $ship_user_id,
				'product_id' => $product_id,
				'bpcl_special_price' => $arrProddetails->bpcl_special_price,
				'billing_price' => $arrProddetails->billing_price,
				'distributorpay' => $arrProddetails->distributorpay,
				'deliverypay' => $arrProddetails->deliverypay,
				'bpclpay' => $arrProddetails->bpclpay,
				'package' => '1',

				'order_item_name' => $arrRowDeailts['name'],
				'product_quantity' => $arrRowDeailts['qty'],
				'product_item_price' => $arrRowDeailts['price'],

				'base_image' => $arrRowDeailts['options']['base_image'],
				'material' => $arrRowDeailts['options']['material_type'],
				'material_code' => $arrRowDeailts['options']['material_code'],
				'realprice' => $arrRowDeailts['options']['mrp'],
				'vendor_id' => $arrRowDeailts['options']['vendor_id'],
				'distributor_id' => $_POST['distributorid'], //$arrRowDeailts['options']['distributor_id'],
				'cdate' => date('Y-m-d'),
				'is_customer' => 2,
			);

			$this->bilship_model->saveOrderFromCart($arrData);

			$productdetailmail .= " 
						<tr>
							<td>" . $i . "</td>
							<td>" . $arrRowDeailts['name'] . "</td>							
							<td>" . $arrRowDeailts['qty'] . "</td>
							<td><i class='fa fa-inr' aria-hidden='true'></i>  " . round($arrRowDeailts['price']) . "</td>";
			$i++;
			$pvalue = ($pvalue + (($arrRowDeailts['price']) * $arrRowDeailts['qty']));
			$productdetailmail .= " 
					<td> <i class='fa fa-inr' aria-hidden='true'></i> " . round(($arrRowDeailts['price']) * $arrRowDeailts['qty']) . "</td>";
			$productdetailmail .= "</tr>
					";

			$distributor_id = $arrRowDeailts['options']['distributor_id'];
		}

		$productdetailmail .= "</table></br></br>";
		$username = $this->session->userdata('name');
		$message = '<div style="width:600px; height:auto; margin:0 auto;">
				<img src="' . $this->config->item('base_url_views') . '/customer/images/logo-new.png" style="height:auto; margin-left:170px;">
					<p>Hello ' . $username . ',</p>
					<p>Your Order No ' . $this->session->userdata('order_number') . ' is being processed.</p>
					<p> Order ID: ' . $arrOrderId . '</p>
					';

		$message .= $productdetailmail;
		$message .= "  
										
				<table align='right'> 		 	 
				<tr><td>Sub Total Amount: </td><td><i class='fa fa-inr' aria-hidden='true'></i>  " . round($pvalue) . "</td></tr>";

		if ($this->session->userdata('coupancode') != "") {
			$message .= "<tr><td>Coupon Discount :</td><td> <i class='fa fa-inr' aria-hidden='true'></i> " . round($this->session->userdata('discount_amount')) . "</td></tr>";
		}
		if ($this->session->userdata('shipping_cost') != "0") {
			$message .= "<tr><td>Shipping Charge  :</td><td> <i class='fa fa-inr' aria-hidden='true'></i> " . round($this->session->userdata('shipping_cost')) . "</td></tr>";
		}
		$message .= "<tr><td>Total Amount: </td><td><i class='fa fa-inr' aria-hidden='true'></i> " . round($this->session->userdata('total_amount')) . "</td></tr>";
		$message .= '</table> ';

		$message .= "<table> 
			<tr>
				</br></br></br></br></br>
					<td>						
					<table> 
						<th align='left'>Shipping Address: </th>
						<tr><td><b>Name</b> : " . $shippaddress['first_name'] . "</td></tr>
						<tr><td>" . $shippaddress['address1'] . ",</td></tr>
						<tr><td> " . $shippaddress['city'] . "-" . $shippaddress['post_code'] . ",</td></tr>					
							<tr><td>" . $shippaddress['state'] . ",</td></tr>																								
						<tr><td>Mo - " . $shippaddress['phone_number'] . "</td></tr>
						<tr><td>Email - " . $this->session->userdata("email") . "</td></tr>
					</table>
					</td>
				</tr>
				</table>";

		$message .= '</div></div>';


		//echo $message; die;

		$user_details = $this->home_model->sellernamedetails($distributor_id);

		$to = $this->session->userdata('email');
		$subject  = 'Thank you for shopping from bpsmart.in';
		$subject_distributor  = 'You have received an order from bpsmart.in';
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From:bpsmart.in <info@bpsmart.in>' . "\r\n" .
			'Reply-To: info@bpsmart.in' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
		$headers .= 'Cc: info@bpsmart.in' . "\r\n";

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From:bpsmart.in <info@bpsmart.in>' . "\r\n" .
			'Reply-To: info@bpsmart.in' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
		$headers .= 'Cc: info@bpsmart.in' . "\r\n";

		mail($user_details->email, $subject_distributor, $message, $headers);
		mail('amvisolution@gmail.com', $subject, $message, $headers);
		mail($to, $subject, $message, $headers);

		$this->cart->destroy();
		// redirect($this->config->item('base_url') . 'Billship/customerthanks/' . $intOrderNumber);
		redirect($this->config->item('base_url') . 'home/distributor_customer_my_order');
	}

	function redirectPaymentGateway()
	{ }


	function paytm($token = '')
	{
		$data['err_msg'] = "";
		$data['token'] = $token;
		$data['amount'] = $this->session->userdata("total_amount");
		$data['name'] = $this->session->userdata("name");
		$data['email'] = $this->session->userdata("email");
		$data['orderid'] = $this->session->userdata("order_number");
		$data['base_url_views'] = $this->config->item("base_url_views");
		$this->load->view('paytm.php', $data);
	}

	function rozarpay()
	{
		$data['err_msg'] = "";
		$data['amount'] = ($this->session->userdata('total_amount') * 100);
		$data['name']   = $this->session->userdata('name');
		$data['email']  = $this->session->userdata("email");
		$this->load->view('rozarpay.php', $data);
	}

	function paypal()
	{
		/*
				$data['err_msg'] = "";	
				$data['amount'] = round(($this->session->userdata('total_amount') / $this->session->userdata('currencyrate')));	
				$data['name']   = $this->session->userdata('name');	
				$data['email']  = $this->session->userdata("email");
				$data['orderid']  = $this->session->userdata('order_number');
				$data['currencycode']  = $this->session->userdata('currencycode');
				$this->load->view('paypal.php',$data);	
			*/
		redirect($this->config->item('base_url') . 'billship/success');
	}

	function rozarpayupdate($id)
	{
		$intOrderNumber  = $this->session->userdata('order_number');
		$data['payment_status'] = 'Success';
		$data['transactionid'] = $id;
		$data['orderid'] = $intOrderNumber;
		$this->bilship_model->rozarpayupdate($data);
		$this->conform();
		redirect($this->config->item('base_url') . 'billship/thanks/' . $intOrderNumber);
	}

	/*function cancel()
	{
		redirect($this->config->item('base_url').'Billship/thanks/0'); 
	}*/
	function success($order_id)
	{
		//print_r($this->cart->contents());die;
		$saveP = explode('|', $_POST['msg']);

		$updaterecord = array(
			'transactionid' => $_POST['txn_id'],
			'payment_status' => 'Success',
			'order_status' => 'P',
			'response_message' => 'paypal'
		);
		//$checktxnid = $this->bilship_model->check_txnid($order_id);
		$additionalamt = '0';
		if ($saveP['14'] == '0300') {
			$this->bilship_model->updatepaymentstatus($order_id, $saveP['2'], 'Success', 'P');
			$this->conform($order_id);
		}
		redirect($this->config->item('base_url') . 'Billship/thanks/' . $order_id);
	}

	function paytmsuccesscustomer()
	{

		if ($this->input->post('STATUS') == 'TXN_SUCCESS') {

			$arrData11['ccpaymentresponse'] = '';
			$order_status = "Success";
			$arrData11['order_id'] = $order_id = $this->session->userdata('order_number');
			$arrData11['transactionid'] = $this->input->post('TXNID');
			$arrData11['order_status'] = 'C';
			$arrData11['payment_status'] = '1';
			$arrData11['epgtransactionid'] = $this->input->post('BANKTXNID');


			$this->bilship_model->updatepaymentstatus($order_id, $arrData11['transactionid'], 'Success', 'P');

			//$this->bilship_model->adminordernotification();
			redirect($this->config->item('base_url') . 'billship/customerthanks/' . $arrData11['order_id']);
		} else {
			$this->session->set_userdata('transactionid', $this->input->post('TXNID'));
			redirect($this->config->item('base_url') . 'billship/customercancel/');
		}
	}

	function paytmsuccess()
	{



		if ($this->input->post('STATUS') == 'TXN_SUCCESS') {

			$arrData11['ccpaymentresponse'] = '';
			$order_status = "Success";
			$arrData11['order_id'] = $order_id = $this->session->userdata('order_number');
			$arrData11['transactionid'] = $this->input->post('TXNID');
			$arrData11['order_status'] = 'C';
			$arrData11['payment_status'] = '1';
			$arrData11['epgtransactionid'] = $this->input->post('BANKTXNID');


			$this->bilship_model->updatepaymentstatus($order_id, $arrData11['transactionid'], 'Success', 'P');

			//$this->bilship_model->adminordernotification();
			redirect($this->config->item('base_url') . 'billship/thanks/' . $order_id);
		} else {
			$this->session->set_userdata('transactionid', $this->input->post('TXNID'));
			redirect($this->config->item('base_url') . 'billship/cancel');
		}
	}

	function conform($order_id)
	{

		//echo $order_id; die;
		/*if($this->cart->total_items() > 0)
				{ 	
					foreach($this->cart->contents() as $items)  
					{
						$this->bilship_model->updatestock($items['options']['attribute_id'],$items['qty']);
					}
				}*/


		//$order_id = $this->session->userdata('order_number');
		$productdetailmail = '';
		$i = 1;
		$productdetailmail .= "<table cellpadding='5' style='border-top:2px solid #000;width: 600px;text-align: center;'>";
		$productdetailmail .= "<tr>
							<th>Sr.No</th>
							<th>Product Name</th>
							<th>Quantity</th>
							<th>Price</th> 
							<th>Total</th> 	
							</tr>";
		$pvalue = '0';
		$userid =  '4';
		//echo $userid; die;
		foreach ($this->cart->contents() as $arrRowDeailts) {

			$productdetailmail .= " 
						<tr>
							<td>" . $i . "</td>
							<td>" . $arrRowDeailts['name'] . "</td>
							
							<td>" . $arrRowDeailts['qty'] . "</td>						
							
							
							<td><i class='fa fa-inr' aria-hidden='true'></i> " . round($arrRowDeailts['price']) . "</td>";


			$i++;
			$pvalue = ($pvalue + (($arrRowDeailts['price']) * $arrRowDeailts['qty']));
			$productdetailmail .= " 
					<td> <i class='fa fa-inr' aria-hidden='true'></i> " . round(($arrRowDeailts['price']) * $arrRowDeailts['qty']) . "</td>";
			$productdetailmail .= "</tr>
					";
		}

		$productdetailmail .= "</table></br></br>";
		$username = $this->session->userdata('name');
		$message = '<div style="width:600px; height:auto; margin:0 auto;">
				<img src="' . $this->config->item('base_url_views') . '/customer/images/logo-new.png" style="height:auto; margin-left:170px;">
					<p>Hello ' . $username . ',</p>
					<p>Your Order No ' . $this->session->userdata('order_number') . ' is being processed.</p>
					<p> Order ID: ' . $order_id . '</p>
					';

		$message .= $productdetailmail;
		$message .= "  
										
				<table align='right'> 		 	 
				<tr><td>Sub Total Amount: </td><td> " . round($pvalue) . "</td></tr>";

		if ($this->session->userdata('coupancode') != "") {
			$message .= "<tr><td>Coupon Discount :</td><td> <i class='fa fa-inr' aria-hidden='true'></i> " . round($this->session->userdata('discount_amount')) . "</td></tr>";
		}
		if ($this->session->userdata('shipping_cost') != "0") {
			$message .= "<tr><td>Shipping Charge  :</td><td> <i class='fa fa-inr' aria-hidden='true'></i> " . round($this->session->userdata('shipping_cost')) . "</td></tr>";
		}
		$message .= "<tr><td>Total Amount: </td><td><i class='fa fa-inr' aria-hidden='true'></i> " . round($this->session->userdata('total_amount')) . "</td></tr>";
		$message .= '</table> ';
		$shippaddress = $this->bilship_model->getorderadd($order_id, $userid);
		//$getcountryname = $this->bilship_model->getcountryname($shippaddress->country);						
		$message .= "<table> 
			<tr>
				</br></br></br></br></br>
					<td>						
					<table> 
						<th align='left'>Shipping Address: </th>
						<tr><td><b>Name</b> : " . $shippaddress->first_name . " " . $shippaddress->last_name . "</td></tr>
						<tr><td>" . $shippaddress->address1 . ",</td></tr>
						<tr><td>" . $shippaddress->address2 . ",</td></tr>						
						<tr><td> " . $shippaddress->city . "-" . $shippaddress->post_code . ",</td></tr>
						<tr><td>" . $shippaddress->state . ",</td></tr>
						<tr><td>Mo - " . $shippaddress->phone_number . "</td></tr>
						<tr><td>Email - " . $this->session->userdata("email") . "</td></tr>
					</table>
					</td>
				</tr>
				</table>";

		$message .= '</div></div>';
		//echo $message; die;
		$to = $this->session->userdata('email');
		$subject = "Thank you for shopping with bpsmart.in";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From:bpsmart.in <info@bpsmart.in>' . "\r\n" .
			'Reply-To: info@bpsmart.in' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
		$headers .= 'Cc: info@bpsmart.in' . "\r\n";

		mail('patelnikul321@gmail.com', $subject, $message, $headers);

		mail($to, $subject, $message, $headers);
	}
	function thanks($id)
	{

		$this->session->unset_userdata('couponid');
		$this->session->unset_userdata('coupanname');
		$this->session->unset_userdata('coupancode');
		$this->session->unset_userdata('discount');
		$this->session->unset_userdata('coupanvalue');
		$this->session->unset_userdata('discount_amount');
		$this->session->unset_userdata('total_amount');
		$this->session->unset_userdata('order_number');
		$this->cart->destroy();

		$data['L_strErrorMessage'] = "";
		$data['err_msg'] = "";
		$data['id'] = $id;
		$this->load->view('distributor_thanku', $data);
	}

	function cancel()
	{
		$data = array();

		$data['L_strErrorMessage'] = "";
		$data['err_msg'] = "";
		$data['id'] = 0;
		$this->load->view('distributor_thanku', $data);
	}

	public function sms($mobile, $message)
	{

		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "http://api.msg91.com/api/sendhttp.php?sender=OROFIT&route=4&mobiles=$mobile&authkey=165310ALWwOvYqYmwa596904f0&country=91&message=$message",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => 0,
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
	}


	function successCustomer($order_id)
	{
		//print_r($this->cart->contents());die;
		$saveP = explode('|', $_POST['msg']);
		/*echo "<pre>";
				print_r($_POST['msg']); die;*/
		$updaterecord = array(
			'transactionid' => $_POST['txn_id'],
			'payment_status' => 'Success',
			'order_status' => 'P',
			'response_message' => 'paypal'
		);
		//$checktxnid = $this->bilship_model->check_txnid($order_id);
		$additionalamt = '0';
		if ($saveP['14'] == '0300') {
			$this->bilship_model->updatepaymentstatus($order_id, $saveP['2'], 'Success', 'P');
			$this->conform($order_id);
		}
		redirect($this->config->item('base_url') . 'Billship/customerthanks/' . $order_id);
	}

	function customerthanks($id)
	{
		$data = array();
		$this->session->unset_userdata('couponid');
		$this->session->unset_userdata('coupanname');
		$this->session->unset_userdata('coupancode');
		$this->session->unset_userdata('discount');
		$this->session->unset_userdata('coupanvalue');
		$this->session->unset_userdata('discount_amount');
		$this->session->unset_userdata('total_amount');
		$this->session->unset_userdata('order_number');
		$this->cart->destroy();

		$data['L_strErrorMessage'] = "";
		$data['err_msg'] = "";
		$data['id'] = $id;
		$this->load->view('customer/customer_thanku', $data);
	}
	function customercancel()
	{
		$data = array();
		$data['L_strErrorMessage'] = "";
		$data['err_msg'] = "";
		$data['id'] = 0;
		$this->load->view('customer/customer_thanku', $data);
	}
}
