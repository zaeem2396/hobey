<?php
class Vendor_model extends CI_Model
{
	function __construct() {
		parent::__construct();
	}

	function add_product($content) 	{

		$L_strErrorMessage='';
		$data['material_type'] = $content['material_type'];
		$data['material_name'] = $content['material_name'];
		
		$data['page_url'] = $content['page_url'];
		$data['material_code'] = $content['material_code'];
		$data['product_description'] = $content['product_description'];
		$data['billing_price'] = $content['billing_price'];
		$data['margin'] = $content['margin'];
		$data['mrp'] = $content['mrp'];
		$data['bpcl_special_price'] = $content['bpcl_special_price'];
		$data['orc'] = $content['orc'];
		$data['package'] = $content['package'];
		// $data['base_unit'] = $content['base_unit'];
		// $data['base_pkg'] = $content['base_pkg'];
		// $data['sale_unit'] = $content['sale_unit'];
		// $data['price_unit'] = $content['price_unit'];
		$data['min_qty'] = $content['min_qty'];

		if($content['product_image'] != '') {
            $data['product_image'] = $content['product_image'];
        }
        
        $data['user_id'] = $this->session->userdata('userid');
        $data['status'] = 1;

		$data['added_date'] = date("Y-m-d");
		$this->_data = $data;
		if ($this->db->insert('product', $this->_data))
			{
			
			$id = $this->db->insert_id();
			if(isset($_POST['state_id']) && count($_POST['state_id']) > 0 && $_POST['state_id']!='')
			{
				for($i=0;$i<count($_POST['state_id']);$i++)
				{
						$product_property['pro_id']   	  = $id;
						$product_property['state_id']   	  = $_POST['state_id'][$i];
						$product_property['city_id'] = $_POST['city_id'][$i];
						//$product_property['area_id']   	  = $_POST['area_id'][$i];
						$product_property['pincode_id']   	  = $_POST['pincode_id'][$i];
						$product_property['inventory']   	  = $_POST['inventory'][$i];
						if($this->db->insert('product_stock_details', $product_property)){}
				}
			}

			return $id;
		 	}else			{
			return false;
			}
	}

	function getallproduct()
	{	
		$sql = "SELECT * from product where is_deleted = 0 and user_id = ".$this->session->userdata('userid')." order by id desc ";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			return $result;
		}
		else
		{
			return false;
		}
	}

	function get_category_name($id) {
		$sql = "select * from material where id = '".$id."' ";
	    $query = $this->db->query($sql);
	  	if ($query->num_rows() > 0)	{
			$result = $query->row()->name;
			return $result;
		} else {
			return false;
		}
	}

	function get_product($id) {
		$sql = "select * from product where id = '".$id."' ";
	    $query = $this->db->query($sql);
	  	if ($query->num_rows() > 0)	{
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	function getBillingPrice($id) {
		$sql = "select * from product where id = '".$id."' ";
	    $query = $this->db->query($sql);
		if ($query->num_rows() > 0)	{
			$result = $query->row()->billing_price;
			return $result;
		} else {
			return false;
		}
	}
	function getPackageSize($id) {
		$sql = "select * from product where id = '".$id."' ";
	    $query = $this->db->query($sql);
		if ($query->num_rows() > 0)	{
			$result = $query->row()->package;
			return $result;
		} else {
			return false;
		}
	}

	function addition_item($prod_id){
	    $sql = "SELECT * from product_stock_details where pro_id = '".$prod_id."'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			return $result;
		}
		else
		{
			return false;
		}
	}

	function edit($id, $content) 	{

		   	$data['material_type'] = $content['material_type'];
			$data['material_name'] = $content['material_name'];			
			$data['page_url'] = $content['page_url'];
			$data['material_code'] = $content['material_code'];
			$data['product_description'] = $content['product_description'];
			$data['billing_price'] = $content['billing_price'];
			$data['margin'] = $content['margin'];
			$data['mrp'] = $content['mrp'];
			$data['bpcl_special_price'] = $content['bpcl_special_price'];
			$data['orc'] = $content['orc'];
			$data['package'] = $content['package'];
			// $data['base_unit'] = $content['base_unit'];
			// $data['base_pkg'] = $content['base_pkg'];
			// $data['sale_unit'] = $content['sale_unit'];
			// $data['price_unit'] = $content['price_unit'];
			$data['min_qty'] = $content['min_qty'];

			if($content['product_image'] != '') {
	            $data['product_image'] = $content['product_image'];
	        }
        
            $data['modified_date'] = date("Y-m-d H:i:s");
			$this->_data = $data;		$this->db->where('id', $id);
		    if ($this->db->update('product', $this->_data))	{

			if(count($_POST['state_id1']) > 0 && $_POST['state_id1']!='')
			{
 
			for($i=0;$i<count($_POST['state_id1']);$i++) {
				if($_POST['state_id1'][$i]!='')
				{
					$content2['pro_id']   = $id;
					$content2['state_id']   = $_POST['state_id1'][$i];
					$content2['city_id']   = $_POST['city_id1'][$i];
					//$content2['area_id']  = $_POST['area_id1'][$i];
					$content2['pincode_id']  = $_POST['pincode_id1'][$i];
					$content2['inventory']  = $_POST['inventory1'][$i];
					//$this->insert_attribute($content2);
					if($this->db->insert('product_stock_details', $content2)){}
				}
			}
			}
			if(count($_POST['updateid1xxx']) > 0 && $_POST['updateid1xxx']!='' )
			{
				for($i=0;$i<count($_POST['updateid1xxx']);$i++){
				$content1['pro_id']   	= $id;
				$content1['updateid1xxx']=$_POST['updateid1xxx'][$i];
				$content1['state_idu']=$_POST['state_id'][$i];
				$content1['city_idu']   	= $_POST['city_id'][$i];
				//$content1['area_idu']  	= $_POST['area_id'][$i];
				$content1['pincode_idu']  		= $_POST['pincode_id'][$i];
				$content1['inventoryu']  		= $_POST['inventory'][$i];
				
				$this->update_attribute($content1);
				}
			}

				return true;
			} else {
				return false;
			}	
		}

		function update_attribute($content)	{
		    
		$data1['state_id']  = $content['state_idu'];
		$data1['city_id']  = $content['city_idu'];
		//$data1['area_id']  = $content['area_idu'];
		$data1['pincode_id']  = $content['pincode_idu'];
		$data1['inventory']  = $content['inventoryu'];

		$this->db->where('id =',$content['updateid1xxx']);
		if ($this->db->update('product_stock_details', $data1))
			{
		return true;
		} else {
		return false;
		}
		}

		function removeattriute($product_id,$id)
	 {
 		$this->db->where('pro_id = ',$product_id);
		$this->db->where('id = ',$id);
		if ($this->db->delete('product_stock_details'))
		{
			return true;
		} else {
			return false;
		}
	}

	function deletes($id)
	{
 	    $data1['is_deleted'] = 1;
		$this->db->where('id =',$id);
		if ($this->db->update('product', $data1))
		{
			
			/*$productdetails = $this->get($id);

		    $vendorid = $productdetails[0]->vendor_id;
			$data2['vendor_id'] 	= $vendorid;
		    $data2['tagname'] 	    = 'Product Deleted';
	        $data2['message'] 	    = 'Your '.$productdetails[0]->name.' has been Deleted.';
	        $data2['added_date'] 	= date('Y-m-d');
    	    
     	    $this->_data = $data2;
    		if ($this->db->insert('notifications',$this->_data))
    		{
    			 
    		}
    		
    		*/
			return true;
		} else {
			return false;
		}
	}


	public function getOrders($status='',$order_id ='')
    {
    	//echo $status; die;
	$sql = "SELECT `ci_orders`.*,ci_shipping_address.*,users.name as user_name,users.mobile as user_mobile,users.email as user_email FROM `ci_orders` LEFT JOIN users as users ON users.id = ci_orders.user_id LEFT JOIN ci_shipping_address as ci_shipping_address ON ci_shipping_address.order_id = ci_orders.order_id WHERE find_in_set('".$this->session->userdata('userid')."',ci_orders.vendor_id) and ci_orders.is_customer = 0 ";
	if($status !='')
	{
		$sql .= ' and ci_orders.payment_status = "'.$status.'" ';
	}

	$sql .= ' group by ci_orders.order_id ORDER BY `ci_orders`.`order_id` DESC ';
	$query = $this->db->query($sql);
	//echo $this->db->last_query(); die;
	$order_list = $query->result_array();
	//echo "<pre>"; print_R($order_list); die;
	foreach ($order_list as &$order) {
            $this->db->where('order_id', $order['order_id']);
            $this->db->where('vendor_id', $this->session->userdata('userid'));
            //$this->db->where('is_customer', 0);
            // if($status !='')
			// 	{
			// 		 $this->db->where('order_status', $status);
			// 	}
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

	public function getOrdersVendor($order_id='',$status)
    {
    	//echo $status; die;
	$sql = "SELECT `ci_orders`.*,ci_shipping_address.*,users.name as user_name,users.mobile as user_mobile,users.email as user_email FROM `ci_orders` LEFT JOIN users as users ON users.id = ci_orders.user_id LEFT JOIN ci_shipping_address as ci_shipping_address ON ci_shipping_address.order_id = ci_orders.order_id WHERE find_in_set('".$this->session->userdata('userid')."',ci_orders.vendor_id) and ci_orders.is_customer = 0 ";
	if($status !='')
	{
		$sql .= " and ci_orders.order_status = '".$status."' ";
	}
	$sql .= ' and ci_orders.payment_status = "Success" ';

	$sql .= ' group by ci_orders.order_id ORDER BY `ci_orders`.`order_id` DESC ';
	$query = $this->db->query($sql);
	//echo $this->db->last_query(); die;
	$order_list = $query->result_array();
	//echo "<pre>"; print_R($order_list); die;
	foreach ($order_list as &$order) {
            $this->db->where('order_id', $order['order_id']);
            $this->db->where('vendor_id', $this->session->userdata('userid'));
            //$this->db->where('is_customer', 0);
            // if($status !='')
			// 	{
			// 		 $this->db->where('order_status', $status);
			// 	}
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

	public function getOrdersCount($order_id = '',$status ='')
    {
		//$this->session->userdata('userid')
	$sql = "SELECT `ci_orders`.* FROM `ci_orders` INNER JOIN ci_order_item as item ON item.order_id = ci_orders.order_id  WHERE item.vendor_id = ".$this->session->userdata('userid')." and ci_orders.is_customer = 0 ";

	if($status !='')
	{
		$sql .= " and item.order_status = '".$status."' ";
	}
	$sql .= " group by ci_orders.order_id ORDER BY `ci_orders`.`order_id` DESC";
	$query = $this->db->query($sql);
	$order_list = $query->result_array();
	//echo $this->db->last_query(); die;
	//echo "<pre>"; print_R($order_list); die;
	foreach ($order_list as &$order) {
            $this->db->where('order_id', $order['order_id']);
            $this->db->where('vendor_id', $this->session->userdata('userid'));
            //$this->db->where('is_customer', 0);
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

	public function getPendingOrdersCount($order_id = '',$status ='')
    {
		//$this->session->userdata('userid')
	$sql = "SELECT `ci_orders`.* FROM `ci_orders` INNER JOIN ci_order_item as item ON item.order_id = ci_orders.order_id  WHERE item.vendor_id = ".$this->session->userdata('userid')." and ci_orders.is_customer = 0 ";

	if($status !='')
	{
		$sql .= " and ci_orders.order_status = '".$status."' ";
	}
	$sql .= ' and ci_orders.payment_status = "Success" ';
	$sql .= " group by ci_orders.order_id ORDER BY `ci_orders`.`order_id` DESC";
	$query = $this->db->query($sql);
	$order_list = $query->result_array();
	//echo $this->db->last_query(); die;
	//echo "<pre>"; print_R($order_list); die;
	foreach ($order_list as &$order) {
            $this->db->where('order_id', $order['order_id']);
            $this->db->where('vendor_id', $this->session->userdata('userid'));
            //$this->db->where('is_customer', 0);
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

	public function getOrders_old($order_id = '',$status ='')
    {
			$this->db->join('users','ci_orders.user_id = users.id', 'left');
			$this->db->join('ci_shipping_address','ci_orders.order_id = ci_shipping_address.order_id', 'left');
			$this->db->select('users.email as user_email');
			$this->db->select('users.name as user_name');
			$this->db->select('users.mobile as user_mobile');
			//$this->db->select('users.lname as lname');
			$this->db->select('ci_orders.*');
			$this->db->select('ci_shipping_address.*');
		 	
		 	$this->db->where('ci_orders.vendor_id', $this->session->userdata('userid'));

		 	//$this->db->where("find_in_set('".$this->session->userdata("userid")."',ci_orders.vendor_id)");

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


    function getuserdata($uid)	{	
		$sql = "SELECT * from users where id='".$uid."'";	
		$query = $this->db->query($sql);		
		if ($query->num_rows() > 0)		{	
		$result = $query->row();	
		return $result;	
		}	
	}

	function update_profile($data)	{
		$content['name']  = $data['fname']; 
		$content['mobile']  = $data['mobile'];
		$this->db->where('id', $this->session->userdata('userid'));	
		if($this->db->update('users', $content))		
		{			
		return true;	
		}else{ 	
		return false;	 	
		}			
	}

	function vendor_update_profile($data)	{
		$content['name']  = $data['fname']; 
		$content['mobile']  = $data['mobile'];
		$content['bank_name']  = $data['bank_name'];
		$content['account_no']  = $data['account_no'];
		$content['ifsc_code']  = $data['ifsc_code'];
		$this->db->where('id', $this->session->userdata('userid'));	
		if($this->db->update('users', $content))		
		{			
		return true;	
		}else{ 	
		return false;	 	
		}			
	}

	function update_password($data)	{
		$content['password']  = $data['pass']; 
		$this->db->where('id', $this->session->userdata('userid'));	
		if($this->db->update('users', $content))		
		{			
		return true;	
		}else{ 	
		return false;	 	
		}			
	}
	

	function productCount($uid)	{	
		$sql = "SELECT count(*) as total_product from product where user_id='".$uid."' and is_deleted = 0";	
		$query = $this->db->query($sql);		
		if ($query->num_rows() > 0)		{	
			$result = $query->row()->total_product;	
			return $result;	
		}	
	}

	 public function status($order_id, $order_status,$trackadd)
    {
		$data=array(
            'order_status'=>$order_status,
			'status_date'=>date('Y-m-d'),
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

    
    public function change_order_status($order_item_id, $order_status)  
      {		
			$data=array(    
			'order_status'=>$order_status,	
			//'pending_comment'=>$trackadd,	
			//'pending_date'=>date( 'Y-m-d H:i:s'),   
			);      
			$this->db->where('order_id',$order_item_id);   
		if($this->db->update('ci_orders',$data))
		{			
			return true;
		} 
		else 
		{
			return false;			
		}   
		}

    public function status_pedning($order_item_id, $order_status)  
      {		
			$data=array(    
			'order_status'=>$order_status,	
			//'pending_comment'=>$trackadd,	
			'pending_date'=>date( 'Y-m-d H:i:s'),   
			);      
			$this->db->where('order_item_id',$order_item_id);   
		if($this->db->update('ci_order_item',$data))
		{			
			return true;
		} 
		else 
		{
			return false;			
		}   
		}	

		public function status_shiped($order_item_id, $order_status)    {	
		$data=array(        
		'order_status'=>$order_status,	
		//'shipped_comment'=>$trackadd,	
		'shiped_date'=>date( 'Y-m-d H:i:s'),   
		);     
		$this->db->where('order_item_id',$order_item_id);   
		if($this->db->update('ci_order_item',$data))	
		{			
		return true;		
		} 			
		else 
		{	
		return false;	
		}    
		}

		public function status_deliver($order_item_id, $order_status)  
		{		
			$data=array(   
			'order_status'=>$order_status,	
			//'deliver_comment'=>$trackadd,	
			'deliver_date'=>date( 'Y-m-d H:i:s'),      
			);        
			$this->db->where('order_item_id',$order_item_id);   
			if($this->db->update('ci_order_item',$data))	
			{			
			return true;	
			} 	
			else 		
			{	
			return false;	
			} 
		}

		public function status_cancel($order_id, $order_status)    {	
			$data=array(            
			'order_status'=>$order_status,			
			//'cancel_comment'=>$trackadd,		
			'cancel_date'=>date( 'Y-m-d H:i:s'),   
			);       
			$this->db->where('order_item_id',$order_item_id);   
			if($this->db->update('ci_order_item',$data))	
			{		
			return true;		
			} 			
			else 	
			{	
			return false;	
			}  
		}
		public function status_received($order_item_id, $order_status)  
      {		
			$data=array(    
			'order_status'=>$order_status,	
			//'pending_comment'=>$trackadd,	
			'received_date'=>date( 'Y-m-d H:i:s'),   
			);      
			$this->db->where('order_item_id',$order_item_id);   
		if($this->db->update('ci_order_item',$data))
		{			
			return true;
		} 
		else 
		{
			return false;			
		}   
		}	
}