<?php
	class Collection_model extends CI_Model {
	private $_data = array();
	function __construct() {
		parent::__construct();
	}

	function get_collection($id){

		$this->db->where('id = ',$id);
		$query = $this->db->get('tbl_collection');
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

		$data['name'] = $content['name'];
		$data['start_date'] = date("Y-m-d",strtotime($content['startdate']));
		$data['end_date'] =  date("Y-m-d",strtotime($content['enddate']));
		$data['state_id'] = $content['state_id'];
		$data['city_id'] = $content['city_id'];
		// $data['pincode_id'] = $content['pincode_id'];

		if($content['product_id']!=''){
			$data['product_id'] = implode(',',$content['product_id']);
		}

		$this->_data = $data;
		if ($this->db->insert('tbl_collection', $this->_data))
			{
				return true;
		 	}  else {
				return false;
			}
		}

	function edit($id, $content)
	{
		$data['name'] = $content['name'];
		$data['start_date'] = date("Y-m-d",strtotime($content['startdate']));
		$data['end_date'] =  date("Y-m-d",strtotime($content['enddate']));
		$data['state_id'] = $content['state_id'];
		$data['city_id'] = $content['city_id'];
		// $data['pincode_id'] = $content['pincode_id'];
		
		if($content['product_id']!=''){
			$data['product_id'] = implode(',',$content['product_id']);
		}else{
			$data['product_id'] = "";
		}


		$this->_data = $data;
		$this->db->where('id', $id);
		if ($this->db->update('tbl_collection', $this->_data))	{
			return true;
		} else {
			return false;
		}
	}

	function show_cityajax($cate_id)
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

	function show_cityajaxpro($cate_id)
	{
		$this->db->where('city_id',$cate_id);
		$this->db->where('is_col_product',1);
		$query = $this->db->get('product');
		if($query->num_rows() > 0)
		{
			return $query->result();
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

		$sql = "SELECT * FROM tbl_collection where id <> 0 ";

		if($num!='' || $offset!='')
			{
				$sql .=	"  order by id desc limit ".$offset." , ".$num." ";
			}


		$query = $this->db->query($sql);



		/*if($num!='' || $offset!='')
			{
				$sql .=	"  order by id desc limit ".$offset." , ".$num." ";
			}*/

		$sql_count = "SELECT * FROM tbl_collection  WHERE id <> 0";


		$query1 = $this->db->query($sql_count);
		$ret['result'] = $query->result_array();
		$ret['count']  = $query1->num_rows();
	    return $ret;
	}

	function deletes($id)
	{
 		$this->db->where('id = ',$id);
		if ($this->db->delete('tbl_collection'))	{
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
	
	function updatestatus($id,$is_active)
	{
	$sql= " update tbl_collection set enabled= '".$is_active."' where id='".$id."' ";
		if ($query = $this->db->query($sql))	{
			return true;
		} else {
			return false;
			}

	}

	function allcproducts(){

		$query = "SELECT * from product where is_col_product= 1";
		$result = $this->db->query($query);
		if ($result->num_rows() > 0)
		{
			$result = $result->result();
			return $result;
		}
	}
	
	function updateorder($id,$val)
	{
		$content['display_front'] = $val;
		$this->db->where('id',$id);
		return $this->db->update('tbl_collection', $content);
	}

}
