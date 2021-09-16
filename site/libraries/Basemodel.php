<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Basemodel
{
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->database();
    }
	
	public function allcategory()
    {
        $sql = "SELECT * FROM category order by name asc";
        $query = $this->CI->db->query($sql);
        return $query->result();
    }
    
    public function allcategorycol($id)
    {
        $sql = "SELECT * FROM category where columndisplay = '".$id."' order by set_order asc";
        $query = $this->CI->db->query($sql);
        return $query->result();
    }
	
	public function allworkshop()
    {
        $sql = "SELECT * FROM workshop_category order by id desc";
        $query = $this->CI->db->query($sql);
        return $query->result();
    }
		
	function category_subcategory($id)
	{
			$sql = "SELECT * FROM subcategory where category_id = '".$id."' order by id asc";
			$query = $this->CI->db->query($sql);
			if ($query->num_rows() > 0)
			{
				$result = $query->result();
				return $result;
			}else{
				return false;
			}
	}

	function blog_subcategory($id)
	{
			$sql = "SELECT * FROM blogsubcategory where blogcategory = '".$id."' order by id desc";
			$query = $this->CI->db->query($sql);
			if ($query->num_rows() > 0)
			{
				$result = $query->result();
				return $result;
			}else{
				return false;
			}
	}
		
	public function allcollectin()
    {
        $sql = "SELECT * FROM collection order by id desc";
        $query = $this->CI->db->query($sql);
        return $query->result();
    }
	
	public function allgift_hamper_category()
    {
        $sql = "SELECT * FROM gift_hamper_category order by set_order asc";
        $query = $this->CI->db->query($sql);
        return $query->result();
    }
    
    public function allgift_hamper_category_col($id)
    {
        $sql = "SELECT * FROM gift_hamper_category where columndisplay = '".$id."' order by set_order asc";
        $query = $this->CI->db->query($sql);
        return $query->result();
    }
	public function allservices()
    {
        $sql = "SELECT * FROM service_category order by name asc";
        $query = $this->CI->db->query($sql);
        return $query->result();
    }
    
    public function allservicescol($id)
    {
        $sql = "SELECT * FROM service_category where columndisplay = '".$id."' order by name asc";
        $query = $this->CI->db->query($sql);
        return $query->result();
    }
    
    public function allwellnesscol($id)
    {
        $sql = "SELECT * FROM wellness_category where columndisplay = '".$id."' order by set_order asc";
        $query = $this->CI->db->query($sql);
        return $query->result();
    }
    
    public function allwellness()
    {
        $sql = "SELECT * FROM wellness_category order by set_order asc";
        $query = $this->CI->db->query($sql);
        return $query->result();
    }
	
    public function receipemaincategory()
    {
        $sql = "SELECT * FROM recipes_main_category order by name asc";
        $query = $this->CI->db->query($sql);
        return $query->result();
    }
	
	public function allbanners($activepage)
	{
		$sql = "SELECT * from banner where activepage = '".$activepage."' order by set_order asc";
		$query = $this->CI->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			return $result;
		}else
		{
			return false;
		}
	}

    public function getcateProduct($cate)
    {
        $sql = "SELECT * from product where category_id = '".$cate."' and is_deleted = '0' and status = '0' order by id desc ";
        $query = $this->CI->db->query($sql);
        if ($query->num_rows() > 0)
        {
            $result = $query->result();
            return $result;
        }else
        {
            return false;
        }
    }
    
   
}
