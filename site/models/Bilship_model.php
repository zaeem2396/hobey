<?php
class Bilship_model extends CI_Model
{
	 
	function __construct()
	{
		parent::__construct();
	}

	 function getOrderNumber()
	{
		$strQuery="SELECT MAX(order_id) AS lastOrderNumber FROM ci_orders";
		$result = $this->db->query($strQuery);
		if($result->num_rows()>0)
		{
			$arrRes=$result->result_array(); 
			return $arrRes[0]['lastOrderNumber']+1;
		}
	}

	function getOrderNumberCustomer()
	{
		$strQuery="SELECT MAX(order_id) AS lastOrderNumber FROM ci_orders_customer";
		$result = $this->db->query($strQuery);
		if($result->num_rows()>0)
		{
			$arrRes=$result->result_array(); 
			return $arrRes[0]['lastOrderNumber']+1;
		}
	}

	function addaddress($data)	{
		$this->_data = $data;
		if ($this->db->insert('ci_shipping_address',$this->_data))
		{			return true;
		}
		 else
		 {		   return false;
		  } 
	}


	function addaddressCustomer($data)	{
		$this->_data = $data;
		if ($this->db->insert('ci_shipping_address_customer',$this->_data))
		{			return true;
		}
		 else
		 {		   return false;
		  } 
	}
	

	function saveOrderInDatabase($arrData,$intOrderID)
	{
		$this->db->insert('ci_orders',$arrData);
		$intOrderID=$this->db->insert_id();
		return $intOrderID;
	}

	function saveOrderInDatabaseCustomer($arrData,$intOrderID)
	{
		$this->db->insert('ci_orders_customer',$arrData);
		$intOrderID=$this->db->insert_id();
		return $intOrderID;
	}

	function getproddetails($arrProddetails)
	 {
		$strQuery="SELECT * from product where id=".$arrProddetails;
		$result = $this->db->query($strQuery);
		if($result->num_rows()>0)
		{
			 $arrRes=$result->row(); 
			return  $arrRes;
		}
	}

	function saveOrderFromCart($arrData)
	{
		if($this->db->insert('ci_order_item',$arrData))
		{ 
			return true;
		}
		else
		{
			return false;
		}
	}

	function saveOrderFromCartCustomer($arrData)
	{
		if($this->db->insert('ci_order_item_customer',$arrData))
		{ 
			return true;
		}
		else
		{
			return false;
		}
	}

	function updatebilladd($id) 
	{
		$data['default_address'] = 1;
		 
		$this->_data = $data;
		$this->db->where('id', $id);
		if ($this->db->update('address_book', $this->_data))	{
			return true;
		} else {
			return false;
		}
	}

	function add_billaddress($user_id,$data) 
	{							
		$content['first_name']  = $data['first_name'];
		//$content['last_name']  = $data['last_name'];
		$content['address1']  = $data['address1'];
		$content['address2']  = $data['address2'];
		$content['city']  = $data['city']; 	
		$content['post_code']  =$data['post_code'];		
		// $content['country']  =$data['country'];
		$content['state']  =$data['state'];
		$content['phone_number']  =$data['phone_number'];
		//$content['email_address']  =$data['email_address'];
		$content['user_id']  = $user_id;
		$this->_data = $content;
		if ($this->db->insert('address_book',$this->_data))
		{
			$last=$this->db->insert_id();
			return $last;
		}
		else
		{
		   return false;
		} 
	}

	function getaddnew($id)
	 {
		$strQuery="SELECT * from address_book where id=".$id."";
		$result = $this->db->query($strQuery);
		if($result->num_rows()>0)
		{
			 $arrRes=$result->row(); 
			return  $arrRes;
		}
	}

/* ============================================================== */

	function getaddressshipp($id)	{		$strQuery="SELECT * from usershipping_address where id=".$id;		$result = $this->db->query($strQuery);		if($result->num_rows()>0)		{			 $arrRes=$result->row(); 			return  $arrRes;		}else{			return false;		}			}		
	function getcountryname($id)	
	{		
				$strQuery="SELECT * from country where id=".$id;
				$result = $this->db->query($strQuery);
				if($result->num_rows()>0)		{
				$arrRes = $result->row()->country_name; 
					return  $arrRes;	
				}else{	
					return false;	
				}	
	}		
		function addbillship() 
	{
		$sql = "SELECT * FROM shipping_address where id = '".$this->session->userdata('shippaddress')."'";
		$query = $this->db->query($sql);
		$shippaddress = $query->row(); 
		 //ECHO  $shippaddress ;
		$sql1 = "SELECT * FROM shipping_address where user_id = '".$this->session->userdata('userid')."' ";
		$query1 = $this->db->query($sql1);
		$billaddress = $query1->row(); 
		 
 		//$data['fname ']  = $shippaddress->Name;
		$data['address']  = $billaddress->Address1;
		$data['address1']  = $billaddress->Address2;
		$data['city']  = $billaddress->City;
		$data['county']  = $billaddress->State;
		$data['postcode']  = $billaddress->Zip;
		$data['mobno']  = $billaddress->Phone;
		
		$data['sname ']  = $shippaddress->Name;
		$data['saddress']  = $shippaddress->Address1;
		$data['saddress1']  = $shippaddress->Address2;
		$data['scity']  = $shippaddress->City;
		$data['scounty']  = $shippaddress->State;
		$data['spostcode']  = $shippaddress->Zip;
		$data['smobno']  = $shippaddress->Phone;
		$data['order_id']  = $this->session->userdata('order_number');
		//print_r($data);die;
		$this->_data = $data;
		if ($this->db->insert('billship',$this->_data))
		{
			return true;
		}
		 else
		 {
		   return false;
		  } 
	} 
	
	 
	function userrewards()
	{
	  $sql = "SELECT * FROM userreward where userid = '".$this->session->userdata('userid')."'";
      $query = $this->db->query($sql);	 
	  $userreward = $query->num_rows(); 		
      if($userreward == '0')
		{
			$content['userid']  = $this->session->userdata('userid'); 
			$content['userpoints']  = $this->session->userdata('total_amount'); 
			  
			$this->_data = $content;
			if ($this->db->insert('userreward',$this->_data))
			{
				return true;
			}
		}
		else
		{
			$sql = "Update userreward set userpoints = userpoints + ".$this->session->userdata('total_amount')."  where userid = '".$this->session->userdata('userid')."'";
			$query = $this->db->query($sql);	
		}
		
	}
	function updatestatus($id, $status) 
	{
		$data['order_status'] = $status;
		 
		$this->_data = $data;
		$this->db->where('order_id', $id);
		if ($this->db->update('ci_orders', $this->_data))	{
			return true;
		} else {
			return false;
		}
	}
	
	
	function add_user_address($user_id,$data) 
	{
 		$content['contact_email_phone']  = $data['contact_email_phone'];
		$content['fname']  = $data['fname'];
		$content['lname']  = $data['lname'];
		$content['address']  = $data['address'];
		$content['house_no']  = $data['house_no'];
		// $content['country']  = $data['country'];
		$content['state']  = $data['state'];
		$content['pincode']  = $data['pincode']; 	
		$content['phone']  =$data['phone'];
		$content['billfname']  =$data['billfname'];	
		$content['billcontact_email_phone']  = $data['billcontact_email_phone'];
		$content['billlname']  = $data['billlname'];
		$content['billaddress']  = $data['billaddress'];
		$content['billhouse_no']  = $data['billhouse_no'];
		// $content['billcountry']  = $data['billcountry'];
		$content['billstate']  = $data['billstate'];
		$content['billpincode']  = $data['billpincode'];
		$content['billphone']  = $data['billphone']; 	
		
		$content['user_id']  = $user_id;
		
		$this->_data = $content;
		
		if ($this->db->insert('usershipping_address',$this->_data))
		{
			return true;
		}
		 else
		 {
		   return false;
		  } 	   
	}
	
	function getorderadd($orderid,$userid)
	{
		$strQuery="SELECT * from ci_shipping_address where order_id=".$orderid." and  user_id = ".$userid." ";
		$result = $this->db->query($strQuery);
		if($result->num_rows()>0)
		{
			 $arrRes=$result->row(); 
			return  $arrRes;
		}else
		{
			return false;
		}
	}
 function shipping_address($user_id,$data) 
	{
 		$content['streetname']  = $data['fname'];
		$content['Landmark']  = $data['lname'];
		//$content['email']  = $data['email'];
		$content['Address1']  = $data['address'];
		$content['City']  = $data['city'];
		$content['State']  = $data['state'];
		$content['Zip']  = $data['zipcode']; 	
		// $content['country']  =$data['country'];
		$content['Phone']  =$data['mobno'];		
		$content['user_id']  = $user_id;
		//$content['Status'] = "1";
		$this->_data = $content;
		//print_r($this->_data); die;
		if ($this->db->insert('usershipping_address',$this->_data))
		{
			return true;
		}
		 else
		 {
		   return false;
		  } 
		   
	}

	

	
	
	
	function getproddetails12($arrProddetails)
	 {
		$strQuery="SELECT * from product where id IN ($arrProddetails) ";
		$result = $this->db->query($strQuery);
		if($result->num_rows()>0)
		{
			 $arrRes=$result->result(); 
			return  $arrRes;
		}
	}
	
	function allshipbilldetails()
	{
		$last_data = $this->session->userdata('userid');   
		$sql = "select * from billship where id = '".$last_data."' order by order_id desc limit 0,1";
		 	
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->row();
			return $result;
		}
	}
	
	function shippingaddress_active($orderid)
	{
		$last_data = $this->session->userdata('userid');   
		$sql = "select * from  shipping_address where user_id = '".$last_data."' AND order_id = '".$orderid."' limit 0,1";
		 	
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->row();
			return $result;
		}
	}
	function shippingaddress_activeccavanue()
	{
		$last_data = $this->session->userdata('userid');   
		$sql = "select * from  shipping_address where user_id = '".$last_data."' limit 0,1";
		 	
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->row();
			return $result;
		}
	}
	function shippingdetails($order_invoice){
		
 		$this->db->where('order_id = ',$order_invoice);
		$query = $this->db->get('billship');
		//echo $this->db->last_query();
		if ($query->num_rows() > 0)	{
			$result = $query->row();
			return $result;
		} else {
			return false;
		}
	}
	function get_email($id){
		
 		$this->db->where('id = ',$id);
		$query = $this->db->get('users');
		//echo $this->db->last_query();
		if ($query->num_rows() > 0)	{
			$result = $query->row()->email;
			return $result;
		} else {
			return false;
		}
	}
function checkvalidemail($email)
	{
		$sql = "select * from user where user_email='".$email."'";
		 	
		$query = $this->db->query($sql);

		if($query->num_rows() > 0)
		{
			return $query->row(); 
		}
		else
		{
			return false;
		}
	}
function adduser($email,$data)
	{
		$content['user_name'] = $data['fname']." ".$data['lname'];
		$content['user_email']    = $email;
		$content['password'] = $data['fname'].$data['mobno'];
	//	$content['mobile'] = $data['reg_mobileno'];
		$this->db->insert('user',$content);
		return $this->db->insert_id();

	}
function userdata($id){

		$this->db->select('*');

		$this->db->where(array('id' => $id));

		$query = $this->db->get('user');

		if($query->num_rows() > 0)

		{

				$result = $query->row();

				return $result;

		}

		else

		{

				return false;

		}

	}
function getadd($addid)
	 {
		$strQuery="SELECT * from usershipping_address where user_id=".$addid." and  status = 1 ";
		$result = $this->db->query($strQuery);
		if($result->num_rows()>0)
		{
			 $arrRes=$result->row(); 
			return  $arrRes;
		}
	}
	
	function updatepaymentstatus($order_id,$txnid, $payment_status,$order_status) 
	{
		$data['transactionid'] = $txnid;
		$data['payment_status'] = $payment_status;
		$data['order_status'] = $order_status;
		$this->_data = $data;
		//print_r($order_id); die;
		$this->db->where('order_id', $order_id);
		if ($this->db->update('ci_orders', $this->_data))
		{
			return true;
		}else{
			return false;
		}
	}
	
	
	function rozarpayupdate($content) {		$data['transactionid']  = $content['transactionid'];		$data['payment_status'] = $content['payment_status'];				$this->_data = $data;		$this->db->where('order_id', $content['orderid']);		if ($this->db->update('ci_orders', $this->_data))	{			return true;		} else {			return false;		}	}
	
	function updateproductstock($pid,$stock) 
	{
		$data['qty'] = $stock;
		$this->_data = $data;
		$this->db->where('id', $pid);
		if ($this->db->update('product', $this->_data))	{
			return true;
		} else {
			return false;
		}
	}
	function get_ship_orderdetails($id)
	{
		$sql = "select * from shipping_address where  order_id ='".$id."'";
		 	
		$query = $this->db->query($sql);

		if($query->num_rows() > 0)
		{
			return $query->row(); 
		}
		else
		{
			return false;
		}
	}
	function check_txnid($id)
	{
		$sql = "select * from ci_orders where order_id ='".$id."'";
		 	
		$query = $this->db->query($sql);

		if($query->num_rows() > 0)
		{
			return $query->row()->transactionid; 
		}
		else
		{
			return false;
		}
	}
	
	function get_order_details_payment($id)
	{
		$sql = "select * from ci_orders where  order_id ='".$id."'";
		 	
		$query = $this->db->query($sql);

		if($query->num_rows() > 0)
		{
			return $query->row(); 
		}
		else
		{
			return false;
		}
	}
	
	function get_order_finalamlount($id)
	{
		$sql = "select * from ci_orders where  order_id ='".$id."'";
		 	
		$query = $this->db->query($sql);

		if($query->num_rows() > 0)
		{
			return $query->row()->order_total; 
		}
		else
		{
			return false;
		}
	}
	
	function get_order_details($id)
	{
		$sql = "select * from ci_order_item where  order_id ='".$id."'";
		 	
		$query = $this->db->query($sql);

		if($query->num_rows() > 0)
		{
			return $query->result(); 
		}
		else
		{
			return false;
		}
	}
	function getmodelname($id){
	$sql = "SELECT * FROM model where id = '".$id."'";
	$query = $this->db->query($sql);
	if ($query->num_rows() > 0)
	{
	$result = $query->row()->name;
	return $result;
	}else
	{
		return "No Model";
	}
	}
	function getstate($sid)
	{
		 $where = array(
			'sid' => $sid,
		); 
		$this->db->where($where);
		$query = $this->db->get('state');
		if($query->num_rows() > 0)
		{
			$result = $query->row()->sname;
			return $result;
		}
		else
		{
			return false;
		} 
	}
	
	
	
	function getcity($sid)
	{
		 $where = array(
			'city_id' => $sid,
		); 
		$this->db->where($where);
		$query = $this->db->get('city');
		if($query->num_rows() > 0)
		{
			$result = $query->row()->city_name;
			return $result;
		}
		else
		{
			return false;
		} 
	}
	
	function getcountry($sid)
	{
		 $where = array(
			'cid' => $sid,
		); 
		$this->db->where($where);
		$query = $this->db->get('country');
		if($query->num_rows() > 0)
		{
			$result = $query->row()->countryname;
			return $result;
		}
		else
		{
			return false;
		} 
	}
	function updatestock($attribute_id,$qty)
	{
			$sql = "Update add_product_price set qty = qty - ".$qty."  where id = '".$attribute_id."'";
			$query = $this->db->query($sql);
	}
function getaddress($orderid,$userid)
	{
		
		$sql = "select * from  shipping_address where user_id = '".$userid."' AND order_id = '".$orderid."' limit 0,1";
		 	
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->row();
			return $result;
		}
	}
function deletecart($id){
		$this->db->where('user_id',$id);
		if ($this->db->delete('usercart'))	
		{	
			return true;
		}else{
			return false;
		}
	}	
	
}  