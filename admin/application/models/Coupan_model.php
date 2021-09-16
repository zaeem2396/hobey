<?php
	class Coupan_model extends CI_Model {
	private $_data = array();
	function __construct() {
		parent::__construct();
	}

	function get_coupan($id){

		$this->db->where('id = ',$id);
		$query = $this->db->get('tbl_coupan');
		if ($query->num_rows() > 0)	{
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}
	
	function getgifthampercategory(){

 		$query = $this->db->get('gift_hamper_category');
		if ($query->num_rows() > 0)	{
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}


	function add($content)
 	{
		$L_strErrorMessage='';

		$data['name'] = $content['coupanname'];
		$data['code'] = $content['coupancode'];
		$data['discount'] = $content['discount'];
		$data['value'] = $content['coupanvalue'];
		$data['description'] = $content['description'];
		/*$data['workshop_id'] = $content['workshop_id'];
		$data['type'] = $content['type'];
		if($content['category']!='')
		{
			$data['category']    = implode(',',$content['category']);
		}
		if($content['subcategory']!='')
		{
			$data['subcategory']    = implode(',',$content['subcategory']);
		}
		if($content['wellness_category']!='')
		{
			$data['wellness_category']  = implode(',',$content['wellness_category']);
		}
		if($content['gift_hamper_category']!='')
		{
			$data['gift_hamper_category']    = implode(',',$content['gift_hamper_category']);
		}
		if($content['service_category']!='')
		{
			$data['service_category']    = implode(',',$content['service_category']);
		}
		if(isset($content['is_discounted']))
		{
			$data['is_discounted'] = $content['is_discounted'];
		}

		if(isset($content['allowed_discount']))
		{
			$data['allowed_discount'] = $content['allowed_discount'];
		}else{
			$data['allowed_discount'] = 0;
		}*/
		/*$data['category'] = $content['allowed_discocategoryunt'];*/

		$data['start_date'] = date("Y-m-d",strtotime($content['startdate']));
		$data['end_date'] =  date("Y-m-d",strtotime($content['enddate']));
/*
		$data['minimum_order'] = $content['minimum_order'];
		$data['start_time'] = $content['start_time'];
		$data['end_time'] = $content['end_time'];

		$data['no_of_coupons'] = $content['no_of_coupons'];
		$data['no_of_coupons_user'] = $content['no_of_coupons_user'];*/

		$this->_data = $data;
		if ($this->db->insert('tbl_coupan', $this->_data))
			{
				return true;
		 	}  else {
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



	function edit($id, $content)
	{
	    $data['workshop_id'] = $content['workshop_id'];
		$data['name'] = $content['coupanname'];
		$data['code'] = $content['coupancode'];
		$data['discount'] = $content['discount'];
		$data['value'] = $content['coupanvalue'];
		$data['description'] = $content['description'];
		$data['start_date'] = date("Y-m-d",strtotime($content['startdate']));
		$data['end_date'] = date("Y-m-d",strtotime($content['enddate']));
		

		$this->_data = $data;
		$this->db->where('id', $id);
		if ($this->db->update('tbl_coupan', $this->_data))	{
			return true;
		} else {
			return false;
		}
	}


    function lists($num, $offset, $content)
	{

		if($offset == '')
		{
			$offset = '0';
		}

		$sql = "SELECT * FROM tbl_coupan where id <> 0 ";

		if($num!='' || $offset!='')
			{
				$sql .=	"  order by id desc limit ".$offset." , ".$num." ";
			}


		$query = $this->db->query($sql);



		/*if($num!='' || $offset!='')
			{
				$sql .=	"  order by id desc limit ".$offset." , ".$num." ";
			}*/

		$sql_count = "SELECT * FROM tbl_coupan  WHERE id <> 0";


		$query1 = $this->db->query($sql_count);
		$ret['result'] = $query->result_array();
		$ret['count']  = $query1->num_rows();
	    return $ret;
	}

	function deletes($id)
	{
 		$this->db->where('id = ',$id);
		if ($this->db->delete('tbl_coupan'))	{
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
	}	function allworkshop()	{ 		$query = $this->db->get('workshop');		if ($query->num_rows() > 0)	{			$result = $query->result();			return $result;		} else {			return false;		}	}
	function allsubcategory($id='')
	{
		if($id!='')
		{
			$this->db->where_in('category_id',explode(',', $id));

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
	function updatestatus($id,$is_active)
	{
	$sql= " update tbl_coupan set enabled= '".$is_active."' where id='".$id."' ";
		if ($query = $this->db->query($sql))	{
			return true;
		} else {
			return false;
			}

	}

		function featured_product($pid,$value)
	{
		$query = "update tbl_coupan set display_front = '".$value."' where id = '".$pid."'";
		$result = $this->db->query($query);
		return true;
	}

	function updateorder($id,$val)
	{
		$content['display_front'] = $val;
		$this->db->where('id',$id);
		return $this->db->update('tbl_coupan', $content);
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


}
?>
