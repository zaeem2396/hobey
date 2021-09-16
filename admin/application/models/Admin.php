<?php
class Admin extends CI_Model {
	private $_data = array();
	function __construct() {
		parent::__construct();
	}
	function check_login($data) {
		$where_array = array(
						'login' => $data['username'],
						'password' => $data['password'],
				);
		$query = $this->db->get_where('admin_user', $where_array);
		if ($query->num_rows() > 0)	{
			$row = $query->row();
			return $row;
		} else {
			return false;
		}
	}
	function getpswd($id)
	{
		$sql = "SELECT * FROM deal_admin_user where admin_id='".$id."' ";
		
		$query = $this->db->query($sql);

		if ($query->num_rows() > 0)
		{
			$result = $query->row()->admin_password;
			return $result;
		}
	
	}
	function adminget($id)
   	{
		$this->db->where('admin_id = ',$id);
    	$query = $this->db->get('deal_admin_user');
   		if ($query->num_rows() > 0)	{
   			$result = $query->row();
   			return $result;
   		} else {
   			return false;
   		}
   	}
	
	function password_edit($id, $content) {
		$data['admin_password']  = $content['password'];
		$this->_data = $data;
		$this->db->where('admin_id', $id);
		if ($this->db->update('deal_admin_user', $this->_data))	{
			return true;
		} else {
			return false;
		}
	}
	function followupdate(){
		$sql = "select * from followup where `added_date` = '".date('Y-m-d')."'";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}
	function todayenquiry(){
		$sql = "select * from enquiry where added_date = '".date('Y-m-d')."'";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}
	
	function list_customers()
	{
		$sql_count = "Select * from deal_customer";
		$query = $this->db->query($sql_count);
		$ret = $query->num_rows();
	    return $ret;	
	}		
	
	function currentuser()
	{		
	$sql = "select * from deal_customer order by customer_id desc limit 0,5";	
	$query = $this->db->query($sql);
	if ($query->num_rows() > 0)	{	
	$result = $query->result();
	return $result;		
	} else 
	{			
     return false;	
	}	
	}	
function list_merchant()	
{	
	$sql_count = "Select * from deal_merchant ";		
	$query = $this->db->query($sql_count);		
	$ret = $query->num_rows();	    return $ret;
	}	
	
	
	function list_admin()
	{	
	$sql_count = "Select * from deal_admin_user ";	
	$query = $this->db->query($sql_count);		
	$ret = $query->num_rows();	    return $ret;	
	}	
	function get_user($id){

		$this->db->where('id = ',$id);
		$query = $this->db->get('admin_user');
		if ($query->num_rows() > 0)	{
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}
function edit_pass($content) {		$data['password']  = $content['newpassword'];	    $this->_data = $data;		$this->db->where('id', $this->session->userdata('adminId'));		if ($this->db->update('admin_user', $this->_data))	{			return true;		} else {			return false;		}	}


function list_user(){
		$sql = "select * from user";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	function list_user1()
	{
		$sql = "select * from user order by id desc";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{	
			$result = $query->result_array();
			return $result;
		}else{
			return $result;
		}
	}
	
	function list_subscribe(){
		$sql = "select * from subscribe";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}
	
	function list_subscribe1(){
		$sql = "select * from subscribe order by id desc";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->result_array();
			return $result;
		}else{
			return $result;
		}
	}
	
	function list_product(){
		$sql = "select * from product";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}
	
	function list_orders($orderstatus=''){
		$sql = "select * from ci_orders ";
		if($orderstatus !='')
		{
			$sql .= " where order_status='".$orderstatus."'";
		}
		$query = $this->db->query($sql);
		return $query->num_rows();
	}	
	
	function orderstatus()
	{
        $return = array();
        $date = date('Y-m-d');
 		$sql = "SELECT * from ci_order_item where cdate = '$date' ";
		$query = $this->db->query($sql);
	    $return['todaysorder'] = $query->num_rows();
	    
	    
	    $weekdate = date('y-m-d',strtotime('-7 days'));
	    $sql = "SELECT * from ci_order_item where cdate >= '$weekdate' and cdate <= '$date' ";
		$query = $this->db->query($sql);
	    $return['weeksale'] = $query->num_rows();
	    
	    $monthdate = date('y-m-d',strtotime('-30 days'));
	    $sql = "SELECT * from ci_order_item where cdate >= '$monthdate' and cdate <= '$date' ";
		$query = $this->db->query($sql);
	    $return['monthsale'] = $query->num_rows();
	    
	    $sql = "SELECT sum(order_total) as total from ci_orders";
		$query = $this->db->query($sql);
	    $return['totalprofit'] = $query->row()->total;
  
 		return $return;
	}
	
	function topproducts(){
	    $sql = "select ci.product_id, sum(ci.product_quantity) as qty, sum(ci.product_item_price) as price,p.name
                from ci_order_item ci
                inner join product p on p.id = ci.product_id
                group by ci.product_id
                Order by sum(ci.product_quantity) desc limit 5";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{	
			$result = $query->result();
			return $result;
		}else{
			return $result;
		}
	}
	
	function topvendors(){
	    $sql = "select ci.vendor_id, sum(ci.product_quantity) as qty, sum(ci.product_item_price) as price, u.company_name
                from ci_order_item ci
                inner join users u on u.id = ci.vendor_id
                group by ci.vendor_id
                Order by sum(ci.product_quantity) desc limit 5";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{	
			$result = $query->result();
			return $result;
		}else{
			return $result;
		}
	}
	
	function newproducts(){
	    $sql = "select p.*,u.company_name from product p 
	            inner join users u on u.id =p.vendor_id
	            where p.status = '1' and is_deleted = '0'
                Order by p.id desc limit 5";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{	
			$result = $query->result();
			return $result;
		}else{
			return $result;
		}
	}
	
	function updatedproducts(){
	    $sql = "select p.*,u.company_name from product p 
	            inner join users u on u.id =p.vendor_id
	            where is_deleted = '0' and is_blocked = '0'
                Order by modified_date desc limit 5";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{	
			$result = $query->result();
			return $result;
		}else{
			return $result;
		}
	}
	
	function productimage($id){
	    $sql = "select * from product_image where pid = '".$id."' and baseimage = '1' ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{	
			$result = $query->row()->image;
			return $result;
		}else{
			return null;
		}
	}
	
	function productminprice($id){
	    $sql = "select min(price) as price from product_attribute where pid = '".$id."'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{	
			$result = $query->row()->price;
			return $result;
		}else{
			return null;
		}
	}
	
	function productcategory($id){
	    $sql = "select group_concat(name) as catname from category where id IN ('".$id."')";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{	
			$result = $query->row()->catname;
			return $result;
		}else{
			return null;
		}
	}
	
	function notifications($id)
	{
	    $sql = "select * from notifications where vendor_id= '".$id."' and is_view = '0' order by id desc";
	    $query = $this->db->query($sql);
	  	if ($query->num_rows() > 0)	{
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}
	
	function list_notifications($num, $offset, $content) 
	{
		
		$sql_update = "UPDATE notifications SET is_view = '1' where id <> 0";
		$query = $this->db->query($sql_update);
		
		if($offset == '')
		{
			$offset = '0';
		}
		$sql = "SELECT * FROM  notifications where vendor_id = 0 ";
	  
		if($num!='' || $offset!='')
		{
			$sql .=	"  order by id desc limit ".$offset." , ".$num." ";
		}
		$query = $this->db->query($sql);
		$sql_count = "SELECT * FROM  notifications where vendor_id = 0";

		 
		$query1 = $this->db->query($sql_count);
		$ret['result'] = $query->result();
		$ret['count']  = $query1->num_rows();
	    return $ret;
	}
	
	function listtopproducts($num, $offset, $content) 
	{
		if($offset == '')
		{
			$offset = '0';
		}
		$sql = "select ci.product_id, sum(ci.product_quantity) as qty, sum(ci.product_item_price) as price,p.name
                from ci_order_item ci
                inner join product p on p.id = ci.product_id
                group by ci.product_id
                Order by sum(ci.product_quantity) desc ";

		$query = $this->db->query($sql);
		
		$ret['result'] = $query->result();
		$ret['count']  = $query->num_rows();
	    return $ret;
	}
	
	function listtopvendors($num, $offset, $content) 
	{
		if($offset == '')
		{
			$offset = '0';
		}
		$sql = "select ci.vendor_id, sum(ci.product_quantity) as qty, sum(ci.product_item_price) as price, u.company_name
                from ci_order_item ci
                inner join users u on u.id = ci.vendor_id
                group by ci.vendor_id
                Order by sum(ci.product_quantity) desc ";

		$query = $this->db->query($sql);
		
		$ret['result'] = $query->result();
		$ret['count']  = $query->num_rows();
	    return $ret;
	}
 	
}
?>