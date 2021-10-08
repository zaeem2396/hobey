<?php
class Account_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	function update_profile($data)
	{
		$content['name']  = $data['fname'];
		$content['mobile']  = $data['mobile'];
		$content['pincode']  = $data['pincode'];
		$this->db->where('id', $this->session->userdata('userid'));
		if ($this->db->update('users', $content)) {
			return true;
		} else {
			return false;
		}
	}

	function getuserdata($uid)
	{
		$sql = "SELECT * from users where id='" . $uid . "'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		}
	}

	function update_password($data)
	{
		$content['password']  = $data['pass'];
		$this->db->where('id', $this->session->userdata('userid'));
		if ($this->db->update('users', $content)) {
			return true;
		} else {
			return false;
		}
	}

	public function getCustomerOrders($order_id = '', $status = '')
	{
		$this->db->join('users', 'ci_orders.user_id = users.id', 'left');
		$this->db->join('ci_shipping_address', 'ci_orders.order_id = ci_shipping_address.order_id', 'left');
		$this->db->select('users.email as user_email');
		$this->db->select('users.name as user_name');
		$this->db->select('users.mobile as user_mobile');
		//$this->db->select('users.lname as lname');
		$this->db->select('ci_orders.*');
		$this->db->select('ci_shipping_address.*');

		$this->db->where('ci_orders.user_id', $this->session->userdata('userid'));

		//$this->db->where("find_in_set('".$this->session->userdata("userid")."',ci_orders.vendor_id)");

		if ($order_id != '') {
			$this->db->where('ci_orders.order_id', $order_id);
		}
		if ($status != '') {
			if ($status == 'Success' or $status == 'FAILED') {
				$this->db->where('ci_orders.payment_status', $status);
			} else {
				$this->db->where('ci_orders.order_status', $status);
			}
		}
		$this->db->order_by('ci_orders.order_id', 'DESC');
		$order_list = $this->db->get('ci_orders')->result_array();
		//echo $this->db->last_query(); die;
		foreach ($order_list as &$order) {
			$this->db->where('order_id', $order['order_id']);
			$item_list = $this->db->get('ci_order_item')->result_array();
			$total = 0;
			$additonal_cost = 0;
			foreach ($item_list as &$item) {
				$this->db->where('id', $item['product_id']);
				$product = $this->db->get('product')->result_array();
				$total += $item['product_item_price'] * $item['product_quantity'];
				//$item['product_name'] = $product[0];
				//$pname=$product['product_name']; 
			}
			$order['items'] = $item_list;
			$order['sub_total'] = $total;
		}
		return $order_list;
	}

	function getadd_all($id)
	{
		$strQuery = "SELECT * from address_book where user_id ='" . $id . "' order by id desc";
		$result = $this->db->query($strQuery);
		if ($result->num_rows() > 0) {
			$arrRes = $result->result();
			return  $arrRes;
		}
	}

	function delete_wishlist($deleteid)
	{

		$this->db->where('id = ', $deleteid);
		if ($this->db->delete('wishlist')) {
			return true;
		} else {
			return false;
		}
	}
	/* =======================================================================================================================*/
	function getproductdetails($id)
	{
		$sql = "SELECT * from product where id='" . $id . "'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		}
	}

	function getstatename($id)
	{
		$sql = "SELECT * from state where id='" . $id . "'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row()->state;
			return $result;
		}
	}


	function update_profilea($data)
	{
		$content['fname']  = $data['fname'];
		$content['lname'] = $data['lname'];
		$content['mobile']  = $data['mobile'];
		$content['no_gst']  = $data['no_gst'];
		$content['service_tax_no']  = $data['service_tax_no'];
		$content['company_name']  = $data['company_name'];
		$this->db->where('id', $this->session->userdata('userid'));
		if ($this->db->update('users', $content)) {
			return true;
		} else {
			return false;
		}
	}

	function changepassword($data)
	{
		$content['password']  = $data['pass'];
		$this->db->where('id', $this->session->userdata('userid'));
		if ($this->db->update('users', $content)) {
			return true;
		} else {
			return false;
		}
	}

	function order_detail($uid)
	{
		$sql = "SELECT * from ci_orders where user_id='" . $uid . "' and order_status = 'C' and payment_status='1' order by order_id desc";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}
	}

	function ship_address($uid)
	{
		$sql = "SELECT * from ci_shipping_address where order_id ='" . $uid . "' ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		}
	}


	function getOrders($orderid)
	{
		$sql = "SELECT * from ci_order_item where order_id = '" . $orderid . "'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}
	}

	function getorderitem($orderid)
	{
		$sql = "SELECT * from ci_order_item where order_item_id = '" . $orderid . "'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		}
	}

	function getorderitem_bookingshipid($orderid)
	{
		$sql = "SELECT * from ci_order_item where api_booking_id = '" . $orderid . "'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		}
	}

	function trackstatus($orderid)
	{
		$sql = "SELECT * from ci_order_status where order_item_id = '" . $orderid . "'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}
	}

	function trackstatus_step($orderid, $step)
	{
		$sql = "SELECT * from ci_order_status where order_item_id = '" . $orderid . "' and status = '" . $step . "'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		}
	}


	function order_detail_deliver($uid)
	{
		$sql = "SELECT * from ci_orders where `status_date` >= DATE_SUB(CURDATE(), INTERVAL 15 DAY) and user_id='" . $uid . "' and order_status = 'D' and (paymentmode=1 or payment_status='Success') order by order_id desc";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}
	}

	function getorderinvoice($uid)
	{
		$sql = "SELECT c.*, ci.* from ci_orders as c
				LEFT JOIN ci_order_item as ci ON c.order_id=ci.order_id 
				INNER JOIN product as p ON p.id = ci.product_id 
				where c.order_id='" . $uid . "' order by c.order_id desc";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}
	}

	function vendordetails($uid)
	{
		$sql = "SELECT * from users where id ='" . $uid . "' ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		}
	}

	function getorderinvoice_vendor($uid)
	{
		$sql = "SELECT c.*, ci.* from ci_orders as c
				LEFT JOIN ci_order_item as ci ON c.order_id=ci.order_id 
				INNER JOIN product as p ON p.id = ci.product_id 
				where ci.order_item_id='" . $uid . "' order by c.order_id desc";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}
	}

	function getccno($userid)
	{
		$sql = $this->db->select("cc_code")->from("users")->where("id", $userid)->get()->result_array();
		// var_dump($this->db->last_query());
		// exit;
		return $sql;
	}

	function returnandexchange($uid)
	{
		$sql = "SELECT c.*,ci.* from ci_orders as c
				LEFT JOIN ci_order_item as ci ON c.order_id=ci.order_id where c.user_id='" . $uid . "' and c.order_status = 'D' and ( ci.is_return = 1 OR ci.is_exchnage =1) and (c.paymentmode=1 or c.payment_status='Success') order by c.order_id desc";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}
	}

	function getproddetails($arrProddetails)
	{
		$strQuery = " SELECT p.*, ( select min(price) from product_attribute where pid = p.id ) as `minprice`, IFNULL(im.image,'noimage.jpg') as base_image FROM product p 
		            LEFT JOIN product_image im ON im.pid=p.id and im.baseimage=1 where p.id = '" . $arrProddetails . "'";
		$result = $this->db->query($strQuery);
		if ($result->num_rows() > 0) {
			$arrRes = $result->row();
			return  $arrRes;
		}
	}

	function sellerdetails($id)
	{
		$sql = "select * from users where id = '" . $id . "'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		}
	}

	function order_product($uid)
	{
		$sql = "SELECT * from ci_order_item where order_id='" . $uid . "' ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}
	}

	function order_product_item_1($uid)
	{
		$sql = "SELECT * from ci_order_item where order_item_id='" . $uid . "' ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		}
	}

	function order_product_return($uid)
	{
		$sql = "SELECT * from ci_order_item where order_id='" . $uid . "' and (is_return=1 or is_exchnage=1)";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}
	}

	function order_product_item($id)
	{
		$sql = "SELECT itm.*,u.email from ci_order_item as itm LEFT JOIN user as u ON u.id=itm.user_info_id where itm.order_item_id='" . $id . "' ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		}
	}




	function wishlist($uid)
	{
		/* $sql = "SELECT p.*,w.id as wish_id,( select min(price) from product_attribute where pid = p.id ) as `minprice`,IFNULL(im.image,'noimage.jpg') as base_image 
		FROM product p 
		LEFT JOIN product_image im ON im.pid=p.id and im.baseimage=1 
		INNER JOIN wishlist w on w.pid=p.id 
		where w.userid=".$uid." order by w.id desc"; */

		$sql = "SELECT w.*,w.id as wishid,w.added_date as wadded_date, p.* ,( select min(price) from product_attribute where pid = p.id ) as `minprice` , IFNULL(im.image,'noimage.jpg') as base_image 
		        FROM wishlist w
		        inner join product p ON p.id = w.pid
		        LEFT JOIN product_image im ON im.pid=p.id and im.baseimage=1 
		        where w.userid = '" . $uid . "' order by w.id desc";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}
	}



	function update_address($content)
	{
		$data1['first_name']    = $content['first_name'];
		$data1['last_name']     = $content['last_name'];
		$data1['email_address'] = $content['email_address'];
		$data1['phone_number']  = $content['phone_number'];
		$data1['address1']       = $content['address'];
		$data1['country']       = $content['country'];
		$data1['state']         = $content['state'];
		$data1['city']          = $content['city'];
		$data1['post_code']      = $content['zip_code'];
		$data1['user_id']       = $this->session->userdata('userid');

		$this->db->where('id', $content['add_id']);
		if ($this->db->update('address_book', $data1)) {
			return true;
		} else {
			return false;
		}
	}
	function update_return_order($data)
	{
		$content['return_reasons']  = $data["return_reasons"];
		$content['return_comment']  = $data["return_comment"];
		$content['is_return']  = 1;

		$this->db->where('order_item_id', $data["return_id"]);
		if ($this->db->update('ci_order_item', $content)) {
			return true;
		} else {
			return false;
		}
	}
	function update_exchange_order($data)
	{
		$content['exchange_comment']  = $data["exchange_comment"];
		$content['size_exchnage']  = $data["size"];
		$content['is_exchnage']  = 1;
		$this->db->where('order_item_id', $data["exchange_id"]);
		if ($this->db->update('ci_order_item', $content)) {
			return true;
		} else {
			return false;
		}
	}


	function productsize($id)
	{
		$sql = "SELECT a.*,s.name,s.id as sizeid FROM product_attribute a LEFT JOIN ci_order_item it ON it.product_id=a.p_id LEFT JOIN size s ON s.id=a.size where it.order_item_id=" . $id . " and it.size_id != s.id GROUP by s.id";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}


	function order_size($id)
	{
		$sql = "SELECT * from size where id ='" . $id . "' ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row()->name;
			return $result;
		}
	}
	public function cancel_product($order_item_id, $orderid)
	{
		$this->db->set('is_cancel', 1);
		$this->db->where('order_item_id', $order_item_id);
		$this->db->update('ci_order_item');
		return $this->db->affected_rows();
	}

	public function cancel_product_details($itemid)
	{
		$sql = "SELECT ci.*, pi.image from ci_order_item ci 
	            left join product_image pi ON pi.pid = ci.product_id and pi.baseimage = '1'
	            where ci.order_item_id ='" . $itemid . "' ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		}
	}

	public function cancel_ordertable($orderid, $total)
	{
		$query = "update ci_orders set order_total =" . $total . "+shippingcost,coup_name='',coupondiscount='',coupon_code='' where order_id = '" . $orderid . "'";
		$result = $this->db->query($query);
		return true;
	}
	public function product_image($productid)
	{
		$this->db->where('id = ', $productid);
		$query = $this->db->get('product');
		if ($query->num_rows() > 0) {
			$result = $query->row()->image;
			return $result;
		} else {
			return false;
		}
	}

	function get_review($product_id, $user_name)
	{
		$this->db->where('userid = ', $user_name);
		$this->db->where('productid = ', $product_id);
		$query = $this->db->get('reviews');
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		} else {
			return false;
		}
	}

	function save_add_reviews($content)
	{

		$L_strErrorMessage = '';
		$data['userid'] = $content['user_id'];
		$data['rating'] = $content['starrating'];
		$data['description'] = $content['description'];
		$data['productid'] = $content['product_id'];
		$data['added_date'] = $content['added_date'];

		$this->_data = $data;
		if ($this->db->insert('reviews', $this->_data)) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

	function savecancelproduct($content)
	{

		$L_strErrorMessage = '';
		$data['userid']      = $content['user_id'];
		$data['productid']   = $content['productid'];
		$data['orderitemid'] = $content['orderitemid'];
		$data['orderid']     = $content['orderid'];
		$data['description'] = $content['description'];
		$data['added_date']  = $content['added_date'];

		$this->_data = $data;
		if ($this->db->insert('cancelrequest', $this->_data)) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}



	function removeadd($id)
	{
		$this->db->where('id = ', $id);
		if ($this->db->delete('address_book')) {
			return true;
		} else {
			return false;
		}
	}

	function edit_address($id)
	{
		$strQuery = "SELECT * from address_book where id ='" . $id . "' ";
		$result   = $this->db->query($strQuery);
		if ($result->num_rows() > 0) {
			$arrRes = $result->row();
			return  $arrRes;
		}
	}

	function add_new_address($content)
	{
		$L_strErrorMessage = '';
		$data['first_name']    = $content['first_name'];
		$data['last_name']     = $content['last_name'];
		$data['email_address'] = $content['email_address'];
		$data['phone_number']  = $content['phone_number'];
		$data['address1']       = $content['address'];
		$data['country']       = $content['country'];
		$data['state']         = $content['state'];
		$data['city']          = $content['city'];
		$data['post_code']      = $content['zip_code'];
		$data['user_id']       = $this->session->userdata('userid');
		$this->_data = $data;
		if ($this->db->insert('address_book', $this->_data)) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

	function add_new_address_new($content)
	{
		$L_strErrorMessage = '';
		//$data['first_name']    = $content['address_title'];
		$data['first_name']     = $content['first_name'];
		$data['post_code'] = $content['post_code'];
		$data['address1']  = $content['address1'];
		$data['address2']       = $content['address2'];
		$data['city']       = $content['city'];
		$data['state']         = $content['state'];
		$data['country']          = $content['country'];
		$data['phone_number']      = $content['phone_number'];
		$data['user_id']       = $this->session->userdata('userid');
		$this->_data = $data;
		if ($this->db->insert('address_book', $this->_data)) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

	function update_address_new($content)
	{
		$data['first_name']     = $content['first_name'];
		$data['post_code'] = $content['post_code'];
		$data['address1']  = $content['address1'];
		$data['address2']       = $content['address2'];
		$data['city']       = $content['city'];
		$data['state']         = $content['state'];
		$data['country']          = $content['country'];
		$data['phone_number']      = $content['phone_number'];
		$data['user_id']       = $this->session->userdata('userid');

		$this->db->where('id', $content['add_id']);
		if ($this->db->update('address_book', $data)) {
			return true;
		} else {
			return false;
		}
	}

	function defaultadd($id)
	{
		$data['default_address']      = 1;
		$this->db->where('id', $id);
		if ($this->db->update('address_book', $data)) {
			return true;
		} else {
			return false;
		}
	}
	function getcityname($id)
	{
		$sql = "SELECT * from city where id ='" . $id . "' ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row()->name;
			return $result;
		}
	}
	function getstatenamein($id)
	{
		$sql = "SELECT * from state where id ='" . $id . "' ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->row()->name;
			return $result;
		}
	}
}
