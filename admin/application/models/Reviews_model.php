<?php
class Reviews_model extends CI_Model
{
    private $data = array();

    public function __construct()
    {
        parent::__construct();
    }

    public function getOrders($order_id = '',$status ='')
    {
		$this->db->join('product','product.id = reviews.productid', 'inner');
        $this->db->join('users','users.id = reviews.userid', 'inner');
		$this->db->select('reviews.*');
		$this->db->select('product.material_name');
		$this->db->select('users.name');
        $this->db->order_by('reviews.id', 'DESC');
        $order_list = $this->db->get('reviews')->result_array();
		// var_dump($this->db->last_query());exit;
        return $order_list;
    }
    
    function updatestatus($id,$is_active)
	{		
		$sql= " update reviews set is_approved = '".$is_active."' where id='".$id."' ";
		if ($query = $this->db->query($sql)){			
				return true;		
		}else
		{	
			return false;			
		
		}
	}
	
	function getuserdata($id){
        $this->db->join('reviews','users.id = reviews.userid', 'inner');
		$this->db->select('users.fname,users.lname,users.email');
        $this->db->order_by('reviews.id', 'DESC');
        $order_list = $this->db->get('users')->row();
        return $order_list;
	}
	
}
