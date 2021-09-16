<?php
	class Delivery_model extends CI_Model {
	private $_data = array();
	function __construct() {
		parent::__construct();
	}

	function rejectorder($id)
	{	
		$data['vendor_accept'] 		= '2';
		$data['admin_cancel'] 		= '1';
		$data['vendor_accept_date'] = date('Y-m-d');
	
		$this->_data = $data;
		$this->db->where('order_item_id',$id);
		if ($this->db->update('ci_order_item', $this->_data))
		{	
			return true;
		}else
		{
			return false;
		}
	}



	function get_product_order_item($uid,$id)
	{
 		$sql = "SELECT ci.*, u.fname, u.lname, u.email,u.mobile, sp.* from ci_order_item ci
		        inner join ci_orders o ON o.order_id = ci.order_id
		        inner join users u on u.id = ci.user_info_id
				left join ci_shipping_address sp on sp.order_id = o.order_id
		        where ci.vendor_id = '".$uid."' and ci.order_item_id = '".$id."' limit 1";
           
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->row();
			return $result;
		}
	}

	function sellerdetails($id){
	    $sql = "select * from users where id = '".$id."'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->row();
 			return $result;
		}
	}

	function get_news($id){

		$this->db->where('id = ',$id);
		$query = $this->db->get('users');
		if ($query->num_rows() > 0)	{
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	function totalpickuppoints($id){
		$this->db->where('user_id = ',$id);
		$query = $this->db->get('pick_up_address');
		if ($query->num_rows() > 0)	{
			$result = $query->result();
			return $query->num_rows();
		} else {
			return '0';
		}
	}

	function pickuppointslist($id){
		$this->db->where('user_id = ',$id);
		$query = $this->db->get('pick_up_address');
		if ($query->num_rows() > 0)	{
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}


	/*function is_exist($name1,$id)
	{
		$this->db->where('id != ',$id);
		$this->db->where('code',$name1);
		$query = $this->db->get('users');
		if($query->num_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
		}*/

	function add($content)
 	{
		$data['name'] = $content['name'];
		$data['distributor_id'] = $content['distributor_id'];
		$data['mobile'] = $content['mobile'];
		$data['email'] = $content['email'];
		$data['password'] = $content['password'];
		$data['address_1'] = $content['address_1'];
		$data['address_2'] = $content['address_2'];
		$data['state_id'] = $content['state_id'];
		$data['city_id'] = $content['city_id'];

		//$data['pincode_id'] = $pincode_ids =  implode(',',$content['pincode']);

		$data['telephone'] = $content['telephone'];
		$data['contact_title'] = $content['contact_title'];
		$data['contact_name'] = $content['contact_name'];
		$data['contact_email'] = $content['contact_email'];
		$data['contact_phone'] = $content['contact_phone'];
		$data['contact_telephone'] = $content['contact_telephone'];
		/*$data['gst_no'] = $content['gst_no'];
		$data['cc_code'] = $content['cc_code'];*/

		// $data['city_id_new'] = $content['city_id_new'];
		$data['bank_name'] = $content['bank_name'];
		$data['account_no'] = $content['account_no'];
		$data['ifsc_code'] = $content['ifsc_code'];

		$data['user_vendor'] = 3;
		$data['added_date'] = date("Y-m-d");
		$data['status'] = 1;
		$data['pincode'] = $content['pincode'];
		//$pincode_name = $this->get_pincode_name($pincode_ids);
		//$data['pincode'] = $pincode_name;
		//$data['payment_code'] = $content['payment_code'];
		$this->_data = $data;
		if ($this->db->insert('users', $this->_data))
			{
				$id = $this->db->insert_id();
				return true;
		 	}  else {
				return false;
			}
		}


		

		function get_pincode_name($id){


			$query = "SELECT GROUP_CONCAT(name SEPARATOR ',') as name from pincode where id IN ($id) ";
		$result = $this->db->query($query);
		if ($result->num_rows() > 0)
		{
			$result = $result->row()->name;
			return $result;
		}
	}

	function coupanattr($id){

			$query = "SELECT * from tbl_coupan where id= '".$id."'";
		$result = $this->db->query($query);
		if ($result->num_rows() > 0)
		{
			$result = $result->result();
			return $result;
		}
	}

	function edit($id, $content)
	{
	    $data['name'] = $content['name'];
		$data['distributor_id'] = $content['distributor_id'];
		$data['mobile'] = $content['mobile'];
		$data['email'] = $content['email'];
		$data['password'] = $content['password'];
		$data['address_1'] = $content['address_1'];
		$data['address_2'] = $content['address_2'];
		$data['state_id'] = $content['state_id'];
		$data['city_id'] = $content['city_id'];

		$data['pincode'] = $content['pincode'];

		// if($content['pincode'] !='')
		// {
		// 	$data['pincode_id'] = $pincode_ids = implode(',',$content['pincode']);
		// 	$pincode_name = $this->get_pincode_name($pincode_ids);
		// 	$data['pincode'] = $pincode_name;
		// }
		$data['telephone'] = $content['telephone'];
		$data['contact_title'] = $content['contact_title'];
		$data['contact_name'] = $content['contact_name'];
		$data['contact_email'] = $content['contact_email'];
		$data['contact_phone'] = $content['contact_phone'];
		$data['contact_telephone'] = $content['contact_telephone'];
		/*$data['gst_no'] = $content['gst_no'];
		$data['cc_code'] = $content['cc_code'];*/
		//$data['payment_code'] = $content['payment_code'];

		// $data['city_id_new'] = $content['city_id_new'];
		$data['bank_name'] = $content['bank_name'];
		$data['account_no'] = $content['account_no'];
		$data['ifsc_code'] = $content['ifsc_code'];

		$this->_data = $data;
		$this->db->where('id', $id);
		if ($this->db->update('users', $this->_data))	{
		return true;
		} else {
			return false;
		}
	}


	function removeattriute($product_id,$id)
	 {
 		$this->db->where('user_id = ',$product_id);
		$this->db->where('id = ',$id);
		if ($this->db->delete('add_vendor_pincode'))
		{
			return true;
		} else {
			return false;
		}
	}

	 function update_attribute($content)
	{
		$data1['user_id']=$content['p_id'];
		$data1['pincode']  = $content['pincodeu'];
		$data1['pin_address']  = $content['pin_addressu'];
		$data1['pin_city'] = $content['pin_cityu'];
		$data1['pin_state'] = $content['pin_stateu'];


		$this->db->where('id =',$content['updateid1xxx']);

		if ($this->db->update('add_vendor_pincode', $data1))
		{
			return true;
		} else {
			return false;
		}
	}

	function get_dist_name($id)
	{
 		$this->db->where('id = ',$id);
		$query = $this->db->get('users');
		if ($query->num_rows() > 0)
		{
			$result = $query->row()->name;
			return $result;
		}
		else
		{
			return false;
		}
	}


	 function insert_attribute($content)
		{

		$data['user_id']=$content['p_id'];
		$data['pincode']  = $content['pincode'];
		$data['pin_address']  = $content['pin_address'];
		$data['pin_city'] = $content['pin_city'];
		$data['pin_state'] = $content['pin_state'];

		$this->_data = $data;
		if ($this->db->insert('add_vendor_pincode', $this->_data))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

    function lists($num, $offset, $content)
	{

		if($offset == '')
		{
			$offset = '0';
		}

		$sql = "SELECT * FROM users where id <> 0 and  user_vendor = 3 ";

		if($num!='' || $offset!='')
			{
				$sql .=	"  order by id desc limit ".$offset." , ".$num." ";
			}


		$query = $this->db->query($sql);



		/*if($num!='' || $offset!='')
			{
				$sql .=	"  order by id desc limit ".$offset." , ".$num." ";
			}*/

		$sql_count = "SELECT * FROM users WHERE id <> 0 and  user_vendor = 3 ";


		$query1 = $this->db->query($sql_count);
		$ret['result'] = $query->result_array();
		$ret['count']  = $query1->num_rows();
	    return $ret;
	}


	function updatestatus($id,$is_active)
	{
		$sql= " update users set status= '".$is_active."' where id='".$id."' ";
		if ($query = $this->db->query($sql))	{
			return true;
		} else {
			return false;
			}

	}

	function addition_item($id)
	{
 		$this->db->where('user_id = ',$id);
		$query = $this->db->get('add_vendor_pincode');
		if ($query->num_rows() > 0)	{
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	function checkemail($email)
	{
		$this->db->select('users.id,users.email');
		$this->db->where(array('email' => $email));
		$query = $this->db->get('users');
		if($query->num_rows() > 0)
		{
			return $query->row()->email;
		}
		else
		{
			return false;
		}
	}

	function checkemailvalid($email,$vendor_id)
	{
		$this->db->select('users.id,users.email');
		$this->db->where('email' , $email);
		$this->db->where('id !=' ,$vendor_id);
		$query = $this->db->get('users');
		if($query->num_rows() > 0)
		{
			return $query->row()->email;
		}
		else
		{
			return false;
		}
	}

	function deletes($id)
	{
 		$this->db->where('id = ',$id);
		if ($this->db->delete('users'))
		{
			return true;
		} else {
			return false;
		}
	}

	function getsubcate_name($id)
	{
 		$this->db->where('id = ',$id);
		$query = $this->db->get('subcategory');
		if ($query->num_rows() > 0)
		{
			$result = $query->row()->subcategoryname;
			return $result;
		}
		else
		{
			return false;
		}
	}

	function allcategory()
	{
 		$query = $this->db->get('category');
		if ($query->num_rows() > 0)	{
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	function allsubcategory($id='')
	{
		if($id!='')
		{
			$this->db->where('categoryid = ',$id);

		}
 		$query = $this->db->get('subcategory');
		if ($query->num_rows() > 0)	{
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	function getcate_name($id)
	{
 		$this->db->where('id = ',$id);
		$query = $this->db->get('category');
		if ($query->num_rows() > 0)
		{
			$result = $query->row()->categoryname;
			return $result;
		}
		else
		{
			return false;
		}
	}

	 function is_add($name)

	{

		$this->db->where('code',$name);

		$query = $this->db->get('tbl_coupan');

		if($query->num_rows() > 0)

		{

			return true;

		}

		else

		{

			return false;

		}



	}

	function getVender($vender_id = 0){
		$this->db->where('user_vendor',1);
		if ($vender_id > 0) {
			$this->db->where('id',$vender_id);
		}
		$query = $this->db->get('users');
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			return $result;
		}

		return array();

	}

	function check_pincode_data($pincode) {
		$sql = "select * from pincode where pincode = '".$pincode."' ";
	    $query = $this->db->query($sql);
	  	if ($query->num_rows() > 0)	{
			$result = $query->row();
			return $result;
		} else {
			return false;
		}
	}

	function checkperishableassigned(){
		$sql = "select * from pick_up_address where perishable = '1' and user_id = '".$this->session->userdata('userid')."' ";
	    $query = $this->db->query($sql);
	  	if ($query->num_rows() > 0)	{
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	function checkperishableassigned1($id){
		$sql = "select * from pick_up_address where perishable = '1' and id != '".$id."' and user_id = '".$this->session->userdata('userid')."' ";
	    $query = $this->db->query($sql);
	  	if ($query->num_rows() > 0)	{
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}


	function add_pick_up_point($content)
	{	
		$data['contact_persons_name'] 			= $content['contact_persons_name'];
		$data['contact_persons_mobile_number'] 	= $content['contact_persons_mobile_number'];
		$data['address'] 						= $content['address'];
		$data['address2'] 						= $content['address2'];
		$data['city'] 							= $content['city'];
		$data['state'] 							= $content['state'];
		$data['pincode'] 						= $content['pincode'];
		$data['google_map_link'] 				= $content['google_map_link'];
		if($content['perishable'] != null){
			$data['perishable'] 				= $content['perishable'];
		} else {
			$data['perishable'] 				= '0';	
		}
		$data['user_id'] 						= $content['user_id'];
		
		$this->_data = $data;

		 

		if($content['update_id'] !='')
		{
			$this->db->where('user_id',$content['user_id']);
			$this->db->where('id',$content['update_id']);
			if ($this->db->update('pick_up_address', $this->_data))
			{	
				return true;
			}
		}else
		{
			if ($this->db->insert('pick_up_address', $this->_data))
			{	
				return true;
			}
		}
	}
	function addresspickup_delete($deleteid,$userid)
	{
		$this->db->where('user_id',$userid);
 		$this->db->where('id = ',$deleteid);
		if ($this->db->delete('pick_up_address'))
		{
			return true;
		} else {
			return false;
		}
	}

	function allstates(){
	    $sql = "Select * from state order by name asc";
	    $query = $this->db->query($sql);
	    
	  	if ($query->num_rows() > 0)	{
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	function alldistributors(){
	    $sql = "SELECT * FROM users where user_vendor = 2 order by name asc";
	    $query = $this->db->query($sql);
	    
	  	if ($query->num_rows() > 0)	{
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	function getdistixls($name,$pincode){
	    $sql = "SELECT * FROM users where name = '".$name."' and user_vendor = 2 and FIND_IN_SET(".$pincode.",pincode)";
	    $query = $this->db->query($sql);
	    
	  	if ($query->num_rows() > 0)	{
			$result = $query->row()->id;
			return $result;
		} else {
			return false;
		}
	}

	function allpincode(){
	    $sql = "Select * from pincode order by id desc";
	    $query = $this->db->query($sql);
	    
	  	if ($query->num_rows() > 0)	{
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	
	function show_subcategory($cate_id)
	{
		$this->db->where('state_id',$cate_id);
		$query = $this->db->get('city');
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}

	public function commonGetId($table_name, $columname, $return, $id)
    {
        $this->db->where($columname, $id);
        $query = $this->db->get($table_name);
        if ($query->num_rows() > 0) {
            $result = $query->row()->$return;
            return $result;
        } else {
            return 0;
        }
    }

	public function isExistByEmail($email){
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            return true;
        }
        return false;
    }
	
}
?>
