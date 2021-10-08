<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Account extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('account_model');
		$this->load->model('home_model');
		if ($this->session->userdata('userid') == '') {
			redirect($this->config->item('base_url') . 'login');
		}
	}
	public function index()
	{
		$data['err_msg'] = '';
		$data['metatitle'] = 'My Account - Nishica';
		$data['metakeywords'] = '';
		$data['metadescription'] = '';
		$this->load->view('userdashboard', $data);
	}

	function customer_myaccount()
	{
		$data['err_msg'] = '';
		if ($this->input->post("action") == "update_profile") {
			//print_r($_POST); die;
			foreach ($_POST as $key => $value) {
				$data[$key] = $this->input->post($key);
			}
			$content['fname']  = $data['fname'];
			$content['mobile']  = $data['mobile'];
			$content['pincode']  = $data['pincode'];
			$this->account_model->update_profile($content);
			$this->session->set_flashdata('register_success', 'Profile updated successfully');
			redirect($this->config->item('base_url') . 'customer-my-account', 'location');
		}

		if ($this->input->post("action") == "update_password") {
			foreach ($_POST as $key => $value) {
				$data[$key] = $this->input->post($key);
			}
			$content['pass']  = $data['pass'];

			$this->account_model->update_password($content);
			$this->session->set_flashdata('register_success', 'Password updated successfully');
			redirect($this->config->item('base_url') . 'customer-my-account', 'location');
		}

		if ($this->input->post("action") == "add_profile") {
			foreach ($_POST as $key => $value) {
				$data[$key] = $this->input->post($key);
			}
			//$content['address_title']  = $data['address_title']; 
			$content['first_name']  = $data['first_name'];
			$content['post_code']  = $data['post_code'];
			$content['address1']  = $data['address1'];
			$content['address2']  = $data['address2'];
			$content['city']  = $data['city'];
			$content['state']  = $data['state'];
			$content['country']  = $data['country'];
			$content['phone_number']  = $data['phone_number'];

			$this->account_model->add_new_address_new($content);
			$this->session->set_flashdata('register_success', 'Address Added successfully');
			redirect($this->config->item('base_url') . 'customer-my-account', 'location');
		}

		$data['profile'] = $this->account_model->getuserdata($this->session->userdata('userid'));
		$data['orders_list'] = $this->account_model->getCustomerOrders($id = '', $status = 'Success');
		$data['getadd_all'] = $this->account_model->getadd_all($this->session->userdata('userid'));
		$data['allwishlist'] = $this->home_model->wishlist($this->session->userdata('userid'));
		$data['all_state'] = $this->home_model->all_state();
		//echo "<pre>"; print_r($data['orders_list']); die;
		$this->load->view('customer/customer_myaccount', $data);
	}

	public function profile()
	{
		$data['err_msg'] = '';
		if ($this->input->post("action") == "update_profile") {
			foreach ($_POST as $key => $value) {
				$data[$key] = $this->input->post($key);
			}
			$content['fname']  = $data['fname'];
			$content['lname'] = $data['lname'];
			$content['mobile']  = $data['mobile'];
			$content['no_gst']  = $data['no_gst'];
			$content['service_tax_no']  = $data['service_tax_no'];
			$content['company_name']  = $data['company_name'];
			$this->account_model->update_profile($content);
			$this->session->set_flashdata('profile_update', 'Profile updated successfully');
			redirect($this->config->item('base_url') . 'my-profile', 'location');
		}

		$data['profile'] = $this->account_model->getuserdata($this->session->userdata('userid'));
		/*$data['allwishlist'] = $this->account_model->wishlist($this->session->userdata('userid'));
		$data['order_detail_deliver'] = $this->account_model->order_detail_deliver($this->session->userdata('userid'));
		*/
		$this->load->view('my-account', $data);
	}

	public function changepassword()
	{
		$data['err_msg'] = '';
		if ($this->input->post("action") == "update_profile") {
			foreach ($_POST as $key => $value) {
				$data[$key] = $this->input->post($key);
			}
			$content['pass']  = $data['pass'];
			$this->account_model->changepassword($content);
			$this->session->set_flashdata('profile_update', 'Password Changed Successfully');
			redirect($this->config->item('base_url') . 'changepassword', 'location');
		}

		$data['profile'] = $this->account_model->getuserdata($this->session->userdata('userid'));
		$data['metatitle'] = 'Change Password - Nishica';
		$data['metakeywords'] = '';
		$data['metadescription'] = '';
		$this->load->view('changepassword', $data);
	}

	public function edit_address($id)
	{
		$data['err_msg'] = '';
		if ($this->input->post("action") == "update_profile") {
			foreach ($_POST as $key => $value) {
				$data[$key] = $this->input->post($key);
			}
			$content['first_name']  = $data['first_name'];
			$content['post_code'] = $data['post_code'];
			$content['address1']  = $data['address1'];
			$content['address2']  = $data['address2'];
			$content['city']  = $data['city'];
			$content['state']  = $data['state'];
			$content['country']  = $data['country'];
			$content['phone_number']  = $data['phone_number'];
			$content['add_id']  = $id;
			$this->account_model->update_address_new($content);
			$this->session->set_flashdata('register_success', 'Address Updated Successfully');
			redirect($this->config->item('base_url') . 'customer-my-account', 'location');
		}
		$data['profile'] = $this->account_model->getuserdata($this->session->userdata('userid'));
		$data['editaddress'] = $this->account_model->edit_address($id);
		$data['all_state'] = $this->home_model->all_state();
		$this->load->view('customer/edit_address', $data);
	}

	public function my_address()
	{
		$data['err_msg'] = '';
		if ($this->input->post("action") == "update_profile") {
			foreach ($_POST as $key => $value) {
				$data[$key] = $this->input->post($key);
			}
			$content['first_name']  = $data['first_name'];
			$content['last_name'] = $data['last_name'];
			$content['email_address']  = $data['email_address'];
			$content['phone_number']  = $data['phone_number'];
			$content['address']  = $data['address'];
			$content['country']  = $data['country'];
			$content['state']  = $data['state'];
			$content['city']  = $data['city'];
			$content['zip_code']  = $data['zip_code'];

			$this->account_model->add_new_address($content);
			$this->session->set_flashdata('profile_update', 'Address Added Successfully');
			redirect($this->config->item('base_url') . 'my-address', 'location');
		}
		$data['getadd_all'] = $this->account_model->getadd_all($this->session->userdata('userid'));
		$data['metatitle'] = 'My Addresses - Nishica';
		$data['metakeywords'] = '';
		$data['metadescription'] = '';
		$this->load->view('my_address', $data);
	}

	public function removeadd($id)
	{
		$this->account_model->removeadd($id);
		$this->session->set_flashdata('register_success', 'Address Deleted Successfully');
		redirect($this->config->item('base_url') . 'customer-my-account', 'location');
	}

	public function defaultaddress($id)
	{
		$this->account_model->defaultadd($id);
		$this->session->set_flashdata('register_success', 'Default Address Set Successfully');
		redirect($this->config->item('base_url') . 'customer-my-account', 'location');
	}

	public function purchase_history()
	{
		$data['err_msg'] = '';
		//$data['profile'] = $this->account_model->getuserdata($this->session->userdata('userid'));
		$data['order_detail'] = $this->account_model->order_detail($this->session->userdata('userid'));
		//$data['order_detail_past'] = $this->account_model->order_detail($this->session->userdata('userid'));
		//$data['returnandexchange'] = $this->account_model->returnandexchange($this->session->userdata('userid'));

		$data['metatitle'] = 'My Orders - Nishica';
		$data['metakeywords'] = '';
		$data['metadescription'] = '';
		$this->load->view('purchase_history', $data);
	}

	function add_reviews()
	{
		$id = $this->input->post("itemid");
		$data['productid'] = $id;
		//$data["order_detail"] = $this->vendor_model->get_product($this->session->userdata('userid'),$id);
		$html = $this->load->view('add_reviews', $data, true);
		echo $html;
	}

	function createinvoice()
	{
		$orderid = $this->input->post("itemid");
		$data['orderid'] = $orderid;
		$data["orderdetails"] = $this->account_model->getorderinvoice($orderid);

		$data["vendordetails"] = $this->account_model->vendordetails($data["orderdetails"][0]->vendor_id);
		$data["ship_address"] = $this->account_model->ship_address($orderid);
		$data['profile'] = $this->account_model->getuserdata($this->session->userdata('userid'));
		$html = $this->load->view('invoice', $data, true);
		echo $html;
	}
	function createinvoice_vendor()
	{
		$orderid = $this->input->post("itemid");
		$data['panel'] = $this->input->post("panel");
		$data['orderid'] = $orderid;
		$data["orderdetails"] = $this->account_model->getorderinvoice($orderid);
		//print_r($data["orderdetails"]);die;
		$data["vendordetails"] = $this->account_model->vendordetails($data["orderdetails"][0]->distributor_id);
		$data['ccno'] = $this->account_model->getccno($this->session->userdata("userid"));
		$data["ship_address"] = $this->account_model->ship_address($data["orderdetails"][0]->order_id);
		$data['profile'] = $this->account_model->getuserdata($data["orderdetails"][0]->user_id);
		$html = $this->load->view('invoice', $data, true);
		echo $html;
	}

	function createinvoice_vendor_sp()
	{
		$orderid = $this->input->post("itemid");
		$data['panel'] = $this->input->post("panel");
		$data['orderid'] = $orderid;
		$data["orderdetails"] = $this->account_model->getorderinvoice($orderid);
		//print_r($data["orderdetails"]);die;
		$data["vendordetails"] = $this->account_model->vendordetails($data["orderdetails"][0]->distributor_id);
		$data['ccno'] = $this->account_model->getccno($this->session->userdata("userid"));
		$data["ship_address"] = $this->account_model->ship_address($data["orderdetails"][0]->order_id);
		$data['profile'] = $this->account_model->getuserdata($data["orderdetails"][0]->user_id);
		$html = $this->load->view('invoiceSp', $data, true);
		echo $html;
	}

	function track_package()
	{
		$id = $this->input->post("itemid");
		$data['productid'] = $id;
		$data["order_detail"] = $this->account_model->getorderitem($id);
		$data['schedulepickuparray'] = array();
		if ($data["order_detail"]->api_booking_id != '') {
			$this->load->library('shipping');
			$id = $data["order_detail"]->api_booking_id;
			$postfields['order_ids'] = $id;
			$result = $this->shipping->deliveredstatus($postfields);
			$schedulepickuparray = json_decode($result);
			$data['schedulepickuparray'] = $schedulepickuparray;
		}

		//print_r($schedulepickuparray); die;

		$html = $this->load->view('track_package', $data, true);
		echo $html;
	}

	function cancelproduct()
	{
		$id = $this->input->post("itemid");
		$data['productid'] = $id;
		$data["order_detail"] = $this->account_model->getorderitem($id);
		$data['schedulepickuparray'] = array();
		$html = $this->load->view('cancel_package', $data, true);
		echo $html;
	}

	function savecancelproduct()
	{
		$data['user_id'] = $this->input->post('user_id');
		$data['productid'] = $this->input->post('productid');
		$data['orderitemid'] = $this->input->post('orderitemid');
		$data['orderid'] = $this->input->post('orderid');
		$data['description'] = $this->input->post('description');
		$data['added_date'] = date('Y-m-d');

		$orderdetails = $this->account_model->order_product_item_1($data['orderitemid']);

		$this->account_model->savecancelproduct($data);

		$message = '<!doctype html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Reviews Submitted Email </title>
	<style>
		@import url("https://fonts.googleapis.com/css?family=Lato");
	</style> 
</head>
<body style="text-align: center;margin: 0;background: #ececec; font-family: "Lato", sans-serif;font-weight: 100;">
	<div style="max-width:630px;margin: 0 auto;border: thin solid #f3f0f0;background: #fff; border:1px solid #ccc">
		<div style="float: left; width: 100%; border-bottom:1px solid #ccc">
		<a href="' . $this->config->item('base_url') . '"><img src="' . $this->config->item('base_url_views') . 'images/logo2-hori.png" style="margin-top:20px;max-width:200px;"></a>
		</div>
		<div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Dear ' . ucfirst($this->session->userdata("fname")) . ',</p>
			
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Your cancel request for the product ' . $orderdetails->order_item_name . ' has been raised. Our team will contact your shortly.</p>
		</div>
		<div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Have a Fabulous Day!<BR>
Team Nishica</p><br>
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Need Help?<br>
			<a href="' . $this->config->item('base_url') . 'contact-us" style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Contact 24x7 Help & Support</a></p>
		</div>
		<div style="clear: both">
	</div></div>
</body>
</html>';

		$subject = "Cancel Request for Product - " . $orderdetails->order_item_name . " ";
		$to = $this->session->userdata('email');

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From:Nishica.in <info@nishica.com>' . "\r\n" .
			'Reply-To: info@nishica.com' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
		$headers .= 'Cc: info@nishica.com' . "\r\n";
		mail($to, $subject, $message, $headers);

		$to = $this->config->item('customercare_email');
		mail($to, $subject, $message, $headers);

		$this->session->set_flashdata('profile_update', 'Your cancel request has been sent successfully. Our team will contact you shortly.');
		redirect($this->config->item('base_url') . 'purchase-history', 'location');
	}


	function save_add_reviews()
	{

		//print_r($_POST); die;
		$data['user_id'] = $this->input->post('user_id');
		$data['product_id'] = $this->input->post('product_id');
		$data['starrating'] = $this->input->post('starrating');
		$data['description'] = $this->input->post('description');
		$data['added_date'] = date('Y-m-d');
		$this->account_model->save_add_reviews($data);

		$message = '<!doctype html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Reviews Submitted Email </title>
	<style>
		@import url("https://fonts.googleapis.com/css?family=Lato");
	</style> 
</head>
<body style="text-align: center;margin: 0;background: #ececec; font-family: "Lato", sans-serif;font-weight: 100;">
	<div style="max-width:630px;margin: 0 auto;border: thin solid #f3f0f0;background: #fff; border:1px solid #ccc">
		<div style="float: left; width: 100%; border-bottom:1px solid #ccc">
		<a href="' . $this->config->item('base_url') . '"><img src="' . $this->config->item('base_url_views') . 'images/logo2-hori.png" style="margin-top:20px;max-width:200px;"></a>
		</div>
		<div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Dear ' . ucfirst($this->session->userdata("fname")) . ',</p>
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">We thank you for your review! Comments may be moderated, so if you don\'t see your comment, please be patient. You will be notified as soon as Its posted.</p>
		</div>
		<div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Have a Fabulous Day<BR>
Team Nishica</p><br>
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Need Help?<br>
			<a href="' . $this->config->item('base_url') . 'contact-us" style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Contact 24x7 Help & Support</a></p>
		</div>
		<div style="clear: both">
	</div></div>
</body>
</html>';

		$subject = "Thank You for Your Review.";
		$to = $this->session->userdata('email');

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From:Nishica<info@nishica.com>' . "\r\n" .
			'Reply-To: info@nishica.com' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
		$headers .= 'Cc: info@nishica.com' . "\r\n";

		mail($to, $subject, $message, $headers);

		$to = $this->config->item('review_email');
		mail($to, $subject, $message, $headers);

		$this->session->set_flashdata('profile_update', 'Reviews Added Successfully');
		redirect($this->config->item('base_url') . 'purchase-history', 'location');
	}

	public function wishlist()
	{
		$data['err_msg'] = '';
		$data['allwishlist'] = $this->account_model->wishlist($this->session->userdata('userid'));
		$data['metatitle'] = 'My Wishlist - Nishica';
		$data['metakeywords'] = '';
		$data['metadescription'] = '';
		$this->load->view('wishlist', $data);
	}

	public function cancel_product($order_item_id, $orderid)
	{
		$this->account_model->cancel_product($order_item_id, $orderid);
		$data["order1"] = $this->account_model->getOrders($orderid);
		$total = 0;
		foreach ($data["order1"] as $item) {
			if ($item->is_cancel == 0) {
				$total += $item->product_item_price * $item->product_quantity;
			}
		}

		$this->account_model->cancel_ordertable($orderid, $total);
		$data["cancelid"] = $order_item_id;


		$message = '<!doctype html><html lang="en"><head>
	<title>Order Cancelled</title>
	<style>
		@import url("https://fonts.googleapis.com/css?family=Lato");
	</style> </head><body style="text-align: center;margin: 0;background: #ececec; font-family: "Lato", sans-serif;font-weight: 100;">
	<div style="max-width:630px;margin: 0 auto;border: thin solid #f3f0f0;background: #fff; border:1px solid #ccc">
		<div style="float: left; width: 100%; border-bottom:1px solid #ccc; text-align:center">
		<a href="' . $this->config->item('base_url') . '"><img src="' . $this->config->item('base_url_views') . 'images/logo2-hori.png" style="margin-top:20px;max-width:200px;"></a>
		</div>
		<div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
			<h3 style="color: #000; font-size: 21px;">Your order is Cancelled.</h3>
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Hi there!</p>
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">As requested, your order has been cancelled. The details of the cancelled items are given below.</p>
		</div>
		<div  style="padding: 20px 4%;font-size: 14px;text-align: left;float: left; width: 92%">
		<p style="text-align: left;text-align: left;border-bottom: 1px solid #727171;padding-bottom: 4px;"><strong>Item Cancelled</strong></p>
			<table style="border-collapse: collapse;width: 100%;">';

		$arrProddetails = $this->account_model->cancel_product_details($order_item_id);

		$message .= '<tr style="border-bottom: 1px solid #CCCECF;">
					<td style="width: 85px;padding-bottom: 10px;vertical-align: top;">
						<img src="' . $this->config->item('http_host') . '/upload/products/medium/' . $arrProddetails->base_image . '" style="max-width:100%;height:97px;" />
					</td>
					<td style="text-align: left;vertical-align: top;padding-left: 15px;padding-bottom: 10px;">
						<p style="margin: 0;"><strong>' . $arrProddetails->order_item_name . '</strong></p>';
		if ($arrProddetails->size_name != '') {
			$message .= '<p style="margin: 0;">
							<span style="color:gray;">Variant:</span> ' . $arrProddetails->size_name . '
						</p>';
		}
		$message .= '<p style="margin: 0;">
							<span style="color:gray;">Quantity:</span> ' . $arrProddetails->product_quantity . '
						</p><br>
						<p style="margin: 0;"><strong></strong></p>
					</td>
					<td style="vertical-align: top;width: 150px;text-align: right;padding-bottom: 10px;">Rs.: ' . round($arrProddetails->product_item_price) . ' </td>
				</tr>';
		$message .= '</table>
		</div>	 
 		<div style="float: left; width: 92%;padding: 10px 4%;text-align: left;">
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;margin: 0;">Have a Fabulous Day<BR>
Team Nishica</p><br>
			<p style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Need Help?<br>
			<a href="' . $this->config->item('base_url') . 'contact-us" style="font-size: 16px;line-height: 30px;color: #58595B;font-family: "Lato", sans-serif;font-weight: 100;     margin: 0;">Contact 24x7 Help & Support</a></p>
		</div>
		<div style="clear: both">
	</div></div>
</body>
</html>';

		//echo $message; die; 
		$to = $this->session->userdata('email');
		$subject  = 'Order Product Cancelled';
		$AddAttachment = array();
		$this->mailsent($to, $subject, $message, $addcc, $AddAttachment);
		$sellerdetails = $this->account_model->sellerdetails($arrProddetails->vendor_id);

		$to = $sellerdetails->email;
		$this->mailsent($to, $subject, $message, $addcc, $AddAttachment);

		$to = $this->config->item('info_email');
		$this->mailsent($to, $subject, $message, $addcc, $AddAttachment);

		$this->session->set_flashdata('profile_update', 'Product Cancelled successfully.');
		redirect($this->config->item('base_url') . 'purchase-history');
	}

	function delete_wishlist($deleteid)
	{
		$data['L_strErrorMessage'] = "";
		$data['err_msg'] = "";
		if ($this->account_model->delete_wishlist($deleteid)) {
			$this->session->set_flashdata('profile_update', 'Product removed from Wishlist Successfully!');
		}
		redirect($this->config->item('base_url') . 'customer-my-account', 'location');
	}

	function return_order()
	{
		if ($this->input->post("action") == "update_return") {

			$content['order_id']  = $this->input->post("order_id");
			$content['return_id']  = $this->input->post("return_id");
			$content['return_reasons']  = $this->input->post("return_reasons");
			$content['return_comment']  = $this->input->post("return_comment");
			$data = $this->account_model->order_product_item($this->input->post("return_id"));

			$message = '';
			$message .= '<!doctype html>
                    <html>
                        <head>
                            
                            <title>Registration Email</title>

                            <style>
                                .logo {
                                    text-align: center;
                                    width: 100%;
                                }
                                .wrapper {
                                    width: 100%;
                                    max-width:500px;
                                    margin:auto;
                                    font-size:14px;
                                    line-height:24px;
                                    font-family:Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;
                                    color:#555;
                                }
                                .wrapper div {
                                    height: auto;
                                    float: left;
                                    margin-bottom: 15px;
                                }
                                .text-center {
                                    text-align: center;
                                }
                                .email-wrapper {
                                    padding:5px;
                                    border:1px solid #ccc;
                                }
                                .big {
                                    text-align: center;
                                    font-size: 26px;
                                    color: #e31e24;
                                    font-weight: bold;
                                    margin-bottom: 0 !important;
                                    text-transform: uppercase;
                                    line-height: 34px;
                                }
                                .welcome {
                                    font-size: 17px;
                                    font-weight: bold;
                                }
                                .footer {
                                    text-align: center;
                                    color: #999;
                                    font-size: 13px;
                                }
                            </style>
                        </head>

                        <body>
                            <div class="wrapper">
                                <div class="logo">
                                    <img src="' . $this->config->item('base_url_views') . 'images/logo.png" >
                                </div>
                                <div class="email-wrapper">

                                    <table style="border-collapse:collapse;" width="100%" border="0" cellspacing="0" cellpadding="10">
                                        <tr>
                                            <td>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="5">
                                                    <tr>
                                                        <td style="font-size:18px;">
                                                            Return Request
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Order <a style="text-decoration:none; color:#cc0000;" href="#">#' . $content['order_id'] . '</a></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="5">
                                                    <tr>
                                                        <td style="font-size:18px;">Hello </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="line-height:20px;">
                                                            Request for return.
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td style="line-height:20px;">
                                                            Reasons :' . $content['return_reasons'] . '
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td style="line-height:20px;">
                                                            Comment : ' . $content['return_comment'] . '
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>


                                        <tr>
                                            <td>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="5">
                                                    <tr>
                                                        <td align="center" style="font-size:18px;">Product Details</td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <table style="border-top:1px solid #ccc; border-collapse:collapse;" width="100%" border="0" cellspacing="0" cellpadding="8">
                                                                <!--loop tr-->';

			$message .= '<tr style="border-bottom:1px solid #ccc;">

                                                                    <td align="center">';
			$message .= '<img src="' . $this->config->item('http_host') . '/upload/products/medium/' . $data->base_image . '" alt="" title="" height="50" width="50">';
			$message .= '</td>
                                                                    <td>
                                                                        ' . $data->order_item_name . '
                                                                    </td>
                                                                    <td>
                                                                        ' . $data->size_name . '
                                                                    </td>
                                                                    <td>
                                                                        ' . $data->colour_name . '
                                                                    </td>
                                                                    <td>
                                                                        ' . $data->product_quantity . '
                                                                    </td>
                                                                    <td align="right">
                                                                        ' . number_format(($data->product_item_price * $data->product_quantity), 2) . '
                                                                    </td>
                                                                </tr>';
			$message .= '<!--loop tr-->
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>


                                        <tr>
                                            <td>We hope to see you again soon!</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold;">http://statusquo.com/</td>
                                        </tr>
                                    </table>
                                </div>
                                <!--<div class="footer">
                                    F-19, Nanddham Industrial Estate, Marol Maroshi Road, Andheri East, Mumbai- 400059
                                    <br>
                                    Tel: 022-65560001 &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; email: info@purpletuche.com
                                    <br>
                                    For further queries, you can email us at info@purpletuche.com
                                </div>-->
                            </div>
                        </body>
                    </html>';
			$to = 'amvisolution@gmail.com';
			$subject  = 'Product Return Request';
			$addcc = array($data->email, 'online@statusquo.in');
			$AddAttachment = array();
			$this->mailsent($to, $subject, $message, $addcc, $AddAttachment);
			$this->account_model->update_return_order($content);
			$this->session->set_flashdata('profile_update', 'Your request has been sent successfully.');
			redirect($this->config->item('base_url') . 'account', 'location');
		}
	}

	function exchange_order()
	{
		if ($this->input->post("action") == "update_exchange") {
			$content['order_id']  = $this->input->post("order_id");
			$content['exchange_id']  = $this->input->post("exchange_id");
			$content['exchange_comment']  = $this->input->post("exchange_comment");
			$content['size']  = $this->input->post("size" . $this->input->post("order_id"));
			$this->account_model->update_exchange_order($content);
			$sizename = $this->account_model->order_size($this->input->post("size" . $this->input->post("order_id")));

			$data = $this->account_model->order_product_item($this->input->post("exchange_id"));

			$message = '';
			$message .= '<!doctype html>
                    <html>
                        <head>
                            
                            <title>Registration Email</title>

                            <style>
                                .logo {
                                    text-align: center;
                                    width: 100%;
                                }
                                .wrapper {
                                    width: 100%;
                                    max-width:500px;
                                    margin:auto;
                                    font-size:14px;
                                    line-height:24px;
                                    font-family:Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;
                                    color:#555;
                                }
                                .wrapper div {
                                    height: auto;
                                    float: left;
                                    margin-bottom: 15px;
                                }
                                .text-center {
                                    text-align: center;
                                }
                                .email-wrapper {
                                    padding:5px;
                                    border:1px solid #ccc;
                                }
                                .big {
                                    text-align: center;
                                    font-size: 26px;
                                    color: #e31e24;
                                    font-weight: bold;
                                    margin-bottom: 0 !important;
                                    text-transform: uppercase;
                                    line-height: 34px;
                                }
                                .welcome {
                                    font-size: 17px;
                                    font-weight: bold;
                                }
                                .footer {
                                    text-align: center;
                                    color: #999;
                                    font-size: 13px;
                                }
                            </style>
                        </head>

                        <body>
                            <div class="wrapper">
                                <div class="logo">
                                    <img src="' . $this->config->item('base_url_views') . 'images/logo.png" >
                                </div>
                                <div class="email-wrapper">

                                    <table style="border-collapse:collapse;" width="100%" border="0" cellspacing="0" cellpadding="10">
                                        <tr>
                                            <td>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="5">
                                                    <tr>
                                                        <td style="font-size:18px;">
                                                            Exchange Request
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Order <a style="text-decoration:none; color:#cc0000;" href="#">#' . $content['order_id'] . '</a></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="5">
                                                    <tr>
                                                        <td style="font-size:18px;">Hello </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="line-height:20px;">
                                                            Request for Exchange.
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td style="line-height:20px;">
                                                            Size :' . $sizename . '
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td style="line-height:20px;">
                                                            Comment : ' . $content['exchange_comment'] . '
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>


                                        <tr>
                                            <td>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="5">
                                                    <tr>
                                                        <td align="center" style="font-size:18px;">Product Details</td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <table style="border-top:1px solid #ccc; border-collapse:collapse;" width="100%" border="0" cellspacing="0" cellpadding="8">
                                                                <!--loop tr-->';

			$message .= '<tr style="border-bottom:1px solid #ccc;">

                                                                    <td align="center">';
			$message .= '<img src="' . $this->config->item('http_host') . '/upload/products/medium/' . $data->base_image . '" alt="" title="" height="50" width="50">';
			$message .= '</td>
                                                                    <td>
                                                                        ' . $data->order_item_name . '
                                                                    </td>
                                                                    <td>
                                                                        ' . $data->size_name . '
                                                                    </td>
                                                                    <td>
                                                                        ' . $data->colour_name . '
                                                                    </td>
                                                                    <td>
                                                                        ' . $data->product_quantity . '
                                                                    </td>
                                                                    <td align="right">
                                                                        ' . number_format(($data->product_item_price * $data->product_quantity), 2) . '
                                                                    </td>
                                                                </tr>';
			$message .= '<!--loop tr-->
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>


                                        <tr>
                                            <td>We hope to see you again soon!</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold;">http://statusquo.com/</td>
                                        </tr>
                                    </table>
                                </div>
                                <!--<div class="footer">
                                    F-19, Nanddham Industrial Estate, Marol Maroshi Road, Andheri East, Mumbai- 400059
                                    <br>
                                    Tel: 022-65560001 &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; email: info@purpletuche.com
                                    <br>
                                    For further queries, you can email us at info@purpletuche.com
                                </div>-->
                            </div>
                        </body>
                    </html>';

			$to = 'amvisolution@gmail.com';
			$subject  = 'Product Exchange Request';
			$addcc = array($data->email, 'online@statusquo.in');
			$AddAttachment = array();
			$this->mailsent($to, $subject, $message, $addcc, $AddAttachment);
			$this->session->set_flashdata('profile_update', 'Your request has been sent successfully.');
			redirect($this->config->item('base_url') . 'account', 'location');
		}
	}

	function selectsize()
	{
		$order_id = $this->input->post("order_id");
		$html = '<div class="form-group">Your Size: ' . $this->input->post("size") . '<br>';
		$all_size = $this->account_model->productsize($this->input->post("id"));
		if ($all_size != "" && count($all_size) > 0) {
			foreach ($all_size as $sizename) {
				$html .= '<label class="radio-inline">
									<input type="radio" name="size' . $order_id . '" value="' . $sizename->sizeid . '" style="height: auto;width: auto;">' . $sizename->name . '
								</label>';
			}
		}
		$html .= '</div>';
		echo $html;
	}

	function mailsent($to, $subject, $message, $addcc, $AddAttachment)
	{

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From:Nishica.in <info@nishica.com>' . "\r\n" .
			'Reply-To: info@nishica.com' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
		$headers .= 'Cc: info@nishica.com' . "\r\n";

		mail($to, $subject, $message, $headers);


		/*error_reporting(E_STRICT);

        $mail             = new PHPMailer();
        $body             = eregi_replace("[\]",'',$message);
        $mail->IsSMTP();
        $mail->SMTPAuth   = true;                  // enable SMTP authentication
        $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
        $mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
        $mail->Port       = 465;                   // set the SMTP port for the GMAIL server
        //$mail->SMTPDebug = 1;
        $mail->Username   = "amvi.himanshu@gmail.com";    // GMAIL username
        $mail->Password   = "amvi@123";     // GMAIL password
        $mail->From       = "statusquo.in";
        $mail->FromName   = "Status Quo";
        $mail->Subject    = $subject;
        $mail->MsgHTML($body);
		$mail->AddAddress($to, "");
		if($addcc !='' && count($addcc)>0)
		{
			foreach($addcc as $key=>$value)
			{
				$mail->AddCC($value);
			}
		}
		if($AddAttachment !='' && count($AddAttachment)>0)
		{
			foreach($AddAttachment as $key=>$value)
			{
				if($value !='')
				{
					$mail->AddAttachment($value);
				}
			}
		}
        $mail->IsHTML(true);
        if(!$mail->Send()) {
             echo "Mailer Error: " . $mail->ErrorInfo; 
        } else {
		    echo "Mailer Error: " . $mail->ErrorInfo;  
        }*/
	}
}

/* End of file welcome.php */

/* Location: ./system/application/controllers/welcome.php */
