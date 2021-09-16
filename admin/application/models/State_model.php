<?php
	class State_model extends CI_Model {
	private $_data = array();
	function __construct() {
		parent::__construct();
	}
	 
		  
	function add($content) 
	{
		$L_strErrorMessage='';
		$data['name'] = $content['name'];	
		
		$this->_data = $data;
		if ($this->db->insert('state', $this->_data))	
		{		
			$id = $this->db->insert_id();
			return $id; 
		} 
		else 
		{
			return false;
		}
	}
	
	function edit($id, $content) 
	{
	
		$data['name'] = $content['name'];
		
		$this->_data = $data;
		$this->db->where('id', $id);
		if ($this->db->update('state', $this->_data))	
		{
			return true;
		} else {
			return false;
		}
	}
		
		function featured_product($pid,$value)
	{
		$query = "update state set set_home = '".$value."' where id = '".$pid."'";
		$result = $this->db->query($query);
		return true;
	}
	
    function lists($num, $offset, $content) 
	{
		
		if($offset == '')
		{
			$offset = '0';
		}
		
		$sql = "SELECT * FROM state where id <> 0 ";
		if($content['categoryname'] != '') 
		{
			$sql .=	" AND  (name like '%".$content['categoryname']."%' ) "; 
		}
		if($num!='' || $offset!='')
		{
			$sql .=	"  order by id desc limit ".$offset." , ".$num." ";
		}
		
		$query = $this->db->query($sql);
		
		
		
		$sql_count = "SELECT * FROM  state  WHERE id <> 0";
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
		if ($this->db->delete('state'))	{
			return true;
		} else {
			return false;
		}
	}
	

	function get_category($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('state');
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		else
		{
			return false;
		}
	}
	
	function updateorder($id,$val){
		$content['set_order'] = $val;
		$this->db->where('id',$id);
		return $this->db->update('state', $content);	
	}
	
	function getgourp_name($id)
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
	function addition_item($id)
	{
 		$this->db->where('category_id',$id);
		$query = $this->db->get('category_input');
		if ($query->num_rows() > 0)	{
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}
	function removeinput($product_id,$id)
	 {
 		$this->db->where('category_id',$product_id);
		$this->db->where('id',$id);
		if ($this->db->delete('category_input'))
		{
			return true;
		} else {
			return false;
		}
	}	
	
	function getfiltername($id = 0)
	{
		$this->db->select('filtername.*');
		$this->db->from('filtername');
		if ($id != 0) {
			$this->db->where("cat_id",$id);
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
			$this->db->where("cat_id",$id);
		}
		$getkeywordsname =  $this->db->get()->result_array();
  		return $getkeywordsname;
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
	/*public function addPincode($state_id,$city_id,$PinCode)
    {
        $data['state_id'] = $state_id;
		$data['city_id'] = $city_id;
		$data['name'] = $PinCode;
        
		$this->_data = $data;
        if ($this->db->insert('pincode', $this->_data)) {
			$city_id = $this->db->insert_id();
            return $city_id;
        }
        return false;
    }*/
}
?>