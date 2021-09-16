<?php
class Reports_management_model extends CI_Model
{
    private $data = array();

    public function __construct()
    {
        parent::__construct();
    }

    public function getOrders($order_id = '',$content)
    {
		$this->db->join('users','ci_orders.user_id = users.id', 'left');
		$this->db->join('ci_shipping_address','ci_orders.order_id = ci_shipping_address.order_id', 'left');
		$this->db->select('users.email as user_email');
		$this->db->select('users.name as user_name');
		$this->db->select('users.mobile as user_mobile');
		$this->db->select('ci_orders.*');
		$this->db->select('ci_shipping_address.*');
        if ($order_id != '') {
            $this->db->where('ci_orders.order_id', $order_id);
		}
							
		// if ($content['status'] != '') {
		// 		$this->db->where('ci_orders.order_status',$content['status']);	
		// }				
		
		if ($content['startdate'] != ''){
				$this->db->where("DATE(`ci_orders`.`cdate`) >= '".date('Y-m-d',strtotime($content['startdate']))."' ");	
		}

		if ($content['enddate'] != ''){
				$this->db->where("DATE(`ci_orders`.`cdate`) <= '".date('Y-m-d',strtotime($content['enddate']))."' ");
		}		
		
		$this->db->where('ci_orders.order_status','D');	
		$this->db->where('ci_orders.payment_status','Success');	
		
        $this->db->order_by('ci_orders.order_id', 'DESC');
        $order_list = $this->db->get('ci_orders')->result_array();
		$ordertotal=0;
		$totalorder=0;
        foreach ($order_list as &$order) {
            $this->db->where('order_id', $order['order_id']);
            $item_list = $this->db->get('ci_order_item')->result_array();
            $total = 0;
            $additonal_cost = 0;
            foreach ($item_list as &$item) {
                $this->db->where('id', $item['product_id']);
                $product = $this->db->get('product')->result_array(); 
                $total += $item['product_item_price']*$item['product_quantity'];
            }
			$order['items'] = $item_list;
            $order['sub_total'] = $total;
			$ordertotal += $order['order_total'];
			$totalorder++;
        }
		$data['ordertotal']=$ordertotal;
		$data['order_list']=$order_list;
		$data['totalorder']=$totalorder;
		
        return $data;
    }

	public function getOrdersreport($order_id = '',$content)
    {
		$this->db->join('users','ci_orders.user_id = users.id', 'left');
		$this->db->join('ci_shipping_address','ci_orders.order_id = ci_shipping_address.order_id', 'left');
		$this->db->select('users.email as user_email');
		$this->db->select('users.name as user_name');
		$this->db->select('users.mobile as user_mobile');
		$this->db->select('ci_orders.*');
		$this->db->select('ci_shipping_address.*');
        if ($order_id != '') {
            $this->db->where('ci_orders.order_id', $order_id);
		}
				
		
		if ($content['startdate'] != ''){
			$this->db->where("DATE(`ci_orders`.`cdate`) = '".date('Y-m-d',strtotime($content['startdate']))."' ");	
		}

		// if ($content['enddate'] != ''){
		// 		$this->db->where("DATE(`ci_orders`.`cdate`) <= '".date('Y-m-d',strtotime($content['enddate']))."' ");
		// }	
		
		$this->db->where('ci_orders.order_status','D');	
		$this->db->where('ci_orders.payment_status','Success');	
		
        $this->db->order_by('ci_orders.order_id', 'DESC');
        $order_list = $this->db->get('ci_orders')->result_array();
		$ordertotal=0;
		$totalorder=0;
        foreach ($order_list as &$order) {
            $this->db->where('order_id', $order['order_id']);
            $item_list = $this->db->get('ci_order_item')->result_array();
            $total = 0;
            $additonal_cost = 0;
            foreach ($item_list as &$item) {
                $this->db->where('id', $item['product_id']);
                $product = $this->db->get('product')->result_array(); 
                $total += $item['product_item_price']*$item['product_quantity'];
            }
			$order['items'] = $item_list;
            $order['sub_total'] = $total;
			$ordertotal += $order['order_total'];
			$totalorder++;
        }
		$data['ordertotal']=$ordertotal;
		$data['order_list']=$order_list;
		$data['totalorder']=$totalorder;

		
		//echo "<pre>";print_r($this->db->last_query());echo "</pre>";
        return $data;
    }
	
		function salesreports($data){
	   
	    // $sql = "SELECT ci.*, u.name, u.email, sp.* from ci_order_item ci
		//         inner join ci_orders o ON o.order_id = ci.order_id
		//         inner join users u on u.id = ci.user_info_id
		//         inner join product p on p.id = ci.product_id
		// 		left join ci_shipping_address sp on sp.order_id = o.order_id
		//         where ci.is_cancel = '0' and ci.vendor_accept != '2' and o.payment_status = '1' ";

		$sql = "SELECT ci.*, u.name, u.email, sp.* from ci_order_item ci
		inner join ci_orders o ON o.order_id = ci.order_id
		inner join users u on u.id = ci.user_info_id
		inner join product p on p.id = ci.product_id
		left join ci_shipping_address sp on sp.order_id = o.order_id
		where ci.is_cancel = '0' and o.payment_status = '1' ";
 		
		if($data['startdate'] != ''){
		    $s = date('Y-m-d',strtotime($data['startdate']));
		    $sql .= " and ci.cdate >= '".$s."'  "; 
		}
		if($data['enddate'] != ''){
		    $t = date('Y-m-d',strtotime($data['enddate']));
		    $sql .= " and ci.cdate <= '".$t."'  "; 
		}
		
		if($data['status'] != ''){
		    $sql .= " and ci.packstatus = '".$data['status']."'  "; 
		}
		
		if($data['product'] != ''){
		    $sql .= " and ci.product_id = '".$data['product']."'  "; 
		}
		
		if($data['vendor'] != ''){
		    $sql .= " and ci.vendor_id = '".$data['vendor']."'  "; 
		}
		        
	    $sql .= "order by ci.order_id desc, ci.order_item_id desc";
		
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			return $result;
		}        
 	}

	function cancelorder($data){
	   
	    // $sql = "SELECT ci.*, u.name, u.email, sp.* from ci_order_item ci
		//         inner join ci_orders o ON o.order_id = ci.order_id
		//         inner join users u on u.id = ci.user_info_id
		//         inner join product p on p.id = ci.product_id
		// 		left join ci_shipping_address sp on sp.order_id = o.order_id
		//         where o.payment_status = '1' and (ci.is_cancel = '1' OR ci.vendor_accept = '2') ";

$sql = "SELECT ci.*, u.name, u.email, sp.* from ci_order_item ci
inner join ci_orders o ON o.order_id = ci.order_id
inner join users u on u.id = ci.user_info_id
inner join product p on p.id = ci.product_id
left join ci_shipping_address sp on sp.order_id = o.order_id
where o.payment_status = '1' and (ci.is_cancel = '1') ";
 		
		if($data['startdate'] != ''){
		    $s = date('Y-m-d',strtotime($data['startdate']));
		    $sql .= " and ci.cdate >= '".$s."'  "; 
		}
		if($data['enddate'] != ''){
		    $t = date('Y-m-d',strtotime($data['enddate']));
		    $sql .= " and ci.cdate <= '".$t."'  "; 
		}
		
		if($data['status'] != ''){
		    $sql .= " and ci.packstatus = '".$data['status']."'  "; 
		}
		
		if($data['product'] != ''){
		    $sql .= " and ci.product_id = '".$data['product']."'  "; 
		}
		
		if($data['vendor'] != ''){
		    $sql .= " and ci.vendor_id = '".$data['vendor']."'  "; 
		}
		        
	    $sql .= "order by ci.order_id desc";
		
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			return $result;
		}        
 	}

	function cancelrequest($data){
	   
	    $sql = "SELECT ci.*, u.name, u.email,cr.* 
				from cancelrequest cr
				inner join ci_order_item ci ON ci.order_item_id = cr.orderitemid
			    inner join ci_orders o ON o.order_id = cr.orderid
		        inner join users u on u.id = cr.userid
		        where  cr.id <> 0 ";
 		
		if($data['startdate'] != ''){
		    $s = date('Y-m-d',strtotime($data['startdate']));
		    $sql .= " and cr.added_date >= '".$s."'  "; 
		}
		if($data['enddate'] != ''){
		    $t = date('Y-m-d',strtotime($data['enddate']));
		    $sql .= " and cr.added_date <= '".$t."'  "; 
		}
		
		if($data['status'] != ''){
		    $sql .= " and ci.packstatus = '".$data['status']."'  "; 
		}
		
		if($data['product'] != ''){
		    $sql .= " and cr.productid = '".$data['product']."'  "; 
		}
		
		if($data['vendor'] != ''){
		    $sql .= " and ci.vendor_id = '".$data['vendor']."'  "; 
		}
		        
	    $sql .= "order by cr.id desc";
		
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			return $result;
		}        
 	}
	
	function lists($offset, $content) 
	{
		//  $sql = "SELECT o.*, u.name, u.email, p.vendor_percentage, sp.* 
		// 		from ci_orders o
		//         inner join ci_order_item ci ON o.order_id = ci.order_id
		//         inner join users u on u.id = ci.user_info_id
		//         inner join product p on p.id = ci.product_id
		// 		left join ci_shipping_address sp on sp.order_id = o.order_id
		//         where ci.is_cancel = '0' and ci.vendor_accept != '2' and o.payment_status = '1' ";

$sql = "SELECT o.*, u.name, u.email, p.vendor_percentage, sp.* 
from ci_orders o
inner join ci_order_item ci ON o.order_id = ci.order_id
inner join users u on u.id = ci.user_info_id
inner join product p on p.id = ci.product_id
left join ci_shipping_address sp on sp.order_id = o.order_id
where ci.is_cancel = '0' and o.payment_status = '1' ";
 		
		if($data['startdate'] != ''){
		    $s = date('Y-m-d',strtotime($data['startdate']));
		    $sql .= " and ci.cdate >= '".$s."'  "; 
		}
		if($data['enddate'] != ''){
		    $t = date('Y-m-d',strtotime($data['enddate']));
		    $sql .= " and ci.cdate <= '".$t."'  "; 
		}
		
		if($data['status'] != ''){
		    $sql .= " and ci.packstatus = '".$data['status']."'  "; 
		}
		
		if($data['product'] != ''){
		    $sql .= " and ci.product_id = '".$data['product']."'  "; 
		}
		
		if($data['vendor'] != ''){
		    $sql .= " and ci.vendor_id = '".$data['vendor']."'  "; 
		}
		        
	    echo $sql .= "order by ci.order_id desc";
		
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$ret['result'] = $query->result();
			$ret['count']  = $query->num_rows();
			return $ret;
		}        
	}

	function lists_salesreport($offset, $content) 
	{
		//  $sql = "SELECT o.*, u.name, u.email, sp.* 
		// 		from ci_orders o
		//         inner join users u on u.id = o.user_id
 		// 		left join ci_shipping_address sp on sp.order_id = o.order_id
		//         where o.payment_status = '1' and ( select count(*) from ci_order_item where order_id = o.order_id and is_cancel = 0 and vendor_accept != 2) > 0  ";

$sql = "SELECT o.*, u.name, u.email, sp.* 
from ci_orders o
inner join users u on u.id = o.user_id
 left join ci_shipping_address sp on sp.order_id = o.order_id
where o.payment_status = '1' and ( select count(*) from ci_order_item where order_id = o.order_id and is_cancel = 0 ) > 0  ";
 		
		if($data['startdate'] != ''){
		    $s = date('Y-m-d',strtotime($data['startdate']));
		    $sql .= " and ci.cdate >= '".$s."'  "; 
		}
		if($data['enddate'] != ''){
		    $t = date('Y-m-d',strtotime($data['enddate']));
		    $sql .= " and ci.cdate <= '".$t."'  "; 
		}
		
		if($data['status'] != ''){
		    $sql .= " and ci.packstatus = '".$data['status']."'  "; 
		}
		
		if($data['product'] != ''){
		    $sql .= " and ci.product_id = '".$data['product']."'  "; 
		}
		
		if($data['vendor'] != ''){
		    $sql .= " and ci.vendor_id = '".$data['vendor']."'  "; 
		}
		        
	    $sql .= "order by o.order_id desc";
		
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$ret['result'] = $query->result();
			$ret['count']  = $query->num_rows();
			return $ret;
		}        
	}



	function  product_detail($id)
	{
		$sql = "SELECT p.*,c.name as category_name,sc.name as subcategory_name FROM product p
		LEFT JOIN category as c ON c.id=p.category_id
		LEFT JOIN subcategory as sc ON sc.id=p.subcatefory_id
 		where p.id=$id";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)	{
			$result = $query->row();
			return $result;
		} else {
			return false;
		}
	}

	function orderitemsproucts($id){
		$sql = "SELECT ci.*, sp.*  from ci_order_item ci
				inner join product p on p.id = ci.product_id
				left join ci_shipping_address sp on sp.order_id = ci.order_id
				where ci.order_id ='".$id."'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)	{
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}
	
	function get_vendor_name($id)
	{
		
		$sql = "SELECT * FROM users where id = '".$id."'";
				
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->row()->name;
			return $result;
		}
	}

	function get_vendor_orders($id)
	{
		$sql = "SELECT ci.* from ci_order_item ci
		inner join ci_orders o ON o.order_id = ci.order_id
		where ci.vendor_id = '".$id."' and ci.is_customer = 0 and ci.order_status = 'D' and o.payment_status = 'Success' ";
				
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			return $result;
		} 
	}

	function get_distributor_orders($id)
	{
		$sql = "SELECT ci.* from ci_order_item ci
		inner join ci_orders o ON o.order_id = ci.order_id
		where ci.distributor_id = '".$id."' and ci.is_customer = 1 and ci.order_status = 'D' and o.payment_status = 'Success' ";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			return $result;
		} 
	}

	// function get_total_distributor($id)
	// {
		
	// 	$sql = "SELECT sum(o.distributorpay) as total from ci_orders o
	// 	inner join ci_order_item ci ON ci.order_id = o.order_id
	// 	where ci.distributor_id = '".$id."' and ci.is_customer = 1 and ci.order_status = 'D' and o.payment_status = 'Success' ";

	// 	$query = $this->db->query($sql);
	// 	if ($query->num_rows() > 0)
	// 	{
	// 		$result = $query->row()->total;
	// 		return $result;
	// 	}
	// }

	function get_deliveryman_orders($id)
	{
		$sql = "SELECT ci.* from ci_order_item ci
		inner join ci_orders o ON o.order_id = ci.order_id
		where ci.is_customer = 1 and ci.order_status = 'D' and o.payment_status = 'Success' and o.deliveryBoyId = '".$id."'";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			return $result;
		} 
	}

	function get_vendor_name_details($id)
	{
		$sql = "SELECT * FROM users where id = '".$id."' ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->row();
			return $result;
		}
	}

	function get_state_name($id)
	{
		$sql = "SELECT * FROM state_list where id = '".$id."' ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->row();
			return $result;
		}
	}
	
	function allvendorproducts(){
	    $sql = "SELECT * from product where status = '0' and is_deleted = '0' ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			return $result;
		} 
	}
	
	function allvendor($data){
	    $sql = "SELECT * from users where user_vendor='1' order by name asc ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			return $result;
		} 
	}
	
	
	function allvendorspecialproducts($data){
		$product_id = $data['product_id'];
	    $sql = "SELECT * from product where is_col_product='1' ";

		if($product_id != ''){
			$sql .= " and id = '".$product_id."'  "; 
		}
		$sql .= " order by material_name asc ";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			return $result;
		} 
	}
	
	function get_allvendorspecialproducts($id){
	    $sql = "SELECT ci.* from ci_order_item ci
		inner join ci_orders o ON o.order_id = ci.order_id
		where ci.is_customer = 2 and ci.product_id = '".$id."'";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			return $result;
		} 
	}

	function allSpProducts(){
	   $sql = "SELECT * from product where is_col_product='1' order by material_name asc ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			return $result;
		} 
	}
	
	function get_alldistrspecialproducts($id,$disid,$product_id ='',$distributor_id =''){
	    $sql = "SELECT ci.* from ci_order_item ci
		inner join ci_orders o ON o.order_id = ci.order_id
		where ci.is_customer = 2 and ci.product_id = '".$id."' and ci.distributor_id = '".$disid."'";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			return $result;
		} 
	}

	function Sdistributor(){
	    $sql = "SELECT * from users where user_vendor='2' order by name asc ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			return $result;
		} 
	}

	function alldistributor($data){
		$distributor_id = $data['distributor_id'];
	    $sql = "SELECT * from users where user_vendor='2' ";
		if($distributor_id != ''){
			$sql .= " and id = '".$distributor_id."'  "; 
		}
		$sql .= " order by name asc "; 
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			return $result;
		} 
	}
	
	function alldeliveryman($data){
	    $sql = "SELECT * from users where user_vendor='3' order by name asc ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			return $result;
		} 
	}

	function allblclpayments($content)
	{
		//$sql = "SELECT * FROM bpcl_payment where id = '".$id."' ";
		$sql = "SELECT * FROM bpcl_payment where pdate = '".date('Y-m-d',strtotime($content['startdate']))."'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			return $result;
		}
	}

	public function getDbuyPrice($id)
    {
        $this->db->where('id = ',$id);
		$query = $this->db->get('product');
		if ($query->num_rows() > 0)	{
			$result = $query->row()->d_buy_price;
			return $result;
		} else {
			return "";
		}
    }
	
}
