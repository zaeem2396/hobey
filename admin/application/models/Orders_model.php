<?php
class Orders_model extends CI_Model
{
    private $data = array();

    public function __construct()
    {
        parent::__construct();
    }

	public function getOrders_vendoritem($order_id = '',$status ='')
    {
			$this->db->join('users','ci_orders.user_id = users.id', 'left');
			$this->db->join('ci_shipping_address','ci_orders.order_id = ci_shipping_address.order_id', 'left');
			$this->db->join('ci_order_item','ci_order_item.order_id = ci_orders.order_id', 'left');
			$this->db->select('users.email as user_email');
			$this->db->select('users.first_name as user_name');
			$this->db->select('users.mobile as user_mobile');
			$this->db->select('ci_order_item.api_booking_id as api_booking_id');
			$this->db->select('users.lname as lname');
			$this->db->select('ci_orders.*');
			$this->db->select('ci_shipping_address.*');
		 
        if ($order_id != '') {
            $this->db->where('ci_order_item.order_item_id', $order_id);
							}
							
		if ($status != '') {
            if($status == 'SUCCESS' OR $status == 'FAILED'){ 
				$this->db->where('ci_orders.payment_status',$status);
			}else{
				$this->db->where('ci_orders.order_status',$status);
			}
		}				
							
        $this->db->order_by('ci_orders.order_id', 'DESC');
        $order_list = $this->db->get('ci_orders')->result_array();
			

        foreach ($order_list as &$order) {
            $this->db->where('order_id', $order['order_id']);
            $item_list = $this->db->get('ci_order_item')->result_array();
            $total = 0;
            $additonal_cost = 0;
            foreach ($item_list as &$item) {
                $this->db->where('id', $item['product_id']);
                $product = $this->db->get('product')->result_array(); 
                $total += $item['product_item_price']*$item['product_quantity'];
				 
				//$item['product_name'] = $product[0];
				 
				//$pname=$product['product_name']; 
            }
          
			$order['items'] = $item_list;
            $order['sub_total'] = $total;
			
        }
        return $order_list;
    }

	public function getOrders_vendoritem_bookingid($order_id,$bookingapiid)
    {
			$this->db->join('users','ci_orders.user_id = users.id', 'left');
			$this->db->join('ci_shipping_address','ci_orders.order_id = ci_shipping_address.order_id', 'left');
			$this->db->join('ci_order_item','ci_order_item.order_id = ci_orders.order_id', 'left');
			$this->db->select('users.email as user_email');
			$this->db->select('users.fname as user_name');
			$this->db->select('users.mobile as user_mobile');
			$this->db->select('ci_order_item.api_booking_id as api_booking_id');
			$this->db->select('users.lname as lname');
			$this->db->select('ci_orders.*');
			$this->db->select('ci_shipping_address.*');
		    $this->db->where('ci_order_item.order_item_id', $order_id);
            
 							
		if ($status != '') {
            if($status == 'SUCCESS' OR $status == 'FAILED'){ 
				$this->db->where('ci_orders.payment_status',$status);
			}else{
				$this->db->where('ci_orders.order_status',$status);
			}
		}				
							
        $this->db->order_by('ci_orders.order_id', 'DESC');
        $order_list = $this->db->get('ci_orders')->result_array();
			

        foreach ($order_list as &$order) {
            $this->db->where('order_id', $order['order_id']);
            $this->db->where('api_booking_id', $bookingapiid);
            $item_list = $this->db->get('ci_order_item')->result_array();
            $total = 0;
            $additonal_cost = 0;
            foreach ($item_list as &$item) {
                $this->db->where('id', $item['product_id']);
                $product = $this->db->get('product')->result_array(); 
                $total += $item['product_item_price']*$item['product_quantity'];
				 
				//$item['product_name'] = $product[0];
				 
				//$pname=$product['product_name']; 
            }
          
			$order['items'] = $item_list;
            $order['sub_total'] = $total;
			
        }
        return $order_list;
    }

	public function getOrders($order_id = '',$status ='')
    {
			$this->db->join('users','ci_orders.user_id = users.id', 'left');
			$this->db->join('ci_shipping_address','ci_orders.order_id = ci_shipping_address.order_id', 'left');
			$this->db->select('users.email as user_email');
			$this->db->select('users.name as user_name');
			$this->db->select('users.mobile as user_mobile');
			//$this->db->select('users.lname as lname');
			$this->db->select('ci_orders.*');
			$this->db->select('ci_shipping_address.*');
		 	
		 	//$this->db->where('ci_orders.is_customer', '0');
        if ($order_id != '') {
            $this->db->where('ci_orders.order_id', $order_id);
		}
		if ($status != '') {
            if($status == 'SUCCESS' OR $status == 'FAILED'){ 
				$this->db->where('ci_orders.payment_status',$status);
			}else{
				$this->db->where('ci_orders.order_status',$status);
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
                $total += $item['product_item_price']*$item['product_quantity'];
				//$item['product_name'] = $product[0];
				//$pname=$product['product_name']; 
            }
    		$order['items'] = $item_list;
            $order['sub_total'] = $total;
	    }
        return $order_list;
    }

	public function getOrdersDistributors($order_id = '',$status ='',$startdate ='',$enddate ='',$distributor_id ='')
    {
			$this->db->join('users','ci_orders.user_id = users.id', 'left');
			$this->db->join('ci_shipping_address','ci_orders.order_id = ci_shipping_address.order_id', 'left');
			$this->db->select('users.email as user_email');
			$this->db->select('users.name as user_name');
			$this->db->select('users.mobile as user_mobile');
			//$this->db->select('users.lname as lname');
			$this->db->select('ci_orders.*');
			$this->db->select('ci_shipping_address.*');
		 	
		 	$this->db->where('ci_orders.is_customer', '0');
        if ($order_id != '') {
            $this->db->where('ci_orders.order_id', $order_id);
		}

		if ($startdate != ''){
			$this->db->where("DATE(`ci_orders`.`cdate`) >= '".date('Y-m-d',strtotime($startdate))."' ");	
		}

		if ($enddate != ''){
			$this->db->where("DATE(`ci_orders`.`cdate`) <= '".date('Y-m-d',strtotime($enddate))."' ");
		}
		if ($distributor_id != ''){
			$this->db->where('ci_orders.user_id', $distributor_id);
		}

		if ($status != '') {
            if($status == 'SUCCESS' OR $status == 'FAILED'){ 
				$this->db->where('ci_orders.payment_status',$status);
			}else{
				$this->db->where('ci_orders.order_status',$status);
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
                $total += $item['product_item_price']*$item['product_quantity'];
				//$item['product_name'] = $product[0];
				//$pname=$product['product_name']; 
            }
    		$order['items'] = $item_list;
            $order['sub_total'] = $total;
	    }
        return $order_list;
    }

    public function getOrdersCustomer($order_id = '',$status ='',$startdate ='',$enddate ='',$user_id ='')
    {
			$this->db->join('users','ci_orders.user_id = users.id', 'left');
			$this->db->join('ci_shipping_address','ci_orders.order_id = ci_shipping_address.order_id', 'left');
			$this->db->select('users.email as user_email');
			$this->db->select('users.name as user_name');
			$this->db->select('users.mobile as user_mobile');
			//$this->db->select('users.lname as lname');
			$this->db->select('ci_orders.*');
			$this->db->select('ci_shipping_address.*');
		 	
		 	$this->db->where('ci_orders.is_customer', '1');
        if ($order_id != '') {
            $this->db->where('ci_orders.order_id', $order_id);
		}

		if ($startdate != ''){
			$this->db->where("DATE(`ci_orders`.`cdate`) >= '".date('Y-m-d',strtotime($startdate))."' ");	
		}

		if ($enddate != ''){
			$this->db->where("DATE(`ci_orders`.`cdate`) <= '".date('Y-m-d',strtotime($enddate))."' ");
		}
		if ($user_id != ''){
			$this->db->where('ci_orders.user_id', $user_id);
		}

		if ($status != '') {
            if($status == 'SUCCESS' OR $status == 'FAILED'){ 
				$this->db->where('ci_orders.payment_status',$status);
			}else{
				$this->db->where('ci_orders.order_status',$status);
			}
		}				
	    $this->db->order_by('ci_orders.order_id', 'DESC');
        $order_list = $this->db->get('ci_orders')->result_array();
	
        foreach ($order_list as &$order) {
            $this->db->where('order_id', $order['order_id']);
            $item_list = $this->db->get('ci_order_item')->result_array();
            $total = 0;
            $additonal_cost = 0;
            foreach ($item_list as &$item) {
                $this->db->where('id', $item['product_id']);
                $product = $this->db->get('product')->result_array(); 
                $total += $item['product_item_price']*$item['product_quantity'];
				//$item['product_name'] = $product[0];
				//$pname=$product['product_name']; 
            }
    		$order['items'] = $item_list;
            $order['sub_total'] = $total;
	    }
        return $order_list;
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

	function allcustomers(){
	    $sql = "SELECT * FROM users where user_vendor = 0 order by name asc";
	    $query = $this->db->query($sql);
	    
	  	if ($query->num_rows() > 0)	{
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}
    
    public function getspecialOrdersCustomer($order_id = '',$status ='',$startdate ='',$enddate ='',$distributor_id ='')
    {
			$this->db->join('users','ci_orders.user_id = users.id', 'left');
			$this->db->join('ci_shipping_address','ci_orders.order_id = ci_shipping_address.order_id', 'left');
			$this->db->select('users.email as user_email');
			$this->db->select('users.name as user_name');
			$this->db->select('users.mobile as user_mobile');
			//$this->db->select('users.lname as lname');
			$this->db->select('ci_orders.*');
			$this->db->select('ci_shipping_address.*');
		 	
		 	$this->db->where('ci_orders.is_customer', '2');
        if ($order_id != '') {
            $this->db->where('ci_orders.order_id', $order_id);
		}

		if ($startdate != ''){
			$this->db->where("DATE(`ci_orders`.`cdate`) >= '".date('Y-m-d',strtotime($startdate))."' ");	
		}

		if ($enddate != ''){
			$this->db->where("DATE(`ci_orders`.`cdate`) <= '".date('Y-m-d',strtotime($enddate))."' ");
		}
		if ($distributor_id != ''){
			$this->db->where('ci_orders.distributor_id', $distributor_id);
		}

		if ($status != '') {
            if($status == 'SUCCESS' OR $status == 'FAILED'){ 
				$this->db->where('ci_orders.payment_status',$status);
			}else{
				$this->db->where('ci_orders.order_status',$status);
			}
		}				
	    $this->db->order_by('ci_orders.order_id', 'DESC');
        $order_list = $this->db->get('ci_orders')->result_array();
	
        foreach ($order_list as &$order) {
            $this->db->where('order_id', $order['order_id']);
            $item_list = $this->db->get('ci_order_item')->result_array();
            $total = 0;
            $additonal_cost = 0;
            foreach ($item_list as &$item) {
                $this->db->where('id', $item['product_id']);
                $product = $this->db->get('product')->result_array(); 
                $total += $item['product_item_price']*$item['product_quantity'];
				//$item['product_name'] = $product[0];
				//$pname=$product['product_name']; 
            }
    		$order['items'] = $item_list;
            $order['sub_total'] = $total;
	    }
        return $order_list;
    }
    
    
	public function getOrdersitem($order_id = '')
    {
         $this->db->where('order_id', $order_id);
        $result = $this->db->get('order_item')->result_array();

        if ($result != null) {
            return $result[0];
        }
        return null;
    }

	public function vendordetails($id = '')
    {
         $this->db->where('id', $id);
        $result = $this->db->get('users')->result_array();

        if ($result != null) {
            return $result[0];
        }
        return null;
    }


	public function getamount($order_id)
    {
        $this->db->where('order_id = ',$order_id);
		$query = $this->db->get('ci_order_item');
		if ($query->num_rows() > 0)	{
			$result = $query->row()->product_item_price;
			return $result;
		} else {
			return false;
		}
    }
	public function getpname($productid)
    {
        $this->db->where('product_id = ',$productid);
		$query = $this->db->get('product');
		if ($query->num_rows() > 0)	{
			$result = $query->row()->product_name;
			return $result;
		} else {
			return false;
		}
    }
	public function product_image($productid)
    {
        $this->db->where('pid = ',$productid);
		 $this->db->where('baseimage= ',"1");
		$query = $this->db->get('product_image');
		if ($query->num_rows() > 0)	{
			$result = $query->row()->image;
			return $result;
		} else {
			return false;
		}
    }
	public function gift_image($productid)
    {
        $this->db->where('id = ',$productid);
		$query = $this->db->get('gift');
		if ($query->num_rows() > 0)	{
			$result = $query->row()->image;
			return $result;
		} else {
			return false;
		}
    }
	public function getcityname($productid)
    {
        $this->db->where('city_id = ',$productid);
		$query = $this->db->get('city');
		if ($query->num_rows() > 0)	{
			$result = $query->row()->city_name;
			return $result;
		} else {
			return false;
		}
    }
	
	public function getstatename($productid)
    {
        $this->db->where('sid = ',$productid);
		$query = $this->db->get('state');
		if ($query->num_rows() > 0)	{
			$result = $query->row()->sname;
			return $result;
		} else {
			return false;
		}
    }
	
	
	public function getcountryname($productid)
    {
        $this->db->where('cid = ',$productid);
		$query = $this->db->get('country');
		if ($query->num_rows() > 0)	{
			$result = $query->row()->countryname;
			return $result;
		} else {
			return false;
		}
    }
	
	
	 public function status($order_id, $order_status,$trackadd)
    {
		$data=array(
             'order_status'=>$order_status,
			 'trackadd'=>$trackadd,
			 'status_date'=>date("Y-m-d H:i:s"),
            );
			
			
        $this->db->where('order_id',$order_id);
        if($this->db->update('ci_orders',$data))
		{
			return true;
		} 
		else 
		{
			return false;
		}
    }
    public function setOrderStatus($order_id, $order_status)
    {
        $this->db->set('payment_status', $order_status);
        $this->db->where('id', $order_id);
        $this->db->update('order');
        return $this->db->affected_rows();
    }

    public function changeItemStatus($order_item_id, $order_item_status)
    {
        $this->db->set('status', $order_item_status);
        $this->db->where('id', $order_item_id);
        $this->db->update('tbl_order_items');
        return $this->db->affected_rows();
    }
  
    
    #private functions
    private function getOrderAddress($user_id, $address_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('id', $address_id);
        $result = $this->db->get('tbl_address_book')->result_array();
        $address = $result[0];

        $this->db->where('city_id', $address['city']);
        $result = $this->db->get('city')->result_array();
        $address['city'] = $result[0]['city_name'];

        $this->db->where('sid', $address['state']);
        $result = $this->db->get('state')->result_array();
        $address['state'] = $result[0]['sname'];

        $this->db->where('cid', $address['country']);
        $result = $this->db->get('country')->result_array();
        $address['country'] = $result[0]['countryname'];

        $this->db->where('id', $address['pincode']);
        $result = $this->db->get('pincodedata')->result_array();
        $address['pincode'] = $result[0]['pincode'];

        return $address;
    }
	public function getmodelname($model)
    {
        $this->db->where('id = ',$model);
		$query = $this->db->get('model');
		if ($query->num_rows() > 0)	{
			$result = $query->row()->name;
			return $result;
		} else {
			return "No Model";
		}
    }

	public function getUsername($id)
    {
        $this->db->where('id = ',$id);
		$query = $this->db->get('users');
		if ($query->num_rows() > 0)	{
			$result = $query->row()->name;
			return $result;
		} else {
			return "";
		}
    }

	public function getUsersid($id)
    {
        $this->db->where('id = ',$id);
		$query = $this->db->get('users');
		if ($query->num_rows() > 0)	{
			$result = $query->row()->state_id;
			return $result;
		} else {
			return "";
		}
    }

	public function getStatenamedisply($id)
    {
        $this->db->where('id = ',$id);
		$query = $this->db->get('state');
		if ($query->num_rows() > 0)	{
			$result = $query->row()->name;
			return $result;
		} else {
			return "";
		}
    }

	public function getUsercid($id)
    {
        $this->db->where('id = ',$id);
		$query = $this->db->get('users');
		if ($query->num_rows() > 0)	{
			$result = $query->row()->city_id;
			return $result;
		} else {
			return "";
		}
    }

	public function getDistnamedisply($id)
    {
        $this->db->where('id = ',$id);
		$query = $this->db->get('city');
		if ($query->num_rows() > 0)	{
			$result = $query->row()->name;
			return $result;
		} else {
			return "";
		}
    }
	
	
	function  get_experiance_order()
	{
		$this->db->order_by("id", "desc");
		$query = $this->db->get('ci_orders_experiences');
		if ($query->num_rows() > 0)	{
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}
	
	function getproddetails($arrProddetails)

	 {

		$strQuery="SELECT p.*,( select min(price) from product_attribute where pid = p.id ) as `minprice`,IFNULL(im.image,'noimage.jpg') as base_image FROM product p LEFT JOIN product_image im ON im.pid=p.id and im.baseimage=1 where p.id=$arrProddetails";

		$result = $this->db->query($strQuery);

		if($result->num_rows()>0)

		{

			 $arrRes=$result->row(); 

			return  $arrRes;

		}

	}
	
	function  get_experiance_order_detail($id)
	{
		$this->db->where('id = ',$id);
		$query = $this->db->get('ci_orders_experiences');
		if ($query->num_rows() > 0)	{
			$result = $query->row();
			return $result;
		} else {
			return false;
		}
	}
	function  get_experiance_attendees_detail($id)
	{
		$this->db->where('expe_order_id = ',$id);
		$query = $this->db->get('ci_expr_attendees');
		if ($query->num_rows() > 0)	{
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}
	
	public function delete_order_by_id($order_id){
		$sql = "DELETE FROM ci_orders WHERE order_id = '".$order_id."'";
		$sql1 = "DELETE FROM ci_order_item WHERE order_id = '".$order_id."'";

		$result = $this->db->query($sql);
		$result1 = $this->db->query($sql1);

		if($result && $result1){
			return true;
		}
		else{
			return false;
		}
	}
	
}