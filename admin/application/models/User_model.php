<?php
	class User_model extends CI_Model {
	private $_data = array();
	function __construct() {
		parent::__construct();
	}

	function get_news($id){

		$this->db->where('id = ',$id);
		$query = $this->db->get('users');
		if ($query->num_rows() > 0)	{
			$result = $query->result();
			return $result;
		} else {
			return false;
		}
	}
	   
	/*function is_exist($name1,$id)
	{
		$this->db->where('id != ',$id);
		$this->db->where('code',$name1);
		$query = $this->db->get('users');
		if($query->num_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
		}*/

	function add($content)
 	{	
		$L_strErrorMessage='';
       
		$data['title'] = $content['title'];
		$data['date'] = $content['date'];
		
		if($content['image']!='')
		{
		$data['image'] = $content['image'];
		}
		
		$data['description'] = $content['description'];
		
		$this->_data = $data;
		if ($this->db->insert('latest_news', $this->_data))
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
	    
		$data['name'] = $content['name'];
		//$data['lname'] = $content['lname'];
		//$data['email'] = $content['email'];
		$data['mobile'] = $content['mobile'];
		//$data['address'] = $content['address'];
		//$data['country'] = $content['country'];
		//$data['state'] = $content['state'];
		//$data['city'] = $content['city'];
		$data['pincode'] = $content['pincode'];
		
		$this->_data = $data;
		$this->db->where('id', $id);
		if ($this->db->update('users', $this->_data))	{
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
		
		$sql = "SELECT * FROM users where id <> 0 and  user_vendor = 0 ";
		
		if($num!='' || $offset!='')
			{
				$sql .=	"  order by id desc limit ".$offset." , ".$num." ";
			}
			
		 
		$query = $this->db->query($sql);
		
		
		
		/*if($num!='' || $offset!='')
			{
				$sql .=	"  order by id desc limit ".$offset." , ".$num." ";
			}*/
		
		$sql_count = "SELECT * FROM users WHERE id <> 0 and  user_vendor = 0 ";

	 
		$query1 = $this->db->query($sql_count);
		$ret['result'] = $query->result_array();
		$ret['count']  = $query1->num_rows();
	    return $ret;
	}
	
	function subscribelists()
	{
		$query = "SELECT * from subscribe where is_sub='0' order by id desc";
		$result = $this->db->query($query);
		if ($result->num_rows() > 0)
		{
			$result = $result->result();
			return $result;
		}

	}

	function lists_subscribe($num, $offset, $content) 
	{
		
		if($offset == '')
		{
			$offset = '0';
		}
		
		$sql = "SELECT * FROM subscribe where id <> 0 ";
		
		if($num!='' || $offset!='')
			{
				$sql .=	"  order by id desc limit ".$offset." , ".$num." ";
			}
			
		 
		$query = $this->db->query($sql);
		
		
		
		/*if($num!='' || $offset!='')
			{
				$sql .=	"  order by id desc limit ".$offset." , ".$num." ";
			}*/
		
		$sql_count = "SELECT * FROM subscribe WHERE id <> 0 ";

	 
		$query1 = $this->db->query($sql_count);
		$ret['result'] = $query->result_array();
		$ret['count']  = $query1->num_rows();
	    return $ret;
	}

	function lists_franchise($num, $offset, $content) 
	{
		
		if($offset == '')
		{
			$offset = '0';
		}
		
		$sql = "SELECT * FROM farchisenquriy where id <> 0 ";
		
		if($num!='' || $offset!='')
		{
			$sql .=	"  order by id desc limit ".$offset." , ".$num." ";
		}
		$query = $this->db->query($sql);
		/*if($num!='' || $offset!='')
			{
				$sql .=	"  order by id desc limit ".$offset." , ".$num." ";
			}*/
		$sql_count = "SELECT * FROM farchisenquriy WHERE id <> 0 ";
		$query1 = $this->db->query($sql_count);
		$ret['result'] = $query->result_array();
		$ret['count']  = $query1->num_rows();
	    return $ret;
	}

	function lists_contactus($num, $offset, $content) 
	{
		
		if($offset == '')
		{
			$offset = '0';
		}
		
		$sql = "SELECT * FROM contactenquriy where id <> 0 ";
		
		if($num!='' || $offset!='')
		{
			$sql .=	"  order by id desc limit ".$offset." , ".$num." ";
		}
		$query = $this->db->query($sql);
		/*if($num!='' || $offset!='')
			{
				$sql .=	"  order by id desc limit ".$offset." , ".$num." ";
			}*/
		$sql_count = "SELECT * FROM contactenquriy WHERE id <> 0 ";
		$query1 = $this->db->query($sql_count);
		$ret['result'] = $query->result_array();
		$ret['count']  = $query1->num_rows();
	    return $ret;
	}
	
	function lists_notify($num, $offset, $content) 
	{
		
		if($offset == '')
		{
			$offset = '0';
		}
		
		$sql = "SELECT * FROM notifymeenquriy where id <> 0 ";
		
		if($num!='' || $offset!='')
		{
			$sql .=	"  order by id desc limit ".$offset." , ".$num." ";
		}
		$query = $this->db->query($sql);
		/*if($num!='' || $offset!='')
			{
				$sql .=	"  order by id desc limit ".$offset." , ".$num." ";
			}*/
		$sql_count = "SELECT * FROM notifymeenquriy WHERE id <> 0 ";
		$query1 = $this->db->query($sql_count);
		$ret['result'] = $query->result_array();
		$ret['count']  = $query1->num_rows();
	    return $ret;
	}  
	
	function downloadnotify()
	{
		$query = "SELECT * from notifymeenquriy order by id desc";
		$result = $this->db->query($query);
		if ($result->num_rows() > 0)
		{
			$result = $result->result();
			return $result;
		}
	}

	function downloadcontact()
	{
		$query = "SELECT * from contactenquriy order by id desc";
		$result = $this->db->query($query);
		if ($result->num_rows() > 0)
		{
			$result = $result->result();
			return $result;
		}
	}
	
	function downloadfranchise()
	{
		$query = "SELECT * from farchisenquriy order by id desc";
		$result = $this->db->query($query);
		if ($result->num_rows() > 0)
		{
			$result = $result->result();
			return $result;
		}
	}

	function deletefranchise($id){
        $this->db->where('id = ',$id);
        if ($this->db->delete('farchisenquriy'))	{
            return true;
        } else {
            return false;
        }
    }

	function deletenotify($id){
        $this->db->where('id = ',$id);
        if ($this->db->delete('notifymeenquriy'))	{
            return true;
        } else {
            return false;
        }
    }

	

	function deletecontact($id){
        $this->db->where('id = ',$id);
        if ($this->db->delete('contactenquriy'))	{
            return true;
        } else {
            return false;
        }
    }
	
    function updatestatus($id,$is_active)
	{
    	$sql= " update users set status= '".$is_active."' where id='".$id."' ";
		if ($query = $this->db->query($sql))	{
			return true;
		} else {
			return false;
	    }
 	}
	
	function deletes($id) 
	{
 		$this->db->where('id = ',$id);
		if ($this->db->delete('users'))	
		{
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

	function getproduct_name($id)
	{
 		$this->db->where('id = ',$id);
		$query = $this->db->get('product');
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

	

	


	
}
