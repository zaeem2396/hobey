<?php
class Area_model extends CI_Model {
	private $_data = array();
	function __construct() {
		parent::__construct();
	}


	function add($content)
	{
		$L_strErrorMessage='';

		$data['state_id'] = $content['state_id'];
		$data['city_id'] = $content['city_id'];
		$data['name'] = $content['name'];
		$this->_data = $data;
		if ($this->db->insert('area', $this->_data))
		{
			$subcategory_id = $this->db->insert_id();
			
			return $subcategory_id;
		}
		else
		{
			return false;
		}
	}

	function edit($id, $content)
	{
		$data['state_id'] = $content['state_id'];
		$data['name'] = $content['name'];
		$data['city_id'] = $content['city_id'];
		$this->_data = $data;
		$this->db->where('id', $id);
		if ($this->db->update('area', $this->_data))	{
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

		$sql = "SELECT * FROM area where id <> 0 ";
		if($content['categoryname'] != '')
		{
			$sql .=	" AND  (name like '%".$content['categoryname']."%' ) ";
		}
		if($num!='' || $offset!='')
		{
			$sql .=	"  order by id desc limit ".$offset." , ".$num." ";
		}

		$query = $this->db->query($sql);



		$sql_count = "SELECT * FROM  area  WHERE id <> 0";
		if($content['categoryname'] !='')
		{
			$sql_count .= " AND `name` like '".$content['categoryname']."%'";
		}
		$query1 = $this->db->query($sql_count);
		$ret['result'] = $query->result();
		$ret['count']  = $query1->num_rows();
	    return $ret;
	}

	function deletes($id)
	{
 		$this->db->where('id = ',$id);
		if ($this->db->delete('area'))	{
			return true;
		}else{
			return false;
		}
	}
	function remove_value($id)
	{
 		$this->db->where('id',$id);
		if ($this->db->delete('filters_value')){
			return true;
		}else{
			return false;
		}
	}
	function remove_name($id)
	{
 		$this->db->where('id',$id);
		if ($this->db->delete('filtername'))
		{
			return true;
		}else{
			return false;
		}
	}

	function get_category($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('area');
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		else
		{
			return false;
		}
	}

	function featured_product($pid,$value)
	{
		$query = "update subcategory set set_home = '".$value."' where id = '".$pid."'";
		$result = $this->db->query($query);
		return true;
	}


	function updateorder($id,$val){
		$content['set_order'] = $val;
		$this->db->where('id',$id);
		return $this->db->update('subcategory', $content);
	}

	function get_state_name($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('state');
		if($query->num_rows() > 0)
		{
			return $query->row()->name;
		}
		else
		{
			return false;
		}
	}

	function get_city_name($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('city');
		if($query->num_rows() > 0)
		{
			return $query->row()->name;
		}
		else
		{
			return false;
		}
	}

	function get_group_name($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('group1');
		if($query->num_rows() > 0)
		{
			return $query->row()->name;
		}
		else
		{
			return false;
		}
	}

	function allstate()
	{
		$query = $this->db->get('state');
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}


function is_already_exist_add($user)
	{
		$this->db->where('email',$user['email']);
		$query = $this->db->get('user');
		if($query->num_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
function is_already_exist_edit($user,$id)
	{
		$this->db->where('id !=',$id);
		$this->db->where('email',$user['email']);
		$query = $this->db->get('user');
		if($query->num_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function updatestatus($id,$is_active){
	$sql= " update user set active_deactive= '".$is_active."' where id='".$id."' ";
	if ($query = $this->db->query($sql))
	{
		return true;
	} else {
		return false;
	}
	}
	function all_group()
	{
		$query = $this->db->get('group1');
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
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
	
	function getfiltername($id = 0)
	{
		$this->db->select('filtername.*');
		$this->db->from('filtername');
		if ($id != 0) {
			$this->db->where("subcat_id",$id);
		}
		$getfiltername =  $this->db->get()->result_array();
		if($getfiltername !="" && count($getfiltername) > 0)
		{
			foreach ($getfiltername as &$name)
			{
				$this->db->from('filters_value');
				$this->db->select('filters_value.*');
				$this->db->where("filters_value.filter_id",$name["id"]);
				$name['filters_value'] = $this->db->get()->result_array();
			}
		}
		return $getfiltername;
	}
	
	function getkeywordsname($id = 0)
	{
	     
		$this->db->select('productkeywords.*');
		$this->db->from('productkeywords');
		if ($id != 0) {
			$this->db->where("service_id",$id);
		}
		$getkeywordsname =  $this->db->get()->result_array();
  		return $getkeywordsname;
	}
	
	function remove_keyname($id)
	{
 		$this->db->where('id',$id);
		if ($this->db->delete('productkeywords'))
		{
			return true;
		}else{
			return false;
		}
	}
	
	
}
?>