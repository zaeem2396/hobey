<?php
	class Bpcl_payment_model extends CI_Model {
	private $_data = array();
	function __construct() {
		parent::__construct();
	}

	function get_bpcl_payment($id){

		$this->db->where('id = ',$id);
		$query = $this->db->get('bpcl_payment');
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

		$data['user_id'] = $content['user_id'];
		$data['user_vendor'] = $content['user_vendor'];
		$data['amount'] = $content['amount'];

		$data['pdate'] = date("Y-m-d",strtotime($content['pdate']));

		$this->_data = $data;
		if ($this->db->insert('bpcl_payment', $this->_data))
			{
				return true;
		 	}  else {
				return false;
			}
		}

	function edit($id, $content)
	{
		$data['user_id'] = $content['user_id'];
		$data['user_vendor'] = $content['user_vendor'];
		$data['amount'] = $content['amount'];

		$data['pdate'] = date("Y-m-d",strtotime($content['pdate']));

		$this->_data = $data;
		$this->db->where('id', $id);
		if ($this->db->update('bpcl_payment', $this->_data))	{
			return true;
		} else {
			return false;
		}
	}

	function show_user($cate_id)
	{
		$this->db->where('user_vendor',$cate_id);
		$query = $this->db->get('users');
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

		$sql = "SELECT * FROM bpcl_payment where id <> 0 ";

		if($num!='' || $offset!='')
			{
				$sql .=	"  order by id desc limit ".$offset." , ".$num." ";
			}


		$query = $this->db->query($sql);



		/*if($num!='' || $offset!='')
			{
				$sql .=	"  order by id desc limit ".$offset." , ".$num." ";
			}*/

		$sql_count = "SELECT * FROM bpcl_payment  WHERE id <> 0";


		$query1 = $this->db->query($sql_count);
		$ret['result'] = $query->result_array();
		$ret['count']  = $query1->num_rows();
	    return $ret;
	}

	function deletes($id)
	{
 		$this->db->where('id = ',$id);
		if ($this->db->delete('bpcl_payment'))	{
			return true;
		} else {
			return false;
		}
	}
	
	function get_user_name($id)
	{
		
		$sql = "SELECT * FROM users where id = '".$id."'";
				
		$query = $this->db->query($sql);
// echo "<pre>";		var_dump($this->db->last_query());
		if ($query->num_rows() > 0)
		{
			$result = $query->row()->name;
			return $result;
		}
	}
}
