<?php
	class Collection_product_model extends CI_Model {
	private $_data = array();
	function __construct() {
		parent::__construct();
	}

	function lists($num, $offset, $content)
	{
		if($offset == '')
		{
			$offset = '0';
		}

		$sql = "SELECT * FROM product where id <> 0 and is_deleted = '0' and is_col_product = 1";

		if($content['vendors'] != '') 
		{
			$sql .= "AND (user_id = '".$content['vendors']."') ";
		}
		
		if($content['categorys'] != '') 
		{
			$sql .= " AND (material_type = '".$content['categorys']."') ";
			
		}
		if($content['sub_category'] != '') 
		{
			$sql .=	" AND  (subcatefory_id = '".$content['sub_category']."' ) "; 
		}

		if($num!='' || $offset!='')
		{
			$sql .=	"  order by id desc limit ".$offset." , ".$num." ";
		}
 		$query = $this->db->query($sql);

		$sql_count = "SELECT * FROM product  WHERE id <> 0 and is_deleted = '0'";

		$query1 = $this->db->query($sql_count);
		$ret['result'] = $query->result_array();
		$ret['count']  = $query1->num_rows();
	    return $ret;
	}
	
	function deletedlists($num, $offset, $content)
	{

		if($offset == '')
		{
			$offset = '0';
		}

		$sql = "SELECT * FROM product where id <> 0 and is_deleted = '1'";

		if($num!='' || $offset!='')
			{
				$sql .=	"  order by id desc limit ".$offset." , ".$num." ";
			}


		$query = $this->db->query($sql);



		$sql_count = "SELECT * FROM product  WHERE id <> 0 and is_deleted = '1'";

		$query1 = $this->db->query($sql_count);
		$ret['result'] = $query->result_array();
		$ret['count']  = $query1->num_rows();
	    return $ret;
	}
	
	
	function deactivatedlists($num, $offset, $content)
	{

		if($offset == '')
		{
			$offset = '0';
		}

		$sql = "SELECT * FROM product where id <> 0 and is_deleted = '0' and status = '1' ";

		if($num!='' || $offset!='')
			{
				$sql .=	"  order by id desc limit ".$offset." , ".$num." ";
			}


		$query = $this->db->query($sql);



		$sql_count = "SELECT * FROM product  WHERE id <> 0 and is_deleted = '0' and status = '1' ";

		$query1 = $this->db->query($sql_count);
		$ret['result'] = $query->result_array();
		$ret['count']  = $query1->num_rows();
	    return $ret;
	}
	
	
	function blockedlists($num, $offset, $content)
	{

		if($offset == '')
		{
			$offset = '0';
		}

		$sql = "SELECT * FROM product where id <> 0 and is_deleted = '0' and is_blocked = '1' ";

		if($num!='' || $offset!='')
			{
				$sql .=	"  order by id desc limit ".$offset." , ".$num." ";
			}


		$query = $this->db->query($sql);



		$sql_count = "SELECT * FROM product  WHERE id <> 0 and is_deleted = '0' and is_blocked = '1' ";

		$query1 = $this->db->query($sql_count);
		$ret['result'] = $query->result_array();
		$ret['count']  = $query1->num_rows();
	    return $ret;
	}


function add($content) 	{

		 

		$L_strErrorMessage='';
		$data['material_name'] = $content['material_name'];
		$data['is_col_product'] = $content['is_col_product'];
		$data['weight'] = $content['weight'];
		$data['price'] = $content['price'];
		$data['quantity'] = $content['quantity'];
		
		$data['mrp'] = $content['mrp'];
		$data['vendorname'] = $content['vendorname'];
		$data['city_id'] = $content['city_id'];
		$data['d_buy_price'] = $content['d_buy_price'];
	
		$data['added_date'] = date("Y-m-d");
		$this->_data = $data;
		if ($this->db->insert('product', $this->_data))
			{
				$id = $this->db->insert_id();
				return $id;
		 	}else			{
			return false;
			}
	}

	function edit($id, $content) 	{
		$data['material_name'] = $content['material_name'];
		$data['is_col_product'] = $content['is_col_product'];
		$data['weight'] = $content['weight'];
		$data['price'] = $content['price'];
		$data['quantity'] = $content['quantity'];
		
		$data['mrp'] = $content['mrp'];
		$data['vendorname'] = $content['vendorname'];
		$data['city_id'] = $content['city_id'];
		$data['d_buy_price'] = $content['d_buy_price'];
			
            $data['modified_date'] = date("Y-m-d H:i:s");
			$this->_data = $data;		$this->db->where('id', $id);
		    if ($this->db->update('product', $this->_data))	{
 
				return true;
			} else {
				return false;
			}	
		}
		

	 function alldata($table_name)
		{
			$query = $this->db->get($table_name);
			if ($query->num_rows() > 0)	{
				$result = $query->result();
				return $result;
			} else {
				return false;
			}
		}

	function category($id)
	{
		$this->db->where('group_id = ',$id);
 		$query = $this->db->get('category');
		if ($query->num_rows() > 0)	{
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	public function isExistByMaterialName($material_name){
        // $this->db->where('material_name', $material_name);
		// $this->db->where('is_col_product', 1);
        // $query = $this->db->get('product');

		$sql = "select * from product where BINARY material_name = BINARY '".$material_name."' and is_col_product=1";
	    $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return true;
        }
        return false;
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
	
	function subcategory($id)
	{
		$this->db->where_in('category_id', explode(",",$id));
		//$this->db->where('category_id = ',$id);
 		$query = $this->db->get('subcategory');
		if ($query->num_rows() > 0)	{
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	function show_input($id)
	{
		$this->db->where_in('category_id', explode(",",$id));
 		$query = $this->db->get('category_input');
		if ($query->num_rows() > 0)	{
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	function get($id){
		$this->db->where('id = ',$id);
		$query = $this->db->get('product');
		if ($query->num_rows() > 0)	{
			$result = $query->result();

			/*$product_filter = array();
			$this->db->where('product_id', $id);
			$query = $this->db->get('product_filter');
			if ($query->num_rows() > 0)	{
				foreach($query->result() as $filter){
					$product_filter[] = $filter->filter_id;
				}
			}
			$result[0]->product_filter = $product_filter;*/

			return $result;
		} else {
			return false;
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
	function updatestatus($id,$is_active)
	{		
		$sql= " update product set status= '".$is_active."' where id='".$id."' ";
		if ($query = $this->db->query($sql)){			
			
		        /* $productdetails = $this->get($id);
		    	
			    $vendorid = $productdetails[0]->vendor_id;
    			$data1['vendor_id'] 	= $vendorid;
    			if($is_active == '0') {
    			    $data1['tagname'] 	    = 'Product Approved';
        	        $data1['message'] 	    = 'Your '.$productdetails[0]->name.' product is approved and live now.';
    			} else {
    			    $data1['tagname'] 	    = 'Product Deactivated';
    			    $data1['message'] 	    = 'Your '.$productdetails[0]->name.' product is Deactived.';
    			}
        	    $data1['added_date'] 	= date('Y-m-d');
        	    
         	    $this->_data = $data1;
        		if ($this->db->insert('notifications',$this->_data))
        		{
        			 
        		} */
			 
				return true;		
		}else
		{	
			return false;			
		
		}
	}
	
	function updateblocked($id,$is_active)
	{		
		$sql= " update product set is_blocked= '".$is_active."' where id='".$id."' ";
		if ($query = $this->db->query($sql)){
		    
		    $productdetails = $this->get($id);
		    	
			    $vendorid = $productdetails[0]->vendor_id;
    			$data1['vendor_id'] 	= $vendorid;
    			if($is_active == '1') {
    			    $data1['tagname'] 	    = 'Product Blocked';
        	        $data1['message'] 	    = 'Your '.$productdetails[0]->name.' product is blocked.';
    			} else {
    			    $data1['tagname'] 	    = 'Product UnBlocked';
    			    $data1['message'] 	    = 'Your '.$productdetails[0]->name.' product is Unblocked and live now';
    			}
        	    $data1['added_date'] 	= date('Y-m-d');
        	    
         	    $this->_data = $data1;
        		if ($this->db->insert('notifications',$this->_data))
        		{
        			 
        		}
        		
				return true;		
		}else
		{	
			return false;			
		
		}
	}
	
	
	
		function presult($id)
	{
		$query = "SELECT * from product where id = '".$id."'";
		$result = $this->db->query($query);
		if ($result->num_rows() > 0)
		{
			$result = $result->row();
			return $result;
		}
	}

	function productimages($id)
	{
		$query = "SELECT * from product_image where pid = '".$id."' ORDER BY image_index ASC";
		$result = $this->db->query($query);
		if ($result->num_rows() > 0)
		{
			$result = $result->result();
			return $result;
		}
	}

	function add_product_image($content)
	{
		$data['pid']           = $content['pid'];
		$data['image']         = $content['image'];

		$this->_data = $data;

		if ($this->db->insert('product_image', $this->_data))	{
			return true;
		} else {
			return false;
		}
	}


  	function setbaseimg($id,$pid)
	{
		$query2 = "update product_image set baseimage = '0'  where pid = '".$pid."'";
		$result2 = $this->db->query($query2);

		$query = "update product_image set baseimage = '1'  where id = '".$id."'";
		$result = $this->db->query($query);
		return true;
	}
	function removeimage($id)
	{
		$this->db->where('id = ',$id);
		if ($this->db->delete('product_image'))	{
			return true;
		} else {
			return false;
		}
	}

	function setImageSequence($data) {
		$image_list = explode(',', $data['image_list']);
		foreach($image_list as $key => $image_id){
			$image_data = array(
				'image_index' => $key + 1
			);

			$this->db->where('id', $image_id);
			$this->db->update('product_image', $image_data);
		}
		return true;
	}

	function deletes($id)
	{
 		$this->db->where('id = ',$id);
		if ($this->db->delete('product'))	{
			return true;
		}else{
			return false;
		}
	}
	
	// function deletes($id)
	// {
 	//     $data1['is_deleted'] = 1;
	// 	$this->db->where('id =',$id);
	// 	if ($this->db->update('product', $data1))
	// 	{
			
	// 		$productdetails = $this->get($id);

	// 	    $vendorid = $productdetails[0]->vendor_id;
	// 		$data2['vendor_id'] 	= $vendorid;
	// 	    $data2['tagname'] 	    = 'Product Deleted';
	//         $data2['message'] 	    = 'Your '.$productdetails[0]->name.' has been Deleted.';
	//         $data2['added_date'] 	= date('Y-m-d');
    	    
    //  	    $this->_data = $data2;
    // 		// if ($this->db->insert('notifications',$this->_data))
    // 		// {
    			 
    // 		// }
    		
    		
	// 		return true;
	// 	} else {
	// 		return false;
	// 	}
	// }

	function adminmessage($result_data,$comment){
	 
	    
	        $vendorid = $result_data[0]->id;
			$data2['vendor_id'] 	= $vendorid;
		    $data2['tagname'] 	    = 'Message from admin';
	        $data2['message'] 	    = $comment;
	        $data2['added_date'] 	= date('Y-m-d');
      	    $this->_data = $data2;
    		if ($this->db->insert('notifications',$this->_data))
    		{
    			return true; 
    		}
	    
	}

	function updateorder($id,$val){
		$query2 = "update product_image set image_index = '".$val."'  where id = '".$id."'";
		$result2 = $this->db->query($query2);
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


	function is_exist($name1,$id)
	{
		$this->db->where('id != ',$id);
		$this->db->where('code',$name1);
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
		function allvendor(){				$this->db->where('user_vendor', '1' );		$this->db->where('status', '0' );		$query = $this->db->get('users');		if ($query->num_rows() > 0)	{			$result = $query->result();			return $result;		} else {			return false;		}	}
	function allcolour(){

		$query = $this->db->get('colour');
		if ($query->num_rows() > 0)	{
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	function get_vendor(){

		$query = $this->db->get('users');
		if ($query->num_rows() > 0)	{
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	function allproduct()
	{
		$query = $this->db->get('product');
		if ($query->num_rows() > 0)	{
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	function addition_item($id)
	{
 		$this->db->where('pro_id = ',$id);
		$query = $this->db->get('product_stock_details');
		if ($query->num_rows() > 0)	{
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}

	function allproduct_diff($id)
	{
 		$this->db->where('id != ',$id);
		$query = $this->db->get('product');
		if ($query->num_rows() > 0)	{
			$result = $query->result();
			return $result;
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


	function featured_product($pid,$value)
	{

		$query = "update product set featured = '".$value."' where id = '".$pid."'";
		//echo $query; die;
		$result = $this->db->query($query);
		return true;
	}


	function get_cate_name($id)
	{
 		$this->db->where('id = ',$id);
		$query = $this->db->get('material');
		if ($query->num_rows() > 0)
		{
			$result = $query->row()->name;
			return $result;
		}
		else
		{
			return false;
		}
	}	function get_vendor_name($id)	{ 	
	    $this->db->where('id = ',$id);		$query = $this->db->get('users');		if ($query->num_rows() > 0)		{			$result = $query->row()->name;			return $result;		}		else		{			return false;		}	}

	function get_subcate_name($id)
	{
 		$this->db->where('id = ',$id);
		$query = $this->db->get('subcategory');
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


	function get_size_name($id)
	{
 		$this->db->where('id = ',$id);
		$query = $this->db->get('size');
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
	function show_input_value($product_id,$category_id,$id)
	{
		$value = "";
		if($product_id !="")
		{
			$this->db->where('pro_id',$product_id);
			$this->db->where('cat_id',$category_id);
			$this->db->where('cat_input_id',$id);
			$query = $this->db->get('product_property_details');
			if ($query->num_rows() > 0)
			{
				$value = $query->row()->value;

			}
		}
		return $value;
	}

	function commangetid($table_name,$columname,$return,$id)
	{
 		$this->db->where($columname,$id);
		$query = $this->db->get($table_name);
		if ($query->num_rows() > 0)
		{
			$result = $query->row()->$return;
			return $result;
		}
		else
		{
			return false;
		}
	}
	function get_id($model_number)
	{
		$query = "SELECT * from product where product_code = '".$model_number."'";
		$result = $this->db->query($query);
		if ($result->num_rows() > 0)
		{
			$result = $result->row();
			return $result;
		}else
		{
			return false;
		}
	}
	function get_id_atrribute($model_number)
	{
		$query = "SELECT * from product_attribute where id = '".$model_number."'";
		$result = $this->db->query($query);
		if ($result->num_rows() > 0)
		{
			$result = $result->row();
			return $result;
		}else
		{
			return false;
		}
	}
	function adddata($content)
	{
						$data=array(
								'name'=>$content['name'],
								'group_id'=>$content['group_id'],
								'category_id'=>$content['category_id'],
								'subcatefory_id'=>$content['subcatefory_id'],
								'fabric_id'=>$content['fabric_id'],
								'neck_id'=>$content['neck_id'],
								'fit_id'=>$content['fit_id'],
								'occasion_id'=>$content['occasion_id'],
								'sleeve_id'=>$content['sleeve_id'],
								'pattern_id'=>$content['pattern_id'],
								'model_wearing_size'=>$content['model_wearing_size'],
								'model_wearing_fir'=>$content['model_wearing_fir'],
								'model_height'=>$content['model_height'],
								'description'=>$content['description'],
								'wash_and_care'=>$content['wash_and_care'],
								/* 'specification'=>$content['specification'],*/
								'discount'=>$content['discount'],
								'image'=>$content['image'],
								'meta_title'=>$content['meta_title'],
								'meta_keyword'=>$content['meta_keyword'],
								'meta_desc'=>$content['meta_desc'],
								'diff_color'=>$content['diff_color'],
								'image'=>$content['listimage'],

						);
		$this->db->where('product_code',$content['product_code']);
		$query=$this->db->update('product',$data);
		if($query)
		{
			return true;
		}else
		{
			return false;
		}
	}
		function adddata_atribute($content)
		{
				$data=array(
					'price'=>$content['price'],
					'qty'=>$content['qty'],
					);
			$this->db->where('id',$content['id']);
			$query=$this->db->update('product_attribute',$data);
			if($query)
			{
				return true;
			}else
			{
				return false;
			}
		}
	function insert($content)
	{
					$data =	array(
								'name'=>$content['name'],
								'product_code'=>$content['product_code'],
								'group_id'=>$content['group_id'],
								'category_id'=>$content['category_id'],
								'subcatefory_id'=>$content['subcatefory_id'],
								'fabric_id'=>$content['fabric_id'],
								'neck_id'=>$content['neck_id'],
								'fit_id'=>$content['fit_id'],
								'occasion_id'=>$content['occasion_id'],
								'sleeve_id'=>$content['sleeve_id'],
								'pattern_id'=>$content['pattern_id'],
								'model_wearing_size'=>$content['model_wearing_size'],
								'model_wearing_fir'=>$content['model_wearing_fir'],
								'model_height'=>$content['model_height'],
								'description'=>$content['description'],
								'wash_and_care'=>$content['wash_and_care'],
								/* 'specification'=>$content['specification'], */
								'discount'=>$content['discount'],
								'image'=>$content['image'],
								'meta_title'=>$content['meta_title'],
								'meta_keyword'=>$content['meta_keyword'],
								'meta_desc'=>$content['meta_desc'],
								'diff_color'=>$content['diff_color'],
								'image'=>$content['listimage'],
						);
		$query=$this->db->insert('product',$data);
		if($query)
		{
			$id = $this->db->insert_id();
			if($content["product_size"] !="")
			{

						if($content['product_color'] !="")
						{
							$query_color = "SELECT * from colour WHERE colour ='".$content['product_color']."'";
							$result_color = $this->db->query($query_color);
							if($result_color->num_rows() > 0)
							{
								$color_id=$result_color->row()->id;
							}else
							{
								$color_id=0;
							}
						}else{  $color_id=0; }
					$sizeid = explode(',',$content["product_size"]);
					foreach($sizeid as $sid){
					$this->product_attribute($id,$sid,$content["product_price"],$color_id);
					}
			}
			if(isset($content["detailimages"]))
			{
				foreach($content["detailimages"] as $imagesss)
				{
					$images['pid']           = $id;
					$images['image']         = $imagesss;
					$this->add_product_image($images);
				}
			}
		}
		else
		{
			return false;
		}
	}
	function product_attribute($id,$product_size,$product_price,$color_id)
	{
		$query = "SELECT * from size WHERE name = '$product_size'";
		$result = $this->db->query($query);
		if($result->num_rows() > 0)
		{
				$attribute["p_id"] =$id;
				$attribute["size"] =$result->row()->id;
				$attribute["price"] =$product_price;
				$attribute["colour"] =$color_id;
				$this->db->insert('product_attribute',$attribute);
		}else
		{
			return false;
		}
	}
	function getattributes()
	{
		$query = "SELECT pa.*,p.name as productname,s.name as sizename,c.colour as colourname,p.product_code as productcode from product_attribute as pa
				  LEFT JOIN product as p ON p.id=pa.p_id
				  LEFT JOIN size as s ON s.id=pa.size
				  LEFT JOIN colour as c ON c.id=pa.colour where p.id = pa.p_id order by p.id  ";

		$result = $this->db->query($query);
		if ($result->num_rows() > 0)
		{
			$result = $result->result();
			return $result;
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

	function show_area($city_id)
	{
		$this->db->where('city_id',$city_id);
		$query = $this->db->get('area');
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}

	function show_pincode($pincode_id)
	{
		$this->db->where('area_id',$pincode_id);
		$query = $this->db->get('pincode');
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}
}
?>