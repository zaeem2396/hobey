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
		$data['package'] = $content['package'];
		$data['base_unit'] = $content['base_unit'];
		$data['base_pkg'] = $content['base_pkg'];
		$data['sale_unit'] = $content['sale_unit'];
		$data['price_unit'] = $content['price_unit'];
		$data['min_qty'] = $content['min_qty'];

		if($content['product_image'] != '') {
            $data['product_image'] = $content['product_image'];
        }
        
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
						$product_property['area_id']   	  = $_POST['area_id'][$i];
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
		$sql = "SELECT * from product where is_deleted = 0 order by id desc ";
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
		$sql = "select * from category where id = '".$id."' ";
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
			$data['package'] = $content['package'];
			$data['base_unit'] = $content['base_unit'];
			$data['base_pkg'] = $content['base_pkg'];
			$data['sale_unit'] = $content['sale_unit'];
			$data['price_unit'] = $content['price_unit'];
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
					$content2['area_id']  = $_POST['area_id1'][$i];
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
				$content1['area_idu']  	= $_POST['area_id'][$i];
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
		$data1['area_id']  = $content['area_idu'];
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

/* ===============================================*/

	function add_company($content)
	{
		$data['company_name'] 				= $content['company_name'];
		$data['company_type'] 				= $content['company_type'];
		$data['brand_name'] 				= $content['brand_name'];
		$data['register_address'] 			= $content['register_address'];
		$data['vendor_name'] 				= $content['vendor_name'];
		$data['no_gst'] 					= $content['no_gst'];
		//$data['under_composition_scheme'] 	= $content['under_composition_scheme'];
		$data['service_tax_no'] 			= $content['service_tax_no'];
		$data['pancardnumber'] 				= $content['pancardnumber'];
		$data['distributor_wholeseller'] 	= $content['distributor_wholeseller'];
		
		$data['vendor_city'] 	= $content['vendor_city'];
		$data['vendor_state'] 	= $content['vendor_state'];
		$data['vendor_pincode'] 	= $content['vendor_pincode'];
		
		
		//$data['gumasta_lisence_no'] 		= $content['gumasta_lisence_no'];
		if(isset($content['gst_certificate']))
		{
			$data['gst_certificate'] 		= $content['gst_certificate'];
		}
		if(isset($content['upload_pan_card']))
		{
			$data['upload_pan_card'] 		= $content['upload_pan_card'];
		}
		if(isset($content['additional_certificate']))
		{
			$data['additional_certificate'] 		= $content['additional_certificate'];
		}
		if(isset($content['additional_certificate2']))
		{
			$data['additional_certificate2'] 		= $content['additional_certificate2'];
		}
		if(isset($content['additional_certificate3']))
		{
			$data['additional_certificate3'] 		= $content['additional_certificate3'];
		}
		if(isset($content['additional_certificate4']))
		{
			$data['additional_certificate4'] 		= $content['additional_certificate4'];
		}
		if(isset($content['additional_certificate5']))
		{
			$data['additional_certificate5'] 		= $content['additional_certificate5'];
		}
		if(isset($content['organic_certificate']))
		{
			$data['organic_certificate'] 		= $content['organic_certificate'];
		}
		/*if(isset($content['upload_gumasta_lisence']))
		{
			$data['upload_gumasta_lisence'] 		= $content['upload_gumasta_lisence'];
		}*/
		
		$this->_data = $data;
		$this->db->where('id', $this->session->userdata('userid'));
		if ($this->db->update('users', $this->_data))
		{	
			return true;
		}else
		{
			return false;
		}
	}
	
	
	
	function add_bank_details($content)
	{
		$data['account_holder_name'] 	= $content['account_holder_name'];
		$data['account_no'] 			= $content['account_no'];
		$data['bank_name'] 				= $content['bank_name'];
		$data['bank_branch_name'] 		= $content['bank_branch_name'];
		$data['ifsc_code'] 				= $content['ifsc_code'];
		$data['micr_code'] 				= $content['micr_code'];
		$data['account_type'] 				= $content['account_type'];
		
		if($content['razorpayacctid'] != ''){
			$data['razorpayacctid'] 				= $content['razorpayacctid'];
		}

		if(isset($content['cancel_cheque']))
		{
			$data['cancel_cheque'] 		= $content['cancel_cheque'];
		}
		
		$this->_data = $data;
		$this->db->where('id', $this->session->userdata('userid'));
		if ($this->db->update('users', $this->_data))
		{	
			return true;
		}else
		{
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
		$data['user_id'] 						= $this->session->userdata('userid');
		
		$this->_data = $data;
		if($content['update_id'] !='')
		{
			$this->db->where('user_id',$this->session->userdata('userid'));
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
	function addresspickup_delete($deleteid)
	{
		$this->db->where('user_id',$this->session->userdata('userid'));
 		$this->db->where('id = ',$deleteid);
		if ($this->db->delete('pick_up_address'))
		{
			return true;
		} else {
			return false;
		}
	}
	
	function notifications($id)
	{
	    $sql = "select * from notifications where vendor_id= '".$id."' and is_view = '0' order by id desc limit 15";
	    $query = $this->db->query($sql);
	  	if ($query->num_rows() > 0)	{
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	function notifications1($id)
	{
		$sql_1 = "update notifications set is_view = '1' where vendor_id= '".$id."' ";
	    $query1 = $this->db->query($sql_1);


	    $sql = "select * from notifications where vendor_id= '".$id."' order by id desc";
	    $query = $this->db->query($sql);
	  	if ($query->num_rows() > 0)	{
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}
	
	function get_address($id)
	{
	    $sql = "Select p.*,s.state as state_name from pick_up_address p
				left join state_list s on s.id=p.state where p.user_id=$id order by p.id desc";
	    $query = $this->db->query($sql);
	  	if ($query->num_rows() > 0)	{
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}
	
	
	function vendortotalorder($id)
	{	
		$sql = "SELECT * from ci_order_item where vendor_id = '".$id."' group by order_id";
		$query = $this->db->query($sql);
		
		return $query->num_rows();
	}
	
	function vendortotalproduct($id)
	{	
		$sql = "SELECT count(*) as total from product where vendor_id = '".$id."'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->row()->total;
			return $result;
		}
	}
	
	
	function productattrdetails($id)
	{	
		$sql = "SELECT * from product_attribute where id = '".$id."'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->row();
			return $result;
		}
	}
	
	function get_vendor_product_inventory($id,$status)
	{	
 	    $sql = "select pa.*, p.*,pa.id as attrid from product_attribute pa
	            left join product p ON p.id = pa.pid
	            where p.vendor_id = '".$id."' and p.is_deleted = '0' ";
	            
	    if($status=='1'){
	        $sql .= " AND pa.qty = 0 ";  
 		}
		if($status=='2'){
		    $sql .= " AND pa.qty <= 5 "; 
 		}          
        
        $sql .= " order by pa.id desc ";
	    $query = $this->db->query($sql);
	    
	  	if ($query->num_rows() > 0)	{
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}
	
	function get_vendor_product_inventory_logs($id,$status)
	{	
	    
	    $sql = "Select pi.*,pi.qty as actualqty, pa.id as attrid,pa.sku_code as sku_code_a, p.*, pa.*, pi.added_date as cdate	from product_inventory pi
	            inner join product_attribute pa ON pi.attrid = pa.id
	            inner join product p ON p.id = pa.pid where pi.vendor_id = '".$id."' and p.is_deleted = '0' order by pi.id desc ";
	    
	    
	    /* $sql = "select pa.*, p.*,pa.id as attrid from product_attribute pa
	            left join product p ON p.id = pa.pid
	            where p.vendor_id = '".$id."' and p.is_deleted = '0' ";
 	    if($status=='1'){
	        $sql .= " AND pa.qty = 0 ";  
 		}
		if($status=='2'){
		    $sql .= " AND pa.qty <= 5 "; 
 		}     */     

	    $query = $this->db->query($sql);
	    
	  	if ($query->num_rows() > 0)	{
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}
	
	function allstates(){
	    $sql = "Select * from state_list order by state asc";
	    $query = $this->db->query($sql);
	    
	  	if ($query->num_rows() > 0)	{
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}
	function updatestatus($id,$is_active)
	{		
		$sql= " update product set status= '".$is_active."' where id='".$id."' ";
		if ($query = $this->db->query($sql)){			
				return true;		
		}else
		{	
			return false;			
		
		}
	}
	
    function orderstatus($id)
	{
        $return = array();
        $date = date('Y-m-d');
 		$sql = "SELECT ci.* from ci_order_item ci
					 inner join ci_orders c on c.order_id = ci.order_id
					 where ci.vendor_id = '".$id."' and ci.cdate = '$date' and c.payment_status = '1'";
		$query = $this->db->query($sql);
	    $return['todaysorder'] = $query->num_rows();
	    
	    $sql1 = "SELECT ci.* from ci_order_item ci
					 inner join ci_orders c on c.order_id = ci.order_id   
					 where ci.vendor_id = '".$id."' and c.payment_status = '1'";

		$query1 = $this->db->query($sql1);
 	    $return['totalorder'] = $query1->num_rows();
		
		$sql3 = "SELECT ci.* from ci_order_item ci
					 inner join ci_orders c on c.order_id = ci.order_id   
					 where ci.vendor_id = '".$id."' and c.payment_status = '1' and ci.packstatus='0' and (ci.vendor_accept='0' and ci.is_cancel = '0') ";

		$query3 = $this->db->query($sql3);
 	    $return['pendingorder'] = $query3->num_rows();
         
        $sql2 = "SELECT ci.* from ci_order_item ci
					 inner join ci_orders c on c.order_id = ci.order_id
					 where ci.vendor_id = '".$id."' and (ci.is_cancel = '1' OR ci.vendor_accept='2') and c.payment_status = '1'";
		$query2 = $this->db->query($sql2);
 	    $return['cancelledorder'] = $query2->num_rows();
 
	    //print_r($return); die;
		return $return;
	}
	
	function paymentstatus($id)
	{
        $return = array();
        /*$sql = "SELECT * from ci_order_item where vendor_id = '".$id."' and cdate = '$date' ";
		$query = $this->db->query($sql);
	    $return['todaysorder'] = $query->num_rows();*/
        $return['nextpayment'] = '0';
        $return['lastpayment'] = '0'; 

        $sql = "SELECT sum(vendor_price) as payment from ci_order_item where vendor_id = '".$id."'";
		$query = $this->db->query($sql);
	    $return['totalpayment'] = $query->row()->payment;

        $return['pendingpayment'] = '0';
	    //print_r($return); die;
		return $return;
	}
	
	function addproductqty($content)
	{	
		$data['productid'] 	= $content['productid'];
		$data['attrid'] 	= $content['attrid'];
		$data['qty'] 		= $content['addqty'];
		$data['vendor_id'] 	= $this->session->userdata('userid');
		$data['added_date'] = date('Y-m-d');
		$this->_data = $data;
		if ($this->db->insert('product_inventory', $this->_data))
		{	
		     $sql = "update product_attribute set qty = qty + ".$content['addqty']." where id = '".$data['attrid']."'";
		     $query = $this->db->query($sql);
			 return true;
		}
	}
	
	/*function get_product($uid,$id)
	{
		
		$sql = "SELECT ci.*, u.fname, u.lname,sp.* from ci_order_item ci
		        inner join ci_orders o ON o.order_id = ci.order_id
		        inner join users u on u.id = ci.user_info_id
				left join ci_shipping_address sp on sp.order_id = o.order_id
		        where ci.vendor_id = '".$uid."' and ci.order_item_id = '".$id."' order by ci.order_id desc";
           
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			return $result;
		}
	}*/
	
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

	function vendor_sel_address($id)
	{
	    $sql = "Select p.*,s.state as state_name from pick_up_address p
				left join state_list s on s.id=p.state where p.id=$id order by p.id desc";
	    $query = $this->db->query($sql);
	  	if ($query->num_rows() > 0)	{
			$result = $query->row();
			return $result;
		} else {
			return false;
		}
	}
	
	
	
	function updateshipdetails($content)
	{
		$data['api_booking_id'] 	= $content['bookingid'];
		$data['api_label_pdf'] 		= $content['pdf'];
		$data['api_productid'] 		= $content['productid'];
		$data['liveecouriercharge'] = $content['liveecouriercharge'];
		$this->_data = $data;
		$this->db->where('order_item_id', $content['order_item_id']);
		if ($this->db->update('ci_order_item', $this->_data))
		{	
			return true;
		}else
		{
			return false;
		}
	}
	
	function create_label_add($content)
	{	
		$data['create_lable_weight'] 	= $content['weight'];
		$data['create_lable_length'] 	= $content['length'];
		$data['create_lable_height'] 	= $content['height'];
		$data['create_lable_width'] 	= $content['width'];
		$data['packstatus'] 			= 1;
		
		$this->_data = $data;
		$this->db->where('order_item_id',$content['order_item_id']);
		if ($this->db->update('ci_order_item', $this->_data))
		{	
			$order_status['vendor_id'] 		= $content['vendor_id'];
			$order_status['user_id'] 		= $content['user_id'];
			$order_status['order_id'] 		= $content['order_id'];
			$order_status['order_item_id'] 	= $content['order_item_id'];
			$order_status['status'] 		= 1;
			$this->_data = $order_status;
			if ($this->db->insert('ci_order_status', $this->_data))
			{
				
			}
			return true;
		}else
		{
			return false;
		}
	}

	function acceptorder($id)
	{	
		$data['vendor_accept'] 		= '1';
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

	function rejectorder($id)
	{	
		$data['vendor_accept'] 		= '2';
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

	function ready_to_dispatch_add($content)
	{	
		/*$data['dispatch_end_date'] 	= $content['end_date'];*/
		$data['dispatch_start_date'] 	= date("Y-m-d H:i:s",strtotime($content['start_date']));
		$data['packstatus'] 			= 2;
		$data['customer_reference'] 	= $content['customer_reference'];

		$this->_data = $data;
		$this->db->where('order_item_id',$content['order_item_id']);
		if ($this->db->update('ci_order_item', $this->_data))
		{	
			$order_status['vendor_id'] 		= $content['vendor_id'];
			$order_status['user_id'] 		= $content['user_id'];
			$order_status['order_id'] 		= $content['order_id'];
			$order_status['order_item_id'] 	= $content['order_item_id'];
			$order_status['status'] 		= 2;
			$this->_data = $order_status;
			if ($this->db->insert('ci_order_status', $this->_data))
			{
				
			}
			return true;
		}else
		{
			return false;
		}
	}
	
	function profitsum($startdate,$enddate){
	    $sql = "select sum(vendor_price) as sum from ci_order_item where vendor_id = '".$this->session->userdata('userid')."' and is_cancel = '0' and cdate >= '$startdate' and cdate <= '$enddate'";
           
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->row()->sum;
			if($result ==''){
			    $result = '0';
			} else {
			    $result = round($result);
			}
			return $result;
		}
	}
	
	function totalsum($startdate,$enddate){
	    $sql = "select sum(product_item_price) as sum from ci_order_item where vendor_id = '".$this->session->userdata('userid')."' and is_cancel = '0' and cdate >='$startdate' and cdate <= '$enddate'";
           
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->row()->sum;
			if($result ==''){
			    $result = '0';
			} else {
			    $result = round($result);
			}
			return $result;
		}
	}

	function checknotifyusers($pid){
		$sql = "select ne.*, p.page_url, p.name from notifymeenquriy ne 
				inner join product p ON p.id = ne.serviceId
				where ne.serviceId = '".$pid."' and ne.is_notified = '0'";
           
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			return $result;
		}
	}

	function updatenotify($id){
		$data['is_notified'] 	= "1";
		$this->_data = $data;
		$this->db->where('id',$id);
		if ($this->db->update('notifymeenquriy', $this->_data))
		{	
			return true;
		}else
		{
			return false;
		}
	}
	
}