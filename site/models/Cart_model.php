<?php
class Cart_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
	}

	function prodetailsspecial($id)
	{
		/*$sql = "SELECT p.*,IFNULL(im.image,'noimage.jpg') as base_image FROM product p 
		LEFT JOIN product_image im ON im.pid=p.id and im.baseimage=1
		where p.id=$id";*/

		//$sql = "SELECT e.* FROM product e where e.id='".$id."'  ";
		$state_id = $this->session->userdata('state_id'); 
		$sql = " SELECT p.* FROM product p where p.id = ".$id." group by p.id ";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->row();
			return $result;
		}
	}
	
		function prodetails($id)
	{
		/*$sql = "SELECT p.*,IFNULL(im.image,'noimage.jpg') as base_image FROM product p 
		LEFT JOIN product_image im ON im.pid=p.id and im.baseimage=1
		where p.id=$id";*/

		//$sql = "SELECT e.* FROM product e where e.id='".$id."'  ";
		$state_id = $this->session->userdata('state_id'); 
		$sql = " SELECT p.*,stock.inventory FROM product p LEFT JOIN product_stock_details as stock ON stock.pro_id = p.id where p.id = ".$id." and stock.state_id IN (".$state_id.") group by p.id ";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->row();
			return $result;
		}
	}
	
	function minprice_row($pid)
	{	
		$sql = "SELECT * from add_product_price where p_id = $pid order by price asc limit 1";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->row();
			return $result;
		}
	}
	function allcountry()
	{	
		$sql = "SELECT * from country order by id desc";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			return $result;
		}else
		{
		  return false;	
		}
	}
	function getcountry($id)
	{	
		$sql = "SELECT * from country where id=".$id." order by id desc";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->row();
			return $result;
		}else
		{
		  return false;	
		}
	}
	
	function selectcoupancode($id){
		$sql = "SELECT * FROM tbl_coupan where start_date <= '".date("Y-m-d")."' and end_date >= '".date("Y-m-d")."' and code='".$id."' and enabled =1 ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->row();
			return $result;
		}else
		{
			return false;
		}
	}
	
	function user_address()
	{	
		$sql = "SELECT s.* from address_book as s where s.user_id = '".$this->session->userdata('userid')."' order by s.id desc";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			return $result;
		}else{
			return false;
		}
	}

	function disti_address()
	{	
		$sql = "SELECT s.* from ci_shipping_address as s where s.user_id = '".$this->session->userdata('userid')."' order by s.id desc";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->row();
			return $result;
		}else{
			return false;
		}
	}

	 function convertCurrency($amount, $from, $to){
		$url = "https://free.currencyconverterapi.com/api/v5/convert?q=".$from."_".$to."&compact=ultra";
		$currency_data = json_decode(file_get_contents($url)); 
		
		$var = $from."_".$to; 
		$price = $currency_data->$var;
		return round($price, 3);
	 }
	 function getusage_coupon($id,$user_id){
		$sql = "SELECT count(*) as usagetotal FROM ci_orders where coupon_code='".$id."' and payment_status='Success' and user_id=".$user_id;
		
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->row()->usagetotal;
			return $result;
		}else
		{
			return false;
		}
	}

	function get_price_attribute($pid)
	{	
		$sql = "SELECT * from product_extra_price where id IN ($pid) ";
		$query = $this->db->query($sql);
		//echo $this->db->last_query(); die;
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			return $result;
		}
	}

	function get_total_qty($pid)
	{	
		$sql = "SELECT sum(product_quantity) as total_sell_qty from ci_order_item where product_id = ".$pid." and is_customer = 0 ";
		$query = $this->db->query($sql);
		//echo $this->db->last_query(); die;
		if ($query->num_rows() > 0)
		{
			$result = $query->row()->total_sell_qty;
			return $result;
		}
	}
	

	function prodetailsCustomer($id)
	{
		/*$sql = "SELECT p.*,IFNULL(im.image,'noimage.jpg') as base_image FROM product p 
		LEFT JOIN product_image im ON im.pid=p.id and im.baseimage=1
		where p.id=$id";*/
		//$pincode = $this->session->userdata('pincode');
		$sql = "SELECT e.*,item.user_info_id as distributor_id FROM product e 
		LEFT JOIN product_stock_details as stock ON stock.pro_id = e.id  
		INNER JOIN ci_order_item item ON item.product_id = e.id LEFT JOIN pincode as pincode ON pincode.id = stock.pincode_id where e.id ='".$id."'   ";

		$query = $this->db->query($sql);
		//echo $this->db->last_query(); die;
		if ($query->num_rows() > 0)
		{
			$result = $query->row();
			return $result;
		}
	}	

	function prodetailsCustomerNew($id,$distributor_id)
	{
		/*$sql = "SELECT p.*,IFNULL(im.image,'noimage.jpg') as base_image FROM product p 
		LEFT JOIN product_image im ON im.pid=p.id and im.baseimage=1
		where p.id=$id";*/
		//$pincode = $this->session->userdata('pincode');
		$sql = "SELECT e.*,sum(item.product_quantity) as product_quantity FROM product e 
		INNER JOIN ci_order_item item ON item.product_id = e.id where e.id ='".$id."' and item.user_info_id = '".$distributor_id."' group by e.id ";

		$query = $this->db->query($sql);
		//echo $this->db->last_query(); die;
		if ($query->num_rows() > 0)
		{
			$result = $query->row();
			return $result;
		}
	}

	function getSpPro($id)
	{

		$sql = "SELECT * FROM product where id ='".$id."'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->row();
			return $result;
		}
	}

	function productDistributorQty($id,$distributor_id)
	{
		/*$sql = "SELECT p.*,IFNULL(im.image,'noimage.jpg') as base_image FROM product p 
		LEFT JOIN product_image im ON im.pid=p.id and im.baseimage=1
		where p.id=$id";*/
		//$pincode = $this->session->userdata('pincode');
		$sql = "SELECT sum(product_quantity) as product_quantity FROM ci_order_item item where item.product_id ='".$id."' and item.user_info_id = '".$distributor_id."' ";

		$query = $this->db->query($sql);
		//echo $this->db->last_query(); die;
		if ($query->num_rows() > 0)
		{
			$result = $query->row()->product_quantity;
			return $result;
		}
	}

	function spSoldQty($id)
	{
		$sql = "SELECT sum(product_quantity) as product_quantity FROM ci_order_item item where item.product_id ='".$id."' ";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->row()->product_quantity;
			return $result;
		}
	}

	function productCustomreDistributorQty($id,$distributor_id)
	{
		/*$sql = "SELECT p.*,IFNULL(im.image,'noimage.jpg') as base_image FROM product p 
		LEFT JOIN product_image im ON im.pid=p.id and im.baseimage=1
		where p.id=$id";*/
		//$pincode = $this->session->userdata('pincode');
		$sql = "SELECT sum(product_quantity) as product_quantity FROM ci_order_item item where item.product_id ='".$id."' and item.distributor_id = '".$distributor_id."' ";

		$query = $this->db->query($sql);
		//echo $this->db->last_query(); die;
		if ($query->num_rows() > 0)
		{
			$result = $query->row()->product_quantity;
			return $result;
		}
	}
	
	function get_product($id)
	{
		$sql = "SELECT p.*,item.user_info_id FROM product p 
		INNER JOIN ci_order_item item ON item.product_id  = p.id  and item.is_customer = 0 
		LEFT JOIN users as users ON users.id = item.user_info_id 
		where p.id ='".$id."'";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->row();
			return $result;
		}
	}
	
}
